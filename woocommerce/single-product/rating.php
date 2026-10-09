<?php
/**
 * Single Product Rating
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/rating.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 10.3.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $product;

if ( ! wc_review_ratings_enabled() ) {
	return;
}

$rating_count = $product->get_rating_count();
$review_count = $product->get_review_count();
$average      = $product->get_average_rating();
// Ground truth's star icon only has 2 real states (filled / `.no-rate` empty) — there's no CSS
// anywhere for a clipped "partial fill" star, so round to the nearest whole star instead of
// leaving a half-lit star with no styling. Same rounding the real, verified-working rating widget
// elsewhere on the site uses (`product_infor_meta()` in class-single-product-hook.php).
$full_stars = round( $average );

$single_rating_icon_classes = '';

$is_single_rating = get_query_var('is_single_rating', false);
if( !empty( $is_single_rating )){
	$single_rating_icon_classes .= 'fs-24';
}

if ( $rating_count > 0 ) : ?>
	<div class="single-product-info-rate">
		<ul class="star-wrap <?php echo esc_attr( $single_rating_icon_classes ); ?>">
			<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
				<li class="icon icon-Star<?php echo esc_attr( $i > $full_stars ? ' no-rate' : '' ); ?>"></li>
			<?php endfor; ?>
		</ul>
		<?php
if ( empty( $is_single_rating ) ) {
	$rating_text = sprintf(
		_n(
			'%s review',
			'%s reviews',
			$review_count,
			'ovinx'
		),
		'<span class="count">' . esc_html( $review_count ) . '</span>'
	);
} else {
	$rating_text = sprintf(
		_n(
			'%s Rating',
			'%s Ratings',
			$review_count,
			'ovinx'
		),
		'<span class="count">' . esc_html( $review_count ) . '</span>'
	);
}
?>

<a
	href="#tab-reviews"
	class=" count-reviews <?php echo esc_attr( empty( $is_single_rating ) ? 'text-caption-01 cl-text-2' : '' ); ?>"
	rel="nofollow"
>
	(<?php echo wp_kses_post( $rating_text ); ?>)
</a>
	</div>
<?php //else: ?>
	<!-- <span class="count-review">(No review)</span> -->
<?php endif; ?>