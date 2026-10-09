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

if(!themesflat_get_opt('tf_buy_together')){
    return;
}

$style = $product->get_meta('_tf_product_together_style');

if( empty($style)){
    // 'list' is the only layout ovinx-html designs/styles (the 'grid' branch below has no CSS and its metabox select is disabled).
    $style = 'list';
}

$checked = $product->get_meta('_tf_product_together_check_all');

if( empty($checked) ){
    $checked = themesflat_get_opt('tf_buy_together_check_all') ? 'yes' : 'no';
}

$checked_classes = $checked == 'yes' ? 'check' : '';
$checked = $checked == 'yes' ? 'checked' : '';

$product_together_ids = $product->get_meta( '_tf_product_together_ids' ) ?? [];
if( empty($product_together_ids) ){
    return;
}
array_unshift($product_together_ids, $product->get_id());
$product_together_ids = array_unique($product_together_ids);

// Cache product objects 1 lần để tránh gọi wc_get_product() lặp lại cho cùng 1 ID ở các vòng lặp bên dưới (grid: ảnh + swatches, list: 1 vòng).
$product_together_cache = [];
foreach ($product_together_ids as $product_together_id) {
    $product_together_cache[$product_together_id] = wc_get_product($product_together_id);
}


themesflat_remove_hook('woocommerce_loop_add_to_cart_link', 'tfwc_add_to_cart', 20, 3 );
add_filter('woocommerce_loop_add_to_cart_link', [ Woo_Single_Product_Hook::instance(), 'select_option_button'] , 21, 3 );

$placeholder_image = wc_placeholder_img_src();

if( $style == 'grid') : ?>
    <div class="tf-product-fbt-wrap">
        <form class="tf-product-form-fbt tf-product-together-form">
            <h5 class="title mb-20 text-center"><?php esc_html_e('Frequently Bought Together', 'ovinx'); ?></h5>
            <div class="content-fbt">
                <div class="list-fbt">
                    <?php foreach ($product_together_ids as $product_together_id):
                        $product_together = $product_together_cache[$product_together_id];
                        if( ! $product_together ) continue;
                        if( $product_together->is_type('variation') ){
                            $atributes =  $product_together->get_attributes();
                            foreach( $atributes as $atribute_key => $value){
                                if( empty($value) ){
                                    continue 2;
                                }
                            }
                        }
                        if(!$product_together->is_in_stock() || $product_together->is_type('external') || $product_together->is_type('grouped') || $product_together->is_type('bundle') || $product_together->is_type('composite')) continue;
                        ?>
                        <div class="fbt-image item-has-checkbox  <?php echo esc_attr($checked_classes); ?>">
                            <a href="<?php echo esc_url($product_together_id == $product->get_id() ? '#' : $product_together->get_permalink()); ?>">
                                <?php
                                    $main_image   = $product_together->get_image_id() ? wp_get_attachment_image_url($product_together->get_image_id(), 'themesflat-product') : '';

                                    if(empty($main_image)) {
                                        $main_image = $placeholder_image;
                                    }
                                ?>
                                <img class="lazyload" width="130" height="100" data-src="<?php echo esc_url($main_image); ?>" src="<?php echo esc_url($placeholder_image); ?>" alt="img-product">
                            </a>
                        </div>
                        <?php if (end($product_together_ids) !== $product_together_id): ?>
                            <span class="fbt-plus"><span class="icon icon-Plus"></span></span>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>

                <div class="fbt-swatches list-order-product">
                    <?php foreach ($product_together_ids as $product_together_id):
                        $product_together = $product_together_cache[$product_together_id];
                        if( ! $product_together ) continue;
                        if( $product_together->is_type('variation') ){
                            $atributes =  $product_together->get_attributes();
                            foreach( $atributes as $atribute_key => $value){
                                if( empty($value) ){
                                    continue 2;
                                }
                            }
                        }
                        if(!$product_together->is_in_stock() || $product_together->is_type('external') || $product_together->is_type('grouped') || $product_together->is_type('bundle') || $product_together->is_type('composite')) continue;
                        $disabled = ($product_together_id == get_the_ID()) ? 'disabled readonly' : '';
                        ?>
                        <div class="order-item fbt-info tf-fbt-item item-has-checkbox <?php echo esc_attr($checked_classes); ?> <?php echo esc_attr($product_together_id == $product->get_id() ? 'main-item' : ''); ?>" data-product_id="<?php echo absint($product_together_id); ?>" <?php echo esc_attr($checked); ?>>
                            <div class="bundle-check">
                                <input type="checkbox" class="tf-check" aria-label="<?php esc_attr_e( 'Include in bundle', 'ovinx' ); ?>" <?php echo esc_attr($disabled); ?> <?php echo esc_attr($checked); ?>>
                            </div>
                            <div class="bundle-title text-md fw-medium">
                                <a href="<?php echo esc_url($product_together_id == $product->get_id() ? '#' : $product_together->get_permalink()); ?>">
                                    <?php echo esc_html($product_together->get_name()); ?>
                                </a>
                            </div>
                            <?php if ($product_together->is_type('variable')): ?>
                                <?php
                                    $default_attrs = $product_together->get_default_attributes();
                                    $normalized_default_attrs = [];
                                    foreach ( $default_attrs as $key => $val ) {
                                        $normalized_default_attrs[ 'attribute_' . $key ] = $val;
                                    }
                                    $variations = $product_together->get_available_variations();
                                    $all_attrs = $product_together->get_variation_attributes();
                                ?>
                                <?php if(count( $all_attrs ) < 6 ) : ?>
                                    <div class="bundle-variant tf-select">
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
                                                        $options_string = $product_together->get_attribute( $taxonomy );
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
                                    <input type="hidden" class="fbt_variation_id" value="" data-atrributes="" />
                                <?php endif; ?>
                            <?php endif; ?>

                            <div class="bundle-price text-md fw-medium">
                                <span class="tf-price" data-price="<?php echo esc_attr( $product_together->is_type('variable') ? '0' : $product_together->get_price() ); ?>"><?php echo wp_kses_post($product_together->get_price_html()); ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="fbt-total-price text-xl fw-medium">
                <span>
                    <div class="h6">
                        <?php printf(
                            __('Total price: %s', 'ovinx'),
                            '<span class="total-price"></span>'
                        ); ?>
                    </div>
                </span>
                <div class="d-flex align-items-center">
                    <span class="price-new"></span>
                    <span class="price-old"></span>
                </div>
            </div>

            <button data-bs-target="#shoppingCart" type="button" data-bs-toggle="" class="tf-fbt-btn has-loading loading-hidden-text tf-btn btn-primary w-100 effect-flash mt-3">
                <span class="btn-text-wrapper">
                    <?php echo esc_html__('Add Selected To Cart' , 'ovinx'); ?>
                    <i class="icon icon-ShoppingBagOpen"></i>
                    <span class="total-price"></span>
                </span>
                <span class="tf-add-to-cart-loading d-none position-relative">
                    <span class="spinner"></span>
                </span>
            </button>
        </form>
    </div>
