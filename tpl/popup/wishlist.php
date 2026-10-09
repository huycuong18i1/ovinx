<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'WCBoost\Wishlist\Helper' ) ){
    return;
}

$wishlist = \WCBoost\Wishlist\Helper::get_wishlist();
$items = $wishlist->get_items();

?>

<div class="canvas-wishlist offcanvas offcanvas-end" id="wishList" aria-modal="true" role="dialog">
    <div class="canvas-header">
        <h5 class="title-pop text-primary"><?php _e('Wish List', 'ovinx'); ?></h5>
        <span class="icon-close-popup" data-bs-dismiss="offcanvas" role="button" aria-label="<?php esc_attr_e( 'Close', 'ovinx' ); ?>">
            <i class="icon icon-close"></i>
        </span>
    </div>
    <div class="canvas-body">
        <?php get_template_part( 'tpl/popup/wishlist-content');  ?>
    </div>
    <div class="canvas-footer">
        <div class="overlay-close" data-bs-dismiss="offcanvas"></div>
        <div class="d-flex flex-column align-items-center gap-16 text-center">
            <a href="<?php echo esc_url( wc_get_page_permalink( 'wishlist' ) ); ?>" class="tf-btn animate-btn w-100">
                <?php _e('View All Wish List', 'ovinx'); ?>
            </a>
            <a href="<?php ?>" class="tf-btn-line p-0">
                <?php _e('Or continue shopping', 'ovinx'); ?>
            </a>
        </div>
    </div>
</div>