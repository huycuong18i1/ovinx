<?php
// Cart Icon
if ( class_exists( 'woocommerce' ) ) { ?>
    <li class="nav-cart">
        <a href="<?php echo esc_url( wc_get_page_permalink( 'cart' ) ); ?>"
            data-bs-toggle="<?php echo esc_attr( ( function_exists( 'is_cart' ) && is_cart() ) || ( function_exists( 'is_checkout' ) && is_checkout() ) ? '' : 'offcanvas'); ?>"
            data-bs-target="#shoppingCart"
            class="nav-icon-item link has-number shop-cart"
            aria-label="<?php esc_attr_e( 'Cart', 'ovinx' ); ?>"
        >
            <div class="position-relative d-flex">
                <i class="icon icon-ShoppingBagOpen"></i>
                <?php if ( $items_count = WC()->cart->get_cart_contents_count() ): ?>
                    <span class="number-order shopping-cart-items-count"><?php echo esc_html( $items_count ) ?></span>
                <?php else: ?>
                    <span class="number-order shopping-cart-items-count">0</span>
                <?php endif ?>
            </div>
            <div class="fw-semibold d-none d-xxl-block">
                <p class="text-label"><?php esc_html_e( 'Cart Total', 'ovinx' ); ?></p>
                <p class="text-button shopping-cart-subtotal"><?php echo wp_kses_post( WC()->cart->get_cart_subtotal() ); ?></p>
            </div>
        </a>
    </li>

<?php  } ?>

