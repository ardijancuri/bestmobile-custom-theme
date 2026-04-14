<?php
/**
 * Footer column: FAQ
 *
 * @package Flavor
 */

defined( 'ABSPATH' ) || exit;

$faq_url = home_url( '/faq' );
?>

<div x-data="{ open: false }">
    <h4
        class="text-sm font-semibold uppercase tracking-wider mb-3 md:mb-4 cursor-pointer flex items-center justify-between lg:cursor-default"
        @click="open = !open"
    >
        <?php esc_html_e( 'FAQ', 'flavor' ); ?>
        <svg class="w-4 h-4 lg:hidden transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
    </h4>

    <ul class="space-y-1.5 md:space-y-2 text-sm text-gray-400 lg:!block" x-show="open" x-cloak x-transition>
        <li>
            <a href="<?php echo esc_url( $faq_url . '#about' ); ?>" class="hover:text-white transition-colors">
                <?php esc_html_e( 'About', 'flavor' ); ?>
            </a>
        </li>
        <li>
            <a href="<?php echo esc_url( $faq_url . '#payments' ); ?>" class="hover:text-white transition-colors">
                <?php esc_html_e( 'Payments', 'flavor' ); ?>
            </a>
        </li>
        <li>
            <a href="<?php echo esc_url( $faq_url . '#technical' ); ?>" class="hover:text-white transition-colors">
                <?php esc_html_e( 'Technical', 'flavor' ); ?>
            </a>
        </li>
        <li>
            <a href="<?php echo esc_url( $faq_url . '#shipping' ); ?>" class="hover:text-white transition-colors">
                <?php esc_html_e( 'Shipping', 'flavor' ); ?>
            </a>
        </li>
        <li>
            <a href="<?php echo esc_url( $faq_url . '#orders' ); ?>" class="hover:text-white transition-colors">
                <?php esc_html_e( 'Orders', 'flavor' ); ?>
            </a>
        </li>
    </ul>
</div>
