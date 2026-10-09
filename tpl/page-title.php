<?php 
if ( ( is_page() && is_page_template( 'tpl/front-page.php' ) ) || is_404() ) {
    return;
}

$titles = themesflat_get_page_titles();
ob_start();
if ( $titles['title'] ) { printf( '%s', wp_kses_post($titles['title']) ); }
$title = ob_get_clean();


?>
<!-- Page title -->
<?php
$page_title_heading = themesflat_get_opt('page_title_heading_enabled');
$breadcrumb = themesflat_get_opt('breadcrumb_enabled');

$page_title_alignment = themesflat_get_opt('page_title_alignment');

$page_title_count = themesflat_get_opt('page_title_count');

$page_title_description = themesflat_get_opt('page_title_description');
if (themesflat_get_opt_elementor('page_title_description') != '') {
    $page_title_description = themesflat_get_opt_elementor('page_title_description');
}

$page_title_description_content = themesflat_get_opt('page_title_description_content');
if (themesflat_get_opt_elementor('page_title_description_content') != '') {
    $page_title_description_content = themesflat_get_opt_elementor('page_title_description_content');
}

$page_title_alignment = themesflat_get_opt('page_title_alignment');
if (themesflat_get_opt_elementor('page_title_alignment') != '') {
    $page_title_alignment = themesflat_get_opt_elementor('page_title_alignment');
}

$single_navigation = themesflat_get_opt('single_navigation');
$page_title_class = '';

$is_single = false;

$is_single = false;

$wishlist_desc = '';
$compare_desc  = '';
$cart_desc     = '';
$checkout_desc = '';

if ( class_exists( 'WooCommerce' ) ) {

    $is_product_page = function_exists( 'is_product' ) && is_product();

    $is_shop_page = function_exists( 'is_shop' ) && is_shop();

    $is_product_category_page =
        function_exists( 'is_product_category' ) &&
        is_product_category();

    $is_cart_page =
        function_exists( 'is_cart' ) &&
        is_cart();

    $is_checkout_page =
        function_exists( 'is_checkout' ) &&
        is_checkout();

    $is_wishlist_page =
        class_exists( 'WCBoost\Wishlist\Helper', false ) &&
        method_exists( 'WCBoost\Wishlist\Helper', 'is_wishlist' ) &&
        \WCBoost\Wishlist\Helper::is_wishlist();

    $is_compare_page =
        class_exists( 'WCBoost\ProductsCompare\Helper', false ) &&
        method_exists( 'WCBoost\ProductsCompare\Helper', 'is_compare_page' ) &&
        \WCBoost\ProductsCompare\Helper::is_compare_page();

    $is_account_page = function_exists( 'is_account_page' ) && is_account_page();

    if ( $is_product_page ) {

        $is_single = true;

        $page_title_heading = themesflat_get_opt(
            'page_title_heading_woo_single'
        );

        $breadcrumb = themesflat_get_opt(
            'breadcrumb_woo_single'
        );

        // Product pages never print a description under the title (ovinx-html has none; the output below is
        // guarded by !is_singular('product')) — so the old "Description" options were removed from the Customizer.
        $page_title_description = 0;

        $page_title_description_content = '';

        $page_title_class = 'tfwc-page-title';

    } elseif ( $is_shop_page || $is_product_category_page ) {

        $is_single = false;

        $breadcrumb = themesflat_get_opt(
            'breadcrumb_woo'
        );

        $page_title_heading = themesflat_get_opt(
            'page_title_heading_woo'
        );

        $page_title_text_btn = themesflat_get_opt(
            'page_title_text_btn'
        );

        $page_title_alignment = themesflat_get_opt(
            'page_title_alignment_woo'
        );

        $page_title_description = themesflat_get_opt(
            'page_title_description_woo'
        );

        $page_title_description_content = themesflat_get_opt(
            'page_title_description_content_shop'
        );

        if ( $is_product_category_page ) {
            $term = get_queried_object();

            if (
                $term instanceof WP_Term &&
                ! empty( $term->description )
            ) {
                $page_title_description_content = $term->description;
            }
        }

        $page_title_class = 'tfwc-page-title';

    } elseif (
        $is_cart_page ||
        $is_checkout_page ||
        $is_wishlist_page ||
        $is_compare_page ||
        $is_account_page
    ) {

        $page_title_description = themesflat_get_opt(
            'page_title_description_woo'
        );

        $page_title_description_content = '';

        if ( $is_wishlist_page ) {
            $wishlist_desc = themesflat_get_opt(
                'page_title_description_content_wishlist'
            );
        }

        if ( $is_compare_page ) {
            $compare_desc = themesflat_get_opt(
                'page_title_description_content_compare'
            );
        }

        if ( $is_cart_page ) {
            $cart_desc = themesflat_get_opt(
                'page_title_description_content_cart'
            );
        }

        if ( $is_checkout_page ) {
            $checkout_desc = themesflat_get_opt(
                'page_title_description_content_checkout'
            );
        }
    }
}

$gallery_layout = empty($_GET['gallery_layout']) ? themesflat_get_opt('tf_product_gallery_layout') : $_GET['gallery_layout'];

if( function_exists('is_product') && is_product() && ( $gallery_layout == 'no_thumb' || $gallery_layout == 'middle_gallery') ){
    return;
}

