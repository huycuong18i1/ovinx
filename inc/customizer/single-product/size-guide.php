<?php

$wp_customize->add_setting( 
    'tf_size_guide',
    array(
        'default' => themesflat_customize_default('tf_size_guide'),
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
    )   
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'tf_size_guide',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Enable ( OFF | ON )', 'ovinx'),
        'section' => 'section_size_guide',
    ) )
);