
<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

if(!themesflat_get_opt('tf_volume_discount')){
    return;
}

if (empty($discount_list)) {
    return;
}

$discount_post_id = '';
foreach( $discount_list as $discount_id => $product_ids){
    if ( in_array($product->get_id(), $product_ids) ) {
        $discount_post_id = $discount_id;
        break;
    }
}

if ( empty($discount_post_id) ) {
    return;
}

$title = get_the_title($discount_post_id);
$volume_discount_data = get_post_meta($discount_post_id, '_volume_discount_data', true);
$volume_discount_type = get_post_meta($discount_post_id, '_volume_discount_style', true);
$discount_items = json_decode($volume_discount_data, true);
$placeholder = wc_placeholder_img_src();

?>
<?php if( $volume_discount_type == 'thumbnail') : ?>
    <div class="tf-product-volume-discount-thumbnail">
        <h5 class="title-discount mb-20"><?php echo esc_html($title); ?></h5>
        <div class="list-volume-discount-thumbnail flat-check-list">
        <?php foreach ($discount_items as $item) : ?>
            <?php
                $from = max(0, $item['from']);
                $to = max(0, $item['to']);
                $discount = max(0, $item['discount']);
                if( empty($from) || empty($discount) || ($from >= $to && !empty($to) ) ){
                    continue;
                }
                $price = $product->get_price();
                $price_new = $price * ( 100 - $discount) / 100;
                $total = $from * $price;
                $total_new = $from * $price_new;
                $variation_data = [];

                if ($product->is_type('variable')) {
                    $variations = $product->get_available_variations();
                    
                    foreach ($variations as $variation) {
                        $variation_id = $variation['variation_id'];
                        $variation_price = max(0, $variation['display_price'] );
                        $variation_price_new = $variation_price * ( 100 - $discount) / 100;
                        $variation_total = $from * $variation_price;
                        $variation_total_new = $from * $variation_price_new;
                        $variation_data[$variation_id] = array(
                            'total_html' => wc_price($variation_total),
                            'total_new_html' => wc_price($variation_total_new)
                        );
                    }
                }

            ?>
            <div class="check-item volume-discount-item volume-discount-thumbnail-item" data-from="<?php echo esc_attr($from); ?>" data-to="<?php echo esc_attr($to); ?>" data-discount="<?php echo esc_attr($discount); ?>" data-variations="<?php echo esc_attr(json_encode($variation_data)); ?>">
                <div class="image-box">
                    <?php if( !empty($item['volume_discount_image']) ) : ?>
                        <img class="lazyload" width="210" height="280" data-src="<?php echo esc_url($item['volume_discount_image']); ?>" src="<?php echo esc_url($placeholder); ?>" alt="img-product">
                    <?php else: ?>
                        <img class="" width="210" height="280" src="<?php echo esc_url($placeholder); ?>" alt="img-product">
                    <?php endif; ?>
                    <div class="tags-save text-caption-01 d-block">
                        <?php
                            printf(
                                __('Save %s%%', 'ovinx'),
                                '<span class="tag-sold">' . esc_html($discount) . '</span>'
                            );
                        ?>
                    </div>
                </div>
                <div class="content-discount">
                    <div class="count fw-medium text-body-1"><?php _e('Buy ', 'ovinx'); ?><span class="text-xl fw-medium"><?php echo esc_html($from); ?></span> <?php echo esc_html($item['unit']); ?></php></div>
                    <div class="tf-price">
                            <span class="price-new text-primary fw-semibold tf-total-new"><?php echo wc_price($total_new); ?></span>
                            <span class="price-old tf-total-old"><?php echo wc_price($total); ?></span>
                    </div>
                </div>
                <?php if(!empty($item['tag_enable'])) : ?>
                    <div class="tag-sale" style="background:<?php echo esc_attr($item['tag_color']); ?>;" >
                        <?php if(!empty($item['tag_icon'])) : ?>
                            <i class="icon <?php echo esc_attr($item['tag_icon']); ?>"></i>
                        <?php endif; ?>
                        <?php echo esc_attr($item['tag_label']); ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        </div>
    </div>
