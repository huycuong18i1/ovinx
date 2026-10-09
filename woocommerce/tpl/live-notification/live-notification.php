<?php
if ( themesflat_get_opt( 'live_notification' ) == 1 ) {

	/**
	 * Render HTML for one live-sale notification.
	 *
	 * @param WC_Product $product     Product object.
	 * @param string     $first_name  Customer name.
	 * @param string     $time_passed Human-readable elapsed time.
	 *
	 * @return string
	 */
	function tfwc_live_notification_html( $product, $first_name, $time_passed ) {
		if ( ! $product instanceof WC_Product ) {
			return '';
		}

		$product_name = $product->get_name();
		$product_link = $product->get_permalink();
		$product_image = $product->get_image(
			'tf-live-sale',
			array(
				'loading' => 'lazy',
				'alt'     => $product_name,
			)
		);

		if ( empty( $first_name ) ) {
			$first_name = esc_html__( 'Somebody', 'ovinx' );
		}

		ob_start();
		?>
		<div class="pop-notice-sale" aria-hidden="true">
			<button
				type="button"
				class="btn-cl-pop link cs-pointer"
				aria-label="<?php echo esc_attr__( 'Close notification', 'ovinx' ); ?>"
			>
				<i class="icon icon-X2"></i>
			</button>

			<div class="pns-thumb">
				<a class="image" href="<?php echo esc_url( $product_link ); ?>">
					<?php echo wp_kses_post( $product_image ); ?>
				</a>

				<div class="purchase" aria-hidden="true">
					<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M13.5 2.5H2.5C2.23478 2.5 1.98043 2.60536 1.79289 2.79289C1.60536 2.98043 1.5 3.23478 1.5 3.5V12.5C1.5 12.7652 1.60536 13.0196 1.79289 13.2071C1.98043 13.3946 2.23478 13.5 2.5 13.5H13.5C13.7652 13.5 14.0196 13.3946 14.2071 13.2071C14.3946 13.0196 14.5 12.7652 14.5 12.5V3.5C14.5 3.23478 14.3946 2.98043 14.2071 2.79289C14.0196 2.60536 13.7652 2.5 13.5 2.5ZM2.5 4.5V3.5H13.5V4.5H2.5Z" fill="white"/>
						<path d="M11.1469 7.11756L7.37458 10.8225C7.2801 10.9153 7.15295 10.9673 7.0205 10.9673C6.88806 10.9673 6.76091 10.9153 6.66643 10.8225L5.04973 9.23485C5.00238 9.18835 4.96465 9.13298 4.93869 9.0719C4.91274 9.01082 4.89906 8.94522 4.89846 8.87886C4.89723 8.74483 4.9493 8.61581 5.04321 8.52017C5.08971 8.47282 5.14508 8.43509 5.20616 8.40913C5.26724 8.38317 5.33283 8.3695 5.39919 8.3689C5.53322 8.36767 5.66224 8.41974 5.75788 8.51365L7.02093 9.75396L10.4391 6.39679C10.5347 6.30288 10.6637 6.25079 10.7977 6.25197C10.9317 6.25316 11.0597 6.30752 11.1536 6.4031C11.2475 6.49868 11.2996 6.62765 11.2984 6.76164C11.2972 6.89563 11.2425 7.02366 11.1469 7.11756Z" fill="#DC4646"/>
					</svg>
				</div>
			</div>

			<div class="pns-content">
				<p class="mb-4 text-caption-01 cl-text-2">
					<?php
					printf(
						/* translators: %s: customer name. */
						esc_html__( '%s has purchased!', 'ovinx' ),
						esc_html( $first_name )
					);
					?>
				</p>

				<a href="<?php echo esc_url( $product_link ); ?>" class="fw-medium link mb-12 lh-24">
					<?php echo esc_html( $product_name ); ?>
				</a>

				<div class="bottom">
					<div class="pns_date">
						<svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
							<path d="M6 11C8.76142 11 11 8.76142 11 6C11 3.23858 8.76142 1 6 1C3.23858 1 1 3.23858 1 6C1 8.76142 3.23858 11 6 11Z" stroke="#696E73" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M6 3V6L8 7" stroke="#696E73" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>

						<span class="text-caption-01 cl-text-2">
							<?php
							printf(
								/* translators: %s: elapsed time. */
								esc_html__( '%s ago', 'ovinx' ),
								esc_html( $time_passed )
							);
							?>
						</span>
					</div>

					<a href="<?php echo esc_url( $product_link ); ?>" class="tf-btn-line style-min text-primary">
						<span class="fw-semibold text-caption-01">
							<?php echo esc_html__( 'View Products', 'ovinx' ); ?>
						</span>
					</a>
				</div>
			</div>
		</div>
		<?php

		return trim( ob_get_clean() );
	}

	/**
	 * Create a random elapsed-time string.
	 *
	 * @return string
	 */
	function tfwc_live_random_time() {
		$days = wp_rand( 2, 20 );

		return sprintf(
			/* translators: %d: number of days. */
			_n( '%d day', '%d days', $days, 'ovinx' ),
			$days
		);
	}

	function tfwc_orders() {
		check_ajax_referer( 'tfwc_nonce', 'nonce' );

		$limit        = max( 1, absint( themesflat_get_opt( 'live_number' ) ) );
		$product_from = themesflat_get_opt( 'product_from' );
		$products     = array();
		$orders       = array();

		switch ( $product_from ) {
			case 'order':
				/*
				 * Giữ nguyên logic query cũ.
				 * Không áp live_status vào query vì option này có thể không đúng
				 * định dạng mà wc_get_orders() yêu cầu.
				 */
				$orders = wc_get_orders(
					array(
						'orderby' => 'date',
						'order'   => 'DESC',
						'limit'   => 100,
					)
				);

				if ( is_wp_error( $orders ) || empty( $orders ) ) {
					wp_send_json_error( 'No orders found.' );
				}

				shuffle( $orders );

				$item_count = 0;

				foreach ( $orders as $order ) {
					if ( ! $order instanceof WC_Order ) {
						continue;
					}

					foreach ( $order->get_items() as $item ) {
						if ( $item_count >= $limit ) {
							break 2;
						}

						$product = $item->get_product();

						if ( ! $product instanceof WC_Product ) {
							continue;
						}

						$completed_date = $order->get_date_completed();

						if ( $completed_date ) {
							$time_passed = human_time_diff(
								$completed_date->getTimestamp(),
								current_time( 'timestamp' )
							);
						} else {
							$time_passed = tfwc_live_random_time();
						}

						$product_html = tfwc_live_notification_html(
							$product,
							$order->get_billing_first_name(),
							$time_passed
						);

						if ( $product_html ) {
							$products[] = array(
								'product_html' => $product_html,
							);

							$item_count++;
						}
					}
				}
				break;

			case 'type':
				$args = array(
					'post_type'      => 'product',
					'post_status'    => 'publish',
					'posts_per_page' => $limit,
					'fields'         => 'ids',
				);

				switch ( themesflat_get_opt( 'product_type' ) ) {
					case 'recent':
						// The theme's own cookie (functions.php: tfwc_save_recently_viewed_product) — comma-separated, newest first.
						// (WooCommerce's `woocommerce_recently_viewed` cookie only exists when its Recently Viewed widget is active.)
						$orders = ! empty( $_COOKIE['recently_viewed_products'] )
							? array_filter(
								array_map(
									'absint',
									explode(
										',',
										wp_unslash( $_COOKIE['recently_viewed_products'] )
									)
								)
							)
							: array();
						break;

					case 'featured':
						$orders = wc_get_featured_product_ids();
						break;

					case 'best_selling':
						$args['meta_key'] = 'total_sales';
						$args['orderby']  = 'meta_value_num';
						$args['order']    = 'DESC';
						$orders           = get_posts( $args );
						break;

					case 'top_rated':
						$args['meta_key'] = '_wc_average_rating';
						$args['orderby']  = 'meta_value_num';
						$args['order']    = 'DESC';
						$orders           = get_posts( $args );
						break;

					case 'sale':
						$orders = wc_get_product_ids_on_sale();
						break;

					default:
						$orders = get_posts( $args );
						break;
				}

				$orders = array_slice(
					array_unique( array_map( 'absint', $orders ) ),
					0,
					$limit
				);

				foreach ( $orders as $product_id ) {
					$product = wc_get_product( $product_id );

					if ( ! $product instanceof WC_Product ) {
						continue;
					}

					$product_html = tfwc_live_notification_html(
						$product,
						esc_html__( 'Somebody', 'ovinx' ),
						tfwc_live_random_time()
					);

					if ( $product_html ) {
						$products[] = array(
							'product_html' => $product_html,
						);
					}
				}
				break;

			case 'category':
				$category = array_filter(
					array_map(
						'absint',
						(array) themesflat_get_opt( 'live_category' )
					)
				);

				if ( empty( $category ) ) {
					wp_send_json_error( 'No category selected.' );
				}

				$orders = get_posts(
					array(
						'post_type'      => 'product',
						'post_status'    => 'publish',
						'posts_per_page' => $limit,
						'fields'         => 'ids',
						'tax_query'      => array(
							array(
								'taxonomy' => 'product_cat',
								'field'    => 'term_id',
								'terms'    => $category,
								'operator' => 'IN',
							),
						),
					)
				);

				foreach ( $orders as $product_id ) {
					$product = wc_get_product( $product_id );

					if ( ! $product instanceof WC_Product ) {
						continue;
					}

					$product_html = tfwc_live_notification_html(
						$product,
						esc_html__( 'Somebody', 'ovinx' ),
						tfwc_live_random_time()
					);

					if ( $product_html ) {
						$products[] = array(
							'product_html' => $product_html,
						);
					}
				}
				break;

			default:
				wp_send_json_error( 'Invalid product source.' );
		}

		if ( empty( $products ) ) {
			$message = sprintf(
				'<p class="woocommerce-info tf-no-results">
					%1$s
					<a href="%2$s" class="tf-shop-link">%3$s</a>
				</p>',
				esc_html__( 'No products were found matching your selection.', 'ovinx' ),
				esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ),
				esc_html__( 'Go To Shop', 'ovinx' )
			);

			wp_send_json_error( $message );
		}

		wp_send_json_success( $products );
	}

	add_action( 'wp_ajax_tfwc_live_notification', 'tfwc_orders' );
	add_action( 'wp_ajax_nopriv_tfwc_live_notification', 'tfwc_orders' );

	function tfwc_live_container() {
		echo '<div id="live-sales-container" aria-live="polite"></div>';
	}

	add_action( 'wp_footer', 'tfwc_live_container' );
}