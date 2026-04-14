/**
 * Flavor Theme - Checkout (One-Page Checkout) JS
 * Alpine.js accordion steps, payment switching, address cards, validation
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

  /* ── Alpine: OPC Accordion ───────────────────────────────── */

  document.addEventListener('alpine:init', () => {
    Alpine.data('checkoutAccordion', () => ({
      steps: [
        { id: 'shipping', label: 'Shipping Address' },
        { id: 'billing', label: 'Billing & Invoice' },
        { id: 'payment', label: 'Payment Method' },
        { id: 'review', label: 'Review & Place Order' },
      ],
      activeStep: 'shipping',
      allowedSteps: ['shipping'],

      isActive(id) {
        return this.activeStep === id;
      },

      isAllowed(id) {
        return this.allowedSteps.includes(id);
      },

      goTo(id) {
        if (this.isAllowed(id)) this.activeStep = id;
      },

      completeStep(id) {
        if (!this.validateStep(id)) return false;

        const idx = this.steps.findIndex((s) => s.id === id);
        const next = this.steps[idx + 1];
        if (next && !this.allowedSteps.includes(next.id)) {
          this.allowedSteps.push(next.id);
        }
        if (next) this.activeStep = next.id;
        return true;
      },

      validateStep(id) {
        const section = document.querySelector(`[data-step="${id}"]`);
        if (!section) return true;

        let valid = true;
        section.querySelectorAll('[data-required]').forEach((field) => {
          const errEl = field.closest('.form-row')?.querySelector('.js-field-error');
          if (!field.value.trim()) {
            valid = false;
            field.classList.add('is-invalid');
            if (errEl) {
              errEl.textContent = field.dataset.errorMsg || 'This field is required.';
              errEl.hidden = false;
            }
          } else {
            field.classList.remove('is-invalid');
            if (errEl) errEl.hidden = true;
          }
        });

        if (!valid) toast('Please fill in all required fields.', 'error');
        return valid;
      },
    }));

    Alpine.data('businessInvoice', () => ({
      showBusiness: false,
      toggle() {
        this.showBusiness = !this.showBusiness;
      },
    }));

    Alpine.data('orderNotes', () => ({
      showNotes: false,
      toggle() {
        this.showNotes = !this.showNotes;
      },
    }));
  });

  /* ── Payment Method Switching ────────────────────────────── */

  document.addEventListener('click', (e) => {
    const group = e.target.closest('.js-payment-group');
    if (group) {
      document.querySelectorAll('.js-payment-group').forEach((g) => g.classList.remove('is-active'));
      group.classList.add('is-active');

      const methodsContainer = group.querySelector('.js-payment-methods');
      if (methodsContainer) methodsContainer.hidden = false;

      document.querySelectorAll('.js-payment-group:not(.is-active) .js-payment-methods').forEach((m) => {
        m.hidden = true;
      });
      return;
    }

    const method = e.target.closest('.js-payment-method');
    if (method) {
      document.querySelectorAll('.js-payment-method').forEach((m) => m.classList.remove('is-selected'));
      method.classList.add('is-selected');

      const methodId = method.dataset.methodId;
      const detailsContainer = document.querySelector('.js-payment-details');
      if (!detailsContainer || !methodId) return;

      detailsContainer.innerHTML = '<div class="loading-spinner"></div>';

      post('flavor_load_payment_details', { method_id: methodId }).then((res) => {
        if (res.success) {
          detailsContainer.innerHTML = res.data.html;
        } else {
          detailsContainer.innerHTML = '';
          toast(res.data?.message || 'Could not load payment details.', 'error');
        }
      });

      const hiddenInput = document.querySelector('input[name="payment_method"]');
      if (hiddenInput) hiddenInput.value = methodId;
    }
  });

  /* ── Address Card Selection ──────────────────────────────── */

  document.addEventListener('click', (e) => {
    const card = e.target.closest('.js-address-card');
    if (!card) return;

    const container = card.closest('.js-address-cards');
    if (!container) return;

    container.querySelectorAll('.js-address-card').forEach((c) => c.classList.remove('is-selected'));
    card.classList.add('is-selected');

    const data = card.dataset;
    const fields = ['first_name', 'last_name', 'address_1', 'address_2', 'city', 'state', 'postcode', 'country', 'phone', 'email'];
    const prefix = container.dataset.prefix || 'billing';

    fields.forEach((field) => {
      const input = document.querySelector(`[name="${prefix}_${field}"]`);
      if (input && data[field] !== undefined) {
        input.value = data[field];
        input.dispatchEvent(new Event('change', { bubbles: true }));
      }
    });
  });

  /* ── Inline Validation on Blur ───────────────────────────── */

  document.addEventListener(
    'blur',
    (e) => {
      const field = e.target;
      if (!field.dataset.required) return;

      const errEl = field.closest('.form-row')?.querySelector('.js-field-error');
      if (!field.value.trim()) {
        field.classList.add('is-invalid');
        if (errEl) {
          errEl.textContent = field.dataset.errorMsg || 'This field is required.';
          errEl.hidden = false;
        }
      } else {
        field.classList.remove('is-invalid');
        if (errEl) errEl.hidden = true;
      }
    },
    true
  );

  /* ── Step Continue Buttons ───────────────────────────────── */

  document.addEventListener('click', (e) => {
    const btn = e.target.closest('.js-step-continue');
    if (!btn) return;

    const stepId = btn.dataset.step;
    if (!stepId) return;

    const accordionEl = document.querySelector('[x-data*="checkoutAccordion"]');
    if (accordionEl && accordionEl.__x) {
      accordionEl.__x.$data.completeStep(stepId);
    }
  });
})();
