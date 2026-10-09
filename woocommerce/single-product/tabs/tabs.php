<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
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
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );

$product_tabs_style = themesflat_get_opt('tf_product_tabs_style');
$class = '';
if (isset($_GET['tab_style'])){
	$product_tabs_style = sanitize_text_field($_GET['tab_style']);
}
$referer = wp_get_referer();
$is_comment_tab_active = ( $referer && strpos( $referer, '#comment-' ) !== false );

if ($product_tabs_style == 'default' ) {
	$class =  'tf-product-tabs tab-product-desc';
} else {
	$class =  'tf-product-tabs tab-vertical-product-desc';
}

if ( ! empty( $product_tabs ) ) : ?>

<section class="section-product-description flat-spacing flat-animate-tab">
		<?php if ($product_tabs_style == 'default' || $product_tabs_style == 'verticle') { ?>
			<div class="flat-animate-tab <?php echo esc_attr($class); ?>  ">
				<ul class="list-tab-btn-v1 tabs wc-tabs" role="tablist">
					<?php $count = 1; foreach ( $product_tabs as $key => $product_tab ) : ?>
						<li class="<?php echo esc_attr( $key ); ?>_tab nav-tab-item " id="tab-title-<?php echo esc_attr( $key ); ?>" role="presentation">
							<a href="#tab-<?php echo esc_attr( $key ); ?>" role="tab" aria-controls="tab-<?php echo esc_attr( $key ); ?>" data-bs-toggle="tab" aria-selected="true" class="tab-link h6 tf-btn-tab <?php if ( ($count == 1 && !$is_comment_tab_active) || ($is_comment_tab_active && $key == 'reviews') ){ echo 'active';}?>">
								<span class="text">
									<?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
								</span>	
							</a>
						</li>
					<?php $count++; endforeach;  ?>
				</ul>
				<div class="tab-content">
				<?php $count = 1; foreach ( $product_tabs as $key => $product_tab ) : ?>
						<div class="tab-pane <?php if( ($count == 1 && !$is_comment_tab_active) || ($is_comment_tab_active && $key == 'reviews') ){ echo 'active show';} ?>  wd-product-descriptions woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr( $key ); ?> panel entry-content wc-tab <?php echo esc_attr($key == "reviews" ? "widget-review" : ""); ?>" id="tab-<?php echo esc_attr( $key ); ?>" role="tabpanel" aria-labelledby="tab-title-<?php echo esc_attr( $key ); ?>">
						<?php
						if ( isset( $product_tab['callback'] ) ) {
							call_user_func( $product_tab['callback'], $key, $product_tab );
						}
						?>
					</div>
				<?php $count++; endforeach; ?>
				</div> 
				<?php do_action( 'woocommerce_product_after_tabs' ); ?>
			</div>
		<?php } else { ?>
			<div class="tf-product-accordion">
			<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
				<div class="widget-accordion wd-product-descriptions accordion-item_v2 style-2 nav-tab-item">				
					<div class="accordion-title accordion-action h5 fw-medium collapsed" data-bs-target="#tab-<?php echo esc_attr( $key ); ?>" data-bs-toggle="collapse" aria-expanded="false" aria-controls="tab-<?php echo esc_attr( $key ); ?>" role="button">
						<span><?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?></span>
						<span class="icon ic-accordion-custom cl-2"></span>
					</div>
					<div id="tab-<?php echo esc_attr( $key ); ?>" class="collapse <?php echo esc_attr($key == "reviews" ? "widget-review" : ""); ?>">
						<div class="<?php echo esc_attr($key == "reviews" ? "" : "accordion-body accordion-content tab-content_desc"); ?>">
						<?php
							if ( isset( $product_tab['callback'] ) ) {
								call_user_func( $product_tab['callback'], $key, $product_tab );
							}
						?>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
			</div>
		<?php } ?>
</section>


<?php endif; ?>
