<?php
/**
 * @package ovinx
 */

if ( themesflat_get_opt( 'footer_newsletter_enabled' ) != 1 ) {
	return;
}

$footer_newsletter_title       = themesflat_get_opt( 'footer_newsletter_title' );
$footer_newsletter_description = themesflat_get_opt( 'footer_newsletter_description' );
$footer_newsletter_shortcode   = themesflat_get_opt( 'footer_newsletter_shortcode' );
?>
<div class="section-cta bg-surface flat-spacing-2" role="region" aria-label="<?php esc_attr_e( 'Newsletter', 'ovinx' ); ?>">
	<div class="container">
		<div class="row align-items-center gy-30">
			<div class="col-md-5 col-xl-6">
				<?php if ( $footer_newsletter_title != '' ) : ?>
					<h3 class="h4 mb-12"><?php echo wp_kses_post( $footer_newsletter_title ); ?></h3>
				<?php endif; ?>
				<?php if ( $footer_newsletter_description != '' ) : ?>
					<p class="text-secondary"><?php echo wp_kses_post( $footer_newsletter_description ); ?></p>
				<?php endif; ?>
			</div>
			<div class="col-md-7 col-xl-6">
				<div class="col-right">
					<?php if ( $footer_newsletter_shortcode != '' ) : ?>
						<?php echo do_shortcode( html_entity_decode( $footer_newsletter_shortcode ) ); ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>
