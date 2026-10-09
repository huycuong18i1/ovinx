<?php
/**
 * Blog archive card title — matches ovinx-html's blog.html `.entry-title`.
 * Used only by content.php (blog archive card).
 *
 * @package ovinx
 */
?>
<h5 class="entry-title">
	<a href="<?php echo esc_url( get_permalink() ); ?>" class="link-underline cl-text-main">
		<?php the_title(); ?>
	</a>
</h5>
