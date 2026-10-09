<?php
/**
 * The template for displaying comments — matches ovinx-html's blog-single.html
 * (`.wg-comment` list + `.wg-leave-comment` form).
 *
 * @package ovinx
 */

function themesflat_comments( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	?>
	<li <?php comment_class( 'comment-item' ); ?> id="li-comment-<?php comment_ID(); ?>">
		<div class="cmt_image">
			<?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, 60 ); ?>
		</div>
		<?php // id="comment-N" is what WP's comment-reply.js ("add_below") looks up to move the reply form under this comment, and what the post-submit redirect (#comment-N) scrolls to. ?>
		<div class="cmt_infor" id="comment-<?php comment_ID(); ?>">
			<p class="h6 infor__name lh-28">
				<?php echo esc_html( get_comment_author() ); ?>
			</p>
			<?php $rating = (int) get_comment_meta( get_comment_ID(), 'rating', true ); ?>
			<div class="d-flex align-items-center gap-8">
				<?php if ( $rating >= 1 && $rating <= 5 ) : ?>
					<div class="star-wrap">
						<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
							<i class="icon icon-Star<?php echo esc_attr( $i > $rating ? ' cl-text-mute' : '' ); ?>"></i>
						<?php endfor; ?>
					</div>
				<?php endif; ?>
				<p class="date-cmt">
					<?php // time(), not current_time('timestamp'): get_comment_time('U') is a real epoch, current_time('timestamp') is shifted by the site's UTC offset. ?>
					<?php echo esc_html( human_time_diff( get_comment_time( 'U' ), time() ) ); ?> <?php esc_html_e( 'ago', 'ovinx' ); ?>
				</p>
			</div>
			<?php // div, not p — comment_text() already outputs its own <p>. ?>
			<div class="infor__desc text-body-02 cl-text-main">
				<?php comment_text(); ?>
				<?php if ( '0' == $comment->comment_approved ) : ?>
					<span class="unapproved"><?php esc_html_e( 'Your comment is awaiting moderation.', 'ovinx' ); ?></span>
				<?php endif; ?>
			</div>
			<?php
			// No point replying to a comment that isn't public yet.
			if ( '0' != $comment->comment_approved ) {
				comment_reply_link( array_merge( $args, array(
					'depth'         => $depth,
					'max_depth'     => $args['max_depth'],
					'add_below'     => 'comment',
					'respond_id'    => 'wg-respond',
					'reply_text'    => esc_html__( 'Reply', 'ovinx' ),
					'reply_to_text' => esc_html__( 'Reply to %s', 'ovinx' ),
					'login_text'    => esc_html__( 'Log in to reply', 'ovinx' ),
				) ) );
			}
			?>
		</div>
	<?php
	// </li> is closed by wp_list_comments() via the walker's end_el.
}

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<?php if ( have_comments() ) : ?>
	<div class="wg-comment mb-20">
		<div class="heading d-flex align-items-center justify-content-between">
			<h5>
				<?php comments_number( esc_html__( '0 Comments', 'ovinx' ), esc_html__( '1 Comment', 'ovinx' ), esc_html__( '% Comments', 'ovinx' ) ); ?>
			</h5>
		</div>

		<ul class="list-comment">
			<?php wp_list_comments( array( 'callback' => 'themesflat_comments', 'style' => 'ul' ) ); ?>
		</ul>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<nav class="navigation comment-navigation" role="navigation">
				<h5 class="screen-reader-text section-heading"><?php esc_html_e( 'Comment navigation', 'ovinx' ); ?></h5>
				<div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'ovinx' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'ovinx' ) ); ?></div>
			</nav>
		<?php endif; ?>

		<?php if ( ! comments_open() && get_comments_number() ) : ?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'ovinx' ); ?></p>
		<?php endif; ?>
	</div>
<?php endif; ?>

