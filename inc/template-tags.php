<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package ovinx
 */


/**
 * Prints HTML with meta information for the current post-date/time, post categories and author.
 */

if ( ! function_exists( 'themesflat_posted_category' ) ) :
function themesflat_posted_category( $layout = '' ) { 	
	if ( has_category() ) {
		echo '<div class="post-categories">'.esc_html__("In - ",'ovinx');
			the_category( ', ' );
		echo '</div>';
	}	
}
endif;

if ( ! function_exists( 'themesflat_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function themesflat_entry_footer() {

	
		
	
	?>
                      
                        
                    
	<div class="entry_media content-bottom">
		<?php
		if ( 'post' == get_post_type() ) {

			$tags_list = get_the_tags();
						
			if ( $tags_list && is_single() ) {
		?>
			<ul class="entry_tag bottom_tag">
				<li class="text-primary">
					<?php esc_html_e( 'Tag:', 'ovinx' ); ?>
				</li>
				<?php foreach ($tags_list as $tag) { ?>				
				<li>
					<a href="<?php echo esc_url(get_tag_link($tag->term_id));?>" class="text-caption-01">
						<?php echo esc_html($tag->name);?>
					</a>
				</li>
				<?php }	?>
			</ul>

		<?php 
			}			
		}
	
			themesflat_social_single();
		?>
	</div>
	<?php

}
endif;

if ( ! function_exists( 'themesflat_post_navigation' ) ) :
function themesflat_post_navigation() {
    $prev_post = get_previous_post();
    $next_post = get_next_post();

    if ( ! $prev_post && ! $next_post ) {
        return;
    }

    $container_class = '';
    if ( empty( $prev_post ) && ! empty( $next_post ) ) {
        $container_class = 'navi-next';
    }
    ?>

		<div class="main-blog-single">
			<div class="group-direc <?php echo esc_attr( $container_class ); ?>">
				
				<?php if ( $prev_post ) : ?>
					<a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>" class="btn-direc prev link">
						<p class="fw-semibold text-decoration-underline">
							<?php esc_html_e( 'Previous', 'ovinx' ); ?>
						</p>
						<p class="name-post h6 fw-medium">
							<?php echo esc_html( get_the_title( $prev_post->ID ) ); ?>
						</p>
					</a>
				<?php endif; ?>
	
					<span class="br-line type-vertical"></span>
	
				<?php if ( $next_post ) : ?>
					<a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>" class="btn-direc next link">
						<p class="fw-semibold text-decoration-underline">
							<?php esc_html_e( 'Next', 'ovinx' ); ?>
						</p>
						<p class="name-post h6 fw-medium">
							<?php echo esc_html( get_the_title( $next_post->ID ) ); ?>
						</p>
					</a>
				<?php endif; ?>
	
			</div>
		</div>

    <?php
}
endif;

/**
 * Blog comment star rating (ovinx-html blog-single.html `.rate-click` + `.star-wrap`).
 * Stored in the same `rating` comment meta WooCommerce uses for product reviews, but only
 * for non-product posts — WooCommerce already saves/validates its own rating on products.
 */
if ( ! function_exists( 'ovinx_save_comment_rating' ) ) :
function ovinx_save_comment_rating( $comment_id, $comment_approved, $commentdata ) {
	if ( empty( $commentdata['comment_post_ID'] ) || 'product' === get_post_type( $commentdata['comment_post_ID'] ) ) {
		return;
	}

	// A reply answers a comment, it doesn't review the post — the form hides the stars for replies, so also ignore a stale value.
	if ( ! empty( $commentdata['comment_parent'] ) ) {
		return;
	}

	$rating = isset( $_POST['rating'] ) ? absint( $_POST['rating'] ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Missing -- core comment form, nonce handled by wp-comments-post.php
	if ( $rating >= 1 && $rating <= 5 ) {
		add_comment_meta( $comment_id, 'rating', $rating, true );
	}
}
endif;
add_action( 'comment_post', 'ovinx_save_comment_rating', 10, 3 );
