<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;
if( $product->is_type( 'external' ) || $product->is_type( 'grouped' ) || $product->is_type( 'bundle' ) || $product->is_type( 'composite' ) ) {
    return;
}
if ( $product->is_type( 'simple' ) && ! $product->is_in_stock() ) {
    return;
}

if(!themesflat_get_opt('tf_buyx_gety')){
    return;
}

if ( ! function_exists( 'tf_get_contents' ) ) {
	function tf_get_contents($contents) {
		if( !empty($contents) ){
			return $contents;
			// return wp_kses_post($contents);
		}
	}
}

$tf_buyx_gety_item_id = $product->get_meta( '_tf_buyx_gety_item_id' ) ?? '';
$tf_buyx_gety_number_main = $product->get_meta( '_tf_buyx_gety_number_main' ) ?? '';
$tf_buyx_gety_number_get = $product->get_meta( '_tf_buyx_gety_number_get' ) ?? '';
$tf_buyx_gety_discount = $product->get_meta( '_tf_buyx_gety_discount' ) ?? '';
$tf_buyx_gety_title = $product->get_meta( '_tf_buyx_gety_title' ) ?? '';
$limit = $product->get_meta( '_tf_buyx_gety_limit' ) ?? '';

if( empty($tf_buyx_gety_item_id) || empty($tf_buyx_gety_number_main) || empty($tf_buyx_gety_number_get) || empty($tf_buyx_gety_discount) ){
    return;
}

$discount_product = wc_get_product($tf_buyx_gety_item_id);
if ( !is_object( $discount_product ) ) {
    return;
}

if( !empty($limit) ){
    $bundle_count = 0;

    foreach (WC()->cart->get_cart() as $cart_item) {
        if (
            isset($cart_item['tf_custom_bundle']) && 
            $cart_item['tf_custom_bundle'] === true &&
            isset($cart_item['is_bundle_parent']) && 
            $cart_item['is_bundle_parent'] === true &&
            $cart_item['product_id'] == $product->get_id()
        ) {
            $bundle_count++;
        }
    }

    if ($bundle_count >= $limit) {
        return;
    }
}

if (
    !$product->is_purchasable() || !$discount_product->is_purchasable() ||
    !$product->is_in_stock() || !$discount_product->is_in_stock()
) {
    return;
}

$placeholder_image = wc_placeholder_img_src();

$main_image   = $product->get_image_id() ? wp_get_attachment_image_url($product->get_image_id(), 'themesflat-product') : '';

if(empty($main_image)) {
    $main_image = $placeholder_image;
}

$discount_image   = $discount_product->get_image_id() ? wp_get_attachment_image_url($discount_product->get_image_id(), 'themesflat-product') : '';

if(empty($discount_image)) {
    $discount_image = $placeholder_image;
}

?>

