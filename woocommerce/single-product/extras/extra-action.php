<?php

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! themesflat_get_opt( 'tf_extra_action' ) ) {
    return;
}

if ( ! $product instanceof WC_Product ) {
    $product = wc_get_product( get_queried_object_id() );
}

$size_guide_id = 0;

if (
    themesflat_get_opt( 'tf_size_guide' ) &&
    $product instanceof WC_Product
) {
    $size_guide_id = Woo_Single_Product_Hook::instance()
        ->get_product_size_guide_id( $product );
}

?>

<div class="tf-product-extra-link">

    <?php
    // Wishlist first (design order: Wishlist, Compare, Share). It used to be the boxed heart beside Add to cart.
    if (
        themesflat_get_opt( 'tf_wishlist_pos' ) &&
        class_exists( 'WCBoost\Wishlist\Frontend' ) &&
        method_exists( 'WCBoost\Wishlist\Frontend', 'single_add_to_wishlist_button' )
    ) :
        ?>
        <div class="product-extra-icon link tf-extra-wishlist">
            <?php
            set_query_var( 'is_wl_extra_row', true );
            \WCBoost\Wishlist\Frontend::instance()->single_add_to_wishlist_button();
            set_query_var( 'is_wl_extra_row', false );
            ?>
        </div>
    <?php endif; ?>

    <?php
    if (
        themesflat_get_opt( 'tf_wishlist_pos' ) &&
        class_exists( 'WCBoost\ProductsCompare\Frontend' )
    ) :
        ?>
        <div class="product-extra-icon link">
            <?php
            if (
                method_exists(
                    'WCBoost\ProductsCompare\Frontend',
                    'single_add_to_compare_button'
                )
            ) {
                set_query_var( 'is_wl_single_product', true );

                \WCBoost\ProductsCompare\Frontend::instance()
                    ->single_add_to_compare_button();

                set_query_var( 'is_wl_single_product', false );
            }
            ?>
        </div>
    <?php endif; ?>

    <?php if ( themesflat_get_opt( 'extra_link_ask_question' ) ) : ?>

        <a
            href="#ovinx-ask-question"
            data-bs-toggle="modal"
            class="product-extra-icon cl-text-main link ask-question"
        >
            <i class="icon icon-Question fs-20" aria-hidden="true"></i>
            <span class="text-wish fw-medium lh-24">
                <?php
                echo esc_html(
                    themesflat_get_opt(
                        'extra_link_ask_question_btn_text'
                    )
                );
                ?>
            </span>
        </a>

    <?php endif; ?>

    <?php if ( $size_guide_id ) : ?>

        <div class="product-extra-icon link">
            <i class="icon icon-Ruler" aria-hidden="true"></i>

            <?php
            Woo_Single_Product_Hook::instance()
                ->size_guide_button();
            ?>
        </div>

    <?php endif; ?>

    <?php if ( themesflat_get_opt( 'tf_product_share' ) ) : ?>

        <a
            href="#shareSocial"
            data-bs-toggle="modal"
            class="product-extra-icon cl-text-main link tf-product-share-btn"
        >
            <i class="icon icon-ShareNetwork fs-20" aria-hidden="true"></i>
            <span class="text-wish fw-medium lh-24">
                <?php esc_html_e( 'Share', 'ovinx' ); ?>
            </span>
        </a>

    <?php endif; ?>

</div>