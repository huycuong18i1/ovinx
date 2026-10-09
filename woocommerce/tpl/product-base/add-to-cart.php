<?php
use Automattic\WooCommerce\StoreApi\StoreApi;
use Automattic\WooCommerce\StoreApi\Utilities\CartController;
use Automattic\WooCommerce\StoreApi\Exceptions\RouteException;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

add_filter('woocommerce_loop_add_to_cart_link', 'tfwc_add_to_cart', 20, 3 );
add_filter( 'woocommerce_add_to_cart_fragments', 'tfwc_add_to_cart_fragment' );

function tfwc_add_to_cart( $html, $product, $args ) {
    /**
     * Ground truth's list-style card ALSO uses `.box-action_add` (same real component as grid —
     * see btn-add-to-cart.php), just marked `d-md-none` there since desktop list-style has its own
     * separate Add to Cart button inside `.card-product_button` (rendered by
     * tfwc_list_button_panel(), not through this WC filter at all). The old style-list branch here
     * output a small `<li><a class="box-icon">` icon button instead (wrong component entirely, and
     * `icon-Handbag` isn't even a real icon name) — removed, now everything routes through
     * btn-add-to-cart.php like grid.
     */
    set_query_var( 'tf_card_product_args', $args );

    echo tfwc_get_template_part( '/product-base/btn-add-to-cart.php' );

    set_query_var( 'tf_card_product_args', false );
}

function tfwc_add_to_cart_fragment( $data ) {

    $item_count = sprintf(
        _n( '%d', '%d', WC()->cart->get_cart_contents_count(), 'ovinx' ),
        WC()->cart->get_cart_contents_count()
    );
    
            
    // Class list must cover BOTH contexts this selector matches: desktop header
    // (.nav-icon-list .nav-icon-item.has-number .number-order) and mobile bottom
    // toolbar (.tf-toolbar-bottom .toolbar-count) — see CLAUDE.md fragment-overwrite note.
    $data['.nav-cart a.nav-icon-item .shopping-cart-items-count'] = '<span class="number-order toolbar-count shopping-cart-items-count">'. esc_html( $item_count ).'</span>';

    // QA P5-01: header "Cart Total" (tpl/header/header-cart.php) had no fragment, so it kept the old
    // amount after an AJAX add/update. Markup + classes must stay identical to the template.
    $data['.nav-cart a.nav-icon-item .shopping-cart-subtotal'] = '<p class="text-button shopping-cart-subtotal">' . wp_kses_post( WC()->cart->get_cart_subtotal() ) . '</p>';

    return $data;
}

add_action('wp_ajax_tfwc_update_cart_item', 'tfwc_update_cart_item'); 
add_action('wp_ajax_nopriv_tfwc_update_cart_item', 'tfwc_update_cart_item'); 

if( !function_exists('get_real_bundle_product_qty_in_cart') ){
    function get_real_bundle_product_qty_in_cart( $product_id ) {
        $total = 0;
    
        foreach ( WC()->cart->get_cart() as $cart_item ) {
    
            $id = $cart_item['variation_id'] ?: $cart_item['product_id'];
    
            if (
                !empty($cart_item['tf_custom_bundle']) &&
                (
                    $cart_item['product_id'] == $product_id ||
                    ( isset($cart_item['variation_id']) && $cart_item['variation_id'] == $product_id )
                )
            ) {
                $total += $cart_item['quantity'];
            }
    
            // if ( isset($cart_item['is_bundle_child']) && $cart_item['product_id'] == $product_id ) {
            //     $total += $cart_item['quantity'];
            // }
        }
    
        return $total;
    }
}

