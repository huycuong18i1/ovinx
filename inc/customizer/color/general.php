<?php 
$wp_customize->add_setting(
    'primary_color',
    array(
        'default'           => themesflat_customize_default('primary_color'),
        'sanitize_callback' => 'sanitize_hex_color',
    )
);
$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'primary_color',
        array(
            'label'         => esc_html__('Primary Color', 'ovinx'),
            'section'       => 'color_general',
            'settings'      => 'primary_color',
            'priority'      => 3
        )
    )
);

