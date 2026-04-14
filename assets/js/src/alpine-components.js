/**
 * Alpine.js component registrations — loaded BEFORE Alpine.js
 *
 * @package Flavor
 */

document.addEventListener('alpine:init', () => {
  'use strict';

  const ajaxUrl = (window.flavorData || {}).ajaxUrl || (window.flavorAjax || {}).url || '/wp-admin/admin-ajax.php';
  const nonce   = (window.flavorData || {}).nonce   || (window.flavorAjax || {}).nonce || '';

  Alpine.store('ui', {
    cookieBannerTop: 0,

    setCookieBannerTop(value) {
      this.cookieBannerTop = Number(value) || 0;
    },
  });

  Alpine.store('homepageProducts', {
    sections: {},

    normalize(ids) {
      const source = Array.isArray(ids) ? ids : [];
      return [...new Set(
        source
          .map((id) => Number(id) || 0)
          .filter((id) => id > 0),
      )];
    },

    setSection(section, ids) {
      if (!section) return;
      this.sections[section] = this.normalize(ids);
    },

    addToSection(section, ids) {
      if (!section) return;
      const current = this.sections[section] || [];
      this.sections[section] = this.normalize(current.concat(ids || []));
    },

    getIds(exceptSection = '') {
      const ids = [];

      Object.entries(this.sections).forEach(([section, sectionIds]) => {
        if (exceptSection && section === exceptSection) {
          return;
        }

        ids.push(...sectionIds);
      });

      return this.normalize(ids);
    },

    readIdsFromElement(element) {
      if (!element || typeof element.querySelectorAll !== 'function') {
        return [];
      }

      return this.normalize(
        Array.from(element.querySelectorAll('[data-product-id]')).map((node) => node.getAttribute('data-product-id')),
      );
    },

    readIdsFromHtml(html) {
      const template = document.createElement('template');
      template.innerHTML = String(html || '').trim();
      return this.readIdsFromElement(template.content);
    },
  });

  function post(action, body = {}) {
    const fd = new FormData();
    fd.append('action', action);
    fd.append('nonce', nonce);
    Object.entries(body).forEach(([k, v]) => {
      if (Array.isArray(v)) {
        v.forEach((item) => fd.append(`${k}[]`, item));
        return;
      }

      if (v && typeof v === 'object') {
        fd.append(k, JSON.stringify(v));
        return;
      }

      fd.append(k, v ?? '');
    });
    return fetch(ajaxUrl, { method: 'POST', body: fd }).then(r => r.json());
  }

  /* ── Tabbed Products (Homepage "Recommended for you") ──── */

  Alpine.data('flavorTabbedProducts', (opts = {}) => ({
    activeTab: opts.initialTab || 'for-you',
    activeCat: opts.initialCat || 0,
    sectionKey: opts.sectionKey || 'homepage-tabbed',
    loading: false,

    init() {
      this.syncSectionProducts();
    },

    switchTab(slug, cat) {
      if (this.activeTab === slug) return;
      this.activeTab = slug;
      this.activeCat = cat;
      this.loadProducts();
    },

    loadProducts() {
      this.loading = true;
      const homepageStore = Alpine.store('homepageProducts');

      post('flavor_load_products', {
        category: this.activeCat,
        per_page: 10,
        context: 'tabbed',
        exclude_ids: homepageStore.getIds(this.sectionKey).join(','),
      }).then(res => {
        if (res.success) {
          const html = String((res.data || {}).html || '');
          const fragment = document.createRange().createContextualFragment(html);
          const newNodes = Array.from(fragment.childNodes).filter((node) => node.nodeType === Node.ELEMENT_NODE);

          this.$refs.grid.innerHTML = '';
          this.$refs.grid.appendChild(fragment);

          if (window.Alpine && typeof window.Alpine.initTree === 'function') {
            newNodes.forEach((node) => window.Alpine.initTree(node));
          }

          this.syncSectionProducts();
        }
        this.loading = false;
      }).catch(() => {
        this.loading = false;
      });
    },

    syncSectionProducts() {
      Alpine.store('homepageProducts').setSection(
        this.sectionKey,
        Alpine.store('homepageProducts').readIdsFromElement(this.$refs.grid),
      );
    },
  }));

  Alpine.data('flavorAllProducts', (opts = {}) => ({
    sectionKey: opts.sectionKey || 'homepage-all-products',
    perPage: Number(opts.perPage) || 10,
    loading: false,
    ended: !!opts.ended,

    init() {
      this.syncSectionProducts();
    },

    loadMore() {
      if (this.loading || this.ended) return;
      const grid = this.$refs.grid;
      const homepageStore = Alpine.store('homepageProducts');

      if (!grid) {
        this.ended = true;
        return;
      }

      this.loading = true;

      post('flavor_load_more_products', {
        per_page: this.perPage,
        exclude_ids: homepageStore.getIds().join(','),
      }).then((res) => {
        if (!res.success || !res.data) {
          this.loading = false;
          window.dispatchEvent(new CustomEvent('toast', { detail: { message: 'Could not load more products.', type: 'error' } }));
          return;
        }

        const html = String(res.data.html || '').trim();
        const hasMore = typeof res.data.has_more === 'boolean'
          ? res.data.has_more
          : false;

        if (html) {
          const fragment = document.createRange().createContextualFragment(html);
          const newNodes = Array.from(fragment.childNodes).filter((node) => node.nodeType === Node.ELEMENT_NODE);
          const newIds = homepageStore.readIdsFromHtml(html);

          grid.appendChild(fragment);
          homepageStore.addToSection(this.sectionKey, newIds);

          if (window.Alpine && typeof window.Alpine.initTree === 'function') {
            newNodes.forEach((node) => window.Alpine.initTree(node));
          }
        }

        this.ended = !hasMore || !html;
        this.loading = false;
      }).catch(() => {
        this.loading = false;
        window.dispatchEvent(new CustomEvent('toast', { detail: { message: 'Could not load more products.', type: 'error' } }));
      });
    },

    syncSectionProducts() {
      Alpine.store('homepageProducts').setSection(
        this.sectionKey,
        Alpine.store('homepageProducts').readIdsFromElement(this.$refs.grid),
      );
    },
  }));

  /* ── Toast Notifications ─────────────────────────────────── */

  Alpine.data('flavorToasts', () => ({
    toasts: [],

    addToast(detail) {
      const id = Date.now();
      this.toasts.push({
        id,
        message: detail.message,
        type: detail.type || 'success',
      });
      setTimeout(() => this.removeToast(id), 4000);
    },

    removeToast(id) {
      this.toasts = this.toasts.filter(t => t.id !== id);
    },
  }));

  /* ── Cart Page Component ─────────────────────────────────── */

  Alpine.data('flavorCart', () => ({
    couponCode: '',
    couponMessage: '',
    couponSuccess: false,
    applying: false,
    cartEmpty: false,

    removeItem(key) {
      const row = document.querySelector(`[data-cart-key="${key}"]`);
      if (row) {
        row.style.opacity = '0.4';
        row.style.transition = 'opacity .3s';
      }
      post('flavor_remove_cart_item', { cart_item_key: key }).then(res => {
        if (res.success) {
          if (row) row.remove();
          if (res.data && res.data.cart_empty) {
            this.cartEmpty = true;
            location.reload();
          } else {
            location.reload();
          }
        } else {
          if (row) row.style.opacity = '1';
        }
      });
    },

    updateQty(key, qty) {
      post('flavor_update_cart_quantity', { cart_item_key: key, quantity: qty }).then(() => {
        location.reload();
      });
    },

    toggleWarranty(key, val) {
      post('flavor_toggle_warranty', { cart_item_key: key, warranty: val ? 'yes' : 'no' }).then(() => {
        location.reload();
      });
    },

    applyCoupon() {
      if (!this.couponCode || this.applying) return;
      this.applying = true;
      this.couponMessage = '';

      post('flavor_apply_coupon', { coupon_code: this.couponCode }).then(res => {
        this.applying = false;
        if (res.success) {
          this.couponSuccess = true;
          this.couponMessage = res.data.message || 'Coupon applied!';
          setTimeout(() => location.reload(), 800);
        } else {
          this.couponSuccess = false;
          this.couponMessage = (res.data && res.data.message) || 'Invalid coupon.';
        }
      }).catch(() => {
        this.applying = false;
        this.couponSuccess = false;
        this.couponMessage = 'Something went wrong.';
      });
    },
  }));

  /* ── Product Page Component ──────────────────────────────── */

  Alpine.data('productPage', (config = {}) => ({
    productId: config.productId || 0,
    quantity: 1,
    warranty: false,
    price: config.price || 0,
    regularPrice: config.regularPrice || 0,
    inStock: config.inStock !== false,
    warrantyPrice: config.warrantyPrice || 0,
    addingToCart: false,

    get displayPrice() {
      const base = this.price || this.regularPrice;
      return this.warranty ? base + this.warrantyPrice : base;
    },

    setQty(val) {
      this.quantity = Math.max(1, parseInt(val) || 1);
    },

    addToCart(redirect) {
      if (this.addingToCart) return;
      this.addingToCart = true;

      post('flavor_add_to_cart', {
        product_id: this.productId,
        quantity: this.quantity,
        warranty: this.warranty ? '1' : '0',
      }).then(res => {
        this.addingToCart = false;
        if (res.success) {
          if (window.flavorApplyMiniCart && res.data && res.data.mini_cart) {
            window.flavorApplyMiniCart(res.data.mini_cart);
          } else if (window.flavorRefreshMiniCart) {
            window.flavorRefreshMiniCart();
          }

          if (redirect) {
            window.location.href = (window.flavorData || {}).checkoutUrl || '/checkout/';
          } else {
            window.dispatchEvent(new CustomEvent('open-mini-cart'));
          }
        } else {
          window.dispatchEvent(new CustomEvent('toast', { detail: { message: (res.data && res.data.message) || 'Error', type: 'error' } }));
        }
      }).catch(() => {
        this.addingToCart = false;
      });
    },
  }));

  /* ── Shop / Archive Page Component ───────────────────────── */

  Alpine.data('shopPage', (opts = {}) => ({
    view: 'grid',
    quickFilter: opts.quickFilter || '',
    sortBy: opts.sortBy || 'relevance',
    filterDrawerOpen: false,
    loading: false,
    hasMore: !!opts.hasMore,
    currentPage: Number(opts.currentPage) || 1,
    perPage: Number(opts.perPage) || 12,
    archiveType: opts.archiveType || 'shop',
    categoryId: Number(opts.categoryId) || 0,
    searchQuery: opts.searchQuery || '',
    totalProducts: Number(opts.totalProducts) || 0,
    brandSearch: '',
    showAll: false,
    filters: {
      price_min: '',
      price_max: '',
      categories: [],
      brands: [],
      in_stock: false,
      out_of_stock: false,
      on_sale: false,
      attributes: {},
    },
    get activeFilterCount() {
      let count = 0;
      if (this.filters.price_min || this.filters.price_max) count++;
      count += this.filters.categories.length;
      count += this.filters.brands.length;
      if (this.filters.in_stock) count++;
      if (this.filters.out_of_stock) count++;
      if (this.filters.on_sale) count++;
      return count;
    },
    get activeFilters() {
      const chips = [];
      if (this.filters.price_min || this.filters.price_max) {
        chips.push({
          key: 'price',
          label: `${this.filters.price_min || '0'} - ${this.filters.price_max || '∞'}`,
          remove: () => {
            this.filters.price_min = '';
            this.filters.price_max = '';
            this.loadProducts(1);
          },
        });
      }
      this.filters.categories.forEach(c => {
        chips.push({
          key: `cat-${c}`,
          label: c,
          remove: () => {
            this.filters.categories = this.filters.categories.filter(x => x !== c);
            this.loadProducts(1);
          },
        });
      });
      this.filters.brands.forEach(b => {
        chips.push({
          key: `brand-${b}`,
          label: b,
          remove: () => {
            this.filters.brands = this.filters.brands.filter(x => x !== b);
            this.loadProducts(1);
          },
        });
      });
      if (this.filters.in_stock) {
        chips.push({
          key: 'in_stock',
          label: 'In Stock',
          remove: () => {
            this.filters.in_stock = false;
            this.loadProducts(1);
          },
        });
      }
      if (this.filters.out_of_stock) {
        chips.push({
          key: 'out_of_stock',
          label: 'Out of Stock',
          remove: () => {
            this.filters.out_of_stock = false;
            this.loadProducts(1);
          },
        });
      }
      if (this.filters.on_sale) {
        chips.push({
          key: 'on_sale',
          label: 'On Sale',
          remove: () => {
            this.filters.on_sale = false;
            this.loadProducts(1);
          },
        });
      }
      return chips;
    },
    clearAllFilters() {
      this.filters.price_min = '';
      this.filters.price_max = '';
      this.filters.categories = [];
      this.filters.brands = [];
      this.filters.in_stock = false;
      this.filters.out_of_stock = false;
      this.filters.on_sale = false;
      this.filters.attributes = {};
      this.quickFilter = '';
      this.loadProducts(1);
    },
    toggleArrayFilter(key, value) {
      const arr = this.filters[key];
      const idx = arr.indexOf(value);
      if (idx === -1) { arr.push(value); } else { arr.splice(idx, 1); }
    },
    toggleAttributeFilter(taxonomy, value) {
      if (!this.filters.attributes[taxonomy]) this.filters.attributes[taxonomy] = [];
      const arr = this.filters.attributes[taxonomy];
      const idx = arr.indexOf(value);
      if (idx === -1) { arr.push(value); } else { arr.splice(idx, 1); }
    },
    buildArchiveRequest(page = 1) {
      return {
        page,
        per_page: this.perPage,
        archive_type: this.archiveType,
        category_id: this.categoryId,
        search_query: this.searchQuery,
        quick_filter: this.quickFilter,
        sort_by: this.sortBy,
        price_min: this.filters.price_min,
        price_max: this.filters.price_max,
        categories: this.filters.categories,
        brands: this.filters.brands,
        attributes: this.filters.attributes,
        in_stock: this.filters.in_stock ? '1' : '0',
        out_of_stock: this.filters.out_of_stock ? '1' : '0',
        on_sale: this.filters.on_sale ? '1' : '0',
      };
    },
    renderGridHtml(html, append = false) {
      const grid = this.$refs.productGrid;

      if (!grid) {
        return;
      }

      const fragment = document.createRange().createContextualFragment(String(html || ''));
      const newNodes = Array.from(fragment.childNodes).filter((node) => node.nodeType === Node.ELEMENT_NODE);

      if (!append) {
        grid.innerHTML = '';
      }

      grid.appendChild(fragment);

      if (window.Alpine && typeof window.Alpine.initTree === 'function') {
        newNodes.forEach((node) => window.Alpine.initTree(node));
      }
    },
    loadProducts(page = 1, append = false) {
      if (this.loading) return;

      this.loading = true;

      post('flavor_load_archive_products', this.buildArchiveRequest(page)).then((res) => {
        if (!res.success || !res.data) {
          throw new Error('Archive load failed');
        }

        this.renderGridHtml(res.data.html || '', append);
        this.totalProducts = Number(res.data.total) || 0;
        this.hasMore = !!res.data.has_more;
        this.currentPage = Number(res.data.current_page) || page;
        this.filterDrawerOpen = false;
        this.loading = false;
      }).catch(() => {
        this.loading = false;
        window.dispatchEvent(new CustomEvent('toast', {
          detail: {
            message: 'Could not load products.',
            type: 'error',
          },
        }));
      });
    },
    loadMore() {
      if (this.loading || !this.hasMore) return;
      this.loadProducts(this.currentPage + 1, true);
    },
    applyFilters() {
      this.loadProducts(1);
    },
  }));

  /* ── Mobile Sticky Bar (Single Product) ──────────────────── */

  Alpine.data('mobileStickyBar', () => ({
    visible: false,
    init() {
      const mainCTA = document.querySelector('.js-product-add-to-cart');
      if (!mainCTA) return;
      const observer = new IntersectionObserver(
        ([entry]) => { this.visible = !entry.isIntersecting; },
        { threshold: 0 }
      );
      observer.observe(mainCTA);
    },
  }));

  /* ── Global Wishlist (localStorage) ──────────────────────── */

  Alpine.store('wishlist', {
    items: JSON.parse(localStorage.getItem('flavor_wishlist') || '[]'),
    has(id) {
      return this.items.includes(id);
    },
    toggle(id) {
      const idx = this.items.indexOf(id);
      if (idx === -1) {
        this.items.push(id);
      } else {
        this.items.splice(idx, 1);
      }
      localStorage.setItem('flavor_wishlist', JSON.stringify(this.items));
    },
  });
});
