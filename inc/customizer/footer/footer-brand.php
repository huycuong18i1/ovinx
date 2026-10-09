<?php
$wp_customize->add_setting(
    'footer_description',
    array(
        'default'           => themesflat_customize_default('footer_description'),
        'sanitize_callback' => 'themesflat_sanitize_text',
    )
);
$wp_customize->add_control(
    'footer_description',
    array(
        'label'    => esc_html__( 'Description', 'ovinx' ),
        'section'  => 'section_footer_brand',
        'type'     => 'textarea',
        'priority' => 1,
    )
);
