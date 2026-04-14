<?php
/**
 * AJAX handlers for Flavor theme
 *
 * @package Flavor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter products via AJAX
 */
add_action( 'wp_ajax_flavor_filter_products', 'flavor_filter_products' );
add_action( 'wp_ajax_nopriv_flavor_filter_products', 'flavor_filter_products' );

function flavor_filter_products() {
	check_ajax_referer( 'flavor_ajax_nonce', 'nonce' );

	$price_min   = isset( $_POST['price_min'] ) ? floatval( $_POST['price_min'] ) : 0;
	$price_max   = isset( $_POST['price_max'] ) ? floatval( $_POST['price_max'] ) : 999999;
	$brands      = ! empty( $_POST['brands'] ) ? array_map( 'sanitize_text_field', explode( ',', sanitize_text_field( wp_unslash( $_POST['brands'] ) ) ) ) : array();
	$rating      = isset( $_POST['rating'] ) ? absint( $_POST['rating'] ) : 0;
	$in_stock    = isset( $_POST['in_stock'] ) && $_POST['in_stock'] === '1';
	$sort        = isset( $_POST['sort'] ) ? sanitize_text_field( wp_unslash( $_POST['sort'] ) ) : 'default';
	$page        = isset( $_POST['page'] ) ? max( 1, absint( $_POST['page'] ) ) : 1;
	$product_cat = isset( $_POST['product_cat'] ) ? sanitize_text_field( wp_unslash( $_POST['product_cat'] ) ) : '';
	$per_page    = get_theme_mod( 'flavor_products_per_page', 12 );

	$meta_query = array( 'relation' => 'AND' );
	$tax_query  = array( 'relation' => 'AND' );

	// Price
	$meta_query[] = array(
		'key'     => '_price',
		'value'   => array( $price_min, $price_max ),
		'type'    => 'NUMERIC',
		'compare' => 'BETWEEN',
	);

	// Stock
	if ( $in_stock ) {
		$meta_query[] = array(
			'key'   => '_stock_status',
			'value' => 'instock',
		);
	}

	// Brands
	if ( ! empty( $brands ) ) {
		$tax_query[] = array(
			'taxonomy' => 'pa_brand',
			'field'    => 'name',
			'terms'    => $brands,
		);
	}

	// Category
	if ( $product_cat ) {
		$tax_query[] = array(
			'taxonomy' => 'product_cat',
			'field'    => 'slug',
			'terms'    => $product_cat,
		);
	}

	// Sort
	$orderby  = 'date';
	$order    = 'DESC';
	$meta_key = '';

	switch ( $sort ) {
		case 'price_asc':
			$orderby  = 'meta_value_num';
			$order    = 'ASC';
			$meta_key = '_price';
			break;
		case 'price_desc':
			$orderby  = 'meta_value_num';
			$order    = 'DESC';
			$meta_key = '_price';
			break;
		case 'popularity':
			$orderby  = 'meta_value_num';
			$order    = 'DESC';
			$meta_key = 'total_sales';
			break;
		case 'rating':
			$orderby  = 'meta_value_num';
			$order    = 'DESC';
			$meta_key = '_wc_average_rating';
			break;
		case 'name_asc':
			$orderby = 'title';
			$order   = 'ASC';
			break;
	}

	$args = array(
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'posts_per_page' => $per_page,
		'paged'          => $page,
		'meta_query'     => $meta_query, // phpcs:ignore
		'tax_query'      => $tax_query,  // phpcs:ignore
		'orderby'        => $orderby,
		'order'          => $order,
	);

	if ( $meta_key ) {
		$args['meta_key'] = $meta_key; // phpcs:ignore
	}

	// Rating filter via post IDs
	if ( $rating > 0 ) {
		$rated_ids = flavor_get_products_by_min_rating( $rating );
		if ( empty( $rated_ids ) ) {
			wp_send_json_success( array( 'html' => '<p class="text-center text-gray-500 col-span-full py-8">' . esc_html__( 'No products found.', 'flavor' ) . '</p>', 'total' => 0, 'pagination' => '' ) );
			return;
		}
		$args['post__in'] = $rated_ids;
	}

	$query = new WP_Query( $args );

	ob_start();
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			get_template_part( 'template-parts/product/product-card' );
		}
	} else {
		echo '<p class="text-center text-gray-500 col-span-full py-8">' . esc_html__( 'No products found.', 'flavor' ) . '</p>';
	}
	$html = ob_get_clean();

	// Pagination
	$pagination = '';
	if ( $query->max_num_pages > 1 ) {
		ob_start();
		echo paginate_links( array(
			'total'   => $query->max_num_pages,
			'current' => $page,
			'format'  => '?paged=%#%',
			'type'    => 'list',
		) );
		$pagination = ob_get_clean();
	}

	wp_reset_postdata();

	wp_send_json_success( array(
		'html'       => $html,
		'total'      => $query->found_posts,
		'pagination' => $pagination,
	) );
}

