<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

if ( $product->get_stock_status() === 'outofstock' ) {

	$label = esc_html__( 'Out Of Stock', 'ovinx' );
	$class = 'out-stock';

} else {

	$class = '';
	$label = esc_html__( 'In stock', 'ovinx' );

	if ( $product->managing_stock() && is_numeric( $product->get_stock_quantity() ) ) {
		$stock_quantity  = $product->get_stock_quantity();
		$low_stock_amount = wc_get_low_stock_amount( $product );

		if ( $stock_quantity <= $low_stock_amount ) {
			$class = 'low-stock';
			$label = esc_html__( 'Low Stock', 'ovinx' );
		}
	}
}
?>
<div class="product-badge_stock text-label fw-semibold <?php echo esc_attr( $class ); ?>">
	<span class="br-dot"></span><?php echo wp_kses_post( $label ); ?>
</div>
