<?php
/**
 * Blog archive card meta (date + author) — matches ovinx-html's blog.html `.blog-meta`.
 * Used only by content.php (blog archive card).
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
