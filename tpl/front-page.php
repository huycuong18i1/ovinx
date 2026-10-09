<?php
/*
Template Name: Front Page
*/

get_header(); ?>
<div id="main" class="site-main">
	<div class="entry-content">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php the_content(); ?>
		<?php endwhile; ?>
	</div><!-- .entry-content -->
</div><!-- #main -->

<?php get_footer(); ?>