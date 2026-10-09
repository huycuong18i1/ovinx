<?php  
/**
 * @package ovinx
 */
?>
<?php 

$meta_elements = themesflat_layout_draganddrop(themesflat_get_opt('meta_elements'));

if (in_array('tag', $meta_elements)) {
    $tags = get_the_tags();
    if ($tags) {
        echo '<div class="entry-tag">';
        echo '<ul class="style-list"><li>';

        foreach ($tags as $tag) {
            echo '<a class="type-life" href="' . get_tag_link($tag->term_id) . '">' . $tag->name . '</a> ';
        }

        echo '</li></ul>';
        echo '</div>';
    }
}
?>
