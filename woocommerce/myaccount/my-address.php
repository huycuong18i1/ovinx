<?php
/**
 * My Addresses — list view (billing/shipping cards with Edit/Add links). No ground-truth markup
 * exists for this specific list view (ovinx-html's account-addresses.html shows a single combined
 * edit form directly, but that contradicts WooCommerce's real billing+shipping address model, which
 * checkout depends on) — built using the theme's own confirmed-real `.wg-my-order`-style bordered
 * card language for visual consistency with Orders, rather than inventing new unstyled markup.
 *
 * @package ovinx
 */

defined( 'ABSPATH' ) || exit;

$customer_id = get_current_user_id();

if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		array(
			'billing'  => __( 'Billing address', 'ovinx' ),
			'shipping' => __( 'Shipping address', 'ovinx' ),
		),
		$customer_id
	);
} else {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		array(
			'billing' => __( 'Billing address', 'ovinx' ),
		),
		$customer_id
	);
}
?>

<h4 class="account-title"><?php esc_html_e( 'My Address', 'ovinx' ); ?></h4>

<p class="mb-20"><?php echo esc_html( apply_filters( 'woocommerce_my_account_my_address_description', __( 'The following addresses will be used on the checkout page by default.', 'ovinx' ) ) ); ?></p>

<div class="tf-grid-layout sm-col-2">
	<?php foreach ( $get_addresses as $name => $address_title ) :
		$address = wc_get_account_formatted_address( $name );
		?>
		<div class="wg-my-order woocommerce-Address">
			<div class="order-heading h6">
				<div class="order_number"><?php echo esc_html( $address_title ); ?></div>
				<a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address', $name ) ); ?>" class="link cl-text-main text-decoration-underline">
					<?php echo esc_html( $address ? __( 'Edit', 'ovinx' ) : __( 'Add', 'ovinx' ) ); ?>
				</a>
			</div>
			<div class="order-content">
				<address class="text-body-02">
					<?php
					echo wp_kses_post( $address ? $address : __( 'You have not set up this type of address yet.', 'ovinx' ) );
					do_action( 'woocommerce_my_account_after_my_address', $name );
					?>
				</address>
			</div>
		</div>
	<?php endforeach; ?>
</div>
