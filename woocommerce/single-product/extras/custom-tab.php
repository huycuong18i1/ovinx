<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

$custom_tab_content = themesflat_get_opt('tf_product_custom_tab_content');  

?>

<div>
    <span class="cl-text-2">
        <?php echo wp_kses_post($custom_tab_content); ?>
    </span>
</div>