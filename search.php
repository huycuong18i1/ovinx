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

get_header(); ?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="wrap-content-area clearfix">
				<div id="primary" class="content-area">
				<div id="main" class="post-wrap">
					<?php
					$layout =themesflat_get_opt( 'shop_layout' );
					if (isset($_GET['sidebar'])){
						$layout = $_GET['sidebar'];
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
										$catalog_btn_change = isset($_GET['catalog_btn_change']) ? (int) $_GET['catalog_btn_change'] : themesflat_get_opt('catalog_btn_change');
										?>
										<div class="tf-shop-control">
											
												<div class="tf-group-filter">
													<?php if($catalog_btn_change == 1) {?>
														<a href="#filterShop" data-bs-toggle="offcanvas" aria-controls="filterShop" class="tf-btn-filter">
															<span class="icon icon-filter"></span><span class="text"><?php echo esc_html__('Filter','ovinx');?></span>
														</a>

														<div class="offcanvas offcanvas-start canvas-sidebar canvas-filter" id="filterShop" aria-modal="true" role="dialog" style="z-index: 100000;">
															<div class="canvas-wrapper">
																<div class="canvas-header">
																	<span class="title"><?php echo esc_html__('Filter','ovinx')?></span>
																	<div class="icon-close icon-close-popup" data-bs-dismiss="offcanvas" aria-label="Close"></div>
																</div>
																<div class="canvas-body">
																	<?php dynamic_sidebar('shop-sidebar');?>
																</div>
															</div>
														</div>
													<?php } ?>

													<?php if($layout == 'sidebar-left' || $layout == 'sidebar-right') {?>
														<a href="#filterShop"  class="tf-btn-filter d-flex d-xl-none">
															<span class="icon icon-filter"></span><span class="text"><?php echo esc_html__('Filter','ovinx');?></span>
														</a>
													<?php } ?>

													<?php if(themesflat_get_opt('catalog_sort_by') == 1) { ?>
														<div class="tf-dropdown-sort" data-bs-toggle="dropdown">
															<div class="btn-select">
																<span class="text-sort-value"><?php echo esc_html__('Alphabetically, A-Z','ovinx');?></span>
																<span class="icon icon-arr-down"></span>
															</div>
															<div class="dropdown-menu">
																<div class="select-item " data-sort-value="best-selling">
																<span class="text-value-item"><?php echo esc_html__('Best selling','ovinx');?></span>
																</div>
																<div class="select-item active" data-sort-value="a-z">
																<span class="text-value-item"><?php echo esc_html__('Alphabetically, A-Z','ovinx');?></span>
																</div>
																<div class="select-item" data-sort-value="z-a">
																<span class="text-value-item"><?php echo esc_html__('Alphabetically, Z-A','ovinx');?></span>
																</div>
																<div class="select-item" data-sort-value="price-low-high">
																<span class="text-value-item"><?php echo esc_html__('Price, low to high','ovinx');?></span>
																</div>
																<div class="select-item" data-sort-value="price-high-low">
																<span class="text-value-item"><?php echo esc_html__('Price, high to low','ovinx');?></span>
																</div>
															</div>
														</div>
														
													<?php } ?>
												</div>
											
											<?php if(themesflat_get_opt('catalog_view') == 1) {?>
												<?php

												$number_view = isset($_GET['number_view']) && is_numeric($_GET['number_view']) ? (int) $_GET['number_view'] : themesflat_get_opt('number_view');
												$number_view_active = isset($_GET['number_view_active']) && is_numeric($_GET['number_view_active']) ? (int) $_GET['number_view_active'] : themesflat_get_opt('number_view_active');

												$product_style = isset($_GET['product_style']) ? $_GET['product_style'] : themesflat_get_opt('product_style');
												if (isset($_POST['product_style'])) {
													$product_style = $_POST['product_style'];
												}
												
												if( $product_style == 'style-list') {
													// $product_style = 'style-list';
													$number_view_active = 1;
												}
												?>

												<ul class="tf-control-layout">
													<?php $number_view_active_class = ($number_view_active == 1) ? ' active' : ''; ?>
													<li class="tf-view-layout-switch sw-layout-1 style-list <?php echo esc_attr($number_view_active_class); ?>" data-value-layout="tf-col-1" data-style="style-list">
														<div class="item icon-list">
															<span></span>
															<span></span>
														</div>
													</li>
													<?php
													for ($i = 2; $i <= $number_view; $i++) {
														$layout_class = 'sw-layout-' . $i;
														$icon_class = 'icon-grid-' . $i;
														$active_class = ($i == $number_view_active) ? 'active' : ''; 
													?>
														<li class="tf-view-layout-switch <?php echo esc_attr($layout_class); ?> <?php echo esc_attr($active_class); ?>" data-value-layout="tf-col-<?php echo esc_attr($i); ?>" data-style="<?php echo esc_attr($product_style); ?>">
															<div class="item <?php echo esc_attr($icon_class); ?>">
																<?php 
																for ($j = 1; $j <= $i; $j++) {
																	echo '<span></span>';
																}
																?>
															</div>
														</li>
													<?php } ?>
												</ul>

											<?php } ?>
										</div>
									<?php } ?>
								</div>

								<div class="meta-filter-shop" >
									<div id="product-count-grid" class="count-text"></div>
									<div id="applied-filters" class="selected-filters"></div>
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