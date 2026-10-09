<?php
/**
 * Single Product Thumbnails
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-thumbnails.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     10.3.4
 */

defined( 'ABSPATH' ) || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
}

global $product;

$attachment_ids = $product->get_gallery_image_ids();
if( themesflat_get_opt('tf_product_video')){
	$video_url = $product->get_meta('_tf_video_url');
	$video_position = $product->get_meta('_tf_video_position');
	$video_thumb = $product->get_meta('_tf_video_thumb');
	if(!empty($video_url) ){
		array_push($attachment_ids, 'tf_video_position');
	}
}
if( themesflat_get_opt('tf_product_3d')){
	$model_viewer_url = $product->get_meta('_tf_3d_viewer_url');
	$model_viewer_position = $product->get_meta('_tf_3d_viewer_position');
	$model_viewer_thumb = $product->get_meta('_tf_3d_viewer_thumb');
	if(!empty($model_viewer_url) ){
		array_push($attachment_ids, 'tf_3d_viewer_position');
	}
}

if(!function_exists('render_video')){
	function render_video($url) {
		$videoExtensions = ['mp4', 'webm', 'ogg'];

		$pathInfo = pathinfo(parse_url($url, PHP_URL_PATH));
		$extension = strtolower($pathInfo['extension'] ?? '');

		if (in_array($extension, $videoExtensions)) {
			return "<video controls width='100%' preload='metadata' playsinline='true' autoplay='true' controls='' loop='' muted=''>
						<source src='" . htmlspecialchars($url) . "' type='video/{$extension}'>
					</video>";
		}

		if (preg_match('/(youtube\.com|youtu\.be)/', $url)) {
		parse_str(parse_url($url, PHP_URL_QUERY), $query);
			$videoId = $query['v'] ?? '';

			if (!$videoId) {
				if (preg_match('#youtu\.be/([^?\&]+)#', $url, $matches)) {
					$videoId = $matches[1];
				} elseif (preg_match('#/shorts/([^?\&]+)#', $url, $matches)) {
					$videoId = $matches[1];
				}
			}

			if ($videoId) {
				return "<iframe
					title='Product video'
					src='https://www.youtube.com/embed/{$videoId}'
					frameborder='0'
					allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share'
					allowfullscreen
				></iframe>";
			}
		}

		if (preg_match('/tiktok\.com/', $url)) {
			return "<iframe title='Product video' src='{$url}' frameborder='0' allow='autoplay; encrypted-media' allowfullscreen></iframe>";
		}

		if (preg_match('/instagram\.com/', $url)) {
			return "<iframe title='Product video' src='{$url}embed' frameborder='0' allowfullscreen></iframe>";
		}

		return "<iframe title='Product video' src='{$url}' frameborder='0' allowfullscreen></iframe>";
	}
}

if ( $attachment_ids && $product->get_image_id() ) {
	foreach ( $attachment_ids as $key => $attachment_id ) {
		/**
		 * Filter product image thumbnail HTML string.
		 *
		 * @since 1.6.4
		 *
		 * @param string $html          Product image thumbnail HTML string.
		 * @param int    $attachment_id Attachment ID.
		 */
		if( $attachment_id == 'tf_video_position' ) {
			?>
				<div class="swiper-slide slide-video">
					<div class="item" data-video-thumb="<?php echo esc_url($video_thumb); ?>">
						<?php echo render_video($video_url); ?>
					</div>
				</div>
			<?php
			continue;
		}

		if( $attachment_id == 'tf_3d_viewer_position' ) {
			?>
				<div class="swiper-slide slide-3d">
					<div class="item" data-model-viewer-thumb="<?php echo esc_url($model_viewer_thumb); ?>">
						<div class="tf-model-viewer">
							<model-viewer reveal="auto" toggleable="true" src="<?php echo esc_url($model_viewer_url); ?>" camera-controls="true" alt="<?php echo esc_html( $product->get_title() ); ?>" poster="<?php echo esc_url($model_viewer_thumb); ?>" class="tf-model-viewer-ui disabled" ar-status="not-presenting">
							</model-viewer>
							<div class="tf-model-viewer-ui-button">
								<div class="wrap-btn-viewer">
									<i class="icon icon-btn3d"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php
			continue;
		}

		echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', wc_get_gallery_image_html( $attachment_id, true, $key ), $attachment_id ); // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}