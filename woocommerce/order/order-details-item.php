<?php
/**
 * Order Item Details
 *
 * Rebuilt (2026-09-28, user: "phần order này cần style lại đẹp hơn nổi bật
 * phần product") — the previous markup (`.content > .img-product >
 * figure.img-product-child`) was copied from `amerce` and had ZERO matching
 * CSS in this theme (`.img-product-child` doesn't exist anywhere in
 * `themes/ovinx-html/`), so the product thumbnail rendered at its raw
 * intrinsic size (up to 225x300px), unstyled. Real ground truth for a
 * product-with-image line item inside `.list-order-product` is
 * `themes/ovinx-html/account-orders.html` (~line 2613, My Account > Orders
 * detail modal — `.img-prd`/`.infor-prd`/`.quantity-price`), which already
 * has real, working CSS in `themes/ovinx/css/styles.css` (~line 11037,
 * `.list-order-product .order-item`/`.img-prd`/`.infor-prd`/
 * `.quantity-price`) — this file now emits that exact markup instead.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-item.php.
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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! apply_filters( 'woocommerce_order_item_visible', true, $item ) ) {
	return;
}

if ( ! function_exists( 'tf_remove_key_item_data' ) ) {
	function tf_remove_key_item_data( $item_data, $cart_item ) {
		if ( is_array( $item_data ) ) {
			$i = 0;
			foreach ( $item_data as $key => $data ) {
				++$i;
				if ( 1 === $i ) {
					continue;
				}
				if ( isset( $item_data[ $key ]['display'] ) ) {
					$item_data[ $key ]['display'] = '/ ' . $item_data[ $key ]['display'];
				}
				if ( isset( $item_data[ $key ]['value'] ) ) {
					$item_data[ $key ]['value'] = '/ ' . $item_data[ $key ]['value'];
				}
			}
		}
		return $item_data;
	}
}

$product            = $item->get_product();
$is_visible         = $product && $product->is_visible();
$product_permalink  = apply_filters( 'woocommerce_order_item_permalink', $is_visible ? $product->get_permalink( $item ) : '', $item, $order );
$item_name          = apply_filters( 'woocommerce_order_item_name', $item->get_name(), $item, $is_visible );

$qty          = $item->get_quantity();
$refunded_qty = $order->get_qty_refunded_for_item( $item_id );
$qty_display  = $refunded_qty ? '<del>' . esc_html( $qty ) . '</del> <ins>' . esc_html( $qty - ( $refunded_qty * -1 ) ) . '</ins>' : esc_html( $qty );
$qty_display  = apply_filters( 'woocommerce_order_item_quantity_html', $qty_display, $item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

// Real per-unit price actually billed on this order line (respects any
// line-level discount), not the product's current live price — matches
// ground truth's "{qty} x {unit price}" breakdown.
$unit_price_html = $qty > 0 ? wc_price( $item->get_subtotal() / $qty ) : $order->get_formatted_line_subtotal( $item );
?>
<li class="<?php echo esc_attr( apply_filters( 'woocommerce_order_item_class', 'woocommerce-table__line-item order_item order-item', $item, $order ) ); ?>">
	<?php if ( $product_permalink ) : ?>
		<a href="<?php echo esc_url( $product_permalink ); ?>" class="img-prd">
			<?php echo wp_kses( $product ? $product->get_image() : '', ovinx_template_html_allowed_tags() ); // WooCommerce's own image markup ?>
		</a>
	<?php else : ?>
		<span class="img-prd">
			<?php echo wp_kses( $product ? $product->get_image() : '', ovinx_template_html_allowed_tags() ); // WooCommerce's own image markup ?>
		</span>
	<?php endif; ?>

	<div class="infor-prd">
		<?php if ( $product_permalink ) : ?>
			<a href="<?php echo esc_url( $product_permalink ); ?>" class="prd_name cl-text-main link-underline fw-medium lh-24 text-line-clamp-2">
				<?php echo wp_kses_post( $item_name ); ?>
			</a>
		<?php else : ?>
			<span class="prd_name cl-text-main fw-medium lh-24 text-line-clamp-2">
				<?php echo wp_kses_post( $item_name ); ?>
			</span>
		<?php endif; ?>
		<p class="prd_type text-caption-01">
			<?php esc_html_e( 'Quantity:', 'ovinx' ); ?>
			<span class="cl-text-main"><?php echo wp_kses_post( $qty_display ); // quantity html (<del>/<ins>), filtered by woocommerce_order_item_quantity_html ?></span>
		</p>
		<span class="variant">
			<?php
			do_action( 'woocommerce_order_item_meta_start', $item_id, $item, $order, false );
			add_filter( 'woocommerce_get_item_data', 'tf_remove_key_item_data', 10, 2 );
			wc_display_item_meta( $item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			themesflat_remove_hook( 'woocommerce_get_item_data', 'tf_remove_key_item_data', 10, 2 );
			do_action( 'woocommerce_order_item_meta_end', $item_id, $item, $order, false );
			?>
		</span>
	</div>

	<div class="quantity-price lh-24 fw-medium cl-text-main">
		<span class="quantity"><?php echo wp_kses_post( $qty_display ); // quantity html (<del>/<ins>), filtered by woocommerce_order_item_quantity_html ?></span>
		x
		<span class="price"><?php echo wp_kses_post( $unit_price_html ); ?></span>
	</div>
</li>

<?php if ( $show_purchase_note && $purchase_note ) : ?>

<li class="woocommerce-table__product-purchase-note product-purchase-note">

	<div><?php echo wpautop( do_shortcode( wp_kses_post( $purchase_note ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>

</li>

<?php endif; ?>
