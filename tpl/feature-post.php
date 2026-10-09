<?php
$feature_post = '';

$blog_layout = themesflat_get_opt('blog_archive_layout');
if (isset($_GET['blog_layout'])){
	$blog_layout = sanitize_text_field($_GET['blog_layout']);
}


$blog_list_style = themesflat_get_opt('blog_list_style');
if (isset($_GET['blog_list_style'])){
	$blog_archive_layout = sanitize_text_field($_GET['blog_list_style']);
}

$size =  'themesflat-blog';

$thumb = get_the_post_thumbnail( get_the_ID(), $size );
if ( empty( $thumb ) )
	return;

$feature_post .= get_the_post_thumbnail( get_the_ID(), $size );
?>


<!-- <div class="entry_image"> -->
    <a href="<?php echo esc_url( get_permalink() ); ?>" class="entry-image img-style4">
        <?php echo wp_kses_post( $feature_post ); ?>
    </a>
<!-- </div> -->
