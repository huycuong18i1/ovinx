<?php

$wp_customize->add_setting(
    'single_sku',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('single_sku'),     
      )   
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'single_sku',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Product SKU', 'ovinx'),
        'section' => 'section_product_options',
    ))
);

$wp_customize->add_setting(
    'single_brand',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('single_brand'),     
      )   
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'single_brand',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Product Vendor', 'ovinx'),
        'section' => 'section_product_options',
    ))
);

$wp_customize->add_setting(
    'single_available',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('single_available'),     
      )   
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'single_available',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Available', 'ovinx'),
        'section' => 'section_product_options',
    ))
);

$wp_customize->add_setting(
    'single_category',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('single_category'),     
      )   
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'single_category',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Product Category', 'ovinx'),
        'section' => 'section_product_options',
    ))
);