<?php
/**
 * The Template for displaying product archives (shop / category pages).
 *
 * Override of woocommerce/templates/archive-product.php
 *
 * @package Flavor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$is_ajax = wp_doing_ajax();
$wp_query       = $GLOBALS['wp_query'] ?? null;
$total_products = $wp_query instanceof WP_Query ? (int) $wp_query->found_posts : 0;
$current_page   = max( 1, absint( get_query_var( 'paged' ) ?: get_query_var( 'page' ) ?: 1 ) );
$max_pages      = $wp_query instanceof WP_Query ? (int) $wp_query->max_num_pages : 1;
$per_page       = $wp_query instanceof WP_Query && ! empty( $wp_query->query_vars['posts_per_page'] ) ? absint( $wp_query->query_vars['posts_per_page'] ) : absint( get_option( 'posts_per_page', 12 ) );
$archive_type   = is_search() ? 'search' : ( is_product_category() ? 'category' : 'shop' );
$category_id    = 0;

if ( is_product_category() ) {
	$queried_object = get_queried_object();
	if ( $queried_object instanceof WP_Term ) {
		$category_id = (int) $queried_object->term_id;
	}
}

$shop_page_payload = wp_json_encode(
	array(
		'totalProducts' => $total_products,
		'currentPage'   => $current_page,
		'hasMore'       => $current_page < $max_pages,
		'perPage'       => max( 1, $per_page ),
		'archiveType'   => $archive_type,
		'categoryId'    => $category_id,
		'searchQuery'   => is_search() ? get_search_query() : '',
		'sortBy'        => 'relevance',
	)
);
?>

<div class="max-w-site-xxl mx-auto px-3 md:px-4" x-data="shopPage(<?php echo esc_attr( $shop_page_payload ); ?>)">

	<?php get_template_part( 'template-parts/global/breadcrumbs' ); ?>

	<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
		<h1 class="text-xl md:text-2xl font-bold text-gray-700 mb-3">
			<?php woocommerce_page_title(); ?>
		</h1>
	<?php endif; ?>

	<!-- Toolbar: Tabs + Sort in one row -->
	<div class="flex items-center justify-between gap-3 border-b border-gray-300 overflow-hidden">
		<div class="flex items-center gap-0 overflow-x-auto overflow-y-hidden scrollbar-hide">
			<button
				@click="filterDrawerOpen = true"
				class="lg:hidden inline-flex items-center gap-2 px-3 py-3 text-sm font-medium text-gray-600 hover:text-primary transition-colors flex-shrink-0"
			>
				<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
				<?php esc_html_e( 'Filters', 'flavor' ); ?>
				<span x-show="activeFilterCount > 0" x-cloak x-text="activeFilterCount" class="bg-primary text-white text-xs rounded-full w-5 h-5 flex items-center justify-center"></span>
			</button>
			<?php
			$tabs = array(
				''            => __( 'All products', 'flavor' ),
				'bestsellers' => __( 'Best sellers', 'flavor' ),
				'most_viewed' => __( 'Most viewed', 'flavor' ),
				'top_rated'   => __( 'Top rated', 'flavor' ),
			);
			foreach ( $tabs as $key => $label ) : ?>
				<button
					@click="quickFilter = '<?php echo esc_js( $key ); ?>'; loadProducts(1)"
					:class="quickFilter === '<?php echo esc_js( $key ); ?>' ? 'border-primary text-primary font-semibold' : 'border-transparent text-gray-600 hover:text-gray-700'"
					class="px-4 py-3 text-sm whitespace-nowrap border-b-2 -mb-px transition-colors flex-shrink-0"
				>
					<?php echo esc_html( $label ); ?>
				</button>
			<?php endforeach; ?>
		</div>
		<div class="flex-shrink-0">
			<?php get_template_part( 'template-parts/shop/sort-dropdown' ); ?>
		</div>
	</div>

	<!-- Mobile filter drawer -->
	<?php get_template_part( 'template-parts/shop/filter-drawer' ); ?>

	<div class="flex gap-6 mt-4">
		<!-- LEFT SIDEBAR (filters) — desktop only -->
		<aside class="hidden lg:block w-[280px] flex-shrink-0">
			<?php get_template_part( 'template-parts/shop/filter-sidebar' ); ?>
		</aside>

		<!-- MAIN CONTENT -->
		<div class="flex-1 min-w-0">
			<?php get_template_part( 'template-parts/shop/product-grid' ); ?>

			<?php if ( ! $is_ajax ) : ?>
				<?php get_template_part( 'template-parts/shop/seo-content' ); ?>
			<?php endif; ?>
		</div>
	</div>

</div>

<?php
get_footer();
