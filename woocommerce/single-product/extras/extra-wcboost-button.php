<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

if( empty($product) ){
    $product = wc_get_product(get_the_ID());
}

// Main single-product page: the wishlist/compare links live in the "extra links" row (extra-action.php) instead.
if ( get_query_var( 'ovinx_wishlist_in_extra_row', false ) ) {
    return;
}

// Design (shop-default.html): no heart/compare box in the Quick View popup. Re-enable with
// add_filter( 'ovinx_quickview_show_wishlist', '__return_true' ).
if ( get_query_var( 'is_quick_view', false ) && ! apply_filters( 'ovinx_quickview_show_wishlist', false ) ) {
    return;
}

?>
<div class="group-btn-action">
    <?php if(themesflat_get_opt('tf_wishlist_pos') && class_exists( 'WCBoost\Wishlist\Frontend' )): ?>
        <?php
            if( method_exists( 'WCBoost\Wishlist\Frontend', 'single_add_to_wishlist_button' ) ){
                set_query_var('is_wl_single_product', true);
                \WCBoost\Wishlist\Frontend::instance()->single_add_to_wishlist_button();
                set_query_var('is_wl_single_product', false);
            }
        ?>
    <?php endif; ?>
    <div class="btn-widget d-none">
        <?php if(themesflat_get_opt('tf_wishlist_pos') && class_exists( 'WCBoost\ProductsCompare\Frontend' )): ?>
                <?php
                    if( method_exists( 'WCBoost\ProductsCompare\Frontend', 'single_add_to_compare_button' ) ){
                        set_query_var('is_wl_single_product', true);
                        \WCBoost\ProductsCompare\Frontend::instance()->single_add_to_compare_button();
                        set_query_var('is_wl_single_product', false);
                    }
                ?>
        <?php endif; ?>
    </div>
</div>