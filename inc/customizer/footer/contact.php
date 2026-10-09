<?php
$wp_customize->add_setting(
    'footer_contact_phone',
    array(
        'default'           => themesflat_customize_default('footer_contact_phone'),
        'sanitize_callback' => 'themesflat_sanitize_text',
    )
);
$wp_customize->add_control(
    'footer_contact_phone',
    array(
        'label'    => esc_html__( 'Phone Number', 'ovinx' ),
        'section'  => 'section_footer_contact',
        'type'     => 'text',
        'priority' => 1,
    )
);

$wp_customize->add_setting(
    'footer_contact_address',
    array(
        'default'           => themesflat_customize_default('footer_contact_address'),
        'sanitize_callback' => 'themesflat_sanitize_text',
    )
);
$wp_customize->add_control(
    'footer_contact_address',
    array(
        'label'    => esc_html__( 'Address', 'ovinx' ),
        'section'  => 'section_footer_contact',
        'type'     => 'text',
        'priority' => 2,
    )
);

$wp_customize->add_setting(
    'footer_contact_map_url',
    array(
        'default'           => themesflat_customize_default('footer_contact_map_url'),
        'sanitize_callback' => 'esc_url_raw',
    )
);
$wp_customize->add_control(
    'footer_contact_map_url',
    array(
        'label'    => esc_html__( 'Address Map Link', 'ovinx' ),
        'section'  => 'section_footer_contact',
        'type'     => 'text',
        'priority' => 3,
    )
);

$wp_customize->add_setting(
    'footer_contact_email',
    array(
        'default'           => themesflat_customize_default('footer_contact_email'),
        'sanitize_callback' => 'sanitize_email',
    )
);
$wp_customize->add_control(
    'footer_contact_email',
    array(
        'label'    => esc_html__( 'Email Address', 'ovinx' ),
        'section'  => 'section_footer_contact',
        'type'     => 'text',
        'priority' => 4,
    )
);
