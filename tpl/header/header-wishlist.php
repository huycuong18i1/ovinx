<?php
// Wishlist Icon
if ( class_exists( 'WCBoost\Wishlist\Helper' ) ) { 
    $wishlist = \WCBoost\Wishlist\Helper::get_wishlist();
    $wishlist_count = ovinx_wishlist_count( $wishlist );

    ?>
    <li class="nav-wishlist d-md-inline-flex icon-wishlist-header">
        <a href="<?php echo esc_url( wc_get_page_permalink( 'wishlist' ) ); ?>" class="nav-icon-item wishlist-btn-fragment link has-number" aria-label="<?php esc_attr_e( 'Wishlist', 'ovinx' ); ?>">
            <i class="icon icon-Hearth"></i>
            <span class="number-order count-box whishlist-items-count toolbar-count"><?php echo esc_html( $wishlist_count ); ?></span>
        </a>
    </li>

<?php  } ?>





