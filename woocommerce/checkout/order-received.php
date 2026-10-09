<?php
/**
 * "Order received" message.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/order-received.php.
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
 *
 * @var WC_Order|false $order
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="thank-wrap flat-spacing pt-0">

	<div class="title-success-order text-center">
		<span class="icon icon-CheckCircle d-block"></span>
		<div class="box-title">
			<h2 class="title letter-space-1 woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received">

			<?php
				/**
				 * Filter the message shown after a checkout is complete.
				 *
				 * @since 2.2.0
				 *
				 * @param string         $message The message.
				 * @param WC_Order|false $order   The order created during checkout, or false if order data is not available.
				 */
				$message = apply_filters(
					'woocommerce_thankyou_order_received_text',
					esc_html( __( 'Thank you. Your order has been received.', 'ovinx' ) ),
					$order
				);

				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo wp_kses_post($message);
			?>
			</h2>

			<p class="cl-text-2">
				<?php
					esc_html_e( 'You are awesome, Ovinx! Thank you so much for your purchase.' , 'ovinx' );
				?>
			</p>
		</div>
	</div>

	<?php do_action('woocommerce_after_thankyou_order_received_text'); ?>
</div>
