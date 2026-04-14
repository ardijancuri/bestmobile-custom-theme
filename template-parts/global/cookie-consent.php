<?php
/**
 * Cookie consent bar
 *
 * @package Flavor
 */

defined( 'ABSPATH' ) || exit;
?>

<div
    x-data="{
        show: !localStorage.getItem('cookie_accepted'),
        isDesktop: window.innerWidth >= 1024,
        syncPosition() {
            if (!this.show) {
                this.$store.ui.setCookieBannerTop(0);
                return;
            }

            this.$nextTick(() => {
                const rect = this.$el.getBoundingClientRect();
                this.$store.ui.setCookieBannerTop(Math.max(window.innerHeight - rect.top, 0));
            });
        },
        accept() {
            localStorage.setItem('cookie_accepted', '1');
            this.show = false;
            this.$store.ui.setCookieBannerTop(0);
        }
    }"
    x-init="$watch('show', () => syncPosition()); syncPosition()"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="translate-y-full opacity-0"
    x-transition:enter-end="translate-y-0 opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="translate-y-0 opacity-100"
    x-transition:leave-end="translate-y-full opacity-0"
    @resize.window="isDesktop = window.innerWidth >= 1024; syncPosition()"
    x-cloak
    class="fixed left-0 right-0 z-50 px-4 py-3 text-white"
    :style="{ backgroundColor: '#252525', bottom: isDesktop ? '0px' : 'calc(3.5rem + env(safe-area-inset-bottom, 0px))' }"
>
    <div class="container-site flex flex-col sm:flex-row items-center justify-between gap-3">
        <p class="text-sm text-gray-300">
            <?php esc_html_e( 'We use cookies to enhance your experience. By continuing to browse, you agree to our use of cookies.', 'flavor' ); ?>
        </p>
        <button
            @click="accept()"
            class="shrink-0 px-4 py-1.5 bg-primary text-white text-sm font-medium rounded hover:bg-primary/90 transition-colors"
        >
            <?php esc_html_e( 'Close', 'flavor' ); ?>
        </button>
    </div>
</div>