/**
 * Quick filter tabs — bestseller, most-viewed, top-rated
 */
add_action( 'wp_ajax_flavor_quick_filter', 'flavor_quick_filter' );
add_action( 'wp_ajax_nopriv_flavor_quick_filter', 'flavor_quick_filter' );

function flavor_quick_filter() {
	check_ajax_referer( 'flavor_ajax_nonce', 'nonce' );

	$tab         = isset( $_POST['tab'] ) ? sanitize_text_field( wp_unslash( $_POST['tab'] ) ) : 'bestseller';
	$product_cat = isset( $_POST['product_cat'] ) ? sanitize_text_field( wp_unslash( $_POST['product_cat'] ) ) : '';
	$per_page    = get_theme_mod( 'flavor_products_per_page', 12 );

	$args = array(
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'posts_per_page' => $per_page,
	);

	if ( $product_cat ) {
		$args['tax_query'] = array( // phpcs:ignore
			array(
				'taxonomy' => 'product_cat',
				'field'    => 'slug',
				'terms'    => $product_cat,
			),
		);
	}

	switch ( $tab ) {
		case 'bestseller':
			$args['meta_key'] = 'total_sales'; // phpcs:ignore
			$args['orderby']  = 'meta_value_num';
			$args['order']    = 'DESC';
			break;
		case 'most-viewed':
			$args['meta_key'] = 'flavor_views_count'; // phpcs:ignore
			$args['orderby']  = 'meta_value_num';
			$args['order']    = 'DESC';
			break;
		case 'top-rated':
			$args['meta_key'] = '_wc_average_rating'; // phpcs:ignore
			$args['orderby']  = 'meta_value_num';
			$args['order']    = 'DESC';
			break;
	}

	$query = new WP_Query( $args );

	ob_start();
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			get_template_part( 'template-parts/product/product-card' );
		}
	} else {
		echo '<p class="text-center text-gray-500 col-span-full py-8">' . esc_html__( 'No products found.', 'flavor' ) . '</p>';
	}
	$html = ob_get_clean();
	wp_reset_postdata();

	wp_send_json_success( array( 'html' => $html ) );
}

/**
 * Helper: get product IDs with minimum average rating
 */
function flavor_get_products_by_min_rating( $min_rating ) {
	global $wpdb;
	$results = $wpdb->get_col( $wpdb->prepare(
		"SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_wc_average_rating' AND meta_value >= %f",
		(float) $min_rating
	) );
	return array_map( 'absint', $results );
}

/**
 * Build product archive query args for shop/category/search AJAX loads.
 *
 * @param array $request Request data.
 * @return array{query_args: array, page: int}
 */
