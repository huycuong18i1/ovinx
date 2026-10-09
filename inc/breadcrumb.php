<?php
if ( ! function_exists( 'breadcrumb_trail' ) ){
	require_once trailingslashit( get_template_directory() ) . 'inc/breadcrumb-trail/breadcrumb-trail.php';
}

function themesflat_breadcrumb() {
	$bread_crumb_prefix = themesflat_get_opt( 'bread_crumb_prefix' );
	$show_browse = false;
	if ( $bread_crumb_prefix ) {
		$show_browse = true;
	}
    $show_title = true;
    $args = array(
        'container' => 'div',
        'before' => '',
        'after' => '',
        'browse_tag' => 'span',
        'list_tag' => 'div',
        'item_tag' => 'span',
        'separater' => '<span class="sep dot">'.themesflat_get_opt('breadcrumb_separator').'</span>',
        'show_on_front' => true,
        'network' => false,
        'show_title' => $show_title,
        'show_browse' => $show_browse,
        'labels' => array(
            'browse' => $bread_crumb_prefix,
            'aria_label' => esc_attr_x('Breadcrumbs', 'breadcrumbs aria label', 'ovinx'),
            'home' => esc_html__('Home', 'ovinx'),
            'error_404' => esc_html__('404', 'ovinx'),
            'archives' => esc_html__('Archives', 'ovinx'),
            // Translators: %s is the search query.
            'search' => esc_html__('Search results for: %s', 'ovinx'),
            // Translators: %s is the page number.
            'paged' => esc_html__('Page %s', 'ovinx'),
            // Translators: %s is the page number.
            'paged_comments' => esc_html__('Comment Page %s', 'ovinx'),
            // Translators: Minute archive title. %s is the minute time format.
            'archive_minute' => esc_html__('Minute %s', 'ovinx'),
            // Translators: Weekly archive title. %s is the week date format.
            'archive_week' => esc_html__('Week %s', 'ovinx'),

            // "%s" is replaced with the translated date/time format.
            'archive_minute_hour' => '%s',
            'archive_hour' => '%s',
            'archive_day' => '%s',
            'archive_month' => '%s',
            'archive_year' => '%s',
        ),
        'post_taxonomy' => array(
             'post'  => false, // 'post' post type and 'post_tag' taxonomy
        ),
        'echo' => true
    );
    return breadcrumb_trail($args);
}