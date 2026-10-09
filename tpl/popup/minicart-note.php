<?php
    $tfwc_order_note = WC()->session->get('tfwc_order_note', '');
?>

<div class="tf-mini-cart-tool-openable add-note">
    <div class="overlay tf-mini-cart-tool-close"></div>
    <form action="#" class="tf-mini-cart-tool-content style-border" method="POST">
        <label for="Cart-note" class="tf-mini-cart-tool-text h6 fw-medium">
            <i class="icon icon-Chats"></i>
            <?php _e('Note','ovinx')?>
        </label>

        <textarea name="order_comments" class="d-flex" id="Cart-note" placeholder="Instruction for seller..."><?php echo esc_html($tfwc_order_note); ?></textarea>

        <p class="notice-order-note"></p>
        
        <div class="tf-cart-tool-btns"> 
            <button class="subscribe-button tf-btn w-100 animate-btn" type="submit">
                <?php _e('Save','ovinx')?>
            </button>
            <div class="tf-btn style-stroke w-100 tf-mini-cart-tool-close">
                <?php _e('Close','ovinx')?>
            </div>
        </div>
    </form>
</div>
