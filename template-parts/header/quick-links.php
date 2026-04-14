<?php
/**
 * Quick Links Bar - Below Header
 *
 * @package Flavor
 */

defined( 'ABSPATH' ) || exit;
?>

<nav class="bg-white border-b border-gray-100 hidden tablet-sm:flex" aria-label="<?php esc_attr_e( 'Quick links', 'flavor' ); ?>">
    <div class="container-site flex items-center justify-between py-2">
        <!-- Left: Categories + Quick Links -->
        <div class="flex items-center gap-6">
            <!-- Categories Button -->
            <button
                @click="$dispatch('toggle-mega-menu')"
                class="flex items-center gap-2 text-sm font-semibold text-gray-900 hover:text-primary transition-colors"
            >
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <?php esc_html_e( 'Categories', 'flavor' ); ?>
            </button>

            <!-- Quick Links Menu -->
            <?php
            wp_nav_menu(
                array(
                    'theme_location' => 'quick-links',
                    'container'      => false,
                    'menu_class'     => 'flex items-center gap-5',
                    'depth'          => 1,
                    'fallback_cb'    => function () {
                        ?>
                        <ul class="flex items-center gap-5">
                            <li><a href="#" class="text-sm text-gray-600 hover:text-primary transition-colors"><?php esc_html_e( 'Outlet', 'flavor' ); ?></a></li>
                            <li><a href="#" class="text-sm text-gray-600 hover:text-primary transition-colors"><?php esc_html_e( "What's New", 'flavor' ); ?></a></li>
                            <li><a href="#" class="text-sm text-gray-600 hover:text-primary transition-colors"><?php esc_html_e( 'Gift Card', 'flavor' ); ?></a></li>
                        </ul>
                        <?php
                    },
                )
            );
            ?>
        </div>

        <!-- Right: Chat -->
        <button
            class="flex items-center gap-1.5 text-sm text-gray-600 hover:text-primary transition-colors"
            aria-label="<?php esc_attr_e( 'Chat', 'flavor' ); ?>"
        >
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
            <span class="hidden lg:inline"><?php esc_html_e( 'Chat', 'flavor' ); ?></span>
        </button>
    </div>
</nav>
