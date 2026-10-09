<?php
/**
 * My Account Dashboard — matches ovinx-html's account-page.html
 * (`.account-title` / `.acount-order_stats` swiper / `.account-my_recent` table, real CSS in css/styles.css).
 *
 * @package ovinx
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$customer_id = get_current_user_id();

$processing_count = wc_get_orders( array(
	'customer' => $customer_id,
	'status'   => array( 'wc-processing', 'wc-on-hold' ),
	'limit'    => -1,
	'return'   => 'ids',
) );
$cancelled_count = wc_get_orders( array(
	'customer' => $customer_id,
	'status'   => array( 'wc-cancelled' ),
	'limit'    => -1,
	'return'   => 'ids',
) );
$total_count = wc_get_orders( array(
	'customer' => $customer_id,
	'status'   => array_keys( wc_get_order_statuses() ),
	'limit'    => -1,
	'return'   => 'ids',
) );

$recent_orders = wc_get_orders( array(
	'customer' => $customer_id,
	'limit'    => 4,
	'orderby'  => 'date',
	'order'    => 'DESC',
) );
?>

<h4 class="account-title"><?php esc_html_e( 'Dashboard', 'ovinx' ); ?></h4>

<div class="acount-order_stats">
	<!-- Ground truth uses a swiper here, but this theme has no generic init for the
	     data-view-md/-preview/-space attribute convention it relies on (grepped js/main.js,
	     none found) — and with exactly 3 fixed stat cards a carousel isn't functionally
	     needed anyway, so a plain responsive grid is used instead (same real .order-box CSS). -->
	<div class="tf-grid-layout sm-col-2 md-col-3">
		<div class="order-box">
			<div class="order_info">
				<h4 class="info__count"><?php echo count( $processing_count ); ?></h4>
				<p class="info__label text-button-small text-uppercase"><?php esc_html_e( 'Awaiting Pickup', 'ovinx' ); ?></p>
			</div>
			<div class="order_icon">
				<i class="icon icon-ClockCountdown"></i>
			</div>
		</div>
		<div class="order-box">
			<div class="order_info">
				<h4 class="info__count"><?php echo count( $cancelled_count ); ?></h4>
				<p class="info__label text-button-small text-uppercase"><?php esc_html_e( 'Cancelled Orders', 'ovinx' ); ?></p>
			</div>
			<div class="order_icon">
				<i class="icon icon-ReceiptX"></i>
			</div>
		</div>
		<div class="order-box">
			<div class="order_info">
				<h4 class="info__count"><?php echo count( $total_count ); ?></h4>
				<p class="info__label text-button-small text-uppercase"><?php esc_html_e( 'Total Orders', 'ovinx' ); ?></p>
			</div>
			<div class="order_icon">
				<i class="icon icon-Package"></i>
			</div>
		</div>
	</div>
</div>

<div class="account-my_recent">
	<h5 class="title-case"><?php esc_html_e( 'Recent Orders', 'ovinx' ); ?></h5>
	<?php if ( empty( $recent_orders ) ) : ?>
		<p><?php esc_html_e( 'No orders yet.', 'ovinx' ); ?></p>
	<?php else : ?>
		<div class="overflow-auto">
			<table class="table-my_recent">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Order', 'ovinx' ); ?></th>
						<th><?php esc_html_e( 'Products', 'ovinx' ); ?></th>
						<th><?php esc_html_e( 'Pricing', 'ovinx' ); ?></th>
						<th><?php esc_html_e( 'Status', 'ovinx' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $recent_orders as $order ) :
						$items = $order->get_items();
						$first_item = reset( $items );
						$product = $first_item ? $first_item->get_product() : false;
						?>
						<tr class="tb-order-item">
							<td class="tb-order_code">#<?php echo esc_html( $order->get_order_number() ); ?></td>
							<td>
								<div class="tb-order_product">
									<a href="<?php echo esc_url( $order->get_view_order_url() ); ?>" class="img-prd">
										<?php echo wp_kses( $product ? $product->get_image( array( 48, 48 ) ) : wc_placeholder_img( array( 48, 48 ) ), ovinx_template_html_allowed_tags() ); ?>
									</a>
									<div class="infor-prd">
										<a href="<?php echo esc_url( $order->get_view_order_url() ); ?>" class="prd_name cl-text-main link-underline fw-medium lh-24">
											<?php echo esc_html( $first_item ? $first_item->get_name() : __( 'Order', 'ovinx' ) ); ?>
										</a>
										<?php if ( $first_item ) : ?>
											<p class="prd_type text-caption-01"><?php esc_html_e( 'Quantity:', 'ovinx' ); ?> <span class="cl-text-main"><?php echo esc_html( $first_item->get_quantity() ); ?></span></p>
										<?php endif; ?>
									</div>
								</div>
							</td>
							<td class="tb-order_price"><?php echo wp_kses_post( $order->get_formatted_order_total() ); ?></td>
							<td>
								<div class="tb-order_status text-label <?php echo esc_attr( ovinx_order_status_class( $order->get_status() ) ); ?>">
									<?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?>
								</div>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	<?php endif; ?>
</div>
