<?php 

$wp_customize->add_setting(
    'header_mb_heading',
    array(
        'default' => themesflat_customize_default('header_mb_heading'),
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'header_mb_heading',
    array(
        'label' => esc_html__( 'Heading', 'ovinx' ),
        'section' => 'section_info',
        'type' => 'text',
        'priority' => 1
    )
);

$wp_customize->add_setting(
    'header_email',
    array(
        'default' => themesflat_customize_default('header_email'),
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'header_email',
    array(
        'label' => esc_html__( 'Email', 'ovinx' ),
        'section' => 'section_info',
        'type' => 'text',
        'priority' => 5
    )
);

$wp_customize->add_setting(
    'header_phone',
    array(
        'default' => themesflat_customize_default('header_phone'),
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'header_phone',
    array(
        'label' => esc_html__( 'Phone', 'ovinx' ),
        'section' => 'section_info',
        'type' => 'text',
        'priority' => 6
    )
);

$wp_customize->add_setting(
    'header_address',
    array(
        'default' => themesflat_customize_default('header_address'),
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'header_address',
    array(
        'label' => esc_html__( 'Address', 'ovinx' ),
        'section' => 'section_info',
        'type' => 'text',
        'priority' => 7
    )
);

$wp_customize->add_setting(
    'header_mb_language',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('header_mb_language'),     
      )   
  );
$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'header_mb_language',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Show Language', 'ovinx'),
        'section' => 'section_info',
        'priority' => 9
    ))
);


$wp_customize->add_setting(
'header_mb_currency',
    array(
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
        'default' => themesflat_customize_default('header_mb_currency'),     
    )   
);
$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'header_mb_currency',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Show Currency', 'ovinx'),
        'section' => 'section_info',
        'priority' => 10
    ))
);
  
  
