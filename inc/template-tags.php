<?php
/**
 * Template Tags - Helper functions
 *
 * @package Flavor
 */

defined( 'ABSPATH' ) || exit;

/**
 * Display store prices without decimals.
 *
 * @return int
 */
function flavor_price_decimals() {
    return 0;
}
add_filter( 'wc_get_price_decimals', 'flavor_price_decimals' );
add_filter( 'woocommerce_price_num_decimals', 'flavor_price_decimals' );

/**
 * Remove decimal digits from already-rendered price HTML.
 *
 * This keeps theme output consistent even when a price string was generated
 * before WooCommerce applied the decimal setting we want.
 *
 * @param string $price_html Rendered WooCommerce price HTML.
 * @return string
 */
function flavor_strip_price_html_decimals( $price_html ) {
    if ( ! is_string( $price_html ) || '' === trim( $price_html ) ) {
        return $price_html;
    }

    if ( absint( wc_get_price_decimals() ) > 0 ) {
        return $price_html;
    }

    $decimal_separator = wc_get_price_decimal_separator();
    if ( '' === $decimal_separator ) {
        return $price_html;
    }

    $pattern = '/' . preg_quote( $decimal_separator, '/' ) . '\d+(?=(?:&nbsp;|&#160;|\s|<|$))/u';

    return preg_replace( $pattern, '', $price_html );
}

/**
 * Strip decimals from wc_price() output.
 *
 * @param string $price_html Rendered price HTML.
 * @return string
 */
function flavor_filter_wc_price_html( $price_html ) {
    return flavor_strip_price_html_decimals( $price_html );
}
add_filter( 'wc_price', 'flavor_filter_wc_price_html', 20 );

/**
 * Strip decimals from product price HTML.
 *
 * @param string     $price_html Rendered price HTML.
 * @param WC_Product $product    Product instance.
 * @return string
 */
function flavor_filter_product_price_html( $price_html, $product ) {
    unset( $product );

    return flavor_strip_price_html_decimals( $price_html );
}
add_filter( 'woocommerce_get_price_html', 'flavor_filter_product_price_html', 20, 2 );

/**
 * Display breadcrumbs via template part.
 */
function flavor_breadcrumbs() {
    get_template_part( 'template-parts/global/breadcrumbs' );
}

/**
 * Display the posted-on date.
 */
function flavor_posted_on() {
    $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

    if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
        $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated hidden" datetime="%3$s">%4$s</time>';
    }

    $time_string = sprintf(
        $time_string,
        esc_attr( get_the_date( DATE_W3C ) ),
        esc_html( get_the_date() ),
        esc_attr( get_the_modified_date( DATE_W3C ) ),
        esc_html( get_the_modified_date() )
    );

    printf(
        '<span class="posted-on text-sm text-gray-500">%s</span>',
        '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
    );
}

/**
 * Display the post author.
 */
function flavor_posted_by() {
    printf(
        '<span class="byline text-sm text-gray-500">%s <a class="text-primary hover:underline" href="%s">%s</a></span>',
        esc_html__( 'by', 'flavor' ),
        esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
        esc_html( get_the_author() )
    );
}

/**
 * Get WooCommerce cart item count.
 *
 * @return int
 */
function flavor_cart_count() {
    if ( function_exists( 'WC' ) && WC()->cart ) {
        return WC()->cart->get_cart_contents_count();
    }
    return 0;
}

/**
 * Get user wishlist count from user meta.
 *
 * @param int|null $user_id User ID. Defaults to current user.
 * @return int
 */
function flavor_wishlist_count( $user_id = null ) {
    if ( ! $user_id ) {
        $user_id = get_current_user_id();
    }

    if ( ! $user_id ) {
        return 0;
    }

    $wishlist = get_user_meta( $user_id, 'flavor_wishlist', true );

    if ( is_array( $wishlist ) ) {
        return count( $wishlist );
    }

    return 0;
}

/**
 * Wrap decimal digits in a smaller inline span for selected price displays.
 *
 * @param string $price_html Rendered WooCommerce price HTML.
 * @return string
 */
