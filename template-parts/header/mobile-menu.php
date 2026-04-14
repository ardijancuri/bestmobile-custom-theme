<?php
/**
 * Mobile Menu - Full-screen slide-in drawer
 *
 * @package Flavor
 */

defined( 'ABSPATH' ) || exit;

$product_categories = get_terms(
    array(
        'taxonomy'   => 'product_cat',
        'hide_empty' => false,
        'parent'     => 0,
        'exclude'    => get_option( 'default_product_cat' ),
    )
);

if ( is_wp_error( $product_categories ) ) {
    $product_categories = array();
}
?>

<!-- Overlay -->
<div
    x-show="mobileMenuOpen"
    x-cloak
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    @click="mobileMenuOpen = false"
    class="fixed inset-0 bg-black/50 z-50 tablet-sm:hidden"
></div>

<!-- Drawer -->
<div
    x-show="mobileMenuOpen"
    x-cloak
    x-transition:enter="transition ease-out duration-300 transform"
    x-transition:enter-start="-translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in duration-200 transform"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full"
    @keydown.escape.window="mobileMenuOpen = false"
    class="fixed inset-y-0 left-0 w-full max-w-sm bg-white z-50 overflow-y-auto tablet-sm:hidden"
    x-data="{ openCat: null }"
>
    <!-- Header -->
    <div class="flex items-center justify-between p-4 border-b border-gray-100">
        <span class="text-lg font-bold text-gray-900"><?php esc_html_e( 'Menu', 'flavor' ); ?></span>
        <button
            @click="mobileMenuOpen = false"
            class="p-2 text-gray-500 hover:text-gray-900"
            aria-label="<?php esc_attr_e( 'Close menu', 'flavor' ); ?>"
        >
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Search -->
    <div class="p-4">
        <form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" class="relative">
            <input
                type="search"
                name="s"
                placeholder="<?php esc_attr_e( 'Search products...', 'flavor' ); ?>"
                class="w-full bg-gray-100 rounded-full pl-10 pr-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-0"
            >
            <input type="hidden" name="post_type" value="product">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </form>
    </div>

    <!-- Categories Accordion -->
    <div class="px-4 pb-4">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2"><?php esc_html_e( 'Categories', 'flavor' ); ?></p>
        <ul class="space-y-0.5">
            <?php foreach ( $product_categories as $cat ) :
                $children = get_terms(
                    array(
                        'taxonomy'   => 'product_cat',
                        'hide_empty' => false,
                        'parent'     => $cat->term_id,
                    )
                );
                $has_children = ! is_wp_error( $children ) && ! empty( $children );
                ?>
                <li>
                    <?php if ( $has_children ) : ?>
                        <button
                            @click="openCat = openCat === <?php echo (int) $cat->term_id; ?> ? null : <?php echo (int) $cat->term_id; ?>"
                            class="flex items-center justify-between w-full py-2.5 text-sm text-gray-700 hover:text-primary transition-colors"
                        >
                            <span><?php echo esc_html( $cat->name ); ?></span>
                            <svg
                                class="w-4 h-4 transition-transform duration-200"
                                :class="{ 'rotate-180': openCat === <?php echo (int) $cat->term_id; ?> }"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <ul
                            x-show="openCat === <?php echo (int) $cat->term_id; ?>"
                            x-collapse
                            class="pl-4 space-y-0.5"
                        >
                            <li>
                                <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" class="block py-2 text-sm text-primary font-medium">
                                    <?php
                                    /* translators: %s: category name */
                                    printf( esc_html__( 'All %s', 'flavor' ), esc_html( $cat->name ) );
                                    ?>
                                </a>
                            </li>
                            <?php foreach ( $children as $child ) : ?>
                                <li>
                                    <a href="<?php echo esc_url( get_term_link( $child ) ); ?>" class="block py-2 text-sm text-gray-600 hover:text-primary transition-colors">
                                        <?php echo esc_html( $child->name ); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else : ?>
                        <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" class="block py-2.5 text-sm text-gray-700 hover:text-primary transition-colors">
                            <?php echo esc_html( $cat->name ); ?>
                        </a>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Quick Links -->
    <div class="px-4 pb-6 border-t border-gray-100 pt-4">
        <ul class="space-y-0.5">
            <li><a href="#" class="block py-2.5 text-sm font-medium text-gray-900 hover:text-primary transition-colors"><?php esc_html_e( 'Outlet', 'flavor' ); ?></a></li>
            <li><a href="#" class="block py-2.5 text-sm font-medium text-gray-900 hover:text-primary transition-colors"><?php esc_html_e( "What's New", 'flavor' ); ?></a></li>
            <li><a href="#" class="block py-2.5 text-sm font-medium text-gray-900 hover:text-primary transition-colors"><?php esc_html_e( 'Gift Card', 'flavor' ); ?></a></li>
        </ul>
    </div>
</div>