function flavor_build_archive_products_query_args( $request ) {
	$page         = max( 1, absint( $request['page'] ?? 1 ) );
	$per_page     = max( 1, min( 24, absint( $request['per_page'] ?? 12 ) ) );
	$archive_type = sanitize_key( wp_unslash( $request['archive_type'] ?? 'shop' ) );
	$category_id  = absint( $request['category_id'] ?? 0 );
	$search_query = sanitize_text_field( wp_unslash( $request['search_query'] ?? '' ) );
	$quick_filter = sanitize_key( wp_unslash( $request['quick_filter'] ?? '' ) );
	$sort_by      = sanitize_key( wp_unslash( $request['sort_by'] ?? 'relevance' ) );
	$default_sort = sanitize_key( get_theme_mod( 'flavor_default_sort', 'menu_order' ) );
	$price_min    = isset( $request['price_min'] ) && '' !== $request['price_min'] ? (float) wp_unslash( $request['price_min'] ) : '';
	$price_max    = isset( $request['price_max'] ) && '' !== $request['price_max'] ? (float) wp_unslash( $request['price_max'] ) : '';
	$brands       = array();
	$categories   = array();
	$attributes   = array();
	$in_stock     = wc_string_to_bool( wp_unslash( $request['in_stock'] ?? false ) );
	$out_of_stock = wc_string_to_bool( wp_unslash( $request['out_of_stock'] ?? false ) );
	$on_sale      = wc_string_to_bool( wp_unslash( $request['on_sale'] ?? false ) );

	if ( isset( $request['brands'] ) ) {
		$brands = (array) $request['brands'];
	} elseif ( isset( $request['brands_csv'] ) ) {
		$brands = explode( ',', sanitize_text_field( wp_unslash( $request['brands_csv'] ) ) );
	}
	$brands = array_values( array_filter( array_map( 'sanitize_title', (array) $brands ) ) );

	if ( isset( $request['categories'] ) ) {
		$categories = (array) $request['categories'];
	} elseif ( isset( $request['categories_csv'] ) ) {
		$categories = explode( ',', sanitize_text_field( wp_unslash( $request['categories_csv'] ) ) );
	}
	$categories = array_values( array_filter( array_map( 'sanitize_title', (array) $categories ) ) );

	if ( isset( $request['attributes'] ) ) {
		$decoded_attributes = json_decode( wp_unslash( $request['attributes'] ), true );
		if ( is_array( $decoded_attributes ) ) {
			$attributes = $decoded_attributes;
		}
	}

	$tax_query  = array( 'relation' => 'AND' );
	$meta_query = array( 'relation' => 'AND' );

	if ( 'category' === $archive_type && $category_id && empty( $categories ) ) {
		$tax_query[] = array(
			'taxonomy' => 'product_cat',
			'field'    => 'term_id',
			'terms'    => $category_id,
		);
	}

	if ( ! empty( $categories ) ) {
		$tax_query[] = array(
			'taxonomy' => 'product_cat',
			'field'    => 'slug',
			'terms'    => $categories,
		);
	}

	if ( ! empty( $brands ) ) {
		$tax_query[] = array(
			'taxonomy' => 'pa_brand',
			'field'    => 'slug',
			'terms'    => $brands,
		);
	}

	foreach ( $attributes as $taxonomy => $terms ) {
		$taxonomy = sanitize_key( $taxonomy );
		$terms    = array_values( array_filter( array_map( 'sanitize_title', (array) $terms ) ) );

		if ( ! taxonomy_exists( $taxonomy ) || empty( $terms ) ) {
			continue;
		}

		$tax_query[] = array(
			'taxonomy' => $taxonomy,
			'field'    => 'slug',
			'terms'    => $terms,
		);
	}

	if ( '' !== $price_min || '' !== $price_max ) {
		$meta_query[] = array(
			'key'     => '_price',
			'value'   => array(
				'' !== $price_min ? $price_min : 0,
				'' !== $price_max ? $price_max : 999999999,
			),
			'type'    => 'NUMERIC',
			'compare' => 'BETWEEN',
		);
	}

	if ( $in_stock && ! $out_of_stock ) {
		$meta_query[] = array(
			'key'   => '_stock_status',
			'value' => 'instock',
		);
	} elseif ( $out_of_stock && ! $in_stock ) {
		$meta_query[] = array(
			'key'   => '_stock_status',
			'value' => 'outofstock',
		);
	}

	$query_args = array(
		'post_type'           => 'product',
		'post_status'         => 'publish',
		'posts_per_page'      => $per_page,
		'paged'               => $page,
		'ignore_sticky_posts' => true,
	);

	if ( count( $tax_query ) > 1 ) {
		$query_args['tax_query'] = $tax_query; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
	}

	if ( count( $meta_query ) > 1 ) {
		$query_args['meta_query'] = $meta_query; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
	}

	if ( 'search' === $archive_type && '' !== $search_query ) {
		$query_args['s'] = $search_query;
	}

	if ( $on_sale || 'discount' === $sort_by ) {
		$on_sale_ids = wc_get_product_ids_on_sale();
		$query_args['post__in'] = ! empty( $on_sale_ids ) ? array_map( 'absint', $on_sale_ids ) : array( 0 );
	}

	switch ( $quick_filter ) {
		case 'bestsellers':
			$query_args['meta_key'] = 'total_sales'; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
			$query_args['orderby']  = 'meta_value_num';
			$query_args['order']    = 'DESC';
			break;
		case 'most_viewed':
			$query_args['meta_key'] = 'flavor_views_count'; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
			$query_args['orderby']  = 'meta_value_num';
			$query_args['order']    = 'DESC';
			break;
		case 'top_rated':
			$query_args['meta_key'] = '_wc_average_rating'; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
			$query_args['orderby']  = 'meta_value_num';
			$query_args['order']    = 'DESC';
			break;
		default:
			switch ( $sort_by ) {
				case 'price_asc':
					$query_args['meta_key'] = '_price'; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
					$query_args['orderby']  = 'meta_value_num';
					$query_args['order']    = 'ASC';
					break;
				case 'price_desc':
					$query_args['meta_key'] = '_price'; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
					$query_args['orderby']  = 'meta_value_num';
					$query_args['order']    = 'DESC';
					break;
				case 'newest':
					$query_args['orderby'] = array(
						'date' => 'DESC',
						'ID'   => 'DESC',
					);
					$query_args['order']   = 'DESC';
					break;
				case 'discount':
					$query_args['orderby'] = array(
						'date' => 'DESC',
						'ID'   => 'DESC',
					);
					$query_args['order']   = 'DESC';
					break;
				case 'relevance':
				default:
					if ( 'search' === $archive_type && '' !== $search_query ) {
						$query_args['orderby'] = 'relevance';
						break;
					}

					switch ( $default_sort ) {
						case 'date':
							$query_args['orderby'] = array(
								'date' => 'DESC',
								'ID'   => 'DESC',
							);
							$query_args['order']   = 'DESC';
							break;
						case 'popularity':
							$query_args['meta_key'] = 'total_sales'; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
							$query_args['orderby']  = 'meta_value_num';
							$query_args['order']    = 'DESC';
							break;
						case 'rating':
							$query_args['meta_key'] = '_wc_average_rating'; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
							$query_args['orderby']  = 'meta_value_num';
							$query_args['order']    = 'DESC';
							break;
						case 'price':
							$query_args['meta_key'] = '_price'; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
							$query_args['orderby']  = 'meta_value_num';
							$query_args['order']    = 'ASC';
							break;
						case 'price-desc':
							$query_args['meta_key'] = '_price'; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
							$query_args['orderby']  = 'meta_value_num';
							$query_args['order']    = 'DESC';
							break;
						case 'menu_order':
						default:
							$query_args['orderby'] = array(
								'menu_order' => 'ASC',
								'title'      => 'ASC',
							);
							break;
					}
					break;
			}
			break;
	}

	return array(
		'query_args' => $query_args,
		'page'       => $page,
	);
}

