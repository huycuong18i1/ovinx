<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;
if ( $product->get_stock_status() == 'outofstock' ) { 
    echo '<div class="on-sale-wrap">';
        echo '<span class="on-sale-item out-stock">'.esc_html__('Out of Stock','ovinx').'</span>';
    echo '</div>';
} else {
    $badges_html = '';

    if ( $product->is_in_stock() && !$product->is_on_backorder() && $product->is_purchasable() ) {
        $badges_html .= '<span class="on-sale-item in-stock">' . esc_html__('In Stock', 'ovinx') . '</span>';
    }

    if ( $product->is_on_backorder() ) {
        $badges_html .= '<span class="on-sale-item pre-oder">' . esc_html__('Pre-Order', 'ovinx') . '</span>';
    }

    

    if ( !empty($badges_html) ) {
        echo '<div class="on-sale-wrap">' . $badges_html . '</div>';
    }
} ?>


