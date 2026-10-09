<?php 
$wp_customize->add_setting('themesflat_options[info]', array(
        'type'              => 'info_control',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'esc_attr',            
    )
);
$wp_customize->add_control( new themesflat_Info( $wp_customize, 'page-title-style', array(
    'label' => esc_html__('Page Title Style', 'ovinx'),
    'section' => 'section_page_title',
    'settings' => 'themesflat_options[info]',
    'priority' => 1
    ) )
);

// Page title heading
$wp_customize->add_setting(
  'page_title_heading_enabled',
    array(
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
        'default' => themesflat_customize_default('page_title_heading_enabled'),     
    )   
);
$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'page_title_heading_enabled',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Heading ( OFF | ON )', 'ovinx'),
        'section' => 'section_page_title',
        'priority' => 2,
    ))
);

$wp_customize->add_setting(
'page_title_description',
    array(
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
        'default' => themesflat_customize_default('page_title_description'),     
    )   
);
$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'page_title_description',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Description', 'ovinx'),
                            'section'   => 'section_page_title',
        'priority'  => 3,
    ))
);

$wp_customize->add_setting (
    'page_title_description_content',
    array(
        'default' => themesflat_customize_default('page_title_description_content') ,
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'page_title_description_content',
    array(
        'type'      => 'text',
        'label'     => esc_html__('Content Description', 'ovinx'),
                            'section'   => 'section_page_title',
        'priority'  => 3,
                  'active_callback' => function() use ( $wp_customize ) {
                return ( 
                    check_setting_is_on( 'page_title_description' )
                );
           },
    )
);

$wp_customize->add_setting (
    'page_title_alignment',
    array(
        'default' => themesflat_customize_default('page_title_alignment'),
        'sanitize_callback' => 'esc_attr',
    )
);
$wp_customize->add_control(
    'page_title_alignment',
    array(
        'type'      => 'select',
        'label'     => esc_html__('Alignment', 'ovinx'),
        'section'   => 'section_page_title',
        'priority'  => 4,
        'choices'   => array(
            'left'   => esc_html__('Left', 'ovinx'),
            'center' => esc_html__('Center', 'ovinx'),
            'right'  => esc_html__('Right', 'ovinx'),
        ),
    )
);

$wp_customize->add_setting(
    'page_title_count',
    array(
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
        'default' => themesflat_customize_default('page_title_count'),
    )
);
$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'page_title_count',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Show Post Count (archives)', 'ovinx'),
        'section' => 'section_page_title',
        'priority' => 5,
    ))
);

// Box control
$wp_customize->add_setting(
    'page_title_controls',
    array(
        'default' => themesflat_customize_default('page_title_controls'),
        'sanitize_callback' => 'themesflat_sanitize_text',
    )
);
$wp_customize->add_control( new themesflat_BoxControls($wp_customize,
    'page_title_controls',
    array(
        'label' => esc_html__( 'Page Title Controls (px)', 'ovinx' ),
        'section' => 'section_page_title',
        'type' => 'box-controls',
        'priority' => 7
    ))
);  