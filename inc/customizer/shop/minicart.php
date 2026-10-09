
<?php 
// Free Shipping
$wp_customize->add_setting('free_shipping_bar_heading', array(
    'type'              => 'info_control',
    'capability'        => 'edit_theme_options',
    'sanitize_callback' => 'esc_attr',            
)
);

$wp_customize->add_control( new themesflat_Info( $wp_customize, 'free_shipping_bar-body', array(
    'label' => esc_html__('Free Shipping Bar', 'ovinx'),
    'section' => 'section_shop_minicart',
    'settings' => 'free_shipping_bar_heading',
) )
);
$wp_customize->add_setting(
    'free_shipping_bar',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('free_shipping_bar'),     
      )   
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'free_shipping_bar',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Free Shipping', 'ovinx'),
        'section' => 'section_shop_minicart',
    ))
);


$wp_customize->add_setting (
    'progress_cart_text',
    array(
        'default' => themesflat_customize_default('progress_cart_text'),
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'progress_cart_text',
    array(
        'type'      => 'textarea',
        'label'     => esc_html__('Progessbar text', 'ovinx'),
        'section'   => 'section_shop_minicart',
        'active_callback' => function() use ( $wp_customize ) {
            return ( 
                check_setting_is_on( 'free_shipping_bar' )
            );
        },
    )
);

$wp_customize->add_setting (
    'success_cart_text',
    array(
        'default' => themesflat_customize_default('success_cart_text'),
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);

$wp_customize->add_control(
    'success_cart_text',
    array(
        'type'      => 'textarea',
        'label'     => esc_html__('Success text', 'ovinx'),
        'section'   => 'section_shop_minicart',
        'active_callback' => function() use ( $wp_customize ) {
            return ( 
                check_setting_is_on( 'free_shipping_bar' )
            );
        },
    )
);

$wp_customize->add_setting (
    'minicart_term_link',
    array(
        'default' => themesflat_customize_default('minicart_term_link'),
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);

$wp_customize->add_control(
    'minicart_term_link',
    array(
        'type'      => 'text',
        'label'     => esc_html__('Terms & Conditions link', 'ovinx'),
        'section'   => 'section_shop_minicart',
        // no active_callback: the link is rendered by mini-cart.php/cart-totals.php whether or not the free-shipping bar is on
    )
);

// Bottom
$wp_customize->add_setting('minicart_bottom_heading', array(
    'type'              => 'info_control',
    'capability'        => 'edit_theme_options',
    'sanitize_callback' => 'esc_attr',            
)
);

$wp_customize->add_control( new themesflat_Info( $wp_customize, 'minicart_bottom-body', array(
    'label' => esc_html__('Bottom Extra', 'ovinx'),
    'section' => 'section_shop_minicart',
    'settings' => 'minicart_bottom_heading',
) )
);
$wp_customize->add_setting(
    'minicart_gift',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('minicart_gift'),     
      )   
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'minicart_gift',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Gift', 'ovinx'),
        'section' => 'section_shop_minicart',
    ))
);

$wp_customize->add_setting (
    'gift_fee',
    array(
        'default' => themesflat_customize_default('gift_fee'),
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'gift_fee',
    array(
        'type'      => 'text',
        'label'     => esc_html__('Fee to Gift', 'ovinx'),
        'section'   => 'section_shop_minicart',
        'active_callback' => function() use ( $wp_customize ) {
            return ( 
                check_setting_is_on( 'minicart_gift' )
            );
        },
    )
);

$wp_customize->add_setting(
    'minicart_note',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('minicart_note'),     
      )   
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'minicart_note',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Note', 'ovinx'),
        'section' => 'section_shop_minicart',
    ))
);


$wp_customize->add_setting(
    'minicart_shipping',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('minicart_shipping'),     
      )   
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'minicart_shipping',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Shipping', 'ovinx'),
        'section' => 'section_shop_minicart',
    ))
);

$wp_customize->add_setting(
    'minicart_coupon',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('minicart_coupon'),     
      )   
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'minicart_coupon',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Coupon', 'ovinx'),
        'section' => 'section_shop_minicart',
    ))
);

// GUEST SESSION

$wp_customize->add_setting('guest_session_expiring_setting', array(
    'type'              => 'info_control',
    'capability'        => 'edit_theme_options',
    'sanitize_callback' => 'esc_attr',            
)
);

$wp_customize->add_control( new themesflat_Info( $wp_customize, 'guest_session_expiring-body',
    array(
        'label' => esc_html__('Cart Session Expiring', 'ovinx'),
        'section' => 'section_shop_minicart',
        'settings' => 'guest_session_expiring_setting',
    ) )
);

$wp_customize->add_setting(
    'tf_guest_cart_hours_enable',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('tf_guest_cart_hours_enable'),     
      )   
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'tf_guest_cart_hours_enable',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Custom Time', 'ovinx'),
        'section' => 'section_shop_minicart',
    ))
);

$wp_customize->add_setting (
    'tf_guest_cart_hours',
    array(
        'default' => themesflat_customize_default('tf_guest_cart_hours'),
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);

$wp_customize->add_control(
    'tf_guest_cart_hours',
    array(
        'type'      => 'text',
        'label'     => esc_html__('Hours', 'ovinx'),
        'section'   => 'section_shop_minicart',
        'active_callback' => function() use ( $wp_customize ) {
            return ( 
                check_setting_is_on( 'tf_guest_cart_hours_enable' )
            );
        },
    )
);







