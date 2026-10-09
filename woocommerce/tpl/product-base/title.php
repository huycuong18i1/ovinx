<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

$product_url = get_permalink($product->get_id());

$searched_key= get_query_var('searched_key');

if( !empty( $searched_key ) ){

	$search_param = array(
		'from' => 'search',
		'q'    => urlencode($searched_key)
	);
	
	$product_url = add_query_arg(
		$search_param,
		get_permalink($product->get_id())
	);

}

// Ground truth: grid uses `name-product lh-24 fw-medium link-underline cl-text-main`, list style
// uses `name-product h5 link-underline cl-text-main` instead.
$title_class = ( tfwc_get_product_style() === 'style-list' )
	? 'name-product h5 link-underline cl-text-main'
	: 'name-product lh-24 fw-medium link-underline cl-text-main';
?>
<a href="<?php echo esc_url($product_url) ;?>" class="<?php echo esc_attr( $title_class ); ?>"> <?php echo esc_html( $product->get_name() ); ?></a>