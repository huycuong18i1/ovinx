<?php
$wp_customize->add_setting(
    'footer_newsletter_enabled',
    array(
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
        'default'           => themesflat_customize_default('footer_newsletter_enabled'),
    )
);
$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'footer_newsletter_enabled',
    array(
        'type'     => 'checkbox',
        'label'    => esc_html__( 'Newsletter ( OFF | ON )', 'ovinx' ),
        'section'  => 'section_footer_newsletter',
        'priority' => 1,
    ))
);

$wp_customize->add_setting(
    'footer_newsletter_title',
    array(
        'default'           => themesflat_customize_default('footer_newsletter_title'),
        'sanitize_callback' => 'themesflat_sanitize_text',
    )
);
$wp_customize->add_control(
    'footer_newsletter_title',
    array(
        'label'           => esc_html__( 'Title', 'ovinx' ),
        'section'         => 'section_footer_newsletter',
        'type'            => 'text',
        'priority'        => 2,
        'active_callback' => function() use ( $wp_customize ) {
            return ( check_setting_is_on( 'footer_newsletter_enabled' ) );
        },
    )
);

$wp_customize->add_setting(
    'footer_newsletter_description',
    array(
        'default'           => themesflat_customize_default('footer_newsletter_description'),
        'sanitize_callback' => 'themesflat_sanitize_text',
    )
);
$wp_customize->add_control(
    'footer_newsletter_description',
    array(
        'label'           => esc_html__( 'Description', 'ovinx' ),
        'section'         => 'section_footer_newsletter',
        'type'            => 'textarea',
        'priority'        => 3,
        'active_callback' => function() use ( $wp_customize ) {
            return ( check_setting_is_on( 'footer_newsletter_enabled' ) );
        },
    )
);

$wp_customize->add_setting(
    'footer_newsletter_shortcode',
    array(
        'default'           => themesflat_customize_default('footer_newsletter_shortcode'),
        'sanitize_callback' => 'themesflat_sanitize_text',
    )
);
$wp_customize->add_control(
    'footer_newsletter_shortcode',
    array(
        'label'           => esc_html__( 'Subscribe Form Shortcode (e.g. Mailchimp)', 'ovinx' ),
        'description'     => esc_html__( 'Paste the shortcode from your newsletter plugin (e.g. Mailchimp for WordPress) here to render the subscribe form.', 'ovinx' ),
        'section'         => 'section_footer_newsletter',
        'type'            => 'textarea',
        'priority'        => 4,
        'active_callback' => function() use ( $wp_customize ) {
            return ( check_setting_is_on( 'footer_newsletter_enabled' ) );
        },
    )
);
