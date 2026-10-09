<?php

$wp_customize->add_setting(
    'tf_volume_discount_title',
    array(
        'default'   => themesflat_customize_default('tf_volume_discount_title'),
        'sanitize_callback' => 'esc_attr',
    )
);

$wp_customize->add_setting( 
    'tf_volume_discount',
    array(
        'default' => themesflat_customize_default('tf_volume_discount'),
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
    )   
);

$wp_customize->add_control( new themesflat_Info( $wp_customize,
    'tf_volume_discount_title',
    array(
        'label' => esc_html__('Volume Discount', 'ovinx'),
        'section' => 'section_volume_discount',
    ) )
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'tf_volume_discount',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Enable ( OFF | ON )', 'ovinx'),
        'section' => 'section_volume_discount',
    ) )
);