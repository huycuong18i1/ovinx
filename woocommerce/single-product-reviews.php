<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     10.3.4
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

if ( ! comments_open() ) {
	return;
}


function tfwc_woo_comments($comment, $args, $depth) {

	$children_class= '';

	if( $comment->comment_parent){
		$children_class = 'comment_reply';
	};
	$GLOBALS['comment'] = $comment;
	$rating = get_comment_meta( $comment->comment_ID, 'rating', true );
	?>
	<li <?php comment_class(['comment-item', 'post-review-item', $children_class]); ?> id="comment-<?php comment_ID() ?>">
		<div class="cmt_image">
			<?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, 60 ); ?>
		</div>
		<div class="cmt_infor">
			<p class="h6 infor__name lh-28 comment_author">
				<?php echo get_comment_author_link(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<?php edit_comment_link(esc_html__('(Edit)', 'ovinx' ),'  ','') ?>
			</p>
			<div class="d-flex align-items-center gap-8">
				<?php if ( $rating ) : ?>
					<div class="star-wrap">
						<?php
						for ( $i = 1; $i <= 5; $i++ ) {
							echo wp_kses_post( ( $i <= $rating ) ? '<i class="icon icon-Star"></i>' : '<i class="icon icon-Star cl-text-mute"></i>' );
						}
						?>
					</div>
				<?php endif; ?>
				<p class="date-cmt"><?php echo esc_html( date( 'M jS, Y', strtotime( get_comment_date( 'F j, Y' ) ) ) ); ?></p>
			</div>
			<div class="infor__desc text-body-02 cl-text-main">
				<?php comment_text(); ?>
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<span class="unapproved"><?php esc_html_e( 'Your comment is awaiting moderation.', 'ovinx' ) ?></span>
				<?php endif; ?>
			</div>
		</div>
	</li>
<?php
}

?>


