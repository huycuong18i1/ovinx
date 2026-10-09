<?php
/**
 * External product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/external.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 10.3.4
 */

defined( 'ABSPATH' ) || exit;

$tf_btn_classes = 'hover-primary';

if( !empty($_GET['tf_btn_classes']) ){
	$tf_btn_classes = sanitize_text_field($_GET['tf_btn_classes']);
}

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="cart tf-product-total-quantity tf-external-form" action="<?php echo esc_url( $product_url ); ?>" method="get">

	<div class="group-btn">
		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
		<a href="<?php echo esc_url( $product_url ); ?>" class="tf-btn btn-fill type-xl fw-medium animate-btn w-100 flex-grow-1 btn-add-to-cart single_add_to_cart_button button alt<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?> <?php echo esc_attr($tf_btn_classes); ?>"><?php echo esc_html( $button_text ); ?></a>
		<?php wc_query_string_form_fields( $product_url ); ?>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
	</div>
</form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
