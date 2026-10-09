<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
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

use Automattic\WooCommerce\Enums\ProductType;

defined( 'ABSPATH' ) || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
}

global $product;

if ( ! function_exists( 'tf_get_contents' ) ) {
	function tf_get_contents($contents) {
		if( !empty($contents) ){
			return $contents;
			// return wp_kses_post($contents);
		}
	}
}

// return;

add_filter( 'woocommerce_gallery_image_size', function() {
    return 'full';
});

$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$post_thumbnail_id = $product->get_image_id();
$wrapper_classes   = apply_filters(
	'woocommerce_single_product_image_gallery_classes',
	array(
		'woocommerce-product-gallery',
		'woocommerce-product-gallery--' . ( $post_thumbnail_id ? 'with-images' : 'without-images' ),
		'woocommerce-product-gallery--columns-' . absint( $columns ),
		'images',
	)
);

$wrapper_classes[] = '';
$gallery_classes = 'wrapper-gallery-scroll wrapper-gallery';
$gallery_layout = empty($_GET['gallery_layout']) ? themesflat_get_opt('tf_product_gallery_layout') : $_GET['gallery_layout'];
$preview_thumbs = 6;

switch( $gallery_layout ){
	case 'grid':
		$wrapper_classes[] = 'tf-product-media-wrap';
		$wrapper_classes[] = 'product-thumbs-slider';
		$wrapper_classes[] = 'tf-product-swiper-mobile';
		$wrapper_classes[] = 'thumbs-bottom';
		$gallery_classes .= ' flat-single-grid';
		$direction = "horizontal";
		break;
	case 'grid_style_2':
		$wrapper_classes[] = 'tf-product-media-wrap';
		$wrapper_classes[] = 'product-thumbs-slider';
		$wrapper_classes[] = 'tf-product-swiper-mobile';
		$wrapper_classes[] = 'thumbs-bottom';
		$gallery_classes .= ' flat-single-grid grid-style-2';
		$direction = "horizontal";
		break;
	case 'stacked':
		$wrapper_classes[] = 'tf-product-media-wrap';
		$wrapper_classes[] = 'product-thumbs-slider';
		$wrapper_classes[] = 'tf-product-swiper-mobile';
		$wrapper_classes[] = 'thumbs-bottom';
		$gallery_classes .= ' flat-single-grid stacked-style';
		$direction = "horizontal";
		break;
	case 'left_thumb':
		$wrapper_classes[] = 'product-thumbs-slider';
		$wrapper_classes[] = 'thumbs-slider';
		$wrapper_classes[] = 'thumbs-left';
		$wrapper_classes[] = 'row_left';
		$wrapper_classes[] = 'style-row';
		$wrapper_classes[] = 'tf-product-media-wrap';

		$gallery_classes .= ' swiper tf-product-media-main';
		$direction = "vertical";
		break;
	case 'right_thumb':
		$wrapper_classes[] = 'product-thumbs-slider';
		$wrapper_classes[] = 'thumbs-slider';
		$wrapper_classes[] = 'thumbs-right';
		$wrapper_classes[] = 'style-row';
		$wrapper_classes[] = 'tf-product-media-wrap';
		$gallery_classes .= ' swiper tf-product-media-main';
		$direction = "vertical";
		break;
	case 'bottom_thumb':
		/**
		 * Ground truth (product-detail.html) has no `.style-row` here — the base
		 * `.product-thumbs-slider{flex-direction:column}` (css/styles.css ~L14264, unconditional,
		 * no `.style-row` needed) already lays the thumbnail strip out as a horizontal row BELOW
		 * the main image. `.style-row` forces `flex-direction:row` instead (a *side-by-side*
		 * columns layout, meant for left_thumb/right_thumb only) — with it here the thumbnail
		 * strip got squeezed into a narrow left-hand sliver instead of sitting below the image.
		 */
		$wrapper_classes[] = 'product-thumbs-slider';
		$wrapper_classes[] = 'thumbs-slider';
		$wrapper_classes[] = 'thumbs-bottom';
		$wrapper_classes[] = 'tf-product-media-wrap';
		$gallery_classes .= ' swiper tf-product-media-main';
		$direction = "horizontal";
		break;
	case 'no_thumb':
		$wrapper_classes[] = 'product-thumbs-slider';
		$wrapper_classes[] = 'thumbs-slider';
		$wrapper_classes[] = 'no-thumbs';
		$wrapper_classes[] = 'tf-product-media-wrap';
		$gallery_classes .= ' swiper tf-product-media-main';
		$direction = "vertical";
		break;
	case 'middle_gallery':
		$wrapper_classes[] = 'product-thumbs-slider';
		$wrapper_classes[] = 'thumbs-slider';
		$wrapper_classes[] = 'no-thumbs';
		$wrapper_classes[] = 'middle-gallery';
		$wrapper_classes[] = 'tf-product-media-wrap';
		$gallery_classes .= ' swiper tf-product-media-main';
		$direction = "vertical";
		break;
	default:
		$gallery_layout = 'left_thumb';
		$wrapper_classes[] = 'product-thumbs-slider';
		$wrapper_classes[] = 'thumbs-slider';
		$wrapper_classes[] = 'thumbs-left';
		$wrapper_classes[] = 'row_left';
		$wrapper_classes[] = 'style-row';
		$wrapper_classes[] = 'tf-product-media-wrap';

		$gallery_classes .= ' swiper tf-product-media-main';
		$direction = "vertical";
		break;
}
?>

