<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

/**
 * Ground truth (shop-default.html) always uses 2 separate spans — .price-new (cl-text-main, the
 * normal dark text color, NOT the brand/primary accent) and, only when on sale, .price-old
 * (muted, strikethrough via its own CSS) — never WC's own del/ins price_html blob wrapped in one
 * colored span, which is what this used to output.
 */
$sale_price    = '';
$regular_price = '';

if ( $product->is_type( 'simple' ) && $product->is_on_sale() ) {
	$sale_price    = $product->get_sale_price();
	$regular_price = $product->get_regular_price();
} elseif ( $product->is_type( 'variable' ) && $product->is_on_sale() ) {
	// A variable product's price is a RANGE across its variations, not one number — get_sale_price()/
	// get_regular_price() are empty on the parent. Only collapse it to the same simple new/old pair
	// when every variation actually shares one sale price and one regular price (true here: this
	// importer never varies price per color); a genuine range ($X-$Y) can't honestly be shown as a
	// single "new vs old" pair, so that case is left to fall through to WC's own price_html below.
	$min_price    = $product->get_variation_price( 'min' );
	$max_price    = $product->get_variation_price( 'max' );
	$min_regular  = $product->get_variation_regular_price( 'min' );
	$max_regular  = $product->get_variation_regular_price( 'max' );

	if ( '' !== $min_price && $min_price === $max_price && '' !== $min_regular && $min_regular === $max_regular ) {
		$sale_price    = $min_price;
		$regular_price = $min_regular;
	}
}

if ( '' !== $sale_price && '' !== $regular_price ) {
	?>
	<div class="price-wrap">
		<span class="price-new cl-text-main fw-medium lh-24"><?php echo wp_kses_post( wc_price( wc_get_price_to_display( $product, array( 'price' => $sale_price ) ) ) ); ?></span>
		<span class="price-old cl-text-mute text-caption-01"><?php echo wp_kses_post( wc_price( wc_get_price_to_display( $product, array( 'price' => $regular_price ) ) ) ); ?></span>
	</div>
	<?php
} else {
	?>
	<div class="price-wrap">
		<span class="price-new cl-text-main fw-medium lh-24">
			<?php echo wp_kses_post( $product->get_price_html() ); ?>
		</span>
	</div>
	<?php
}
