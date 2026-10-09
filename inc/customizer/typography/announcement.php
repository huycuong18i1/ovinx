<?php
$wp_customize->add_setting('themesflat_options[info]', array(
        'type'              => 'info_control',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'esc_attr',            
    )
);
$wp_customize->add_control( new themesflat_Info( $wp_customize, 'announcement-style', array(
    'label' => esc_html__('Typography & Colors', 'ovinx'),
    'section' => 'section_typo_announcement',
    'settings' => 'themesflat_options[info]',
    'priority' => 6
    ) )
);

// Topbar fonts
$wp_customize->add_setting(
    'typography_promo',
    array(
        'default' => themesflat_customize_default('typography_promo'),
        'sanitize_callback' => 'esc_html',
    )
);
$wp_customize->add_control( new themesflat_Typography($wp_customize,
    'typography_promo',
    array(
        'label' => esc_html__( 'Text Typography', 'ovinx' ),
        'section' => 'section_typo_announcement',
        'type' => 'typography',
        'fields' => array('family','style','line_height','size','letter_spacing'),
        'priority' => 7
    ))
);

$wp_customize->add_setting(
    'promo_background_color',
    array(
        'default'           => themesflat_customize_default('promo_background_color'),
        'sanitize_callback' => 'esc_attr',
    )
);
$wp_customize->add_control( new themesflat_ColorOverlay(
        $wp_customize,
        'promo_background_color',
        array(
            'label'         => esc_html__('Background Color', 'ovinx'),
            'section' => 'section_typo_announcement',
            'priority'      => 8
        )
    )
);

$wp_customize->add_setting(
    'promo_textcolor',
    array(
        'default'           => themesflat_customize_default('promo_textcolor'),
        'sanitize_callback' => 'esc_attr',
    )
);
$wp_customize->add_control( new themesflat_ColorOverlay(
        $wp_customize,
        'promo_textcolor',
        array(
            'label'         => esc_html__('Text Color', 'ovinx'),
            'section' => 'section_typo_announcement',
            'priority'      => 9
        )
    )
);


