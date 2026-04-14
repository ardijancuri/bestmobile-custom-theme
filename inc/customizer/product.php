<?php
/**
 * Customizer: Product settings
 *
 * @package Flavor
 */

defined('ABSPATH') || exit;

/**
 * Register product customizer settings.
 *
 * @param WP_Customize_Manager $wp_customize
 */
function flavor_customizer_product($wp_customize) {
    $wp_customize->add_section('flavor_product', [
        'title'    => __('Product Page Settings', 'flavor'),
        'priority' => 31,
        'panel'    => 'flavor_theme_options',
    ]);

    // Installment display on/off
    $wp_customize->add_setting('flavor_installment_display', [
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ]);

    $wp_customize->add_control('flavor_installment_display', [
        'label'   => __('Show Installment Display', 'flavor'),
        'section' => 'flavor_product',
        'type'    => 'checkbox',
    ]);

    // Installment months
    $wp_customize->add_setting('flavor_installment_months', [
        'default'           => '24,36',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ]);

    $wp_customize->add_control('flavor_installment_months', [
        'label'       => __('Installment Months (comma-separated)', 'flavor'),
        'description' => __('e.g. 24,36', 'flavor'),
        'section'     => 'flavor_product',
        'type'        => 'text',
    ]);

    // Warranty upsell on/off
    $wp_customize->add_setting('flavor_warranty_upsell', [
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ]);

    $wp_customize->add_control('flavor_warranty_upsell', [
        'label'   => __('Show Warranty Upsell', 'flavor'),
        'section' => 'flavor_product',
        'type'    => 'checkbox',
    ]);

    // Shipping zones (up to 5 zone_name + delivery_days pairs)
    for ($i = 1; $i <= 5; $i++) {
        $wp_customize->add_setting("flavor_shipping_zone_{$i}_name", [
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ]);

        $wp_customize->add_control("flavor_shipping_zone_{$i}_name", [
            'label'   => sprintf(__('Shipping Zone %d – Name', 'flavor'), $i),
            'section' => 'flavor_product',
            'type'    => 'text',
        ]);

        $wp_customize->add_setting("flavor_shipping_zone_{$i}_days", [
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ]);

        $wp_customize->add_control("flavor_shipping_zone_{$i}_days", [
            'label'   => sprintf(__('Shipping Zone %d – Delivery Days', 'flavor'), $i),
            'section' => 'flavor_product',
            'type'    => 'text',
        ]);
    }

    // Cross-sells on/off
    $wp_customize->add_setting('flavor_cross_sells', [
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ]);

    $wp_customize->add_control('flavor_cross_sells', [
        'label'   => __('Show Cross-Sells', 'flavor'),
        'section' => 'flavor_product',
        'type'    => 'checkbox',
    ]);

    // Cross-sells count
    $wp_customize->add_setting('flavor_cross_sells_count', [
        'default'           => 4,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ]);

    $wp_customize->add_control('flavor_cross_sells_count', [
        'label'       => __('Cross-Sells Count', 'flavor'),
        'section'     => 'flavor_product',
        'type'        => 'number',
        'input_attrs' => [
            'min'  => 4,
            'max'  => 8,
            'step' => 1,
        ],
    ]);
}
add_action('customize_register', 'flavor_customizer_product');
