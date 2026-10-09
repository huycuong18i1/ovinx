<?php
global $product;

/**
 * Each tab's own template (related.php/recently.php) already renders nothing when it has no
 * products, but this wrapper used to show the tab button + empty tab-pane regardless (gated
 * only by the Customizer on/off toggle, not by whether there's actually anything to show) —
 * rendering into a buffer first lets us skip a tab (or the whole section) that has no content.
 */

$tabs = array();

if ( themesflat_get_opt('related_display') == 1 ) {
	ob_start();
	wc_get_template( 'tpl/product-single/related.php' );
	$related_html = trim( ob_get_clean() );

	if ( '' !== $related_html ) {
		$tabs['tf-single-related'] = array(
			'heading' => themesflat_get_opt('related_heading'),
			'html'    => $related_html,
		);
	}
}

if ( themesflat_get_opt('recently_display') == 1 ) {
	ob_start();
	wc_get_template( 'tpl/product-single/recently.php' );
	$recently_html = trim( ob_get_clean() );

	if ( '' !== $recently_html ) {
		$tabs['tf-single-recently'] = array(
			'heading' => themesflat_get_opt('recently_heading'),
			'html'    => $recently_html,
		);
	}
}

if ( empty( $tabs ) ) {
	return;
}
?>

<section class="flat-spacing p-0 flat-animate-tab rsection">
		<ul class="tab-btn-wrap-v1 style-2 justify-content-sm-center list-tab-btn-v1" role="tablist">

			<?php $tab_index = 0; foreach ( $tabs as $tab_id => $tab ) : $tab_index++; ?>
				<li class="nav-tab-item" role="presentation">
					<a href="#<?php echo esc_attr( $tab_id ); ?>" data-bs-toggle="tab" class="tf-btn-tab h4 <?php echo esc_attr( 1 === $tab_index ? 'active' : '' ); ?>" role="tab">
						<span class="tab-title">
							<?php echo esc_html( $tab['heading'] ); ?>
						</span>
					</a>
				</li>
			<?php endforeach; ?>

		</ul>

		<div class="tab-content">

			<?php $tab_index = 0; foreach ( $tabs as $tab_id => $tab ) : $tab_index++; ?>
				<div class="tab-pane <?php echo esc_attr( 1 === $tab_index ? 'active show' : '' ); ?>" id="<?php echo esc_attr( $tab_id ); ?>" role="tabpanel">
					<?php echo wp_kses( $tab['html'], ovinx_template_html_allowed_tags() ); // markup from this theme's own templates ?>
				</div>
			<?php endforeach; ?>

		</div>

</section>
