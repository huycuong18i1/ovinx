<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

if(themesflat_get_opt('tf_trust_seal')){
    $seal_text = themesflat_get_opt('tf_trust_seal_text');

    $seal_items = themesflat_get_opt('tf_trust_seal_items');
    if( empty( $seal_items ) ){
        return;
    }
    $seal_items = ! is_array( $seal_items ) ? explode( ',', $seal_items ) : $seal_items;
}else{
    return;
}

?>

<div class="tf-product-trust-seal">
    <p class="h6 text-seal">
        <i class="icon icon-ShieldCheck"></i>
        <?php echo esc_html($seal_text); ?>
    </p>
    <ul class="list-card">
        <?php
        foreach ( $seal_items as $image_url ) {
            ?>
            <li class="card-item">
                <img width="50" height="32" src="<?php echo esc_url( $image_url ); ?>" alt="card">
            </li>
        <?php } ?>
    </ul>
</div>