<?php 


$wp_customize->add_setting(
    'product_style',
    array(
        'default'           => themesflat_customize_default('product_style'),
        'sanitize_callback' => 'esc_attr',
    )
);
$wp_customize->add_control( 
    'product_style',
    array (
        'type'      => 'select',           
        'section'   => 'section_product_card',
        'label'         => esc_html__('Card Style', 'ovinx'),
        'choices'   => array (
            'style-1'     => esc_html__( 'Grid 1','ovinx' ),
            'style-2'     => esc_html__( 'Grid 2','ovinx' ),
            'style-3'     => esc_html__( 'Grid 3','ovinx' ),
            'style-4'     => esc_html__( 'Grid 4','ovinx' ),
            'style-list'      =>  esc_html__( 'List','ovinx' ),
        ),
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
    'show_out_stock_btn',
      array(
          'sanitize_callback' => 'absint',
          'default' => themesflat_customize_default('show_out_stock_btn'),     
      )   
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'show_out_stock_btn',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Show Out Stock button', 'ovinx'),
        'section' => 'section_product_card',
        
    ))
);

$wp_customize->add_setting(
    'out_stock_btn_text',
      array(
          'sanitize_callback' => 'themesflat_sanitize_text',
          'default' => themesflat_customize_default('out_stock_btn_text'),     
      )   
);

$wp_customize->add_control( 
      'out_stock_btn_text',
      array(
          'type' => 'text',
          'label' => esc_html__('Button Text', 'ovinx'),
          'section' => 'section_product_card',
          'active_callback' => function() use ( $wp_customize ) {
            return ( 
                1 == $wp_customize->get_setting( 'show_out_stock_btn' )->value()
            );
          },
      )
);

$wp_customize->add_setting(
    'out_stock_form',
      array(
          'sanitize_callback' => 'themesflat_sanitize_text',
          'default' => themesflat_customize_default('out_stock_form'),     
      )   
);

$wp_customize->add_control( 
      'out_stock_form',
      array(
            'type' => 'text',
            'label' => esc_html__('Out stock form', 'ovinx'),
            'input_attrs' => array(
                'placeholder' => '[contact-form-7 id="123" title="Notify me"]',
            ),
            'section' => 'section_product_card',
            'active_callback' => function() use ( $wp_customize ) {
                return ( 
                    1 == $wp_customize->get_setting( 'show_out_stock_btn' )->value()
                );
            },
      )
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
        'label'         => esc_html__('Attribute First (Display to card thumbnail)', 'ovinx'),
        'choices'   => tfwc_attribute_customize_register(),
    )
);

$wp_customize->add_setting (
    'attr1_count',
    array(
        'default' => themesflat_customize_default('attr1_count'),
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'attr1_count',
    array(
        'type'      => 'text',
        'label'     => esc_html__('Number Of Attribute 1', 'ovinx'),
        'section'   => 'section_product_card',     
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
        'label'         => esc_html__('Attribute Second (Display to card sumary)', 'ovinx'),
        'choices'   => tfwc_attribute_customize_register(),
    )
);

$wp_customize->add_setting (
    'attr2_count',
    array(
        'default' => themesflat_customize_default('attr2_count'),
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'attr2_count',
    array(
        'type'      => 'text',
        'label'     => esc_html__('Number Of Attribute 2', 'ovinx'),
        'section'   => 'section_product_card',     
    )
);


function tfwc_attribute_customize_register() {
    if ( ! class_exists( 'WooCommerce' ) ) {
        return array();
    }
    $product_attributes = wc_get_attribute_taxonomies();

    // 'none' must be a real selectable choice: attribute-first.php's thumbnail-overlay swatch
    // (`.variant-box`) has no matching CSS anywhere in the ovinx-html design (never used in any
    // ground-truth page) and is disabled by default (see options-definition.php) — without this
    // choice an admin could never turn it back off from the Customizer UI once a real attribute
    // is selected.
    $attribute_choices = array( 'none' => esc_html__( 'None', 'ovinx' ) );

    foreach ( $product_attributes as $attribute ) {
        $attribute_choices[$attribute->attribute_name] = wc_attribute_label( $attribute->attribute_name );
    }

    return $attribute_choices;
}



