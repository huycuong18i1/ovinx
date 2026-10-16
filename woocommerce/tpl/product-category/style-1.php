<?php
    $show_top_category = themesflat_get_opt('show_top_category');
    $top_category_title = themesflat_get_opt('top_category_title');
    
    if (isset($_GET['show_top_category'])){
        $show_top_category = sanitize_text_field($_GET['show_top_category']);
    }

    if ( $show_top_category != 1 ) return;

    $category_number = themesflat_get_opt('category_number');

    $order_by = themesflat_get_opt('category_order');

    $order = 'ASC';
    if ($order_by == 'count') {
        $order = 'DESC';
    }
    
    $parent_id = 0; 
    if (is_tax('product_cat')) { 
        $current_cat = get_queried_object(); 
        $parent_id = $current_cat->term_id;
    }
    
    $args = array(
        'taxonomy'   => 'product_cat',
        'parent'     => $parent_id,
        'number'     => $category_number,
        'orderby'    => $order_by, 
        'order'      => $order,
        'hide_empty' => false, 
    );
    
    $terms = get_terms($args);

    if ( is_wp_error( $terms ) || ! $terms ) {
        return;
    }

    $thumbnail_size = 'tf-category';

    $term_count = is_array($terms) ? count($terms) : 0;

    $columns = themesflat_get_opt('category_columns');
    $columns = is_string($columns) ? json_decode($columns, true) : $columns;
    $columns = wp_parse_args($columns, [
        'desktop' => 5,
        'tablet'  => 3,
        'mobile_sm'  => 2,
        'mobile'  => 2,
    ]);
    $category_dek = $columns['desktop'];
    $category_tab  = $columns['tablet'];
    $category_mob_sm  = $columns['mobile_sm'];
    $category_mob  = $columns['mobile'];
    if (isset($_GET['category_dek'])){
        $category_dek = sanitize_text_field($_GET['category_dek']);
    }
    if (isset($_GET['category_tab'])){
        $category_tab = sanitize_text_field($_GET['category_tab']);
    }
    if (isset($_GET['category_mob_sm'])){
        $category_mob_sm = sanitize_text_field($_GET['category_mob_sm']);
    }
    if (isset($_GET['category_mob'])){
        $category_mob = sanitize_text_field($_GET['category_mob']);
    }
?>

<section class="section-category flat-spacing-2 tf-btn-swiper-main">
    <div class="container">
        <div class="swiper tf-swiper ovinx-swiper wrap-sw-over-2" data-preview="<?php echo esc_attr($category_dek); ?>" data-tablet="<?php echo esc_attr($category_tab); ?>" data-mobile-sm="1.7" data-mobile="<?php echo esc_attr($category_mob); ?>" data-space-lg="30"
            data-space-md="20" data-space="10" data-pagination="<?php echo esc_attr( max( 1, (int) $category_mob ) ); ?>" data-pagination-sm="<?php echo esc_attr( max( 1, (int) $category_mob_sm ) ); ?>" data-pagination-md="<?php echo esc_attr( max( 1, (int) $category_tab ) ); ?>" data-pagination-lg="<?php echo esc_attr( max( 1, (int) $category_dek ) ); ?>"
        >
            <div class="swiper-wrapper">

                <?php foreach( $terms as $term ) {
                    $thumb_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
                    $images = ! empty( wp_get_attachment_image_src( $thumb_id, $thumbnail_size ) ) ? wp_get_attachment_image_src( $thumb_id, $thumbnail_size )[0] : tf_wc_placeholder_img_src();
                    $thumb_url = !empty( $images ) ? $images : wc_placeholder_img_src( $thumbnail_size );
                    // $bg_color = get_term_meta($term->term_id, 'bg_color', true);
                    $bg_color = '';
                ?>

                    <div class="swiper-slide">
                        <a href="<?php echo esc_url( get_term_link( $term->term_id )); ?>" class="category-v01 hover-img" style="<?php echo !empty( $bg_color ) ? 'background-color: '. esc_attr( $bg_color ).';' : ''; ?>">
                            <div class="cate-image img-style aspect-ratio-1">
                                <img loading="lazy" class="lazyload" width="140" data-src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php echo esc_attr( $term->name );?>">
                            </div>
                            <div class="cate-info">
                                <h5 class="cate-name h5 text-center link link-underline">
                                    <?php echo esc_html( $term->name ); ?>
                                </h5>
                                <p class="info_quanity text-center text-caption-01">
                                    <?php echo sprintf( _n( '%s Product', '%s Products', $term->count, 'ovinx' ), $term->count ); ?>
                                </p>
                            </div>
                        </a>
                    </div>

                <?php } ?>
                
            </div>
            <!-- <div class="sw-dot-default d-flex d-sm-none tf-sw-pagination"></div> -->
        </div>
    </div>
    </section>