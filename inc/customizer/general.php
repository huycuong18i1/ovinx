<?php 
$wp_customize->get_section( 'title_tagline' )->panel = 'general_panel';
$wp_customize->get_section( 'background_image' )->panel = 'general_panel';
$wp_customize->get_section( 'static_front_page' )->panel = 'general_panel';


$wp_customize->add_section('section_general',array(
    'title'         => 'Go Top, Preload, Social',
    'panel'         => 'general_panel',
));
require THEMESFLAT_DIR . "inc/customizer/general/general.php";

$wp_customize->add_section('section_login',array(
    'title'         => 'Login',
    'panel'         => 'general_panel',
));
require THEMESFLAT_DIR . "inc/customizer/general/login.php";
