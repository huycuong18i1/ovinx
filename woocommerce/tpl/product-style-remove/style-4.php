<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

// Action Hook
remove_action( 'woocommerce_before_shop_loop_item', 'tfwc_class_thumnail_open' ,5);

remove_action('woocommerce_before_shop_loop_item_title','tfwc_thumnail' ,10 );
remove_action('woocommerce_before_shop_loop_item_title','tfwc_attribute_first' ,20 );

remove_action('woocommerce_before_shop_loop_item_title','tfwc_badges' ,22 );

remove_action('woocommerce_before_shop_loop_item_title','tfwc_class_wrap_btn_open' ,25 );

remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 27 );

if( class_exists('\WCBoost\Wishlist\Frontend') ) {
	remove_action( 'woocommerce_before_shop_loop_item_title', 'tfwc_class_wishlist_open', 29 );
	remove_action( 'woocommerce_before_shop_loop_item_title', array( \WCBoost\Wishlist\Frontend::instance(), 'loop_add_to_wishlist_button' ), 30 );
	remove_action( 'woocommerce_before_shop_loop_item_title', 'tfwc_class_wishlist_close', 31 );
}

remove_action( 'woocommerce_before_shop_loop_item_title', 'tfwc_quickview_button' , 40 );

if( class_exists('\WCBoost\ProductsCompare\Frontend') ) {
	remove_action( 'woocommerce_before_shop_loop_item_title', array( \WCBoost\ProductsCompare\Frontend::instance(), 'loop_add_to_compare_button' ), 45 );
}


remove_action( 'woocommerce_before_shop_loop_item_title', 'tfwc_class_wrap_btn_close' ,70);


remove_action( 'woocommerce_before_shop_loop_item_title', 'tfwc_countdown' ,75);

remove_action( 'woocommerce_before_shop_loop_item_title', 'tfwc_class_thumnail_close' ,80);


remove_action('woocommerce_after_shop_loop_item_title','tfwc_class_content_open' ,20 );


remove_action('woocommerce_after_shop_loop_item_title','tfwc_rating' ,22 );
remove_action('woocommerce_after_shop_loop_item_title','tfwc_category' ,23 );
remove_action('woocommerce_after_shop_loop_item_title','tfwc_title' ,25 );
remove_action('woocommerce_after_shop_loop_item_title','tfwc_price' ,30 );
remove_action('woocommerce_after_shop_loop_item_title','tfwc_attribute_second' ,40 );
remove_action('woocommerce_after_shop_loop_item_title','tfwc_progressbar' ,45 );
remove_action('woocommerce_after_shop_loop_item_title','tfwc_in_out_stock' ,50 );

remove_action('woocommerce_after_shop_loop_item_title','tfwc_class_content_close' ,100 );