/**
 * Load archive products for shop/category/search pages.
 */
function flavor_load_archive_products_handler() {
	check_ajax_referer( 'flavor_ajax_nonce', 'nonce' );

	$query_data = flavor_build_archive_products_query_args( $_POST );
	$query      = new WP_Query( $query_data['query_args'] );
	$page       = (int) $query_data['page'];

	ob_start();
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$GLOBALS['product'] = wc_get_product( get_the_ID() );
			wc_get_template_part( 'content', 'product' );
		}
	} else {
		echo '<div class="col-span-full text-center py-12 text-gray-600">';
		esc_html_e( 'No products found.', 'flavor' );
		echo '</div>';
	}
	$html = ob_get_clean();

	$has_more = $query->max_num_pages > $page;

	wp_reset_postdata();

	wp_send_json_success(
		array(
			'html'         => $html,
			'total'        => (int) $query->found_posts,
			'has_more'     => $has_more,
			'current_page' => $page,
			'max_pages'    => (int) $query->max_num_pages,
		)
	);
}
add_action( 'wp_ajax_flavor_load_archive_products', 'flavor_load_archive_products_handler' );
add_action( 'wp_ajax_nopriv_flavor_load_archive_products', 'flavor_load_archive_products_handler' );

/**
 * Add to cart with optional warranty (AJAX)
 */
add_action( 'wp_ajax_flavor_add_to_cart', 'flavor_add_to_cart_handler' );
add_action( 'wp_ajax_nopriv_flavor_add_to_cart', 'flavor_add_to_cart_handler' );

