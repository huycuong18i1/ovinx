<?php 
$gift_applied = WC()->session->get('tfwc_gift') ? true : false; 
$currency   = get_woocommerce_currency_symbol();
$gift_fee = themesflat_get_opt('gift_fee');
?>
<div class="tf-mini-cart-tool-openable add-gift">
	<div class="overlay tf-mini-cart-tool-close"></div>
    <form action="#" class="tf-mini-cart-tool-content">
        <div class="tf-mini-cart-tool-text h6 fw-medium">
            <i class="icon icon-Package"></i>
            <?php _e('Add gift wrap','ovinx')?>
        </div>

        <div class="wrap">
            <p>
                <?php _e('The product will be wrapped carefully','ovinx');?>
            </p>
            <h5>
                <?php
                    $price = esc_html($currency) . (float) $gift_fee;
                    echo sprintf('Only <span class="text-primary">%s</span> for a gift box', $price);
                ?>
            </h5>
        </div>
        <p class="notice-gift" style="<?php echo esc_attr('display: none;'); ?>"></p>
        <div class="tf-cart-tool-btns">
            <button class="subscribe-button tf-btn w-100 animate-btn" type="submit" data-action="<?php echo esc_attr( $gift_applied ? 'remove' : 'add' ); ?>">
                <?php
                if ($gift_applied) {
                    _e('Remove', 'ovinx');
                } else {
                    _e('Add a Gift Wrap', 'ovinx');
                }
                ?>
            </button>
            <div class="tf-btn style-stroke w-100 tf-mini-cart-tool-close">
                <?php _e('Close','ovinx')?>
            </div>
        </div>
    </form>
</div>