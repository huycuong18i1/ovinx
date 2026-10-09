<?php
/**
 * Template for displaying the wishlist footer.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/wishlist/wishlist-footer.php.
 *
 * @author  WCBoost
 * @package WCBoost\Wishlist\Templates
 * @version 10.3.4
 */

defined( 'ABSPATH' ) || exit;

/**
 * Ground truth (wishlist.html) has no share-this-wishlist row or "Edit wishlist" link — the
 * plugin's default `wcboost_wishlist_footer` hook (share_buttons/link_edit_wishlist) is
 * intentionally not fired here; it only ever printed raw, unstyled text (no CSS anywhere in
 * this theme targets `.wcboost-wishlist-footer`/`.wcboost-wishlist-edit-link*`) and isn't part
 * of this design.
 */

TFWC_Cart_Checkout::instance()->tfwc_get_wl_recently();