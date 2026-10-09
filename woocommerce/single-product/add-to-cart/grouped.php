<?php
/**
 * Grouped product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/grouped.php.
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

defined( 'ABSPATH' ) || exit;

global $product, $post;

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

if ( ! function_exists( 'tf_get_contents' ) ) {
	function tf_get_contents($contents) {
		if( !empty($contents) ){
			return $contents;
			// return wp_kses_post($contents);
		}
	}
}

$placeholder = wc_placeholder_img_src();

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="cart grouped_form tf-product-total-quantity tf-grouped-form form-group-product" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
	<div class="table-wrapper">
		<table cellspacing="0" class="woocommerce-grouped-product-list group_table table-group-product">
			<tbody class="tf-product-more-option">
				<?php
				$quantites_required      = false;
				$previous_post           = $post;
				$grouped_product_columns = apply_filters(
					'woocommerce_grouped_product_columns',
					array(
						'item-product-image',
						'item-product-content',
						// 'label',
						// 'price',
						// 'quantity',
					),
					$product
				);
				$show_add_to_cart_button = false;

				do_action( 'woocommerce_grouped_product_list_before', $grouped_product_columns, $quantites_required, $product );

				foreach ( $grouped_products as $grouped_product_child ) {
					$post_object        = get_post( $grouped_product_child->get_id() );
					$quantites_required = $quantites_required || ( $grouped_product_child->is_purchasable() && ! $grouped_product_child->has_options() );
					$post               = $post_object; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
					setup_postdata( $post );

					if ( $grouped_product_child->is_in_stock() ) {
						$show_add_to_cart_button = true;
					}

					echo '<tr id="product-' . esc_attr( $grouped_product_child->get_id() ) . '" class="woocommerce-grouped-product-list-item more-option-item item-product ' . esc_attr( implode( ' ', wc_get_product_class( '', $grouped_product_child ) ) ) . '">';

					// Output columns for each product.
					foreach ( $grouped_product_columns as $column_id ) {
						do_action( 'woocommerce_grouped_product_list_before_' . $column_id, $grouped_product_child );

						switch ( $column_id ) {
							case 'quantity':
								ob_start();

								if ( ! $grouped_product_child->is_purchasable() || $grouped_product_child->has_options() || ! $grouped_product_child->is_in_stock() ) {
									set_query_var('is_grouped_loop', true);
									woocommerce_template_loop_add_to_cart();
									set_query_var('is_grouped_loop', false);
								} elseif ( $grouped_product_child->is_sold_individually() ) {
									echo '<input type="checkbox" name="' . esc_attr( 'quantity[' . $grouped_product_child->get_id() . ']' ) . '" value="1" class="wc-grouped-product-add-to-cart-checkbox" id="' . esc_attr( 'quantity-' . $grouped_product_child->get_id() ) . '" />';
									echo '<label for="' . esc_attr( 'quantity-' . $grouped_product_child->get_id() ) . '" class="screen-reader-text">' . esc_html__( 'Buy one of this item', 'ovinx' ) . '</label>';
								} else {
									do_action( 'woocommerce_before_add_to_cart_quantity' );

									woocommerce_quantity_input(
										array(
											'input_name'  => 'quantity[' . $grouped_product_child->get_id() . ']',
											'input_value' => isset( $_POST['quantity'][ $grouped_product_child->get_id() ] ) ? wc_stock_amount( wc_clean( wp_unslash( $_POST['quantity'][ $grouped_product_child->get_id() ] ) ) ) : '0', // phpcs:ignore WordPress.Security.NonceVerification.Missing
											'min_value'   => apply_filters( 'woocommerce_quantity_input_min', 0, $grouped_product_child ),
											'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $grouped_product_child->get_max_purchase_quantity(), $grouped_product_child ),
											'placeholder' => '0',
										)
									);

									do_action( 'woocommerce_after_add_to_cart_quantity' );
								}

								$value = ob_get_clean();
								break;
							case 'label':
								$value = '<label for="product-' . esc_attr( $grouped_product_child->get_id() ) . '">';
								$value .= $grouped_product_child->is_visible() ? '<a href="' . esc_url( apply_filters( 'woocommerce_grouped_product_list_link', $grouped_product_child->get_permalink(), $grouped_product_child->get_id() ) ) . '">' . $grouped_product_child->get_name() . '</a>' : $grouped_product_child->get_name();
								$value .= '</label>';
								break;
							case 'price':
								$value  = '<div class="tf-price">';
								$value .= $grouped_product_child->get_price_html() . wc_get_stock_html( $grouped_product_child );
								$value  .= '</div>';
								break;
							case 'item-product-image':
								$value  = '';
								$value .= '<div class="more_image">';
								$value .= '<img class="lazyload" width="100" height="133" src="'. esc_url($placeholder).'" data-src="' . esc_url(wp_get_attachment_url( $grouped_product_child->get_image_id())) . '" alt="img-product">';
								$value .= '</div>';
								break;
							case 'item-product-content':
								ob_start();

								if ( ! $grouped_product_child->is_purchasable() || $grouped_product_child->has_options() || ! $grouped_product_child->is_in_stock() ) {
									set_query_var('is_grouped_loop', true);
									woocommerce_template_loop_add_to_cart();
									set_query_var('is_grouped_loop', false);
								} elseif ( $grouped_product_child->is_sold_individually() ) {
									echo '<input type="checkbox" name="' . esc_attr( 'quantity[' . $grouped_product_child->get_id() . ']' ) . '" value="1" class="wc-grouped-product-add-to-cart-checkbox tf-check" id="' . esc_attr( 'quantity-' . $grouped_product_child->get_id() ) . '" />';
									echo '<label for="' . esc_attr( 'quantity-' . $grouped_product_child->get_id() ) . '" class="screen-reader-text">' . esc_html__( 'Buy one of this item', 'ovinx' ) . '</label>';
								} else {
									do_action( 'woocommerce_before_add_to_cart_quantity' );

									woocommerce_quantity_input(
										array(
											'input_name'  => 'quantity[' . $grouped_product_child->get_id() . ']',
											'input_value' => isset( $_POST['quantity'][ $grouped_product_child->get_id() ] ) ? wc_stock_amount( wc_clean( wp_unslash( $_POST['quantity'][ $grouped_product_child->get_id() ] ) ) ) : '0', // phpcs:ignore WordPress.Security.NonceVerification.Missing
											'min_value'   => apply_filters( 'woocommerce_quantity_input_min', 0, $grouped_product_child ),
											'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $grouped_product_child->get_max_purchase_quantity(), $grouped_product_child ),
											'placeholder' => '0',
										)
									);

									do_action( 'woocommerce_after_add_to_cart_quantity' );
								}

								$quantity_html= ob_get_clean();
								ob_start();
								?>
								<div class="item-product-content more_info">

									<div class="item-product-info">
										<label for="product-<?php echo esc_attr( $grouped_product_child->get_id() ); ?>">
										<?php if ( $grouped_product_child->is_visible() ) : ?>
											<a href="<?php echo esc_url(
											apply_filters(
												'woocommerce_grouped_product_list_link',
												$grouped_product_child->get_permalink(),
												$grouped_product_child->get_id()
											)
											); ?>" class="product-name info__name link">
											<?php echo esc_html( $grouped_product_child->get_name() ); ?>
											</a>
										<?php else : ?>
											<?php echo esc_html( $grouped_product_child->get_name() ); ?>
										<?php endif; ?>
										</label>

										<div class="item-product-price">
											<div class="box-price tf-price price-wrap">
												<?php echo tf_get_contents($grouped_product_child->get_price_html()); ?>

												<?php if ($grouped_product_child->is_on_sale()) : ?>
													<?php
														$regular_price = (float) $grouped_product_child->get_regular_price();
														$sale_price = (float) $grouped_product_child->get_sale_price();

														if ($regular_price > 0 && $sale_price > 0) {
															$discount_text = '-';
															$discount = round((($regular_price - $sale_price) / $regular_price) * 100);
															$discount_text .= $discount . '%';
														} else {
															$discount = 0;
															$discount_text = esc_html__('Sale!', 'ovinx');
														}
													?>
													<p class="badge-sale text-white fw-semibold text-caption-02">
														<span class="number-sale" data-person-sale="<?php echo esc_attr($discount); ?>">
															<?php echo esc_html($discount_text); ?>
														</span>
													</p>
												<?php endif; ?>

											</div>
											<div class="note <?php echo esc_attr($grouped_product_child->is_in_stock() ? 'available' : ''); ?>"><?php echo wc_get_stock_html( $grouped_product_child ); ?></div>
										</div>
									</div>

									<?php echo tf_get_contents($quantity_html); ?>

								</div>
								<?php
								$value = ob_get_clean();
								break;
							default:
								$value = '';
								break;
						}

						echo '<td class="woocommerce-grouped-product-list-item__' . esc_attr( $column_id ) . ' '.esc_attr( $column_id ).'">' . apply_filters( 'woocommerce_grouped_product_list_column_' . $column_id, $value, $grouped_product_child ) . '</td>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

						do_action( 'woocommerce_grouped_product_list_after_' . $column_id, $grouped_product_child );
					}
					echo '</tr>';
					?>
						
					<?php
				}
				$post = $previous_post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
				setup_postdata( $post );

				do_action( 'woocommerce_grouped_product_list_after', $grouped_product_columns, $quantites_required, $product );
				?>
			</tbody>
		</table>
	</div>

	<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" />

	<?php if ( $quantites_required && $show_add_to_cart_button ) : ?>

		<div class="group-btn">
			<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
			<button type="submit" class="tf-btn btn-fill-2 fw-medium animate-btn type-xl flex-grow-1 btn-add-to-cart single_add_to_cart_button button alt<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?> <?php echo esc_attr($tf_btn_classes); ?>">
				<span class="single-add-to-cart-text">
					<?php echo esc_html( $product->single_add_to_cart_text() ); ?>
				</span>
				<span class="tf-add-to-cart-loading d-none position-relative">
					<span class="spinner"></span>
				</span>
			</button>
			<?php do_action( 'woocommerce_after_add_to_cart_button', $product ); ?>
		</div>
		
		<?php do_action( 'woocommerce_end_add_to_cart_form' ); ?>
	<?php endif; ?>
</form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
