<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;
$stock_available  = 0; 
$stock_sold       = 0; 

$total_sales = get_post_meta( $product->get_id(), 'total_sales', true );
$stock = get_post_meta($product->get_id(), '_stock', true );

if (is_numeric($total_sales)) {
    $stock_sold = round(floatval($total_sales));
}

if (is_numeric($stock)) {
    $stock_available = round(floatval($stock));
}

if ($stock_available + $stock_sold > 0) {
    $percentage = round(($stock_sold / ($stock_available + $stock_sold)) * 100);
} else {
    $percentage = 0; 
}

if( $stock_available && $percentage > 0) { 
    $class = $class_text = '';
    if($stock_available > 3) {
        $class = "bg-green-2";
        $class_text = "text-success-5";
    }
    
    ?>
    <div class="product-progress-sale">
        <div class="progress-cart" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="<?php echo esc_attr( $percentage ); ?>" aria-label="<?php esc_attr_e( 'Sold', 'ovinx' ); ?>">
            <div class="value <?php echo esc_attr($class);?>" style="<?php echo esc_attr( 'width:' . $percentage . '%' ); ?>"></div>
        </div>
        <?php if(!empty($show_sold_count)) : ?>
            <div class="d-flex justify-content-between">
                <p class="text-sold text-sm mt-1">
                    <?php echo esc_html('Sold:','ovinx');?>
                    <span class="fw-medium text-primary">
                        <?php echo number_format_i18n( $stock_sold );?>
                    </span>
                </p>
                <p class="text-avaiable text-sm mt-1">
                    <?php echo esc_html('Available:','ovinx');?>
                    <span class="fw-medium text-red-2 <?php echo esc_attr($class_text);?>">
                        <?php echo number_format_i18n( $stock_available );?>
                    </span>
                </p>
            </div>
        <?php else: ?>
            <p class="text-avaiable text-sm mt-1"><?php echo esc_html('Available:','ovinx');?> <span class="fw-medium text-red-2 <?php echo esc_attr($class_text);?>"><?php echo number_format_i18n( $stock_available );?></span></p>
        <?php endif; ?>
    </div>
<?php } ?>