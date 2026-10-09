<?php 

$wp_customize->add_setting(
  'enable_login_fb',
    array(
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
        'default' => themesflat_customize_default('enable_login_fb'),     
    )   
);
$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'enable_login_fb',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Login Facebook ( OFF | ON )', 'ovinx'),
        'section' => 'section_login',
    ))
);
$wp_customize->add_setting(
    'facebook_login_client_id',
    array(
        'default' => themesflat_customize_default('facebook_login_client_id'),
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'facebook_login_client_id',
    array(
        'label' => esc_html__( 'Facebook login id', 'ovinx' ),
        'section' => 'section_login',
        'type' => 'text',
        'active_callback' => function() use ( $wp_customize ) {
            return ( 
                check_setting_is_on( 'enable_login_fb' )
            );
        },
    )
);

$wp_customize->add_setting(
    'facebook_login_client_secret',
    array(
        'default' => themesflat_customize_default('facebook_login_client_secret'),
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'facebook_login_client_secret',
    array(
        'label' => esc_html__( 'Facebook login secret', 'ovinx' ),
        'section' => 'section_login',
        'type' => 'text',
        'active_callback' => function() use ( $wp_customize ) {
            return ( 
                check_setting_is_on( 'enable_login_fb' )
            );
        },
    )
);

$wp_customize->add_setting(
  'enable_login_gg',
    array(
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
        'default' => themesflat_customize_default('enable_login_gg'),     
    )   
);
$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'enable_login_gg',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Login Google ( OFF | ON )', 'ovinx'),
        'section' => 'section_login',
    ))
);

$wp_customize->add_setting(
    'google_login_client_id',
    array(
        'default' => themesflat_customize_default('google_login_client_id'),
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'google_login_client_id',
    array(
        'label' => esc_html__( 'Google login id', 'ovinx' ),
        'section' => 'section_login',
        'type' => 'text',
        'active_callback' => function() use ( $wp_customize ) {
            return ( 
                check_setting_is_on( 'enable_login_gg' )
            );
        },
    )
);

$wp_customize->add_setting(
    'google_login_client_secret',
    array(
        'default' => themesflat_customize_default('google_login_client_secret'),
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'google_login_client_secret',
    array(
        'label' => esc_html__( 'Google login secret', 'ovinx' ),
        'section' => 'section_login',
        'type' => 'text',
        'active_callback' => function() use ( $wp_customize ) {
            return ( 
                check_setting_is_on( 'enable_login_gg' )
            );
        },
    )
);
