<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function tfwc_quickview_button() {
    global $product;
    $product_id = $product->get_id(); 
    
    $product_style = isset($_GET['product_style']) ? sanitize_text_field($_GET['product_style']) : themesflat_get_opt('product_style');

    if (isset($_POST['product_style'])) {
        $product_style = sanitize_text_field($_POST['product_style']);
    }

    // ground truth's list-style card markup uses the SAME tooltip-left as grid for this icon.
    $class = '';

    if($product_style == 'style-2' || $product_style == 'style-wishlist style-3') {
        $class = ' tooltip-top ';
    } else {
        $class = ' tooltip-left ';
    }

    if($product_style == 'style-3' || $product_style == 'style-4') {
        $class = ' d-none ';
    }


    // Ground truth's list-style card uses the SAME <li><a>...</a></li> as grid — no special case.
    echo
    '<li>
        <a href="#quickView" data-bs-toggle="offcanvas" class="hover-tooltip '.$class.' box-icon quickview tf_quickview_btn" data-product_id="'.$product_id.'" aria-label="'.esc_attr__( 'Quick View', 'ovinx' ).'">
            <span class="icon icon-EyeOpen"></span>
            <span class="tooltip">'. esc_html__('Quick View','ovinx') .'</span>
        </a>
    </li>'  ;
}

function tfwc_quickview_modal() {
    $output = '';
    ob_start();
    ?>
    <div class="offcanvas offcanvas-end canvas-quickview" id="quickView">

        <div class="mini-quick-image">
        </div>

        <div class="wrap-canvas">
        </div>

    </div>

    <?php 
     $output .= ob_get_clean();
     echo empty($output) ? '' : $output;
}

add_action( 'wp_footer', 'tfwc_quickview_modal' );

