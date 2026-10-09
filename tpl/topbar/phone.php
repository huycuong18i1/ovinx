<?php 
$information_phone = themesflat_get_opt('information_phone');
if (!empty($information_phone)) { ?>
<div class="item phone">
    <a href="tel:<?php echo esc_attr($information_phone);?>" class="text-caption-01  link"><?php echo esc_html($information_phone);?></a>
</div>
<?php } ?>