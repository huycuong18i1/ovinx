<?php

if (themesflat_get_opt('show_bottom') == 1): ?>

    <div class="footer-bottom order-xl-2 position-relative">
        <span class="br-line fake-class top-0 bg-white_10 d-xl-none"></span>
        <div class="container">
            <div class="footer-bottom_wrap">
                <p class="text-copy cl-text-mute">
                    <?php echo wp_kses( themesflat_get_opt( 'footer_copyright' ), themesflat_kses_allowed_html() ); ?>
                </p>

                <div class="tf-list gap-12">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="cl-text-mute link-white link-underline"><?php esc_html_e( 'Sitemap', 'ovinx' ); ?></a>
                    <span class="br-line type-vertical bg-white_10"></span>
                    <a href="#" class="cl-text-mute link-white link-underline"><?php esc_html_e( 'Accessibility', 'ovinx' ); ?></a>
                    <span class="br-line type-vertical bg-white_10"></span>
                    <a href="<?php echo esc_url( function_exists( 'get_privacy_policy_url' ) && get_privacy_policy_url() ? get_privacy_policy_url() : '#' ); ?>" class="cl-text-mute link-white link-underline"><?php esc_html_e( 'Cookies Policy', 'ovinx' ); ?></a>
                </div>
            </div>

            <?php if ( themesflat_get_opt( 'show_bottom_currency' ) == 1 || themesflat_get_opt( 'show_bottom_language' ) == 1 || themesflat_get_opt( 'show_img_payment' ) == 1 ) : ?>
                <div class="footer-bottom_extra tf-list gap-12 flex-wrap justify-content-center justify-content-xl-start">
                    <?php if ( themesflat_get_opt('show_bottom_currency') == 1 ): ?>
                    <div class="tf-list list-currenci">
                        <?php
                        if ( class_exists('woocs') ) {
                            $currencies = ovinx_get_woocs_currencies();
                            ?>

                            <div class="tf-currencies">
                                <select id="custom-currency-switcher" class="dropdown bootstrap-select tf-dropdown-select style-default type-currencies setting-curreny-language dropup">
                                    <?php foreach ( $currencies as $code => $currency ): ?>
                                        <?php
                                            $flag_url = $currency['flag'];
                                        ?>
                                        <option
                                            value="<?php echo esc_attr($code); ?>"
                                            data-thumbnail="<?php echo esc_url($flag_url); ?>"
                                            <?php echo esc_attr(($WOOCS->current_currency === $code) ? 'selected' : ''); ?>
                                        >
                                            <?php echo esc_html($currency['description']) . ' (' . esc_html($code) . ' ' . esc_html($currency['symbol']) . ')'; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php } else { ?>
                            <div class="tf-currencies">
                                <select class="dropdown bootstrap-select tf-dropdown-select style-default type-currencies setting-curreny-language dropup">
                                    <option value="USD" selected data-thumbnail="<?php echo esc_url(THEMESFLAT_LINK . 'images/country/us.png') ?> "> United States (USD $)</option>
                                    <option value="EUR" data-thumbnail="<?php echo esc_url(THEMESFLAT_LINK . 'images/country/fr.png') ?>">France (EUR €)</option>
                                    <option value="VND" data-thumbnail="<?php echo esc_url(THEMESFLAT_LINK . 'images/country/vn.png') ?>">Vietnam (VND ₫)</option>
                                </select>
                            </div>
                    <?php } endif; ?>
                    </div>
                    <?php if ( themesflat_get_opt('show_bottom_language') == 1 ): ?>
                        <?php
                        if ( class_exists('woocommerce_wpml') ) {
                            $languages = apply_filters( 'wpml_active_languages', NULL, array(
                                'skip_missing' => 0,
                                'link_empty_to' => '',
                                'orderby' => 'code',
                                'order' => 'asc',
                            ) );
                            ?>

                            <div class="tf-languages">
                                <select class="dropdown bootstrap-select tf-dropdown-select setting-curreny-language style-default type-languages dropup" id="custom-language-switcher">
                                    <?php if ( ! empty( $languages ) ) : ?>
                                        <?php foreach ( $languages as $lang ): ?>
                                            <option
                                                value="<?php echo esc_url( $lang['url'] ); ?>"
                                                data-thumbnail="<?php echo esc_url( $lang['country_flag_url'] ); ?>"
                                                <?php echo esc_attr($lang['active'] ? 'selected' : ''); ?>
                                            >
                                                <?php echo esc_html( $lang['translated_name'] ); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        <?php } else { ?>
                            <div class="tf-languages">
                                <select class="dropdown bootstrap-select tf-dropdown-select setting-curreny-language style-default type-languages dropup">
                                    <option>English</option>
                                    <option>العربية</option>
                                    <option>简体中文</option>
                                    <option>اردو</option>
                                </select>
                            </div>
                        <?php } endif; ?>
                    <?php if ( themesflat_get_opt('show_img_payment') == 1 ): ?>
                    <ul class="tf-list payment-list">
                       <?php
                                        $img_payment = explode(',', themesflat_get_opt('img_payment'));
                                        if (!empty($img_payment[0])) {
                                            foreach ($img_payment as $image) {
                                                echo '<li><img src="'.esc_attr($image).'" alt="'.esc_html__("payment",'ovinx').'"></li>';
                                            }
                                        }
                                        ?>
                    </ul>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

<?php endif; ?>