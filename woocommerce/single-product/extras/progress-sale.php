<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

if(themesflat_get_opt('progress_sale')){
    $text = themesflat_get_opt('progress_sale_text');
    $sub_text = themesflat_get_opt('progress_sale_subtext');
    $low_stock = themesflat_get_opt('progress_sale_low_stock');
}else{
    return;
}

$stock_quantity = $product->get_stock_quantity();
$total_sales =  $product->get_total_sales();
$low_stock_threshold = $product->get_low_stock_amount();
if ( empty($low_stock_threshold) ) {
    $low_stock_threshold = $low_stock;
}
$status_class = "";

if ($stock_quantity > 0 && $total_sales > 0) {
    $percent_left = ($stock_quantity / ($total_sales + $stock_quantity) ) * 100;
    $percent_sold = 100 - $percent_left;
} else {
    return;
}

if ($stock_quantity <= $low_stock_threshold){
    $status_class .= "bg-danger";
}

?>

<?php
/**
 * Markup follows ground truth `ovinx-html/product-stock-bar.html` (`.tf-product-progress-sale`: title ->
 * `.progress-cart` bar -> sold/left line) so the theme's existing CSS styles it. `product-info-progress-sale`
 * is kept only as the JS hook (single-product.js animates `.value` to its `data-progress`).
 */
?>
<div class="tf-product-progress-sale product-info-progress-sale">
    <p class="title fw-semibold text-uppercase cl-text-main mb-8"><?php echo esc_html($text); ?></p>

    <div class="progress-cart mb-4">
        <div class="value <?php echo esc_attr($status_class); ?>" style="width: 0%;" data-progress="<?php echo esc_attr($percent_left); ?>"></div>
    </div>

    <p class="infor_sold">
        <?php
        echo wp_kses(
            strtr($sub_text, [
                '{total_sales}' => "{$total_sales}",
                '{count}'  => "<span class='count'>{$stock_quantity}</span>",
            ]),
            [
                'span' => [
                    'class' => true
                ]
            ]
        );
        ?>
    </p>
</div>