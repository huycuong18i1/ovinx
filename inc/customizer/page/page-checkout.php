<?php 


$wp_customize->add_control( new themesflat_Info( $wp_customize,
'page_checkout_title',
array(
    'label' => esc_html__('Checkout Page', 'ovinx'),
    'section' => 'section_checkout_page',
) )
);
$wp_customize->add_control( new themesflat_Info( $wp_customize, 'testimonial-thankyou-body', array(
    'label' => esc_html__('Testimonial', 'ovinx'),
    'section' => 'section_checkout_page',
    'settings' => 'testimonial_thankyou_heading',
) )
);

$wp_customize->add_setting ( 
    'checkout_testi',
    array (
        'sanitize_callback' => 'themesflat_sanitize_checkbox' ,
        'default' => themesflat_customize_default('checkout_testi'),     
    )
);
$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'checkout_testi',
    array(
        'type'      => 'checkbox',
        'label'     => esc_html__('Checkout Testimonial', 'ovinx'),
        'section'   => 'section_checkout_page',
    ))
);

$wp_customize->add_setting('testimonial_checkout', array(
    'default' => themesflat_customize_default('testimonial_checkout'),
    'transport' => 'postMessage',
    'sanitize_callback' => 'themesflat_sanitize_testimonial_thankyou_repeater'
));

$wp_customize->add_control(new Testimonial_Thankyou_Repeater_Control($wp_customize, 'testimonial_checkout', array(
    'label' => 'Testimonials',
    'section' => 'section_checkout_page',
    'settings' => 'testimonial_checkout',
)));


// Give Feedback

$wp_customize->add_setting(
    'order_give_feedback',
    array(
        'default' => themesflat_customize_default('order_give_feedback'),
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
    )
);

$wp_customize->add_setting(
    'order_give_feedback_content',
    array(
        'default' => themesflat_customize_default('order_give_feedback_content'),
        'sanitize_callback' => 'themesflat_sanitize_raw',
    )
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'order_give_feedback',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Feedback form ( OFF | ON )', 'ovinx'),
        'section' => 'section_checkout_page',
    ) )
);

$wp_customize->add_control( new WP_Customize_Control( $wp_customize,
    'order_give_feedback_content',
    array(
        'label' => esc_html__('Content', 'ovinx'),
        'type' => 'textarea',
        'input_attrs' => array(
            'placeholder' => '[contact-form-7 id="123" title="Feedback form 1"]',
        ),
        'section' => 'section_checkout_page',
        'active_callback' => fn() => check_setting_is_on( 'order_give_feedback' )
    ) )
);