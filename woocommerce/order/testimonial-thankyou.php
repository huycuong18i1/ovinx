<?php if(themesflat_get_opt('checkout_testi') == 1) {?>

    <div class="fl-order-testimonial">
        <div dir="ltr" class="ovinx-swiper swiper tf-swiper">
            <div class="swiper-wrapper">
                <?php
                    $testimonials = themesflat_get_opt('testimonial_checkout');
                    $testimonials = json_decode($testimonials, true);

                    if (!empty($testimonials)) :

                        foreach ($testimonials as $testimonial) :
                        ?>

                            <div class="swiper-slide">
                                <div class="box-order-tes text-center">
                                    
                                    <span class="icon">
                                        <!-- icon-Quote -->
                                        <?php echo wp_kses_post($testimonial['quote']); ?>
                                    </span>

                                    <div class="content">
                                        <div class="title text-uppercase fw-semibold">
                                            <?php echo esc_html($testimonial['title']); ?>
                                        </div>
                                        <p class="note h6 cl-text-2">
                                            <?php echo esc_html($testimonial['review']); ?>
                                        </p>
                                    </div>

                                    <span class="author font-2 fw-semibold">
                                        <?php echo esc_html($testimonial['name']); ?>
                                    </span>

                                </div>
                            </div>

                        <?php endforeach; ?>
                    <?php endif; ?>

                <?php ?>
            </div>
            <div class="sw-dot-default tf-sw-pagination"></div>
        </div>
    </div>

<?php
} ?>