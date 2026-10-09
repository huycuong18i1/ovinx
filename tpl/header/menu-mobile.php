<?php
if ( ! class_exists( 'Themesflat_Mobile_Navwalker' ) ) {
    class Themesflat_Mobile_Navwalker extends Walker_Nav_Menu {

        private $current_sub_id = '';

        function start_lvl( &$output, $depth = 0, $args = null ) {
            $output .= '<div class="collapse" id="' . esc_attr( $this->current_sub_id ) . '"><ul class="sub-nav-menu">';
        }

        function end_lvl( &$output, $depth = 0, $args = null ) {
            $output .= '</ul></div>';
        }

        function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
            $classes      = empty( $item->classes ) ? array() : (array) $item->classes;
            $has_children = in_array( 'menu-item-has-children', $classes, true );
            $is_active    = array_intersect( array( 'current-menu-item', 'current-menu-parent', 'current-menu-ancestor' ), $classes );

            $this->current_sub_id = 'mb-sub-' . $item->ID;

            $title = apply_filters( 'the_title', $item->title, $item->ID );
            $title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

            if ( 0 === $depth ) {
                $link_class = 'mb-menu-link' . ( $is_active ? ' active' : '' ) . ( $has_children ? ' collapsed' : '' );

                $output .= '<li class="nav-mb-item">';

                if ( $has_children ) {
                    $output .= '<a href="#' . esc_attr( $this->current_sub_id ) . '" class="' . esc_attr( $link_class ) . '" data-bs-toggle="collapse" aria-expanded="false" aria-controls="' . esc_attr( $this->current_sub_id ) . '">'
                        . '<span>' . $title . '</span><span class="icon ic-custom"></span></a>';
                } else {
                    $output .= '<a href="' . esc_url( $item->url ) . '" class="' . esc_attr( $link_class ) . '"><span>' . $title . '</span></a>';
                }
            } else {
                $link_class = 'sub-nav-link' . ( $is_active ? ' active' : '' ) . ( $has_children ? ' collapsed' : '' );

                $output .= '<li>';

                if ( $has_children ) {
                    $output .= '<a href="#' . esc_attr( $this->current_sub_id ) . '" class="' . esc_attr( $link_class ) . '" data-bs-toggle="collapse" aria-expanded="false" aria-controls="' . esc_attr( $this->current_sub_id ) . '">'
                        . $title . '<span class="icon icon-CaretDownV2"></span></a>';
                } else {
                    $output .= '<a href="' . esc_url( $item->url ) . '" class="' . esc_attr( $link_class ) . '">' . $title . '</a>';
                }
            }
        }

        function end_el( &$output, $item, $depth = 0, $args = null ) {
            $output .= '</li>';
        }
    }
}

$header_mb_language = themesflat_get_opt('header_mb_language');
$header_mb_currency = themesflat_get_opt('header_mb_currency');

$show_topbar_mobile_language = 1;
$show_topbar_mobile_currency = 1;

 $class_mb_language =  $class_mb_currency =  '';

if (  $show_topbar_mobile_language != 1 ) {
    $class_mb_language = 'd-none';
}

if (  $show_topbar_mobile_currency != 1) {
    $class_mb_currency = 'd-none';
}

$header_mb_heading = themesflat_get_opt('header_mb_heading');
$header_phone = themesflat_get_opt('header_phone');
$header_email = themesflat_get_opt('header_email');
$header_address = themesflat_get_opt('header_address');
?>


