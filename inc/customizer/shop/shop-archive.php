<?php 
//Sidebar Position
$wp_customize->add_setting(
    'shop_layout',
    array(
        'default'           => themesflat_customize_default('shop_layout'),
        'sanitize_callback' => 'esc_attr',
    )
);
$wp_customize->add_control( 
    'shop_layout',
    array (
        'type'      => 'select',           
        'section'   => 'section_shop_archive',
        'priority'  => 1,
        'label'         => esc_html__('Sidebar Position', 'ovinx'),
        'choices'   => array (
            'sidebar-right'     => esc_html__( 'Sidebar Right','ovinx' ),
            'sidebar-left'      =>  esc_html__( 'Sidebar Left','ovinx' ),
            'fullwidth'         =>   esc_html__( 'Full Width','ovinx' ),
        ),
    )
);

$wp_customize->add_setting( 
    'filter_sticky',
    array(
        'default' => themesflat_customize_default('filter_sticky'),
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
    )   
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'filter_sticky',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Filter Sticky', 'ovinx'),
        'section' => 'section_shop_archive',
        'active_callback' => fn() => check_setting_is_on( 'shop_layout', 'sidebar-right' ) || check_setting_is_on( 'shop_layout', 'sidebar-left' ) || check_setting_is_on( 'shop_layout', 'fullwidth' )
    ) )
);

$wp_customize->add_setting( 
    'filter_sidebar_button',
    array(
        'default' => themesflat_customize_default('filter_sidebar_button'),
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
    )   
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'filter_sidebar_button',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Show Apply Filter Button', 'ovinx'),
        'section' => 'section_shop_archive',
        'active_callback' => fn() => check_setting_is_on( 'shop_layout', 'fullwidth' )
    ) )
);

$wp_customize->add_setting (
    'shop_products_per_page',
    array(
        'default' => themesflat_customize_default('shop_products_per_page'),
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);

$wp_customize->add_control(
    'shop_products_per_page',
    array(
        'type'      => 'text',
        'label'     => esc_html__('Product Per Page', 'ovinx'),
        'section'   => 'section_shop_archive',       
    )
);


$wp_customize->add_setting(
    'shop_pagination',
    array(
        'default'           => themesflat_customize_default('shop_pagination'),
        'sanitize_callback' => 'esc_attr',
    )
);

$wp_customize->add_control( 
    'shop_pagination',
    array (
        'type'      => 'select',           
        'section'   => 'section_shop_archive',
        'label'         => esc_html__('Pagination', 'ovinx'),
        'choices'   => array (
            'number'     => esc_html__( 'Number','ovinx' ),
            'loadmore'      =>  esc_html__( 'Load More','ovinx' ),
            'autoload'      =>  esc_html__( 'Auto Load','ovinx' ),
        ),

    )
);

$wp_customize->add_setting(
    'pagination_ajax',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('pagination_ajax'),     
      )   
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'pagination_ajax',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Pagination Link Ajax', 'ovinx'),
        'section' => 'section_shop_archive',
        'active_callback' => function() use ( $wp_customize ) {
            return ( 
                'number' == $wp_customize->get_setting( 'shop_pagination' )->value()
            );
          },
    ))
);


$wp_customize->add_setting(
    'shop_loadmore_text',
      array(
          'sanitize_callback' => 'themesflat_sanitize_text',
          'default' => themesflat_customize_default('shop_loadmore_text'),     
      )   
);

$wp_customize->add_control( 
      'shop_loadmore_text',
      array(
          'type' => 'text',
          'label' => esc_html__('Load More Text', 'ovinx'),
          'section' => 'section_shop_archive',
          'active_callback' => function() use ( $wp_customize ) {
            return ( 
                'loadmore' == $wp_customize->get_setting( 'shop_pagination' )->value()
            );
          },
      )
);