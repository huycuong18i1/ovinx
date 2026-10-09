<?php

$wp_customize->add_setting(
    'tf_buy_together_title',
    array(
        'default'   => themesflat_customize_default('tf_buy_together_title'),
        'sanitize_callback' => 'esc_attr',
    )
);

$wp_customize->add_setting( 
    'tf_buy_together',
    array(
        'default' => themesflat_customize_default('tf_buy_together'),
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
    )   
);

$wp_customize->add_setting( 
    'tf_buy_together_position',
    array(
        'default' => themesflat_customize_default('tf_buy_together_position'),
        'sanitize_callback' => 'esc_attr',
    )   
);

$wp_customize->add_setting( 
    'tf_buy_together_check_all',
    array(
        'default' => themesflat_customize_default('tf_buy_together_check_all'),
        'sanitize_callback' => 'esc_attr',
    )   
);

$wp_customize->add_control( new themesflat_Info( $wp_customize,
    'tf_buy_together_title',
    array(
        'label' => esc_html__('Buy Together', 'ovinx'),
        'section' => 'section_buy_together',
    ) )
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'tf_buy_together',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Enable ( OFF | ON )', 'ovinx'),
        'section' => 'section_buy_together',
    ) )
);

$wp_customize->add_control( new WP_Customize_Control( $wp_customize,
    'tf_buy_together_position',
    array(
        'label' => esc_html__('Position', 'ovinx'),
        'type' => 'select',
        'choices' => array(
            'left' => esc_html__( 'Left' , 'ovinx' ),
            'right' => esc_html__( 'Right', 'ovinx' ),
        ),
        'section' => 'section_buy_together',
        'active_callback' => fn() => check_setting_is_on( 'tf_buy_together' )
    ) )
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'tf_buy_together_check_all',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Check All', 'ovinx'),
        'section' => 'section_buy_together',
        'active_callback' => fn() => check_setting_is_on( 'tf_buy_together' )
    ) )
);