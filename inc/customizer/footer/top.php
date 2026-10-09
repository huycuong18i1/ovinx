<?php 
// Show Bottom
$wp_customize->add_setting ( 
    'footer_top',
    array (
        'sanitize_callback' => 'themesflat_sanitize_checkbox' ,
        'default' => themesflat_customize_default('footer_top'),     
    )
);
$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'footer_top',
    array(
        'type'      => 'checkbox',
        'label'     => esc_html__('Footer Top', 'ovinx'),
        'section'   => 'section_ft_top',
        'priority'  => 1
    ))
);

$wp_customize->add_setting('footer_top_category_arr', array(
    'default' => themesflat_customize_default('footer_top_category_arr'),
    'sanitize_callback' => 'ovinx_sanitize_array',
));

$wp_customize->add_control(new Themesflat_Repeater_Controls($wp_customize, 'footer_top_category_arr', array(
    'label'   => __('Category List', 'ovinx'),
    'section'   => 'section_ft_top',
    'settings' => 'footer_top_category_arr',
    'priority' => 2,
)));