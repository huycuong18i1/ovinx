<?php
/**
 * Checkout coupon form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-coupon.php.
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

if ( ! wc_coupons_enabled() ) { // @codingStandardsIgnoreLine.
	return;
}

?>
<div class="woocommerce-form-coupon-toggle">
	<?php wc_print_notice( apply_filters( 'woocommerce_checkout_coupon_message', esc_html__( 'Have a coupon?', 'ovinx' ) . ' <a href="#" class="showcoupon">' . esc_html__( 'Click here to enter your code', 'ovinx' ) . '</a>' ), 'notice' ); ?>
</div>

<form class="checkout_coupon woocommerce-form-coupon" method="post" style="<?php echo esc_attr('display:none;'); ?>">
	<div class="ip-discount-code">
		<label for="coupon_code" class="screen-reader-text"><?php esc_html_e( 'Coupon:', 'ovinx' ); ?></label>
		<input type="text" name="coupon_code" placeholder="<?php esc_attr_e( 'Coupon code', 'ovinx' ); ?>" id="coupon_code" value="" />
		<button type="submit" class="tf-btn style-2 animate-btn bg-cl-text" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'ovinx' ); ?>"><?php esc_html_e( 'Apply coupon', 'ovinx' ); ?></button>
	</div>
</form>
