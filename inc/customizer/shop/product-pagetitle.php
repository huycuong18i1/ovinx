<?php 


$wp_customize->add_setting(
    'product_style',
    array(
        'default'           => themesflat_customize_default('product_style'),
        'sanitize_callback' => 'esc_attr',
    )
);

$wp_customize->add_setting(
    'show_rating',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('show_rating'),     
      )   
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'show_rating',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Show Rating', 'ovinx'),
        'section' => 'section_product_card',
        
    ))
);

$wp_customize->add_setting(
    'show_category',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('show_category'),     
      )   
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'show_category',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Show Category', 'ovinx'),
        'section' => 'section_product_card',
        
    ))
);

$wp_customize->add_setting(
    'show_countdown',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('show_countdown'),     
      )   
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'show_countdown',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Show Count Down', 'ovinx'),
        'section' => 'section_product_card',
        
    ))
);

$wp_customize->add_setting(
    'show_badges',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('show_badges'),     
      )   
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'show_badges',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Show Badges', 'ovinx'),
        'section' => 'section_product_card',
        
    ))
);

$wp_customize->add_setting(
    'show_progressbar',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('show_progressbar'),     
      )   
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'show_progressbar',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Show Progressbar', 'ovinx'),
        'section' => 'section_product_card',
        
    ))
);

$wp_customize->add_setting(
    'show_in_out_stock',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('show_in_out_stock'),     
      )   
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'show_in_out_stock',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Show In/Out Stock', 'ovinx'),
        'section' => 'section_product_card',
        
    ))
);

$wp_customize->add_setting(
    'attribute_first',
    array(
        'default'           => themesflat_customize_default('attribute_first'),
        'sanitize_callback' => 'esc_attr',
    )
);
$wp_customize->add_control( 
    'attribute_first',
    array (
        'type'      => 'select',           
        'section'   => 'section_product_card',
        'label'         => esc_html__('Attribute First(Display to card thumbnail)', 'ovinx'),
        'choices'   => tfwc_attribute_customize_register(),
    )
);

$wp_customize->add_setting(
    'attribute_second',
    array(
        'default'           => themesflat_customize_default('attribute_second'),
        'sanitize_callback' => 'esc_attr',
    )
);
$wp_customize->add_control( 
    'attribute_second',
    array (
        'type'      => 'select',           
        'section'   => 'section_product_card',
        'label'         => esc_html__('Attribute First(Display to card sumary)', 'ovinx'),
        'choices'   => tfwc_attribute_customize_register(),
    )
);



function tfwc_attribute_customize_register() {
    if ( ! class_exists( 'WooCommerce' ) ) {
        return array(); 
    }
    $product_attributes = wc_get_attribute_taxonomies();
    
    $attribute_choices = array();
    
    foreach ( $product_attributes as $attribute ) {
        $attribute_choices[$attribute->attribute_name] = wc_attribute_label( $attribute->attribute_name );
    }
    
    return $attribute_choices;
}



