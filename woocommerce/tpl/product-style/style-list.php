<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

/**
 * List-style card — rebuilt to match ground truth's list-style card markup (user-provided sample):
 * `.card-product_wrapper` (image/badges/action-list/color-list — IDENTICAL structure to grid, see
 * style-1.php) + `.card-product_info` (category/title/rating/price/mobile-add-to-cart/desc-list)
 * + `<span class="br-line type-vertical">` + `.card-product_button` (desktop-only price/qty/add to
 * cart/compare/share panel). The old version wrapped action icons in a `<div>` instead of `<ul>`,
 * used a wrong small icon-only Add to Cart button, and never built `.card-product_button` at all.
 */

// Wrapper (image area) — same hook order as grid (style-1.php); ground truth's list-style card
// uses the exact same badges/action-list/color-list markup as grid, just laid out differently by
// CSS (`.product-style_list`), so no style-list-specific branching is needed here.
add_action( 'woocommerce_before_shop_loop_item', 'tfwc_class_thumnail_open', 5 );

add_action( 'woocommerce_before_shop_loop_item_title', 'tfwc_thumnail', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'tfwc_badges', 22 );
add_action( 'woocommerce_before_shop_loop_item_title', 'tfwc_class_wrap_btn_open', 25 );

if ( class_exists( '\WCBoost\Wishlist\Frontend' ) ) {
	add_action( 'woocommerce_before_shop_loop_item_title', 'tfwc_class_wishlist_open', 30 );
	add_action( 'woocommerce_before_shop_loop_item_title', array( \WCBoost\Wishlist\Frontend::instance(), 'loop_add_to_wishlist_button' ), 31 );
	add_action( 'woocommerce_before_shop_loop_item_title', 'tfwc_class_wishlist_close', 32 );
}

if ( class_exists( '\WCBoost\ProductsCompare\Frontend' ) ) {
	add_action( 'woocommerce_before_shop_loop_item_title', array( \WCBoost\ProductsCompare\Frontend::instance(), 'loop_add_to_compare_button' ), 40 );
}

add_action( 'woocommerce_before_shop_loop_item_title', 'tfwc_quickview_button', 45 );
add_action( 'woocommerce_before_shop_loop_item_title', 'tfwc_class_wrap_btn_close', 70 );
add_action( 'woocommerce_before_shop_loop_item_title', 'tfwc_attribute_second', 72 ); // .product-color_list
add_action( 'woocommerce_before_shop_loop_item_title', 'tfwc_countdown', 75 );
add_action( 'woocommerce_before_shop_loop_item_title', 'tfwc_class_thumnail_close', 80 );

// Info (text area) — ground truth order: Category → Title → Rating → Price → mobile-only Add to
// Cart → Brand/Weight/SKU facts list.
add_action( 'woocommerce_after_shop_loop_item_title', 'tfwc_class_content_open', 20 );
add_action( 'woocommerce_after_shop_loop_item_title', 'tfwc_category', 22 );
add_action( 'woocommerce_after_shop_loop_item_title', 'tfwc_title', 23 );
add_action( 'woocommerce_after_shop_loop_item_title', 'tfwc_rating', 24 );
add_action( 'woocommerce_after_shop_loop_item_title', 'tfwc_price', 25 ); // .price-wrap — CSS hides it on desktop (>=768px), list-style shows the real price in .card-product_button instead
add_action( 'woocommerce_after_shop_loop_item_title', 'tfwc_action_bot', 30 ); // .box-action_add.d-md-none — mobile-only fallback Add to Cart
add_action( 'woocommerce_after_shop_loop_item_title', 'tfwc_progressbar', 33 );
add_action( 'woocommerce_after_shop_loop_item_title', 'tfwc_product_desc_list', 35 );
add_action( 'woocommerce_after_shop_loop_item_title', 'tfwc_class_content_close', 100 );

// Sibling-level (after .card-product_wrapper AND .card-product_info both close): the vertical
// divider + desktop-only .card-product_button panel (price/quantity/add to cart/compare/share).
add_action( 'woocommerce_after_shop_loop_item', 'tfwc_list_card_button', 10 );
