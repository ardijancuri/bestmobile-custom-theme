<?php
/**
 * Flavor Theme Functions
 *
 * @package Flavor
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'FLAVOR_VERSION', '1.0.0' );
define( 'FLAVOR_DIR', get_template_directory() );
define( 'FLAVOR_URI', get_template_directory_uri() );

// Theme setup
require_once FLAVOR_DIR . '/inc/theme-setup.php';

// Enqueue scripts and styles
require_once FLAVOR_DIR . '/inc/enqueue.php';

// Theme defaults
require_once FLAVOR_DIR . '/inc/theme-defaults.php';

// Customizer
require_once FLAVOR_DIR . '/inc/customizer/customizer.php';

// Template tags
require_once FLAVOR_DIR . '/inc/template-tags.php';

// Widgets
require_once FLAVOR_DIR . '/inc/widgets.php';

// WooCommerce integration
if ( class_exists( 'WooCommerce' ) ) {
	require_once FLAVOR_DIR . '/inc/woocommerce.php';
}

// AJAX handlers
require_once FLAVOR_DIR . '/inc/ajax-handlers.php';
