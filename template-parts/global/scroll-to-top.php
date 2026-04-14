<?php
/**
 * Scroll to top button
 *
 * @package Flavor
 */

defined( 'ABSPATH' ) || exit;
?>

<div
    x-data="{
        show: false,
        isDesktop: window.innerWidth >= 1024,
        get bottomOffset() {
            const baseOffset = this.isDesktop ? 24 : 80;
            const cookieBannerTop = this.$store.ui.cookieBannerTop || 0;

            return `${cookieBannerTop > 0 ? cookieBannerTop + 16 : baseOffset}px`;
        }
    }"
    @scroll.window="show = window.scrollY > 400"
    @resize.window="isDesktop = window.innerWidth >= 1024"
    x-cloak
>
    <button
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-75"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-75"
        @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
        class="fixed right-4 bg-primary text-white rounded-full w-10 h-10 shadow-lg flex items-center justify-center hover:bg-primary/90 transition-colors"
        :style="{ bottom: bottomOffset, zIndex: 40 }"
        aria-label="<?php esc_attr_e( 'Scroll to top', 'flavor' ); ?>"
    >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
    </button>
</div>
