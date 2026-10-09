<div class="tf-mini-cart-tool-openable estimate-shipping">
    <div class="overlay tf-mini-cart-tool-close"></div>  
    <div id="shipping-form" class="tf-mini-cart-tool-content style-border">
        <div class="tf-mini-cart-tool-text h6 fw-medium">
            <i class="icon icon-Truck"></i>
            <?php _e('Shipping', 'ovinx' ); ?>
        </div>
        
        <div class="shipping-cal-wrapper">
            <?php woocommerce_shipping_calculator(); ?>
            <p class="notice-shipping"></p>
        </div>
        <div class="tf-cart-tool-btns">
            <?php if ( 'yes' === get_option( 'woocommerce_enable_shipping_calc' ) && WC()->cart->needs_shipping() ) :?>
                <button class="tf-btn w-100 animate-btn shipping-est-btn" type="submit"><?php _e('Estimate','ovinx')?></button>
            <?php endif; ?>
            <div class="tf-btn style-stroke w-100 tf-mini-cart-tool-close">
                <?php _e('Close','ovinx')?>
            </div>
        </div>
    </div>
</div>