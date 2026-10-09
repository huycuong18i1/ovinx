<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;
if ( ! function_exists( 'tf_get_contents' ) ) {
	function tf_get_contents($contents) {
		if( !empty($contents) ){
			return $contents;
			// return wp_kses_post($contents);
		}
	}
}
$image_id = $product->get_image_id();
$image_url = wp_get_attachment_url( $image_id );
$placeholder = wc_placeholder_img_src();

?>
<div class="tf-product-info-wrap mt-0">
    <div class="tf-product-info-inner tf-product-quick_add tf-quick-prd_variant">
        <div class="product-mini-view">
            <a href="<?php echo esc_url($product->get_permalink()); ?>" class="prd-image">
                <img class="lazyload img-product" width="80" height="107" src="<?php echo esc_url($placeholder); ?>" data-src="<?php echo esc_url($image_url); ?>" alt="Image Product">
            </a>
            <div class="prd-content">
                <a href="<?php echo esc_url($product->get_permalink()); ?>" class="prd-name fw-medium link-underline link text-capitalize">
                    <?php echo esc_html($product->get_name()); ?>
                </a>
                
                <div class="tf-price">
                    <?php tfwc_price(); ?>
                </div>
            </div>
        </div>
        <?php woocommerce_template_single_add_to_cart(); ?>
        <?php
        if( !$product->is_in_stock() ){
            Woo_Single_Product_Hook::instance()->woocommerce_template_out_of_stock_notification();
        }
        ?>
    </div>
</div>
<?php //woocommerce_template_single_variation(); ?>
