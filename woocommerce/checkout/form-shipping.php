<?php
/**
 * Checkout shipping information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-shipping.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 * @global WC_Checkout $checkout
 */

defined( 'ABSPATH' ) || exit;
?>
<?php if ( true === WC()->cart->needs_shipping_address() ) : ?>
	<div class="box-ip-checkout woocommerce-shipping-fields">

		<h5 id="ship-to-different-address" class="title mb-20">
			<span class="checkbox-wrap">
				<input id="ship-to-different-address-checkbox" class="tf-check-rounded" <?php checked( apply_filters( 'woocommerce_ship_to_different_address_checked', 'shipping' === get_option( 'woocommerce_ship_to_destination' ) ? 1 : 0 ), 1 ); ?> type="checkbox" name="ship_to_different_address" value="1" />
				<label for="ship-to-different-address-checkbox" class="lh-24 cl-text-main fw-medium"><?php esc_html_e( 'Ship to a different address?', 'ovinx' ); ?></label>
			</span>
		</h5>

		<div class="shipping_address">

			<?php do_action( 'woocommerce_before_checkout_shipping_form', $checkout ); ?>

			<div class="form-content gap-xl-24 tf-grid-layout sm-col-2 woocommerce-shipping-fields__field-wrapper">
				<?php
				$fields = $checkout->get_checkout_fields( 'shipping' );

				foreach ( $fields as $key => $field ) {
					woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
				}
				?>
			</div>

			<?php do_action( 'woocommerce_after_checkout_shipping_form', $checkout ); ?>

		</div>
	</div>
<?php endif; ?>

<?php if ( apply_filters( 'woocommerce_enable_order_notes_field', 'yes' === get_option( 'woocommerce_enable_order_comments', 'yes' ) ) ) : ?>
	<div class="box-ip-checkout woocommerce-additional-fields">
		<?php do_action( 'woocommerce_before_order_notes', $checkout ); ?>

		<?php if ( ! WC()->cart->needs_shipping() || wc_ship_to_billing_address_only() ) : ?>

			<h5 class="title mb-20"><?php esc_html_e( 'Additional information', 'ovinx' ); ?></h5>

		<?php endif; ?>

		<div class="form-content gap-xl-24 woocommerce-additional-fields__field-wrapper">
			<?php foreach ( $checkout->get_checkout_fields( 'order' ) as $key => $field ) : ?>
				<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
			<?php endforeach; ?>
		</div>

		<?php do_action( 'woocommerce_after_order_notes', $checkout ); ?>
	</div>
<?php endif; ?>
