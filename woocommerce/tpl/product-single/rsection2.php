<?php
global $product;

/**
 * Same empty-tab fix as tpl/product-single/rsection.php — see the comment there.
 * "You May Also Like" lists the product's real upsells (up-sells.php) and "Cross Sell Product"
 * its real cross-sells (cross-sells.php) — they used to include related.php / recently.php by mistake,
 * so both tabs duplicated the other pair and the configured upsell/cross-sell products never showed.
 */

$tabs = array();

if ( themesflat_get_opt('upsell_display') == 1 ) {
	ob_start();
	wc_get_template( 'tpl/product-single/up-sells.php' );
	$upsell_html = trim( ob_get_clean() );

	if ( '' !== $upsell_html ) {
		$tabs['tf-single-upsell'] = array(
			'heading' => themesflat_get_opt('upsell_heading'),
			'html'    => $upsell_html,
		);
	}
}

if ( themesflat_get_opt('cross_sell_display') == 1 ) {
	ob_start();
	wc_get_template( 'tpl/product-single/cross-sells.php' );
	$cross_sell_html = trim( ob_get_clean() );

	if ( '' !== $cross_sell_html ) {
		$tabs['tf-single-cross-sell'] = array(
			'heading' => themesflat_get_opt('cross_sell_heading'),
			'html'    => $cross_sell_html,
		);
	}
}

if ( empty( $tabs ) ) {
	return;
}
?>

<section class="flat-animate-tab rsection tf-rsection pb-0">
		<ul class="tab-btn-wrap-v1 style-2 justify-content-sm-center list-tab-btn-v1 style-2" role="tablist">

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
