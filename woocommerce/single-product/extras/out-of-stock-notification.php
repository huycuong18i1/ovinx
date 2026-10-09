<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

if(!themesflat_get_opt('tf_out_of_stock_notification') || $product->get_stock_status() !== "outofstock" || $product->get_type() == 'variable' ){
    return;
}

$html = themesflat_get_opt('tf_out_of_stock_notification_html');
add_filter( 'woocommerce_out_of_stock_message', '__return_empty_string' );
?>

<div class="tf-out-stock-wrapper">
    <?php if( empty($html) && current_user_can('administrator') ){ ?>
        <p class="desc-pop cl-text-2 text-center"><?php _e('Please set up content for this section in <br /> <b> Customizing > Single Product > Out Of Stock Notification</b>', 'ovinx'); ?></p>
    <?php } ?>
    <?php echo do_shortcode(html_entity_decode($html)); ?>
</div>