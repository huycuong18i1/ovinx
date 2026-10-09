<?php

$wp_customize->add_section('section_shop_category',array(
    'title'         => 'Top Category',
    'priority'      => 1,
    'panel'         => 'shop_panel',
));
require THEMESFLAT_DIR . "inc/customizer/shop/shop-category.php";

$wp_customize->add_section('section_shop_pagetitle',array(
    'title'         => 'Page Tilte',
    'priority'      => 1,
    'panel'         => 'shop_panel',
));
require THEMESFLAT_DIR . "inc/customizer/shop/page-title.php";

$wp_customize->add_section('section_shop_catalog',array(
    'title'         => 'Catalog Toolbar',
    'priority'      => 1,
    'panel'         => 'shop_panel',
));
require THEMESFLAT_DIR . "inc/customizer/shop/shop-catalog.php";

// ADD SECTION SHOP ARCHIVE
$wp_customize->add_section('section_shop_archive',array(
    'title'         => 'Shop Layout',
    'priority'      => 1,
    'panel'         => 'shop_panel',
));
require THEMESFLAT_DIR . "inc/customizer/shop/shop-archive.php";

$wp_customize->add_section('section_product_card',array(
    'title'         => 'Product Card',
    'priority'      => 1,
    'panel'         => 'shop_panel',
));
require THEMESFLAT_DIR . "inc/customizer/shop/product-card.php";

$wp_customize->add_section('section_product_badges',array(
    'title'         => 'Product Badges',
    'priority'      => 1,
    'panel'         => 'shop_panel',
));
require THEMESFLAT_DIR . "inc/customizer/shop/product-badges.php";


$wp_customize->add_section('section_shop_minicart',array(
    'title'         => 'Mini Cart',
    'priority'      => 20,
    'panel'         => 'shop_panel',
));
require THEMESFLAT_DIR . "inc/customizer/shop/minicart.php";


$wp_customize->add_section('section_live_notification',array(
    'title'         => 'Live Notification',
    'priority'      => 20,
    'panel'         => 'shop_panel',
));
require THEMESFLAT_DIR . "inc/customizer/shop/live-notification.php";

$wp_customize->add_section('section_cookies',array(
    'title'         => 'Cookies',
    'priority'      => 20,
    'panel'         => 'shop_panel',
));
require THEMESFLAT_DIR . "inc/customizer/shop/cookies.php";



$wp_customize->add_section('section_shop_empty',array(
    'title'         => 'Wishlist & Compare Empty',
    'priority'      => 20,
    'panel'         => 'shop_panel',
));
require THEMESFLAT_DIR . "inc/customizer/shop/empty-states.php";
