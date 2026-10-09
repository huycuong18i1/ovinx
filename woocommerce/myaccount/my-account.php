<?php
/**
 * My Account page — outer row/column wrapper matching ovinx-html's account-page.html
 * (`.flat-spacing-mix-1 > .container > .row > .col-lg-3` nav + `.col-lg-9.ms-auto` content).
 *
 * @package ovinx
 */

defined( 'ABSPATH' ) || exit;
?>
	<div class="container">
		<div class="row">
			<div class="col-lg-3">
				<?php do_action( 'woocommerce_account_navigation' ); ?>
			</div>
			<div class="col-lg-9 ms-auto">
				<div class="my-account-content woocommerce-MyAccount-content">
					<?php do_action( 'woocommerce_account_content' ); ?>
				</div>
			</div>
		</div>
	</div>
