<?php
/**
 * Product quantity inputs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/quantity-input.php.
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

if( !function_exists('get_real_bundle_product_qty_in_cart') ){
function get_real_bundle_product_qty_in_cart( $product_id ) {

    if ( ! function_exists('WC') || ! WC()->cart ) {
        return 0;
    }

    $total = 0;

    foreach ( WC()->cart->get_cart() as $cart_item ) {

        if (
            ! empty( $cart_item['tf_custom_bundle'] ) &&
            (
                $cart_item['product_id'] == $product_id ||
                (
                    isset( $cart_item['variation_id'] ) &&
                    $cart_item['variation_id'] == $product_id
                )
            )
        ) {
            $total += $cart_item['quantity'];
        }
    }

    return $total;
}
}

global $product;

$quantity_style = get_query_var('quantity_style', 'style-1');

$is_minicart = get_query_var('mini_cart_quantity', false);

$in_cart = 0;

if( !empty($is_minicart ) ){
	$quantity_style = 'style-3';
	$product_id = get_query_var('mini_cart_product_id_loop', false);
	$product = wc_get_product($product_id);

	if( !empty($product) && !empty($max_value) ){
		$bunle_in_cart_qty = get_real_bundle_product_qty_in_cart($product->get_id());
		$max_value = max(1, (int)$max_value - (int)$bunle_in_cart_qty);
	}

}elseif(!empty($max_value) && !empty($product) ){
	
	if ( WC()->cart ) {
		$item_quantities = WC()->cart->get_cart_item_quantities();
		$in_cart = $item_quantities[$product->get_id()] ?? 0;
	} else {
		$in_cart = 0;
	}

	$max_value = max(1, (int)$max_value - (int)$in_cart);
}

// $quantity_style= '';

if ( $max_value && $min_value === $max_value && $product->is_type('simple') ) {
	?>
	<div class="quantity hidden">
		<input type="hidden" id="<?php echo esc_attr( $input_id ); ?>" class="qty" name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $min_value ); ?>" />
	</div>
	<?php
} else {
	/* translators: %s: Quantity. */
	$label = ! empty( $args['product_name'] ) ? sprintf( esc_html__( '%s quantity', 'ovinx' ), wp_strip_all_tags( $args['product_name'] ) ) : esc_html__( 'Quantity', 'ovinx' );
	?>
	<div class="quantity">
	    <label class="screen-reader-text label text-md d-block" for="<?php echo esc_attr( $input_id ); ?>"><?php esc_html_e( 'Quantity:', 'ovinx' ); ?></label>
	    <div class="inner-quantity wg-quantity <?php echo esc_attr( $quantity_style ); ?>">
		    <button type="button" value="-" class="btn-quantity qty_button minus btn-decrease" aria-label="<?php esc_attr_e( 'Decrease quantity', 'ovinx' ); ?>">
				<i class="icon icon-Minus"></i>
			</button>
		    <input  type="number"
					id="<?php echo esc_attr( $input_id ); ?>"
					class="quantity-product <?php echo esc_attr( join( ' ', (array) $classes ) ); ?>"
					step="<?php echo esc_attr( $step ); ?>"
					min="<?php echo esc_attr( $min_value ); ?>"
					<?php if ( 0 < $max_value ) : ?>
						max="<?php echo esc_attr( $max_value ); ?>"
					<?php endif; ?>
					name="<?php echo esc_attr( $input_name ); ?>"
					value="<?php echo esc_attr( $input_value ); ?>"
					title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'ovinx' ); ?>"
					placeholder="<?php echo esc_attr( $placeholder ); ?>"
					inputmode="<?php echo esc_attr( $inputmode ); ?>" />
		    <button type="button" value="+" class="btn-quantity qty_button plus btn-increase" aria-label="<?php esc_attr_e( 'Increase quantity', 'ovinx' ); ?>">
				<i class="icon icon-Plus"></i>
			</button>
		</div>
	</div>
	<?php
}
