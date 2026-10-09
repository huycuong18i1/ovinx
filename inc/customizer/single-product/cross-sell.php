<?php
$wp_customize->add_setting(
    'cross_sell_display',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('cross_sell_display'),     
      )   
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'cross_sell_display',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Cross Sell Product', 'ovinx'),
        'section' => 'section_cross_sell',
    ))
);


$wp_customize->add_setting (
    'cross_sell_heading',
    array(
        'default' => themesflat_customize_default('cross_sell_heading'),
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'cross_sell_heading',
    array(
        'type'      => 'textarea',
        'label'     => esc_html__('Heading Cross Sell', 'ovinx'),
        'section'   => 'section_cross_sell',
        'active_callback' => function() use ( $wp_customize ) {
            return ( 
                check_setting_is_on( 'cross_sell_display' )
            );
        },
    )
);


$wp_customize->add_setting( 'cross_sell_product_columns', array(
	'default'           => themesflat_customize_default('cross_sell_product_columns'),
	'sanitize_callback' => 'themesflat_sanitize_responsive_columns',
) );

$wp_customize->add_control( new themesflat_ResponsiveColumnsSwitch( $wp_customize, 'cross_sell_product_columns', array(
	'label'    => __( 'Columns', 'ovinx' ),
	'section'  => 'section_cross_sell',
	'settings' => 'cross_sell_product_columns',
    'active_callback' => function() use ( $wp_customize ) {
        return ( 
            check_setting_is_on( 'cross_sell_display' )
        );
    },
) ) );