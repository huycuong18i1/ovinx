<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
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

if ( ! $product->is_purchasable() ) {
	return;
}

// echo wc_get_stock_html( $product ); // WPCS: XSS ok.

if ( $product->is_in_stock() ) : ?>

	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

	<form class="cart tf-product-total-quantity tf-simple-form mb-30" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<div class="group-btn">
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

			<button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="action-price animate-btn type-xl tf-btn w-100 btn-add-to-cart single_add_to_cart_button flex-grow-1 button alt<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?> <?php echo esc_attr($tf_btn_classes); ?>">
				<span class="single-add-to-cart-text">
					<?php echo esc_html( $product->single_add_to_cart_text() ); ?>
				</span>
				<span class="dynamic-price-se d-none">-</span>
				<span class="dynamic-price" data-discount="0" data-price="<?php echo esc_attr( $product->get_price() ); ?>"></span>
				<span class="tf-add-to-cart-loading d-none position-relative">
					<span class="spinner"></span>
				</span>
			</button>
			<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
		</div>
		<?php do_action( 'woocommerce_end_add_to_cart_form' ); ?>
	</form>

	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<?php endif; ?>