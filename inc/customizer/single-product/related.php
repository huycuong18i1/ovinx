<?php
$wp_customize->add_setting(
    'related_display',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('related_display'),     
      )   
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'related_display',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Related Product', 'ovinx'),
        'section' => 'section_product_related',
    ))
);


$wp_customize->add_setting (
    'related_heading',
    array(
        'default' => themesflat_customize_default('related_heading'),
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'related_heading',
    array(
        'type'      => 'textarea',
        'label'     => esc_html__('Heading Related', 'ovinx'),
        'section'   => 'section_product_related',
        'active_callback' => function() use ( $wp_customize ) {
            return ( 
                check_setting_is_on( 'related_display' )
            );
        },
    )
);

$wp_customize->add_setting (
    'related_limit',
    array(
        'default' => themesflat_customize_default('related_limit'),
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'related_limit',
    array(
        'type'      => 'text',
        'label'     => esc_html__('Limit Product', 'ovinx'),
        'section'   => 'section_product_related',
        'active_callback' => function() use ( $wp_customize ) {
            return ( 
                check_setting_is_on( 'related_display' )
            );
        },
    )
);


$wp_customize->add_setting( 'related_product_columns', array(
	'default'           => themesflat_customize_default('related_product_columns'),
	'sanitize_callback' => 'themesflat_sanitize_responsive_columns',
) );

$wp_customize->add_control( new themesflat_ResponsiveColumnsSwitch( $wp_customize, 'related_product_columns', array(
	'label'    => __( 'Columns', 'ovinx' ),
	'section'  => 'section_product_related',
	'settings' => 'related_product_columns',
    'active_callback' => function() use ( $wp_customize ) {
        return ( 
            check_setting_is_on( 'related_display' )
        );
    },
) ) );