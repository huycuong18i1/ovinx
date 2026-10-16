<?php
/**
 * Pagination - Show numbered pagination for catalog pages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/pagination.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 10.3.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$total   = isset( $total ) ? $total : wc_get_loop_prop( 'total_pages' );
$current = isset( $current ) ? $current : wc_get_loop_prop( 'current_page' );
$base    = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
$format  = isset( $format ) ? $format : '';

$per_page     = wc_get_loop_prop( 'per_page' );
$total_products        = wc_get_loop_prop( 'total' );

$end = min( $current * $per_page, $total_products );

$style = '';

if ( $total <= 1 ) {
	$style .= 'display:none;';
	// return;
}

$shop_pagination = themesflat_get_opt('shop_pagination');
$shop_loadmore_text = themesflat_get_opt('shop_loadmore_text');


if (isset($_GET['pagination'])) {
	$shop_pagination = sanitize_text_field($_GET['pagination']);
}

$pagination_ajax = themesflat_get_opt('pagination_ajax');
if (isset($_GET['pagination_ajax'])) {
	$pagination_ajax = sanitize_text_field($_GET['pagination_ajax']);
}

$pagination_ajax_class = '';
if ($pagination_ajax == 1) {
	$pagination_ajax_class = 'ajax-pagination';
}
$pagi_align = empty( ($_GET['shop_pagination_align']) ) ? themesflat_get_opt('shop_pagination_align') : sanitize_text_field($_GET['shop_pagination_align']);

$pagi_align_classes = 'align-items-center';
if ( $pagi_align == 'left' ) {
	$pagi_align_classes = 'align-items-start';
} elseif ( $pagi_align == 'right' ) {
	$pagi_align_classes = 'align-items-end';
}
?>

<?php
$width_line = 0;
if ( $total_products > 0 ) {
    $width_line = ($end / $total_products) * 100;
}
?>

<?php if($shop_pagination == 'number') { ?>
<?php
	/**
	 * Ground truth's real pagination component is `.tf-pagination > a/p.pag-item(.active)` (used
	 * for both Shop and Blog — see tpl/pagination.php's mục 2.4c fix, same pattern applied here) —
	 * WooCommerce's own `paginate_links()` only ever outputs its default `page-numbers`/`current`
	 * classes with no equivalent for `.pag-item`. UNLIKE blog pagination, shop's AJAX pagination
	 * click handler (js/shop.js) is hard-wired to the selector `.ajax-pagination a.page-numbers`,
	 * so `page-numbers` can't simply be replaced like blog's fix did — the real classes are ADDED
	 * alongside it instead, keeping the AJAX behavior working. Icons were also the wrong case
	 * (`icon-caret-left/-right` isn't ground truth's real icon; `icon-CaretLeft/-Right` is).
	 */
	$tfwc_pagination_links = paginate_links( apply_filters( 'woocommerce_pagination_args', array(
		'base'         => $base,
		'format'       => $format,
		'add_args'     => false,
		'current'      => max( 1, $current ),
		'total'        => $total,
		'prev_text'    => '<i class="icon icon-CaretLeft"></i>',
		'next_text'    => '<i class="icon icon-CaretRight"></i>',
		'end_size'     => 1,
		'mid_size'     => 1,
		'type'         => 'array',
	) ) );

	if ( ! empty( $tfwc_pagination_links ) ) {
		$tfwc_pagination_links = array_map( function ( $link ) {
			$link = str_replace( 'page-numbers current', 'page-numbers current pag-item active', $link );
			$link = str_replace( 'class="page-numbers"', 'class="page-numbers pag-item"', $link );
			// QA P3-09: the prev/next links only contain an icon.
			$link = str_replace( '<a class="next page-numbers', '<a aria-label="' . esc_attr__( 'Next page', 'ovinx' ) . '" class="next page-numbers', $link );
			$link = str_replace( '<a class="prev page-numbers', '<a aria-label="' . esc_attr__( 'Previous page', 'ovinx' ) . '" class="prev page-numbers', $link );
			return $link;
		}, $tfwc_pagination_links );
	}
?>
<nav class="woocommerce-pagination ovinx-shop-pagination <?php echo esc_attr($pagination_ajax_class);?> ">
	<div class="ovinx-pagi-wrapper d-flex flex-column justify-content-center gap-1 <?php echo esc_attr($pagi_align_classes); ?>">
		<div class="wg-pagination tf-pagination">
			<?php if ( ! empty( $tfwc_pagination_links ) ) : ?>
				<?php foreach ( $tfwc_pagination_links as $tfwc_pagination_link ) : ?>
					<?php echo wp_kses( $tfwc_pagination_link, ovinx_template_html_allowed_tags() ); ?>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>
</nav>
<?php } ?>

<?php if($shop_pagination == 'loadmore') { ?>
	<nav class="woocommerce-pagination loadmore wg-show-more ovinx-shop-pagination ovinx-load-more wd-load justify-content-center" style="<?php echo esc_attr($style); ?>" role="navigation">
		<div class="ovinx-pagi-wrapper d-flex flex-column justify-content-center align-items-center gap-1">
			<span class="showing-total-info" style="--pagi-info-line-width:<?php echo esc_attr($width_line); ?>%;">
				Showing <?php echo esc_html($end); ?> of <?php echo esc_html($total_products); ?> products
				<span class="pagi-info-line"> </span>
			</span>
			<button id="load-more-btn" class="btn-loadmore tf-btn tf-loading loadmore" data-page="2">
				<span class="text"><?php echo esc_html($shop_loadmore_text)?></span>
				<div class="spinner-circle" style="">
					<span class="spinner-circle1 spinner-child"></span>
					<span class="spinner-circle2 spinner-child"></span>
					<span class="spinner-circle3 spinner-child"></span>
					<span class="spinner-circle4 spinner-child"></span>
					<span class="spinner-circle5 spinner-child"></span>
					<span class="spinner-circle6 spinner-child"></span>
					<span class="spinner-circle7 spinner-child"></span>
					<span class="spinner-circle8 spinner-child"></span>
					<span class="spinner-circle9 spinner-child"></span>
				</div>
			</button>
		</div>
    </nav>
	
<?php } ?>

<?php if($shop_pagination == 'autoload') { ?>
	<nav class="woocommerce-pagination ovinx-shop-pagination autoload wd-load justify-content-center wg-show-more" style="<?php echo esc_attr($style); ?>" role="navigation">
		<div class="ovinx-pagi-wrapper d-flex flex-column justify-content-center align-items-center gap-1">
			<button id="autoload-btn" class="tf-btn btn-dark2 tf-loading animate-btn animate-dark" data-page="2">
				<div class="spinner-circle">
					<span class="spinner-circle1 spinner-child"></span>
					<span class="spinner-circle2 spinner-child"></span>
					<span class="spinner-circle3 spinner-child"></span>
					<span class="spinner-circle4 spinner-child"></span>
					<span class="spinner-circle5 spinner-child"></span>
					<span class="spinner-circle6 spinner-child"></span>
					<span class="spinner-circle7 spinner-child"></span>
					<span class="spinner-circle8 spinner-child"></span>
					<span class="spinner-circle9 spinner-child"></span>
				</div>
			</button>
		</div>
	</nav>
<?php } ?>