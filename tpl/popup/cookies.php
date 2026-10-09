<div class="cookie-banner" id="cookie-banner">
    <div class="overplay"></div>
    <div class="content">        
        <p class="text-md"><?php echo esc_html(themesflat_get_opt('tf_cookies_content')); ?></p>
        <div class="button-group">
            <?php if(themesflat_get_opt('tf_cookies_btn') != '') {
                // Page ID (what the control used to store) -> permalink; a plain URL (the default is '#') -> as is; empty -> privacy policy page.
                $cookies_btn_url = themesflat_get_opt('tf_cookies_btn_url');
                if ( is_numeric( $cookies_btn_url ) ) {
                    $cookies_btn_url = get_permalink( (int) $cookies_btn_url );
                }
                if ( empty( $cookies_btn_url ) ) {
                    $cookies_btn_url = get_privacy_policy_url();
                }
                ?>
                <a class="btn-out-line-white btn-submit-total tf-btn animate-btn" href="<?php echo esc_url( $cookies_btn_url ? $cookies_btn_url : '#' ); ?>"><?php echo esc_html(themesflat_get_opt('tf_cookies_btn')); ?></a>
            <?php } ?>
            <?php if(themesflat_get_opt('tf_cookies_btn_active') != '') { ?>
                <button id="accept-cookie" class="accept-button btn-out-line-white btn-submit-total tf-btn animate-btn"><?php echo esc_html(themesflat_get_opt('tf_cookies_btn_active')); ?></button>
            <?php } ?>
        </div>
    </div>
</div>