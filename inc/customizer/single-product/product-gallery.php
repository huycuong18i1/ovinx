<?php

$wp_customize->add_setting(
    'tf_product_gallery_title',
    array(
        'default'   => themesflat_customize_default('tf_product_gallery_title'),
        'sanitize_callback' => 'esc_attr',
    )
);

$wp_customize->add_setting( 
    'tf_product_gallery_layout',
    array(
        'default' => themesflat_customize_default('tf_product_gallery_layout'),
        'sanitize_callback' => 'esc_attr',
    )   
);

$wp_customize->add_setting(
    'tf_product_gallery_zoom',
    array(
        'default' => themesflat_customize_default('tf_product_gallery_zoom'),
        'sanitize_callback' => 'esc_attr',
    )   
);

$wp_customize->add_setting(
    'tf_product_gallery_lightbox',
    array(
        'default' => themesflat_customize_default('tf_product_gallery_lightbox'),
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
    )
);

$wp_customize->add_setting( 
    'tf_variation_gallery',
    array(
        'default' => themesflat_customize_default('tf_variation_gallery'),
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
    )   
);

$wp_customize->add_setting( 
    'tf_product_video',
    array(
        'default' => themesflat_customize_default('tf_product_video'),
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
    )   
);

$wp_customize->add_setting( 
    'tf_product_3d',
    array(
        'default' => themesflat_customize_default('tf_product_3d'),
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
    )   
);

$wp_customize->add_control( new themesflat_Info( $wp_customize,
    'tf_product_gallery_title',
    array(
        'label' => esc_html__('Product Gallery', 'ovinx'),
        'section' => 'section_product_gallery',
    ) )
);

$wp_customize->add_control( new WP_Customize_Control( $wp_customize,
    'tf_product_gallery_layout',
    array(
        'label' => esc_html__('Layout', 'ovinx'),
        'type' => 'select',
        'choices' => array(
            'left_thumb' => esc_html__( 'Left Thumbnail' , 'ovinx' ),
            'right_thumb' => esc_html__( 'Right Thumbnail' , 'ovinx' ),
            'bottom_thumb' => esc_html__( 'Bottom Thumbnail' , 'ovinx' ),
            'grid' => esc_html__( 'Grid' , 'ovinx' ),
            'grid_style_2' => esc_html__( 'Grid Style 2' , 'ovinx' ),
            'stacked' => esc_html__( 'Stacked' , 'ovinx' ),
            // 'no_thumb' => esc_html__( 'Slide no Thumbnail' , 'ovinx' ),
            // 'middle_gallery' => esc_html__( 'Middle Gallery' , 'ovinx' ),
        ),
        'section' => 'section_product_gallery',
    ) )
);

$wp_customize->add_control( new WP_Customize_Control( $wp_customize,
    'tf_product_gallery_zoom',
    array(
        'label' => esc_html__('Zoom', 'ovinx'),
        'type' => 'select',
        'choices' => array(
            'no' => esc_html__( 'No zoom' , 'ovinx' ),
            'inner' => esc_html__( 'Inner Zoom' , 'ovinx' ),
            'inner_circle' => esc_html__( 'Inner Circle Zoom' , 'ovinx' ),
            'external' => esc_html__( 'External Zoom' , 'ovinx' ),
        ),
        'section' => 'section_product_gallery',
    ) )
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'tf_product_gallery_lightbox',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Lightbox', 'ovinx'),
        'section' => 'section_product_gallery',
    ) )
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'tf_variation_gallery',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Variation Gallery (a separate image set per variation)', 'ovinx'),
        'section' => 'section_product_gallery',
    ) )
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'tf_product_video',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Product Video', 'ovinx'),
        'section' => 'section_product_gallery',
    ) )
);

$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'tf_product_3d',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Product 3D Viewer', 'ovinx'),
        'section' => 'section_product_gallery',
    ) )
);