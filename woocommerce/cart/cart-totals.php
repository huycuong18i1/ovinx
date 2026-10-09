<?php
/**
 * Cart totals
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-totals.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 10.3.4
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="cart_totals <?php echo ( WC()->customer->has_calculated_shipping() ) ? 'calculated_shipping' : ''; ?>">

	<?php do_action( 'woocommerce_before_cart_totals' ); ?>

	<h5 class="title mb-20">
		<?php _e( 'Order Summary', 'ovinx' ); ?>
	</h5>

	<div class="subtotal lh-24 fw-medium cl-text-main">
		<span><?php esc_html_e( 'Subtotal', 'ovinx' ); ?></span>
		<span class="total"><?php wc_cart_totals_subtotal_html(); ?></span>
	</div>

	<?php if ( WC()->cart->get_coupons() ) : ?>
		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<div class="discount lh-24 fw-medium cl-text-main coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
				<span><?php wc_cart_totals_coupon_label( $coupon ); ?></span>
				<span class="total"><?php wc_cart_totals_coupon_html( $coupon ); ?></span>
			</div>
		<?php endforeach; ?>
	<?php else : ?>
		<div class="discount lh-24 fw-medium cl-text-main">
			<span><?php esc_html_e( 'Discounts', 'ovinx' ); ?></span>
			<span class="total">-<?php echo wp_kses_post( wc_price( 0 ) ); ?></span>
		</div>
	<?php endif; ?>

	<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
		<div class="discount lh-24 fw-medium cl-text-main">
			<span><?php echo esc_html( $fee->name ); ?></span>
			<span class="total"><?php wc_cart_totals_fee_html( $fee ); ?></span>
		</div>
	<?php endforeach; ?>

	<?php
	if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) {
		if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) {
			foreach ( WC()->cart->get_tax_totals() as $code => $tax ) { // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
				?>
				<div class="discount lh-24 fw-medium cl-text-main tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
					<span><?php echo esc_html( $tax->label ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<span class="total"><?php echo wp_kses_post( $tax->formatted_amount ); ?></span>
				</div>
				<?php
			}
		} else {
			?>
			<div class="discount lh-24 fw-medium cl-text-main">
				<span><?php echo esc_html( WC()->countries->tax_or_vat() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
				<span class="total"><?php wc_cart_totals_taxes_total_html(); ?></span>
			</div>
			<?php
		}
	}
	?>

	<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

		<?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>

		<div class="ship">
			<p class="fw-medium lh-24 cl-text-main"><?php esc_html_e( 'Shipping', 'ovinx' ); ?></p>
			<div class="box-check-payment flex-grow-1">
				<?php wc_cart_totals_shipping_html(); ?>
			</div>
		</div>

		<?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>

	<?php elseif ( WC()->cart->needs_shipping() && 'yes' === get_option( 'woocommerce_enable_shipping_calc' ) ) : ?>

		<div class="ship">
			<p class="fw-medium lh-24 cl-text-main"><?php esc_html_e( 'Shipping', 'ovinx' ); ?></p>
			<div class="box-check-payment flex-grow-1">
				<?php woocommerce_shipping_calculator(); ?>
			</div>
		</div>

	<?php endif; ?>

	<?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>

	<h5 class="total-order">
		<span><?php esc_html_e( 'Total', 'ovinx' ); ?></span>
		<span class="total each-total-price"><?php wc_cart_totals_order_total_html(); ?></span>
	</h5>

	<?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>

	<fieldset class="checkbox-wrap check-agree">
		<input id="agree-term" name="agree" type="checkbox" class="tf-check-rounded" required=true>
		<label for="agree-term" class="cl-text-main">
			<?php _e('I agree with', 'ovinx'); ?>
			<a href="<?php echo esc_url( themesflat_get_opt( 'minicart_term_link') ?? '#' ); ?>" class="text-decoration-underline link">
				<?php _e('Terms & Conditions', 'ovinx'); ?>
			</a>
		</label>
	</fieldset>

	<div class="list-ver checkout-btn text-center">
		<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" id="checkout-btn" class="action-checkout tf-btn w-100 animate-btn">
			<?php esc_html_e( 'Process To Checkout', 'ovinx' ); ?>
		</a>
		<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="cl-text-main link-underline">
			<span class="fw-semibold text-uppercase">Or Continue Shopping</span>
		</a>
	</div>

	<?php do_action( 'woocommerce_after_cart_totals' ); ?>

</div>

