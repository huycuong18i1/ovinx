<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package ovinx
 */

get_header(); 
$blog_archive_style = themesflat_get_opt('blog_archive_style');
if (isset($_GET['blog_archive_style'])){
	$blog_archive_style = sanitize_text_field($_GET['blog_archive_style']);
}

$blog_grid_style = themesflat_get_opt('blog_grid_style');
if (isset($_GET['blog_grid_style'])){
	$blog_grid_style = sanitize_text_field($_GET['blog_grid_style']);
}

$class_post = "";


if ($blog_archive_style == 'style-grid' ) {
	$class_post = "tf-grid-layout sm-col-2 xl-col-3";
}

$layout = themesflat_get_opt('post_sidebar_layout');
if (isset($_GET['sidebar'])){
	$layout = $_GET['sidebar'];
}

if ( $layout == 'sidebar-left' || $layout == 'sidebar-right' ) {
	$class_column = 'col-lg-8';
} else {
	$class_column = 'col-lg-12';
}

	
			

?>

<section class="s-blog-list">
    <div class="container">
        <div class="row">
            <div class="<?php echo esc_attr($class_column); ?>">
                <?php if ( have_posts() ) : ?>
					<div class="tf-grid-layout wrap-blog-article  has-post-content <?php echo esc_attr($class_post); ?> <?php echo esc_attr($blog_archive_style); ?>">
						<?php /* Start the Loop */ ?>
						<?php $count=1; while ( have_posts() ) : the_post(); ?>

							<?php
								/* Include the Post-Format-specific template for the content.
								* If you want to override this in a child theme, then include a file
								* called content-___.php (where ___ is the Post Format name) and that will be used instead.
								*/
								set_query_var( 'count', $count );
								get_template_part( 'content', get_post_type() );
							?>

						<?php $count++; endwhile; ?>		
					</div>	
					<?php else : ?>
						<?php get_template_part( 'content', 'none' ); ?>

				<?php endif; ?>
				<?php
					$themesflat_paging_for = 'blog';
					$themesflat_paging_style = themesflat_get_opt('blog_archive_pagination_style');		        
					get_template_part( 'tpl/pagination' );
				?>	
            </div>
			<?php if ($class_column != 'col-lg-12'): ?>
				<div class="col-lg-4 d-none d-lg-block sidebar-col">
					<div class="blog-sidebar sidebar-content-wrap sticky-top">
						<?php dynamic_sidebar('blog-sidebar'); ?>
					</div>
				</div>
			<?php endif; ?>
        </div>
    </div>
</section>

<div class="btn-sidebar-mb d-lg-none right">
    <button type="button" data-bs-toggle="offcanvas" data-bs-target="#mbSidebar" aria-label="<?php esc_attr_e( 'Open sidebar', 'ovinx' ); ?>">
        <i class="icon icon icon-Sidebar"></i>
    </button>
</div>


<div class="offcanvas offcanvas-end canvas-sidebar" id="mbSidebar" aria-modal="true" role="dialog">
	<div class="canvas-wrapper">
		<div class="canvas-header">
			<h5 class="title"><?php echo esc_html__('SIDEBAR','ovinx')?></h5>
			<span class="icon-Close icon-close-popup cl-text-main cs-pointer fs-20 link-rotate" data-bs-dismiss="offcanvas"></span>
		</div>
		<div class="canvas-body sidebar-mobile-append blog-sidebar"> 
			<?php dynamic_sidebar('blog-sidebar'); ?>
		</div>
</div>

<?php get_footer(); ?>