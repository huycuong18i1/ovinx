<?php

if ( ! themesflat_get_opt( 'show_related_post' ) )
    return;
$layout = themesflat_get_opt( 'related_post_style');
$carousel = 1;
$grid_columns  = themesflat_get_opt( 'grid_columns_post_related' );


if ( get_query_var('paged') ) {
    $paged = get_query_var('paged');
} elseif ( get_query_var('page') ) {
    $paged = get_query_var('page');
} else {
    $paged = 1;
}

$categories = get_the_category();
$category_ids = [];

if ($categories) {
    foreach ($categories as $category) {
        $category_ids[] = $category->term_id;
    }
}

$args = [
    'category__in' => $category_ids, 
    'post__not_in' => [get_the_ID()],
    'posts_per_page' => themesflat_get_opt( 'number_related_post' ), 
    'orderby' => 'rand' 
];

$columns = themesflat_get_opt('related_post_columns');
$columns = is_string($columns) ? json_decode($columns, true) : $columns;
$columns = wp_parse_args($columns, [
    'desktop' => 3,
    'tablet'  => 2,
    'mobile'  => 1,
]);
$category_dek = $columns['desktop'];
$category_tab  = $columns['tablet'];
$category_mob  = $columns['mobile'];

if ( $layout != '' ) {
    $class[] = $layout;
}
if ( $grid_columns != '' ) {
    $class[] = 'columns-' . $grid_columns ;
}
if ( $carousel == 1 ) {
    $class[] = 'has-carousel';
}

$imgs = array(
    'blog-grid' => 'themesflat-blog-grid',
    'blog-list' => 'themesflat-blog',
    );
$themesflat_thumbnail = $imgs[$layout];

$query = new WP_Query($args);
if( $query->have_posts() ) {
?>


<div class="flat-spacing-4 pb-0">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="sect-heading text-center">
                    <h4 class="s-title"><?php echo esc_html( themesflat_get_opt('related_post_title') ) ?></h4>
                    <p class="text-body-02"><?php echo esc_html( themesflat_get_opt('related_post_des') ) ?></p>
                </div>
                <div dir="" class="swiper tf-swiper tfwc-slider" data-swiper='{
                            "slidesPerView": <?php echo esc_attr($category_mob) ?>,
                            "spaceBetween": 12,
                            "speed": 800,
                            "observer": true,
                            "observeParents": true,
                            "slidesPerGroup": <?php echo esc_attr( max( 1, (int) $category_mob ) ) ?>,
                            "navigation": {
                                "clickable": true,
                                "nextEl": ".nav-next-new",
                                "prevEl": ".nav-prev-new"
                            },
                            "pagination": { "el": ".sw-pagination-new", "clickable": true },
                            "breakpoints": {
                            "577": { "slidesPerView": <?php echo esc_attr($category_tab) ?>, "spaceBetween": 12, "slidesPerGroup": <?php echo esc_attr( max( 1, (int) $category_tab ) ) ?> },
                            "991": { "slidesPerView": <?php echo esc_attr($category_dek) ?>, "spaceBetween": 30, "slidesPerGroup": <?php echo esc_attr( max( 1, (int) $category_dek ) ) ?> }
                            }
                        }'>
                    <div class="swiper-wrapper">
                        
                        <?php
                        $query = new WP_Query($args);
                        if( $query->have_posts() ) {
                            while ($query->have_posts()) : $query->the_post(); ?>
                            <div class="swiper-slide">
                                <article class="article-blog style-2 hover-img">
                                    <?php get_template_part( 'tpl/feature-post-related' ); ?>

                                    <div class="blog-content">
                                        <div class="d-grid gap-8 mb-16">
                                            <?php
                                            get_template_part( 'tpl/entry-content/entry-content-meta-related' );
                                            get_template_part( 'tpl/entry-content/entry-content-title-related' );
                                            ?>
                                        </div>
                                        <?php get_template_part( 'tpl/entry-content/entry-content-readmore-related' ); ?>
                                    </div>
                                </article><!-- /.entry -->
                            </div>
                            <?php
                            endwhile;
                        }
                        wp_reset_postdata();            
                        ?>
                    </div>
                    <div class="d-flex d-xl-none sw-dot-default sw-pagination-new justify-content-center"></div>
                </div>
            </div>
        </div>
    </div>



</div>

<?php } ?>

