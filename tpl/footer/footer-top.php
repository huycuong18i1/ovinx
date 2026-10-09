<?php
$logo_site        = ! empty( themesflat_get_opt_elementor( 'site_logo' )['url'] )
    ? themesflat_get_opt_elementor( 'site_logo' )['url']
    : themesflat_get_opt( 'site_logo' );
$footer_description = themesflat_get_opt( 'footer_description' );
?>
<div class="footer-top order-xl-1">
    <div class="container">
        <div class="footer-top_wrap">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo-site">
                <?php if ( ! empty( $logo_site ) ) : ?>
                    <img loading="lazy" src="<?php echo esc_url( $logo_site ); ?>" alt="<?php bloginfo( 'name' ); ?>">
                <?php else : ?>
                    <?php bloginfo( 'name' ); ?>
                <?php endif; ?>
            </a>

            <?php if ( ! empty( $footer_description ) ) : ?>
                <p class="ft-text cl-text-mute"><?php echo wp_kses_post( $footer_description ); ?></p>
            <?php endif; ?>

            <?php themesflat_render_social(); ?>

            <span class="br-line bg-white_10 fake-class top-0"></span>
            <span class="br-line bg-white_10 fake-class bottom-0"></span>
        </div>
    </div>
</div>
