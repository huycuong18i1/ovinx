<?php

$wp_customize->add_setting( 
    'tf_wishlist_pos',
    array(
        'default' => themesflat_customize_default('tf_wishlist_pos'),
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
    )   
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'tf_wishlist_pos',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Button position by theme', 'ovinx'),
        'section' => 'wcboost_wishlist_button',
    ) )
);