$page_title_background_image = !empty(themesflat_get_opt_elementor('page_title_background_image')['url']) ? themesflat_get_opt_elementor('page_title_background_image')['url'] : themesflat_get_opt('page_title_background_image');

$class_single_post = '';
$blog_single_style = empty($_GET['blog_single_style']) ? themesflat_get_opt('blog_single_style') : $_GET['blog_single_style'];
if ( is_single() && get_post_type() === 'post' && $blog_single_style == 'default') {
    $class_single_post = 'single ';
}

$hide_pagetitle = "block";
if (themesflat_get_opt_elementor('hide_pagetitle') != '') {
    $hide_pagetitle = themesflat_get_opt_elementor('hide_pagetitle');
}

$class_header = '';
$style_header = themesflat_get_opt('style_header');
if (themesflat_get_opt_elementor('style_header') != '') {
    $style_header = themesflat_get_opt_elementor('style_header');
}
$header_full_width = themesflat_get_opt('header_full_width');
if (themesflat_get_opt_elementor('header_full_width') != '') {
    $header_full_width = themesflat_get_opt_elementor('header_full_width');
}
if ($style_header == 'header-01' && $header_full_width != 1) {
    $class_header = 'page-title-pd2';
}

$section_classes = '';
$page_title_classes = ' main-page-title';

if( function_exists('is_product') && is_product()){
    $section_classes .= ' section-page-title-single flat-spacing-3';
}else{
    $class_single_post .= ' tf-page-title';
}

?>
<?php if($hide_pagetitle == "block") { ?>
<section aria-label="<?php esc_attr_e( 'Page header', 'ovinx' ); ?>" class="section-page-title position-relative <?php echo esc_attr( $section_classes ); ?> <?php echo esc_attr( $class_single_post ); ?> <?php echo esc_attr( themesflat_get_opt_elementor('extra_classes_pagetitle') ); ?>  <?php echo esc_attr($page_title_class); ?>   <?php echo esc_attr($class_header); ?>" style="background:url('<?php echo esc_url($page_title_background_image); ?>') no-repeat left bottom / cover">
    <span class="br-line fake-class top-0"></span>
    <div class="container">
        <div class="page-title <?php echo esc_attr( $page_title_classes ); ?> <?php echo esc_attr($page_title_alignment); ?>">

            <div class="breadcrumbs <?php echo esc_attr($page_title_description != 1 ? 'no-desc' : ''); ?>">
                <?php 
                    if ( $breadcrumb  == 1 ):                 
                        themesflat_breadcrumb(); 
                    endif; 
                ?>

                <?php
                    global $wp_query;
                    $count_post = (!is_single() && $wp_query->found_posts > 1) ? $wp_query->found_posts : '';
                ?>

                <?php if ($page_title_heading == 1 && !is_singular('post')): ?>

                    <?php if ($page_title_count == 1 && !is_single()): ?>
                        <h1 class="h3"><?php echo wp_kses_post($title); ?> <span class="number-count"><?php echo wp_kses_post($count_post); ?></span></h1>
                    <?php else: ?>
                        <h1 class="h3"><?php echo wp_kses_post($title); ?></h1>
                    <?php endif; ?>

                <?php endif; ?>

 
            </div>

            <?php if ($page_title_description == 1 && !is_singular(['post', 'product'])): ?>
                <p class="text-body-02">
                    <?php echo wp_kses_post($page_title_description_content); ?>
                </p>
            <?php endif; ?>

            <?php if ( $page_title_description == 1 && !empty($wishlist_desc) ): ?>
                <p class="text-body-02">
                    <?php echo wp_kses_post($wishlist_desc); ?>
                </p>
            <?php endif; ?>

            <?php if ( $page_title_description == 1 && !empty($compare_desc) ): ?>
                <p class="text-body-02">
                    <?php echo wp_kses_post($compare_desc); ?>
                </p>
            <?php endif; ?>

            <?php if ( $page_title_description == 1 && !empty($cart_desc) ): ?>
                <p class="text-body-02">
                    <?php echo wp_kses_post($cart_desc); ?>
                </p>
            <?php endif; ?>

            <?php if ( $page_title_description == 1 && !empty($checkout_desc) ): ?>
                <p class="text-body-02">
                    <?php echo wp_kses_post($checkout_desc); ?>
                </p>
            <?php endif; ?>

            <?php if (is_singular('post')): ?>
                <div class="group-direc">
                    <?php $prev_post = get_previous_post(); ?>
                    <?php if ($prev_post): ?>
                        <a href="<?php echo esc_url( get_permalink($prev_post->ID) ); ?>" class="cl-text-main link">
                            <i class="icon icon-CaretLeft"></i>
                        </a>
                    <?php endif; ?>

                    <a href="<?php echo esc_url( get_post_type_archive_link('post') ); ?>" class="cl-text-main link">
                        <i class="icon icon-SquaresFour"></i>
                    </a>

                    <?php $next_post = get_next_post(); ?>
                    <?php if ($next_post): ?>
                        <a href="<?php echo esc_url( get_permalink($next_post->ID) ); ?>" class="cl-text-main link">
                            <i class="icon icon-CaretRight"></i>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php
                if( function_exists('is_product') && is_product() && class_exists('Woo_Single_Product_Hook') ){
                    Woo_Single_Product_Hook::instance()->tfwc_prev_next_product();
                }
            ?>
  
        </div>
    </div>
    
</section>
<?php } ?>