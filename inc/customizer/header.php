<?php
/**
 * Customizer: Header settings
 *
 * @package Flavor
 */

defined( 'ABSPATH' ) || exit;

/**
 * Sanitize header logo scale values.
 *
 * @param mixed $value Scale percentage.
 * @return int
 */
function flavor_sanitize_logo_scale( $value ) {
	$value = absint( $value );

	if ( $value < 60 ) {
		return 60;
	}

	if ( $value > 160 ) {
		return 160;
	}

	return $value;
}

/**
 * Register header Customizer settings.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function flavor_customizer_header( $wp_customize ) {

    $wp_customize->add_setting( 'flavor_logo_scale_mobile', array(
        'default'           => flavor_get_theme_default( 'flavor_logo_scale_mobile', 100 ),
        'sanitize_callback' => 'flavor_sanitize_logo_scale',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'flavor_logo_scale_mobile', array(
        'label'       => esc_html__( 'Header Logo Size (Mobile %)', 'flavor' ),
        'description' => esc_html__( 'Scale the logo shown in the main header on mobile devices.', 'flavor' ),
        'section'     => 'title_tagline',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 60,
            'max'  => 160,
            'step' => 5,
        ),
    ) );

    $wp_customize->add_setting( 'flavor_logo_scale_desktop', array(
        'default'           => flavor_get_theme_default( 'flavor_logo_scale_desktop', 100 ),
        'sanitize_callback' => 'flavor_sanitize_logo_scale',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'flavor_logo_scale_desktop', array(
        'label'       => esc_html__( 'Header Logo Size (Desktop %)', 'flavor' ),
        'description' => esc_html__( 'Scale the logo shown in the main header on tablets and desktops.', 'flavor' ),
        'section'     => 'title_tagline',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 60,
            'max'  => 160,
            'step' => 5,
        ),
    ) );

    $wp_customize->add_setting( 'flavor_footer_logo_scale_mobile', array(
        'default'           => flavor_get_theme_default( 'flavor_footer_logo_scale_mobile', 100 ),
        'sanitize_callback' => 'flavor_sanitize_logo_scale',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'flavor_footer_logo_scale_mobile', array(
        'label'       => esc_html__( 'Footer Logo Size (Mobile %)', 'flavor' ),
        'description' => esc_html__( 'Scale the logo shown in the footer on mobile devices.', 'flavor' ),
        'section'     => 'title_tagline',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 60,
            'max'  => 160,
            'step' => 5,
        ),
    ) );

    $wp_customize->add_setting( 'flavor_footer_logo_scale_desktop', array(
        'default'           => flavor_get_theme_default( 'flavor_footer_logo_scale_desktop', 100 ),
        'sanitize_callback' => 'flavor_sanitize_logo_scale',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'flavor_footer_logo_scale_desktop', array(
        'label'       => esc_html__( 'Footer Logo Size (Desktop %)', 'flavor' ),
        'description' => esc_html__( 'Scale the logo shown in the footer on tablets and desktops.', 'flavor' ),
        'section'     => 'title_tagline',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 60,
            'max'  => 160,
            'step' => 5,
        ),
    ) );

    $wp_customize->add_section( 'flavor_header', array(
        'title'    => esc_html__( 'Header', 'flavor' ),
        'priority' => 30,
    ) );

    // Topbar on/off.
    $wp_customize->add_setting( 'flavor_topbar_enabled', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ) );
    $wp_customize->add_control( 'flavor_topbar_enabled', array(
        'label'   => esc_html__( 'Show Top Bar', 'flavor' ),
        'section' => 'flavor_header',
        'type'    => 'checkbox',
    ) );

    // Topbar text.
    $wp_customize->add_setting( 'flavor_topbar_text', array(
        'default'           => esc_html__( 'Free shipping on orders over €50', 'flavor' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'flavor_topbar_text', array(
        'label'   => esc_html__( 'Top Bar Text', 'flavor' ),
        'section' => 'flavor_header',
        'type'    => 'text',
    ) );

    // Topbar bg color.
    $wp_customize->add_setting( 'flavor_topbar_bg_color', array(
        'default'           => '#1A1A1A',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'flavor_topbar_bg_color', array(
        'label'   => esc_html__( 'Top Bar Background Color', 'flavor' ),
        'section' => 'flavor_header',
    ) ) );

    // Topbar text color.
    $wp_customize->add_setting( 'flavor_topbar_text_color', array(
        'default'           => '#FFFFFF',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'flavor_topbar_text_color', array(
        'label'   => esc_html__( 'Top Bar Text Color', 'flavor' ),
        'section' => 'flavor_header',
    ) ) );

    // Sticky header.
    $wp_customize->add_setting( 'flavor_sticky_header', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ) );
    $wp_customize->add_control( 'flavor_sticky_header', array(
        'label'   => esc_html__( 'Sticky Header', 'flavor' ),
        'section' => 'flavor_header',
        'type'    => 'checkbox',
    ) );

    // Search placeholder.
    $wp_customize->add_setting( 'flavor_search_placeholder', array(
        'default'           => esc_html__( 'Search products...', 'flavor' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'flavor_search_placeholder', array(
        'label'   => esc_html__( 'Search Placeholder Text', 'flavor' ),
        'section' => 'flavor_header',
        'type'    => 'text',
    ) );

    // Bottom nav on/off.
    $wp_customize->add_setting( 'flavor_bottom_nav', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ) );
    $wp_customize->add_control( 'flavor_bottom_nav', array(
        'label'   => esc_html__( 'Show Mobile Bottom Navigation', 'flavor' ),
        'section' => 'flavor_header',
        'type'    => 'checkbox',
    ) );
}
add_action( 'customize_register', 'flavor_customizer_header' );
