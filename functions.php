<?php
/**
 * themesflat functions and definitions
 *
 * @package ovinx
 */
// remove_theme_mods();

define( 'THEMESFLAT_DIR', trailingslashit( get_template_directory() )) ;
define( 'THEMESFLAT_LINK', trailingslashit( get_template_directory_uri() ) );
define( 'THEMESFLAT_PROTOCOL' , (is_ssl()) ? 'https' : 'http' );
if ( ! function_exists( 'themesflat_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function themesflat_setup() {

    /*
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     * If you're building a theme based on burger, use a find and replace
     * to change 'ovinx' to the name of your theme in all the template files
     */
    load_theme_textdomain( 'ovinx', THEMESFLAT_DIR . '/languages' );

    // Add default posts and comments RSS feed links to head.
    
    add_theme_support( 'automatic-feed-links' );

    add_theme_support( "wp-block-styles" );
    add_theme_support( "responsive-embeds" );
    add_theme_support( 'custom-logo', array(
            'flex-height' => true,
            'flex-width'  => true,
        ) );
    add_theme_support( "align-wide" );
    add_theme_support( 'title-tag' );

    // Content width
    global $content_width;
    if ( ! isset( $content_width ) ) {
        $content_width = 1200; /* pixels */
    }

    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
     */
    function wpse_setup_theme() {
        add_theme_support( 'post-thumbnails' ); 
        add_theme_support( 'woocommerce' );
    }
     
    add_action( 'after_setup_theme', 'wpse_setup_theme' );

    if (function_exists('add_image_size')){
        add_image_size( 'themesflat-blog', 675, 460, true );
        add_image_size( 'themesflat-blog-single', 2115, 900, true );    
        // QA PERF-007: product cards / quick view / bundles ask for this size everywhere (wp_get_attachment_image_url(..., 'themesflat-product')),
        // but it was never registered, so WordPress fell back to the full 1000px+ original for a ~270px card.
        // Box-resize (no crop) so non-square product photos are not cut. Existing images: run tools/qa/regenerate-product-images.php.
        add_image_size( 'themesflat-product', 600, 600, false );
    }

    // This theme uses wp_nav_menu() in one location.
    register_nav_menus( array(
        'primary' => esc_html__( 'Primary Menu (Includes mega menu)', 'ovinx' ),
        'mobile' => esc_html__( 'Mobile Menu', 'ovinx' ),
        'topbar' => esc_html__( 'Topbar Menu', 'ovinx' ),
        'category-menu' => esc_html__( 'Category Menu', 'ovinx' ),        
    ) );

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support( 'html5', array(
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
    ) );

    /*
     * Enable support for Post Formats.
     * See http://codex.wordpress.org/Post_Formats
     */
    add_theme_support( 'post-formats', array(
        'aside', 'image', 'gallery', 'video', 'quote', 'link', 'audio'
    ) );

    // Set up the WordPress core custom background feature.
    $args = array(
        'default-color' => 'ffffff',
        'default-image' => '',
    );

    add_theme_support( 'custom-background', $args );
    add_theme_support( 'custom-header', $args );

    // Custom stylesheet to the TinyMCE visual editor
    function themesflat_add_editor_styles() {
        add_editor_style( '/css/editor-style.css' );
    }
    add_action( 'admin_init', 'themesflat_add_editor_styles' );

    // Enable woocommerce support
    add_theme_support( 'woocommerce' );

}
endif; // themesflat_setup

add_action( 'after_setup_theme', 'themesflat_setup' );

function themesflat_wpfilesystem() {
    include_once (ABSPATH . '/wp-admin/includes/file.php');
    WP_Filesystem();
}

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function themesflat_widgets_init() {

    register_sidebar( array(
        'name'          => esc_html__( 'Sidebar Blog', 'ovinx' ),
        'id'            => 'blog-sidebar',
        'description'   => esc_html__( 'Add widgets here to appear in your sidebar Blog Sidebar.', 'ovinx' ),
        'before_widget' => '<div id="%1$s" class="sidebar-item widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h5 class="widget-title sb-title">',
        'after_title'   => '</h5>',
    ) );

    //Widget footer
    register_sidebar( array(
        'name'          => esc_html__( 'Footer Widget Area 1', 'ovinx' ),
        'id'            => 'footer-1',
        'description'   => esc_html__( 'Add widgets here to appear in your sidebar Footer area 1.', 'ovinx' ),
        'before_widget' => '<div id="%1$s" class="footer-col-block widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title footer-heading footer-heading-mobile text-white">',
        'after_title'   => '</h4>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Widget Area 2', 'ovinx' ),
        'id'            => 'footer-2',
        'description'   => esc_html__( 'Add widgets here to appear in your sidebar Footer area 2.', 'ovinx' ),
        'before_widget' => '<div id="%1$s" class="footer-col-block widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title footer-heading footer-heading-mobile text-white">',
        'after_title'   => '</h4>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Widget Area 3', 'ovinx' ),
        'id'            => 'footer-3',
        'description'   => esc_html__( 'Add widgets here to appear in your sidebar Footer area 3.', 'ovinx' ),
        'before_widget' => '<div id="%1$s" class="footer-col-block widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title footer-heading footer-heading-mobile text-white">',
        'after_title'   => '</h4>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Widget Area 4', 'ovinx' ),
        'id'            => 'footer-4',
        'description'   => esc_html__( 'Add widgets here to appear in your sidebar Footer area 4.', 'ovinx' ),
        'before_widget' => '<div id="%1$s" class="footer-col-block widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title footer-heading footer-heading-mobile text-white">',
        'after_title'   => '</h4>',
    ) );

    if ( class_exists( 'woocommerce' ) ) {
        register_sidebar( array(
            'name'          => esc_html__( 'Sidebar Shop', 'ovinx' ),
            'id'            => 'shop-sidebar',
            'description'   => esc_html__( 'Add widgets here to appear in your sidebar shop.', 'ovinx' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>',
        ) );

        register_sidebar( array(
            'name'          => esc_html__( 'After Sidebar Shop', 'ovinx' ),
            'id'            => 'after-shop-sidebar',
            'description'   => esc_html__( 'Add widgets here to appear in your after sidebar shop.', 'ovinx' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>',
        ) );

        register_sidebar( array(
            'name'          => esc_html__( 'Sidebar Single Shop', 'ovinx' ),
            'id'            => 'shop-single-sidebar',
            'description'   => esc_html__( 'Add widgets here to appear in your sidebar shop single.', 'ovinx' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>',
        ) );
    }
}
add_action( 'widgets_init', 'themesflat_widgets_init' );

/**
 * Footer widget areas (footer-1..4) dùng widget "Navigation Menu" có sẵn của WordPress -
 * markup mặc định (<ul class="menu"><li class="menu-item..."><a>) không khớp CSS thật
 * (.footer-menu-list / cl-text-mute link-white link-underline) của ovinx-html.
 * Chỉ can thiệp đúng 4 sidebar footer-*, không đụng menu ở nơi khác.
 */
function themesflat_footer_nav_menu_args( $nav_menu_args, $nav_menu, $args, $instance ) {
    if ( empty( $args['id'] ) || ! preg_match( '/^footer-[1-4]$/', $args['id'] ) ) {
        return $nav_menu_args;
    }

    $container_class = ( $nav_menu instanceof WP_Term )
        ? 'menu-' . $nav_menu->slug . '-container'
        : 'menu-container';

    $nav_menu_args['menu_class']         = 'footer-menu-list';
    $nav_menu_args['container_class']    = $container_class . ' tf-collapse-content';
    $nav_menu_args['footer_widget_menu'] = true;

    return $nav_menu_args;
}
add_filter( 'widget_nav_menu_args', 'themesflat_footer_nav_menu_args', 10, 4 );

function themesflat_footer_nav_menu_link_attributes( $atts, $item, $args, $depth ) {
    if ( empty( $args->footer_widget_menu ) ) {
        return $atts;
    }

    $atts['class'] = 'cl-text-mute link-white link-underline';

    return $atts;
}
add_filter( 'nav_menu_link_attributes', 'themesflat_footer_nav_menu_link_attributes', 10, 4 );

function themesflat_get_style($style) {
    $style = $style ?? '';
    return str_replace('italic', 'i', $style);
}

function themesflat_fonts_url() {
    $fonts_url = '';
    $typography_logo =  themesflat_get_json('typography_body');

    $typography_promo =  themesflat_get_json('typography_promo');
    $typography_body =  themesflat_get_json('typography_body');
    $typography_headings = themesflat_get_json('typography_headings');
    $typography_menu = themesflat_get_json('typography_menu');
    $typography_sub_menu =  themesflat_get_json('typography_sub_menu');
    $typography_topbar =  themesflat_get_json('typography_topbar');
    $typography_blockquote =  themesflat_get_json('typography_blockquote');
    $typography_blog_post_title =  themesflat_get_json('typography_blog_post_title');
    $typography_blog_post_meta = themesflat_get_json('typography_blog_post_meta');
    $typography_blog_post_buttons = themesflat_get_json('typography_blog_post_buttons');
    $typography_blog_single_title = themesflat_get_json('typography_blog_single_title');
    $typography_sidebar_widget_title = themesflat_get_json('typography_sidebar_widget_title');
    $typography_footer_widget_title = themesflat_get_json('typography_footer_widget_title');
    $typography_page_title = themesflat_get_json('typography_page_title');
    $typography_breadcrumb = themesflat_get_json('typography_breadcrumb');
    $typography_buttons = themesflat_get_json('typography_buttons');
    $typography_pagination = themesflat_get_json('typography_pagination');
    $typography_bottom_menu = themesflat_get_json('typography_bottom_menu');   
    $typography_footer = themesflat_get_json('typography_footer');
    $typography_bottom_copyright = themesflat_get_json('typography_bottom_copyright');

    $font_families = array(); 
    

    if ( '' != $typography_body ) {
        $font_families[] = $typography_body['family'].':100,200,300,400,500,600,700,900,'.themesflat_get_style($typography_body['style']);
    } else {
        $font_families[] = 'Poppins:400,400i,700,700i,900';
    }
    if ( '' != $typography_logo ) {
        $font_families[] = $typography_logo['family'].':100,200,300,400,500,600,700,900,'.themesflat_get_style($typography_logo['style']);
    } 
    if ( '' != $typography_headings ) {
        $font_families[] = $typography_headings['family'].':100,200,300,400,500,600,700,900,'.themesflat_get_style($typography_headings['style']);
    } 
    if ( '' != $typography_menu ) {
        $font_families[] = $typography_menu['family'].':100,200,300,400,500,600,700,900,'.themesflat_get_style($typography_menu['style']);
    }
    if ( '' != $typography_sub_menu ) {
        $font_families[] = $typography_sub_menu['family'].':100,200,300,400,500,600,700,900,'.themesflat_get_style($typography_sub_menu['style']);
    }
    if ( '' != $typography_topbar ) {
        $font_families[] = $typography_topbar['family'].':100,200,300,400,500,600,700,900,'.themesflat_get_style($typography_topbar['style']);
    }
    if ( '' != $typography_blockquote ) {
        $font_families[] = $typography_blockquote['family'].':100,200,300,400,500,600,700,900,'.themesflat_get_style($typography_blockquote['style']);
    }
    if ( '' != $typography_blog_post_title ) {
        $font_families[] = $typography_blog_post_title['family'].':100,200,300,400,500,600,700,900,'.themesflat_get_style($typography_blog_post_title['style']);
    }
    if ( '' != $typography_blog_post_meta ) {
        $font_families[] = $typography_blog_post_meta['family'].':100,200,300,400,500,600,700,900,'.themesflat_get_style($typography_blog_post_meta['style']);
    }
    if ( '' != $typography_blog_post_buttons ) {
        $font_families[] = $typography_blog_post_buttons['family'].':100,200,300,400,500,600,700,900,'.themesflat_get_style($typography_blog_post_buttons['style']);
    }
    if ( '' != $typography_blog_single_title ) {
        $font_families[] = $typography_blog_single_title['family'].':100,200,300,400,500,600,700,900,'.themesflat_get_style($typography_blog_single_title['style']);
    }
    if ( '' != $typography_sidebar_widget_title ) {
        $font_families[] = $typography_sidebar_widget_title['family'].':100,200,300,400,500,600,700,900,'.themesflat_get_style($typography_sidebar_widget_title['style']);
    }
    if ( '' != $typography_footer_widget_title ) {
        $font_families[] = $typography_footer_widget_title['family'].':100,200,300,400,500,600,700,900,'.themesflat_get_style($typography_footer_widget_title['style']);
    }
    if ( '' != $typography_page_title ) {
        $font_families[] = $typography_page_title['family'].':100,200,300,400,500,600,700,900,'.themesflat_get_style($typography_page_title['style']);
    }
    if ( '' != $typography_breadcrumb ) {
        $font_families[] = $typography_breadcrumb['family'].':100,200,300,400,500,600,700,900,'.themesflat_get_style($typography_breadcrumb['style']);
    }
    if ( '' != $typography_buttons ) {
        $font_families[] = $typography_buttons['family'].':100,200,300,400,500,600,700,900,'.themesflat_get_style($typography_buttons['style']);
    }
    if ( '' != $typography_pagination ) {
        $font_families[] = $typography_pagination['family'].':100,200,300,400,500,600,700,900,'.themesflat_get_style($typography_pagination['style']);
    }
    if ( '' != $typography_bottom_menu ) {
        $font_families[] = $typography_bottom_menu['family'].':100,200,300,400,500,600,700,900,'.themesflat_get_style($typography_bottom_menu['style']);
    }
    if ( '' != $typography_footer ) {
        $font_families[] = $typography_footer['family'].':100,200,300,400,500,600,700,900,'.themesflat_get_style($typography_footer['style']);
    }
    if ( '' != $typography_bottom_copyright ) {
        $font_families[] = $typography_bottom_copyright['family'].':100,200,300,400,500,600,700,900,'.themesflat_get_style($typography_bottom_copyright['style']);
    } 
    if ( '' != $typography_promo ) {
        $font_families[] = $typography_promo['family'].':100,200,300,400,500,600,700,900,'.themesflat_get_style($typography_promo['style']);
    }   
    
    // Performance: every typography option pushed its own "Family:100,200,...900" entry, so one family (Barlow) was
    // requested ~20 times with 9 weights each. Collapse to ONE entry per family and only the weights the stylesheet
    // really uses (400/500/600/700 — see css/styles.css), and ask Google for font-display: swap.
    $families = array();
    foreach ( $font_families as $font_family ) {
        $name = trim( strtok( $font_family, ':' ) );
        if ( '' !== $name ) {
            $families[ $name ] = $name . ':400,500,600,700';
        }
    }

    $query_args = array(
        'family'  => implode( '|', array_values( $families ) ),
        'display' => 'swap',
    );

    $fonts_url = add_query_arg( array_map( 'rawurlencode', $query_args ), 'https://fonts.googleapis.com/css' );

    return esc_url_raw( $fonts_url );
}

// Elementor prints its own Google Fonts <link>s (Roboto, Roboto Slab and Barlow again, 18 variants each, render-blocking).
// The theme already loads Barlow (above), and the Elementor kit's global fonts are mapped to Barlow in css/styles.css.
add_filter( 'elementor/frontend/print_google_fonts', '__return_false' );

/**
 * Open the connection to the font hosts early (preconnect) and preload the icon font that every page needs, so the
 * icons don't wait behind the render-blocking stylesheets.
 */
function ovinx_font_resource_hints( $urls, $relation_type ) {
    if ( 'preconnect' === $relation_type && ! ovinx_use_local_fonts() ) {
        $urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' => 'anonymous' );
        $urls[] = array( 'href' => 'https://fonts.googleapis.com' );
    }
    return $urls;
}
add_filter( 'wp_resource_hints', 'ovinx_font_resource_hints', 10, 2 );

/**
 * Inline @font-face for the self-hosted Barlow (see ovinx_use_local_fonts()) + preload of the latin 400 and 600 files.
 * Printed at priority 1 so it precedes every stylesheet.
 */
function ovinx_print_local_fonts() {
    if ( ! ovinx_use_local_fonts() ) {
        return;
    }
    $dir = get_template_directory_uri() . '/fonts/barlow';
    $css = file_get_contents( get_template_directory() . '/fonts/barlow/barlow.css' );
    foreach ( array( 'barlow-400-latin', 'barlow-600-latin' ) as $file ) {
        printf( '<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n", esc_url( $dir . '/' . $file . '.woff2' ) );
    }
    echo '<style id="ovinx-local-fonts">' . str_replace( '{{FONT_DIR}}', esc_url( $dir ), $css ) . "</style>\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- theme-owned file
}
add_action( 'wp_head', 'ovinx_print_local_fonts', 1 );
function ovinx_preload_icon_font() {
    // Same URL (incl. ?query) that css/icon-ovinx.css requests, otherwise the preload would be wasted.
    printf( '<link rel="preload" href="%s" as="font" type="font/woff" crossorigin>' . "\n", esc_url( THEMESFLAT_LINK . 'fonts/icomoon.woff?pjx77z' ) );
}
add_action( 'wp_head', 'ovinx_preload_icon_font', 1 );

/**
 * Hero slider image = the page's Largest Contentful Paint element. WordPress already decides loading/fetchpriority for
 * <img> tags in rendered content (wp_get_loading_optimization_attributes); here the slideshow widget's slide images
 * (.scale-item) are told explicitly: the first one is requested immediately with fetchpriority="high" (never lazy),
 * every other slide is lazy-loaded.
 */
function ovinx_slideshow_image_loading( $loading_attrs, $tag_name, $attr ) {
    if ( 'img' !== $tag_name || ! is_array( $loading_attrs ) ) {
        return $loading_attrs;
    }

    // WordPress marks the FIRST content image it meets as the LCP candidate (fetchpriority="high"). On this theme that
    // image is a mega-menu banner in the header, not the hero — so core never gets to pick; the slideshow widget
    // (ovinx-addon widget-slideshow.php) sets fetchpriority on its first slide itself.
    unset( $loading_attrs['fetchpriority'] );

    return $loading_attrs;
}
add_filter( 'wp_get_loading_optimization_attributes', 'ovinx_slideshow_image_loading', 10, 3 );

/**
 * <meta name="description"> fallback (Lighthouse SEO: "Document does not have a meta description"). Skipped whenever a
 * SEO plugin is active — those print their own, and two descriptions would be worse than none.
 */
function ovinx_meta_description() {
    if ( defined( 'WPSEO_VERSION' ) || class_exists( 'RankMath' ) || defined( 'AIOSEO_VERSION' ) || defined( 'SEOPRESS_VERSION' ) || defined( 'THE_SEO_FRAMEWORK_VERSION' ) ) {
        return;
    }

    $description = '';

    if ( is_singular() ) {
        $post = get_queried_object();
        if ( $post instanceof WP_Post && ! post_password_required( $post ) ) {
            $description = has_excerpt( $post ) ? $post->post_excerpt : wp_strip_all_tags( strip_shortcodes( $post->post_content ) );
        }
    } elseif ( function_exists( 'is_shop' ) && is_shop() ) {
        $shop_page = get_post( wc_get_page_id( 'shop' ) );
        if ( $shop_page instanceof WP_Post ) {
            $description = has_excerpt( $shop_page ) ? $shop_page->post_excerpt : wp_strip_all_tags( strip_shortcodes( $shop_page->post_content ) );
        }
    } elseif ( is_category() || is_tag() || is_tax() ) {
        $description = term_description();
    }

    if ( '' === trim( wp_strip_all_tags( (string) $description ) ) ) {
        $description = get_bloginfo( 'description', 'display' );
    }
    if ( '' === trim( (string) $description ) ) {
        $description = get_bloginfo( 'name', 'display' );
    }

    $description = trim( preg_replace( '/\s+/', ' ', wp_strip_all_tags( (string) $description ) ) );
    $description = wp_trim_words( $description, 28, '…' );

    if ( '' !== $description ) {
        echo '<meta name="description" content="' . esc_attr( $description ) . '">' . "\n";
    }
}
add_action( 'wp_head', 'ovinx_meta_description', 1 );

/**
 * Generate WebP for every resized copy of new JPEG uploads (the original stays as uploaded). WebP is ~30 % smaller at the
 * same quality; WordPress puts the resized files into srcset automatically. Only when the server can write WebP.
 */
function ovinx_webp_subsizes( $formats ) {
    if ( function_exists( 'wp_image_editor_supports' ) && wp_image_editor_supports( array( 'mime_type' => 'image/webp' ) ) ) {
        $formats['image/jpeg'] = 'image/webp';
    }
    return $formats;
}
add_filter( 'image_editor_output_format', 'ovinx_webp_subsizes' );

/**
 * PERF (PageSpeed mobile): Barlow is self-hosted instead of fetched from Google Fonts. The Google CSS was a render-blocking
 * request to a third-party host (new DNS + TCP + TLS connection, then a second connection to fonts.gstatic.com for the files):
 * ~800ms of the mobile First Contentful Paint. Now the @font-face rules are printed inline in <head> (no request) and the two
 * most-used files are preloaded. Only applies while Barlow is the only family set in the Customizer typography options; if the
 * site owner picks another Google family the old Google Fonts <link> is used for everything, exactly as before.
 */
function ovinx_use_local_fonts() {
    static $use = null;
    if ( null !== $use ) {
        return $use;
    }
    $use = false;
    $query = wp_parse_url( themesflat_fonts_url(), PHP_URL_QUERY );
    if ( $query ) {
        parse_str( $query, $args );
        $names = array();
        foreach ( explode( '|', (string) ( $args['family'] ?? '' ) ) as $family ) {
            $names[] = trim( strtok( $family, ':' ) );
        }
        $names = array_unique( array_filter( $names ) );
        $use   = ( array( 'Barlow' ) === array_values( $names ) ) && is_readable( get_template_directory() . '/fonts/barlow/barlow.css' );
    }
    return $use;
}

function themesflat_scripts_styles() {
    if ( ovinx_use_local_fonts() ) {
        return;
    }
    wp_enqueue_style( 'themesflat-theme-slug-fonts', themesflat_fonts_url(), array(), null );
}

add_action( 'wp_enqueue_scripts', 'themesflat_scripts_styles' );

/**
 * Enqueue scripts and styles.
 */

/**
 * QA P1-02: cache-busting version for the theme's OWN css/js = file modification time, so a browser/CDN refetches
 * a file exactly when it changes (no more "Ctrl+F5" after every edit) and keeps it cached otherwise.
 * Replaces the fixed '1.0.0', the WordPress-version fallback (?ver=<WP version>), missing versions and time().
 * Third-party libraries under css|js/3rd keep their own handling.
 *
 * @param string $rel Path relative to the theme root, e.g. 'css/styles.css'.
 * @return string
 */
function ovinx_asset_ver( $rel ) {
    $file = THEMESFLAT_DIR . ltrim( $rel, '/' );
    return file_exists( $file ) ? (string) filemtime( $file ) : (string) wp_get_theme()->get( 'Version' );
}

/**
 * QA P1-06: product cards ask for each product's main + first gallery image one by one, which costs a
 * "SELECT * FROM wp_posts WHERE ID = N" (+ its meta) per image. Load them in a single batch for every frontend
 * query that returns products (theme loops, Elementor widgets, archives). Markup is unchanged.
 *
 * @param WP_Post[] $posts Posts returned by a WP_Query.
 * @return WP_Post[]
 */
function ovinx_prime_product_image_caches( $posts ) {
    if ( is_admin() || empty( $posts ) || ! function_exists( '_prime_post_caches' ) ) {
        return $posts;
    }

    $product_ids = array();
    foreach ( $posts as $post ) {
        if ( $post instanceof WP_Post && 'product' === $post->post_type ) {
            $product_ids[] = (int) $post->ID;
        }
    }
    if ( empty( $product_ids ) ) {
        return $posts;
    }

    update_meta_cache( 'post', $product_ids );

    $image_ids = array();
    foreach ( $product_ids as $product_id ) {
        $thumb = (int) get_post_meta( $product_id, '_thumbnail_id', true );
        if ( $thumb ) {
            $image_ids[ $thumb ] = $thumb;
        }
        $gallery = explode( ',', (string) get_post_meta( $product_id, '_product_image_gallery', true ) );
        $first   = (int) ( $gallery[0] ?? 0 ); // the card's hover image
        if ( $first ) {
            $image_ids[ $first ] = $first;
        }
    }

    if ( $image_ids ) {
        _prime_post_caches( array_values( $image_ids ), false, true );
    }

    return $posts;
}
add_filter( 'the_posts', 'ovinx_prime_product_image_caches' );

/**
 * QA P1-06: `woocommerce_placeholder_image` can point at an attachment that no longer exists (here: ID 7). WooCommerce
 * then runs wp_get_attachment_image_src() on it for every wc_placeholder_img_src() call - and WordPress never caches a
 * missing post - so every product card paid 2 extra "SELECT * FROM wp_posts WHERE ID = 7". When the attachment is
 * gone, report "no custom placeholder" (0): wc_placeholder_img_src() then returns the same bundled placeholder.png it
 * already falls back to, so the output is identical. The check runs once per request.
 *
 * @param mixed $value Stored option value (attachment ID or URL).
 * @return mixed
 */
function ovinx_valid_placeholder_image( $value ) {
    static $exists = array();

    if ( is_admin() || ! is_numeric( $value ) || (int) $value <= 0 ) {
        return $value;
    }

    $id = (int) $value;
    if ( ! isset( $exists[ $id ] ) ) {
        $exists[ $id ] = (bool) get_post( $id );
    }

    return $exists[ $id ] ? $value : 0;
}
add_filter( 'option_woocommerce_placeholder_image', 'ovinx_valid_placeholder_image' );

/**
 * QA P1-11: wp-block-library (~138KB) is only needed on a product page when the description itself is made of blocks
 * or a block widget is shown in a sidebar/footer; otherwise skip it.
 */
function ovinx_maybe_dequeue_block_library() {
    if ( ! function_exists( 'is_product' ) || ! is_product() ) {
        return;
    }
    if ( has_blocks( get_post() ) ) {
        return;
    }

    // Sidebars a product page can actually print: the shop ones + whichever areas the footer columns 2-4 point to.
    $sidebars = array( 'shop-sidebar', 'after-shop-sidebar', 'shop-single-sidebar' );
    for ( $i = 2; $i <= 4; $i++ ) {
        $sidebars[] = themesflat_get_opt( 'footer' . $i );
    }
    $assigned = wp_get_sidebars_widgets();
    foreach ( $sidebars as $sidebar ) {
        foreach ( (array) ( $assigned[ $sidebar ] ?? array() ) as $widget_id ) {
            if ( 0 === strpos( (string) $widget_id, 'block-' ) ) {
                return; // a block widget is shown on this page: it needs the block styles.
            }
        }
    }
    wp_dequeue_style( 'wp-block-library' );
}
add_action( 'wp_enqueue_scripts', 'ovinx_maybe_dequeue_block_library', 100 );

function themesflat_scripts() {
    // Theme stylesheet.


    wp_register_style( 'icon-ovinx', THEMESFLAT_LINK . 'css/icon-ovinx.css', array(), ovinx_asset_ver( 'css/icon-ovinx.css' ) );
    wp_register_style( 'themesflat-animated', THEMESFLAT_LINK . 'css/3rd/animate.css' );
    wp_register_style( 'themesflat-toast', THEMESFLAT_LINK . 'css/3rd/jquery.toast.min.css');
    wp_register_style( 'themesflat-bootstrap', THEMESFLAT_LINK . 'css/3rd/bootstrap.min.css' );
    wp_register_style( 'themesflat-bootstrap-select', THEMESFLAT_LINK . 'css/3rd/bootstrap-select.min.css' );
    wp_register_style( 'themesflat-swiper', THEMESFLAT_LINK . 'css/3rd/swiper-bundle.min.css' );

    $libs_array = [
        'icon-ovinx',
        'themesflat-animated',
        'themesflat-toast',
        'themesflat-bootstrap',
        'themesflat-bootstrap-select',
        'themesflat-swiper'
    ];

    wp_enqueue_style( 'themesflat-styles', THEMESFLAT_LINK . 'css/styles.css', $libs_array, ovinx_asset_ver( 'css/styles.css' ) );
    // Typography for plain WordPress editor content (lists, tables, blockquotes, core blocks…) that styles.css resets away.
    wp_enqueue_style( 'ovinx-wp-core', THEMESFLAT_LINK . 'css/wp-core.css', array( 'themesflat-styles' ), ovinx_asset_ver( 'css/wp-core.css' ) );

    wp_register_style( 'nice-select', THEMESFLAT_LINK . 'css/3rd/nice-select.css' );

    if ( class_exists( 'woocommerce' ) ) {
        wp_enqueue_script( 'wc-cart-fragments' );
        if( is_rtl() ){
            wp_style_add_data( 'tf-woo', 'rtl', 'replace' );
        }
    }

    wp_enqueue_style( 'themesflat-inline-css', THEMESFLAT_LINK . 'css/3rd/inline-css.css', array(), ovinx_asset_ver( 'css/3rd/inline-css.css' ) );

    if ( themesflat_get_opt('enable_smooth_scroll') == 1 ) {
       wp_enqueue_script( 'smoothscroll', THEMESFLAT_LINK . 'js/smoothscroll.js', array(), ovinx_asset_ver( 'js/smoothscroll.js' ), true);
    }
    
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }

    wp_register_script('nice-select', THEMESFLAT_LINK . 'js/3rd/nice-select.js', array('jquery'),'',true);
    wp_register_script('nouislider', THEMESFLAT_LINK . 'js/3rd/nouislider.min.js', array('jquery'),'',true);
    wp_enqueue_script('themesflat-toast', THEMESFLAT_LINK . 'js/3rd/jquery.toast.min.js', array('jquery'),'',true);
    wp_enqueue_script( 'themesflat-bootstrap', THEMESFLAT_LINK . 'js/3rd/bootstrap.min.js', array('jquery'), null, true );
    wp_enqueue_script( 'themesflat-bootstrap-select', THEMESFLAT_LINK . 'js/3rd/bootstrap-select.min.js', array('themesflat-bootstrap'), null, true );
    wp_register_script( 'themesflat-swiper', THEMESFLAT_LINK . 'js/3rd/swiper-bundle.min.js', array(), null, true );    
    wp_enqueue_script( 'infinityslide', THEMESFLAT_LINK . 'js/3rd/infinityslide.js', array(), null, true );        
    wp_register_script( 'count-down', THEMESFLAT_LINK . 'js/3rd/count-down.js', array(), null, true );

    if ( ! wp_script_is( 'themesflat-lazysize', 'registered' ) ) {
        wp_register_script('themesflat-lazysize', THEMESFLAT_LINK . 'js/3rd/lazysize.min.js', array(),'',true);
    }

    wp_enqueue_script( 'themesflat-main', THEMESFLAT_LINK . 'js/main.js', array('themesflat-bootstrap-select', 'themesflat-lazysize', 'themesflat-swiper'), ovinx_asset_ver( 'js/main.js' ), true );

    if( is_rtl() ){
        wp_style_add_data( 'themesflat-main', 'rtl', 'replace' );
        wp_style_add_data( 'themesflat-responsive', 'rtl', 'replace' );
    }
}

add_action( 'wp_enqueue_scripts', 'themesflat_scripts', 10 );


// Customizer additions.
require THEMESFLAT_DIR . 'inc/customizer.php';

// Helper
require THEMESFLAT_DIR . 'inc/helper.php';

// Struct
require THEMESFLAT_DIR . 'inc/structure.php';

// Breadcrumbs additions.
require THEMESFLAT_DIR . 'inc/breadcrumb.php';

// Custom template tags for this theme.
require THEMESFLAT_DIR . 'inc/template-tags.php';

// Style.
require THEMESFLAT_DIR . 'inc/styles.php';

// Required plugins
require_once THEMESFLAT_DIR . 'inc/plugins/class-tgm-plugin-activation.php';

// Plugin Activation
require_once THEMESFLAT_DIR . 'inc/plugins/plugins.php';

require THEMESFLAT_DIR . "inc/options/options-definition.php";
require_once( THEMESFLAT_DIR . 'inc/options/controls/social_icons.php');
require_once( THEMESFLAT_DIR . 'inc/options/controls/number.php');
require_once( THEMESFLAT_DIR . 'inc/options/controls/dropdown-topbar.php');
require_once( THEMESFLAT_DIR . 'inc/options/controls/dropdown-sidebars.php');
require_once( THEMESFLAT_DIR . 'inc/options/controls/dropdown-pages.php');
require_once( THEMESFLAT_DIR . 'inc/options/controls/box-control.php');
require_once( THEMESFLAT_DIR . 'inc/options/controls/typography.php');
require_once( THEMESFLAT_DIR . 'inc/options/controls/radio-images.php');
require_once( THEMESFLAT_DIR . 'inc/options/controls/check-box.php');
require_once( THEMESFLAT_DIR . 'inc/options/controls/color_overlay.php');
require_once( THEMESFLAT_DIR . 'inc/options/controls/multi-images.php');
require_once( THEMESFLAT_DIR . 'inc/options/controls/styler_slider.php');
require_once( THEMESFLAT_DIR . 'inc/options/controls/draganddrop-controls.php');
require_once( THEMESFLAT_DIR . 'inc/options/controls/repeater-control.php');
require_once( THEMESFLAT_DIR . 'inc/options/controls/repeater-control2.php');
require_once( THEMESFLAT_DIR . 'inc/options/controls/testi-thankyou.php');
require_once( THEMESFLAT_DIR . 'inc/elementor-options/elementor-options.php');
require_once( THEMESFLAT_DIR . 'inc/elementor-options/elementor-functions.php');
require_once( THEMESFLAT_DIR . 'demo/import-demo.php');

// Load Customizer Style
function themesflat_load_customizer_style() {
    wp_enqueue_script( 'wp-plupload' );
    wp_enqueue_style( 'plugin-install' ); 
    wp_enqueue_script('jquery-ui');

    wp_register_style('themesflat-customizer', THEMESFLAT_LINK .'/css/admin/customizer.min.css', false, filemtime( THEMESFLAT_DIR . 'css/admin/customizer.min.css' ) );
    wp_enqueue_style('themesflat-customizer' );
    
    wp_enqueue_style( 'icon-ovinx', THEMESFLAT_LINK . 'css/icon-ovinx.css' );

    wp_enqueue_style('themesflat-alpha-color-picker', THEMESFLAT_LINK .'/css/admin/alpha-color-picker.min.css', false, '1.0.0' );    
    wp_enqueue_script('themesflat-alpha-color-picker', THEMESFLAT_LINK . 'js/admin/alpha-color-picker.js', array('wp-color-picker'),'2.1.2',true);
    wp_enqueue_script('themesflat-multi-image', THEMESFLAT_LINK . 'js/admin/multi-image.js', array('jquery','customize-preview'),'', true );
    wp_enqueue_script('themesflat-sortablejs', THEMESFLAT_LINK . 'js/admin/3rd/Sortable.min.js', array(), '1.15.0', true);
    wp_enqueue_script('themesflat-customizer', THEMESFLAT_LINK .'/js/admin/customizer.js', array( 'jquery','customize-preview', 'themesflat-sortablejs' ), filemtime( THEMESFLAT_DIR . 'js/admin/customizer.js' ), true );
    wp_enqueue_script('themesflat-rp-topbar', THEMESFLAT_LINK . 'js/admin/customizer-repeater-controls-topbar.js', array('jquery'), null, true );
    wp_enqueue_script('themesflat-rp-1', THEMESFLAT_LINK . 'js/admin/customizer-repeater-controls.js', array('jquery'), null, true );
    wp_enqueue_script('themesflat-rp-2', THEMESFLAT_LINK . 'js/admin/customizer-repeater2-controls.js', array('jquery'), null, true );
}

add_action( 'customize_controls_enqueue_scripts', 'themesflat_load_customizer_style' );
add_action( 'admin_enqueue_scripts', 'themesflat_load_customizer_style' ); 

// Load Admin Style
function themesflat_load_admin_style() {
    wp_enqueue_style( 'themesflat-admin', THEMESFLAT_LINK .'/css/admin/admin.css', false, '1.0.0' );
}

add_action( 'admin_enqueue_scripts', 'themesflat_load_admin_style', 999 );

add_action('pre_get_posts', 'tf_blog_post_per_page');
function tf_blog_post_per_page($query) {
    $posts_per_page = themesflat_get_opt('blog_posts_per_page');
    if (isset($_GET['posts_per_page'])){
		$posts_per_page = sanitize_text_field($_GET['posts_per_page']);
	}
    
    if (!is_admin() && $query->is_main_query() && is_home()) {
        $query->set('posts_per_page',$posts_per_page );
    }
}

// Woocommerce
if ( class_exists( 'woocommerce' )) {
    require_once THEMESFLAT_DIR . 'woocommerce/class-woo/class-woo-hook.php';
    new Woo_Hook();
        
    require_once THEMESFLAT_DIR . 'woocommerce/class-woo/class-cart-checkout-hook.php';
    TFWC_Cart_Checkout::instance();

    require_once THEMESFLAT_DIR . 'woocommerce/class-woo/class-single-product-hook.php';
    Woo_Single_Product_Hook::instance();

    require_once THEMESFLAT_DIR . 'woocommerce/class-woo/class-setting-product.php';
    new Woo_Product_Setting();
    
    
    // Display products per page
    add_filter( 'loop_shop_per_page', 'tfwc_products_per_page', 20 );
    function tfwc_products_per_page() {
        $items = themesflat_get_opt('shop_products_per_page');

        if( !empty($_GET['products_per_page']) ){
            $items = intval($_GET['products_per_page']);
        }

        if ( !$items || $items <= 0 ) {
            return 8;
        } else {
            return $items;
        }
        
    }

    add_action('wp',  'tfwc_save_recently_viewed_product');
    function tfwc_save_recently_viewed_product() {
        if (is_singular('product')) {
            $product_id = get_the_ID();
    
            $recently_viewed = isset($_COOKIE['recently_viewed_products']) ? explode(',', $_COOKIE['recently_viewed_products']) : [];
    
            $recently_viewed = array_diff($recently_viewed, [$product_id]);
    
            array_unshift($recently_viewed, $product_id);
    
            // $limit = (int) themesflat_get_opt('recently_limit');
            $limit = 15;

            if ($limit <= 0) {
                $limit = 5;
            }
    
            $recently_viewed = array_slice($recently_viewed, 0, $limit);
    
            setcookie('recently_viewed_products', implode(',', $recently_viewed), time() + 30 * DAY_IN_SECONDS, '/');
    
            $_COOKIE['recently_viewed_products'] = implode(',', $recently_viewed);
        }
    }

}

// Search Woocommerce
add_action( 'pre_get_posts', 'tf_search_product' );

function tf_search_product( $query ) {
  // Only force a product search when WooCommerce exists; otherwise normal posts/pages must be searchable.
  if( ! is_admin() && is_search() && $query->is_main_query() && class_exists( 'WooCommerce' ) ) {
    $query->set( 'post_type', 'product' );
  }
}

// Load More Ajax Security

function tf_enqueue_script_style() {
    // Localize the script with new data
    $script_data_array = array(
      'ajaxurl' => admin_url( 'admin-ajax.php' ),
      'security' => wp_create_nonce( 'load_more_posts' ),
    );
    $user_vars = array(
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'nonce' => wp_create_nonce( 'custom-ajax-nonce' ),
      );
    $search_data_array = array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( '_flat_nonce' ),
        'ajax_search'          => intval(1),
        "search_content_type" => "product",
      );
    wp_localize_script( 'themesflat-main', 'ajax_object', $user_vars );
    wp_localize_script( 'themesflat-main', 'blog', $script_data_array );
    wp_localize_script( 'themesflat-main', 'the_ajax_script', $search_data_array );

    $filter_var = array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'filter_nonce' => wp_create_nonce('filter-nonce'),		
	);
	wp_localize_script('themesflat-main', 'filter_var', $filter_var);
    // Enqueued script with localized data.
    wp_enqueue_script( 'themesflat-main' ); 
}

