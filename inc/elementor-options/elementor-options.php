<?php 
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Plugin;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow as Group_Control_Box_Shadow;
use Elementor\Modules\DynamicTags\Module as TagsModule;


class themesflat_options_elementor {
	public function __construct(){	
        add_action('elementor/documents/register_controls', [$this, 'themesflat_elementor_register_options'], 10);
        add_action('elementor/editor/before_enqueue_scripts', function() { wp_enqueue_script( 'elementor-preview-load', THEMESFLAT_LINK . '/js/elementor/elementor-preview-load.js', array( 'jquery' ), null, true );
        }, 10, 3);
    }

    public function themesflat_elementor_register_options($element){
        $post_id = $element->get_id();
        $post_type = get_post_type($post_id);

        if ( ($post_type !== 'post') && ($post_type !== 'portfolios') && ($post_type !== 'services') && ($post_type !== 'team') ) {
        	$this->themesflat_options_page_header($element);
            $this->themesflat_options_page_footer($element);                      
        }

        $this->themesflat_options_page($element);
        $this->themesflat_options_page_pagetitle($element);

        


    }

    public function themesflat_options_page_header($element) {
        // TF Header
        $element->start_controls_section(
            'themesflat_header_options',
            [
                'label' => esc_html__('TF Header', 'ovinx'),
                'tab' => Controls_Manager::TAB_SETTINGS,
            ]
        );

         $element->add_control(
            'show_promo_bar',
            [
                'label'     => esc_html__( 'Promo Bar', 'ovinx'),
                'type'      => Controls_Manager::SELECT,
                'default'   => '',
                'options'   => [
                    '' => esc_html__( 'Theme Setting', 'ovinx'),
                    0       => esc_html__( 'Hide', 'ovinx'),
                    1       => esc_html__( 'Show', 'ovinx'),                    
                ],
                
            ]
        );

        $element->add_control(
            'promo_bar_position',
            [
                'label'     => esc_html__( 'Promo Bar Position', 'ovinx'),
                'type'      => Controls_Manager::SELECT,
                'default'   => '',
                'options'   => [
                    '' => esc_html__( 'Theme Setting', 'ovinx'),
                    'promo-top'       => esc_html__( 'Top', 'ovinx'),
                    'promo-bottom'       => esc_html__( 'Bottom', 'ovinx'),                    
                ],
                
            ]
        );

        $element->add_control(
            'promo_color',
            [
                'label' => esc_html__( 'Color Text Promo Bar', 'ovinx' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tf-slider-promo .text-caption-01, {{WRAPPER}} .tf-slider-promo .nav-prev-swiper, {{WRAPPER}} .tf-slider-promo .nav-next-swiper, {{WRAPPER}} .tf-promo-bar .infiniteSlide-text-v03 .text a' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $element->add_control(
            'promo_background_color',
            [
                'label' => esc_html__( 'Background Promo Bar', 'ovinx' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tf-slider-promo, {{WRAPPER}} .tf-promo-bar .infiniteSlide-text-v03' => 'background: {{VALUE}} !important;',
                ],
            ]
        );


        $element->add_control(
            'h_options_topbar',
            [
                'label' => esc_html__( 'Topbar', 'ovinx' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $element->add_control(
            'topbar_show',
            [
                'label'     => esc_html__( 'Top Bar', 'ovinx'),
                'type'      => Controls_Manager::SELECT,
                'default'   => '',
                'options'   => [
                    '' => esc_html__( 'Theme Setting', 'ovinx'),
                    0       => esc_html__( 'Hide', 'ovinx'),
                    1       => esc_html__( 'Show', 'ovinx'),                    
                ],
                
            ]
        ); 

        $element->add_control(
			'topbar_items_left',
			[
				'label' => esc_html__( 'Topbar Items Left', 'ovinx' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
                'options'     => [
        'phone'   => __('Phone', 'ovinx'),
        'menu-topbar' => __('Menu', 'ovinx'),
        'currency'    => __('Currency', 'ovinx'),
        'language'    => __('Language', 'ovinx'),
        'social'    => __('Social', 'ovinx'),
                ],
			]
		);

        $element->add_control(
			'topbar_items_center',
			[
				'label' => esc_html__( 'Topbar Items Center', 'ovinx' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
                'options'     => [
        'phone'   => __('Phone', 'ovinx'),
        'menu-topbar' => __('Menu', 'ovinx'),
        'currency'    => __('Currency', 'ovinx'),
        'language'    => __('Language', 'ovinx'),
        'social'    => __('Social', 'ovinx'),
        'text-slider'    => __('Text Slider', 'ovinx'),
        'text-slider-2'    => __('Text Slider 2', 'ovinx'),
                ],
			]
		);

        $element->add_control(
			'topbar_items_right',
			[
				'label' => esc_html__( 'Topbar Items Right', 'ovinx' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
                'options'     => [
        'phone'   => __('Phone', 'ovinx'),
        'menu-topbar' => __('Menu', 'ovinx'),
        'currency'    => __('Currency', 'ovinx'),
        'language'    => __('Language', 'ovinx'),
        'social'    => __('Social', 'ovinx'),
                ],
			]
		);

        $element->add_control(
            'topbar_background_color',
            [
                'label' => esc_html__( 'Background', 'ovinx' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tf-topbar:not(.tf-slider-promo)' => 'background: {{VALUE}} !important;',
                ],
            ]
        );

        $element->add_control(
            'topbar_textcolor',
            [
                'label' => esc_html__( 'Color', 'ovinx' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tf-topbar:not(.tf-slider-promo), {{WRAPPER}} .tf-topbar:not(.tf-slider-promo) .tf-dropdown-select.style-default>.dropdown-toggle::after, {{WRAPPER}} .tf-topbar:not(.tf-slider-promo) .tf-dropdown-select.style-default .filter-option-inner-inner, {{WRAPPER}} .tf-topbar:not(.tf-slider-promo) .item a, {{WRAPPER}} .tf-topbar:not(.tf-slider-promo) ul .menu-item a, {{WRAPPER}} .tf-topbar:not(.tf-slider-promo) .menu-fallback, {{WRAPPER}} .tf-topbar:not(.tf-slider-promo) .text-adver, {{WRAPPER}} .tf-topbar:not(.tf-slider-promo) .tf-social-icon-2 a' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $element->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'header_border',
				'label' => esc_html__( 'Topbar Border', 'ovinx' ),
				'selector' => '{{WRAPPER}} .tf-topbar:not(.tf-slider-promo)',
			]
		);

        //Extra Classes Header
        $element->add_control(
            'extra_classes_topbar',
            [
                'label'   => esc_html__( 'Extra Classes', 'ovinx' ),
                'type'    => Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $element->add_control(
            'h_options_header',
            [
                'label' => esc_html__( 'Header', 'ovinx' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $element->add_control(
            'style_header',
            [
                'label'     => esc_html__( 'Header Layout', 'ovinx'),
                'type'      => Controls_Manager::SELECT,
                'default'   => '',
                'options'   => [
                	'' => esc_html__( 'Theme Setting', 'ovinx'),
                    'header-default' => esc_html__( 'Default', 'ovinx'),
                    'header-02' => esc_html__( 'Header 02', 'ovinx'),
                    'header-03' => esc_html__( 'Header 03', 'ovinx'),
                ],
            ]
        );

        // Logo
        $element->add_control(
            'site_logo',
            [
                'label'   => esc_html__( 'Custom Logo', 'ovinx' ),
                'type'    => Controls_Manager::MEDIA,
            ]
        );

        $element->add_responsive_control(
            'logo_width',
            [
                'label'      => esc_html__( 'Logo Width', 'ovinx' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range'      => [
                    'px' => [
                        'min' => 30,
                        'max' => 500,
                    ],
                    '%' => [
                        'min' => 50,
                        'max' => 150,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} #logo a img' => 'max-width: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );

       
        $element->add_control(
            'header_sticky',
            [
                'label'     => esc_html__( 'Header Sticky', 'ovinx'),
                'type'      => Controls_Manager::SELECT,
                'default'   => '',
                'options'   => [
                    '' => esc_html__( 'Theme Setting', 'ovinx'),
                    0       => esc_html__( 'No', 'ovinx'),
                    1       => esc_html__( 'Yes', 'ovinx'),                    
                ],
                
            ]
        );

        $element->add_control(
            'header_search_box_form',
            [
                'label'     => esc_html__( 'Search Box Input', 'ovinx'),
                'type'      => Controls_Manager::SELECT,
                'default'   => '',
                'options'   => [
                    '' => esc_html__( 'Theme Setting', 'ovinx'),
                    0       => esc_html__( 'Hide', 'ovinx'),
                    1       => esc_html__( 'Show', 'ovinx'),
                ],

            ]
        );

        $element->add_control(
            'show_header_category',
            [
                'label'     => esc_html__( 'Category Menu', 'ovinx'),
                'type'      => Controls_Manager::SELECT,
                'default'   => '',
                'options'   => [
                    '' => esc_html__( 'Theme Setting', 'ovinx'),
                    0       => esc_html__( 'Hide', 'ovinx'),
                    1       => esc_html__( 'Show', 'ovinx'),                    
                ],
                
            ]
        );  

        $element->add_control(
            'header_cart_icon',
            [
                'label'     => esc_html__( 'Header Cart', 'ovinx'),
                'type'      => Controls_Manager::SELECT,
                'default'   => '',
                'options'   => [
                    '' => esc_html__( 'Theme Setting', 'ovinx'),
                    0       => esc_html__( 'Hide', 'ovinx'),
                    1       => esc_html__( 'Show', 'ovinx'),                    
                ],
                
            ]
        );
        $element->add_control(
            'header_wishlist_icon',
            [
                'label'     => esc_html__( 'Header Wishlist', 'ovinx'),
                'type'      => Controls_Manager::SELECT,
                'default'   => '',
                'options'   => [
                    '' => esc_html__( 'Theme Setting', 'ovinx'),
                    0       => esc_html__( 'Hide', 'ovinx'),
                    1       => esc_html__( 'Show', 'ovinx'),
                ],

            ]
        );

        $element->add_control(
            'header_compare_icon',
            [
                'label'     => esc_html__( 'Header Compare', 'ovinx'),
                'type'      => Controls_Manager::SELECT,
                'default'   => '',
                'options'   => [
                    '' => esc_html__( 'Theme Setting', 'ovinx'),
                    0       => esc_html__( 'Hide', 'ovinx'),
                    1       => esc_html__( 'Show', 'ovinx'),
                ],

            ]
        );

        $element->add_control(
            'header_login',
            [
                'label'     => esc_html__( 'Header Login', 'ovinx'),
                'type'      => Controls_Manager::SELECT,
                'default'   => '',
                'options'   => [
                    '' => esc_html__( 'Theme Setting', 'ovinx'),
                    0       => esc_html__( 'Hide', 'ovinx'),
                    1       => esc_html__( 'Show', 'ovinx'),                    
                ],
                
            ]
        ); 

        //Extra Classes Header
        $element->add_control(
            'extra_classes_header',
            [
                'label'   => esc_html__( 'Extra Classes', 'ovinx' ),
                'type'    => Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $element->end_controls_section();
    }

    public function themesflat_options_page_pagetitle($element) {
        // TF Page Title
        $element->start_controls_section(
            'themesflat_pagetitle_options',
            [
                'label' => esc_html__('TF Page Title', 'ovinx'),
                'tab' => Controls_Manager::TAB_SETTINGS,
            ]
        );       

        $element->add_control(
            'hide_pagetitle',
            [
                'label'     => esc_html__( 'Hide Page Title', 'ovinx'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'block',
                'options'   => [
                    'none'       => esc_html__( 'Yes', 'ovinx'),
                    'block'      => esc_html__( 'No', 'ovinx'),
                ],
                'selectors'  => [
                    '{{WRAPPER}} .tf-page-title' => 'display: {{VALUE}};',
                ],
            ]
        ); 

        
        $element->add_control(
            'page_title_alignment',
            [
                'label'     => esc_html__( 'Page Title Alignment', 'ovinx'),
                'type'      => Controls_Manager::SELECT,
                'default'   => '',
                'options'   => [
                    '' => esc_html__( 'Theme Setting', 'ovinx'),
                    'left' => esc_html__( 'Left', 'ovinx'),
                    'center'       => esc_html__( 'Center', 'ovinx'),
                    'right'       => esc_html__( 'Right', 'ovinx'),                    
                ],
                
            ]
        ); 

        $element->add_control(
            'page_title_description',
            [
                'label'     => esc_html__( 'Enable Page Title Description', 'ovinx'),
                'type'      => Controls_Manager::SELECT,
                'default'   => '',
                'options'   => [
                    '' => esc_html__( 'Theme Setting', 'ovinx'),
                    0       => esc_html__( 'Hide', 'ovinx'),
                    1       => esc_html__( 'Show', 'ovinx'),                    
                ],
                
            ]
        ); 

        $element->add_control(
            'page_title_description_content',
            [
                'label'   => esc_html__( 'Page Title Description Content', 'ovinx' ),
                'type'    => Controls_Manager::TEXTAREA,
            ]
        );

        $element->add_responsive_control(
            'pagetitle_padding',
            [
                'label' => esc_html__( 'Padding', 'ovinx' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'allowed_dimensions' => [ 'top', 'bottom' ],
                'selectors' => [
                    '{{WRAPPER}} .tf-page-title' => 'padding-top: {{TOP}}{{UNIT}}; padding-bottom: {{BOTTOM}}{{UNIT}};',
                ],
                'condition' => [ 'hide_pagetitle' => 'block' ]
            ]
        ); 

        $element->add_responsive_control(
            'pagetitle_margin',
            [
                'label' => esc_html__( 'Margin', 'ovinx' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'allowed_dimensions' => [ 'top', 'bottom' ],
                'selectors' => [
                    '{{WRAPPER}} .tf-page-title' => 'margin-top: {{TOP}}{{UNIT}}; margin-bottom: {{BOTTOM}}{{UNIT}};',
                ],
                'condition' => [ 'hide_pagetitle' => 'block' ]
            ]
        );              

        //Extra Classes Page Title
        $element->add_control(
            'extra_classes_pagetitle',
            [
                'label'   => esc_html__( 'Extra Classes', 'ovinx' ),
                'type'    => Controls_Manager::TEXT,
                'label_block' => true,
                'separator' => 'before'
            ]
        );

        $element->end_controls_section();
    }

    public function themesflat_options_page_footer($element) {
        // TF Footer
        $element->start_controls_section(
            'themesflat_footer_options',
            [
                'label' => esc_html__('TF Footer', 'ovinx'),
                'tab' => Controls_Manager::TAB_SETTINGS,
            ]
        );

        $element->add_control(
            'footer_heading',
            [
                'label'     => esc_html__( 'Footer', 'ovinx'),
                'type'      => Controls_Manager::HEADING,
            ]
        );       

        $element->add_control(
            'hide_footer',
            [
                'label'     => esc_html__( 'Hide Footer', 'ovinx'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'block',
                'options'   => [
                    'none'       => esc_html__( 'Yes', 'ovinx'),
                    'block'      => esc_html__( 'No', 'ovinx'),
                ],
                'selectors'  => [
                    '{{WRAPPER}} .tf-footer' => 'display: {{VALUE}};',
                ],
            ]
        );

        $element->add_responsive_control(
            'footer_padding',
            [
                'label' => esc_html__( 'Padding', 'ovinx' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'allowed_dimensions' => [ 'top', 'bottom' ],
                'selectors' => [
                    '{{WRAPPER}} .tf-footer' => 'padding-top: {{TOP}}{{UNIT}}; padding-bottom: {{BOTTOM}}{{UNIT}};',
                ],
                'condition' => [ 'hide_footer' => 'block' ]
            ]
        );

        $element->add_control(
            'footer_color',
            [
                'label' => esc_html__( 'Color', 'ovinx' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tf-footer, {{WRAPPER}} .tf-footer h1, {{WRAPPER}} .tf-footer h2, {{WRAPPER}} .tf-footer h3, {{WRAPPER}} .tf-footer h4, {{WRAPPER}} .tf-footer h5, {{WRAPPER}} .tf-footer h6, {{WRAPPER}} .tf-footer p, {{WRAPPER}} .tf-footer a, {{WRAPPER}} .tf-footer input, {{WRAPPER}} .tf-footer .text-white, {{WRAPPER}} .tf-footer .cl-text-mute' => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .tf-footer .footer-heading-mobile::after, {{WRAPPER}} .tf-footer .footer-heading-mobile::before' => 'background-color: {{VALUE}};',
                ],
                'condition' => [ 'hide_footer' => 'block' ]
            ]
        );

        $element->add_control(
            'footer_color_hover',
            [
                'label' => esc_html__( 'Color Hover Link', 'ovinx' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tf-footer a:hover' => 'color: {{VALUE}} !important;',
                ],
                'condition' => [ 'hide_footer' => 'block' ]
            ]
        );

        // `footer.tf-footer` also carries `.bg-primary-2` (background-color !important),
        // so the plain Background group control's `background-color` would never win.
        $element->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'footer_bg',
                'label' => esc_html__( 'Background', 'ovinx' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .tf-footer',
                'fields_options' => [
                    'color' => [
                        'selectors' => [
                            '{{SELECTOR}}' => 'background-color: {{VALUE}} !important;',
                        ],
                    ],
                ],
                'condition' => [ 'hide_footer' => 'block' ]
            ]
        );


        // Bottom
        $element->add_control(
            'bottom_heading',
            [
                'label'     => esc_html__( 'Bottom', 'ovinx'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $element->add_control(
            'hide_bottom',
            [
                'label'     => esc_html__( 'Hide?', 'ovinx'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'block',
                'options'   => [
                    'none'       => esc_html__( 'Yes', 'ovinx'),
                    'block'      => esc_html__( 'No', 'ovinx'),
                ],
                'selectors'  => [
                    '{{WRAPPER}} .footer-bottom' => 'display: {{VALUE}};' 
                ],
            ]
        );

        $element->add_control(
            'bottom_color',
            [
                'label' => esc_html__( 'Color', 'ovinx' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .footer-bottom, {{WRAPPER}} .footer-bottom *' => 'color: {{VALUE}} !important;',
                ],
                'condition' => [ 'hide_bottom' => 'block' ]
            ]
        );

        $element->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'bottom_bg',
                'label' => esc_html__( 'Background', 'ovinx' ),
                'types' => [ 'classic', 'gradient', 'video' ],
                'selector' => '{{WRAPPER}} .footer-bottom',
                'condition' => [ 'hide_bottom' => 'block']
            ]
        );

        

        $element->add_responsive_control(
            'bottom_padding',
            [
                'label' => esc_html__( 'Padding', 'ovinx' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'allowed_dimensions' => [ 'top', 'bottom' ],
                'selectors' => [
                    '{{WRAPPER}} .footer-bottom' => 'padding-top: {{TOP}}{{UNIT}}; padding-bottom: {{BOTTOM}}{{UNIT}};',
                ],
                'condition' => [ 'hide_bottom' => 'block']
            ]
        );

        //Extra Classes Footer
        $element->add_control(
            'extra_classes_footer',
            [
                'label'   => esc_html__( 'Extra Classes', 'ovinx' ),
                'type'    => Controls_Manager::TEXT,
                'label_block' => true,
                'separator' => 'before'
            ]
        );

        $element->end_controls_section();
    }

    public function themesflat_options_page($element) {
        // TF Page
        $element->start_controls_section(
            'themesflat_page_options',
            [
                'label' => esc_html__('TF Page', 'ovinx'),
                'tab' => Controls_Manager::TAB_SETTINGS,
            ]
        );
        
        $element->add_control(
            'background_body',
            [
                'label' => esc_html__( 'Backround Body', 'ovinx' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .themesflat-boxed' => 'background: {{VALUE}};',                  
                ],
                
            ]
        );

        $element->add_control(
            'page_sidebar_layout',
            [
                'label'     => esc_html__( 'Sidebar Position', 'ovinx'),
                'type'      => Controls_Manager::SELECT,
                'default'   => '',
                'options'   => [
                    '' => esc_html__( 'No Sidebar', 'ovinx'),
                    'sidebar-right'     => esc_html__( 'Sidebar Right','ovinx' ),
                    'sidebar-left'      =>  esc_html__( 'Sidebar Left','ovinx' ),
                    'fullwidth'         =>   esc_html__( 'Full Width','ovinx' ),
                    'fullwidth-small'   =>   esc_html__( 'Full Width Small','ovinx' ),
                    'fullwidth-center'  =>   esc_html__( 'Full Width Center','ovinx' ),
                ],
            ]
        );

        $element->add_control(
            'main_content_heading',
            [
                'label'     => esc_html__( 'Main Content', 'ovinx'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $element->add_responsive_control(
            'main_content_padding',
            [
                'label' => esc_html__( 'Padding', 'ovinx' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'allowed_dimensions' => [ 'top', 'bottom' ],
                'selectors' => [
                    '{{WRAPPER}} #themesflat-content' => 'padding-top: {{TOP}}{{UNIT}} !important; padding-bottom: {{BOTTOM}}{{UNIT}} !important;',
                ],
            ]
        ); 

        $element->add_responsive_control(
            'main_content_margin',
            [
                'label' => esc_html__( 'Margin', 'ovinx' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'allowed_dimensions' => [ 'top', 'bottom' ],
                'selectors' => [
                    '{{WRAPPER}} #themesflat-content' => 'margin-top: {{TOP}}{{UNIT}} !important; margin-bottom: {{BOTTOM}}{{UNIT}} !important;',
                ],
            ]
        );

        $element->end_controls_section();
    }

}

new themesflat_options_elementor();