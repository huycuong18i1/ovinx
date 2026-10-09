<?php

if ( ! class_exists( 'WooCommerce' ) ) {
    return;
}

$product_categories = get_terms(array(
    'taxonomy'   => 'product_cat',
    'orderby'    => 'name',
    'order'      => 'ASC',
    'hide_empty' => false,
));

if ( empty($product_categories) || is_wp_error($product_categories) ) {
    return;
}
?>

<form class="form_search-product" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <input type="hidden" name="post_type" value="product">
    <div class="select-category">
        <select name="product_cat" id="product_cat" class="dropdown_product_cate">
            <option value="" selected="selected"><?php echo esc_html__('All categories','ovinx');?></option>
            <?php foreach ($product_categories as $cat): ?>
                <option class="level-0" value="<?php echo esc_attr($cat->slug); ?>">
                    <?php echo esc_html($cat->name); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <ul class="select-options">
            <li class="link" rel=""><span><?php echo esc_html__('All categories','ovinx')?></span></li>
            <?php foreach ($product_categories as $cat): ?>
                <li class="link" rel="<?php echo esc_attr($cat->slug); ?>">
                    <span><?php echo esc_html($cat->name); ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="line-border"></div>

    <input class="entry-ip ajax-search-input" type="text" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php echo esc_attr__('Search for products...','ovinx');?>" required>
    <button type="button" class="btn-submit tf-search-btn is-search" aria-label="<?php esc_attr_e( 'Search', 'ovinx' ); ?>">
        <span class="tf-text-clear">
            <i class="icon icon-Close"></i>
        </span>
        <span class="tf-text-search">
            <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" aria-label="<?php esc_attr_e( 'Search', 'ovinx' ); ?>">
                <i class="icon icon-MagnifyingGlass"></i>
            </a>
        </span>
    </button>
</form>
