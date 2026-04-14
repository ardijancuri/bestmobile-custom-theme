<?php
/**
 * Enqueue theme assets
 *
 * @package Flavor
 */

defined( 'ABSPATH' ) || exit;

/**
 * Enqueue all theme styles and scripts.
 */
function flavor_enqueue_assets() {
    // Inter font.
    wp_enqueue_style( 'flavor-inter-font', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap', array(), null );

    // Main theme CSS (Tailwind compiled).
    wp_enqueue_style( 'flavor-style', FLAVOR_URI . '/assets/css/dist/style.css', array(), FLAVOR_VERSION );

    // Swiper CSS.
    wp_enqueue_style( 'swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', array(), null );

    // GLightbox CSS.
    wp_enqueue_style( 'glightbox', 'https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css', array(), null );

    // Alpine.js component definitions (must load BEFORE Alpine).
    wp_enqueue_script( 'flavor-alpine-components', FLAVOR_URI . '/assets/js/src/alpine-components.js', array(), FLAVOR_VERSION, true );

    // Alpine.js (defer).
    wp_enqueue_script( 'alpinejs-collapse', 'https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3/dist/cdn.min.js', array( 'flavor-alpine-components' ), null, true );
    wp_enqueue_script( 'alpinejs', 'https://cdn.jsdelivr.net/npm/alpinejs@3/dist/cdn.min.js', array( 'alpinejs-collapse' ), null, true );

    // Localize data early so alpine:init callbacks can access it.
    wp_localize_script( 'flavor-alpine-components', 'flavorData', array(
        'ajaxUrl'     => admin_url( 'admin-ajax.php' ),
        'nonce'       => wp_create_nonce( 'flavor_ajax_nonce' ),
        'homeUrl'     => home_url( '/' ),
        'cartUrl'     => function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : '',
        'checkoutUrl' => function_exists( 'wc_get_checkout_url' ) ? wc_get_checkout_url() : '',
    ) );

    // Swiper JS.
    wp_enqueue_script( 'swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), null, true );

    // GLightbox JS.
    wp_enqueue_script( 'glightbox', 'https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js', array(), null, true );

    // Theme JS files.
    wp_enqueue_script( 'flavor-header', FLAVOR_URI . '/assets/js/src/header.js', array(), FLAVOR_VERSION, true );
    wp_enqueue_script( 'flavor-app', FLAVOR_URI . '/assets/js/src/app.js', array( 'alpinejs' ), FLAVOR_VERSION, true );

    // Conditional scripts.
    if ( is_front_page() ) {
        wp_enqueue_script( 'flavor-slider', FLAVOR_URI . '/assets/js/src/slider.js', array( 'swiper' ), FLAVOR_VERSION, true );
        wp_enqueue_script( 'flavor-products', FLAVOR_URI . '/assets/js/src/products.js', array( 'flavor-app' ), FLAVOR_VERSION, true );
    }

    if ( function_exists( 'is_product' ) && is_product() ) {
        wp_enqueue_script( 'flavor-product-page', FLAVOR_URI . '/assets/js/src/product-page.js', array( 'swiper', 'glightbox' ), FLAVOR_VERSION, true );
    }

    if ( function_exists( 'is_shop' ) && ( is_shop() || is_product_category() || is_search() ) ) {
        wp_enqueue_script( 'flavor-filters', FLAVOR_URI . '/assets/js/src/filters.js', array(), FLAVOR_VERSION, true );
    }

    if ( function_exists( 'is_cart' ) && is_cart() ) {
        wp_enqueue_script( 'flavor-cart', FLAVOR_URI . '/assets/js/src/cart.js', array(), FLAVOR_VERSION, true );
    }

    if ( function_exists( 'is_checkout' ) && is_checkout() ) {
        wp_enqueue_script( 'flavor-checkout', FLAVOR_URI . '/assets/js/src/checkout.js', array(), FLAVOR_VERSION, true );
    }

    // flavorData is already localized on flavor-alpine-components above.
}
add_action( 'wp_enqueue_scripts', 'flavor_enqueue_assets' );

/**
 * Add targeted CSS overrides that depend on WordPress-generated markup.
 */
function flavor_enqueue_inline_overrides() {
    $logo_scale_mobile         = max( 60, min( 160, absint( get_theme_mod( 'flavor_logo_scale_mobile', flavor_get_theme_default( 'flavor_logo_scale_mobile', 100 ) ) ) ) );
    $logo_scale_desktop        = max( 60, min( 160, absint( get_theme_mod( 'flavor_logo_scale_desktop', flavor_get_theme_default( 'flavor_logo_scale_desktop', 100 ) ) ) ) );
    $footer_logo_scale_mobile  = max( 60, min( 160, absint( get_theme_mod( 'flavor_footer_logo_scale_mobile', flavor_get_theme_default( 'flavor_footer_logo_scale_mobile', 100 ) ) ) ) );
    $footer_logo_scale_desktop = max( 60, min( 160, absint( get_theme_mod( 'flavor_footer_logo_scale_desktop', flavor_get_theme_default( 'flavor_footer_logo_scale_desktop', 100 ) ) ) ) );

    $logo_width_mobile    = (int) round( 110 * ( $logo_scale_mobile / 100 ) );
    $logo_height_mobile   = (int) round( 32 * ( $logo_scale_mobile / 100 ) );
    $logo_width_desktop   = (int) round( 132 * ( $logo_scale_desktop / 100 ) );
    $logo_height_desktop  = (int) round( 40 * ( $logo_scale_desktop / 100 ) );
    $footer_logo_height_mobile  = (int) round( 32 * ( $footer_logo_scale_mobile / 100 ) );
    $footer_logo_height_desktop = (int) round( 40 * ( $footer_logo_scale_desktop / 100 ) );

    $css = '
:root {
    --flavor-logo-width-mobile: ' . $logo_width_mobile . 'px;
    --flavor-logo-height-mobile: ' . $logo_height_mobile . 'px;
    --flavor-logo-width-desktop: ' . $logo_width_desktop . 'px;
    --flavor-logo-height-desktop: ' . $logo_height_desktop . 'px;
    --flavor-footer-logo-height-mobile: ' . $footer_logo_height_mobile . 'px;
    --flavor-footer-logo-height-desktop: ' . $footer_logo_height_desktop . 'px;
}

.site-shell {
    min-height: 100vh;
    min-height: 100dvh;
    display: flex;
    flex-direction: column;
}

.site-footer {
    margin-top: auto;
    width: 100%;
}

.site-header-branding {
    width: var(--flavor-logo-width-mobile);
    height: var(--flavor-logo-height-mobile);
    min-width: var(--flavor-logo-width-mobile);
    display: flex;
    align-items: center;
    justify-content: flex-start;
    overflow: hidden;
}

@media (min-width: 768px) {
    .site-header-branding {
        width: var(--flavor-logo-width-desktop);
        height: var(--flavor-logo-height-desktop);
        min-width: var(--flavor-logo-width-desktop);
    }
}

.site-header-branding .custom-logo-link {
    display: flex;
    align-items: center;
    width: 100%;
    height: 100%;
    line-height: 0;
}

.site-header-branding .custom-logo {
    display: block;
    width: auto;
    height: auto;
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

.site-footer-branding {
    display: inline-flex;
    align-items: center;
    line-height: 0;
    max-width: 140px;
}

.site-footer-branding-image {
    display: block;
    width: auto;
    height: var(--flavor-footer-logo-height-mobile);
    max-width: 100%;
    object-fit: contain;
}

.site-footer-inner {
    padding-bottom: calc(6rem + env(safe-area-inset-bottom, 0px));
}

@media (min-width: 768px) {
    .site-footer-branding {
        max-width: 180px;
    }

    .site-footer-branding-image {
        height: var(--flavor-footer-logo-height-desktop);
    }
}

@media (min-width: 810px) {
    .site-footer-inner {
        padding-bottom: 2.5rem;
    }
}

.product-card-price del {
    margin-right: 0.25rem;
    font-size: 0.75rem;
    line-height: 1rem;
    font-weight: 400;
    color: #6B7280;
    text-decoration: line-through;
}

.product-card-price ins {
    color: #252525;
    font-weight: 700;
    text-decoration: none;
}

.product-card-price .price-decimals {
    font-size: 0.56em;
    line-height: 1;
    position: relative;
    top: 0.22em;
    vertical-align: baseline;
}

.product-single-price .price-decimals,
.product-single-sticky-price .price-decimals {
    font-size: 0.5em;
    line-height: 1;
    position: relative;
    top: 0.24em;
    vertical-align: baseline;
}

.wp-block-woocommerce-cart .wc-block-cart__submit .wc-block-cart__submit-button.wc-block-components-button,
.wp-block-woocommerce-cart .wp-block-woocommerce-proceed-to-checkout-block .wc-block-components-button.wc-block-cart__submit-button {
    background-color: var(--color-primary, #E15726) !important;
    border: 1px solid var(--color-primary, #E15726) !important;
    color: #ffffff !important;
    border-radius: 0.75rem;
    box-shadow: none;
}

.wp-block-woocommerce-cart .wc-block-cart__submit .wc-block-cart__submit-button.wc-block-components-button:hover,
.wp-block-woocommerce-cart .wc-block-cart__submit .wc-block-cart__submit-button.wc-block-components-button:focus,
.wp-block-woocommerce-cart .wp-block-woocommerce-proceed-to-checkout-block .wc-block-components-button.wc-block-cart__submit-button:hover,
.wp-block-woocommerce-cart .wp-block-woocommerce-proceed-to-checkout-block .wc-block-components-button.wc-block-cart__submit-button:focus {
    background-color: var(--color-primary-hover, var(--color-primary, #E15726)) !important;
    border-color: var(--color-primary-hover, var(--color-primary, #E15726)) !important;
    color: #ffffff !important;
    opacity: 1;
}

.wp-block-woocommerce-cart .wc-block-cart__submit .wc-block-cart__submit-button .wc-block-components-button__text,
.wp-block-woocommerce-cart .wp-block-woocommerce-proceed-to-checkout-block .wc-block-components-button.wc-block-cart__submit-button .wc-block-components-button__text {
    color: inherit;
}

.special-offers-featured-media {
    min-height: 360px;
}

.special-offers-featured-image {
    width: 100%;
    max-width: 340px;
    height: 360px;
    object-fit: contain;
}

.special-offers-list-scroll {
    overflow-y: auto;
}

.special-offers-list-scroll::-webkit-scrollbar {
    width: 6px;
}

.special-offers-list-scroll::-webkit-scrollbar-thumb {
    background-color: rgba(107, 114, 128, 0.35);
    border-radius: 9999px;
}

@media (min-width: 1024px) {
    .special-offers-layout {
        align-items: stretch;
    }

    .special-offers-featured-column {
        flex: 0 0 46%;
        max-width: 46%;
    }

    .special-offers-list-column {
        flex: 0 0 54%;
        max-width: 54%;
    }

    .special-offers-featured-card,
    .special-offers-list-card {
        height: 100%;
    }

    .special-offers-featured-card {
        min-height: 620px;
    }

    .special-offers-featured-media {
        min-height: 420px;
    }

    .special-offers-featured-image {
        max-width: 380px;
        height: 420px;
    }

    .special-offers-list-scroll {
        max-height: 620px;
    }
}
';

    wp_add_inline_style( 'flavor-style', $css );
}
add_action( 'wp_enqueue_scripts', 'flavor_enqueue_inline_overrides', 25 );

/**
 * Enable live preview for Customizer-only sizing controls.
 */
function flavor_enqueue_customizer_preview_assets() {
    wp_enqueue_script(
        'flavor-customizer-preview',
        FLAVOR_URI . '/assets/js/src/customizer-preview.js',
        array( 'customize-preview' ),
        FLAVOR_VERSION,
        true
    );
}
add_action( 'customize_preview_init', 'flavor_enqueue_customizer_preview_assets' );

/**
 * Add defer attribute to Alpine.js scripts.
 *
 * @param string $tag    Script HTML tag.
 * @param string $handle Script handle.
 * @return string
 */
function flavor_defer_alpine( $tag, $handle ) {
    if ( in_array( $handle, array( 'alpinejs', 'alpinejs-collapse', 'flavor-alpine-components' ), true ) ) {
        return str_replace( ' src', ' defer src', $tag );
    }
    return $tag;
}
add_filter( 'script_loader_tag', 'flavor_defer_alpine', 10, 2 );

/**
 * Preload Inter font.
 */
function flavor_preload_fonts() {
    echo '<style>[x-cloak]{display:none!important}</style>' . "\n";
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}
add_action( 'wp_head', 'flavor_preload_fonts', 1 );
