<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (!class_exists('Woo_Product_Setting')) {
	class Woo_Product_Setting
	{
		public function __construct() {
			if( is_admin() ) {				
				add_action('init', array($this, 'actions'), 10);
			}
		}
	
		public function actions(){
			if ( ! function_exists( 'is_woocommerce' ) ) {
				return;
			}

			add_filter( 'woocommerce_product_data_tabs', array($this, 'tfwc_badges') );
			add_action( 'woocommerce_product_data_panels', array( $this, 'tfwc_badges_control' ) );
			add_filter('woocommerce_process_product_meta', array( $this, 'tfwc_badges_save' ));

			add_filter( 'woocommerce_product_data_tabs', array($this, 'tfwc_product_card_attributes') );
			add_action( 'woocommerce_product_data_panels', array( $this, 'tfwc_product_card_attributes_control' ) );
			add_filter('woocommerce_admin_process_product_object', array( $this, 'tfwc_product_card_attributes_save' ));

			
			add_filter( 'woocommerce_product_data_tabs', array($this, 'tfwc_product_sale_marquee') );
			add_action( 'woocommerce_product_data_panels', array( $this, 'tfwc_product_sale_marquee_control' ) );
			add_filter('woocommerce_admin_process_product_object', array( $this, 'tfwc_product_sale_marquee_save' ));
		}

		public function tfwc_badges( $tabs ) {
			$tabs['tfwc_badges'] = [
				'label'    => esc_html__( 'Badges', 'ovinx' ),
				'target'   => 'tfwc_badges_control',
				'class'    => [ 'product-badges-tab' ],
				'priority' => 61,
			];
	
			return $tabs;
		}

		public function tfwc_badges_control() {
			?>
			<div id="tfwc_badges_control" class="panel woocommerce_options_panel hidden">
				<div class="options_group">
				<?php
					woocommerce_wp_checkbox( array(
						'id'          => 'tfwc_badges_new',
						'label'       => esc_html__( 'Is New product ?', 'ovinx' ),
						'description' => esc_html__( 'Check to set the product as new.', 'ovinx' ),
					) );
				?>
				</div>
				<div class="options_group">
					<?php
					woocommerce_wp_text_input(array(
						'id'          => 'tfwc_badges_new_time',
						'label'       => esc_html__('New Badge Expiry Date', 'ovinx'),
						'placeholder' => __('YYYY-MM-DD', 'ovinx'),
						'type'        => 'date',
						'description' => __('Select the date when the "New" label should be removed.', 'ovinx'),
					));
					?>
				</div>
				<div class="options_group">
					<?php
						$post_custom = get_post_custom( get_the_ID());
						woocommerce_wp_text_input(
							array(
								'id'       => 'tfwc_badges_custom',
								'label'    => esc_html__( 'Custom Badge', 'ovinx' ),
								'placeholder' => __('Enter text for custom badges.', 'ovinx'),
							)
						);	
						
					?>
				</div>
				<div class="options_group">
					<?php
					woocommerce_wp_text_input(array(
						'id'          => 'tfwc_badges_color',
						'label'       => esc_html__('Custom Badge Color', 'ovinx'),
						'type'        => 'text',
						'class'       => 'short-input',
						'description' => __('Choose the text color for the custom badge.', 'ovinx'),
					));
					?>
				</div>
				<div class="options_group">
					<?php
					woocommerce_wp_text_input(array(
						'id'          => 'tfwc_badges_bg',
						'label'       => esc_html__('Custom Badge Background Color', 'ovinx'),
						'type'        => 'text',
						'class'       => 'short-input',
						'description' => __('Choose the background color for the custom badge.', 'ovinx'),
					));
					?>
				</div>
			</div>
			<?php
		}
		
		public function tfwc_badges_save($post_id) {
			$is_new = isset($_POST['tfwc_badges_new']) ? 'yes' : 'no';
			update_post_meta($post_id, 'tfwc_badges_new', $is_new);

			
			if (!empty($_POST['tfwc_badges_new_time'])) {
				$expiry_date = sanitize_text_field($_POST['tfwc_badges_new_time']);
				update_post_meta($post_id, 'tfwc_badges_new_time', $expiry_date);
			} else {
				delete_post_meta($post_id, 'tfwc_badges_new_time');
			}

			if (isset($_POST['tfwc_badges_custom'])) {
				update_post_meta($post_id, 'tfwc_badges_custom', sanitize_text_field($_POST['tfwc_badges_custom']));
			}


			if (!empty($_POST['tfwc_badges_color']) && $_POST['tfwc_badges_color'] !== '#000000') {
				update_post_meta($post_id, 'tfwc_badges_color', sanitize_hex_color($_POST['tfwc_badges_color']));
			} else {
				delete_post_meta($post_id, 'tfwc_badges_color'); 
			}
		
			if (!empty($_POST['tfwc_badges_bg']) && $_POST['tfwc_badges_bg'] !== '#000000') {
				update_post_meta($post_id, 'tfwc_badges_bg', sanitize_hex_color($_POST['tfwc_badges_bg']));
			} else {
				delete_post_meta($post_id, 'tfwc_badges_bg'); 
			}
		}

		public function tfwc_product_card_attributes( $tabs ){
			$tabs['tfwc_product_card_attributes'] = [
				'label'    => esc_html__( 'Product Card Attributes', 'ovinx' ),
				'target'   => 'tfwc_product_card_attributes_control',
				'class'    => [ 'show_if_variable' ],	
				'priority' => 62,
			];
			return $tabs;
		}

		public function tfwc_product_card_attributes_control(){
			global $product_object;
			$attributes = $product_object->get_attributes();

			$attribute_options = [
				'' => 'Default',
				'none' => 'None',
			];
		
			foreach ($attributes as $attribute) {
				if ($attribute->is_taxonomy()) {
					$slug = $attribute->get_name();
					$label = wc_attribute_label($slug);

					$attribute_options[str_replace('pa_', '', $slug)] = ucfirst($label);
				}
			}

			?>
				<div id="tfwc_product_card_attributes_control" class="panel woocommerce_options_panel" style="<?php echo esc_attr('display:none;'); ?>">
					<div class="options_group">
						<p class="form-field show_if_variable">
							<?php
								woocommerce_wp_select( array(
									'id'          => '_tfwc_product_card_attribute',
									'value'       => $product_object->get_meta('_tfwc_product_card_attribute'),
									'options'        => $attribute_options,
									'label'       => __('Primary Attribute', 'ovinx'),
								));

								woocommerce_wp_text_input( array(
								    'id'          => '_tfwc_product_card_attribute_max_number',
								    'value'       => $product_object->get_meta('_tfwc_product_card_attribute_max_number'),
								    'type'        => 'number',
								    'data_type'   => 'decimal',
								    'label'       => __('Attribute Max Number', 'ovinx'),
								    'custom_attributes' => [
								        'min' => 1
								    ]
								));

								woocommerce_wp_select( array(
									'id'          => '_tfwc_product_card_second_attribute',
									'value'       => $product_object->get_meta('_tfwc_product_card_second_attribute'),
									'options'        => $attribute_options,
									'label'       => __('Second Attribute', 'ovinx'),
								));

								woocommerce_wp_text_input( array(
								    'id'          => '_tfwc_product_card_second_attribute_max_number',
								    'value'       => $product_object->get_meta('_tfwc_product_card_second_attribute_max_number'),
								    'type'        => 'number',
								    'data_type'   => 'decimal',
								    'label'       => __('Second Attribute Max Number', 'ovinx'),
								    'custom_attributes' => [
								        'min' => 1
								    ]
								));
							?>
						</p>
					</div>
				</div>
			<?php
		}

		public function tfwc_product_card_attributes_save($product) {
			$tfwc_product_card_attribute = isset( $_POST['_tfwc_product_card_attribute'] ) ? sanitize_text_field($_POST['_tfwc_product_card_attribute']) : '';
			$tfwc_product_card_attribute_max_number = isset( $_POST['_tfwc_product_card_attribute_max_number'] ) ? sanitize_text_field($_POST['_tfwc_product_card_attribute_max_number']) : '';
			$tfwc_product_card_second_attribute = isset( $_POST['_tfwc_product_card_second_attribute'] ) ? sanitize_text_field($_POST['_tfwc_product_card_second_attribute']) : '';
			$tfwc_product_card_second_attribute_max_number = isset( $_POST['_tfwc_product_card_second_attribute_max_number'] ) ? sanitize_text_field($_POST['_tfwc_product_card_second_attribute_max_number']) : '';

			$product->update_meta_data( '_tfwc_product_card_attribute', $tfwc_product_card_attribute );
			$product->update_meta_data( '_tfwc_product_card_attribute_max_number', $tfwc_product_card_attribute_max_number );
			$product->update_meta_data( '_tfwc_product_card_second_attribute', $tfwc_product_card_second_attribute );
			$product->update_meta_data( '_tfwc_product_card_second_attribute_max_number', $tfwc_product_card_second_attribute_max_number );
		}

		public function tfwc_product_sale_marquee( $tabs ) {
			$tabs['tfwc_badges'] = [
				'label'    => esc_html__( 'Sale marquee', 'ovinx' ),
				'target'   => 'tfwc_product_sale_marquee_control',
				'class'    => [ 'product-sale-marquee-tab' ],
				'priority' => 65,
			];
	
			return $tabs;
		}

		public function tfwc_product_sale_marquee_control() {
			global $product_object;
			?>
			<div id="tfwc_product_sale_marquee_control" class="panel woocommerce_options_panel hidden">
				<div class="options_group">
					<?php
						woocommerce_wp_textarea_input(
							array(
								'id'       => '_tfwc_sale_marquee_text',
								'label'    => esc_html__( 'Sale text', 'ovinx' ),
								'value'       => $product_object->get_meta('_tfwc_sale_marquee_text'),
								'type' => 'text',
								'placeholder' => __('Enter text for sale marquee(include html)', 'ovinx'),
							)
						);
					?>
				</div>
				<div class="options_group">
					<?php
					woocommerce_wp_text_input(array(
						'id'          => '_tfwc_sale_marquee_color',
						'label'       => esc_html__('Color', 'ovinx'),
						'type'        => 'color',
						'class'       => 'short-input',
						'value'       => $product_object->get_meta('_tfwc_sale_marquee_color') ?: '#FFFFFF',
						'description' => __('Choose the text color for sale text', 'ovinx'),
					));
					?>
				</div>
				<div class="options_group">
					<?php
					woocommerce_wp_text_input(array(
						'id'          => '_tfwc_sale_marquee_bg',
						'label'       => esc_html__('Background Color', 'ovinx'),
						'type'        => 'color',
						'class'       => 'short-input',
						'value'       => $product_object->get_meta('_tfwc_sale_marquee_bg') ?: '#000000',
						'description' => __('Choose the background color for the sale background.', 'ovinx'),
					));
					?>
				</div>
			</div>
			<?php
		}
		
		public function tfwc_product_sale_marquee_save($product) {

			if (isset($_POST['_tfwc_sale_marquee_text'])) {
				// $product->update_meta_data( '_tfwc_sale_marquee_text', ($_POST['_tfwc_sale_marquee_text']) );
				$value = wp_unslash($_POST['_tfwc_sale_marquee_text']);
				$product->update_meta_data('_tfwc_sale_marquee_text', $value);
			}

			if (isset($_POST['_tfwc_sale_marquee_color'])) {
				$product->update_meta_data( '_tfwc_sale_marquee_color', sanitize_text_field($_POST['_tfwc_sale_marquee_color']) );
			}

			if (isset($_POST['_tfwc_sale_marquee_bg'])) {
				$product->update_meta_data( '_tfwc_sale_marquee_bg', sanitize_text_field($_POST['_tfwc_sale_marquee_bg']) );
			}
		}
		
	}
}