<?php
/**
 * Breadcrumbs partial
 *
 * @package Flavor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( function_exists( 'woocommerce_breadcrumb' ) ) {
	woocommerce_breadcrumb( array(
		'wrap_before' => '<nav aria-label="' . esc_attr__( 'Breadcrumb', 'flavor' ) . '" class="w-full py-3 text-xs text-gray-600"><ol class="flex flex-wrap items-center gap-1">',
		'wrap_after'  => '</ol></nav>',
		'before'      => '<li class="flex items-center gap-1">',
		'after'       => '</li>',
		'delimiter'   => '<svg class="w-3 h-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>',
	) );
}
