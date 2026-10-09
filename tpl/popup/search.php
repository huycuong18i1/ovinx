<?php
if ( class_exists( 'woocommerce' ) ) { 
$keywords = [];
$limit = 7;
$tf_data_keywords = get_option( 'tf_search_keywords', [] );

$header_style= themesflat_get_opt('style_header');

if (themesflat_get_opt_elementor('style_header') != '') {
    $header_style = themesflat_get_opt_elementor('style_header');
}

if ( !empty( $tf_data_keywords ) && is_array( $tf_data_keywords ) ) {
    arsort( $tf_data_keywords );

    $keywords = array_slice( $tf_data_keywords, 0, $limit, true );
}

?>
<!-- search -->
<div class="offcanvas offcanvas-top offcanvas-search <?php if ( is_user_logged_in() && is_admin_bar_showing() ) { echo 'is-admin';} ?>" id="tfsearch" 
  data-bs-backdrop="false"
  data-bs-scroll="true"
  data-bs-focus="false">
    <div class="custom-search-backdrop" data-bs-dismiss="offcanvas" ></div>
    <div class="offcanvas-content">

        <button type="button" class="btn-close-popup" data-bs-dismiss="offcanvas" aria-label="<?php esc_attr_e( 'Close', 'ovinx' ); ?>">
            <i class="icon icon-Close2"></i>
        </button>

        <div class="popup-content">
            <div class="tf-search-top-wrapper">

                        <div class="label-search">
            <h3>
                <?php _e('Search', 'ovinx'); ?>
            </h3>
            <button type="button" class="btn-close-popup" data-bs-dismiss="offcanvas" aria-label="<?php esc_attr_e( 'Close', 'ovinx' ); ?>">
            <i class="icon icon-Close2"></i>
        </button>
        </div>

                <div class="inner-midle tf-search-wrapper">
                    <?php get_template_part( 'tpl/header/search-category'); ?>
                        <!-- <span class="tf-close-search-popup">
                            <i class="icon icon-close"></i>
                        </span> -->
                </div>

                <?php if ( ! empty( $keywords ) ) : ?>
                    <div class="most-keywords-wrap">
                        <h4 class="most-keywords-title"><?php _e(themesflat_get_opt('header_search_box_menu')); ?></h4>

                        <ul class="tf-most-search-keywords">
                            <?php foreach ( $keywords as $keyword => $count ) : ?>
                                <li class="tf-most-search-keyword-item">
                                    <a href="<?php echo esc_url(
                                        // add_query_arg(
                                        //     [
                                        //         's'         => $keyword,
                                        //         'post_type'=> 'product',
                                        //     ],
                                        //     wc_get_page_permalink( 'shop' )
                                        // )
                                        
                                        add_query_arg(
                                            array(
                                                's'         => urlencode($keyword),
                                                'post_type' => 'product',
                                            ),
                                            home_url('/')
                                        )
                                    ); ?>">
                                        <?php echo esc_html( $keyword ); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        
                    </div>
                <?php endif; ?>
            </div>

            <div class="most-search-products-wrap">
                <h4 class="most-search-products-title"><?php _e(themesflat_get_opt('header_search_box_product')); ?></h4>
                <div class="most-search-products-content">
                    <div class="results-content">
                        <?php

                        $args = array(
                            'limit'    => 4,
                            'status'   => 'publish',
                            'orderby'  => 'meta_value_num',
                            'order'    => 'DESC',
                            'meta_key' => 'tf_searched_product',
                            'meta_query' => array(
                                array(
                                    'key'     => 'tf_searched_product',
                                    'compare' => 'EXISTS',
                                ),
                            ),
                        );

                        if( function_exists( 'wc_get_products' ) ){
                            $search_products = wc_get_products( $args );
                        }

                        if ( empty( $search_products ) ) {
                            $pop_args = array(
                                'limit'    => 4,
                                'status'   => 'publish',
                                'orderby'  => 'popularity', // WooCommerce popularity = total_sales
                                'order'    => 'DESC',
                            );
                        
                            $search_products = wc_get_products( $pop_args );
                        }

                        if ( !empty($search_products) ) { ?>

                            <div dir="ltr" class="swiper tf-swiper ovinx-swiper wrap-sw-over-2 wow fadeInUp"
                                data-preview="4"
                                data-tablet="3"
                                data-mobile="2"
                                data-mobile-sm="2"
                                data-space-lg="20"
                                data-space-md="20"
                                data-space="15"
                                data-pagination="1"
                                data-pagination-sm="1"
                                data-pagination-md="1"
                                data-pagination-lg="1"
                            >
                                <div class="swiper-wrapper">
                                    
                                    <?php foreach ( $search_products as $search_product ) : ?>
                                        <?php
                        
                                        if ( 'hidden' === $search_product->get_catalog_visibility() ) {
                                            continue; 
                                        }    
                                        ?>
                                        <div class="swiper-slide">
                                        <?php
                                        
                                        $post_object = get_post( $search_product->get_id() );
                        
                                        setup_postdata( $GLOBALS['post'] = $post_object );
                        
                                        // $_POST['product_style'] = 'style-1' ;
                                        tfwc_get_template_part( '/product-style-remove/style-1.php' );                           
                                        tfwc_get_template_part( '/product-style-remove/style-2.php' );                           
                                        tfwc_get_template_part( '/product-style-remove/style-3.php' );                           
                                        tfwc_get_template_part( '/product-style-remove/style-4.php' );                           
                                        tfwc_get_template_part( '/product-style-remove/style-list.php' );                           
                                        tfwc_get_template_part( '/product-style-remove/style-wishlist.php' );
                
                                        tfwc_get_template_part( '/product-style/style-1.php' );
                                        wc_get_template_part( 'content', 'product' );
                                        ?>
                                        </div>
                                    <?php endforeach;
                                    wp_reset_postdata();
                                    ?>
                                    
                                    
                                </div>
                                <div class="sw-dot-default tf-sw-pagination"></div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="result-products-wrap">

                <div class="result-products-title-wrap">
                    <h4 class="result-products-title">
                        <span>
                            <?php _e(themesflat_get_opt('header_search_box_product_related')); ?>
                        </span>
                    </h4>
                    <div class="tfwc-view-all tf-btn-line"></div>
                </div>

                <div class="result-products-content results-product">
                    <div dir="ltr" class="swiper tf-swiper ovinx-swiper wrap-sw-over-2 wow fadeInUp"
                        data-preview="4"
                        data-tablet="3"
                        data-mobile="2"
                        data-mobile-sm="2"
                        data-space-lg="20"
                        data-space-md="20"
                        data-space="15"
                        data-pagination="2"
                        data-pagination-sm="2"
                        data-pagination-md="3"
                        data-pagination-lg="3"
                    >
                        <div class="swiper-wrapper">
                            <!-- Results will be appended here via AJAX -->
                        </div>
                        <div class="sw-dot-default tf-sw-pagination"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- /search -->

<?php } ?>