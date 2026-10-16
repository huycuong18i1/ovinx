<?php
// Content controls (style / slides / marquee) are shared by desktop and mobile, so show them when EITHER
// "Enable Promo Bar" (this section) or "Show Promo Bar Mobile" (Mobile > Announcement Bar) is on.
if ( ! function_exists( 'ovinx_promo_bar_enabled_anywhere' ) ) {
function ovinx_promo_bar_enabled_anywhere( $control ) {
    $desktop = $control->manager->get_setting( 'show_promo_bar' );
    $mobile  = $control->manager->get_setting( 'show_promo_bar_mobile' );

    return ( $desktop && $desktop->value() == 1 ) || ( $mobile && $mobile->value() == 1 );
}
}

$wp_customize->add_setting( 
    'show_promo_bar',
    array(
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
        'default'           => themesflat_customize_default('show_promo_bar'),     
    )   
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'show_promo_bar',
    array(
        'type'     => 'checkbox',
        'label'    => esc_html__('Enable Promo Bar', 'ovinx'),
        'section'  => 'section_announcement',
        'priority' => 1,
    ))
); 

$wp_customize->add_setting(
    'promo_topbar_style',
    array(
        'default'           => themesflat_customize_default('promo_topbar_style'),
        'sanitize_callback' => 'esc_attr',
    )
);
$wp_customize->add_control(
    'promo_topbar_style',
    array(
        'type'      => 'select',
        'label'     => esc_html__('Style', 'ovinx'),
        'section'   => 'section_announcement',
        'priority'  => 2,
        'choices'   => array(
            'style-slides' => esc_html__('Slides', 'ovinx'),
            'style-text'   => esc_html__('Marquee Text', 'ovinx'),
        ),
        'active_callback' => function( $control ) {
            return ovinx_promo_bar_enabled_anywhere( $control );
        },
    )
);

$wp_customize->add_setting('promo_slides_arr', array(
    'default'           => themesflat_customize_default('promo_slides_arr'),
    'sanitize_callback' => 'ovinx_sanitize_array',
));

$wp_customize->add_control(new Themesflat_Repeater_Controls($wp_customize, 'promo_slides_arr', array(
    'label'           => esc_html__('Slide Items', 'ovinx'),
    'section'         => 'section_announcement',
    'settings'        => 'promo_slides_arr',
    'priority'        => 4,
    'active_callback' => function( $control ) {

        return (
            ovinx_promo_bar_enabled_anywhere( $control ) && $control->manager->get_setting( 'promo_topbar_style' )->value() == 'style-slides'
        );
    },
)));

$wp_customize->add_setting('promo_marquee_arr', array(
    'default'           => themesflat_customize_default('promo_marquee_arr'),
    'sanitize_callback' => 'ovinx_sanitize_array',
));

$wp_customize->add_control(new Themesflat_Repeater_Controls($wp_customize, 'promo_marquee_arr', array(
    'label'           => esc_html__('Marquee Text Items', 'ovinx'),
    'section'         => 'section_announcement',
    'settings'        => 'promo_marquee_arr',
    'priority'        => 5,
    'active_callback' => function( $control ) {

        return (
            ovinx_promo_bar_enabled_anywhere( $control ) && $control->manager->get_setting( 'promo_topbar_style' )->value() == 'style-text'
        );
    },
)));