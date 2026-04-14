<?php
/**
 * Theme Setup
 *
 * @package Flavor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function flavor_setup() {
	// Make theme available for translation
	load_theme_textdomain( 'flavor', FLAVOR_DIR . '/languages' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails
	add_theme_support( 'post-thumbnails' );

	// Custom image sizes
	add_image_size( 'flavor-product-card', 300, 300, false );
	add_image_size( 'flavor-product-gallery', 600, 600, false );
	add_image_size( 'flavor-banner', 1360, 240, true );
	add_image_size( 'flavor-banner-mobile', 600, 200, true );
	add_image_size( 'flavor-category-card', 180, 180, false );
	add_image_size( 'flavor-brand-logo', 100, 40, false );

	// Register navigation menus
	register_nav_menus( array(
		'primary'     => esc_html__( 'Primary Menu', 'flavor' ),
		'mega-menu'   => esc_html__( 'Mega Menu', 'flavor' ),
		'quick-links' => esc_html__( 'Quick Links Bar', 'flavor' ),
		'mobile'      => esc_html__( 'Mobile Menu', 'flavor' ),
		'footer-1'    => esc_html__( 'Footer Column 1', 'flavor' ),
		'footer-2'    => esc_html__( 'Footer Column 2', 'flavor' ),
		'footer-3'    => esc_html__( 'Footer Column 3', 'flavor' ),
		'footer-4'    => esc_html__( 'Footer Column 4', 'flavor' ),
	) );

	// HTML5 support
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
	) );

	// WooCommerce support
	add_theme_support( 'woocommerce', array(
		'thumbnail_image_width' => 300,
		'single_image_width'    => 600,
		'product_grid'          => array(
			'default_rows'    => 4,
			'min_rows'        => 1,
			'default_columns' => 4,
			'min_columns'     => 2,
			'max_columns'     => 5,
		),
	) );

	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	// Custom logo
	add_theme_support( 'custom-logo', array(
		'height'      => 32,
		'width'       => 110,
		'flex-height' => true,
		'flex-width'  => true,
	) );
}
add_action( 'after_setup_theme', 'flavor_setup' );
