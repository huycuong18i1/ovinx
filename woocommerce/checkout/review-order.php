<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
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
?>

<?php
	if( !function_exists('tf_coupon_label') ){
		function tf_coupon_label($label, $coupon){
			return sprintf( esc_html__( 'Discount: %s', 'ovinx' ), $coupon->get_code() );
		}
	}
?>

<div class="shop_table woocommerce-checkout-review-order-table">

	<?php do_action( 'woocommerce_review_order_before_cart_contents' ); ?>

	<ul class="list-order-product">
		<?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) : ?>
			<?php
			$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) :
				?>
				<li class="order-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
					<div class="infor-prd">
						<a href="<?php echo esc_url( $_product->get_permalink( $cart_item ) ); ?>" class="prd_name cl-text-main link-underline fw-medium lh-24 text-line-clamp-2">
							<?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) ); ?>
						</a>
						<p class="prd_type text-caption-01">
							<?php esc_html_e( 'Quantity:', 'ovinx' ); ?>
							<span class="cl-text-main">
								<?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', $cart_item['quantity'], $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</span>
						</p>
						<span class="variant">
							<?php
								set_query_var('is_checkout_page', true );
								echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								set_query_var('is_checkout_page', false );
							?>
						</span>
					</div>
					<div class="quantity-price lh-24 fw-medium cl-text-main">
						<span class="price">
							<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</span>
					</div>
				</li>
				<?php
			endif;
			?>
		<?php endforeach; ?>
	</ul>

	<?php do_action( 'woocommerce_review_order_after_cart_contents' ); ?>

	<div class="subtotal lh-24 fw-medium cl-text-main">
		<span><?php esc_html_e( 'Subtotal', 'ovinx' ); ?></span>
		<span class="total"><?php wc_cart_totals_subtotal_html(); ?></span>
	</div>

	<?php add_filter( 'woocommerce_cart_totals_coupon_label', 'tf_coupon_label', 10, 2 ); ?>
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
	<?php themesflat_remove_hook( 'woocommerce_cart_totals_coupon_label', 'tf_coupon_label', 10, 2 ); ?>

	<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
		<div class="discount lh-24 fw-medium cl-text-main fee">
			<span><?php echo esc_html( $fee->name ); ?></span>
			<span class="total"><?php wc_cart_totals_fee_html( $fee ); ?></span>
		</div>
	<?php endforeach; ?>

	<?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
		<?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
			<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited ?>
				<div class="discount lh-24 fw-medium cl-text-main tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
					<span><?php echo esc_html( $tax->label ); ?></span>
					<span class="total"><?php echo wp_kses_post( $tax->formatted_amount ); ?></span>
				</div>
			<?php endforeach; ?>
		<?php else : ?>
			<div class="discount lh-24 fw-medium cl-text-main tax-total">
				<span><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></span>
				<span class="total"><?php wc_cart_totals_taxes_total_html(); ?></span>
			</div>
		<?php endif; ?>
	<?php endif; ?>

	<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

		<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

		<div class="ship">
			<p class="fw-medium lh-24 cl-text-main"><?php esc_html_e( 'Shipping', 'ovinx' ); ?></p>
			<div class="box-check-payment flex-grow-1">
				<?php wc_cart_totals_shipping_html(); ?>
			</div>
		</div>

		<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

	<?php endif; ?>

	<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

	<h5 class="total-order">
		<span><?php esc_html_e( 'Total', 'ovinx' ); ?></span>
		<span class="total each-total-price"><?php wc_cart_totals_order_total_html(); ?></span>
	</h5>

	<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>

</div>
