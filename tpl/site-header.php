<?php
/**
 * @package ovinx
 */

$style_header = themesflat_get_opt( 'style_header' );

if ( themesflat_get_opt_elementor( 'style_header' ) != '' ) {
    $style_header = themesflat_get_opt_elementor( 'style_header' );
}

$promo_bar_position = 'promo-top';

if ( themesflat_get_opt_elementor( 'promo_bar_position' ) != '' ) {
    $promo_bar_position = themesflat_get_opt_elementor( 'promo_bar_position' );
}

/**
 * Promo bar top
 */
if ( $promo_bar_position === 'promo-top' ) {
    get_template_part( 'tpl/promo-bar' );
}

/**
 * Header
 */
    // ── Pre-built header mode ────────────────────────────────────────────────
    switch ( $style_header ) {
        case 'header-default':
            get_template_part( 'tpl/header/header-default' );
            break;

        case 'header-02':
            get_template_part( 'tpl/header/header-02' );
            break;

        case 'header-03':
            get_template_part( 'tpl/header/header-03' );
            break;

        default:
            get_template_part( 'tpl/header/header-default' );
            break;
    }

/**
 * Promo bar bottom
 */
if ( $promo_bar_position === 'promo-bottom' ) {
    get_template_part( 'tpl/promo-bar' );
}