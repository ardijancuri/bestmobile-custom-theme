<?php
/**
 * Popular Categories — Large CTA cards
 *
 * @package Flavor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$enabled = get_theme_mod( 'flavor_popular_cats_enabled', true );
if ( ! $enabled ) {
	return;
}

$title   = get_theme_mod( 'flavor_popular_cats_title', __( 'Popular Categories', 'flavor' ) );
$cat_ids = get_theme_mod( 'flavor_popular_cats_ids', '' );

if ( $cat_ids ) {
	$cat_ids    = array_filter( array_map( 'absint', explode( ',', $cat_ids ) ) );
	$categories = array();
	foreach ( $cat_ids as $id ) {
		$term = get_term( $id, 'product_cat' );
		if ( $term && ! is_wp_error( $term ) ) {
			$categories[] = $term;
		}
	}
	$categories = array_slice( $categories, 0, 4 );
} else {
	$categories = get_terms( array(
		'taxonomy'   => 'product_cat',
		'hide_empty' => true,
		'parent'     => 0,
		'number'     => 4,
		'orderby'    => 'count',
		'order'      => 'DESC',
		'exclude'    => array( get_option( 'default_product_cat' ) ),
	) );
	if ( is_wp_error( $categories ) ) {
		$categories = array();
	}
}

if ( empty( $categories ) ) {
	return;
}
?>

<section class="my-6" aria-label="<?php echo esc_attr( $title ); ?>">
	<h2 class="text-lg font-bold text-gray-700 mb-4"><?php echo esc_html( $title ); ?></h2>

	<div class="grid grid-cols-1 tablet-sm:grid-cols-2 lg:grid-cols-4 gap-4">
		<?php foreach ( $categories as $cat ) :
			$used_product_ids  = flavor_homepage_get_used_product_ids();
			$category_products = wc_get_products(
				array(
					'status'   => 'publish',
					'limit'    => 1,
					'orderby'  => 'date',
					'order'    => 'DESC',
					'category' => array( $cat->slug ),
					'exclude'  => $used_product_ids,
				)
			);
			$product_image_id = ! empty( $category_products ) ? $category_products[0]->get_image_id() : 0;
			$image_url        = $product_image_id ? wp_get_attachment_image_url( $product_image_id, 'flavor-product-card' ) : wc_placeholder_img_src( 'medium' );

			if ( ! empty( $category_products ) ) {
				flavor_homepage_add_used_product_ids( array( $category_products[0]->get_id() ) );
			}
		?>
			<a href="<?php echo esc_url( get_term_link( $cat ) ); ?>"
			   class="bg-gray-50 rounded-lg p-4 flex items-start justify-between gap-4 hover:shadow-md transition-shadow group">
				<div class="flex-1 min-w-0 self-start">
					<h3 class="text-base font-bold text-gray-700 mb-1 group-hover:text-primary transition-colors">
						<?php echo esc_html( $cat->name ); ?>
					</h3>
					<span class="inline-flex items-center text-sm text-primary font-medium align-top">
						<?php esc_html_e( 'Buy now', 'flavor' ); ?>
						<svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
					</span>
				</div>
				<?php if ( $image_url ) : ?>
					<img src="<?php echo esc_url( $image_url ); ?>"
						 alt="<?php echo esc_attr( $cat->name ); ?>"
						 class="w-[140px] h-[140px] lg:w-[170px] lg:h-[170px] rounded-lg object-contain flex-shrink-0 self-start"
						 loading="lazy">
				<?php endif; ?>
			</a>
		<?php endforeach; ?>
	</div>
</section>
