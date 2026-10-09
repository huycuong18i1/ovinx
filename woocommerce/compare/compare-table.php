<?php
/**
 * Template for displaying the table of compared products.
 *
 * Markup follows ovinx-html/compare.html (`.tf-table-compare`): product head (image + remove + name), then one row per
 * spec. Rows are built from real WooCommerce data and a row is only printed when at least one compared product has a
 * value for it, so the table never shows a column of "----" placeholders.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/compare/compare-table.php.
 *
 * @author  WCBoost
 * @package WCBoost\ProductsCompare\Templates
 * @version 10.3.4
 */

defined( 'ABSPATH' ) || exit;

if ( ! isset( $compare_items ) ) {
	return;
}

/**
 * Add-to-cart link used only inside this table: same `.tf-btn` as the design, and it must RETURN the markup
 * (the old version echoed and returned nothing). Declared once; the filter is attached/detached around the table.
 */
if ( ! function_exists( 'tfwc_add_to_cart_compare' ) ) {
	function tfwc_add_to_cart_compare( $html, $product, $args ) {
		return sprintf(
			'<a href="%1$s" data-quantity="%2$s" class="tf_add_to_cart has-loading loading-hidden-text tf-btn %3$s" %4$s>
				<span class="text text-caption-01">%5$s</span>
				<span class="tf-add-to-cart-loading d-none position-relative"><span class="spinner"></span></span>
			</a>',
			esc_url( $product->add_to_cart_url() ),
			esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
			esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
			isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
			esc_html( $product->add_to_cart_text() )
		);
	}
}

global $is_compare_table;
$is_compare_table = true;
themesflat_remove_hook( 'woocommerce_loop_add_to_cart_link', 'tfwc_add_to_cart', 20, 3 );
add_filter( 'woocommerce_loop_add_to_cart_link', 'tfwc_add_to_cart_compare', 20, 3 );

do_action( 'wcboost_products_compare_before_compare_table', $compare_items );

/* ---------------------------------------------------------------------------------------------------------------
 * Build the spec rows: [ row key => [ 'label' => string, 'class' => string, 'cells' => [ product_id => html ] ] ].
 * An empty-string cell means "no value" for that product; a row with no value anywhere is dropped further down.
 * ------------------------------------------------------------------------------------------------------------- */
$rows = array();

// Rating.
$rows['rating'] = array( 'label' => __( 'Rating', 'ovinx' ), 'class' => 'compare-value', 'cells' => array(), 'always' => true );
foreach ( $compare_items as $_product ) {
	$average = (float) $_product->get_average_rating();
	$count   = (int) $_product->get_rating_count();
	$filled  = (int) round( $average );

	ob_start();
	?>
	<div class="compare_rate">
		<div class="star-wrap normal d-flex align-items-center">
			<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
				<i class="icon icon-Star<?php echo esc_attr( $i > $filled ? ' cl-text-line' : '' ); ?>"></i>
			<?php endfor; ?>
		</div>
		<span class="rate_count">(<?php echo esc_html( number_format_i18n( $count ) ); ?>)</span>
	</div>
	<?php
	$rows['rating']['cells'][ $_product->get_id() ] = ob_get_clean();
}

// Price.
$rows['price'] = array( 'label' => __( 'Price', 'ovinx' ), 'class' => 'compare-value', 'cells' => array(), 'always' => true );
foreach ( $compare_items as $_product ) {
	$rows['price']['cells'][ $_product->get_id() ] = '<div class="item_price price-wrap tf-price">' . wp_kses_post( $_product->get_price_html() ) . '</div>';
}

// Availability.
$rows['stock'] = array( 'label' => __( 'Availability', 'ovinx' ), 'class' => 'compare-value', 'cells' => array(), 'always' => true );
foreach ( $compare_items as $_product ) {
	$availability = $_product->get_availability();
	$in_stock     = $_product->is_in_stock();
	$text         = ! empty( $availability['availability'] ) ? $availability['availability'] : ( $in_stock ? __( 'In stock', 'ovinx' ) : __( 'Out of stock', 'ovinx' ) );

	$rows['stock']['cells'][ $_product->get_id() ] = sprintf(
		'<div class="compare_stock"><span class="product-badge_stock %1$s"><span class="br-dot"></span>%2$s</span></div>',
		$in_stock ? '' : 'out-stock',
		esc_html( $text )
	);
}