add_action( 'wp_enqueue_scripts', 'tf_enqueue_script_style' );
  
function ovinx_load_posts_by_ajax_callback() {
    check_ajax_referer('load_more_posts', 'security');

	$blog_layout = themesflat_get_opt('blog_archive_style');
	
	$imgs = array(
		'blog-grid' => 'themesflat-blog-grid',
		'blog-list' => 'themesflat-blog',
		);
	$class_names = array(
		1 => 'blog-one-column',
		2 => 'blog-two-columns',
		3 => 'blog-three-columns',
		4 => 'blog-four-columns',
		);		

	$themesflat_thumbnail = $imgs[$blog_layout];
	$themesflat_thumbnail = apply_filters('themesflat/template/themesflat_thumbnail',$themesflat_thumbnail);
	$class = array('blog-archive');
	$class[] = 'archive-'.get_post_type();
	$class[] = $blog_layout;

	$class = apply_filters('themesflat/template/blog_class',$class);
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="wrap-content-area clearfix">
                    <div id="primary" class="content-area" >
                        <div id="main" class="post-wrap">
                        <?php if ( have_posts() ) : ?>
                        <div class="wrap-blog-article <?php echo esc_attr(implode(" ",$class));?> has-post-content">
                            <?php /* Start the Loop */ ?>
                            <?php while ( have_posts() ) : the_post(); ?>

                                <?php
                                    /* Include the Post-Format-specific template for the content.
                                    * If you want to override this in a child theme, then include a file
                                    * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                                    */
                                    get_template_part( 'content', get_post_type() );
                                ?>

                            <?php endwhile; ?>		
                        </div>	
                        <?php else : ?>

                            <?php get_template_part( 'content', 'none' ); ?>

                        <?php endif; ?>
                        </div><!-- #main -->
                        <div class="clearfix">
                        <?php	        
                            get_template_part( 'tpl/pagination' );				
                        ?>
                        </div>
                    </div><!-- #primary -->
                    <?php 
                    if ( themesflat_get_opt( 'sidebar_layout' ) == 'sidebar-left' || themesflat_get_opt( 'sidebar_layout' ) == 'sidebar-right' ) :
                        get_sidebar();
                    endif;
                    ?>
                </div><!-- /.wrap-content-area -->
            </div><!-- /.col-md-12 -->
        </div><!-- /.row -->
    </div>
    <?php   
    wp_die();
}

