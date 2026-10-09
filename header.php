<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package ovinx
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="https://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php // QA UX-015: skip link first, BEFORE wp_body_open() (that hook prints the #goTop button, which used to take the first Tab stop). ?>
<a class="skip-link screen-reader-text" href="#main-content"><?php esc_html_e( 'Skip to content', 'ovinx' ); ?></a>
<?php wp_body_open(); ?>
<div class="themesflat-boxed">
	<?php
        get_template_part( 'tpl/site-header');        		
	?>
	
	<!-- Page Title -->
	<?php get_template_part( 'tpl/page-title'); ?>
	<?php 

		if ( class_exists( 'WooCommerce' ) ) {
			if ( is_shop()|| is_tax('product_cat') ) {
				get_template_part('woocommerce/tpl/product-category/style-1');
			}
		}
		
		$class_is_full_width = '';

		$gallery_layout = empty($_GET['gallery_layout']) ? themesflat_get_opt('tf_product_gallery_layout') : $_GET['gallery_layout'];

		if( function_exists('is_product') && is_product() && ( $gallery_layout == 'no_thumb' || $gallery_layout == 'middle_gallery') ){
			$class_is_full_width = 'page-single-no-thumb';
		}

	?>	
	<main id="main-content" class="site-main clearfix">
		<div id="themesflat-content" class="page-wrap <?php echo esc_attr( themesflat_blog_layout() ); ?> <?php echo esc_attr( $class_is_full_width ); ?>">