<?php
/**
 * Related-posts carousel card "Read More" link — matches blog-single.html `.tf-btn-line.style-min`.
 * Used only by tpl/related-post.php.
 *
 * @package ovinx
 */

$readmore_text = themesflat_get_opt( 'blog_archive_readmore_text' );
if ( empty( $readmore_text ) ) {
	$readmore_text = esc_html__( 'Read More', 'ovinx' );
}
?>
<a href="<?php echo esc_url( get_permalink() ); ?>" class="tf-btn-line style-min fw-semibold">
	<?php echo esc_html( $readmore_text ); ?><span class="screen-reader-text"> <?php echo esc_html( sprintf( /* translators: %s: post title */ __( 'about %s', 'ovinx' ), get_the_title() ) ); ?></span>
</a>