add_action('wp_ajax_load_posts_by_ajax', 'ovinx_load_posts_by_ajax_callback');
add_action('wp_ajax_nopriv_load_posts_by_ajax', 'ovinx_load_posts_by_ajax_callback'); 

themesflat_remove_hook( 'render_block', 'wp_render_layout_support_flag', 10, 2 );
themesflat_remove_hook( 'render_block', 'gutenberg_render_layout_support_flag', 10, 2 );

add_filter('wpcf7_autop_or_not', '__return_false');

// Redirect single product when search template
add_action( 'template_redirect', 'ovinx_redirect_to_product_if_single_result' );

function ovinx_redirect_to_product_if_single_result() {
    // WP unit-test fix: the theme must also work on sites without WooCommerce (search was a fatal "WC_Product_Query not found").
    if ( ! class_exists( 'WC_Product_Query' ) ) {
        return;
    }
    if ( is_search() && !is_admin() && isset( $_GET['s'] ) ) {
        $query = new WC_Product_Query( array(
            's'              => sanitize_text_field( $_GET['s'] ),
            'limit'          => 2, 
            'status'         => 'publish',
            'return'         => 'ids',
        ) );

        $products = $query->get_products();

        if ( count( $products ) === 1 ) {
            wp_redirect( get_permalink( $products[0] ) );
            exit;
        }
    }
}

