<?php
$header_login = themesflat_get_opt('header_login');
if (themesflat_get_opt_elementor('header_login') != '') {
    $header_login = themesflat_get_opt_elementor('header_login');
}

$header_wishlist_icon = themesflat_get_opt('header_wishlist_icon');
if (themesflat_get_opt_elementor('header_wishlist_icon') != '') {
    $header_wishlist_icon = themesflat_get_opt_elementor('header_wishlist_icon');
}

$header_cart_icon = themesflat_get_opt('header_cart_icon');
if (themesflat_get_opt_elementor('header_cart_icon') != '') {
    $header_cart_icon = themesflat_get_opt_elementor('header_cart_icon');
}

$information_phone = themesflat_get_opt('information_phone');

$show_header_category = themesflat_get_opt('show_header_category');
if (themesflat_get_opt_elementor('show_header_category') != '') {
    $show_header_category = themesflat_get_opt_elementor('show_header_category');
}
?>
<?php get_template_part( 'tpl/topbar-09'); ?>

        <header class="tf-header tf-header-landing header-default <?php echo esc_attr( themesflat_get_opt_elementor('extra_classes_header') ); ?>">
            <div class="header-inner bg-primary-2 position-relative z-1">
                <div class="container">
                    <div class="header-inner_wrap">
                        <div class="header-left">
                            <div class="box-btn-open-menu d-flex d-xl-none">
                                <a href="#mobileMenu" data-bs-toggle="offcanvas" class="btn-open-menu" aria-label="<?php esc_attr_e( 'Open menu', 'ovinx' ); ?>">
                                    <i class="icon icon-List text-white fs-24"></i>
                                </a>
                            </div>
                            <?php get_template_part( 'tpl/header/brand'); ?>
                        </div>

                        <div class="header-center xl-justify-content-center">
                            <?php if ( $show_header_category == 1 ) : ?>
                                <?php get_template_part( 'tpl/header/header-category-mega'); ?>
                            <?php endif; ?>

                            <form action="<?php echo esc_url( home_url( '/' ) ); ?>" class="form-search-nav lg-d-none">
                                <input type="hidden" name="post_type" value="product">
                                <input class="style-2 ajax-search-input" type="text" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'What are you looking for today?', 'ovinx' ); ?>" required>
                                <button type="submit" class="btn-action_submit" aria-label="<?php esc_attr_e( 'Search', 'ovinx' ); ?>">
                                    <i class="icon icon-MagnifyingGlass"></i>
                                </button>
                            </form>
                        </div>

                        <div class="header-right">
                            <?php if ( ! empty( $information_phone ) ) : ?>
                                <div class="nead-help-wrap lg-d-none">
                                    <p class="text-caption-01 text-white"><?php esc_html_e( 'Need help:', 'ovinx' ); ?></p>
                                    <a href="tel:<?php echo esc_attr( $information_phone ); ?>" class="text-white fw-semibold link-underline"><?php echo esc_html( $information_phone ); ?></a>
                                </div>
                                <span class="br-line type-vertical bg-white_10 lg-d-none"></span>
                            <?php endif; ?>

                            <ul class="nav-icon-list">
                                <?php if ( $header_login == 1 ) :
                                    $is_logged_in = is_user_logged_in();
                                    $toggle = $is_logged_in ? 'offcanvas' : 'modal';
                                ?>
                                <li class="nav-account">
                                    <a href="#log" data-bs-toggle="<?php echo esc_attr($toggle); ?>" class="nav-icon-item text-white link" aria-label="<?php echo esc_attr( $is_logged_in ? __( 'My Account', 'ovinx' ) : __( 'Login/Register', 'ovinx' ) ); ?>">
                                        <i class="icon icon-User"></i>
                                    </a>
                                </li>
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

            <div class="container bottom-header-container">
                <div class="row align-items-center">
                    <div class="col-xl-8">
                        <div class="header-bottom">
                            <?php get_template_part( 'tpl/header/navigator'); ?>
                        </div>
                    </div>
                    <div class="col-xl-4 d-flex justify-content-end">
                        <?php echo wp_kses_post( themesflat_get_opt( 'header_special_offers' ) ); ?>
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
