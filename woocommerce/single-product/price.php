<?php
/**
 * Single Product Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 10.3.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

?>
<div class="product-infor-price">
	<?php add_filter('woocommerce_format_sale_price', [ Woo_Single_Product_Hook::instance(), 'add_line_before_sale_price'], 10, 3); ?>
	<?php echo wp_kses_post( $product->get_price_html() ); ?>
	<?php themesflat_remove_hook('woocommerce_format_sale_price', [ Woo_Single_Product_Hook::instance(), 'add_line_before_sale_price'], 10, 3); ?>

	<?php if ($product->is_on_sale()) : ?>
		<?php
			$regular_price = (float) $product->get_regular_price();
			$sale_price = (float) $product->get_sale_price();

			if ($regular_price > 0 && $sale_price > 0) {
				$discount = round((($regular_price - $sale_price) / $regular_price) * 100);
				$discount_text = '-' . $discount . '%';
			} else {
				$discount_text = esc_html__('Sale!', 'ovinx');
			}
		?>
		<span class="badge-sale text-label fw-semibold">
			<?php echo esc_html($discount_text); ?>
		</span>
	<?php endif; ?>
</div>
