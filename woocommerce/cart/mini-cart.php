<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
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

do_action( 'woocommerce_before_mini_cart' ); 

?>

<?php if ( ! WC()->cart->is_empty() && !empty(WC()->cart)   ) : ?>

	<?php

		// add_filter('woocommerce_cart_item_thumbnail', function($thumbnail, $cart_item, $cart_item_key) {

		// 	if (
		// 		strpos($thumbnail, 'size-tf-mini-cart-thumnail') === false &&
		// 		strpos($thumbnail, 'attachment-tf-mini-cart-thumnail') === false
		// 	) {
		// 		return $thumbnail;
		// 	}
		
		// 	$attachment_id = $cart_item['data']->get_image_id();
		
		// 	if (!$attachment_id) {
		// 		return $thumbnail;
		// 	}

		// 	return wp_get_attachment_image(
		// 		$attachment_id,
		// 		'tf-mini-cart-thumnail',
		// 		false,
		// 		[
		// 			'class'   => 'lazyload',
		// 			'loading' => 'lazy',
		// 			'width'   => '100',
		// 			'height'  => '133',
		// 		]
		// 	);
		
		// }, 10, 3);

		add_filter('wp_get_attachment_image_attributes', function($attr, $attachment, $size) {

			if ($size !== 'tf-mini-cart-thumnail') {
				return $attr;
			}

			if (!empty($attr['src'])) {
				$attr['data-src'] = $attr['src'];
			}

			if (!empty($attr['srcset'])) {
				$attr['data-srcset'] = $attr['srcset'];
				unset($attr['srcset']);
			}

			$attr['src'] = wc_placeholder_img_src('woocommerce_thumbnail');
		
			// Add lazyload
			$attr['class']   = isset($attr['class']) 
				? $attr['class'] . ' lazyload' 
				: 'lazyload';
		
			// $attr['loading'] = 'lazy';
		
			$attr['width']  = '100';
			$attr['height'] = '133';
		
			return $attr;
		
		}, 10, 3);

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
						$item_data[ $key ]['display'] = '/ ' . $item_data[ $key ]['display'];
					}
					if( isset($item_data[ $key ]['value']) ){
						$item_data[ $key ]['value'] = '/ ' . $item_data[ $key ]['value'];
					}
				}
			}
			return $item_data;
		}
	}
	?>
	<div class="tf-mini-cart-wrap">
		<div class="tf-mini-cart-sroll">
			<ul class="tf-mini-cart-items list-mini-product">
				<?php
					do_action( 'woocommerce_before_mini_cart_contents' );
					if (!defined('DOING_AJAX') || !DOING_AJAX) {
						WC()->cart->calculate_totals();
					}
					foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
						$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
						$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

						if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
							$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
							$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image('tf-mini-cart-thumnail'), $cart_item, $cart_item_key );
							$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
							$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
							?>
							<li class="mini-product-cart file-delete <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>" data-cart_item_key="<?php echo esc_attr( $cart_item_key );?>">
								<div class="prd-image">
									<a href="<?php echo esc_url( $product_permalink ); ?>">
										<?php echo sprintf('%s',$thumbnail);?>
									</a>
								</div>
								<div class="prd-action">
									<a class="prd_name fw-medium cl-text-main link-underline text-line-clamp-1" href="<?php echo esc_url( $product_permalink ); ?>">
										<?php echo wp_kses_post( $product_name )?>
									</a>
									<?php do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key ); ?>
									<?php echo wc_get_formatted_cart_item_data( $cart_item ); ?>
									<?php do_action( 'woocommerce_after_cart_item_price', $cart_item, $cart_item_key ); ?>

									<div class="quantity-price fw-medium cl-text-main">
										<span><?php echo esc_html( $cart_item['quantity'] ); ?></span>
										<span>x</span>
										<span class="tf-mini-card-price"><?php echo sprintf( '%s', $product_price );?></span>
									</div>

									<?php
										if( ! (!empty($cart_item['tf_custom_bundle']) && !empty($cart_item['is_bundle_child'])) ){
											echo apply_filters(
												'woocommerce_cart_item_remove_link',
												sprintf(
													'<a href="#" class="remove_from_cart_button tf-btn-line style-min text-primary remove cs-pointer" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">
													<span class="text-caption-01 fw-semibold">
														%s
													</span>
													</a>',
													esc_attr__( 'Remove this item', 'ovinx' ),
													esc_attr( $product_id ),
													esc_attr( $cart_item_key ),
													esc_attr( $_product->get_sku() ),
													esc_attr__( 'Remove', 'ovinx' ),
												),
												$cart_item_key
											);
										}
									?>
								</div>
							</li>
							<?php
						}
					}

					do_action( 'woocommerce_mini_cart_contents' );
				?>
			</ul>
		</div>
	</div>

		<div class="tf-mini-cart-bottom">
			<div class="tf-mini-cart-tool">
				<?php if ( themesflat_get_opt( 'minicart_gift') == 1 ) {?>
				<div class="tf-mini-cart-tool-btn btn-add-gift">
					<i class="icon icon-Package"></i>
					<div class="text-xxs"><?php _e('Gift','ovinx');?></div>
				</div>
				<?php } if ( themesflat_get_opt( 'minicart_note') == 1 ) {?>
				<div class="tf-mini-cart-tool-btn btn-add-note">
					<i class="icon icon-Chats"></i>
					<div class="text-xxs"><?php _e('Note','ovinx');?></div>
				</div>
				<?php } if ( themesflat_get_opt( 'minicart_shipping') == 1 ) {?>

				<div class="tf-mini-cart-tool-btn btn-estimate-shipping">
					<i class="icon icon-Truck"></i>
					<div class="text-xxs"><?php _e('Shipping','ovinx');?></div>
				</div>

				<?php } if ( themesflat_get_opt( 'minicart_coupon') == 1 ) {?>

				<div class="tf-mini-cart-tool-btn btn-coupon">
					<i class="icon icon-SealPercent"></i>
					<div class="text-xxs"><?php _e('Coupon','ovinx');?></div>
				</div>
				<?php } ?>
			</div>

			<div class="canvas-footer">
				<?php wc_get_template( 'cart/minicart-totals.php' ); ?>

				<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

				<div class="checkbox-wrap">
                    <input id="minicart-agree-term" type="checkbox" class="tf-check style-2">
                    <label for="minicart-agree-term" class="">
						<?php _e('I agree with', 'ovinx'); ?>
                        <a href="<?php echo esc_url( themesflat_get_opt( 'minicart_term_link') ?? '#' ); ?>" class="text-decoration-underline">
                            <?php _e('Terms & Conditions', 'ovinx'); ?>
                        </a>
                    </label>
                </div>

				<div class="group-btn">
					<a href="<?php echo esc_url(wc_get_cart_url());?>" class="tf-btn style-stroke small-2 w-100">
						<span class="text-caption-01">
							<?php echo esc_html__( 'View Cart', 'ovinx' ); ?>
						</span>
					</a>
					<a href="<?php echo esc_url(wc_get_checkout_url());?>" class="tf-btn small-2 w-100 checkout-btn">
						<span class="text-caption-01">
							<?php echo esc_html__( 'Check Out', 'ovinx' ); ?>
						</span>
					</a>
				</div>

				<div class="text-center">
                    <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="d-flex justify-content-center fw-semibold text-center link mt-12">
					<?php echo _e( 'Or Continue Shopping', 'ovinx' ); ?>
                    </a>
                </div>

				<?php do_action( 'woocommerce_widget_shopping_cart_after_buttons' ); ?>
			</div>
		</div>
		
		<?php
			if ( themesflat_get_opt( 'minicart_note') == 1 ) {
				get_template_part( 'tpl/popup/minicart-note'); 
			} 
			if ( themesflat_get_opt( 'minicart_coupon') == 1 ) {
				get_template_part( 'tpl/popup/minicart-coupon');
			} 
			if ( themesflat_get_opt( 'minicart_shipping') == 1 ) {
				get_template_part( 'tpl/popup/minicart-shipping'); 
			} 
			if ( themesflat_get_opt( 'minicart_gift') == 1 ) {
				get_template_part( 'tpl/popup/minicart-gift'); 
			}
		?>

<?php else : ?>
	<div class="tf-mini-cart-wrap">
		<div class="tf-mini-cart-sroll">
			<div class="box-text_empty type-shop_cart">
				<div class="shop-empty_top">

					<span class="icon">
						<i class="icon-ShoppingBagOpen"></i>
					</span>

					<h4 class="text-emp">
						<?php _e('Your cart is empty', 'ovinx'); ?>
					</h4>

					<p class="cl-text-2">
						<?php _e('Your cart is currently empty. Let us assist you in finding the right product', 'ovinx'); ?>
					</p>

				</div>
				<div class="shop-empty_bot">

					<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ) ?>" class="tf-btn animate-btn">
						<?php _e('Shopping', 'ovinx'); ?>
					</a>

					<a href="<?php echo esc_url( site_url() ) ?>" class="tf-btn style-stroke">
						<?php _e('Back to home', 'ovinx'); ?>
					</a>

				</div>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>



