<?php
/**
 * Ovinx Theme Customizer
 *
 * @package ovinx
 */

if ( !function_exists('check_setting_is_on') ){
    function check_setting_is_on( $setting_name, $value = false ) {
        global $wp_customize;
        if( empty($value) ){
            return $wp_customize->get_setting( $setting_name )->value() == 1;
        }else{
            return $wp_customize->get_setting( $setting_name )->value() == $value;
        }
    }
}

function themesflat_customize_register( $wp_customize ) {
    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';    
    $wp_customize->remove_control('display_header_text');
    $wp_customize->remove_control('header_textcolor');
    $wp_customize->remove_control('background_color');
    $wp_customize->remove_section('colors');
    $wp_customize->remove_section('header_image');
    remove_theme_support( 'custom-header' );
  
    //Heading
    class themesflat_Info extends WP_Customize_Control {
        public $type = 'heading';
        public $label = '';
        public function render_content() {
        ?>
            <h3 class="themesflat-title-control"><?php echo esc_html( $this->label ); ?></h3>
        <?php
        }
    }    

    //Title
    class themesflat_Title_Info extends WP_Customize_Control {
        public $type = 'title';
        public $label = '';
        public function render_content() {
        ?>
            <h4><?php echo esc_html( $this->label ); ?></h4>
        <?php
        }
    }    

    //Desc
    class themesflat_Theme_Info extends WP_Customize_Control {
        public $type = 'info';
        public $label = '';
        public function render_content() {
        ?>
            <h3><?php echo esc_html( $this->label ); ?></h3>
        <?php
        }
    }    

    //Desc
    class themesflat_Desc_Info extends WP_Customize_Control {
        public $type = 'desc';
        public $label = '';
        public function render_content() {
        ?>
            <p class="themesflat-desc-control"><?php echo esc_html( $this->label ); ?></p>
        <?php
        }
    }     
    
    //Repeater
    class themesflat_Repeater extends WP_Customize_Control {
        public $type = 'desc';
        public $label = '';
        public function render_content() {
        ?>
            <p class="themesflat-desc-control"><?php echo esc_html( $this->label ); ?></p>
        <?php
        }
    }   

    //___GENERAL___//
    $wp_customize->add_panel('general_panel',array(
        'title'         => 'General',
        'priority'      => 50,
    ));
    require THEMESFLAT_DIR . "inc/customizer/general.php";

    //___TYPOGRAPHY___//
    $wp_customize->add_panel('typography_panel',array(
        'title'         => 'Typography & Color',
        'priority'      => 51,
    ));      
    require THEMESFLAT_DIR . "inc/customizer/typography.php";

    //___HEADER___//   
    $wp_customize->add_panel('header_panel',array(
        'title'         => 'Header',
        'priority'      => 53,
    ));
    require THEMESFLAT_DIR . "inc/customizer/header.php";

    //___PAGETITLE___//   
    $wp_customize->add_panel('page_title_panel',array(
        'title'         => 'Page Title',
        'priority'      => 54,
    ));
    require THEMESFLAT_DIR . "inc/customizer/page-title.php";

    //___PAGETITLE___//   
    $wp_customize->add_panel('content_panel',array(
        'title'         => 'Blog',
        'priority'      => 55,
    ));
    require THEMESFLAT_DIR . "inc/customizer/content.php";
    
   //___FOOTER___//
    $wp_customize->add_panel('footer_panel',array(
        'title'         => 'Footer',
        'priority'      => 57,
    ));      
    require THEMESFLAT_DIR . "inc/customizer/footer.php";

    require THEMESFLAT_DIR . "inc/customizer/page.php";
    
    //___SHOP___//
    if ( class_exists( 'WooCommerce' ) ) {
        $wp_customize->add_panel('shop_panel',array(
            'title'         => 'Shop',
            'priority'      => 58,
        ));      
        require THEMESFLAT_DIR . "inc/customizer/shop.php";


        $wp_customize->add_panel('single_product_panel',array(
            'title'         => 'Single Product',
            'priority'      => 59,
        ));      
        require THEMESFLAT_DIR . "inc/customizer/single-product.php";
        
    }
    $wp_customize->add_panel('mobile_panel',array(
        'title'         => 'Mobile',
        'priority'      => 60,
    ));      
    require THEMESFLAT_DIR . "inc/customizer/mobile.php";


}
add_action( 'customize_register', 'themesflat_customize_register' );