function flavor_add_to_cart_handler() {
	check_ajax_referer( 'flavor_ajax_nonce', 'nonce' );

	$product_id = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;
	$quantity   = isset( $_POST['quantity'] ) ? max( 1, absint( $_POST['quantity'] ) ) : 1;
	$warranty   = isset( $_POST['warranty'] ) && $_POST['warranty'] === '1';

	if ( ! $product_id ) {
		wp_send_json_error( array( 'message' => __( 'Invalid product.', 'flavor' ) ) );
		return;
	}

	$cart_item_data = array();
	if ( $warranty ) {
		$warranty_price = (float) get_post_meta( $product_id, '_flavor_warranty_price', true );
		if ( $warranty_price > 0 ) {
			$cart_item_data['flavor_warranty']       = true;
			$cart_item_data['flavor_warranty_price'] = $warranty_price;
		}
	}

	$cart_item_key = WC()->cart->add_to_cart( $product_id, $quantity, 0, array(), $cart_item_data );

	if ( $cart_item_key ) {
		ob_start();
		wc_print_notices();
		$notices = ob_get_clean();

		// Get updated fragments
		ob_start();
		woocommerce_mini_cart();
		$mini_cart = ob_get_clean();

		wp_send_json_success( array(
			'cart_hash'  => WC()->cart->get_cart_hash(),
			'cart_count' => WC()->cart->get_cart_contents_count(),
			'mini_cart'  => flavor_mini_cart_response(),
			'notices'    => $notices,
			'fragments'  => apply_filters( 'woocommerce_add_to_cart_fragments', array(
				'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>',
			) ),
		) );
	} else {
		wp_send_json_error( array( 'message' => __( 'Could not add to cart.', 'flavor' ) ) );
	}
}

/**
 * Handle buy-now redirect to checkout
 */
add_action( 'woocommerce_add_to_cart_redirect', 'flavor_buy_now_redirect' );

function flavor_buy_now_redirect( $url ) {
	if ( isset( $_POST['flavor_redirect_checkout'] ) && $_POST['flavor_redirect_checkout'] === '1' ) {
		return wc_get_checkout_url();
	}
	return $url;
}
function flavor_load_products_handler() {
	check_ajax_referer( 'flavor_ajax_nonce', 'nonce' );

	$context  = sanitize_text_field( wp_unslash( $_POST['context'] ?? '' ) );
	$category = absint( $_POST['category'] ?? 0 );
	$per_page = absint( $_POST['per_page'] ?? 10 );
	$per_page = min( $per_page, 20 );
	$exclude_ids = flavor_normalize_product_ids( wp_unslash( $_POST['exclude_ids'] ?? array() ) );

	$args = array(
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'posts_per_page' => $per_page,
		'orderby'        => 'date',
		'order'          => 'DESC',
	);

	if ( ! empty( $exclude_ids ) ) {
		$args['post__not_in'] = $exclude_ids;
	}

	// Special offers: randomly pick up to 6 products manually flagged in admin.
	if ( 'special_offers' === $context ) {
		$args['posts_per_page'] = max( 1, min( $per_page, 6 ) );
		$args['meta_query']     = array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
			array(
				'key'   => '_flavor_show_in_special_offers',
				'value' => 'yes',
			),
		);
		$args['orderby']        = 'rand';
	}

	if ( 'tabbed' === $context ) {
		$args['meta_query'] = array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
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
		);
		$args['orderby']    = array(
			'date' => 'DESC',
			'ID'   => 'DESC',
		);
	}

	// Category filter
	if ( $category > 0 ) {
		$args['tax_query'] = array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
			array(
				'taxonomy' => 'product_cat',
				'field'    => 'term_id',
				'terms'    => $category,
			),
		);
	}

	$query = new WP_Query( $args );

	// For special offers, return structured data (used by Alpine.js)
	if ( 'special_offers' === $context ) {
		$products = array();
		while ( $query->have_posts() ) {
			$query->the_post();
			$product_data = flavor_prepare_special_offer_product_data( wc_get_product( get_the_ID() ) );

			if ( $product_data ) {
				$products[] = $product_data;
			}
		}
		wp_reset_postdata();
		wp_send_json_success( array( 'products' => $products ) );
	}

	// For tabbed products, return HTML cards
	ob_start();
	while ( $query->have_posts() ) {
		$query->the_post();
		$GLOBALS['product'] = wc_get_product( get_the_ID() );
		get_template_part( 'template-parts/product/product-card' );
	}
	$html = ob_get_clean();
	wp_reset_postdata();

	wp_send_json_success( array( 'html' => $html ) );
}
add_action( 'wp_ajax_flavor_load_products', 'flavor_load_products_handler' );
add_action( 'wp_ajax_nopriv_flavor_load_products', 'flavor_load_products_handler' );

