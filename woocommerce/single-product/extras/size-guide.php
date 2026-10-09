<?php
defined( 'ABSPATH' ) || exit;
if ( ! function_exists( 'tf_get_contents' ) ) {
	function tf_get_contents($contents) {
		if( !empty($contents) ){
			return $contents;
			// return wp_kses_post($contents);
		}
	}
}
global $product;
if( empty($product) ){
    $product = wc_get_product(get_the_ID());
}

if( empty($product) ){
    return;
}

$size_guide_data = $product->get_meta('_tf_size_guide_data');
$size_guide_table_data = get_post_meta($size_guide_data, '_size_guide_table_data', true);
$size_guide_table_data = json_decode($size_guide_table_data, true);
$size_guide_table_name = get_post_meta($size_guide_data, '_size_guide_table_name', true);
$size_guide_table_desc = get_post_meta($size_guide_data, '_size_guide_table_desc', true);
$size_guide_table_image = get_post_meta($size_guide_data, '_size_guide_table_image', true);
?>

<div class="tf-table-res-df mb-20">
    <?php if( !empty($size_guide_table_name) ) : ?>
        <div class="title h6 fw-medium mb-16 cl-text-main"><?php echo esc_html($size_guide_table_name); ?></div>
    <?php endif; ?>
    
    <?php if( !empty($size_guide_table_data) ) : ?>
        <div class="overflow-auto">
            <table class="tf-sizeguide-table">
                <thead>
                    <tr>
                        <?php $th = array_shift($size_guide_table_data); ?>
                        <?php foreach( $th as $value) : ?>
                            <th><?php echo esc_html($value); ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach( $size_guide_table_data as $row) : ?>
                        <tr>
                        <?php foreach( $row as $value) : ?>
                            <th><?php echo esc_html($value); ?></th>
                        <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<div>
    <?php echo tf_get_contents($size_guide_table_desc); ?>
</div>
