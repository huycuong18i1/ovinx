<?php
$wp_customize->add_setting(
    'recently_display',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('recently_display'),     
      )   
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'recently_display',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Recently Product', 'ovinx'),
        'section' => 'section_product_recently',
    ))
);


$wp_customize->add_setting (
    'recently_heading',
    array(
        'default' => themesflat_customize_default('recently_heading'),
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'recently_heading',
    array(
        'type'      => 'textarea',
        'label'     => esc_html__('Heading Recently', 'ovinx'),
        'section'   => 'section_product_recently',
        'active_callback' => function() use ( $wp_customize ) {
            return ( 
                check_setting_is_on( 'recently_display' )
            );
        },
    )
);

$wp_customize->add_setting (
    'recently_limit',
    array(
        'default' => themesflat_customize_default('recently_limit'),
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'recently_limit',
    array(
        'type'      => 'text',
        'label'     => esc_html__('Limit Product', 'ovinx'),
        'section'   => 'section_product_recently',
        'active_callback' => function() use ( $wp_customize ) {
            return ( 
                check_setting_is_on( 'recently_display' )
            );
        },
    )
);

$wp_customize->add_setting( 'recently_product_columns', array(
	'default'           => themesflat_customize_default('recently_product_columns'),
	'sanitize_callback' => 'themesflat_sanitize_responsive_columns',
) );

$wp_customize->add_control( new themesflat_ResponsiveColumnsSwitch( $wp_customize, 'recently_product_columns', array(
	'label'    => __( 'Columns', 'ovinx' ),
	'section'  => 'section_product_recently',
	'settings' => 'recently_product_columns',
    'active_callback' => function() use ( $wp_customize ) {
        return ( 
            check_setting_is_on( 'recently_display' )
        );
    },
) ) );