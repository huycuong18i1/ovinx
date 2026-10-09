<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'WCBoost\Wishlist\Helper' ) ){
    return;
}

$wishlist = \WCBoost\Wishlist\Helper::get_wishlist();
$items = $wishlist->get_items();

?>

<ul class="list-mini-product">
    <?php if ( ! empty( $items ) ) :
        foreach ( $items as $item ) :

            global $product;
            $product = $item->get_product();
            if ( ! $product ) continue;

            $product_id   = $product->get_id();
            $product_name = $product->get_name();
            $product_link = get_permalink( $product_id );
            $product_img  = wp_get_attachment_image_url( $product->get_image_id(), 'thumbnail' );
            $price_html   = $product->get_price_html();
    ?>

        <li class="mini-product-cart file-delete" data-item-id="<?php echo esc_attr( $item->get_id() ); ?>">
            <div class="prd-wrap">
                <div class="prd_image">
                    <img loading="lazy" width="100" height="100"
                        src="<?php echo esc_url($product_img); ?>"
                        alt="<?php echo esc_attr($product_name); ?>">
                </div>

                <a href="<?php echo esc_url($product_link); ?>"
                class="prd_name link-underline text-primary fw-medium">
                    <?php echo esc_html($product_name); ?>
                </a>
            </div>

            <div class="prd-action">

                <?php
                    $current_product_style = '';

                    if (isset($_POST['product_style'])) {
                        $current_product_style = sanitize_text_field($_POST['product_style']);
                    }

                    $_POST['product_style'] = 'wishlist_canvas';
                    
                    echo do_shortcode( '[wcboost_wishlist_button product_id="' . esc_attr( $product->get_id() ) . '"]' );

                    $_POST['product_style'] = $current_product_style;
                ?>


                <div class="quantity-price text-primary fw-medium">
                    <span><?php echo wp_kses_post($price_html); ?></span>
                </div>
            </div>
        </li>

        <?php endforeach; else : ?>

        <li class="empty"><?php _e('Your wishlist is empty.', 'ovinx'); ?></li>

    <?php endif; ?>
</ul>