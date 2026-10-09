<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

// Function

/**
 * Shared version of the `$product_style` detection repeated across product-base/*.php
 * (GET → number_view_active override → POST, in that order — matches the existing pattern used
 * everywhere else so behavior doesn't change, just de-duplicated for new code).
 */
function tfwc_get_product_style() {
    $product_style = isset( $_GET['product_style'] ) ? sanitize_text_field( wp_unslash( $_GET['product_style'] ) ) : themesflat_get_opt( 'product_style' );

    $number_view_active = isset( $_GET['number_view_active'] ) ? sanitize_text_field( wp_unslash( $_GET['number_view_active'] ) ) : themesflat_get_opt( 'number_view_active' );
    if ( $number_view_active == 1 ) {
        $product_style = 'style-list';
    }

    if ( isset( $_POST['product_style'] ) ) {
        $product_style = sanitize_text_field( wp_unslash( $_POST['product_style'] ) );
    }

    return $product_style;
}

function tfwc_class_thumnail_open() {
    echo '<div class="card-product_wrapper">';
}

function tfwc_class_thumnail_close() {
    global $product;
    // the #unavailable modal is only printed when "out_stock_form" has content (tpl/.../unavailable.php), so without it the button would open nothing
    if( $product->get_stock_status() == "outofstock" && themesflat_get_opt('show_out_stock_btn') && !empty(themesflat_get_opt('out_stock_form')) ){
    ?>
        <a href="#unavailable" data-bs-toggle="modal" class="variant-box stock bg-main link text-white d-none d-md-block">
            <p class="text-center">
                <?php echo esc_html(themesflat_get_opt('out_stock_btn_text')); ?>
            </p>
        </a>
    <?php
    }

    // Sale marquee moved into tpl/product-base/thumnail.php (inside .product-img itself) — see
    // comment there.

    echo '</div>';
}

function tfwc_class_content_open() {		
    echo '<div class="card-product_info">';
}

function tfwc_class_content_wrap_open() {
    // echo '<div class="product_info_wrap">';
}

function tfwc_class_content_close() {		
    echo '</div>';
}

function tfwc_class_content_wrap_close() {		
    // echo '</div>';
}

function tfwc_class_wishlist_open() {		
    echo '<li class="wishlist">';
}

function tfwc_class_wishlist_close() {		
    echo '</li>';
}

function tfwc_class_wrap_btn_open() {
    // Ground truth's list-style card uses the SAME <ul class="product-action_list"> as grid for
    // wishlist/compare/quick-view — no special-casing needed.
    echo '<ul class="product-action_list">';
}

function tfwc_class_wrap_btn_close() {
    echo '</ul>';
}

function tfwc_thumnail() {			
    echo tfwc_get_template_part('/product-base/thumnail.php' );
}

function tfwc_title() {			
     echo tfwc_get_template_part( '/product-base/title.php' );
}

function tfwc_price() {		
    echo tfwc_get_template_part( '/product-base/price.php' );
}

function tfwc_attribute_first() {		
    echo tfwc_get_template_part( '/product-base/attribute-first.php' );
}

function tfwc_attribute_second() {
    echo tfwc_get_template_part( '/product-base/attribute-second.php' );
}

function tfwc_badges() {	
    if( themesflat_get_opt('show_badges') == 1) {
        echo tfwc_get_template_part( '/product-base/badges.php' );
    }
}

function tfwc_action_bot(){
    /**
     * `woocommerce_template_loop_add_to_cart()` renders `.box-action_add` (via
     * product-base/btn-add-to-cart.php), whose real CSS (`position:absolute; bottom:10px` sliding to
     * `bottom:-50px` on card hover) is written to be a DIRECT CHILD of `.card-product_info` (the
     * text block, which has its own `position:relative`) — NOT wrapped in `.product-action_bot`
     * (a completely different, unrelated real component: an image-overlay "choose options" button
     * with its own absolute positioning/box-shadow, meant for `.btn-action_choose` children). Nesting
     * .box-action_add inside .product-action_bot double-stacked two conflicting absolute-position
     * contexts, so the button floated at the image/info boundary instead of sliding up from the
     * bottom of the card like ground truth. No wrapper here — just the button.
     */
    woocommerce_template_loop_add_to_cart();
}

/**
 * Ground truth (shop-default.html) wraps the star rating AND the in/out-of-stock badge together
 * inside ONE `.product-rating` flex row (`display:flex; justify-content:space-between`) so they sit
 * side by side. They used to be 2 separate hooks (tfwc_rating at priority ~22-23, tfwc_in_out_stock
 * at priority 50, with category/description/attribute_second in between) rendering 2 unrelated
 * top-level blocks — that can never lay out side by side. Merged into one function/hook so both real
 * partials render inside the shared wrapper; tfwc_in_out_stock() is kept below for any other direct
 * callers but is no longer hooked on its own (see product-style/*.php).
 */
function tfwc_rating() {
    $show_rating = themesflat_get_opt('show_rating') == 1;
    $show_stock  = themesflat_get_opt('show_in_out_stock') == 1;

    if ( ! $show_rating && ! $show_stock ) {
        return;
    }

    // tfwc_get_template_part() echoes directly (load_template has no return value) — capture via
    // an output buffer so both partials can be wrapped together instead of printed independently.
    ob_start();
    if ( $show_rating ) {
        tfwc_get_template_part( '/product-base/rating.php' );
    }
    if ( $show_stock ) {
        tfwc_get_template_part( '/product-base/in-out-stock.php' );
    }
    $inner = ob_get_clean();

    if ( empty( trim( $inner ) ) ) {
        return;
    }

    echo '<div class="product-rating">' . $inner . '</div>';
}

function tfwc_in_out_stock() {
    if( themesflat_get_opt('show_in_out_stock') == 1) {
        echo tfwc_get_template_part( '/product-base/in-out-stock.php' );
    }
}

function tfwc_countdown() {		
    if( themesflat_get_opt('show_countdown') == 1) {
        set_query_var('countdown_style','style-2');
        echo tfwc_get_template_part( '/product-base/countdown.php' );
        set_query_var('countdown_style', false);
    }
}

function tfwc_progressbar() {
    if( themesflat_get_opt('show_progressbar') == 1) {			
        echo tfwc_get_template_part( '/product-base/progressbar.php' );
    }
}

function tfwc_description() {	
    if( themesflat_get_opt('show_description') == 1) {	
        echo tfwc_get_template_part( '/product-base/description.php' );
    }
}

function tfwc_category() {
    if( themesflat_get_opt('show_category') == 1) {
        echo tfwc_get_template_part( '/product-base/category.php' );
    }
}

/**
 * List-style-only: the "Brand/Weight/SKU" bullet facts under the price (see desc-list.php) and the
 * desktop-only right-hand `.card-product_button` panel (price/quantity/add-to-cart/compare/share —
 * see card-button.php). Both are no-ops outside style-list.
 */
function tfwc_product_desc_list() {
    if ( tfwc_get_product_style() !== 'style-list' ) {
        return;
    }
    echo tfwc_get_template_part( '/product-base/desc-list.php' );
}

function tfwc_list_card_button() {
    if ( tfwc_get_product_style() !== 'style-list' ) {
        return;
    }
    echo tfwc_get_template_part( '/product-base/card-button.php' );
}

?>