<div id="reviews" class="woocommerce-Reviews">
	<!-- <div class=""> -->
		<div class="accordion-body product-desc_review write-cancel-review-wrap">
			<?php
			global $wpdb;
			global $post;
			global $product;
			$count = $wpdb->get_var("
				SELECT COUNT(meta_value) FROM $wpdb->commentmeta
				LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
				WHERE meta_key = 'rating'
				AND comment_post_ID = $post->ID
				AND comment_approved = '1'
				AND meta_value > 0
			");

			$sql = $wpdb->prepare( "
				SELECT meta_value 
				FROM {$wpdb->prefix}commentmeta 
				INNER JOIN {$wpdb->prefix}comments ON {$wpdb->prefix}commentmeta.comment_id = {$wpdb->prefix}comments.comment_ID 
				WHERE comment_post_ID = %d AND meta_key = 'rating' ", get_the_ID() 
			);
			$results = $wpdb->get_results( $sql );
			$rating5 = 0;
			$rating4 = 0;
			$rating3 = 0;
			$rating2 = 0;
			$rating1 = 0;

			foreach($results as $result){
				if( $result->meta_value == '5' ) {
					$rating5++;
				} else if( $result->meta_value == '4' ) {
					$rating4++;
				} else if( $result->meta_value == '3' ) {
					$rating3++;
				} else if( $result->meta_value == '2' ) {
					$rating2++;
				} else if( $result->meta_value == '1' ) {
					$rating1++;
				}

			}
			$review_count = $product->get_review_count();
			$rating = $wpdb->get_var("
				SELECT SUM(meta_value) FROM $wpdb->commentmeta
				LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
				WHERE meta_key = 'rating'
				AND comment_post_ID = $post->ID
				AND comment_approved = '1'
			");

			echo '<div class="box-rating">';
				if ( $count > 0 ) {
					$product_id = $product->get_id();
					$review_count = $product->get_review_count();
					$average = number_format($rating / $count, 1);
					?>
					<div class="col-left">
						<div class="rating-ratio">
							<p class="text-display fw-medium">
								<?php echo esc_html($average); ?>
							</p>
							<?php
								// The theme's own `single-product/rating.php` already renders the star icons
								// AND the "(N Rating)" text together (linked to #tab-reviews) — no separate
								// wrapper/count needed here, that would just duplicate it.
								set_query_var('is_single_rating', true);
								woocommerce_template_single_rating();
								set_query_var('is_single_rating', null);
							?>
						</div>
						<ul class="rating-progress-list">
							<?php foreach ( array( 5 => $rating5, 4 => $rating4, 3 => $rating3, 2 => $rating2, 1 => $rating1 ) as $star => $star_count ) : ?>
								<li class="fw-medium rate-progress-star">
									<span class="number-star fw-semibold cl-text-main"><?php echo esc_html( $star ); ?></span>
									<i class="icon icon-Star fs-20 cl-text-yellow"></i>
									<span class="progress" role="progressbar" aria-valuenow="<?php echo esc_attr( round( $star_count * 100 / $review_count ) ); ?>" aria-valuemin="0" aria-valuemax="100">
										<span class="progress-bar" style="width:<?php echo esc_attr( $star_count * 100 / $review_count ); ?>%;"></span>
									</span>
									<span class="number-percent">
										<?php echo esc_html( round( $star_count * 100 / $review_count ) ); ?>%
									</span>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php } ?>
				<div>
					<button type="button" class="action btn-comment-review btn-cancel-review tf-btn">
						<?php esc_html_e( 'CANCEL REVIEW', 'ovinx' ); ?>
					</button>
					<button type="button" class="action btn-comment-review btn-write-review tf-btn">
						<?php esc_html_e( 'WRITE A REVIEW', 'ovinx' ); ?>
					</button>
				</div>
			<?php
			echo '</div>';
			?>
			<div class="box-preview-wrapper">

				<div id="comments" class="comments-area">
					<div class="wg-comment cancel-review-wrap">
						<?php if ( have_comments() ) : ?>

							<div class="heading d-flex align-items-center justify-content-between">
								<?php $review_count_formatted = sprintf( '%02d', $review_count ); ?>
								<h5><?php echo esc_html( $review_count_formatted ); ?> <?php echo esc_html( _n( 'review', 'reviews', $review_count, 'ovinx' ) ); ?></h5>
								<div class="review-heading-right sort-by">
									<div class="sort-by review-sort">
										<span class="text-caption-01">Sort by:</span>
										<div class="select-wrap select-sort-comment">
											<select class="select-2">
												<option value="1" selected=""><?php _e('Most Recent', 'ovinx'); ?></option>
												<option value="2"><?php _e('Last Week', 'ovinx'); ?></option>
												<option value="3"><?php _e('Today', 'ovinx'); ?></option>
											</select>
											<i class="icon icon-CaretDown"></i>
										</div>
									</div>
								</div>
							</div>
							<ul class="list-comment">
								<?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'tfwc_woo_comments' ) ) ); ?>
							</ul>

							<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
								echo '<nav class="woocommerce-pagination">';
								paginate_comments_links( apply_filters( 'woocommerce_comment_pagination_args', array(
									'prev_text' => '&larr;',
									'next_text' => '&rarr;',
									'type'      => 'list',
								) ) );
								echo '</nav>';
							endif; ?>

						<?php else : ?>

							<p class="woocommerce-noreviews"><?php echo esc_html__( 'There are no reviews yet.', 'ovinx' ); ?></p>

						<?php endif; ?>
					</div>
				</div>

				<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>

					<div id="review_form_wrapper">
						<div id="review_form" class="wg-leave-comment write-review-wrap">
							<?php
								$commenter = wp_get_current_commenter();

								$review_title = have_comments()
									? esc_html__( 'Write a review:', 'ovinx' )
									/* translators: %s: product title */
									: sprintf( esc_html__( 'Be the first to review &ldquo;%s&rdquo;', 'ovinx' ), get_the_title() );

								$comment_form = array(
									'title_reply'          => '',
									'title_reply_to'       => esc_html__( 'Leave a Reply to %s', 'ovinx' ),
									'title_reply_before'   => '',
									'title_reply_after'    => '',
									'fields'               => array(),
									'label_submit'  => esc_html__( 'Submit Review', 'ovinx' ),
									'class_submit' => 'tf-btn',
									// Ground truth's generic form reset (`form input[type=submit]{background:transparent}`,
									// css/styles.css) assumes submit controls are always real `<button>` elements — an
									// `<input type="submit">` (WP core's own default) collides with that reset and
									// renders invisible. Match ground truth's own real submit buttons (`<button class="tf-btn">`).
									'submit_button' => '<button name="%1$s" type="submit" id="%2$s" class="%3$s">%4$s</button>',
									'submit_field' => '<p class="form-submit">%1$s %2$s</p>',
									'logged_in_as'  => '',
									'comment_field' 		=> '',
									'comment_notes_before' => '',
									'comment_notes_after'  => '</div>', // phpcs:ignore -- closes the .form-content div opened in comment_field below.
									'class_form' => 'form-write-review',
								);

								if ( $account_page_url = wc_get_page_permalink( 'myaccount' ) ) {
									$comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf( esc_html__( 'You must be <a href="%s">logged in</a> to post a review.', 'ovinx' ), esc_url( $account_page_url ) ) . '</p>';
								}

								$comment_form['comment_field'] = '<div class="heading mb-8"><h6>' . $review_title . '</h6>';

								if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
									// WooCommerce core (`wc-single-product.js`) auto-inserts its own accessible,
									// already-clickable 5-star widget (`<p class="stars">`) right before `#rating`
									// — styled in css/styles.css to look like the ground truth's `.rate-click` stars
									// instead of building a second, decorative/non-functional star row here.
									$comment_form['comment_field'] .= '<div class="comment-form-rating">
										<input type="text" name="rating" id="rating" value="" class="screen-reader-text" ' . ( wc_review_ratings_required() ? 'required' : '' ) . ' />
									</div>';
								}

								$comment_form['comment_field'] .= '</div>';

								$comment_form['comment_field'] .= '<p class="desc mb-20">' . esc_html__( 'Your email address will not be published. Required fields are marked', 'ovinx' ) . ' <span class="text-primary">*</span></p>';

								$comment_form['comment_field'] .= '<div class="form-content mb-20"><div class="tf-grid-layout sm-col-2">
									<fieldset class="tf-field"><label for="author" class="cl-text-main">' . esc_html__( 'Your Name', 'ovinx' ) . ' <span class="text-primary">*</span></label><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" required placeholder="' . esc_attr__( 'Your name*', 'ovinx' ) . '" /></fieldset>
									<fieldset class="tf-field"><label for="email" class="cl-text-main">' . esc_html__( 'Your Email', 'ovinx' ) . ' <span class="text-primary">*</span></label><input id="email" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" aria-required="true" required placeholder="' . esc_attr__( 'Your email (private)', 'ovinx' ) . '" /></fieldset>
								</div>
								<fieldset class="tf-field"><label for="comment" class="cl-text-main">' . esc_html__( 'Your Review', 'ovinx' ) . ' <span class="text-primary">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" required placeholder="' . esc_attr__( 'Write your comment here*', 'ovinx' ) . '"></textarea></fieldset>';

								comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );

							?>
						</div>
					</div>

				<?php else : ?>

					<p class="woocommerce-verification-required"><?php echo esc_html__( 'Only logged in customers who have purchased this product may leave a review.', 'ovinx' ); ?></p>

				<?php endif; ?>
			</div>
			<!-- <div class="clear"></div> -->
		</div>
	<!-- </div> -->
</div>
