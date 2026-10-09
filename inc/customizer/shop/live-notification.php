
<?php 

$wp_customize->add_setting(
    'live_notification',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('live_notification'),     
      )   
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'live_notification',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Live Notification', 'ovinx'),
        'section' => 'section_live_notification',
    ))
);

$wp_customize->add_setting (
    'live_number',
    array(
        'default' => themesflat_customize_default('live_number'),
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'live_number',
    array(
        'type'      => 'text',
        'label'     => esc_html__('Limit Number Display', 'ovinx'),
        'section'   => 'section_live_notification',
        'active_callback' => function() use ( $wp_customize ) {
            return ( 
                check_setting_is_on( 'live_notification' )
            );
        },
    )
);

$wp_customize->add_setting (
    'live_timeout',
    array(
        'default' => themesflat_customize_default('live_timeout'),
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'live_timeout',
    array(
        'type'      => 'text',
        'label'     => esc_html__('Setting Timout  (ms)', 'ovinx'),
        'section'   => 'section_live_notification',
        'active_callback' => function() use ( $wp_customize ) {
            return ( 
                check_setting_is_on( 'live_notification' )
            );
        },
    )
);

$wp_customize->add_setting (
    'live_interval',
    array(
        'default' => themesflat_customize_default('live_interval'),
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'live_interval',
    array(
        'type'      => 'text',
        'label'     => esc_html__('Setting Inteval (ms)', 'ovinx'),
        'section'   => 'section_live_notification',
        'active_callback' => function() use ( $wp_customize ) {
            return ( 
                check_setting_is_on( 'live_notification' )
            );
        },
    )
);



$wp_customize->add_setting(
    'product_from',
    array(
        'default'           => themesflat_customize_default('product_from'),
        'sanitize_callback' => 'esc_attr',
    )
);
$wp_customize->add_control(
    'product_from',
    array(
        'type'      => 'select',           
        'section'   => 'section_live_notification',
        'label'     => esc_html__('Get Product From', 'ovinx'),
        'choices'   => array(
            'order'     => esc_html__( 'Product Order', 'ovinx' ),
            'type'     => esc_html__( 'Product Type', 'ovinx' ),            
            'category'     => esc_html__( 'Product Category', 'ovinx' ),            
        ),
        'active_callback' => function() use ( $wp_customize ) {
            return ( 
                check_setting_is_on( 'live_notification' )
            );
        },
    )
);

$wp_customize->add_setting(
    'product_type',
    array(
        'default'           => themesflat_customize_default('product_type'),
        'sanitize_callback' => 'esc_attr',
    )
);
$wp_customize->add_control(
    'product_type',
    array(
        'type'      => 'select',           
        'section'   => 'section_live_notification',
        'label'     => esc_html__('Product Type', 'ovinx'),
        'choices'   => array(
            'recent'     => esc_html__( 'Recent', 'ovinx' ),
            'featured'     => esc_html__( 'Featured', 'ovinx' ),            
            'best_selling'     => esc_html__( 'Best Selling', 'ovinx' ),            
            'top_rated'     => esc_html__( 'Top Rated', 'ovinx' ),            
            'sale'     => esc_html__( 'Sale', 'ovinx' ),                
        ),
        'active_callback' => function() use ( $wp_customize ) {
            return ( 
                check_setting_is_on( 'live_notification' )
                &&
                'type' === $wp_customize->get_setting( 'product_from' )->value()
            );
        },
    )
);

$wp_customize->add_setting( 'live_category', array(
    'default'   => themesflat_customize_default('live_category'),
    'sanitize_callback' => 'esc_attr',
) );


$wp_customize->add_control(
    'live_category',
    array(
        'type'      => 'select',           
        'section'   => 'section_live_notification',
        'label'     => esc_html__('Select categories', 'ovinx'),
        'choices' => tfwc_get_product_categories(),
        'active_callback' => function() use ( $wp_customize ) {
            return ( 
                check_setting_is_on( 'live_notification' )
                &&
                'category' === $wp_customize->get_setting( 'product_from' )->value()
            );
        },
    )
);
