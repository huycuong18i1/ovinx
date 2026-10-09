<?php

// ─── Header Style ────────────────────────────────────────────────────────────
$wp_customize->add_setting(
    'style_header',
    array(
        'default'           => themesflat_customize_default('style_header'),
        'sanitize_callback' => 'esc_attr',
    )
);
$wp_customize->add_control( new themesflat_RadioImages($wp_customize,
    'style_header',
    array (
        'type'      => 'radio-images',
        'section'   => 'section_options',
        'priority'  => 1,
        'label'         => esc_html__('Header Layout', 'ovinx'),
        'choices'   => array (
            'header-default' => array (
                'tooltip'   => esc_html__( 'Default','ovinx' ),
                'src'       => THEMESFLAT_LINK . 'images/controls/header-default.jpg'
            ),
            'header-02' => array (
                'tooltip'   => esc_html__( 'Header 02','ovinx' ),
                'src'       => THEMESFLAT_LINK . 'images/controls/header-02.jpg'
            ),
            'header-03' => array (
                'tooltip'   => esc_html__( 'Header 03','ovinx' ),
                'src'       => THEMESFLAT_LINK . 'images/controls/header-03.jpg'
            ),
        ),
    ))
);

// ─── Sticky Header ───────────────────────────────────────────────────────────
$wp_customize->add_setting(
  'header_sticky',
    array(
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
        'default' => themesflat_customize_default('header_sticky'),
    )
);
$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'header_sticky',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Sticky Header', 'ovinx'),
        'section' => 'section_options',
        'priority' => 2,
    ))
);

// ─── Search Box ──────────────────────────────────────────────────────────────
$wp_customize->add_setting(
  'header_search_box',
    array(
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
        'default' => themesflat_customize_default('header_search_box'),
    )
);
$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'header_search_box',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Search Icon', 'ovinx'),
        'section' => 'section_options',
        'priority' => 5,
    ))
);

$wp_customize->add_setting(
  'header_search_box_form',
    array(
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
        'default' => themesflat_customize_default('header_search_box_form'),
    )
);
$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'header_search_box_form',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Search Form', 'ovinx'),
        'section' => 'section_options',
        'priority' => 5,
        'active_callback' => function() use ( $wp_customize ) {
            return in_array( $wp_customize->get_setting( 'style_header' )->value(), array( 'header-02', 'header-03' ), true );
        },
    ))
);

// ─── Account Button ──────────────────────────────────────────────────────────
$wp_customize->add_setting(
    'header_login',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('header_login'),
      )
);
$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
      'header_login',
      array(
          'type' => 'checkbox',
          'label' => esc_html__('Account Icon', 'ovinx'),
          'section' => 'section_options',
          'priority' => 7,
      ))
);

// ─── Wishlist Icon ───────────────────────────────────────────────────────────
$wp_customize->add_setting(
    'header_wishlist_icon',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('header_wishlist_icon'),
      )
);
$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
      'header_wishlist_icon',
      array(
          'type' => 'checkbox',
          'label' => esc_html__('Wishlist Icon', 'ovinx'),
          'section' => 'section_options',
          'priority' => 9,
      ))
);

// ─── Cart Icon ───────────────────────────────────────────────────────────────
$wp_customize->add_setting(
  'header_cart_icon',
    array(
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
        'default' => themesflat_customize_default('header_cart_icon'),
    )
);
$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'header_cart_icon',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Cart Icon', 'ovinx'),
        'section' => 'section_options',
        'priority' => 10,
    ))
);

// ─── Compare Icon ────────────────────────────────────────────────────────────
$wp_customize->add_setting(
  'header_compare_icon',
    array(
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
        'default' => themesflat_customize_default('header_compare_icon'),
    )
);
$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'header_compare_icon',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Compare Icon', 'ovinx'),
        'section' => 'section_options',
        'priority' => 11,
    ))
);

// ─── Category Menu ───────────────────────────────────────────────────────────
$wp_customize->add_setting(
  'show_header_category',
    array(
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
        'default' => themesflat_customize_default('show_header_category'),
    )
);
$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'show_header_category',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Category Menu', 'ovinx'),
        'section' => 'section_options',
        'priority' => 10,
    ))
);

// ─── Special Offer Text ──────────────────────────────────────────────────────
$wp_customize->add_setting(
    'header_special_offers',
    array(
        'default'           => themesflat_customize_default('header_special_offers'),
        'sanitize_callback' => 'ovinx_sanitize_array',
    )
);
$wp_customize->add_control(
    'header_special_offers',
    array(
        'label'   => esc_html__( 'Special Offer', 'ovinx' ),
        'section' => 'section_options',
        'type'    => 'text',
        'priority' => 11,
    )
);
