<?php
/**
 * List-style card's right-hand panel (`.card-product_button` — Price/Quantity/Add to Cart +
 * Compare/Share) and the vertical divider before it. Ground truth (list-style card markup)
 * hides both on mobile (real CSS: `.product-style_list .card-product_button, .product-style_list
 * > .br-line { display:none }` under max-width:767px) — the mobile fallback add-to-cart lives in
 * `.card-product_info` instead (`tfwc_action_bot()`, `.box-action_add.d-md-none`).
 *
 * @package ovinx
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

global $product;

$button_text = $product->is_type( 'variable' )
	? __( 'Quick Add', 'ovinx' )
	: $product->add_to_cart_text(); // escaped where it is printed (esc_html), not here — avoids double-encoding

/**
 * Ground truth's Compare link here was a plain `<a href="?add_to_compare=...">` — a real add-url,
 * but a normal full-page navigation with none of the AJAX classes/state that
 * `.product-action_list`'s own Compare icon (product-base/compare.php's `tfwc_compare_button()`,
 * wired to the wcboost-products-compare plugin's own click handler — see its assets/js/compare.js
 * `AddToCompareHandler`) gets for free. Build the same real args (`Frontend::get_button_template_args()`
 * — the exact method that hook uses) instead of hand-rolling the URL, so this text-label button is
 * wired to the same real AJAX add/remove-from-compare behavior, just with our own icon+label markup.
 */
$compare_args = class_exists( '\WCBoost\ProductsCompare\Frontend' )
	? \WCBoost\ProductsCompare\Frontend::instance()->get_button_template_args( $product )
	: null;

/**
 * The pasted ground-truth markup's Quick Add link only had `tf_add_to_cart tf-btn w-100` — none of
 * WooCommerce core's own `.add_to_cart_button`/`.ajax_add_to_cart` classes or `data-product_id`
 * that `wp-content/plugins/woocommerce/assets/js/frontend/add-to-cart.js` requires to intercept the
 * click and submit via AJAX (see its `AddToCartHandler.prototype.onAddToCart`) — without them the
 * browser just follows the href like a normal link. Grid style's simple-product button
 * (btn-add-to-cart.php) already gets these for free through WC's own `woocommerce_loop_add_to_cart_args`
 * filter; rebuilt the same real class/attribute set here by hand since this panel builds its own
 * markup instead of going through that filter.
 */
$quick_add_classes = array( 'tf_add_to_cart', 'tf-btn', 'w-100' );

if ( $product->is_type( 'simple' ) ) {
	$quick_add_classes[] = 'add_to_cart_button';

	if ( $product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && ( $product->is_in_stock() || $product->backorders_allowed() ) ) {
		$quick_add_classes[] = 'ajax_add_to_cart';
	}
}

$quick_add_classes[] = 'product_type_' . $product->get_type();
?>
<span class="br-line type-vertical pseudo-elm"></span>
<div class="card-product_button">
	<div class="price h4">
		<?php esc_html_e( 'Price:', 'ovinx' ); ?>
		<span><?php echo wp_kses_post( $product->get_price_html() ); ?></span>
	</div>
	<div class="group-btn">
		<p class="quanty"><?php esc_html_e( 'Quantity:', 'ovinx' ); ?></p>
		<div class="wg-quantity">
			<button type="button" class="btn-quantity minus-btn" aria-label="<?php esc_attr_e( 'Decrease quantity', 'ovinx' ); ?>">
				<i class="icon icon-Minus"></i>
			</button>
			<input class="quantity-product" type="text" name="number" value="1">
			<button type="button" class="btn-quantity plus-btn" aria-label="<?php esc_attr_e( 'Increase quantity', 'ovinx' ); ?>">
				<i class="icon icon-Plus"></i>
			</button>
		</div>
		<a
			href="<?php echo esc_url( $product->add_to_cart_url() ); ?>"
			data-quantity="1"
			data-product_id="<?php echo esc_attr( $product->get_id() ); ?>"
			data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>"
			class="<?php echo esc_attr( implode( ' ', $quick_add_classes ) ); ?>"
		>
			<i class="icon icon-ShoppingBagOpen"></i>
			<?php echo esc_html( $button_text ); ?>
		</a>
	</div>
	<div class="tf-list">
		<?php if ( $compare_args ) : ?>
			<a
				href="<?php echo esc_url( $compare_args['url'] ); ?>"
				class="tf-btn-icon cl-text-main <?php echo esc_attr( implode( ' ', (array) $compare_args['class'] ) ); ?>"
				role="button"
				data-product_id="<?php echo esc_attr( $product->get_id() ); ?>"
				<?php if ( ! empty( $compare_args['aria-label'] ) ) : ?>aria-label="<?php echo esc_attr( $compare_args['aria-label'] ); ?>"<?php endif; ?>
			>
				<span class="wcboost-products-compare-button__icon"><?php echo empty( $compare_args['icon'] ) ? '<i class="icon icon-ArrowsLeftRight"></i>' : $compare_args['icon']; ?></span>
				<span class="fw-medium lh-24 wcboost-products-compare-button__text"><?php echo esc_html( $compare_args['label'] ); ?></span>
			</a>
		<?php endif; ?>
		<?php
		/**
		 * `#shareSocial` is a single, page-wide modal — it can't hold real per-product share links
		 * for every card in the Shop loop at once. `Woo_Hook::tfwc_shop_share_popup()`
		 * (class-woo/class-woo-hook.php) renders the shell on Shop/archive pages; `js/shop.js`'s
		 * `productShare()` fills in this product's permalink/title (from the data attributes below)
		 * right before the modal opens.
		 */
		?>
		<a
			href="#shareSocial"
			data-bs-toggle="modal"
			class="tf-btn-icon cl-text-main tf_share_btn"
			data-permalink="<?php echo esc_url( $product->get_permalink() ); ?>"
			data-title="<?php echo esc_attr( $product->get_name() ); ?>"
		>
			<i class="icon icon-ShareNetwork"></i>
			<span class="fw-medium lh-24"><?php esc_html_e( 'Share', 'ovinx' ); ?></span>
		</a>
	</div>
</div>
