<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if( !themesflat_get_opt('show_out_stock_btn') || empty(themesflat_get_opt('out_stock_form')) ){
    return;
}

function tfwc_unavailable_modal(){
    ob_start();
    ?>
    <div class="modal modalCentered fade modal-unavailable" id="unavailable" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <span class="icon-close-popup" data-bs-dismiss="modal" role="button" aria-label="<?php esc_attr_e( 'Close', 'ovinx' ); ?>">
                    <i class="icon-close"></i>
                </span>
                <?php echo do_shortcode(themesflat_get_opt('out_stock_form')); ?>
            </div>
        </div>
    </div>

    <?php
    echo ob_get_clean();
}

add_action( 'wp_footer', 'tfwc_unavailable_modal' );