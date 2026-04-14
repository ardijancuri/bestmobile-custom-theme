(function (api) {
  'use strict';

  if (!api || !document.documentElement) {
    return;
  }

  const root = document.documentElement;

  function clampScale(value) {
    const numeric = parseInt(value, 10);

    if (Number.isNaN(numeric)) {
      return 100;
    }

    return Math.max(60, Math.min(160, numeric));
  }

  function setPxVar(name, value) {
    root.style.setProperty(name, `${Math.round(value)}px`);
  }

  function applyHeaderMobile(value) {
    const scale = clampScale(value) / 100;
    setPxVar('--flavor-logo-width-mobile', 110 * scale);
    setPxVar('--flavor-logo-height-mobile', 32 * scale);
  }

  function applyHeaderDesktop(value) {
    const scale = clampScale(value) / 100;
    setPxVar('--flavor-logo-width-desktop', 132 * scale);
    setPxVar('--flavor-logo-height-desktop', 40 * scale);
  }

  function applyFooterMobile(value) {
    const scale = clampScale(value) / 100;
    setPxVar('--flavor-footer-logo-height-mobile', 40 * scale);
  }

  function applyFooterDesktop(value) {
    const scale = clampScale(value) / 100;
    setPxVar('--flavor-footer-logo-height-desktop', 40 * scale);
  }

  api('flavor_logo_scale_mobile', function (value) {
    value.bind(applyHeaderMobile);
  });

  api('flavor_logo_scale_desktop', function (value) {
    value.bind(applyHeaderDesktop);
  });

  api('flavor_footer_logo_scale_mobile', function (value) {
    value.bind(applyFooterMobile);
  });

  api('flavor_footer_logo_scale_desktop', function (value) {
    value.bind(applyFooterDesktop);
  });
})(window.wp && window.wp.customize ? window.wp.customize : null);
