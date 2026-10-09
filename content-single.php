<?php
/**
 * Blog single post content — matches ovinx-html's blog-single.html.
 *
 * @package ovinx
 */

$categories = get_the_category();
$category   = ! empty( $categories ) ? $categories[0] : null;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-single-content' ); ?>>

	<div class="single-content_heading">
		<?php if ( $category ) : ?>
			<div class="entry-tag text-button-small">
				<?php echo esc_html( $category->name ); ?>
			</div>
		<?php endif; ?>
		<h1 class="h2 entry-name">
			<?php the_title(); ?>
		</h1>
		<ul class="entry-meta">
			<li>
				<i class="icon icon-CalendarBlank"></i>
				<p class="cl-text-main text-body-02">
					<?php echo esc_html( get_the_date( 'd F, Y' ) ); ?>
				</p>
			</li>
			<li class="br-line type-vertical h-16"></li>
			<li>
				<i class="icon icon-User"></i>
				<p class="cl-text-main text-body-02">
					<span class="text-secondary"><?php esc_html_e( 'Post by', 'ovinx' ); ?></span>
					<?php the_author(); ?>
				</p>
			</li>
		</ul>
	</div>

	<div class="single-content_body">
		<?php the_content(); ?>
		<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'ovinx' ),
			'after'  => '</div>',
		) );
		?>

		<?php if ( themesflat_get_opt( 'show_entry_footer_content' ) == 1 ) : ?>
			<?php $post_tags = get_the_tags(); ?>
			<div class="bottom-other">
				<?php if ( $post_tags && ! is_wp_error( $post_tags ) ) : ?>
					<div class="single-tag">
						<span class="fw-medium lh-24 cl-text-main"><?php esc_html_e( 'Tag', 'ovinx' ); ?></span>
						<?php foreach ( $post_tags as $tag ) : ?>
							<a href="<?php echo esc_url( get_tag_link( $tag ) ); ?>" class="entry-tag text-label">
								<?php echo esc_html( $tag->name ); ?>
							</a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
				<div class="single-social">
					<span class="fw-medium lh-24 cl-text-main"><?php esc_html_e( 'Share this post:', 'ovinx' ); ?></span>
					<?php themesflat_render_social(); ?>
				</div>
			</div>
		<?php endif; ?>
	</div>

	<?php if ( themesflat_get_opt( 'show_post_navigator' ) == 1 ) : ?>
		<?php
		$prev_post = get_previous_post();
		$next_post = get_next_post();
		?>
		<?php if ( $prev_post || $next_post ) : ?>
			<div class="single-content_footer">
				<?php if ( $prev_post ) : ?>
					<a href="<?php echo esc_url( get_permalink( $prev_post ) ); ?>" class="btn-direc_post direc-prev h6 lh-28 link">
						<span class="text-body-03 text-decoration-underline"><?php esc_html_e( 'PREVIOUS', 'ovinx' ); ?></span>
						<?php echo esc_html( get_the_title( $prev_post ) ); ?>
					</a>
				<?php endif; ?>
				<span class="br-line type-vertical pseudo-elm"></span>
				<?php if ( $next_post ) : ?>
					<a href="<?php echo esc_url( get_permalink( $next_post ) ); ?>" class="btn-direc_post direc-next h6 lh-28 link">
						<span class="text-body-03 text-decoration-underline"><?php esc_html_e( 'NEXT', 'ovinx' ); ?></span>
						<?php echo esc_html( get_the_title( $next_post ) ); ?>
					</a>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	<?php endif; ?>

</article>
