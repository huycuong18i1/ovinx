<?php
        wp_nav_menu( array(
            'theme_location' => 'topbar', 
            'container'   => false,
            'menu_class'  => 'topbar-nav-menu',
            'fallback_cb' => 'themesflat_menu_fallback', 
        ) );
?>