<?php
/**
 * Customizer — Homepage sections
 *
 * @package Flavor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register homepage customizer settings
 */
function flavor_customizer_homepage( $wp_customize ) {

	// ─── Panel ───
	$wp_customize->add_panel( 'flavor_homepage', array(
		'title'    => esc_html__( 'Homepage', 'flavor' ),
		'priority' => 30,
	) );

	// ═══════════════════════════════════════════
	// Hero Slider
	// ═══════════════════════════════════════════
	$wp_customize->add_section( 'flavor_hero_slider', array(
		'title' => esc_html__( 'Hero Slider', 'flavor' ),
		'panel' => 'flavor_homepage',
	) );

	for ( $i = 1; $i <= 5; $i++ ) {
		$wp_customize->add_setting( "flavor_hero_slide_{$i}_image", array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, "flavor_hero_slide_{$i}_image", array(
			'label'   => sprintf( esc_html__( 'Slide %d — Desktop Image', 'flavor' ), $i ),
			'section' => 'flavor_hero_slider',
		) ) );

		$wp_customize->add_setting( "flavor_hero_slide_{$i}_image_mobile", array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, "flavor_hero_slide_{$i}_image_mobile", array(
			'label'   => sprintf( esc_html__( 'Slide %d — Mobile Image', 'flavor' ), $i ),
			'section' => 'flavor_hero_slider',
		) ) );

		$wp_customize->add_setting( "flavor_hero_slide_{$i}_link", array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( "flavor_hero_slide_{$i}_link", array(
			'label'   => sprintf( esc_html__( 'Slide %d — Link URL', 'flavor' ), $i ),
			'section' => 'flavor_hero_slider',
			'type'    => 'url',
		) );

		$wp_customize->add_setting( "flavor_hero_slide_{$i}_alt", array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( "flavor_hero_slide_{$i}_alt", array(
			'label'   => sprintf( esc_html__( 'Slide %d — Alt Text', 'flavor' ), $i ),
			'section' => 'flavor_hero_slider',
			'type'    => 'text',
		) );
	}

	// ═══════════════════════════════════════════
	// USP Bar
	// ═══════════════════════════════════════════
	$wp_customize->add_section( 'flavor_usp_bar', array(
		'title' => esc_html__( 'USP Bar', 'flavor' ),
		'panel' => 'flavor_homepage',
	) );

	$wp_customize->add_setting( 'flavor_usp_enabled', array(
		'default'           => true,
		'sanitize_callback' => 'flavor_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'flavor_usp_enabled', array(
		'label'   => esc_html__( 'Enable USP Bar', 'flavor' ),
		'section' => 'flavor_usp_bar',
		'type'    => 'checkbox',
	) );

	for ( $i = 0; $i < 4; $i++ ) {
		$n = $i + 1;
		$wp_customize->add_setting( "flavor_usp_{$i}_title", array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( "flavor_usp_{$i}_title", array(
			'label'   => sprintf( esc_html__( 'USP %d — Title', 'flavor' ), $n ),
			'section' => 'flavor_usp_bar',
			'type'    => 'text',
		) );

		$wp_customize->add_setting( "flavor_usp_{$i}_subtitle", array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( "flavor_usp_{$i}_subtitle", array(
			'label'   => sprintf( esc_html__( 'USP %d — Subtitle', 'flavor' ), $n ),
			'section' => 'flavor_usp_bar',
			'type'    => 'text',
		) );

		$wp_customize->add_setting( "flavor_usp_{$i}_icon", array(
			'default'           => '',
			'sanitize_callback' => 'flavor_sanitize_svg',
		) );
		$wp_customize->add_control( "flavor_usp_{$i}_icon", array(
			'label'       => sprintf( esc_html__( 'USP %d — Icon SVG', 'flavor' ), $n ),
			'section'     => 'flavor_usp_bar',
			'type'        => 'textarea',
			'description' => esc_html__( 'Paste inline SVG markup', 'flavor' ),
		) );
	}

	// ═══════════════════════════════════════════
	// Tabbed Products
	// ═══════════════════════════════════════════
	$wp_customize->add_section( 'flavor_tabbed_products', array(
		'title' => esc_html__( 'Tabbed Products', 'flavor' ),
		'panel' => 'flavor_homepage',
	) );

	$wp_customize->add_setting( 'flavor_tabbed_products_enabled', array(
		'default'           => true,
		'sanitize_callback' => 'flavor_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'flavor_tabbed_products_enabled', array(
		'label'   => esc_html__( 'Enable Tabbed Products', 'flavor' ),
		'section' => 'flavor_tabbed_products',
		'type'    => 'checkbox',
	) );

	$wp_customize->add_setting( 'flavor_tabbed_products_title', array(
		'default'           => esc_html__( 'Recommended for you', 'flavor' ),
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'flavor_tabbed_products_title', array(
		'label'   => esc_html__( 'Section Title', 'flavor' ),
		'section' => 'flavor_tabbed_products',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'flavor_tabbed_products_categories', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'flavor_tabbed_products_categories', array(
		'label'       => esc_html__( 'Category IDs (comma-separated)', 'flavor' ),
		'section'     => 'flavor_tabbed_products',
		'type'        => 'text',
		'description' => esc_html__( 'Enter product category IDs separated by commas', 'flavor' ),
	) );

	$wp_customize->add_setting( 'flavor_tabbed_products_see_all_link', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'flavor_tabbed_products_see_all_link', array(
		'label'   => esc_html__( 'See All Link URL', 'flavor' ),
		'section' => 'flavor_tabbed_products',
		'type'    => 'url',
	) );

	// ═══════════════════════════════════════════
	// Promo Banner
	// ═══════════════════════════════════════════
	$wp_customize->add_section( 'flavor_promo_banner', array(
		'title' => esc_html__( 'Promo Banner', 'flavor' ),
		'panel' => 'flavor_homepage',
	) );

	$wp_customize->add_setting( 'flavor_promo_banner_enabled', array(
		'default'           => true,
		'sanitize_callback' => 'flavor_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'flavor_promo_banner_enabled', array(
		'label'   => esc_html__( 'Enable Promo Banner', 'flavor' ),
		'section' => 'flavor_promo_banner',
		'type'    => 'checkbox',
	) );

	$wp_customize->add_setting( 'flavor_promo_banner_image', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'flavor_promo_banner_image', array(
		'label'   => esc_html__( 'Desktop Image (1360×240)', 'flavor' ),
		'section' => 'flavor_promo_banner',
	) ) );

	$wp_customize->add_setting( 'flavor_promo_banner_image_mobile', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'flavor_promo_banner_image_mobile', array(
		'label'   => esc_html__( 'Mobile Image', 'flavor' ),
		'section' => 'flavor_promo_banner',
	) ) );

	$wp_customize->add_setting( 'flavor_promo_banner_link', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'flavor_promo_banner_link', array(
		'label'   => esc_html__( 'Link URL', 'flavor' ),
		'section' => 'flavor_promo_banner',
		'type'    => 'url',
	) );

	// ═══════════════════════════════════════════
	// Special Offers
	// ═══════════════════════════════════════════
	$wp_customize->add_section( 'flavor_special_offers', array(
		'title' => esc_html__( 'Special Offers', 'flavor' ),
		'panel' => 'flavor_homepage',
	) );

	$wp_customize->add_setting( 'flavor_special_offers_enabled', array(
		'default'           => true,
		'sanitize_callback' => 'flavor_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'flavor_special_offers_enabled', array(
		'label'   => esc_html__( 'Enable Special Offers', 'flavor' ),
		'section' => 'flavor_special_offers',
		'type'    => 'checkbox',
	) );

	$wp_customize->add_setting( 'flavor_special_offers_title', array(
		'default'           => esc_html__( 'Special Offers', 'flavor' ),
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'flavor_special_offers_title', array(
		'label'   => esc_html__( 'Section Title', 'flavor' ),
		'section' => 'flavor_special_offers',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'flavor_special_offers_countdown', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'flavor_special_offers_countdown', array(
		'label'       => esc_html__( 'Countdown End Date', 'flavor' ),
		'section'     => 'flavor_special_offers',
		'type'        => 'datetime-local',
		'description' => esc_html__( 'When the offer expires (ISO format)', 'flavor' ),
	) );

	// ═══════════════════════════════════════════
	// All Products
	// ═══════════════════════════════════════════
	$wp_customize->add_section( 'flavor_all_products', array(
		'title' => esc_html__( 'All Products', 'flavor' ),
		'panel' => 'flavor_homepage',
	) );

	$wp_customize->add_setting( 'flavor_all_products_enabled', array(
		'default'           => true,
		'sanitize_callback' => 'flavor_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'flavor_all_products_enabled', array(
		'label'   => esc_html__( 'Enable All Products', 'flavor' ),
		'section' => 'flavor_all_products',
		'type'    => 'checkbox',
	) );

	$wp_customize->add_setting( 'flavor_all_products_title', array(
		'default'           => esc_html__( 'All Products', 'flavor' ),
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'flavor_all_products_title', array(
		'label'   => esc_html__( 'Section Title', 'flavor' ),
		'section' => 'flavor_all_products',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'flavor_all_products_per_page', array(
		'default'           => 10,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'flavor_all_products_per_page', array(
		'label'   => esc_html__( 'Products per page', 'flavor' ),
		'section' => 'flavor_all_products',
		'type'    => 'number',
		'input_attrs' => array( 'min' => 4, 'max' => 20, 'step' => 1 ),
	) );

	// ═══════════════════════════════════════════
	// Popular Categories
	// ═══════════════════════════════════════════
	$wp_customize->add_section( 'flavor_popular_cats', array(
		'title' => esc_html__( 'Popular Categories', 'flavor' ),
		'panel' => 'flavor_homepage',
	) );

	$wp_customize->add_setting( 'flavor_popular_cats_enabled', array(
		'default'           => true,
		'sanitize_callback' => 'flavor_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'flavor_popular_cats_enabled', array(
		'label'   => esc_html__( 'Enable Popular Categories', 'flavor' ),
		'section' => 'flavor_popular_cats',
		'type'    => 'checkbox',
	) );

	$wp_customize->add_setting( 'flavor_popular_cats_title', array(
		'default'           => esc_html__( 'Popular Categories', 'flavor' ),
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'flavor_popular_cats_title', array(
		'label'   => esc_html__( 'Section Title', 'flavor' ),
		'section' => 'flavor_popular_cats',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'flavor_popular_cats_ids', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'flavor_popular_cats_ids', array(
		'label'       => esc_html__( 'Category IDs (comma-separated)', 'flavor' ),
		'section'     => 'flavor_popular_cats',
		'type'        => 'text',
		'description' => esc_html__( 'Leave empty to auto-select top categories', 'flavor' ),
	) );

	// ═══════════════════════════════════════════
	// Brand Logos
	// ═══════════════════════════════════════════
	$wp_customize->add_section( 'flavor_brands', array(
		'title' => esc_html__( 'Brand Logos', 'flavor' ),
		'panel' => 'flavor_homepage',
	) );

	$wp_customize->add_setting( 'flavor_brands_enabled', array(
		'default'           => true,
		'sanitize_callback' => 'flavor_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'flavor_brands_enabled', array(
		'label'   => esc_html__( 'Enable Brand Logos', 'flavor' ),
		'section' => 'flavor_brands',
		'type'    => 'checkbox',
	) );

	$wp_customize->add_setting( 'flavor_brands_title', array(
		'default'           => esc_html__( 'Our Brands', 'flavor' ),
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'flavor_brands_title', array(
		'label'   => esc_html__( 'Section Title', 'flavor' ),
		'section' => 'flavor_brands',
		'type'    => 'text',
	) );

	for ( $i = 1; $i <= 8; $i++ ) {
		$wp_customize->add_setting( "flavor_brand_logo_{$i}_image", array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, "flavor_brand_logo_{$i}_image", array(
			'label'   => sprintf( esc_html__( 'Brand %d — Logo', 'flavor' ), $i ),
			'section' => 'flavor_brands',
		) ) );

		$wp_customize->add_setting( "flavor_brand_logo_{$i}_name", array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( "flavor_brand_logo_{$i}_name", array(
			'label'   => sprintf( esc_html__( 'Brand %d — Name', 'flavor' ), $i ),
			'section' => 'flavor_brands',
			'type'    => 'text',
		) );

		$wp_customize->add_setting( "flavor_brand_logo_{$i}_link", array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( "flavor_brand_logo_{$i}_link", array(
			'label'   => sprintf( esc_html__( 'Brand %d — Link', 'flavor' ), $i ),
			'section' => 'flavor_brands',
			'type'    => 'url',
		) );
	}
}
add_action( 'customize_register', 'flavor_customizer_homepage' );

/**
 * Sanitize checkbox
 */
function flavor_sanitize_checkbox( $checked ) {
	return ( ( isset( $checked ) && true === $checked ) ? true : false );
}

/**
 * Sanitize SVG (allow safe tags)
 */
function flavor_sanitize_svg( $svg ) {
	return wp_kses( $svg, array(
		'svg'    => array( 'class' => true, 'viewBox' => true, 'fill' => true, 'stroke' => true, 'xmlns' => true, 'width' => true, 'height' => true ),
		'path'   => array( 'd' => true, 'fill' => true, 'stroke' => true, 'stroke-linecap' => true, 'stroke-linejoin' => true, 'stroke-width' => true ),
		'circle' => array( 'cx' => true, 'cy' => true, 'r' => true, 'fill' => true, 'stroke' => true ),
		'rect'   => array( 'x' => true, 'y' => true, 'width' => true, 'height' => true, 'fill' => true, 'rx' => true ),
		'line'   => array( 'x1' => true, 'y1' => true, 'x2' => true, 'y2' => true, 'stroke' => true ),
	) );
}
