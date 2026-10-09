<?php 
$wp_customize->add_setting(
  'page_title_heading_woo',
    array(
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
        'default' => themesflat_customize_default('page_title_heading_woo'),     
    )   
);
$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'page_title_heading_woo',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Heading', 'ovinx'),
        'section' => 'section_shop_pagetitle',
    ))
);

$wp_customize->add_setting(
    'breadcrumb_woo',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('breadcrumb_woo'),     
      )   
);
$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'breadcrumb_woo',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Breadcrumb', 'ovinx'),
        'section' => 'section_shop_pagetitle',
    ))
);

$wp_customize->add_setting(
    'page_title_alignment_woo',
    array(
        'default'           => themesflat_customize_default('page_title_alignment_woo'),
        'sanitize_callback' => 'esc_attr',
    )
);
$wp_customize->add_control( 
    'page_title_alignment_woo',
    array (
        'type'      => 'select',           
        'section' => 'section_shop_pagetitle',
        'label'         => esc_html__('Page Title Alignment', 'ovinx'),
        'choices'   => array (
            'left' =>  esc_html__( 'Left','ovinx' ),
            'center' =>  esc_html__( 'Center','ovinx' ),
            'right' =>  esc_html__( 'Right','ovinx' )
            ) ,
    )
); 

// PAGE DESCRIPTION

$wp_customize->add_setting(
'page_title_description_woo',
    array(
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
        'default' => themesflat_customize_default('page_title_description_woo'),     
    )   
);
$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'page_title_description_woo',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Description', 'ovinx'),
        'section' => 'section_shop_pagetitle',
        // 'active_callback' => function( $control ) {
        //     $page_title_alignment   = $control->manager->get_setting( 'page_title_alignment_woo' )->value();
        //     return ( $page_title_alignment !== 'center' );
        // },
    ))
);

// SHOP DESCRIPTION

$wp_customize->add_setting (
    'page_title_description_content_shop',
    array(
        'default' => themesflat_customize_default('page_title_description_content_shop') ,
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'page_title_description_content_shop',
    array(
        'type'      => 'text',
        'label'     => esc_html__('Shop Page Description', 'ovinx'),
        'section' => 'section_shop_pagetitle',
        'active_callback' => function( $control ) {
            $page_title_description = $control->manager->get_setting( 'page_title_description_woo' )->value();
            return ( $page_title_description == 1);
        },
    )
);

// WISHLIST DESCRIPTION

$wp_customize->add_setting (
    'page_title_description_content_wishlist',
    array(
        'default' => themesflat_customize_default('page_title_description_content_wishlist') ,
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'page_title_description_content_wishlist',
    array(
        'type'      => 'text',
        'label'     => esc_html__('Wishlist Page Description', 'ovinx'),
        'section' => 'section_shop_pagetitle',
        'active_callback' => function( $control ) {
            $page_title_description = $control->manager->get_setting( 'page_title_description_woo' )->value();
            return ( $page_title_description == 1);
        },
    )
);

// COMPARE DESCRIPTION

$wp_customize->add_setting (
    'page_title_description_content_compare',
    array(
        'default' => themesflat_customize_default('page_title_description_content_compare') ,
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'page_title_description_content_compare',
    array(
        'type'      => 'text',
        'label'     => esc_html__('Compare Page Description', 'ovinx'),
        'section' => 'section_shop_pagetitle',
        'active_callback' => function( $control ) {
            $page_title_description = $control->manager->get_setting( 'page_title_description_woo' )->value();
            return ( $page_title_description == 1);
        },
    )
);

// CART DESCRIPTION

$wp_customize->add_setting (
    'page_title_description_content_cart',
    array(
        'default' => themesflat_customize_default('page_title_description_content_cart') ,
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'page_title_description_content_cart',
    array(
        'type'      => 'text',
        'label'     => esc_html__('Cart Page Description', 'ovinx'),
        'section' => 'section_shop_pagetitle',
        'active_callback' => function( $control ) {
            $page_title_description = $control->manager->get_setting( 'page_title_description_woo' )->value();
            return ( $page_title_description == 1);
        },
    )
);

// CART DESCRIPTION

$wp_customize->add_setting (
    'page_title_description_content_checkout',
    array(
        'default' => themesflat_customize_default('page_title_description_content_checkout') ,
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'page_title_description_content_checkout',
    array(
        'type'      => 'text',
        'label'     => esc_html__('Checkout Page Description', 'ovinx'),
        'section' => 'section_shop_pagetitle',
        'active_callback' => function( $control ) {
            $page_title_description = $control->manager->get_setting( 'page_title_description_woo' )->value();
            return ( $page_title_description == 1);
        },
    )
);

// Box control
$wp_customize->add_setting(
    'page_title_controls_woo',
    array(
        'default' => themesflat_customize_default('page_title_controls_woo'),
        'sanitize_callback' => 'themesflat_sanitize_text',
    )
);
$wp_customize->add_control( new themesflat_BoxControls($wp_customize,
    'page_title_controls_woo',
    array(
        'label' => esc_html__( 'Page Title Controls (px)', 'ovinx' ),
        'section' => 'section_shop_pagetitle',
        'type' => 'box-controls',
    ))
);  



  