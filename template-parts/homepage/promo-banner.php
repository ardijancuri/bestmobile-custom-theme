<?php
/**
 * Promo Banner — Full-width image banner
 *
 * @package Flavor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$enabled   = get_theme_mod( 'flavor_promo_banner_enabled', true );
if ( ! $enabled ) {
	return;
}

$image     = get_theme_mod( 'flavor_promo_banner_image', '' );
$image_mob = get_theme_mod( 'flavor_promo_banner_image_mobile', '' );
$link      = get_theme_mod( 'flavor_promo_banner_link', '' );

if ( ! $image ) {
	return;
}
?>

<section class="my-6" aria-label="<?php esc_attr_e( 'Promotion', 'flavor' ); ?>">
	<?php if ( $link ) : ?>
		<a href="<?php echo esc_url( $link ); ?>" class="block">
	<?php endif; ?>
		<picture>
			<?php if ( $image_mob ) : ?>
				<source media="(max-width: 599px)" srcset="<?php echo esc_url( $image_mob ); ?>">
			<?php endif; ?>
			<source media="(min-width: 600px)" srcset="<?php echo esc_url( $image ); ?>">
			<img src="<?php echo esc_url( $image ); ?>"
				 alt="<?php esc_attr_e( 'Promotional banner', 'flavor' ); ?>"
				 class="w-full rounded-lg shadow-sm object-cover"
				 width="1360" height="240"
				 loading="lazy">
		</picture>
	<?php if ( $link ) : ?>
		</a>
	<?php endif; ?>
</section>
