<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

if ( function_exists( 'themesflat_get_opt' ) ) {
    $atb_name = themesflat_get_opt('attribute_first');
    $attr_type = themesflat_get_opt('attr1_type');
    $attr_count = themesflat_get_opt('attr1_count');

    $product_second_attribute = $product->get_meta('_tfwc_product_card_attribute');
    $product_second_attribute_max_number = $product->get_meta('_tfwc_product_card_attribute_max_number');

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

$terms = wc_get_product_terms($product->get_id(), $atb_name, ['fields' => 'all']);

$label_to_term_id = [];

foreach ($terms as $term) {
    $label_to_term_id[$term->slug] = $term->term_id;
    $label_to_term_id[$term->name] = $term->term_id;
    $label_to_term_id[sanitize_title($term->name)] = $term->term_id;
}

$sizes = $product->get_attribute($atb_name);

$product_style = isset($_GET['product_style']) ? $_GET['product_style'] : themesflat_get_opt('product_style');
if (isset($_POST['product_style'])) {
	$product_style = sanitize_text_field($_POST['product_style']);
}
$class = '';
if($product_style != 'style-list') {
	$class = '  ';
}

if (!empty($sizes) && ($product->is_type('variable')) ) :
    $sizes_arr = array_slice(explode(',', $sizes), 0, $attr_count);
?>

    <div class="variant-box">

        <?php switch ($attr_type) : 
            case 'label':
                ?>
                <ul class="product-size_list size-box">
                    <?php foreach ($sizes_arr as $size) : ?>

                        <?php
                            $slug = sanitize_title(trim($size));
                            $label = trim($size);

                            $term_id = 0;

                            if (isset($label_to_term_id[$size])) {
                                $term_id = $label_to_term_id[$size];
                            } elseif (isset($label_to_term_id[$slug])) {
                                $term_id = $label_to_term_id[$slug];
                            }

                            if ($term_id && !empty($product_swatches[$term_id]['label'])) {
                                $label = $product_swatches[$term_id]['label'];
                            }
                        ?>
                        <li class="size-item text-caption-01 <?php echo esc_attr($class); ?>"><?php echo esc_html( $label ); ?></li>
                    <?php endforeach; ?>
                </ul>
                <?php
                break;
            case 'label2':
                ?>
                <ul class="list-color-product list-capacity-product justify-content-center">
                    <?php foreach ($sizes_arr as $size) : ?>
                        <li class="list-color-item color-swatch <?php echo esc_attr($class); ?>">
                            <span class="text-quantity"><?php echo esc_html(trim($size)); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <?php
                break;
            default:
                break;
        endswitch; ?>

    </div>
<?php endif; ?>

