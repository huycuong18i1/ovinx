;(function($) {
    "use strict";

    // Only options whose value changes server-rendered markup need a preview reload;
    // pure CSS options (colors, padding, ...) are live-previewed by Elementor itself.
    var reloadOptions = [
        // TF Header
        'show_promo_bar',
        'promo_bar_position',
        'topbar_show',
        'topbar_items_left',
        'topbar_items_center',
        'topbar_items_right',
        'style_header',
        'site_logo',
        'header_sticky',
        'header_search_box_form',
        'show_header_category',
        'header_cart_icon',
        'header_wishlist_icon',
        'header_compare_icon',
        'header_login',
        // TF Page
        'page_sidebar_layout',
        // TF Page Title
        'page_title_description',
        'page_title_alignment'
    ];

    jQuery(document).ready(function(){
        reloadOptions.forEach(function (option) {
            elementor.settings.page.addChangeCallback( option, handleReloadPreview );
        });
    });

    function handleReloadPreview ( newValue ) {
        elementor.saver.saveEditor({
            status: elementor.settings.page.model.get('post_status'),
            onSuccess: () => {
                elementor.reloadPreview();

                elementor.once("preview:loaded", function() {
                    elementor.getPanelView().setPage("page_settings");
                });
            }
        })
    }

})(jQuery);
