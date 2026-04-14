<?php
/**
 * Mobile bottom navigation
 *
 * @package Flavor
 */

defined( 'ABSPATH' ) || exit;

if ( ! get_theme_mod( 'flavor_bottom_nav', true ) ) {
    return;
}

$cart_url    = function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : home_url( '/cart' );
$account_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : home_url( '/my-account' );
$cart_count  = function_exists( 'WC' ) && WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
?>

<nav class="w-full z-40 bg-white shadow-[0_-2px_10px_rgba(0,0,0,0.1)] border-t border-gray-200 lg:hidden" style="position: fixed; bottom: 0; left: 0; right: 0; -webkit-transform: translate3d(0,0,0); transform: translate3d(0,0,0); -webkit-backface-visibility: hidden; backface-visibility: hidden; padding-bottom: env(safe-area-inset-bottom, 0px);" aria-label="<?php esc_attr_e( 'Mobile navigation', 'flavor' ); ?>">
    <div class="flex items-center justify-around h-14">
        <!-- Home -->
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex flex-col items-center gap-0.5 text-xs <?php echo is_front_page() ? 'text-primary' : 'text-gray-500'; ?>">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1h-2z"/></svg>
            <span><?php esc_html_e( 'Home', 'flavor' ); ?></span>
        </a>

        <!-- Categories -->
        <button
            @click="mobileMenuOpen = !mobileMenuOpen"
            class="flex flex-col items-center gap-0.5 text-xs text-gray-500"
            type="button"
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
            <span><?php esc_html_e( 'Categories', 'flavor' ); ?></span>
        </button>

        <!-- Cart -->
        <a href="<?php echo esc_url( $cart_url ); ?>" class="relative flex flex-col items-center gap-0.5 text-xs <?php echo is_cart() ? 'text-primary' : 'text-gray-500'; ?>">
            <span class="relative">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                <span class="absolute -top-1.5 -right-1.5 bg-primary text-white text-[10px] font-bold rounded-full w-4 h-4 flex items-center justify-center cart-count <?php echo $cart_count > 0 ? '' : 'hidden'; ?>"><?php echo esc_html( $cart_count ); ?></span>
            </span>
            <span><?php esc_html_e( 'Cart', 'flavor' ); ?></span>
        </a>

        <!-- Account -->
        <a href="<?php echo esc_url( $account_url ); ?>" class="flex flex-col items-center gap-0.5 text-xs <?php echo is_account_page() ? 'text-primary' : 'text-gray-500'; ?>">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            <span><?php esc_html_e( 'Account', 'flavor' ); ?></span>
        </a>
    </div>
</nav>
