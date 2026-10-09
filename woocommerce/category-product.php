<?php
    $show_top_category = themesflat_get_opt('show_top_category');
    if ( $show_top_category != 1 ) return;
    $args = array(
        'taxonomy' => 'product_cat',
        'parent'   => 0,
        'number' => 0,
    );

    $terms = get_terms( $args );

		if ( is_wp_error( $terms ) || ! $terms ) {
			return;
		}

		$thumbnail_size = 'full';

    $category_dek = themesflat_get_opt('category_dek');
    $category_tab = themesflat_get_opt('category_tab');
    $category_mob = themesflat_get_opt('category_mob');
    $category_mob2 = themesflat_get_opt('category_mob2');
        
?>


<div class="wrap-product-category " data-column="<?php echo esc_attr($category_dek) ?>" data-column2="<?php echo esc_attr($category_tab) ?>" data-column3="<?php echo esc_attr($category_mob) ?>" data-column4="<?php echo esc_attr($category_mob2) ?>">
    <div class="owl-carousel">
        <?php foreach( $terms as $term ) {	
            $thumb_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
            $images = ! empty( wp_get_attachment_image_src( $thumb_id, $thumbnail_size ) ) ? wp_get_attachment_image_src( $thumb_id, $thumbnail_size )[0] : wc_placeholder_img_src( $thumbnail_size );
            $thumb_url = !empty( $thumb_id ) ? $images : wc_placeholder_img_src( $thumbnail_size ); ?>
            <div class="item">
                <a href="<?php echo esc_url( get_term_link( $term->term_id )); ?>">
                    <div class="thumb">                        
                        <img src="<?php echo esc_url( $thumb_url ); ?>" alt="image">                                
                    </div>
                </a> 
                <h5 class="title">
                    <a href="<?php echo esc_url( get_term_link( $term->term_id )); ?>"><?php echo esc_html( $term->name );?></a>
                </h5>
            </div>
        <?php } ?>
    </div>
</div>