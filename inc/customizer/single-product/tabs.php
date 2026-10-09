<?php

$wp_customize->add_setting(
    'tf_product_tabs_style',
    array(
        'default'           => themesflat_customize_default('tf_product_tabs_style'),
        'sanitize_callback' => 'esc_attr',
    )
);

// TABS Settings
$wp_customize->add_setting(
    'tf_product_description_tab',
    array(
        'default' => themesflat_customize_default('tf_product_description_tab'),
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
    )
);

$wp_customize->add_setting(
    'tf_product_additional_info_tab',
    array(
        'default' => themesflat_customize_default('tf_product_additional_info_tab'),
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
    )
);

$wp_customize->add_setting(
    'tf_product_reviews_tab',
    array(
        'default' => themesflat_customize_default('tf_product_reviews_tab'),
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
    )
);

$wp_customize->add_setting(
    'tf_product_custom_tab',
    array(
        'default' => themesflat_customize_default('tf_product_custom_tab'),
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
    )   
);

// Buttom Text
$wp_customize->add_setting(
    'tf_product_custom_tab_title',
    array(
        'default' => themesflat_customize_default('tf_product_custom_tab_title'),
        'sanitize_callback' => 'esc_attr',
    )
);

// Content
$wp_customize->add_setting( 
    'tf_product_custom_tab_content',
    array(
        'default' => themesflat_customize_default('tf_product_custom_tab_content'),
        'sanitize_callback' => 'themesflat_sanitize_raw',
    )
);

// CONTROLS


$wp_customize->add_control(
    'tf_product_tabs_style',
    array(
        'type'      => 'select',           
        'section'   => 'section_tabs',
        'label'     => esc_html__('Product Tabs Style', 'ovinx'),
        'choices'   => array(
            'default'     => esc_html__( 'Default', 'ovinx' ),
            'accordion'     => esc_html__( 'Accordion', 'ovinx' ),
        ),
    )
);

$wp_customize->add_control( new WP_Customize_Control( $wp_customize,
    'tf_product_description_tab',
    array(
        'label' => esc_html__('Description', 'ovinx'),
        'type' => 'checkbox',
        'section' => 'section_tabs',
    ) )
);

$wp_customize->add_control( new WP_Customize_Control( $wp_customize,
    'tf_product_additional_info_tab',
    array(
        'label' => esc_html__('Additional information', 'ovinx'),
        'type' => 'checkbox',
        'section' => 'section_tabs',
    ) )
);

$wp_customize->add_control( new WP_Customize_Control( $wp_customize,
    'tf_product_reviews_tab',
    array(
        'label' => esc_html__('Reviews', 'ovinx'),
        'type' => 'checkbox',
        'section' => 'section_tabs',
    ) )
);

$wp_customize->add_control( new WP_Customize_Control( $wp_customize,
    'tf_product_custom_tab',
    array(
        'label' => esc_html__('Custom Tab', 'ovinx'),
        'type' => 'checkbox',
        'section' => 'section_tabs',
    ) )
);

$wp_customize->add_control( new WP_Customize_Control( $wp_customize,
    'tf_product_custom_tab_title',
    array(
        'label' => esc_html__('Title', 'ovinx'),
        'type' => 'text',
        'section' => 'section_tabs',
        'active_callback' => fn() => check_setting_is_on( 'tf_product_custom_tab' )
    ) )
);

$wp_customize->add_control( new WP_Customize_Control( $wp_customize,
    'tf_product_custom_tab_content',
    array(
        'label' => esc_html__('Content', 'ovinx'),
        'type' => 'textarea',
        'section' => 'section_tabs',
        'active_callback' => fn() => check_setting_is_on( 'tf_product_custom_tab' )
    ) )
);