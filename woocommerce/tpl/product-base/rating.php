<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $product;

if ( ! $product->get_rating_count() ) {
	return;
}

$average_rating = $product->get_average_rating();
$review_count   = $product->get_review_count();
$rounded_rating = round( $average_rating );

// Ground truth: grid's star-wrap/count use `fs-12`/`text-caption-01` sizing, list style leaves
// both at their default size (no extra size classes).
$is_list_style   = ( tfwc_get_product_style() === 'style-list' );
$star_wrap_class = $is_list_style ? 'star-wrap gap-0' : 'star-wrap fs-12 gap-0';
$count_class     = $is_list_style ? '' : 'text-caption-01';
?>
<div class="rating-wrap">
	<div class="<?php echo esc_attr( $star_wrap_class ); ?>">
		<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
			<i class="icon icon-Star<?php echo esc_attr( $i > $rounded_rating ? ' cl-text-mute' : '' ); ?>"></i>
		<?php endfor; ?>
	</div>
	<span class="<?php echo esc_attr( $count_class ); ?>">&nbsp;(<?php echo esc_html( $review_count ); ?>)</span>
</div>