/**
 * Load more products — infinite scroll
 */
function flavor_load_more_products_handler() {
	check_ajax_referer( 'flavor_ajax_nonce', 'nonce' );

	$per_page = absint( $_POST['per_page'] ?? 10 );
	$per_page = min( $per_page, 20 );
	$exclude_ids = flavor_normalize_product_ids( wp_unslash( $_POST['exclude_ids'] ?? array() ) );

	$args = array(
		'post_type'           => 'product',
		'post_status'         => 'publish',
		'posts_per_page'      => $per_page + 1,
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
		'orderby'             => array(
			'date' => 'DESC',
			'ID'   => 'DESC',
		),
	);

	if ( ! empty( $exclude_ids ) ) {
		$args['post__not_in'] = $exclude_ids;
	}

	$query = new WP_Query( $args );

	ob_start();
	$rendered = 0;
	while ( $query->have_posts() ) {
		$query->the_post();

		if ( $rendered >= $per_page ) {
			break;
		}

		$GLOBALS['product'] = wc_get_product( get_the_ID() );
		get_template_part( 'template-parts/product/product-card' );
		++$rendered;
	}
	$html = ob_get_clean();
	$has_more = $query->post_count > $per_page;
	wp_reset_postdata();

	wp_send_json_success( array(
		'html'         => $html,
		'has_more'     => $has_more,
	) );
}
add_action( 'wp_ajax_flavor_load_more_products', 'flavor_load_more_products_handler' );
add_action( 'wp_ajax_nopriv_flavor_load_more_products', 'flavor_load_more_products_handler' );

/**
 * Toggle wishlist (simple session-based implementation)
 */
function flavor_toggle_wishlist_handler() {
	check_ajax_referer( 'flavor_ajax_nonce', 'nonce' );

	$product_id = absint( $_POST['product_id'] ?? 0 );
	if ( ! $product_id ) {
		wp_send_json_error( array( 'message' => 'Invalid product' ) );
	}

	if ( ! is_user_logged_in() ) {
		// For guests, just acknowledge (frontend handles visual state)
		wp_send_json_success( array( 'status' => 'toggled' ) );
	}

	$user_id  = get_current_user_id();
	$wishlist = get_user_meta( $user_id, 'flavor_wishlist', true );
	if ( ! is_array( $wishlist ) ) {
		$wishlist = array();
	}

	$key = array_search( $product_id, $wishlist, true );
	if ( false !== $key ) {
		unset( $wishlist[ $key ] );
		$status = 'removed';
	} else {
		$wishlist[] = $product_id;
		$status     = 'added';
	}

	update_user_meta( $user_id, 'flavor_wishlist', array_values( $wishlist ) );

	wp_send_json_success( array( 'status' => $status ) );
}
add_action( 'wp_ajax_flavor_toggle_wishlist', 'flavor_toggle_wishlist_handler' );
add_action( 'wp_ajax_nopriv_flavor_toggle_wishlist', 'flavor_toggle_wishlist_handler' );

// flavorAjax is merged into flavorData (see inc/enqueue.php).

/**
 * Get wishlist products HTML by IDs
 */
function flavor_get_wishlist_products_handler() {
	check_ajax_referer( 'flavor_ajax_nonce', 'nonce' );

	$ids = isset( $_POST['product_ids'] ) ? array_filter( array_map( 'absint', explode( ',', sanitize_text_field( wp_unslash( $_POST['product_ids'] ) ) ) ) ) : array();

	if ( empty( $ids ) ) {
		wp_send_json_success( array( 'html' => '' ) );
	}

	$args = array(
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'post__in'       => $ids,
		'posts_per_page' => count( $ids ),
		'orderby'        => 'post__in',
	);

	$query = new WP_Query( $args );

	ob_start();
	while ( $query->have_posts() ) {
		$query->the_post();
		$GLOBALS['product'] = wc_get_product( get_the_ID() );
		get_template_part( 'template-parts/product/product-card' );
	}
	$html = ob_get_clean();
	wp_reset_postdata();

	wp_send_json_success( array( 'html' => $html ) );
}
add_action( 'wp_ajax_flavor_get_wishlist_products', 'flavor_get_wishlist_products_handler' );
add_action( 'wp_ajax_nopriv_flavor_get_wishlist_products', 'flavor_get_wishlist_products_handler' );

