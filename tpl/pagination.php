<?php


global $the_query;
// Don't print empty markup if there's only one page.
if ( $GLOBALS['wp_query']->max_num_pages < 2 ) return;

$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
$pagenum_link = html_entity_decode( get_pagenum_link() );
$query_args   = array();
$url_parts    = explode( '?', $pagenum_link );

if ( isset( $url_parts[1] ) ) {
	wp_parse_str( $url_parts[1], $query_args );
}

$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

$format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

/**
 * Re-classes WordPress's default `page-numbers`/`current` pagination markup
 * to match ovinx-html's `.tf-pagination`/`.pag-item`/`.pag-item.active` design.
 */
$themesflat_to_pag_items = function ( $links ) {
	if ( empty( $links ) ) {
		return array();
	}
	return array_map( function ( $link ) {
		return str_replace(
			array( 'page-numbers current', 'page-numbers' ),
			array( 'pag-item active', 'pag-item' ),
			$link
		);
	}, $links );
};

// Set up paginated links (numbers + prev/next arrows).
$links = paginate_links( array(
	'base'      => $pagenum_link,
	'format'    => $format,
	'total'     => $GLOBALS['wp_query']->max_num_pages,
	'current'   => $paged,
	'mid_size'  => 1,
	'add_args'  => array_map( 'urlencode', $query_args ),
	// QA UX-006: arrow-only links need a name.
	'next_text' => '<i class="icon icon-CaretRight" aria-hidden="true"></i><span class="screen-reader-text">' . esc_html__( 'Next page', 'ovinx' ) . '</span>',
	'prev_text' => '<i class="icon icon-CaretLeft" aria-hidden="true"></i><span class="screen-reader-text">' . esc_html__( 'Previous page', 'ovinx' ) . '</span>',
	'type'      => 'array',
) );
$links = $themesflat_to_pag_items( $links );

$numeric_links = paginate_links( array(
	'base'      => $pagenum_link,
	'format'    => $format,
	'total'     => $GLOBALS['wp_query']->max_num_pages,
	'current'   => $paged,
	'mid_size'  => 1,
	'add_args'  => array_map( 'urlencode', $query_args ),
	'prev_next' => false,
	'type'      => 'array',
) );
$numeric_links = $themesflat_to_pag_items( $numeric_links );

$next_link = get_next_posts_link( esc_html__( 'Next', 'ovinx' ) );
$prev_link = get_previous_posts_link( esc_html__( 'Previous', 'ovinx' ) );
$loadmore_text = apply_filters('themesflat/template/loadmore_text',esc_html__('Load More','ovinx'));
$more_link = get_next_posts_link( esc_html( $loadmore_text) );
$themesflat_paging_for = 'blog';
$themesflat_paging_style = themesflat_get_opt('blog_archive_pagination_style');
?>

<?php if ( $themesflat_paging_style == 'pager' && ! ( empty( $next_link ) && empty( $prev_link ) ) ): ?>

	<nav class="navigation wg-pagination paging-navigation pager <?php  echo esc_attr($themesflat_paging_for);?>" role="navigation">
		<div class="tf-pagination">
			<?php echo wp_kses( $prev_link, themesflat_kses_allowed_html() ) ?>
			<?php echo wp_kses( $next_link, themesflat_kses_allowed_html() ) ?>
		</div>
	</nav>

<?php elseif ( $themesflat_paging_style == 'numeric' && ! empty( $numeric_links ) ): ?>

	<nav class="navigation wg-pagination paging-navigation numeric <?php  echo esc_attr($themesflat_paging_for);?>" role="navigation">
		<div class="tf-pagination">
			<?php foreach ( $numeric_links as $numeric_link ) : ?>
				<?php echo wp_kses( $numeric_link, themesflat_kses_allowed_html() ); ?>
			<?php endforeach; ?>
		</div>
	</nav>

<?php elseif ( $themesflat_paging_style == 'loadmore' && ! empty( $next_link ) ): ?>

	<nav class="navigation wg-pagination paging-navigation loadmore <?php  echo esc_attr($themesflat_paging_for);?>" role="navigation">
		<div class="tf-pagination text-center draw-border">
			<?php echo wp_kses( $more_link, themesflat_kses_allowed_html() ) ?>
		</div>
	</nav>

<?php elseif ( ! empty( $links ) ): ?>

	<nav class="navigation wg-pagination paging-navigation pager-numeric <?php  echo esc_attr($themesflat_paging_for);?>" role="navigation">
		<div class="tf-pagination">
			<?php foreach ( $links as $link ) : ?>
				<?php echo wp_kses( $link, themesflat_kses_allowed_html() ); ?>
			<?php endforeach; ?>
		</div>
	</nav>

<?php endif ?>
