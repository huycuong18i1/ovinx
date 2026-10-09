<!-- shoppingCart -->
<?php if (themesflat_get_opt( 'header_cart_icon') == 1  && class_exists( 'woocommerce' ) && !is_cart() && !is_checkout() ) { ?>
    <div class="offcanvas offcanvas-end canvas-shop-cart popup-shopping-cart <?php if ( is_user_logged_in() && is_admin_bar_showing() ) { echo 'is-admin';} ?>" id="shoppingCart">

        <div class="canvas-wrapper">
            <div class="canvas-header">
                <h6 class="title-pop"><?php _e( 'Shopping Cart', 'ovinx' ); ?></h6>
                <button type="button" class="btn-close-popup" data-bs-dismiss="offcanvas" aria-label="<?php esc_attr_e( 'Close', 'ovinx' ); ?>">
                    <i class="icon icon-Close2"></i>
                </button>
            </div>
            <div class="wrap list-file-delete">
                <?php // .tf-mini-cart-threshold is the WooCommerce fragment target (Woo_Hook::update_free_shipping_bar_fragments); content shared via inc/helper.php ?>
                <div class="tf-mini-cart-threshold">
                    <?php echo ovinx_get_mini_cart_threshold(); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped where built ?>
                </div>
                <div class="widget_shopping_cart_content wrap">
                    <?php woocommerce_mini_cart(); ?>
                </div>
            </div>

            <div class="canvas-footer">
                <div class="overlay-close" data-bs-dismiss="offcanvas"></div>
            </div>
        </div>
    </div>
<?php } ?>
<!-- /shoppingCart --> 