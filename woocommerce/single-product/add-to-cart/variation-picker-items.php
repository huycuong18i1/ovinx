<?php
defined( 'ABSPATH' ) || exit;

$attribute_slug = str_replace('pa_', '', $attribute);
if( empty($options) ){
	return;
}
?>

<div class="variant-picker-item variant-<?php echo esc_attr( $attribute_slug ); ?>">
	<div class="d-flex justify-content-between variant-picker-label">
		<div>
			<?php echo wc_attribute_label( $attribute ); // WPCS: XSS ok. ?>:
			<span class="variant-picker-label-value value-currentColor"><?php echo wc_attribute_label($options[0]); ?></span>
		</div>
		<?php do_action('tf_size_guide_' . esc_attr( $attribute_slug ) ); ?>
	</div>
	<div class="variant-picker-values">
		<?php foreach ( $options as $key => $option ) : ?>
			<?php if ($attribute_slug == 'color') : ?>
				<div class="hover-tooltip tooltip-bot <?php echo esc_attr( $attribute_slug ); ?>-btn <?php echo esc_attr($key == 0 ? 'active' : ''); ?>" data-<?php echo esc_attr( $attribute_slug ); ?>="<?php echo esc_attr( $option ); ?>">
				<span class="check-<?php echo esc_attr( $attribute_slug ); ?>" style="background-color:<?php echo esc_attr( $option ); ?>"></span>
				<span class="tooltip"><?php echo ucfirst( wc_attribute_label( $option ) );?></span>
			</div>
			<?php else: ?>
				<span class="<?php echo esc_attr( $attribute_slug ); ?>-btn <?php echo esc_attr($key == 0 ? 'active' : ''); ?>" data-<?php echo esc_attr( $attribute_slug ); ?>="<?php echo esc_attr( $option ); ?>"><?php echo ucfirst( wc_attribute_label( $option ) );?></span>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
</div>