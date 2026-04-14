<?php
/**
 * Product gallery - Swiper.js carousel with GLightbox
 *
 * @package Flavor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

$attachment_ids = $product->get_gallery_image_ids();
$main_image_id  = $product->get_image_id();

$image_ids = array();
if ( $main_image_id ) {
	$image_ids[] = $main_image_id;
}
$image_ids = array_values( array_unique( array_filter( array_merge( $image_ids, $attachment_ids ) ) ) );
$total     = count( $image_ids );
?>

<div class="relative js-product-gallery-wrap">
	<?php if ( $total > 1 ) : ?>
	<div class="absolute top-3 right-3 z-10 bg-black/50 text-white text-xs px-2 py-1 rounded-full">
		<span class="js-product-gallery-current">1</span> / <?php echo absint( $total ); ?>
	</div>
	<?php endif; ?>

	<div class="swiper product-gallery-swiper js-product-gallery rounded-lg overflow-hidden bg-gray-50" id="product-gallery-main">
		<div class="swiper-wrapper">
			<?php foreach ( $image_ids as $index => $img_id ) :
				$full_url = wp_get_attachment_image_url( $img_id, 'full' );
				$med_url  = wp_get_attachment_image_url( $img_id, 'flavor-product-gallery' );
				$alt      = get_post_meta( $img_id, '_wp_attachment_image_alt', true ) ?: $product->get_name();
			?>
			<div class="swiper-slide">
				<a href="<?php echo esc_url( $full_url ); ?>" class="glightbox js-gallery-lightbox" data-gallery="product-gallery">
					<img
						src="<?php echo esc_url( $med_url ); ?>"
						alt="<?php echo esc_attr( $alt ); ?>"
						class="w-full aspect-square object-contain"
						width="600"
						height="600"
						loading="<?php echo 0 === $index ? 'eager' : 'lazy'; ?>"
						decoding="async"
					>
				</a>
			</div>
			<?php endforeach; ?>
		</div>

		<?php if ( $total > 1 ) : ?>
		<div class="swiper-button-prev js-gallery-prev !text-gray-700 !w-8 !h-8 !bg-white/80 !rounded-full after:!text-xs"></div>
		<div class="swiper-button-next js-gallery-next !text-gray-700 !w-8 !h-8 !bg-white/80 !rounded-full after:!text-xs"></div>
		<div class="swiper-pagination !bottom-2"></div>
		<?php endif; ?>
	</div>

	<?php if ( $total > 1 ) : ?>
	<div class="hidden md:block mt-3">
		<div class="swiper product-gallery-thumbs js-product-thumbs" id="product-gallery-thumbs">
			<div class="swiper-wrapper">
				<?php foreach ( $image_ids as $img_id ) :
					$thumb_url = wp_get_attachment_image_url( $img_id, 'thumbnail' );
				?>
				<div class="swiper-slide !w-16 !h-16 cursor-pointer rounded border-2 border-transparent hover:border-primary transition-colors overflow-hidden">
					<img src="<?php echo esc_url( $thumb_url ); ?>" alt="" class="w-full h-full object-cover" loading="lazy">
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
	<?php endif; ?>
</div>
