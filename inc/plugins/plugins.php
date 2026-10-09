<?php
// Register action to declare required plugins
add_action('tgmpa_register', 'themesflat_recommend_plugin');
function themesflat_recommend_plugin() {
    
    $plugins = array(
        array(
            'name' => esc_html__('Elementor', 'ovinx'),
            'slug' => 'elementor',
            'required' => true
        ),
        array(
            'name' => esc_html__('ovinx Addon', 'ovinx'),
            'slug' => 'ovinx-addon',
            'source' => esc_url(THEMESFLAT_PROTOCOL . '://ovinx.autodealwordpress.com/wp-content/demo/ovinx-addon.zip'),
            'required' => true
        ), 
        array(
            'name' => esc_html__('Contact Form 7', 'ovinx'),
            'slug' => 'contact-form-7',
            'required' => false
        ),    
        array(
            'name' => esc_html__('Mailchimp', 'ovinx'),
            'slug' => 'mailchimp-for-wp',
            'required' => false
        ),        
        array(
            'name' => esc_html__('WooCommerce', 'ovinx'),
            'slug' => 'woocommerce',
            'required' => true
        ),
        array(
            'name' => esc_html__('One Click Demo Import', 'ovinx'),
            'slug' => 'one-click-demo-import',
            'required' => false
        ),
        array(
            'name' => esc_html__('WCBoost - Wishlist', 'ovinx'),
            'slug' => 'wcboost-wishlist',
            'required' => true
        ),
        array(
            'name' => esc_html__('WCBoost - Variation Swatches', 'ovinx'),
            'slug' => 'wcboost-variation-swatches',
            'required' => true
        ),
        array(
            'name' => esc_html__('WCBoost - Products Compare', 'ovinx'),
            'slug' => 'wcboost-products-compare',
            'required' => true
        ),

    );
    
    tgmpa($plugins);
}

