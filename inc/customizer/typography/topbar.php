<?php 

$wp_customize->add_setting('themesflat_options[info]', array(
        'type'              => 'info_control',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'esc_attr',            
    )
);
$wp_customize->add_control( new themesflat_Info( $wp_customize, 'top-bar-style', array(
    'label' => esc_html__('Typography & Colors', 'ovinx'),
    'section' => 'section_typo_topbar',
    'settings' => 'themesflat_options[info]',
    'priority' => 1
    ) )
);

// Topbar fonts
$wp_customize->add_setting(
    'typography_topbar',
    array(
        'default' => themesflat_customize_default('typography_topbar'),
        'sanitize_callback' => 'esc_html',
    )
);
$wp_customize->add_control( new themesflat_Typography($wp_customize,
    'typography_topbar',
    array(
        'label' => esc_html__( 'Text Typography', 'ovinx' ),
        'section' => 'section_typo_topbar',
        'type' => 'typography',
        'fields' => array('family','style','line_height','size','letter_spacing'),
        'priority' => 1
    ))
);

$wp_customize->add_setting(
    'topbar_background_color',
    array(
        'default'           => themesflat_customize_default('topbar_background_color'),
        'sanitize_callback' => 'esc_attr',
    )
);
$wp_customize->add_control( new themesflat_ColorOverlay(
        $wp_customize,
        'topbar_background_color',
        array(
            'label'         => esc_html__('Background', 'ovinx'),
            'section' => 'section_typo_topbar',
            'priority'      => 2
        )
    )
);

$wp_customize->add_setting(
    'topbar_textcolor',
    array(
        'default'           => themesflat_customize_default('topbar_textcolor'),
        'sanitize_callback' => 'esc_attr',
    )
);
$wp_customize->add_control( new themesflat_ColorOverlay(
        $wp_customize,
        'topbar_textcolor',
        array(
            'label'         => esc_html__('Text Color', 'ovinx'),
            'section' => 'section_typo_topbar',
            'priority'      => 3
        )
    )
);
