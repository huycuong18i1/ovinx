<?php
/**
 * The template for displaying all single posts.
 *
 * @package ovinx
 */

get_header(); ?>
<?php
	$layout = themesflat_get_opt('post_layout_single');
	if (isset($_GET['sidebar'])){
		$layout = $_GET['sidebar'];
	}

	if ( $layout == 'sidebar-left' || $layout == 'sidebar-right' ) {
		$class_column = 'col-lg-8';
	} else {
		$class_column = 'col-lg-10 col-xl-8 mx-auto';
	}
?>
<div class="section-blog-single">
	<div class="container">
		<?php while ( have_posts() ) : the_post(); ?>

			<?php if ( has_post_thumbnail() ) : ?>
				<div class="entry-image-hero">
					<?php the_post_thumbnail( 'themesflat-blog-single', array( 'loading' => 'eager', 'fetchpriority' => 'high' ) ); // QA PERF-001: hero is above the fold, never lazy ?>
				</div>
			<?php endif; ?>

			<div class="row">
				<div class="<?php echo esc_attr($class_column); ?>">
					<?php get_template_part( 'content', 'single' ); ?>

					<?php if ( is_user_logged_in() ) : ?>
						<?php if ( get_the_author_meta( 'description' ) ): ?>
							<div class="author-post">
								<div class="author-body clearfix">
									<div class="author-avatar">
										<?php
										echo get_avatar(get_the_author_meta('user_email'),$size='170');
										?>
									</div><!--/.author-avatarr -->

									<div class="info">
										<div class="name">
											<h6><?php the_author_posts_link(); ?></h6>
										</div>
										<p class="intro">
											<?php
											echo get_the_author_meta( 'description' );
											?>
										</p>
										<?php themesflat_render_social(); ?>
									</div><!--/.author-info -->
								</div><!--/.author-info -->
							</div><!--/.author-body -->
						<?php endif; ?>
					<?php endif; ?>
					<?php
						// If comments are open or we have at least one comment, load up the comment template
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;
					?>
				</div>
				<?php if ( $layout == 'sidebar-left' || $layout == 'sidebar-right' ) : ?>
					<div class="col-lg-4 d-none d-lg-block">
						<div class="blog-sidebar sidebar-content-wrap sticky-top">
							<?php dynamic_sidebar('blog-sidebar'); ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		<?php endwhile; ?>
	</div>
</div>
<?php get_template_part( 'tpl/related-post' )?>

<?php if ( $layout == 'sidebar-left' || $layout == 'sidebar-right' ) : ?>
	<div class="btn-sidebar-mb d-lg-none <?php if($layout == 'sidebar-right') { echo 'right' ; }?>">
		<button data-bs-toggle="offcanvas" data-bs-target="#mbSidebar">
			<i class="icon icon icon-Sidebar"></i>
		</button>
	</div>
	<div class="offcanvas <?php if($layout == 'sidebar-left') { echo 'offcanvas-start' ; } else { echo 'offcanvas-end' ;}?> canvas-filter canvas-sidebar " id="mbSidebar" aria-modal="true" role="dialog">
		<div class="canvas-wrapper">
			<div class="canvas-header">
				<span class="title"><?php echo esc_html__('SIDEBAR','ovinx')?></span>
				<button class="icon-close icon-close-popup" data-bs-dismiss="offcanvas" aria-label="Close"></button>
			</div>
			<div class="canvas-body sidebar-mobile-append sidebar-blog">
				<?php dynamic_sidebar('blog-sidebar'); ?>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php get_footer(); ?>
