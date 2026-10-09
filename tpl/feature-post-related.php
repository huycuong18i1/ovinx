<?php
/**
 * Related-posts carousel card thumbnail + category tag overlay.
 * Used only by tpl/related-post.php — matches ovinx-html's blog-single.html `.article-blog.style-2`.
 *
 * @package ovinx
 */

$size  = 'themesflat-blog';
$thumb = get_the_post_thumbnail( get_the_ID(), $size, array( 'loading' => 'lazy' ) );
if ( empty( $thumb ) ) {
	return;
}

$categories = get_the_category();
$category   = ! empty( $categories ) ? $categories[0] : null;

$meta_elements = themesflat_layout_draganddrop( themesflat_get_opt( 'meta_elements' ) );
$show_category = in_array( 'category', (array) $meta_elements, true );
?>

<a href="<?php echo esc_url( get_permalink() ); ?>" class="blog-image img-style">
	<?php echo wp_kses_post( $thumb ); ?>
	<?php if ( $category && $show_category ) : ?>
		<div class="entry_tag">
			<p class="name-tag text-label text-uppercase fw-semibold">
				<?php echo esc_html( $category->name ); ?>
			</p>
		</div>
	<?php endif; ?>
</a>
