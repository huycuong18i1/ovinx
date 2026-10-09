<?php
/**
 * My Account > Reset password (the page the reset-link e-mail opens) — WooCommerce's own POST flow (field names/nonce kept),
 * styled like the Sign In card in form-login.php.
 *
 * @package ovinx
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_reset_password_form' );
?>
<div class="container">
	<div class="account-auth">
		<div class="account-auth__panel is-active">
			<div class="modal-heading text-center">
				<h2 class="title-pop h4"><?php esc_html_e( 'Reset Password', 'ovinx' ); ?></h2>
				<p class="desc-pop"><?php echo wp_kses_post( apply_filters( 'woocommerce_reset_password_message', esc_html__( 'Enter a new password below.', 'ovinx' ) ) ); ?></p>
			</div>
			<form method="post" class="woocommerce-ResetPassword lost_reset_password form-log">
				<div class="form-content">
					<fieldset class="tf-field">
						<label for="password_1" class="tf-lable"><?php esc_html_e( 'New password', 'ovinx' ); ?> <span class="text-primary">*</span></label>
						<div class="password-wrapper w-100">
							<span class="toggle-pass icon icon-EyeSlash" role="button" tabindex="0" aria-label="<?php esc_attr_e( 'Show password', 'ovinx' ); ?>"></span>
							<input class="password-field" type="password" name="password_1" id="password_1" autocomplete="new-password" placeholder="<?php esc_attr_e( 'New password', 'ovinx' ); ?>" required aria-required="true">
						</div>
					</fieldset>
					<fieldset class="tf-field">
						<label for="password_2" class="tf-lable"><?php esc_html_e( 'Re-enter new password', 'ovinx' ); ?> <span class="text-primary">*</span></label>
						<div class="password-wrapper w-100">
							<span class="toggle-pass icon icon-EyeSlash" role="button" tabindex="0" aria-label="<?php esc_attr_e( 'Show password', 'ovinx' ); ?>"></span>
							<input class="password-field" type="password" name="password_2" id="password_2" autocomplete="new-password" placeholder="<?php esc_attr_e( 'Re-enter new password', 'ovinx' ); ?>" required aria-required="true">
						</div>
					</fieldset>
					<?php do_action( 'woocommerce_resetpassword_form' ); ?>
				</div>
				<input type="hidden" name="reset_key" value="<?php echo esc_attr( $args['key'] ); ?>">
				<input type="hidden" name="reset_login" value="<?php echo esc_attr( $args['login'] ); ?>">
				<input type="hidden" name="wc_reset_password" value="true">
				<?php wp_nonce_field( 'reset_password', 'woocommerce-reset-password-nonce' ); ?>
				<div class="group-action">
					<button type="submit" class="tf-btn w-100" value="<?php esc_attr_e( 'Save', 'ovinx' ); ?>"><?php esc_html_e( 'Save', 'ovinx' ); ?></button>
				</div>
			</form>
		</div>
	</div>
</div>
<?php
do_action( 'woocommerce_after_reset_password_form' );