<div class="tf-buyx-gety-wrapper">
    <form class="form-buyX-getY tf-buyX-getY-form" method="POST">
        <h5 class="title-buyX-getY"><?php echo esc_html($tf_buyx_gety_title); ?></h5>
        <div class="group-item-product">
            <div class="item-product">
                <input type="hidden" name="tf_product_id_x" class="tf-main-product-id tf-buyx-gety-data" value="<?php echo esc_attr($product->get_id()); ?>" data-variation_id="" data-attribute="" />
                <div class="ribbon"><?php echo esc_html("Buy " . $tf_buyx_gety_number_main); ?></div>
                <div class="img-product">
                    <img class="lazyload" width="130" height="100" data-src="<?php echo esc_url($main_image); ?>" src="<?php echo esc_url($placeholder_image); ?>" alt="img-product">
                </div>
                <div class="info-product">
                    <a href="<?php echo esc_url($product->get_permalink()); ?>" class="name-product lh-24 fw-medium link-underline-text text-line-clamp-2">
                        <?php echo esc_html($product->get_name()); ?>
                    </a>
                    <span class="price-product tf-price price-wrap">
                        <?php echo tf_get_contents($product->get_price_html()); ?>
                    </span>
                    <?php 
                        // global $product;
                        // echo tfwc_get_template_part( '/product-base/rating.php' );
                    ?>
                    <?php if ($product->is_type('variable')): ?>
                        <?php
                            $default_attrs = $product->get_default_attributes();
                            $normalized_default_attrs = [];
                            foreach ( $default_attrs as $key => $val ) {
                                $normalized_default_attrs[ 'attribute_' . $key ] = $val;
                            }
                            $variations = $product->get_available_variations();
                            $all_attrs = $product->get_variation_attributes();
                        ?>
                        <?php if(count( $all_attrs ) < 6 ) : ?>
                            <div class="variant-product tf-select">
                                <select aria-label="<?php esc_attr_e( 'Select variation', 'ovinx' ); ?>">
                                <?php
                                    foreach ( $variations as $variation ) {
                                        $variation_obj = wc_get_product( $variation['variation_id'] );
                                        if ( ! $variation_obj || ! $variation_obj->exists() ) continue;
                                        if (!$variation_obj->is_purchasable() || !$variation_obj->is_in_stock()) {
                                            continue;
                                        }
                                    
                                        $price = $variation_obj->get_price();
                                        $image_url = wp_get_attachment_image_url( $variation_obj->get_image_id(), 'full' );
                                        $price_html = $variation_obj->get_price_html();
                                    
                                        $attribute_sets = [[]];

                                        foreach ( $variation['attributes'] as $attr => $value ) {
                                            $taxonomy = str_replace( 'attribute_', '', $attr );
                                    
                                            if ( empty( $value ) ) {
                                                $options_string = $product->get_attribute( $taxonomy );
                                                $options = array_map( 'trim', preg_split( '/[,|]/', $options_string ) );
                                    
                                                $new_sets = [];
                                                foreach ( $attribute_sets as $set ) {
                                                    foreach ( $options as $option ) {
                                                        if ( ! empty( $option ) ) {
                                                            $option_slug = sanitize_title( $option );
                                                            $new_set = $set;
                                                            $new_set[$attr] = $option_slug;
                                    
                                                            $term = get_term_by( 'slug', $option_slug, $taxonomy );
                                                            $new_set['_label'][$taxonomy] = $term ? $term->name : ucfirst( $option );
                                    
                                                            $new_sets[] = $new_set;
                                                        }
                                                    }
                                                }
                                                $attribute_sets = $new_sets;
                                            } else {
                                                foreach ( $attribute_sets as &$set ) {
                                                    $set[$attr] = $value;
                                    
                                                    $term = get_term_by( 'slug', $value, $taxonomy );
                                                    $set['_label'][$taxonomy] = $term ? $term->name : ucfirst( $value );
                                                }
                                            }
                                        }
                                    
                                        foreach ( $attribute_sets as $set ) {
                                            if( empty($set) ) continue;
                                            $label = implode( ' / ', $set['_label'] );
                                    
                                            $data_attributes = array_filter($set, fn($k) => strpos($k, '_label') === false, ARRAY_FILTER_USE_KEY);
                                    
                                            echo '<option 
                                                value="' . esc_attr( $variation['variation_id'] ) . '" 
                                                data-image="' . esc_url( $image_url ) . '" 
                                                data-attributes="' . esc_attr( json_encode( $data_attributes ) ) . '" 
                                                data-price="' . esc_attr( $price ) . '" 
                                                data-price-html="' . esc_attr( $price_html ) . '" 
                                                ' . selected( empty(array_diff_assoc($variation['attributes'], $normalized_default_attrs)), true, false ) . '>'
                                                . $label . 
                                                '</option>';
                                        }
                                    }                                
                                ?>
                                </select>
                            </div>
                        <?php else: ?>
                            <?php woocommerce_template_loop_add_to_cart(); ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
            <!-- <img class="arrow" src="<?php echo esc_url( THEMESFLAT_LINK . "/images/icons/arr.png"); ?>" alt=""> -->
            <span class="plus-add">
                <i class="icon icon-Plus"></i>
            </span>
            <div class="item-product">
                <input type="hidden" name="tf_product_id_y" class="tf-discount-product-id tf-buyx-gety-data" value="<?php echo esc_attr($discount_product->get_id()); ?>" data-variation_id="" data-attribute="" />
                <div class="ribbon ">
                    <?php
                    if ($tf_buyx_gety_discount >= 100) {
                        echo esc_html("Get " . $tf_buyx_gety_number_get . " free");
                    }else{
                        echo esc_html("Get " . $tf_buyx_gety_number_get . " Off " . $tf_buyx_gety_discount . "%");
                    }
                    ?>
                </div>
                <div class="img-product">
                    <img class="lazyload" width="130" height="100" data-src="<?php echo esc_url($discount_image); ?>" src="<?php echo esc_url($placeholder_image); ?>" alt="img-product">
                </div>
                <div class="info-product">
                    <a href="<?php echo esc_url($discount_product->get_permalink()); ?>" class="name-product lh-24 fw-medium link-underline-text text-line-clamp-2">
                        <?php echo esc_html($discount_product->get_name()); ?>
                    </a>
                    <div class="price-product tf-price price-wrap">
                        <?php echo wc_price($discount_product->get_price()); ?>
                    </div>
                    <?php if ($discount_product->is_type('variable')): ?>
                        <?php
                            $default_attrs = $discount_product->get_default_attributes();
                            $normalized_default_attrs = [];
                            foreach ( $default_attrs as $key => $val ) {
                                $normalized_default_attrs[ 'attribute_' . $key ] = $val;
                            }
                            $variations = $discount_product->get_available_variations();
                            $all_attrs = $discount_product->get_variation_attributes();
                        ?>
                        <?php if(count( $all_attrs ) < 6 ) : ?>
                            <div class="variant-product tf-select">
                                <select aria-label="<?php esc_attr_e( 'Select variation', 'ovinx' ); ?>">
                                <?php
                                    foreach ( $variations as $variation ) {
                                        $variation_obj = wc_get_product( $variation['variation_id'] );
                                        if ( ! $variation_obj || ! $variation_obj->exists() ) continue;
                                        if (!$variation_obj->is_purchasable() || !$variation_obj->is_in_stock()) {
                                            continue;
                                        }
                                    
                                        $price = $variation_obj->get_price();
                                        $image_url = wp_get_attachment_image_url( $variation_obj->get_image_id(), 'full' );
                                        $price_html = $variation_obj->get_price_html();
                                    
                                        $attribute_sets = [[]];

                                        foreach ( $variation['attributes'] as $attr => $value ) {
                                            $taxonomy = str_replace( 'attribute_', '', $attr );
                                    
                                            if ( empty( $value ) ) {
                                                $options_string = $discount_product->get_attribute( $taxonomy );
                                                $options = array_map( 'trim', preg_split( '/[,|]/', $options_string ) );
                                    
                                                $new_sets = [];
                                                foreach ( $attribute_sets as $set ) {
                                                    foreach ( $options as $option ) {
                                                        if ( ! empty( $option ) ) {
                                                            $option_slug = sanitize_title( $option );
                                                            $new_set = $set;
                                                            $new_set[$attr] = $option_slug;
                                    
                                                            $term = get_term_by( 'slug', $option_slug, $taxonomy );
                                                            $new_set['_label'][$taxonomy] = $term ? $term->name : ucfirst( $option );
                                    
                                                            $new_sets[] = $new_set;
                                                        }
                                                    }
                                                }
                                                $attribute_sets = $new_sets;
                                            } else {
                                                foreach ( $attribute_sets as &$set ) {
                                                    $set[$attr] = $value;
                                    
                                                    $term = get_term_by( 'slug', $value, $taxonomy );
                                                    $set['_label'][$taxonomy] = $term ? $term->name : ucfirst( $value );
                                                }
                                            }
                                        }
                                    
                                        foreach ( $attribute_sets as $set ) {
                                            if( empty($set) ) continue;
                                            $label = implode( ' / ', $set['_label'] );
                                    
                                            $data_attributes = array_filter($set, fn($k) => strpos($k, '_label') === false, ARRAY_FILTER_USE_KEY);
                                    
                                            echo '<option 
                                                value="' . esc_attr( $variation['variation_id'] ) . '" 
                                                data-image="' . esc_url( $image_url ) . '" 
                                                data-attributes="' . esc_attr( json_encode( $data_attributes ) ) . '" 
                                                data-price="' . esc_attr( $price ) . '" 
                                                data-price-html="' . esc_attr( $price_html ) . '" 
                                                ' . selected( empty(array_diff_assoc($variation['attributes'], $normalized_default_attrs)), true, false ) . '>'
                                                . $label . 
                                                '</option>';
                                        }
                                    }                                
                                ?>
                                </select>
                            </div>
                        <?php else: ?>
                            <?php woocommerce_template_loop_add_to_cart(); ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <button class="tf-btn  tf-buyx-gety-btn has-loading" type="button">
            <span>
                <?php echo esc_html__('Grab this deal', 'ovinx'); ?>
            </span>
            <span class="tf-add-to-cart-loading d-none position-relative">
                <span class="spinner"></span>
            </span>
        </button>
    </form>
</div>
<?php
return;

themesflat_remove_hook('woocommerce_loop_add_to_cart_link', 'tfwc_add_to_cart', 20, 3 );
add_filter('woocommerce_loop_add_to_cart_link', [ Woo_Single_Product_Hook::instance(), 'select_option_button'] , 21, 3 );