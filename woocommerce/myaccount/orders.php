<?php
/**
 * My Account Orders — matches ovinx-html's account-orders.html
 * (`.account-my_order` tabs + `.wg-my-order` cards, real CSS in css/styles.css).
 *
 * Ground truth's "Order Details" opens an AJAX-populated modal (#orderDetail) with no real WC
 * data wiring possible from the static export — instead this links straight to WooCommerce's own
 * view-order endpoint ($order->get_view_order_url()), which is styled separately
 * (woocommerce/single-order.php / order-details.php).
 *
 * @package ovinx
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$customer_id = get_current_user_id();

$ovinx_order_tabs = array(
	'all-order' => array( 'label' => __( 'All Order', 'ovinx' ), 'statuses' => array_keys( wc_get_order_statuses() ) ),
	'pending'   => array( 'label' => __( 'Pending', 'ovinx' ), 'statuses' => array( 'wc-pending', 'wc-on-hold' ) ),
	'delivery'  => array( 'label' => __( 'Delivery', 'ovinx' ), 'statuses' => array( 'wc-processing' ) ),
	'completed' => array( 'label' => __( 'Completed', 'ovinx' ), 'statuses' => array( 'wc-completed' ) ),
	'canceled'  => array( 'label' => __( 'Canceled', 'ovinx' ), 'statuses' => array( 'wc-cancelled', 'wc-refunded', 'wc-failed' ) ),
);

if ( ! function_exists( 'ovinx_render_order_card' ) ) {
	function ovinx_render_order_card( $order ) {
		?>
		<div class="wg-my-order">
			<div class="order-heading h6">
				<div class="order_number">
					<?php esc_html_e( 'Order Number:', 'ovinx' ); ?>
					<span class="number-code">#<?php echo esc_html( $order->get_order_number() ); ?></span>
				</div>
				<div class="order_status">
					<?php esc_html_e( 'Order Status:', 'ovinx' ); ?>
					<div class="tb-order_status text-label <?php echo esc_attr( ovinx_order_status_class( $order->get_status() ) ); ?>">
						<?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?>
					</div>
				</div>
			</div>
			<div class="order-content">
				<?php foreach ( $order->get_items() as $item ) :
					$product = $item->get_product();
					?>
					<div class="order_prd_item">
						<div class="prd__image">
							<?php echo wp_kses( $product ? $product->get_image( array( 100, 100 ) ) : wc_placeholder_img( array( 100, 100 ) ), ovinx_template_html_allowed_tags() ); ?>
						</div>
						<div class="prd__info">
							<p class="name lh-24 fw-medium cl-text-main"><?php echo esc_html( $item->get_name() ); ?></p>
							<p class="type text-caption-01 cl-text-2"><?php esc_html_e( 'Quantity:', 'ovinx' ); ?> <span class="cl-text-main"><?php echo esc_html( $item->get_quantity() ); ?></span></p>
						</div>
						<div class="prd__price lh-24 fw-medium cl-text-main">
							<span class="quantity"><?php echo esc_html( $item->get_quantity() ); ?></span>
							x
							<span class="price"><?php echo wp_kses_post( wc_price( $order->get_item_total( $item ) ) ); ?></span>
						</div>
					</div>
				<?php endforeach; ?>
				<div class="group-btn">
					<a href="<?php echo esc_url( $order->get_view_order_url() ); ?>" class="action-order tf-btn small-2">
						<span class="text-caption-01 text-uppercase"><?php esc_html_e( 'Order Details', 'ovinx' ); ?></span>
					</a>
					<?php
					$actions = wc_get_account_orders_actions( $order );
					if ( isset( $actions['cancel'] ) ) :
						?>
						<a href="<?php echo esc_url( $actions['cancel']['url'] ); ?>" class="action-order tf-btn small-2 style-stroke">
							<span class="text-caption-01 text-uppercase"><?php esc_html_e( 'Cancel Order', 'ovinx' ); ?></span>
						</a>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php
	}
}
?>

<h4 class="account-title"><?php esc_html_e( 'Your Orders', 'ovinx' ); ?></h4>

<div class="account-my_order">
	<ul class="list-tab-btn-v1 style-2 justify-content-start" role="tablist">
		<?php $ovinx_tab_i = 0; foreach ( $ovinx_order_tabs as $tab_id => $tab ) : ?>
			<li class="nav-tab-item" role="presentation">
				<a href="#<?php echo esc_attr( $tab_id ); ?>" data-bs-toggle="tab" class="tf-btn-tab <?php echo 0 === $ovinx_tab_i ? 'active' : ''; ?>" role="tab">
					<span class="h5"><?php echo esc_html( $tab['label'] ); ?></span>
				</a>
			</li>
		<?php $ovinx_tab_i++; endforeach; ?>
	</ul>
	<div class="tab-content">
		<?php $ovinx_tab_i = 0; foreach ( $ovinx_order_tabs as $tab_id => $tab ) :
			$tab_orders = wc_get_orders( array(
				'customer' => $customer_id,
				'status'   => $tab['statuses'],
				'limit'    => 20,
				'orderby'  => 'date',
				'order'    => 'DESC',
			) );
			?>
			<div class="tab-pane <?php echo 0 === $ovinx_tab_i ? 'active show' : ''; ?>" id="<?php echo esc_attr( $tab_id ); ?>" role="tabpanel">
				<?php if ( empty( $tab_orders ) ) : ?>
					<p><?php esc_html_e( 'No orders in this category.', 'ovinx' ); ?></p>
				<?php else : ?>
					<div class="my-order_list d-grid gap-24">
						<?php foreach ( $tab_orders as $order ) : ovinx_render_order_card( $order ); endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		<?php $ovinx_tab_i++; endforeach; ?>
	</div>
</div>
