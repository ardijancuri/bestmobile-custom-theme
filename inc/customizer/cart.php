<?php
/**
 * Customizer: Cart settings
 *
 * @package Flavor
 */

defined('ABSPATH') || exit;

/**
 * Register cart customizer settings.
 *
 * @param WP_Customize_Manager $wp_customize
 */
function flavor_customizer_cart($wp_customize) {
    $wp_customize->add_section('flavor_cart', [
        'title'    => __('Cart Settings', 'flavor'),
        'priority' => 32,
        'panel'    => 'flavor_theme_options',
    ]);

    // Cross-sells on cart on/off
    $wp_customize->add_setting('flavor_cart_cross_sells', [
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ]);

    $wp_customize->add_control('flavor_cart_cross_sells', [
        'label'   => __('Show Cross-Sells on Cart', 'flavor'),
        'section' => 'flavor_cart',
        'type'    => 'checkbox',
    ]);

    // Warranty feature on/off
    $wp_customize->add_setting('flavor_cart_warranty', [
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ]);

    $wp_customize->add_control('flavor_cart_warranty', [
        'label'   => __('Enable Warranty Feature', 'flavor'),
        'section' => 'flavor_cart',
        'type'    => 'checkbox',
    ]);

    // Sticky checkout button on/off
    $wp_customize->add_setting('flavor_cart_sticky_checkout', [
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ]);

    $wp_customize->add_control('flavor_cart_sticky_checkout', [
        'label'   => __('Sticky Checkout Button (Mobile)', 'flavor'),
        'section' => 'flavor_cart',
        'type'    => 'checkbox',
    ]);

    // Empty cart message
    $wp_customize->add_setting('flavor_cart_empty_message', [
        'default'           => __('Your cart is currently empty.', 'flavor'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ]);

    $wp_customize->add_control('flavor_cart_empty_message', [
        'label'   => __('Empty Cart Message', 'flavor'),
        'section' => 'flavor_cart',
        'type'    => 'text',
    ]);
}
add_action('customize_register', 'flavor_customizer_cart');
