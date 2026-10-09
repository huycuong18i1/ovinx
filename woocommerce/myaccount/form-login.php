<?php
/**
 * My Account — what a logged-out visitor sees: Sign In / Create Account / Forgot Password in one card.
 *
 * Same markup vocabulary as the header popups (plugins/ovinx-addon/woocommerce/templates/user/{login,register,reset-password}.php,
 * which follow ovinx-html's 404.html #login/#register/#modalForgot): .modal-heading, .form-log, .tf-field, .field-bottom,
 * .group-action, .password-wrapper. The three forms use the SAME AJAX handlers as the popups (ovinx-addon user.js binds by
 * class: .tfwc-custom-login-form / .tfwc-custom-register-form / .tfwc-resset-password), so they behave identically.
 * Panels switch client-side (js/main.js accountAuthPanels(), [data-auth-show]); without JS the Sign In panel still works
 * (the form falls back to a normal POST-less no-op, so JS is required for the AJAX handlers — same as the popups).
 *
 * @package ovinx
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_customer_login_form' );

$opt = function ( $key, $default = '' ) {
	return function_exists( 'themesflat_get_opt' ) ? themesflat_get_opt( $key ) : $default;
};

$enable_fb       = $opt( 'enable_login_fb' );
$enable_gg       = $opt( 'enable_login_gg' );
$register_policy = $opt( 'register_policy' );

// Social sign-in URLs (same sources as the popup templates).
global $google_client;
$login_google_url = ( is_object( $google_client ) && method_exists( $google_client, 'tfwc_get_authorization_url' ) ) ? $google_client->tfwc_get_authorization_url() : '';

$login_facebook_url = 'https://www.facebook.com/v15.0/dialog/oauth?' . http_build_query(
	array(
		'client_id'     => $opt( 'facebook_login_client_id' ),
		'redirect_uri'  => home_url(),
		'scope'         => 'email',
		'state'         => '',
		'response_type' => 'code',
	)
);

$show_fb = $enable_fb && '' !== (string) $opt( 'facebook_login_client_id' );
$show_gg = $enable_gg && '' !== $login_google_url;

$social = function ( $label ) use ( $show_fb, $show_gg, $login_facebook_url, $login_google_url ) {
	if ( ! $show_fb && ! $show_gg ) {
		return;
	}
	?>
	<div class="text-center">
		<p class="text-caption-01 cl-text-mute mb-12"><?php echo esc_html( $label ); ?></p>
		<div class="d-flex flex-column gap-12">
			<?php if ( $show_fb ) : ?>
				<a href="<?php echo esc_url( $login_facebook_url ); ?>" class="tf-btn style-stroke w-100 animate-btn">
					<span class="icon"><img loading="lazy" width="24" height="24" src="<?php echo esc_url( THEMESFLAT_LINK . 'images/logo/face.svg' ); ?>" alt=""></span>
					<?php esc_html_e( 'Facebook', 'ovinx' ); ?>
				</a>
			<?php endif; ?>
			<?php if ( $show_gg ) : ?>
				<a href="<?php echo esc_url( $login_google_url ); ?>" class="tf-btn style-stroke w-100 animate-btn">
					<span class="icon"><img loading="lazy" width="24" height="24" src="<?php echo esc_url( THEMESFLAT_LINK . 'images/logo/google.svg' ); ?>" alt=""></span>
					<?php esc_html_e( 'Google', 'ovinx' ); ?>
				</a>
			<?php endif; ?>
		</div>
	</div>
	<?php
};

$redirect = wc_get_page_permalink( 'myaccount' );
?>
<div class="container">
	<div class="account-auth" data-account-auth>

		<?php // ---------------------------------------------------------------- Sign In ?>
		<div class="account-auth__panel is-active" data-auth-panel="login">
			<div class="modal-heading text-center">
				<h2 class="title-pop h4"><?php esc_html_e( 'Sign In', 'ovinx' ); ?></h2>
				<p class="desc-pop"><?php esc_html_e( 'Sign in to access your personalized experience.', 'ovinx' ); ?></p>
			</div>
			<form method="post" class="tfwc-custom-login-form form-log" novalidate>
				<div class="form-content">
					<div class="tfwc-message" aria-live="polite"></div>
					<fieldset class="tf-field">
						<label for="acc-login-user" class="tf-lable"><?php esc_html_e( 'Username or email address', 'ovinx' ); ?> <span class="text-primary">*</span></label>
						<input type="text" name="username" id="acc-login-user" autocomplete="username" placeholder="<?php esc_attr_e( 'Username or email address*', 'ovinx' ); ?>" required>
					</fieldset>
					<fieldset class="tf-field">
						<label for="acc-login-pass" class="tf-lable"><?php esc_html_e( 'Password', 'ovinx' ); ?> <span class="text-primary">*</span></label>
						<div class="password-wrapper w-100">
							<span class="toggle-pass icon icon-EyeSlash" role="button" tabindex="0" aria-label="<?php esc_attr_e( 'Show password', 'ovinx' ); ?>"></span>
							<input class="password-field" type="password" name="password" id="acc-login-pass" autocomplete="current-password" placeholder="<?php esc_attr_e( 'Password', 'ovinx' ); ?>" required>
						</div>
					</fieldset>
					<fieldset class="field-bottom">
						<div class="checkbox-wrap">
							<input id="acc-remember" type="checkbox" class="tf-check" name="remember" value="1">
							<label for="acc-remember"><?php esc_html_e( 'Remember me', 'ovinx' ); ?></label>
						</div>
						<a href="#forgot" data-auth-show="forgot" class="link"><?php esc_html_e( 'Forgot Your Password?', 'ovinx' ); ?></a>
					</fieldset>
					<?php $social( __( 'or sign in with', 'ovinx' ) ); ?>
				</div>
				<input type="hidden" name="redirect" value="<?php echo esc_url( $redirect ); ?>">
				<div class="group-action">
					<button type="submit" class="tf-btn w-100"><?php esc_html_e( 'Login', 'ovinx' ); ?></button>
					<a href="#register" data-auth-show="register" class="tf-btn style-stroke"><?php esc_html_e( 'Create Account', 'ovinx' ); ?></a>
				</div>
			</form>
		</div>

		<?php // ---------------------------------------------------------------- Create Account ?>
		<div class="account-auth__panel" data-auth-panel="register" hidden>
			<div class="modal-heading text-center">
				<h2 class="title-pop h4"><?php esc_html_e( 'Create Account', 'ovinx' ); ?></h2>
				<p class="desc-pop"><?php esc_html_e( 'Be part of our growing family of new customers!', 'ovinx' ); ?></p>
			</div>
			<form method="post" class="tfwc-custom-register-form form-log" novalidate>
				<div class="form-content">
					<div class="tfwc-message" aria-live="polite"></div>
					<fieldset class="tf-field">
						<label for="acc-reg-user" class="tf-lable"><?php esc_html_e( 'Username', 'ovinx' ); ?> <span class="text-primary">*</span></label>
						<input type="text" name="username" id="acc-reg-user" autocomplete="username" placeholder="<?php esc_attr_e( 'Username', 'ovinx' ); ?>" required>
					</fieldset>
					<fieldset class="tf-field">
						<label for="acc-reg-email" class="tf-lable"><?php esc_html_e( 'Email', 'ovinx' ); ?> <span class="text-primary">*</span></label>
						<input type="email" name="email" id="acc-reg-email" autocomplete="email" placeholder="<?php esc_attr_e( 'Email', 'ovinx' ); ?>" required>
					</fieldset>
					<fieldset class="tf-field">
						<label for="acc-reg-pass" class="tf-lable"><?php esc_html_e( 'Password', 'ovinx' ); ?> <span class="text-primary">*</span></label>
						<div class="password-wrapper w-100">
							<span class="toggle-pass icon icon-EyeSlash" role="button" tabindex="0" aria-label="<?php esc_attr_e( 'Show password', 'ovinx' ); ?>"></span>
							<input class="password-field" type="password" name="password" id="acc-reg-pass" autocomplete="new-password" placeholder="<?php esc_attr_e( 'Password', 'ovinx' ); ?>" required>
						</div>
					</fieldset>
					<fieldset class="tf-field">
						<label for="acc-reg-pass2" class="tf-lable"><?php esc_html_e( 'Confirm password', 'ovinx' ); ?> <span class="text-primary">*</span></label>
						<div class="password-wrapper w-100">
							<span class="toggle-pass icon icon-EyeSlash" role="button" tabindex="0" aria-label="<?php esc_attr_e( 'Show password', 'ovinx' ); ?>"></span>
							<input class="password-field" type="password" name="password2" id="acc-reg-pass2" autocomplete="new-password" placeholder="<?php esc_attr_e( 'Confirm Password', 'ovinx' ); ?>" required>
						</div>
					</fieldset>
					<?php if ( ! empty( $register_policy ) ) : ?>
						<fieldset class="field-bottom">
							<div class="checkbox-wrap">
								<input id="acc-agree" type="checkbox" class="tf-check" required>
								<label for="acc-agree" class="text-caption-01"><?php echo wp_kses_post( $register_policy ); ?></label>
							</div>
						</fieldset>
					<?php endif; ?>
					<?php $social( __( 'or sign up with', 'ovinx' ) ); ?>
				</div>
				<div class="group-action">
					<button type="submit" class="tf-btn w-100"><?php esc_html_e( 'Create Account', 'ovinx' ); ?></button>
					<a href="#login" data-auth-show="login" class="tf-btn style-stroke"><?php esc_html_e( 'Login', 'ovinx' ); ?></a>
				</div>
			</form>
		</div>

		<?php // ---------------------------------------------------------------- Forgot Password ?>
		<div class="account-auth__panel" data-auth-panel="forgot" hidden>
			<div class="modal-heading text-center">
				<h2 class="title-pop h4"><?php esc_html_e( 'Forgot Password', 'ovinx' ); ?></h2>
				<p class="desc-pop"><?php esc_html_e( 'Enter the e-mail address associated with your account. Click submit to have a password reset link e-mailed to you.', 'ovinx' ); ?></p>
			</div>
			<form method="post" class="tfwc-resset-password form-reset form-log" novalidate>
				<div class="form-content">
					<fieldset class="tf-field">
						<label for="acc-forgot-login" class="tf-lable"><?php esc_html_e( 'Your Email Address', 'ovinx' ); ?> <span class="text-primary">*</span></label>
						<input type="text" name="user_login" id="acc-forgot-login" autocomplete="username" placeholder="<?php esc_attr_e( 'Email or username', 'ovinx' ); ?>" required>
					</fieldset>
					<input type="hidden" name="action" value="reset_password_ajax">
					<input type="hidden" name="tfwc_security_reset_password" value="<?php echo esc_attr( wp_create_nonce( 'tfwc_reset_password_ajax_nonce' ) ); ?>">
					<div class="tfwc_messages_reset_password" aria-live="polite"></div>
				</div>
				<div class="group-action">
					<button type="submit" class="tf-btn w-100"><?php esc_html_e( 'Send Reset Link', 'ovinx' ); ?></button>
					<p class="orther-log text-center">
						<a href="#login" data-auth-show="login" class="cl-text-main text-decoration-underline"><?php esc_html_e( 'Back To Login', 'ovinx' ); ?></a>
					</p>
				</div>
			</form>
		</div>

	</div>
</div>
<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
