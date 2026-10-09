<?php
$wp_customize->add_setting(
'tf_cookies',
    array(
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
        'default' => themesflat_customize_default('tf_cookies'),     
    )   
);
$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'tf_cookies',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Cookies', 'ovinx'),
        'section' => 'section_cookies',
    ))
);

$wp_customize->add_setting (
    'tf_cookies_content',
    array(
        'default' => themesflat_customize_default('tf_cookies_content'),
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'tf_cookies_content',
    array(
        'type'      => 'textarea',
        'label'     => esc_html__('Cookies Content', 'ovinx'),
        'section'   => 'section_cookies',
        'active_callback' => function() use ( $wp_customize ) {
            return ( 
                check_setting_is_on( 'tf_cookies' )
            );
        },
    )
);

$wp_customize->add_setting (
    'tf_cookies_btn',
    array(
        'default' => themesflat_customize_default('tf_cookies_btn'),
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'tf_cookies_btn',
    array(
        'type'      => 'text',
        'label'     => esc_html__('Cookies btn Policy', 'ovinx'),
        'section'   => 'section_cookies',
        'active_callback' => function() use ( $wp_customize ) {
            return ( 
                check_setting_is_on( 'tf_cookies' )
            );
        },
    )
);

$wp_customize->add_setting( 
    'tf_cookies_btn_url', 
    array(
    'default' => '',
    'sanitize_callback' => 'themesflat_sanitize_text'
));

//add control
$wp_customize->add_control( 'tf_cookies_btn_url', array(
    'label' => 'Select page for button link to',
    'active_callback' => function () use ( $wp_customize ) {
        return ( 
            check_setting_is_on( 'tf_cookies' )
            &&
            '' != $wp_customize->get_setting( 'tf_cookies_btn' )->value()

        );
    }, 
    'type'  => 'dropdown-pages',
    'section' => 'section_cookies',
    'settings' => 'tf_cookies_btn_url'
));


$wp_customize->add_setting (
    'tf_cookies_btn_active',
    array(
        'default' => themesflat_customize_default('tf_cookies_btn_active'),
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'tf_cookies_btn_active',
    array(
        'type'      => 'text',
        'label'     => esc_html__('Btn Cookies Accept', 'ovinx'),
        'section'   => 'section_cookies',
        'active_callback' => function() use ( $wp_customize ) {
            return ( 
                check_setting_is_on( 'tf_cookies' )
            );
        },
    )
);



?>