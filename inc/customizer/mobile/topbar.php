<?php 

$wp_customize->add_setting( 
  'show_top_bar_mobile',
    array(
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
        'default' => themesflat_customize_default('show_top_bar_mobile'),     
    )   
);
$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'show_top_bar_mobile',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Show Top Bar Mobile', 'ovinx'),
        'section' => 'section_mobile_topbar',
        'priority' => 1,
    ))
); 