// Brand.
$rows['brand'] = array( 'label' => __( 'Brand', 'ovinx' ), 'class' => 'compare-value', 'cells' => array() );
foreach ( $compare_items as $_product ) {
	$brands = taxonomy_exists( 'product_brand' ) ? get_the_terms( $_product->get_id(), 'product_brand' ) : false;
	$rows['brand']['cells'][ $_product->get_id() ] = ( $brands && ! is_wp_error( $brands ) )
		? '<span>' . esc_html( implode( ', ', wp_list_pluck( $brands, 'name' ) ) ) . '</span>'
		: '';
}

// Every visible product attribute (Size, Color, Material, Thickness, Warranty...) that any compared product has.
// `pa_image` is a swatch-only attribute with nothing readable to compare.
$attribute_rows = array();
foreach ( $compare_items as $_product ) {
	foreach ( $_product->get_attributes() as $attribute_key => $attribute ) {
		if ( ! is_a( $attribute, 'WC_Product_Attribute' ) || ! $attribute->get_visible() || 'pa_image' === $attribute_key ) {
			continue;
		}
		$attribute_rows[ $attribute_key ] = wc_attribute_label( $attribute->get_name(), $_product );
	}
}

foreach ( $attribute_rows as $attribute_key => $attribute_label ) {
	$is_color = 'pa_color' === $attribute_key;

	$rows[ 'attr_' . $attribute_key ] = array( 'label' => $attribute_label, 'class' => 'compare-value', 'cells' => array() );

	foreach ( $compare_items as $_product ) {
		$html      = '';
		$attribute = $_product->get_attributes();
		$attribute = isset( $attribute[ $attribute_key ] ) ? $attribute[ $attribute_key ] : null;

		if ( $attribute && $attribute->get_visible() ) {
			if ( $attribute->is_taxonomy() ) {
				$terms = wc_get_product_terms( $_product->get_id(), $attribute_key, array( 'fields' => 'all' ) );

				if ( $is_color && $terms ) {
					ob_start();
					?>
					<ul class="product-color_list justify-content-center">
						<?php foreach ( $terms as $term ) :
							$color = class_exists( '\WCBoost\VariationSwatches\Admin\Term_Meta' )
								? \WCBoost\VariationSwatches\Admin\Term_Meta::instance()->get_meta( $term->term_id, 'color' )
								: get_term_meta( $term->term_id, 'color', true );
							$bg    = $color ? $color : strtolower( $term->slug );
							$light = in_array( strtolower( $bg ), array( '#ffffff', '#fff', 'white' ), true );
							?>
							<li title="<?php echo esc_attr( $term->name ); ?>" class="product-color-item color-swatch hover-tooltip tooltip-bot<?php echo esc_attr( $light ? ' line' : '' ); ?>">
								<span class="tooltip color-filter"><?php echo esc_html( $term->name ); ?></span>
								<span class="swatch-value" style="background-color: <?php echo esc_attr( $bg ); ?>;"></span>
							</li>
						<?php endforeach; ?>
					</ul>
					<?php
					$html = ob_get_clean();
				} elseif ( $terms ) {
					$html = '<span>' . esc_html( implode( ', ', wp_list_pluck( $terms, 'name' ) ) ) . '</span>';
				}
			} elseif ( $attribute->get_options() ) {
				$html = '<span>' . esc_html( implode( ', ', array_map( 'trim', $attribute->get_options() ) ) ) . '</span>';
			}
		}

		$rows[ 'attr_' . $attribute_key ]['cells'][ $_product->get_id() ] = $html;
	}
}

// SKU / Dimensions / Weight.
$rows['sku']        = array( 'label' => __( 'SKU', 'ovinx' ), 'class' => 'compare-value', 'cells' => array() );
$rows['dimensions'] = array( 'label' => __( 'Dimensions', 'ovinx' ), 'class' => 'compare-value', 'cells' => array() );
$rows['weight']     = array( 'label' => __( 'Weight', 'ovinx' ), 'class' => 'compare-value', 'cells' => array() );
foreach ( $compare_items as $_product ) {
	$id = $_product->get_id();

	$rows['sku']['cells'][ $id ]        = $_product->get_sku() ? '<span>' . esc_html( $_product->get_sku() ) . '</span>' : '';
	$rows['dimensions']['cells'][ $id ] = $_product->has_dimensions() ? '<span>' . esc_html( wc_format_dimensions( $_product->get_dimensions( false ) ) ) . '</span>' : '';
	$rows['weight']['cells'][ $id ]     = $_product->has_weight() ? '<span>' . esc_html( wc_format_weight( $_product->get_weight() ) ) . '</span>' : '';
}

