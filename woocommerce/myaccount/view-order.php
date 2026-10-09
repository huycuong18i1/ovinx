<?php
/**
 * View Order — full override (WC's own view-order.php + order/order-details*.php chain replaced
 * by a single file here for simplicity). No direct ground truth exists as a real page — ovinx-html's
 * account-orders.html only has an AJAX-populated MODAL (`#orderDetail`, `.modal-order_detail`) with no
 * real WC data wiring possible from a static export. Reuses that modal's exact inner classes
 * (`.col-left`/`.col-right`/`.box-info`/`.grid-info` — scoped in CSS under `.modal-order_detail`, so
 * that class is kept as a wrapper here purely for its CSS even though this isn't an actual Bootstrap
 * modal — and `.list-order-product`/`.list-total`/`.last-total`, which are real, unscoped classes)
 * repurposed as a full page instead of a modal.
 *
 * @package ovinx
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! current_user_can( 'view_order', $order->get_id() ) ) {
	echo '<p>' . esc_html__( 'Invalid order.', 'ovinx' ) . '</p>';
	return;
}

$actions = array_filter(
	wc_get_account_orders_actions( $order ),
	function ( $key ) {
		return 'view' !== $key;
	},
	ARRAY_FILTER_USE_KEY
);

$total_rows = $order->get_order_item_totals();
// 'payment_method' is already shown separately in the left column (box-info), and its position in
// this array isn't fixed (WC adds it either before or after 'order_total' depending on the
// 'email_improvements' feature flag) — pull both out by key rather than assuming array order.
unset( $total_rows['payment_method'] );
$grand_total = isset( $total_rows['order_total'] ) ? $total_rows['order_total'] : false;
unset( $total_rows['order_total'] );
?>

<h4 class="account-title">
	<?php
	printf(
		/* translators: 1: order number */
		esc_html__( 'Order #%s', 'ovinx' ),
		esc_html( $order->get_order_number() )
	);
	?>
</h4>
<p class="mb-20">
	<?php
	printf(
		/* translators: 1: order date 2: order status */
		esc_html__( 'Placed on %1$s — currently %2$s.', 'ovinx' ),
		esc_html( wc_format_datetime( $order->get_date_created() ) ),
		esc_html( wc_get_order_status_name( $order->get_status() ) )
	);
	?>
</p>

<div class="modal-order_detail">
	<div class="modal-content tf-grid-layout md-col-2 gap-0">

		<div class="col-left">
			<div class="modal-heading">
				<h4 class="title-pop"><?php esc_html_e( 'Order Details', 'ovinx' ); ?></h4>
			</div>
			<div class="tf-grid-layout sm-col-2 md-col-1 lg-col-2 grid-info">
				<div class="box-info">
					<p class="info-title fw-medium text-uppercase"><?php esc_html_e( 'Contact Information', 'ovinx' ); ?></p>
					<h6><?php echo esc_html( $order->get_formatted_billing_full_name() ); ?></h6>
					<h6><?php echo esc_html( $order->get_billing_email() ); ?></h6>
				</div>
				<div class="box-info">
					<p class="info-title fw-medium text-uppercase"><?php esc_html_e( 'Payment Method', 'ovinx' ); ?></p>
					<h6><?php echo esc_html( $order->get_payment_method_title() ); ?></h6>
				</div>
				<?php if ( $order->get_formatted_shipping_address() ) : ?>
				<div class="box-info">
					<p class="info-title fw-medium text-uppercase"><?php esc_html_e( 'Shipping Address', 'ovinx' ); ?></p>
					<h6><?php echo wp_kses_post( $order->get_formatted_shipping_address() ); ?></h6>
				</div>
				<?php endif; ?>
				<div class="box-info">
					<p class="info-title fw-medium text-uppercase"><?php esc_html_e( 'Billing Address', 'ovinx' ); ?></p>
					<h6><?php echo wp_kses_post( $order->get_formatted_billing_address() ); ?></h6>
				</div>
			</div>

			<?php if ( ! empty( $actions ) ) : ?>
			<div class="group-btn mt-20">
				<?php foreach ( $actions as $key => $action ) : ?>
					<a href="<?php echo esc_url( $action['url'] ); ?>" class="action-order tf-btn small-2 <?php echo 'cancel' === $key ? 'style-stroke' : ''; ?>">
						<?php echo esc_html( $action['name'] ); ?>
					</a>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
		</div>

		<div class="col-right">
			<div class="modal-heading">
				<h4 class="title-pop"><?php esc_html_e( 'Items', 'ovinx' ); ?></h4>
			</div>
			<ul class="list-order-product">
				<?php foreach ( $order->get_items() as $item ) :
					$product = $item->get_product();
				?>
					<li class="order-item">
						<?php if ( $product ) : ?>
							<a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="img-prd">
								<?php echo wp_kses_post( $product->get_image( array( 100, 133 ) ) ); ?>
							</a>
						<?php else : ?>
							<span class="img-prd"><?php echo wc_placeholder_img( array( 100, 133 ) ); ?></span>
						<?php endif; ?>
						<div class="infor-prd">
							<?php if ( $product ) : ?>
								<a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="prd_name cl-text-main link-underline fw-medium lh-24 text-line-clamp-2">
									<?php echo esc_html( $item->get_name() ); ?>
								</a>
							<?php else : ?>
								<span class="prd_name cl-text-main fw-medium lh-24 text-line-clamp-2"><?php echo esc_html( $item->get_name() ); ?></span>
							<?php endif; ?>
							<p class="prd_type text-caption-01">
								<?php esc_html_e( 'Quantity:', 'ovinx' ); ?>
								<span class="cl-text-main"><?php echo esc_html( $item->get_quantity() ); ?></span>
							</p>
						</div>
						<div class="quantity-price lh-24 fw-medium cl-text-main">
							<span class="quantity"><?php echo esc_html( $item->get_quantity() ); ?></span>
							x
							<span class="price"><?php echo wp_kses_post( wc_price( $order->get_item_total( $item, false, true ) ) ); ?></span>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
			<ul class="list-total">
				<?php foreach ( $total_rows as $total ) : ?>
					<li class="total-item cl-text-main lh-24 fw-medium">
						<span><?php echo esc_html( $total['label'] ); ?></span>
						<span><?php echo wp_kses_post( $total['value'] ); ?></span>
					</li>
				<?php endforeach; ?>
			</ul>
			<?php if ( $grand_total ) : ?>
			<div class="last-total h5 fw-medium d-flex align-items-center justify-content-between">
				<span><?php echo esc_html( $grand_total['label'] ); ?></span>
				<span><?php echo wp_kses_post( $grand_total['value'] ); ?></span>
			</div>
			<?php endif; ?>
		</div>

	</div>
</div>
