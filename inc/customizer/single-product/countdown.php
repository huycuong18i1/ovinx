<?php

$wp_customize->add_setting(
    'tf_countdown_title',
    array(
        'default'   => themesflat_customize_default('tf_countdown_title'),
        'sanitize_callback' => 'esc_attr',
    )
);

$wp_customize->add_setting( 
    'tf_countdown',
    array(
        'default' => themesflat_customize_default('tf_countdown'),
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
    )   
);

$wp_customize->add_setting( 
    'tf_countdown_text',
    array(
        'default' => themesflat_customize_default('tf_countdown_text'),
        'sanitize_callback' => 'esc_attr',
    )   
);

$wp_customize->add_setting(
    'tf_countdown_subtext',
    array(
        'default' => themesflat_customize_default('tf_countdown_subtext'),
        'sanitize_callback' => 'esc_attr',
    )   
);

$wp_customize->add_control( new themesflat_Info( $wp_customize,
    'tf_countdown_title',
    array(
        'label' => esc_html__('Countdown', 'ovinx'),
        'section' => 'section_countdown',
    ) )
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'tf_countdown',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Enable ( OFF | ON )', 'ovinx'),
        'section' => 'section_countdown',
    ) )
);

$wp_customize->add_control( new WP_Customize_Control( $wp_customize,
    'tf_countdown_text',
    array(
        'label' => esc_html__('Text', 'ovinx'),
        'type' => 'text',
        'section' => 'section_countdown',
        'active_callback' => fn() => check_setting_is_on( 'tf_countdown' )
    ) )
);

$wp_customize->add_control( new WP_Customize_Control( $wp_customize,
    'tf_countdown_subtext',
    array(
        'label' => esc_html__('Sub Text', 'ovinx'),
        'type' => 'text',
        'section' => 'section_countdown',
        'active_callback' => fn() => check_setting_is_on( 'tf_countdown' )
    ) )
);