function tfwc_quickview_modal_content() {
    set_query_var( 'is_quick_view', true );
    set_query_var('quantity_style', 'style-1');
    $output = '';
    add_filter( 'woocommerce_dropdown_variation_attribute_options_html', [ Woo_Single_Product_Hook::instance(), 'tf_variation_swatches_dropdown_html' ], 120,2);
    if(themesflat_get_opt('tf_out_of_stock_notification')){
        add_filter( 'woocommerce_out_of_stock_message', '__return_empty_string' );
    }
    // add_action( 'woocommerce_single_product_summary', [ Woo_Single_Product_Hook::instance(), 'woocommerce_template_out_of_stock_notification' ], 13 );
    add_filter( 'woocommerce_product_single_add_to_cart_text', [  Woo_Single_Product_Hook::instance(), 'add_to_cart_button_text'], 10, 2 );
    add_filter('woocommerce_available_variation', [ Woo_Single_Product_Hook::instance(), 'single_add_to_cart_text_variations'], 10, 3);

    themesflat_remove_hook( 'wcboost_wishlist_loop_add_to_wishlist_link', 'tfwc_wishlish_button' , 20, 2 );
    themesflat_remove_hook( 'wcboost_products_compare_loop_add_to_compare_link', 'tfwc_compare_button' , 20, 2 );
    
    // add_action( 'woocommerce_before_add_to_cart_button', [ Woo_Single_Product_Hook::instance(), 'woocommerce_template_add_to_cart_quantity']);
    add_action( 'woocommerce_after_add_to_cart_button', [ Woo_Single_Product_Hook::instance(), 'woocommerce_template_extra_wcboost_button' ], 11);

    add_action('woocommerce_grouped_product_list_before', function(){
        themesflat_remove_hook('woocommerce_loop_add_to_cart_link', 'tfwc_add_to_cart', 20, 3 );
        themesflat_remove_hook( 'woocommerce_product_add_to_cart_text', 'tfwc_product_add_to_cart_text', 10, 2 );
        add_filter('woocommerce_loop_add_to_cart_link', [ Woo_Single_Product_Hook::instance(), 'quick_add_button'] , 21, 3 );
    } );

    add_action( 'woocommerce_end_add_to_cart_form', [ Woo_Single_Product_Hook::instance(), 'woocommerce_template_extra_button' ]);
    add_action( 'woocommerce_end_single_variation', [ Woo_Single_Product_Hook::instance(), 'woocommerce_template_extra_button' ]);

    // Design: a visible "Quantity:" label above the quantity row. Variable products print their own (variation-add-to-cart-button.php).
    add_action( 'woocommerce_before_add_to_cart_button', function () {
        global $product;
        if ( $product instanceof WC_Product && $product->is_type( 'simple' ) ) {
            echo '<p class="cl-text-main tf-quickview-qty-label">' . esc_html__( 'Quantity:', 'ovinx' ) . '</p>';
        }
    }, 5 );

    add_filter( 'wcboost_variation_swatches_image_html', [ Woo_Single_Product_Hook::instance() , 'wcboost_variation_swatches_image_html' ], 20, 4);
    add_filter( 'wcboost_variation_swatches_color_html', [ Woo_Single_Product_Hook::instance() , 'wcboost_variation_swatches_color_html' ], 20, 4);
    add_filter( 'wcboost_variation_swatches_item_args', [ Woo_Single_Product_Hook::instance(), 'wcboost_variation_swatches_item_args' ], 20, 4 );
    add_filter( 'wcboost_variation_swatches_attribute_swatches_data', [ Woo_Single_Product_Hook::instance(), 'wcboost_variation_swatches_attribute_swatches_data' ], 20, 3 );
    Woo_Single_Product_Hook::instance()->size_guide_position();
    ob_start();
    global $product;

    ?>

        <div class="mini-quick-image">
            <?php tfwc_quickview_thumnail(); ?>
        </div>

        <div class="wrap-canvas">
            <div class="canvas-header ps-md-0">
                <h5 class="title-pop"><?php _e('Quick View', 'ovinx'); ?></h5>
                <button type="button" class="btn-close-popup" data-bs-dismiss="offcanvas" aria-label="<?php esc_attr_e( 'Close', 'ovinx' ); ?>">
                    <i class="icon icon-Close2"></i>
                </button>
            </div>
            <div class="canvas-body ps-md-0 tf-quick-view">
                <div class="tf-product-info-wrap ">
                    <div class="tf-product-info-inner">
                        <div class="tf-product-info-heading quickview-product-info">
                            <?php
                                tfwc_quickview_top();
                                tfwc_quickview_title();
                                tfwc_quickview_meta();
                                add_filter('woocommerce_format_sale_price', [ Woo_Single_Product_Hook::instance(), 'add_line_before_sale_price'], 10, 3);
                                tfwc_quickview_price();
                                themesflat_remove_hook('woocommerce_format_sale_price', [ Woo_Single_Product_Hook::instance(), 'add_line_before_sale_price'], 10, 3);
                                tfwc_quickview_short_code();
                                tfwc_quickview_fake_view();
                            ?>
                        </div>
                        <div class="br-line"></div>
                        <?php
                            woocommerce_template_single_add_to_cart();
                        ?>
                        <?php
                        if( !$product->is_in_stock() ){
                            Woo_Single_Product_Hook::instance()->woocommerce_template_out_of_stock_notification();
                        }
                        ?>
                        <div class="box-action">
                            <a href="<?php echo esc_url( get_permalink());?>" class="tf-btn-line">
                                <span class="fw-semibold"><?php echo esc_html__('View full details','ovinx')?></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php 
     $output .= ob_get_clean();
     echo empty($output) ? '' : $output;
     set_query_var( 'is_quick_view', false );
     set_query_var('quantity_style', false);
}

function tfwc_quickview_thumnail() {
    global $product; 
    $attachment_ids = $product->get_gallery_image_ids();
    $placeholder = wc_placeholder_img_src();
    ?>

    <div class="wrap-quick">
    <?php if (!empty($attachment_ids)) {
        ?>
        <?php  foreach ($attachment_ids as $attachment_id) {
            $image_url = wp_get_attachment_url($attachment_id, 'themesflat-product');

            if( empty($image_url) ){
                continue;
            }

            ?>
            <div class="image">
                <img class="lazyload" src="<?php echo esc_html($placeholder); ?>" loading="lazy" width="340" height="444" data-src="<?php echo esc_url($image_url); ?>" alt="image">
            </div>
        <?php } ?>
    <?php
    } else{
        // add_image_size( 'themesflat-product', 400, 400, true );

        $image_url = wp_get_attachment_image_url($product->get_image_id(), 'themesflat-product')
            ?: wp_get_attachment_url($product->get_image_id())
            ?: wc_placeholder_img_src();

    ?>
        <div class="image">
            <img class="lazyload" src="<?php echo esc_html($placeholder); ?>" loading="lazy" width="340" height="340" data-src="<?php echo esc_url($image_url); ?>" alt="image">
        </div>
    <?php } ?>
    </div>
    <?php
}


