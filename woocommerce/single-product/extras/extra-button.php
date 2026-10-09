<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

if(!themesflat_get_opt('tf_buy_now') || empty(themesflat_get_opt('tf_buy_now_query_arg')) ){
	return;
}

$tf_btn_classes = '';

if( !empty($_GET['tf_btn_classes']) ){
	$tf_btn_classes = sanitize_text_field($_GET['tf_btn_classes']);
}

$tf_btn_classes .= ' has-loading';
$is_quick_view = get_query_var('is_quick_view', false);
$is_quick_add = get_query_var('is_quick_add', false);

if( !empty($is_quick_view) || !empty($is_quick_add) ){
	$tf_btn_classes .= ' loading-hidden-text';
}

// Design (shop-default.html): the Quick View popup has Add to cart + View full details only - no Buy It Now.
// Re-enable with add_filter( 'ovinx_quickview_show_buy_now', '__return_true' ).
if ( ! empty( $is_quick_view ) && ! apply_filters( 'ovinx_quickview_show_buy_now', false ) ) {
	return;
}

?>

<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="tf-buy-now-btn tf-btn type-xl btn-primary animate-btn w-100 <?php echo esc_attr($tf_btn_classes); ?>">
	<span class="fw-semibold text-capitalize"><?php echo esc_html__('Buy it now','ovinx')?></span>
	<span class="tf-add-to-cart-loading d-none position-relative">
		<span class="spinner"></span>
	</span>
</a>