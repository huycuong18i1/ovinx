<?php
/**
 * My Account > Lost password — "e-mail sent" screen, styled like the other guest cards.
 *
 * @package ovinx
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_lost_password_confirmation_message' );
?>
<div class="container">
	<div class="account-auth">
		<div class="account-auth__panel is-active text-center">
			<div class="modal-heading text-center">
				<h2 class="title-pop h4"><?php esc_html_e( 'Check Your Email', 'ovinx' ); ?></h2>
				<p class="desc-pop"><?php esc_html_e( 'Password reset email has been sent.', 'ovinx' ); ?></p>
			</div>
			<p><?php echo esc_html( apply_filters( 'woocommerce_lost_password_confirmation_message', esc_html__( 'A password reset email has been sent to the email address on file for your account, but may take several minutes to show up in your inbox. Please wait at least 10 minutes before attempting another reset.', 'ovinx' ) ) ); ?></p>
			<div class="form-log">
				<div class="group-action mt-20">
					<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="tf-btn w-100"><?php esc_html_e( 'Back To Login', 'ovinx' ); ?></a>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
do_action( 'woocommerce_after_lost_password_confirmation_message' );
