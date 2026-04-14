<?php
/**
 * Customizer: Shop settings
 *
 * @package Flavor
 */

defined('ABSPATH') || exit;

/**
 * Register shop customizer settings.
 *
 * @param WP_Customize_Manager $wp_customize
 */
function flavor_customizer_shop($wp_customize) {
    $wp_customize->add_section('flavor_shop', [
        'title'    => __('Shop Settings', 'flavor'),
        'priority' => 30,
        'panel'    => 'flavor_theme_options',
    ]);

    // Products per page
    $wp_customize->add_setting('flavor_products_per_page', [
        'default'           => 12,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ]);

    $wp_customize->add_control('flavor_products_per_page', [
        'label'       => __('Products Per Page', 'flavor'),
        'section'     => 'flavor_shop',
        'type'        => 'number',
        'input_attrs' => [
            'min'  => 4,
            'max'  => 48,
            'step' => 1,
        ],
    ]);

    // Default sort order
    $wp_customize->add_setting('flavor_default_sort', [
        'default'           => 'menu_order',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ]);

    $wp_customize->add_control('flavor_default_sort', [
        'label'   => __('Default Sort Order', 'flavor'),
        'section' => 'flavor_shop',
        'type'    => 'select',
        'choices' => [
            'menu_order' => __('Default (menu order)', 'flavor'),
            'date'       => __('Newest first', 'flavor'),
            'popularity' => __('Popularity', 'flavor'),
            'rating'     => __('Average rating', 'flavor'),
            'price'      => __('Price: low to high', 'flavor'),
            'price-desc' => __('Price: high to low', 'flavor'),
        ],
    ]);

    // Grid columns (desktop)
    $wp_customize->add_setting('flavor_grid_columns', [
        'default'           => 4,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ]);

    $wp_customize->add_control('flavor_grid_columns', [
        'label'       => __('Grid Columns (Desktop)', 'flavor'),
        'section'     => 'flavor_shop',
        'type'        => 'number',
        'input_attrs' => [
            'min'  => 3,
            'max'  => 5,
            'step' => 1,
        ],
    ]);

    // Show/hide filter button
    $wp_customize->add_setting('flavor_show_filter_button', [
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ]);

    $wp_customize->add_control('flavor_show_filter_button', [
        'label'   => __('Show Filter Button', 'flavor'),
        'section' => 'flavor_shop',
        'type'    => 'checkbox',
    ]);

    // Show/hide quick-filter tabs
    $wp_customize->add_setting('flavor_show_quick_filter_tabs', [
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ]);

    $wp_customize->add_control('flavor_show_quick_filter_tabs', [
        'label'   => __('Show Quick-Filter Tabs', 'flavor'),
        'section' => 'flavor_shop',
        'type'    => 'checkbox',
    ]);
}
add_action('customize_register', 'flavor_customizer_shop');
