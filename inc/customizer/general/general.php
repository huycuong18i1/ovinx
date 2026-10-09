
<?php
// Enable Smooth Scroll
$wp_customize->add_setting(
  'enable_smooth_scroll',
    array(
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
        'default' => themesflat_customize_default('enable_smooth_scroll'),     
    )   
);
$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'enable_smooth_scroll',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Smooth Scroll ( OFF | ON )', 'ovinx'),
        'section' => 'section_general',
        'priority' => 1,
    ))
);

// Enable Preload
$wp_customize->add_setting(
  'enable_preload',
    array(
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
        'default' => themesflat_customize_default('enable_preload'),     
    )   
);
$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'enable_preload',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Preload ( OFF | ON )', 'ovinx'),
        'section' => 'section_general',
        'priority' => 2,
    ))
);

//Socials
$wp_customize->add_setting(
  'social_links',
  array(
    'sanitize_callback' => 'esc_attr',
    'default' => themesflat_customize_default('social_links'),     
  )   
);
$wp_customize->add_control( new themesflat_SocialIcons($wp_customize,
    'social_links',
    array(
        'type' => 'social-icons',
        'section' => 'section_general',
        'priority' => 4,
    ))
);

// Social Share
$wp_customize->add_setting(
  'show_social_share',
    array(
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
        'default' => themesflat_customize_default('show_social_share'),     
    )   
);
$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'show_social_share',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Social Share  ( OFF | ON )', 'ovinx'),
        'description'   => esc_html__('Social share only visible on detail pages', 'ovinx'),
        'section' => 'section_general',
        'priority' => 6,
    ))
);

// Go Top Button
$wp_customize->add_setting(
  'go_top',
    array(
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
        'default' => themesflat_customize_default('go_top'),     
    )   
);
$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'go_top',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Go Top Button ( OFF | ON )', 'ovinx'),
        'section' => 'section_general',
        'priority' => 8,
    ))
);