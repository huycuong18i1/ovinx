<?php

$args = array(
    'status' => 'publish',
    'limit' => -1,
);
$products = wc_get_products( $args );

$categories = get_terms( array(
    'taxonomy' => 'product_cat',
    'orderby' => 'name',
    'hide_empty' => true,
) );

$materials = get_terms( array(
    'taxonomy' => 'pa_material',
    'hide_empty' => true,
) );

$stone_colors = get_terms( array(
    'taxonomy' => 'pa_color',
    'hide_empty' => true,
) );

$sizes = get_terms( array(
    'taxonomy' => 'pa_size-number',
    'hide_empty' => true,
    'fields' => 'names',
) );

$in_stock_count = 0;
$out_of_stock_count = 0;

foreach ( $products as $product ) {
    if ( $product->get_stock_status() === 'instock' ) {
        $in_stock_count++;
    } else {
        $out_of_stock_count++;
    }
}
?>

<div class="apply-filter-wrap">
    <p class="title h6 fw-normal text-uppercase d-xl-none"><?php esc_html_e( 'Applied Filters', 'ovinx' ); ?></p>
    <div id="product-count-grid" class="count-text text-main-4 d-xl-none"><?php esc_html_e( 'No Filter Selected', 'ovinx' ); ?></div>
    <div class="meta-filter-shop">
        <div id="product-count-grid" class="count-text"></div>
        <div id="applied-filters" class="check-yes selected-filters"></div>
    </div>
</div>

<!-- Availability Filter -->
<div class="widget-facet">
    <div class="facet-title h6 fw-normal" data-bs-target="#availability" role="button" data-bs-toggle="collapse"
        aria-expanded="true" aria-controls="availability">
        <span class="h6 fw-normal text-uppercase"><?php esc_html_e( 'Availability', 'ovinx' ); ?></span>
        <span class="icon ic-accordion-custom"></span>
    </div>
    <div id="availability" class="collapse show">
        <ul class="collapse-body filter-group-check current-scrollbar">
            <li class="list-item">
                <input type="radio" name="availability" class="tf-check style-2" id="inStock">
                <label for="inStock" class="label">
                    <span><?php esc_html_e( 'In Stock', 'ovinx' ); ?></span><span class="count-wrap">[ <?php echo esc_html( $in_stock_count ); ?> ]</span>
                </label>
            </li>
            <li class="list-item disabled">
                <input type="radio" name="availability" class="tf-check style-2" id="outStock">
                <label for="outStock" class="label">
                    <span><?php esc_html_e( 'Out of Stock', 'ovinx' ); ?></span><span class="count-wrap">[ <?php echo esc_html( $out_of_stock_count ); ?> ]</span>
                </label>
            </li>
        </ul>
    </div>
</div>

<!-- Category Filter -->
<div class="widget-facet">
    <div class="facet-title h6 fw-normal" data-bs-target="#categories" role="button" data-bs-toggle="collapse"
        aria-expanded="true" aria-controls="categories">
        <span class="h6 fw-normal text-uppercase"><?php esc_html_e( 'Category', 'ovinx' ); ?></span>
        <span class="icon ic-accordion-custom"></span>
    </div>
    <div id="categories" class="collapse show">
        <ul class="collapse-body filter-group-check current-scrollbar">
            <?php foreach ( $categories as $category ) : ?>
                <li class="list-item">
                    <input type="checkbox" name="category" class="tf-check style-2 tf_filter_category" data-category="<?php echo esc_attr( $category->slug ); ?>" id="category-<?php echo esc_attr( $category->term_id ); ?>">
                    <label for="category-<?php echo esc_attr( $category->term_id ); ?>" class="label">
                        <span><?php echo esc_html( $category->name ); ?></span><span class="count-wrap">[ <span class="count"><?php echo esc_html( $category->count ); ?></span> ]</span>
                    </label>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<!-- Material Filter -->
