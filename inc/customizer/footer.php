<?php
/**
 * Customizer: Footer settings
 *
 * @package Flavor
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register footer Customizer settings.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function flavor_customizer_footer( $wp_customize ) {

    $wp_customize->add_section( 'flavor_footer', array(
        'title'    => esc_html__( 'Footer', 'flavor' ),
        'priority' => 35,
    ) );

    $wp_customize->add_setting( 'flavor_footer_brand_text', array(
        'default'           => flavor_get_theme_default( 'flavor_footer_brand_text', esc_html__( 'Stay connected', 'flavor' ) ),
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );
    $wp_customize->add_control( 'flavor_footer_brand_text', array(
        'label'       => esc_html__( 'Footer Description', 'flavor' ),
        'description' => esc_html__( 'Shown under the footer logo.', 'flavor' ),
        'section'     => 'flavor_footer',
        'type'        => 'textarea',
    ) );

    // Social URLs.
    $socials = array(
        'flavor_social_facebook'  => esc_html__( 'Facebook URL', 'flavor' ),
        'flavor_social_twitter'   => esc_html__( 'Twitter / X URL', 'flavor' ),
        'flavor_social_instagram' => esc_html__( 'Instagram URL', 'flavor' ),
    );

    foreach ( $socials as $id => $label ) {
        $wp_customize->add_setting( $id, array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ) );
        $wp_customize->add_control( $id, array(
            'label'   => $label,
            'section' => 'flavor_footer',
            'type'    => 'url',
        ) );
    }

    // Contact fields.
    $text_fields = array(
        'flavor_contact_email'  => esc_html__( 'Contact Email', 'flavor' ),
        'flavor_contact_phone'  => esc_html__( 'Contact Phone', 'flavor' ),
        'flavor_whatsapp_number' => esc_html__( 'WhatsApp Number', 'flavor' ),
        'flavor_viber_number'   => esc_html__( 'Viber Number', 'flavor' ),
        'flavor_business_email' => esc_html__( 'Business Email', 'flavor' ),
        'flavor_address'        => esc_html__( 'Physical Address', 'flavor' ),
    );

    foreach ( $text_fields as $id => $label ) {
        $wp_customize->add_setting( $id, array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control( $id, array(
            'label'   => $label,
            'section' => 'flavor_footer',
            'type'    => 'text',
        ) );
    }

    // Ecosystem logos (up to 8).
    for ( $i = 1; $i <= 8; $i++ ) {
        $wp_customize->add_setting( "flavor_ecosystem_logo_{$i}", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ) );
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, "flavor_ecosystem_logo_{$i}", array(
            /* translators: %d: logo number */
            'label'   => sprintf( esc_html__( 'Ecosystem Logo %d', 'flavor' ), $i ),
            'section' => 'flavor_footer',
        ) ) );
    }
}
add_action( 'customize_register', 'flavor_customizer_footer' );
