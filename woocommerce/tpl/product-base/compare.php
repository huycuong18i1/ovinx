<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

add_filter( 'wcboost_products_compare_button_icon', 'tfwc_compare_icon' , 20, 2 );
add_filter( 'wcboost_products_compare_loop_add_to_compare_link', 'tfwc_compare_button' , 20, 2 );

function tfwc_compare_button($html, $args) {

    $is_wl_single_product = get_query_var('is_wl_single_product', false);

    if( !empty($is_wl_single_product)){
        return $html;
    }

    $classes = is_singular( 'product' ) ? 'wcboost-products-compare-button wcboost-products-compare-button--single button' : 'wcboost-products-compare-button wcboost-products-compare-button--loop button';
    $product_title = isset( $args['product_title'] ) ? $args['product_title'] : '';
    if( empty( $product_title ) ) {
        $product = isset($args['product_id']) ? wc_get_product( $args['product_id'] ) : '';
        $product_title = $product ? $product->get_title() : '';
    }

    $label_add = \WCBoost\ProductsCompare\Helper::get_button_text( 'add' );
    $label_added = \WCBoost\ProductsCompare\Helper::get_button_text( 'view' );

    if( get_option( 'wcboost_products_compare_exists_item_button_behaviour' ) == 'remove' ) {
        $label_added = \WCBoost\ProductsCompare\Helper::get_button_text( 'remove' );
    }

    $product_style = isset($_GET['product_style']) ? $_GET['product_style'] : themesflat_get_opt('product_style');
 
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

    // Ground truth's list-style card uses the SAME <li><a>...</a></li> as grid — no special case.
    return sprintf(
        '<li class="compare">
            <a href="%1s" class="box-icon hover-tooltip '.$class.' %2s" role="button" %3s data-tooltip="%4s" data-tooltip_added="%5s">
            <span class="wcboost-products-compare-button__icon">%s</span>
            <span class="wcboost-products-compare-button__text tooltip">%4s</span>
        </a>
        </li>',
        esc_url( isset( $args['url'] ) ? $args['url'] : add_query_arg( [ 'add-to-compare' => $args['product_id'] ] ) ),
        esc_attr( isset( $args['class'] ) ? $args['class'] : esc_attr( $classes ) ),
        isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
        wp_kses_post( $label_add ),
        wp_kses_post( $label_added ),
        empty( $args['icon'] ) ? '' :  $args['icon'],
        esc_html( isset( $args['label'] ) ? $args['label'] : __( 'Add to Compare', 'ovinx' ) )
    );
}

function tfwc_compare_icon($svg, $icon) {
    if( $icon == 'arrows' ) {
        $product_style = isset($_GET['product_style']) ? $_GET['product_style'] : themesflat_get_opt('product_style');
        if (isset($_POST['product_style'])) {
            $product_style = sanitize_text_field($_POST['product_style']);
        }
            
        $svg = '<span class="icon icon-ArrowsLeftRight"></span>';
    } else if( $icon == 'check' ) {
        // `icon-trash` isn't a real icon (not in the 70-icon icomoon export) — the "added" state
        // just needs a checkmark, not a delete icon; `icon-Check` is the real one.
        $svg = '<span class="icon icon-Check"></span>';
    }

    return $svg;
}


if ( class_exists( 'WCBoost\ProductsCompare\Plugin' ) ) {
    $compare_behavior = get_option( 'wcboost_products_compare_added_behavior' );
    if ($compare_behavior != 'popup') {
        add_action('wp_footer', 'tfwc_canvas_compare' );
    }
    
}

