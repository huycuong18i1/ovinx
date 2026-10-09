<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Existing wishlist items must become remove buttons instead of links
 * that redirect users to the wishlist page.
 */
add_filter( 'option_wcboost_wishlist_exists_item_button_behaviour', 'tfwc_force_wishlist_remove_behaviour' );

function tfwc_force_wishlist_remove_behaviour( $behaviour ) {
	return 'remove';
}

add_filter( 'wcboost_wishlist_add_to_wishlist_fragments', 'tfwc_wishlist_count', 10, 1 );
add_filter( 'wcboost_wishlist_svg_icon', 'tfwc_wishlish_icon' , 20, 2 );
add_filter( 'wcboost_wishlist_loop_add_to_wishlist_link', 'tfwc_wishlish_button' , 20, 2 );
add_filter( 'wcboost_wishlist_button_template_args', 'tfwc_single_wishlish_button_args', 10, 3);

function tfwc_single_wishlish_button_args($args, $wishlist, $product ){
    $is_wl_single_product = get_query_var('is_wl_single_product', false);

    // Single product page: the wishlist link sits in the "extra links" row (icon + text, like Compare/Share), not as
    // a boxed heart next to Add to cart. Plain link: drop WooCommerce's `button` look.
    if ( get_query_var( 'is_wl_extra_row', false ) ) {
        $classes = is_array( $args['class'] ?? null ) ? $args['class'] : preg_split( '/\s+/', trim( (string) ( $args['class'] ?? '' ) ) );
        $args['class'] = array_values( array_diff( array_filter( $classes ), array( 'button', 'wp-element-button' ) ) );
        return $args;
    }

    if( !empty($is_wl_single_product)){

        if( empty($args['class']) ){
            $args = ['product-extra-icon'];
        }else{
            if( is_array($args['class']) ){
                $args['class'][] = 'product-extra-icon';
                $args['class'][] = 'tf-btn-icon';
                $args['class'][] = 'hover-tooltip';
            }else{
                $args['class'] .= ' product-extra-icon tf-btn-icon hover-tooltip';
            }
        }
    }

    // if ( class_exists('WCBoost\Wishlist\Helper', false) && method_exists('WCBoost\Wishlist\Helper', 'is_wishlist') && \WCBoost\Wishlist\Helper::is_wishlist() ) {
    //     $item = new \WCBoost\Wishlist\Wishlist_Item( $product );
    //     if( $wishlist->has_item( $item ) ){
    //         $args['is_wishlist_page_with_remove_url'] = $item->get_remove_url();
    //     }
    // }

    return $args;
}

function tfwc_wishlish_button($html, $args) {

    $is_wl_single_product = get_query_var('is_wl_single_product', false);
    $wl_item_remove_link = get_query_var('wl_item_remove_link', false);

    if( !empty($is_wl_single_product)){
        return $html;
    }

    $classes = is_singular( 'product' ) ? 'wcboost-wishlist-button wcboost-wishlist-button--single button tf-btn-icon' : 'wcboost-wishlist-button wcboost-wishlist-button--theme button';

    $label_add = \WCBoost\Wishlist\Helper::get_button_text( 'add' );
    $label_added = \WCBoost\Wishlist\Helper::get_button_text( 'remove' );

    // Wishlist page card: the tooltip must say "Remove", not "Add".
    if ( $wl_item_remove_link ) {
        $label_add = $label_added;
    }

    if( get_option( 'wcboost_wishlist_exists_item_button_behaviour' ) == 'view_wishlist' ) {
        $label_added = \WCBoost\Wishlist\Helper::get_button_text( 'view' );
    }

    if( get_option( 'wcboost_wishlist_exists_item_button_behaviour' ) == 'hide' ) {
        return '';
    }

    $product_style = isset( $_GET['product_style'] ) ? sanitize_text_field( wp_unslash( $_GET['product_style'] ) ) : themesflat_get_opt( 'product_style' );

    if (isset($_POST['product_style'])) {
        $product_style = sanitize_text_field( wp_unslash( $_POST['product_style'] ) );
    }

    // ground truth's list-style card markup uses the SAME tooltip-left as grid for these action
    // icons — only style-2/style-wishlist-3 need tooltip-top.
    $class = '';
    if($product_style == 'style-2' || $product_style == 'style-wishlist style-3') {
        $class = ' tooltip-top ';
    } else {
        $class = ' tooltip-left ';
    }

    // `tfwc_force_wishlist_remove_behaviour()` above always forces this option to 'remove', so a
    // 'view_wishlist' branch here (which used to return a hardcoded `icon-trash` — not a real
    // icon in this theme's set) could never actually run; removed as dead code rather than left
    // as unreachable, misleading leftovers.

    return sprintf(
        '
            <a href="%1$s" class="box-icon hover-tooltip '.$class.' %2$s" role="button" %3$s data-tooltip="%4$s" data-tooltip_added="%5$s">
                <span class="wcboost-wishlist-button__icon">%6$s</span>            
                <span class="wcboost-wishlist-button__text tooltip">%4$s</span>
            </a>
        ',
        esc_url( isset( $args['url'] ) ? $args['url'] : add_query_arg( [ 'add-to-wishlist' => $args['product_id'] ] ) ),
        esc_attr( isset( $args['class'] ) ? $args['class'] : esc_attr( $classes ) ),
        isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
        wp_kses_post( $label_add ),
        wp_kses_post( $label_added ),
        empty( $args['icon'] ) ? '' :  $args['icon'],
        esc_html( $wl_item_remove_link ? wp_strip_all_tags( $label_added ) : ( isset( $args['label'] ) ? $args['label'] : __( 'Add to wishlist', 'ovinx' ) ) )
    );
}

function tfwc_wishlish_icon($svg, $icon) {
    
    if ( function_exists( 'wcboost_wishlist' ) ) {
        /**
         * Ground truth (wishlist.html) always shows the FILLED heart for an already-wishlisted
         * item, including its own "Remove Wishlist" button — there is no separate trash/X icon for
         * this state. `icon-trash`/`icon-heart`/`icon-heart-stroke` never existed in this theme's
         * 70-icon set (real names: `icon-Hearth` outline, `icon-HeartFill` filled) — the icon was
         * previously blank/invisible regardless of style or remove-behaviour.
         */
        if ( $icon == 'heart' ) {
            $svg = '<span class="icon icon-Hearth"></span>';
        } else if ( $icon == 'heart-filled' ) {
            $remove_class = get_option( 'wcboost_wishlist_exists_item_button_behaviour' ) == 'remove' ? ' remove' : '';
            $svg = '<span class="icon icon-HeartFill' . esc_attr( $remove_class ) . '"></span>';

            // On the wishlist page every card is a saved item, so its button removes it: show a trash can instead of the filled heart.
            if ( get_query_var( 'wl_item_remove_link', false ) ) {
                $svg = '<span class="icon icon-trash remove"></span>';
            }
        }
    } 
    return $svg;
}

function tfwc_wishlist_count($data) {
    $wishlist = \WCBoost\Wishlist\Helper::get_wishlist();
    $wishlist_count = ovinx_wishlist_count( $wishlist );

    // Class list must cover BOTH contexts this selector matches: desktop header
    // (.nav-icon-list .nav-icon-item.has-number .number-order) and mobile bottom
    // toolbar (.tf-toolbar-bottom .toolbar-count) — see CLAUDE.md fragment-overwrite note.
    $data['.wishlist-btn-fragment .count-box'] = '<span class="number-order toolbar-count count-box whishlist-items-count">'. $wishlist_count . '</span>';

    return $data;
}

?>