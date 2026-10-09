<?php 
// Footer Box control
$wp_customize->add_setting(
    'footer_controls',
    array(
        'default' => themesflat_customize_default('footer_controls'),
        'sanitize_callback' => 'themesflat_sanitize_text',
    )
);
$wp_customize->add_control( new themesflat_BoxControls($wp_customize,
    'footer_controls',
    array(
        'label' => esc_html__( 'Footer Box Controls (px)', 'ovinx' ),
        'section' => 'section_footer',
        'type' => 'box-controls',
        'priority' => 2
    ))
);

