<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

if ( ! $product instanceof WC_Product ) {
	return;
}

$args = get_query_var( 'tf_card_product_args' );
$args = is_array( $args ) ? $args : array();

$product_style = isset( $_GET['product_style'] )
	? sanitize_text_field( wp_unslash( $_GET['product_style'] ) )
	: themesflat_get_opt( 'product_style' );

if ( isset( $_POST['product_style'] ) ) {
	$product_style = sanitize_text_field( wp_unslash( $_POST['product_style'] ) );
}

$product_id = $product->get_id();

/**
 * Ground truth's list-style card uses this SAME .box-action_add button, just marked d-md-none
 * (list-style has its own separate desktop button in .card-product_button — see
 * tfwc_list_button_panel()); grid shows it on every screen size via hover.
 */
$box_action_add_class = 'box-action_add' . ( $product_style === 'style-list' ? ' d-md-none w-100' : '' );
?>

<?php if ( $product->is_type( 'simple' ) ) : ?>

	<div class="<?php echo esc_attr( $box_action_add_class ); ?>">
		<?php
		printf(
			'<a href="%1$s" data-quantity="%2$s" class="tf_add_to_cart not-size has-loading loading-hidden-text tf-btn w-100 h-v2 %3$s" %4$s>
				<i class="icon icon-ShoppingBagOpen"></i>
				<span class="text text-caption-01">%5$s</span>
				<span class="tf-add-to-cart-loading d-none position-relative">
					<span class="spinner"></span>
				</span>
			</a>',
			esc_url( $product->add_to_cart_url() ),
			esc_attr( $args['quantity'] ?? 1 ),
			esc_attr( $args['class'] ?? 'button' ),
			isset( $args['attributes'] )
				? wc_implode_html_attributes( $args['attributes'] )
				: '',
			esc_html( $product->add_to_cart_text() )
		);
		?>
	</div>

<?php else : ?>

<?php if ( $product_style === 'style-3' ) : ?>

	<div class="d-flex vertical w-100 gap-10 p-0">
		<?php
		$button_text = $product->is_type( 'variable' )
			? esc_html__( 'Quick Add', 'ovinx' )
			: esc_html( $product->add_to_cart_text() );

		printf(
			'<a href="%1$s" data-quantity="%2$s" class="tf_add_to_cart tf-btn has-loading loading-hidden-text btn-white small w-100 %3$s" %4$s>
				<span class="text text-1 text-caption-01">%5$s</span>
				<span class="tf-add-to-cart-loading d-none position-relative">
					<span class="spinner"></span>
				</span>
			</a>',
			esc_url( $product->add_to_cart_url() ),
			esc_attr( $args['quantity'] ?? 1 ),
			esc_attr( $args['class'] ?? 'button' ),
			isset( $args['attributes'] )
				? wc_implode_html_attributes( $args['attributes'] )
				: '',
			$button_text
		);
		?>

		<a
			href="#quickView"
			data-bs-toggle="offcanvas"
			class="tf-btn btn-white small w-100 quickview tf_quickview_btn"
			data-product_id="<?php echo esc_attr( $product_id ); ?>"
		>
			<?php esc_html_e( 'Quick View', 'ovinx' ); ?>
		</a>
	</div>

<?php elseif ( $product_style === 'style-4' ) : ?>

	<div class="d-flex vertical w-100 gap-10 p-0">
		<?php
		$button_text = $product->is_type( 'variable' )
			? esc_html__( 'Quick Add', 'ovinx' )
			: esc_html( $product->add_to_cart_text() );

		printf(
			'<a href="%1$s" data-quantity="%2$s" class="tf_add_to_cart tf-btn has-loading loading-hidden-text btn-white small w-100 %3$s" %4$s>
				<span class="text text-1 text-caption-01">%5$s</span>
				<span class="tf-add-to-cart-loading d-none position-relative">
					<span class="spinner"></span>
				</span>
			</a>',
			esc_url( $product->add_to_cart_url() ),
			esc_attr( $args['quantity'] ?? 1 ),
			esc_attr( $args['class'] ?? 'button' ),
			isset( $args['attributes'] )
				? wc_implode_html_attributes( $args['attributes'] )
				: '',
			$button_text
		);
		?>

		<a href="#quickView" data-bs-toggle="offcanvas" class="md-d-none  box-icon quickview tf_quickview_btn btn-icon-quick_view" data-quantity="1" data-product_id="<?php echo esc_attr( $product_id ); ?>" aria-label="<?php esc_attr_e( 'Quick View', 'ovinx' ); ?>">
            <span class="icon icon-EyeOpen"></span>
        </a>
	</div>

<?php else : ?>

	<div class="<?php echo esc_attr( $box_action_add_class ); ?>">
		<?php
		$button_text = $product->is_type( 'variable' )
			? esc_html__( 'Quick Add', 'ovinx' )
			: esc_html( $product->add_to_cart_text() );

		printf(
			'<a href="%1$s" data-quantity="%2$s" class="tf_add_to_cart tf-btn has-loading loading-hidden-text w-100 h-v2 %3$s" %4$s>
				<i class="icon icon-ShoppingBagOpen"></i>
				<span class="text text-1 text-caption-01">%5$s</span>
				<span class="tf-add-to-cart-loading d-none position-relative">
					<span class="spinner"></span>
				</span>
			</a>',
			esc_url( $product->add_to_cart_url() ),
			esc_attr( $args['quantity'] ?? 1 ),
			esc_attr( $args['class'] ?? 'button' ),
			isset( $args['attributes'] )
				? wc_implode_html_attributes( $args['attributes'] )
				: '',
			$button_text
		);
		?>
	</div>

<?php endif; ?>

<?php endif; ?>