<?php

if ( !function_exists('themesflat_sanitize_raw') ){
    function themesflat_sanitize_raw( $value ) {
        // QA CODE-004: was `return $value;` (raw). Keeps shortcodes and normal post HTML, drops <script> etc.
        return wp_kses_post( $value );
    }
}

$wp_customize->add_section('single_product_pagetitle',array(
    'title'         => 'Page Title',
    'priority'      => 19,
    'panel'         => 'single_product_panel',
));

require THEMESFLAT_DIR . "inc/customizer/single-product/page-title.php";
// Recent Sales Count

$wp_customize->add_section('section_recent_sales_count',array(
    'title'         => 'Recent Sales Count',
    'priority'      => 20,
    'panel'         => 'single_product_panel',
));

require THEMESFLAT_DIR . "inc/customizer/single-product/recent-sales-count.php";

// Fake People view

$wp_customize->add_section('section_people_view',array(
    'title'         => 'People View',
    'priority'      => 21,
    'panel'         => 'single_product_panel',
));

require THEMESFLAT_DIR . "inc/customizer/single-product/people-view.php";

// Progress sale

$wp_customize->add_section('section_progress_sale',array(
    'title'         => 'Progress Sale',
    'priority'      => 22,
    'panel'         => 'single_product_panel',
));

require THEMESFLAT_DIR . "inc/customizer/single-product/progress-sale.php";

// Countdown

$wp_customize->add_section('section_countdown',array(
    'title'         => 'Countdown',
    'priority'      => 23,
    'panel'         => 'single_product_panel',
));

require THEMESFLAT_DIR . "inc/customizer/single-product/countdown.php";

// Size guide

$wp_customize->add_section('section_size_guide',array(
    'title'         => 'Size Guide',
    'priority'      => 24,
    'panel'         => 'single_product_panel',
));

require THEMESFLAT_DIR . "inc/customizer/single-product/size-guide.php";

// Volume Discount
$wp_customize->add_section('section_volume_discount',array(
    'title'         => 'Volume Discount',
    'priority'      => 24,
    'panel'         => 'single_product_panel',
));

require THEMESFLAT_DIR . "inc/customizer/single-product/volume-discount.php";

// Buy Together
$wp_customize->add_section('section_buy_together',array(
    'title'         => 'Buy Together',
    'priority'      => 24,
    'panel'         => 'single_product_panel',
));

require THEMESFLAT_DIR . "inc/customizer/single-product/buy-together.php";

// Buy X Get Y
$wp_customize->add_section('section_buyx_gety',array(
    'title'         => 'Buy X Get Y',
    'priority'      => 24,
    'panel'         => 'single_product_panel',
));

require THEMESFLAT_DIR . "inc/customizer/single-product/buyx-gety.php";

// Wishlist

require THEMESFLAT_DIR . "inc/customizer/single-product/wishlist.php";

// Extra Description

$wp_customize->add_section('section_extra_desc',array(
    'title'         => 'Extra Description',
    'priority'      => 27,
    'panel'         => 'single_product_panel',
));

require THEMESFLAT_DIR . "inc/customizer/single-product/extra-desc.php";

// Product Gallery

$wp_customize->add_section('section_product_gallery',array(
    'title'         => 'Product Gallery',
    'priority'      => 28,
    'panel'         => 'single_product_panel',
));

require THEMESFLAT_DIR . "inc/customizer/single-product/product-gallery.php";

// Product Options

$wp_customize->add_section('section_product_options',array(
    'title'         => 'Single Product Options',
    'priority'      => 28,
    'panel'         => 'single_product_panel',
));

require THEMESFLAT_DIR . "inc/customizer/single-product/options.php";

// Product Tabs
$wp_customize->add_section('section_tabs',array(
    'title'         => 'Product Tabs',
    'priority'      => 28,
    'panel'         => 'single_product_panel',
));

require THEMESFLAT_DIR . "inc/customizer/single-product/tabs.php";

// Out Of Stock Notification

$wp_customize->add_section('section_out_of_stock_notification',array(
    'title'         => 'Out Of Stock Notification',
    'priority'      => 28,
    'panel'         => 'single_product_panel',
));
require THEMESFLAT_DIR . "inc/customizer/single-product/out-of-stock-notification.php";

// Related Product

$wp_customize->add_section('section_product_related',array(
    'title'         => 'Related Product',
    'priority'      => 28,
    'panel'         => 'single_product_panel',
));

require THEMESFLAT_DIR . "inc/customizer/single-product/related.php";

// Recently Product

$wp_customize->add_section('section_product_recently',array(
    'title'         => 'Recently Product',
    'priority'      => 28,
    'panel'         => 'single_product_panel',
));

require THEMESFLAT_DIR . "inc/customizer/single-product/recently.php";

// Upsell Product

$wp_customize->add_section('section_product_upsell',array(
    'title'         => 'Upsell Product',
    'priority'      => 28,
    'panel'         => 'single_product_panel',
));

require THEMESFLAT_DIR . "inc/customizer/single-product/upsell.php";

// Cross Sell Product

$wp_customize->add_section('section_cross_sell',array(
    'title'         => 'Cross Sell Product',
    'priority'      => 28,
    'panel'         => 'single_product_panel',
));

require THEMESFLAT_DIR . "inc/customizer/single-product/cross-sell.php";