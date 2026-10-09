<?php 
// Badge In/Out Stock
$wp_customize->add_setting('badges_stock_heading', array(
    'type'              => 'info_control',
    'capability'        => 'edit_theme_options',
    'sanitize_callback' => 'esc_attr',            
)
);

$wp_customize->add_control( new themesflat_Info( $wp_customize, 'badges_stock-body', array(
    'label' => esc_html__('Badge In/Out Stock', 'ovinx'),
    'section' => 'section_product_badges',
    'settings' => 'badges_stock_heading',
    'priority'      => 1,
) )
);
$wp_customize->add_setting(
    'badges_stock',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('badges_stock'),     
      )   
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'badges_stock',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Badge In/Out Stock', 'ovinx'),
        'section' => 'section_product_badges',
        'priority' => 1,
    ))
);

$wp_customize->add_setting(
    'badges_stock_color',
    array(
        'default'           => themesflat_customize_default('badges_stock_color'),
        'sanitize_callback' => 'esc_attr',
    )
);
$wp_customize->add_control( new themesflat_ColorOverlay(
        $wp_customize,
        'badges_stock_color',
        array(
            'label'         => esc_html__('Color', 'ovinx'),
            'section'       => 'section_product_badges',
            'priority'      => 1,
            'active_callback' => function() use ( $wp_customize ) {
                return ( 
                    check_setting_is_on( 'badges_stock' )
                );
            },
        )
    )
);

$wp_customize->add_setting(
    'badges_stock_background_color',
    array(
        'default'           => themesflat_customize_default('badges_stock_background_color'),
        'sanitize_callback' => 'esc_attr',
    )
);
$wp_customize->add_control( new themesflat_ColorOverlay(
        $wp_customize,
        'badges_stock_background_color',
        array(
            'label'         => esc_html__('Background', 'ovinx'),
            'section'       => 'section_product_badges',
            'priority'      => 1,
            'active_callback' => function() use ( $wp_customize ) {
                return ( 
                    check_setting_is_on( 'badges_stock' )
                );
            },
        )
    )
);

// Badge Trending
$wp_customize->add_setting('badges_trending_heading', array(
    'type'              => 'info_control',
    'capability'        => 'edit_theme_options',
    'sanitize_callback' => 'esc_attr',            
)
);

$wp_customize->add_control( new themesflat_Info( $wp_customize, 'badges_trending-body', array(
    'label' => esc_html__('Badge Trending', 'ovinx'),
    'section' => 'section_product_badges',
    'settings' => 'badges_trending_heading',
    'priority'      => 1,
) )
);

$wp_customize->add_setting(
    'badges_trending',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('badges_trending'),     
      )   
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'badges_trending',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Badge Trending', 'ovinx'),
        'section' => 'section_product_badges',
        'priority' => 1,
    ))
);

$wp_customize->add_setting(
    'badges_trending_color',
    array(
        'default'           => themesflat_customize_default('badges_trending_color'),
        'sanitize_callback' => 'esc_attr',
    )
);
$wp_customize->add_control( new themesflat_ColorOverlay(
        $wp_customize,
        'badges_trending_color',
        array(
            'label'         => esc_html__('Color', 'ovinx'),
            'section'       => 'section_product_badges',
            'priority'      => 1,
            'active_callback' => function() use ( $wp_customize ) {
                return ( 
                    check_setting_is_on( 'badges_trending' )
                );
            },
        )
    )
);

$wp_customize->add_setting(
    'badges_trending_background_color',
    array(
        'default'           => themesflat_customize_default('badges_trending_background_color'),
        'sanitize_callback' => 'esc_attr',
    )
);
$wp_customize->add_control( new themesflat_ColorOverlay(
        $wp_customize,
        'badges_trending_background_color',
        array(
            'label'         => esc_html__('Background', 'ovinx'),
            'section'       => 'section_product_badges',
            'priority'      => 1,
            'active_callback' => function() use ( $wp_customize ) {
                return ( 
                    check_setting_is_on( 'badges_trending' )
                );
            },
        )
    )
);

