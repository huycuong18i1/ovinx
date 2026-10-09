<?php 
//Logo
$wp_customize->add_setting(
    'logo_style',
    array(
        'default'           => themesflat_customize_default('logo_style'),
        'sanitize_callback' => 'esc_attr',
    )
);
$wp_customize->add_control(
    'logo_style',
    array(
        'type'      => 'select',           
        'section'   => 'section_logo',
        'label'     => esc_html__('Logo Style', 'ovinx'),
        'choices'   => array(
            'image'     => esc_html__( 'Image', 'ovinx' ),
            'text'     => esc_html__( 'Text', 'ovinx' ),            
        ),
    )
);

$wp_customize->add_setting(
    'logo_text',
    array(
        'default' => themesflat_customize_default('logo_text'),
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'logo_text',
    array(
        'label' => esc_html__( 'Text', 'ovinx' ),
        'section' => 'section_logo',
        'type' => 'text',
        'active_callback' => function() use ( $wp_customize ) {
                return ( 
                    'text' === $wp_customize->get_setting( 'logo_style' )->value()
                );
            },
    )
);

$wp_customize->add_setting(
    'site_logo',
    array(
        'default' => themesflat_customize_default('site_logo'),
        'sanitize_callback' => 'esc_url_raw',
    )
);    
$wp_customize->add_control(
    new WP_Customize_Image_Control(
        $wp_customize,
        'site_logo',
        array(
           'label'          => esc_html__( 'Upload Your Logo ', 'ovinx' ),
           'description'    => esc_html__( 'If you don\'t display logo please remove it your website display 
            Site Title default in General', 'ovinx' ),
           'type'           => 'image',
           'section'        => 'section_logo',           
            'active_callback' => function() use ( $wp_customize ) {
                return ( 
                    'image' === $wp_customize->get_setting( 'logo_style' )->value()
                );
            },
        )
    )
);

// Logo Size
$wp_customize->add_setting(
    'logo_width',
    array(
        'default'   =>  themesflat_customize_default('logo_width'),
        'sanitize_callback' => 'esc_attr',
    )
);
$wp_customize->add_control( new themesflat_Slide_Control( $wp_customize,
    'logo_width',
        array(
            'type'      =>  'slide-control',
            'section'   =>  'section_logo',
            'label'     =>  'Logo Size Width(px)',
            'input_attrs' => array(
                'min' => 0,
                'max' => 500,
                'step' => 1,
            ),
            'active_callback' => function() use ( $wp_customize ) {
                return ( 
                    'image' === $wp_customize->get_setting( 'logo_style' )->value()
                );
            },
        )

    )
);
