<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 10.3.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<?php if ( isset( WC()->session ) && WC()->session->has_session() ): ?>
	<?php

		$session_array = (array) WC()->session;

		$expiration = $session_array["\0*\0_session_expiration"];
		$expiring   = $session_array["\0*\0_session_expiring"];

		$expiration_time = $expiration - time();

	?>

	<?php if( $expiration_time > 0 && $expiration_time < 7200000 ) : ?>
		<div class="tf-cart-sold">
			<div class="notification-sold">
				<div class="count-text text-caption-01 cl-text-main">
				<?php
					printf(
						/* translators: %s: countdown timer html */
						esc_html__( '🔥 Your cart will expire in %s minutes! Please checkout now before your items sell out!', 'ovinx' ),
						'<span class="js-countdown time-count cd-has-zero cd-no" data-timer="' . esc_attr($expiration_time) . '" data-labels=":,:,:,"></span>'
					);
				?>
				</div>
			</div>
		</div>
	<?php endif; ?>
<?php endif; ?>

<?php

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	// echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', esc_html__( 'You must be logged in to checkout.', 'ovinx' ) ) );

	?>
	<div class="wrap-quick-login">
		<p class="title cl-text-2">
			<?php
				echo wp_kses_post(
					sprintf(
						__( 'You must be %s in to checkout. ', 'ovinx' ),
						'<a href="#log" data-bs-toggle="modal" class="tf-btn-line-2 style-primary fw-semibold ">logged</a>'
					)
				);
			?>
		</p>

	</div>

	<?php

	return;
}

?>

<form name="checkout" method="post" class="checkout woocommerce-checkout-form" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
	<div class="flat-spacing-mix-1">
		<div class="container">
			<div class="row">
				<?php if ( $checkout->get_checkout_fields() ) : ?>

					<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
					<div class="col-lg-7">
						<div id="customer_details" class="tf-page-checkout mb-lg-0">
							<?php do_action( 'woocommerce_checkout_billing' ); ?>
							<?php do_action( 'woocommerce_checkout_shipping' ); ?>
						</div>
					</div>
					<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

				<?php endif; ?>

				<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
				<div class="col-lg-5">
					<div class="fl-sidebar-cart mt-lg-0 sticky-top">
						<div class="box-order-summary order-checkout">
							<h4 id="order_review_heading" class="mb-24"><?php esc_html_e( 'Your order', 'ovinx' ); ?></h4>

							<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

							<div id="order_review" class="woocommerce-checkout-review-order">
								<?php do_action( 'woocommerce_checkout_order_review' ); ?>
							</div>
						</div>
					</div>
				</div>
				<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
			</div>
		</div>
	</div>
</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
