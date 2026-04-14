<?php
/**
 * Footer column: Account
 *
 * @package Flavor
 */

defined( 'ABSPATH' ) || exit;
?>

<div x-data="{ open: false }">
    <h4
        class="text-sm font-semibold uppercase tracking-wider mb-3 md:mb-4 cursor-pointer flex items-center justify-between lg:cursor-default"
        @click="open = !open"
    >
        <?php esc_html_e( 'Account', 'flavor' ); ?>
        <svg class="w-4 h-4 lg:hidden transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
    </h4>

    <ul class="space-y-1.5 md:space-y-2 text-sm text-gray-400 lg:!block" x-cloak x-show="open" x-transition>
        <li>
            <a href="<?php echo esc_url( function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : home_url( '/cart' ) ); ?>" class="hover:text-white transition-colors">
                <?php esc_html_e( 'My Cart', 'flavor' ); ?>
            </a>
        </li>
        <li>
            <a href="<?php echo esc_url( function_exists( 'wc_get_account_endpoint_url' ) ? wc_get_account_endpoint_url( 'orders' ) : home_url( '/my-account/orders' ) ); ?>" class="hover:text-white transition-colors">
                <?php esc_html_e( 'Orders', 'flavor' ); ?>
            </a>
        </li>
        <li>
            <a href="<?php echo esc_url( home_url( '/wishlist' ) ); ?>" class="hover:text-white transition-colors">
                <?php esc_html_e( 'Wishlist', 'flavor' ); ?>
            </a>
        </li>
        <li>
            <a href="<?php echo esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : home_url( '/my-account' ) ); ?>" class="hover:text-white transition-colors">
                <?php esc_html_e( 'My Account', 'flavor' ); ?>
            </a>
        </li>
    </ul>
</div>
