<?php 

$wp_customize->add_section('section_mobile_announcement',array(
    'title'         => 'Announcement Bar',
    'panel'         => 'mobile_panel',
));
require THEMESFLAT_DIR . "inc/customizer/mobile/announcement.php";

$wp_customize->add_section('section_mobile_topbar',array(
    'title'         => 'Topbar Bar',
    'panel'         => 'mobile_panel',
));
require THEMESFLAT_DIR . "inc/customizer/mobile/topbar.php";

$wp_customize->add_section('section_mobile_header',array(
    'title'         => 'Header',
    'panel'         => 'mobile_panel',
));
require THEMESFLAT_DIR . "inc/customizer/mobile/header.php";


$wp_customize->add_section('section_mobile_product_card',array(
    'title'         => 'Product Card',
    'panel'         => 'mobile_panel',
));
require THEMESFLAT_DIR . "inc/customizer/mobile/product-card.php";


$wp_customize->add_section('section_info',array(
    'title'         => 'Mobile Infor',
    'panel'         => 'mobile_panel',
)); 
require THEMESFLAT_DIR . "inc/customizer/mobile/info.php";

$wp_customize->add_section('section_navbar',array(
    'title'         => 'Navbar Mobile',
    'panel'         => 'mobile_panel',
)); 
require THEMESFLAT_DIR . "inc/customizer/mobile/navbar_mobile.php";



