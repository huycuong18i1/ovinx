<?php
/**
 * Template for displaying wishlist table.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/wishlist/wishlist-table.php.
 *
 * @author  WCBoost
 * @package WCBoost\Wishlist\Templates
 * @version 10.3.4
 */

defined( 'ABSPATH' ) || exit;

if ( ! isset( $wishlist ) ) {
	return;
}


if( !function_exists('tf_wishlist_page_args') ){
	function tf_wishlist_page_args( $args, $wishlist, $product ){

		$item = new \WCBoost\Wishlist\Wishlist_Item( $product );

		if ( $wishlist->has_item( $item )){
			$args['url']        = $item->get_remove_url();
			/* translators: %s product name */
			$args['aria-label'] = sprintf( __( 'Remove %s from the wishlist', 'ovinx' ), '&ldquo;' . $product->get_title() . '&rdquo;' );
			$args['label']      = \WCBoost\Wishlist\Helper::get_button_text( 'remove' );
		}

		return $args;
	}
}

?>

<?php do_action( 'wcboost_wishlist_before_wishlist_table', $wishlist ); ?>

<?php
$GLOBALS['is_wcboost_wishlist_page'] = true;
$wishlist_items = ovinx_get_valid_wishlist_items( $wishlist );
$per_page = 8; 
$current_page = max( 1, get_query_var( 'paged', 1 ) );
$total_items = count( $wishlist_items );
$total_pages = ceil( $total_items / $per_page );

$offset = ( $current_page - 1 ) * $per_page;
$paged_items = array_slice( $wishlist_items, $offset, $per_page, true );
?>

<div class="section-wishlist">
	<div class="container">

		<?php if ( $total_items > 0 ) : ?>
			<div class="wishlist-toolbar" data-status="<?php echo esc_attr( sprintf( /* translators: %d: number of items */ _n( 'Wishlist updated: %d item.', 'Wishlist updated: %d items.', $total_items, 'ovinx' ), $total_items ) ); ?>">
				<a href="<?php echo esc_url( ovinx_wishlist_clear_all_url() ); ?>" class="tf-btn style-stroke small-2 wishlist-clear-all" rel="nofollow">
					<i class="icon icon-trash" aria-hidden="true"></i>
					<span><?php esc_html_e( 'Clear all', 'ovinx' ); ?></span>
				</a>
			</div>
		<?php endif; ?>

		<div class="tf-grid-layout tf-col-2 md-col-3 xl-col-4 wrapper-wishlist layout-prd_2row">
			<?php foreach ( $paged_items as $item_key => $item ) :
				$product = $item->get_product();
				if ( ! $product || ! $product->exists() ) continue;

				$GLOBALS['product'] = $product;

				$product_style = 'style-1';
				$_POST['product_style'] = $product_style ;

				// add_filter( 'wcboost_wishlist_button_template_args', 'tf_wishlist_page_args', 10, 3);

				set_query_var('wl_item_remove_link',$item->get_remove_url());

				wc_get_template_part( 'content', 'product' );

				set_query_var('wl_item_remove_link',false);

				// themesflat_remove_hook( 'wcboost_wishlist_button_template_args', 'tf_wishlist_page_args', 10, 3);

			endforeach; ?>
		</div>

		<?php if ( $total_pages > 1 ) : ?>
			<nav class="navigation wg-pagination paging-navigation pager-numeric wishlist" role="navigation">
				<div class="tf-pagination">
					<?php
					$wishlist_pagination_links = paginate_links( array(
						'base'      => str_replace( 99999, '%#%', esc_url( get_pagenum_link( 99999 ) ) ),
						'format'    => '?paged=%#%',
						'current'   => $current_page,
						'total'     => $total_pages,
						'mid_size'  => 1,
						'prev_text' => '<i class="icon icon-CaretLeft"></i>',
						'next_text' => '<i class="icon icon-CaretRight"></i>',
						'type'      => 'array',
					) );

					foreach ( $wishlist_pagination_links as $wishlist_pagination_link ) :
						$wishlist_pagination_link = str_replace(
							array( 'page-numbers current', 'page-numbers' ),
							array( 'pag-item active', 'pag-item' ),
							$wishlist_pagination_link
						);
						echo wp_kses_post( $wishlist_pagination_link );
					endforeach;
					?>
				</div>
			</nav>
		<?php endif; ?>

	</div>
</div>

<?php do_action( 'wcboost_wishlist_after_wishlist_table', $wishlist ); ?>
