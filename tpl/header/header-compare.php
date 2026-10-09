<?php
// Compare Icon
if ( class_exists( 'WCBoost\ProductsCompare\Plugin' ) ) :
    $compare_count = wcboost_products_compare()->list->count_items();
?>
    <li class="d-none d-sm-block">
        <a href="<?php echo esc_url( wc_get_page_permalink( 'compare' ) ); ?>" class="nav-icon-item link" aria-label="<?php esc_attr_e( 'Compare', 'ovinx' ); ?>">
            <i class="icon icon-ArrowsLeftRight"></i>
        </a>
    </li>
<?php endif; ?>
