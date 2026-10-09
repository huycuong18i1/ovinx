<?php 
global $product;
$product_id = $product->get_id();
$get_id_post_thumbnail = get_post_thumbnail_id();
$featured_image = sprintf('<img src="%s" alt="image">', \Elementor\Group_Control_Image_Size::get_attachment_image_src( $get_id_post_thumbnail, 'thumbnail', $settings )); 
$featured_image_url = get_the_post_thumbnail_url(); 

$product_type = $product->get_type();
$sale_price  = 0;
$regular_price = 0;
if($product_type == 'variable'){
    $product_variations = $product->get_available_variations();
    foreach ($product_variations as $kay => $value){
        if($value['display_price'] < $value['display_regular_price']){
            $sale_price = $value['display_price'];
            $regular_price = $value['display_regular_price'];
        }
    }
    if($regular_price > $sale_price ) {
        $product_sale = intval(((floatval($regular_price) - floatval($sale_price)) ) );
    }else{
        return  '';
    }
}else{		
    $regular_price = get_post_meta( get_the_ID(), '_regular_price', true);
    $sale_price = get_post_meta( get_the_ID(), '_sale_price', true);
    $product_sale = intval(((floatval($regular_price) - floatval($sale_price)) ) );
}

?>
<div class="item col-2x" data-product-id="<?php echo esc_attr($product_id); ?>"  >
    <div class="image">
        <div class="swiper-container gallery-slider2">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="<?php echo esc_attr($featured_image_url); ?>" alt="Image"><div class="price-save"><div class="label"><?php echo esc_html__( 'Save', 'ovinx' ) ?></div><?php echo esc_html__( '$', 'ovinx' ).$product_sale.esc_html__( '.00', 'ovinx' )  ?></div></div>
                <?php
                $attachment_ids = $product->get_gallery_image_ids();
                $count = count($attachment_ids);
                    $c = 1;
                    foreach( $attachment_ids as $attachment_id ) { 
                        $image_link = wp_get_attachment_url( $attachment_id );?>
                        <div class="swiper-slide"><img src="<?php echo esc_attr($image_link); ?>" alt="Image"><div class="price-save"><div class="label"><?php echo esc_html__( 'Save', 'ovinx' ) ?></div><?php echo esc_html__( '$', 'ovinx' ).$product_sale.esc_html__( '.00', 'ovinx' ) ?></div></div>
                    <?php $c++; if ($c > 2) break; }  
                ?>
            </div>
        </div>
        <div class="swiper-container gallery-thumbs2">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="<?php echo esc_attr($featured_image_url); ?>" alt="Image"></div>
                <?php
                $attachment_ids = $product->get_gallery_image_ids();
                $count = count($attachment_ids);
                $c = 1;
                    foreach( $attachment_ids as $attachment_id ) { 
                        $image_link = wp_get_attachment_url( $attachment_id );?>
                        <div class="swiper-slide"><img src="<?php echo esc_attr($image_link); ?>" alt="Image"></div>
                    <?php $c++; if ($c > 2) break; }  
                ?>
            </div>
        </div>
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
    <div class="bottom-product">
        <div class="content">
            <h3 class="name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <div class="price"><?php echo trim($product->get_price_html()); ?></div>
        </div>
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