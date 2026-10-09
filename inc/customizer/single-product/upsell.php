<?php
$wp_customize->add_setting(
    'upsell_display',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('upsell_display'),     
      )   
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'upsell_display',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Upsell Product', 'ovinx'),
        'section' => 'section_product_upsell',
    ))
);


$wp_customize->add_setting (
    'upsell_heading',
    array(
        'default' => themesflat_customize_default('upsell_heading'),
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'upsell_heading',
    array(
        'type'      => 'textarea',
        'label'     => esc_html__('Heading Upsell', 'ovinx'),
        'section'   => 'section_product_upsell',
        'active_callback' => function() use ( $wp_customize ) {
            return ( 
                check_setting_is_on( 'upsell_display' )
            );
        },
    )
);


$wp_customize->add_setting( 'upsell_product_columns', array(
	'default'           => themesflat_customize_default('upsell_product_columns'),
	'sanitize_callback' => 'themesflat_sanitize_responsive_columns',
) );

$wp_customize->add_control( new themesflat_ResponsiveColumnsSwitch( $wp_customize, 'upsell_product_columns', array(
	'label'    => __( 'Columns', 'ovinx' ),
	'section'  => 'section_product_upsell',
	'settings' => 'upsell_product_columns',
    'active_callback' => function() use ( $wp_customize ) {
        return ( 
            check_setting_is_on( 'upsell_display' )
        );
    },
) ) );