<?php 

$wp_customize->add_setting(
    'btn_pc_cart',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('btn_pc_cart'),     
      )   
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'btn_pc_cart',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Btn Add To Cart', 'ovinx'),
        'section' => 'section_mobile_product_card',
        
    ))
);


$wp_customize->add_setting(
    'btn_pc_wishlist',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('btn_pc_wishlist'),     
      )   
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'btn_pc_wishlist',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Btn Wishlist', 'ovinx'),
        'section' => 'section_mobile_product_card',
        
    ))
);


$wp_customize->add_setting(
    'btn_pc_quickview',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('btn_pc_quickview'),     
      )   
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'btn_pc_quickview',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Btn QuickView', 'ovinx'),
        'section' => 'section_mobile_product_card',
        
    ))
);


$wp_customize->add_setting(
    'btn_pc_compare',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('btn_pc_compare'),     
      )   
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'btn_pc_compare',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Btn Compare', 'ovinx'),
        'section' => 'section_mobile_product_card',
        
    ))
);

$wp_customize->add_setting(
    'pc_badges',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('pc_badges'),     
      )   
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'pc_badges',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Badges', 'ovinx'),
        'section' => 'section_mobile_product_card',
        
    ))
);


