<?php
/**
 * @package ovinx
 */
$blog_archive_layout = themesflat_get_opt('blog_archive_layout');
if (isset($_GET['blog_archive_layout'])){
    $blog_archive_layout = sanitize_text_field($_GET['blog_archive_layout']);
}
$blog_archive_layout = $args['blog_archive_layout'] ?? $blog_archive_layout ;
$class_blog = '';

    echo '<div class="post-content post-excerpt entry_desc '. $class_blog .'">';
        if( strpos( get_the_content(), 'more-link' ) === false ) {
            add_filter( 'excerpt_more', 'themesflat_excerpt_not_more' );
            the_excerpt();     
        } else {
            add_filter( 'the_content_more_link', 'themesflat_excerpt_not_more' );
            the_content();
        }
        wp_link_pages( array(
            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'ovinx' ),
            'after'  => '</div>',
        ) );
    echo '</div>';