function tfwc_quickview_top() {
    global $product;
    /**
     * Ground truth's Quick View markup (ovinx-html/shop-default.html) uses its own `.product-infor-tag`
     * class here, distinct from the card's `.product-cate` (product-base/category.php) — reusing that
     * card template left the real CSS at `.canvas-quickview .quickview-product-info .product-infor-tag`
     * (css/styles.css) unmatched. Same category data, just the real class name this context expects.
     */
    $categories = get_the_terms( $product->get_id(), 'product_cat' );

    if ( $categories ) {
        foreach ( $categories as $category ) {
            printf(
                '<a class="product-infor-tag fw-semibold" href="%1$s">%2$s</a>',
                esc_url( get_term_link( $category ) ),
                esc_html( $category->name )
            );
            break;
        }
    }
}

function tfwc_quickview_meta() {
    global $product;
    ?>
    <div class="product-infor-meta">

        <?php if( $product->get_rating_count() > 0 ) : ?>
            <div class="infor_rate">
                <?php echo tfwc_get_template_part( '/product-base/rating.php' ); ?>
            </div>
        <?php endif; ?>

        <div class="br-line type-vertical"></div>

        <?php Woo_Single_Product_Hook::instance()->woocommerce_template_recent_sales_count(); ?>

        <?php if ( $product->get_sku() ) : ?>
            <div class="br-line type-vertical"></div>
            <p class="infor_sku">
                <?php esc_html_e( 'SKU:', 'ovinx' ); ?>
                <span class="cl-text-main"><?php echo esc_html( $product->get_sku() ); ?></span>
            </p>
        <?php endif; ?>

    </div>
    <?php
}

function tfwc_quickview_title() {
    the_title( ' <h3 class="product-infor-name mb-12 letter-space-0"><a href="' . esc_url( get_permalink() ) .'">', '</a></h3>' );
}


function tfwc_quickview_price_old() {
    global $product;
    ?> 
    <div class="product-info-price price-wrap">
        <?php if ($product->is_on_sale()) : ?>
            <h6 class="price-new price-on-sale h4"><?php echo (wc_price($product->get_price())); ?></h6>
            <h6 class="price-old"><?php echo (wc_price($product->get_regular_price())); ?></h6>
        <?php else : ?>
            <h6 class="price-old compare-at-price fw-normal h6"><?php echo (wc_price($product->get_price())); ?></h6>
        <?php endif; ?>
    </div>
    <?php
}

function tfwc_quickview_price() {
    global $product;
    ?>
    <div class="product-infor-price tf-price">
        <h5 class="price-label"><?php esc_html_e( 'Price:', 'ovinx' ); ?></h5>
        <div class="price-wrap">
            <?php
            ?>

            <?php echo wp_kses_post($product->get_price_html()); ?>

            <!-- Badge sale -->
            <?php if ($product->is_on_sale()) : ?>
                <?php
                    $regular_price = (float) $product->get_regular_price();
                    $sale_price = (float) $product->get_sale_price();

                    if ($regular_price > 0 && $sale_price > 0) {
                        $discount = round((($regular_price - $sale_price) / $regular_price) * 100);
                        $discount_text = '-'. $discount . '%';
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
    </div>
    <?php
}

function tfwc_quickview_short_code() {
    global $product;
    $content = $product->get_short_description();
    if( empty( $content ) ) {
        return;
    }
    echo sprintf('<p class="product-infor-desc mb-12">%s</p>', wp_kses_post( do_shortcode($content) ));

}

function tfwc_quickview_fake_view() {
    Woo_Single_Product_Hook::instance()->woocommerce_template_people_view();
}

add_action('wp_ajax_load_quickview_product', 'load_quickview_product');
add_action('wp_ajax_nopriv_load_quickview_product', 'load_quickview_product');

function load_quickview_product() {
    check_ajax_referer('tfwc_nonce', 'nonce');

    if (!isset($_POST['product_id'])) {
        wp_send_json_error(['message' => 'No Product']);
    }

    $product_id = intval($_POST['product_id']);

    ob_start();

    $query = new WP_Query([
        'post_type' => 'product',
        'p' => $product_id
    ]);
    
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $product = wc_get_product(get_the_ID());
            if ( ! $product || ! $product->exists() ) {
                continue; 
            }

            $GLOBALS['product'] = $product;
            set_query_var('is_quick_view_template', true);

            tfwc_quickview_modal_content();

            set_query_var('is_quick_view_template', false);
        }
        wp_reset_postdata();
    } else {
        echo '<p>No Product</p>';
    }

    $output = ob_get_clean();
    wp_send_json_success(['content' => $output]);

    wp_die();
}
?>