<?php
if ( comments_open() ) :
	$commenter  = wp_get_current_commenter();
	$logged_in  = is_user_logged_in();
	$must_login = get_option( 'comment_registration' ) && ! $logged_in;
	$name_req   = (bool) get_option( 'require_name_email' );
	$req_attr   = $name_req ? ' required aria-required="true"' : '';
	$req_star   = $name_req ? ' <span class="text-primary">*</span>' : '';
	$permalink  = get_permalink();

	$name_email_fields = '';
	$cookies_field     = '';
	if ( ! $logged_in ) {
		$name_email_fields = '<div class="tf-grid-layout sm-col-2">
									<fieldset class="tf-field">
										<label for="author" class="cl-text-main">' . esc_html__( 'Your Name', 'ovinx' ) . $req_star . '</label>
										<input type="text" name="author" id="author" placeholder="' . esc_attr__( 'Your name*', 'ovinx' ) . '" value="' . esc_attr( $commenter['comment_author'] ) . '" size="32" maxlength="245" autocomplete="name"' . $req_attr . '>
									</fieldset>
									<fieldset class="tf-field">
										<label for="email" class="cl-text-main">' . esc_html__( 'Your Email', 'ovinx' ) . $req_star . '</label>
										<input type="email" name="email" id="email" placeholder="' . esc_attr__( 'Your email (private)', 'ovinx' ) . '" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="32" maxlength="100" autocomplete="email"' . $req_attr . '>
									</fieldset>
								</div>';

		// WP's own "remember me" checkbox (name wp-comment-cookies-consent is what wp_handle_comment_submission() reads).
		// Rendered here, inside .form-content, because core would otherwise append its unstyled <p> AFTER the form content.
		if ( has_action( 'set_comment_cookies', 'wp_set_comment_cookies' ) && get_option( 'show_comments_cookies_opt_in' ) ) {
			$cookies_field = '<div class="checkbox-wrap">
										<input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes" class="tf-check"' . ( empty( $commenter['comment_author_email'] ) ? '' : ' checked' ) . '>
										<label for="wp-comment-cookies-consent">' . esc_html__( 'Save my name, email, and website in this browser for the next time I comment.', 'ovinx' ) . '</label>
									</div>';
		}
	}

	// Star picker: only for a top-level comment by someone who can actually post (replies don't carry a rating —
	// see ovinx_save_comment_rating()). It sits in the form heading so it moves together with #wg-respond when
	// WP's reply JS relocates the form, and so main.js::rateClick() can still find <input name="rating">.
	$stars_html = '';
	if ( ! $must_login && empty( $_GET['replytocom'] ) ) {
		$stars_html = '<div class="star-wrap rate-click fs-24">' . str_repeat( '<i class="icon icon-Star"></i>', 5 ) . '</div>';
	}

	$logged_in_as = '';
	if ( $logged_in ) {
		$logged_in_as = '<p class="desc mb-20 logged-in-as">' . sprintf(
			/* translators: 1: user display name, 2: log out URL. */
			wp_kses( __( 'Logged in as <strong>%1$s</strong>. <a href="%2$s">Log out?</a>', 'ovinx' ), array( 'strong' => array(), 'a' => array( 'href' => array() ) ) ),
			esc_html( wp_get_current_user()->display_name ),
			esc_url( wp_logout_url( $permalink ) )
		) . '</p>';
	}

	$comment_args = array(
		'title_reply'          => esc_html__( 'Leave a comment', 'ovinx' ),
		'title_reply_to'       => esc_html__( 'Reply to %s', 'ovinx' ),
		'title_reply_before'   => '<div class="heading mb-8"><h6 id="reply-title" class="comment-reply-title">',
		'title_reply_after'    => '</h6>' . $stars_html . '</div>',
		'cancel_reply_link'    => esc_html__( 'Cancel reply', 'ovinx' ),
		'must_log_in'          => '<p class="desc must-log-in">' . sprintf(
			/* translators: %s: login URL. */
			wp_kses( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'ovinx' ), array( 'a' => array( 'href' => array() ) ) ),
			esc_url( wp_login_url( $permalink ) )
		) . '</p>',
		'logged_in_as'         => $logged_in_as,
		'comment_notes_before' => '<p class="desc mb-20">' . esc_html__( 'Your email address will not be published. Required fields are marked', 'ovinx' ) . ' <span class="text-primary">*</span></p>',
		'comment_notes_after'  => '',
		'class_form'           => 'form-write-review',
		'class_submit'         => 'tf-btn',
		'label_submit'         => esc_html__( 'Post Comment', 'ovinx' ),
		'submit_button'        => '<button name="%1$s" type="submit" id="%2$s" class="%3$s">%4$s</button>',
		'submit_field'         => '%1$s%2$s',
		// 'cookies' => '' stops core re-adding its own (unstyled, form-external) cookies checkbox; see $cookies_field above.
		'fields'               => array( 'cookies' => '' ),
		'comment_field'        => '<input type="hidden" name="rating" id="rating" value="0"><div class="form-content mb-20">' . $name_email_fields . '
									<fieldset class="tf-field">
										<label for="comment" class="cl-text-main">' . esc_html__( 'Your Comment', 'ovinx' ) . ' <span class="text-primary">*</span></label>
										<textarea id="comment" name="comment" rows="4" maxlength="65525" required aria-required="true"></textarea>
									</fieldset>' . $cookies_field . '
								</div>',
	);
	?>
	<?php // id="wg-respond" (not core's "respond"): the whole block — heading, stars, notes, form — moves as one unit when replying. Reply links pass respond_id => 'wg-respond'. ?>
	<div class="wg-leave-comment" id="wg-respond">
		<?php comment_form( $comment_args ); ?>
	</div>
<?php endif; ?>
