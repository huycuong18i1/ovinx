<?php
if( !function_exists('get_recently_viewed_products') ){
    function get_recently_viewed_products() {
        if (isset($_COOKIE['recently_viewed_products'])) {
            $product_ids = explode(',', $_COOKIE['recently_viewed_products']);
            $product_ids = array_filter($product_ids); 
            $product_ids = array_map('intval', $product_ids); 

            if (!empty($product_ids)) {
                $args = array(
                    'post_type'      => 'product',
                    'post__in'       => $product_ids,
                    'orderby'        => 'post__in',
                    'posts_per_page' => count($product_ids),
                    'post_status'    => 'publish',
                );

                $query = new WP_Query($args);

                return $query;
            }
        }
        return false;
    }
}

$query = get_recently_viewed_products();

$columns = themesflat_get_opt('recently_product_columns');
$columns = is_string($columns) ? json_decode($columns, true) : $columns;

$columns = wp_parse_args($columns, [
    'desktop' => 4,
    'tablet'  => 3,
    'mobile'  => 2,
]);

$recently_desk = $columns['desktop'];
$recently_tab  = $columns['tablet'];
$recently_mob  = $columns['mobile'];

$show_heading = get_query_var('show_heading', false);

if ($query) {
?>

    <?php if($show_heading) : ?>
        <div class="tab-title h4 fw-medium text-center">
            <?php echo esc_html(themesflat_get_opt('recently_heading'));?>
        </div>
    <?php endif; ?>

    <div dir="ltr" class="swiper tf-swiper wrap-sw-over-2 ovinx-swiper wow fadeInUp"
        data-preview="<?php echo esc_attr($recently_desk); ?>"
        data-tablet="<?php echo esc_attr($recently_tab); ?>"
        data-mobile="<?php echo esc_attr($recently_mob); ?>"
        data-mobile-sm="<?php echo esc_attr($recently_mob); ?>"
        data-space-lg="30"
        data-space-md="20"
        data-space="15"
        data-pagination="<?php echo esc_attr( max( 1, (int) $recently_mob ) ); ?>"
        data-pagination-sm="<?php echo esc_attr( max( 1, (int) $recently_mob ) ); ?>"
        data-pagination-md="<?php echo esc_attr( max( 1, (int) $recently_tab ) ); ?>"
        data-pagination-lg="<?php echo esc_attr( max( 1, (int) $recently_desk ) ); ?>"
    >
        <div class="swiper-wrapper">
            
            <?php
            $limit = themesflat_get_opt('recently_limit');
            $recently_count = $limit;
            $count = 0;

            // Thiết lập các hook style sản phẩm 1 lần duy nhất trước vòng lặp (trước đây bị lặp lại cho mỗi sản phẩm gây tốn CPU không cần thiết vì cùng 1 style cho cả swiper).
            $product_style = themesflat_get_opt('recently_product_style');
            $product_style = 'style-1';
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

            while ( $query->have_posts() && $count < $limit  )  : $query->the_post();
            $count++;
            $recently_count = $query->found_posts;
            global $product;
            if ( 'hidden' === $product->get_catalog_visibility() ) {
                continue;
            }

            ?>

            <div class="swiper-slide">
                <?php
                wc_get_template_part( 'content', 'product' );
                ?>
            </div>
            <?php
            endwhile;
            wp_reset_postdata();
            ?>
        </div>

    </div>

    
<?php }?>