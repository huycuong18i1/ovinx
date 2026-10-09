<?php  
/**
 * @package ovinx
 */
?>
						
<?php
$blog_archive_layout = themesflat_get_opt('blog_archive_layout');
if (isset($_GET['blog_archive_layout'])){
	$blog_archive_layout = sanitize_text_field($_GET['blog_archive_layout']);
}
$blog_archive_layout = $args['blog_archive_layout'] ?? $blog_archive_layout ;
if ($blog_archive_layout == 'style-list') {
	// if ( is_singular('post') ) :						
	// 	the_title( '<h5 class="entry-title text-primary entry_title">', '</h5>' );
	// else :
		the_title( sprintf( '<h5 class="entry-title entry_title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h5>' );
	// endif;
} elseif ($blog_archive_layout == 'style-grid') {
		the_title( sprintf( '<h5 class="entry-title entry_title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h5>' );
} else {
	the_title( sprintf( '<h3 class="entry-title entry_title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
}
?>	