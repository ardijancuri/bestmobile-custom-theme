/**
 * Flavor Theme - Single Product Page JS
 * Swiper gallery, GLightbox, quantity, tabs/accordion, warranty, sticky CTA.
 *
 * @package Flavor
 */

(function () {
  'use strict';

  function initGallery() {
    const thumbsEl = document.querySelector('.js-product-thumbs');
    const mainEl = document.querySelector('.js-product-gallery');
    if (!mainEl) return;
    if (mainEl.swiper) return;

    const galleryWrap = mainEl.closest('.js-product-gallery-wrap');
    const currentEl = galleryWrap ? galleryWrap.querySelector('.js-product-gallery-current') : null;

    let thumbsSwiper = null;
    if (thumbsEl) {
      thumbsSwiper = new Swiper(thumbsEl, {
        spaceBetween: 8,
        slidesPerView: 4,
        freeMode: true,
        watchSlidesProgress: true,
      });
    }

    new Swiper(mainEl, {
      spaceBetween: 0,
      pagination: {
        el: mainEl.querySelector('.swiper-pagination'),
        clickable: true,
      },
      navigation: {
        nextEl: mainEl.querySelector('.js-gallery-next'),
        prevEl: mainEl.querySelector('.js-gallery-prev'),
      },
      thumbs: thumbsSwiper ? { swiper: thumbsSwiper } : undefined,
      on: {
        init(swiper) {
          if (currentEl) {
            currentEl.textContent = String(swiper.activeIndex + 1);
          }
        },
        slideChange(swiper) {
          if (currentEl) {
            currentEl.textContent = String(swiper.activeIndex + 1);
          }
        },
      },
    });
  }

  function initLightbox() {
    if (typeof GLightbox === 'undefined') return;

    GLightbox({
      selector: '.js-gallery-lightbox',
      touchNavigation: true,
      loop: true,
    });
  }

  document.addEventListener('click', (e) => {
    const btn = e.target.closest('.js-qty-btn');
    if (!btn) return;

    const wrapper = btn.closest('.js-qty-wrapper');
    if (!wrapper) return;

    const input = wrapper.querySelector('.js-qty-input');
    if (!input) return;

    let qty = parseInt(input.value, 10) || 1;
    const max = parseInt(input.dataset.max, 10) || 9999;

    qty = btn.dataset.dir === 'plus' ? Math.min(qty + 1, max) : Math.max(qty - 1, 1);

    input.value = qty;
    input.dispatchEvent(new Event('change', { bubbles: true }));
  });

  document.addEventListener('alpine:init', () => {
    Alpine.data('productTabs', () => ({
      activeTab: 'description',
      isMobile: window.innerWidth < 810,

      init() {
        this._onResize = () => {
          this.isMobile = window.innerWidth < 810;
        };
        window.addEventListener('resize', this._onResize);
      },

      destroy() {
        window.removeEventListener('resize', this._onResize);
      },

      setTab(id) {
        if (this.isMobile && this.activeTab === id) {
          this.activeTab = '';
        } else {
          this.activeTab = id;
        }
      },

      isOpen(id) {
        return this.activeTab === id;
      },
    }));

    Alpine.data('warrantyToggle', () => ({
      warranty: false,
      basePrice: 0,
      warrantyPrice: 0,

      init() {
        const el = this.$el.closest('.js-product-warranty');
        if (el) {
          this.basePrice = parseFloat(el.dataset.basePrice) || 0;
          this.warrantyPrice = parseFloat(el.dataset.warrantyPrice) || 0;
        }
      },

      get displayPrice() {
        return this.warranty ? this.basePrice + this.warrantyPrice : this.basePrice;
      },

      formatPrice(val) {
        return Math.round(val).toLocaleString();
      },
    }));
  });

  function initStickyBar() {
    const mainCTA = document.querySelector('.js-product-add-to-cart');
    const stickyBar = document.querySelector('.js-sticky-atc-bar');
    if (!mainCTA || !stickyBar) return;

    const observer = new IntersectionObserver(
      ([entry]) => {
        stickyBar.classList.toggle('is-visible', !entry.isIntersecting);
      },
      { threshold: 0 }
    );

    observer.observe(mainCTA);
  }

  function init() {
    initGallery();
    initLightbox();
    initStickyBar();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
