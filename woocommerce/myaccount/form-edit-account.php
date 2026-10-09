<?php
/**
 * Edit account form — matches ovinx-html's account-setting.html layout (`.account-my_address.setting`,
 * `.form-content`/`.tf-grid-layout`/`.tf-field`, real CSS in css/styles.css) using ONLY WooCommerce's
 * real account fields (first/last/display name, email, password). Ground truth's avatar/gender/DOB/phone
 * fields have no WC equivalent — building those is new functionality, not a style fix, so they're
 * intentionally left out here.
 *
 * @package ovinx
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_edit_account_form' );
?>

<h4 class="account-title"><?php esc_html_e( 'Account Details', 'ovinx' ); ?></h4>

<div class="account-my_address setting">
	<form class="woocommerce-EditAccountForm edit-account form-setting" action="" method="post" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?>>
		<?php do_action( 'woocommerce_edit_account_form_start' ); ?>

		<div class="form-content gap-xl-24">
			<div class="tf-grid-layout sm-col-2">
				<fieldset class="tf-field">
					<label for="account_first_name" class="tf-lable cl-text-main fw-medium"><?php esc_html_e( 'First Name', 'ovinx' ); ?> <span class="text-primary">*</span></label>
					<input type="text" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr( $user->first_name ); ?>" placeholder="<?php esc_attr_e( 'First Name', 'ovinx' ); ?>" required>
				</fieldset>
				<fieldset class="tf-field">
					<label for="account_last_name" class="tf-lable cl-text-main fw-medium"><?php esc_html_e( 'Last Name', 'ovinx' ); ?> <span class="text-primary">*</span></label>
					<input type="text" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr( $user->last_name ); ?>" placeholder="<?php esc_attr_e( 'Last Name', 'ovinx' ); ?>" required>
				</fieldset>
			</div>
			<div class="tf-grid-layout sm-col-2">
				<fieldset class="tf-field">
					<label for="account_email" class="tf-lable cl-text-main fw-medium"><?php esc_html_e( 'Email', 'ovinx' ); ?> <span class="text-primary">*</span></label>
					<input type="email" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr( $user->user_email ); ?>" placeholder="<?php esc_attr_e( 'Email', 'ovinx' ); ?>" required>
				</fieldset>
				<fieldset class="tf-field">
					<label for="account_display_name" class="tf-lable cl-text-main fw-medium"><?php esc_html_e( 'Display Name', 'ovinx' ); ?> <span class="text-primary">*</span></label>
					<input type="text" name="account_display_name" id="account_display_name" value="<?php echo esc_attr( $user->display_name ); ?>" placeholder="<?php esc_attr_e( 'Display Name', 'ovinx' ); ?>" required>
				</fieldset>
			</div>

			<?php do_action( 'woocommerce_edit_account_form_fields' ); ?>
		</div>

		<div>
			<p class="h5 mb-20"><?php esc_html_e( 'Change Password', 'ovinx' ); ?></p>
			<div class="form-content gap-xl-24">
				<fieldset class="tf-field password-wrapper">
					<label for="password_current" class="tf-lable cl-text-main fw-medium"><?php esc_html_e( 'Current Password', 'ovinx' ); ?></label>
					<div class="password-wrapper w-100">
						<span class="toggle-pass icon icon-EyeSlash"></span>
						<input class="password-field" type="password" name="password_current" id="password_current" autocomplete="current-password" placeholder="<?php esc_attr_e( 'Current Password', 'ovinx' ); ?>">
					</div>
				</fieldset>
				<fieldset class="tf-field password-wrapper">
					<label for="password_1" class="tf-lable cl-text-main fw-medium"><?php esc_html_e( 'New Password', 'ovinx' ); ?></label>
					<div class="password-wrapper w-100">
						<span class="toggle-pass icon icon-EyeSlash"></span>
						<input class="password-field" type="password" name="password_1" id="password_1" autocomplete="new-password" placeholder="<?php esc_attr_e( 'New Password', 'ovinx' ); ?>">
					</div>
				</fieldset>
				<fieldset class="tf-field password-wrapper">
					<label for="password_2" class="tf-lable cl-text-main fw-medium"><?php esc_html_e( 'Confirm New Password', 'ovinx' ); ?></label>
					<div class="password-wrapper w-100">
						<span class="toggle-pass icon icon-EyeSlash"></span>
						<input class="password-field" type="password" name="password_2" id="password_2" autocomplete="new-password" placeholder="<?php esc_attr_e( 'Confirm New Password', 'ovinx' ); ?>">
					</div>
				</fieldset>
			</div>
		</div>

		<?php do_action( 'woocommerce_edit_account_form' ); ?>

		<div class="btn-submit">
			<?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
			<button type="submit" class="tf-btn px-v1" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'ovinx' ); ?>"><?php esc_html_e( 'Save Change', 'ovinx' ); ?></button>
			<input type="hidden" name="action" value="save_account_details">
		</div>

		<?php do_action( 'woocommerce_edit_account_form_end' ); ?>
	</form>
</div>

<?php do_action( 'woocommerce_after_edit_account_form' ); ?>
