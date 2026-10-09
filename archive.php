<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package ovinx
 */

get_header(); ?>
<?php 
	$blog_layout = themesflat_get_opt('blog_archive_layout');
	$columns =  themesflat_get_opt('blog_grid_columns') ;
	if (isset($_GET['blog_layout'])){
		$blog_layout = $_GET['blog_layout'];
	}
	if (isset($_GET['columns'])){
		$columns = $_GET['columns'];
	}
	$post_class = '';
	$class_names = array(
		1 => '',
		2 => '',
		3 => '',
		4 => '',
	);;
	if ($blog_layout == 'blog-grid') {
		$post_class = 's-blog-list-grid ';
		$class_names = array(
			1 => 'blog-one-column grid-1',
			2 => 'blog-two-columns grid-2',
			3 => 'blog-three-columns grid-3',
			4 => 'blog-four-columns grid-4',
		);
	}
	
			
	$class = array('blog-archive');
	$class[] = $blog_layout;
	$class[] = themesflat_get_opt('blog_archive_style');
	// `blog_grid_columns` has no Customizer control (empty by default) — only 1-4 are valid keys.
	$class[] =  $class_names[$columns] ?? '';
	$class[] =  $post_class;
	

	$blog_category = themesflat_get_opt('blog_category');
	if (isset($_GET['blog_category'])){
		$blog_category = $_GET['blog_category'];
	}

	$columns = themesflat_get_opt('blog_category_columns');
    $columns = is_string($columns) ? json_decode($columns, true) : $columns;
    $columns = wp_parse_args($columns, [
        'desktop' => 5,
        'tablet'  => 3,
        'mobile'  => 2,
    ]);
    $category_dek = $columns['desktop'];
    $category_tab  = $columns['tablet'];
    $category_mob  = $columns['mobile'];
	
?>

<section class="s-blog-list-v1 sec-blog space-blog">
	<div class="container">
		<div class="row">
			<div class="col-lg-8">
				<?php if ( have_posts() ) : ?>
					
	
					<div class="tf-grid-layout s-content wrap-blog-article <?php echo esc_attr(implode(" ",$class));?> has-post-content">
						<?php /* Start the Loop */ ?>
						<?php while ( have_posts() ) : the_post(); ?>

							<?php
								/* Include the Post-Format-specific template for the content.
								* If you want to override this in a child theme, then include a file
								* called content-___.php (where ___ is the Post Format name) and that will be used instead.
								*/
								get_template_part( 'content', get_post_type() );
							?>

						<?php endwhile; ?>		
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
			<?php
            $layout = themesflat_get_opt( 'post_sidebar_layout' );

			if (isset($_GET['sidebar'])){
                $layout = $_GET['sidebar'];
            }

			if ( $layout == 'sidebar-left' || $layout == 'sidebar-right' ) :
				get_sidebar();
			endif;
			?>
		</div>
	</div>
</section>
<?php
if ( $layout == 'sidebar-left' || $layout == 'sidebar-right' ) :
	?>
	<div class="btn-sidebar-mb d-lg-none <?php if($layout == 'sidebar-right') { echo 'right' ; }?>">
		<button type="button" data-bs-toggle="offcanvas" data-bs-target="#mbSidebar" aria-label="<?php esc_attr_e( 'Open sidebar', 'ovinx' ); ?>">
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
	<?php
endif;
?>
<?php get_footer(); ?>