function ovinx_get_woocs_currencies() {
  if ( ! class_exists('WOOCS') ) return [];
  global $WOOCS;
  if ( empty($WOOCS) ) return [];
  return (array) $WOOCS->get_currencies();
}



/**
 * The newsletter (Mailchimp for WP) form is stored in the database and its submit button is icon-only —
 * add the accessible name Lighthouse asks for ("Buttons do not have an accessible name") without editing the saved form.
 */
function ovinx_mc4wp_submit_label( $content ) {
    return str_replace(
        '<button type="submit" class="btn-action_submit">',
        '<button type="submit" class="btn-action_submit" aria-label="' . esc_attr__( 'Subscribe', 'ovinx' ) . '">',
        $content
    );
}
add_filter( 'mc4wp_form_content', 'ovinx_mc4wp_submit_label' );

/**
 * WooCommerce labels the button of an out-of-stock / non-purchasable product "Read more" — a link text Lighthouse
 * (SEO > "Links do not have descriptive text") rejects, and a poor label for a product card anyway.
 */
function ovinx_non_generic_add_to_cart_text( $text, $product = null ) {
    // WooCommerce falls back to "Read more" for a simple product that is out of stock / not purchasable and for a variable
    // product that is not purchasable (see WC_Product_Simple / WC_Product_Variable::add_to_cart_text()).
    if ( $product instanceof WC_Product ) {
        $unavailable = ( $product->is_type( 'simple' ) && ( ! $product->is_purchasable() || ! $product->is_in_stock() ) )
            || ( $product->is_type( 'variable' ) && ! $product->is_purchasable() );
        if ( $unavailable ) {
            return __( 'View product', 'ovinx' );
        }
    }
    return $text;
}
add_filter( 'woocommerce_product_add_to_cart_text', 'ovinx_non_generic_add_to_cart_text', 99, 2 );

