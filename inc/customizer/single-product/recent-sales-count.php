<?php

$wp_customize->add_setting(
    'recent_sales_count',
    array(
        'default'   => themesflat_customize_default('recent_sales_title'),
        'sanitize_callback' => 'esc_attr',
    )
);

$wp_customize->add_setting( 
    'fake_sold',
    array(
        'default' => themesflat_customize_default('fake_sold'),
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
    )   
);

$wp_customize->add_setting( 
    'fake_sold_random_from',
    array(
        'default' => themesflat_customize_default('fake_sold_random_from'),
        'sanitize_callback' => 'esc_attr',
    )   
);

$wp_customize->add_setting( 
    'fake_sold_random_to',
    array(
        'default' => themesflat_customize_default('fake_sold_random_to'),
        'sanitize_callback' => 'esc_attr',
    )   
);

$wp_customize->add_setting( 
    'fake_sold_increment_max',
    array(
        'default' => themesflat_customize_default('fake_sold_increment_max'),
        'sanitize_callback' => 'esc_attr',
    ) 
);

$wp_customize->add_setting( 
    'fake_sold_interval',
    array(
        'default' => themesflat_customize_default('fake_sold_interval'),
        'sanitize_callback' => 'esc_attr',
    )
);

$wp_customize->add_setting( 
    'fake_sold_text',
    array(
        'default' => themesflat_customize_default('fake_sold_text'),
        'sanitize_callback' => 'esc_attr',
    )   
); 

$wp_customize->add_control( new themesflat_Info( $wp_customize,
    'recent_sales_count',
    array(
        'label' => esc_html__('Recent Sales Count', 'ovinx'),
        'section' => 'section_recent_sales_count',
    ) )
);


$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'fake_sold',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Enable ( OFF | ON )', 'ovinx'),
        'section' => 'section_recent_sales_count',
    ))
);

$wp_customize->add_control( new WP_Customize_Control( $wp_customize,
    'fake_sold_random_from',
    array(
        'label' => esc_html__('Random from', 'ovinx'),
        'type' => 'number',
        'input_attrs' => array(
            'min' => 1,
        ),
        'section' => 'section_recent_sales_count',
        'active_callback' => fn() => check_setting_is_on( 'fake_sold' )
    ) )
);

$wp_customize->add_control( new WP_Customize_Control( $wp_customize,
    'fake_sold_random_to',
    array(
        'label' => esc_html__('Random to', 'ovinx'),
        'type' => 'number',
        'input_attrs' => array(
            'min' => 1,
        ),
        'section' => 'section_recent_sales_count',
        'active_callback' => fn() => check_setting_is_on( 'fake_sold' )
    ) )
);

$wp_customize->add_control( new WP_Customize_Control( $wp_customize,
    'fake_sold_increment_max',
    array(
        'label' => esc_html__('Increment', 'ovinx'),
        'type' => 'number',
        'input_attrs' => array(
            'min' => 1,
        ),
        'section' => 'section_recent_sales_count',
        'active_callback' => fn() => check_setting_is_on( 'fake_sold' )
    ) )
);

$wp_customize->add_control( new WP_Customize_Control( $wp_customize,
    'fake_sold_interval',
    array(
        'label' => esc_html__('Interval(minutes)', 'ovinx'),
        'type' => 'number',
        'input_attrs' => array(
            'min' => 1,
        ),
        'section' => 'section_recent_sales_count',
        'active_callback' => fn() => check_setting_is_on( 'fake_sold' )
    ) )
);

$wp_customize->add_control( new WP_Customize_Control( $wp_customize,
    'fake_sold_text',
    array(
        'label' => esc_html__('Text', 'ovinx'),
        'type' => 'text',
        'section' => 'section_recent_sales_count',
        'active_callback' => fn() => check_setting_is_on( 'fake_sold' )
    ) )
);