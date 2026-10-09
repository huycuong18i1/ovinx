                                        <?php
                                        $style_header = themesflat_get_opt('style_header');
                                        if ( themesflat_get_opt_elementor('style_header') != '' ) {
                                            $style_header = themesflat_get_opt_elementor('style_header');
                                        }
                                        $language_color_class = ( $style_header === 'header-09' ) ? ' color-white' : '';

                                        // Optional extra select classes via get_template_part( ..., $args ) — used by the Ovinx Footer widget.
                                        if ( ! empty( $args['extra_class'] ) ) {
                                            $language_color_class .= ' ' . $args['extra_class'];
                                        }

                                        if ( class_exists('woocommerce_wpml') ) {
                                            $languages = apply_filters( 'wpml_active_languages', NULL, array(
                                                'skip_missing' => 0,
                                                'link_empty_to' => '',
                                                'orderby' => 'code',
                                                'order' => 'asc',
                                            ) );
                                            ?>

                                            <div class="tf-languages ">
                                                <select class="tf-dropdown-select style-default type-languages setting-curreny-language<?php echo esc_attr( $language_color_class ); ?>" id="custom-language-switcher">
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
                                            <div class="tf-languages ">
                                                <select class="tf-dropdown-select style-default type-languages setting-curreny-language<?php echo esc_attr( $language_color_class ); ?>">
                                                    <option selected data-thumbnail="<?php echo esc_url(THEMESFLAT_LINK . 'images/country/us.png') ?>">English</option>
                                                    <option data-thumbnail="<?php echo esc_url(THEMESFLAT_LINK . 'images/country/fr.png') ?>">Français</option>
                                                    <option data-thumbnail="<?php echo esc_url(THEMESFLAT_LINK . 'images/country/vn.png') ?>">Tiếng Việt</option>
                                                </select>
                                            </div>
                                <?php }; ?>