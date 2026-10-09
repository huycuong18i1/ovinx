<?php 

$wp_customize->add_setting(
    'blog_archive_style',
    array(
        'default'           => themesflat_customize_default('blog_archive_style'),
        'sanitize_callback' => 'esc_attr',
    )
);
$wp_customize->add_control( 
    'blog_archive_style',
    array (
        'type'      => 'select',           
        'section'   => 'section_content_blog_archive',
        'priority'  => 1,
        'label'         => esc_html__('Blog Layout', 'ovinx'),
        'choices'   => array (
            'style-standard' =>  esc_html__( 'Default','ovinx' ),                  
            'style-grid' =>  esc_html__( 'Grid','ovinx' ),                  
            )  
    )
);

$wp_customize->add_setting (
    'blog_posts_per_page',
    array(
        'default' => themesflat_customize_default('blog_posts_per_page'),
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);

$wp_customize->add_control(
    'blog_posts_per_page',
    array(
        'type'      => 'text',
        'label'     => esc_html__('Post Per Page', 'ovinx'),
        'section'   => 'section_content_blog_archive',
        'priority'  => 1,       
    )
);

$wp_customize->add_setting(
    'post_sidebar_layout',
    array(
        'default'           => themesflat_customize_default('post_sidebar_layout'),
        'sanitize_callback' => 'esc_attr',
    )
);
$wp_customize->add_control( 
    'post_sidebar_layout',
    array (
        'type'      => 'select',           
        'section'   => 'section_content_blog_archive',
        'priority'  => 2,
        'label'         => esc_html__('Blog Sidebar Layout', 'ovinx'),
        'choices'   => array (
            'fullwidth' =>  esc_html__( 'Full Width','ovinx' ),                  
            'sidebar-left' =>  esc_html__( 'Sidebar Left','ovinx' ),                  
            'sidebar-right'=> esc_html__( 'Sidebar Right','ovinx' ),
            )  
    )
);

$wp_customize->add_setting (
    'blog_sidebar_list',
    array(
        'default'           => themesflat_customize_default('blog_sidebar_list'),
        'sanitize_callback' => 'esc_html',
    )
);
$wp_customize->add_control( new themesflat_DropdownSidebars($wp_customize,
    'blog_sidebar_list',
    array(
        'type'      => 'dropdown',           
        'section'   => 'section_content_blog_archive',
        'priority'  => 4,
        'label'         => esc_html__('List Sidebar', 'ovinx'),
        
    ))
);

// Excerpt
$wp_customize->add_setting(
    'blog_archive_post_excepts_length',
    array(
        'default'   =>  themesflat_customize_default('blog_archive_post_excepts_length'),
        'sanitize_callback' => 'esc_attr',
    )
);
$wp_customize->add_control( new themesflat_Slide_Control( $wp_customize,
    'blog_archive_post_excepts_length',
        array(
            'type'      =>  'slide-control',
            'section'   =>  'section_content_blog_archive',
            'label'     =>  'Post Excepts Length',
            'priority'  => 6,
            'input_attrs' => array(
                'min' => 0,
                'max' => 500,
                'step' => 1,
            ),
        )

    )
); 

// Read More Text
$wp_customize->add_setting (
    'blog_archive_readmore_text',
    array(
        'default' => themesflat_customize_default('blog_archive_readmore_text'),
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'blog_archive_readmore_text',
    array(
        'type'      => 'text',
        'label'     => esc_html__('Read More Text', 'ovinx'),
        'section'   => 'section_content_blog_archive',
        'priority'  => 7
    )
);

// Meta Elements
$wp_customize->add_setting (
    'meta_elements',
    array (
        'sanitize_callback' => 'themesflat_sanitize_text',
        'default' => themesflat_customize_default('meta_elements'),     
    )
);
$wp_customize->add_control( new themesflat_Control_Drag_And_Drop( $wp_customize,
    'meta_elements',
    array(
        'type'      => 'draganddrop-controls',
        'label'     => esc_html__('Meta Elements', 'ovinx'),
        'description' => esc_html__( 'Drag and drop elements to re-order.', 'ovinx' ),
        'section'   => 'section_content_blog_archive',
        'priority'  => 8,
        'choices' => array(
            'date'      => esc_html__( 'Date', 'ovinx' ),
            'author'    => esc_html__( 'Author', 'ovinx' ),
            'category'  => esc_html__( 'Category', 'ovinx' ),
        ),
    ))
); 

// Pagination
$wp_customize->add_setting(
    'blog_archive_pagination_style',
    array(
        'default'           => themesflat_customize_default('blog_archive_pagination_style'),
        'sanitize_callback' => 'esc_attr',
    )
);
$wp_customize->add_control( 
    'blog_archive_pagination_style',
    array(
        'type'      => 'select',           
        'section'   => 'section_content_blog_archive',
        'priority'  => 9,
        'label'         => esc_html__('Pagination Style', 'ovinx'),
        'choices'   => array(
            'pager-numeric'         =>  esc_html__('Page & Numeric','ovinx'),
            'numeric'         =>  esc_html__('Numeric','ovinx'),
            'pager'         =>  esc_html__('Pager (Prev/Next only)','ovinx'),
            'loadmore'         =>  esc_html__('Load More','ovinx'),
        ),
    )
);