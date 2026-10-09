<?php
/**
 * Template for displaying the empty wishlist.
 *
 * Text and button come from Customizer > Shop > Wishlist & Compare Empty (see ovinx_get_empty_list_notice()).
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/wishlist/wishlist-empty.php.
 *
 * @author  WCBoost
 * @package WCBoost\Wishlist\Templates
 * @version 10.3.4
 */

defined( 'ABSPATH' ) || exit;

echo ovinx_get_empty_list_notice( 'wishlist', ! empty( $args['return_url'] ) ? $args['return_url'] : '' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped inside the helper
