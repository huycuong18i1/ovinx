<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package ovinx
 */
?>

<?php  
	$sidebar = themesflat_get_opt( 'blog_sidebar_list' );
	if ( is_page() ) {			
		$sidebar = themesflat_get_opt( 'page_sidebar_list' );			
	}	

	if( 'product' == get_post_type() ){
		$sidebar = 'shop-sidebar';
	}	

	if ( is_search() && function_exists( 'is_woocommerce' ) && is_woocommerce() ) {			
		$sidebar = 'shop-sidebar';			
	}
	
	if (class_exists( 'WooCommerce' ) && is_shop() ) {
		?>	
		<div class="col-xl-3">
			
			<div class="sidebar sidebar-blog d-lg-grid d-none sidebar-content-wrap">
				<?php	  
					themesflat_dynamic_sidebar ( $sidebar ); 
				?>
			</div>
		</div>
	<?php
	} else { 	?>

	<div class="col-lg-4 d-none d-lg-block">
		<div class="blog-sidebar sidebar-content-wrap sticky-top">
			<?php
				themesflat_dynamic_sidebar ( $sidebar );
			?>
		</div>
	</div>
	<?php
	}
?>