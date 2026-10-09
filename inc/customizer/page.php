<?php 

require THEMESFLAT_DIR . "inc/customizer/page/page-wishlist.php";

$wp_customize->add_section('section_checkout_page',array(
    'title'         => 'Thankyou Page',
    'priority'      => 2,
    'panel'         => 'woocommerce',
));
require THEMESFLAT_DIR . "inc/customizer/page/page-checkout.php";