<div class="offcanvas offcanvas-start canvas-mb <?php if ( is_user_logged_in() && is_admin_bar_showing() ) { echo 'is-admin';} ?>" id="mobileMenu" aria-label="<?php esc_attr_e( 'Menu', 'ovinx' ); ?>">
  
    <div class="canvas-header">
        <span class="d-flex">
            <i class="icon icon-Close2 link-rotate cs-pointer cl-text-main" data-bs-dismiss="offcanvas" role="button" tabindex="0" aria-label="<?php esc_attr_e( 'Close', 'ovinx' ); ?>"></i>
        </span>
        <?php get_search_form(); ?>
    </div>


    <div class="canvas-body">
        <div class="mb-content-top">
            <nav class="nav-ul-mb" id="wrapper-menu-navigation" class="" role="navigation">
                <?php
                    wp_nav_menu( array( 'theme_location' => 'mobile', 'menu_class' => 'nav-ul-mb' , 'fallback_cb' => 'themesflat_menu_fallback', 'container' => false, 'walker' => new Themesflat_Mobile_Navwalker() ) );
                ?>
            </nav>   
        </div>

        <div class="need-help-wrap">
            <?php if  (!empty($header_mb_heading)) { ?>
                <h6 class="nd-title text-caption-02 cl-text-main mb-12"><?php echo esc_html($header_mb_heading); ?></h6>
            <?php } ?>
            <?php if (!empty($header_address)) :
                $map_url = 'https://www.google.com/maps?q=' . urlencode($header_address);
            ?>
                <a href="<?php echo esc_url($map_url); ?>"
                target="_blank" rel="noopener noreferrer"
                class="text-caption-01 cl-text-main link-underline mb-8">
                    <?php echo esc_html($header_address); ?>
                </a>
            <?php endif; ?>
            <?php if  (!empty($header_phone)) { ?>
                <a href="tel:<?php echo esc_attr($header_phone); ?>" class="h5 fw-medium cl-text-main link-underline mb-12">
                    <?php echo esc_html($header_phone); ?>
                </a>
            <?php } ?>
            <?php if  (!empty($header_email)) { ?>
                <a href="mailto:<?php echo esc_attr($header_email); ?>" class="text-caption-01 cl-text-main link-underline mb-20">
                    <?php echo esc_html($header_email); ?>
                </a>
            <?php } ?>
            <?php themesflat_render_social(); ?>
        </div>
        
    </div>
    <div class="canvas-footer">
        <?php if ( $header_mb_currency == 1 ): ?>
        <?php 
        if ( class_exists('woocs') ) {
             $currencies = ovinx_get_woocs_currencies();
            ?>

            <div class="tf-currencies <?php echo esc_attr($class_mb_currency); ?>">
                <select id="custom-currency-switcher" class="dropdown bootstrap-select tf-dropdown-select style-default type-currencies setting-curreny-language dropup">
                    <?php foreach ( $currencies as $code => $currency ): ?>
                        <?php
                            $flag_url = $currency['flag'];
                        ?>
                        <option 
                            value="<?php echo esc_attr($code); ?>" 
                            data-thumbnail="<?php echo esc_url($flag_url); ?>" 
                            <?php echo esc_attr(($WOOCS->current_currency === $code) ? 'selected' : ''); ?>
                        >
                            <?php echo esc_html($currency['description']) . ' (' . esc_html($code) . ' ' . esc_html($currency['symbol']) . ')'; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        <?php } else { ?>
            <div class="tf-currencies <?php echo esc_attr($class_mb_currency); ?>">
                <select class="dropdown bootstrap-select tf-dropdown-select style-default type-currencies setting-curreny-language dropup">
                                <option value="USD" selected data-thumbnail="<?php echo esc_url(THEMESFLAT_LINK . 'images/country/us.png') ?> ">(USD $)</option>
                                <option value="EUR" data-thumbnail="<?php echo esc_url(THEMESFLAT_LINK . 'images/country/fr.png') ?>">(EUR €)</option>
                                <option value="VND" data-thumbnail="<?php echo esc_url(THEMESFLAT_LINK . 'images/country/vn.png') ?>">(VND ₫)</option>
                </select>
            </div>
    <?php } endif; ?> 
    <?php if ( $header_mb_language == 1 ): ?>                       
        <?php
        if ( class_exists('woocommerce_wpml') ) {
            $languages = apply_filters( 'wpml_active_languages', NULL, array(
                'skip_missing' => 0,
                'link_empty_to' => '',
                'orderby' => 'code',
                'order' => 'asc',
            ) );
            ?>

            <div class="tf-languages <?php echo esc_attr($class_mb_language); ?>">
                <select class="dropdown bootstrap-select tf-dropdown-select setting-curreny-language style-default type-languages dropup" id="custom-language-switcher">
                    <?php if ( ! empty( $languages ) ) : ?>
                        <?php foreach ( $languages as $lang ): ?>
                            <option 
                                value="<?php echo esc_url( $lang['url'] ); ?>" 
                                data-thumbnail="<?php echo esc_url( $lang['country_flag_url'] ); ?>"
                                <?php echo esc_attr($lang['active'] ? 'selected' : ''); ?>
                            >
                                <?php echo esc_html( $lang['translated_name'] ); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
        <?php } else { ?>
            <div class="tf-languages <?php echo esc_attr($class_mb_language); ?>">
                <select class="dropdown bootstrap-select tf-dropdown-select setting-curreny-language style-default type-languages dropup">
                    <option>English</option>
                    <option>العربية</option>
                    <option>简体中文</option>
                    <option>اردو</option>
                </select>
            </div>
    <?php } endif; ?> 
       
    </div>
</div>

