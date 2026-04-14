<?php
/**
 * Customizer: Theme colors
 *
 * @package Flavor
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register theme color controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function flavor_customizer_colors( $wp_customize ) {
	$wp_customize->add_section(
		'flavor_theme_colors',
		array(
			'title'    => esc_html__( 'Theme Colors', 'flavor' ),
			'priority' => 25,
		)
	);

	$color_settings = array(
		'flavor_color_primary'       => array(
			'label'   => esc_html__( 'Primary Color', 'flavor' ),
			'default' => flavor_get_theme_default( 'flavor_color_primary', '#E15726' ),
		),
		'flavor_color_primary_light' => array(
			'label'   => esc_html__( 'Primary Light Color', 'flavor' ),
			'default' => flavor_get_theme_default( 'flavor_color_primary_light', '#FCEEE9' ),
		),
		'flavor_color_accent'        => array(
			'label'   => esc_html__( 'Accent Color', 'flavor' ),
			'default' => flavor_get_theme_default( 'flavor_color_accent', '#E34850' ),
		),
		'flavor_color_surface_dark'  => array(
			'label'   => esc_html__( 'Dark Surface Color', 'flavor' ),
			'default' => flavor_get_theme_default( 'flavor_color_surface_dark', '#1A1A1A' ),
		),
	);

	foreach ( $color_settings as $setting_id => $setting ) {
		$wp_customize->add_setting(
			$setting_id,
			array(
				'default'           => $setting['default'],
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => 'refresh',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$setting_id,
				array(
					'label'   => $setting['label'],
					'section' => 'flavor_theme_colors',
				)
			)
		);
	}
}
add_action( 'customize_register', 'flavor_customizer_colors' );

/**
 * Return a sanitized theme color or its default fallback.
 *
 * @param string $setting Theme mod name.
 * @param string $default Fallback hex color.
 * @return string
 */
function flavor_get_theme_color( $setting, $default ) {
	$default = flavor_get_theme_default( $setting, $default );
	$value = sanitize_hex_color( get_theme_mod( $setting, $default ) );

	return $value ? $value : $default;
}

/**
 * Convert a hex color to its RGB channels.
 *
 * @param string $hex Hex color value.
 * @return array{r:int,g:int,b:int}
 */
function flavor_hex_to_rgb( $hex ) {
	$hex = ltrim( (string) $hex, '#' );

	if ( 3 === strlen( $hex ) ) {
		$hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
	}

	return array(
		'r' => hexdec( substr( $hex, 0, 2 ) ),
		'g' => hexdec( substr( $hex, 2, 2 ) ),
		'b' => hexdec( substr( $hex, 4, 2 ) ),
	);
}

/**
 * Convert a hex color to rgba().
 *
 * @param string $hex   Hex color value.
 * @param float  $alpha Alpha channel between 0 and 1.
 * @return string
 */
function flavor_hex_to_rgba( $hex, $alpha ) {
	$rgb   = flavor_hex_to_rgb( $hex );
	$alpha = min( 1, max( 0, (float) $alpha ) );

	return sprintf( 'rgba(%d, %d, %d, %.3f)', $rgb['r'], $rgb['g'], $rgb['b'], $alpha );
}

/**
 * Lighten or darken a hex color.
 *
 * @param string $hex   Hex color value.
 * @param int    $steps Steps between -255 and 255.
 * @return string
 */
function flavor_adjust_hex_color( $hex, $steps ) {
	$rgb   = flavor_hex_to_rgb( $hex );
	$steps = max( -255, min( 255, (int) $steps ) );

	foreach ( $rgb as $channel => $value ) {
		$rgb[ $channel ] = max( 0, min( 255, $value + $steps ) );
	}

	return sprintf( '#%02X%02X%02X', $rgb['r'], $rgb['g'], $rgb['b'] );
}

/**
 * Output dynamic theme colors as inline CSS.
 */
function flavor_enqueue_theme_color_styles() {
	$primary       = flavor_get_theme_color( 'flavor_color_primary', '#E15726' );
	$primary_light = flavor_get_theme_color( 'flavor_color_primary_light', '#FCEEE9' );
	$accent        = flavor_get_theme_color( 'flavor_color_accent', '#E34850' );
	$surface_dark  = flavor_get_theme_color( 'flavor_color_surface_dark', '#1A1A1A' );

	$primary_hover  = flavor_adjust_hex_color( $primary, -18 );
	$primary_ring   = flavor_hex_to_rgba( $primary, 0.18 );
	$primary_shadow = flavor_hex_to_rgba( $primary, 0.25 );
	$accent_soft    = flavor_hex_to_rgba( $accent, 0.14 );
	$accent_strong  = flavor_adjust_hex_color( $accent, -48 );

	$css = "
:root {
	--color-primary: {$primary};
	--color-primary-light: {$primary_light};
	--color-primary-hover: {$primary_hover};
	--color-primary-ring: {$primary_ring};
	--color-accent: {$accent};
	--color-accent-soft: {$accent_soft};
	--color-accent-strong: {$accent_strong};
	--color-surface-dark: {$surface_dark};
}

.bg-black-dark {
	background-color: var(--color-surface-dark) !important;
}

.bg-orange-50 {
	background-color: var(--color-primary-light) !important;
}

.hover\\:bg-orange-600:hover {
	background-color: var(--color-primary-hover) !important;
}

.text-red,
.text-red-500,
.text-red-600 {
	color: var(--color-accent) !important;
}

.text-red-800 {
	color: var(--color-accent-strong) !important;
}

.bg-red,
.bg-red-600 {
	background-color: var(--color-accent) !important;
}

.bg-red-100 {
	background-color: var(--color-accent-soft) !important;
}

.border-red-500 {
	border-color: var(--color-accent) !important;
}

.hover\\:text-red:hover,
.hover\\:text-red-500:hover {
	color: var(--color-accent) !important;
}

.shadow-primary\\/25 {
	--tw-shadow-color: {$primary_shadow} !important;
}

.woocommerce form .form-row input.input-text:focus,
.woocommerce form .form-row textarea:focus,
.woocommerce form .form-row select:focus,
.woocommerce-form input:focus,
.woocommerce-form select:focus,
.woocommerce-form textarea:focus {
	box-shadow: 0 0 0 3px var(--color-primary-ring);
}
";

	wp_add_inline_style( 'flavor-style', $css );
}
add_action( 'wp_enqueue_scripts', 'flavor_enqueue_theme_color_styles', 20 );
