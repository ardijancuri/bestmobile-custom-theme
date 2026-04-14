<?php
/**
 * Theme default values.
 *
 * @package Flavor
 */

defined( 'ABSPATH' ) || exit;

/**
 * Return code-level default theme mods for new installs.
 *
 * These defaults are safe to export with the theme because they avoid
 * site-specific media IDs and URLs.
 *
 * @return array<string, mixed>
 */
function flavor_get_theme_default_mods() {
	return array(
		'flavor_color_primary'             => '#2b6cb0',
		'flavor_color_primary_light'       => '#f7f7f7',
		'flavor_color_accent'              => '#E34850',
		'flavor_color_surface_dark'        => '#0c3468',
		'flavor_logo_scale_mobile'         => 100,
		'flavor_logo_scale_desktop'        => 130,
		'flavor_footer_logo_scale_mobile'  => 140,
		'flavor_footer_logo_scale_desktop' => 70,
		'flavor_footer_brand_text'         => 'Elevate your mobile experience with products and top notch services of our mobile store.',
	);
}

/**
 * Get a single default theme mod value.
 *
 * @param string $setting  Theme mod name.
 * @param mixed  $fallback Fallback when the setting has no theme default.
 * @return mixed
 */
function flavor_get_theme_default( $setting, $fallback = '' ) {
	$defaults = flavor_get_theme_default_mods();

	return array_key_exists( $setting, $defaults ) ? $defaults[ $setting ] : $fallback;
}
