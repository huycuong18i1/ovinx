<?php
function hexToRgba($hex, $alpha = 1) {
    $hex = str_replace('#', '', $hex);

    if (strlen($hex) === 3) {
        $r = hexdec(str_repeat(substr($hex, 0, 1), 2));
        $g = hexdec(str_repeat(substr($hex, 1, 1), 2));
        $b = hexdec(str_repeat(substr($hex, 2, 1), 2));
    } else {
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
    }

    return "rgba($r, $g, $b, $alpha)";
}

function tf_wc_placeholder_img_src(){
    return esc_url( THEMESFLAT_LINK . 'images/product/placeholder-595x744.svg' );
}

function themesflat_render_box_control($name,$control=array(),$id='') {
    add_action('admin_enqueue_scripts','themesflat_admin_color_picker');
    $default = array(
        'margin-top' => '',
        'margin-bottom' => '',
        'margin-left' => '',
        'margin-right' => '',
        'padding-top' => '',
        'padding-bottom' => '',
        'padding-left' => '',
        'padding-right' => '',
        'border-top-width' => '',
        'border-bottom-width' => '',
        'border-left-width' => '',
        'border-right-width' => ''
        );
    $controls = themesflat_decode($control);
    if (!is_array($controls)) {
        $controls = array();
    }
    $controls = array_merge($default,$controls);
    ?>
    <div class="themesflat_box_control">
        <div class="themesflat_box_position">
            <div class="themesflat_box_margin">
                <label class="themesflat_box_label"><?php echo esc_html('Margin');?></label>
                <input placeholder="-" data-position='margin-top' value ="<?php  echo esc_attr(($controls['margin-top']));?>" class="top" type="text"/>
                <input placeholder="-" data-position='margin-bottom' value ="<?php  echo esc_attr(($controls['margin-bottom']));?>" class="bottom" type="text"/>
                <input placeholder="-" data-position='margin-left' value ="<?php  echo esc_attr(($controls['margin-left']));?>" class="left" type="text"/>
                <input placeholder="-" data-position='margin-right' value ="<?php  echo esc_attr(($controls['margin-right']));?>" class="right" type="text"/>
            </div>

            <div class="themesflat_box_padding">
                <label class="themesflat_box_label"><?php echo esc_html('Padding');?></label>
                <input placeholder="-" data-position='padding-top' value ="<?php  echo esc_attr(($controls['padding-top']));?>" class="top" type="text"/>
                <input placeholder="-" data-position='padding-bottom' value ="<?php  echo esc_attr(($controls['padding-bottom']));?>" class="bottom" type="text"/>
                <input placeholder="-" data-position='padding-left' value ="<?php  echo esc_attr(($controls['padding-left']));?>" class="left" type="text"/>
                <input placeholder="-" data-position='padding-right' value ="<?php  echo esc_attr(($controls['padding-right']));?>" class="right" type="text"/>
            </div>

            <div class="themesflat_box_border">
                <label class="themesflat_box_label"><?php echo esc_html('Border');?></label>
                <input placeholder="-" data-position='border-top-width' value ="<?php  echo esc_attr(($controls['border-top-width']));?>" class="top" type="text"/>
                <input placeholder="-" data-position='border-bottom-width' value ="<?php  echo esc_attr(($controls['border-bottom-width']));?>" class="bottom" type="text"/>
                <input placeholder="-" data-position='border-left-width' value ="<?php  echo esc_attr(($controls['border-left-width']));?>" class="left" type="text"/>
                <input placeholder="-" data-position='border-right-width' value ="<?php  echo esc_attr(($controls['border-right-width']));?>" class="right" type="text"/>
            </div>
            <div class="themesflat_control_logo"></div>
        </div>
    </div>
    <input name="<?php echo esc_attr($name);?>" data-customize-setting-link="<?php echo  esc_attr($id);?>" value="<?php echo esc_attr(json_encode($controls));?>" type="hidden"/>
    <?php 
}

function themesflat_excerpt_more( $more ) {
    return '';
}

function themesflat_excerpt_not_more( $more ) {
    return '';
}

function themesflat_remove_more_link_scroll( $link ) {
    $link = preg_replace( '|#more-[0-9]+|', '', $link );

    return $link;
}
add_filter( 'the_content_more_link', 'themesflat_remove_more_link_scroll' );

function themesflat_predefined_header_styles() {
    static $styles;

    if ( empty( $styles ) ) {
        $styles = apply_filters( 'themesflat/header_styles', array(
            'header-v1' => esc_html__( 'Classic', 'ovinx' ),
            'header-v2' => esc_html__( 'Header style 02', 'ovinx' ),
            'header-v4' => esc_html__( 'Modern', 'ovinx' ),
        ) );
    }

    return $styles;
}

function themesflat_available_social_icons() {
    $icons = apply_filters( 'themesflat_available_icons', array(

        'facebook'  => array(
            'iclass'     => 'icon-FacebookLogoFill',
            'title'      => 'Facebook',
            'share_link' => THEMESFLAT_PROTOCOL . '://www.facebook.com/sharer/sharer.php?u=',
        ),

        'instagram' => array(
            'iclass'     => 'icon-InstagramLogoFill',
            'title'      => 'Instagram',
            'share_link' => 'https://www.instagram.com/?url=',
        ),

        'twitter'   => array(
            'iclass'     => 'icon-XLogoFill',
            'title'      => 'Twitter',
            'share_link' => THEMESFLAT_PROTOCOL . '://twitter.com/intent/tweet?url=',
        ),

        'pinterest' => array(
            'iclass'     => 'icon-PinterestLogoFill',
            'title'      => 'Pinterest',
            'share_link' => 'https://pinterest.com/pin/create/button/?url=',
        ),

        'reddit'    => array(
            'iclass'     => 'icon-reddit',
            'title'      => 'Reddit',
            'share_link' => 'https://www.reddit.com/submit?url=',
        ),

        'telegram'  => array(
            'iclass'     => 'icon-telegram',
            'title'      => 'Telegram',
            'share_link' => 'https://t.me/share/url?url=',
        ),

        'whatsapp'  => array(
            'iclass'     => 'icon-whatsapp',
            'title'      => 'WhatsApp',
            'share_link' => 'https://api.whatsapp.com/send?text=',
        ),

        'messenger' => array(
            'iclass'     => 'icon-messenger',
            'title'      => 'Messenger',
            'share_link' => '',
        ),

        'discord'   => array(
            'iclass'     => 'icon-discord',
            'title'      => 'Discord',
            'share_link' => '',
        ),

        'snapchat'  => array(
            'iclass'     => 'icon-snapchat',
            'title'      => 'Snapchat',
            'share_link' => '',
        ),

        'github'    => array(
            'iclass'     => 'icon-github',
            'title'      => 'Github',
            'share_link' => '',
        ),

        'tumblr'    => array(
            'iclass'     => 'icon-tumblr',
            'title'      => 'Tumblr',
            'share_link' => 'https://www.tumblr.com/widgets/share/tool?canonicalUrl=',
        ),

        'line'      => array(
            'iclass'     => 'icon-line',
            'title'      => 'Line',
            'share_link' => 'https://social-plugins.line.me/lineit/share?url=',
        ),

        'tiktok'    => array(
            'iclass'     => 'icon-TiktokLogo',
            'title'      => 'Tiktok',
            'share_link' => '',
        ),

        'youtube'   => array(
            'iclass'     => 'icon-YoutubeLogoFill',
            'title'      => 'Youtube',
            'share_link' => '',
        ),

        'email'     => array(
            'iclass'     => 'icon-EnvelopeSimple',
            'title'      => 'Email',
            'share_link' => '',
        ),
    ) );

    $icons['__ordering__'] = array_keys( $icons );

    return $icons;
}

/**
 * Menu fallback
 */
function themesflat_menu_fallback() {
    echo '<ul id="menu-main" class="menu">
    <li>
    <a class="menu-fallback" href="' . esc_url(admin_url('nav-menus.php')) . '">' . esc_html__( 'Create Menu', 'ovinx' ) . '</a></li></ul>';
}


/**
 * Change the excerpt length
 */
function themesflat_excerpt_length( $length ) {  
    $excerpt = themesflat_get_opt('blog_archive_post_excepts_length');
    return $excerpt;
}
add_filter( 'excerpt_length', 'themesflat_excerpt_length', 999 );

/**
 * Blog layout
 */
function themesflat_blog_layout() {  
      
    switch (get_post_type()) {
        case 'page':
            $layout = themesflat_get_opt_elementor('page_sidebar_layout');   
            break;
        case 'post':
            $layout = themesflat_get_opt('post_sidebar_layout');
            if (isset($_GET['sidebar'])){
                $layout = sanitize_text_field($_GET['sidebar']);
            }   
            if (is_single()) {
                $layout = themesflat_get_opt('post_layout_single');
                if (isset($_GET['sidebar'])){
                    $layout = sanitize_text_field($_GET['sidebar']);
                }  
            }
            break;
            break;
        case 'product':
            $layout = themesflat_get_opt('shop_layout');
            if (isset($_GET['sidebar'])){
                $layout = sanitize_text_field($_GET['sidebar']);
            }
            if (is_single()) {
                $layout = themesflat_get_opt('shop_layout_single');
            }
            break;
        default:
            $layout = themesflat_get_opt('page_sidebar_layout');
            break;

    }

    if (is_search() && class_exists('WooCommerce')) {
        $layout = themesflat_get_opt('shop_layout');
    }

    return $layout;
}

function themesflat_font_style($style) {
    $style = $style ?? ''; 

    if (strlen($style) > 3) {
        switch (substr($style, 0,3)) {
            case 'reg':
                $a[0] = '400';
                $a[1] = 'normal';
                break;
            case 'ita':
                $a[0] = '400';
                $a[1] = 'italic';               
                break;
            default:
                $a[0] = substr($style, 0,3);
                $a[1] = substr($style, 3);
                break;
        }
    } else {
        $a[0] = $style ?: '400'; 
        $a[1] = 'normal';
    }
    return $a;
}

function themesflat_hex2rgba($color, $opacity = false) {
 
    $default = 'rgb(0,0,0)';
 
    //Return default if no color provided
    if(empty($color))
          return $default; 
 
    //Sanitize $color if "#" is provided 
    if ($color[0] == '#' ) {
        $color = substr( $color, 1 );
    }

    //Check if color has 6 or 3 characters and get values
    if (strlen($color) == 6) {
            $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
    } elseif ( strlen( $color ) == 3 ) {
            $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
    } else {
            return $default;
    }

    //Convert hexadec to rgb
    $rgb =  array_map('hexdec', $hex);

    //Check if opacity is set(rgba or rgb)
    if($opacity){
        if(abs($opacity) > 1)
            $opacity = 1.0;
        $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
    } else {
        $output = 'rgb('.implode(",",$rgb).')';
    }

    //Return rgb(a) color string
    return $output;
}

