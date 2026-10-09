<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

// Action Hook
add_action( 'woocommerce_before_shop_loop_item', 'tfwc_class_thumnail_open' ,5);

add_action('woocommerce_before_shop_loop_item_title','tfwc_thumnail' ,10 );

// add_action('woocommerce_before_shop_loop_item_title','tfwc_attribute_first' ,20 );

add_action('woocommerce_before_shop_loop_item_title','tfwc_badges' ,22 );

// tfwc_action_bot (.box-action_add / Add to Cart) moved to woocommerce_after_shop_loop_item_title
// (priority 99, inside .card-product_info) — see comment there.

add_action('woocommerce_before_shop_loop_item_title','tfwc_attribute_first' , 23 );

add_action('woocommerce_before_shop_loop_item_title','tfwc_class_wrap_btn_open' ,25 );

if( class_exists('\WCBoost\Wishlist\Frontend') ) {
	add_action( 'woocommerce_before_shop_loop_item_title', 'tfwc_class_wishlist_open', 30 );
	add_action( 'woocommerce_before_shop_loop_item_title', array( \WCBoost\Wishlist\Frontend::instance(), 'loop_add_to_wishlist_button' ), 31 );
	add_action( 'woocommerce_before_shop_loop_item_title', 'tfwc_class_wishlist_close', 32 );
}

if( class_exists('\WCBoost\ProductsCompare\Frontend') ) {
	add_action( 'woocommerce_before_shop_loop_item_title', array( \WCBoost\ProductsCompare\Frontend::instance(), 'loop_add_to_compare_button' ), 40 );
}

add_action( 'woocommerce_before_shop_loop_item_title', 'tfwc_quickview_button' , 45 );


add_action( 'woocommerce_before_shop_loop_item_title', 'tfwc_class_wrap_btn_close' ,70);

/**
 * Ground truth (shop-default.html) puts `.product-color_list` directly inside
 * `.card-product_wrapper` (overlaying the thumbnail, sibling of `.product-badge_list`/
 * `.product-action_list`), not inside `.card-product_info` (the text block below the image) —
 * it was previously hooked on `_after_shop_loop_item_title`, rendering it inside the info block
 * where its `position:absolute; left/bottom:10px` rule overlaps the category text instead of the
 * image.
 */
add_action( 'woocommerce_before_shop_loop_item_title', 'tfwc_attribute_second' ,72);

add_action( 'woocommerce_before_shop_loop_item_title', 'tfwc_countdown' ,75);

add_action( 'woocommerce_before_shop_loop_item_title', 'tfwc_class_thumnail_close' ,80);


add_action('woocommerce_after_shop_loop_item_title','tfwc_class_content_open' ,20 );
add_action('woocommerce_after_shop_loop_item_title','tfwc_class_content_wrap_open' ,21 );

// Ground truth's info block order is Category → Title → Rating → Price (category was previously
// hooked at priority 30, after price, rendering it LAST instead of first).
add_action('woocommerce_after_shop_loop_item_title','tfwc_category', 22 );
add_action('woocommerce_after_shop_loop_item_title','tfwc_title', 23 );
add_action('woocommerce_after_shop_loop_item_title','tfwc_rating', 24 );
add_action('woocommerce_after_shop_loop_item_title','tfwc_price', 25 );

add_action('woocommerce_after_shop_loop_item_title','tfwc_description', 35 );
// tfwc_attribute_second (.product-color_list) moved to woocommerce_before_shop_loop_item_title
// (priority 72) — see comment there.
add_action('woocommerce_after_shop_loop_item_title','tfwc_progressbar' ,45 );
// tfwc_in_out_stock is now called from inside tfwc_rating() so both share one .product-rating
// flex row (matches ground truth) — no longer hooked separately here.

add_action('woocommerce_after_shop_loop_item_title','tfwc_class_content_wrap_close' ,95 );
/**
 * .box-action_add's real CSS (`position:absolute` sliding up from the bottom of .card-product_info
 * on card hover) requires it to be a direct child of .card-product_info — moved here from
 * woocommerce_before_shop_loop_item_title (priority 22), where it used to be wrapped in
 * `.product-action_bot` (a different, unrelated real component: an image-overlay button with its
 * own conflicting absolute positioning), causing the button to float at the image/info boundary
 * instead of sliding up correctly from the bottom of the card.
 */
add_action( 'woocommerce_after_shop_loop_item_title', 'tfwc_action_bot', 99 );
add_action('woocommerce_after_shop_loop_item_title','tfwc_class_content_close' ,100 );