<?php else : ?>
    <div class="tf-product-fbt">
        <h5 class="mb-24"><?php esc_html_e('Frequently Bought Together', 'ovinx'); ?></h5>
        <form class="tf-product-form-bundle tf-product-together-form">
            <ul class="list-order-product list-bundle-prd">
                <?php
                    foreach($product_together_ids as $product_together_id){
                        $product_together = $product_together_cache[$product_together_id];
                        if( ! $product_together ) continue;
                        if( $product_together->is_type('variation') ){
                            $atributes =  $product_together->get_attributes();
                            foreach( $atributes as $atribute_key => $value){
                                if( empty($value) ){
                                    continue 2;
                                }
                            }
                        }
                        if($product_together->is_in_stock() && !$product_together->is_type('external') && !$product_together->is_type('grouped') && !$product_together->is_type('bundle') && !$product_together->is_type('composite')){
                            $together_url = $product_together_id == $product->get_id() ? '#' : $product_together->get_permalink();
                            $main_image   = $product_together->get_image_id() ? wp_get_attachment_image_url($product_together->get_image_id(), 'themesflat-product') : '';

                            if(empty($main_image)) {
                                $main_image = $placeholder_image;
                            }
                            ?>
                            <li class="order-item tf-fbt-item item-has-checkbox <?php echo esc_attr($checked_classes); ?> <?php echo esc_attr($product_together_id == $product->get_id() ? 'main-item' : ''); ?>" data-product_id="<?php echo absint($product_together_id); ?>">
                                <div class="bundle-check d-flex">
                                    <input type="checkbox" class="tf-check" aria-label="<?php esc_attr_e( 'Include in bundle', 'ovinx' ); ?>" <?php echo esc_attr($checked); ?>>
                                </div>
                                <a href="<?php echo esc_url($together_url); ?>" class="img-prd">
                                    <img loading="lazy" width="100" height="133" src="<?php echo esc_url($main_image); ?>" alt="<?php echo esc_attr($product_together->get_name()); ?>">
                                </a>
                                <div class="infor-prd">
                                    <a href="<?php echo esc_url($together_url); ?>" class="prd_name cl-text-main link-underline fw-medium lh-24 text-line-clamp-2">
                                        <?php echo esc_html($product_together->get_name()); ?>
                                    </a>
                                    <?php if ($product_together->is_type('variable')): ?>
                                        <?php
                                            $default_attrs = $product_together->get_default_attributes();
                                            $normalized_default_attrs = [];
                                            foreach ( $default_attrs as $key => $val ) {
                                                $normalized_default_attrs[ 'attribute_' . $key ] = $val;
                                            }
                                            $variations = $product_together->get_available_variations();
                                            $all_attrs = $product_together->get_variation_attributes();
                                        ?>
                                        <?php if(count( $all_attrs ) < 6 ) : ?>
                                            <div class="bundle-variant tf-select">
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
                                                                $options_string = $product_together->get_attribute( $taxonomy );
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
                                            <input type="hidden" class="fbt_variation_id" value="" data-atrributes="" />
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                                <div class="quantity-price lh-24 fw-medium cl-text-main">
                                    <span class="tf-price price" data-price="<?php echo esc_attr( $product_together->is_type('variable') ? '0' : $product_together->get_price() ); ?>"><?php echo wp_kses_post($product_together->get_price_html()); ?></span>
                                </div>
                            </li>
                            <?php
                        }
                    }
                ?>
            </ul>
            <h6 class="bundle-total-submit mb-12">
                <span class="text cl-text-2 fw-normal"><?php esc_html_e('Total price:', 'ovinx'); ?></span>
                &nbsp;
                <span class="total-price total-price-bundle fw-semibold"></span>
            </h6>
            <button data-bs-target="#shoppingCart" type="button" data-bs-toggle="" class="btn-submit-total tf-btn has-loading tf-fbt-btn w-100">
                <span class="text-uppercase"><?php echo esc_html__('Add Selected To Cart' , 'ovinx'); ?></span>
                <span class="tf-add-to-cart-loading d-none position-relative">
                    <span class="spinner"></span>
                </span>
            </button>
        </form>
    </div>
<?php endif; ?>

<?php
add_filter('woocommerce_loop_add_to_cart_link', 'tfwc_add_to_cart', 20, 3 );
themesflat_remove_hook('woocommerce_loop_add_to_cart_link', [ Woo_Single_Product_Hook::instance(), 'select_option_button'], 21, 3 );
?>