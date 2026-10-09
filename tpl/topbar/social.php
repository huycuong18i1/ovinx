<?php
$style_header = themesflat_get_opt('style_header');
if ( themesflat_get_opt_elementor('style_header') != '' ) {
    $style_header = themesflat_get_opt_elementor('style_header');
}
$social_color_class = ( $style_header === 'header-09' ) ? ' text-white' : '';
?>
<div class="topbar-social<?php echo esc_attr( $social_color_class ); ?>">
    <?php themesflat_render_social();   ?>
</div>