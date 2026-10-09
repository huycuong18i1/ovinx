
<?php

global $wp_query;

$count = isset( $wp_query->found_posts ) ? $wp_query->found_posts : 0;

?>


<div class="offcanvas offcanvas-start canvas-sidebar canvas-filter tf-filter-sidebar-shop" id="filterShop" aria-modal="true" role="dialog">
            <div class="canvas-wrapper">
                <div class="canvas-header">
                    <h5 class="h5 title">
                        <?php echo esc_html__('Filters','ovinx')?>
                    </h5>
                    <div class="icon-Close icon-close-popup cl-text-main cs-pointer fs-20 link-rotate" data-bs-dismiss="offcanvas" aria-label="Close"></div>
                </div>
                <div class="canvas-body">
                    <div class="meta-filter-shop tf-hidden-xl-min">
                        <div id="product-count-grid-mobile" class="count-text-total tf-hidden-xl-min">
                            <?php echo sprintf( _n( 'A total of <span class="count-number">%s</span> result', 'A total of <span class="count-number">%s</span> results', $count ?? 0, 'ovinx' ), number_format_i18n($count) ); ?>
                        </div>
                        <div id="product-count-grid" class="count-text"></div>
                        <div id="applied-filters" class="selected-filters w-100"></div>
                        <button id="reset-filter" class="btn-check-none remove-all-filters">
                            <i class="icon icon-Close2"></i>
                            <span class=""><?php _e('Clear all', 'ovinx'); ?></span>
                        </button>
                    </div>
                    <?php
                        dynamic_sidebar('shop-sidebar');
                        dynamic_sidebar('after-shop-sidebar');
                    ?>
                </div>
                <?php if( themesflat_get_opt('filter_sidebar_button') || !empty($_GET['filter_sidebar_button']) ) : ?>
                    <div class="canvas-bottom">
                        <button id="tf-reset-filter" class="tf-btn btn-reset tf-clear-filters-btn btn-white">
                            <span class="fw-medium"><?php _e('CLEAR ALL', 'ovinx'); ?></span>
                        </button>
                        <button type="button" class="tf-btn btn-fill animate-btn tf-apply-filters-btn">
                            <span class="fw-medium">
                                <?php _e('APPLY', 'ovinx'); ?>
                                <span class="apply-filter-count">[<?php echo esc_html($count); ?>]</span>
                            </span>
                        </button>
                    </div>
                <?php endif; ?>
            </div>
</div>
