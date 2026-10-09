<?php
$wp_customize->add_setting(
    'recently_wl_display',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('recently_wl_display'),     
      )   
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'recently_wl_display',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Recently Product', 'ovinx'),
        'section' => 'wcboost_wishlist_page',
    ))
);


$wp_customize->add_setting (
    'recently_wl_heading',
    array(
        'default' => themesflat_customize_default('recently_wl_heading'),
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'recently_wl_heading',
    array(
        'type'      => 'textarea',
        'label'     => esc_html__('Heading Recently', 'ovinx'),
        'section'   => 'wcboost_wishlist_page',
        'active_callback' => function() use ( $wp_customize ) {
            return ( 
                check_setting_is_on( 'recently_wl_display' )
            );
        },
    )
);

$wp_customize->add_setting (
    'recently_wl_limit',
    array(
        'default' => themesflat_customize_default('recently_wl_limit'),
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'recently_wl_limit',
    array(
        'type'      => 'text',
        'label'     => esc_html__('Limit Product', 'ovinx'),
        'section'   => 'wcboost_wishlist_page',
        'active_callback' => function() use ( $wp_customize ) {
            return ( 
                check_setting_is_on( 'recently_wl_display' )
            );
        },
    )
);

$wp_customize->add_setting( 'recently_wl_product_columns', array(
	'default'           => themesflat_customize_default('recently_wl_product_columns'),
	'sanitize_callback' => 'themesflat_sanitize_responsive_columns',
) );

$wp_customize->add_control( new themesflat_ResponsiveColumnsSwitch( $wp_customize, 'recently_wl_product_columns', array(
	'label'    => __( 'Columns', 'ovinx' ),
	'section'  => 'wcboost_wishlist_page',
	'settings' => 'recently_wl_product_columns',
    'active_callback' => function() use ( $wp_customize ) {
        return ( 
            check_setting_is_on( 'recently_wl_display' )
        );
    },
) ) );