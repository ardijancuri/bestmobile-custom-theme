<?php
/**
 * Main Header Bar
 *
 * @package Flavor
 */

defined( 'ABSPATH' ) || exit;

$cart_count = function_exists( 'WC' ) && WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
$account_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : '#';
?>

<header class="bg-black-dark sticky top-0 z-50">
    <div class="container-site">
        <!-- Mobile Layout: h-[110px] with flex-wrap -->
        <div class="flex flex-wrap items-center justify-between h-[110px] md:h-16 py-2 md:py-0">

            <!-- Left: Logo -->
            <div class="flex items-center order-1">
                <!-- Mobile menu toggle -->
                <button
                    @click="mobileMenuOpen = true"
                    class="md:hidden mr-3 text-white p-1"
                    aria-label="<?php esc_attr_e( 'Open menu', 'flavor' ); ?>"
                >
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <?php if ( has_custom_logo() ) : ?>
                    <div class="site-header-branding flex shrink-0 items-center overflow-hidden leading-none">
                        <?php the_custom_logo(); ?>
                    </div>
                <?php else : ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="text-white text-xl font-bold leading-none">
                        <?php bloginfo( 'name' ); ?>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Center: Search (desktop) -->
            <div class="hidden md:block md:w-1/2 order-2">
                <?php get_template_part( 'template-parts/header/search-bar' ); ?>
            </div>

            <!-- Right: Icons -->
            <div class="flex items-center gap-4 order-3 text-white">
                <!-- Wishlist -->
                <a href="<?php echo esc_url( home_url( '/wishlist/' ) ); ?>" class="relative group flex items-center">
                    <svg class="w-5 h-5 group-hover:text-primary transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    <span x-show="$store.wishlist.items.length > 0" x-text="$store.wishlist.items.length" x-cloak class="absolute -top-2 -right-2 bg-primary text-white text-[10px] font-bold rounded-full w-4 h-4 flex items-center justify-center"></span>
                </a>

                <!-- Cart -->
                <div class="relative">
                    <button
                        @click="$dispatch('open-mini-cart')"
                        class="relative group flex items-center"
                        aria-label="<?php esc_attr_e( 'Cart', 'flavor' ); ?>"
                    >
                        <svg class="w-5 h-5 group-hover:text-primary transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <span class="cart-count absolute -top-2 -right-2 bg-primary text-white text-[10px] font-bold rounded-full w-4 h-4 flex items-center justify-center <?php echo $cart_count > 0 ? '' : 'hidden'; ?>"><?php echo esc_html( $cart_count ); ?></span>
                    </button>
                </div>

                <!-- User / Login -->
                <a href="<?php echo esc_url( $account_url ); ?>" class="group flex items-center gap-1">
                    <svg class="w-5 h-5 group-hover:text-primary transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span class="hidden md:inline text-sm group-hover:text-primary transition-colors">
                        <?php echo is_user_logged_in() ? esc_html__( 'Account', 'flavor' ) : esc_html__( 'Login', 'flavor' ); ?>
                    </span>
                </a>
            </div>

            <!-- Mobile: Search (bottom row) -->
            <div class="w-full order-4 md:hidden mt-1">
                <?php get_template_part( 'template-parts/header/search-bar' ); ?>
            </div>
        </div>
    </div>
</header>
