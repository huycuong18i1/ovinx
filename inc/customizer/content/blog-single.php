<?php 

// Show Post Navigator
$wp_customize->add_setting (
    'show_post_navigator',
    array (
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
        'default' => themesflat_customize_default('show_post_navigator'),     
    )
);
$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'show_post_navigator',
    array(
        'type'      => 'checkbox',
        'label'     => esc_html__('Post Navigator ( OFF | ON )', 'ovinx'),
        'section'   => 'section_content_blog_single',
    ))
);

// Enable Entry Footer Content
$wp_customize->add_setting(
  'show_entry_footer_content',
    array(
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
        'default' => themesflat_customize_default('show_entry_footer_content'),     
    )   
);
$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'show_entry_footer_content',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Entry Footer ( OFF | ON )', 'ovinx'),
        'section' => 'section_content_blog_single',
    ))
);

$wp_customize->add_setting(
  'show_related_post',
    array(
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
        'default' => themesflat_customize_default('show_related_post'),     
    )   
);
$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'show_related_post',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Related Post ( OFF | ON )', 'ovinx'),
        'section' => 'section_content_blog_single',
    ))
);

// Related Posts Title
$wp_customize->add_setting (
    'related_post_title',
    array(
        'default' => themesflat_customize_default('related_post_title'),
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'related_post_title',
    array(
        'type'      => 'text',
        'label'     => esc_html__('Title', 'ovinx'),
        'section'   => 'section_content_blog_single',
        'active_callback' => function() use ( $wp_customize ) {
            return (
                check_setting_is_on( 'show_related_post' )
            );
        },
    )
);

// Related Posts Description
$wp_customize->add_setting (
    'related_post_des',
    array(
        'default' => themesflat_customize_default('related_post_des'),
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'related_post_des',
    array(
        'type'      => 'textarea',
        'label'     => esc_html__('Description', 'ovinx'),
        'section'   => 'section_content_blog_single',
        'active_callback' => function() use ( $wp_customize ) {
            return (
                check_setting_is_on( 'show_related_post' )
            );
        },
    )
);

// Gird columns Related Posts
$wp_customize->add_setting( 'related_post_columns', array(
	'default'           => themesflat_customize_default('related_post_columns'),
	'sanitize_callback' => 'themesflat_sanitize_responsive_columns',
) );

$wp_customize->add_control( new themesflat_ResponsiveColumnsSwitch( $wp_customize, 'related_post_columns', array(
	'label'    => __( 'Columns', 'ovinx' ),
	'section'  => 'section_content_blog_single',
	'settings' => 'related_post_columns',
    'active_callback' => function() use ( $wp_customize ) {
            return ( 
                check_setting_is_on( 'show_related_post' )
            );
        },
) ) );


// Number Of Related Posts
$wp_customize->add_setting (
    'number_related_post',
    array(
        'default' => themesflat_customize_default('number_related_post'),
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'number_related_post',
    array(
        'type'      => 'text',
        'label'     => esc_html__('Number Of Related Posts', 'ovinx'),
        'section'   => 'section_content_blog_single',
        'active_callback' => function() use ( $wp_customize ) {
            return ( 
                check_setting_is_on( 'show_related_post' )
            );
        },
    )
);