<?php
/**
 * All Products — Infinite scroll grid
 *
 * @package Flavor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$enabled   = get_theme_mod( 'flavor_all_products_enabled', true );
if ( ! $enabled ) {
	return;
}

$title     = get_theme_mod( 'flavor_all_products_title', __( 'All Products', 'flavor' ) );
$per_page  = absint( get_theme_mod( 'flavor_all_products_per_page', 10 ) );
$used_ids  = flavor_homepage_get_used_product_ids();

// Initial products
$query_args = array(
	'post_type'           => 'product',
	'post_status'         => 'publish',
	'posts_per_page'      => $per_page,
	'paged'               => 1,
	'ignore_sticky_posts' => true,
	'orderby'             => array(
		'date' => 'DESC',
		'ID'   => 'DESC',
	),
);

if ( ! empty( $used_ids ) ) {
	$query_args['post__not_in'] = $used_ids;
}

$products_query = new WP_Query( $query_args );
$max_pages      = (int) $products_query->max_num_pages;
$initial_ids    = array();
?>

<section class="my-6" x-data="flavorAllProducts({ perPage: <?php echo (int) $per_page; ?>, ended: <?php echo $max_pages <= 1 ? 'true' : 'false'; ?>, sectionKey: 'homepage-all-products' })" aria-label="<?php echo esc_attr( $title ); ?>">
	<h2 class="text-lg font-bold text-gray-700 mb-4"><?php echo esc_html( $title ); ?></h2>

	<div x-ref="grid" class="grid grid-cols-2 tablet-sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-4" id="allProductsGrid">
		<?php
		if ( $products_query->have_posts() ) :
			while ( $products_query->have_posts() ) :
				$products_query->the_post();
				$initial_ids[]      = get_the_ID();
				$GLOBALS['product'] = wc_get_product( get_the_ID() );
				get_template_part( 'template-parts/product/product-card' );
			endwhile;
		else :
			?>
			<p class="col-span-full py-8 text-center text-gray-500"><?php esc_html_e( 'No products found.', 'flavor' ); ?></p>
			<?php
		endif;
		wp_reset_postdata();

		if ( ! empty( $initial_ids ) ) {
			flavor_homepage_add_used_product_ids( $initial_ids );
		}
		?>

	</div>

	<!-- Show More / End message -->
	<div class="text-center mt-6">
		<template x-if="!ended && !loading">
			<button type="button" @click="loadMore()"
					class="bg-primary border border-primary text-sm font-medium text-white px-8 py-2.5 rounded-lg hover:bg-primary/90 hover:border-primary/90 transition-colors shadow-sm">
				<?php esc_html_e( 'Show More', 'flavor' ); ?>
			</button>
		</template>
		<template x-if="loading">
			<div class="grid grid-cols-2 tablet-sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-4">
				<template x-for="n in <?php echo esc_attr( min( $per_page, 5 ) ); ?>" :key="n">
					<?php get_template_part( 'template-parts/product/product-card-skeleton' ); ?>
				</template>
			</div>
		</template>
		<template x-if="ended">
			<p class="text-sm text-gray-500"><?php esc_html_e( 'End of results', 'flavor' ); ?></p>
		</template>
	</div>
</section>
