<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (!class_exists('Woo_Hook')) {
	class Woo_Hook
	{
		public function __construct() {
			if( is_admin() ) {				
				add_action('init', array($this, 'actions'), 10);
			} else {				
				add_action('wp', array($this, 'actions'), 10 );				
			}

		}
		public function actions(){			
	
			
			add_action( 'wp_enqueue_scripts', array( $this, 'tfwc_enqueue_woo_scripts' ), 20 );

			// Disable WooCommerce styles
			add_filter( 'woocommerce_enqueue_styles', '__return_false' );

			// Remove breadcrumb (we're using the WooFramework default breadcrumb)
			remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);

			// Removes the "shop" title on the main shop page
			add_filter( 'woocommerce_show_page_title', '__return_false' );

			// Add metafield Large Description
			add_action('product_cat_edit_form_fields', array( $this, 'tfwc_edit_large_description_category'), 10, 2);
			add_action('product_cat_add_form_fields', array( $this, 'tfwc_add_large_description_category'), 10, 2);
			add_action('edited_product_cat', array( $this,'tfwc_save_large_description_category'), 10, 2);
			add_action('create_product_cat', array( $this,'tfwc_save_large_description_category'), 10, 2);

			// Addd metafield BG Color Category
			add_action('product_cat_edit_form_fields', [ $this, 'add_bg_color_field_cat' ]);
			add_action('product_cat_add_form_fields', [ $this, 'add_bg_color_field_cat' ]);

			add_action('create_product_cat', [ $this, 'save_bg_color_field_cat' ]);
			add_action('edited_product_cat', [ $this, 'save_bg_color_field_cat' ]);

			// Ajax search product
			add_action('wp_ajax_tfwc_search_products', array( $this,'tfwc_search_products'));
			add_action('wp_ajax_nopriv_tfwc_search_products', array( $this,'tfwc_search_products'));

			add_action('wp_ajax_tfwc_search_products_header', array( $this,'tfwc_search_products_header'));
			add_action('wp_ajax_nopriv_tfwc_search_products_header', array( $this,'tfwc_search_products_header'));

			// Free Shipping bar
			add_filter('woocommerce_add_to_cart_fragments', array( $this,'update_free_shipping_bar_fragments'));

			// Minicart bottom popup

			add_filter( 'woocommerce_checkout_get_value', array( $this,'tfwc_checkout_order_notes'), 10, 2 );

			add_action('woocommerce_checkout_update_order_meta', array( $this,'tfwc_save_order_note_to_order'));
			add_action('wp_ajax_save_order_note', array( $this,'tfwc_save_order_note_to_session'));
			add_action('wp_ajax_nopriv_save_order_note', array( $this,'tfwc_save_order_note_to_session'));

			add_action('wp_ajax_apply_coupon', array( $this,'tfwc_apply_coupon'));
			add_action('wp_ajax_nopriv_apply_coupon', array( $this,'tfwc_apply_coupon'));

			add_action( 'wp_ajax_nopriv_tfwc_remove_coupon',  array( $this,'tfwc_remove_coupon' ));
			add_action( 'wp_ajax_tfwc_remove_coupon',  array( $this,'tfwc_remove_coupon' ));

			add_action('wp_ajax_tfwc_save_shipping', array( $this, 'tfwc_save_shipping'));
			add_action('wp_ajax_nopriv_tfwc_save_shipping',array( $this, 'tfwc_save_shipping'));

			add_action('wp_ajax_tfwc_apply_gift', array( $this,'tfwc_apply_gift'));
			add_action('wp_ajax_nopriv_tfwc_apply_gift', array( $this,'tfwc_apply_gift'));
	
			add_action('woocommerce_cart_calculate_fees', array( $this,'tfwc_apply_gift_fee'));
			add_action('wp_ajax_tfwc_remove_gift', array( $this,'tfwc_remove_gift'));
			add_action('wp_ajax_nopriv_tfwc_remove_gift', array( $this,'tfwc_remove_gift'));

			add_action('wp_ajax_remove_cart_item', array( $this,'tfwc_remove_cart_item'));
			add_action('wp_ajax_nopriv_remove_cart_item', array( $this,'tfwc_remove_cart_item'));

			add_action( 'wp_ajax_tfwc_clear_cart', array($this, 'tfwc_clear_cart' ));
			add_action( 'wp_ajax_nopriv_tfwc_clear_cart', array( $this, 'tfwc_clear_cart'));

			add_action('wp_footer', array( $this,'tf_footer_shop'));

			// Live Notifications
			wc_get_template('tpl/live-notification/live-notification.php' );

			// Archive Shop
			remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
			remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 ); 
			remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
			remove_action('woocommerce_shop_loop_item_title','woocommerce_template_loop_product_title' );
			remove_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_price' );
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
			remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

			// Compare
			if( class_exists('\WCBoost\ProductsCompare\Frontend') ) {
				$compare = \WCBoost\ProductsCompare\Frontend::instance();
				remove_action( 'woocommerce_after_add_to_cart_form', array( $compare, 'single_add_to_compare_button' ) );
				remove_action( 'woocommerce_after_shop_loop_item', array( $compare, 'loop_add_to_compare_button' ), 15 );
				tfwc_get_template_part( '/product-base/compare.php' );
			}

			if( class_exists('\WCBoost\Wishlist\Frontend') ) {			
				tfwc_get_template_part( '/product-base/wishlish.php' );
			}
		
			tfwc_get_template_part( '/product-base/add-to-cart.php' );

			tfwc_get_template_part( '/product-base/quickview.php' );

			tfwc_get_template_part( '/product-base/unavailable.php' );

			/**
			 * List-style card's `.tf-list` Share button (product-base/card-button.php) links to
			 * `#shareSocial`, but that modal is normally only rendered on single product pages
			 * (Woo_Single_Product_Hook::share_popup(), hooked to `woocommerce_before_single_product`)
			 * — on the Shop archive the element doesn't exist at all. Register the shell here for
			 * Shop/archive contexts instead of touching that single-product-specific method.
			 */
			if ( is_shop() || is_product_taxonomy() ) {
				add_action( 'wp_footer', array( $this, 'tfwc_shop_share_popup' ) );
			}

			tfwc_get_template_part( '/product-base/helpers.php' );		

			$product_style = isset($_GET['product_style']) ? sanitize_text_field($_GET['product_style']) : themesflat_get_opt('product_style');

			// $number_view_active = isset($_GET['number_view_active']) ? sanitize_text_field($_GET['number_view_active']) : themesflat_get_opt('number_view_active');

			// if( $number_view_active == 1){
				
			// }
			
			if (isset($_POST['product_style'])) {
				$product_style = sanitize_text_field($_POST['product_style']);
			}

			// if ( function_exists( 'wcboost_wishlist' ) ) {
			// 	$wishlist_page_id = get_option( 'wcboost_wishlist_page_id' );
			// 	if(is_page( $wishlist_page_id )) {
			// 		$product_style = 'style-wishlist';
			// 	} 
			// }
			
			switch ($product_style) {
				case 'style-list':
					tfwc_get_template_part( '/product-style/style-list.php' );
					break;
				case 'style-1': 
					tfwc_get_template_part( '/product-style/style-1.php' );
					break;
				case 'style-2':	
					tfwc_get_template_part( '/product-style/style-2.php' );
					break;
				case 'style-3':	
					tfwc_get_template_part( '/product-style/style-3.php' );
					break;
				case 'style-4':	
					tfwc_get_template_part( '/product-style/style-4.php' );
					break;
				case 'style-wishlist':	
					tfwc_get_template_part( '/product-style/style-wishlist.php' );
					break;
				default :
					tfwc_get_template_part( '/product-style/style-1.php' );
					break;
			}


			// Ajax filter 
			add_action('wp_ajax_filter_products', array( $this, 'tfwc_handle_ajax_filter_products' ));
			add_action('wp_ajax_nopriv_filter_products',array( $this, 'tfwc_handle_ajax_filter_products' ) );

			add_action( 'woocommerce_product_query', function( $q ) {

				if ( is_admin() || ! $q->is_search() ) return;
				if ( $q->get( 'post_type' ) !== 'product' ) return;

				static $hooked = false;
				if ( $hooked ) return;
				$hooked = true;

				add_filter( 'the_posts', function( $posts, $query ) {

					if ( ! $query->is_main_query() || empty( $posts ) ) {
						return $posts;
					}

					$keyword = trim( get_search_query() );
					if ( ! $keyword ) {
						return $posts;
					}

					$ip   = $this->tf_get_client_ip();
					$hash = 'wc_kw_' . md5( (string) $keyword . $ip );

					if ( get_transient( $hash ) ) {
						return $posts;
					}

					set_transient( $hash, 1, MINUTE_IN_SECONDS );

					$data = get_option( 'tf_search_keywords', [] );
					$data[ $keyword ] = ( $data[ $keyword ] ?? 0 ) + 1;

					arsort( $data );
					$data = array_slice( $data, 0, 50, true );

					update_option( 'tf_search_keywords', $data );

					return $posts;

				}, 10, 2 );
			});

			add_action('wp', [ $this, 'tf_track_product_views_from_search'] , 20);

			add_filter( 'wc_session_expiring', [$this, 'custom_guest_session_expiring'], 99);
			add_filter( 'wc_session_expiration', [$this, 'custom_guest_session_expiration'], 99 );
			
		}

		public function custom_guest_session_expiring( $seconds ) {

			$guest_cart_hours_enable = themesflat_get_opt('tf_guest_cart_hours_enable');
			$guest_cart_hours = themesflat_get_opt('tf_guest_cart_hours');

			// if ( is_user_logged_in() || empty( $guest_cart_hours_enable )) {
			// 	return $seconds;
			// }

			if ( empty( $guest_cart_hours_enable )) {
				return $seconds;
			}
		
			// Validate
			$hours = absint( $guest_cart_hours ?? 168 );
		
			// Fallback 168h = 7day
			if ( $hours <= 0 ) {
				$hours = 168;
			}
		
			return $hours * HOUR_IN_SECONDS;
		}

		public function custom_guest_session_expiration( $seconds ) {

			$guest_cart_hours_enable = themesflat_get_opt('tf_guest_cart_hours_enable');
			$guest_cart_hours = themesflat_get_opt('tf_guest_cart_hours');

			// if ( is_user_logged_in() || empty( $guest_cart_hours_enable )) {
			// 	return $seconds;
			// }

			if ( empty( $guest_cart_hours_enable )) {
				return $seconds;
			}
		
			$hours = absint( $guest_cart_hours ?? 168 );
		
			// Validate
			$hours = absint( $hours );
		
			// Fallback
			if ( $hours <= 0 ) {
				$hours = 168;
			}

			return ( $hours * HOUR_IN_SECONDS ) + HOUR_IN_SECONDS;
		}

		public function tf_track_product_views_from_search() {

			if ( ! is_product() ) return;
			if ( empty( $_GET['from'] ) || $_GET['from'] !== 'search' ) return;

			$product = wc_get_product( get_queried_object_id() );
			if ( ! $product ) return;

			$ip = $this->tf_get_client_ip();

			$transient_key = 'tf_searched_product_' . $product->get_id() . '_' . md5( $ip );

			if ( get_transient( $transient_key ) ) return;

			$views = (int) $product->get_meta( 'tf_searched_product', true );
			$product->update_meta_data( 'tf_searched_product', $views + 1 );
			$product->save();

			set_transient( $transient_key, 1, 2 * HOUR_IN_SECONDS );
		}
		public function tfwc_enqueue_woo_scripts()
		{	
			if ( ! wp_script_is( 'themesflat-countdown', 'enqueued' ) ) {
				wp_enqueue_script('themesflat-countdown', THEMESFLAT_LINK . 'js/3rd/count-down.js', array('jquery'), null, true);
			}
			// wp_enqueue_script('themesflat-countdown');
			wp_enqueue_script('themesflat-shop', THEMESFLAT_LINK . 'js/shop.js', array('jquery' , 'themesflat-toast', 'themesflat-countdown', 'nouislider'), ovinx_asset_ver( 'js/shop.js' ), true);
			$filter_sidebar_button = '';

			if( themesflat_get_opt('filter_sidebar_button') || !empty($_GET['filter_sidebar_button']) ){
				$filter_sidebar_button = true;
			}

			$can_use_store_api = false;

			// if (class_exists('WP_REST_Server')) {
			// 	$server = rest_get_server();
			
			// 	$namespaces = $server->get_namespaces();
				
			// 	if ( in_array( 'wc/store/v1', $namespaces ) ) {
			// 		$can_use_store_api = true;
			// 	}
			// }
			
			$currency_settings = array(
                'currency_symbol'      => html_entity_decode(get_woocommerce_currency_symbol(), ENT_QUOTES, 'UTF-8'),
                'currency_position'    => get_option('woocommerce_currency_pos'), // left, right, left_space, right_space
                'thousand_separator'   => wc_get_price_thousand_separator(),
                'decimal_separator'    => wc_get_price_decimal_separator(),
                'decimal_count'        => wc_get_price_decimals(),
            );

$trans_text = [
    'added_to_cart'             => __( 'Added to cart', 'ovinx' ),
    'view_cart'                 => __( 'View Cart', 'ovinx' ),
    'checkout'                  => __( 'Checkout', 'ovinx' ),
    'select_options'            => __( 'Select options', 'ovinx' ),
    'out_of_stock'              => __( 'Out of stock', 'ovinx' ),
    'in_stock'                  => __( 'In stock', 'ovinx' ),
    'success'                   => __( 'Success', 'ovinx' ),
    'copy_success'              => __( 'Link copied to clipboard!', 'ovinx' ),
    'term_required'             => __( 'Please agree to the Terms and Conditions before continuing', 'ovinx' ),

    // Compare and wishlist.
    'compare_empty'             => __( 'No products added in the compare table.', 'ovinx' ),
    'add_to_wishlist'           => __( 'Add to wishlist', 'ovinx' ),
    'remove_from_wishlist'      => __( 'Remove from wishlist', 'ovinx' ),
    'view_wishlist'             => __( 'View wishlist', 'ovinx' ),

    // Quick View, Quick Add and variation text.
    'quick_view_error'          => __( 'Error loading Quick View.', 'ovinx' ),
    'choose_option'             => __( 'Choose an option', 'ovinx' ),
    'select_product_options'    => __( 'Please select some product options before buying this product.', 'ovinx' ),
    'discount_off'              => __( '%s%% Off', 'ovinx' ),

    // Product filters and result count.
    'brand'                     => __( 'Brand', 'ovinx' ),
    'availability'              => __( 'Availability', 'ovinx' ),
    'category'                  => __( 'Category', 'ovinx' ),
    'price'                     => __( 'Price', 'ovinx' ),
    'rating'                    => __( 'Rating', 'ovinx' ),
    'stars_and_up'              => __( '%s stars & up', 'ovinx' ),
    'product_found'             => __( '%s Product found', 'ovinx' ),
    'products_found'            => __( '%s Products found', 'ovinx' ),

    // AJAX search.
    'no_results_found_for'      => __( 'No results found for "%s".', 'ovinx' ),
    'search_hint'               => __( 'Check the spelling or use a different word or phrase.', 'ovinx' ),
    'related_products'          => __( 'Related products', 'ovinx' ),
    'no_product_found'          => __( 'No product found', 'ovinx' ),
    'error'                     => __( 'Error!', 'ovinx' ),

    // Mini-cart tools.
    'save_success'              => __( 'Saved successfully!', 'ovinx' ),
    'enter_note'                => __( 'Please enter a note.', 'ovinx' ),
    'generic_error'             => __( 'An error occurred. Please try again.', 'ovinx' ),
    'enter_coupon'              => __( 'Please enter a coupon code.', 'ovinx' ),
    'shipping_updated'          => __( 'Shipping information has been updated successfully.', 'ovinx' ),
    'shipping_update_error'     => __( 'There was an error updating the shipping information.', 'ovinx' ),
    'shipping_processing_error' => __( 'An error occurred while processing the shipping information.', 'ovinx' ),
    'remove'                    => __( 'Remove', 'ovinx' ),
    'add_gift_wrap'             => __( 'Add a Gift Wrap', 'ovinx' ),
    'gift_saved'                => __( 'Gift wrap saved successfully! Please view the cart or checkout to confirm.', 'ovinx' ),
    'gift_removed'              => __( 'Gift wrap removed successfully! Please view the cart or checkout to confirm.', 'ovinx' ),
];

			wp_localize_script('themesflat-shop', 'tfwc_woo_params', array(
				'ajax_url' => admin_url('admin-ajax.php'),
				'nonce' => wp_create_nonce('tfwc_nonce'),
				'live_timeout' => themesflat_get_opt('live_timeout'),
				'live_interval' => themesflat_get_opt('live_interval'),
				'live_notification' => themesflat_get_opt('live_notification'),
				'cart_url' => wc_get_cart_url(),
                'checkout_url' => wc_get_checkout_url(),
				'buy_now' => themesflat_get_opt('tf_buy_now') && !empty(themesflat_get_opt('tf_buy_now_query_arg')) ? themesflat_get_opt('tf_buy_now_query_arg') : '',
				'currency_settings' => $currency_settings,
				'filter_sidebar_button' => $filter_sidebar_button,
				'has_store_api' => $can_use_store_api,
				'trans_text' => $trans_text,
				// 'store_update_item_endpoint'      => esc_url_raw(rest_url('wc/store/v1/cart/update-item?_locale=site'))
			));
		}
	
		public function tfwc_handle_ajax_filter_products() {
			check_ajax_referer('tfwc_nonce', 'nonce');

			$shop_loadmore_text = themesflat_get_opt('shop_loadmore_text');
			if (isset($_POST['pagination_type']) && !empty($_POST['pagination_type'])) {
				$shop_pagination = sanitize_text_field($_POST['pagination_type']);
			} else {
				$shop_pagination = themesflat_get_opt('shop_pagination');
			}

			$availability = isset($_POST['availability']) ? $_POST['availability'] : [];
			$brand = isset($_POST['brand']) ? $_POST['brand'] : [];
			$category = isset($_POST['categories']) ? $_POST['categories'] : [];
		
			$price_min = isset($_POST['min_price']) && is_numeric($_POST['min_price']) ? intval($_POST['min_price']) : 0;
			$price_max = isset($_POST['max_price']) && is_numeric($_POST['max_price']) ? intval($_POST['max_price']) : 1000000;

			$rating = isset($_POST['rating']) ? intval($_POST['rating']) : '';

			$price = isset($_POST['price']) ? intval($_POST['price']) : 0;
			$operator = isset($_POST['operator']) ? ($_POST['operator']) : '';

			$posts_per_page = themesflat_get_opt('shop_products_per_page');

			if( $_POST['products_per_page'] ){
				$posts_per_page = intval($_POST['products_per_page']);
			}

			if ( !$posts_per_page || $posts_per_page <= 0 ) {
				$posts_per_page = 8;
			}

			$page = isset($_POST['page']) ? $_POST['page'] : 1; 

			$search_query = isset($_POST['s']) ? $_POST['s'] : '';

			$operator_allowed = ['=', '>', '<', '>=', '<='];

			$args = [
				'post_type'      => 'product',
				'posts_per_page' => $posts_per_page,
				'paged' => $page,
				'post_status' => 'publish',
				's' => $search_query,
				// 'meta_query'     => ['relation' => 'AND'],
				// 'tax_query'      => ['relation' => 'AND']
			];


			$sort_by = isset($_POST['sortValue']) ? sanitize_text_field($_POST['sortValue']) : '';

			switch ($sort_by) {
				case 'best-selling':
					$args['meta_key'] = 'total_sales';
					$args['orderby'] = 'meta_value_num';
					$args['order'] = 'DESC';
					break;
				case 'a-z':
					$args['orderby'] = 'title';
					$args['order'] = 'ASC';
					break;
				case 'z-a':
					$args['orderby'] = 'title';
					$args['order'] = 'DESC';
					break;
				case 'price-low-high':
					$args['orderby'] = 'meta_value_num';
					$args['meta_key'] = '_price';
					$args['order'] = 'ASC';
					break;
				case 'price-high-low':
					$args['orderby'] = 'meta_value_num';
					$args['meta_key'] = '_price';
					$args['order'] = 'DESC';
					break;
				default:
					$args['orderby'] = 'title'; 
					$args['order'] = 'ASC';
					break;
			}

			$args['tax_query'][] = [
				'taxonomy' => 'product_visibility',
				'field'    => 'slug',
				'terms'    => 'exclude-from-catalog',
				'operator' => 'NOT IN',
			];

			if (!empty($_POST['attributes']) && is_array($_POST['attributes'])) {
				foreach ($_POST['attributes'] as $attr_name => $values) {
					if (!empty($values)) {
						$args['tax_query'][] = array(
							'taxonomy' => $attr_name,  
							'field'    => 'id',  
							'terms'    => array_map('sanitize_title', $values), 
							'operator' => 'IN',  
						);
					}
				}
			}

			if ( $price_min > 0 || $price_max < 1000000 ) {

				$args['meta_query'][] = [
					'relation' => 'AND',
					[
						'key'     => '_price',
						'value'   => array((float)$price_min, (float)$price_max),
						'type'    => 'NUMERIC',
						'compare' => 'BETWEEN'
					]
				];
				
				// $args['tax_query'][] = [
				// 	'taxonomy' => 'product_type',
				// 	'field'    => 'slug',
				// 	'terms'    => ['grouped'],
				// 	'operator' => 'NOT IN',
				// ];
			}

			// if( $price >= 0 && in_array($operator, $operator_allowed) ) {
			// 	$args['meta_query'][] = [
			// 		'relation' => 'AND',
			// 		[
			// 			'key'     => '_price',
			// 			'value'   => (float)$price,
			// 			'type'    => 'NUMERIC',
			// 			'compare' => $operator
			// 		]
			// 	];
			// }

			if ( !empty($rating) && $rating > 0 ) {
				$args['meta_query'][] = [
					'key'     => '_wc_average_rating',
					'value'   => $rating,
					'type'    => 'NUMERIC',
					'compare' => '>='
				];
			}	
			
			// Taxonomy

			if (!empty($category)) {
				$args['tax_query'][] = [
					'taxonomy' => 'product_cat',
					'field'    => 'slug',
					'terms'    => $category,
					'operator' => 'IN',
				];
			}
				
			if (!empty($brand)) {
				$args['tax_query'][] = [
					'taxonomy' => 'product_brand', 
					'field'    => 'slug',
					'terms'    => $brand,
					'operator' => 'IN'
				];
			}
		
			if (!empty($availability)) {
		
				if (in_array('On Sale', $availability)) {
					$product_ids_on_sale = wc_get_product_ids_on_sale();
					if (!empty($product_ids_on_sale)) {
						$args['post__in'] = $product_ids_on_sale;
					}
					
				}
			
				if (in_array('featured', $availability)) {

					$args['tax_query'][] = [
						// 'relation' => 'OR',
						[
							'taxonomy' => 'product_visibility',
							'field'    => 'name',
							'terms'    => 'featured',
							'operator' => 'IN',
						]
					];
					
				}
				if (in_array('In Stock', $availability)) {
					$availability_query[] = [
						'key'     => '_stock_status',
						'value'   => 'instock'
					];
				}
				if (in_array('Out Stock', $availability)) {
					$availability_query[] = [
						'relation' => 'OR',  
						[
							'key'   => '_stock_status',
							'value' => 'outofstock',
							'compare' => '='
						],
						[
							'key'     => '_stock_quantity',
							'value'   => 0,
							'compare' => '='
						]
					];
				}
		
				$args['meta_query'][] = $availability_query;
			}
		
			$query = new WP_Query($args);

			$product_count = $query->found_posts;

			if ($query->have_posts()) {
				$products = [];
				$count = 0;
				while ($query->have_posts()) {
					$count++;
					$query->the_post();
					ob_start();
					wc_get_template_part( 'content', 'product' );
					$products[] = ob_get_clean();
				}

				wp_reset_postdata();

				$next_page = (($page < $query->max_num_pages) ? true : false ) || ( $shop_pagination == 'number' && $query->max_num_pages != 1);

				$end = $query->post_count + ($posts_per_page * max($page - 1, 0) );

				$width_line = 0;

				if ( $query->found_posts > 0 ) {
					$width_line = ( $end / ($query->found_posts) ) * 100;
				}

				$showing_text = sprintf(
					_n(
						'Showing %1$d of %2$d product',
						'Showing %1$d of %2$d products',
						$query->found_posts,
						'ovinx'
					),
					$end,
					$query->found_posts
				);

				if ($shop_pagination == 'number') {
					$pagination = '';

					$pagi_align = empty( ($_GET['shop_pagination_align']) ) ? themesflat_get_opt('shop_pagination_align') : sanitize_text_field($_GET['shop_pagination_align']);

					$pagi_align_classes = 'align-items-center';
					
					if ( $pagi_align == 'left' ) {
						$pagi_align_classes = 'align-items-start';
					} elseif ( $pagi_align == 'right' ) {
						$pagi_align_classes = 'align-items-end';
					}

					ob_start();

					/**
					 * This is the AJAX-pagination twin of woocommerce/loop/pagination.php's 'number'
					 * branch (rendered a second, independent time here — same pattern documented in
					 * CLAUDE.md for the wishlist/cart header badges) — must get the same `.tf-pagination`
					 * / `.pag-item(.active)` classes + `icon-CaretLeft`/`icon-CaretRight` icon fix, or the
					 * AJAX-loaded pages fall back to unstyled default `page-numbers` markup.
					 */
					$tfwc_ajax_pagination_links = paginate_links( apply_filters( 'woocommerce_pagination_args', array(
						'base' => esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) ),
						'format'       => '',
						'add_args'     => false,
						'current'      => max( 1, $page ),
						'total'        => $query->max_num_pages,
						'prev_text'    => '<i class="icon icon-CaretLeft"></i>',
						'next_text'    => '<i class="icon icon-CaretRight"></i>',
						'end_size'     => 1,
						'mid_size'     => 1,
						'type'         => 'array',
					) ) );

					if ( ! empty( $tfwc_ajax_pagination_links ) ) {
						$tfwc_ajax_pagination_links = array_map( function ( $link ) {
							$link = str_replace( 'page-numbers current', 'page-numbers current pag-item active', $link );
							$link = str_replace( 'class="page-numbers"', 'class="page-numbers pag-item"', $link );
							return $link;
						}, $tfwc_ajax_pagination_links );
					}
					?>

					<!-- <div class="ovinx-pagi-wrapper d-flex flex-column justify-content-center gap-1 <?php echo esc_attr($pagi_align_classes); ?>"> -->
						<div class="wg-pagination tf-pagination">
							<?php if ( ! empty( $tfwc_ajax_pagination_links ) ) : ?>
								<?php foreach ( $tfwc_ajax_pagination_links as $tfwc_ajax_pagination_link ) : ?>
									<?php echo wp_kses( $tfwc_ajax_pagination_link, ovinx_template_html_allowed_tags() ); ?>
								<?php endforeach; ?>
							<?php endif; ?>
						</div>
					<!-- </div> -->
					<?php
					$pagination .= ob_get_clean();
				} else if ($shop_pagination == 'loadmore') {
					$pagination = '';

					// Same option as loop/pagination.php - a hard-coded string here dropped the custom text after every AJAX filter/sort.
					$shop_loadmore_text = themesflat_get_opt('shop_loadmore_text');

					if ($page < $query->max_num_pages) {
						$pagination .= '
						<span class="showing-total-info" style="--pagi-info-line-width:' . esc_attr($width_line). '%;">
							' . esc_html($showing_text)  
							.'<span class="pagi-info-line"> </span>
						</span>
						<button id="load-more-btn" class="tf-btn btn-outline-dark2 tf-loading-2 loadmore" data-page="' . ($page + 1) . '">
							<span class="text">' . esc_html($shop_loadmore_text) . '</span>
							<div class="spinner-circle">
								<span class="spinner-circle1 spinner-child"></span>
								<span class="spinner-circle2 spinner-child"></span>
								<span class="spinner-circle3 spinner-child"></span>
								<span class="spinner-circle4 spinner-child"></span>
								<span class="spinner-circle5 spinner-child"></span>
								<span class="spinner-circle6 spinner-child"></span>
								<span class="spinner-circle7 spinner-child"></span>
								<span class="spinner-circle8 spinner-child"></span>
								<span class="spinner-circle9 spinner-child"></span>
							</div>
						</button>';
					}else{
						$pagination .= '
						<span class="showing-total-info" style="--pagi-info-line-width:' . esc_attr($width_line). '%;">
							' . esc_html($showing_text)  
							.'<span class="pagi-info-line"> </span>
						</span>';
					}
				} else if ($shop_pagination == 'autoload') {
					$pagination = '';
					if ($next_page) {
						$pagination = '
						<span class="showing-total-info" style="--pagi-info-line-width:' . esc_attr($width_line). '%;">
							' . esc_html($showing_text)  
							.'<span class="pagi-info-line"></span>
						</span>
						<button id="autoload-btn" class="tf-btn btn-dark2 tf-loading animate-btn animate-dark" data-page="' . ($page + 1) . '">
							<div class="spinner-circle">
								<span class="spinner-circle1 spinner-child"></span>
								<span class="spinner-circle2 spinner-child"></span>
								<span class="spinner-circle3 spinner-child"></span>
								<span class="spinner-circle4 spinner-child"></span>
								<span class="spinner-circle5 spinner-child"></span>
								<span class="spinner-circle6 spinner-child"></span>
								<span class="spinner-circle7 spinner-child"></span>
								<span class="spinner-circle8 spinner-child"></span>
								<span class="spinner-circle9 spinner-child"></span>
							</div>
						</button>';
					}else{
						$pagination .= '
						<span class="showing-total-info" style="--pagi-info-line-width:' . esc_attr($width_line). '%;">
							' . esc_html($showing_text)  
							.'<span class="pagi-info-line"> </span>
						</span>';	
					}
				}
				
				wp_send_json_success([
					'products'     => $products,
					'product_count' => $product_count,
					'pagination' => $pagination,
					'next_page' => $next_page,
				]);
			} else {
				wp_reset_postdata();
				wp_send_json_success([
    'products' => '<p class="tf-no-results">' 
        . esc_html__( 'No products were found matching your selection.', 'ovinx' ) .
        ' <a href="' . esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ) . '" class="tf-shop-link">'
        . esc_html__( 'Go To Shop', 'ovinx' ) .
        '</a></p>',
					'product_count' => 0,
					'next_page' => false
				]);
			}
			wp_die();
		}
	
		public function tfwc_edit_large_description_category($term) {
			$large_description = get_term_meta($term->term_id, '_large_description', true);
			?>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="large_description"><?php _e('Large Description', 'ovinx'); ?></label>
				</th>
				<td>
					<?php
					wp_editor( $large_description, 'large_description', array(
						'textarea_name' => 'large_description',
						'textarea_rows' => 10,
						'editor_class' => 'large-description-editor'
					));
					?>
					<p class="description"><?php _e('Enter a detailed description for this category using the WYSIWYG editor.', 'ovinx'); ?></p>
				</td>
			</tr>
			<?php
		}
		
		public function tfwc_add_large_description_category($taxonomy) {
			?>
				<div class="form-field">
					<label for="large_description"><?php _e('Large Description', 'ovinx'); ?></label>
					<?php
					wp_editor( '', 'large_description', array(
						'textarea_name' => 'large_description',
						'textarea_rows' => 10,
						'editor_class' => 'large-description-editor'
					));
					?>
					<p class="description"><?php _e('Enter a detailed description for this category using the WYSIWYG editor.', 'ovinx'); ?></p>
				</div>
			<?php
		}

		public function tfwc_save_large_description_category($term_id) {
			if (isset($_POST['large_description'])) {
				update_term_meta($term_id, '_large_description', wp_kses_post($_POST['large_description']));
			}
		}

		public function add_bg_color_field_cat($term) {
			$bg_color = '';
			if ( $term instanceof WP_Term && ! empty( $term->term_id ) ) {
				$bg_color = get_term_meta( $term->term_id, 'bg_color', true );
				// $bg_color = get_term_meta($term->term_id, 'bg_color', true);
			}
			
			if (empty($bg_color)) {
				$bg_color = '#ffffff00'; // Default color
			}
			?>
			<tr class="form-field">
				<th scope="row"><label for="bg_color"><?php esc_html_e( 'Background Color', 'ovinx' ); ?></label></th>
				<td>
					<input type="color" name="bg_color" id="bg_color" value="<?php echo esc_attr($bg_color); ?>" />
					<p class="description"><?php esc_html_e(
	'Select background color for this category.',
	'ovinx'
); ?></p>
				</td>
			</tr>
			<?php
		}

		public function save_bg_color_field_cat($term_id) {
			if (isset($_POST['bg_color'])) {
				update_term_meta($term_id, 'bg_color', sanitize_text_field($_POST['bg_color']));
			}
		}

		public function tf_track_search_keyword( $keyword ) {

			$keyword = trim( wp_strip_all_tags( $keyword ) );
			if ( ! $keyword ) return;

			$ip   = $this->tf_get_client_ip();
			$hash = 'wc_kw_' . md5( (string) $keyword . $ip );

			if ( get_transient( $hash ) ) return;

			set_transient( $hash, 1, MINUTE_IN_SECONDS );

			$data = get_option( 'tf_search_keywords', [] );
			$data[ $keyword ] = ( $data[ $keyword ] ?? 0 ) + 1;

			arsort( $data );
			$data = array_slice( $data, 0, 20, true );

			update_option( 'tf_search_keywords', $data );
		}

		protected function tf_get_client_ip() {
			$ip = filter_input( INPUT_SERVER, 'REMOTE_ADDR', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
			return $ip ?: '0.0.0.0';
		}
		
		public function tfwc_search_products() {
			check_ajax_referer('tfwc_nonce', 'nonce');
			// QA P1-04: the live-search request does not always send `cat` (or `query`); avoid "Undefined array key" warnings.
			$query = isset( $_POST['query'] ) ? sanitize_text_field( wp_unslash( $_POST['query'] ) ) : '';
			$cat   = isset( $_POST['cat'] ) ? sanitize_text_field( wp_unslash( $_POST['cat'] ) ) : '';

			$query = trim( $query );

			$cat = empty( $cat ) ? [] : array_map('trim', explode(',', $cat));

			$search_product_limit = themesflat_get_opt('search_product_limit');

			$args = array(
				'post_type'      => 'product',
				'posts_per_page' => $search_product_limit,
				's'              => $query
			);

			if (!empty($cat)) {
				$args['tax_query'][] = [
					'taxonomy' => 'product_cat',
					'field'    => 'slug',
					'terms'    => $cat,
				];
			}			
		
			$args['tax_query'][] = [
				'taxonomy' => 'product_visibility',
				'field'    => 'slug',
				'terms'    => 'exclude-from-catalog',
				'operator' => 'NOT IN',
			];

			$results = [];
			$results_product = '';
			$results_categories = '';
			$results_suggestions = '';
			$results_view_all = '';
			$total_found = 0;
			$show_view_all = false;
		
			$search_query = new WP_Query($args);

			$total_found = $search_query->found_posts;
		
			if ($search_query->have_posts()) {
				$results_product = '';
				set_query_var('searched_key', $query);
				
				while ($search_query->have_posts()) {
					$search_query->the_post();

					$product =  wc_get_product( get_the_ID() );

					if ( ! $product || ! is_a( $product, 'WC_Product' ) || $product->get_catalog_visibility() !== 'visible' ) {
						continue;
					}

					ob_start();
					global $product;
					echo '<div class="swiper-slide">';
					wc_get_template_part('content', 'product');
					echo '</div>';
					$results_product .= ob_get_clean();
				}

				$this->tf_track_search_keyword( $query );
				set_query_var('searched_key', false);
				wp_reset_postdata();
				
			} else {
				// wp_send_json_success('<p class="tf-no-results">No products found.</p>');
			}

			// $product_cats = get_terms([
			// 	'taxonomy'   => 'product_cat',
			// 	'hide_empty' => true,
			// 	'name__like' => $query,
			// ]);
		
			// if (!empty($product_cats) && !is_wp_error($product_cats)) {
			// 	foreach ($product_cats as $cat) {
			// 		$cat_link = get_term_link($cat);

			// 		$highlighted_name = preg_replace(
			// 			'/((' . preg_quote($query, '/') . '))/i',
			// 			'<span class="tfwc-highlight">$1</span>',
			// 			$cat->name
			// 		);
					
			// 		$results_categories .= '<div class="tfwc-category-item">
			// 			<a href="' . esc_url($cat_link) . '">' . $highlighted_name . '</a>
			// 		</div>';
			// 	}
			// }

			global $wpdb;

			if ($total_found > $search_product_limit) {
				$show_view_all = true;
			}

			if ($show_view_all) {
				// $shop_page_url = get_permalink(wc_get_page_id('shop'));
				// $search_url = add_query_arg('s', urlencode($query), $shop_page_url);
				
				$search_url = add_query_arg(
					array(
						's'         => urlencode($query),
						'post_type' => 'product',
						'product_cat' => urlencode( sanitize_text_field($_POST['cat']) ),
					),
					home_url('/')
				);
			
				$results_view_all = sprintf(
					'<a href="%s">%s</a>',
					esc_url($search_url),
					esc_html(sprintf(
						_n('View all %d product', 'View all %d products', $total_found, 'ovinx'),
						$total_found
					))
				);
			}

			$results['products'] = $results_product;
			// $results['categories'] = $results_categories;
			// $results['suggestions'] = $results_suggestions;
			$results['total'] = $total_found;
			$results['show_view_all'] = $show_view_all;
			$results['view_all_html'] = $results_view_all;

			wp_send_json_success($results);
		
			wp_die();
		}
		
		public function tfwc_search_products_header() {
			check_ajax_referer('tfwc_nonce', 'nonce');
			$query = sanitize_text_field($_POST['query']);
			$category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
		
			$args = array(
				'post_type'      => 'product',
				'posts_per_page' => -1,
				's'              => $query
			);
		
			$args['tax_query'][] = [
				'taxonomy' => 'product_visibility',
				'field'    => 'slug',
				'terms'    => 'exclude-from-catalog',
				'operator' => 'NOT IN',
			];

			if ( ! empty( $category ) ) {
				$args['tax_query'][] = array(
					'taxonomy' => 'product_cat',
					'field'    => 'slug',
					'terms'    => $category,
				);
			}
		
			$search_query = new WP_Query($args);
		
			if ($search_query->have_posts()) {
				$results = '';
				while ($search_query->have_posts()) {
					$search_query->the_post();
					global $product;
					ob_start();
					?>
					<li>
						<a class="search-result-item" href="<?php echo esc_url(get_permalink()); ?>">
							<div class="img-box">
								<img 
									class="lazyload" 
									data-src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'thumbnail')); ?>" 
									src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'thumbnail')); ?>" 
									alt="<?php echo esc_attr(get_the_title()); ?>"
								/>
							</div>
							<div class="box-content">
								<p class="title link"><?php echo esc_html(get_the_title()); ?></p>
								<div class="price">
									<?php if ( $product->is_on_sale() ) : ?>
										<span class="new-price"><?php echo wp_kses_post($product->get_price_html()); ?></span>
									<?php else : ?>
										<span class="regular-price"><?php echo wp_kses_post($product->get_price_html()); ?></span>
									<?php endif; ?>
								</div>
							</div>
						</a>
					</li>
					<?php
					$results .= ob_get_clean();
				}
				
				wp_send_json_success($results);
			} else {
				wp_send_json_success(
'<p class="tf-no-results">' 
        . esc_html__( 'No products were found matching your selection.', 'ovinx' ) .
        ' <a href="' . esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ) . '" class="tf-shop-link">'
        . esc_html__( 'Go To Shop', 'ovinx' ) .
        '</a></p>'
);
			}
		
			wp_die();
		}

		public function update_free_shipping_bar_fragments($fragments) {
			// Markup comes from the same helpers tpl/popup/minicart.php uses for the first paint (inc/helper.php).
			// Both targets must exist in the page: `.tf-mini-cart-threshold` (mini cart popup) and `.box-delivery` (cart page).
			$fragments['.tf-mini-cart-threshold'] = '<div class="tf-mini-cart-threshold">' . ovinx_get_mini_cart_threshold() . '</div>';

			$fragments['.box-delivery'] = '<div class="box-delivery notification-progress">' . ovinx_get_free_shipping_bar() . '</div>';

			return $fragments;
		}
		
		public function tfwc_save_order_note_to_session() {
			check_ajax_referer('tfwc_nonce', 'nonce');
			if (isset($_POST['order_comments'])) {
				WC()->session->set('tfwc_order_note', sanitize_text_field($_POST['order_comments']));
				wp_send_json_success([
	'message' => __(
		'Order note saved successfully',
		'ovinx'
	),
]);
			}
			wp_die();
		}

		public function tfwc_save_order_note_to_order($order_id) {
			$note = WC()->session->get('tfwc_order_note');
			if (!empty($note)) {
				update_post_meta($order_id, '_customer_order_note', sanitize_text_field($note));
				WC()->session->__unset('tfwc_order_note'); 
			}
		}

		public	function tfwc_checkout_order_notes( $value, $input ) {
			if ( 'order_comments' === $input ) {
				$notes = WC()->session->get( 'tfwc_order_note','' );
				if ( ! empty( $notes ) ) {
					return $notes;
				}
			}
			return $value;
		}
		
		public function tfwc_apply_coupon() {
			check_ajax_referer('tfwc_nonce', 'nonce');
			if (isset($_POST['coupon_code']) && !empty($_POST['coupon_code'])) {
				$coupon_code = sanitize_text_field($_POST['coupon_code']);
				
				if (WC()->cart->has_discount($coupon_code)) {
					wp_send_json_error(array(
						'message' => __(
	'This coupon is already applied.',
	'ovinx'
)
					));
				}
		
				if (WC()->cart->add_discount( wc_format_coupon_code( wp_unslash( $coupon_code ) ) )) {
					WC()->cart->calculate_totals();					

					ob_start();
					wc_get_template( 'cart/minicart-totals.php' );
					$minicart_totals = ob_get_clean();

					wp_send_json_success(array(
						'message' => __(
	'Coupon applied successfully!',
	'ovinx'
),
						'minicart_totals' => $minicart_totals
					));
				} else {
					wp_send_json_error(array(
						'message' => __(
	'Invalid coupon code.',
	'ovinx'
)
					));
				}
				
			} else {
				wp_send_json_error(array(
					'message' => __(
	'Coupon code is required.',
	'ovinx'
)
				));
			}

			wp_die();
		}

		public function tfwc_remove_coupon(){		
			check_ajax_referer('tfwc_nonce', 'nonce');
			if (isset($_POST['coupon_code']) && !empty($_POST['coupon_code'])) {
				$coupon_code = sanitize_text_field($_POST['coupon_code']);
				WC()->cart->remove_coupon( $coupon_code );
				WC()->cart->calculate_totals();	

				ob_start();
				wc_get_template( 'cart/minicart-totals.php' );
				$minicart_totals = ob_get_clean();

				wp_send_json_success(array(
					'minicart_totals' => $minicart_totals
				));
				
				
			} else {
				wp_send_json_error(array(
					'message' => 'Coupon code is required.'
				));
			}

			wp_die();
		}
		
		public function tfwc_save_shipping() {
			check_ajax_referer('tfwc_nonce', 'nonce');
			$country   = sanitize_text_field($_POST['country']);
			$state     = sanitize_text_field($_POST['state']);
			$city      = sanitize_text_field($_POST['city']);
			$postcode  = sanitize_text_field($_POST['postcode']);
			
			$customer = WC()->customer;
		
			$country  = sanitize_text_field($_POST['country']);
			$state    = sanitize_text_field($_POST['state']);
			$city     = sanitize_text_field($_POST['city']);
			$postcode = sanitize_text_field($_POST['postcode']);
		
			$customer->set_shipping_country($country);
			$customer->set_shipping_state($state);
			$customer->set_shipping_city($city);
			$customer->set_shipping_postcode($postcode);
			
			$customer->save();
		
			WC()->cart->calculate_totals();
			WC()->session->set('shipping_country', $country);
			WC()->session->set('shipping_state', $state);
			WC()->session->set('shipping_city', $city);
			WC()->session->set('shipping_postcode', $postcode);
			
			wp_send_json_success(
	__( 'Shipping address updated!', 'ovinx' )
);
		}

