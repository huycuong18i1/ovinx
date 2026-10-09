<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

$product_style = isset($_GET['product_style']) ? $_GET['product_style'] : themesflat_get_opt('product_style');
if (isset($_POST['product_style'])) {
    $product_style = sanitize_text_field($_POST['product_style']);
}
// ground truth's list-style color swatches use tooltip-bot, same as grid — tooltip-top isn't even
// a real CSS variant here (only .hover-tooltip.tooltip-bot/-left/-right exist).
$class = ' tooltip-bot ';

if ( function_exists( 'themesflat_get_opt' ) ) {
    
    $atb_name = themesflat_get_opt('attribute_second');
    $attr_type = 'color'; // fallback swatch type (the old "attr2_type" setting never had a Customizer control)
    $attr_count = themesflat_get_opt('attr2_count');

    $product_second_attribute = $product->get_meta('_tfwc_product_card_second_attribute');
    $product_second_attribute_max_number = $product->get_meta('_tfwc_product_card_second_attribute_max_number');

    if( !empty($product_second_attribute) ) {
        $atb_name = $product_second_attribute;
    }

    if( !empty($product_second_attribute_max_number) ) {
        $attr_count = $product_second_attribute_max_number;
    }

}

if ( $atb_name == 'none' ) {
    return;
}

$atb_name = 'pa_' . $atb_name ;

$swatch_type = '';

$swatches = $product->get_meta('wcboost_variation_swatches');

if ( ! empty( $swatches[$atb_name]['type'] ) ) {
    $swatch_type = $swatches[$atb_name]['type'];
}

if ( empty( $swatch_type ) ) {
    $taxonomy = wc_get_attribute( str_replace('pa_', '', $atb_name) );
    
    if ( $taxonomy && ! empty($taxonomy->type) ) {
        $swatch_type = $taxonomy->type;
    }
}

if ( empty( $swatch_type ) ) {
    $swatch_type = $attr_type;
}

$product_swatches = $swatches[$atb_name]['swatches'] ?? [];

$variation_data = [];
if ($product->is_type('variable')) {
    $variations = $product->get_available_variations();
    foreach ($variations as $variation) {
        $color_value = $variation['attributes']['attribute_'.$atb_name] ?? '';
        if ($color_value) {
            $variation_data[$color_value] = [
                'price' => wc_price($variation['display_price']),
                'image' => $variation['image']['src'] ?? '',
            ];
        }
    }
}

$color_terms = wc_get_product_terms($product->get_id(), $atb_name, ['fields' => 'all']);
$color_options = [];
$bg_options = [];
if (!empty($color_terms)) {
    foreach ($color_terms as $term) {
        $color_options[$term->slug] = $term->name;
        
    }
}

$color_terms = array_slice($color_terms, 0, $attr_count );

$default_attributes = $product->get_default_attributes();
$default_value = $default_attributes[$atb_name] ?? '';

if ($product->is_type('variable') && !empty($color_options)) :
    $key = 0 ;
    
