<?php
/**
 * Edit address form — matches ovinx-html's account-addresses.html field styling
 * (`.form-content`/`.tf-grid-layout`), built on WooCommerce's real field set (keeps the real
 * billing/shipping data model checkout depends on — ground truth's single combined form has no
 * such split, so isn't followed literally here, only its visual language is).
 *
 * WooCommerce's own frontend CSS is dequeued theme-wide (`woocommerce_enqueue_styles` filtered to
 * false in woocommerce/class-woo/class-woo-hook.php), so `woocommerce_form_field()`'s default
 * `<p class="form-row">` output gets its input/select/textarea styling "for free" from the theme's
 * own generic `form input[type=...]` rule (css/styles.css:7748) which matches by tag+type, not by
 * WC's own classes — only the 2-column GRID layout below is new, added via `woocommerce_form_field_args`.
 *
 * @package ovinx
 */

defined( 'ABSPATH' ) || exit;

$page_title = ( 'billing' === $load_address ) ? esc_html__( 'Billing Address', 'ovinx' ) : esc_html__( 'Shipping Address', 'ovinx' );

do_action( 'woocommerce_before_edit_account_address_form' );

if ( ! function_exists( 'ovinx_address_field_args' ) ) {
	function ovinx_address_field_args( $args ) {
		$args['label_class'][] = 'tf-lable';
		$args['label_class'][] = 'cl-text-main';
		$args['label_class'][] = 'fw-medium';
		return $args;
	}
}
add_filter( 'woocommerce_form_field_args', 'ovinx_address_field_args' );
?>

<h4 class="account-title"><?php echo esc_html( apply_filters( 'woocommerce_my_account_edit_address_title', $page_title, $load_address ) ); ?></h4>

<?php if ( ! $load_address ) : ?>
	<?php wc_get_template( 'myaccount/my-address.php' ); ?>
<?php else : ?>

	<div class="account-my_address">
		<form method="post" novalidate class="form-account-address">
			<div class="woocommerce-address-fields form-content">
				<?php do_action( "woocommerce_before_edit_address_form_{$load_address}" ); ?>

				<div class="woocommerce-address-fields__field-wrapper tf-grid-layout sm-col-2">
					<?php
					foreach ( $address as $key => $field ) {
						woocommerce_form_field( $key, $field, wc_get_post_data_by_key( $key, $field['value'] ) );
					}
					?>
				</div>

				<?php do_action( "woocommerce_after_edit_address_form_{$load_address}" ); ?>
			</div>

			<button type="submit" class="btn-action-submit tf-btn px-v1" name="save_address" value="<?php esc_attr_e( 'Save address', 'ovinx' ); ?>"><?php esc_html_e( 'Update Address', 'ovinx' ); ?></button>
			<?php wp_nonce_field( 'woocommerce-edit_address', 'woocommerce-edit-address-nonce' ); ?>
			<input type="hidden" name="action" value="edit_address">
		</form>
	</div>

<?php endif; ?>

<?php do_action( 'woocommerce_after_edit_account_address_form' ); ?>
