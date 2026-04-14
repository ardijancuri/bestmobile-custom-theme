<?php
/**
 * Tabbed Products — Recommended products with category tabs
 *
 * @package Flavor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$enabled = get_theme_mod( 'flavor_tabbed_products_enabled', true );
if ( ! $enabled ) {
	return;
}

$section_title = get_theme_mod( 'flavor_tabbed_products_title', __( 'Recommended for you', 'flavor' ) );

// Build tabs: first is "For you" (all), rest from customizer categories
$tabs = array(
	array(
		'slug' => 'for-you',
		'name' => esc_html__( 'For you', 'flavor' ),
		'cat'  => 0,
	),
);

$tab_cats = get_theme_mod( 'flavor_tabbed_products_categories', '' );
if ( $tab_cats ) {
	$cat_ids = array_filter( array_map( 'absint', explode( ',', $tab_cats ) ) );
	foreach ( $cat_ids as $cat_id ) {
		$term = get_term( $cat_id, 'product_cat' );
		if ( $term && ! is_wp_error( $term ) ) {
			$tabs[] = array(
				'slug' => $term->slug,
				'name' => esc_html( $term->name ),
				'cat'  => $cat_id,
			);
		}
	}
}

$see_all_link = get_theme_mod( 'flavor_tabbed_products_see_all_link', '' );
$per_page     = 10;
$used_ids     = flavor_homepage_get_used_product_ids();

$initial_query_args = array(
	'post_type'           => 'product',
	'post_status'         => 'publish',
	'posts_per_page'      => $per_page,
	'ignore_sticky_posts' => true,
	'meta_query'          => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
		'relation' => 'OR',
		array(
			'key'     => '_flavor_show_in_special_offers',
			'compare' => 'NOT EXISTS',
		),
		array(
			'key'     => '_flavor_show_in_special_offers',
			'value'   => 'yes',
			'compare' => '!=',
		),
	),
	'orderby'             => array(
		'date' => 'DESC',
		'ID'   => 'DESC',
	),
);

if ( ! empty( $used_ids ) ) {
	$initial_query_args['post__not_in'] = $used_ids;
}

$initial_query = new WP_Query( $initial_query_args );
$initial_ids   = array();

ob_start();
if ( $initial_query->have_posts() ) {
	while ( $initial_query->have_posts() ) {
		$initial_query->the_post();
		$initial_ids[]      = get_the_ID();
		$GLOBALS['product'] = wc_get_product( get_the_ID() );
		get_template_part( 'template-parts/product/product-card' );
	}
} else {
	?>
	<p class="col-span-full py-8 text-center text-gray-500"><?php esc_html_e( 'No products found.', 'flavor' ); ?></p>
	<?php
}
$initial_html = ob_get_clean();

wp_reset_postdata();

if ( ! empty( $initial_ids ) ) {
	flavor_homepage_add_used_product_ids( $initial_ids );
}
?>

<section class="my-6" x-data="flavorTabbedProducts({initialTab: 'for-you', initialCat: 0, sectionKey: 'homepage-tabbed'})" aria-label="<?php echo esc_attr( $section_title ); ?>">
	<!-- Header -->
	<div class="flex items-center justify-between mb-4">
		<h2 class="text-lg font-bold text-gray-700"><?php echo esc_html( $section_title ); ?></h2>
		<?php if ( $see_all_link ) : ?>
			<a href="<?php echo esc_url( $see_all_link ); ?>" class="text-sm text-primary hover:underline">
				<?php esc_html_e( 'See all', 'flavor' ); ?>
				<svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
			</a>
		<?php endif; ?>
	</div>

	<!-- Tabs -->
	<div class="flex border-b border-gray-200 mb-4 overflow-x-auto scrollbar-hide">
		<?php foreach ( $tabs as $i => $tab ) : ?>
			<button @click="switchTab('<?php echo esc_attr( $tab['slug'] ); ?>', <?php echo esc_attr( $tab['cat'] ); ?>)"
					class="px-4 py-3 text-sm font-medium whitespace-nowrap transition-colors relative"
					:class="activeTab === '<?php echo esc_attr( $tab['slug'] ); ?>' ? 'text-primary' : 'text-gray-500 hover:text-gray-700'">
				<?php echo esc_html( $tab['name'] ); ?>
				<span class="absolute bottom-0 left-0 right-0 h-0.5 bg-primary transition-opacity"
					  :class="activeTab === '<?php echo esc_attr( $tab['slug'] ); ?>' ? 'opacity-100' : 'opacity-0'"></span>
			</button>
		<?php endforeach; ?>
	</div>

	<!-- Product Grid (AJAX loaded) -->
	<div x-ref="grid"
		 class="grid grid-cols-2 tablet-sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-4 transition-opacity duration-300"
		 :class="loading ? 'opacity-0' : 'opacity-100'"><?php echo $initial_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
</section>