?>
    <?php switch ($swatch_type) :
        case 'color':
            ?>
            <ul class="product-color_list">
                <?php foreach ($color_terms as $term) :
                    $key ++;
                    $data_price = $variation_data[$term->slug]['price'] ?? '';
                    $data_image = $variation_data[$term->slug]['image'] ?? '';
                    $data_color = $product_swatches[$term->term_id]['color'] ?? '';

                    $is_active = ($term->slug === $default_value) ? 'active' : '';

                    if ( empty($data_image) ) {
                        $data_image    = $product->get_image_id() ? wp_get_attachment_image_url($product->get_image_id(), 'themesflat-product') : '';
                        if(empty($data_image)) {
                            $data_image = wc_placeholder_img_src();
                        }
                    }
                    
                    if ( class_exists( '\WCBoost\VariationSwatches\Admin\Term_Meta' ) ) {
                        $color = \WCBoost\VariationSwatches\Admin\Term_Meta::instance()->get_meta( $term->term_id,'color' );
                    } else {
                        $color = get_term_meta($term->term_id, 'color', true);
                    }

                    if( !empty($data_color) ) {
                        $color = $data_color;
                    }
            
                    $bg_color = $color ? esc_attr($color) : esc_attr(strtolower($term->slug));

                    $class_white = '';

                    if ( strtolower($bg_color) === '#ffffff' || strtolower($bg_color) === '#fff'  || strtolower($bg_color) === 'white' ) {
                        $class_white = 'line';
                    }

                ?>
                    <li class="product-color-item att-color-<?php echo esc_attr($bg_color); ?> color-swatch hover-tooltip <?php echo esc_attr($class);?> <?php echo esc_attr($class_white);?> <?php echo esc_attr($is_active);?>" 
                        data-price="<?php echo esc_attr($data_price); ?>" 
                        data-image="<?php echo esc_url($data_image); ?>">
                        <span class="tooltip color-filter"><?php echo esc_html($term->name); ?></span>
                        <span class="swatch-value" style="background-color: <?php echo esc_attr($bg_color); ?>;"></span>
                        <img class="" data-src="<?php echo esc_url($data_image); ?>" alt="image-product">
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php
            break;
        case 'image':
            ?>
            <ul class="product-color_list">

                <?php foreach ($color_terms as $term) :
                    $key ++;
                    
                    $data_price = $variation_data[$term->slug]['price'] ?? '';
                    $data_image = $variation_data[$term->slug]['image'] ?? '';
                    $term_id  = $term->term_id;

                    $label = $term->name;

                    if ($term_id && !empty($product_swatches[$term_id]['label'])) {
                        $label = $product_swatches[$term_id]['label'];
                    }

                    $is_active = ($term->slug === $default_value) ? 'active' : '';

                    if ( empty($data_image) ) {
                        $data_image = $product->get_image_id() ? wp_get_attachment_image_url($product->get_image_id(), 'themesflat-product') : '';
                        if(empty($data_image)) {
                            $data_image = wc_placeholder_img_src();
                        }
                    }

                    if ($term_id && !empty($product_swatches[$term_id]['image'])) {
                        $swatch_image_url = wp_get_attachment_image_url( $product_swatches[$term_id]['image'] , 'full');
                        if( !empty($swatch_image_url) ) {
                            $data_image = $swatch_image_url;
                        }
                    }
                    
                    if ( class_exists( '\WCBoost\VariationSwatches\Admin\Term_Meta' ) ) {
                        $color = \WCBoost\VariationSwatches\Admin\Term_Meta::instance()->get_meta( $term->term_id,'color' );
                    } else {
                        $color = get_term_meta($term->term_id, 'color', true);
                    }
            
                    $bg_color = $color ? esc_attr($color) : esc_attr(strtolower($term->slug));

                    $class_white = '';

                    if ( strtolower($bg_color) === '#ffffff' || strtolower($bg_color) === '#fff'  || strtolower($bg_color) === 'white' ) {
                        $class_white = 'line';
                    }

                ?>
                    <li class="product-color-item color-swatch image-swatch hover-tooltip <?php echo esc_attr($class);?> <?php echo esc_attr($class_white);?> <?php echo esc_attr($is_active);?>" 
                        data-price="<?php echo esc_attr($data_price); ?>" 
                        data-image="<?php echo esc_url($data_image); ?>">

                        <span class="tooltip color-filter"><?php echo esc_html($label); ?></span>
                        <img class="lazyload" data-src="<?php echo esc_url($data_image); ?>" alt="image-product">

                    </li>
                <?php endforeach; ?>
            </ul>
            <?php
            break;
        default:
            /**
             * Ground truth's `.product-color_list` design intentionally hides everything inside
             * each swatch (img/.swatch-value/.color-filter are `display:none` — only a small 8x4px
             * dash is shown, growing + darkening when `.active`, see css/styles.css). There is no
             * ground-truth "label pill" variant for a non-color/non-image attribute — printing the
             * term label as visible text here (the old `label-swatch tf-btn btn-white` combo has
             * zero matching CSS) overflowed on top of the product image. Falling back to the exact
             * same real dash-swatch markup as the color/image branches keeps every attribute type
             * visually consistent and bug-free instead of inventing new unstyled UI.
             */
            ?>
            <ul class="product-color_list">

                <?php foreach ($color_terms as $term) :
                    $key ++;

                    $data_price = $variation_data[$term->slug]['price'] ?? '';
                    $data_image = $variation_data[$term->slug]['image'] ?? '';
                    $term_id  = $term->term_id;

                    $label = $term->name;

                    if ($term_id && !empty($product_swatches[$term_id]['label'])) {
                        $label = $product_swatches[$term_id]['label'];
                    }

                    $is_active = ($term->slug === $default_value) ? 'active' : '';

                    if ( empty($data_image) ) {
                        $data_image    = $product->get_image_id() ? wp_get_attachment_image_url($product->get_image_id(), 'themesflat-product') : '';
                        if(empty($data_image)) {
                            $data_image = wc_placeholder_img_src();
                        }
                    }
                ?>
                    <li class="product-color-item color-swatch hover-tooltip <?php echo esc_attr($class);?> <?php echo esc_attr($is_active);?>"
                        data-price="<?php echo esc_attr($data_price); ?>"
                        data-image="<?php echo esc_url($data_image); ?>">
                        <span class="tooltip color-filter"><?php echo esc_html( $label ); ?></span>
                        <img data-src="<?php echo esc_url($data_image); ?>" alt="image-product">
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php
            break;
    endswitch;

else :
    /**
     * No real color attribute/variation data (simple product, or a variable product whose
     * only attributes aren't "color"). Ground truth (`ovinx-html/shop-default.html`) still
     * renders `.product-color_list` on EVERY card regardless — e.g. product #9 there has no
     * real color name at all, just one `<li>` per photo (main image + each gallery image),
     * used purely as an image-preview dash row (see swatchColor() in js/shop.js: it swaps
     * the card's main photo from any `.color-swatch img`'s data-src, with zero awareness of
     * WooCommerce attributes — so this works identically to the real-attribute branches
     * above without any JS change). Falling back to the product's own gallery here instead
     * of omitting the row keeps every card visually consistent with the design instead of
     * only the handful of products that happen to have a genuine color attribute.
     */
    $gallery_image_ids = array_values( array_filter( array_merge( array( $product->get_image_id() ), $product->get_gallery_image_ids() ) ) );
    if ( ! empty( $attr_count ) ) {
        $gallery_image_ids = array_slice( $gallery_image_ids, 0, $attr_count );
    }
    if ( count( $gallery_image_ids ) > 1 ) :
    ?>
        <ul class="product-color_list">
            <?php foreach ( $gallery_image_ids as $i => $img_id ) :
                $img_url = wp_get_attachment_image_url( $img_id, 'themesflat-product' );
                if ( empty( $img_url ) ) {
                    continue;
                }
            ?>
                <li class="product-color-item color-swatch hover-tooltip <?php echo esc_attr( $class ); ?> <?php echo 0 === $i ? 'active' : ''; ?>"
                    data-price=""
                    data-image="<?php echo esc_url( $img_url ); ?>">
                    <span class="tooltip color-filter"></span>
                    <span class="swatch-value"></span>
                    <img data-src="<?php echo esc_url( $img_url ); ?>" alt="image-product">
                </li>
            <?php endforeach; ?>
        </ul>
    <?php
    endif;
endif; ?>
<?php
?>