<?php else: ?>
    <div class="tf-product-volume-discount">
        <h5 class="title-discount mb-20"><?php echo esc_html($title); ?></h5>
        <div class="flat-check-list list-volume-discount">
            <?php foreach ($discount_items as $item) : ?>
                <?php
                    $from = max(0, $item['from']);
                    $to = max(0, $item['to']);
                    $discount = max(0, $item['discount']);
                    if( empty($from) || empty($discount) || ($from >= $to && !empty($to) ) ){
                        continue;
                    }
                    $price = $product->get_price();
                    $price_new = $price * ( 100 - $discount) / 100;
                    $total = $from * $price;
                    $total_new = $from * $price_new;
                    $variation_data = [];

                    if ($product->is_type('variable')) {
                        $variations = $product->get_available_variations();
                        
                        foreach ($variations as $variation) {
                            $variation_id = $variation['variation_id'];
                            $variation_price = max(0, $variation['display_price'] );
                            $variation_price_new = $variation_price * ( 100 - $discount) / 100;
                            $variation_total = $from * $variation_price;
                            $variation_total_new = $from * $variation_price_new;
                            $variation_data[$variation_id] = array(
                                'save_volume_html' => wc_price($variation_total - $variation_total_new),
                                'total_html' => wc_price($variation_total),
                                'total_new_html' => wc_price($variation_total_new),
                                'total_new' => $variation_total_new,
                            );
                        }
                    }

                ?>
                <div class="check-item volume-discount-item volume-discount-list-item" data-from="<?php echo esc_attr($from); ?>" data-to="<?php echo esc_attr($to); ?>" data-discount="<?php echo esc_attr($discount); ?>" data-variations="<?php echo esc_attr(json_encode($variation_data)); ?>" >
                    <div class="content-discount">
                        <div class="info-discount content">

                            <div class="volume-check check">
                                <span class=""></span>
                            </div>

                            <span class="name fw-semibold">
                                <?php
                                    $from_html = '<span class="text-xl fw-bold">' . esc_html($from) . '</span>';
                                    $to_html   = empty($to)
                                        ? '+'
                                        : sprintf(
                                            __('to %s', 'ovinx'),
                                            '<span class="text-xl fw-bold">' . esc_html($to) . '</span>'
                                        );
                                    $discount_html = '<span class="text-xl fw-bold">' . esc_html($discount) . '</span>';
                                    
                                    printf(
                                        __('Buy from %1$s %2$s for %3$s%% OFF per item', 'ovinx'),
                                        $from_html,
                                        $to_html,
                                        $discount_html
                                    );

                                ?>
                            </span>

                            <span class="tags-save text-caption-01">
                                <?php
                                    printf(
                                        __('Save %s', 'ovinx'),
                                        '<span class="tf-save-volume">' . wc_price($total - $total_new) . '</span>'
                                    );
                                ?>
                            </span>

                        </div>

                        <?php
                            if( WC()->cart ){
                                $cart = WC()->cart;
                                if ( $cart ) {
                                    $packages = $cart->get_shipping_packages();
                                    $package  = reset( $packages );
                                    $zone     = wc_get_shipping_zone( $package );
                                    foreach ( $zone->get_shipping_methods( true ) as $key => $method ) {
                                        if ( 'free_shipping' === $method->id ) {
                                            $instance = isset( $method->instance_settings ) ? $method->instance_settings : null;
                                            $amount   = isset( $instance['min_amount'] ) ? $instance['min_amount'] : 0;
                                            $requires = isset( $instance['requires'] ) ? $instance['requires'] : '';
                                            
                                            $cart_total    = $cart->get_displayed_subtotal();
                                            
                                            if ($product->is_type('variable')){
                                            ?>
                                                <span class="tag-shipping text-xs tf-free-shipping-tag" data-free-shipping="<?php echo esc_attr($amount); ?>"><?php echo esc_html__( 'FREE SHIPPING' , 'ovinx'); ?></span>
                                            <?php
                                            }elseif( $total_new >= $amount){
                                            ?>
                                                <span class="tag-shipping text-xs tf-free-shipping-tag"><?php echo esc_html__( 'FREE SHIPPING' , 'ovinx'); ?></span>
                                            <?php
                                            }
                                            break;
                                        }
                                    }
                                }
                            }
                        ?>

                        <div class="d-block text-end discount-price tf-price">
                            <span class="cl-text-2"><?php _e('Total price:', 'ovinx'); ?></span>
                            <span class="price-new fw-semibold tf-total-new"><?php echo wc_price($total_new); ?></span>
                            <span class="price-old tf-total-old"><?php echo wc_price($total); ?></span>
                        </div>

                        <?php if(!empty($item['tag_enable'])) : ?>
                            <div class="tag-sale" style="--discount-bg:<?php echo esc_attr($item['tag_color']); ?>;" >
                                <?php if(!empty($item['tag_icon'])) : ?>
                                    <i class="icon <?php echo esc_attr($item['tag_icon']); ?>"></i>
                                <?php endif; ?>
                                <?php echo esc_attr($item['tag_label']); ?>
                                <span class="discount-effect-flash"></span>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <button data-bs-target="#shoppingCart" data-bs-toggle="offcanvas"
            class="d-none tf-btn btn-primary w-100 animate-btn"><?php echo esc_html__( 'Choose This Deal' , 'ovinx'); ?></button>
    </div>
<?php endif; ?>