public function tfwc_apply_gift_fee() {
	if ( ! WC()->session->get('tfwc_gift') ) {
		return;
	}

	$gift_fee_name = __( 'Gift', 'ovinx' );

	foreach ( WC()->cart->get_fees() as $fee ) {
		if ( $fee->name === $gift_fee_name ) {
			return;
		}
	}

	$tfwc_gift_fee = themesflat_get_opt('gift_fee');

	WC()->cart->add_fee(
		$gift_fee_name,
		(float) $tfwc_gift_fee
	);
}

		public function tfwc_apply_gift() {
			check_ajax_referer('tfwc_nonce', 'nonce');
			if (!WC()->cart) {
				wp_die();
			}

			if(WC()->session->get('tfwc_gift')){
				WC()->session->__unset('tfwc_gift');
			}else{
				WC()->session->set('tfwc_gift', true);
			}

			WC()->cart->calculate_totals();
		
			wp_die();
		}
		
		public function tfwc_remove_gift() {
			check_ajax_referer('tfwc_nonce', 'nonce');
			if (!WC()->cart) {
				wp_die();
			}

			WC()->session->__unset('tfwc_gift');
			WC()->cart->calculate_totals();

			wp_send_json_success([
	'message' => __(
		'Gift removed successfully',
		'ovinx'
	),
]);
			wp_die();
		}

		public function tfwc_remove_cart_item() {
			check_ajax_referer('tfwc_nonce', 'nonce');		
			if ( isset( $_POST['cart_item_key'] ) ) {
				$cart_item_key = sanitize_text_field( $_POST['cart_item_key'] );
		
				WC()->cart->remove_cart_item( $cart_item_key );
		
				WC_AJAX::get_refreshed_fragments();
				
				wp_send_json_success();
			} else {
				wp_send_json_error([
	'message' => __(
		'Cart item key is missing.',
		'ovinx'
	),
]);
			}
		}

		public function tfwc_clear_cart() {
			check_ajax_referer( 'tfwc_nonce', 'nonce' );

			if ( WC()->cart ) {
				WC()->cart->empty_cart();
				wp_send_json_success(
	__( 'Cart cleared', 'ovinx' )
);
			} else {
				wp_send_json_error(
	__( 'Cart not available', 'ovinx' )
);
			}
		}


		public function tf_footer_shop() {
			echo  get_template_part( 'woocommerce/mobile/footer-shop' );
		}

		/**
		 * Shop/archive-context `#shareSocial` shell — same visual markup as
		 * Woo_Single_Product_Hook::share_popup(), but this one modal is shared by every card in
		 * the loop, so it can't be pre-filled with one product's real permalink/title server-side.
		 * Placeholder `#`/empty content here; `js/shop.js`'s `productShare()` fills in the clicked
		 * card's real data (from its `data-permalink`/`data-title`) right before the modal opens.
		 */
		public function tfwc_shop_share_popup() {
			?>
			<div class="modal modalCentered fade modal-share popup-style-2" id="shareSocial" aria-modal="true" role="dialog">
				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content">
						<div class="modal-heading d-flex align-items-center justify-content-between">
							<h4 class="title-pop"><?php _e( 'Share', 'ovinx' ); ?></h4>
							<span class="cs-pointer d-flex link" data-bs-dismiss="modal">
								<i class="icon-X2 fs-24"></i>
							</span>
						</div>

						<div class="modal-main">

							<div class="">
								<?php
								$arg_socials = [];

								if ( themesflat_get_opt( 'tf_product_share_facebook' ) ) {
									$arg_socials['facebook'] = '#';
								}

								if ( themesflat_get_opt( 'tf_product_share_instagram' ) ) {
									$arg_socials['instagram'] = '#';
								}

								if ( themesflat_get_opt( 'tf_product_share_x' ) ) {
									$arg_socials['twitter'] = '#';
								}

								if ( themesflat_get_opt( 'tf_product_share_email' ) ) {
									$arg_socials['email'] = '#';
								}

								echo themesflat_render_social( '', $arg_socials );
								?>
							</div>

							<div class="wrap-code btn-coppy-text">
								<div class="coppyText cl-text-2" id="coppyText"></div>
								<div class="btn-action-copy tf-btn tf-btn animate-btn d-inline-flex w-max-content" id="btn-coppy-text"><?php _e( 'Copy', 'ovinx' ); ?></div>
							</div>

						</div>

					</div>
				</div>
			</div>
			<?php
		}

	}
}