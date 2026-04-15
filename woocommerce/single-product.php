<?php
/**
 * Single Product template override
 *
 * @package Flavor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

?>
<?php

while ( have_posts() ) :
	the_post();

	global $product;
	$sticky_price_html = flavor_price_html_with_small_decimals( $product->get_price_html() );
?>

<div class="max-w-site-xxl mx-auto px-3 md:px-4" x-data="productPage(<?php echo esc_attr( wp_json_encode( array(
	'productId'      => $product->get_id(),
	'price'          => (float) $product->get_price(),
	'regularPrice'   => (float) $product->get_regular_price(),
	'inStock'        => $product->is_in_stock(),
	'warrantyPrice'  => (float) get_post_meta( $product->get_id(), '_flavor_warranty_price', true ),
) ) ); ?>)">

	<?php get_template_part( 'template-parts/global/breadcrumbs' ); ?>

	<!-- Main product section -->
	<div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-8 py-4">
		<div>
			<?php get_template_part( 'template-parts/product/product-gallery' ); ?>
		</div>
		<div>
			<?php get_template_part( 'template-parts/product/product-info' ); ?>

			<?php if ( get_theme_mod( 'flavor_warranty_enabled', true ) ) : ?>
				<?php get_template_part( 'template-parts/product/warranty-upsell' ); ?>
			<?php endif; ?>

			<?php get_template_part( 'template-parts/product/shipping-estimate' ); ?>
		</div>
	</div>

	<?php get_template_part( 'template-parts/product/product-tabs' ); ?>
	<?php get_template_part( 'template-parts/product/cross-sells' ); ?>

</div>

<?php get_template_part( 'template-parts/product/buy-now' ); ?>

<!-- Mobile sticky bar -->
<div
	x-data="mobileStickyBar()"
	x-show="visible"
	x-transition:enter="transition-transform ease-out duration-200"
	x-transition:enter-start="translate-y-full"
	x-transition:enter-end="translate-y-0"
	x-transition:leave="transition-transform ease-in duration-150"
	x-transition:leave-start="translate-y-0"
	x-transition:leave-end="translate-y-full"
	class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-300 shadow-lg z-40 px-4 pb-3 md:hidden"
	style="display: none;"
>
	<div class="flex items-center justify-between gap-3">
		<div>
			<span class="product-single-sticky-price text-lg font-bold"><?php echo wp_kses_post( $sticky_price_html ); ?></span>
		</div>
		<button
			@click="$dispatch('add-to-cart', { id: <?php echo absint( $product->get_id() ); ?>, qty: 1 })"
			class="bg-primary text-white font-semibold px-6 py-2.5 rounded-lg hover:bg-primary/90 transition-colors whitespace-nowrap"
		>
			<?php esc_html_e( 'Add to Cart', 'flavor' ); ?>
		</button>
	</div>
</div>

<?php
endwhile;

get_footer();