function tfwc_update_cart_item() {

    // 1. Validate Nonce
    if ( ! isset($_POST['nonce']) || ! wp_verify_nonce($_POST['nonce'], 'tfwc_nonce') ) {
        wp_send_json_error( __( 'Invalid security token.', 'ovinx' ) );
    }

    $cart_item_key = sanitize_text_field( $_POST['cart_item_key'] ?? '' );
    $new_qty       = wc_stock_amount( $_POST['quantity'] ?? 0 );
    $cart          = WC()->cart->get_cart();

    if ( empty($cart_item_key) || ! isset( $cart[ $cart_item_key ] ) ) {
        wp_send_json_error( __( 'Cart item does not exist.', 'ovinx' ) );
    }

    $cart_item    = $cart[ $cart_item_key ];
    $product_data = $cart_item['data'];
    $bunle_in_cart_qty = get_real_bundle_product_qty_in_cart($product_data->get_id());

    // $quantities = WC()->cart->get_cart_item_quantities();
    // $real_in_cart = isset($quantities[$product_data->get_id()]) ? $quantities[$product_data->get_id()] : 0;

    /**
     * ======================================================
     * VALIDATIONS (FAIL FAST)
     * ======================================================
     */

    // 2. Purchasable
    if ( ! $product_data->is_purchasable() ) {
        wp_send_json_error([
            'message' =>
                __( 'Sorry, this product cannot be purchased.', 'ovinx' )
            ]
        );
    }

    // 3. In stock
    if ( ! $product_data->is_in_stock() ) {
        wp_send_json_error([
            'message' =>
                sprintf(
                    __( 'You cannot update <b>"%s"</b> because it is out of stock.', 'ovinx' ),
                    $product_data->get_name()
                )
            ]
        );
    }

    // 4. Sold individually

    if ( $product_data->is_sold_individually() && $new_qty > 1 ) {
        wp_send_json_error([
            'message' =>
                sprintf(
                    __( 'You can only have 1 <b>"%s"</b> in your cart.', 'ovinx' ),
                    $product_data->get_name()
                )
            ]
        );
    }

    // 5. Stock check
    if ( $product_data->managing_stock() && ! $product_data->backorders_allowed() ) {

        $in_cart = WC()->cart->get_cart_item_quantities()[$product_data->get_id()] ?? 0;

        if ( ! $product_data->has_enough_stock( $new_qty + $bunle_in_cart_qty ) ) {

            $stock_quantity = $product_data->get_stock_quantity();

            wp_send_json_error([
                'message' => sprintf(
                    _n(
                        'Only <b>%1$d"</b> item of <b>"%2$s"</b> left in stock.',
                        'Only <b>%1$d</b> items of <b>"%2$s"</b> left in stock.',
                        $stock_quantity,
                        'ovinx'
                    ),
                    wc_format_stock_quantity_for_display( $stock_quantity, $product_data ),
                    $product_data->get_name()
                )
            ]);
        }
    }

    /**
     * ======================================================
     * UPDATE CART
     * ======================================================
     */

    WC()->cart->set_quantity( $cart_item_key, $new_qty, false );
    WC()->cart->calculate_totals();

    // Return fragments
    WC_AJAX::get_refreshed_fragments();

    wp_die();
}


function tfwc_product_add_to_cart_text($text, $product) {
    if( $product && $product->get_type() == 'variable' ) {
        $text = esc_html__( 'Select Options', 'ovinx' );
    }

    return $text;
}

add_filter( 'woocommerce_product_add_to_cart_text', 'tfwc_product_add_to_cart_text', 10, 2 );


// STORE API

// add_action('wp_ajax_tfwc_store_update_item', 'tfwc_store_update_item');
// add_action('wp_ajax_nopriv_tfwc_store_update_item', 'tfwc_store_update_item');

function tfwc_store_update_item() {

    if ( ! isset($_POST['nonce']) || ! wp_verify_nonce($_POST['nonce'], 'tfwc_nonce') ) {
        wp_send_json_error('Invalid nonce');
    }

    $cart_item_key = sanitize_text_field($_POST['cart_item_key'] ?? '');
    $quantity      = absint($_POST['quantity'] ?? 0);

    if ( empty($cart_item_key) ) {
        wp_send_json_error('Missing cart item key');
    }

    $cart = WC()->cart->get_cart();

    if ( ! isset($cart[$cart_item_key]) ) {
        wp_send_json_error('Cart item not found');
    }

    $product = $cart[$cart_item_key]['data'];
    $quantity = wc_stock_amount($quantity);

    /**
     * ======================================================
     *  STORE API MODE
     * ======================================================
     */
    if ( class_exists(StoreApi::class) ) {

        try {

            // $cart_controller = StoreApi::container()
            //     ->get(CartController::class);
            $cart_controller = \Automattic\WooCommerce\StoreApi\StoreApi::container()->get(
                \Automattic\WooCommerce\StoreApi\Utilities\CartController::class
            );

            $cart_controller->load_cart();

            // Store API update uses cart item key
            $cart_controller->set_cart_item_quantity(
                $cart_item_key,
                $quantity
            );

            wp_send_json_success([
                'source' => 'store_api',
                'cart'   => $cart_controller->get_cart_for_response(),
            ]);

        } catch (RouteException $e) {

            wp_send_json_error([
                'source' => 'store_api',
                'message' => $e->getMessage()
            ]);

        } catch (\Exception $e) {

            wp_send_json_error([
                'source' => 'store_api',
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * ======================================================
     *  LEGACY MODE
     * ======================================================
     */

    try {

        // sold individually check
        if ( $product->is_sold_individually() && $quantity > 1 ) {
            wp_send_json_error('This product is limited to 1 per order');
        }

        // stock check
        if ( $product->managing_stock() ) {

            $stock = $product->get_stock_quantity();

            if ( $quantity > $stock ) {
                wp_send_json_error('Not enough stock');
            }
        }

        WC()->cart->set_quantity($cart_item_key, $quantity, false);
        WC()->cart->calculate_totals();

        wp_send_json_success([
            'source' => 'legacy',
            'cart'   => WC()->cart->get_cart(),
        ]);

    } catch (\Exception $e) {

        wp_send_json_error([
            'source' => 'legacy',
            'message' => $e->getMessage()
        ]);
    }
}

?>