<?php 
$wp_customize->add_setting(
    'catalog_toolbar',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('catalog_toolbar'),     
      )   
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'catalog_toolbar',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Show Catalog Toolbar', 'ovinx'),
        'section' => 'section_shop_catalog',
    ))
);



$wp_customize->add_setting('catalog_btn_change', array(
    'default' => themesflat_customize_default('catalog_btn_change'),  
    'sanitize_callback' => 'absint', 
));

$wp_customize->add_control('catalog_btn_change', array(
    'label'    => __('Show Catalog Button Filter', 'ovinx'),
    'section'  => 'section_shop_catalog',
    'type'     => 'checkbox', 
    'active_callback' => function() use ( $wp_customize ) {
        return ( 
            check_setting_is_on( 'catalog_toolbar' )
        );
    },
));

$wp_customize->add_setting('catalog_sort_by', array(
    'default' => themesflat_customize_default('catalog_sort_by'),  
    'sanitize_callback' => 'absint', 
));

$wp_customize->add_control('catalog_sort_by', array(
    'label'    => __('Show Catalog Sort By', 'ovinx'),
    'section'  => 'section_shop_catalog',
    'type'     => 'checkbox', 
    'active_callback' => function() use ( $wp_customize ) {
        return ( 
            check_setting_is_on( 'catalog_toolbar' )
        );
    },
));

$wp_customize->add_setting('catalog_view', array(
    'default' => themesflat_customize_default('catalog_view'),  
    'sanitize_callback' => 'absint', 
));

$wp_customize->add_control('catalog_view', array(
    'label'    => __('Show Catalog View', 'ovinx'),
    'section'  => 'section_shop_catalog',
    'type'     => 'checkbox', 
    'active_callback' => function() use ( $wp_customize ) {
        return ( 
            check_setting_is_on( 'catalog_toolbar' )
        );
    },
));

$wp_customize->add_setting (
    'number_view',
    array(
        'default' => themesflat_customize_default('number_view'),
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'number_view',
    array(
        'type'      => 'select',
        'label'     => esc_html__('Number Of Column View', 'ovinx'),
        'section'   => 'section_shop_catalog',
        'description'   => esc_html__('Highest grid-switch button shown (2 to 4 columns — there are no icons/breakpoints beyond 4).', 'ovinx'),
        'choices'   => array(
            '2' => esc_html__( '2', 'ovinx' ),
            '3' => esc_html__( '3', 'ovinx' ),
            '4' => esc_html__( '4', 'ovinx' ),
        ),
        'active_callback' => function() use ( $wp_customize ) {
            return ( 
                check_setting_is_on( 'catalog_view' )
                && 
                check_setting_is_on( 'catalog_toolbar' )
            );
        },
    )
);

$wp_customize->add_setting (
    'number_view_active',
    array(
        'default' => themesflat_customize_default('number_view_active'),
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'number_view_active',
    array(
        'type'      => 'text',
        'label'     => esc_html__('Number Active View', 'ovinx'),
        'section'   => 'section_shop_catalog',
        'active_callback' => function() use ( $wp_customize ) {
            return ( 
                check_setting_is_on( 'catalog_view' )
                && 
                check_setting_is_on( 'catalog_toolbar' )
            );
        },
    )
);