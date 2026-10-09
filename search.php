<?php
/**
 * The template for displaying search results pages.
 *
 * @package ovinx
 */

// Without WooCommerce there is no product catalogue to search: show the normal post list (index.php) for the results.
if ( ! class_exists( 'WooCommerce' ) ) {
	get_template_part( 'index' );
	return;
}

get_header();

wc_get_template( 'tpl/shop-control/control-filter.php' );
?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="wrap-content-area clearfix">
				<div id="primary" class="content-area">
				<div id="main" class="post-wrap">
					<?php
					$layout =themesflat_get_opt( 'shop_layout' );
					if (isset($_GET['sidebar'])){
						$layout = sanitize_text_field( wp_unslash( $_GET['sidebar'] ) );
					}

					$shop_products_per_page = 8;
					if(function_exists('themesflat_get_opt')){
						$shop_products_per_page = themesflat_get_opt('shop_products_per_page');
					}

					$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
					$search_query = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';

					$args = array(
						'post_type' => 'product',
						'posts_per_page' => $shop_products_per_page,
						'paged' => $paged,
						's' => $search_query,
						'post_status' => 'publish',
					);

					$search_products = new WP_Query($args);

					?>

					<div class="content-woocommerce">
						<div class="products-content">
							
							<?php if ( $search_products->have_posts() ) : ?>
								<div class="meta-wrap clearfix">
									<?php do_action( 'woocommerce_before_shop_loop' ); ?>
									<?php if(themesflat_get_opt('catalog_toolbar') == 1) {
										// Same toolbar as the shop page (tpl/shop-control/*). This page has no sidebar column, so the
										// sidebar layouts use the full-width bar ("Show Filters" button + off-canvas filters, sort, layout switch).
										if ( 'filter-top' === $layout ) {
											wc_get_template( 'tpl/shop-control/control-top.php' );
										} else {
											wc_get_template( 'tpl/shop-control/control.php' );
										}
									} ?>
								</div>
								<?php woocommerce_product_loop_start();								

								?>
								
								<?php while ( $search_products->have_posts() ) : $search_products->the_post(); ?>
									<?php wc_get_template_part( 'content', 'product' ); ?>
								<?php endwhile; ?>
								<?php woocommerce_product_loop_end(); ?>

								<?php do_action( 'woocommerce_after_shop_loop' ); ?>
								<?php
									set_query_var( 'total', $search_products->max_num_pages );
									set_query_var( 'current', max( 1, $paged ) );
									get_template_part( 'woocommerce/loop/pagination' );
								
								?>
								
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
						</div>
					</div>

					<?php

					wp_reset_postdata(); ?>
					
					</div><!-- #main -->
					
				</div><!-- #primary -->
				
			</div><!-- /.wrap-content-area -->
		</div><!-- /.col-md-12 -->
	</div>
</div>
<?php get_footer(); ?>