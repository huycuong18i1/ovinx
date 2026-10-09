jQuery(document).ready(function ($) {
	var tfwc_hide_rule_field = function() {
		var selected = jQuery('#tfwc_template_type').val() || 'none';
		jQuery( '.tfwc-options-table' ).removeClass().addClass( 'tfwc-options-table widefat tfwc-selected-template-type-' + selected );
	}

	jQuery(document).on( 'change', '#tfwc_template_type', function( e ) {
		tfwc_hide_rule_field();
	});

	tfwc_hide_rule_field();
});
