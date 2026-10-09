<?php
/**
 * Checkout Order Receipt Template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/order-receipt.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 10.3.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="box-progress-order">
	<div class="order-progress-item order-code text-center">
		<div class="title text-sm fw-medium"><?php esc_html_e( 'Order number:', 'ovinx' ); ?></div>
		<div class="text-md fw-medium code"><?php echo esc_html( $order->get_order_number() ); ?></div>
	</div>
	<div class="order-progress-item order-date text-center">
		<div class="title text-sm fw-medium"><?php esc_html_e( 'Date:', 'ovinx' ); ?></div>
		<div class="text-md fw-medium date"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></div>
	</div>
	<div class="order-progress-item order-total text-center">
		<div class="title text-sm fw-medium"><?php esc_html_e( 'Total:', 'ovinx' ); ?></div>
		<div class="text-md fw-medium total"><?php echo wp_kses_post( $order->get_formatted_order_total() ); ?></div>
	</div>
	<?php if ( $order->get_payment_method_title() ) : ?>
	<div class="order-progress-item payment-method text-center">
		<div class="title text-sm fw-medium"><?php esc_html_e( 'Payment method:', 'ovinx' ); ?></div>
		<div class="text-md fw-medium metod"><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></div>
	</div>
	<?php endif; ?>
</div>

<?php do_action( 'woocommerce_receipt_' . $order->get_payment_method(), $order->get_id() ); ?>

<div class="clear"></div>