function themesflat_render_box_position($class,$box_control,$custom_string='') {
    $css = esc_attr($class) .'{';
    if (is_array($box_control)) {
        foreach ($box_control as $key => $value) {
            if ( $value !='') {
                $css .= esc_attr($key) .':'.esc_attr(str_replace("px","",$value)).'px; ';
            }
        }
    }
    $css .= esc_attr($custom_string);
    $css .= '}';

    wp_add_inline_style( 'themesflat-inline-css', $css );
}

function ovinx_sanitize_array( $value ) {
    if ( is_array( $value ) ) {
        return array_map( 'sanitize_text_field', $value );
    }
    return sanitize_text_field( $value );
}

function themesflat_get_json($key) {
    // Cache per key for the current request: theme_mods don't change mid-request,
    // so this avoids repeating get_theme_mod()/json_decode() for the same key
    // (e.g. typography_* is read both when building the Google Fonts URL and
    // when generating inline CSS).
    static $cache = array();

    if ( array_key_exists( $key, $cache ) ) {
        return $cache[ $key ];
    }

    $mod_value = get_theme_mod( $key );

    if ( $mod_value == '' ) {
        return $cache[ $key ] = themesflat_customize_default($key);
    }
    if (!is_array($mod_value)) {
        $decoded_value = json_decode(str_replace('&quot;', '"',  $mod_value), true );
    }
    else {
        $decoded_value = $mod_value;
    }
    return $cache[ $key ] = $decoded_value;
}

function themesflat_decode($value) {
    if (!is_array($value)) {
        $decoded_value = json_decode(str_replace('&quot;', '"',  $value) , true );
    }
    else {
        $decoded_value = $value;
    }
    return $decoded_value;
}

function themesflat_dynamic_sidebar($sidebar) {
    if ( is_active_sidebar ( $sidebar ) ) {
        dynamic_sidebar( $sidebar );        
    } 
}

/**
 * Get post meta, using rwmb_meta() function from Meta Box class
 */
function themesflat_meta( $key,$ID = '') {
    global $post;
    if ( $ID =='' && !is_null($post)) :
        return get_post_meta( $post->ID,$key, true );
    else:
        return get_post_meta($ID,$key,true);
    endif;
}

function themesflat_get_opt( $key ) {
    return get_theme_mod( $key, themesflat_customize_default( $key ) );
}

function themesflat_remove_hook($hook_name, $callback, $priority = 10) {
    $fn = 'remove_filter';
    $fn($hook_name, $callback, $priority);
}


function themesflat_load_page_menu($params) {
    if ( themesflat_meta( 'enable_custom_navigator' ) == 1 && themesflat_meta('menu_location_primary') != false ) {
        if ($params['theme_location'] == 'primary') {
            $params['menu'] = (int)themesflat_meta('menu_location_primary');
        }
    }
    return ($params);
}

add_filter( 'wp_nav_menu_args', 'themesflat_load_page_menu' );

function themesflat_render_social($prefix = '',$value='',$show_title=false) {

    if ($value == '') {
        $value = themesflat_get_json('social_links');
    }

    $class= array();
    $class[] = ($show_title == false ? 'themesflat-socials tf-social-icon tf-social-icon-2 hv-dark' : 'themesflat-widget-socials tf-social-icon-2 hv-dark mb-20');

    if ( ! is_array( $value ) ) {
            $decoded_value = json_decode(str_replace('&quot;', '"', $value), true );
            $value = is_array( $decoded_value ) ? $decoded_value : array();
        }

    $icons = themesflat_available_social_icons();

    ?>
    <ul class="<?php echo esc_attr(implode(" ", $class));?>">
        <?php
        foreach ( $value as $key => $val ) {
            if ($key != '__ordering__') {
                $title = ! empty( $icons[$key]['title'] ) ? $icons[$key]['title'] : ucfirst( $key );
                printf(
                    '<li class="%1$s">
                        <a class="social-item" href="%2$s" target="_blank" rel="noopener noreferrer" aria-label="%5$s">
                            <i class="%4$s"></i>
                        </a>
                    </li>',
                    esc_attr( $key ),
                    esc_url( $val ),
                    esc_attr( $val ),
                    esc_attr( $icons[$key]['iclass'] ),
                    esc_attr($title)
                );
            }
    }
        ?>
    </ul><!-- /.social -->       
    <?php 
}

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function themesflat_pingback_header() {
    if ( is_singular() && pings_open() ) {
        echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
    }
}
add_action( 'wp_head', 'themesflat_pingback_header' );

function themesflat_preload_hook() {
	// Preloader.
	if ( themesflat_get_opt( 'enable_preload' ) == 1 ) {
		?>
		<div class="preload preload-container">
			<div class="preload-logo">
				<div class="spinner type-primary"></div>
			</div>
		</div>
		<?php
	}

	// Scroll to top.
	if ( themesflat_get_opt( 'go_top' ) == 1 ) {
		$is_single_product = class_exists( 'WooCommerce' ) && is_product();
		?>
		<button
			id="goTop"
			class="<?php echo esc_attr( $is_single_product ? 'is-single' : '' ); ?>"
			type="button"
			aria-label="<?php echo esc_attr__( 'Scroll to top', 'ovinx' ); ?>"
		>
			<span class="border-progress" aria-hidden="true"></span>
			<span class="icon icon-CaretUpV2" aria-hidden="true"></span>
		</button>
		<?php
	}
}
add_action( 'wp_body_open', 'themesflat_preload_hook' );

/**
 * wp_kses() allow-list for markup produced by this theme's own templates and captured with ob_start()
 * (product tabs, payment-gateway icons, ...). wp_kses_post() alone would strip things those templates legitimately
 * emit: <img srcset/sizes/loading>, form fields, <svg>, aria-valuenow, and so on.
 */
if ( ! function_exists( 'ovinx_template_html_allowed_tags' ) ) {
	function ovinx_template_html_allowed_tags() {
		static $tags = null;
		if ( null !== $tags ) {
			return $tags;
		}

		$tags = wp_kses_allowed_html( 'post' );

		$extra = array(
			'img'      => array( 'src' => true, 'srcset' => true, 'sizes' => true, 'alt' => true, 'width' => true, 'height' => true, 'loading' => true, 'decoding' => true ),
			'form'     => array( 'action' => true, 'method' => true, 'novalidate' => true, 'enctype' => true ),
			'input'    => array( 'type' => true, 'name' => true, 'value' => true, 'placeholder' => true, 'checked' => true, 'disabled' => true, 'readonly' => true, 'required' => true, 'min' => true, 'max' => true, 'step' => true, 'size' => true, 'maxlength' => true, 'autocomplete' => true, 'inputmode' => true ),
			'select'   => array( 'name' => true, 'multiple' => true, 'required' => true, 'disabled' => true ),
			'option'   => array( 'value' => true, 'selected' => true, 'disabled' => true ),
			'textarea' => array( 'name' => true, 'rows' => true, 'cols' => true, 'placeholder' => true, 'required' => true, 'maxlength' => true ),
			'button'   => array( 'type' => true, 'name' => true, 'value' => true, 'disabled' => true ),
			'label'    => array( 'for' => true ),
			'svg'      => array( 'xmlns' => true, 'width' => true, 'height' => true, 'viewbox' => true, 'fill' => true, 'focusable' => true ),
			'path'     => array( 'd' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true, 'stroke-linecap' => true, 'stroke-linejoin' => true, 'fill-rule' => true, 'clip-rule' => true ),
			'circle'   => array( 'cx' => true, 'cy' => true, 'r' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true ),
			'g'        => array( 'fill' => true, 'clip-path' => true ),
		);

		$global = array(
			'class' => true, 'id' => true, 'style' => true, 'title' => true, 'role' => true, 'dir' => true, 'tabindex' => true, 'hidden' => true,
			'data-*' => true,
			'aria-hidden' => true, 'aria-label' => true, 'aria-labelledby' => true, 'aria-describedby' => true, 'aria-controls' => true,
			'aria-expanded' => true, 'aria-current' => true, 'aria-selected' => true, 'aria-live' => true, 'aria-atomic' => true,
			'aria-haspopup' => true, 'aria-modal' => true, 'aria-required' => true, 'aria-disabled' => true,
			'aria-valuenow' => true, 'aria-valuemin' => true, 'aria-valuemax' => true,
		);

		foreach ( $extra as $tag => $attrs ) {
			$tags[ $tag ] = array_merge( isset( $tags[ $tag ] ) ? (array) $tags[ $tag ] : array(), $attrs );
		}
		foreach ( $tags as $tag => $attrs ) {
			$tags[ $tag ] = array_merge( (array) $attrs, $global );
		}

		return $tags;
	}
}

/**
 * Free-shipping progress bar (text + progress bar) for the mini cart / cart page.
 *
 * Single source for BOTH the first paint (tpl/popup/minicart.php) and the AJAX refresh
 * (Woo_Hook::update_free_shipping_bar_fragments()) — they used to build it separately and drift apart.
 * Returns '' when the bar is switched off, or no enabled "Free shipping" method with a minimum amount
 * exists in the cart's shipping zone (WooCommerce > Settings > Shipping > zone > Free shipping > "A minimum order amount").
 */
