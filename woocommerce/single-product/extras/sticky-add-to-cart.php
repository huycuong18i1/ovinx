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

$image = wp_get_attachment_image_src( $product->get_image_id(), 'full' );
if ( ! empty($image[0]) ) {
    $image = $image[0]; 
}else{
    $image = wc_placeholder_img_src();
}
?>
<div class="tf-sticky-btn-atc tf-sticky-atc-wrapper">
    <div class="container">
        <div class="tf-height-observer w-100 d-flex align-items-center justify-content-between">
            <div class="tf-sticky-atc-product d-flex align-items-center">
                <?php
                /**
                 * Ground truth (ovinx-html/product-detail.html ~L1638-1663) nests an extra real
                 * `.atc-product-side > .prd_img` wrapper here — the real CSS for capping the
                 * thumbnail to 60px (`.tf-sticky-btn-atc .atc-product-side .prd_img{max-width:60px;
                 * overflow:hidden}` + `img{width:100%;height:100%;object-fit:cover}`, css/styles.css
                 * ~L14837) already exists but never matched anything, since this markup used
                 * different invented class names (`.tf-sticky-atc-img`/`.tf-sticky-atc-title`, no
                 * `.atc-product-side` wrapper at all) — the `<img>` rendered at its natural full
                 * size (558×744px in testing) instead of a 60px thumbnail, blowing up this whole
                 * fixed bottom bar into a giant vertical block. Also added the real `.prd_info`/
                 * `.name__prd`/`.price__prd` (real price, not just the bare title ground truth's
                 * markup expects here).
                 */
                ?>
                <div class="atc-product-side">
                    <div class="prd_img">
                        <img class="lazyload" data-src="<?php echo esc_url($image); ?>" alt="<?php echo esc_html($product->get_title()); ?>" src="">
                    </div>
                    <div class="prd_info d-none d-sm-grid">
                        <p class="name__prd cl-text-main fw-medium lh-24 text-line-clamp-1"><?php echo esc_html($product->get_title()); ?></p>
                        <div class="price__prd">
                            <?php echo wp_kses_post($product->get_price_html()); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tf-sticky-atc-infos">
                <form class="tf-sticky-atc-form" method="post" enctype="multipart/form-data" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" data-product_id="<?php echo absint( $product->get_id() ); ?>">   
                    <?php if ( $product && $product->is_type( 'variable' ) ) { ?>
                            <?php
                            $default_attrs = $product->get_default_attributes();
                            $all_attrs = $product->get_variation_attributes();
                            $normalized_default_attrs = [];
                            foreach ( $default_attrs as $key => $val ) {
                                $normalized_default_attrs[ 'attribute_' . $key ] = $val;
                            }
                            $variations    = $product->get_available_variations();
                            ?>
                            <?php if(count( $all_attrs ) < 4 ) : ?>
                                <div class="tf-sticky-atc-variant-price text-center tf-select">
                                    <select name="sticky-add-to-cart-product-variations">
                                    <?php
                                        foreach ( $variations as $variation ) {
                                            $variation_obj = wc_get_product( $variation['variation_id'] );
                                            if ( ! $variation_obj || ! $variation_obj->exists() ) continue;
                                        
                                            $price = wc_price( $variation_obj->get_price() );
                                            $image_url = wp_get_attachment_image_url( $variation_obj->get_image_id(), 'thumbnail' );
                                        
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
                                                $label = implode( ' / ', $set['_label'] ) . ' - ' . $price;
                                        
                                                $data_attributes = array_filter($set, fn($k) => strpos($k, '_label') === false, ARRAY_FILTER_USE_KEY);
                                        
                                                echo '<option 
                                                    value="' . esc_attr( $variation['variation_id'] ) . '" 
                                                    data-image="' . esc_url( $image_url ) . '" 
                                                    data-attributes="' . esc_attr( json_encode( $data_attributes ) ) . '" 
                                                    ' . selected( empty(array_diff_assoc($variation['attributes'], $normalized_default_attrs)), true, false ) . '>'
                                                    . $label . 
                                                    '</option>';
                                            }
                                        }                                    
                                    ?>
                                    </select>
                                </div>
                            <?php else : ?>
                                <?php
                                    remove_all_filters( 'woocommerce_dropdown_variation_attribute_options_html');
                                    $attributes = $product->get_variation_attributes();
                                ?>
                                <div class="d-flex align-items-center gap-1">
                                    <div class="tf-sticky-atc-options" >
                                    <?php foreach ( $attributes as $attribute_name => $options ) :?>
                                        <div class="tf-sticky-atc-variant-price text-center tf-select">
                                        <p class="title d-none">
                                            <?php echo wc_attribute_label($attribute_name); ?>:
                                        </p>
                                        <?php
                                            wc_dropdown_variation_attribute_options(
                                                array(
                                                    'options'   => $options,
                                                    'attribute' => $attribute_name,
                                                    'product'   => $product,
                                                )
                                            );
                                        ?>
                                        </div>
                                    <?php endforeach; ?>
                                    </div>
                                    <span class="open-options icon icon-ArrowUpRight2"></span>
                                </div>
                            <?php endif; ?>
                    <?php } ?>
                    <div class="tf-sticky-atc-btns">
                        <?php
                        woocommerce_quantity_input(
                            array(
                                'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
                                'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
                                'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
                            )
                        );
                        ?>
                        <a data-bs-toggle="" data-bs-target="#shoppingCart" class="tf-sticky-atc-ajax has-loading loading-hidden-text tf-btn btn-fill animate-btn fw-medium">
                            <span>
                                <?php echo esc_html__( themesflat_get_opt('single_add_to_cart_text') ?? 'Add to cart' , 'ovinx'); ?>
                            </span>
                            <span class="tf-add-to-cart-loading d-none position-relative">
                                <span class="spinner"></span>
                            </span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>