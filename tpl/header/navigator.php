
<?php
    class WP_Bootstrap_Navwalker extends Walker_Nav_Menu {

/**
 * Cấp 0→1 dùng .sub-menu (hiện khi hover .menu-item, css/styles.css dòng ~4209).
 * Cấp ≥1 dùng .has-menu-lv2/.sub-menu-lv2 (hiện khi hover riêng .has-menu-lv2, dòng ~4827)
 * - PHẢI khác class nhau, nếu không mọi cấp cùng dùng .sub-menu sẽ khiến hover cấp 0
 * hiện luôn TẤT CẢ submenu con cháu cùng lúc (do .menu-item:hover .sub-menu là descendant selector).
 */
function start_lvl( &$output, $depth = 0, $args = null ) {
    if ( 0 === $depth ) {
        $output .= '<div class="sub-menu"><ul class="sub-menu_list">';
    } else {
        $output .= '<div class="sub-menu-lv2"><ul class="sub-menu_list">';
    }
}

        function end_lvl( &$output, $depth = 0, $args = null ) {
            $output .= '</ul></div>';
        }

function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
    $classes = empty( $item->classes ) ? array() : (array) $item->classes;
    $has_children = in_array( 'menu-item-has-children', $classes, true );

    if ( 0 === $depth ) {
        // .sub-menu (cấp 1) định vị theo chính <li> này (position:relative bắt buộc
        // để absolute .sub-menu không lệch trồi ra ngoài, css/styles.css dòng ~4268).
        $classes[] = 'position-relative';
    } elseif ( $has_children ) {
        $classes[] = 'has-menu-lv2';
    }

    if (
        in_array('current-menu-item', $classes) ||
        in_array('current-menu-parent', $classes) ||
        in_array('current-menu-ancestor', $classes)
    ) {
        $classes[] = 'active';
    }

    $classes = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );

    $class_names = ! empty( $classes ) ? ' class="' . esc_attr( $classes ) . '"' : '';
    $id = 'menu-item-' . $item->ID;

    $output .= '<li id="'. esc_attr($id) .'" '. $class_names .'>';

    $title = apply_filters( 'the_title', $item->title, $item->ID );
    $title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

    if ($depth === 0) {
        $arrow = $has_children ? '<i class="icon icon-CaretDownV2"></i>' : '';
        $output .= '<a href="' . esc_url( $item->url ) . '" class="item-link"><span class="text">'
            . $title . '</span>' . $arrow . '</a>';
    } else {
        $link_class = 'sub-menu_link' . ( $has_children ? ' has-icon' : '' );
        $arrow = $has_children ? '<i class="icon icon-CaretRightV2"></i>' : '';
        $output .= '<a href="' . esc_url( $item->url ) . '" class="' . esc_attr( $link_class ) . '"><span class="text">'
            . $title . '</span>' . $arrow . '</a>';
    }
}

        function end_el( &$output, $item, $depth = 0, $args = null ) {
            $output .= '</li>';
        }
    }
?>
<?php $walker = class_exists('TF_MegaMenu_Walker') ? new TF_MegaMenu_Walker() : new WP_Bootstrap_Navwalker; ?>
<div class="nav-wrap">
    <nav id="mainnav" class="box-navigation d-none d-xl-block" role="navigation">
        <?php
            wp_nav_menu( array( 
                'theme_location' => 'primary', 
                'menu_class' => 'box-nav-menu', 
                'fallback_cb' => 'themesflat_menu_fallback', 
                'container' => false, 
                'walker' => $walker, 
            ) );
        ?>
    </nav><!-- #site-navigation -->  
</div><!-- /.nav-wrap -->   

