<?php
/**
 * Related-posts carousel card meta (date + author) — matches blog-single.html `.blog-meta`.
 * Used only by tpl/related-post.php. Respects the same 'meta_elements' option as the blog
 * archive card (entry-content-meta-archive.php), per explicit user instruction.
 *
 * @package ovinx
 */
$meta_elements = themesflat_layout_draganddrop( themesflat_get_opt( 'meta_elements' ) );
?>
<div class="blog-meta">
	<?php foreach ( $meta_elements as $meta_element ) :
		if ( 'date' === $meta_element ) : ?>
			<p class="text-body-03 cl-text-main"><?php echo esc_html( get_the_date( 'd F' ) ); ?></p>
		<?php elseif ( 'author' === $meta_element ) : ?>
			<p class="text-body-03 cl-text-mute">
				<?php esc_html_e( 'Post by', 'ovinx' ); ?>
				<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="cl-text-main link">
					<?php the_author(); ?>
				</a>
			</p>
		<?php endif;
	endforeach; ?>
</div>