/**
 * Final clean-up of <img> tags on the rendered page (front end only).
 *  - Elementor, WordPress and the widgets each add loading / fetchpriority / decoding / class to the same tag, so some
 *    tags carry the attribute twice (invalid HTML; the browser keeps the first). Keep the first of each.
 *  - Only ONE image may be "high priority": the first hero slide (.scale-item), which is the mobile LCP element.
 *    Everything else loses fetchpriority="high" (WordPress otherwise gives it to the first content image it meets — a
 *    hidden mega-menu banner — so the hero was fetched late).
 */
function ovinx_normalize_img_tags( $html ) {
    if ( false === stripos( $html, '<img' ) ) {
        return $html;
    }

    $hero_done = false;
    $unique    = array( 'class', 'loading', 'fetchpriority', 'decoding', 'alt', 'width', 'height', 'src', 'srcset', 'sizes' );

    return preg_replace_callback(
        '/<img\b[^>]*>/i',
        function ( $m ) use ( &$hero_done, $unique ) {
            $tag  = $m[0];
            $seen = array();

            $tag = preg_replace_callback(
                '/\s([a-z][a-z0-9\-:]*)=("[^"]*"|\'[^\']*\')/i',
                function ( $a ) use ( &$seen, $unique ) {
                    $name = strtolower( $a[1] );
                    if ( in_array( $name, $unique, true ) ) {
                        if ( isset( $seen[ $name ] ) ) {
                            return '';
                        }
                        $seen[ $name ] = true;
                    }
                    return $a[0];
                },
                $tag
            );

            if ( preg_match( '/\sfetchpriority=("|\')high\1/i', $tag ) ) {
                // The one allowed LCP image: the hero slide (.scale-item) or, on a blog post, the featured hero image (QA PERF-001).
                if ( ! $hero_done && ( false !== strpos( $tag, 'scale-item' ) || false !== strpos( $tag, 'attachment-themesflat-blog-single' ) || false !== strpos( $tag, 'data-lcp="1"' ) ) ) {
                    $hero_done = true;
                } else {
                    $tag = preg_replace( '/\sfetchpriority=("|\')high\1/i', '', $tag );
                }
            }

            return $tag;
        },
        $html
    );
}

