<div class="footer-inner order-xl-0 position-relative <?php (themesflat_meta( 'footer_class' ) != "" ? esc_attr( themesflat_meta( 'footer_class' ) ):'') ;?>">
        <div class="container">
            <div class="footer-inner_wrap">
                <div class="footer-col-block footer-contact">
                    <?php get_template_part( 'tpl/footer/footer-contact' ); ?>
                </div>
                <?php
                    for ( $key = 2; $key <= 4; $key++ ) {
                        $widget = themesflat_get_opt( "footer" . $key );
                        themesflat_dynamic_sidebar( $widget );
                    }
                ?>
            </div>
        </div>
    </div>
