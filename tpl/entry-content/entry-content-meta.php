<?php  
/**
 * @package ovinx
 */
?>
<?php 
$blog_archive_layout = themesflat_get_opt('blog_archive_layout');
if (isset($_GET['blog_archive_layout'])){
    $blog_archive_layout = sanitize_text_field($_GET['blog_archive_layout']);
}
$blog_archive_layout = $args['blog_archive_layout'] ?? $blog_archive_layout ;
$class_blog = '';

echo '<ul class="entry_meta meta-list">';
    $meta_elements = themesflat_layout_draganddrop(themesflat_get_opt( 'meta_elements' ));
    $count = 0;
    $total_elements = count($meta_elements);
    foreach ( $meta_elements as $meta_element ) :
        $count++;

        if ($count == 2 && $total_elements > 1 ) { 
            echo '<li class="br-line"></li>';
        }
        if ( 'author' == $meta_element ) {
            echo '<li class="entry_author">';
            
                $author_id =get_the_author_meta( 'ID');
                $author_email = get_the_author_meta('user_email', $author_id);
                $avatar = get_avatar($author_email, 80);
                echo '<div class="avt">'. $avatar .'</div>';
                printf(
                '<a class="name_author   text-main-4 link" href="%s" title="%s" rel="author">%s</a>',
                esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) )),
                esc_attr( sprintf( esc_html__( 'Post by <span class="fw-medium">%s</span>', 'ovinx' ), get_the_author() ) ),get_the_author());
            echo '</li>';
        }   elseif ( 'date' == $meta_element ) {
            
                    echo '<li class="entry_day ">';   
                        $archive_year  = get_the_time('Y'); 
                        $archive_month = get_the_time('m'); 
                        $archive_day   = get_the_time('d');                 
                        echo '<a class="date'. $class_blog .'" href="'.get_day_link( $archive_year, $archive_month, $archive_day).'">'.get_the_date('M d Y').'</a>';
                    echo '</li>';
        }
         elseif ( 'tag' == $meta_element ) {
            
            $tags = get_the_tags();
            if ($tags) {
                echo '<ul class="style-list"><li>';

                foreach ($tags as $tag) {
                    echo '<a class="badge-tag text-label" href="' . get_tag_link($tag->term_id) . '">' . $tag->name . '</a> ';
                }

                echo '</li></ul>';
            }  
        }
    endforeach;
echo '</ul>';
?>

