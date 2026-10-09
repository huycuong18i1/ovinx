<?php
/**
 * Related-posts carousel card title — matches blog-single.html `.entry-title`.
 * Used only by tpl/related-post.php.
 *
 * @package ovinx
 */
?>
<h5 class="entry-title">
	<a href="<?php echo esc_url( get_permalink() ); ?>" class="link-underline cl-text-main">
		<?php the_title(); ?>
	</a>
</h5>