function ovinx_start_img_normalizer() {
    if ( is_admin() || wp_doing_ajax() || is_feed() || is_robots() || is_embed() || is_customize_preview() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
        return;
    }
    if ( isset( $_GET['elementor-preview'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        return;
    }
    ob_start( 'ovinx_normalize_img_tags' );
}
add_action( 'template_redirect', 'ovinx_start_img_normalizer', 0 );

/**
 * PERF (PageSpeed mobile): three render-blocking <script>s sat in <head> on every page — underscore.js, wp-util.js and
 * WooCommerce's add-to-cart-variation.js (which depends on them; WordPress keeps a script's dependencies in the same group).
 * None is needed before the first paint, so move them to the footer. jQuery stays in <head> (inline scripts of plugins
 * call it while the page is parsed). jQuery Migrate (deprecation shim, +5KB and one more blocking request) is dropped on the
 * front end; the editor/admin keep it.
 */
function ovinx_footer_scripts() {
    if ( is_admin() || ( class_exists( '\Elementor\Plugin' ) && \Elementor\Plugin::$instance->preview->is_preview_mode() ) ) {
        return;
    }
    $scripts = wp_scripts();
    foreach ( array( 'underscore', 'wp-util', 'wc-add-to-cart-variation' ) as $handle ) {
        if ( isset( $scripts->registered[ $handle ] ) ) {
            $scripts->add_data( $handle, 'group', 1 );
        }
    }
}
add_action( 'wp_enqueue_scripts', 'ovinx_footer_scripts', 999 );

// PERF: WordPress's emoji detection script (inline JS + wp-emoji-release.min.js, ~60ms of main-thread time on mobile) is not
// needed — modern browsers render emoji natively.
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
add_filter( 'emoji_svg_url', '__return_false' );
function ovinx_drop_jquery_migrate( $scripts ) {
    if ( is_admin() || is_customize_preview() || isset( $_GET['elementor-preview'] ) || ! isset( $scripts->registered['jquery'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        return;
    }
    $scripts->registered['jquery']->deps = array_diff( (array) $scripts->registered['jquery']->deps, array( 'jquery-migrate' ) );
}
add_action( 'wp_default_scripts', 'ovinx_drop_jquery_migrate' );
/**
 * Stylesheet loading (front end only):
 *  - animate.css, jquery.toast, Contact Form 7's and the WCBoost CSS are not needed for the first paint, so they no longer
 *    block rendering: they are registered with media="print" (the browser still fetches them, at low priority) and switched
 *    to media="all" on window load, with a <noscript> fallback. WCBoost wishlist / compare / swatches only style buttons that
 *    are mostly below the fold (swatches stay blocking on a product page, where they are in the first screen).
 *  - css/icon-ovinx.css was requested twice: once by the theme (icon-ovinx) and once more by Elementor's custom icon
 *    library (elementor-icons-ovinx_icon). Drop Elementor's copy outside the editor/preview.
 */
function ovinx_defer_styles() {
    static $deferred = array();

    if ( is_admin() || ( class_exists( '\Elementor\Plugin' ) && \Elementor\Plugin::$instance->preview->is_preview_mode() ) ) {
        return $deferred;
    }

    $styles = wp_styles();

    if ( wp_style_is( 'icon-ovinx', 'enqueued' ) && wp_style_is( 'elementor-icons-ovinx_icon', 'enqueued' ) ) {
        wp_dequeue_style( 'elementor-icons-ovinx_icon' );
    }

    $handles = array( 'themesflat-animated', 'themesflat-toast', 'contact-form-7', 'wcboost-wishlist', 'wcboost-products-compare' );
    if ( ! ( function_exists( 'is_product' ) && is_product() ) ) {
        $handles[] = 'wcboost-variation-swatches';
    }

    foreach ( $handles as $handle ) {
        if ( isset( $deferred[ $handle ] ) || ! isset( $styles->registered[ $handle ] ) || ! wp_style_is( $handle, 'enqueued' ) ) {
            continue;
        }
        if ( in_array( $styles->registered[ $handle ]->args, array( 'all', '' ), true ) || null === $styles->registered[ $handle ]->args ) {
            $styles->registered[ $handle ]->args = 'print';
            $deferred[ $handle ]                 = true;
        }
    }

    return $deferred;
}
add_action( 'wp_print_styles', 'ovinx_defer_styles', 1 );
add_action( 'wp_print_footer_scripts', 'ovinx_defer_styles', 1 );

/**
 * Switches the deferred stylesheets to media="all" once the page has loaded and prints the <noscript> fallback.
 */
function ovinx_print_deferred_styles_loader() {
    $deferred = ovinx_defer_styles();
    if ( empty( $deferred ) ) {
        return;
    }

    $styles = wp_styles();
    $ids    = array();
    echo '<noscript>';
    foreach ( array_keys( $deferred ) as $handle ) {
        $obj   = $styles->registered[ $handle ];
        $ids[] = $handle . '-css';
        echo '<link rel="stylesheet" href="' . esc_url( $styles->_css_href( $obj->src, $obj->ver, $handle ) ) . '">';
    }
    echo '</noscript>';
    ?>
<script>
(function(ids){function go(){ids.forEach(function(id){var l=document.getElementById(id);if(l){l.media='all';}});}
if(document.readyState==='complete'){go();}else{window.addEventListener('load',go);}})(<?php echo wp_json_encode( $ids ); ?>);
</script>
    <?php
}
add_action( 'wp_footer', 'ovinx_print_deferred_styles_loader', 99 );
/**
 * Polite live region for status messages that scripts produce after an AJAX update (WCAG 4.1.3), e.g. the wishlist page.
 */
function ovinx_sr_status_region() {
    echo '<div id="ovinx-sr-status" class="visually-hidden" role="status" aria-live="polite" aria-atomic="true"></div>';
}
add_action( 'wp_footer', 'ovinx_sr_status_region', 5 );
