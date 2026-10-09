<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

if(themesflat_get_opt('tf_extra_info')){

}else{
    return;
}

$single_brand = themesflat_get_opt('single_brand');
$single_available = themesflat_get_opt('single_available');
$single_cats = themesflat_get_opt('single_category');

?>

<ul class="tf-product-more-infor">

    <!-- Vendor (Brand / Author / Custom field) -->
     <?php if( $single_brand): ?>
        <li class="cl-text-main">
            <span class="infor-name"><?php _e('Vendor:', 'ovinx'); ?></span>
            <span class="fw-medium">
                <?php

                    $brands = wc_get_product_terms($product->get_id(), 'product_brand', array('fields' => 'ids'));

                    if ( !empty($brands) ) {
                        $brand_links = [];

                        foreach ($brands as $brand_id) {
                            $brand_link = get_term_link($brand_id, 'product_brand');
                            if (!is_wp_error($brand_link)) {
                                $brand_links[] = '<a href="' . esc_url($brand_link) . '">' . get_term($brand_id, 'product_brand')->name . '</a>';
                            }
                        }

                        echo implode(', ', $brand_links);

                    } else {
                        echo __('N/A', 'ovinx');
                    }
                ?>
            </span>
        </li>
    <?php endif; ?>

    <!-- Available (Stock) -->
    <?php if( $single_available): ?>
        <li class="cl-text-main">
            <span class="infor-name"><?php _e('Available:', 'ovinx'); ?></span>
            <span class="fw-medium">
                <?php
                    if ( $product->is_in_stock() ) {
                        echo __('In stock', 'ovinx');
                    } else {
                        echo __('Out of stock', 'ovinx');
                    }
                ?>
            </span>
        </li>
    <?php endif; ?>

    <!-- Categories -->
    <?php if( $single_cats): ?>
        <li class="cl-text-main">
            <span class="infor-name"><?php _e('Categories:', 'ovinx'); ?></span>
            <span class="fw-medium">
                <?php
                    echo wc_get_product_category_list(
                        $product->get_id(),
                        ', '
                    );
                ?>
            </span>
        </li>
    <?php endif; ?>

</ul>