<div class="sticky-top">
	<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>" style="<?php echo esc_attr('opacity: 0; transition: opacity .25s ease-in-out;'); ?>">
		<?php if( $gallery_layout == "left_thumb" || $gallery_layout == "right_thumb" || $gallery_layout == "bottom_thumb" || true) : ?>
			<div dir="ltr" class="swiper tf-product-media-thumbs other-image-zoom" data-preview="<?php echo esc_attr($preview_thumbs); ?>" data-direction="<?php echo esc_attr($direction); ?>">
				<div class="swiper-wrapper stagger-wrap">
				</div>
			</div>
			<?php ob_start(); ?>
		<?php endif; ?>
		<div dir="ltr" class="woocommerce-product-gallery__wrapper <?php echo esc_attr($gallery_classes); ?>">
			<?php
			if( $gallery_layout == "left_thumb" || $gallery_layout == "right_thumb" || $gallery_layout == "bottom_thumb" || true){
				ob_start();
			}
			if ( $post_thumbnail_id ) {
				$html = wc_get_gallery_image_html( $post_thumbnail_id, true );
			} else {
				$wrapper_classname = $product->is_type( ProductType::VARIABLE ) && ! empty( $product->get_available_variations( 'image' ) ) ?
					'woocommerce-product-gallery__image woocommerce-product-gallery__image--placeholder' :
					'woocommerce-product-gallery__image--placeholder';
				$html              = sprintf( '<div class="%s">', esc_attr( $wrapper_classname ) );
				$html             .= sprintf( '<img src="%s" alt="%s" class="wp-post-image lazyload" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'ovinx' ) );
				$html             .= '</div>';
			}

			echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id ); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped

			do_action( 'woocommerce_product_thumbnails' );

			if( $gallery_layout == "left_thumb" || $gallery_layout == "right_thumb" || $gallery_layout == "bottom_thumb") : 
				$contents = ob_get_clean();
			?>
				<div  class="swiper-wrapper">
					<?php echo tf_get_contents($contents); ?>
				</div>
			<?php else: ?>
				<?php $contents = ob_get_clean(); ?>
				<div  class="tf-swiper-wrapper-mobile">
					<?php echo tf_get_contents($contents); ?>
				</div>
			<?php endif; ?>
		</div>
		<?php if( $gallery_layout == "left_thumb" || $gallery_layout == "right_thumb" || $gallery_layout == "bottom_thumb" || true) :
			$contents = ob_get_clean();
		?>
			<div class="flat-wrap-media-product">
				<?php echo tf_get_contents($contents); ?>
				<?php if( $gallery_layout == "no_thumb" || $gallery_layout == "middle_gallery") : ?>
					<div class="thumbs-pagination style-2"></div>
					<div class="nav-swiper-group style-2">
						<div class=" nav-thumbs thumbs-prev">
							<span class="fw-normal"><?php _e('PRE', 'ovinx' ); ?></span>
						</div>
						<span class="text-main">/</span>
						<div class=" nav-thumbs thumbs-next">
							<span class="fw-normal"><?php _e('NEXT', 'ovinx' ); ?></span>
						</div>
					</div>
				<?php else: ?>
					<!-- <div class="swiper-button-prev nav-swiper thumbs-prev"></div> -->
					<!-- <div class="swiper-button-next nav-swiper thumbs-next"></div> -->
				<?php endif; ?>
			</div>

		<?php endif; ?>
		<?php if(themesflat_get_opt('tf_variation_gallery') && $product->is_type('variable') ): ?>
			<div class="tf-overlay-container hidden">
				<div class="tf-overlay">
				</div>
				<div class="spinner"></div>
			</div>
		<?php endif; ?>
	</div>
	<?php if( $gallery_layout !=="grid" ) : ?>
		<?php do_action( 'woocommerce_after_product_thumbnails' ); ?>
	<?php endif; ?>
</div>