<div class="widget-facet">
    <div class="facet-title h6 fw-normal" data-bs-target="#materials" role="button" data-bs-toggle="collapse"
        aria-expanded="true" aria-controls="materials">
        <span class="h6 fw-normal text-uppercase"><?php esc_html_e( 'Material', 'ovinx' ); ?></span>
        <span class="icon ic-accordion-custom"></span>
    </div>
    <div id="materials" class="collapse show">
        <ul class="collapse-body filter-group-check current-scrollbar">
            <?php if ( is_array( $materials ) ) : ?>
                <?php foreach ( $materials as $material ) : ?>
                    <li class="list-item">
                        <input type="checkbox" name="material" class="tf-check style-2" id="material-<?php echo esc_attr( $material->term_id ); ?>">
                        <label for="material-<?php echo esc_attr( $material->term_id ); ?>" class="label">
                            <span><?php echo esc_html( ucfirst( $material->name ) ); ?></span>
                            <span class="count-wrap">[ <span class="count"><?php echo esc_html( $material->count ); ?></span> ]</span>
                        </label>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>
</div>

<!-- Stone Color Filter -->
<div class="widget-facet">
    <div class="facet-title h6 fw-normal" data-bs-target="#stone-color" role="button" data-bs-toggle="collapse"
        aria-expanded="true" aria-controls="stone-color">
        <span class="h6 fw-normal text-uppercase"><?php esc_html_e( 'Stone Colour', 'ovinx' ); ?></span>
        <span class="icon ic-accordion-custom"></span>
    </div>
    <div id="stone-color" class="collapse show">
        <ul class="collapse-body filter-group-check current-scrollbar">
            <?php if ( is_array( $stone_colors ) ) : ?>
                <?php foreach ( $stone_colors as $color ) : ?>
                    <li class="list-item">
                        <input type="checkbox" name="color" class="tf-check style-2" id="color-<?php echo esc_attr( $color->term_id ); ?>">
                        <label for="color-<?php echo esc_attr( $color->term_id ); ?>" class="label">
                            <img src="images/products/material/dia-<?php echo esc_attr( strtolower( $color->slug ) ); ?>.jpg" alt="Colour" class="img-check">
                            <span><?php echo esc_html( ucfirst( $color->name ) ); ?></span>
                            <span class="count-wrap">[ <span class="count"><?php echo esc_html( $color->count ); ?></span> ]</span>
                        </label>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>
</div>

<!-- Price Filter -->
<div class="widget-facet">
    <div class="facet-title h6 fw-normal" data-bs-target="#price" role="button" data-bs-toggle="collapse" aria-expanded="true"
        aria-controls="price">
        <span class="h6 fw-normal text-uppercase">price</span>
        <span class="icon ic-accordion-custom"></span>
    </div>
    <div id="price" class="collapse show">
        <ul class="collapse-body filter-group-check current-scrollbar">
            <li class="list-item">
                <input type="radio" name="price" class="tf-check style-2" id="u-500">
                <label for="u-500" class="label">
                    <span>Under $500</span><span class="count-wrap">[ <span class="count">20</span> ]</span>
                </label>
            </li>
            <li class="list-item">
                <input type="radio" name="price" class="tf-check style-2" id="u-1000">
                <label for="u-1000" class="label">
                    <span>Under $1000</span><span class="count-wrap">[ <span class="count">20</span> ]</span>
                </label>
            </li>
            <li class="list-item">
                <input type="radio" name="price" class="tf-check style-2" id="u-2000">
                <label for="u-2000" class="label">
                    <span>Under $2000</span><span class="count-wrap">[ <span class="count">20</span> ]</span>
                </label>
            </li>
            <li class="list-item">
                <input type="radio" name="price" class="tf-check style-2" id="up-2000">
                <label for="up-2000" class="label">
                    <span>Over $2000</span><span class="count-wrap">[ <span class="count">20</span> ]</span>
                </label>
            </li>
        </ul>
    </div>
</div>

<!-- Size Filter -->
<div class="widget-facet">
    <div class="facet-title h6 fw-normal" data-bs-target="#size" role="button" data-bs-toggle="collapse"
        aria-expanded="true" aria-controls="size">
        <span class="h6 fw-normal text-uppercase"><?php esc_html_e( 'Size', 'ovinx' ); ?></span>
        <span class="icon ic-accordion-custom"></span>
    </div>
    <div id="size" class="collapse show">
        <div class="collapse-body filter-size-box flat-check-list">
            <?php if ( is_array( $sizes ) ) : ?>
                <?php foreach ( $sizes as $size ) : ?>
                    <div class="check-item size-item size-check"><span class="count size"><?php echo esc_html( $size ); ?></span></div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
