<?php
/**
 * Footer column: Brand
 *
 * @package Flavor
 */

defined( 'ABSPATH' ) || exit;

$facebook_url  = get_theme_mod( 'flavor_social_facebook', '#' );
$twitter_url   = get_theme_mod( 'flavor_social_twitter', '#' );
$instagram_url = get_theme_mod( 'flavor_social_instagram', '#' );
$brand_text    = get_theme_mod( 'flavor_footer_brand_text', flavor_get_theme_default( 'flavor_footer_brand_text', esc_html__( 'Stay connected', 'flavor' ) ) );
?>

<div class="footer-column-brand">
    <!-- Logo -->
    <div class="mb-3 md:mb-4">
        <?php
        $custom_logo_id = get_theme_mod( 'custom_logo' );
        if ( $custom_logo_id ) :
            $logo_url = wp_get_attachment_image_url( $custom_logo_id, 'medium' );
            ?>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-footer-branding">
                <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php bloginfo( 'name' ); ?>" class="site-footer-branding-image brightness-0 invert">
            </a>
        <?php else : ?>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="text-2xl font-bold text-white hover:text-primary transition-colors">
                <?php bloginfo( 'name' ); ?>
            </a>
        <?php endif; ?>
    </div>

    <!-- Stay connected -->
    <?php if ( '' !== trim( (string) $brand_text ) ) : ?>
        <p class="text-sm text-gray-400 mb-3"><?php echo esc_html( $brand_text ); ?></p>
    <?php endif; ?>

    <!-- Legal links -->
    <nav class="flex flex-wrap items-center gap-4 text-xs text-gray-400">
        <a href="<?php echo esc_url( get_privacy_policy_url() ); ?>" class="hover:text-white transition-colors"><?php esc_html_e( 'Privacy Policy', 'flavor' ); ?></a>
        <a href="<?php echo esc_url( home_url( '/terms' ) ); ?>" class="hover:text-white transition-colors"><?php esc_html_e( 'Terms', 'flavor' ); ?></a>
        <a href="<?php echo esc_url( home_url( '/price-guarantee' ) ); ?>" class="hover:text-white transition-colors"><?php esc_html_e( 'Price Guarantee', 'flavor' ); ?></a>
    </nav>

    <!-- Social icons -->
    <div class="mt-6 mb-4 md:mb-0 flex items-center gap-3 md:gap-4">
        <?php if ( $facebook_url ) : ?>
            <a href="<?php echo esc_url( $facebook_url ); ?>" target="_blank" rel="noopener noreferrer" class="text-white hover:text-primary transition-colors" aria-label="Facebook">
                <svg class="w-6 h-6 md:w-7 md:h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
            </a>
        <?php endif; ?>

        <?php if ( $twitter_url ) : ?>
            <a href="<?php echo esc_url( $twitter_url ); ?>" target="_blank" rel="noopener noreferrer" class="text-white hover:text-primary transition-colors" aria-label="X / Twitter">
                <svg class="w-6 h-6 md:w-7 md:h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
            </a>
        <?php endif; ?>

        <?php if ( $instagram_url ) : ?>
            <a href="<?php echo esc_url( $instagram_url ); ?>" target="_blank" rel="noopener noreferrer" class="text-white hover:text-primary transition-colors" aria-label="Instagram">
                <svg class="w-6 h-6 md:w-7 md:h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
            </a>
        <?php endif; ?>
    </div>
</div>
