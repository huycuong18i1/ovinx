<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

if(themesflat_get_opt('tf_countdown')){
    $text = themesflat_get_opt('tf_countdown_text');
    $sub_text = themesflat_get_opt('tf_countdown_subtext');
    $classes = '';
    if($product->is_type('variable')){
        /**
         * A variable product's parent has no single sale window to check (each variation can have
         * its own) — this used to fall through and render the full countdown block anyway with a
         * `hidden` class meant to CSS-hide it, but `.hidden` isn't a real class in this theme
         * (Bootstrap 5 uses `.d-none`; nothing defines `.hidden{display:none}`), so it rendered
         * visibly showing a meaningless "0Days0Hours0Mins0Secs" on every variable product's page.
         * Same "don't show without a real sale window" rule as the simple-product branch below.
         */
        return;
    }else{
        $classes .= ' show';
        $sale_start_date = $product->get_date_on_sale_from();
        $sale_end_date = $product->get_date_on_sale_to();

        if ( ! ($product->is_on_sale() && $sale_start_date && $sale_end_date) ) {
            return;
        }
        $current = new DateTime();
        $interval = $current->diff($sale_end_date);
        $seconds_remaining = $interval->days * 86400 + $interval->h * 3600 + $interval->i * 60 + $interval->s;

        if( new DateTime($sale_start_date) > $current || !$seconds_remaining > 0 ){
            return;
        }
    }
}else{
    return;
}
?>

<span class="br-line"></span>
<div class="tf-product-countdown-timer product-info-countdown <?php echo esc_attr($classes); ?>">
    <p class="cl-text-main text-uppercase fw-semibold">
        <?php echo esc_html($text); ?>
        <?php if( !empty($sub_text) ) : ?>
            <br class="d-none d-sm-block d-md-none d-lg-block">
            <?php echo esc_html($sub_text); ?>
        <?php endif; ?>
    </p>
    <div class="countdown-v01">
        <div class="js-countdown tf-countdown-box cd-has-zero cd-custom" data-labels="Days,Hours,Mins,Secs" data-timer="<?php echo esc_attr($seconds_remaining); ?>"></div>
    </div>
</div>
<span class="br-line mb-30"></span>
