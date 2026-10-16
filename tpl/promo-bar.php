<?php 

// Desktop ("Enable Promo Bar") and mobile ("Show Promo Bar Mobile") are independent switches: the bar is
// rendered when either is on, and the other breakpoint is hidden with CSS (inc/styles.php hides it on
// mobile when the mobile switch is off; `.promo-mobile-only` in styles.css hides it on desktop).
$show_promo_bar        = themesflat_get_opt('show_promo_bar');
$show_promo_bar_mobile = themesflat_get_opt('show_promo_bar_mobile');
if (themesflat_get_opt_elementor('show_promo_bar') != '') {
    // Per-page Elementor override turns the bar on/off for both breakpoints.
    $show_promo_bar = themesflat_get_opt_elementor('show_promo_bar');
    if ($show_promo_bar != 1) {
        $show_promo_bar_mobile = 0;
    }
}
$promo_mobile_only_class = ( $show_promo_bar != 1 && $show_promo_bar_mobile == 1 ) ? ' promo-mobile-only' : '';

$promo_topbar_style = themesflat_get_opt('promo_topbar_style');

$promo_marquee_arr = themesflat_get_opt('promo_marquee_arr');
$promo_marquee_json = json_decode($promo_marquee_arr, true);

$promo_slides_arr = themesflat_get_opt('promo_slides_arr');
$promo_slides_json = json_decode($promo_slides_arr, true);

?>
<?php if ( $show_promo_bar == 1 || $show_promo_bar_mobile == 1 ) { ?>

        <?php if ( $promo_topbar_style == 'style-slides' ) : ?>

            <div class="tf-topbar topbar-v2 bg-primary-2 tf-btn-swiper-main tf-slider-promo<?php echo esc_attr( $promo_mobile_only_class ); ?> <?php echo esc_attr( themesflat_get_opt_elementor('extra_classes_header') ); ?>">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-3 col-2">
                            <div class="d-flex justify-content-end">
                                <div class="nav-prev-swiper text-white link d-flex">
                                    <i class="icon icon-CaretLeftV2 fs-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-8">
                            <div dir="ltr" class="swiper tf-swiper swiper-topbar default" data-touch="false" data-auto="true" data-loop="true" data-speed="1500">
                                <div class="swiper-wrapper">
                                    <?php if ( ! empty( $promo_slides_json ) ) : foreach ( $promo_slides_json as $value ) : ?>
                                        <div class="swiper-slide">
                                            <p class="text-caption-01 text-white text-center">
                                                <?php echo wp_kses_post( $value['text'] ); ?>
                                            </p>
                                        </div>
                                    <?php endforeach; endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-2">
                            <div class="d-flex nav-next-swiper text-white link">
                                <i class="icon icon-CaretRightV2 fs-20"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <span class="br-line fake-class bottom-0 bg-white_10"></span>
            </div>

        <?php else: ?>

            <div class="tf-promo-bar style-text<?php echo esc_attr( $promo_mobile_only_class ); ?> <?php echo esc_attr( themesflat_get_opt_elementor('extra_classes_header') ); ?>">
                <div class="infiniteSlide-text-v03">
                    <div class="infiniteSlide infiniteSlide-wrapper" data-clone="5">
                        <?php if ( ! empty( $promo_marquee_json ) ) : ?>
                            <?php foreach ( $promo_marquee_json as $value ) : ?>
                                <p class="text fw-medium"> <a href="<?php echo esc_attr( $value['link'] ); ?>"><?php echo esc_html( $value['text'] ); ?></a> </p>
                                <i class="icon-Star2"></i>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="promo-bar-close">
                    <svg aria-hidden="true" role="img" focusable="false" fill="currentColor" width="16" height="16" viewBox="0 0 16 16"><path d="M16 1.4L14.6 0L8 6.6L1.4 0L0 1.4L6.6 8L0 14.6L1.4 16L8 9.4L14.6 16L16 14.6L9.4 8L16 1.4Z" fill="currentColor"></path></svg>
                </div>
            </div>

        <?php endif; ?>


<?php } ?>