// Badge Custom
$wp_customize->add_setting('badges_custom_heading', array(
    'type'              => 'info_control',
    'capability'        => 'edit_theme_options',
    'sanitize_callback' => 'esc_attr',            
)
);

$wp_customize->add_control( new themesflat_Info( $wp_customize, 'badges_custom-body', array(
    'label' => esc_html__('Badge Custom', 'ovinx'),
    'section' => 'section_product_badges',
    'settings' => 'badges_custom_heading',
    'priority'      => 1,
) )
);

$wp_customize->add_setting(
    'badges_custom',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('badges_custom'),     
      )   
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'badges_custom',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Badge Custom', 'ovinx'),
        'section' => 'section_product_badges',
        'priority' => 1,
    ))
);

$wp_customize->add_setting(
    'badges_custom_color',
    array(
        'default'           => themesflat_customize_default('badges_custom_color'),
        'sanitize_callback' => 'esc_attr',
    )
);
$wp_customize->add_control( new themesflat_ColorOverlay(
        $wp_customize,
        'badges_custom_color',
        array(
            'label'         => esc_html__('Color', 'ovinx'),
            'section'       => 'section_product_badges',
            'priority'      => 1,
            'active_callback' => function() use ( $wp_customize ) {
                return ( 
                    check_setting_is_on( 'badges_custom' )
                );
            },
        )
    )
);

$wp_customize->add_setting(
    'badges_custom_background_color',
    array(
        'default'           => themesflat_customize_default('badges_custom_background_color'),
        'sanitize_callback' => 'esc_attr',
    )
);
$wp_customize->add_control( new themesflat_ColorOverlay(
        $wp_customize,
        'badges_custom_background_color',
        array(
            'label'         => esc_html__('Background', 'ovinx'),
            'section'       => 'section_product_badges',
            'priority'      => 1,
            'active_callback' => function() use ( $wp_customize ) {
                return ( 
                    check_setting_is_on( 'badges_custom' )
                );
            },
        )
    )
);

// Badge Sale
$wp_customize->add_setting('badges_sale_heading', array(
    'type'              => 'info_control',
    'capability'        => 'edit_theme_options',
    'sanitize_callback' => 'esc_attr',            
)
);

$wp_customize->add_control( new themesflat_Info( $wp_customize, 'badges_sale-body', array(
    'label' => esc_html__('Badge Sale', 'ovinx'),
    'section' => 'section_product_badges',
    'settings' => 'badges_sale_heading',
    'priority'      => 1,
) )
);

$wp_customize->add_setting(
    'badges_sale',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('badges_sale'),     
      )   
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'badges_sale',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Badge Sale', 'ovinx'),
        'section' => 'section_product_badges',
        'priority' => 1,
    ))
);

$wp_customize->add_setting(
    'badges_sale_color',
    array(
        'default'           => themesflat_customize_default('badges_sale_color'),
        'sanitize_callback' => 'esc_attr',
    )
);
$wp_customize->add_control( new themesflat_ColorOverlay(
        $wp_customize,
        'badges_sale_color',
        array(
            'label'         => esc_html__('Color', 'ovinx'),
            'section'       => 'section_product_badges',
            'priority'      => 1,
            'active_callback' => function() use ( $wp_customize ) {
                return ( 
                    check_setting_is_on( 'badges_sale' )
                );
            },
        )
    )
);

$wp_customize->add_setting(
    'badges_sale_background_color',
    array(
        'default'           => themesflat_customize_default('badges_sale_background_color'),
        'sanitize_callback' => 'esc_attr',
    )
);
$wp_customize->add_control( new themesflat_ColorOverlay(
        $wp_customize,
        'badges_sale_background_color',
        array(
            'label'         => esc_html__('Background', 'ovinx'),
            'section'       => 'section_product_badges',
            'priority'      => 1,
            'active_callback' => function() use ( $wp_customize ) {
                return ( 
                    check_setting_is_on( 'badges_sale' )
                );
            },
        )
    )
);

