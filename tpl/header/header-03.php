<?php
$header_search_box_form = themesflat_get_opt('header_search_box_form');
if (themesflat_get_opt_elementor('header_search_box_form') != '') {
    $header_search_box_form = themesflat_get_opt_elementor('header_search_box_form');
}

$header_cart_icon = themesflat_get_opt('header_cart_icon');
if (themesflat_get_opt_elementor('header_cart_icon') != '') {
    $header_cart_icon = themesflat_get_opt_elementor('header_cart_icon');
}

$header_wishlist_icon = themesflat_get_opt('header_wishlist_icon');
if (themesflat_get_opt_elementor('header_wishlist_icon') != '') {
    $header_wishlist_icon = themesflat_get_opt_elementor('header_wishlist_icon');
}

$header_compare_icon = themesflat_get_opt('header_compare_icon');
if (themesflat_get_opt_elementor('header_compare_icon') != '') {
    $header_compare_icon = themesflat_get_opt_elementor('header_compare_icon');
}

$header_login = themesflat_get_opt('header_login');
if (themesflat_get_opt_elementor('header_login') != '') {
    $header_login = themesflat_get_opt_elementor('header_login');
}

$show_header_category = themesflat_get_opt('show_header_category');
if (themesflat_get_opt_elementor('show_header_category') != '') {
    $show_header_category = themesflat_get_opt_elementor('show_header_category');
}

$information_phone = themesflat_get_opt('information_phone');
?>
<?php get_template_part( 'tpl/topbar-09'); ?>

        <header class="tf-header header-v3 header-03 <?php echo esc_attr( themesflat_get_opt_elementor('extra_classes_header') ); ?>">
            <div class="header-inner position-relative z-1">
                <div class="container">
                    <div class="header-inner_wrap">
                        <div class="header-left">
                            <div class="box-btn-open-menu d-flex d-xl-none">
                                <a href="#mobileMenu" data-bs-toggle="offcanvas" aria-label="<?php esc_attr_e( 'Open menu', 'ovinx' ); ?>">
                                    <i class="icon icon-OpenMenu fs-24 cl-text-main"></i>
                                </a>
                            </div>
                            <div class="lg-d-none">
                                <?php get_template_part( 'tpl/header/brand'); ?>
                            </div>
                        </div>

                        <div class="header-center xl-justify-content-center">
                            <div class="d-lg-none">
                                <?php get_template_part( 'tpl/header/brand'); ?>
                            </div>

                            <?php if ( $show_header_category == 1 ) : ?>
                                <?php get_template_part( 'tpl/header/header-category-mega'); ?>
                            <?php endif; ?>

                            <?php if ( $header_search_box_form == 1 ) : ?>
                                <form action="<?php echo esc_url( home_url( '/' ) ); ?>" class="form-search-nav style-2 lg-d-none">
                                    <input class="ajax-search-input" type="text" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'What are you looking for today?', 'ovinx' ); ?>" required>
                                    <button type="submit" class="btn-action_submit" aria-label="<?php esc_attr_e( 'Search', 'ovinx' ); ?>">
                                        <i class="icon icon-MagnifyingGlass"></i>
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>

                        <div class="header-right">
                            <?php if ( ! empty( $information_phone ) ) : ?>
                                <div class="nead-help-wrap text-caption-01 cl-text-main lg-d-none">
                                    <span><?php esc_html_e( 'Call us:', 'ovinx' ); ?></span>
                                    <a href="tel:<?php echo esc_attr( $information_phone ); ?>" class="fw-semibold link-underline"><?php echo esc_html( $information_phone ); ?></a>
                                </div>
                                <span class="br-line type-vertical lg-d-none"></span>
                            <?php endif; ?>

                            <ul class="nav-icon-list">
                                <?php if ( $header_login == 1 ) :
                                    $is_logged_in = is_user_logged_in();
                                    $toggle = $is_logged_in ? 'offcanvas' : 'modal';
                                ?>
                                <li class="nav-account">
                                    <a href="#log" data-bs-toggle="<?php echo esc_attr($toggle); ?>" class="nav-icon-item cl-text-main link" aria-label="<?php echo esc_attr( $is_logged_in ? __( 'My Account', 'ovinx' ) : __( 'Login/Register', 'ovinx' ) ); ?>">
                                        <i class="icon icon-User"></i>
                                    </a>
                                </li>
                                <?php endif; ?>

                                <?php if ( $header_compare_icon == 1 ) : ?>
                                    <?php get_template_part( 'tpl/header/header-compare'); ?>
                                <?php endif; ?>

                                <?php if ( $header_wishlist_icon == 1 ) : ?>
                                    <?php get_template_part( 'tpl/header/header-wishlist'); ?>
                                <?php endif; ?>

                                <?php if ( $header_cart_icon == 1 ) : ?>
                                    <?php get_template_part( 'tpl/header/header-cart'); ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="header-bottom d-none d-xl-block position-relative">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="inner-header">
                                <div class="row">
                                    <div class="col-xl-8">
                                        <?php get_template_part( 'tpl/header/navigator'); ?>
                                    </div>
                                    <div class="col-xl-4 d-flex justify-content-end">
                                        <?php echo wp_kses_post( themesflat_get_opt( 'header_special_offers' ) ); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <span class="br-line fake-class top-0"></span>
            </div>

        </header>

<?php get_template_part( 'tpl/header/menu-mobile'); ?>

        <?php
            if ( themesflat_get_opt( 'header_search_box') == 1 ) {
                get_template_part( 'tpl/popup/search');
            }
        ?>
