<?php
/**
 * My Account navigation
 *
 * Matches ovinx-html's account-page.html sidebar (`.my-account-nav > a.link-account`, real CSS at
 * css/styles.css:10580). Ground truth has no mobile equivalent (sidebar is desktop-only, `d-lg-block d-none`)
 * — the offcanvas fallback below is an addition for real mobile UX, reusing the theme's existing offcanvas
 * conventions (canvas-header/canvas-body) rather than any specific ground-truth markup.
 *
 * @package ovinx
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_account_navigation' );

if ( ! function_exists( 'ovinx_account_nav_icon' ) ) {
	function ovinx_account_nav_icon( $endpoint ) {
		$icons = array(
			'dashboard'       => 'icon-HouseLine',
			'orders'          => 'icon-Package',
			'downloads'       => 'icon-Package2',
			'edit-address'    => 'icon-Tag',
			'edit-account'    => 'icon-GearSix',
			'customer-logout' => 'icon-SignOut',
		);
		return isset( $icons[ $endpoint ] ) ? $icons[ $endpoint ] : 'icon-User';
	}
}
?>

<div class="btn-sidebar-mb d-lg-none">
	<button data-bs-toggle="offcanvas" data-bs-target="#mbAccount">
		<i class="icon icon-Sidebar"></i>
	</button>
</div>
<div class="offcanvas offcanvas-start canvas-filter canvas-sidebar canvas-sidebar-account" id="mbAccount" aria-modal="true" role="dialog">
	<div class="canvas-wrapper">
		<div class="canvas-header">
			<span class="title"><?php _e( 'Account', 'ovinx' ); ?></span>
			<button type="button" class="btn-close-popup" data-bs-dismiss="offcanvas" aria-label="Close">
				<i class="icon icon-Close2"></i>
			</button>
		</div>
		<div class="canvas-body">
			<nav class="woocommerce-MyAccount-navigation" aria-label="<?php esc_attr_e( 'Account pages', 'ovinx' ); ?>">
				<div class="my-account-nav">
					<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
						<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>" <?php echo wc_is_current_account_menu_item( $endpoint ) ? 'aria-current="page"' : ''; ?> class="link-account h6 <?php echo wc_is_current_account_menu_item( $endpoint ) ? 'active' : ''; ?>">
							<i class="icon <?php echo esc_attr( ovinx_account_nav_icon( $endpoint ) ); ?>"></i>
							<span class="text"><?php echo esc_html( $label ); ?></span>
						</a>
					<?php endforeach; ?>
				</div>
			</nav>
		</div>
	</div>
</div>
<nav class="sidebar-content-wrap sticky-top d-lg-block d-none woocommerce-MyAccount-navigation" aria-label="<?php esc_attr_e( 'Account pages', 'ovinx' ); ?>">
	<div class="my-account-nav">
		<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
			<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>" <?php echo wc_is_current_account_menu_item( $endpoint ) ? 'aria-current="page"' : ''; ?> class="link-account h6 <?php echo wc_is_current_account_menu_item( $endpoint ) ? 'active' : ''; ?>">
				<i class="icon <?php echo esc_attr( ovinx_account_nav_icon( $endpoint ) ); ?>"></i>
				<span class="text"><?php echo esc_html( $label ); ?></span>
			</a>
		<?php endforeach; ?>
	</div>
</nav>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>
