<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (!class_exists('TFWC_Cart_Checkout')) {
	class TFWC_Cart_Checkout
	{

		protected static $instance = null;
    
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function __construct() {
			if( is_admin() ) {				
				add_action('init', array($this, 'actions'), 10);
				add_filter( 'woocommerce_update_cart_action_cart_updated', array( $this, 'tf_save_extra_cart_fields') );
			} else {				
				add_action('wp', array($this, 'actions'), 10 );
				add_filter( 'woocommerce_update_cart_action_cart_updated', array( $this, 'tf_save_extra_cart_fields') );			
			}

		}
	
		public function actions(){	
			// Page Cart
			add_action( 'woocommerce_before_cart_totals', array($this, 'tfwc_start_form_total' ) );
			add_action( 'woocommerce_after_cart_totals', array($this, 'tfwc_end_form_total' ) );


			// add_action( 'woocommerce_after_cart_table', array( $this, 'tfwc_note_form' ) );
			add_action( 'woocommerce_after_cart', array( $this, 'tfwc_get_recently' ),10 );
			add_action( 'woocommerce_after_cart_empty', array( $this, 'tfwc_get_recently' ),10 );
			add_action( 'wp_loaded', array( $this, 'tfwc_clear_cart' ) );

			/**
			 * Not gated by is_checkout(): WC's "update order review" AJAX request (fired by
			 * checkout.js right after page load to recalc totals) re-renders payment.php outside
			 * the normal checkout page query, so is_checkout() is false there — this filter needs
			 * to apply on every request that can render the order button, not just the first.
			 */
			add_filter('woocommerce_order_button_text', function(){
				return __('PLACE ORDER', 'ovinx');
			});

			// Page Checkout
			if ( is_checkout() ) {

				add_filter('woocommerce_checkout_fields', array( $this,'tfwc_checkout_fields'));
				add_filter('woocommerce_form_field_args', array( $this,'tfwc_checkout_field_args'), 10, 3);

				add_filter('woocommerce_thankyou_order_received_text', function($text, $order){
					return __('Thank you for your order!', 'ovinx');
				},10, 2);

				add_action('woocommerce_after_thankyou_order_received_text', function(){
					return;
					?>
						<p class="sub-title">
							<?php _e('You are awesome, ovinx! Thank you so much for your purchase.', 'ovinx' ); ?>
						</p>

						<?php if( !is_user_logged_in() ): ?>
							<div class="wrap-login-message">
								<?php _e('Please <a href="#log" class="link" data-bs-toggle="modal">log in</a> to your account to view this order.', 'ovinx'); ?>
							</div>
						<?php endif; ?>
					<?php
				});

				add_filter('woocommerce_checkout_login_message', function($text){

					$registration_at_checkout   = WC_Checkout::instance()->is_registration_required();

					if( $registration_at_checkout ){
						return '';
					}

					ob_start();
					?>
					<div class="wrap-quick-login">
						<p class="title cl-text-2">Already have an account?
							<a href="#log" data-bs-toggle="modal" class="tf-btn-line-2 style-primary fw-semibold ">
								Login Here
							</a>
						</p>
						
					</div>
					<?php
					return ob_get_clean();
				},10,1);

				add_action('woocommerce_before_checkout_form_cart_notices', function(){
					if ( WC()->cart->is_empty() ) {
						wc_get_template( 'cart/cart-empty.php' );
					}
				},10);
			}

			add_action('woocommerce_after_order_details' , array($this, 'give_feedback') );
			
		}

		public function tfwc_get_related(){
			if(themesflat_get_opt('related_display') == 1) {
				set_query_var('show_heading', true);
				global $product;
				if( empty($product) ){
					$cart = WC()->cart->get_cart();
					if (!empty($cart)) {
						$cart_item = reset($cart);
						$product_id = $cart_item['product_id'];
						$product = wc_get_product($product_id);
					} else {
						set_query_var('show_heading', false);
						return;
					}
				}
				wc_get_template( 'tpl/product-single/related.php' );
				set_query_var('show_heading', false);
			}
		}

		public function tfwc_get_recently(){
			if(themesflat_get_opt('recently_display') == 1) {

				set_query_var('show_heading', true);
				?>
				<section class="flat-spacing flat-animate-tab cart-rsection pb-0">
					<?php wc_get_template( 'tpl/product-single/recently.php' );?>
				</section>

				<?php
				set_query_var('show_heading', false);
			}
		}


		public function tfwc_get_wl_recently(){
			if(themesflat_get_opt('recently_wl_display') == 1) {

				set_query_var('show_heading', true);
				?>
				<section class="flat-spacing flat-animate-tab cart-rsection">
					<?php wc_get_template( 'wishlist/wishlist-recently.php' );?>
				</section>

				<?php
				set_query_var('show_heading', false);
			}
		}

		public function tfwc_enqueue_woo_scripts()
		{	
			
		}

		public function tf_save_extra_cart_fields($cart_updated){
			if ( ! isset( $_POST['woocommerce-cart-nonce'] ) || ! wp_verify_nonce( $_POST['woocommerce-cart-nonce'], 'woocommerce-cart' ) || empty( $_POST['update_cart'] ) ) {
				return $cart_updated;
			}
		
			if ( isset( $_POST['order_comments'] ) ) {
				WC()->session->set( 'tfwc_order_note', sanitize_text_field( $_POST['order_comments'] ) );
			}

			if ( isset( $_POST['add_gift'] ) ) {
				WC()->session->set('tfwc_gift', true);
			} else {
				WC()->session->__unset('tfwc_gift'); 
			}

			return $cart_updated;
		}

		/**
		 * Ground truth's cart page (`view-cart.html`) has a "CLEAR ALL" button next to the coupon
		 * form (`.clear-file-delete`) that empties the whole cart in one click — a real feature the
		 * theme didn't have yet, not just a style gap. Reuses the same `woocommerce-cart-nonce`
		 * already printed in `woocommerce/cart/cart.php`'s form, same as `tf_save_extra_cart_fields()`
		 * above. Runs on `wp_loaded` (same hook WooCommerce's own cart form handlers use) so it can
		 * redirect before any output is sent.
		 */
		public function tfwc_clear_cart(){
			if ( empty( $_POST['tf_clear_cart'] ) || ! isset( $_POST['woocommerce-cart-nonce'] ) || ! wp_verify_nonce( $_POST['woocommerce-cart-nonce'], 'woocommerce-cart' ) ) {
				return;
			}

			WC()->cart->empty_cart();

			wp_safe_redirect( wc_get_cart_url() );
			exit;
		}

		public function give_feedback(){
			if ( themesflat_get_opt('order_give_feedback') == 1  && !empty(themesflat_get_opt('order_give_feedback_content')) ): ?>
				<div class="cart-box">
					<?php echo do_shortcode(themesflat_get_opt('order_give_feedback_content')); ?>
				</div>
			<?php endif; ?>

			<?php
		}

		public function tfwc_note_form() {
			$tfwc_order_note = WC()->session->get('tfwc_order_note', '');
			?>
			<div class="cart-note">
				<label for="note" class="text-md fw-medium"><?php echo esc_html__( 'Special instructions for seller', 'ovinx' )?></label>
				<textarea id="note" name="order_comments" class="input-text" rows="4" cols="5"><?php echo esc_html($tfwc_order_note); ?></textarea>
			</div>
			<?php
		}

		public function tfwc_start_form_total() { ?>
			<div class="cart-box checkout-cart-box">
		<?php
		}
		public function tfwc_end_form_total() { ?>
			</div>
		<?php
		}

		public function tfwc_checkout_fields($fields) {

			// BILLING

			$fields['billing']['billing_first_name']['label']       = __( 'First Name', 'ovinx' );
			$fields['billing']['billing_first_name']['placeholder'] = __( 'First Name', 'ovinx' );
			$fields['billing']['billing_first_name']['class']       = array( 'tf-field' );

			$fields['billing']['billing_last_name']['label']       = __( 'Last Name', 'ovinx' );
			$fields['billing']['billing_last_name']['placeholder'] = __( 'Last Name', 'ovinx' );
			$fields['billing']['billing_last_name']['class']       = array( 'tf-field' );

			// billing_company only exists when the store enables it (WooCommerce → Settings →
			// Checkout field visibility) — this site has it hidden, so guard against
			// auto-vivifying a phantom label-less field via a bare ['class'] assignment.
			if ( isset( $fields['billing']['billing_company'] ) ) {
				$fields['billing']['billing_company']['class'] = array( 'tf-field', 'wd-full' );
			}
			$fields['billing']['billing_country']['class']     = array( 'tf-field', 'tf-select', 'wd-full' );

			$fields['billing']['billing_address_1']['label']       = __( 'Street address', 'ovinx' );
			$fields['billing']['billing_address_1']['placeholder'] = __( 'House number and street name', 'ovinx' );
			$fields['billing']['billing_address_1']['class']       = array( 'tf-field', 'wd-full' );

			$fields['billing']['billing_address_2']['placeholder'] = __( 'Apartment, suite, unit, etc. (optional)', 'ovinx' );
			$fields['billing']['billing_address_2']['class']       = array( 'tf-field', 'wd-full' );

			$fields['billing']['billing_city']['label']       = __( 'Town / City', 'ovinx' );
			$fields['billing']['billing_city']['placeholder'] = __( 'Town / City', 'ovinx' );
			$fields['billing']['billing_city']['class']       = array( 'tf-field' );

			$fields['billing']['billing_state']['class'] = array( 'tf-field', 'tf-select', 'wd-full' );

			$fields['billing']['billing_postcode']['label']       = __( 'ZIP', 'ovinx' );
			$fields['billing']['billing_postcode']['placeholder'] = __( 'ZIP', 'ovinx' );
			$fields['billing']['billing_postcode']['class']       = array( 'tf-field' );

			$fields['billing']['billing_phone']['label']       = __( 'Phone Number', 'ovinx' );
			$fields['billing']['billing_phone']['placeholder'] = __( 'Phone Number', 'ovinx' );
			$fields['billing']['billing_phone']['class']       = array( 'tf-field' );

			$fields['billing']['billing_email']['label']       = __( 'Email Address', 'ovinx' );
			$fields['billing']['billing_email']['placeholder'] = __( 'Email Address', 'ovinx' );
			$fields['billing']['billing_email']['class']       = array( 'tf-field' );

			// SHIPPING

			$fields['shipping']['shipping_first_name']['label']       = __( 'First Name', 'ovinx' );
			$fields['shipping']['shipping_first_name']['placeholder'] = __( 'First Name', 'ovinx' );
			$fields['shipping']['shipping_first_name']['class']       = array( 'tf-field' );

			$fields['shipping']['shipping_last_name']['label']       = __( 'Last Name', 'ovinx' );
			$fields['shipping']['shipping_last_name']['placeholder'] = __( 'Last Name', 'ovinx' );
			$fields['shipping']['shipping_last_name']['class']       = array( 'tf-field' );

			if ( isset( $fields['shipping']['shipping_company'] ) ) {
				$fields['shipping']['shipping_company']['class'] = array( 'tf-field', 'wd-full' );
			}
			$fields['shipping']['shipping_country']['class']    = array( 'tf-field', 'tf-select', 'wd-full' );

			$fields['shipping']['shipping_address_1']['label']       = __( 'Street address', 'ovinx' );
			$fields['shipping']['shipping_address_1']['placeholder'] = __( 'House number and street name', 'ovinx' );
			$fields['shipping']['shipping_address_1']['class']       = array( 'tf-field', 'wd-full' );

			$fields['shipping']['shipping_address_2']['placeholder'] = __( 'Apartment, suite, unit, etc. (optional)', 'ovinx' );
			$fields['shipping']['shipping_address_2']['class']       = array( 'tf-field', 'wd-full' );

			$fields['shipping']['shipping_city']['label']       = __( 'Town / City', 'ovinx' );
			$fields['shipping']['shipping_city']['placeholder'] = __( 'Town / City', 'ovinx' );
			$fields['shipping']['shipping_city']['class']       = array( 'tf-field' );

			$fields['shipping']['shipping_state']['class'] = array( 'tf-field', 'tf-select', 'wd-full' );

			$fields['shipping']['shipping_postcode']['label']       = __( 'ZIP', 'ovinx' );
			$fields['shipping']['shipping_postcode']['placeholder'] = __( 'ZIP', 'ovinx' );
			$fields['shipping']['shipping_postcode']['class']       = array( 'tf-field' );

			// ORDER (order notes)

			$fields['order']['order_comments']['label']       = __( 'Order notes', 'ovinx' );
			$fields['order']['order_comments']['placeholder'] = __( 'Write note...', 'ovinx' );
			$fields['order']['order_comments']['class']       = array( 'tf-field', 'wd-full' );

			return $fields;
		}

		/**
		 * Ground truth's checkout fields (`.tf-field > label.cl-text-main + input`) style the label
		 * directly on the element, unlike WC's default `label_class` (empty) — applied via
		 * `woocommerce_form_field_args` (same pattern as `myaccount/form-edit-address.php`'s
		 * `ovinx_address_field_args()`) instead of hardcoding it into every field array above.
		 */
		public function tfwc_checkout_field_args( $args, $key, $value ) {
			$args['label_class'][] = 'cl-text-main';
			return $args;
		}

	}		
}