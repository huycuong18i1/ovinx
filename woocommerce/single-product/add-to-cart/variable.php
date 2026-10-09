<?php
/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
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

$attribute_keys  = array_keys( $attributes );
$variations_json = wp_json_encode( $available_variations );
$variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );

if ( ! $product instanceof WC_Product ) {
    $product = wc_get_product( get_queried_object_id() );
}

$size_guide_id = 0;

if (
    themesflat_get_opt( 'tf_size_guide' ) &&
    $product instanceof WC_Product
) {
    $size_guide_id = Woo_Single_Product_Hook::instance()
        ->get_product_size_guide_id( $product );
}
do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart tf-variable-form" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo empty($variations_attr) ? json_encode([]) : $variations_attr ; // WPCS: XSS ok. ?>">
	<?php do_action( 'woocommerce_before_variations_form' ); ?>	

	<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
		<p class="stock out-of-stock"><?php echo esc_html( apply_filters( 'woocommerce_out_of_stock_message', __( 'This product is currently out of stock and unavailable.', 'ovinx' ) ) ); ?></p>
	<?php else : ?>
		<table class="variations" cellspacing="0" role="presentation">
			<tbody class="tf-product-info-variant">
				<?php foreach ( $attributes as $attribute_name => $options ) : ?>
					<tr class="variant-picker-item">
						<th class="tf-label label">
							<div class="d-flex justify-content-between variant-picker-label">
								<div class="d-flex align-items-center gap-8">
									<label for="<?php echo esc_attr( sanitize_title( $attribute_name ) ); ?>"><?php echo wc_attribute_label( $attribute_name ); // WPCS: XSS ok. ?>:</label>
									<span class="variant-picker-label-value text-uppercase fw-semibold" data-attribute="<?php echo esc_attr( sanitize_title( $attribute_name ) ); ?>"></span>
								</div>
								<?php if ( $size_guide_id && $attribute_name == 'pa_size' ) : ?>

										<?php
										Woo_Single_Product_Hook::instance()
											->size_guide_button();
										?>
								<?php endif; ?>
							</div>
						</th>
						<td class="tf-variation-items attribute-size-guide value border-0">
							<?php
								wc_dropdown_variation_attribute_options(
									array(
										'options'   => $options,
										'attribute' => $attribute_name,
										'product'   => $product,
									)
								);
								/**
								 * Filters the reset variation button.
								 *
								 * @since 2.5.0
								 *
								 * @param string  $button The reset variation button HTML.
								 */
								do_action('tf_size_guide_' . esc_attr( sanitize_title( $attribute_name ) ) );
								echo end( $attribute_keys ) === $attribute_name ? wp_kses_post( apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#" aria-label="' . esc_attr__( 'Clear options', 'ovinx' ) . '">' . esc_html__( 'Clear', 'ovinx' ) . '</a>' ) ) : '';
							?>
						</td>
					</tr>
				<?php endforeach; ?>

				<!-- <tr class="variant-picker-item">
					<th class="tf-label label m-0 p-0 border-0">
						<div class="d-flex justify-content-between variant-picker-label h6 fw-normal">
							<span><?php echo _e('Quantity', 'ovinx') ; // WPCS: XSS ok. ?></span>
						</div>
					</th>
					<td class="tf-variation-items value border-0">
						<?php
							// Woo_Single_Product_Hook::instance()->woocommerce_template_add_to_cart_quantity();
							// wc_get_template( 'single-product/extras/add-to-cart-quantity.php');
						?>
					</td>
				</tr> -->
				
			</tbody>
		</table>
		<div class="reset_variations_alert screen-reader-text" role="alert" aria-live="polite" aria-relevant="all"></div>
		<?php do_action( 'woocommerce_after_variations_table' ); ?>

		<div class="single_variation_wrap">
			<?php
				/**
				 * Hook: woocommerce_before_single_variation.
				 */
				do_action( 'woocommerce_before_single_variation' );

				/**
				 * Hook: woocommerce_single_variation. Used to output the cart button and placeholder for variation data.
				 *
				 * @since 2.4.0
				 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
				 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
				 */
				do_action( 'woocommerce_single_variation' );

				/**
				 * Hook: woocommerce_after_single_variation.
				 */
				do_action( 'woocommerce_after_single_variation' );
			?>
		</div>
	<?php endif; ?>

	<?php do_action( 'woocommerce_after_variations_form' ); ?>
</form>

<?php
do_action( 'woocommerce_after_add_to_cart_form' );
