<div class="tf-mini-cart-tool-openable coupon">
    <div class="overlay tf-mini-cart-tool-close"></div>
    <form action="#" class="tf-mini-cart-tool-content" method="POST">
        <div class="tf-mini-cart-tool-text h6 fw-medium">
            <i class="icon icon-SealPercent"></i>
            <?php _e('Coupon','ovinx')?>
        </div>
        <div class="tf-mini-cart-tool-text1 text-dark-1"><?php _e('* Discount will be calculated and applied at checkout','ovinx')?></div>
        <input type="text" name="tfwc_coupon_code" class="input-text input-coupon">

        <p class="notice-coupon"></p>

        <div class="tf-cart-tool-btns">
            <button class="subscribe-button tf-btn animate-btn d-inline-flex w-100" type="submit">
                <?php _e('Apply Coupon','ovinx')?>
            </button>

            <div class="tf-btn style-stroke w-100 tf-mini-cart-tool-close">
                <?php _e('Close','ovinx')?>
            </div>
        </div>
        
    </form>
</div>