<?php
/**
 * My Account > Lost password (/my-account/lost-password/) — WooCommerce's own POST flow (field names/nonce kept), styled like the
 * Sign In / Forgot Password card in form-login.php. The in-page "Forgot Password" panel uses the AJAX handler instead; this
 * template is what WooCommerce shows for direct visits and for its own emails.
 *
 * @package ovinx
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_lost_password_form' );
?>
<div class="container">
	<div class="account-auth">
		<div class="account-auth__panel is-active">
			<div class="modal-heading text-center">
				<h2 class="title-pop h4"><?php esc_html_e( 'Forgot Password', 'ovinx' ); ?></h2>
				<p class="desc-pop"><?php echo wp_kses_post( apply_filters( 'woocommerce_lost_password_message', esc_html__( 'Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.', 'ovinx' ) ) ); ?></p>
			</div>
			<form method="post" class="woocommerce-ResetPassword lost_reset_password form-log">
				<div class="form-content">
					<fieldset class="tf-field">
						<label for="user_login" class="tf-lable"><?php esc_html_e( 'Username or email', 'ovinx' ); ?> <span class="text-primary">*</span></label>
						<input type="text" name="user_login" id="user_login" autocomplete="username" placeholder="<?php esc_attr_e( 'Username or email', 'ovinx' ); ?>" required aria-required="true">
					</fieldset>
					<?php do_action( 'woocommerce_lostpassword_form' ); ?>
				</div>
				<input type="hidden" name="wc_reset_password" value="true">
				<?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>
				<div class="group-action">
					<button type="submit" class="tf-btn w-100" value="<?php esc_attr_e( 'Reset password', 'ovinx' ); ?>"><?php esc_html_e( 'Reset password', 'ovinx' ); ?></button>
					<p class="orther-log text-center">
						<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="cl-text-main text-decoration-underline"><?php esc_html_e( 'Back To Login', 'ovinx' ); ?></a>
					</p>
				</div>
			</form>
		</div>
	</div>
</div>
<?php
do_action( 'woocommerce_after_lost_password_form' );