/**
 * Live Search — returns matching products as JSON.
 */
function flavor_live_search_handler() {
	$query = isset( $_POST['query'] ) ? sanitize_text_field( wp_unslash( $_POST['query'] ) ) : '';

	if ( strlen( $query ) < 2 ) {
		wp_send_json_success( array() );
	}

	$products = new WP_Query( array(
		'post_type'      => 'product',
		'post_status'    => 'publish',
		's'              => $query,
		'posts_per_page' => 5,
	) );

	$results = array();
	if ( $products->have_posts() ) {
		while ( $products->have_posts() ) {
			$products->the_post();
			$product = wc_get_product( get_the_ID() );
			if ( ! $product ) {
				continue;
			}
			$results[] = array(
				'id'    => $product->get_id(),
				'name'  => $product->get_name(),
				'url'   => get_permalink( $product->get_id() ),
				'price' => $product->get_price_html(),
				'image' => wp_get_attachment_image_url( $product->get_image_id(), 'thumbnail' ) ?: wc_placeholder_img_src( 'thumbnail' ),
			);
		}
		wp_reset_postdata();
	}

	wp_send_json_success( $results );
}
add_action( 'wp_ajax_flavor_live_search', 'flavor_live_search_handler' );
add_action( 'wp_ajax_nopriv_flavor_live_search', 'flavor_live_search_handler' );

/**
 * Helper — render mini-cart empty state.
 *
 * @return string
 */
function flavor_get_mini_cart_empty_html() {
	ob_start();
	?>
	<div class="flex flex-col items-center justify-center h-full text-center">
		<svg class="w-16 h-16 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
			<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/>
		</svg>
		<p class="text-gray-500"><?php esc_html_e( 'Your cart is empty', 'flavor' ); ?></p>
	</div>
	<?php

	return ob_get_clean();
}

/**
 * Helper — render mini-cart line items.
 *
 * @return string
 */
