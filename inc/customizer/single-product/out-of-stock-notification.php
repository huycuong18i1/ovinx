<?php

$wp_customize->add_setting(
    'tf_out_of_stock_notification_title',
    array(
        'default'   => themesflat_customize_default('tf_out_of_stock_notification_title'),
        'sanitize_callback' => 'esc_attr',
    )
);

$wp_customize->add_setting( 
    'tf_out_of_stock_notification',
    array(
        'default' => themesflat_customize_default('tf_out_of_stock_notification'),
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
    )   
);

$wp_customize->add_setting( 
    'tf_out_of_stock_notification_html',
    array(
        'default' => empty(themesflat_customize_default('tf_out_of_stock_notification_html')) ? '' : themesflat_customize_default('tf_out_of_stock_notification_html'),
        'sanitize_callback' => 'esc_attr',
    )   
);

$wp_customize->add_control( new themesflat_Info( $wp_customize,
    'tf_out_of_stock_notification_title',
    array(
        'label' => esc_html__('Out Of Stock Notification', 'ovinx'),
        'section' => 'section_out_of_stock_notification',
    ) )
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'tf_out_of_stock_notification',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Enable ( OFF | ON )', 'ovinx'),
        'section' => 'section_out_of_stock_notification',
    ) )
);

$wp_customize->add_control( new WP_Customize_Control( $wp_customize,
    'tf_out_of_stock_notification_html',
    array(
        'label' => esc_html__('HTML', 'ovinx'),
        'type' => 'textarea',
        'section' => 'section_out_of_stock_notification',
        'active_callback' => fn() => check_setting_is_on( 'tf_out_of_stock_notification' )
    ) )
);