<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
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

do_action( 'woocommerce_before_cart' );
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );

if ( is_cart() && isset($_GET[themesflat_get_opt('tf_buy_now_query_arg')]) && function_exists('WC') ) {
    WC()->cart->calculate_totals();
    WC()->session->save_data();
    WC()->cart->maybe_set_cart_cookies();
}

?>

<?php
	if( !function_exists('tf_remove_key_item_data') ){
		function tf_remove_key_item_data( $item_data, $cart_item ) {
			
			if ( is_array( $item_data ) ) {
				$i = 0;
				foreach ( $item_data as $key => $data ) {
					$i++;
					if( $i == 1 ){
						continue;
					}
					if( isset($item_data[ $key ]['display']) ){
						$item_data[ $key ]['display'] = $item_data[ $key ]['display'];
					}

					if( isset($item_data[ $key ]['value']) ){
						$item_data[ $key ]['value'] = $item_data[ $key ]['value'] . '\n';
					}
				}
			}

			return $item_data;
		}
	}
?>

<?php set_query_var('mini_cart_quantity', true); ?>
<div class="s-shop-cart section-shoping-cart each-list-prd">
	<div class="container container-hd">
		<div class="row row-hd row-cart">
			<div class="tf-cart-left col-lg-8">

				<?php if ( isset( WC()->session ) && WC()->session->has_session() ): ?>
					<?php

						$session_array = (array) WC()->session;

						$expiration = $session_array["\0*\0_session_expiration"];
						$expiring   = $session_array["\0*\0_session_expiring"];

						$expiration_time = $expiration - time();
						
					?>

					<?php if( $expiration_time > 0 && $expiration_time < 7200000 ) : ?>
						<div class="tf-cart-sold">
							<div class="notification-sold">
								<div class="count-text text-caption-01 cl-text-main">
								<?php
									printf(
										/* translators: %s: countdown timer html */
										esc_html__( '🔥 Your cart will expire in %s minutes! Please checkout now before your items sell out!', 'ovinx' ),
										'<span class="js-countdown time-count cd-has-zero cd-no" data-timer="' . esc_attr($expiration_time) . '" data-labels=":,:,:,"></span>'
									);
								?>
								</div>
							</div>
						</div>
					<?php endif; ?>
				<?php endif; ?>

				<div class="tf-page-cart-main">
					<form class="woocommerce-cart-form form-cart form-shop-cart" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
						<div class="woocommerce-cart-form__contents">

							<?php do_action( 'woocommerce_before_cart_table' ); ?>

							<table class="table-shop-cart table-order-detail tf-table-page-cart" cellspacing="0">
								<thead>
									<tr>
										<th class="order_product product-name h6 fw-medium"><?php esc_html_e( 'Products', 'ovinx' ); ?></th>
										<th class="order_price h6 fw-medium"><?php esc_html_e( 'Price', 'ovinx' ); ?></th>
										<th class="order_quantity h6 fw-medium text-center"><?php esc_html_e( 'Quantity', 'ovinx' ); ?></th>
										<th class="order_subtotal h6 fw-medium text-end"><?php esc_html_e( 'Total Price', 'ovinx' ); ?></th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<?php do_action( 'woocommerce_before_cart_contents' ); ?>

									<?php
									foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
										$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
										$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

										if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
											$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
											?>
											<tr class="each-prd file-delete tf-cart_item order_item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

												<td class="product-thumbnail tf-cart-item_product cart_product">
													<?php
													$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image('tf-cart'), $cart_item, $cart_item_key );

													?>
													
													<!-- <div class="order_product"> -->
														<a href="<?php echo esc_url($product_permalink); ?>" class="image img-prd">
															<?php echo wp_kses_post($thumbnail); ?>
														</a>
														<div class="infor-prd">

															<a href="<?php echo esc_url($product_permalink); ?>" class="prd_name fw-medium link lh-24">
																<?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' ); ?>
																<?php
																	do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );
																?>
															</a>

															<p>
																<?php
																	do_action( 'tf_after_cart_item_name', $cart_item, $cart_item_key );
																?>
															</p>

															<p class="prd-type">
																<?php

																	// add_filter( 'woocommerce_get_item_data', 'tf_remove_key_item_data', 10, 2 );

																	set_query_var('is_cart_page', true );
																
																	// Meta data.
																	echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

																	set_query_var('is_cart_page', false );

																	// themesflat_remove_hook( 'woocommerce_get_item_data', 'tf_remove_key_item_data', 10, 2 );
																?>
															</p>

															<?php
																// Backorder notification.
																if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
																	echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'ovinx' ) . '</p>', $product_id ) );
																}
															?>

														</div>
													<!-- </div> -->
												</td>

												<td class="order_price each-price cart_price" data-cart-title="<?php esc_attr_e( 'Price', 'ovinx' ); ?>">
													<div class="price-wrap tf-price">
														<?php echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok. ?>
													</div>
												</td>

												<td class="order_quantity product-quantity tf-cart-item_quantity cart_quantity" data-cart-title="<?php esc_attr_e( 'Quantity', 'ovinx' ); ?>">
													<div class="text-center">

													<?php
													if( !empty($cart_item['tf_custom_bundle']) ){
														?>
															<div class="cart-item-quantity">
																<div class="quantity-bundle-product">
																	<?php echo esc_html__('Qty: ', 'ovinx') . $cart_item['quantity']; ?>
																</div>
															</div>
														<?php
													}else{
														if ( $_product->is_sold_individually() ) {
															$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
														} else {
															// set_query_var('mini_cart_quantity', false );
															// set_query_var('quantity_style', 'style-1' );
															set_query_var('mini_cart_product_id_loop', $_product->get_id());
															$product_quantity = woocommerce_quantity_input(
																array(
																	'input_name'   => "cart[{$cart_item_key}][qty]",
																	'input_value'  => $cart_item['quantity'],
																	'max_value'    => $_product->get_max_purchase_quantity(),
																	'min_value'    => '0',
																	'product_name' => $_product->get_name(),
																),
																$_product,
																false
															);
															set_query_var('mini_cart_product_id_loop', false);
														}
														echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
													}
													?>

													</div>
												</td>

												<td class="product-subtotal tf-cart-item_total order_subtotal each-subtotal-price" data-cart-title="<?php esc_attr_e( 'Total Price', 'ovinx' ); ?>">
													<div class="cart_total">
														<span class="number-quantity"><?php echo esc_html( $cart_item['quantity'] ); ?></span>
														x
														<span class="price">
															<?php
																echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
															?>
														</span>
													</div>
												</td>

												<td class="product-remove cart_remove">
													<?php
														if( ! (!empty($cart_item['tf_custom_bundle']) && !empty($cart_item['is_bundle_child'])) ){
															echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
																'woocommerce_cart_item_remove_link',
																sprintf(
																	'<a href="%s" class="remove icon" aria-label="%s" data-product_id="%s" data-product_sku="%s"><i class="icon-Close"></i></a>',
																	esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
																	esc_attr( sprintf( __( 'Remove %s from cart', 'ovinx' ), $_product->get_name() ) ),
																	esc_attr( $product_id ),
																	esc_attr( $_product->get_sku() )
																),
																$cart_item_key
															);
														}
													?>
												</td>
											</tr>
											<?php
										}
									}
									?>

									<?php do_action( 'woocommerce_cart_contents' ); ?>

									<!-- <tr>
										<td colspan="6" class="extra-fields">
										</td>
									</tr> -->

									<!-- <tr>
										<td colspan="6" class="actions ">
										</td>
									</tr> -->

									<?php do_action( 'woocommerce_after_cart_contents' ); ?>
								</tbody>
							</table>
							<?php do_action( 'woocommerce_after_cart_table' ); ?>

							<div class="extra-fields mb-20">
								<?php
									$tfwc_order_note = WC()->session->get('tfwc_order_note', '');
									$gift_applied = WC()->session->get('tfwc_gift') ? true : false;
									$currency   = get_woocommerce_currency_symbol();
									$gift_fee = themesflat_get_opt('gift_fee');
								?>
								<div class="checkbox-wrap">
									<input name="add_gift" id="add-gift" type="checkbox" class="tf-check tf-add-gift" <?php echo esc_attr($gift_applied ? 'checked' : ''); ?> >
									<label for="add-gift" class="cl-text-main"><?php _e('Add gift packaging', 'ovinx'); ?> (<?php echo esc_html($currency) . (float) $gift_fee ; ?>)</label>
								</div>
								<fieldset class="tf-field mt-20">
									<label class="label-text cl-text-main">
										<?php _e('Special instructions for seller', 'ovinx'); ?>
									</label>
									<textarea name="order_comments" class="order-comments"><?php echo esc_html($tfwc_order_note); ?></textarea>
								</fieldset>
							</div>

							<div class="wrap-coupon d-flex justify-content-between align-items-center flex-wrap gap-20">
								<?php if ( wc_coupons_enabled() ) { ?>
									<div class="coupon ip-discount-code">

										<input type="text" name="coupon_code" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Add voucher discount', 'ovinx' ); ?>" />
										<button type="submit" class="action tf-btn style-2 animate-btn bg-cl-text" name="apply_coupon" value="<?php esc_attr_e( 'Apply', 'ovinx' ); ?>">
											<?php esc_html_e( 'Apply Code', 'ovinx' ); ?>
										</button>

										<?php do_action( 'woocommerce_cart_coupon' ); ?>
									</div>
								<?php } ?>

								<div class="d-flex align-items-center gap-12 group-btn-cart">
									<button type="submit" class="button tf-btn radius-6 btn-out-line-dark-2 tf-update-cart-btn" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'ovinx' ); ?>"><?php esc_html_e( 'Update cart', 'ovinx' ); ?></button>
									<button type="submit" class="tf-btn style-stroke px-v1 clear-file-delete" name="tf_clear_cart" value="1"><?php esc_html_e( 'Clear All', 'ovinx' ); ?></button>
								</div>
							</div>


							<?php do_action( 'woocommerce_cart_actions' ); ?>

							<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>

						</div>
					</form>
				</div>
			</div>
			<div class="tf-cart-right col-lg-4">
				<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

				<div class="right fl-sidebar-cart mt-lg-0 sticky-top">
					<div class="checkout-sidebar box-order-summary ">
						<?php if ( function_exists( 'is_cart' ) && is_cart() ) : ?>

							<?php
								if (themesflat_get_opt('free_shipping_bar') == 1) {
									$amount   = 0;
									$requires = '';
									$discount = false;
									$cart     = WC()->cart;
								
									if ($cart && !$cart->is_empty()) {
										$packages = $cart->get_shipping_packages();
										$package  = reset($packages);
										$zone     = wc_get_shipping_zone($package);
								
										$free_shipping_method = null;
										foreach ($zone->get_shipping_methods(true) as $method) {
											if ('free_shipping' === $method->id) {
												$free_shipping_method = $method;
												break;
											}
										}
								
										if ($free_shipping_method) {
											$instance = $free_shipping_method->instance_settings;
											$amount   = isset($instance['min_amount']) ? $instance['min_amount'] : 0;
											$requires = isset($instance['requires']) ? $instance['requires'] : '';
											$discount = isset($instance['ignore_discounts']) && 'yes' === $instance['ignore_discounts'];
										}
								
										$cart_total   = $cart->get_displayed_subtotal();
										$currency     = get_woocommerce_currency_symbol();
										$remaining    = $amount - $cart_total;
										$percent      = ($amount > 0) ? min(100, 100 - ($remaining / $amount) * 100) : 0; 
								
										$progress_cart_text = themesflat_get_opt('progress_cart_text');
										$success_cart_text  = themesflat_get_opt('success_cart_text');
								
										$progress_text = str_replace(
											['{currency}', '{total}'],
											[$currency, $remaining],
											$progress_cart_text
										);
								
										$shipping_bar = '';
										if ($amount > 0) {
											// ob_start();

											?>
												<div class="box-delivery notification-progress">
													<span class="text">
														<?php echo wp_kses_post( ($cart_total < $amount) ? $progress_text : $success_cart_text); ?>
													</span>
													<div class="progress-cart tf-progress-bar tf-progress-ship">
														<div class="value" style="width:0%;" data-progress="<?php echo esc_attr($percent); ?>">
															<span class="round"></span>
														</div>
													</div>
												</div>
											<?php
										}
									}
								}
							?>
						<?php endif; ?>
						<?php
							/**
							 * Cart collaterals hook.
							 *
							 * @hooked woocommerce_cross_sell_display
							 * @hooked woocommerce_cart_totals - 10
							 */
							do_action( 'woocommerce_cart_collaterals' );
						?>
					</div>
					<?php do_action( 'tf_after_cart_collaterals' ); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php set_query_var('mini_cart_quantity', false); ?>
<?php do_action( 'woocommerce_after_cart' ); ?>
