<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

/**
 * Per-type inline color/background from Customizer (badges_{type}_color / _background_color).
 * Ground truth (ovinx-html) only ever shows the "sale"/"new" modifiers with their own real CSS
 * colors (.product-badge_item.new / .sale) — the other types (stock/trending/order/custom) have
 * no dedicated color in the design, so the Customizer's per-type Color/Background controls (which
 * previously only worked for "custom") are wired here for every type + a neutral dark fallback
 * background is added at the base .product-badge_item level (css/styles.css) so a badge is never
 * invisible even when no custom color is set.
 */
if ( ! function_exists( 'tfwc_badge_inline_style' ) ) {
    function tfwc_badge_inline_style( $type ) {
        $color = themesflat_get_opt( 'badges_' . $type . '_color' );
        $bg    = themesflat_get_opt( 'badges_' . $type . '_background_color' );
        $style = '';
        if ( ! empty( $color ) ) {
            $style .= 'color:' . esc_attr( $color ) . ' !important;';
        }
        if ( ! empty( $bg ) ) {
            $style .= 'background-color:' . esc_attr( $bg ) . ' !important;';
        }
        return $style;
    }
}

if ( $product->get_stock_status() == 'outofstock' ) {
    ?>
    <div class="product-badge_list">
        <?php
        if( themesflat_get_opt('badges_stock') == 1 && !$product->is_in_stock() &&  ! $product->is_on_backorder() && $product->is_purchasable() ) {
            echo '<span class="product-badge_item text-label badge-out-of-stock" style="' . esc_attr( tfwc_badge_inline_style( 'stock' ) ) . '">'.esc_html__('Out of Stock','ovinx').'</span>';
        }
        ?>
    </div>
    <?php
} else {
?>
<div class="product-badge_list">
    <?php

    if( themesflat_get_opt('badges_stock') == 1 && $product->is_in_stock() &&  ! $product->is_on_backorder() && $product->is_purchasable() ) {
        echo '<span class="product-badge_item text-label in-stock" style="' . esc_attr( tfwc_badge_inline_style( 'stock' ) ) . '">'.esc_html__('In Stock','ovinx').'</span>';
    }

    if (themesflat_get_opt('badges_sale') == 1) {
        if ($product->is_type('variable')) {
            $min_regular_price = $product->get_variation_regular_price('min');
            $max_regular_price = $product->get_variation_regular_price('max');
            $min_sale_price = $product->get_variation_sale_price('min');
            $max_sale_price = $product->get_variation_sale_price('max');
        
            if ($min_regular_price > 0 && $min_sale_price > 0 & $min_regular_price > $min_sale_price) {
                $discount = round(((($min_regular_price - $min_sale_price) / $min_regular_price) * 100));
                $discount_text = '-' . $discount . '&#37;';
                echo '<span class="badge-sale product-badge_item text-label sale" style="' . esc_attr( tfwc_badge_inline_style( 'sale' ) ) . '">' . esc_html($discount_text) . '</span>';
            }
        }
        
        else if ($product->is_type('grouped')) {
            $min_regular_price = PHP_INT_MAX;
            $min_sale_price = PHP_INT_MAX;
            $has_sale = false; 
        
            foreach ($product->get_children() as $child_id) {
                $child_product = wc_get_product($child_id);
                if ( ! $child_product ) {
                    continue;
                }
        
                if ($child_product->get_regular_price() < $min_regular_price) {
                    $min_regular_price = $child_product->get_regular_price();
                }
                if ($child_product->get_sale_price() < $min_sale_price && $child_product->is_on_sale()) {
                    $min_sale_price = $child_product->get_sale_price();
                    $has_sale = true; 
                }
            }
        
            if ($has_sale && $min_regular_price > 0 && $min_sale_price > 0 & $min_regular_price > $min_sale_price) {
                $discount = round(((($min_regular_price - $min_sale_price) / $min_regular_price) * 100));
                $discount_text = '-' .$discount . '&#37;';
                echo '<span class="badge-sale product-badge_item text-label sale" style="' . esc_attr( tfwc_badge_inline_style( 'sale' ) ) . '">' . esc_html($discount_text) . '</span>';
            }
        }
        
        else  {
            $regular_price = (float) $product->get_regular_price();
            $sale_price = (float) $product->get_sale_price();
        
            // QA P4-01: is_on_sale() honours the sale schedule; the raw sale price meta alone showed "-40%" for expired sales.
            if ($product->is_on_sale() && $regular_price > 0 && $sale_price > 0 & $regular_price > $sale_price ) {
                $discount = round(((($regular_price - $sale_price) / $regular_price) * 100));
                $discount_text = '-' . $discount . '&#37;';
                echo '<span class="badge-sale product-badge_item text-label sale" style="' . esc_attr( tfwc_badge_inline_style( 'sale' ) ) . '">' . esc_html($discount_text) . '</span>';
            }

        }
    }


    if ($product->is_on_backorder() && themesflat_get_opt('badges_order') == 1) {
        echo '<span class="product-badge_item text-label pre-oder" style="' . esc_attr( tfwc_badge_inline_style( 'order' ) ) . '">'.esc_html__('Pre-Order','ovinx').'</span>';
    }

    if ($product->get_featured() && themesflat_get_opt('badges_trending') == 1) {
        echo '<span class="product-badge_item text-label trend" style="' . esc_attr( tfwc_badge_inline_style( 'trending' ) ) . '">'.esc_html__('Trending','ovinx').'</span>';
    }

   
    $is_new = get_post_meta($product->get_id(), 'tfwc_badges_new', true);
    $expiry_date = get_post_meta(get_the_ID(), 'tfwc_badges_new_time', true);
    $current_date = date('Y-m-d');    

    if ($is_new === 'yes' && (!empty($expiry_date) && $current_date <= $expiry_date) && themesflat_get_opt('badges_new') == 1) {
        echo '<span class="product-badge_item text-label new" style="' . esc_attr( tfwc_badge_inline_style( 'new' ) ) . '">'.esc_html__('NEW','ovinx').'</span>';
    } else {
        update_post_meta(get_the_ID(), 'tfwc_badges_new', 'no');
    }    

    $custom_badge = get_post_meta(get_the_ID(), 'tfwc_badges_custom', true);
    $badge_color = get_post_meta(get_the_ID(), 'tfwc_badges_color', true);
    $badge_bg = get_post_meta(get_the_ID(), 'tfwc_badges_bg', true);
    $style = tfwc_badge_inline_style( 'custom' );
    if (!empty($badge_color)) {
        $style .= 'color:' . esc_attr($badge_color) . ' !important;';
    }
    if (!empty($badge_bg)) {
        $style .= 'background-color:' . esc_attr($badge_bg) . '!important;';
    }
    if ( !empty(  $custom_badge ) && themesflat_get_opt('badges_custom') == 1 ) {
        echo '<span class="product-badge_item text-label custom" style="' . esc_attr($style) . '">'.esc_html($custom_badge).'</span>';
    }
    
    ?>
</div>

<?php } ?>


