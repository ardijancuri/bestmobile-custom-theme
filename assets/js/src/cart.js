/**
 * Flavor Theme - Cart Page JS
 * AJAX cart operations, warranty toggle, coupon, mini-cart sync, sticky checkout
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
    Object.entries(body).forEach(([k, v]) => fd.append(k, v));
    return fetch(ajaxUrl, { method: 'POST', body: fd }).then((r) => r.json());
  }

  function toast(message, type = 'info') {
    window.dispatchEvent(new CustomEvent('toast', { detail: { message, type } }));
  }

  function refreshMiniCart() {
    if (typeof window.flavorRefreshMiniCart === 'function') {
      window.flavorRefreshMiniCart();
    }
  }

  function updateCartTotals(html) {
    const wrapper = document.querySelector('.js-cart-totals');
    if (wrapper && html) wrapper.innerHTML = html;
  }

  /* ── Quantity +/- ────────────────────────────────────────── */

  document.addEventListener('click', (e) => {
    const btn = e.target.closest('.js-cart-qty-btn');
    if (!btn) return;

    const row = btn.closest('.js-cart-item');
    if (!row) return;

    const input = row.querySelector('.js-cart-qty-input');
    if (!input) return;

    let qty = parseInt(input.value, 10) || 1;
    const max = parseInt(input.dataset.max, 10) || 9999;

    if (btn.dataset.dir === 'plus') {
      qty = Math.min(qty + 1, max);
    } else {
      qty = Math.max(qty - 1, 1);
    }

    input.value = qty;
    row.classList.add('is-loading');

    post('flavor_update_cart_quantity', {
      cart_item_key: row.dataset.key,
      quantity: qty,
    }).then((res) => {
      row.classList.remove('is-loading');
      if (res.success) {
        const subtotalEl = row.querySelector('.js-cart-item-subtotal');
        if (subtotalEl) subtotalEl.innerHTML = res.data.line_total;
        updateCartTotals(res.data.totals_html);
        refreshMiniCart();
      } else {
        toast(res.data?.message || 'Could not update quantity.', 'error');
      }
    });
  });

  /* ── Remove Item ─────────────────────────────────────────── */

  document.addEventListener('click', (e) => {
    const btn = e.target.closest('.js-cart-remove');
    if (!btn) return;
    e.preventDefault();

    const row = btn.closest('.js-cart-item');
    if (!row) return;

    row.style.opacity = '0.4';
    row.style.transition = 'opacity .3s';

    post('flavor_remove_cart_item', { cart_item_key: row.dataset.key }).then((res) => {
      if (res.success) {
        row.style.height = row.offsetHeight + 'px';
        requestAnimationFrame(() => {
          row.style.transition = 'opacity .3s, height .3s, margin .3s, padding .3s';
          row.style.opacity = '0';
          row.style.height = '0';
          row.style.margin = '0';
          row.style.padding = '0';
          row.style.overflow = 'hidden';
        });
        setTimeout(() => {
          row.remove();
          updateCartTotals(res.data.totals_html);
          if (res.data.cart_empty) {
            const cartWrap = document.querySelector('.js-cart-wrapper');
            if (cartWrap) cartWrap.innerHTML = res.data.empty_html || '<p>Your cart is empty.</p>';
          }
        }, 350);
        refreshMiniCart();
      } else {
        row.style.opacity = '1';
        toast(res.data?.message || 'Could not remove item.', 'error');
      }
    });
  });

  /* ── Warranty Toggle ─────────────────────────────────────── */

  document.addEventListener('change', (e) => {
    if (!e.target.matches('.js-cart-warranty')) return;

    const row = e.target.closest('.js-cart-item');
    if (!row) return;

    post('flavor_toggle_warranty', {
      cart_item_key: row.dataset.key,
      warranty: e.target.value,
    }).then((res) => {
      if (res.success) {
        const subtotalEl = row.querySelector('.js-cart-item-subtotal');
        if (subtotalEl) subtotalEl.innerHTML = res.data.line_total;
        updateCartTotals(res.data.totals_html);
        refreshMiniCart();
      } else {
        toast(res.data?.message || 'Could not update warranty.', 'error');
      }
    });
  });

  /* ── Coupon ──────────────────────────────────────────────── */

  const couponForm = document.querySelector('.js-coupon-form');
  if (couponForm) {
    couponForm.addEventListener('submit', (e) => {
      e.preventDefault();
      const input = couponForm.querySelector('.js-coupon-input');
      const code = (input?.value || '').trim();
      if (!code) return;

      const btn = couponForm.querySelector('button');
      if (btn) btn.disabled = true;

      post('flavor_apply_coupon', { coupon_code: code }).then((res) => {
        if (btn) btn.disabled = false;
        if (res.success) {
          toast(res.data.message, 'success');
          updateCartTotals(res.data.totals_html);
          if (input) input.value = '';
          refreshMiniCart();
        } else {
          toast(res.data?.message || 'Invalid coupon.', 'error');
        }
      });
    });
  }

  /* ── Sticky Mobile Checkout Button ───────────────────────── */

  const mainCheckoutBtn = document.querySelector('.js-checkout-btn');
  const stickyBar = document.querySelector('.js-sticky-checkout-bar');

  if (mainCheckoutBtn && stickyBar) {
    const observer = new IntersectionObserver(
      ([entry]) => {
        stickyBar.classList.toggle('is-visible', !entry.isIntersecting);
      },
      { threshold: 0 }
    );
    observer.observe(mainCheckoutBtn);
  }
})();
