<?php

    global $product;

    $related_products = wc_get_related_products( $product->get_id(), themesflat_get_opt('related_limit'));
    
    $related_count = count( $related_products );

    $columns = themesflat_get_opt('related_product_columns');
    $columns = is_string($columns) ? json_decode($columns, true) : $columns;
    $columns = wp_parse_args($columns, [
        'desktop' => 4,
        'tablet'  => 3,
        'mobile'  => 2,
    ]);
    $related_desk = $columns['desktop'];
    $related_tab  = $columns['tablet'];
    $related_mob  = $columns['mobile'];
?>

<?php if ($related_products) { ?>
    
    <div dir="ltr" class="swiper wrap-sw-over-2  tf-swiper ovinx-swiper wow fadeInUp"
        data-preview="<?php echo esc_attr($related_desk); ?>"
        data-tablet="<?php echo esc_attr($related_tab); ?>"
        data-mobile="<?php echo esc_attr($related_mob); ?>"
        data-mobile-sm="<?php echo esc_attr($related_mob); ?>"
        data-space-lg="30"
        data-space-md="20"
        data-space="15"
        data-pagination="<?php echo esc_attr( max( 1, (int) $related_mob ) ); ?>"
        data-pagination-sm="<?php echo esc_attr( max( 1, (int) $related_mob ) ); ?>"
        data-pagination-md="<?php echo esc_attr( max( 1, (int) $related_tab ) ); ?>"
        data-pagination-lg="<?php echo esc_attr( max( 1, (int) $related_desk ) ); ?>"
    >
        <div class="swiper-wrapper">

            <?php
            // Thiết lập hook product-style 1 lần trước vòng lặp (giá trị style không đổi giữa các sản phẩm nên không cần remove/add lại hook mỗi lần lặp).
            $product_style = 'style-1'; // only style-1 is designed in ovinx-html (the Customizer "style" setting had no control)
            $_POST['product_style'] = $product_style ;
            switch ($product_style) {
                case 'style-1':
                    tfwc_get_template_part( '/product-style-remove/style-1.php' );
                    tfwc_get_template_part( '/product-style-remove/style-2.php' );
                    tfwc_get_template_part( '/product-style-remove/style-3.php' );
                    tfwc_get_template_part( '/product-style-remove/style-4.php' );
                    tfwc_get_template_part( '/product-style-remove/style-list.php' );
                    tfwc_get_template_part( '/product-style-remove/style-wishlist.php' );

                    tfwc_get_template_part( '/product-style/style-1.php' );

                    break;
                case 'style-2':
                    tfwc_get_template_part( '/product-style-remove/style-1.php' );
                    tfwc_get_template_part( '/product-style-remove/style-2.php' );
                    tfwc_get_template_part( '/product-style-remove/style-3.php' );
                    tfwc_get_template_part( '/product-style-remove/style-4.php' );
                    tfwc_get_template_part( '/product-style-remove/style-list.php' );
                    tfwc_get_template_part( '/product-style-remove/style-wishlist.php' );
                    tfwc_get_template_part( '/product-style/style-2.php' );

                    break;
                case 'style-3':
                    tfwc_get_template_part( '/product-style-remove/style-1.php' );
                    tfwc_get_template_part( '/product-style-remove/style-2.php' );
                    tfwc_get_template_part( '/product-style-remove/style-3.php' );
                    tfwc_get_template_part( '/product-style-remove/style-4.php' );
                    tfwc_get_template_part( '/product-style-remove/style-list.php' );
                    tfwc_get_template_part( '/product-style-remove/style-wishlist.php' );
                    tfwc_get_template_part( '/product-style/style-3.php' );

                    break;
                case 'style-4':
                    tfwc_get_template_part( '/product-style-remove/style-1.php' );
                    tfwc_get_template_part( '/product-style-remove/style-2.php' );
                    tfwc_get_template_part( '/product-style-remove/style-3.php' );
                    tfwc_get_template_part( '/product-style-remove/style-4.php' );
                    tfwc_get_template_part( '/product-style-remove/style-list.php' );
                    tfwc_get_template_part( '/product-style-remove/style-wishlist.php' );

                    tfwc_get_template_part( '/product-style/style-4.php' );

                    break;
                default:
                    tfwc_get_template_part( '/product-style-remove/style-1.php' );
                    tfwc_get_template_part( '/product-style-remove/style-2.php' );
                    tfwc_get_template_part( '/product-style-remove/style-3.php' );
                    tfwc_get_template_part( '/product-style-remove/style-4.php' );
                    tfwc_get_template_part( '/product-style-remove/style-list.php' );
                    tfwc_get_template_part( '/product-style-remove/style-wishlist.php' );

                    tfwc_get_template_part( '/product-style/style-1.php' );

                    break;
            }
            ?>

            <?php foreach ( $related_products as $related_product ) : ?>
                <?php
                $related_product = wc_get_product( $related_product );

                if ( 'hidden' === $related_product->get_catalog_visibility() ) {
                    continue;
                }
                ?>
                <div class="swiper-slide">
                <?php

                $post_object = get_post( $related_product->get_id() );

                setup_postdata( $GLOBALS['post'] = $post_object );

                wc_get_template_part( 'content', 'product' );
                ?>
                </div>
            <?php endforeach;
            wp_reset_postdata();
            ?>
            
            
        </div>
        <div class="sw-dot-default tf-sw-pagination d-xl-none"></div>
    </div>
<?php } ?>