// Drop every spec row nobody has a value for; a "-" placeholder fills the gaps in the rows that stay.
foreach ( $rows as $key => $row ) {
	if ( ! empty( $row['always'] ) ) {
		continue;
	}
	if ( '' === trim( implode( '', $row['cells'] ) ) ) {
		unset( $rows[ $key ] );
	}
}
?>

<div class="tf-table-compare">
	<?php // The table carries a class on purpose: wp-core.css styles every class-less table inside .entry-content as a striped content table. ?>
	<table class="tf-compare-table">
		<thead>
			<tr class="compare-row">
				<th class="compare-col"></th>
				<?php foreach ( $compare_items as $_product ) : ?>
					<th class="compare-col compare-head">
						<div class="compare-item text-center">
							<div class="item_image">
								<a href="<?php echo esc_url( $_product->get_permalink() ); ?>">
									<?php
									$compare_image = $_product->get_image_id()
										? wp_get_attachment_image( $_product->get_image_id(), 'woocommerce_single', false, array( 'loading' => 'lazy', 'alt' => $_product->get_name() ) )
										: wc_placeholder_img( 'woocommerce_single' );
									echo wp_kses_post( $compare_image );
									?>
								</a>
								<a class="remove wcboost-products-compare-remove" href="<?php echo esc_url( \WCBoost\ProductsCompare\Helper::get_remove_url( $_product ) ); ?>" aria-label="<?php echo esc_attr( sprintf( /* translators: %s: product name */ __( 'Remove %s from compare', 'ovinx' ), $_product->get_name() ) ); ?>" data-product_id="<?php echo esc_attr( $_product->get_id() ); ?>">
									<i class="icon icon-Close"></i>
								</a>
							</div>
							<a href="<?php echo esc_url( $_product->get_permalink() ); ?>" class="item_name fw-medium cl-text-main link-underline">
								<?php echo esc_html( $_product->get_name() ); ?>
							</a>
						</div>
					</th>
				<?php endforeach; ?>
			</tr>
		</thead>
		<tbody>
			<?php foreach ( $rows as $row ) : ?>
				<tr class="compare-row">
					<td class="compare-col compare-title"><?php echo esc_html( $row['label'] ); ?></td>
					<?php foreach ( $compare_items as $_product ) :
						$cell = isset( $row['cells'][ $_product->get_id() ] ) ? $row['cells'][ $_product->get_id() ] : '';
						?>
						<td class="compare-col <?php echo esc_attr( $row['class'] ); ?>">
							<?php echo '' !== trim( $cell ) ? $cell : '<span class="cl-text-mute">&ndash;</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- every cell is built and escaped above ?>
						</td>
					<?php endforeach; ?>
				</tr>
			<?php endforeach; ?>

			<tr class="compare-row">
				<td class="compare-col compare-title"><?php esc_html_e( 'Add To Cart', 'ovinx' ); ?></td>
				<?php foreach ( $compare_items as $_product ) : ?>
					<td class="compare-col compare-value">
						<?php
						if ( ! $_product->is_purchasable() && ! $_product->is_in_stock() ) {
							?>
							<a href="<?php echo esc_url( $_product->get_permalink() ); ?>" class="tf-btn">
								<span class="text text-caption-01"><?php esc_html_e( 'View product', 'ovinx' ); ?></span>
							</a>
							<?php
						} else {
							$GLOBALS['product'] = $_product;
							woocommerce_template_loop_add_to_cart();
							wc_setup_product_data( null );
						}
						?>
					</td>
				<?php endforeach; ?>
			</tr>
		</tbody>
	</table>
</div>

<?php
themesflat_remove_hook( 'woocommerce_loop_add_to_cart_link', 'tfwc_add_to_cart_compare', 20, 3 );
add_filter( 'woocommerce_loop_add_to_cart_link', 'tfwc_add_to_cart', 20, 3 );
$is_compare_table = false;

do_action( 'wcboost_products_compare_after_compare_table', $compare_items );
