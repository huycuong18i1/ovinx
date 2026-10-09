<?php
global $product;
    
$upsells = $product->get_upsell_ids();

$upsell_count = count( $upsells );
$upsell_count = 0;

$columns = themesflat_get_opt('upsell_product_columns');
$columns = is_string($columns) ? json_decode($columns, true) : $columns;
$columns = wp_parse_args($columns, [
    'desktop' => 4,
    'tablet'  => 3,
    'mobile'  => 2,
]);
$upsell_desk = $columns['desktop'];
$upsell_tab  = $columns['tablet'];
$upsell_mob  = $columns['mobile'];

if ( $upsells ) : ?>
    
    <div dir="ltr" class="swiper tf-swiper ovinx-swiper wrap-sw-over-2 wow fadeInUp"
        data-preview="<?php echo esc_attr($upsell_desk); ?>"
        data-tablet="<?php echo esc_attr($upsell_tab); ?>"
        data-mobile="<?php echo esc_attr($upsell_mob); ?>"
        data-mobile-sm="<?php echo esc_attr($upsell_mob); ?>"
        data-space-lg="30"
        data-space-md="20"
        data-space="15"
        data-pagination="<?php echo esc_attr( max( 1, (int) $upsell_mob ) ); ?>"
        data-pagination-sm="<?php echo esc_attr( max( 1, (int) $upsell_mob ) ); ?>"
        data-pagination-md="<?php echo esc_attr( max( 1, (int) $upsell_tab ) ); ?>"
        data-pagination-lg="<?php echo esc_attr( max( 1, (int) $upsell_desk ) ); ?>"
    >
        <div class="swiper-wrapper">

    <?php
    // Thiết lập hook product-style 1 lần trước vòng lặp (giá trị style không đổi giữa các sản phẩm nên không cần remove/add lại hook mỗi lần lặp).
    // Lưu ý: bản gốc gọi wc_get_template_part('content','product') TRƯỚC switch nên sản phẩm đầu tiên có thể render bằng hook style của lượt trước đó;
    // đưa switch lên trước vòng lặp giúp hook luôn đúng style đã cấu hình ngay từ sản phẩm đầu tiên.
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
    <?php foreach ( $upsells as $upsell ) : ?>
        <?php
            $upsell_product = wc_get_product( $upsell );

            if ( 'hidden' === $upsell_product->get_catalog_visibility() ) {
                continue;
            }
            $upsell_count++;
            ?>
        <div class="swiper-slide">
            <?php

            $post_object = get_post( $upsell_product->get_id() );

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

<?php
endif;

wp_reset_postdata();
?>