function tfwc_compare_popup(){
    global $product;
    ?>
        <div class="modal modalCentered fade modal-compare" id="compare" >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <span class="icon-close-popup" data-bs-dismiss="modal" role="button" aria-label="<?php esc_attr_e( 'Close', 'ovinx' ); ?>">
                        <i class="icon-close"></i>
                    </span>
                    <div class="modal-heading">
                        <h3 class="title"><?php _e('Compare Products','ovinx')?></h3>
                    </div>
                    <div class="modal-body main-list-clear list-file-delete">
                        <div class="tf-compare-inner">
                            <div class="tf-compare-list list-empty">
                                <?php
                                    $items = \WCBoost\ProductsCompare\Plugin::instance()->list->get_items();  
                                    $clear_url = \WCBoost\ProductsCompare\Helper::get_clear_url();
                                    $product_ids = array_values($items);
                                    if ( empty( $product_ids ) ) {
                                        ?>
                                        <p class="text-empty"><?php echo esc_html__('Your compare list is currently empty','ovinx'); ?></p>
                                        <?php
                                    } else {
                                        foreach ( $product_ids as $product_id ) {
                                            $product = wc_get_product( $product_id );
                                
                                            if ( ! $product ) {
                                                continue;
                                            }
                                            $image_url_large = wp_get_attachment_url( $product->get_image_id() );
                                            $remove_url = \WCBoost\ProductsCompare\Helper::get_remove_url( $product );
                                            ?>
                                            <div class="tf-compare-item file-delete">
                                                <div class="card_product-wrapper aspect-ratio-1">
                                                    <span class="remove icon-close tf-remove-compare" data-remove-url="<?php echo esc_url($remove_url); ?>"></span>
                                                    <a href="<?php echo esc_url($product->get_permalink()); ?>" class="product-img" target="_blank" rel="noopener noreferrer">
                                                        <img class="img-product lazyload" data-src="<?php echo esc_url($image_url_large); ?>" src="<?php echo esc_url($image_url_large); ?>" alt="<?php echo esc_html($product->get_title()); ?>">
                                                    </a>
                                                </div>
                                                <div class="card_product-info text-center">
                                                    <a class="name-product text-line-clamp-2" href="<?php echo esc_url($product->get_permalink()); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html($product->get_title()); ?></a>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="group-btn">
                            <a href="<?php echo esc_html(wc_get_page_permalink( 'compare' )); ?>" class="tf-btn animate-btn fw-medium" target="_blank" rel="noopener noreferrer">
                                <?php _e('Compare','ovinx')?>
                                <?php if(count($product_ids) > 0) : ?>
                                <span class="count-item-compare">(<?php echo esc_html(count($product_ids)); ?>)</span>
                                <?php endif; ?>
                            </a>
                            <a href="#" class="tf-btn tf-btn style-stroke clear-list-empty tf-compare-button-clear-all fw-medium clear-list-empty tf-clear-compare" data-clear-url="<?php echo esc_url($clear_url); ?>">
                                <span><?php _e('Clear All','ovinx')?></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
}

function tfwc_canvas_compare(){
    global $product;
    ?>
        <div class="offcanvas offcanvas-bottom canvas-compare" id="compare" aria-hidden="true">

            <div class="canvas-wrapper">
                <div class="canvas-body">
                    <div class="container">
                        <div class="tf-compare-list main-list-clear wrap-empty_text">

                            <div class="tf-compare-head">
                                <h4 class="title letter-space-0"><?php _e('Compare products', 'ovinx'); ?></h4>
                            </div>

                            <div class="tf-compare-offcanvas list-empty">

                                <p class="box-text_empty cl-text-2" style="display: none;">
                                    <?php _e('Your compare list is currently empty', 'ovinx'); ?>
                                </p>

                                <?php
                                
                                    $items = \WCBoost\ProductsCompare\Plugin::instance()->list->get_items();
                                    $clear_url = \WCBoost\ProductsCompare\Helper::get_clear_url();
                                    $product_ids = array_values($items);
                                    $placeholder = wc_placeholder_img_src();
                                    foreach ( $product_ids as $product_id ) {
                                        $product = wc_get_product( $product_id );
                            
                                        if ( ! $product ) {
                                            continue;
                                        }

                                        $image_url_large = wp_get_attachment_url( $product->get_image_id() );
                                        $remove_url = \WCBoost\ProductsCompare\Helper::get_remove_url( $product );

                                        ?>

                                            <div class="tf-compare-item file-delete position-relative">

                                                <span class="icon remove tf-remove-compare" data-remove-url="<?php echo esc_url($remove_url); ?>">
                                                    <i class="icon-X2"></i>
                                                </span>

                                                <a href="<?php echo esc_url($product->get_permalink()); ?>" class="" target="_blank" rel="noopener noreferrer">
                                                    <img class="radius-3 lazyload" width="660" height="880" src="<?php echo esc_url($placeholder); ?>" data-src="<?php echo esc_url($image_url_large); ?>" alt="<?php echo esc_html($product->get_title()); ?>">
                                                </a>

                                                <!-- <div class="content">
                                                    <div class="text-title">
                                                        <a class="link text-line-clamp-2" href="<?php echo esc_url($product->get_permalink()); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html($product->get_title()); ?></a>
                                                    </div>
                                                    <p class="price-wrap tf-price">
                                                        <?php echo wp_kses_post($product->get_price_html()); ?>
                                                    </p>
                                                </div> -->

                                            </div>
                                        <?php
                                    }
                                ?>
                                
                            </div>

                            <div class="tf-compare-buttons justify-content-center">

                                <a href="<?php echo esc_html(wc_get_page_permalink( 'compare' )); ?>" class="tf-btn animate-btn" target="_blank" rel="noopener noreferrer">
                                    <?php echo esc_html__('Compare','ovinx');?>
                                    <?php if(count($product_ids) > 0) : ?>
                                        <span class="count-item-compare">(<?php echo esc_html(count($product_ids)); ?>)</span>
                                    <?php endif; ?>
                                </a>

                                <div class="tf-btn tf-btn style-stroke clear-list-empty tf-compare-button-clear-all clear-list-empty tf-compare-button-clear-all tf-clear-compare" data-clear-url="<?php echo esc_url($clear_url); ?>">
                                    <span><?php echo esc_html__('Clear All','ovinx');?></span>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    <?php
}

?>