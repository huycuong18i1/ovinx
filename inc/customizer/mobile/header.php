<?php

$wp_customize->add_setting(
    'btn_login_mobile',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('btn_login_mobile'),     
      )   
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'btn_login_mobile',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Btn Login', 'ovinx'),
        'section' => 'section_mobile_header',
        
    ))
);


$wp_customize->add_setting(
    'btn_wishlist_mobile',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('btn_wishlist_mobile'),     
      )   
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'btn_wishlist_mobile',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Btn Wishlist', 'ovinx'),
        'section' => 'section_mobile_header',
        
    ))
);


$wp_customize->add_setting(
    'btn_cart_mobile',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('btn_cart_mobile'),     
      )   
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'btn_cart_mobile',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Btn Cart', 'ovinx'),
        'section' => 'section_mobile_header',
        
    ))
);