if ( ! function_exists( 'ovinx_get_free_shipping_bar' ) ) {
	function ovinx_get_free_shipping_bar() {
		if ( ! function_exists( 'WC' ) || ! WC()->cart || themesflat_get_opt( 'free_shipping_bar' ) != 1 ) {
			return '';
		}

		$cart     = WC()->cart;
		$packages = $cart->get_shipping_packages();
		$package  = reset( $packages );
		if ( ! $package ) { // e.g. a cart with only virtual products has no shipping package
			return '';
		}

		$amount = 0;
		foreach ( wc_get_shipping_zone( $package )->get_shipping_methods( true ) as $method ) {
			if ( 'free_shipping' === $method->id ) {
				$amount = isset( $method->instance_settings['min_amount'] ) ? (float) $method->instance_settings['min_amount'] : 0;
				break;
			}
		}
		if ( $amount <= 0 ) {
			return '';
		}

		$cart_total = (float) $cart->get_displayed_subtotal();
		$remaining  = max( 0, $amount - $cart_total );
		$percent    = round( min( 100, 100 - ( $remaining / $amount ) * 100 ), 2 );

		if ( $cart_total < $amount ) {
			$text = str_replace(
				array( '{currency}', '{total}' ),
				array( get_woocommerce_currency_symbol(), wc_format_decimal( $remaining, wc_get_price_decimals() ) ),
				themesflat_get_opt( 'progress_cart_text' )
			);
		} else {
			// The success text option is a bare string (the progress one carries its own <p class="text">).
			$text = '<p class="text">' . themesflat_get_opt( 'success_cart_text' ) . '</p>';
		}

		ob_start();
		?>
		<div class="free-shipping-text notification-progress">
			<?php echo wp_kses_post( $text ); ?>
			<div class="progress-cart tf-progress-bar tf-progress-ship">
				<div class="value" style="width:0%;" data-progress="<?php echo esc_attr( $percent ); ?>">
					<span class="round2"></span>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

/**
 * Mini cart "threshold" card: free-shipping bar + "N products / Empty cart" row.
 * Rendered inside <div class="tf-mini-cart-threshold"> (the WooCommerce fragment target); '' while the cart is empty.
 * Shared by tpl/popup/minicart.php and Woo_Hook::update_free_shipping_bar_fragments().
 */
if ( ! function_exists( 'ovinx_get_mini_cart_threshold' ) ) {
	function ovinx_get_mini_cart_threshold() {
		if ( ! function_exists( 'WC' ) || ! WC()->cart || WC()->cart->is_empty() ) {
			return '';
		}

		$item_count = WC()->cart->get_cart_contents_count();

		ob_start();
		?>
		<div class="cart-threshold">
			<?php echo ovinx_get_free_shipping_bar(); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped/kses'd where built ?>
			<div class="tf-number-count">
				<p class="fw-medium"><span class="prd-count"><?php echo esc_html( $item_count ); ?></span><?php echo esc_html( _n( ' product', ' products', $item_count, 'ovinx' ) ); ?></p>
				<?php // .tf-clear-cart-btn is the JS hook (shop.js clearMiniCart -> ajax tfwc_clear_cart) ?>
				<a href="javascript:void(0)" class="tf-btn-line style-min text-primary tf-clear-cart-btn">
					<span class="text-caption-01 fw-semibold"><?php esc_html_e( 'EMPTY CART', 'ovinx' ); ?></span>
				</a>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

// Hook popup
function themesflat_popup_hook() {
    if ( themesflat_get_opt( 'header_cart_icon') == 1 ) {
        get_template_part( 'tpl/popup/minicart'); 
    }
    if ( class_exists( 'WCBoost\Wishlist\Helper' ) ) { 
        get_template_part( 'tpl/popup/wishlist');
    }

	$tf_cookies = themesflat_get_opt( 'tf_cookies');
    if (isset($_GET['cookies'])){
		$tf_cookies = sanitize_text_field($_GET['cookies']);
	}
    if ( $tf_cookies == 1 ) {
        get_template_part( 'tpl/popup/cookies');  
    } 

    // get_template_part( 'tpl/popup/search-product');   
}
add_action( 'wp_footer', 'themesflat_popup_hook' );

/* Themesflat Language Switch */
if (! function_exists( 'themesflat_language_switch' )) {
    function themesflat_language_switch(){ ?>
        <div class="flat-language languages">
            <?php if ( ! empty($languages_sidebar) ): ?>
                <?php themesflat_dynamic_sidebar('languages-sidebar'); ?>
            <?php else: ?>
            <ul class="unstyled">
                <li class="current">                    
                    <a href="?lang=en" class="lang_sel_sel">
                        <?php echo esc_html__("English",'ovinx');?><i class="icon-monal-arrow-down" aria-hidden="true"></i>
                    </a>
                    <ul class="unstyled-child">
                       <li class="icl-en">
                            <a href="?lang=en" class="lang_sel_sel">
                             <?php echo esc_html__("English",'ovinx');?>
                            </a>
                       </li>
                       <li class="icl-fr fr">
                            <a href="?lang=fr" class="lang_sel_other">
                             <?php echo esc_html__("French",'ovinx');?>
                            </a>
                       </li>
                       <li class="icl-ge ge">
                            <a href="?lang=it" class="lang_sel_other">
                                <?php echo esc_html__("German",'ovinx');?>
                            </a>
                       </li>
                    </ul>
                </li>
            </ul>
            <?php endif; ?>
        </div>    
    <?php }
}
if (! function_exists( 'themesflat_money_switch' )) {
    function themesflat_money_switch(){ ?>
        <div class="flat-language money">
            <?php if ( ! empty($languages_sidebar) ): ?>
                <?php themesflat_dynamic_sidebar('languages-sidebar'); ?>
            <?php else: ?>
            <ul class="unstyled">
                <li class="current"> 
                    <a href="?currency=USD" class="lang_sel_sel">
                       <?php echo esc_html__("USD",'ovinx');?><i class="icon-monal-arrow-down" aria-hidden="true"></i>
                    </a>  
                    <ul class="unstyled-child">
                       <li >
                            <a href="?currency=USD" class="lang_sel_sel">
                             <?php echo esc_html__("USD",'ovinx');?>
                            </a> 
                       </li>
                       <li >
                            <a href="?currency=EUR" class="lang_sel_other">
                             <?php echo esc_html__("EUR",'ovinx');?>
                             </a> 
                       </li>
                       <li>
                            <a href="?currency=VND" class="lang_sel_other">
                                <?php echo esc_html__("VND",'ovinx');?>
                            </a> 
                       </li>
                    </ul>
                </li>
            </ul>
            <?php endif; ?>
        </div>    
    <?php }
}

function themesflat_kses_allowed_html() {
    $allowed_tags = array(
        'a' => array(
            'class' => array(),
            'href'  => array(),
            'rel'   => array(),
            'title' => array(),
        ),
        'abbr' => array(
            'class' => array(),
            'title' => array(),
        ),
        'b' => array(),
        'blockquote' => array(
            'class' => array(),
            'cite'  => array(),
        ),
        'br' => array(),
        'cite' => array(
            'class' => array(),
            'title' => array(),
        ),
        'code' => array(
            'class' => array(),
        ),
        'del' => array(
            'datetime' => array(),
            'title' => array(),
        ),
        'dd' => array(),
        'div' => array(
            'class' => array(),
            'title' => array(),
            'style' => array(),
        ),
        'dl' => array(
            'class' => array(),
        ),
        'dt' => array(
            'class' => array(),
        ),
        'em' => array(
            'class' => array(),
        ),
        'h1' => array(
            'class' => array(),
            'style' => array(),
        ),
        'h2' => array(
            'class' => array(),
            'style' => array(),
        ),
        'h3' => array(
            'class' => array(),
            'style' => array(),
        ),
        'h4' => array(
            'class' => array(),
            'style' => array(),
        ),
        'h5' => array(
            'class' => array(),
            'style' => array(),
        ),
        'h6' => array(
            'class' => array(),
            'style' => array(),
        ),
        'i' => array(
            'class' => array(),
        ),
        'img' => array(
            'alt'    => array(),
            'class'  => array(),
            'height' => array(),
            'src'    => array(),
            'width'  => array(),
        ),
        'li' => array(
            'class' => array(),
            'style' => array(),
        ),
        'ol' => array(
            'class' => array(),
        ),
        'p' => array(
            'class' => array(),
            'style' => array(),
        ),
        'q' => array(
            'cite' => array(),
            'title' => array(),
            'class' => array(),
        ),
        'span' => array(
            'class' => array(),
            'title' => array(),
            'style' => array(),
        ),
        'strike' => array(
            'class' => array(),
        ),
        'strong' => array(
            'class' => array(),
        ),
        'ul' => array(
            'class' => array(),
            'style' => array(),
        ),
        'input' => array(
            'class' => array(),
            'id' => array(),
            'type' => array(),
            'value' => array(),
            'data-customize-setting-link' => array(),
            'placeholder' => array(),
            'name' => array(),
            'tabindex' => array(),
            'size' => array(),
            'aria-required' => array(),
        ),
        'label' => array(
            'class' => array(),
            'style' => array(),
            'for' => array(),
        ),
    );    
    return $allowed_tags;
}
// add_filter( 'wp_kses_allowed_html', 'themesflat_kses_allowed_html', 10, 2);


function themesflat_layout_draganddrop($blocks) {
    if ( ! is_array( $blocks ) ) {
        $blocks = explode( ',', $blocks );
    }
    $blocks = array_combine( $blocks, $blocks );
    return $blocks;
}


function themesflat_categories_postcount_filter ($variable) {
    $variable = str_replace('</a> (', '<span> (', $variable);
    $variable = str_replace(')', ')</span></a>', $variable);
    return $variable;
}
add_filter('wp_list_categories','themesflat_categories_postcount_filter');

function themesflat_archive_postcount_filter ($variable) {
    $variable = str_replace('</a>&nbsp;(', '<span> (', $variable);
    $variable = str_replace(')', ')</span></a>', $variable);
    return $variable;
}
add_filter('get_archives_link', 'themesflat_archive_postcount_filter');

function themesflat_social_single() {
    if( themesflat_get_opt('show_social_share') == 1 ):
        $value = themesflat_get_json('social_links');
        $sharelink = themesflat_available_social_icons();
        ?>

        <div class="entry_social bottom_social">
            <p class="text-primary"><?php echo esc_html__( 'Share this post:', 'ovinx' ); ?> </p>      
            <ul class="tf-social-icon-2">
                <?php
                    foreach ( $value as $key => $val ) {
                        if ( $key != '__ordering__') {
                            $link = $sharelink[$key]['share_link'].get_the_permalink();
                            $iclass = $sharelink[$key]['iclass'];
                            printf(
                                '<li class="%1$s">
                                    <a href="%2$s" target="_blank" rel="noopener noreferrer" title="%1$s" class="social-item social-'.$key.'"> 
                                        <i class="%4$s"></i>
                                    </a>
                                </li>',
                                esc_attr( $key ),
                                esc_url( $link ),
                                esc_attr( $link ),
                                esc_attr( $iclass )
                            );
                        }
                    }
                ?>
            </ul>
        </div>
        <?php
    endif;
}

function themesflat_get_page_titles() {
    $title = '';
    
    if ( ! is_archive() ) {       
        if ( is_home() ) {
            if ( ! is_front_page() && $page_for_posts = get_option( 'page_for_posts' ) ) {
                $title = get_post_meta( $page_for_posts, 'custom_title', true );
                if ( empty( $title ) ) {
                    $title = get_the_title( $page_for_posts );
                }
            }
            if ( is_front_page() ) {

                    $title = esc_html__('Blog', 'ovinx');
                             
            }
        } 
        elseif ( is_page() ) {
            $title = get_post_meta( get_the_ID(), 'custom_title', true );
            if ( ! $title ) {
                $title = get_the_title();
            }
        } elseif ( is_404() ) {
            $title = esc_html__( '404', 'ovinx' );
        } elseif ( is_search() ) {
            $title = sprintf( esc_html__( 'Search results for &#8220;%s&#8221;', 'ovinx' ), get_search_query() );
        } else {
            $title = get_post_meta( get_the_ID(), 'custom_title', true );
            if ( ! $title ) {
                $title = get_the_title();
            } 

            if (is_single() && get_post_type() == 'post' && themesflat_get_opt('blog_featured_title') != ''){
                $title = themesflat_get_opt('blog_featured_title');
            } elseif(is_single() && get_post_type() == 'services' && themesflat_get_opt('services_featured_title') != ''){                
                $title = themesflat_get_opt('services_featured_title');
            } elseif(is_single() && get_post_type() == 'team' && themesflat_get_opt('team_featured_title') != ''){                
                $title = themesflat_get_opt('team_featured_title');
            }
            
        }
    } else {
        if ( is_author() ) {
            the_post();
            $title = sprintf( esc_html__( 'Author: %s', 'ovinx' ), get_the_author() );
            rewind_posts();
        } elseif ( is_day() ) {
            $title = sprintf( esc_html__( 'Daily: %s', 'ovinx' ), get_the_date() );
        } elseif ( is_month() ) {
            $title = sprintf( esc_html__( 'Monthly: %s', 'ovinx' ), get_the_date( 'F Y' ) );
        } elseif ( is_year() ) {
            $title = sprintf( esc_html__( 'Yearly: %s', 'ovinx' ), get_the_date( 'Y' ) );
        } elseif ( is_search() ) {
            $title = sprintf( esc_html__( 'Search results for &#8220;%s&#8221;', 'ovinx' ), get_search_query() );
        } elseif ( class_exists( 'WooCommerce' ) ) {
            if ( is_shop() ) {
                $title = 'Shop'; 
            } elseif ( is_product_category() ) {
                $title = single_term_title( '', false ); 
            } elseif ( is_product_tag() ) {
                $title = single_term_title( '', false );
            } elseif ( is_tax() || is_category() || is_tag() ) {
                $title = single_term_title( '', false );
            }
        } elseif ( is_tax() || is_category() || is_tag() ) {
            $title = single_term_title( '', false );
        } else {
            $title = get_the_title();
        }
    }

    return array(
        'title' => $title,
    );
}

function themesflat_svg( $icon ) {
    $svg = array(
        'cart' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 34 34">
                        <path d="M6.7,30.2c0,1.1,0.9,2.1,2.1,2.1s2.1-0.9,2.1-2.1c0-1.1-0.9-2.1-2.1-2.1S6.7,29,6.7,30.2z M25.3,30.2
                        c0,1.1,0.9,2.1,2.1,2.1s2.1-0.9,2.1-2.1c0-1.1-0.9-2.1-2.1-2.1S25.3,29,25.3,30.2z M0.5,4.4c0,0.6,0.5,1,1,1h2.1l1.3,5.5l1.8,9
                        c0,0.1,0,0.1,0,0.2l-1.1,4.7c-0.1,0.3,0,0.6,0.2,0.9c0.2,0.2,0.5,0.4,0.8,0.4h23.5c0.6,0,1-0.5,1-1c0-0.6-0.5-1-1-1H8l0.5-2.1
                        c0.1,0,0.2,0.1,0.3,0.1h18.9c1.1,0,1.8-0.2,2.4-1.6l3.4-10.3c0.6-1.8-0.7-2.6-1.8-2.6H6.7c-0.2,0-0.3,0.1-0.5,0.1L5.5,4.1
                        c-0.1-0.5-0.5-0.8-1-0.8h-3C0.9,3.3,0.5,3.8,0.5,4.4z M6.8,9.5h24.6l-3.3,10.1c0,0.1-0.1,0.2-0.1,0.2c-0.1,0-0.2,0-0.3,0H8.8v-0.2
                        l0-0.2L6.8,9.5z"/>
                    </svg>',
        'close' =>            '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16.0673 15.1829C16.1254 15.241 16.1714 15.3099 16.2028 15.3858C16.2343 15.4617 16.2505 15.543 16.2505 15.6251C16.2505 15.7072 16.2343 15.7885 16.2028 15.8644C16.1714 15.9403 16.1254 16.0092 16.0673 16.0673C16.0092 16.1254 15.9403 16.1714 15.8644 16.2028C15.7885 16.2343 15.7072 16.2505 15.6251 16.2505C15.543 16.2505 15.4617 16.2343 15.3858 16.2028C15.3099 16.1714 15.241 16.1254 15.1829 16.0673L10.0001 10.8837L4.81729 16.0673C4.70002 16.1846 4.54096 16.2505 4.3751 16.2505C4.20925 16.2505 4.05019 16.1846 3.93292 16.0673C3.81564 15.95 3.74976 15.791 3.74976 15.6251C3.74976 15.4593 3.81564 15.3002 3.93292 15.1829L9.11651 10.0001L3.93292 4.81729C3.81564 4.70002 3.74976 4.54096 3.74976 4.3751C3.74976 4.20925 3.81564 4.05019 3.93292 3.93292C4.05019 3.81564 4.20925 3.74976 4.3751 3.74976C4.54096 3.74976 4.70002 3.81564 4.81729 3.93292L10.0001 9.11651L15.1829 3.93292C15.3002 3.81564 15.4593 3.74976 15.6251 3.74976C15.791 3.74976 15.95 3.81564 16.0673 3.93292C16.1846 4.05019 16.2505 4.20925 16.2505 4.3751C16.2505 4.54096 16.1846 4.70002 16.0673 4.81729L10.8837 10.0001L16.0673 15.1829Z" fill="#333E48"/>
                    </svg>',
        'shopft' =>'<svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.25 9C22.2504 8.93027 22.2409 8.86083 22.2219 8.79375L20.8766 4.0875C20.7861 3.77523 20.5971 3.50059 20.3378 3.30459C20.0784 3.10858 19.7626 3.00174 19.4375 3H5.5625C5.23741 3.00174 4.9216 3.10858 4.66223 3.30459C4.40287 3.50059 4.21386 3.77523 4.12344 4.0875L2.77906 8.79375C2.7597 8.86079 2.74991 8.93022 2.75 9V10.5C2.75 11.0822 2.88554 11.6563 3.1459 12.1771C3.40625 12.6978 3.78427 13.1507 4.25 13.5V19.5C4.25 19.8978 4.40804 20.2794 4.68934 20.5607C4.97064 20.842 5.35218 21 5.75 21H19.25C19.6478 21 20.0294 20.842 20.3107 20.5607C20.592 20.2794 20.75 19.8978 20.75 19.5V13.5C21.2157 13.1507 21.5937 12.6978 21.8541 12.1771C22.1145 11.6563 22.25 11.0822 22.25 10.5V9ZM5.5625 4.5H19.4375L20.5081 8.25H4.49469L5.5625 4.5ZM10.25 9.75H14.75V10.5C14.75 11.0967 14.5129 11.669 14.091 12.091C13.669 12.5129 13.0967 12.75 12.5 12.75C11.9033 12.75 11.331 12.5129 10.909 12.091C10.4871 11.669 10.25 11.0967 10.25 10.5V9.75ZM8.75 9.75V10.5C8.75 11.0967 8.51295 11.669 8.09099 12.091C7.66903 12.5129 7.09674 12.75 6.5 12.75C5.90326 12.75 5.33097 12.5129 4.90901 12.091C4.48705 11.669 4.25 11.0967 4.25 10.5V9.75H8.75ZM19.25 19.5H5.75V14.175C5.9969 14.2248 6.24813 14.2499 6.5 14.25C7.08217 14.25 7.65634 14.1145 8.17705 13.8541C8.69776 13.5937 9.1507 13.2157 9.5 12.75C9.8493 13.2157 10.3022 13.5937 10.823 13.8541C11.3437 14.1145 11.9178 14.25 12.5 14.25C13.0822 14.25 13.6563 14.1145 14.1771 13.8541C14.6978 13.5937 15.1507 13.2157 15.5 12.75C15.8493 13.2157 16.3022 13.5937 16.8229 13.8541C17.3437 14.1145 17.9178 14.25 18.5 14.25C18.7519 14.2499 19.0031 14.2248 19.25 14.175V19.5ZM18.5 12.75C17.9033 12.75 17.331 12.5129 16.909 12.091C16.4871 11.669 16.25 11.0967 16.25 10.5V9.75H20.75V10.5C20.75 11.0967 20.5129 11.669 20.091 12.091C19.669 12.5129 19.0967 12.75 18.5 12.75Z" fill="#333E48"/>
                    </svg>',
        'wishlistft' =>'<svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21.4064 5.34377C20.3874 4.32738 19.0075 3.75582 17.5683 3.75406C16.1291 3.7523 14.7478 4.3205 13.7264 5.33439L12.5001 6.47345L11.2729 5.33064C10.2518 4.31233 8.8679 3.74139 7.42577 3.74341C5.98365 3.74544 4.60139 4.32026 3.58308 5.34142C2.56478 6.36259 1.99383 7.74645 1.99585 9.18858C1.99788 10.6307 2.5727 12.013 3.59386 13.0313L11.9704 21.5306C12.0402 21.6015 12.1234 21.6578 12.2151 21.6962C12.3069 21.7346 12.4053 21.7544 12.5048 21.7544C12.6043 21.7544 12.7027 21.7346 12.7945 21.6962C12.8862 21.6578 12.9694 21.6015 13.0392 21.5306L21.4064 13.0313C22.4254 12.0116 22.9978 10.6291 22.9978 9.18752C22.9978 7.74596 22.4254 6.3634 21.4064 5.34377ZM20.3423 11.9775L12.5001 19.9313L4.65324 11.97C3.91478 11.2316 3.49991 10.23 3.49991 9.18564C3.49991 8.1413 3.91478 7.13973 4.65324 6.40127C5.3917 5.6628 6.39327 5.24794 7.43761 5.24794C8.48196 5.24794 9.48353 5.6628 10.222 6.40127L10.2407 6.42002L11.9892 8.04658C12.128 8.17574 12.3105 8.24754 12.5001 8.24754C12.6897 8.24754 12.8723 8.17574 13.0111 8.04658L14.7595 6.42002L14.7782 6.40127C15.5172 5.6633 16.519 5.24911 17.5634 5.24982C18.6077 5.25052 19.609 5.66606 20.347 6.40502C21.085 7.14398 21.4991 8.14582 21.4984 9.19017C21.4977 10.2345 21.0822 11.2358 20.3432 11.9738L20.3423 11.9775Z" fill="#333E48"/>
                    </svg>',
        'cartft' =>'<svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_3044_24968)">
                        <path d="M9.5 20.25C9.5 20.5467 9.41203 20.8367 9.2472 21.0834C9.08238 21.33 8.84811 21.5223 8.57403 21.6358C8.29994 21.7494 7.99834 21.7791 7.70736 21.7212C7.41639 21.6633 7.14912 21.5204 6.93934 21.3107C6.72956 21.1009 6.5867 20.8336 6.52882 20.5426C6.47094 20.2517 6.50065 19.9501 6.61418 19.676C6.72771 19.4019 6.91997 19.1676 7.16665 19.0028C7.41332 18.838 7.70333 18.75 8 18.75C8.39782 18.75 8.77936 18.908 9.06066 19.1893C9.34196 19.4706 9.5 19.8522 9.5 20.25ZM17.75 18.75C17.4533 18.75 17.1633 18.838 16.9166 19.0028C16.67 19.1676 16.4777 19.4019 16.3642 19.676C16.2506 19.9501 16.2209 20.2517 16.2788 20.5426C16.3367 20.8336 16.4796 21.1009 16.6893 21.3107C16.8991 21.5204 17.1664 21.6633 17.4574 21.7212C17.7483 21.7791 18.0499 21.7494 18.324 21.6358C18.5981 21.5223 18.8324 21.33 18.9972 21.0834C19.162 20.8367 19.25 20.5467 19.25 20.25C19.25 19.8522 19.092 19.4706 18.8107 19.1893C18.5294 18.908 18.1478 18.75 17.75 18.75ZM22.2172 6.97031L19.5425 15.6619C19.4024 16.1226 19.1175 16.5259 18.7301 16.812C18.3427 17.0981 17.8734 17.2517 17.3919 17.25H8.38156C7.8931 17.2482 7.41837 17.0882 7.02848 16.7939C6.63858 16.4997 6.35449 16.087 6.21875 15.6178L2.82687 3.75H1.25C1.05109 3.75 0.860322 3.67098 0.71967 3.53033C0.579018 3.38968 0.5 3.19891 0.5 3C0.5 2.80109 0.579018 2.61032 0.71967 2.46967C0.860322 2.32902 1.05109 2.25 1.25 2.25H2.82687C3.15257 2.25108 3.46916 2.35761 3.72925 2.55365C3.98934 2.74969 4.17895 3.0247 4.26969 3.3375L5.03 6H21.5C21.6174 5.99996 21.7331 6.02746 21.8379 6.08029C21.9427 6.13313 22.0336 6.20982 22.1034 6.30421C22.1732 6.39859 22.2198 6.50803 22.2396 6.62372C22.2593 6.73941 22.2517 6.85812 22.2172 6.97031ZM20.4847 7.5H5.45844L7.66062 15.2062C7.70543 15.3629 7.80002 15.5007 7.93009 15.5988C8.06016 15.6969 8.21864 15.75 8.38156 15.75H17.3919C17.5524 15.7501 17.7086 15.6986 17.8377 15.6033C17.9668 15.508 18.0619 15.3737 18.1091 15.2203L20.4847 7.5Z" fill="#333E48"/>
                        </g>
                        <defs>
                        <clipPath id="clip0_3044_24968">
                        <rect width="24" height="24" fill="white" transform="translate(0.5)"/>
                        </clipPath>
                        </defs>
                    </svg>',
        'accountft' =>'<svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20.1486 17.8751C18.7208 15.4067 16.5205 13.6367 13.9527 12.7976C15.2229 12.0415 16.2097 10.8893 16.7617 9.51804C17.3136 8.14678 17.4002 6.63224 17.0081 5.20701C16.616 3.78178 15.7668 2.52467 14.5911 1.62873C13.4154 0.732786 11.9781 0.247559 10.4999 0.247559C9.0217 0.247559 7.58438 0.732786 6.40866 1.62873C5.23294 2.52467 4.38382 3.78178 3.99171 5.20701C3.59959 6.63224 3.68616 8.14678 4.23813 9.51804C4.79009 10.8893 5.77692 12.0415 7.04708 12.7976C4.47926 13.6357 2.27895 15.4057 0.851138 17.8751C0.798777 17.9605 0.764047 18.0555 0.748996 18.1545C0.733945 18.2535 0.738878 18.3545 0.763504 18.4516C0.78813 18.5487 0.831951 18.6399 0.89238 18.7197C0.952809 18.7996 1.02862 18.8666 1.11535 18.9167C1.20207 18.9667 1.29795 18.999 1.39733 19.0114C1.49671 19.0238 1.59757 19.0163 1.69397 18.9891C1.79037 18.9619 1.88034 18.9157 1.95859 18.8532C2.03684 18.7907 2.10178 18.7131 2.14958 18.6251C3.91583 15.5726 7.0377 13.7501 10.4999 13.7501C13.9621 13.7501 17.084 15.5726 18.8502 18.6251C18.898 18.7131 18.9629 18.7907 19.0412 18.8532C19.1194 18.9157 19.2094 18.9619 19.3058 18.9891C19.4022 19.0163 19.5031 19.0238 19.6024 19.0114C19.7018 18.999 19.7977 18.9667 19.8844 18.9167C19.9712 18.8666 20.047 18.7996 20.1074 18.7197C20.1678 18.6399 20.2116 18.5487 20.2363 18.4516C20.2609 18.3545 20.2658 18.2535 20.2508 18.1545C20.2357 18.0555 20.201 17.9605 20.1486 17.8751ZM5.24989 7.00011C5.24989 5.96176 5.55779 4.94672 6.13467 4.08337C6.71155 3.22001 7.53149 2.5471 8.4908 2.14974C9.45011 1.75238 10.5057 1.64841 11.5241 1.85099C12.5425 2.05356 13.478 2.55357 14.2122 3.2878C14.9464 4.02202 15.4464 4.95748 15.649 5.97589C15.8516 6.99429 15.7476 8.04989 15.3503 9.0092C14.9529 9.96851 14.28 10.7884 13.4166 11.3653C12.5533 11.9422 11.5382 12.2501 10.4999 12.2501C9.10796 12.2486 7.77347 11.695 6.78922 10.7108C5.80498 9.72653 5.25138 8.39204 5.24989 7.00011Z" fill="#333E48"/>
                        </svg>',
        'searchft' =>'<svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20.0306 18.4693L15.3365 13.7762C16.6971 12.1428 17.3755 10.0478 17.2307 7.92691C17.0859 5.80604 16.129 3.82265 14.5591 2.38932C12.9892 0.955989 10.9271 0.183083 8.80188 0.231383C6.67663 0.279683 4.65181 1.14547 3.14864 2.64864C1.64547 4.15181 0.779683 6.17663 0.731383 8.30188C0.683083 10.4271 1.45599 12.4892 2.88932 14.0591C4.32265 15.629 6.30604 16.5859 8.42691 16.7307C10.5478 16.8755 12.6428 16.1971 14.2762 14.8365L18.9693 19.5306C19.039 19.6003 19.1218 19.6556 19.2128 19.6933C19.3038 19.731 19.4014 19.7504 19.5 19.7504C19.5985 19.7504 19.6961 19.731 19.7871 19.6933C19.8782 19.6556 19.9609 19.6003 20.0306 19.5306C20.1003 19.4609 20.1556 19.3782 20.1933 19.2871C20.231 19.1961 20.2504 19.0985 20.2504 19C20.2504 18.9014 20.231 18.8038 20.1933 18.7128C20.1556 18.6218 20.1003 18.539 20.0306 18.4693ZM2.24997 8.49997C2.24997 7.16495 2.64585 5.8599 3.38755 4.74987C4.12925 3.63984 5.18346 2.77467 6.41686 2.26378C7.65026 1.75289 9.00746 1.61922 10.3168 1.87967C11.6262 2.14012 12.8289 2.78299 13.7729 3.727C14.7169 4.671 15.3598 5.87374 15.6203 7.18311C15.8807 8.49248 15.7471 9.84968 15.2362 11.0831C14.7253 12.3165 13.8601 13.3707 12.7501 14.1124C11.64 14.8541 10.335 15.25 8.99997 15.25C7.21037 15.248 5.49463 14.5362 4.22919 13.2708C2.96375 12.0053 2.25196 10.2896 2.24997 8.49997Z" fill="#333E48"/>
                        </svg>',
        'admin' =>  '<svg width="22" height="23" viewBox="0 0 22 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.9998 11.5283C5.20222 11.5283 0.485352 16.2452 0.485352 22.0428C0.485352 22.2952 0.69017 22.5 0.942518 22.5C1.19487 22.5 1.39968 22.2952 1.39968 22.0428C1.39968 16.749 5.70606 12.4426 10.9999 12.4426C16.2937 12.4426 20.6001 16.749 20.6001 22.0428C20.6001 22.2952 20.8049 22.5 21.0572 22.5C21.3096 22.5 21.5144 22.2952 21.5144 22.0428C21.5144 16.2443 16.7975 11.5283 10.9998 11.5283Z" fill="#333E48" stroke="#333E48" stroke-width="0.3"/>
                    <path d="M10.9999 0.5C8.22767 0.5 5.97119 2.75557 5.97119 5.52866C5.97119 8.30174 8.22771 10.5573 10.9999 10.5573C13.772 10.5573 16.0285 8.30174 16.0285 5.52866C16.0285 2.75557 13.772 0.5 10.9999 0.5ZM10.9999 9.64303C8.73146 9.64303 6.88548 7.79705 6.88548 5.52866C6.88548 3.26027 8.73146 1.41429 10.9999 1.41429C13.2682 1.41429 15.1142 3.26027 15.1142 5.52866C15.1142 7.79705 13.2682 9.64303 10.9999 9.64303Z" fill="#333E48" stroke="#333E48" stroke-width="0.3"/>
                    </svg>',
        'search' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 34 34">
                        <path d="M20.3,0.9c-7.2,0-13,5.8-13,13c0,3.1,1.1,5.9,2.9,8.2l-8.6,8.6c-0.5,0.5-0.5,1.4,0,2s1.4,0.5,2,0l8.6-8.6
                        c2.2,1.8,5.1,2.9,8.2,2.9c7.2,0,13-5.8,13-13S27.5,0.9,20.3,0.9z M20.3,24.9c-6.1,0-11-4.9-11-11s4.9-11,11-11s11,4.9,11,11
                        S26.4,24.9,20.3,24.9z"/>
                    </svg>',
        'menu' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path d="M28.5,4.5h-27C0.7,4.5,0,3.8,0,3s0.7-1.5,1.5-1.5h27C29.3,1.5,30,2.2,30,3S29.3,4.5,28.5,4.5z
                         M15,13.5H1.5C0.7,13.5,0,12.8,0,12s0.7-1.5,1.5-1.5H15c0.8,0,1.5,0.7,1.5,1.5S15.8,13.5,15,13.5z M28.5,22.5h-27
                        C0.7,22.5,0,21.8,0,21s0.7-1.5,1.5-1.5h27c0.8,0,1.5,0.7,1.5,1.5S29.3,22.5,28.5,22.5z"/>
                    </svg>',
        'wishlist' => '<svg version="1.0" xmlns="http://www.w3.org/2000/svg"
                             width="240.000000pt" height="220.000000pt" viewBox="0 0 240.000000 220.000000">
                            <g transform="translate(0.000000,220.000000) scale(0.100000,-0.100000)" stroke="none">
                            <path d="M487 2185 c-160 -33 -322 -145 -400 -276 -61 -104 -81 -184 -81 -324
                            0 -109 3 -128 33 -215 54 -159 152 -316 319 -512 52 -62 263 -282 469 -488
                            l373 -375 373 375 c206 206 417 426 469 488 167 196 265 353 319 512 30 87 33
                            106 33 215 0 95 -4 134 -22 190 -30 96 -86 187 -155 252 -74 68 -140 106 -242
                            140 -67 22 -99 26 -195 27 -128 0 -198 -14 -301 -63 -83 -39 -188 -126 -236
                            -195 -21 -31 -40 -55 -43 -56 -3 0 -17 20 -33 44 -62 98 -196 196 -328 240
                            -103 35 -248 43 -352 21z m258 -99 c174 -41 315 -157 406 -331 24 -46 46 -85
                            49 -85 3 0 18 26 34 58 67 137 168 245 286 306 90 46 151 61 250 61 301 -2
                            508 -188 527 -475 15 -226 -114 -465 -451 -832 -144 -157 -631 -638 -646 -638
                            -15 0 -500 479 -646 638 -262 285 -402 503 -441 685 -27 127 -3 285 59 386
                            111 179 358 277 573 227z"/>
                            </g>
                            </svg>',
        'quickview' => '<svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21.2532 10.7216C21.2231 10.6537 20.4952 9.03891 18.877 7.4207C16.7209 5.26453 13.9975 4.125 11 4.125C8.00249 4.125 5.27913 5.26453 3.12296 7.4207C1.50476 9.03891 0.773429 10.6562 0.746789 10.7216C0.707698 10.8095 0.6875 10.9046 0.6875 11.0009C0.6875 11.0971 0.707698 11.1922 0.746789 11.2802C0.776867 11.348 1.50476 12.962 3.12296 14.5802C5.27913 16.7355 8.00249 17.875 11 17.875C13.9975 17.875 16.7209 16.7355 18.877 14.5802C20.4952 12.962 21.2231 11.348 21.2532 11.2802C21.2923 11.1922 21.3125 11.0971 21.3125 11.0009C21.3125 10.9046 21.2923 10.8095 21.2532 10.7216ZM11 16.5C8.35484 16.5 6.04398 15.5384 4.13101 13.6426C3.34609 12.862 2.67831 11.9719 2.14843 11C2.67817 10.028 3.34597 9.13789 4.13101 8.35742C6.04398 6.46164 8.35484 5.5 11 5.5C13.6451 5.5 15.956 6.46164 17.869 8.35742C18.6554 9.1377 19.3247 10.0278 19.8559 11C19.2362 12.1567 16.5369 16.5 11 16.5ZM11 6.875C10.1841 6.875 9.38662 7.11693 8.70826 7.57019C8.02991 8.02345 7.5012 8.66769 7.18899 9.42143C6.87678 10.1752 6.79509 11.0046 6.95425 11.8047C7.11342 12.6049 7.50628 13.3399 8.08318 13.9168C8.66007 14.4937 9.39507 14.8866 10.1952 15.0457C10.9954 15.2049 11.8248 15.1232 12.5786 14.811C13.3323 14.4988 13.9765 13.9701 14.4298 13.2917C14.8831 12.6134 15.125 11.8158 15.125 11C15.1239 9.90633 14.6889 8.85778 13.9156 8.08444C13.1422 7.3111 12.0937 6.87614 11 6.875ZM11 13.75C10.4561 13.75 9.92441 13.5887 9.47217 13.2865C9.01994 12.9844 8.66746 12.5549 8.45932 12.0524C8.25118 11.5499 8.19672 10.9969 8.30283 10.4635C8.40894 9.93005 8.67085 9.44005 9.05545 9.05546C9.44004 8.67086 9.93005 8.40895 10.4635 8.30284C10.9969 8.19673 11.5499 8.25119 12.0524 8.45933C12.5549 8.66747 12.9844 9.01995 13.2865 9.47218C13.5887 9.92442 13.75 10.4561 13.75 11C13.75 11.7293 13.4603 12.4288 12.9445 12.9445C12.4288 13.4603 11.7293 13.75 11 13.75Z" fill="black"/>
                        </svg>',
        'wishlist2' => '<svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12.9062 0.5C11.293 0.5 9.88047 1.19375 9 2.36641C8.11953 1.19375 6.70703 0.5 5.09375 0.5C3.80955 0.501447 2.57837 1.01223 1.6703 1.9203C0.762235 2.82837 0.251447 4.05955 0.25 5.34375C0.25 10.8125 8.35859 15.2391 8.70391 15.4219C8.79492 15.4708 8.89665 15.4965 9 15.4965C9.10335 15.4965 9.20508 15.4708 9.29609 15.4219C9.64141 15.2391 17.75 10.8125 17.75 5.34375C17.7486 4.05955 17.2378 2.82837 16.3297 1.9203C15.4216 1.01223 14.1904 0.501447 12.9062 0.5ZM9 14.1562C7.57344 13.325 1.5 9.53828 1.5 5.34375C1.50124 4.39101 1.88026 3.47765 2.55396 2.80396C3.22765 2.13026 4.14101 1.75124 5.09375 1.75C6.61328 1.75 7.88906 2.55938 8.42188 3.85938C8.46896 3.97401 8.54907 4.07205 8.65201 4.14105C8.75494 4.21005 8.87607 4.2469 9 4.2469C9.12393 4.2469 9.24506 4.21005 9.34799 4.14105C9.45093 4.07205 9.53104 3.97401 9.57812 3.85938C10.1109 2.55703 11.3867 1.75 12.9062 1.75C13.859 1.75124 14.7724 2.13026 15.446 2.80396C16.1197 3.47765 16.4988 4.39101 16.5 5.34375C16.5 9.53203 10.425 13.3242 9 14.1562Z" fill="black"/>
                        </svg>',
        'compare' => '<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M13.6922 11.1922L11.1922 13.6922C11.0749 13.8094 10.9159 13.8753 10.75 13.8753C10.5842 13.8753 10.4251 13.8094 10.3078 13.6922C10.1905 13.5749 10.1247 13.4158 10.1247 13.25C10.1247 13.0841 10.1905 12.9251 10.3078 12.8078L11.7414 11.375H0.750003C0.584243 11.375 0.425272 11.3091 0.308062 11.1919C0.190852 11.0747 0.125003 10.9157 0.125003 10.75C0.125003 10.5842 0.190852 10.4253 0.308062 10.308C0.425272 10.1908 0.584243 10.125 0.750003 10.125H11.7414L10.3078 8.69217C10.1905 8.57489 10.1247 8.41583 10.1247 8.24998C10.1247 8.08413 10.1905 7.92507 10.3078 7.80779C10.4251 7.69052 10.5842 7.62463 10.75 7.62463C10.9159 7.62463 11.0749 7.69052 11.1922 7.80779L13.6922 10.3078C13.7503 10.3658 13.7964 10.4348 13.8279 10.5106C13.8593 10.5865 13.8755 10.6678 13.8755 10.75C13.8755 10.8321 13.8593 10.9134 13.8279 10.9893C13.7964 11.0652 13.7503 11.1341 13.6922 11.1922ZM2.80782 6.19217C2.92509 6.30944 3.08415 6.37533 3.25 6.37533C3.41586 6.37533 3.57492 6.30944 3.69219 6.19217C3.80947 6.07489 3.87535 5.91583 3.87535 5.74998C3.87535 5.58413 3.80947 5.42507 3.69219 5.30779L2.2586 3.87498H13.25C13.4158 3.87498 13.5747 3.80913 13.6919 3.69192C13.8092 3.57471 13.875 3.41574 13.875 3.24998C13.875 3.08422 13.8092 2.92525 13.6919 2.80804C13.5747 2.69083 13.4158 2.62498 13.25 2.62498H2.2586L3.69219 1.19217C3.80947 1.07489 3.87535 0.915834 3.87535 0.749981C3.87535 0.584129 3.80947 0.425069 3.69219 0.307794C3.57492 0.190518 3.41586 0.124634 3.25 0.124634C3.08415 0.124634 2.92509 0.190518 2.80782 0.307794L0.307816 2.80779C0.249706 2.86584 0.203606 2.93477 0.172154 3.01064C0.140701 3.08652 0.124512 3.16785 0.124512 3.24998C0.124512 3.33212 0.140701 3.41345 0.172154 3.48932C0.203606 3.56519 0.249706 3.63412 0.307816 3.69217L2.80782 6.19217Z" fill="black"/>
                        </svg>',
        'compare2' =>                '<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26" fill="none">
                        <g clip-path="url(#clip0_2306_17912)">
                        <path d="M7.85714 10.4286L4.42857 13.8572L1 10.4286" stroke="#333E48" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M18.1429 15.625L21.5714 12.1964L25 15.625" stroke="#333E48" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M7 20.7142C7 19.2941 5.84874 18.1428 4.42858 18.1428C3.00841 18.1428 1.85715 19.2941 1.85715 20.7142C1.85715 22.1344 3.00841 23.2856 4.42858 23.2856C5.84874 23.2856 7 22.1344 7 20.7142Z" stroke="#333E48" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M24.1429 5.28575C24.1429 3.86559 22.9916 2.71432 21.5714 2.71432C20.1513 2.71432 19 3.86559 19 5.28575C19 6.70591 20.1513 7.85718 21.5714 7.85718C22.9916 7.85718 24.1429 6.70591 24.1429 5.28575Z" stroke="#333E48" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M4.42856 13L4.42856 8.5C4.42856 7.64752 4.76721 6.82995 5.37 6.22716C5.9728 5.62436 6.79036 5.28571 7.64284 5.28571L19 5.28571" stroke="#333E48" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M21.5714 13.0535L21.5714 17.5535C21.5714 18.406 21.2328 19.2236 20.63 19.8264C20.0272 20.4292 19.2096 20.7678 18.3571 20.7678L7 20.7678" stroke="#333E48" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                        </g>
                        <defs>
                        <clipPath id="clip0_2306_17912">
                        <rect width="26" height="26" fill="white" transform="translate(0 26) rotate(-90)"/>
                        </clipPath>
                        </defs>
                        </svg>',
        '360deg' =>   '<svg height="512pt" viewBox="0 -66 512.001 512" width="512pt" xmlns="http://www.w3.org/2000/svg"><path d="m322.285156 335.644531c-7.441406 0-13.898437-5.  53125-14.863281-13.105469-1.042969-8.21875 4.769531-15.726562 12.984375-16.773437 47.398438-6.039063 89.84375-18.882813 119.515625-36.171875 27.136719-15.808594 42.078125-34.394531 42.078125-52.332031 0-19.769531-17.484375-35.945313-32.15625-46.039063-6.824219-4.695312-8.550781-14.03125-3.855469-20.859375 4.695313-6.824219 14.035157-8.550781 20.859375-3.855469 29.539063 20.320313 45.152344 44.785157 45.152344 70.757813 0 29.476563-19.699219 56.535156-56.972656 78.25-33.550782 19.546875-78.789063 33.382813-130.828125 40.011719-.644531.078125-1.285157.117187-1.914063.117187zm0 0"/><path d="m252.34375 314.15625-40-40c-5.859375-5.859375-15.355469-5.859375-21.214844 0-5.855468 5.855469-5.855468 15.355469 0 21.210938l11.6875 11.6875c-44.8125-4.628907-85.523437-15.0625-117.046875-30.222657-35.441406-17.042969-55.769531-38.757812-55.769531-59.570312 0-17.652344 14.554688-36 40.980469-51.664063 7.128906-4.222656 9.480469-13.425781 5.257812-20.550781-4.226562-7.128906-13.429687-9.480469-20.554687-5.257813-46.023438 27.28125-55.683594 57.1875-55.683594 77.472657 0 33.28125 25.84375 64.039062 72.769531 86.609375 36.421875 17.511718 83.535157 29.242187 134.863281 33.78125l-16.503906 16.503906c-5.855468 5.855469-5.855468 15.355469 0 21.214844 2.929688 2.925781 6.769532 4.390625 10.609375 4.390625 3.835938 0 7.675781-1.464844 10.605469-4.390625l40-40c5.855469-5.859375 5.855469-15.359375 0-21.214844zm0 0"/><path d="m157.097656 187.222656v-3.609375c0-12.730469-7.792968-15.199219-18.242187-15.199219-6.460938 0-8.550781-5.699218-8.550781-11.398437 0-5.703125 2.089843-11.402344 8.550781-11.402344 7.21875 0 14.820312-.949219 14.820312-16.339843 0-11.019532-6.269531-13.679688-14.0625-13.679688-9.308593 0-14.058593 2.28125-14.058593 9.691406 0 6.457032-2.851563 10.828125-13.871094 10.828125-13.679688 0-15.386719-2.851562-15.386719-11.972656 0-14.816406 10.636719-34.007813 43.316406-34.007813 24.132813 0 42.371094 8.738282 42.371094 34.390626 0 13.867187-5.128906 26.789062-14.628906 31.160156 11.210937 4.179687 19.378906 12.539062 19.378906 27.929687v3.609375c0 31.160156-21.46875 42.941406-48.070313 42.941406-32.679687 0-45.21875-19.949218-45.21875-35.910156 0-8.550781 3.609376-10.832031 14.058594-10.832031 12.160156 0 15.199219 2.660156 15.199219 9.882813 0 8.929687 8.363281 11.019531 16.910156 11.019531 12.921875 0 17.484375-4.75 17.484375-17.101563zm0 0"/><path d="m302.066406 183.613281v1.710938c0 32.679687-20.332031 44.839843-46.550781 44.839843s-46.742187-12.160156-46.742187-44.839843v-50.351563c0-32.679687 21.089843-44.839844 48.453124-44.839844 32.109376 0 44.839844 19.949219 44.839844 35.71875 0 9.121094-4.371094 11.96875-13.871094 11.96875-8.167968 0-15.390624-2.089843-15.390624-10.828124 0-7.21875-7.597657-11.019532-16.527344-11.019532-11.210938 0-17.863282 5.890625-17.863282 19v17.097656c6.082032-6.648437 14.632813-8.359374 23.753907-8.359374 21.65625 0 39.898437 9.5 39.898437 39.902343zm-63.652344 3.800781c0 13.109376 6.460938 18.808594 17.101563 18.808594s16.910156-5.699218 16.910156-18.808594v-1.710937c0-13.871094-6.269531-19.191406-17.101562-19.191406-10.257813 0-16.910157 4.941406-16.910157 17.480469zm0 0"/><path d="m325.054688 185.324219v-50.351563c0-32.679687 20.328124-44.839844 46.550781-44.839844 26.21875 0 46.738281 12.160157 46.738281 44.839844v50.351563c0 32.679687-20.519531 44.839843-46.738281 44.839843-26.222657 0-46.550781-12.160156-46.550781-44.839843zm63.648437-50.351563c0-13.109375-6.457031-19-17.097656-19s-16.910157 5.890625-16.910157 19v50.351563c0 13.109375 6.269532 19 16.910157 19s17.097656-5.890625 17.097656-19zm0 0"/><path d="m454.351562 90c-24.816406 0-45-20.1875-45-45s20.183594-45 45-45c24.8125 0 45 20.1875 45 45s-20.1875 45-45 45zm0-60c-8.273437 0-15 6.730469-15 15 0 8.273438 6.726563 15 15 15 8.269532 0 15-6.726562 15-15 0-8.269531-6.730468-15-15-15zm0 0"/></svg>',
        'wishlist_all'=>'<svg width="26" height="27" viewBox="0 0 26 27" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M18.1949 2.73732C16.1929 2.72573 14.2896 3.67827 13 5.33729C11.7184 3.66693 9.80988 2.71168 7.80503 2.73732C4.0467 2.73732 1 6.03791 1 10.1094C1 17.0867 12.2405 23.8993 12.6962 24.1626C12.8801 24.2957 13.1199 24.2957 13.3038 24.1626C13.7595 23.8993 25 17.1854 25 10.1094C25 6.03791 21.9532 2.73732 18.1949 2.73732ZM13 22.8461C11.2379 21.7272 2.21519 15.7702 2.21519 10.1094C2.21519 6.765 4.71785 4.05371 7.80508 4.05371C9.69561 4.02682 11.4648 5.05986 12.4836 6.78534C12.6904 7.09433 13.0893 7.16318 13.3746 6.93905C13.4291 6.89621 13.477 6.84437 13.5164 6.78534C15.206 3.98618 18.6702 3.20077 21.2541 5.03107C22.8358 6.15155 23.7879 8.06199 23.7848 10.1094C23.7848 15.836 14.762 21.7601 13 22.8461Z" fill="currentColor" stroke="currentColor" stroke-width="1"/>
        </svg>',
        'admin_all'=>'<svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M11.9998 12.5283C6.20222 12.5283 1.48535 17.2452 1.48535 23.0428C1.48535 23.2952 1.69017 23.5 1.94252 23.5C2.19487 23.5 2.39968 23.2952 2.39968 23.0428C2.39968 17.749 6.70606 13.4426 11.9999 13.4426C17.2937 13.4426 21.6001 17.749 21.6001 23.0428C21.6001 23.2952 21.8049 23.5 22.0572 23.5C22.3096 23.5 22.5144 23.2952 22.5144 23.0428C22.5144 17.2443 17.7975 12.5283 11.9998 12.5283Z" fill="currentColor" stroke="currentColor" stroke-width="1"/>
            <path d="M12.0003 1.5C9.22815 1.5 6.97168 3.75557 6.97168 6.52866C6.97168 9.30174 9.2282 11.5573 12.0003 11.5573C14.7725 11.5573 17.029 9.30174 17.029 6.52866C17.029 3.75557 14.7725 1.5 12.0003 1.5ZM12.0003 10.643C9.73195 10.643 7.88597 8.79705 7.88597 6.52866C7.88597 4.26027 9.73195 2.41429 12.0003 2.41429C14.2687 2.41429 16.1147 4.26027 16.1147 6.52866C16.1147 8.79705 14.2687 10.643 12.0003 10.643Z" fill="currentColor" stroke="currentColor" stroke-width="1"/>
        </svg>',
        'cart_all'=>'<svg width="28" height="27" viewBox="0 0 28 27" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M9.55865 19.6096C7.8483 19.6096 6.46191 20.996 6.46191 22.7064C6.46191 24.4165 7.8483 25.8029 9.55865 25.8029C11.2688 25.8029 12.6552 24.4165 12.6552 22.7064C12.6534 20.9969 11.2681 19.6114 9.55865 19.6096ZM9.55865 24.6644C8.47712 24.6644 7.60037 23.7877 7.60037 22.7064C7.60037 21.6248 8.47712 20.7481 9.55865 20.7481C10.64 20.7481 11.5167 21.6248 11.5167 22.7064C11.5167 23.7877 10.64 24.6644 9.55865 24.6644Z" fill="currentColor" stroke="currentColor"/>
            <path d="M26.4365 6.6144H6.33692L5.92712 4.32036C5.67452 2.90819 4.56764 1.80353 3.15502 1.55382L1.66925 1.29211C1.35951 1.23697 1.064 1.44354 1.00885 1.75305C0.95393 2.06279 1.16028 2.3583 1.47002 2.41345L2.96135 2.67516C3.90235 2.84193 4.63902 3.57859 4.80578 4.51959L6.82076 15.887C7.05868 17.2472 8.2405 18.2393 9.62132 18.238H21.5751C22.831 18.2418 23.9401 17.4197 24.3018 16.2172L26.9772 7.34861C27.0268 7.17562 26.9955 6.98929 26.8918 6.84209C26.7835 6.69956 26.6152 6.61551 26.4365 6.6144ZM23.2145 15.8813C22.9997 16.6035 22.3342 17.0975 21.5809 17.0938H9.6271C8.79794 17.096 8.08818 16.4994 7.94788 15.682L6.54193 7.74707H25.6736L23.2145 15.8813Z" fill="currentColor" stroke="currentColor"/>
            <path d="M21.5118 19.6096C19.8014 19.6096 18.415 20.996 18.415 22.7064C18.415 24.4165 19.8014 25.8029 21.5118 25.8029C23.2219 25.8029 24.6083 24.4165 24.6083 22.7064C24.6065 20.9969 23.2212 19.6114 21.5118 19.6096ZM21.5118 24.6644C20.4302 24.6644 19.5535 23.7877 19.5535 22.7064C19.5535 21.6248 20.4302 20.7481 21.5118 20.7481C22.5931 20.7481 23.4698 21.6248 23.4698 22.7064C23.4698 23.7877 22.5931 24.6644 21.5118 24.6644Z" fill="currentColor" stroke="currentColor"/>
        </svg>',

    );

    if ( array_key_exists( $icon, $svg) ) {
        return $svg[$icon];
    } else {
        return null;
    }
}

function add_category_image_field($term) {
   
    ?>
    <div class="form-field">
        <label for="category-image"><?php _e('Category Image', 'ovinx'); ?></label>
        <input type="hidden" id="category-image" name="category_image" value="">
        <div id="category-image-preview">
          
        </div>
        <button type="button" class="upload-image-button button"><?php _e('Upload Image', 'ovinx'); ?></button>
    </div>
<?php }    

function edit_category_image_field($term) {
   
    $thumbnail_id = get_term_meta($term->term_id, 'thumbnail_id', true);
    ?>
    <div class="form-field">
        <label for="category-image"><?php _e('Category Image', 'ovinx'); ?></label>
        <input type="hidden" id="category-image" name="category_image" value="<?php echo esc_attr($thumbnail_id); ?>">
        <div id="category-image-preview">
            <?php if ($thumbnail_id) : ?>
                <?php echo wp_get_attachment_image($thumbnail_id, 'thumbnail'); ?>
            <?php endif; ?>
        </div>
        <button type="button" class="upload-image-button button"><?php _e('Upload Image', 'ovinx'); ?></button>
    </div>
    
    <?php
}

add_action('category_add_form_fields', 'add_category_image_field');
add_action('category_edit_form_fields', 'edit_category_image_field');


function save_category_image_field($term_id) {
    if (isset($_POST['category_image'])) {
        update_term_meta($term_id, 'thumbnail_id', absint($_POST['category_image']));
    }
}

add_action('created_category', 'save_category_image_field');
add_action('edit_category', 'save_category_image_field');


if ( ! function_exists('tfwc_get_template_part') ){
    function tfwc_get_template_part( $template_name, $arguments = array(), $template_path = '', $default_path = '' ) {
        if ( ! empty( $arguments ) && is_array( $arguments ) ) {
            extract( $arguments );
        }

        if ( ! $template_path ) {
            $template_path = THEMESFLAT_DIR;
        }

        if ( ! $default_path ) {
            $default_path = THEMESFLAT_DIR . '/woocommerce/tpl/';
        }

        // $template = locate_template( $template_name . '.php', false );
        $template = locate_template( 'woocommerce/tpl' . $template_name, false );

        // Get default template
        if ( ! $template ) {
            $template = $default_path . $template_name;
        }

        if ( ! file_exists( $template ) ) {
            return;
        }

        // include( $template );
        load_template( $template, false );
    }
}

function custom_search_form($form) {
    $form = '
    <form method="get" class="search-form form-search-mb" action="' . esc_url(home_url('/')) . '">
        <fieldset>
            <input type="search" class="search-field" placeholder="' . esc_attr__('What are you looking for?', 'ovinx') . '" value="' . get_search_query() . '" name="s">
        </fieldset>
        <button type="submit" class="btn-action cl-text-main" aria-label="' . esc_attr__('Search', 'ovinx') . '">
            <i class="icon icon-MagnifyingGlass"></i>
        </button>
    </form>';

    return $form;
}
add_filter('get_search_form', 'custom_search_form');

/**
 * Maps a WooCommerce order status to one of the 4 real .stt-* badge classes
 * that exist in css/styles.css (stt-completed/stt-pending/stt-delivery/stt-canceled) —
 * used by woocommerce/myaccount/dashboard.php and orders.php.
 */
function ovinx_order_status_class( $status ) {
    $map = array(
        'pending'    => 'stt-pending',
        'on-hold'    => 'stt-pending',
        'processing' => 'stt-delivery',
        'completed'  => 'stt-completed',
        'cancelled'  => 'stt-canceled',
        'refunded'   => 'stt-canceled',
        'failed'     => 'stt-canceled',
    );
    return isset( $map[ $status ] ) ? $map[ $status ] : 'stt-pending';
}



/**
 * Wishlist / Compare empty-list notice: renders the centered title + description + button block
 * (ovinx-html wishlist.html "Wishlist Empty") from the Customizer options in
 * inc/customizer/shop/empty-states.php.
 *
 * @param string $key          'wishlist' or 'compare' (option prefix `{key}_empty_*`).
 * @param string $fallback_url Button link when the Customizer link is empty (usually the return-to-shop URL).
 * @return string HTML.
 */
function ovinx_get_empty_list_notice( $key, $fallback_url = '' ) {
    $allowed = array(
        'br'     => array( 'class' => array() ),
        'strong' => array(),
        'b'      => array(),
        'em'     => array(),
        'i'      => array(),
        'a'      => array( 'href' => array(), 'class' => array(), 'title' => array() ),
    );

    $title = themesflat_get_opt( $key . '_empty_title' );
    $desc  = themesflat_get_opt( $key . '_empty_desc' );
    $text  = themesflat_get_opt( $key . '_empty_button_text' );
    $url   = themesflat_get_opt( $key . '_empty_button_url' );

    if ( empty( $url ) ) {
        $url = $fallback_url ? $fallback_url : ( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' ) );
    }

    ob_start();
    ?>
    <div class="tf-wishlist-empty text-center flat-spacing-mix-1">
        <div class="container">
            <?php if ( '' !== trim( (string) $title ) ) : ?>
                <h2 class="emp_title h3"><?php echo wp_kses( $title, $allowed ); ?></h2>
            <?php endif; ?>
            <?php if ( '' !== trim( (string) $desc ) ) : ?>
                <p class="emp_desc"><?php echo wp_kses( $desc, $allowed ); ?></p>
            <?php endif; ?>
            <?php if ( '' !== trim( (string) $text ) ) : ?>
                <?php // In its own block so wpautop (Elementor text widget on the wishlist page) does not wrap the inline link in a stray <p>. ?>
                <div class="emp_action"><a href="<?php echo esc_url( $url ); ?>" class="tf-btn wc-backward"><?php echo esc_html( $text ); ?></a></div>
            <?php endif; ?>
        </div>
    </div>
    <?php
    // One line: the wishlist page is output through the_content/a shortcode, where wpautop would turn the line breaks into stray <p> tags.
    return trim( preg_replace( '/>\s+</', '><', ob_get_clean() ) );
}

/**
 * Wishlist items whose product still exists and is published.
 *
 * WCBoost's own count_items() also counts items whose product was trashed / deleted (or is a draft), but the wishlist page skips
 * them — so the header badge said "3" while the page showed nothing. Everything the theme displays (badges, fragments, the
 * page itself) goes through this instead.
 *
 * @param \WCBoost\Wishlist\Wishlist|null $wishlist Wishlist; the current one when omitted.
 * @return \WCBoost\Wishlist\Wishlist_Item[] Valid items, same keys as get_items().
 */
function ovinx_get_valid_wishlist_items( $wishlist = null ) {
    if ( ! class_exists( 'WCBoost\Wishlist\Helper' ) ) {
        return array();
    }
    if ( ! $wishlist ) {
        $wishlist = \WCBoost\Wishlist\Helper::get_wishlist();
    }
    if ( ! $wishlist ) {
        return array();
    }

    $valid = array();
    foreach ( $wishlist->get_items() as $key => $item ) {
        $product = $item->get_product();
        if ( $product && $product->exists() && 'publish' === $product->get_status() ) {
            $valid[ $key ] = $item;
        }
    }

    return $valid;
}

function ovinx_wishlist_count( $wishlist = null ) {
    return count( ovinx_get_valid_wishlist_items( $wishlist ) );
}

/**
 * A wishlist that only holds dead products shows the same "empty" notice as a wishlist without items.
 */
function ovinx_wishlist_template_when_empty( $template, $wishlist ) {
    if ( 'wishlist/wishlist.php' === $template && 0 === ovinx_wishlist_count( $wishlist ) ) {
        return 'wishlist/wishlist-empty.php';
    }
    return $template;
}
add_filter( 'wcboost_wishlist_template', 'ovinx_wishlist_template_when_empty', 10, 2 );

/**
 * "Clear all" on the wishlist page: nonce-protected link → empties the current wishlist (items go to the plugin's trash, like a
 * single removal) → back to the wishlist page.
 */
function ovinx_wishlist_clear_all_url() {
    return wp_nonce_url( add_query_arg( 'ovinx-clear-wishlist', '1', wc_get_page_permalink( 'wishlist' ) ), 'ovinx-clear-wishlist' );
}

function ovinx_wishlist_clear_all_action() {
    if ( empty( $_GET['ovinx-clear-wishlist'] ) || empty( $_GET['_wpnonce'] ) || ! class_exists( 'WCBoost\Wishlist\Helper' ) ) {
        return;
    }
    if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'ovinx-clear-wishlist' ) ) {
        return;
    }

    wc_nocache_headers();

    $wishlist = \WCBoost\Wishlist\Helper::get_wishlist();
    if ( $wishlist && $wishlist->can_edit() ) {
        $wishlist->get_items(); // empty() only trashes the items that are already loaded.
        $wishlist->empty();
    }

    wp_safe_redirect( wc_get_page_permalink( 'wishlist' ) );
    exit;
}
add_action( 'wp_loaded', 'ovinx_wishlist_clear_all_action', 25 );
// Lives here (not in woocommerce/tpl/product-base/wishlish.php): that file is only loaded on the `wp` hook, after `wp_loaded`.
