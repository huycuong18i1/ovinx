<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
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

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
$gallery_layout = empty($_GET['gallery_layout']) ? themesflat_get_opt('tf_product_gallery_layout') :  $_GET['gallery_layout'];

$class_main = apply_filters('tf_single_main_classes', 'tf-main-product');
$class_container = apply_filters('tf_single_container_classes', 'container');
$class_left_col = apply_filters('tf_single_left_col_classes', 'col-md-6');
$class_right_col = apply_filters('tf_single_right_col_classes', 'col-md-6');

$class_row = apply_filters('tf_single_row_classes', 'row');
?>
<section id="product-<?php the_ID(); ?>" <?php wc_product_class( 'tf-single-product flat-single-product', $product ); ?>>
	<div class="<?php echo esc_attr($class_main); ?> section-image-zoom">
		<div class="<?php echo esc_attr($class_container); ?>">
			<div class="<?php echo esc_attr($class_row); ?>">
				<!-- Product Images -->
				<div class="<?php echo esc_attr($class_left_col); ?> left-col">
					<?php
					/**
					 * Hook: woocommerce_before_single_product_summary.
					 *
					 * @hooked woocommerce_show_product_sale_flash - 10
					 * @hooked woocommerce_show_product_images - 20
					 */
					do_action( 'woocommerce_before_single_product_summary' );
					?>
				</div>
				<?php if( $gallery_layout == 'middle_gallery'){ ?>
					<div class="main-grid-b">
						<div class="main-product-info tf-product-info-list left sticky-top">
							<div class="tf-product-info-heading">
							<?php
								do_action( 'tf_single_product_summary_left' );
							?>
							</div>
						</div>
					</div>
				<?php } ?>
				<div class="<?php echo esc_attr($class_right_col); ?> right-col">
					<div class="tf-product-info-wrap sticky-top mt-md-0">
						<div class="tf-zoom-main"></div>
						<div class="tf-product-info-list other-image-zoom">
							<div class="tf-product-info-heading">
								<?php
								/**
								 * Hook: woocommerce_single_product_summary.
								 *
								 * @hooked woocommerce_template_single_title - 5
								 * @hooked woocommerce_template_single_rating - 10
								 * @hooked woocommerce_template_single_price - 10
								 * @hooked woocommerce_template_single_excerpt - 20
								 * @hooked woocommerce_template_single_add_to_cart - 30
								 * @hooked woocommerce_template_single_meta - 40
								 * @hooked woocommerce_template_single_sharing - 50
								 * @hooked WC_Structured_Data::generate_product_data() - 60
								 */
								do_action( 'woocommerce_single_product_summary' );
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php
/**
 * Hook: woocommerce_after_single_product_summary.
 *
 * @hooked woocommerce_output_product_data_tabs - 10
 * @hooked woocommerce_upsell_display - 15
 * @hooked woocommerce_output_related_products - 20
 */


remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
do_action( 'woocommerce_after_single_product_summary' );

if( themesflat_get_opt('related_display') == 1 || themesflat_get_opt('recently_display') == 1 ) {
	wc_get_template( 'tpl/product-single/rsection.php' );
}

if( themesflat_get_opt('upsell_display') == 1 || themesflat_get_opt('cross_sell_display') == 1 ) {
	wc_get_template( 'tpl/product-single/rsection2.php' );
}


?>

<?php do_action( 'woocommerce_after_single_product' ); ?>