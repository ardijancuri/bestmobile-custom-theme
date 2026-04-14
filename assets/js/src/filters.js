/**
 * Flavor Theme - Product Filters JS
 * AJAX filtering, URL state, price range, brand search, chips
 *
 * @package Flavor
 */

(function () {
  'use strict';

  const { ajaxUrl, nonce } = window.flavorData || {};

  function post(action, body = {}) {
    const fd = new FormData();
    fd.append('action', action);
    fd.append('_ajax_nonce', nonce);
    Object.entries(body).forEach(([k, v]) => {
      if (Array.isArray(v)) {
        v.forEach((item) => fd.append(`${k}[]`, item));
      } else {
        fd.append(k, v);
      }
    });
    return fetch(ajaxUrl, { method: 'POST', body: fd }).then((r) => r.json());
  }

  function toast(message, type = 'info') {
    window.dispatchEvent(new CustomEvent('toast', { detail: { message, type } }));
  }

  function debounce(fn, ms) {
    let t;
    return (...args) => {
      clearTimeout(t);
      t = setTimeout(() => fn(...args), ms);
    };
  }

  const state = {
    price_min: '',
    price_max: '',
    brands: [],
    attributes: [],
    rating: '',
    stock: '',
    orderby: '',
    page: 1,
  };

  const grid = document.querySelector('.js-product-grid');
  const chipsContainer = document.querySelector('.js-filter-chips');
  const countEl = document.querySelector('.js-product-count');

  /* ── URL State ───────────────────────────────────────────── */

  function readURL() {
    const p = new URLSearchParams(window.location.search);
    state.price_min = p.get('price_min') || '';
    state.price_max = p.get('price_max') || '';
    state.brands = p.getAll('brands[]').length ? p.getAll('brands[]') : (p.get('brands') || '').split(',').filter(Boolean);
    state.attributes = p.getAll('attributes[]').length ? p.getAll('attributes[]') : (p.get('attributes') || '').split(',').filter(Boolean);
    state.rating = p.get('rating') || '';
    state.stock = p.get('stock') || '';
    state.orderby = p.get('orderby') || '';
    state.page = parseInt(p.get('page'), 10) || 1;
  }

  function pushURL() {
    const p = new URLSearchParams();
    if (state.price_min) p.set('price_min', state.price_min);
    if (state.price_max) p.set('price_max', state.price_max);
    state.brands.forEach((b) => p.append('brands[]', b));
    state.attributes.forEach((a) => p.append('attributes[]', a));
    if (state.rating) p.set('rating', state.rating);
    if (state.stock) p.set('stock', state.stock);
    if (state.orderby) p.set('orderby', state.orderby);
    if (state.page > 1) p.set('page', state.page);

    const qs = p.toString();
    history.pushState(state, '', window.location.pathname + (qs ? '?' + qs : ''));
  }

  /* ── Fetch Products ──────────────────────────────────────── */

  function fetchProducts(updateURL = true) {
    if (!grid) return;

    grid.classList.add('is-loading');
    grid.setAttribute('aria-busy', 'true');
    grid.innerHTML = Array.from({ length: 12 }, () => '<div class="product-card product-card--skeleton"></div>').join('');

    if (updateURL) pushURL();

    post('flavor_filter_products', { ...state }).then((res) => {
      grid.classList.remove('is-loading');
      grid.removeAttribute('aria-busy');

      if (res.success) {
        grid.innerHTML = res.data.html;
        if (countEl) countEl.textContent = res.data.total;
        renderChips();
        const loadMoreBtn = document.querySelector('.js-load-more');
        if (loadMoreBtn) loadMoreBtn.hidden = !res.data.has_more;
      } else {
        toast(res.data?.message || 'Could not load products.', 'error');
      }
    });
  }

  /* ── Chips ───────────────────────────────────────────────── */

  function renderChips() {
    if (!chipsContainer) return;
    let html = '';

    if (state.price_min || state.price_max) {
      html += `<button class="filter-chip js-chip-remove" data-filter="price">${state.price_min || '0'} – ${state.price_max || '∞'} <span aria-hidden="true">×</span></button>`;
    }
    state.brands.forEach((b) => {
      html += `<button class="filter-chip js-chip-remove" data-filter="brand" data-value="${b}">${b} <span aria-hidden="true">×</span></button>`;
    });
    state.attributes.forEach((a) => {
      html += `<button class="filter-chip js-chip-remove" data-filter="attribute" data-value="${a}">${a} <span aria-hidden="true">×</span></button>`;
    });
    if (state.rating) {
      html += `<button class="filter-chip js-chip-remove" data-filter="rating">${state.rating}★+ <span aria-hidden="true">×</span></button>`;
    }
    if (state.stock) {
      html += `<button class="filter-chip js-chip-remove" data-filter="stock">In Stock <span aria-hidden="true">×</span></button>`;
    }
    if (html) {
      html += '<button class="filter-chip filter-chip--clear js-clear-all">Clear all <span aria-hidden="true">×</span></button>';
    }
    chipsContainer.innerHTML = html;
  }

  /* ── Collect Filters ─────────────────────────────────────── */

  function collectFilters() {
    const priceMin = document.querySelector('.js-filter-price-min');
    const priceMax = document.querySelector('.js-filter-price-max');
    if (priceMin) state.price_min = priceMin.value;
    if (priceMax) state.price_max = priceMax.value;

    state.brands = Array.from(document.querySelectorAll('.js-filter-brand:checked')).map((cb) => cb.value);
    state.attributes = Array.from(document.querySelectorAll('.js-filter-attr:checked')).map((cb) => cb.value);

    const ratingEl = document.querySelector('.js-filter-rating:checked');
    state.rating = ratingEl ? ratingEl.value : '';

    const stockEl = document.querySelector('.js-filter-stock:checked');
    state.stock = stockEl ? stockEl.value : '';

    const orderEl = document.querySelector('.js-filter-orderby');
    if (orderEl) state.orderby = orderEl.value;

    state.page = 1;
  }

  /* ── Events ──────────────────────────────────────────────── */

  window.addEventListener('filter-drawer-open', () => {
    const drawer = document.querySelector('.js-filter-drawer');
    if (drawer) drawer.classList.add('is-open');
    document.body.classList.add('has-drawer-open');
  });

  window.addEventListener('filter-drawer-close', () => {
    const drawer = document.querySelector('.js-filter-drawer');
    if (drawer) drawer.classList.remove('is-open');
    document.body.classList.remove('has-drawer-open');
  });

  const debouncedFetch = debounce(() => {
    collectFilters();
    fetchProducts();
  }, 500);

  document.addEventListener('input', (e) => {
    if (e.target.matches('.js-filter-price-min, .js-filter-price-max')) debouncedFetch();
  });

  document.addEventListener('change', (e) => {
    if (e.target.matches('.js-filter-brand, .js-filter-attr, .js-filter-rating, .js-filter-stock, .js-filter-orderby')) {
      collectFilters();
      fetchProducts();
    }
  });

  // Brand search
  document.addEventListener('input', (e) => {
    if (!e.target.matches('.js-brand-search')) return;
    const query = e.target.value.toLowerCase();
    document.querySelectorAll('.js-brand-item').forEach((item) => {
      item.hidden = !(item.textContent || '').toLowerCase().includes(query);
    });
  });

  // Chip removal
  document.addEventListener('click', (e) => {
    const chip = e.target.closest('.js-chip-remove');
    if (!chip) return;

    const filter = chip.dataset.filter;
    const value = chip.dataset.value;

    if (filter === 'price') {
      state.price_min = '';
      state.price_max = '';
      const minEl = document.querySelector('.js-filter-price-min');
      const maxEl = document.querySelector('.js-filter-price-max');
      if (minEl) minEl.value = '';
      if (maxEl) maxEl.value = '';
    } else if (filter === 'brand') {
      state.brands = state.brands.filter((b) => b !== value);
      const cb = document.querySelector(`.js-filter-brand[value="${value}"]`);
      if (cb) cb.checked = false;
    } else if (filter === 'attribute') {
      state.attributes = state.attributes.filter((a) => a !== value);
      const cb = document.querySelector(`.js-filter-attr[value="${value}"]`);
      if (cb) cb.checked = false;
    } else if (filter === 'rating') {
      state.rating = '';
      document.querySelectorAll('.js-filter-rating').forEach((r) => (r.checked = false));
    } else if (filter === 'stock') {
      state.stock = '';
      const cb = document.querySelector('.js-filter-stock');
      if (cb) cb.checked = false;
    }

    state.page = 1;
    fetchProducts();
  });

  // Clear all
  document.addEventListener('click', (e) => {
    if (!e.target.closest('.js-clear-all')) return;
    state.price_min = '';
    state.price_max = '';
    state.brands = [];
    state.attributes = [];
    state.rating = '';
    state.stock = '';
    state.page = 1;

    document.querySelectorAll('.js-filter-brand, .js-filter-attr, .js-filter-rating, .js-filter-stock').forEach((cb) => (cb.checked = false));
    const minEl = document.querySelector('.js-filter-price-min');
    const maxEl = document.querySelector('.js-filter-price-max');
    if (minEl) minEl.value = '';
    if (maxEl) maxEl.value = '';

    fetchProducts();
  });

  window.addEventListener('popstate', () => {
    readURL();
    fetchProducts(false);
  });

  // Init
  readURL();
  renderChips();
})();