function flavor_get_mini_cart_list_items_html() {
	if ( ! WC()->cart ) {
		return '';
	}

	ob_start();
	foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
		$_product = $cart_item['data'];

		if ( ! $_product || ! $_product->exists() || $cart_item['quantity'] <= 0 ) {
			continue;
		}
		?>
		<li class="flex gap-3 pb-4 border-b border-gray-100" data-cart-key="<?php echo esc_attr( $cart_item_key ); ?>">
			<div class="w-16 h-16 flex-shrink-0 rounded-lg overflow-hidden bg-gray-100">
				<?php echo $_product->get_image( array( 64, 64 ), array( 'class' => 'w-full h-full object-cover' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
			<div class="flex-1 min-w-0">
				<h4 class="text-sm font-medium text-gray-900 truncate">
					<a href="<?php echo esc_url( $_product->get_permalink() ); ?>" class="hover:text-[var(--color-primary,#E15726)]">
						<?php echo esc_html( $_product->get_name() ); ?>
					</a>
				</h4>
				<p class="text-sm text-gray-500 mt-0.5"><?php echo WC()->cart->get_product_price( $_product ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
				<div class="flex items-center justify-between mt-2">
					<div class="flex items-center border border-gray-200 rounded-md overflow-hidden">
						<button type="button" class="w-7 h-7 flex items-center justify-center text-gray-500 hover:bg-gray-50" onclick="flavorMiniCartQty('<?php echo esc_js( $cart_item_key ); ?>', <?php echo max( 0, $cart_item['quantity'] - 1 ); ?>)">
							<svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15"/></svg>
						</button>
						<span class="w-8 text-center text-xs font-medium"><?php echo absint( $cart_item['quantity'] ); ?></span>
						<button type="button" class="w-7 h-7 flex items-center justify-center text-gray-500 hover:bg-gray-50" onclick="flavorMiniCartQty('<?php echo esc_js( $cart_item_key ); ?>', <?php echo $cart_item['quantity'] + 1; ?>)">
							<svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
						</button>
					</div>
					<button type="button" class="text-gray-400 hover:text-red-500 transition-colors" onclick="flavorMiniCartRemove('<?php echo esc_js( $cart_item_key ); ?>')" aria-label="<?php esc_attr_e( 'Remove', 'flavor' ); ?>">
						<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
					</button>
				</div>
			</div>
		</li>
		<?php
	}

	return ob_get_clean();
}

/**
 * Helper — render full mini-cart items panel.
 *
 * @return string
 */
function flavor_get_mini_cart_items_html() {
	if ( ! WC()->cart || WC()->cart->is_empty() ) {
		return flavor_get_mini_cart_empty_html();
	}

	$list_items_html = trim( flavor_get_mini_cart_list_items_html() );

	if ( '' === $list_items_html ) {
		return flavor_get_mini_cart_empty_html();
	}

	return '<ul class="space-y-4">' . $list_items_html . '</ul>';
}

/**
 * Helper — render mini-cart footer content.
 *
 * @return string
 */
function flavor_get_mini_cart_footer_html() {
	if ( ! WC()->cart || WC()->cart->is_empty() ) {
		return '';
	}

	ob_start();
	?>
	<div class="flex justify-between text-sm">
		<span class="text-gray-600"><?php esc_html_e( 'Subtotal', 'flavor' ); ?></span>
		<span class="font-bold mini-cart-subtotal"><?php wc_cart_totals_subtotal_html(); ?></span>
	</div>
	<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="block w-full text-center border-2 border-gray-900 text-gray-900 font-semibold py-3 rounded-xl hover:bg-gray-900 hover:text-white transition-colors">
		<?php esc_html_e( 'View Cart', 'flavor' ); ?>
	</a>
	<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="block w-full text-center bg-[var(--color-primary,#E15726)] text-white font-semibold py-3 rounded-xl hover:opacity-90 transition-opacity">
		<?php esc_html_e( 'Checkout', 'flavor' ); ?>
	</a>
	<?php

	return ob_get_clean();
}

/**
 * Helper — get mini cart response data.
 */
function flavor_mini_cart_response() {
	if ( ! WC()->cart ) {
		return array(
			'html'       => flavor_get_mini_cart_empty_html(),
			'items_html' => flavor_get_mini_cart_empty_html(),
			'footer_html'=> '',
			'total'      => '',
			'count'      => 0,
		);
	}

	WC()->cart->calculate_totals();

	$items_html  = flavor_get_mini_cart_items_html();
	$footer_html = flavor_get_mini_cart_footer_html();

	return array(
		'html'       => $items_html,
		'items_html' => $items_html,
		'footer_html'=> $footer_html,
		'total'      => WC()->cart->get_cart_subtotal(),
		'count'      => (int) WC()->cart->get_cart_contents_count(),
	);
}

/**
 * Mini Cart — current cart contents.
 */
function flavor_get_mini_cart_handler() {
	check_ajax_referer( 'flavor_ajax_nonce', 'nonce' );

	wp_send_json_success( flavor_mini_cart_response() );
}
add_action( 'wp_ajax_flavor_get_mini_cart', 'flavor_get_mini_cart_handler' );
add_action( 'wp_ajax_nopriv_flavor_get_mini_cart', 'flavor_get_mini_cart_handler' );

function flavor_mini_cart_remove_handler() {
	check_ajax_referer( 'flavor_ajax_nonce', 'nonce' );

	$cart_key = isset( $_POST['cart_key'] ) ? sanitize_text_field( $_POST['cart_key'] ) : '';
	if ( $cart_key && WC()->cart ) {
		WC()->cart->remove_cart_item( $cart_key );
		wp_send_json_success( flavor_mini_cart_response() );
	}
	wp_send_json_error();
}
add_action( 'wp_ajax_flavor_mini_cart_remove', 'flavor_mini_cart_remove_handler' );
add_action( 'wp_ajax_nopriv_flavor_mini_cart_remove', 'flavor_mini_cart_remove_handler' );

/**
 * Mini Cart — Update item quantity.
 */
function flavor_mini_cart_qty_handler() {
	check_ajax_referer( 'flavor_ajax_nonce', 'nonce' );

	$cart_key = isset( $_POST['cart_key'] ) ? sanitize_text_field( $_POST['cart_key'] ) : '';
	$quantity = isset( $_POST['quantity'] ) ? absint( $_POST['quantity'] ) : 1;
	if ( $cart_key && WC()->cart ) {
		WC()->cart->set_quantity( $cart_key, $quantity );
		wp_send_json_success( flavor_mini_cart_response() );
	}
	wp_send_json_error();
}
add_action( 'wp_ajax_flavor_mini_cart_qty', 'flavor_mini_cart_qty_handler' );
add_action( 'wp_ajax_nopriv_flavor_mini_cart_qty', 'flavor_mini_cart_qty_handler' );
