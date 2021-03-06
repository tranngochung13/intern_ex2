<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Premium_Banner extends Widget_Base {

	protected $templateInstance;

	public function getTemplateInstance() {
		return $this->templateInstance = premium_Template_Tags::getInstance();
	}

	public function get_name() {
		return 'premium-addon-banner';
	}

	public function get_title() {
		return sprintf( '%1$s %2$s', \PremiumAddons\Helper_Functions::get_prefix(), __('Banner', 'premium-addons-for-elementor') );
	}

	public function get_icon() {
		return 'pa-banner';
	}
    
	public function get_categories() {
		return [ 'premium-elements' ];
	}
    
    public function get_script_depends()
    {
        return ['premium-addons-js'];
    }

	// Adding the controls fields for the premium banner
	// This will controls the animation, colors and background, dimensions etc
	protected function _register_controls() {

		$this->start_controls_section('premium_banner_global_settings',
			[
				'label'         => __( 'Image', 'premium-addons-for-elementor' )
			]
		);
        
        $this->add_control('premium_banner_image',
			[
				'label'			=> __( 'Upload Image', 'premium-addons-for-elementor' ),
				'description'	=> __( 'Select an image for the Banner', 'premium-addons-for-elementor' ),
				'type'			=> Controls_Manager::MEDIA,
                'dynamic'       => [ 'active' => true ],
				'default'		=> [
					'url'	=> Utils::get_placeholder_image_src()
				],
				'show_external'	=> true
			]
		);
        
        $this->add_control('premium_banner_link_url_switch',
            [
                'label'         => __('Link', 'premium-addons-for-elementor'),
                'type'          => Controls_Manager::SWITCHER
            ]
        );

		$this->add_control('premium_banner_image_link_switcher',
			[
				'label'			=> __( 'Custom Link', 'premium-addons-for-elementor' ),
				'type'			=> Controls_Manager::SWITCHER,
				'description'	=> __( 'Add a custom link to the banner', 'premium-addons-for-elementor' ),
                'condition'     => [
                    'premium_banner_link_url_switch'    => 'yes',
                ],
			]
		);
        
        $this->add_control('premium_banner_image_custom_link',
			[
				'label'			=> __( 'Set custom Link', 'premium-addons-for-elementor' ),
				'type'			=> Controls_Manager::URL,
                'dynamic'       => [ 'active' => true ],
				'description'	=> __( 'What custom link you want to set to banner?', 'premium-addons-for-elementor' ),
				'condition'		=> [
					'premium_banner_image_link_switcher' => 'yes',
                    'premium_banner_link_url_switch'    => 'yes'
				],
				'show_external' => false
			]
		);

		$this->add_control('premium_banner_image_existing_page_link',
			[
				'label'			=> __( 'Existing Page', 'premium-addons-for-elementor' ),
				'type'			=> Controls_Manager::SELECT2,
				'condition'		=> [
					'premium_banner_image_link_switcher!' => 'yes',
                    'premium_banner_link_url_switch'    => 'yes'
				],
                'multiple'      => false,
				'options'		=> $this->getTemplateInstance()->get_all_post()
			]
		);
        
        $this->add_control('premium_banner_link_title',
			[
				'label'			=> __( 'Link Title', 'premium-addons-for-elementor' ),
				'type'			=> Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'condition'     => [
                    'premium_banner_link_url_switch'    => 'yes'
                ]
			]
		);
        

		$this->add_control('premium_banner_image_link_open_new_tab',
			[
				'label'			=> __( 'New Tab', 'premium-addons-for-elementor' ),
				'type'			=> Controls_Manager::SWITCHER,
				'description'	=> __( 'Choose if you want the link be opened in a new tab or not', 'premium-addons-for-elementor' ),
                'condition'     => [
                    'premium_banner_link_url_switch'    => 'yes'
                ]
			]
		);

		$this->add_control('premium_banner_image_link_add_nofollow',
			[
				'label'			=> __( 'Nofollow Option', 'premium-addons-for-elementor' ),
				'type'			=> Controls_Manager::SWITCHER,
				'description'	=> __('if you choose yes, the link will not be counted in search engines', 'premium-addons-for-elementor' ),
                'condition'     => [
                    'premium_banner_link_url_switch'    => 'yes'
                ]
			]
		);
        
        $this->add_control('premium_banner_image_animation',
			[
				'label'			=> __( 'Effect', 'premium-addons-for-elementor' ),
				'type'			=> Controls_Manager::SELECT,
				'default'		=> 'animation1',
				'description'	=> __( 'Choose a hover effect for the banner', 'premium-addons-for-elementor' ),
				'options'		=> [
					'animation1'		=> __('Effect 1', 'premium-addons-for-elementor'),
					'animation5'		=> __('Effect 2', 'premium-addons-for-elementor'),
					'animation13'       => __('Effect 3', 'premium-addons-for-elementor'),
					'animation2'		=> __('Effect 4', 'premium-addons-for-elementor'),
					'animation4'		=> __('Effect 5', 'premium-addons-for-elementor'),
					'animation6'		=> __('Effect 6', 'premium-addons-for-elementor')
				]
			]
		);
        
        $this->add_control('premium_banner_active',
			[
				'label'			=> __( 'Always Hovered', 'premium-addons-for-elementor' ),
				'type'			=> Controls_Manager::SWITCHER,
				'description'	=> __( 'Choose if you want the effect to be always triggered', 'premium-addons-for-elementor' )
			]
		);
        
        $this->add_control('premium_banner_hover_effect',
            [
                'label'         => __('Hover Effect', 'premium-addons-for-elementor'),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'none'          => __('None', 'premium-addons-for-elementor'),
                    'zoomin'        => __('Zoom In', 'premium-addons-for-elementor'),
                    'zoomout'       => __('Zoom Out', 'premium-addons-for-elementor'),
                    'scale'         => __('Scale', 'premium-addons-for-elementor'),
                    'grayscale'     => __('Grayscale', 'premium-addons-for-elementor'),
                    'blur'          => __('Blur', 'premium-addons-for-elementor'),
                    'bright'        => __('Bright', 'premium-addons-for-elementor'),
                    'sepia'         => __('Sepia', 'premium-addons-for-elementor'),
                ],
                'default'       => 'none',
            ]
        );
        
        $this->add_control('premium_banner_height',
			[
				'label'			=> __( 'Height', 'premium-addons-for-elementor' ),
				'type'			=> Controls_Manager::SELECT,
                'options'		=> [
					'default'		=> __('Default', 'premium-addons-for-elementor'),
					'custom'		=> __('Custom', 'premium-addons-for-elementor')
				],
				'default'		=> 'default',
				'description'	=> __( 'Choose if you want to set a custom height for the banner or keep it as it is', 'premium-addons-for-elementor' )
			]
		);
        
		$this->add_responsive_control('premium_banner_custom_height',
			[
				'label'			=> __( 'Min Height', 'premium-addons-for-elementor' ),
				'type'			=> Controls_Manager::NUMBER,
				'description'	=> __( 'Set a minimum height value in pixels', 'premium-addons-for-elementor' ),
				'condition'		=> [
					'premium_banner_height' => 'custom'
				],
				'selectors'		=> [
					'{{WRAPPER}} .premium-banner-ib' => 'height: {{VALUE}}px;'
				]
			]
		);
        
        $this->add_responsive_control('premium_banner_img_vertical_align',
			[
				'label'			=> __( 'Vertical Align', 'premium-addons-for-elementor' ),
				'type'			=> Controls_Manager::SELECT,
				'condition'		=> [
					'premium_banner_height' => 'custom'
				],
                'options'		=> [
					'flex-start'	=> __('Top', 'premium-addons-for-elementor'),
                    'center'		=> __('Middle', 'premium-addons-for-elementor'),
					'flex-end'		=> __('Bottom', 'premium-addons-for-elementor'),
                    'inherit'		=> __('Full', 'premium-addons-for-elementor')
				],
                'default'       => 'flex-start',
				'selectors'		=> [
					'{{WRAPPER}} .premium-banner-img-wrap' => 'align-items: {{VALUE}}; -webkit-align-items: {{VALUE}};'
				]
			]
		);
     
		$this->add_control('premium_banner_extra_class',
			[
				'label'			=> __( 'Extra Class', 'premium-addons-for-elementor' ),
				'type'			=> Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'description'	=> __( 'Add extra class name that will be applied to the banner, and you can use this class for your customizations.', 'premium-addons-for-elementor' )
			]
		);

		
		$this->end_controls_section();

		$this->start_controls_section('premium_banner_image_section',
  			[
  				'label' => __( 'Content', 'premium-addons-for-elementor' )
  			]
  		);
        
        $this->add_control('premium_banner_title',
			[
				'label'			=> __( 'Title', 'premium-addons-for-elementor' ),
				'placeholder'	=> __( 'Give a title to this banner', 'premium-addons-for-elementor' ),
				'type'			=> Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
				'default'		=> __( 'Premium Banner', 'premium-addons-for-elementor' ),
				'label_block'	=> false
			]
		);
        
        $this->add_control('premium_banner_title_tag',
			[
				'label'			=> __( 'HTML Tag', 'premium-addons-for-elementor' ),
				'description'	=> __( 'Select a heading tag for the title. Headings are defined with H1 to H6 tags', 'premium-addons-for-elementor' ),
				'type'			=> Controls_Manager::SELECT,
				'default'		=> 'h3',
				'options'       => [
                    'h1'    => 'H1',
                    'h2'    => 'H2',
                    'h3'    => 'H3',
                    'h4'    => 'H4',
                    'h5'    => 'H5',
                    'h6'    => 'H6',
                ],
				'label_block'	=> true,
			]
		);
        
        
        $this->add_control('premium_banner_description_hint',
			[
				'label'			=> __( 'Description', 'premium-addons-for-elementor' ),
				'type'			=> Controls_Manager::HEADING,
			]
		);
        
        $this->add_control('premium_banner_description',
			[
				'label'			=> __( 'Description', 'premium-addons-for-elementor' ),
				'description'	=> __( 'Give the description to this banner', 'premium-addons-for-elementor' ),
				'type'			=> Controls_Manager::WYSIWYG,
                'dynamic'       => [ 'active' => true ],
				'default'		=> __( 'Premium Banner gives you a wide range of styles and options that you will definitely fall in love with', 'premium-addons-for-elementor' ),
				'label_block'	=> true
			]
		);
        
        $this->add_control('premium_banner_link_switcher',
            [
                'label'         => __('Button', 'premium-addons-for-elementor'),
                'type'          => Controls_Manager::SWITCHER,
                'condition'     => [
                    'premium_banner_link_url_switch!'   => 'yes'
                ]
            ]
        );

        
        $this->add_control('premium_banner_more_text', 
            [
                'label'         => __('Text','premium-addons-for-elementor'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'default'       => 'Click Here',
                'condition'     => [
                    'premium_banner_link_switcher'    => 'yes',
                    'premium_banner_link_url_switch!'   => 'yes'
                ]
            ]
        );
        
        $this->add_control('premium_banner_link_selection',
            [
                'label'         => __('Link Type', 'premium-addons-for-elementor'),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'url'   => __('URL', 'premium-addons-for-elementor'),
                    'link'  => __('Existing Page', 'premium-addons-for-elementor'),
                ],
                'default'       => 'url',
                'label_block'   => true,
                'condition'     => [
                    'premium_banner_link_switcher'    => 'yes',
                    'premium_banner_link_url_switch!'   => 'yes'
                ]
            ]
        );

        $this->add_control('premium_banner_link',
            [
                'label'         => __('Link', 'premium-addons-for-elementor'),
                'type'          => Controls_Manager::URL,
                'dynamic'       => [ 'active' => true ],
                'default'       => [
                    'url'   => '#',
                ],
                'placeholder'   => 'https://premiumaddons.com/',
                'label_block'   => true,
                'condition'     => [
                    'premium_banner_link_selection' => 'url',
                    'premium_banner_link_switcher'    => 'yes',
                    'premium_banner_link_url_switch!'   => 'yes'
                ]
            ]
        );
        
        $this->add_control('premium_banner_existing_link',
            [
                'label'         => __('Existing Page', 'premium-addons-for-elementor'),
                'type'          => Controls_Manager::SELECT2,
                'options'       => $this->getTemplateInstance()->get_all_post(),
                'multiple'      => false,
                'condition'     => [
                    'premium_banner_link_selection'     => 'link',
                    'premium_banner_link_switcher'    => 'yes',
                    'premium_banner_link_url_switch!'   => 'yes'
                ],
                'label_block'   => true
            ]
        );
        
        
        $this->add_control('premium_banner_title_text_align', 
            [
                'label'         => __('Alignment', 'premium-addons-for-elementor'),
                'type'          => Controls_Manager::CHOOSE,
                'options'       => [
                    'left'  => [
                        'title'     => __('Left', 'premium-addons-for-elementor'),
                        'icon'      => 'fa fa-align-left'
                    ],
                    'center'  => [
                        'title'     => __('Center', 'premium-addons-for-elementor'),
                        'icon'      => 'fa fa-align-center'
                    ],
                    'right'  => [
                        'title'     => __('Right', 'premium-addons-for-elementor'),
                        'icon'      => 'fa fa-align-right'
                    ],
                ],
                'default'       => 'left',
                'toggle'        => false,
                'selectors'     => [
                    '{{WRAPPER}} .premium-banner-ib-title, {{WRAPPER}} .premium-banner-ib-content, {{WRAPPER}} .premium-banner-read-more'   => 'text-align: {{VALUE}};',
                ]
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('premium_banner_responsive_section',
            [
                'label'         => __('Responsive', 'premium-addons-for-elementor'),
            ]
        );
        
        $this->add_control('premium_banner_responsive_switcher',
            [
                'label'         => __('Responsive Controls', 'premium-addons-for-elementor'),
                'type'          => Controls_Manager::SWITCHER,
                'description'   => __('If the description text is not suiting well on specific screen sizes, you may enable this option which will hide the description text.', 'premium-addons-for-elementor')
            ]
        );
        
        $this->add_control('premium_banner_min_range', 
            [
                'label'     => __('Minimum Size', 'premium-addons-for-elementor'),
                'type'      => Controls_Manager::NUMBER,
                'description'=> __('Note: minimum size for extra small screens is 1px.','premium-addons-for-elementor'),
                'default'   => 1,
                'condition' => [
                    'premium_banner_responsive_switcher'    => 'yes'
                ],
            ]
        );

        $this->add_control('premium_banner_max_range', 
            [
                'label'     => __('Maximum Size', 'premium-addons-for-elementor'),
                'type'      => Controls_Manager::NUMBER,
                'description'=> __('Note: maximum size for extra small screens is 767px.','premium-addons-for-elementor'),
                'default'   => 767,
                'condition' => [
                    'premium_banner_responsive_switcher'    => 'yes'
                ],
            ]
        );

		$this->end_controls_section();
        
        $this->start_controls_section('premium_banner_opacity_style',
			[
				'label' 		=> __( 'Image', 'premium-addons-for-elementor' ),
				'tab' 			=> Controls_Manager::TAB_STYLE
			]
		);
        
        $this->add_control('premium_banner_image_bg_color',
			[
				'label' 		=> __( 'Background Color', 'premium-addons-for-elementor' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .premium-banner-ib' => 'background: {{VALUE}};'
				]
			]
		);
        
		$this->add_control('premium_banner_image_opacity',
			[
				'label' => __( 'Image Opacity', 'premium-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1
				],
				'range' => [
					'px' => [
		                'min' => 0,
		                'max' => 1,
		                'step' => .1
		            ]
				],
				'selectors' => [
		            '{{WRAPPER}} .premium-banner-ib .premium-banner-ib-img' => 'opacity: {{SIZE}};'
		        ]
			]
		);


		$this->add_control('premium_banner_image_hover_opacity',
			[
				'label' => __( 'Hover Opacity', 'premium-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1
				],
				'range' => [
					'px' => [
		                'min' => 0,
		                'max' => 1,
		                'step' => .1
		            ]
				],
				'selectors' => [
		            '{{WRAPPER}} .premium-banner-ib .premium-banner-ib-img.active' => 'opacity: {{SIZE}};'
		        ]
			]
		);
        
        $this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters',
				'selector' => '{{WRAPPER}} .premium-banner-ib',
			]
		);

		$this->add_group_control(
            Group_Control_Border::get_type(), 
            [
                'name'          => 'premium_banner_image_border',
                'selector'      => '{{WRAPPER}} .premium-banner-ib'
            ]
        );

		$this->add_responsive_control(
			'premium_banner_image_border_radius',
			[
				'label' => __( 'Border Radius', 'premium-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units'    => ['px', '%' ,'em'],
				'selectors' => [
		            '{{WRAPPER}} .premium-banner-ib' => 'border-radius: {{SIZE}}{{UNIT}};'
		        ]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section('premium_banner_title_style',
			[
				'label' 		=> __( 'Title', 'premium-addons-for-elementor' ),
				'tab' 			=> Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control('premium_banner_color_of_title',
			[
				'label' => __( 'Color', 'premium-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1
				],
				'selectors' => [
					'{{WRAPPER}} .premium-banner-ib-desc .premium_banner_title' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_control('premium_banner_style2_title_bg',
			[
				'label'			=> __( 'Title Background', 'premium-addons-for-elementor' ),
				'type'			=> Controls_Manager::COLOR,
				'default'       => '#f2f2f2',
				'description'	=> __( 'Choose a background color for the title', 'premium-addons-for-elementor' ),
				'condition'		=> [
					'premium_banner_image_animation' => 'animation5'
				],
				'selectors'     => [
				    '{{WRAPPER}} .premium-banner-animation5 .premium-banner-ib-desc'    => 'background: {{VALUE}};',
			    ]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'premium_banner_title_typography',
				'selector' => '{{WRAPPER}} .premium-banner-ib-desc .premium_banner_title',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1
			]
		);
        
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'label'             => __('Shadow','premium-addons-for-elementor'),
                'name'              => 'premium_banner_title_shadow',
                'selector'          => '{{WRAPPER}} .premium-banner-ib-desc .premium_banner_title'
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section('premium_banner_styles_of_content',
			[
				'label' 		=> __( 'Description', 'premium-addons-for-elementor' ),
				'tab' 			=> Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control('premium_banner_color_of_content',
			[
				'label' => __( 'Color', 'premium-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3
				],
				'selectors' => [
					'{{WRAPPER}} .premium-banner .premium_banner_content' => 'color: {{VALUE}};'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'          => 'premium_banner_content_typhography',
				'selector'      => '{{WRAPPER}} .premium-banner .premium_banner_content',
				'scheme'        => Scheme_Typography::TYPOGRAPHY_3,
			]
		);
        
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'label'             => __('Shadow','premium-addons-for-elementor'),
                'name'              => 'premium_banner_description_shadow',
                'selector'          => '{{WRAPPER}} .premium-banner .premium_banner_content',
            ]
        );

		$this->end_controls_section();
        
        $this->start_controls_section('premium_banner_styles_of_button',
			[
				'label' 		=> __( 'Button', 'premium-addons-for-elementor' ),
				'tab' 			=> Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'premium_banner_link_switcher'   => 'yes',
                    'premium_banner_link_url_switch!'   => 'yes'
                ]
			]
		);

		$this->add_control('premium_banner_color_of_button',
			[
				'label' => __( 'Color', 'premium-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3
				],
				'selectors' => [
					'{{WRAPPER}} .premium-banner .premium-banner-link' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_control('premium_banner_hover_color_of_button',
			[
				'label' => __( 'Hover Color', 'premium-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'selectors' => [
					'{{WRAPPER}} .premium-banner .premium-banner-link:hover' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'          => 'premium_banner_button_typhography',
                'scheme'        => Scheme_Typography::TYPOGRAPHY_3,
				'selector'      => '{{WRAPPER}} .premium-banner .premium-banner-link',
			]
		);
        
        $this->add_control(
			'premium_banner_backcolor_of_button',
			[
				'label' => __( 'Background Color', 'premium-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .premium-banner .premium-banner-link' => 'background-color: {{VALUE}};'
				],
			]
		);
        
        $this->add_control('premium_banner_hover_backcolor_of_button',
			[
				'label' => __( 'Hover Background Color', 'premium-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .premium-banner .premium-banner-link:hover' => 'background-color: {{VALUE}};'
				]
			]
		);

        $this->add_group_control(
            Group_Control_Border::get_type(), 
            [
                'name'          => 'premium_banner_button_border',
                'selector'      => '{{WRAPPER}} .premium-banner .premium-banner-link'
            ]
        );
        
        $this->add_control('premium_banner_button_border_radius',
            [
                'label'         => __('Border Radius', 'premium-addons-for-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%' ,'em'],
                'selectors'     => [
                    '{{WRAPPER}} .premium-banner .premium-banner-link' => 'border-radius: {{SIZE}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'label'             => __('Shadow','premium-addons-for-elementor'),
                'name'              => 'premium_banner_button_shadow',
                'selector'          => '{{WRAPPER}} .premium-banner .premium-banner-link',
            ]
        );
        
        $this->add_responsive_control('premium_banner_button_padding',
            [
                'label'         => __('Padding', 'premium-addons-for-elementor'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .premium-banner .premium-banner-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

		$this->end_controls_section();

	}


	protected function render() {
        
			$settings 	= $this->get_settings_for_display();
            
            $this->add_inline_editing_attributes('premium_banner_title');
            $this->add_inline_editing_attributes('premium_banner_description', 'advanced');

			$title_tag 	= $settings[ 'premium_banner_title_tag' ];
			$title 		= $settings[ 'premium_banner_title' ];
			$full_title = '<'. $title_tag . ' class="premium-banner-ib-title ult-responsive premium_banner_title"><div '. $this->get_render_attribute_string('premium_banner_title') .'>' .$title. '</div></'.$title_tag.'>';

			$link = 'yes' == $settings['premium_banner_image_link_switcher'] ? $settings['premium_banner_image_custom_link']['url'] : get_permalink( $settings['premium_banner_image_existing_page_link'] );

			$link_title = $settings['premium_banner_link_url_switch'] === 'yes' ? $settings['premium_banner_link_title'] : '';
            
			$open_new_tab = $settings['premium_banner_image_link_open_new_tab'] == 'yes' ? ' target="_blank"' : '';
            $nofollow_link = $settings['premium_banner_image_link_add_nofollow'] == 'yes' ? ' rel="nofollow"' : '';
			$full_link = '<a class="premium-banner-ib-link" href="'. $link .'" title="'. $link_title .'"'. $open_new_tab . $nofollow_link . '></a>';
			$animation_class = 'premium-banner-' . $settings['premium_banner_image_animation'];
            $hover_class = ' ' . $settings['premium_banner_hover_effect'];
			$extra_class = ! empty( $settings['premium_banner_extra_class'] ) ? ' '. $settings['premium_banner_extra_class'] : '';
			$active = $settings['premium_banner_active'] == 'yes' ? ' active' : '';
			$full_class = $animation_class.$hover_class.$extra_class.$active;
            $min_size = $settings['premium_banner_min_range'] .'px';
            $max_size = $settings['premium_banner_max_range'] .'px';


            $banner_url = 'url' == $settings['premium_banner_link_selection'] ? $settings['premium_banner_link']['url'] : get_permalink($settings['premium_banner_existing_link']);
            
            $alt = esc_attr( Control_Media::get_image_alt( $settings['premium_banner_image'] ) );
            
        ?>
            <div class="premium-banner" id="premium-banner-<?php echo esc_attr($this->get_id()); ?>">
				<div class="premium-banner-ib <?php echo $full_class; ?> premium-banner-min-height">
					<?php if( !empty(  $settings['premium_banner_image']['url'] ) ) : ?>
                        <?php if( $settings['premium_banner_height'] == 'custom' ) : ?>
                            <div class="premium-banner-img-wrap">
                        <?php endif; ?>
                            <img class="premium-banner-ib-img" alt="<?php echo $alt; ?>" src="<?php echo $settings['premium_banner_image']['url']; ?>">
                        <?php if( $settings['premium_banner_height'] == 'custom' ): ?>
                            </div>
                        <?php endif; ?>
					<?php endif; ?>
					<div class="premium-banner-ib-desc">
						<?php echo $full_title; ?>
                        <?php if( ! empty( $settings['premium_banner_description'] ) ) : ?>
                            <div class="premium-banner-ib-content premium_banner_content">
                                <div <?php echo $this->get_render_attribute_string('premium_banner_description'); ?>><?php echo $settings[ 'premium_banner_description' ]; ?></div>
                            </div>
                        <?php endif; ?>
                    <?php if( 'yes' == $settings['premium_banner_link_switcher'] && !empty( $settings['premium_banner_more_text'] ) ) : ?>
                        
                            <div class ="premium-banner-read-more">
                                <a class = "premium-banner-link" <?php if( !empty( $banner_url ) ) : ?> href="<?php echo esc_url( $banner_url ); ?>"<?php endif;?><?php if( !empty( $settings['premium_banner_link']['is_external'] ) ) : ?> target="_blank" <?php endif; ?><?php if( !empty($settings['premium_banner_link']['nofollow'] ) ) : ?> rel="nofollow" <?php endif; ?>><?php echo esc_html( $settings['premium_banner_more_text'] ); ?></a>
                            </div>
                        
                    <?php endif; ?>
					</div>
					<?php 
						if( $settings['premium_banner_link_url_switch'] == 'yes' && ( ! empty( $settings['premium_banner_image_custom_link']['url'] ) || !empty( $settings['premium_banner_image_existing_page_link'] ) ) ) {
							echo $full_link;
						}
					 ?>
				</div>
                <?php if($settings['premium_banner_responsive_switcher'] == 'yes' ) : ?>
                <style>
                    @media( min-width: <?php echo $min_size; ?> ) and (max-width:<?php echo $max_size; ?> ) {
                    #premium-banner-<?php echo esc_attr( $this->get_id() ); ?> .premium-banner-ib-content {
                        display: none;
                        }  
                    }
                </style>
                <?php endif; ?>
			</div>
		<?php
	}

	protected function _content_template() {
        ?>
        <#

            view.addRenderAttribute( 'banner', 'id', 'premium-banner-' + view.getID() );
            view.addRenderAttribute( 'banner', 'class', 'premium-banner' );
            
            var active = 'yes' === settings.premium_banner_active ? 'active' : '';
            
            view.addRenderAttribute( 'banner_inner', 'class', [
                'premium-banner-ib',
                'premium-banner-min-height',
                'premium-banner-' + settings.premium_banner_image_animation,
                settings.premium_banner_hover_effect,
                settings.premium_banner_extra_class,
                active
            ] );
            
            var titleTag = settings.premium_banner_title_tag,
                title    = settings.premium_banner_title;
                
            view.addRenderAttribute( 'title_wrap', 'class', [
                'premium-banner-ib-title',
                'ult-responsive',
                'premium_banner_title'
            ] );
            
            view.addInlineEditingAttributes( 'title' );
            
            var description = settings.premium_banner_description;
            
            view.addInlineEditingAttributes( 'description', 'advanced' );
            
            var linkSwitcher = settings.premium_banner_link_switcher,
                readMore     = settings.premium_banner_more_text,
                bannerUrl    = 'url' === settings.premium_banner_link_selection ? settings.premium_banner_link.url : settings.premium_banner_existing_link;
                
            var bannerLink = 'yes' === settings.premium_banner_image_link_switcher ? settings.premium_banner_image_custom_link.url : settings.premium_banner_image_existing_page_link,
                linkTitle = 'yes' === settings.premium_banner_link_url_switch ? settings.premium_banner_link_title : '';
                
            var minSize = settings.premium_banner_min_range + 'px',
                maxSize = settings.premium_banner_max_range + 'px';
        #>
        
            <div {{{ view.getRenderAttributeString( 'banner' ) }}}>
				<div {{{ view.getRenderAttributeString( 'banner_inner' ) }}}>
					<# if( '' !== settings.premium_banner_image.url ) { #>
                        <# if( 'custom' === settings.premium_banner_height ) { #>
                            <div class="premium-banner-img-wrap">
                        <# } #>
                            <img class="premium-banner-ib-img" src="{{ settings.premium_banner_image.url }}">
                        <# if( 'custom' === settings.premium_banner_height ) { #>
                            </div>
                        <# } #>
                    <# } #>
					<div class="premium-banner-ib-desc">
                        <# if( '' !== title ) { #>
                            <{{{titleTag}}} {{{ view.getRenderAttributeString('title_wrap') }}}><div {{{ view.getRenderAttributeString( 'title' ) }}}>{{{ title }}}</div></{{{titleTag}}}>
                        <# } #>
                        <# if( '' !== description ) { #>
                            <div class="premium-banner-ib-content premium_banner_content">
                                <div {{{ view.getRenderAttributeString( 'description' ) }}}>{{{ description }}}</div>
                            </div>
                        <# } #>
                    <# if( 'yes' === linkSwitcher && '' !== readMore ) { #>
                        <div class ="premium-banner-read-more">
                            <a class = "premium-banner-link" href="{{ bannerUrl }}">{{{ readMore }}}</a>
                        </div>
                    <# } #>
					</div>
					<# if( 'yes' === settings.premium_banner_link_url_switch  && ( '' !== settings.premium_banner_image_custom_link.url || '' !== settings.premium_banner_image_existing_page_link ) ) { #>
							<a class="premium-banner-ib-link" href="{{ bannerLink }}" title="{{ linkTitle }}"></a>
                    <# } #>
				</div>
                <# if( 'yes' === settings.premium_banner_responsive_switcher ) { #>
                <style>
                    @media( min-width: {{minSize}} ) and ( max-width: {{maxSize}} ) {
                        #premium-banner-{{ view.getID() }} .premium-banner-ib-content {
                            display: none;
                        }  
                    }
                </style>
                <# } #>
            </div>
        
        
        <?php
	}
}