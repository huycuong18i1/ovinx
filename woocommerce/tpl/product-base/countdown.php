<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

$end_time = null;
// QA P4-01: the product whose sale window drives the timer (parent for simple, first variation for variable).
$sale_product = $product;

if ( $product->is_type('variable') ) {
    $available_variations = $product->get_available_variations();

    if ( !empty($available_variations) ) {
        $first_variation_id = $available_variations[0]['variation_id'];
        $first_variation = wc_get_product( $first_variation_id );

        if ( $first_variation ) {
            $end_time     = $first_variation->get_date_on_sale_to();
            $sale_product = $first_variation;
        }
    }
}else{
    $end_time = $product->get_date_on_sale_to();
}

/**
 * No ground-truth page ever shows a countdown inside a shop-grid card (only the single product
 * page's `.countdown-v01` and the homepage's `.countdown-v02`, both far too wide for a card) —
 * `.product-countdown` itself is real (css/styles.css, hover positioning), but its former inner
 * wrapper class `countdown-v05` never existed anywhere. Compact CSS for
 * `.product-countdown .countdown__*` is added in styles.css, reusing the exact same
 * `.countdown__timer/__item/__value/__label` markup the count-down.js plugin builds for v01/v02,
 * so no new JS is needed — just a scaled-down real variant instead of a fake class.
 */
// QA P4-01: only while the sale is really active (is_on_sale() honours the schedule) and the end date is still in
// the future — DateTime::diff() ->days is always positive, so a past end date used to render e.g. "2439 days".
if( !empty($end_time) && $sale_product && $sale_product->is_on_sale() ){
    $current_time = new DateTime();
    $interval = $current_time->diff($end_time);
    $seconds_remaining = $interval->days * 86400 + $interval->h * 3600 + $interval->i * 60 + $interval->s;
    if( 0 === $interval->invert && $seconds_remaining > 0 ){
        ?>
        <div class="product-countdown">
            <div class="js-countdown cd-has-zero" data-timer="<?php echo esc_attr($seconds_remaining); ?>" data-labels="D,H,M,S"></div>
        </div>
        <?php
    }
}
?>