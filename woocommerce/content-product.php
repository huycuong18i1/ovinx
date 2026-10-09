<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 10.3.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

 
$class_size = '';
if ( function_exists( 'themesflat_get_opt' ) ) {
    $atb_name = themesflat_get_opt('attribute_first');
}

if ( $atb_name == 'none' ) {
    $class_size = '';
} else {
	$atb_name = 'pa_' . $atb_name ;


	$sizes = $product->get_attribute($atb_name);
	
	if (!empty($sizes) && ($product->is_type('variable')) ) {
		$class_size = 'card-product-size';
	}
}

$product_classes = 'fadein isanimated card-product '. $class_size .' ';

$show_out_stock = themesflat_get_opt('badges_stock');

if($product->get_stock_status() == "outofstock"){
    $product_classes .= " out-of-stock ";
}

$product_style = isset($_GET['product_style']) ? sanitize_text_field($_GET['product_style']) : themesflat_get_opt('product_style');
$number_view_active = isset($_GET['number_view_active']) ? sanitize_text_field($_GET['number_view_active']) : themesflat_get_opt('number_view_active');

if( $number_view_active == 1){
	$product_style = 'style-list';
}

if (isset($_POST['product_style'])) {
	$product_style = sanitize_text_field($_POST['product_style']);
}

// if($product_style == 'style-1'){
// 	$product_classes .= ' card_product--V01';
// }

if( $product_style == 'style-list'){
	$product_classes .= " product-list product-style_list ";
}else{
	$product_classes .= " grid ".$product_style;
}

?>
<div <?php post_class($product_classes); ?> >

	<?php
	/**
	 * woocommerce_before_shop_loop_item hook.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item' );

	/**
	 * woocommerce_before_shop_loop_item_title hook.
	 *
	 * @hooked woocommerce_show_product_loop_sale_flash - 10
	 * @hooked woocommerce_template_loop_product_thumbnail - 10
	 */

	do_action( 'woocommerce_before_shop_loop_item_title' );

	/**
	 * woocommerce_shop_loop_item_title hook.
	 *
	 * @hooked woocommerce_template_loop_product_title - 10
	 */
	
	


	/**
	 * woocommerce_after_shop_loop_item_title hook.
	 *
	 * @hooked woocommerce_template_loop_rating - 5
	 * @hooked woocommerce_template_loop_price - 10
	 */
	do_action( 'woocommerce_after_shop_loop_item_title' );

	/**
	 * woocommerce_after_shop_loop_item hook.
	 *
	 * @hooked woocommerce_template_loop_product_link_close - 5
	 * @hooked woocommerce_template_loop_add_to_cart - 10
	 */
	do_action( 'woocommerce_after_shop_loop_item' );
	?>

</div>
