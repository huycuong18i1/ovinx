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

$placeholder = wc_placeholder_img_src();

?> 


<a href="<?php echo esc_url($product_url); ?>" class="product-img">	
	<?php
		$main_image    = $product->get_image_id() ? wp_get_attachment_image_url($product->get_image_id(), 'themesflat-product') : '';
		if(empty($main_image)) {
			$main_image = wc_placeholder_img_src();
		}
		$gallery_images = $product->get_gallery_image_ids();
		$second_image  = (!empty($gallery_images)) ? wp_get_attachment_image_url($gallery_images[0], 'themesflat-product') : '';

		echo '<img class="img-product lazyload main-img" src="' . esc_url($placeholder) . '" data-src="' . esc_url($main_image) . '" alt="' . esc_attr($product->get_name()) . '">';

		
		if ($second_image) {
			echo '<img class="img-hover lazyload second-img " src="' . esc_url($placeholder) . '" data-src="' . esc_url($second_image) . '" alt="' . esc_attr($product->get_name()) . '">';
		}

		// Moved inside .product-img (instead of the wider .card-product_wrapper, which has its own
		// 16px padding) so the marquee ribbon sits flush against the actual photo edges.
		if ( $product->get_stock_status() == 'instock' && ! empty( $product->get_meta( '_tfwc_sale_marquee_text' ) ) ) {
			wc_get_template( 'tpl/product-base/sale-marquee.php' );
		}
	?>
</a>

