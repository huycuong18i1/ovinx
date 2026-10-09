<?php
global $WOOCS;

$style_header = themesflat_get_opt('style_header');
if ( themesflat_get_opt_elementor('style_header') != '' ) {
    $style_header = themesflat_get_opt_elementor('style_header');
}
$currency_color_class = ( $style_header === 'header-09' ) ? ' color-white' : '';

// Optional extra select classes via get_template_part( ..., $args ) — used by the Ovinx Footer widget.
if ( ! empty( $args['extra_class'] ) ) {
    $currency_color_class .= ' ' . $args['extra_class'];
}

if (
    class_exists( 'WOOCS' ) &&
    isset( $WOOCS ) &&
    is_object( $WOOCS ) &&
    function_exists( 'ovinx_get_woocs_currencies' )
) :
    $currencies = ovinx_get_woocs_currencies();

    if ( ! empty( $currencies ) ) :
?>

    <div class="tf-currencies d-xxl-flex">
        <select id="custom-currency-switcher" class="tf-dropdown-select style-default type-currencies setting-curreny-language<?php echo esc_attr( $currency_color_class ); ?>">
            <?php foreach ( $currencies as $code => $currency ) : ?>
                <?php
                $flag_url    = isset( $currency['flag'] ) ? $currency['flag'] : '';
                $description = isset( $currency['description'] ) ? $currency['description'] : $code;
                $symbol      = isset( $currency['symbol'] ) ? $currency['symbol'] : '';
                ?>
                <option
                    value="<?php echo esc_attr( $code ); ?>"
                    data-thumbnail="<?php echo esc_url( $flag_url ); ?>"
                    <?php selected( $WOOCS->current_currency, $code ); ?>
                >
                    <?php echo esc_html( $description . ' (' . $code . ' ' . $symbol . ')' ); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

<?php
    endif;
else :
?>

    <div class="tf-currencies d-xxl-flex">
        <select class="tf-dropdown-select style-default type-currencies setting-curreny-language<?php echo esc_attr( $currency_color_class ); ?>">
                                <option value="USD">USD $</option>
                                <option value="EUR">EUR €</option>
                                <option value="VND">VND đ</option>
        </select>
    </div>

<?php endif; ?>


