<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
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
 * @var WC_Order $order
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="woocommerce-order">

	<?php
	if ( $order ) :

		do_action( 'woocommerce_before_thankyou', $order->get_id() );
		?>

		<?php if ( $order->has_status( 'failed' ) ) : ?>
			<div class="thank-wrap flat-spacing pt-0">
				<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'ovinx' ); ?></p>

				<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
					<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php esc_html_e( 'Pay', 'ovinx' ); ?></a>
					<?php if ( is_user_logged_in() ) : ?>
						<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php esc_html_e( 'My account', 'ovinx' ); ?></a>
					<?php endif; ?>
				</p>
			</div>
		<?php else : ?>

			<?php wc_get_template( 'checkout/order-received.php', array( 'order' => $order ) ); ?>

			<div class="container">
				<div class="s-checkout place-order-wrap row gy-30">
					<div class="left-col col-xl-8">
						<div class="tf-main-success">

							<div class="box-progress-order">
                                <div class="order-progress-item order-code text-center">
                                    <div class="title text-caption-01 fw-semibold"><?php esc_html_e( 'Order number', 'ovinx' ); ?></div>
                                    <div class="fw-medium code"><?php echo esc_html( $order->get_order_number() ); ?></div>
                                </div>
                                <div class="order-progress-item order-date text-center">
                                    <div class="title text-caption-01 fw-semibold"><?php esc_html_e( 'Order date', 'ovinx' ); ?></div>
                                    <div class="fw-medium date"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></div>
                                </div>
                                <div class="order-progress-item order-total text-center">
                                    <div class="title text-caption-01 fw-semibold"><?php esc_html_e( 'Order total', 'ovinx' ); ?></div>
                                    <div class="fw-medium total"><?php echo wp_kses_post( $order->get_formatted_order_total() ); ?></div>
                                </div>
                                <div class="order-progress-item payment-method text-center">
                                    <div class="title text-caption-01 fw-semibold"><?php esc_html_e( 'Payment method', 'ovinx' ); ?></div>
                                    <div class="fw-medium metod">
										<?php if ( $order->get_payment_method_title() ) : ?>
											<?php echo wp_kses_post( $order->get_payment_method_title() ); ?>
										<?php endif; ?>
									</div>
                                </div>
                            </div>

							<div class="box-timeline-order d-none">
                                <div class="timeline-item active text-center">
                                    <div class="box-icon">
                                        <span class="icon icon-Confirm"></span>
                                    </div>
                                    <div class="content">
                                        <div class="title fw-medium">Confirmed</div>
                                        <span class="date fw-medium text-caption-01 cl-text-2">10 April 2026</span>
                                    </div>
                                </div>
                                <div class="line-time"></div>
                                <div class="timeline-item text-center">
                                    <div class="box-icon">
                                        <span class="icon icon-Shipped"></span>
                                    </div>
                                    <div class="content">
                                        <div class="title fw-medium">Shipped</div>
                                        <span class="date fw-medium text-caption-01 cl-text-2">20 April 2026</span>
                                    </div>
                                </div>
                                <div class="line-time"></div>
                                <div class="timeline-item text-center">
                                    <div class="box-icon">
                                        <span class="icon icon-Location"></span>
                                    </div>
                                    <div class="content">
                                        <div class="title fw-medium">Delivered</div>
                                        <span class="date fw-medium text-caption-01 cl-text-2">22 April 2026</span>
                                    </div>
                                </div>
                            </div>

							<div class="map-order">
								<?php
								$store_address   = get_option( 'woocommerce_store_address' );
								$store_address_2 = get_option( 'woocommerce_store_address_2' );
								$store_city      = get_option( 'woocommerce_store_city' );
								$store_postcode  = get_option( 'woocommerce_store_postcode' );
								$store_country   = get_option( 'woocommerce_default_country' );

								$full_address = trim( $store_address . ' ' . $store_address_2 . ', ' . $store_city . ', ' . $store_postcode . ', ' . $store_country );
								$encoded_address = urlencode( $full_address );
								?>

								<iframe
									title="Map"
									src="https://www.google.com/maps?q=<?php echo esc_attr($encoded_address); ?>&output=embed"
									width="100%"
									height="499"
									style="<?php echo esc_attr('border:0;'); ?>"
									allowfullscreen
									loading="lazy"
									referrerpolicy="no-referrer-when-downgrade">
								</iframe>
							</div>

							<?php wc_get_template( 'order/order-details-customer.php', array( 'order' => $order ) ); ?>

							<?php wc_get_template( 'order/testimonial-thankyou.php'); ?>
						</div>
					</div>

					<div class="right-col col-xl-4">
						<div class="tf-page-cart-sidebar">
							<?php wc_get_template( 'order/order-details.php', array( 'order_id' => $order->get_id() ) ); ?>
						</div>
						<?php do_action('tf_after_order_details'); ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
		<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
		<?php //do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

	<?php else : ?>

		<?php wc_get_template( 'checkout/order-received.php', array( 'order' => false ) ); ?>

	<?php endif; ?>

</div>
