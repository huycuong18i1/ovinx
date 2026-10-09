<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

$ask_question_title = themesflat_get_opt('extra_link_ask_question_title');
$ask_question_subtitle = themesflat_get_opt('extra_link_ask_question_subtitle');
$ask_question_content = themesflat_get_opt('extra_link_ask_question_content');  

?>

<div class="modal modalCentered fade modal-log modal-ask" id="ovinx-ask-question" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="btn-close-popup" data-bs-dismiss="modal" aria-label="<?php esc_attr_e( 'Close', 'ovinx' ); ?>">
                <i class="icon icon-Close2"></i>
            </button>
            <div class="modal-heading text-center">
                <h4 class="title-pop">
                    <?php echo esc_html($ask_question_title); ?>
                </h4>
                <?php if( !empty($ask_question_subtitle) ){ ?>
                    <p class="desc-pop"><?php echo esc_html($ask_question_subtitle); ?></p>
                <?php } ?>
            </div>
            <div class="modal-main">
                <?php echo do_shortcode($ask_question_content); ?>
                <?php if( empty($ask_question_content) && current_user_can('administrator') ){ ?>
                    <p class="desc-pop cl-text-2 text-center"><?php _e('Please set up content for this section in <br /> <b> Customizing > Single Product > Extra Description > Ask Question</b>', 'ovinx'); ?></p>
                <?php } ?>
            </div>
        </div>
    </div>
</div>