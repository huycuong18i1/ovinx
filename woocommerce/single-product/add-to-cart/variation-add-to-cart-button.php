<?php
/**
 * Single variation cart button
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 10.3.4
 */

defined( 'ABSPATH' ) || exit;

global $product;
$tf_btn_classes = '';

if( !empty($_GET['tf_btn_classes']) ){
	$tf_btn_classes = sanitize_text_field($_GET['tf_btn_classes']);
}

$tf_btn_classes .= ' has-loading';
$is_quick_view = get_query_var('is_quick_view', false);
$is_quick_add = get_query_var('is_quick_add', false);

if( !empty($is_quick_view) || !empty($is_quick_add) ){
	$tf_btn_classes .= ' loading-hidden-text';
}

$label_classes = 'quantity-label';

if ( $product->is_sold_individually() ) {
	$label_classes .= ' hidden';
}

?>
<div class="cart tf-product-total-quantity woocommerce-variation-add-to-cart variations_button">
	<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

	<div class="variant-picker-label <?php echo esc_attr($label_classes); ?>">
		<div class="">
			<?php _e('Quantity:', 'ovinx'); ?>
		</div>
	</div>

	<div class="variant-quantity">

		<?php //wc_get_template( 'single-product/extras/add-to-cart-quantity.php'); ?>
		<div class="group-btn flex-grow-1">

			<?php
			do_action( 'woocommerce_before_add_to_cart_quantity' );

			woocommerce_quantity_input(
				array(
					'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
					'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
					'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
				)
			);

			do_action( 'woocommerce_after_add_to_cart_quantity' );
			?>

			<button type="submit" class="action-price animate-btn tf-btn type-xl w-100 flex-grow-1 btn-add-to-cart single_add_to_cart_button button alt <?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?> <?php echo esc_attr($tf_btn_classes); ?>">
				<span class="single-add-to-cart-text">
					<?php echo esc_html( $product->single_add_to_cart_text() ); ?>
				</span>
				<span class="dynamic-price-se d-none">-</span>
				<span class="dynamic-price" data-discount="0" data-price="0"></span>
				<span class="tf-add-to-cart-loading d-none position-relative">
					<span class="spinner"></span>
				</span>
			</button>

			<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
		</div>

	</div>
	<?php do_action( 'woocommerce_end_single_variation' ); ?>
	<input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
	<input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
	<input type="hidden" name="variation_id" class="variation_id" value="0" />
</div>