function ovinx_remove_wishlist_customizer_settings( $wp_customize ) {  
    $wp_customize->remove_setting( 'wcboost_wishlist_button_type' );
    $wp_customize->remove_setting( 'wcboost_wishlist_button_style[background_color]' );
    $wp_customize->remove_setting( 'wcboost_wishlist_button_style[border_color]' );
    $wp_customize->remove_setting( 'wcboost_wishlist_button_style[text_color]' );
    $wp_customize->remove_setting( 'wcboost_wishlist_button_hover_style[background_color]' );
    $wp_customize->remove_setting( 'wcboost_wishlist_button_hover_style[border_color]' );
    $wp_customize->remove_setting( 'wcboost_wishlist_button_hover_style[text_color]' );

    $wp_customize->remove_setting( 'wcboost_wishlist_single_button_position' );
    $wp_customize->remove_setting( 'wcboost_wishlist_loop_button_position' );

    $wp_customize->remove_control( 'wcboost_wishlist_button_type' );
    $wp_customize->remove_control( 'wcboost_wishlist_button_style[background_color]' );
    $wp_customize->remove_control( 'wcboost_wishlist_button_style[border_color]' );
    $wp_customize->remove_control( 'wcboost_wishlist_button_style[text_color]' );
    $wp_customize->remove_control( 'wcboost_wishlist_button_hover_style[background_color]' );
    $wp_customize->remove_control( 'wcboost_wishlist_button_hover_style[border_color]' );
    $wp_customize->remove_control( 'wcboost_wishlist_button_hover_style[text_color]' );

    $wp_customize->remove_control( 'wcboost_wishlist_single_button_position' );
    $wp_customize->remove_control( 'wcboost_wishlist_loop_button_position' );
}
add_action( 'customize_register', 'ovinx_remove_wishlist_customizer_settings', 99 );

// Text
function themesflat_sanitize_text( $input ) {
    return wp_kses( $input, themesflat_kses_allowed_html() );
}

// themesflat_sanitize_pagination
function themesflat_sanitize_pagination ( $input ) {
    $valid = array(
        'pager' => esc_html__('Pager', 'ovinx'),
        'numeric' => esc_html__('Numeric', 'ovinx'),
        'page_numeric' => esc_html__('Pager & Numeric', 'ovinx')                
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

// themesflat_sanitize_related_post
function themesflat_sanitize_related_post ( $input ) {
    $valid = array(
        'simple_list' => esc_html__('Simple List', 'ovinx'),
        'grid' => esc_html__('Grid', 'ovinx')        
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

// Checkboxes
function themesflat_sanitize_checkbox( $input ) {
    if ( $input == 1 ) {
        return 1;
    } else {
        return '';
    }
}

function themesflat_sanitize_image_urls($value) {
    if (is_string($value)) {
        $urls = explode(',', $value); 
        $urls = array_map('esc_url_raw', $urls); 
        return implode(',', $urls); 
    }
    return '';
}

// themesflat_sanitize_layout_product
function themesflat_sanitize_layout_product( $input ) {
    $valid = array(        
        'fullwidth'         => esc_html__( 'No Sidebar', 'ovinx' ),
        'sidebar-right'           => esc_html__( 'Sidebar Right', 'ovinx' ),
        'sidebar-left'         => esc_html__( 'Sidebar Left', 'ovinx' )
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}


function themesflat_sanitize_testimonial_thankyou_repeater($input) {
    $input = json_decode($input, true);

    if (!is_array($input)) {
        return json_encode([]);
    }

    $sanitized_items = [];

    foreach ($input as $item) {
        $sanitized_items[] = [
            'quote'  => isset($item['quote']) ? wp_kses_post($item['quote']) : '',
            'title'  => isset($item['title']) ? sanitize_text_field($item['title']) : '',
            'review' => isset($item['review']) ? sanitize_textarea_field($item['review']) : '',
            'name'   => isset($item['name']) ? sanitize_text_field($item['name']) : '',
        ];
    }

    return wp_json_encode($sanitized_items);
}

function tfwc_get_product_categories() {
    if ( ! class_exists( 'WooCommerce' ) ) {
        return array(); 
    }
    $categories = get_terms( array(
        'taxonomy'   => 'product_cat',
        'orderby'    => 'name',
        'order'      => 'ASC',
        'hide_empty' => false,
    ) );

    $choices = array();
    foreach ( $categories as $category ) {
        $choices[ $category->term_id ] = $category->name;
    }

    return $choices;
}

function themesflat_sanitize_responsive_columns( $value ) {
	$value = json_decode( $value, true );
	$defaults = array( 'desktop' => 4, 'tablet' => 3, 'mobile' => 2 );

	foreach ( $defaults as $device => $default ) {
		$value[$device] = isset($value[$device]) && is_numeric($value[$device]) ? max(1, min(10, intval($value[$device]))) : $default;
	}

	return $value;
}