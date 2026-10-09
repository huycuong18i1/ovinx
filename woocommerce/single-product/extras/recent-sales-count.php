<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

if(themesflat_get_opt('fake_sold')){
    $sold_last_24_hours = $product->get_meta('_sold_last_24_hours');
    $last_updated = $product->get_meta('_last_sold_update');
    $random_from = max(1, themesflat_get_opt('fake_sold_random_from'));
    $random_to = max(1, themesflat_get_opt('fake_sold_random_to'));
    $interval = max(1, themesflat_get_opt('fake_sold_interval'));
    $increment_max = max(1, themesflat_get_opt('fake_sold_increment_max'));
    $text = themesflat_get_opt('fake_sold_text');

    if (!$sold_last_24_hours) {
        $sold_last_24_hours = rand($random_from, $random_to);
        $product->update_meta_data('_sold_last_24_hours', $sold_last_24_hours);
    }

    if (!$last_updated || (time() - $last_updated) > $interval * 60) {

        $increment = rand(1, $increment_max);
        $sold_last_24_hours += $increment;
        $last_updated = time();

        $product->update_meta_data('_sold_last_24_hours', $sold_last_24_hours);

        $product->update_meta_data('_last_sold_update', $last_updated);

        $product->save();
    }

    $last_updated_date = date('Y-m-d', $last_updated);
    $current_date = date('Y-m-d');
    
    if ($last_updated_date != $current_date) {
        $sold_last_24_hours = rand($random_from, $random_to);
        $product->update_meta_data('_sold_last_24_hours', $sold_last_24_hours);
        $product->update_meta_data('_last_sold_update', time());
    }

}else{
    return;
}

?>
<div class="infor_sold">
    <i class="icon icon-Lightning tf-ani-flash"></i>
    <?php echo esc_html( "$sold_last_24_hours $text"); ?>
</div>