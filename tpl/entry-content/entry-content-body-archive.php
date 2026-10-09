<?php
/**
 * Blog archive card excerpt — matches ovinx-html's blog.html `.entry-desc`.
 * Used only by content.php (blog archive card).
 *
 * @package ovinx
 */

add_filter( 'excerpt_more', 'themesflat_excerpt_not_more' );
?>
<p class="entry-desc">
	<?php echo wp_kses_post( get_the_excerpt() ); ?>
</p>
