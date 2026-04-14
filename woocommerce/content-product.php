<?php
/**
 * WooCommerce product loop content override.
 * Delegates to product-card template part.
 *
 * @package Flavor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

get_template_part( 'template-parts/product/product-card' );
