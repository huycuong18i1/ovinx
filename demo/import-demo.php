<?php
/**
 * Demo Import Data
 */

function themesflat_import_files() {

    return array(

        array(

            'import_file_name'           => 'Import Demo Data',

            'import_file_url'            => esc_url(THEMESFLAT_PROTOCOL.'://ovinx.autodealwordpress.com/wp-content/demo/content.xml'),
			'import_widget_file_url'     => esc_url(THEMESFLAT_PROTOCOL.'://ovinx.autodealwordpress.com/wp-content/demo/widgets.wie'),
			'import_customizer_file_url' => esc_url(THEMESFLAT_PROTOCOL.'://ovinx.autodealwordpress.com/wp-content/demo/options.dat'),

            'import_preview_image_url'   => esc_url(THEMESFLAT_LINK.'screenshot.jpg'),

            'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the MailChimp form.', 'ovinx' ),

            'preview_url'                => esc_url('https://ovinx.autodealwordpress.com/'),

        ),

    );

}

add_filter( 'pt-ocdi/import_files', 'themesflat_import_files' );

function themesflat_before_content_import() { 
    $posts = get_posts(array( 'post_type' => 'post','numberposts' => -1));
    foreach ( $posts as $posts ) {
        wp_delete_post( $posts->ID, true);
    }   

    global $wp_registered_sidebars;
    $widgets = get_option('sidebars_widgets');
    foreach ($wp_registered_sidebars as $sidebar => $value) {
        unset($widgets[$sidebar]);
    }
    update_option('sidebars_widgets',$widgets);

    $shop_page = get_page_by_title( 'Shop' );
    $cart_page = get_page_by_title( 'Cart' );
    $checkout_page = get_page_by_title( 'Checkout' );
    $account_page = get_page_by_title( 'My account' );


    wp_delete_post( $shop_page->ID);
    wp_delete_post( $cart_page->ID);
    wp_delete_post( $checkout_page->ID);
    wp_delete_post( $account_page->ID);
}
add_action( 'pt-ocdi/before_content_import', 'themesflat_before_content_import' );

function themesflat_after_import_setup($selected_import) {
    // Removes Elementor Global Defaults for Fonts, Colors, and Typography
    update_option( "elementor_disable_color_schemes", "yes" );
    update_option( "elementor_disable_typography_schemes", "yes" );

    $main_menu = get_term_by( 'name', 'main-menu', 'nav_menu' );
    $mobile_menu = get_term_by( 'name', 'mobile-menu', 'nav_menu' );
    set_theme_mod( 'nav_menu_locations', array(
            'primary' => $main_menu->term_id,
            'mobile' => $main_menu->term_id
        )
    );

    $front_page_id = get_page_by_title( 'Home 01' );
    $blog_page_id  = get_page_by_title( 'Blog' );
    $shop_page_id  = get_page_by_title( 'Shop' );

    $cart_page_id = get_page_by_title( 'Cart' );
    $checkout_page_id = get_page_by_title( 'Checkout' );
    $account_page_id = get_page_by_title( 'My account' );
    
    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );
    update_option( 'page_for_posts', $blog_page_id->ID );
    update_option( 'posts_per_page', 4 );
    update_option( 'woocommerce_shop_page_id', $shop_page_id->ID );

    update_option( 'woocommerce_cart_page_id', $cart_page_id->ID );
    update_option( 'woocommerce_checkout_page_id', $checkout_page_id->ID );
    update_option( 'woocommerce_myaccount_page_id', $account_page_id->ID );

    
    global $wp_rewrite;
    $wp_rewrite->set_permalink_structure('/%postname%/');
    $wp_rewrite->flush_rules(); 
}
add_action( 'pt-ocdi/after_import', 'themesflat_after_import_setup' );