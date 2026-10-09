<?php
/**
 * @package ovinx
 */
//Output all custom styles for this theme

function themesflat_custom_styles( $custom ) {
	$custom = '';

	//GROUP FONT
		/*Typography Menu*/	
			$logo_font = themesflat_get_json('typography_logo');
			$logo_fontfamily = $logo_font['family'];
			$logo_fontsize = $logo_font['size'];
			$logo_lineheight = $logo_font['line_height'];
			$logo_letter_spacing = $logo_font['letter_spacing'];
			$logo_style = themesflat_font_style( $logo_font['style'] );
			$logo_font_weight = $logo_style[0];
			$logo_font_style = $logo_style[1];
				
			// font family
			if ( $logo_fontfamily != '') {
				$custom .= ".logo-header .site-title a { font-family:" . $logo_fontfamily . ";}"."\n";
			}
			// font weight
			if ( $logo_font_weight != '' ) {
				$custom .= ".logo-header .site-title a { font-weight:" . $logo_font_weight . ";}"."\n";
			}
			// font style
			if ( isset( $logo_font_style )) {
				$custom .= ".logo-header .site-title a  { font-style:" . $logo_font_style . "; }"."\n";   
			}
			// font size
			if ( $logo_fontsize != '' ) {
				$custom .= ".logo-header .site-title a { font-size:" . intval($logo_fontsize) . "px;}"."\n";
			}
			// line height
			if ( $logo_lineheight != '' ) {
				$custom .= ".logo-header .site-title a { line-height:" . $logo_lineheight . ";}"."\n";
			}
			// letter spacing
			if ( $logo_letter_spacing != '' ) {
				$custom .= ".logo-header .site-title a{ letter-spacing:" . $logo_letter_spacing . ";}"."\n";
			}


		$font = themesflat_get_json('typography_body');

		$font_style = themesflat_font_style($font['style']);

		/*Typography Menu*/	
			$menu_fonts_ = themesflat_get_json('typography_menu');
			$menu_fonts_family = $menu_fonts_['family'];
			$menu_fonts_size = $menu_fonts_['size'];
			$menu_line_height = $menu_fonts_['line_height'];
			$menu_letter_spacing = $menu_fonts_['letter_spacing'];
			$menu_style = themesflat_font_style( $menu_fonts_['style'] );
			$menu_font_weight = $menu_style[0];
			$menu_font_style = $menu_style[1];
				
			// font family
			if ( $menu_fonts_family != '') {
				$custom .= "#mainnav > ul > li > a, .header-modal-menu-left-btn .text, header .flat-information li { font-family:" . $menu_fonts_family . ";}"."\n";
			}
			// font weight
			if ( $menu_font_weight != '' ) {
				$custom .= "#mainnav > ul > li > a, .header-modal-menu-left-btn .text { font-weight:" . $menu_font_weight . ";}"."\n";
			}
			// font style
			if ( isset( $menu_font_style )) {
		        $custom .= "#mainnav > ul > li > a, .header-modal-menu-left-btn .text  { font-style:" . $menu_font_style . "; }"."\n";   
			}
		    // font size
		    if ( $menu_fonts_size != '' ) {
		        $custom .= "#mainnav > ul > li > a, .header-modal-menu-left-btn .text, header .flat-information li { font-size:" . intval($menu_fonts_size) . "px;}"."\n";
		    }
		    // line height
		    if ( $menu_line_height != '' ) {
		        $custom .= "#mainnav > ul > li > a, #header .show-search, header .block a, #header .mini-cart-header .cart-count, #header .mini-cart .cart-count, .button-menu { line-height:" . $menu_line_height . ";}"."\n";
		        
		    }
		    // letter spacing
		    if ( $menu_letter_spacing != '' ) {
		        $custom .= "#mainnav > ul > li > a, #header .show-search a, header .block a, #header .mini-cart-header .cart-count, #header .mini-cart .cart-count, .button-menu { letter-spacing:" . $menu_letter_spacing . ";}"."\n";
		    }

		/*Typography Body*/
			$body_fonts = $font['family'];
			$body_line_height = $font['line_height'];
			$body_font_weight = $font_style[0];
			$body_font_style = $font_style[1];
			$body_size = $font['size'];
			$body_letter_spacing = $font['letter_spacing'];
		
			// font family
			if ( $body_fonts !='' ) {
				$custom .= "body,button,input,select,textarea { font-family:" . $body_fonts . ";}"."\n";
			}

			// font family important
			if ( $body_fonts !='' ) {
				$custom .= ".blog-single .entry-content .icon-list { font-family:" . $body_fonts . "!important;}"."\n";
			}

			// font weight
			if ( $body_font_weight !='' ) {
				$custom .= "body,button,input,select,textarea { font-weight:" . $body_font_weight . ";}"."\n";
			}
			// font style
			if ( isset( $body_font_style ) ) {
		        $custom .= "body,button,input,select,textarea { font-style:" . $body_font_style . "; }"."\n";        
			}
		    // font size
		    if ( $body_size !=''  ) {
		        $custom .= "body,button,input,select,textarea { font-size:" . intval( $body_size ) . "px; }"."\n";    
		    }
		    // line height
		    if ( $body_line_height != '' ) {
		        $custom .= "body,button,input,select,textarea { line-height:" . $body_line_height . ";}"."\n";    
		    }
		    // letter spacing
		    if ( $body_letter_spacing != '' ) {
		        $custom .= "body,button,input,select,textarea { letter-spacing:" . $body_letter_spacing . ";}"."\n";    
		    }

		/*Typography Headings*/
			$headings_fonts_ = themesflat_get_json('typography_headings');
			$headings_fonts_family = $headings_fonts_['family'];
			$headings_style = themesflat_font_style( $headings_fonts_['style'] );
			$headings_font_weight = $headings_style[0];
			$headings_font_style = $headings_style[1];
			$headings_line_height = $headings_fonts_['line_height'];
			$headings_letter_spacing = $headings_fonts_['letter_spacing'];
	    	    	
			// font family
			if ( $headings_fonts_family !='' ) {
				$custom .= "h1,h2,h3,h4,h5,h6 { font-family:" . $headings_fonts_family . ";}"."\n";

			}
			//font weight
			if ( $headings_font_weight !='' ) {
				$custom .= "h1,h2,h3,h4,h5,h6 { font-weight:" . $headings_font_weight . ";}"."\n";
			}
			//line height
			if ( $headings_line_height !='' ) {
				$custom .= "h1,h2,h3,h4,h5,h6 { line-height:" . $headings_line_height . ";}"."\n";
			}
			// letter spacing
			if ( $headings_letter_spacing !='' ) {
				$custom .= "h1,h2,h3,h4,h5,h6 { letter-spacing:" . $headings_letter_spacing . ";}"."\n";
			}
			// font style
			if ( isset( $headings_font_style )) {
		        $custom .= "h1,h2,h3,h4,h5,h6  { font-style:" . $headings_font_style . "; }"."\n";
			}

			// H1 font size
			if ( $h1_size = themesflat_get_opt( 'h1_size' ) ) {
				$custom .= "h1 { font-size:" . intval($h1_size) . "px; }"."\n";
			}
		    // H2 font size
		    if ( $h2_size = themesflat_get_opt( 'h2_size' ) ) {
		        $custom .= "h2 { font-size:" . intval($h2_size) . "px; }"."\n";
		    }
		    // H3 font size
		    if ( $h3_size = themesflat_get_opt( 'h3_size' ) ) {
		        $custom .= "h3 { font-size:" . intval($h3_size) . "px; }"."\n";
		    }
		    // H4 font size
		    if ( $h4_size = themesflat_get_opt( 'h4_size' ) ) {
		        $custom .= "h4 { font-size:" . intval($h4_size) . "px; }"."\n";
		    }
		    // H5 font size
		    if ( $h5_size = themesflat_get_opt( 'h5_size' ) ) {
		        $custom .= "h5 { font-size:" . intval($h5_size) . "px; }"."\n";
		    }
		    // H6 font size
		    if ( $h6_size = themesflat_get_opt( 'h6_size' ) ) {
		        $custom .= "h6 { font-size:" . intval($h6_size) . "px; }"."\n";
		    }

		/*Typography Menu*/	
			$menu_fonts_ = themesflat_get_json('typography_menu');
			$menu_fonts_family = $menu_fonts_['family'];
			$menu_fonts_size = $menu_fonts_['size'];
			$menu_line_height = $menu_fonts_['line_height'];
			$menu_letter_spacing = $menu_fonts_['letter_spacing'];
			$menu_style = themesflat_font_style( $menu_fonts_['style'] );
			$menu_font_weight = $menu_style[0];
			$menu_font_style = $menu_style[1];
				
			// font family
			if ( $menu_fonts_family != '') {
				$custom .= "#mainnav > ul > li > a, .header-modal-menu-left-btn .text, header .flat-information li { font-family:" . $menu_fonts_family . ";}"."\n";
			}
			// font weight
			if ( $menu_font_weight != '' ) {
				$custom .= "#mainnav > ul > li > a, .header-modal-menu-left-btn .text { font-weight:" . $menu_font_weight . ";}"."\n";
			}
			// font style
			if ( isset( $menu_font_style )) {
		        $custom .= "#mainnav > ul > li > a, .header-modal-menu-left-btn .text  { font-style:" . $menu_font_style . "; }"."\n";   
			}
		    // font size
		    if ( $menu_fonts_size != '' ) {
		        $custom .= "#mainnav > ul > li > a, .header-modal-menu-left-btn .text, header .flat-information li { font-size:" . intval($menu_fonts_size) . "px;}"."\n";
		    }
		    // line height
		    if ( $menu_line_height != '' ) {
		        $custom .= "#mainnav > ul > li > a, #header .show-search, header .block a, #header .mini-cart-header .cart-count, #header .mini-cart .cart-count, .button-menu { line-height:" . $menu_line_height . ";}"."\n";
		        
		    }
		    // letter spacing
		    if ( $menu_letter_spacing != '' ) {
		        $custom .= "#mainnav > ul > li > a, #header .show-search a, header .block a, #header .mini-cart-header .cart-count, #header .mini-cart .cart-count, .button-menu { letter-spacing:" . $menu_letter_spacing . ";}"."\n";
		    }

		/*Typography Sub menu*/
			$sub_menu_fonts_ = themesflat_get_json('typography_sub_menu');
			$sub_menu_fonts_family = $sub_menu_fonts_['family'];
			$sub_menu_fonts_size = $sub_menu_fonts_['size'];
			$sub_menu_line_height = $sub_menu_fonts_['line_height'];
			$sub_menu_letter_spacing = $sub_menu_fonts_['letter_spacing'];
			$sub_menu_style = themesflat_font_style( $sub_menu_fonts_['style'] );
			$sub_menu_font_weight = $sub_menu_style[0];
			$sub_menu_font_style = $sub_menu_style[1];
		
			// font family
			if ( $sub_menu_fonts_family != '') {
				$custom .= ".tf-header .box-navigation .sub-menu a { font-family:" . $sub_menu_fonts_family . ";}"."\n";
			}
			// font weight
			if ( $sub_menu_font_weight != '' ) {
				$custom .= ".tf-header .box-navigation .sub-menu a { font-weight:" . $sub_menu_font_weight . ";}"."\n";
			}
			// font style
			if ( isset( $sub_menu_font_style )) {
		        $custom .= ".tf-header .box-navigation .sub-menu a  { font-style:" . $sub_menu_font_style . "; }"."\n";   
			}
		    // font size
		    if ( $sub_menu_fonts_size != '' ) {
		        $custom .= ".tf-header .box-navigation .sub-menu a { font-size:" . intval($sub_menu_fonts_size) . "px;}"."\n";
		    }
		    // line height
		    if ( $sub_menu_line_height != '' ) {
		        $custom .= ".tf-header .box-navigation .sub-menu a { line-height:" . $sub_menu_line_height . ";}"."\n";
		    } 
		    // letter spacing
		    if ( $sub_menu_letter_spacing != '' ) {
		        $custom .= ".tf-header .box-navigation .sub-menu a { letter-spacing:" . $sub_menu_letter_spacing . ";}"."\n";
		    } 

		/*Typography Blockquote*/	
		    $blockquote_fonts_ = themesflat_get_json('typography_blockquote');
			$blockquote_fonts_family = $blockquote_fonts_['family'];
			$blockquote_fonts_size = $blockquote_fonts_['size'];
			$blockquote_line_height = $blockquote_fonts_['line_height'];
			$blockquote_letter_spacing = $blockquote_fonts_['letter_spacing'];
			$blockquote_style = themesflat_font_style( $blockquote_fonts_['style'] );
			$blockquote_font_weight = $blockquote_style[0];
			$blockquote_font_style = $blockquote_style[1]; 
			// font family
			if ( $blockquote_fonts_family != '') {
				$custom .= "blockquote, blockquote p, .wp-block-quote p, .s-blog-detail .main-post blockquote p { font-family:" . $blockquote_fonts_family . ";}"."\n";
			}
			// font weight
			if ( $blockquote_font_weight != '' ) {
				$custom .= "blockquote, blockquote p, .wp-block-quote p, .s-blog-detail .main-post blockquote p { font-weight:" . $blockquote_font_weight . ";}"."\n";
			}
			// font style
			if ( isset( $blockquote_font_style )) {
		        $custom .= "blockquote, blockquote p, .wp-block-quote p, .s-blog-detail .main-post blockquote p { font-style:" . $blockquote_font_style . "; }"."\n";  
			}
		    // font size
		    if ( $blockquote_fonts_size != '' ) {
		        $custom .= "blockquote, blockquote p, .wp-block-quote p, .s-blog-detail .main-post blockquote p { font-size:" . intval($blockquote_fonts_size) . "px;}"."\n";
		    }
		    // line height
		    if ( $blockquote_line_height != '' ) {
		        $custom .= "blockquote, blockquote p, .wp-block-quote p, .s-blog-detail .main-post blockquote p { line-height:" . $blockquote_line_height . ";}"."\n";
		    } 
		    // letter spacing
		    if ( $blockquote_letter_spacing != '' ) {
		        $custom .= "blockquote, blockquote p, .wp-block-quote p, .s-blog-detail .main-post blockquote p { letter-spacing:" . $blockquote_letter_spacing . ";}"."\n";
		    }

		/*Typography blog post title*/ 
			$blog_post_title_fonts_ = themesflat_get_json('typography_blog_post_title');
			$blog_post_title_fonts_family = $blog_post_title_fonts_['family'];
			$blog_post_title_fonts_size = $blog_post_title_fonts_['size'];
			$blog_post_title_line_height = $blog_post_title_fonts_['line_height'];
			$blog_post_title_letter_spacing = $blog_post_title_fonts_['letter_spacing'];
			$blog_post_title_style = themesflat_font_style( $blog_post_title_fonts_['style'] );
			$blog_post_title_font_weight = $blog_post_title_style[0];
			$blog_post_title_font_style = $blog_post_title_style[1]; 
			// font family
			if ( $blog_post_title_fonts_family != '') {
				$custom .= "article .entry-title { font-family:" . $blog_post_title_fonts_family . ";}"."\n";
			}
			// font weight
			if ( $blog_post_title_font_weight != '' ) {
				$custom .= "article .entry-title { font-weight:" . $blog_post_title_font_weight . ";}"."\n";
			}
			// font style
			if ( isset( $blog_post_title_font_style )) {
		        $custom .= "article .entry-title { font-style:" . $blog_post_title_font_style . "; }"."\n";  
			}
		    // font size
		    if ( $blog_post_title_fonts_size != '' ) {
		        $custom .= "article .entry-title { font-size:" . intval($blog_post_title_fonts_size) . "px;}"."\n";
		    }
		    // line height
		    if ( $blog_post_title_line_height != '' ) {
		        $custom .= "article .entry-title { line-height:" . $blog_post_title_line_height . ";}"."\n";
		    } 
		    // letter spacing
		    if ( $blog_post_title_letter_spacing != '' ) {
		        $custom .= "article .entry-title { letter-spacing:" . $blog_post_title_letter_spacing . ";}"."\n";
		    }

		/*Typography blog post title*/ 
			$blog_post_meta_fonts_ = themesflat_get_json('typography_blog_post_meta');
			$blog_post_meta_fonts_family = $blog_post_meta_fonts_['family'];
			$blog_post_meta_fonts_size = $blog_post_meta_fonts_['size'];
			$blog_post_meta_line_height = $blog_post_meta_fonts_['line_height'];
			$blog_post_meta_letter_spacing = $blog_post_meta_fonts_['letter_spacing'];
			$blog_post_meta_style = themesflat_font_style( $blog_post_meta_fonts_['style'] );
			$blog_post_meta_font_weight = $blog_post_meta_style[0];
			$blog_post_meta_font_style = $blog_post_meta_style[1]; 
			// font family
			if ( $blog_post_meta_fonts_family != '') {
				$custom .= ".tf-grid-layout.wrap-blog-article .content-post .entry_meta { font-family:" . $blog_post_meta_fonts_family . ";}"."\n";
			}
			// font weight
			if ( $blog_post_meta_font_weight != '' ) {
				$custom .= ".tf-grid-layout.wrap-blog-article .content-post .entry_meta { font-weight:" . $blog_post_meta_font_weight . ";}"."\n";
			}
			// font style
			if ( isset( $blog_post_meta_font_style )) {
		        $custom .= ".tf-grid-layout.wrap-blog-article .content-post .entry_meta { font-style:" . $blog_post_meta_font_style . "; }"."\n";  
			}
		    // font size
		    if ( $blog_post_meta_fonts_size != '' ) {
		        $custom .= ".tf-grid-layout.wrap-blog-article .content-post .entry_meta { font-size:" . intval($blog_post_meta_fonts_size) . "px;}"."\n";
		    }
		    // line height
		    if ( $blog_post_meta_line_height != '' ) {
		        $custom .= ".tf-grid-layout.wrap-blog-article .content-post .entry_meta { line-height:" . $blog_post_meta_line_height . ";}"."\n";
		    } 
		    // letter spacing
		    if ( $blog_post_meta_letter_spacing != '' ) {
		        $custom .= ".tf-grid-layout.wrap-blog-article .content-post .entry_meta { letter-spacing:" . $blog_post_meta_letter_spacing . ";}"."\n";
		    }

		/*Typography blog post buttons*/	
		    $blog_post_buttons_fonts_ = themesflat_get_json('typography_blog_post_buttons');
			$blog_post_buttons_fonts_family = $blog_post_buttons_fonts_['family'];
			$blog_post_buttons_fonts_size = $blog_post_buttons_fonts_['size'];
			$blog_post_buttons_line_height = $blog_post_buttons_fonts_['line_height'];
			$blog_post_buttons_letter_spacing = $blog_post_buttons_fonts_['letter_spacing'];
			$blog_post_buttons_style = themesflat_font_style( $blog_post_buttons_fonts_['style'] );
			$blog_post_buttons_font_weight = $blog_post_buttons_style[0];
			$blog_post_buttons_font_style = $blog_post_buttons_style[1]; 
			// font family
			if ( $blog_post_buttons_fonts_family != '') {
				$custom .= "article .themesflat-button { font-family:" . $blog_post_buttons_fonts_family . ";}"."\n";
			}
			// font weight
			if ( $blog_post_buttons_font_weight != '' ) {
				$custom .= "article .themesflat-button { font-weight:" . $blog_post_buttons_font_weight . ";}"."\n";
			}
			// font style
			if ( isset( $blog_post_buttons_font_style )) {
		        $custom .= "article .themesflat-button { font-style:" . $blog_post_buttons_font_style . "; }"."\n";  
			}
		    // font size
		    if ( $blog_post_buttons_fonts_size != '' ) {
		        $custom .= "article .themesflat-button { font-size:" . intval($blog_post_buttons_fonts_size) . "px;}"."\n";
		    }
		    // line height
		    if ( $blog_post_buttons_line_height != '' ) {
		        $custom .= "article .themesflat-button { line-height:" . $blog_post_buttons_line_height . ";}"."\n";
		    } 
		    // letter spacing
		    if ( $blog_post_buttons_letter_spacing != '' ) {
		        $custom .= "article .themesflat-button { letter-spacing:" . $blog_post_buttons_letter_spacing . ";}"."\n";
		    }

		/*Typography blog single title*/	
		    $blog_single_title_fonts_ = themesflat_get_json('typography_blog_single_title');
			$blog_single_title_fonts_family = $blog_single_title_fonts_['family'];
			$blog_single_title_fonts_size = $blog_single_title_fonts_['size'];
			$blog_single_title_line_height = $blog_single_title_fonts_['line_height'];
			$blog_single_title_letter_spacing = $blog_single_title_fonts_['letter_spacing'];
			$blog_single_title_style = themesflat_font_style( $blog_single_title_fonts_['style'] );
			$blog_single_title_font_weight = $blog_single_title_style[0];
			$blog_single_title_font_style = $blog_single_title_style[1]; 
			// font family
			if ( $blog_single_title_fonts_family != '') {
				$custom .= ".blog-single .entry-title { font-family:" . $blog_single_title_fonts_family . ";}"."\n";
			}
			// font weight
			if ( $blog_single_title_font_weight != '' ) {
				$custom .= ".blog-single .entry-title { font-weight:" . $blog_single_title_font_weight . ";}"."\n";
			}
			// font style
			if ( isset( $blog_single_title_font_style )) {
		        $custom .= ".blog-single .entry-title { font-style:" . $blog_single_title_font_style . "; }"."\n";  
			}
		    // font size
		    if ( $blog_single_title_fonts_size != '' ) {
		        $custom .= ".blog-single .entry-title { font-size:" . intval($blog_single_title_fonts_size) . "px;}"."\n";
		    }
		    // line height
		    if ( $blog_single_title_line_height != '' ) {
		        $custom .= ".blog-single .entry-title { line-height:" . $blog_single_title_line_height . ";}"."\n";
		    } 
		    // letter spacing
		    if ( $blog_single_title_letter_spacing != '' ) {
		        $custom .= ".blog-single .entry-title { letter-spacing:" . $blog_single_title_letter_spacing . ";}"."\n";
		    }

		/*Typography sidebar widget title*/
		    $sidebar_widget_title_fonts_ = themesflat_get_json('typography_sidebar_widget_title');
			$sidebar_widget_title_fonts_family = $sidebar_widget_title_fonts_['family'];
			$sidebar_widget_title_fonts_size = $sidebar_widget_title_fonts_['size'];
			$sidebar_widget_title_line_height = $sidebar_widget_title_fonts_['line_height'];
			$sidebar_widget_title_letter_spacing = $sidebar_widget_title_fonts_['letter_spacing'];
			$sidebar_widget_title_style = themesflat_font_style( $sidebar_widget_title_fonts_['style'] );
			$sidebar_widget_title_font_weight = $sidebar_widget_title_style[0];
			$sidebar_widget_title_font_style = $sidebar_widget_title_style[1]; 
			// font family
			if ( $sidebar_widget_title_fonts_family != '') {
				$custom .= ".sidebar-item .sb-title { font-family:" . $sidebar_widget_title_fonts_family . ";}"."\n";
			}
			// font weight
			if ( $sidebar_widget_title_font_weight != '' ) {
				$custom .= ".sidebar-item .sb-title { font-weight:" . $sidebar_widget_title_font_weight . ";}"."\n";
			}
			// font style
			if ( isset( $sidebar_widget_title_font_style )) {
		        $custom .= ".sidebar-item .sb-title { font-style:" . $sidebar_widget_title_font_style . "; }"."\n";
			}
		    // font size
		    if ( $sidebar_widget_title_fonts_size != '' ) {
		        $custom .= ".sidebar-item .sb-title { font-size:" . intval($sidebar_widget_title_fonts_size) . "px;}"."\n";
		    }
		    // line height
		    if ( $sidebar_widget_title_line_height != '' ) {
		        $custom .= ".sidebar-item .sb-title { line-height:" . $sidebar_widget_title_line_height . ";}"."\n";
		    }
		    // letter spacing
		    if ( $sidebar_widget_title_letter_spacing != '' ) {
		        $custom .= ".sidebar-item .sb-title { letter-spacing:" . $sidebar_widget_title_letter_spacing . ";}"."\n";
		    }

		/*Typography footer widget title*/	
		    $footer_widget_title_fonts_ = themesflat_get_json('typography_footer_widget_title');
			$footer_widget_title_fonts_family = $footer_widget_title_fonts_['family'];
			$footer_widget_title_fonts_size = $footer_widget_title_fonts_['size'];
			$footer_widget_title_line_height = $footer_widget_title_fonts_['line_height'];
			$footer_widget_title_letter_spacing = $footer_widget_title_fonts_['letter_spacing'];
			$footer_widget_title_style = themesflat_font_style( $footer_widget_title_fonts_['style'] );
			$footer_widget_title_font_weight = $footer_widget_title_style[0];
			$footer_widget_title_font_style = $footer_widget_title_style[1]; 
			// font family
			if ( $footer_widget_title_fonts_family != '') {
				$custom .= "footer .widget .widget-title, footer .widget h2, footer .widget h3, footer .widget h4, footer .widget h5, footer .widget h6, footer .wp-block-search .wp-block-search__label { font-family:" . $footer_widget_title_fonts_family . ";}"."\n";
			}
			// font weight
			if ( $footer_widget_title_font_weight != '' ) {
				$custom .= "footer .widget .widget-title, footer .widget h2, footer .widget h3, footer .widget h4, footer .widget h5, footer .widget h6, footer .wp-block-search .wp-block-search__label { font-weight:" . $footer_widget_title_font_weight . ";}"."\n";
			}
			// font style
			if ( isset( $footer_widget_title_font_style )) {
		        $custom .= "footer .widget .widget-title, footer .widget h2, footer .widget h3, footer .widget h4, footer .widget h5, footer .widget h6, footer .wp-block-search .wp-block-search__label { font-style:" . $footer_widget_title_font_style . "; }"."\n";
			}
		    // font size
		    if ( $footer_widget_title_fonts_size != '' ) {
		        $custom .= "footer .widget .widget-title, footer .widget h2, footer .widget h3, footer .widget h4, footer .widget h5, footer .widget h6, footer .wp-block-search .wp-block-search__label { font-size:" . intval($footer_widget_title_fonts_size) . "px;}"."\n";
		    }
		    // line height
		    if ( $footer_widget_title_line_height != '' ) {
		        $custom .= "footer .widget .widget-title, footer .widget h2, footer .widget h3, footer .widget h4, footer .widget h5, footer .widget h6, footer .wp-block-search .wp-block-search__label { line-height:" . $footer_widget_title_line_height . ";}"."\n";
		    }
		    // letter spacing
		    if ( $footer_widget_title_letter_spacing != '' ) {
		        $custom .= "footer .widget .widget-title, footer .widget h2, footer .widget h3, footer .widget h4, footer .widget h5, footer .widget h6, footer .wp-block-search .wp-block-search__label { letter-spacing:" . $footer_widget_title_letter_spacing . ";}"."\n";
		    }

		/*Typography page title*/	
		    $page_title_fonts_ = themesflat_get_json('typography_page_title');
			$page_title_fonts_family = $page_title_fonts_['family'];
			$page_title_fonts_size = $page_title_fonts_['size'];
			$page_title_line_height = $page_title_fonts_['line_height'];
			$page_title_letter_spacing = $page_title_fonts_['letter_spacing'];
			$page_title_style = themesflat_font_style( $page_title_fonts_['style'] );
			$page_title_font_weight = $page_title_style[0];
			$page_title_font_style = $page_title_style[1]; 
			// font family
			if ( $page_title_fonts_family != '') {
				$custom .= ".page-title .heading { font-family:" . $page_title_fonts_family . " !important;}"."\n";
			}
			// font weight
			if ( $page_title_font_weight != '' ) {
				$custom .= ".page-title .heading { font-weight:" . $page_title_font_weight . " !important;}"."\n";
			}
			// font style
			if ( isset( $page_title_font_style )) {
		        $custom .= ".page-title .heading { font-style:" . $page_title_font_style . " !important; }"."\n";  
			}
		    // font size
		    if ( $page_title_fonts_size != '' ) {
		        $custom .= ".page-title .heading { font-size:" . intval($page_title_fonts_size) . "px !important;}"."\n";
		    }
		    // line height
		    if ( $page_title_line_height != '' ) {
		        $custom .= ".page-title .heading { line-height:" . $page_title_line_height . " !important;}"."\n";
		    } 
		    // letter spacing
		    if ( $page_title_letter_spacing != '' ) {
		        $custom .= ".page-title .heading { letter-spacing:" . $page_title_letter_spacing . " !important;}"."\n";
		    }

		/*Typography breadcrumb*/	
		    $breadcrumb_fonts_ = themesflat_get_json('typography_breadcrumb');
			$breadcrumb_fonts_family = $breadcrumb_fonts_['family'];
			$breadcrumb_fonts_size = $breadcrumb_fonts_['size'];
			$breadcrumb_line_height = $breadcrumb_fonts_['line_height'];
			$breadcrumb_letter_spacing = $breadcrumb_fonts_['letter_spacing'];
			$breadcrumb_style = themesflat_font_style( $breadcrumb_fonts_['style'] );
			$breadcrumb_font_weight = $breadcrumb_style[0];
			$breadcrumb_font_style = $breadcrumb_style[1]; 
			// font family
			if ( $breadcrumb_fonts_family != '') {
				$custom .= ".breadcrumbs, .breadcrumbs span a, .breadcrumbs a, .breadcrumbs span { font-family:" . $breadcrumb_fonts_family . ";}"."\n";
			}
			// font weight
			if ( $breadcrumb_font_weight != '' ) {
				$custom .= ".breadcrumbs, .breadcrumbs span a, .breadcrumbs a, .breadcrumbs span { font-weight:" . $breadcrumb_font_weight . ";}"."\n";
			}
			// font style
			if ( isset( $breadcrumb_font_style )) {
		        $custom .= ".breadcrumbs, .breadcrumbs span a, .breadcrumbs a, .breadcrumbs span { font-style:" . $breadcrumb_font_style . "; }"."\n";  
			}
		    // font size
		    if ( $breadcrumb_fonts_size != '' ) {
		        $custom .= ".breadcrumbs, .breadcrumbs span a, .breadcrumbs a, .breadcrumbs span { font-size:" . intval($breadcrumb_fonts_size) . "px;}"."\n";
		    }
		    // line height
		    if ( $breadcrumb_line_height != '' ) {
		        $custom .= ".breadcrumbs, .breadcrumbs span a, .breadcrumbs a, .breadcrumbs span { line-height:" . $breadcrumb_line_height . ";}"."\n";
		    } 
		    // letter spacing
		    if ( $breadcrumb_letter_spacing != '' ) {
		        $custom .= ".breadcrumbs, .breadcrumbs span a, .breadcrumbs a, .breadcrumbs span { letter-spacing:" . $breadcrumb_letter_spacing . ";}"."\n";
		    }

		/*Typography buttons*/	
		    $buttons_fonts_ = themesflat_get_json('typography_buttons');
			$buttons_fonts_family = $buttons_fonts_['family'];
			$buttons_fonts_size = $buttons_fonts_['size'];
			$buttons_line_height = $buttons_fonts_['line_height'];
			$buttons_letter_spacing = $buttons_fonts_['letter_spacing'];
			$buttons_style = themesflat_font_style( $buttons_fonts_['style'] );
			$buttons_font_weight = $buttons_style[0];
			$buttons_font_style = $buttons_style[1]; 
			// font family
			if ( $buttons_fonts_family != '') {
				$custom .= ".themesflat-button, .tf-btn, button, input[type=\"button\"], input[type=\"reset\"], input[type=\"submit\"] { font-family:" . $buttons_fonts_family . ";}"."\n";
			}
			// font weight
			if ( $buttons_font_weight != '' ) {
				$custom .= ".themesflat-button, .tf-btn, button, input[type=\"button\"], input[type=\"reset\"], input[type=\"submit\"] { font-weight:" . $buttons_font_weight . ";}"."\n";
			}
			// font style
			if ( isset( $buttons_font_style )) {
		        $custom .= ".themesflat-button, .tf-btn, button, input[type=\"button\"], input[type=\"reset\"], input[type=\"submit\"] { font-style:" . $buttons_font_style . "; }"."\n";  
			}
		    // font size
		    if ( $buttons_fonts_size != '' ) {
		        $custom .= ".themesflat-button, .tf-btn, button, input[type=\"button\"], input[type=\"reset\"], input[type=\"submit\"] { font-size:" . intval($buttons_fonts_size) . "px;}"."\n";
		    }
		    // line height
		    if ( $buttons_line_height != '' ) {
		        $custom .= ".themesflat-button, .tf-btn, button, input[type=\"button\"], input[type=\"reset\"], input[type=\"submit\"] { line-height:" . $buttons_line_height . ";}"."\n";
		    } 
		    // letter spacing
		    if ( $buttons_letter_spacing != '' ) {
		        $custom .= ".themesflat-button, .tf-btn, button, input[type=\"button\"], input[type=\"reset\"], input[type=\"submit\"] { letter-spacing:" . $buttons_letter_spacing . ";}"."\n";
		    }

		/*Typography pagination*/	
		    $pagination_fonts_ = themesflat_get_json('typography_pagination');
			$pagination_fonts_family = $pagination_fonts_['family'];
			$pagination_fonts_size = $pagination_fonts_['size'];
			$pagination_line_height = $pagination_fonts_['line_height'];
			$pagination_letter_spacing = $pagination_fonts_['letter_spacing'];
			$pagination_style = themesflat_font_style( $pagination_fonts_['style'] );
			$pagination_font_weight = $pagination_style[0];
			$pagination_font_style = $pagination_style[1]; 
			// font family
			if ( $pagination_fonts_family != '') {
				$custom .= ".tf-pagination .pag-item, .wg-pagination .page-numbers { font-family:" . $pagination_fonts_family . ";}"."\n";
			}
			// font weight
			if ( $pagination_font_weight != '' ) {
				$custom .= ".tf-pagination .pag-item, .wg-pagination .page-numbers { font-weight:" . $pagination_font_weight . ";}"."\n";
			}
			// font style
			if ( isset( $pagination_font_style )) {
		        $custom .= ".tf-pagination .pag-item, .wg-pagination .page-numbers { font-style:" . $pagination_font_style . "; }"."\n";  
			}
		    // font size
		    if ( $pagination_fonts_size != '' ) {
		        $custom .= ".tf-pagination .pag-item, .wg-pagination .page-numbers { font-size:" . intval($pagination_fonts_size) . "px;}"."\n";
		    }
		    // line height
		    if ( $pagination_line_height != '' ) {
		        $custom .= ".tf-pagination .pag-item, .wg-pagination .page-numbers { line-height:" . $pagination_line_height . ";}"."\n";
		    } 
		    // letter spacing
		    if ( $pagination_letter_spacing != '' ) {
		        $custom .= ".tf-pagination .pag-item, .wg-pagination .page-numbers { letter-spacing:" . $pagination_letter_spacing . ";}"."\n";
		    }

		/*Typography footer*/
		$footer_fonts_ = themesflat_get_json('typography_footer');
		$footer_fonts_family = $footer_fonts_['family'];
		$footer_fonts_size = $footer_fonts_['size'];
		$footer_line_height = $footer_fonts_['line_height'];
		$footer_letter_spacing = $footer_fonts_['letter_spacing'];
		$footer_style = themesflat_font_style( $footer_fonts_['style'] );
		$footer_font_weight = $footer_style[0];
		$footer_font_style = $footer_style[1]; 
		// font family
		if ( $footer_fonts_family != '') {
			$custom .= "#footer { font-family:" . $footer_fonts_family . ";}"."\n";
		}
		// font weight
		if ( $footer_font_weight != '' ) {
			$custom .= "#footer { font-weight:" . $footer_font_weight . ";}"."\n";
		}
		// font style
		if ( isset( $footer_font_style )) {
			$custom .= "#footer { font-style:" . $footer_font_style . "; }"."\n";
		}
		// font size
		if ( $footer_fonts_size != '' ) {
			$custom .= "#footer { font-size:" . intval($footer_fonts_size) . "px;}"."\n";
		}
		// line height
		if ( $footer_line_height != '' ) {
			$custom .= "#footer { line-height:" . $footer_line_height . ";}"."\n";
		}
		// letter spacing
		if ( $footer_letter_spacing != '' ) {
			$custom .= "#footer { letter-spacing:" . $footer_letter_spacing . ";}"."\n";
		}
		/*Typography copyright*/	
		    $copyright_fonts_ = themesflat_get_json('typography_bottom_copyright');
			$copyright_fonts_family = $copyright_fonts_['family'];
			$copyright_fonts_size = $copyright_fonts_['size'];
			$copyright_line_height = $copyright_fonts_['line_height'];
			$copyright_letter_spacing = $copyright_fonts_['letter_spacing'];
			$copyright_style = themesflat_font_style( $copyright_fonts_['style'] );
			$copyright_font_weight = $copyright_style[0];
			$copyright_font_style = $copyright_style[1]; 
			// font family
			if ( $copyright_fonts_family != '') {
				$custom .= ".text-copy { font-family:" . $copyright_fonts_family . ";}"."\n";
			}
			// font weight
			if ( $copyright_font_weight != '' ) {
				$custom .= ".text-copy { font-weight:" . $copyright_font_weight . ";}"."\n";
			}
			// font style
			if ( isset( $copyright_font_style )) {
		        $custom .= ".text-copy { font-style:" . $copyright_font_style . "; }"."\n";
			}
		    // font size
		    if ( $copyright_fonts_size != '' ) {
		        $custom .= ".text-copy { font-size:" . intval($copyright_fonts_size) . "px;}"."\n";
		    }
		    // line height
		    if ( $copyright_line_height != '' ) {
		        $custom .= ".text-copy { line-height:" . $copyright_line_height . ";}"."\n";
		    }
		    // letter spacing
		    if ( $copyright_letter_spacing != '' ) {
		        $custom .= ".text-copy { letter-spacing:" . $copyright_letter_spacing . ";}"."\n";
		    }

		/*Typography bottom menu*/	
		    $bottom_menu_fonts_ = themesflat_get_json('typography_bottom_menu');
			$bottom_menu_fonts_family = $bottom_menu_fonts_['family'];
			$bottom_menu_fonts_size = $bottom_menu_fonts_['size'];
			$bottom_menu_line_height = $bottom_menu_fonts_['line_height'];
			$bottom_menu_letter_spacing = $bottom_menu_fonts_['letter_spacing'];
			$bottom_menu_style = themesflat_font_style( $bottom_menu_fonts_['style'] );
			$bottom_menu_font_weight = $bottom_menu_style[0];
			$bottom_menu_font_style = $bottom_menu_style[1]; 
			// font family
			if ( $bottom_menu_fonts_family != '') {
				$custom .= ".footer-bottom_wrap .tf-list a { font-family:" . $bottom_menu_fonts_family . ";}"."\n";
			}
			// font weight
			if ( $bottom_menu_font_weight != '' ) {
				$custom .= ".footer-bottom_wrap .tf-list a { font-weight:" . $bottom_menu_font_weight . ";}"."\n";
			}
			// font style
			if ( isset( $bottom_menu_font_style )) {
		        $custom .= ".footer-bottom_wrap .tf-list a { font-style:" . $bottom_menu_font_style . "; }"."\n";
			}
		    // font size
		    if ( $bottom_menu_fonts_size != '' ) {
		        $custom .= ".footer-bottom_wrap .tf-list a { font-size:" . intval($bottom_menu_fonts_size) . "px;}"."\n";
		    }
		    // line height
		    if ( $bottom_menu_line_height != '' ) {
		        $custom .= ".footer-bottom_wrap .tf-list a { line-height:" . $bottom_menu_line_height . ";}"."\n";
		    }
		    // letter spacing
		    if ( $bottom_menu_letter_spacing != '' ) {
		        $custom .= ".footer-bottom_wrap .tf-list a { letter-spacing:" . $bottom_menu_letter_spacing . ";}"."\n";
		    }
	//GROUP LAYOUT
		$content_controls = themesflat_decode(themesflat_get_opt('content_controls'));
	    themesflat_render_box_position("#themesflat-content",$content_controls);

	
	//GROUP TOP BAR 
	    if ( themesflat_get_opt( 'topbar_background_color' ) !='' ) {
			$custom .= ".tf-topbar { background:" . esc_attr(themesflat_get_opt ('topbar_background_color')) ." !important ; } "."\n";
	    }

	    if ( themesflat_get_opt( 'topbar_textcolor' ) !='' ) {
			$custom .= ".tf-topbar, .tf-topbar .tf-dropdown-select.style-default>.dropdown-toggle::after, .tf-topbar .nav-prev-swiper, .tf-topbar .tf-dropdown-select.style-default .filter-option-inner-inner, .tf-topbar .nav-next-swiper, .tf-topbar .item a, .tf-topbar ul .menu-item a, .tf-topbar .item a, .tf-topbar .menu-fallback, .tf-topbar .text-adver, .tf-topbar .tf-social-icon-2 a  { color:" . esc_attr( themesflat_get_opt( 'topbar_textcolor' ) ) ." !important;} "."\n";
	    }
	    $topbar_controls = themesflat_decode(themesflat_get_opt('topbar_controls'));

		// Announcement Bar (promo_topbar_style == 'style-text', marquee variant, tpl/promo-bar.php)
		if ( themesflat_get_opt( 'promo_background_color' ) !='' ) {
			$custom .= ".tf-promo-bar .infiniteSlide-text-v03, .tf-slider-promo { background:" . esc_attr(themesflat_get_opt ('promo_background_color')) ." !important ; } "."\n";
	    }

	    if ( themesflat_get_opt( 'promo_textcolor' ) !='' ) {
			$custom .= ".tf-promo-bar .infiniteSlide-text-v03 .text a, .tf-slider-promo .nav-prev-swiper, .tf-slider-promo .nav-next-swiper, .tf-slider-promo .text-caption-01 { color:" . esc_attr( themesflat_get_opt( 'promo_textcolor' ) ) ." !important;} "."\n";
	    }


	    themesflat_render_box_position(".tf-main-topbar",$topbar_controls);
	    /*Typography Topbar*/
		    $topbar_fonts_ = themesflat_get_json('typography_topbar');
			$topbar_fonts_family = $topbar_fonts_['family'];
			$topbar_fonts_size = $topbar_fonts_['size'];
			$topbar_line_height = $topbar_fonts_['line_height'];
			$topbar_letter_spacing = $topbar_fonts_['letter_spacing'];
			$topbar_style = themesflat_font_style( $topbar_fonts_['style'] );
			$topbar_font_weight = $topbar_style[0];
			$topbar_font_style = $topbar_style[1];
			// font family
			if ( $topbar_fonts_family != '') {
				$custom .= ".tf-topbar, .tf-topbar .item a, .tf-topbar .tf-dropdown-select.style-default .filter-option-inner-inner, .tf-topbar .text-adver { font-family:" . $topbar_fonts_family . " !important;}"."\n";
			}
			// font weight
			if ( $topbar_font_weight != '' ) {
				$custom .= ".tf-topbar, .tf-topbar .item a, .tf-topbar .tf-dropdown-select.style-default .filter-option-inner-inner, .tf-topbar .text-adver { font-weight:" . $topbar_font_weight . " !important;}"."\n";
			}
			// font style
			if ( isset( $topbar_font_style )) {
		        $custom .= ".tf-topbar, .tf-topbar .item a, .tf-topbar .tf-dropdown-select.style-default .filter-option-inner-inner, .tf-topbar .text-adver { font-style:" . $topbar_font_style . " !important; }"."\n";
			}
		    // font size
		    if ( $topbar_fonts_size != '' ) {
		        $custom .= ".tf-topbar, .tf-topbar .item a, .tf-topbar .tf-dropdown-select.style-default .filter-option-inner-inner, .tf-topbar .text-adver { font-size:" . intval($topbar_fonts_size) . "px;}"."\n";
		    }
		    // line height
		    if ( $topbar_line_height != '' ) {
		        $custom .= ".tf-topbar, .tf-topbar .item a, .tf-topbar .tf-dropdown-select.style-default .filter-option-inner-inner, .tf-topbar .text-adver { line-height:" . $topbar_line_height . " !important;}"."\n";
		    }
		    // letter spacing
		    if ( $topbar_letter_spacing != '' ) {
		        $custom .= ".tf-topbar, .tf-topbar .item a, .tf-topbar .tf-dropdown-select.style-default .filter-option-inner-inner, .tf-topbar .text-adver { letter-spacing:" . $topbar_letter_spacing . " !important;}"."\n";
		    }

			// announcement (promo_topbar_style: both style-text .tf-promo-bar marquee AND style-slides .tf-slider-promo)
			$announcement_fonts_ = themesflat_get_json('typography_promo');
			$announcement_fonts_family = $announcement_fonts_['family'];
			$announcement_fonts_size = $announcement_fonts_['size'];
			$announcement_line_height = $announcement_fonts_['line_height'];
			$announcement_letter_spacing = $announcement_fonts_['letter_spacing'];
			$announcement_style = themesflat_font_style( $announcement_fonts_['style'] );
			$announcement_font_weight = $announcement_style[0];
			$announcement_font_style = $announcement_style[1];
			// font family
			if ( $announcement_fonts_family != '') {
				$custom .= ".tf-promo-bar .infiniteSlide-text-v03 .text a, .tf-slider-promo .text-caption-01  { font-family:" . $announcement_fonts_family . " !important;}"."\n";
			}
			// font weight
			if ( $announcement_font_weight != '' ) {
				$custom .= ".tf-promo-bar .infiniteSlide-text-v03 .text a, .tf-slider-promo .text-caption-01 { font-weight:" . $announcement_font_weight . " !important;}"."\n";
			}
			// font style
			if ( isset( $announcement_font_style )) {
		        $custom .= ".tf-promo-bar .infiniteSlide-text-v03 .text a, .tf-slider-promo .text-caption-01 { font-style:" . $announcement_font_style . " !important; }"."\n";
			}
		    // font size
		    if ( $announcement_fonts_size != '' ) {
		        $custom .= ".tf-promo-bar .infiniteSlide-text-v03 .text a, .tf-slider-promo .text-caption-01 { font-size:" . intval($announcement_fonts_size) . "px;}"."\n";
		    }
		    // line height
		    if ( $announcement_line_height != '' ) {
		        $custom .= ".tf-promo-bar .infiniteSlide-text-v03 .text a, .tf-slider-promo .text-caption-01 { line-height:" . $announcement_line_height . " !important;}"."\n";
		    }
		    // letter spacing
		    if ( $announcement_letter_spacing != '' ) {
		        $custom .= ".tf-promo-bar .infiniteSlide-text-v03 .text a, .tf-slider-promo .text-caption-01 { letter-spacing:" . $announcement_letter_spacing . " !important;}"."\n";
		    }

	//GROUP HEADER
	    $header_backgroundcolor = themesflat_get_opt( 'header_backgroundcolor');
		if ( $header_backgroundcolor !='' ) {
			$custom .= ".tf-header { background:" . esc_attr($header_backgroundcolor) . ";}"."\n";
		}

		$header_backgroundcolor_bottom = themesflat_get_opt( 'header_backgroundcolor_bottom');
		if ( $header_backgroundcolor_bottom !='' ) {
			$custom .= ".header-inner { background:" . esc_attr($header_backgroundcolor_bottom) . " !important;}"."\n";
		}


		$header_backgroundcolor_sticky = themesflat_get_opt( 'header_backgroundcolor_sticky');
		if ( $header_backgroundcolor_sticky !='' ) {
			$custom .= ".tf-header.header-fix { background:" . esc_attr( $header_backgroundcolor_sticky ) . " !important;    backdrop-filter: blur(12px);}"."\n";
		}

		// Header inner text/icon color — real elements inside .header-inner (mobile toggle icon, "Need help" text/phone link,
		// account/wishlist/cart icons) all hardcode text-white/#fff with no Customizer hook, verified via getComputedStyle.
		$header_inner_text_color = themesflat_get_opt( 'header_inner_text_color');
		if ( $header_inner_text_color !='' ) {
			$custom .= ".header-inner .box-btn-open-menu .icon, .header-inner .nead-help-wrap, .header-inner .nead-help-wrap a, .header-inner .nav-icon-list .nav-icon-item { color:" . esc_attr($header_inner_text_color) . " !important;}"."\n";
		}

		// "Today's Deal" text (header_special_offers raw text field, default markup uses .deal-link, see options-definition.php)
		$header_special_offers_color = themesflat_get_opt( 'header_special_offers_color');
		if ( $header_special_offers_color !='' ) {
			$custom .= ".deal-link, .deal-link .text { color:" . esc_attr($header_special_offers_color) . " !important;}"."\n";
		}

		$mainnav_color = themesflat_get_opt( 'mainnav_color');
		if ( $mainnav_color !='' ) {
			$custom .= "#mainnav > ul > li > a, #mainnav > ul > li > a i, .header-modal-menu-left-btn .text, header .flat-information li, header .flat-information li a { color:" . esc_attr($mainnav_color) . ";}"."\n";
			$custom .= ".header-modal-menu-left-btn .modal-menu-left-btn .line{ background:" . esc_attr($mainnav_color) . ";}"."\n";
		}

		$mainnav_hover_color = themesflat_get_opt( 'mainnav_hover_color');
		if ( $mainnav_hover_color !='' ) {
			$custom .= "#mainnav > ul > li:hover > a, #mainnav > ul > li:hover > a i { color:" . esc_attr($mainnav_hover_color) . ";}"."\n";
			$custom .= "#mainnav > ul > li:hover .item-link .text::before { background:" . esc_attr($mainnav_hover_color) . ";}"."\n";
		}

		$mainnav_active_color = themesflat_get_opt( 'mainnav_active_color');
		if ( $mainnav_active_color !='' ) {
			$custom .= "#mainnav > ul > li.current-menu-item > a, #mainnav > ul > li.current-menu-ancestor > a, #mainnav > ul > li.current-menu-ancestor > a .icon, #mainnav > ul > li.current-menu-parent > a, #mainnav > ul > li.current-menu-parent > a i { color:" . esc_attr($mainnav_active_color) . ";}"."\n";
		}

		//Subnav a color
		$sub_nav_color = themesflat_get_opt( 'sub_nav_color');
		if ( $sub_nav_color !='' ) {
			$custom .= ".box-navigation .sub-menu a, #mainnav ul.sub-menu > li > a, .tf-header .sub-menu .menu-link-text, #mainnav li.megamenu > ul.sub-menu > .menu-item-has-children > a { color:" . esc_attr( $sub_nav_color ) . ";}"."\n";
		}
		//Subnav background color
		$sub_nav_background = themesflat_get_opt( 'sub_nav_background');
		if ( $sub_nav_background !='' ) {
			$custom .= "#mainnav ul.sub-menu, .box-navigation .sub-menu { background-color:" . esc_attr( $sub_nav_background ) . ";}"."\n";			
		}

		//sub_nav_color_hover
		$sub_nav_color_hover = themesflat_get_opt( 'sub_nav_color_hover');
		if ( $sub_nav_color_hover !='' ) {
			$custom .= ".sub-menu .sub-menu_list .menu-item.active .sub-menu_link,.sub-menu .sub-menu_list .menu-item .sub-menu_link:hover,.box-navigation .sub-menu a:hover, .box-navigation .sub-menu .active a, #mainnav ul.sub-menu > li > a:hover, .tf-header .sub-menu .menu-link-text:hover, #mainnav li.megamenu > ul.sub-menu > .menu-item-has-children > a:hover  { color:" . esc_attr( $sub_nav_color_hover ) . " !important;}"."\n";
		}

		$logo_controls = themesflat_decode(themesflat_get_opt('logo_controls'));
	    themesflat_render_box_position("#header #logo",$logo_controls);

	    $logo_width = themesflat_get_opt( 'logo_width');
		if ( $logo_width !='' ) {
			$custom .= ".logo-site img,.logo-header .site-logo { max-width:" . esc_attr($logo_width) . "px;height: auto;}"."\n";
		}

		$menu_distance_between = themesflat_get_opt( 'menu_distance_between');
		if ( $menu_distance_between !='' ) {
			// $custom .= ".tf-header .box-nav-menu > li { padding-left:" . esc_attr($menu_distance_between) . "px;padding-right:" . esc_attr($menu_distance_between) . "px;}"."\n";
			$custom .= ".tf-header .box-nav-menu { gap:" . esc_attr($menu_distance_between) . "px;}"."\n";
		}

		if ( themesflat_get_opt( 'button_action_header_color' ) !='' ) {
			$custom .= ".tf-header .header-left .text-caption-01, .tf-header .header-left .topbar-nav-menu .menu-item a,#header .nav-icon-item, .header-absolute-2:not(.header-sticky) .form-search button, .header-absolute-2:not(.header-sticky) .form-search input::placeholder, .header-absolute-2:not(.header-sticky) .form-search button, .header-absolute-2:not(.header-sticky) .form-search input, .header-absolute-2:not(.header-sticky) .nav-icon-item, .tf-header .nav-icon-item, .tf-header .form-search button, .tf-header .form-search input::placeholder, .tf-header .form-search input, .tf-header .tf-dropdown-select > .dropdown-toggle, .tf-header .tf-dropdown-select > .dropdown-toggle::after  { color:" . esc_attr( themesflat_get_opt( 'button_action_header_color' ) ) ." !important;} "."\n";
			$custom .= ".tf-header .form-search input  { border-color:" . esc_attr( themesflat_get_opt( 'button_action_header_color' ) ) ." !important;} "."\n";
	    }

		if ( themesflat_get_opt( 'button_action_header_color_hover' ) !='' ) {
			$custom .= ".tf-header .header-left .text-caption-01:hover, .tf-header .header-left .topbar-nav-menu .menu-item a:hover,#header .nav-icon-item:hover, .header-absolute-2:not(.header-sticky) .form-search button:hover, .header-absolute-2:not(.header-sticky) .form-search button:hover, .header-absolute-2:not(.header-sticky) .nav-icon-item:hover, .tf-header .nav-icon-item:hover, .tf-header .form-search button:hover  { color:" . esc_attr( themesflat_get_opt( 'button_action_header_color_hover' ) ) ." !important;} "."\n";
	    }

	//GROUP FOOTER
		$footer_controls = themesflat_decode(themesflat_get_opt('footer_controls'));
	    themesflat_render_box_position("#footer",$footer_controls);

	    $footer_background_color = themesflat_get_opt( 'footer_background_color');
		if ( $footer_background_color != '' ) {
			$custom .= "#footer,.footer_background,.tf-footer  { background:" . esc_attr($footer_background_color) . " !important;}"."\n";
		}
	
		$footer_background_image = themesflat_get_opt('footer_background_image');
		$footer_image_size = themesflat_get_opt('footer_image_size');
	    if ( $footer_background_image !='' ) { 
		    $custom .= '.footer_background .overlay-footer {background-image: url('.$footer_background_image.');}'."\n";
		    $custom .= '.footer_background .overlay-footer {background-size: '.$footer_image_size.';}'."\n";    
		}
		$footer_title_widget_color = themesflat_get_opt( 'footer_title_widget_color');
		if ( $footer_title_widget_color !='' ) {
			$custom .= "#footer .widget-title, #footer h2, #footer h3, #footer h4, #footer h5, #footer h6, #footer .wp-block-search .wp-block-search__label { color:" . esc_attr($footer_title_widget_color) . ";}"."\n";
		}
		$footer_text_color = themesflat_get_opt( 'footer_text_color');
		if ( $footer_text_color !='' ) {
			$custom .= "#footer, #footer a, footer .widget.widget-recent-news li .text .post-date, footer .widget.widget_latest_news li .text .post-date, #footer .footer-widgets .widget.widget_themesflat_socials ul li a, footer select option, footer .widget.widget_recent_entries ul li .post-date, #footer .wp-block-latest-posts__post-author, #footer .wp-block-latest-posts__post-date { color:" . esc_attr($footer_text_color) . ";}"."\n";
		}
		if ( $footer_text_color !='' ) {
			$custom .= "#footer .footer-widgets .widget.widget_themesflat_socials ul li a:hover { color:" . esc_attr($footer_text_color) . "!important;}"."\n";
		}
		$footer_text_color_hover = themesflat_get_opt( 'footer_text_color_hover');
		if ( $footer_text_color_hover !='' ) {
			$custom .= "#footer a:hover { color:" . esc_attr($footer_text_color_hover) . ";}"."\n";
			$custom .= "footer .widget.widget_product_categories ul > li > a:before, footer .widget.widget_categories ul > li > a:before, footer .widget.widget_pages ul > li > a:before, footer .widget.widget_archive ul > li > a:before, footer .widget.widget_meta ul > li > a:before, footer .widget.widget_block ul > li > a:before { background:" . esc_attr($footer_text_color_hover) . ";}"."\n";
		}		

		$bottom_background_color = themesflat_get_opt( 'bottom_background_color');
		if ( $bottom_background_color !='' ) {
			$custom .= ".footer-bottom { background:" . esc_attr($bottom_background_color) . ";}"."\n";
		}
		$bottom_text_color = themesflat_get_opt( 'bottom_text_color');
		if ( $bottom_text_color !='' ) {
			$custom .= ".text-copy { color:" . esc_attr($bottom_text_color) . " !important;}"."\n";
		}
		$bottom_link_color = themesflat_get_opt( 'bottom_link_color');
		if ( $bottom_link_color !='' ) {
			$custom .= ".footer-bottom_wrap .tf-list a { color:" . esc_attr($bottom_link_color) . ";}"."\n";
		}
		$bottom_text_color_hover = themesflat_get_opt( 'bottom_text_color_hover');
		if ( $bottom_text_color_hover !='' ) {
			$custom .= ".footer-bottom_wrap .tf-list a:hover { color:" . esc_attr($bottom_text_color_hover) . ";}"."\n";
		}
		
	
	
    //GROUP PAGE TITLE
		$page_title_controls = themesflat_decode(themesflat_get_opt('page_title_controls'));
	    themesflat_render_box_position(".tf-page-title",$page_title_controls);

		$page_title_controls_woo = themesflat_decode(themesflat_get_opt('page_title_controls_woo'));
	    themesflat_render_box_position(".tf-page-title.tfwc-page-title",$page_title_controls_woo);

	    //  Page Title Opacity
		$page_title_background_color = themesflat_get_opt( 'page_title_background_color');

		if ( $page_title_background_color !='' ) {
			$custom .= ".tf-page-title:after { background:linear-gradient(270deg, ". hexToRgba($page_title_background_color, $alpha = 0) ." 0%, ". hexToRgba($page_title_background_color, $alpha = 0.8) ." 53.2%, ". hexToRgba($page_title_background_color, $alpha = 1) ." 100%) ;}"."\n";
		}
		$page_title_background_image2_elementor = themesflat_get_opt_elementor('page_title_background_image2');
		$page_title_background_image2 = !empty($page_title_background_image2_elementor['url']) ? $page_title_background_image2_elementor['url'] : themesflat_get_opt('page_title_background_image2');
		if ( $page_title_background_image2 !='' ) {
			$custom .= ".tf-page-title:before { background:url('". esc_url($page_title_background_image2) ."') no-repeat left bottom / cover ;}"."\n";
		}
		
		$page_title_background_color2 = themesflat_get_opt( 'page_title_background_color2');
		if ( $page_title_background_color !='' && $page_title_background_color2 !='' ) {
		$custom .= ".tf-page-title { background:linear-gradient(120deg, ". esc_attr($page_title_background_color) ." 30%, ". esc_attr($page_title_background_color2) ." 60%) ;}"."\n";
		}

		$page_title_background_color_woo = themesflat_get_opt( 'page_title_background_color_woo');
		$page_title_background_color2_woo = themesflat_get_opt( 'page_title_background_color2_woo');
		if ( $page_title_background_color_woo !='' && $page_title_background_color2_woo !='' ) {
		$custom .= ".tf-page-title { background:linear-gradient(120deg, ". esc_attr($page_title_background_color_woo) ." 30%, ". esc_attr($page_title_background_color2_woo) ." 60%) ;}"."\n";
		}

		$page_title_background_color_opacity_woo = themesflat_get_opt( 'page_title_background_color_opacity_woo');
		if ( $page_title_background_color_opacity_woo !='' ) {
			$custom .= ".tf-page-title { opacity:" . esc_attr($page_title_background_color_opacity_woo) . "%; filter:alpha(opacity=" . esc_attr($page_title_background_color_opacity_woo) . "); }"."\n";
		}
		
		$page_title_img_woo = themesflat_get_opt('page_title_background_image_woo');
		$page_title_image_size_woo = themesflat_get_opt('page_title_image_size_woo');
	    if ( $page_title_img_woo !='' ) { 
		    $custom .= '.tf-page-title {background-image: url('.$page_title_img_woo.');}'."\n";
		    $custom .= '.tf-page-title {background-size: '.$page_title_image_size_woo.';}'."\n";  
		}				    


		$custom .= ".page-title .heading {color:" . themesflat_get_opt('page_title_text_color') . "!important;}"."\n";

		$custom .= ".breadcrumbs span, .breadcrumbs span a, .breadcrumbs a, .breadcrumbs span i, .breadcrumbs span.trail-browse i {color:" . themesflat_get_opt('breadcrumb_color') . ";}"."\n";
				

	//GROUP BODY
		// Body color
		$body_text = themesflat_get_opt( 'body_text_color' );
		if ($body_text !='') {
			$custom .= "body, input, select, textarea, .s-blog-detail .main-post p, .product-extra-icon.text-caption { color:" . esc_attr($body_text) . "}"."\n";
			$custom .= ".themesflat-portfolio .item .category-post a:hover,ul.iconlist .list-title .testimonial-content blockquote,.testimonial-content .author-info,.themesflat_counter.style2 .themesflat_counter-content-right,.themesflat_counter.style2 .themesflat_counter-content-left, .page-links a:focus,.widget_search .search-form input[type=search],.entry-meta ul,.entry-meta ul.meta-right,.entry-footer strong, .themesflat_button_container .themesflat-button.no-background, .portfolio-single .entry-content, article .entry-meta ul li a, .blog-single .entry-footer .tags-links a, .navigation.posts-navigation .nav-links li a .meta-nav, .flat-language ul.unstyled-child li a, .themesflat-price-product del { color:" . esc_attr($body_text) . "}"."\n";
			//border bodycolor
			
		}

		// background bodycolor
	    if ( themesflat_get_opt ('body_background_color') !='' ) {
			$custom .= "body, .page-wrap, .boxed .themesflat-boxed { background-color:" . esc_attr(themesflat_get_opt ('body_background_color')) ." ; } "."\n";
	    }
	
	//GROUP COLOR
	    // Primary color
	    $primary_color = themesflat_get_opt( 'primary_color' );
	    if ( $primary_color !='' ) { 
			$custom .= ' :root { --primary:' . esc_attr($primary_color) . " }"."\n";
	    }
		// Mobile
		$custom .= '@media (max-width: 767px) {';

			if ( themesflat_get_opt( 'show_promo_bar_mobile' ) != 1 ) {
				$custom .= ".tf-promo-bar { display:none !important; } "."\n";
			}

			if ( themesflat_get_opt( 'show_top_bar_mobile' ) != 1 ) {
				$custom .= ".tf-topbar { display:none !important; } "."\n";
			}

			if ( themesflat_get_opt( 'btn_login_mobile' ) != 1 ) {
				$custom .= ".tf-header .nav-icon-list .nav-account { display:none !important; } "."\n";
			}

			if ( themesflat_get_opt( 'btn_wishlist_mobile' ) != 1 ) {
				$custom .= ".tf-header .nav-icon-list .nav-wishlist { display:none !important; } "."\n";
			}

			if ( themesflat_get_opt( 'btn_cart_mobile' ) != 1 ) {
				$custom .= ".tf-header .nav-icon-list .nav-cart { display:none !important; } "."\n";
			}

			if ( themesflat_get_opt( 'btn_pc_wishlist' ) != 1 ) {
				$custom .= ".card-product .product-action_list li.wishlist { display:none !important; } "."\n";
			}

			if ( themesflat_get_opt( 'btn_pc_compare' ) != 1 ) {
				$custom .= ".card-product .product-action_list li.compare { display:none !important; } "."\n";
			}

			if ( themesflat_get_opt( 'btn_pc_quickview' ) != 1 ) {
				$custom .= ".card-product .tf_quickview_btn, .card-product .product-action_list li:has(> .tf_quickview_btn) { display:none !important; } "."\n";
			}

			if ( themesflat_get_opt( 'btn_pc_cart' ) != 1 ) {
				$custom .= ".card-product .box-action_add, .card-product .tf_add_to_cart { display:none !important; } "."\n";
			}

			if ( themesflat_get_opt( 'pc_badges' ) != 1 ) {
				$custom .= ".card-product .product-badge_list { display:none !important; } "."\n";
			}
			
		$custom .= '}';

	$custom = apply_filters('themesflat/render/style',$custom);
	wp_add_inline_style( 'themesflat-inline-css', $custom );

}

add_action( 'wp_enqueue_scripts', 'themesflat_custom_styles' );