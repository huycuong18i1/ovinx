<?php
/**
 * Customizer: "Wishlist & Compare Empty" — the centered "Nothing Saved Yet" style notice shown by
 * woocommerce/wishlist/wishlist-empty.php and woocommerce/compare/compare-empty.php when the list has no items.
 *
 * Title / description / button text / button link for each page. An empty button text hides the button,
 * an empty link falls back to the Shop page.
 */

if ( ! function_exists( 'ovinx_sanitize_empty_state_text' ) ) {
    // Same as themesflat_sanitize_text() but keeps the `class` on <br> (e.g. `d-none d-sm-block`), which the design uses
    // to break the description only on wide screens.
    function ovinx_sanitize_empty_state_text( $input ) {
        return wp_kses(
            $input,
            array(
                'br'     => array( 'class' => array() ),
                'strong' => array(),
                'b'      => array(),
                'em'     => array(),
                'i'      => array(),
                'a'      => array( 'href' => array(), 'class' => array(), 'title' => array() ),
            )
        );
    }
}

$ovinx_empty_groups = array(
    'wishlist' => esc_html__( 'Wishlist', 'ovinx' ),
    'compare'  => esc_html__( 'Compare', 'ovinx' ),
);

foreach ( $ovinx_empty_groups as $ovinx_empty_key => $ovinx_empty_label ) {

    $wp_customize->add_setting(
        $ovinx_empty_key . '_empty_heading',
        array( 'sanitize_callback' => 'sanitize_text_field' )
    );
    $wp_customize->add_control(
        new themesflat_Info(
            $wp_customize,
            $ovinx_empty_key . '_empty_heading',
            array(
                'label'   => sprintf( /* translators: %s: Wishlist or Compare */ esc_html__( '%s page — empty list', 'ovinx' ), $ovinx_empty_label ),
                'section' => 'section_shop_empty',
            )
        )
    );

    $wp_customize->add_setting(
        $ovinx_empty_key . '_empty_title',
        array(
            'default'           => themesflat_customize_default( $ovinx_empty_key . '_empty_title' ),
            'sanitize_callback' => 'ovinx_sanitize_empty_state_text',
        )
    );
    $wp_customize->add_control(
        $ovinx_empty_key . '_empty_title',
        array(
            'type'    => 'text',
            'label'   => esc_html__( 'Title', 'ovinx' ),
            'section' => 'section_shop_empty',
        )
    );

    $wp_customize->add_setting(
        $ovinx_empty_key . '_empty_desc',
        array(
            'default'           => themesflat_customize_default( $ovinx_empty_key . '_empty_desc' ),
            'sanitize_callback' => 'ovinx_sanitize_empty_state_text',
        )
    );
    $wp_customize->add_control(
        $ovinx_empty_key . '_empty_desc',
        array(
            'type'        => 'textarea',
            'label'       => esc_html__( 'Description', 'ovinx' ),
            'description' => esc_html__( 'Tip: <br class="d-none d-sm-block"> breaks the line only on screens wider than 576px.', 'ovinx' ),
            'section'     => 'section_shop_empty',
        )
    );

    $wp_customize->add_setting(
        $ovinx_empty_key . '_empty_button_text',
        array(
            'default'           => themesflat_customize_default( $ovinx_empty_key . '_empty_button_text' ),
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    $wp_customize->add_control(
        $ovinx_empty_key . '_empty_button_text',
        array(
            'type'        => 'text',
            'label'       => esc_html__( 'Button Text', 'ovinx' ),
            'description' => esc_html__( 'Leave empty to hide the button.', 'ovinx' ),
            'section'     => 'section_shop_empty',
        )
    );

    $wp_customize->add_setting(
        $ovinx_empty_key . '_empty_button_url',
        array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    $wp_customize->add_control(
        $ovinx_empty_key . '_empty_button_url',
        array(
            'type'        => 'url',
            'label'       => esc_html__( 'Button Link', 'ovinx' ),
            'description' => esc_html__( 'Leave empty to link to the Shop page.', 'ovinx' ),
            'section'     => 'section_shop_empty',
        )
    );
}
