<?php 
// Top bar show
$wp_customize->add_setting( 
  'topbar_show',
    array(
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
        'default' => themesflat_customize_default('topbar_show'),     
    )   
);
$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'topbar_show',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Enable Top Bar', 'ovinx'),
        'section' => 'section_topbar',
        'priority' => 1,
    ))
); 


$wp_customize->add_setting('topbar_items_left', array(
    'default' => themesflat_customize_default('topbar_items_left'),
    'sanitize_callback' => 'ovinx_sanitize_array',
));

$wp_customize->add_control( new Themesflat_Repeater_Select( $wp_customize, 'topbar_items_left', array(
    'label'    => esc_html__('Left Section Content', 'ovinx'),
    'section'  => 'section_topbar',
    'priority'  => 3,
    'choices'  => array(
        'currency'    => __('Currency', 'ovinx'),
        'language'    => __('Language', 'ovinx'),
        'social'    => __('Social', 'ovinx'),
    ),
                'active_callback' => function() use ( $wp_customize ) {
                return ( 
                    check_setting_is_on( 'topbar_show' )
                );
           },
)));

$wp_customize->add_setting('topbar_items_center', array(
    'default' => themesflat_customize_default('topbar_items_center'),
    'sanitize_callback' => 'ovinx_sanitize_array',
));

$wp_customize->add_control( new Themesflat_Repeater_Select( $wp_customize, 'topbar_items_center', array(
    'label'    => esc_html__('Center Section Content', 'ovinx'),
    'section'  => 'section_topbar',
    'priority'  => 5,
    'choices'  => array(
        'currency'    => __('Currency', 'ovinx'),
        'language'    => __('Language', 'ovinx'),
        'social'    => __('Social', 'ovinx'),
        'text-slider'    => __('Text Slider', 'ovinx'),
    ),
                'active_callback' => function() use ( $wp_customize ) {
                return ( 
                    check_setting_is_on( 'topbar_show' )
                );
           },
)));

$wp_customize->add_setting('topbar_items_right', array(
    'default' => themesflat_customize_default('topbar_items_right'),
    'sanitize_callback' => 'ovinx_sanitize_array',
));

$wp_customize->add_control( new Themesflat_Repeater_Select( $wp_customize, 'topbar_items_right', array(
    'label'    => esc_html__('Right Section Content', 'ovinx'),
    'section'  => 'section_topbar',
    'priority'  => 7,
    'choices'  => array(
        'currency'    => __('Currency', 'ovinx'),
        'language'    => __('Language', 'ovinx'),
        'social'    => __('Social', 'ovinx'),
    ),
                'active_callback' => function() use ( $wp_customize ) {
                return ( 
                    check_setting_is_on( 'topbar_show' )
                );
           },
)));

$wp_customize->add_setting('themesflat_options[info]', array(
        'type'              => 'info_control',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'esc_attr',            
    )
);
$wp_customize->add_control( new themesflat_Info( $wp_customize, 'topbar_information', array(
    'label' => esc_html__('Top Bar Elements', 'ovinx'),
    'section'  => 'section_topbar',
    'settings' => 'themesflat_options[info]',
    'priority' => 8,
                'active_callback' => function() use ( $wp_customize ) {
                return ( 
                    check_setting_is_on( 'topbar_show' )
                );
           },
    ) )
);

$wp_customize->add_setting(
    'information_phone',
    array(
        'default' => themesflat_customize_default('information_phone'),
        'sanitize_callback' => 'ovinx_sanitize_array',
    )
);
$wp_customize->add_control(
    'information_phone',
    array(
        'label' => esc_html__( 'Contact Phone', 'ovinx' ),
        'section' => 'section_topbar',
        'type' => 'text',
        'priority' => 9,
                    'active_callback' => function() use ( $wp_customize ) {
                return ( 
                    check_setting_is_on( 'topbar_show' )
                );
           },
    )
);

$wp_customize->add_setting('information_slides_arr', array(
    'default' => themesflat_customize_default('information_slides_arr'),
    'sanitize_callback' => 'ovinx_sanitize_array',
));

$wp_customize->add_control(new Themesflat_Repeater_Controls($wp_customize, 'information_slides_arr', array(
    'label'   => __('Announcement Slider Items', 'ovinx'),
    'section' => 'section_topbar',
    'priority' => 15,
                    'active_callback' => function() use ( $wp_customize ) {
                return ( 
                    check_setting_is_on( 'topbar_show' )
                );
           },
)));