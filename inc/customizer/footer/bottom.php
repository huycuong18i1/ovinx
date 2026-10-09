<?php 
// Show Bottom
$wp_customize->add_setting ( 
    'show_bottom',
    array (
        'sanitize_callback' => 'themesflat_sanitize_checkbox' ,
        'default' => themesflat_customize_default('show_bottom'),     
    )
);
$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'show_bottom',
    array(
        'type'      => 'checkbox',
        'label'     => esc_html__('Bottom', 'ovinx'),
        'section'   => 'section_bottom',
        'priority'  => 1
    ))
);

$wp_customize->add_setting ( 
    'show_bottom_language',
    array (
        'sanitize_callback' => 'themesflat_sanitize_checkbox' ,
        'default' => themesflat_customize_default('show_bottom_language'),     
    )
);
$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'show_bottom_language',
    array(
        'type'      => 'checkbox',
        'label'     => esc_html__('Language', 'ovinx'),
        'section'   => 'section_bottom',
        'priority'  => 2,
                'active_callback' => function() use ( $wp_customize ) {
            return ( 
                check_setting_is_on( 'show_bottom' )
            );
        },
    ))
);

$wp_customize->add_setting ( 
    'show_bottom_currency',
    array (
        'sanitize_callback' => 'themesflat_sanitize_checkbox' ,
        'default' => themesflat_customize_default('show_bottom_currency'),     
    )
);
$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'show_bottom_currency',
    array(
        'type'      => 'checkbox',
        'label'     => esc_html__('Currencies', 'ovinx'),
        'section'   => 'section_bottom',
        'priority'  => 3,
                'active_callback' => function() use ( $wp_customize ) {
            return ( 
                check_setting_is_on( 'show_bottom' )
            );
        },
    ))
);


// Footer Copyright
$wp_customize->add_setting(
    'footer_copyright',
    array(
        'default' => themesflat_customize_default('footer_copyright'),
        'sanitize_callback' => 'themesflat_sanitize_text',
    )
);
$wp_customize->add_control(
    'footer_copyright',
    array(
        'label' => esc_html__( 'Copyright', 'ovinx' ),
        'section' => 'section_bottom',
        'type' => 'textarea',
        'priority' => 4,
        'active_callback' => function() use ( $wp_customize ) {
            return ( 
                check_setting_is_on( 'show_bottom' )
            );
        },
    )
);

$wp_customize->add_setting ( 
    'show_img_payment',
    array (
        'sanitize_callback' => 'themesflat_sanitize_checkbox' ,
        'default' => themesflat_customize_default('show_img_payment'),     
    )
);
$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'show_img_payment',
    array(
        'type'      => 'checkbox',
        'label'     => esc_html__('Payment Image', 'ovinx'),
        'section'   => 'section_bottom',
        'priority'  => 5,
                'active_callback' => function() use ( $wp_customize ) {
            return ( 
                check_setting_is_on( 'show_bottom' )
            );
        },
    ))
);
  
$wp_customize->add_setting(
    'img_payment',
    array(
        'sanitize_callback' => 'themesflat_sanitize_image_urls',
        'default'           => themesflat_customize_default('img_payment'),        
    )
);
$wp_customize->add_control(
    new themesflat_MultiImages(
        $wp_customize,
        'img_payment',
        array(
           'label'          => esc_html__( 'Upload Your Partner Image', 'ovinx' ),
           'type'           => 'multi-image',
           'section'        => 'section_bottom',
           'priority'       => 6,
            'active_callback' => function( $control ) {
                $show_bottom  = $control->manager->get_setting( 'show_bottom' )->value();
                $show_img_payment  = $control->manager->get_setting( 'show_img_payment' )->value();

                return (
                    $show_bottom == 1 &&
                    $show_img_payment == 1
                );
            },
        )
    )
);