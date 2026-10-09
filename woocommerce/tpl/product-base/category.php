<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;
$categories = get_the_terms($product->get_id(), 'product_cat');

if ($categories) {
    foreach ($categories as $category) {
        echo '<a class="product-cate text-label fw-semibold" href="'.esc_url( get_term_link( $category ) ).'">' . esc_html($category->name) .'</a>';
        break;
    }
}

?>