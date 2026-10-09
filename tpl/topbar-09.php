<?php
/**
 * Topbar markup matching ovinx-html's exact grid (row > col-lg-3 / col-xl-6 / col-lg-3).
 * Despite the "-09" filename (header-09 no longer exists in this theme), this is the
 * SHARED/canonical topbar used by every header style (header-default, header-02, header-03...)
 * — ovinx-html itself reuses this exact same markup across multiple pages, it's not specific
 * to any one header style. Per explicit user instruction, new header styles reuse this file
 * as-is; do not build a per-header-style topbar variant unless asked to.
 * The generic tpl/topbar.php uses a different markup vocabulary (topbar-left/-center/-right)
 * that has no matching rules in the compiled CSS — do not use it for new headers, see PROGRESS.md.
 *
 * Still honors the existing topbar_items_left/center/right customizer repeaters so those
 * options stay meaningful across every header style that uses this file.
 */

$topbar_show = themesflat_get_opt( 'topbar_show' );
if ( themesflat_get_opt_elementor( 'topbar_show' ) != '' ) {
    $topbar_show = themesflat_get_opt_elementor( 'topbar_show' );
}

if ( $topbar_show != 1 ) {
    return;
}

// Customizer stores each list as a JSON string; the Elementor "TF Header" override
// (SELECT2 multiple) is an array and is only used when at least one item is picked.
$topbar_items_left_json   = json_decode( themesflat_get_opt( 'topbar_items_left' ), true );
$topbar_items_center_json = json_decode( themesflat_get_opt( 'topbar_items_center' ), true );
$topbar_items_right_json  = json_decode( themesflat_get_opt( 'topbar_items_right' ), true );

foreach ( [ 'left', 'center', 'right' ] as $topbar_pos ) {
    $topbar_items_elementor = themesflat_get_opt_elementor( 'topbar_items_' . $topbar_pos );
    if ( ! empty( $topbar_items_elementor ) && is_array( $topbar_items_elementor ) ) {
        ${ 'topbar_items_' . $topbar_pos . '_json' } = $topbar_items_elementor;
    }
}

$information_slides_arr  = themesflat_get_opt( 'information_slides_arr' );
$information_slides_json = json_decode( $information_slides_arr, true );
?>
<div role="region" aria-label="<?php esc_attr_e( 'Store announcements and settings', 'ovinx' ); ?>" class="tf-topbar bg-primary-2 sm-d-none position-relative <?php echo esc_attr( themesflat_get_opt_elementor( 'extra_classes_topbar' ) ); ?>">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-3 d-none d-xl-block">
                <?php if ( ! empty( $topbar_items_left_json ) && is_array( $topbar_items_left_json ) ) : ?>
                    <div class="tf-list gap-16">
                        <?php foreach ( $topbar_items_left_json as $index => $item ) :
                            if ( $index > 0 ) : ?>
                                <span class="br-line type-vertical bg-white_10"></span>
                            <?php endif;
                            switch ( $item ) {
                                case 'currency':
                                    get_template_part( 'tpl/topbar/currency' );
                                    break;
                                case 'language':
                                    get_template_part( 'tpl/topbar/language' );
                                    break;
                                case 'phone':
                                    get_template_part( 'tpl/topbar/phone' );
                                    break;
                                case 'menu-topbar':
                                    get_template_part( 'tpl/topbar/menu-topbar' );
                                    break;
                                case 'social':
                                    get_template_part( 'tpl/topbar/social' );
                                    break;
                            }
                        endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-xl-6">
                <?php foreach ( (array) $topbar_items_center_json as $item ) :
                    if ( $item === 'text-slider' || $item === 'text-slider-2' ) : ?>
                        <div dir="ltr" class="swiper tf-swiper swiper-topbar" data-direction="vertical" data-touch="false" data-auto="true" data-loop="true" data-speed="1500">
                            <div class="swiper-wrapper">
                                <?php if ( ! empty( $information_slides_json ) ) : foreach ( $information_slides_json as $slide ) : ?>
                                    <div class="swiper-slide">
                                        <p class="text-adver text-white text-center">
                                            <i class="icon icon-SealPercent fs-20"></i>
                                            <?php echo wp_kses_post( $slide['text'] ); ?>
                                        </p>
                                    </div>
                                <?php endforeach; endif; ?>
                            </div>
                        </div>
                    <?php else :
                        switch ( $item ) {
                            case 'currency':
                                get_template_part( 'tpl/topbar/currency' );
                                break;
                            case 'language':
                                get_template_part( 'tpl/topbar/language' );
                                break;
                            case 'phone':
                                get_template_part( 'tpl/topbar/phone' );
                                break;
                            case 'menu-topbar':
                                get_template_part( 'tpl/topbar/menu-topbar' );
                                break;
                            case 'social':
                                get_template_part( 'tpl/topbar/social' );
                                break;
                        }
                    endif;
                endforeach; ?>
            </div>

            <div class="col-lg-3 d-none d-xl-block">
                <?php if ( ! empty( $topbar_items_right_json ) && is_array( $topbar_items_right_json ) ) : ?>
                    <div class="tf-list justify-content-end">
                        <?php foreach ( $topbar_items_right_json as $item ) {
                            switch ( $item ) {
                                case 'currency':
                                    get_template_part( 'tpl/topbar/currency' );
                                    break;
                                case 'language':
                                    get_template_part( 'tpl/topbar/language' );
                                    break;
                                case 'phone':
                                    get_template_part( 'tpl/topbar/phone' );
                                    break;
                                case 'menu-topbar':
                                    get_template_part( 'tpl/topbar/menu-topbar' );
                                    break;
                                case 'social':
                                    get_template_part( 'tpl/topbar/social' );
                                    break;
                            }
                        } ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <span class="br-line fake-class bottom-0 bg-white_10"></span>
</div>
