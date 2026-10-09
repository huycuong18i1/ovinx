<?php
/**
 * My Account Downloads — no ground truth exists for this tab in ovinx-html (not part of the static
 * export). Built for visual consistency with Dashboard's Recent Orders table, reusing the same real
 * `.account-my_recent`/`.table-my_recent`/`.tb-order_product` classes (css/styles.css) rather than
 * inventing new unstyled markup.
 *
 * @package ovinx
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$downloads     = WC()->customer->get_downloadable_products();
$has_downloads = (bool) $downloads;

do_action( 'woocommerce_before_account_downloads', $has_downloads );
?>

<h4 class="account-title"><?php esc_html_e( 'Downloads', 'ovinx' ); ?></h4>

<?php if ( ! $has_downloads ) : ?>

	<p class="mb-20"><?php esc_html_e( 'No downloads available yet.', 'ovinx' ); ?></p>
	<a href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>" class="tf-btn px-v1">
		<?php esc_html_e( 'Browse Products', 'ovinx' ); ?>
	</a>

<?php else : ?>

	<?php do_action( 'woocommerce_before_available_downloads' ); ?>

	<div class="account-my_recent">
		<div class="overflow-auto">
			<table class="table-my_recent">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Remaining', 'ovinx' ); ?></th>
						<th><?php esc_html_e( 'Product', 'ovinx' ); ?></th>
						<th><?php esc_html_e( 'Download', 'ovinx' ); ?></th>
						<th><?php esc_html_e( 'Expires', 'ovinx' ); ?></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ( $downloads as $download ) :
					$product = wc_get_product( $download['product_id'] );
				?>
					<tr class="tb-order-item">
						<td class="tb-order_code">
							<?php echo is_numeric( $download['downloads_remaining'] ) ? esc_html( $download['downloads_remaining'] ) : '&infin;'; ?>
						</td>
						<td>
							<div class="tb-order_product">
								<?php if ( $download['product_url'] ) : ?>
									<a href="<?php echo esc_url( $download['product_url'] ); ?>" class="img-prd">
										<?php echo wp_kses( $product ? $product->get_image( array( 48, 48 ) ) : wc_placeholder_img( array( 48, 48 ) ), ovinx_template_html_allowed_tags() ); ?>
									</a>
								<?php else : ?>
									<span class="img-prd"><?php echo wp_kses( $product ? $product->get_image( array( 48, 48 ) ) : wc_placeholder_img( array( 48, 48 ) ), ovinx_template_html_allowed_tags() ); ?></span>
								<?php endif; ?>
								<div class="infor-prd">
									<?php if ( $download['product_url'] ) : ?>
										<a href="<?php echo esc_url( $download['product_url'] ); ?>" class="prd_name cl-text-main link-underline fw-medium lh-24"><?php echo esc_html( $download['product_name'] ); ?></a>
									<?php else : ?>
										<span class="prd_name cl-text-main fw-medium lh-24"><?php echo esc_html( $download['product_name'] ); ?></span>
									<?php endif; ?>
									<p class="prd_type text-caption-01"><?php echo esc_html( $download['download_name'] ); ?></p>
								</div>
							</div>
						</td>
						<td class="tb-order_price">
							<a href="<?php echo esc_url( $download['download_url'] ); ?>" class="action-order tf-btn small-2">
								<?php esc_html_e( 'Download', 'ovinx' ); ?>
							</a>
						</td>
						<td>
							<?php if ( ! empty( $download['access_expires'] ) ) : ?>
								<div class="tb-order_status text-label"><?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $download['access_expires'] ) ) ); ?></div>
							<?php else : ?>
								<div class="tb-order_status text-label stt-completed"><?php esc_html_e( 'Never', 'ovinx' ); ?></div>
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>

	<?php do_action( 'woocommerce_after_available_downloads' ); ?>

<?php endif; ?>

<?php do_action( 'woocommerce_after_account_downloads', $has_downloads ); ?>
