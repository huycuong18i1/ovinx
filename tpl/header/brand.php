<?php
$logo_style = themesflat_get_opt('logo_style');


$logo_site = !empty(themesflat_get_opt_elementor('site_logo')['url'])
    ? themesflat_get_opt_elementor('site_logo')['url']
    : themesflat_get_opt('site_logo');

$logo_text = themesflat_get_opt('logo_text');


$header_style = $args['header_style'] ?? 'header_default';

if ( $logo_style == 'image' ) : ?>
    <div id="logo" class="logo-header">
             
        <a href="<?php echo esc_url( home_url('/') ); ?>" class="logo-site"  title="<?php bloginfo('name'); ?>">
            <?php if  (!empty($logo_site)) { ?>
                <img class="site-logo logo logo-default"  src="<?php echo esc_url($logo_site); ?>" alt="<?php bloginfo('name'); ?>"/>
            <?php } else { ?>
                <?php if ($header_style == 'header_default') { ?>
                 <img class="site-logo logo logo-default"  src="<?php echo esc_url(THEMESFLAT_LINK . 'images/logo-white.svg') ?>" alt="<?php bloginfo('name'); ?>"/>
                <?php } else { ?>
                <img class="site-logo logo logo-default"  src="<?php echo esc_url(THEMESFLAT_LINK . 'images/logo.svg') ?>" alt="<?php bloginfo('name'); ?>"/>
            <?php   
                } 
            } ?>
        </a>
    </div>
<?php else : ?>
    <div id="logo" class="logo-header">
    	<h1 class="site-title"><a href="<?php echo esc_url( home_url('/') ); ?>" rel="home"><?php if ($logo_text == '') { bloginfo( 'name' ); } else { echo esc_attr($logo_text) ; } ; ?></a></h1>
    </div><!-- /.site-infomation -->          
<?php endif; ?>