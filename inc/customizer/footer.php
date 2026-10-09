<?php
$wp_customize->add_section('section_footer_newsletter',array(
    'title'         => 'Newsletter',
    'priority'      => 0,
    'panel'         => 'footer_panel',
));
require THEMESFLAT_DIR . "inc/customizer/footer/newsletter.php";

$wp_customize->add_section('section_footer_brand',array(
    'title'         => 'Footer Brand',
    'priority'      => 1,
    'panel'         => 'footer_panel',
));
require THEMESFLAT_DIR . "inc/customizer/footer/footer-brand.php";

$wp_customize->add_section('section_footer_contact',array(
    'title'         => 'Footer Contact',
    'priority'      => 2,
    'panel'         => 'footer_panel',
));
require THEMESFLAT_DIR . "inc/customizer/footer/contact.php";

$wp_customize->add_section('section_bottom',array(
    'title'         => 'Bottom',
    'priority'      => 5,
    'panel'         => 'footer_panel',
));
require THEMESFLAT_DIR . "inc/customizer/footer/bottom.php";



