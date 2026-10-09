<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

$content = $product->get_short_description();
if( empty( $content ) ) {
	return;
}
?>
<p class="description text-caption-01 mb-10"><?php echo wp_kses_post($content);?> </p>
