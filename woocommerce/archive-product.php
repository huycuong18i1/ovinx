<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 10.3.4
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
} 

$layout = themesflat_get_opt( 'shop_layout' );

if (isset($_GET['sidebar'])){
	$layout = sanitize_text_field($_GET['sidebar']);
}

$filter_sticky = themesflat_get_opt( 'filter_sticky' );

if (isset($_GET['filter_sticky'])){
	$filter_sticky = sanitize_text_field($_GET['filter_sticky']);
}

$sticky_classes = "";

if ($layout !== 'filter-top' && !empty($filter_sticky) ){
	$sticky_classes .= " meta-wrap-sticky";
}

?>

<?php get_header();?>

<?php 
		wc_get_template( 'tpl/shop-control/control-filter.php' );
?>

<div class="container">
	<?php // Non-AJAX add-to-cart / coupon / etc. notices queued in the WC session (the shop loop is AJAX-first, so this is normally empty). ?>
	<?php woocommerce_output_all_notices(); ?>
	<div class="row">
		<div id="primary" class="content-area">

			<div id="main" class="post-wrap">

				<div class="content-woocommerce <?php echo esc_attr($sticky_classes); ?>">
					<?php if ( have_posts() ) : ?>								
							<?php if(themesflat_get_opt('catalog_toolbar') == 1) {

								if ( $layout == 'sidebar-left' || $layout == 'sidebar-right' ) {
								}elseif($layout == 'filter-top') {
									wc_get_template( 'tpl/shop-control/control-top.php' );
								}else{
									wc_get_template( 'tpl/shop-control/control.php' );
								}
								?>
							<?php } ?>
						<div class="row">
							<?php if ( $layout == 'sidebar-left' || $layout == 'sidebar-right' ) :
									$class_sidebar ='';
									if ($layout == 'sidebar-left') {
										$class_sidebar = 'left ';
									}

									if ($layout == 'sidebar-right') {
										$class_sidebar = 'right ';
									}
								?>
								<div class="filters-content col-xl-3 <?php echo esc_attr($class_sidebar)?>">
									<div class="canvas-sidebar sidebar-filter canvas-filter <?php echo esc_attr($class_sidebar)?>">
										<div class="canvas-wrapper">
											<div class="canvas-header">
												<div class="d-flex d-xl-none">
													<span class="icon icon-SlidersHorizontal"></span>
													<span class="text"><?php echo esc_html__('Show Filters','ovinx')?></span>
												</div>
												<h4 class="title d-none d-xl-block"><?php echo esc_html__('Filters','ovinx')?></h4>
												<h5 class="title d-none d-xl-none"><?php echo esc_html__('Filters','ovinx')?></h5>
											</div>
											<div class="canvas-body">
												<div class="apply-filter-wrap d-xl-none">
													<p class="title h6 fw-normal text-uppercase d-xl-none"><?php _e('Applied Filters', 'ovinx'); ?></p>
													<div id="product-count-grid" class="count-text d-xl-none py-1 text-caption-01" style="<?php echo esc_attr('display: none;'); ?>">
														<?php _e('No Filter Selected', 'ovinx'); ?>
													</div>
													<div class="meta-filter-shop d-xl-none">
														<div id="product-count-grid" class="count-text"></div>
														<div id="applied-filters" class="check-yes selected-filters"></div>
														<button id="" class="btn-check-none remove-all-filters" style="display: none;">
															<span class="text-body"><?php echo esc_html__('Clear all','ovinx')?></span>
														</button>
													</div>
												</div>
												<?php
													// wc_get_template( 'tpl/shop-control/filter-sidebar.php' );
													dynamic_sidebar('shop-sidebar');
													if ($layout !== 'filter-top') {
														dynamic_sidebar('after-shop-sidebar');
													}
												?>
											</div>
											<?php if( themesflat_get_opt('filter_sidebar_button') || !empty($_GET['filter_sidebar_button']) ) : ?>
												<div class="canvas-bottom d-xl-none">
													<button id="tf-reset-filter" class="tf-btn btn-reset tf-clear-filters-btn btn-white">
														<span class="fw-medium"><?php _e('CLEAR ALL', 'ovinx'); ?></span>
													</button>
													<button type="button" class="tf-btn btn-fill animate-btn tf-apply-filters-btn">
														<span class="fw-medium">
															<?php _e('APPLY', 'ovinx'); ?>
															<span class="apply-filter-count">[<?php echo esc_html($count); ?> ]</span>
														</span>
													</button>
												</div>
											<?php endif; ?>
										</div>
									</div>
									<div class="overlay-filter" id="overlay-filter"></div>
								</div>
							<?php endif; ?>

							<div class="products-content col-xl-9 flex-grow-1">
								<div class="products-content-wrap">
									<?php
										if ( ( $layout == 'sidebar-left' || $layout == 'sidebar-right' ) && themesflat_get_opt('catalog_toolbar') == 1 ) {
											wc_get_template( 'tpl/shop-control/control-sidebar.php' );
										}
									?>
									<?php
										$count = 0;
										woocommerce_product_loop_start();
									?>
									<?php woocommerce_product_subcategories(); ?>
									<?php while ( have_posts() ) : the_post(); ?>
										<?php
											$count++;
											wc_get_template_part( 'content', 'product' );
										?>
									<?php endwhile; // end of the loop. ?>
									<?php woocommerce_product_loop_end(); ?>

									<!-- woocommerce_after_main_content hook. -->
									<?php do_action( 'woocommerce_after_shop_loop' ); ?>
								</div>
							</div>

						</div>
					<?php else : ?>
<p class="woocommerce-info tf-no-results">
	<?php
	echo esc_html__(
		'No products were found matching your selection.',
		'ovinx'
	);
	?>

	<a
		href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>"
		class="tf-shop-link"
	>
		<?php esc_html_e( 'Go To Shop', 'ovinx' ); ?>
	</a>
</p>
					<?php endif; ?>
					<?php
					if ( class_exists( 'WooCommerce' ) ) {
						if ( is_product_category() ) {
							$term_id = get_queried_object()->term_id;

							$large_description = get_term_meta($term_id, '_large_description', true);
							
							if (!empty($large_description)) {
								echo '<div class="flat-spacing pb-0" id="large_des">
										<div class="container">';
										echo wp_kses_post($large_description);
								echo '</div>
								</div>';
							}
						}
					}
					?>
				</div>
			</div><!-- #main -->
		</div><!-- #primary -->
	</div><!-- /.row -->
</div><!-- /.container -->

<?php get_footer(); ?>