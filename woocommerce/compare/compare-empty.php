<?php
/**
 * Template for displaying the notice of empty compare list.
 *
 * Same layout as the empty wishlist (ovinx-html wishlist.html "Wishlist Empty"); text and button come from
 * Customizer > Shop > Wishlist & Compare Empty (see ovinx_get_empty_list_notice()).
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/compare/compare-empty.php.
 *
 * @author  WCBoost
 * @package WCBoost\ProductsCompare\Templates
 * @version 1.0.3
 */

defined( 'ABSPATH' ) || exit;

echo ovinx_get_empty_list_notice( 'compare', ! empty( $return_url ) ? $return_url : '' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped inside the helper