function flavor_price_html_with_small_decimals( $price_html ) {
    if ( ! is_string( $price_html ) || '' === trim( $price_html ) ) {
        return $price_html;
    }

    $decimals = absint( wc_get_price_decimals() );
    if ( 0 === $decimals ) {
        return flavor_strip_price_html_decimals( $price_html );
    }

    $decimal_separator = wc_get_price_decimal_separator();
    $pattern           = '/(\d+)' . preg_quote( $decimal_separator, '/' ) . '(\d{' . $decimals . '})(?!\d)/u';

    return preg_replace_callback(
        $pattern,
        static function ( $matches ) use ( $decimal_separator ) {
            return $matches[1] . '<span class="price-decimals">' . $decimal_separator . $matches[2] . '</span>';
        },
        $price_html
    );
}

/**
 * Normalize product IDs from arrays or comma-separated strings.
 *
 * @param array|string $ids Product IDs.
 * @return int[]
 */
function flavor_normalize_product_ids( $ids ) {
    if ( is_string( $ids ) ) {
        $ids = explode( ',', $ids );
    }

    if ( ! is_array( $ids ) ) {
        return array();
    }

    return array_values( array_unique( array_filter( array_map( 'absint', $ids ) ) ) );
}

/**
 * Reset the in-request homepage product registry.
 */
function flavor_homepage_reset_used_product_ids() {
    $GLOBALS['flavor_homepage_used_product_ids'] = array();
}

/**
 * Get all homepage product IDs already used by earlier sections in this request.
 *
 * @return int[]
 */
function flavor_homepage_get_used_product_ids() {
    if ( ! isset( $GLOBALS['flavor_homepage_used_product_ids'] ) || ! is_array( $GLOBALS['flavor_homepage_used_product_ids'] ) ) {
        $GLOBALS['flavor_homepage_used_product_ids'] = array();
    }

    return flavor_normalize_product_ids( $GLOBALS['flavor_homepage_used_product_ids'] );
}

/**
 * Register product IDs as already used on the homepage for this request.
 *
 * @param array|string $ids Product IDs.
 * @return int[]
 */
function flavor_homepage_add_used_product_ids( $ids ) {
    $current = flavor_homepage_get_used_product_ids();
    $next    = array_merge( $current, flavor_normalize_product_ids( $ids ) );

    $GLOBALS['flavor_homepage_used_product_ids'] = flavor_normalize_product_ids( $next );

    return $GLOBALS['flavor_homepage_used_product_ids'];
}

/**
 * Build the special-offers payload shared by the homepage template and AJAX.
 *
 * @param WC_Product|false $product Product object.
 * @return array|null
 */
function flavor_prepare_special_offer_product_data( $product ) {
    if ( ! $product instanceof WC_Product ) {
        return null;
    }

    if ( $product->is_type( 'variable' ) ) {
        $regular = (float) $product->get_variation_regular_price( 'min', false );
        $sale    = $product->is_on_sale() ? (float) $product->get_variation_sale_price( 'min', false ) : 0;
        $price   = (float) $product->get_variation_price( 'min', false );
    } else {
        $regular = (float) $product->get_regular_price();
        $sale    = (float) $product->get_sale_price();
        $price   = (float) $product->get_price();
    }

    $discount = ( $regular > 0 && $sale ) ? round( ( ( $regular - $sale ) / $regular ) * 100 ) : 0;

    return array(
        'id'                  => $product->get_id(),
        'name'                => $product->get_name(),
        'url'                 => $product->get_permalink(),
        'image'               => wp_get_attachment_image_url( $product->get_image_id(), 'flavor-product-card' ) ?: wc_placeholder_img_src(),
        'product_type'        => $product->get_type(),
        'in_stock'            => $product->is_in_stock(),
        'purchasable'         => $product->is_purchasable(),
        'can_add_direct'      => $product->is_purchasable() && $product->is_in_stock() && $product->is_type( 'simple' ),
        'has_sale'            => $regular > 0 && $price < $regular,
        'regular_amount'      => round( $regular ),
        'price_amount'        => round( $price ),
        'regular_price'       => number_format_i18n( round( $regular ), 0 ),
        'sale_price'          => number_format_i18n( round( $price ), 0 ),
        'regular_price_label' => wp_kses_post( wc_price( round( $regular ) ) ),
        'price_label'         => wp_kses_post( wc_price( round( $price ) ) ),
        'price_html'          => wp_kses_post( $product->get_price_html() ),
        'discount'            => $discount,
    );
}
