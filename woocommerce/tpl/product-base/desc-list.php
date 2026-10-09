<?php
/**
 * `.product-desc_list` — list-style-only bullet facts under the price. Ground truth's demo shows
 * "Brand/Item Weight/Manufacturer" (automotive-parts placeholder content from ovinx-html's demo
 * data) which has no direct WC field mapping — built instead from REAL data this store actually
 * has: the `product_brand` taxonomy (confirmed real, already used for the `data-brand` filter
 * attribute on `.card-product`), WooCommerce's own Weight field, and SKU. Each line only prints
 * when that product actually has the data — nothing fabricated.
 *
 * @package ovinx
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

global $product;

$lines = array();

if ( taxonomy_exists( 'product_brand' ) ) {
	$brands = get_the_terms( $product->get_id(), 'product_brand' );
	if ( $brands && ! is_wp_error( $brands ) ) {
		$lines[] = sprintf(
			/* translators: %s: brand name */
			esc_html__( 'Brand: %s', 'ovinx' ),
			esc_html( $brands[0]->name )
		);
	}
}

if ( $product->get_weight() ) {
	$lines[] = sprintf(
		/* translators: 1: weight 2: weight unit */
		esc_html__( 'Weight: %1$s %2$s', 'ovinx' ),
		esc_html( $product->get_weight() ),
		esc_html( get_option( 'woocommerce_weight_unit' ) )
	);
}

if ( $product->get_sku() ) {
	$lines[] = sprintf(
		/* translators: %s: SKU */
		esc_html__( 'SKU: %s', 'ovinx' ),
		esc_html( $product->get_sku() )
	);
}

if ( empty( $lines ) ) {
	return;
}
?>
<ul class="product-desc_list">
	<?php foreach ( $lines as $line ) : ?>
		<li>
			<span class="br-dot"></span>
			<?php echo wp_kses_post( $line ); ?>
		</li>
	<?php endforeach; ?>
</ul>
