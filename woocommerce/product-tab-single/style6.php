<?php 
global $product;
$product_id = $product->get_id();
$get_id_post_thumbnail = get_post_thumbnail_id();
$stock_sold = ( $total_sales = get_post_meta( $product_id, 'total_sales', true ) ) ? round( $total_sales ) : 0;
$stock_available = ( $stock = get_post_meta( $product_id, '_stock', true ) ) ? round( $stock ) : 0;
$total_stock = $stock_sold + $stock_available;
$percentage = ( $stock_available > 0 ? round($stock_available/$total_stock * 100) : 0 );
$featured_image = sprintf('<img src="%s" alt="image">', \Elementor\Group_Control_Image_Size::get_attachment_image_src( $get_id_post_thumbnail, 'thumbnail', $settings )); 
?>
<div class="item" data-product-id="<?php echo esc_attr($product_id); ?>">
    <div class="image">
        <?php echo sprintf('%s',$featured_image);?>
        <div class="wrap-btn-action">
            <?php if ( ! $product->managing_stock() && ! $product->is_in_stock() ) { ?>
                        
            <?php } else { ?>
            <div class="tf-btn-add-to-cart">
                <span class="add_to_cart button" data-product_id="<?php the_ID(); ?>"><span class="cartplus icon-monal-cart"></span>
                    <span class="check icon-monal-check-mark"></span><?php echo esc_html__( '', 'ovinx' ) ?></span>
            </div>
            <?php } ?>

            <?php if (class_exists('YITH_WCWL')): ?>            
                <?php echo do_shortcode('[yith_wcwl_add_to_wishlist link_classes="add_to_wishlist" label="" product_added_text="" browse_wishlist_text="" already_in_wishslist_text="" icon="ovinx-icon-wishlish"]');  ?>
            <?php endif; ?>


            <?php if (function_exists('yith_wcqv_init')): ?>
                <div class="tf-btn-quickview">
                    <span class="tf-call-quickview button" data-product_id="<?php the_ID(); ?>"><i class="fa fa-eye"></i></span>
                </div>
            <?php endif; ?>

            <?php if (class_exists('YITH_Woocompare')): ?>            
                <?php  echo do_shortcode('[yith_compare_button]');  ?>
            <?php endif; ?>         
        </div>
    </div>
    <div class="content">
        <?php themesflat_display_product_cat( $product_id ); ?>
        <h3 class="name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        
        <div class="price"><?php echo trim($product->get_price_html()); ?></div>

        <?php if ( $stock_available > 0 ) { ?>
        <div class="special-progress">
            <div class="info_sold clearfix">
                <div class="pull-left">
                    <?php echo esc_html__('Available: ','ovinx').'<span class="text-theme">'.$stock_available.'</span>'; ?>
                    
                </div>
                <div class="pull-right">
                    <?php echo esc_html__('Sold: ','ovinx').'<span class="text-theme">'.$stock_sold.'</span>'; ?>
                </div>
            </div>
            <div class="progress">
                <span class="progress-bar" style="<?php echo esc_attr('width:' . $percentage . '%'); ?>"></span>
            </div>
        </div>
        <?php } ?>

        <?php
        $time_sale = get_post_meta( $product_id, '_sale_price_dates_to', true );
        if ( $time_sale ) { ?>
            <div class="time-wrapper">
                <div class=" tf-countdown  clearfix" 
                    data-date="<?php echo  esc_attr( date( 'Y-m-d H:i:s', $time_sale ) )  ; ?>">
                </div>
            </div>
        <?php } ?>

        
    </div>
        
</div>