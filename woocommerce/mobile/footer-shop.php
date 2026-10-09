<?php
$show_navigation_bar = themesflat_get_opt('show_navigation_bar');

if($show_navigation_bar == 1) {
    ?>
    <div class="tf-toolbar-bottom">
    <?php
        $content_elements = themesflat_layout_draganddrop(themesflat_get_opt( 'navbar_element' ));
        foreach ( $content_elements as $content_element ) :
            if ( 'home' == $content_element ) {
                ?>
                <div class="toolbar-item">
                    <a href="<?php echo esc_url( home_url() ); ?>">
                        <span class="toolbar-icon">
                            <i class="icon icon-HouseLine"></i>
                        </span>
                        <span class="toolbar-label"><?php echo _e('Home','ovinx')?></span>
                    </a>
                </div>
                <?php
            } elseif ( 'account' == $content_element ) {
                ?>
                <div class="toolbar-item">
                    <?php
                    if (is_user_logged_in()) {
                        $my_account_page_id = wc_get_page_id('myaccount');
                        $my_account_url = get_permalink($my_account_page_id);
                        $modal_type = 'offcanvas';
                    } else {
                        $my_account_url = '#log';
                        $modal_type = 'modal';
                    }
                    ?>
                    <a href="#log" data-bs-toggle="<?php echo esc_attr($modal_type); ?>">
                        <span class="toolbar-icon">
                            <i class="icon icon-User"></i>
                        </span>
                        <span class="toolbar-label"><?php echo _e('Account','ovinx')?></span>
                    </a>
                </div>
                <?php
            } elseif ( 'shop' == $content_element ) {
                ?>
                <div class="toolbar-item">
                    <?php
                        $shop_page_id = wc_get_page_id('shop');
                        $shop_url = get_permalink($shop_page_id);
                    ?>
                    <a href="<?php echo esc_url($shop_url);?>">
                        <span class="toolbar-icon">
                            <i class="icon icon-SquaresFour"></i>
                        </span>
                        <span class="toolbar-label"><?php echo _e('Shop','ovinx')?></span>
                    </a>
                </div>
                <?php
            }  elseif ( 'wishlist' == $content_element ) {

                    if ( class_exists( 'WCBoost\Wishlist\Helper' ) ) {
                    $wishlist = \WCBoost\Wishlist\Helper::get_wishlist();
                    $wishlist_count = ovinx_wishlist_count( $wishlist );

                    ?>
                    <div class="toolbar-item">
                        <a href="<?php echo esc_url( wc_get_page_permalink( 'wishlist' ) ); ?>" class="wishlist-btn-fragment">
                            <span class="toolbar-icon">
                                <i class="icon icon-Hearth"></i>
                                <span class="toolbar-count count-box whishlist-items-count"><?php echo esc_html( $wishlist_count ); ?></span>
                            </span>
                            <span class="toolbar-label"><?php echo _e('Wishlist','ovinx')?></span>
                        </a>
                    </div>
                    <?php
                    }
            } elseif ( 'cart' == $content_element ) {

                if ( class_exists( 'woocommerce' ) ) { ?>
                    <div class="toolbar-item nav-cart">
                        <a href="<?php echo esc_url( wc_get_page_permalink( 'cart' ) ); ?>" data-bs-toggle="offcanvas" data-bs-target="#shoppingCart" class="nav-icon-item">
                            <span class="toolbar-icon">
                                <i class="icon icon-ShoppingBagOpen"></i>
                                <?php if ( $items_count = WC()->cart->get_cart_contents_count() ): ?>
                                    <span class="toolbar-count shopping-cart-items-count"><?php echo esc_html( $items_count ) ?></span>
                                <?php else: ?>
                                    <span class="toolbar-count shopping-cart-items-count">0</span>
                                <?php endif ?>
                            </span>
                            <span class="toolbar-label"><?php echo _e('Cart','ovinx')?></span>
                        </a>
                    </div>

                <?php  }
            }
        endforeach;
    ?>
    </div>
<?php } ?>
