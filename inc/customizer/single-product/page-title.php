<?php

$wp_customize->add_setting(
  'page_title_heading_woo_single',
    array(
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
        'default' => themesflat_customize_default('page_title_heading_woo_single'),     
    )   
);
$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'page_title_heading_woo_single',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Heading', 'ovinx'),
        'section' => 'single_product_pagetitle',
    ))
);

$wp_customize->add_setting(
    'breadcrumb_woo_single',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('breadcrumb_woo_single'),     
      )   
);
$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'breadcrumb_woo_single',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Breadcrumb', 'ovinx'),
        'section' => 'single_product_pagetitle',
    ))
);

  $wp_customize->add_setting(
      'single_navigation',
        array(
            'sanitize_callback' => 'themesflat_sanitize_checkbox',
            'default' => themesflat_customize_default('single_navigation'),     
        )   
  );
  $wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
      'single_navigation',
      array(
          'type' => 'checkbox',
          'label' => esc_html__('Prev Next Product', 'ovinx'),
          'section' => 'single_product_pagetitle',
      ))
  );  