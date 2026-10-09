<?php
/**
 * @package ovinx
 */
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'article-blog hover-img' ); ?>>
			<?php get_template_part( 'tpl/feature-post-archive'); ?>

			<div class="blog-content">
				<div class="d-grid gap-12 mb-20">
					<?php
					get_template_part( 'tpl/entry-content/entry-content-meta-archive' );
					get_template_part( 'tpl/entry-content/entry-content-title-archive' );
					get_template_part( 'tpl/entry-content/entry-content-body-archive' );
					?>
				</div>
				<?php get_template_part( 'tpl/entry-content/entry-content-readmore-archive' ); ?>
			</div>

	</article>
