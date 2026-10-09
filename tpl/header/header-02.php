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

$information_phone = themesflat_get_opt('information_phone');
?>
<?php get_template_part( 'tpl/topbar-09'); ?>

        <header class="tf-header header-v2 header-02 <?php echo esc_attr( themesflat_get_opt_elementor('extra_classes_header') ); ?>">
            <div class="header-inner position-relative z-1">
                <div class="container">
                    <div class="header-inner_wrap">
                        <div class="header-left">
                            <div class="box-btn-open-menu d-flex d-xl-none">
                                <a href="#mobileMenu" data-bs-toggle="offcanvas" class="cl-text-main" aria-label="<?php esc_attr_e( 'Open menu', 'ovinx' ); ?>">
                                    <i class="icon icon-OpenMenu fs-24"></i>
                                </a>
                            </div>
                            <div class="xl-d-none">
                                <?php get_template_part( 'tpl/header/brand'); ?>
                            </div>
                        </div>

                        <span class="br-line type-vertical"></span>

                        <div class="header-center xl-justify-content-center">
                            <div class="d-xl-none">
                                <?php get_template_part( 'tpl/header/brand'); ?>
                            </div>
                            <?php if ( $header_search_box_form == 1 ) : ?>
                                <form action="<?php echo esc_url( home_url( '/' ) ); ?>" class="form-search-nav xl-d-none">
                                    <input class="ajax-search-input" type="text" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'What are you looking for today?', 'ovinx' ); ?>" required>
                                    <button type="submit" class="cl-text-main link fs-28" aria-label="<?php esc_attr_e( 'Search', 'ovinx' ); ?>">
                                        <i class="icon icon-MagnifyingGlass"></i>
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>

                        <span class="br-line type-vertical"></span>

                        <div class="header-right">
                            <?php if ( ! empty( $information_phone ) ) : ?>
                                <div class="nead-help-wrap lg-d-none">
                                    <p class="text-caption-01 text-secondary"><?php esc_html_e( 'Need help:', 'ovinx' ); ?></p>
                                    <a href="tel:<?php echo esc_attr( $information_phone ); ?>" class="cl-text-main fw-semibold link-underline"><?php echo esc_html( $information_phone ); ?></a>
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
                                <li class="br-line type-vertical"></li>
                                <?php endif; ?>

                                <?php if ( $header_compare_icon == 1 ) : ?>
                                    <?php get_template_part( 'tpl/header/header-compare'); ?>
                                    <li class="br-line type-vertical"></li>
                                <?php endif; ?>

                                <?php if ( $header_wishlist_icon == 1 ) : ?>
                                    <?php get_template_part( 'tpl/header/header-wishlist'); ?>
                                    <li class="br-line type-vertical"></li>
                                <?php endif; ?>

                                <?php if ( $header_cart_icon == 1 ) : ?>
                                    <?php get_template_part( 'tpl/header/header-cart'); ?>
                                    <li class="br-line type-vertical"></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="br-line fake-class bottom-0 d-none d-xl-block"></div>
            </div>

            <div class="header-bottom d-none d-xl-block position-relative">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-8">
                            <?php get_template_part( 'tpl/header/navigator'); ?>
                        </div>
                        <div class="col-xl-4 d-flex justify-content-end">
                            <?php echo wp_kses_post( themesflat_get_opt( 'header_special_offers' ) ); ?>
                        </div>
                    </div>
                </div>
            </div>

        </header>

<?php get_template_part( 'tpl/header/menu-mobile'); ?>

        <?php
            if ( themesflat_get_opt( 'header_search_box') == 1 ) {
                get_template_part( 'tpl/popup/search');
            }
        ?>
