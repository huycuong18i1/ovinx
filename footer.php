<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package ovinx
 */
?>        
        </div><!-- #content -->
    </main><!-- #main-content -->


    <?php
    
    $class_bt = '';
    if ( class_exists( 'WooCommerce' ) && is_product() ) {
        global $product;
        if( $product->is_type( 'external' ) || $product->is_type( 'grouped' ) || $product->is_type( 'bundle' ) || $product->is_type( 'composite' ) ) {
            $class_bt = '';
        } else
        if ( $product->is_type( 'simple' ) && ! $product->is_in_stock() ) {
            $class_bt = '';
        } else {
            $class_bt = 'footer-pb-2';
        }
        
    }
    ?>

    <?php get_template_part( 'tpl/footer/newsletter' ); ?>

        <!-- Footer -->
    <footer id="footer" class="tf-footer footer-v1 bg-primary-2 d-xl-flex flex-column footer_background <?php if (themesflat_get_opt('show_navigation_bar') == 1) {echo 'xl-pb-70 ' ;} ; echo esc_attr($class_bt) . ' ' ; echo esc_attr( themesflat_get_opt_elementor('extra_classes_footer') ); ?> ">
        <div class="overlay-footer"></div>

        <?php get_template_part( 'tpl/footer/footer-top'); ?>
        <?php get_template_part( 'tpl/footer/footer-widgets'); ?>
        <?php get_template_part( 'tpl/footer/bottom'); ?>
    </footer>
    <!-- /.Footer -->


</div><!-- /#boxed -->
<?php wp_footer(); ?>
</body>
</html>

