<?php
/**
 * Empty cart page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-empty.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 10.3.4
 */

defined( 'ABSPATH' ) || exit;

/*
 * @hooked wc_empty_cart_message - 10
 */
do_action( 'woocommerce_cart_is_empty' );

if ( wc_get_page_id( 'shop' ) > 0 ) : ?>
	<div class="page-cart-empty-wrap">                        
		<svg width="227" height="227" viewBox="0 0 227 227" fill="none" xmlns="http://www.w3.org/2000/svg">
			<g opacity="0.4">
			<path fill-rule="evenodd" clip-rule="evenodd" d="M184.438 126.329H42.5625V191.989C42.5625 195.121 44.6161 197.884 47.6168 198.784C61.8717 203.058 101.958 215.086 111.461 217.938C112.791 218.335 114.209 218.335 115.539 217.938C125.042 215.086 165.128 203.058 179.383 198.784C182.384 197.884 184.438 195.121 184.438 191.989C184.438 175.545 184.438 126.329 184.438 126.329Z" fill="url(#paint0_linear_1_12824)"></path>
			<path fill-rule="evenodd" clip-rule="evenodd" d="M184.437 126.329H113.5C113.5 126.329 112.812 218.235 113.5 218.235C114.188 218.235 114.873 218.136 115.539 217.938C125.041 215.086 165.128 203.058 179.383 198.784C182.384 197.884 184.437 195.121 184.437 191.989C184.437 175.545 184.437 126.329 184.437 126.329Z" fill="url(#paint1_linear_1_12824)"></path>
			<path fill-rule="evenodd" clip-rule="evenodd" d="M113.5 149.345L42.5625 126.329C42.5625 126.329 30.1236 144.773 24.5621 153.016C23.9378 153.941 23.7853 155.101 24.1471 156.155C24.5124 157.208 25.346 158.027 26.4065 158.375C39.881 162.752 79.7692 175.712 90.2325 179.11C91.7328 179.599 93.3786 179.035 94.2653 177.727C99.0216 170.707 113.5 149.345 113.5 149.345Z" fill="url(#paint2_linear_1_12824)"></path>
			<path fill-rule="evenodd" clip-rule="evenodd" d="M184.438 126.329L113.5 149.345C113.5 149.345 127.978 170.707 132.735 177.727C133.621 179.035 135.267 179.599 136.768 179.11C147.231 175.712 187.119 162.752 200.594 158.375C201.654 158.027 202.488 157.208 202.853 156.155C203.215 155.101 203.062 153.941 202.438 153.016C196.876 144.773 184.438 126.329 184.438 126.329Z" fill="url(#paint3_linear_1_12824)"></path>
			<path fill-rule="evenodd" clip-rule="evenodd" d="M96.3295 77.9816C95.4428 76.6799 93.8006 76.1159 92.3002 76.6054C81.8441 79.9998 41.9453 92.9636 28.4707 97.344C27.4102 97.688 26.5731 98.5074 26.2113 99.5608C25.8495 100.614 26.0021 101.778 26.6263 102.7C31.748 110.297 42.5624 126.329 42.5624 126.329L113.5 103.235C113.5 103.235 100.76 84.4972 96.3295 77.9816Z" fill="url(#paint4_linear_1_12824)"></path>
			<path fill-rule="evenodd" clip-rule="evenodd" d="M200.374 102.7C200.998 101.778 201.15 100.614 200.789 99.5608C200.427 98.5074 199.59 97.688 198.529 97.344C185.055 92.9636 145.156 79.9998 134.7 76.6054C133.199 76.1159 131.557 76.6799 130.67 77.9816C126.24 84.4972 113.5 103.235 113.5 103.235L184.438 126.329C184.438 126.329 195.252 110.297 200.374 102.7Z" fill="url(#paint5_linear_1_12824)"></path>
			<path fill-rule="evenodd" clip-rule="evenodd" d="M184.438 126.329L113.5 103.235L42.5625 126.329L113.5 149.345L184.438 126.329Z" fill="url(#paint6_linear_1_12824)"></path>
			<path fill-rule="evenodd" clip-rule="evenodd" d="M113.5 149.345V103.235L42.5625 126.329L113.5 149.345Z" fill="url(#paint7_linear_1_12824)"></path>
			<path fill-rule="evenodd" clip-rule="evenodd" d="M99.2486 113.422C97.7731 112.457 96.4431 111.425 95.2619 110.343C93.8219 109.02 91.5767 109.116 90.2502 110.56C88.9272 112 89.023 114.245 90.4666 115.568C91.9172 116.901 93.5524 118.171 95.3684 119.359C97.007 120.431 99.2061 119.969 100.277 118.331C101.348 116.692 100.887 114.493 99.2486 113.422Z" fill="url(#paint8_linear_1_12824)"></path>
			<path fill-rule="evenodd" clip-rule="evenodd" d="M88.1966 102.526C87.1431 101.097 86.2529 99.6601 85.5222 98.2236C84.6355 96.4785 82.4967 95.7834 80.7517 96.6701C79.0066 97.5568 78.3114 99.6956 79.1982 101.441C80.0991 103.207 81.1915 104.977 82.4861 106.733C83.6459 108.307 85.8663 108.644 87.4446 107.485C89.0194 106.321 89.3564 104.101 88.1966 102.526Z" fill="url(#paint9_linear_1_12824)"></path>
			<path fill-rule="evenodd" clip-rule="evenodd" d="M83.011 88.0511C83.0465 86.6217 83.2557 85.2349 83.6388 83.9048C84.1779 82.025 83.0891 80.0565 81.2057 79.5173C79.3258 78.9782 77.3573 80.0671 76.8182 81.9505C76.2755 83.8516 75.9705 85.8343 75.9173 87.8738C75.8712 89.8317 77.4176 91.4597 79.3755 91.5058C81.3333 91.5554 82.9614 90.009 83.011 88.0511Z" fill="url(#paint10_linear_1_12824)"></path>
			<path fill-rule="evenodd" clip-rule="evenodd" d="M88.466 76.2046C89.3776 75.3604 90.3991 74.5801 91.5163 73.8743C93.1727 72.8279 93.6693 70.636 92.6265 68.9831C91.5802 67.3267 89.3882 66.8302 87.7318 67.8729C86.2315 68.82 84.8695 69.8663 83.6458 71.0013C82.2093 72.3314 82.1242 74.5765 83.4543 76.013C84.7844 77.4495 87.0295 77.5346 88.466 76.2046Z" fill="url(#paint11_linear_1_12824)"></path>
			<path fill-rule="evenodd" clip-rule="evenodd" d="M101.657 70.0862C103.441 69.7564 105.332 69.5436 107.325 69.462C109.283 69.3769 110.801 67.7205 110.719 65.7661C110.638 63.8118 108.981 62.2902 107.023 62.3718C104.682 62.4711 102.462 62.7229 100.366 63.1095C98.4435 63.4678 97.1666 65.3192 97.5248 67.2416C97.8795 69.1676 99.731 70.4409 101.657 70.0862Z" fill="url(#paint12_linear_1_12824)"></path>
			<path fill-rule="evenodd" clip-rule="evenodd" d="M120.143 69.8769C123.169 69.9124 125.985 69.806 128.599 69.5754C130.55 69.4016 131.993 67.6778 131.82 65.727C131.646 63.7798 129.922 62.3362 127.971 62.51C125.577 62.7193 122.999 62.8186 120.225 62.7831C118.267 62.7619 116.66 64.3331 116.639 66.2875C116.614 68.2453 118.185 69.8556 120.143 69.8769Z" fill="url(#paint13_linear_1_12824)"></path>
			<path fill-rule="evenodd" clip-rule="evenodd" d="M140.258 67.4011C143.769 66.3264 146.734 64.9502 149.217 63.3718C150.866 62.3184 151.356 60.1264 150.302 58.4736C149.252 56.8243 147.057 56.3348 145.404 57.3882C143.407 58.658 141.013 59.7505 138.183 60.6159C136.313 61.1905 135.257 63.1732 135.831 65.0459C136.402 66.9187 138.388 67.9721 140.258 67.4011Z" fill="url(#paint14_linear_1_12824)"></path>
			<path fill-rule="evenodd" clip-rule="evenodd" d="M158.311 53.4443C159.985 49.9825 160.627 46.3221 160.464 42.793C160.372 40.8351 158.708 39.3241 156.754 39.4164C154.8 39.5086 153.285 41.1685 153.378 43.1228C153.491 45.5205 153.058 48.0069 151.923 50.3585C151.072 52.1213 151.81 54.2458 153.573 55.0971C155.335 55.9483 157.46 55.207 158.311 53.4443Z" fill="url(#paint15_linear_1_12824)"></path>
			<path fill-rule="evenodd" clip-rule="evenodd" d="M156.052 30.2512C153.466 26.7575 149.958 24.3244 146.135 23.5405C144.216 23.1503 142.34 24.3847 141.946 26.3035C141.556 28.2224 142.794 30.0987 144.709 30.4924C146.915 30.9428 148.859 32.4573 150.352 34.4755C151.519 36.0468 153.743 36.3766 155.314 35.2133C156.889 34.0463 157.219 31.8225 156.052 30.2512Z" fill="url(#paint16_linear_1_12824)"></path>
			<path fill-rule="evenodd" clip-rule="evenodd" d="M109.716 24.2286C113.553 2.49691 146.812 3.90147 127.45 24.2286H109.716Z" fill="url(#paint17_linear_1_12824)"></path>
			<path fill-rule="evenodd" clip-rule="evenodd" d="M109.716 29.7334C113.553 51.4616 146.812 50.0605 127.45 29.7334H109.716Z" fill="url(#paint18_linear_1_12824)"></path>
			<path fill-rule="evenodd" clip-rule="evenodd" d="M109.396 30.5632H133.146C135.104 30.5632 136.693 28.9742 136.693 27.0164C136.693 25.0585 135.104 23.4695 133.146 23.4695H109.396C107.442 23.4695 105.849 25.0585 105.849 27.0164C105.849 28.9742 107.442 30.5632 109.396 30.5632Z" fill="url(#paint19_linear_1_12824)"></path>
			</g>
			<defs>
			<linearGradient id="paint0_linear_1_12824" x1="42.5625" y1="172.282" x2="184.438" y2="172.282" gradientUnits="userSpaceOnUse">
			<stop stop-color="#CADCF0"></stop>
			<stop offset="1" stop-color="#A4BBDB"></stop>
			</linearGradient>
			<linearGradient id="paint1_linear_1_12824" x1="113.195" y1="172.282" x2="184.437" y2="172.282" gradientUnits="userSpaceOnUse">
			<stop stop-color="#A4BBDB"></stop>
			<stop offset="1" stop-color="#8DA3BE"></stop>
			</linearGradient>
			<linearGradient id="paint2_linear_1_12824" x1="43.0342" y1="126.3" x2="52.9486" y2="191.894" gradientUnits="userSpaceOnUse">
			<stop stop-color="#E9F3FC"></stop>
			<stop offset="1" stop-color="#CADCF0"></stop>
			</linearGradient>
			<linearGradient id="paint3_linear_1_12824" x1="113.787" y1="149.103" x2="188.569" y2="192.112" gradientUnits="userSpaceOnUse">
			<stop stop-color="#E9F3FC"></stop>
			<stop offset="1" stop-color="#CADCF0"></stop>
			</linearGradient>
			<linearGradient id="paint4_linear_1_12824" x1="33.2767" y1="112.564" x2="43.9778" y2="62.119" gradientUnits="userSpaceOnUse">
			<stop stop-color="#E9F3FC"></stop>
			<stop offset="1" stop-color="#CADCF0"></stop>
			</linearGradient>
			<linearGradient id="paint5_linear_1_12824" x1="132.49" y1="75.7506" x2="136.316" y2="138.015" gradientUnits="userSpaceOnUse">
			<stop stop-color="#E9F3FC"></stop>
			<stop offset="1" stop-color="#CADCF0"></stop>
			</linearGradient>
			<linearGradient id="paint6_linear_1_12824" x1="42.5625" y1="126.29" x2="184.438" y2="126.29" gradientUnits="userSpaceOnUse">
			<stop stop-color="#CADCF0"></stop>
			<stop offset="1" stop-color="#A4BBDB"></stop>
			</linearGradient>
			<linearGradient id="paint7_linear_1_12824" x1="120.764" y1="102.203" x2="122.293" y2="159.496" gradientUnits="userSpaceOnUse">
			<stop stop-color="#A4BBDB"></stop>
			<stop offset="1" stop-color="#8DA3BE"></stop>
			</linearGradient>
			<linearGradient id="paint8_linear_1_12824" x1="74.4524" y1="24.2286" x2="144.411" y2="106.775" gradientUnits="userSpaceOnUse">
			<stop stop-color="#559AFF"></stop>
			<stop offset="1" stop-color="#2E69EF"></stop>
			</linearGradient>
			<linearGradient id="paint9_linear_1_12824" x1="74.4524" y1="24.2287" x2="144.411" y2="106.775" gradientUnits="userSpaceOnUse">
			<stop stop-color="#559AFF"></stop>
			<stop offset="1" stop-color="#2E69EF"></stop>
			</linearGradient>
			<linearGradient id="paint10_linear_1_12824" x1="74.4524" y1="24.2287" x2="144.411" y2="106.775" gradientUnits="userSpaceOnUse">
			<stop stop-color="#559AFF"></stop>
			<stop offset="1" stop-color="#2E69EF"></stop>
			</linearGradient>
			<linearGradient id="paint11_linear_1_12824" x1="74.4523" y1="24.2286" x2="144.411" y2="106.775" gradientUnits="userSpaceOnUse">
			<stop stop-color="#559AFF"></stop>
			<stop offset="1" stop-color="#2E69EF"></stop>
			</linearGradient>
			<linearGradient id="paint12_linear_1_12824" x1="74.4524" y1="24.2287" x2="144.411" y2="106.775" gradientUnits="userSpaceOnUse">
			<stop stop-color="#559AFF"></stop>
			<stop offset="1" stop-color="#2E69EF"></stop>
			</linearGradient>
			<linearGradient id="paint13_linear_1_12824" x1="74.4524" y1="24.2286" x2="144.411" y2="106.775" gradientUnits="userSpaceOnUse">
			<stop stop-color="#559AFF"></stop>
			<stop offset="1" stop-color="#2E69EF"></stop>
			</linearGradient>
			<linearGradient id="paint14_linear_1_12824" x1="74.4525" y1="24.2285" x2="144.411" y2="106.775" gradientUnits="userSpaceOnUse">
			<stop stop-color="#559AFF"></stop>
			<stop offset="1" stop-color="#2E69EF"></stop>
			</linearGradient>
			<linearGradient id="paint15_linear_1_12824" x1="74.4524" y1="24.2286" x2="144.411" y2="106.775" gradientUnits="userSpaceOnUse">
			<stop stop-color="#559AFF"></stop>
			<stop offset="1" stop-color="#2E69EF"></stop>
			</linearGradient>
			<linearGradient id="paint16_linear_1_12824" x1="74.4524" y1="24.2286" x2="144.411" y2="106.775" gradientUnits="userSpaceOnUse">
			<stop stop-color="#559AFF"></stop>
			<stop offset="1" stop-color="#2E69EF"></stop>
			</linearGradient>
			<linearGradient id="paint17_linear_1_12824" x1="109.716" y1="16.3404" x2="133.462" y2="16.3404" gradientUnits="userSpaceOnUse">
			<stop stop-color="#E9F3FC"></stop>
			<stop offset="1" stop-color="#CADCF0"></stop>
			</linearGradient>
			<linearGradient id="paint18_linear_1_12824" x1="109.716" y1="37.6216" x2="133.462" y2="37.6216" gradientUnits="userSpaceOnUse">
			<stop stop-color="#E9F3FC"></stop>
			<stop offset="1" stop-color="#CADCF0"></stop>
			</linearGradient>
			<linearGradient id="paint19_linear_1_12824" x1="74.4524" y1="24.2285" x2="144.411" y2="106.775" gradientUnits="userSpaceOnUse">
			<stop stop-color="#559AFF"></stop>
			<stop offset="1" stop-color="#2E69EF"></stop>
			</linearGradient>
			</defs>
		</svg>

		<p class="h3"><?php echo esc_html__('Your cart is empty','ovinx');?></p>
		<a class="tf-btn animate-btn d-inline-flex bg-dark-2 w-max-content button wc-backward<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
			<?php
				/**
				 * Filter "Return To Shop" text.
				 *
				 * @since 4.6.0
				 * @param string $default_text Default text.
				 */
				echo esc_html( apply_filters( 'woocommerce_return_to_shop_text', __( 'Return to shop', 'ovinx' ) ) );
			?>
		</a>
    </div>
<?php endif; ?>

<?php
do_action( 'woocommerce_after_cart_empty' );
?>
