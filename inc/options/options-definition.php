<?php
/**
 * Return the default options of the theme
 * 
 * @return  void
 */

function themesflat_customize_default($key) {
	// This function is used as the eager default-value argument of get_theme_mod()
	// via themesflat_get_opt(), so PHP evaluates it on every single call (hundreds
	// per request) regardless of whether a theme_mod already exists. Building the
	// ~1100-line $default array (with json_encode/__ calls) fresh every time is
	// wasteful; cache it once per request in a static variable instead.
	static $default = null;

	if ( $default !== null ) {
		return empty($default[$key]) ? '' : $default[$key];
	}

	$default = array(
		'social_links'	=> array ("facebook" => 'https://www.facebook.com/' ,"twitter" => 'https://x.com/', "instagram" => 'https://www.instagram.com/', "pinterest" => 'https://www.pinterest.com/', "youtube" => 'https://www.youtube.com/' ),
		'show_social_share' => 1,		
		'go_top' => 1,
		'topbar_background_color'	=> '',
		'topbar_textcolor'	=> '',
		'topbar_show' => 1,

		'promo_marquee_arr' => json_encode([
			['text' => 'FREE SHIPPING ON ALL ORDERS OVER $20.00', 'link' => '#'],
			['text' => 'RETURNS ARE FREE WITHIN 14 DAYS', 'link' => '#'],
			['text' => 'SECURE PAYMENT WITH EVERY PURCHASE', 'link' => '#'],
			['text' => 'FREE SHIPPING ON ALL ORDERS OVER $20.00', 'link' => '#'],
			['text' => 'RETURNS ARE FREE WITHIN 14 DAYS', 'link' => '#'],
		]),

		'promo_slides_arr' => json_encode([
			['text' => '<i class="icon icon-SealPercent fs-20"></i> Enjoy 10% Off Your First Purchase! Use Code: <span class="coppyText cs-pointer lh-20">FIRST10</span>', 'link' => '#'],
			['text' => 'Limited Time Offer: Free shipping on all orders over $50', 'link' => '#'],
		]),

		'information_slides_arr' => json_encode([
			['text' => 'Enjoy 10% Off Your First Purchase! Use Code: <span class="coppyText text-button-small cs-pointer">FIRST10</span>', 'link' => '#'],
			['text' => 'Limited Time Offer: Free shipping on all orders over $50', 'link' => '#'],
		]),

		'topbar_items_left' => json_encode(['currency','language']),
		'topbar_items_center' => json_encode(['text-slider']),
		'topbar_items_right' => json_encode(['social']),
		

		'show_promo_bar' => 0,
		'show_promo_bar_mobile' => 0,
		'show_top_bar_mobile' => 0,
		'promo_topbar_style' => 'style-slides',




		'typography_topbar' => array(
			'family' => 'Barlow',
			'style'  => '400',
			'size'   => '',
			'line_height'=>'',
			'letter_spacing' => '',
		),
		'typography_promo' => array(
			'family' => 'Barlow',
			'style'  => '400',
			'size'   => '',
			'line_height'=>'',
			'letter_spacing' => '',
		),
		'promo_background_color' => '',
		'promo_textcolor' => '',
		'promo_bar_position' => 'promo-top',

		'topbar_controls' => array(''),
		
		'information_phone' => '(+01) 1234 8888',



		'logo_controls' => array('padding-top' => '','padding-bottom' => ''),
		'style_header'	=> 'header-09',	
		'header_full_width'	=> 0,	
		'header_backgroundcolor'=>'#fff',
		'header_backgroundcolor_bottom'=>'',
		'header_inner_text_color'=>'',
		'header_special_offers_color'=>'',
		'header_sticky' => 1,
		
		'header_special_offers' => '<a href="#" class="deal-link cl-text-main link">
                                <i class="icon icon-SealPercent fs-24 text-primary"></i>
                                <span class="text fw-medium">Today\'s Deal</span>
                            </a>',
		
		'header_mb_heading' => 'CONTACT',
		'header_phone' => '(+01) 1234 8888',
		'header_email' => 'hi.ovinx@gmail.com',
		'header_address' => '101 E 129th St, East Chicago, USA',


		'header_mb_language' => 1,
		'header_mb_currency' => 1,

		'header_search_box' => 1,
		'header_search_box_form' => 1,

		'header_search_box_menu'	=> 'Feature keywords Today',
		'header_search_box_product'	=> 'Recently viewed products',
		'header_search_box_product_related'	=> 'Related Products',
		
		

		'search_product_limit'	=> 5,
		'header_cart_icon' => 1,
		'header_wishlist_icon' => 1,
		'header_compare_icon' => 1,
		'header_login' => 1,
		'show_post_navigator' => 0,
		'show_entry_footer_content'	=> 0,
		'logo_style' => 'image',
		'logo_text' => 'Ovinx',
		'button_action_header_color' => '',
		'button_action_header_color_hover' => '',
		'typography_logo' => array(
			'family' => 'Barlow',
			'style'  => '500',
			'size'   => '40',
			'line_height'=>'48px',
			'letter_spacing' => '0px',
		),		
		'logo_width' => 150,
		'menu_location_primary' => 'primary',
		'site_logo'	=> THEMESFLAT_LINK . 'images/logo.svg',
		'show_header_category' => 1,		
		'header_category_title' => 'Categories',

		'show_bottom' => 1,		
		'header_backgroundcolor_sticky'=>'',		
		'primary_color'=>'#d90d51',
		'typography_body' => array(
			'family' => 'Barlow',
			'style'  => 'regular',
			'size'   => '16',
			'line_height'=>'26px',
			'letter_spacing' => '0px',
		),
		'body_text_color'=>'',
		'body_background_color' => '',
		'page_sidebar_layout' => 'sidebar-right',
		'content_controls' => array('padding-top' => 60,'padding-bottom' => 80),
		'typography_menu' => array(
			'family' => 'Barlow',
			'style'  => '500',
			'size'   => '16',
			'line_height'=>'26px',
			'letter_spacing' => '0px',
		), 
		'mainnav_color'		=> '',
		'mainnav_hover_color'=>'',
		'mainnav_active_color'=> '',
		'menu_distance_between' => 0,
		'typography_sub_menu' => array(
			'family' => 'Barlow',
			'style'  => '500',
			'size'   => '16',
			'line_height'=>'24px',
			'letter_spacing' => '0px',
		),
		'sub_nav_color'		=>'',		
		'sub_nav_color_hover'	=>	'',
		'sub_nav_background'=>'',
		'typography_headings'	=> array(
			'family' => 'Barlow',
			'style'  => '500',
			'line_height'=>'',
			'letter_spacing' => ''		
		),
		'h1_size' => '',
		'h2_size' => '',
		'h3_size' => '',
		'h4_size' => '',
		'h5_size' => '',
		'h6_size' => '',
		'typography_blockquote' => array(
			'family' => 'Barlow',
			'style'  => '',
			'size'   => '',
			'line_height'=>'',
			'letter_spacing' => '',
		),	
		'typography_blog_post_title' => array(
			'family' => 'Barlow',
			'style'  => '600',
			'size'   => '24',
			'line_height'=>'30px',
			'letter_spacing' => '',
		),
		'typography_blog_post_meta' => array(
			'family' => 'Barlow',
			'style'  => '400',
			'size'   => '14',
			'line_height'=>'22px',
			'letter_spacing' => '',
		),
		'typography_blog_post_buttons' => array(
			'family' => 'Barlow',
			'style'  => '600',
			'size'   => '',
			'line_height'=>'',
			'letter_spacing' => '',
		),
		'typography_blog_single_title' => array(
			'family' => 'Barlow',
			'style'  => '500',
			'size'   => '40',
			'line_height'=>'1.2',
			'letter_spacing' => '',
		),
		'typography_sidebar_widget_title' => array(
			'family' => 'Barlow',
			'style'  => '500',
			'size'   => '24',
			'line_height'=>'30px',
			'letter_spacing' => '',
		),	
		'typography_footer_widget_title' => array(
			'family' => 'Barlow',
			'style'  => '600',
			'size'   => '16',
			'line_height'=>'26px',
			'letter_spacing' => '',
		),	
		'typography_page_title'	=> array(
			'family' => 'Barlow',
			'style'  => '500',
			'size'   => '',
			'line_height'=>'',
			'letter_spacing' => '',
		),
		'page_title_count' => 0,
		'page_title_description' => 1,
		'page_title_description_content' => 'Stay updated with the latest automotive trends, tips, and product insights.',
		'page_title_alignment' => 'left',
		'page_title_background_color' => '#fff',		
		'page_title_text_color' => '#1a1a1a',		
		'page_title_controls' => array('padding-top' => 60, 'padding-bottom' => 0),
		'page_title_background_image' => '',
		'page_title_background_image2' => '',
		'page_title_heading_enabled' => 1,
		'typography_breadcrumb'	=> array(
			'family' => 'Barlow',
			'style'  => '400',
			'size'   => '14',
			'line_height'=>'22px',
			'letter_spacing' => '0px',
		),
		'bread_crumb_prefix' => '',
		'breadcrumb_separator' =>  wp_kses( '<i class="icon icon-CaretRight"></i>', themesflat_kses_allowed_html() ),
		'breadcrumb_color' => '',
		'typography_buttons' => array(
			'family' => 'Barlow',
			'style'  => '600',
			'size'   => '16',
			'line_height'=>'26px',
			'letter_spacing' => '',
		),
		'typography_pagination'	=> array(
			'family' => 'Barlow',
			'style'  => '600',
			'size'   => '16',
			'line_height'=>'24px',
			'letter_spacing' => '0px',
		),		
		'typography_bottom_menu' => array(
			'family' => 'Barlow',
			'style'  => '',
			'size'   => '',
			'line_height'=>'',
			'letter_spacing' => '',
		),
		'breadcrumb_enabled' => 1,
		'meta_elements' => 'date,author,category',
		'blog_featured_title' => '',
		'post_layout_single' => 'fullwidth',
		'post_sidebar_layout' => 'sidebar-right',		
		'blog_archive_layout' => 'style-standard',
		'blog_grid_style' => 'style-1',		
		'show_related_post' => 0,
		'related_post_style'	=> 'blog-grid',
		'related_post_title'	=> 'Blog and tips Auto parts',
		'related_post_des'	=> 'Unleash automotive excellence with our precision crafted parts and tools.',
		'grid_columns_post_related' => 3,
		'number_related_post' => 3,
		'related_post_columns'  => array(
			'desktop' => 3,
			'tablet'  => 2,
			'mobile'  => 1,
		),
		'blog_sidebar_list'		  => 'blog-sidebar',	
		'blog_archive_post_excepts_length' => 12,
		'blog_archive_readmore_text' => 'Read More',
		'blog_archive_pagination_style' => 'pager-numeric',
		'blog_posts_per_page'	=> 6,
		'page_sidebar_list'	=> 'blog-sidebar',		
		
		'blog_archive_style'	=> 'style-standard',
		'blog_single_style'	=> 'default',
		'blog_category'	=> 0,
		'blog_category_columns'  => array(
			'desktop' => 5,
			'tablet'  => 3,
			'mobile'  => 2,
		),


		

		
		
		'typography_footer' => array(
			'family' => 'Barlow',
			'style'  => '400',
			'size'   => '16',
			'line_height'=>'26px',
			'letter_spacing' => '',
		),
		'footer_top'	=> 1,
		'footer_top_category_arr' => json_encode([
			['text' => 'New Collection', 'link' => '#'],
			['text' => 'All Jewelry', 'link' => '#'],
			['text' => 'Charms', 'link' => '#'],
			['text' => 'Bracelets', 'link' => '#'],
			['text' => 'Rings', 'link' => '#'],
			['text' => 'Earrings', 'link' => '#'],
			['text' => 'Gifts', 'link' => '#'],
			['text' => 'Collections', 'link' => '#'],
		]),
		'footer_background_color'	=> '',
		'footer_title_widget_color' => '',
		'footer_text_color'			=> '',
		'footer_text_color_hover'   => '',
		'footer_controls' => array(),
		'footer2' => 'footer-2',
		'footer3' => 'footer-3',
		'footer4' => 'footer-4',
		'typography_bottom_copyright' => array(
			'family' => 'Barlow',
			'style'  => '400',
			'size'   => '16',
			'line_height'=>'24px',
			'letter_spacing' => '-0.01em',
		),
		'show_bottom_currency' => 1,
		'img_payment' => THEMESFLAT_LINK . 'images/payment/amex.svg,' . THEMESFLAT_LINK . 'images/payment/discover.svg,' . THEMESFLAT_LINK . 'images/payment/master-card.svg,' . THEMESFLAT_LINK . 'images/payment/paypal.svg,' . THEMESFLAT_LINK . 'images/payment/paypal-2.svg,' . THEMESFLAT_LINK . 'images/payment/visa.svg,' . THEMESFLAT_LINK . 'images/payment/water.svg',
		'bottom_background_color'	=> '',
		'bottom_text_color'			=> '',
		'bottom_link_color'         => '',
		'bottom_text_color_hover'   => '',		
		'layout_version'			=> 'wide',		
		'footer_copyright'			=> '©2026 <span class="fw-medium text-white text-decoration-underline">Ovinx</span>. All Rights Reserved.',
		'footer_description'		=> 'We deliver reliable products for strength and performance. Designed<br> for everyday needs.',
		'footer_contact_phone'		=> '(+01) 1234 8888',
		'footer_contact_address'	=> '101 E 129th St, East Chicago, USA',
		'footer_contact_map_url'	=> 'https://www.google.com/maps?q=101+E+129th+St,+East+Chicago,+USA',
		'footer_contact_email'		=> 'hi@ovinx.com',
		'footer_newsletter_enabled'		=> 1,
		'footer_newsletter_title'			=> 'Subscribe To Our Newsletter',
		'footer_newsletter_description'	=> 'Sign up for our newsletter and get 10% off your first purchase',
		'footer_newsletter_shortcode'		=> '',
		'enable_smooth_scroll'	=> 0,
		'show_bottom_language'	=> 0,
		'show_bottom_currency'	=> 0,
		'show_img_payment'	=> 0,
		'enable_preload' => 0,



		// Cookies
		// Wishlist / Compare empty-list notice (Customizer > Shop > Wishlist & Compare Empty)
		'wishlist_empty_title' => __('Nothing Saved Yet', 'ovinx'),
		'wishlist_empty_desc' => __('Start saving the products you love. Explore our collections <br class="d-none d-sm-block">and add items to your wishlist for later.', 'ovinx'),
		'wishlist_empty_button_text' => __('START SHOPPING', 'ovinx'),
		'compare_empty_title' => __('Nothing To Compare Yet', 'ovinx'),
		'compare_empty_desc' => __('Add two or more products to compare their price, rating and specs <br class="d-none d-sm-block">side by side.', 'ovinx'),
		'compare_empty_button_text' => __('START SHOPPING', 'ovinx'),

		'tf_cookies' => 0,
		'tf_cookies_content' => 'The cookie settings on this website are set to "allow all cookies" to give you the very best experience. Please click Accept Cookies to continue to use the site.',
		'tf_cookies_btn' => 'Privacy Policy',
		'tf_cookies_btn_url' => '#',
		'tf_cookies_btn_active' => 'Accept Cookies',
		
		// Mobile


		'btn_login_mobile' => 0,
		'btn_wishlist_mobile' => 0,
		'btn_cart_mobile' => 1,

		'btn_pc_cart' => 1,
		'btn_pc_wishlist' => 1,
		'btn_pc_compare' => 1,
		'btn_pc_quickview' => 1,
		'pc_badges' => 1,


		'show_navigation_bar' => 1,
		'navbar_element' => 'home,account,shop,wishlist,cart',

        //Woo
		'breadcrumb_woo' => 1,
		'page_title_heading_woo' => 1,
		'page_title_text_btn' => 'Read More',
		'page_title_background_color_woo' => '',
		'page_title_background_color2_woo' => '',
		'page_title_background_color_opacity_woo' => '100',	
		'page_title_alignment_woo' => 'left',
		'page_title_controls_woo' => array('padding-top' => 20, 'padding-bottom' =>0),
		
		'page_title_description_woo' => 1,

		'page_title_description_content_shop' => __('Discover the stories behind our exquisite pieces—timeless craftsmanship, meaningful designs, <br class="d-none d-xxl-block"> and the moments that make them unforgettable.', 'ovinx'),

		'page_title_description_content_wishlist' => __('Explore your saved favorites, manage your wishlist effortlessly,<br class="d-none d-lg-block"> and keep track of the items you love most.', 'ovinx'),

		'page_title_description_content_compare' => __('Compare your favorite products side by side to find the best match for your <br class="d-none d-lg-block"> needs, style, and everyday lifestyle.', 'ovinx'),

		'page_title_description_content_cart' => __('Review your selected items, update quantities, and get ready for a smooth and <br class="d-none d-lg-block"> easy checkout experience.', 'ovinx'),

		'page_title_description_content_checkout' => __('Review your order details carefully and complete your purchase securely and <br class="d-none d-lg-block"> easily for a smooth shopping experience.', 'ovinx'),

		// pagetitle single
		'page_title_heading_woo_single' => 0,
		'breadcrumb_woo_single' => 1,

		'single_navigation' => 1,

		'show_top_category' => 1,
		'top_category_title' => 'Shop By Categories',
		'category_order' => 'name',		
		'category_number' => 6,
		'category_dek' => 5,
		'category_tab' => 3,
		'category_mob' => 2,
		'category_mob2' => 2,
		'category_columns'  => array(
			'desktop' => 5,
			'tablet'  => 3,
			'mobile_sm'  => 2,
			'mobile'  => 2,
		),

		// catalog
		'catalog_toolbar' => 1,
		'catalog_view' => 1,
		'catalog_btn_change' => 1,
		'catalog_sort_by' => 1,
		'number_view'  => 4,
		'number_view_active'  => 4,

		'pagination_ajax' => 1,
		'shop_pagination' => 'number',
		'shop_pagination_align' => 'center',
		'shop_loadmore_text' => __('Load More', 'ovinx'),



		
        'shop_products_per_page' => 8,
        'shop_layout' => 'fullwidth',
		'shop_style' => 'grid',
        'shop_layout_single' => 'fullwidth',
		'filter_sticky' => 0,
		'filter_sidebar_button' => 0,

		// product card
		'attribute_first' => 'none',
		'attr1_count' => 5,		
		'attr1_type' => 'label',		
		'attribute_second' => 'color',
		'attr2_count' => 3,	
		'product_style' => 'style-1',				
		'show_out_stock' => 1,
		'show_rating' => 1,
		'show_category' => 1,
		'show_description' => 0,
		'show_progressbar' => 0,
		'show_countdown' => 1,
		'show_in_out_stock' => 1,

		'show_out_stock_btn' => 0,
		'out_stock_btn_text' => 'Notify Me When Available',
		'out_stock_form' => '',
		
		'show_badges' => 1,

		// badges
		'badges_stock' => 1,
		'badges_stock_color' => '',
		'badges_stock_background_color' => '',		
		'badges_trending' => 1,
		'badges_trending_color' => '',
		'badges_trending_background_color' => '',	
		'badges_custom' => 1,
		'badges_custom_color' => '',
		'badges_custom_background_color' => '',	
		'badges_sale' => 1,
		'badges_sale_color' => '',
		'badges_sale_background_color' => '',	
		'badges_new' => 1,
		'badges_new_color' => '',
		'badges_new_background_color' => '',	
		'badges_order' => 1,
		'badges_order_color' => '',
		'badges_order_background_color' => '',
		

		'shop_iconbox' => 1,


		// cart
		'free_shipping_bar' => 1,
		'tf_guest_cart_hours_enable' => 1,
		'tf_guest_cart_hours' => 168,
		'progress_cart_text' => '<p class="text"> Buy <span class="text-primary fw-7">{currency}{total}</span> more to get <span class="text-primary fw-7 text-nowrap">Free Shipping</span></p>',
		'success_cart_text' => 'Congrats! You have got <span class="text-primary fw-7 text-nowrap">Free Shipping</span>',

		'minicart_term_link' => '#',

		
		


		

		'testimonial_boxes' => json_encode([
            [
                'quote' => '<i class="icon icon-quote-3 text-primary"></i>',
                'review' => 'I was blown away by the craftsmanship and detail of my necklace. It’s even more stunning in person! ovinx truly delivers timeless elegance.',
                'name' => 'Ovinx P.',
                'image' => THEMESFLAT_LINK . 'images/testimonial/avt-5.jpg',
                'stars' => 5, 
            ],
            [
                'quote' => '<i class="icon icon-quote-3 text-primary"></i>',
                'review' => 'These minimalist hoops add the perfect touch of elegance to any outfit. Designed for everyday wear with a sleek, modern finish — your new go-to accessory for effortless sophistication',
                'name' => 'Mas S.',
                'image' => THEMESFLAT_LINK . 'images/testimonial/avt-4.jpg',
                'stars' => 4, 
			],
        ]),

		'checkout_testi' => 1,
		'testimonial_checkout' => json_encode([
            [
                'quote' => '<i class="icon-block-quote"></i>',
                'title' => 'HAPPY CUSTOMERS',				
                'review' => '"I’ve never felt more confident in my wardrobe! Every piece I’ve bought from here is high-quality, trendy, and fits perfectly. The entire shopping experience has been seamless from start to finish. Thank you for making fashion so easy!"',
                'name' => 'ovinx P',
            ],
            [
                'quote' => '<i class="icon-block-quote"></i>',
                'title' => 'HAPPY CUSTOMERS',				
                'review' => '"I’ve never felt more confident in my wardrobe! Every piece I’ve bought from here is high-quality, trendy, and fits perfectly. The entire shopping experience has been seamless from start to finish. Thank you for making fashion so easy!"',
                'name' => 'Themesflat',
            ], 
			[
                'quote' => '<i class="icon-block-quote"></i>',
                'title' => 'HAPPY CUSTOMERS',				
                'review' => '"I’ve never felt more confident in my wardrobe! Every piece I’ve bought from here is high-quality, trendy, and fits perfectly. The entire shopping experience has been seamless from start to finish. Thank you for making fashion so easy!"',
                'name' => 'Henry P',
            ]
        ]),

		'order_give_feedback' => 1,
		'order_give_feedback_content' =>
		'
			<form class="feedback-box">
				<h6 class="title">Give us a feedback</h6>
				<p class="text cl-text-2 text-caption-01">
					Let us know what you think about the
					shopping experience, and get a gift coupon for the next shopping.
				</p>
				<div class="form-content gap-16 mb-16">
					<fieldset class="tf-field">
						<label for="fb_Name" class="tf-lable text-caption-01">Name <span class="text-primary">*</span></label>
						<input type="text" id="fb_Name" placeholder="Name" required="">
					</fieldset>
					<fieldset class="tf-field">
						<label for="fb_Email" class="tf-lable text-caption-01">Email <span class="text-primary">*</span></label>
						<input type="text" id="fb_Email" placeholder="Email" required="">
					</fieldset>
					<div class="box-exp">
						<p class="mb-6 cl-text-2 text-caption-01">How was your experience?</p>
						<div class="list-exp">
							<label for="exp1" class="check-exp">
								<input type="radio" id="exp1" checked="" class="tf-check-rounded style-small" name="checkExperience">
								<span class="text-exp">1</span>
							</label>
							<label for="exp2" class="check-exp">
								<input type="radio" id="exp2" class="tf-check-rounded style-small" name="checkExperience">
								<span class="text-exp">2</span>
							</label>
							<label for="exp3" class="check-exp">
								<input type="radio" id="exp3" class="tf-check-rounded style-small" name="checkExperience">
								<span class="text-exp">3</span>
							</label>
							<label for="exp4" class="check-exp">
								<input type="radio" id="exp4" class="tf-check-rounded style-small" name="checkExperience">
								<span class="text-exp">4</span>
							</label>
							<label for="exp5" class="check-exp">
								<input type="radio" id="exp5" class="tf-check-rounded style-small" name="checkExperience">
								<span class="text-exp">5</span>
							</label>
						</div>
					</div>
					<fieldset class="tf-field">
						<label for="fb_Area" class="tf-lable text-caption-01">Share your exprience
							<span class="text-primary">*</span></label>
						<textarea name="" id="fb_Area" placeholder="Share your exprience"></textarea>
					</fieldset>
				</div>
				<button type="submit" class="tf-btn w-100 animate-btn">
					<span class="fw-semibold">
						SEND
					</span>
				</button>
			</form>
		',

		// Minicart
		'minicart_gift' => 1,
		'gift_fee' => 2.00,
		'minicart_note' => 1,
		'minicart_shipping' => 1,
		'minicart_coupon' => 1,

		// Live Notification
		'live_notification' => 0,		
		'product_from' => 'order',
		'live_timeout' => 6000,
		'live_interval' => 8000,

		'live_number' => 5,

		'product_type' => 'sale',

		'live_category' => '',

		// related
		'related_display' => 1,
		'related_limit' => 5,
		'related_heading' => __('Related Products', 'ovinx'),
		'related_product_columns'  => array(
			'desktop' => 4,
			'tablet'  => 3,
			'mobile'  => 2,
		),

		
		// recently
		'recently_display' => 1,
		'recently_limit' => 5,
		'recently_heading' => 'Recently Viewed',
		'recently_product_style' => 'style-1',
		'recently_product_columns'  => array(
			'desktop' => 4,
			'tablet'  => 3,
			'mobile'  => 2,
		),

		// cross sell
		'cross_sell_display' => 1,
		'cross_sell_heading' => 'Cross Sell Product',
		'cross_sell_product_columns'  => array(
			'desktop' => 4,
			'tablet'  => 3,
			'mobile'  => 2,
		),
		
		// upsell
		'upsell_display' => 1,
		'upsell_heading' => 'You May Also Like',
		'upsell_product_columns'  => array(
			'desktop' => 4,
			'tablet'  => 3,
			'mobile'  => 2,
		),

		

		// single product
		'fake_sold' => 1,
		'fake_sold_random_from' => 15,
		'fake_sold_random_to' => 30,
		'fake_sold_increment_max' => 5,
		'fake_sold_interval' => 15,
		'fake_sold_text' => __('sold in last 32 hours', 'ovinx'),

		'fake_view' => 1,
		'fake_view_random_from' => 5,
		'fake_view_random_to' => 60,
		'fake_view_interval' => 6000,
		'fake_view_text' => __('People are viewing this right now', 'ovinx'),

		'progress_sale' => 1,
		'progress_sale_text' => __('Sold It:', 'ovinx'),
		'progress_sale_subtext' => '<span class="percent-sold">{total_sales} Sold -</span> Only {count} item(s) left in stock!',
		'progress_sale_low_stock' => 2,

		'tf_countdown' => 1,
		'tf_countdown_text' => __('Hurry Up!', 'ovinx'),
		'tf_countdown_subtext' => __('Offer ends in:', 'ovinx'),

		'tf_wishlist_pos' => 1,

		'tf_size_guide' => 0,
		

		'tf_product_tabs_style' => 'default',
		'tf_product_custom_tab' => 1,
		'tf_product_custom_tab_title' => __('Shipping & Returns', 'ovinx'),
		'tf_product_custom_tab_content' => __('Custom tab content goes here. You can add any information about the product that you think is relevant and helpful for your customers.', 'ovinx'),

		'tf_product_description_tab' => 1,
		'tf_product_additional_info_tab' => 1,
		'tf_product_reviews_tab' => 1,




		'tf_extra_action' => 1,
		'extra_link_ask_question' => 1,

		'extra_link_ask_question_btn_text' => __('Ask A Question', 'ovinx'),
		
		'extra_link_ask_question_title' => __('Ask A Question', 'ovinx'),
		'extra_link_ask_question_subtitle' => __('Have a question? Ask us today!', 'ovinx'),
		'extra_link_ask_question_content' => '
			<form class="form-log mb-20">
				<div class="form-content">
					<fieldset class="tf-field">
						<label for="name-ask" class="tf-lable fw-medium">
							Your Name<span class="text-primary">*</span>
						</label>
						<input type="text" id="name-ask" placeholder="Your Name*" required="">
					</fieldset>
					<fieldset class="tf-field">
						<label for="email-ask" class="tf-lable fw-medium">
							Your Email<span class="text-primary">*</span>
						</label>
						<input type="email" id="email-ask" placeholder="Your Email*" required="">
					</fieldset>
					<fieldset class="tf-field">
						<label for="phone-ask" class="tf-lable fw-medium">
							Your phone
						</label>
						<input type="tel" id="phone-ask" placeholder="Your phone">
					</fieldset>
					<fieldset class="tf-field">
						<label for="message-ask" class="tf-lable fw-medium">
							Your Message
							<span class="text-primary">*</span>
						</label>
						<textarea id="message-ask" placeholder="Your Message*" required=""></textarea>
					</fieldset>
				</div>
				<div class="group-action">
					<button type="submit" class="tf-btn animate-btn w-100">
						Send Message
					</button>
				</div>
			</form>
		',

		'tf_trust_seal' => 1,
		'tf_trust_seal_text' => 'Guaranteed Safe Checkout:',
		// comma-separated string: that is the format the TF_Multiple_Images control + its sanitizer store/expect
		'tf_trust_seal_items' => implode( ',', [
			THEMESFLAT_LINK . 'images/payment/visa.svg',
			THEMESFLAT_LINK . 'images/payment/master-card.svg',
			THEMESFLAT_LINK . 'images/payment/amex.svg',
			THEMESFLAT_LINK . 'images/payment/paypal.svg',
			THEMESFLAT_LINK . 'images/payment/water.svg',
			THEMESFLAT_LINK . 'images/payment/discover.svg',
		] ),
		'tf_extra_info' => 1,



		'tf_delivery_info' => 1,
		'tf_delivery_text' => __('Estimated Delivery: <span class="fw-semibold"> 12-26 Days </span> (International), <span class="fw-semibold"> 3-6 Days </span> (United States)', 'ovinx'),
		'tf_delivery_icon' => 'icon icon-Timer',

		'tf_delivery_text2' => 'Return within <span class="fw-semibold"> 45 Days </span> of purchase. Duties &amp; taxes are non-refundable.',
		'tf_delivery_icon2' => 'icon icon-ArrowClockwise',

		'tf_delivery_text3' => '',
		'tf_delivery_icon3' => '',

		'tf_delivery_text4' => '',
		'tf_delivery_icon4' => '',

		'tf_product_share' => 1,
		'tf_product_share_facebook' =>  1,
		'tf_product_share_instagram' =>  1,
		'tf_product_share_x' =>  1,
		'tf_product_share_email' =>  1,

		'tf_buy_now' => 1,
		'tf_buy_now_query_arg' => 'buy-it-now',

		'tf_buy_together' => 1,
		'tf_buy_together_position' => 'left',
		'tf_buy_together_check_all' => 0,

		'tf_buyx_gety' => 1,
		'tf_buyx_gety_main_icon' => 'icon icon-SealPercent1',
		'tf_buyx_gety_free_icon' => 'icon icon-Handbag',
		'tf_buyx_gety_discount_icon' => 'icon icon-Fire',
		'tf_buyx_gety_main_text' => 'Part of a promo bundle (main item)',
		'tf_buyx_gety_free_text' => 'Free gift in bundle',
		'tf_buyx_gety_discount_text' => 'Discounted item in bundle ({discount}% off)',

		'tf_volume_discount' => 1,

		// 'tf_product_gallery' => 1,
		'tf_product_gallery_layout' => 'left_thumb',
		'tf_product_gallery_zoom' => 'external',
		'tf_product_gallery_lightbox' => 1,


		'tf_variation_gallery' =>0,
		'tf_product_video' => 1,
		'tf_product_3d' => 0,

		'tf_out_of_stock_notification' => 1,
		'tf_out_of_stock_notification_html' => '
		<form class="tf-product-out-stock">
			<h5 class="title">
				Notify me when it back in stock
			</h5>
			<p class="desc">
				Enter your email address to be notified if the product becomes available again.
			</p>
			<div class="form-content">
				<fieldset class="tf-field">
					<label for="outName">Full Name<span class="text-primary">*</span></label>
					<input type="text" id="outName" placeholder="Full Name*" required="">
				</fieldset>
				<fieldset class="tf-field">
					<label for="outEmail">Email Address<span class="text-primary">*</span></label>
					<input type="email" id="outEmail" placeholder="Email Address*" required="">
				</fieldset>
				<button type="submit" class="tf-btn btn-action-price">
					SUBSCRIBE NOW
				</button>
			</div>
		</form>',

		
		'single_sku' => 1,
		'single_brand' => 1,
		'single_available' => 1,
		'single_category' => 1,

		'single_add_to_cart_text' => __( 'Add to cart', 'ovinx' ),
		'single_sold_out_text' => __( 'Sold out', 'ovinx' ),
		'single_pre_order_text' => __( 'Pre-order', 'ovinx' ),
		

		// recently wishlist
		'recently_wl_display' => 0,
		'recently_wl_limit' => 5,
		'recently_wl_heading' => 'Recently Viewed',
		'recently_wl_product_columns'  => array(
			'desktop' => 4,
			'tablet'  => 3,
			'mobile'  => 2,
		),
		
		// login google
		'enable_login_gg' => 0,
		'google_login_client_id' => '',
		'google_login_client_secret' => '',
		// login facebook
		'enable_login_fb' => 0,
		'facebook_login_client_id' => '',
		'facebook_login_client_secret' => '',


		'register_policy' => __('I agree to the <a href="#"  class="text-decoration-underline fw-medium text-primary link-2">Terms of Use</a>', 'ovinx'),

		// 404
	);
	return empty($default[$key]) ? '' : $default[$key];
}