<?php
/**
 * Single variation cart quantity
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 10.3.4
 */

defined( 'ABSPATH' ) || exit;

global $product;

if( empty( $product ) ) {
	return;
}

?>
<?php
do_action( 'woocommerce_before_add_to_cart_quantity' );

woocommerce_quantity_input(
	array(
		'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
		'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
		'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
	)
);

do_action( 'woocommerce_after_add_to_cart_quantity' );
?>
