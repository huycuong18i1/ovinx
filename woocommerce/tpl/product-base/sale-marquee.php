<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

if( empty($product) ){
    return;
}

$text = $product->get_meta('_tfwc_sale_marquee_text');
$color = $product->get_meta('_tfwc_sale_marquee_color');
$bg = $product->get_meta('_tfwc_sale_marquee_bg');

?>
<div class="product-marquee_sale" style="--sale-marquee-color:<?php echo esc_attr($color); ?>;--sale-marquee-bg:<?php echo esc_attr($bg); ?>">
    <div class="infiniteSlide" data-clone="2">
        <span><?php echo empty($text) ? '' : $text ?></span>
    </div>
</div>