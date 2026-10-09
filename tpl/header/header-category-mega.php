<?php
if ( ! class_exists( 'WooCommerce' ) ) {
    return;
}

$parent_categories = get_terms( array(
    'taxonomy'   => 'product_cat',
    'orderby'    => 'name',
    'order'      => 'ASC',
    'hide_empty' => false,
    'parent'     => 0,
) );

if ( empty( $parent_categories ) || is_wp_error( $parent_categories ) ) {
    return;
}
?>
<div class="nav-category-wrap xl-d-none main-action-active">
    <div class="btn-nav-drop btn-active">
        <i class="icon icon-SquaresFour"></i>
        <span class="lh-24"><?php echo esc_html( themesflat_get_opt( 'header_category_title' ) ); ?></span>
    </div>

    <ul class="box-nav-category active-item">
        <?php foreach ( $parent_categories as $cat ) :
            $children = get_terms( array(
                'taxonomy'   => 'product_cat',
                'orderby'    => 'name',
                'order'      => 'ASC',
                'hide_empty' => false,
                'parent'     => $cat->term_id,
            ) );
            $has_children = ! empty( $children ) && ! is_wp_error( $children );
        ?>
            <li class="<?php echo esc_attr( $has_children ? 'has-sub-nav-category' : '' ); ?>">
                <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" class="nav-category_link">
                    <span class="text"><?php echo esc_html( $cat->name ); ?></span>
                    <?php if ( $has_children ) : ?>
                        <i class="icon icon-CaretRight"></i>
                    <?php endif; ?>
                </a>

                <?php if ( $has_children ) : ?>
                    <div class="sub-nav-category">
                        <div class="tf-grid-layout tf-col-3">
                            <?php foreach ( $children as $child ) :
                                $grandchildren = get_terms( array(
                                    'taxonomy'   => 'product_cat',
                                    'orderby'    => 'name',
                                    'order'      => 'ASC',
                                    'hide_empty' => false,
                                    'parent'     => $child->term_id,
                                ) );
                                $has_grandchildren = ! empty( $grandchildren ) && ! is_wp_error( $grandchildren );
                            ?>
                                <div class="sub-nav-category_list">
                                    <p class="sub-nav__title fw-semibold"><?php echo esc_html( $child->name ); ?></p>
                                    <?php if ( $has_grandchildren ) : ?>
                                        <?php foreach ( $grandchildren as $grandchild ) : ?>
                                            <a href="<?php echo esc_url( get_term_link( $grandchild ) ); ?>" class="sub-nav__link link-underline link">
                                                <?php echo esc_html( $grandchild->name ); ?>
                                            </a>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <a href="<?php echo esc_url( get_term_link( $child ) ); ?>" class="sub-nav__link link-underline link">
                                            <?php echo esc_html( $child->name ); ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
