<?php

$wp_customize->add_setting(
    'tf_buyx_gety_title',
    array(
        'default'   => themesflat_customize_default('tf_buyx_gety_title'),
        'sanitize_callback' => 'esc_attr',
    )
);

$wp_customize->add_setting( 
    'tf_buyx_gety',
    array(
        'default' => themesflat_customize_default('tf_buyx_gety'),
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
    )   
);

$wp_customize->add_setting(
    'tf_buyx_gety_main_icon',
    array(
        'default'   => themesflat_customize_default('tf_buyx_gety_main_icon'),
        'sanitize_callback' => 'esc_attr',
    )
);

$wp_customize->add_setting(
    'tf_buyx_gety_free_icon',
    array(
        'default'   => themesflat_customize_default('tf_buyx_gety_free_icon'),
        'sanitize_callback' => 'esc_attr',
    )
);

$wp_customize->add_setting(
    'tf_buyx_gety_discount_icon',
    array(
        'default'   => themesflat_customize_default('tf_buyx_gety_discount_icon'),
        'sanitize_callback' => 'esc_attr',
    )
);

$wp_customize->add_setting(
    'tf_buyx_gety_main_text',
    array(
        'default'   => themesflat_customize_default('tf_buyx_gety_main_text'),
        'sanitize_callback' => 'esc_attr',
    )
);

$wp_customize->add_setting(
    'tf_buyx_gety_free_text',
    array(
        'default'   => themesflat_customize_default('tf_buyx_gety_free_text'),
        'sanitize_callback' => 'esc_attr',
    )
);

$wp_customize->add_setting(
    'tf_buyx_gety_discount_text',
    array(
        'default'   => themesflat_customize_default('tf_buyx_gety_discount_text'),
        'sanitize_callback' => 'esc_attr',
    )
);

$wp_customize->add_control( new themesflat_Info( $wp_customize,
    'tf_buyx_gety_title',
    array(
        'label' => esc_html__('Buy X Get Y', 'ovinx'),
        'section' => 'section_buyx_gety',
    ) )
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'tf_buyx_gety',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Enable ( OFF | ON )', 'ovinx'),
        'section' => 'section_buyx_gety',
    ) )
);

$wp_customize->add_control( new WP_Customize_Control( $wp_customize,
    'tf_buyx_gety_main_icon',
    array(
        'label' => esc_html__('Main icon class', 'ovinx'),
        'type' => 'text',
        'section' => 'section_buyx_gety',
        'active_callback' => fn() => check_setting_is_on( 'tf_buyx_gety' )
    ) )
);

$wp_customize->add_control( new WP_Customize_Control( $wp_customize,
    'tf_buyx_gety_free_icon',
    array(
        'label' => esc_html__('Free icon class', 'ovinx'),
        'type' => 'text',
        'section' => 'section_buyx_gety',
        'active_callback' => fn() => check_setting_is_on( 'tf_buyx_gety' )
    ) )
);

$wp_customize->add_control( new WP_Customize_Control( $wp_customize,
    'tf_buyx_gety_discount_icon',
    array(
        'label' => esc_html__('Discount icon class', 'ovinx'),
        'type' => 'text',
        'section' => 'section_buyx_gety',
        'active_callback' => fn() => check_setting_is_on( 'tf_buyx_gety' )
    ) )
);

$wp_customize->add_control( new WP_Customize_Control( $wp_customize,
    'tf_buyx_gety_main_text',
    array(
        'label' => esc_html__('Main text', 'ovinx'),
        'type' => 'text',
        'section' => 'section_buyx_gety',
        'active_callback' => fn() => check_setting_is_on( 'tf_buyx_gety' )
    ) )
);

$wp_customize->add_control( new WP_Customize_Control( $wp_customize,
    'tf_buyx_gety_free_text',
    array(
        'label' => esc_html__('Free text', 'ovinx'),
        'type' => 'text',
        'section' => 'section_buyx_gety',
        'active_callback' => fn() => check_setting_is_on( 'tf_buyx_gety' )
    ) )
);

$wp_customize->add_control( new WP_Customize_Control( $wp_customize,
    'tf_buyx_gety_discount_text',
    array(
        'label' => esc_html__('Discount text', 'ovinx'),
        'type' => 'text',
        'section' => 'section_buyx_gety',
        'active_callback' => fn() => check_setting_is_on( 'tf_buyx_gety' )
    ) )
);