<?php if(themesflat_get_opt('footer_top') == 1) {
    $footer_top_category_arr = themesflat_get_opt('footer_top_category_arr');
    $footer_swiper_json = json_decode($footer_top_category_arr, true);
?>

<div class="footer-top">
    <div class="container">
        <ul class="category-list justify-content-xl-center">
            <?php
                if (!empty($footer_swiper_json)) {
                foreach ($footer_swiper_json as $field) {
            ?>
                <li>
                    <a href="<?php echo esc_attr( empty($field['link']) ? '' : $field['link'] ); ?>" class="tf-btn btn-line has-icon link">
                        <span class="text h6 text-uppercase fw-normal"><?php echo esc_html( empty($field['text']) ? '' : $field['text'] ); ?></span>
                        <i class="icon icon-arrow-top-right"></i>
                    </a>
                </li>
            <?php
                    }
                }
            ?>
        </ul>
    </div>
</div>

<?php } ?>