// Badge New
$wp_customize->add_setting('badges_new_heading', array(
    'type'              => 'info_control',
    'capability'        => 'edit_theme_options',
    'sanitize_callback' => 'esc_attr',            
)
);

$wp_customize->add_control( new themesflat_Info( $wp_customize, 'badges_new-body', array(
    'label' => esc_html__('Badge New', 'ovinx'),
    'section' => 'section_product_badges',
    'settings' => 'badges_new_heading',
    'priority'      => 1,
) )
);

$wp_customize->add_setting(
    'badges_new',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('badges_new'),     
      )   
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'badges_new',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Badge New', 'ovinx'),
        'section' => 'section_product_badges',
        'priority' => 1,
    ))
);

$wp_customize->add_setting(
    'badges_new_color',
    array(
        'default'           => themesflat_customize_default('badges_new_color'),
        'sanitize_callback' => 'esc_attr',
    )
);
$wp_customize->add_control( new themesflat_ColorOverlay(
        $wp_customize,
        'badges_new_color',
        array(
            'label'         => esc_html__('Color', 'ovinx'),
            'section'       => 'section_product_badges',
            'priority'      => 1,
            'active_callback' => function() use ( $wp_customize ) {
                return ( 
                    check_setting_is_on( 'badges_new' )
                );
            },
        )
    )
);

$wp_customize->add_setting(
    'badges_new_background_color',
    array(
        'default'           => themesflat_customize_default('badges_new_background_color'),
        'sanitize_callback' => 'esc_attr',
    )
);
$wp_customize->add_control( new themesflat_ColorOverlay(
        $wp_customize,
        'badges_new_background_color',
        array(
            'label'         => esc_html__('Background', 'ovinx'),
            'section'       => 'section_product_badges',
            'priority'      => 1,
            'active_callback' => function() use ( $wp_customize ) {
                return ( 
                    check_setting_is_on( 'badges_new' )
                );
            },
        )
    )
);

// Badge Order
$wp_customize->add_setting('badges_order_heading', array(
    'type'              => 'info_control',
    'capability'        => 'edit_theme_options',
    'sanitize_callback' => 'esc_attr',            
)
);

$wp_customize->add_control( new themesflat_Info( $wp_customize, 'badges_order-body', array(
    'label' => esc_html__('Badge Order', 'ovinx'),
    'section' => 'section_product_badges',
    'settings' => 'badges_order_heading',
    'priority'      => 1,
) )
);

$wp_customize->add_setting(
    'badges_order',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('badges_order'),     
      )   
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'badges_order',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Badge Order', 'ovinx'),
        'section' => 'section_product_badges',
        'priority' => 1,
    ))
);

$wp_customize->add_setting(
    'badges_order_color',
    array(
        'default'           => themesflat_customize_default('badges_order_color'),
        'sanitize_callback' => 'esc_attr',
    )
);
$wp_customize->add_control( new themesflat_ColorOverlay(
        $wp_customize,
        'badges_order_color',
        array(
            'label'         => esc_html__('Color', 'ovinx'),
            'section'       => 'section_product_badges',
            'priority'      => 1,
            'active_callback' => function() use ( $wp_customize ) {
                return ( 
                    check_setting_is_on( 'badges_order' )
                );
            },
        )
    )
);

$wp_customize->add_setting(
    'badges_order_background_color',
    array(
        'default'           => themesflat_customize_default('badges_order_background_color'),
        'sanitize_callback' => 'esc_attr',
    )
);
$wp_customize->add_control( new themesflat_ColorOverlay(
        $wp_customize,
        'badges_order_background_color',
        array(
            'label'         => esc_html__('Background', 'ovinx'),
            'section'       => 'section_product_badges',
            'priority'      => 1,
            'active_callback' => function() use ( $wp_customize ) {
                return ( 
                    check_setting_is_on( 'badges_order' )
                );
            },
        )
    )
);