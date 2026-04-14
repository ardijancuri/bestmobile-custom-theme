<?php
/**
 * Customizer — Load all sections
 *
 * @package Flavor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Load customizer sections
$customizer_files = array(
	'colors',
	'header',
	'footer',
	'homepage',
	'shop',
	'product',
	'cart',
);

foreach ( $customizer_files as $file ) {
	$path = FLAVOR_DIR . '/inc/customizer/' . $file . '.php';
	if ( file_exists( $path ) ) {
		require_once $path;
	}
}
