<?php 

$wp_customize->add_setting(
    'show_navigation_bar',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('show_navigation_bar'),     
      )   
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'show_navigation_bar',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('NavBar Mobile', 'ovinx'),
        'section' => 'section_navbar',
        
    ))
);

$wp_customize->add_setting (
    'navbar_element',
    array (
        'sanitize_callback' => 'themesflat_sanitize_text',
        'default' => themesflat_customize_default('navbar_element'),     
    )
);
$wp_customize->add_control( new themesflat_Control_Drag_And_Drop( $wp_customize,
    'navbar_element',
    array(
        'type'      => 'draganddrop-controls',
        'label'     => esc_html__('Post Content Elements', 'ovinx'),
        'description' => esc_html__( 'Drag and drop elements to re-order.', 'ovinx' ),
        'section'   => 'section_navbar',
        'choices' => array(
            'home'            => esc_html__( 'Home', 'ovinx' ),
            'account'           => esc_html__( 'Account', 'ovinx' ),
            'shop' => esc_html__( 'Shop', 'ovinx' ),
            'wishlist'           => esc_html__( 'Wishlist', 'ovinx' ),
            'cart' => esc_html__( 'Cart', 'ovinx' ),
        ),        
    ))
); 
?>