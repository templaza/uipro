<?php
/**
 * UIPro Heading config class
 *
 * @version     1.0.0
 * @author      TemPlaza
 * @package     UIPro/Classes
 * @category    Classes
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;


if ( ! class_exists( 'UIPro_Config_UICard' ) ) {
	/**
	 * Class UIPro_Config_UICard
	 */
	class UIPro_Config_UICard extends UIPro_Abstract_Config {

		/**
		 * UIPro_Config_Heading constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'uicard';
			self::$name = esc_html__( 'TemPlaza: UI Card', 'uipro' );
			self::$desc = esc_html__( 'Add UI Card Box.', 'uipro' );
			self::$icon = 'eicon-featured-image';
			parent::__construct();

		}

		/*
		 * @return array
		 */
		public function get_options() {
		    $store_id   = md5(__METHOD__);

		    if(isset(static::$cache[$store_id])){
		        return static::$cache[$store_id];
            }

			// options
			$options = array(
                array(
                    'id'          => 'layout',
                    'label' => esc_html__( 'Layout', 'uipro' ),
                    'type' => Controls_Manager::SELECT,
                    'options'       => array(
                        'base'    => esc_html__('Default', 'uipro'),
                        'list'    => esc_html__('List', 'uipro'),
                    ),
                    'default'   => 'base',
                ),
				array(
					'type'          => Controls_Manager::TEXTAREA,
					'name'          => 'title',
					'label'         => esc_html__( 'Title', 'uipro' ),
					'default'       => __('Your Heading Text Here', 'uipro'),
					'description'   => esc_html__( 'Write the title for the heading.', 'uipro' ),
					'dynamic'       => [
						'active'    => true,
					],
					/* vc */
					'admin_label'   => true,
				),
				array(
					'type'          => Controls_Manager::SELECT,
					'name'          => 'title_tag',
					'label'         => esc_html__( 'Title tag', 'uipro' ),
					'options'       => array(
						'h1'        => 'h1',
						'h2'        => 'h2',
						'h3'        => 'h3',
						'h4'        => 'h4',
						'h5'        => 'h5',
						'h6'        => 'h6',
						'div'       => 'div',
						'span'      => 'span',
						'p'         => 'p',
					),
					'default'       => 'h3',
					'description'   => esc_html__( 'Choose heading element.', 'uipro' ),
					'condition'     => array(
						'title!'    => ''
					),
					/* vc */
					'admin_label' => false,
				),
				array(
					'type'          => Group_Control_Typography::get_type(),
					'name'          => 'title_typography',
					'label'         => esc_html__('Title Font', 'uipro'),
					'description'   => esc_html__('Select a font family, font size for the addon title.', 'uipro'),
					'selector'      => '{{WRAPPER}} .ui-card .uk-card-title',
					'condition'     => array(
						'title!'    => ''
					),
				),
				array(
					'type'          =>  Controls_Manager::COLOR,
					'name'          => 'title_color',
					'label'         => esc_html__('Title Color', 'uipro'),
					'description'   => esc_html__('Set the color of title.', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .ui-card .uk-card-title, {{WRAPPER}} .ui-card .uk-card-title a' => 'color: {{VALUE}}',
					],
					'condition'     => array(
						'title!'    => ''
					),
				),
				array(
					'type'          => Controls_Manager::SELECT,
					'name'          => 'title_heading_style',
					'default'       => 'h3',
					'label'         => esc_html__('Style', 'uipro'),
					'description'   => esc_html__('Heading styles differ in font-size but may also come with a predefined color, size and font', 'uipro'),
					'options'       => array(
						''                  => esc_html__('None', 'uipro'),
						'heading-2xlarge'   => esc_html__('2XLarge', 'uipro'),
						'heading-xlarge'    => esc_html__('XLarge', 'uipro'),
						'heading-large'     => esc_html__('Large', 'uipro'),
						'heading-medium'    => esc_html__('Medium', 'uipro'),
						'heading-small'     => esc_html__('Small', 'uipro'),
						'h1'                => esc_html__('H1', 'uipro'),
						'h2'                => esc_html__('H2', 'uipro'),
						'h3'                => esc_html__('H3', 'uipro'),
						'h4'                => esc_html__('H4', 'uipro'),
						'h5'                => esc_html__('H5', 'uipro'),
						'h6'                => esc_html__('H6', 'uipro'),
					),
					'condition'     => array(
						'title!'    => ''
					),
				),

				array(
					'type'          =>  Controls_Manager::SELECT,
					'name'          => 'title_heading_margin',
					'label'         => esc_html__('Title Margin', 'uipro'),
					'description'   => esc_html__('Set the vertical margin for title.', 'uipro'),
					'options'       => array(
						''          => esc_html__('Inherit', 'uipro'),
						'default'   => esc_html__('Default', 'uipro'),
						'small'     => esc_html__('Small', 'uipro'),
						'medium'    => esc_html__('Medium', 'uipro'),
						'large'     => esc_html__('Large', 'uipro'),
						'xlarge'    => esc_html__('X-Large', 'uipro'),
						'custom'    => esc_html__('Custom', 'uipro'),
						'remove'    => esc_html__('None', 'uipro'),
					),
					'default'       => '',
					'condition'     => array(
						'title!'    => ''
					),
				),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'title_custom_margin',
                    'label'         => esc_html__( 'Title custom margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px'],
                    'selectors'     => [
                        '{{WRAPPER}} .uk-card-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition'     => array(
                        'title_heading_margin'    => 'custom'
                    ),
                ),
                array(
                    'type'          => Controls_Manager::TEXTAREA,
                    'name'          => 'meta_title',
                    'label'         => esc_html__( 'Meta Title', 'uipro' ),
                    'description'   => esc_html__( 'Write the meta title.', 'uipro' ),
                    'dynamic'       => [
                        'active'    => true,
                    ],
                ),
                array(
                    'type'          =>  Controls_Manager::SELECT,
                    'name'          => 'meta_position',
                    'label'         => esc_html__('Meta Position', 'uipro'),
                    'description'   => esc_html__('Set the Meta position.', 'uipro'),
                    'options'       => array(
                        'before'     => esc_html__('Before Title', 'uipro'),
                        'after'    => esc_html__('After Title', 'uipro'),
                    ),
                    'default'       => 'after',
                    'condition'     => array(
                        'meta_title!'    => ''
                    ),
                ),
                array(
                    'type'          => Group_Control_Typography::get_type(),
                    'name'          => 'meta_typography',
                    'label'         => esc_html__('Meta Font', 'uipro'),
                    'description'   => esc_html__('Select a font family.', 'uipro'),
                    'selector'      => '{{WRAPPER}} .uk-card-meta',
                    'condition'     => array(
                        'meta_title!'    => ''
                    ),
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'meta_color',
                    'label'         => esc_html__('Meta Color', 'uipro'),
                    'description'   => esc_html__('Set the color of meta.', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .uk-card-meta' => 'color: {{VALUE}}',
                    ],
                    'condition'     => array(
                        'meta_title!'    => ''
                    ),
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'meta_margin',
                    'label'         => esc_html__( 'Meta margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px'],
                    'selectors'     => [
                        '{{WRAPPER}} .uk-card-meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition'     => array(
                        'meta_title!'    => ''
                    ),
                ),
				//Content Settings
				array(
					'name'          => 'text',
					'label'         => esc_html__('Content', 'uipro'),
					'type' => Controls_Manager::WYSIWYG,
					'default' => __( 'Default description', 'uipro' ),
					'placeholder' => __( 'Type your description here', 'uipro' ),
					'separator'     => 'before',
				),
				array(
					'type'          => Group_Control_Typography::get_type(),
					'name'          => 'text_typography',
					'label'         => esc_html__('Content Font', 'uipro'),
					'description'   => esc_html__('Select a font family, font size for the addon content.', 'uipro'),
					'selector'      => '{{WRAPPER}} .ui-card .ui-card-text',
					'condition'     => array(
						'text!'    => ''
					),
				),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'content_color',
                    'label'         => esc_html__('Content Color', 'uipro'),
                    'description'   => esc_html__('Set the color of content.', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ui-card-text' => 'color: {{VALUE}}',
                    ],
                    'condition'     => array(
                        'text!'    => ''
                    ),
                ),

				array(
					'type'          =>  Controls_Manager::SELECT,
					'name'          => 'layout_type',
					'label'         => esc_html__('Layout Type', 'uipro'),
					'description'   => esc_html__('Select icon or image layout type from the list. Both option work for Icon/Image Position Left & Right only.', 'uipro'),
					'options'       => array(
						'icon'      => esc_html__('Icon', 'uipro'),
						'image'     => esc_html__('Image', 'uipro'),
					),
					'default'       => 'icon',
					'separator'     => 'before',
				),
				array(
					'type'          =>  Controls_Manager::SELECT,
					'name'          => 'title_position',
					'label'         => esc_html__('Icon Position', 'uipro'),
					'description'   => esc_html__('Set the icon position.', 'uipro'),
					'options'       => array(
						'after'     => esc_html__('Before Title', 'uipro'),
						'before'    => esc_html__('After Title', 'uipro'),
						'left'    => esc_html__('Left Title', 'uipro'),
					),
					'default'       => 'after',
					'condition'     => array(
						'title!'    => ''
					),
				),

				//Icon Settings
				array(
					'type'          => Controls_Manager::SELECT,
					'name'          => 'icon_type',
					'label' => __( 'Icon Type', 'uipro' ),
					'default' => '',
					'options' => [
						''  => __( 'FontAwesome', 'uipro' ),
						'uikit' => __( 'UIKit', 'uipro' ),
					],
					'conditions' => [
						'terms' => [
							['name' => 'layout_type', 'operator' => '===', 'value' => 'icon'],
						],
					],
				),
				array(
					'type'          => Controls_Manager::ICONS,
					'name'          => 'icon',
					'label'         => esc_html__('Select Icon:', 'uipro'),
					'conditions' => [
						'terms' => [
							['name' => 'layout_type', 'operator' => '===', 'value' => 'icon'],
							['name' => 'icon_type', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'type'          => Controls_Manager::SELECT2,
					'name'          => 'uikit_icon',
					'label'         => esc_html__('Select Icon:', 'uipro'),
					'default' => '',
					'conditions' => [
						'terms' => [
							['name' => 'layout_type', 'operator' => '===', 'value' => 'icon'],
							['name' => 'icon_type', 'operator' => '===', 'value' => 'uikit'],
						],
					],
					'options' => $this->get_font_uikit(),
				),
				array(
					'name'          => 'icon_size',
					'label' => __( 'Icon Size', 'uipro' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 400,
							'step' => 1,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 64,
					],
					'selectors' => [
						'{{WRAPPER}} .ui-media' => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .ui-media i' => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .ui-media svg' => 'width: {{SIZE}}{{UNIT}};',
					],
					'conditions' => [
						'terms' => [
							['name' => 'layout_type', 'operator' => '===', 'value' => 'icon'],
						],
					],
				),
				array(
					'type'          =>  Controls_Manager::COLOR,
					'name'          => 'icon_color',
					'label'         => esc_html__('Icon Color', 'uipro'),
					'description'   => esc_html__('Set the color of Icon.', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .ui-media' => 'color: {{VALUE}}',
						'{{WRAPPER}} .ui-media svg' => 'fill: {{VALUE}}',
					],
					'conditions' => [
						'terms' => [
							['name' => 'layout_type', 'operator' => '===', 'value' => 'icon'],
						],
					],
				),
				array(
					'type'          =>  Controls_Manager::COLOR,
					'name'          => 'icon_bg_color',
					'label'         => esc_html__('Icon Background Color', 'uipro'),
					'description'   => esc_html__('Set the background color of Icon.', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .ui-media' => 'background-color: {{VALUE}}',
					],
					'conditions' => [
						'terms' => [
							['name' => 'layout_type', 'operator' => '===', 'value' => 'icon'],
						],
					],
				),
                array(
                    'name'          => 'icon_box_size',
                    'label' => esc_html__( 'Icon Box Size', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'responsive'    =>  true,
                    'size_units' => [ 'px','%' ],
                    'selectors' => [
                        '{{WRAPPER}} .ui-media' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};display:flex; align-items:center;justify-content:center;',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'layout_type', 'operator' => '===', 'value' => 'icon'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'icon_radius',
                    'label'         => esc_html__( 'Icon Border radius', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-media' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'layout_type', 'operator' => '===', 'value' => 'icon'],
                        ],
                    ],
                ),
                array(
                    'type'      => Controls_Manager::SWITCHER,
                    'name'      => 'icon_arrow',
                    'label'     => esc_html__( 'Show icon Arrow', 'uipro' ),
                    'conditions' => [
                        'terms' => [
                            ['name' => 'layout_type', 'operator' => '===', 'value' => 'icon'],
                        ],
                    ],
                ),
                array(
                    'name'          => 'icon_arrow_width',
                    'label' => esc_html__( 'Arrow width', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'responsive'    =>  true,
                    'range' => [
                        'px' => [
                            'min' => -1000,
                            'max' => 1000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => -100,
                            'max' => 100,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'size' => 6,
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'layout_type', 'operator' => '===', 'value' => 'icon'],
                            ['name' => 'icon_arrow', 'operator' => '===', 'value' => 'yes'],
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .ui-card.yes .ui-media::after' => 'border-width: {{SIZE}}{{UNIT}}; margin-left: -{{SIZE}}{{UNIT}};',
                    ],
                ),
                array(
                    'name'          => 'icon_arrow_bottom',
                    'label' => esc_html__( 'Arrow Offset Bottom', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'responsive'    =>  true,
                    'range' => [
                        'px' => [
                            'min' => -1000,
                            'max' => 1000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => -100,
                            'max' => 100,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'size' => -5,
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'layout_type', 'operator' => '===', 'value' => 'icon'],
                            ['name' => 'icon_arrow', 'operator' => '===', 'value' => 'yes'],
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .ui-card.yes .ui-media::after' => 'bottom: {{SIZE}}{{UNIT}};',
                    ],
                ),
                array(
                    'label' => esc_html__( 'Arrow color', 'uipro' ),
                    'name'  => 'arrow_color',
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .ui-card.yes .ui-media::after' => 'border-top-color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'layout_type', 'operator' => '===', 'value' => 'icon'],
                            ['name' => 'icon_arrow', 'operator' => '===', 'value' => 'yes'],
                        ],
                    ],
                ),

				//Image Settings
				array(
					'type'          =>  Controls_Manager::MEDIA,
					'name'          => 'image',
					'label'         => esc_html__('Select Image:', 'uipro'),
					'default' => [
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					],
					'conditions' => [
						'terms' => [
							['name' => 'layout_type', 'operator' => '===', 'value' => 'image'],
						],
					],
				),
				array(
					'type'          => Controls_Manager::SELECT,
					'name'          => 'image_appear',
					'label' => __( 'Image Appear', 'uipro' ),
					'default' => 'top',
					'options' => [
						'top'        => __( 'Top', 'uipro' ),
						'inside'   => __( 'Inside', 'uipro' ),
						'bottom'   => __( 'Bottom', 'uipro' ),
						'thumbnail'   => __( 'Thumbnail', 'uipro' ),
					],
					'conditions' => [
						'terms' => [
							['name' => 'layout_type', 'operator' => '===', 'value' => 'image'],
						],
					],
				),
				array(
					'type'          => Controls_Manager::SELECT,
					'name'          => 'image_content',
					'label' => __( 'Image Content', 'uipro' ),
					'default' => 'uk-position-bottom',
					'options' => [
						'uk-position-top'        => __( 'Top', 'uipro' ),
						'uk-position-center'   => __( 'Center', 'uipro' ),
						'uk-position-bottom'   => __( 'Bottom', 'uipro' ),
					],
					'conditions' => [
						'terms' => [
							['name' => 'layout_type', 'operator' => '===', 'value' => 'image'],
							['name' => 'image_appear', 'operator' => '===', 'value' => 'thumbnail'],
						],
					],
				),
				array(
					'type'          => Controls_Manager::DIMENSIONS,
					'name'          =>  'image_border-radius',
					'label'         => esc_html__( 'Image border radius', 'uipro' ),
					'responsive'    =>  true,
					'size_units'    => [ 'px', 'em', '%' ],
					'selectors'     => [
						'{{WRAPPER}} .ui-card .ui-media' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'conditions' => [
						'terms' => [
							['name' => 'layout_type', 'operator' => '===', 'value' => 'image'],
						],
					],
				),
				array(
					'type'          => \Elementor\Group_Control_Background::get_type(),
					'name'          => 'image_content_bg',
					'label' => __( 'Image Content Background', 'uipro' ),
					'default' => '',
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .uk-card-body',
					'conditions' => [
						'terms' => [
							['name' => 'layout_type', 'operator' => '===', 'value' => 'image'],
							['name' => 'image_appear', 'operator' => '===', 'value' => 'thumbnail'],
						],
					],
				),

				array(
					'type'          =>  Controls_Manager::SELECT,
					'name'          => 'media_margin',
					'label'         => esc_html__('Media Margin', 'uipro'),
					'description'   => esc_html__('Set the vertical margin for Icon/Image.', 'uipro'),
					'options'       => array(
						''          => esc_html__('Inherit', 'uipro'),
						'default'   => esc_html__('Default', 'uipro'),
						'small'     => esc_html__('Small', 'uipro'),
						'medium'    => esc_html__('Medium', 'uipro'),
						'large'     => esc_html__('Large', 'uipro'),
						'xlarge'    => esc_html__('X-Large', 'uipro'),
						'custom'    => esc_html__('Custom', 'uipro'),
						'remove'    => esc_html__('None', 'uipro'),
					),
					'default'       => '',
				),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'media_custom_margin',
                    'label'         => esc_html__( 'Media custom margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px'],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-media' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'media_margin', 'operator' => '===', 'value' => 'custom'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'id'            => 'media_transition',
                    'label'         => esc_html__( 'Media Transition', 'uipro' ),
                    'description'   => esc_html__( 'Select the image\'s transition style.', 'uipro' ),
                    'options'       => array(
                        '' => __('None', 'uipro'),
                        'scale-up' => __('Scales Up', 'uipro'),
                        'scale-down' => __('Scales Down', 'uipro'),
                        'zoomin-roof' => __('Zoom in roof', 'uipro'),
                    ),
                    'default'       => '',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'image[url]', 'operator' => '!==', 'value' => ''],
                        ],
                    ],
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'roof_border_color',
                    'label'         => esc_html__('Roof Border Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .zoomin-roof a::before' => 'border-right-color: {{VALUE}}',
                        '{{WRAPPER}} .zoomin-roof a::after' => 'border-left-color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'media_transition', 'operator' => '===', 'value' => 'zoomin-roof'],
                        ],
                    ],
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'roof_border_hover_color',
                    'label'         => esc_html__('Roof Border Hover Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .zoomin-roof:hover a::before' => 'border-right-color: {{VALUE}}',
                        '{{WRAPPER}} .zoomin-roof:hover a::after' => 'border-left-color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'media_transition', 'operator' => '===', 'value' => 'zoomin-roof'],
                        ],
                    ],
                ),
                array(
                    'name'          => 'roof_hover-rotate',
                    'label' => __( 'Roof Hover rotate', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'deg' ],
                    'responsive'    =>  true,
                    'range' => [
                        'px' => [
                            'min' => -360,
                            'max' => 360,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'unit' => 'deg',
                        'size' => 50,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .zoomin-roof:hover a::before' => 'transform: rotate({{SIZE}}{{UNIT}});',
                        '{{WRAPPER}} .zoomin-roof:hover a::after' => 'transform: rotate(-{{SIZE}}{{UNIT}});',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'media_transition', 'operator' => '===', 'value' => 'zoomin-roof'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::TEXT,
                    'name'          => 'roof_transform_left_hover',
                    'label'         => esc_html__( 'Roof left transform hover', 'uipro' ),
                    'description'   => esc_html__( 'Example: [translateX(-100%)] Read more: https://www.w3schools.com/cssref/css3_pr_transform.php ', 'uipro' ),
                    'selectors' => [
                        '{{WRAPPER}} .zoomin-roof:hover a::before' => 'transform: {{VALUE}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'media_transition', 'operator' => '===', 'value' => 'zoomin-roof'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::TEXT,
                    'name'          => 'roof_transform_right_hover',
                    'label'         => esc_html__( 'Roof right transform hover', 'uipro' ),
                    'description'   => esc_html__( 'Example: [translateX(100%)] Read more: https://www.w3schools.com/cssref/css3_pr_transform.php ', 'uipro' ),
                    'selectors' => [
                        '{{WRAPPER}} .zoomin-roof:hover a::after' => 'transform: {{VALUE}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'media_transition', 'operator' => '===', 'value' => 'zoomin-roof'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'roof_left_hover-radius',
                    'label'         => esc_html__( 'Roof left hover radius', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .zoomin-roof:hover a.tz-img::before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'media_transition', 'operator' => '===', 'value' => 'zoomin-roof'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'roof_right_hover-radius',
                    'label'         => esc_html__( 'Roof right hover radius', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .zoomin-roof:hover a.tz-img::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'media_transition', 'operator' => '===', 'value' => 'zoomin-roof'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::TEXTAREA,
                    'name'          => 'roof_transform_hover',
                    'label'         => esc_html__( 'Roof transform hover', 'uipro' ),
                    'description'   => esc_html__( 'Example: transform: rotate(20deg) Read more: https://www.w3schools.com/cssref/css3_pr_transform.php ', 'uipro' ),
                    'selectors' => [
                        '{{WRAPPER}} .zoomin-roof:hover a::before' => 'transform: rotate({{SIZE}}{{UNIT}});',
                        '{{WRAPPER}} .zoomin-roof:hover a::after' => 'transform: rotate(-{{SIZE}}{{UNIT}});',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'media_transition', 'operator' => '===', 'value' => 'zoomin-roof'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::TEXT,
                    'name'          => 'roof_left_transform',
                    'label'         => esc_html__( 'Roof left transform', 'uipro' ),
                    'description'   => esc_html__( 'Example: [top right] Read more: https://www.w3schools.com/cssref/css3_pr_transform-origin.php', 'uipro' ),
                    'selectors' => [
                        '{{WRAPPER}} .zoomin-roof a::before' => 'transform-origin: {{VALUE}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'media_transition', 'operator' => '===', 'value' => 'zoomin-roof'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::TEXT,
                    'name'          => 'roof_right_transform',
                    'label'         => esc_html__( 'Roof right transform', 'uipro' ),
                    'description'   => esc_html__( 'Example: [top left] Read more: https://www.w3schools.com/cssref/css3_pr_transform-origin.php', 'uipro' ),
                    'selectors' => [
                        '{{WRAPPER}} .zoomin-roof a::after' => 'transform-origin: {{VALUE}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'media_transition', 'operator' => '===', 'value' => 'zoomin-roof'],
                        ],
                    ],
                ),


                array(
                    'type'          => Controls_Manager::ICONS,
                    'name'          => 'icon_media',
                    'label'         => esc_html__('Icon on media:', 'uipro'),
                    'conditions' => [
                        'terms' => [
                            ['name' => 'layout_type', 'operator' => '===', 'value' => 'image'],
                            ['name' => 'image', 'operator' => '!==', 'value' => ''],
                        ],
                    ],
                ),

                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'icon_media_color',
                    'label'         => esc_html__('Icon Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ui_icon_on_media' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .ui_icon_on_media svg' => 'fill: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'icon_media', 'operator' => '!==', 'value' => ''],
	                        ['name' => 'layout_type', 'operator' => '===', 'value' => 'image'],
                        ],
                    ],
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'icon_media_bg_color',
                    'label'         => esc_html__('Icon Background Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ui_icon_on_media' => 'background-color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'icon_media', 'operator' => '!==', 'value' => ''],
	                        ['name' => 'layout_type', 'operator' => '===', 'value' => 'image'],
                        ],
                    ],
                ),
                array(
                    'name'          => 'icon_media_size',
                    'label' => __( 'Icon Size', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 400,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 64,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .ui-media' => 'font-size: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .ui-media svg' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'icon_media', 'operator' => '!==', 'value' => ''],
	                        ['name' => 'layout_type', 'operator' => '===', 'value' => 'image'],
                        ],
                    ],
                ),
                array(
                    'name'          => 'icon_media_box_size',
                    'label' => esc_html__( 'Icon Box Size', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'responsive'    =>  true,
                    'size_units' => [ 'px','%' ],
                    'selectors' => [
                        '{{WRAPPER}} .ui_icon_on_media' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};display:flex; align-items:center;justify-content:center;',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'icon_media', 'operator' => '!==', 'value' => ''],
	                        ['name' => 'layout_type', 'operator' => '===', 'value' => 'image'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'icon_media_padding',
                    'label'         => esc_html__( 'Icon Box Padding', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui_icon_on_media' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'icon_media', 'operator' => '!==', 'value' => ''],
	                        ['name' => 'layout_type', 'operator' => '===', 'value' => 'image'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'icon_media_custom_margin',
                    'label'         => esc_html__( 'Icon box custom margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px'],
                    'selectors'     => [
                        '{{WRAPPER}} .ui_icon_on_media' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'icon_media', 'operator' => '!==', 'value' => ''],
	                        ['name' => 'layout_type', 'operator' => '===', 'value' => 'image'],
                        ],
                    ],
                ),
                array(
                    'type'          =>  \Elementor\Group_Control_Box_Shadow::get_type(),
                    'name'          => 'icon_media_box_shadow',
                    'label'         => esc_html__('Icon Box Shadow', 'uipro'),
                    'selector' => '{{WRAPPER}} .ui_icon_on_media',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'icon_media', 'operator' => '!==', 'value' => ''],
	                        ['name' => 'layout_type', 'operator' => '===', 'value' => 'image'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'icon_media_radius',
                    'label'         => esc_html__( 'Icon Border radius', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui_icon_on_media' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'icon_media', 'operator' => '!==', 'value' => ''],
	                        ['name' => 'layout_type', 'operator' => '===', 'value' => 'image'],
                        ],
                    ],
                ),

				//Link Settings
				array(
					'type'          => Controls_Manager::URL,
					'name'          => 'link',
					'label'         => esc_html__( 'Title/Image/Icon/Button Url', 'uipro' ),
					'dynamic'       => [
						'active'    => true,
					],
					'default'       => [
						'url'       => '',
					],
					'separator'     => 'before',
				),
				array(
					'type'          => Controls_Manager::SELECT,
					'name'          => 'url_appear',
					'label' => esc_html__( 'Url Appear', 'uipro' ),
					'default' => 'button',
					'options' => [
						'button'        => esc_html__( 'Button', 'uipro' ),
						'button_title'   => esc_html__( 'Button & Title', 'uipro' ),
						'button_media'   => esc_html__( 'Button & Icon/Image', 'uipro' ),
						'all'   => esc_html__( 'All', 'uipro' ),
					],
					'conditions' => [
						'terms' => [
							['name' => 'link[url]', 'operator' => '!==', 'value' => ''],
						],
					],
				),

				//Card Settings
				array(
					'type'          => Controls_Manager::SELECT,
					'name'          => 'card_style',
					'label' => esc_html__( 'Card Style', 'uipro' ),
					'default' => '',
					'options' => [
						'' => esc_html__('None', 'uipro'),
						'default' => esc_html__('Card Default', 'uipro'),
						'primary' => esc_html__('Card Primary', 'uipro'),
						'secondary' => esc_html__('Card Secondary', 'uipro'),
						'hover' => esc_html__('Card Hover', 'uipro'),
						'custom' => esc_html__('Custom', 'uipro'),
					],
					'start_section' => 'card',
					'section_name'      => esc_html__('Card Settings', 'uipro')
				),
				array(
					'type'          =>  Controls_Manager::COLOR,
					'name'          => 'card_background',
					'label'         => esc_html__('Card Background', 'uipro'),
					'description'   => esc_html__('Set the Background Color of Card.', 'uipro'),
					'separator'     => 'before',
					'selectors' => [
						'{{WRAPPER}} .ui-card' => 'background-color: {{VALUE}}',
					],
					'conditions' => [
						'terms' => [
							['name' => 'card_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				),
				array(
					'type'          =>  Controls_Manager::COLOR,
					'name'          => 'card_color',
					'label'         => esc_html__('Card Color', 'uipro'),
					'description'   => esc_html__('Set the Color of Card.', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .ui-card' => 'color: {{VALUE}}',
					],
					'conditions' => [
						'terms' => [
							['name' => 'card_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				),
				array(
					'type'          =>  \Elementor\Group_Control_Border::get_type(),
					'name'          => 'card_border',
					'label'         => esc_html__('Card Border', 'uipro'),
					'description'   => esc_html__('Set the Border of Card.', 'uipro'),
					'selector' => '{{WRAPPER}} .ui-card',
					'conditions' => [
						'terms' => [
							['name' => 'card_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				),
				array(
					'type'          =>  \Elementor\Group_Control_Box_Shadow::get_type(),
					'name'          => 'card_box_shadow',
					'label'         => esc_html__('Card Box Shadow', 'uipro'),
					'description'   => esc_html__('Set the Box Shadow of Card.', 'uipro'),
					'selector' => '{{WRAPPER}} .ui-card',
					'conditions' => [
						'terms' => [
							['name' => 'card_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				),
				array(
					'type'          =>  Controls_Manager::COLOR,
					'name'          => 'card_background_hover',
					'label'         => esc_html__('Card Background Hover', 'uipro'),
					'description'   => esc_html__('Set the Background Color of Card on mouse hover.', 'uipro'),
					'separator'     => 'before',
					'selectors' => [
						'{{WRAPPER}} .ui-card:hover' => 'background-color: {{VALUE}}',
					],
					'conditions' => [
						'terms' => [
							['name' => 'card_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				),
				array(
					'type'          =>  Controls_Manager::COLOR,
					'name'          => 'card_color_hover',
					'label'         => esc_html__('Card Color Hover', 'uipro'),
					'description'   => esc_html__('Set the Color of Card on mouse hover.', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .ui-card:hover, {{WRAPPER}} .ui-card:hover *' => 'color: {{VALUE}}',
					],
					'conditions' => [
						'terms' => [
							['name' => 'card_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				),
				array(
					'type'          =>  \Elementor\Group_Control_Border::get_type(),
					'name'          => 'card_border_hover',
					'label'         => esc_html__('Card Border Hover', 'uipro'),
					'description'   => esc_html__('Set the Border of Card on mouse hover.', 'uipro'),
					'selector' => '{{WRAPPER}} .ui-card:hover',
					'conditions' => [
						'terms' => [
							['name' => 'card_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				),
				array(
					'type'          =>  \Elementor\Group_Control_Box_Shadow::get_type(),
					'name'          => 'card_box_shadow_hover',
					'label'         => esc_html__('Card Box Shadow Hover', 'uipro'),
					'description'   => esc_html__('Set the Box Shadow of Card hover.', 'uipro'),
					'selector' => '{{WRAPPER}} .ui-card:hover',
					'conditions' => [
						'terms' => [
							['name' => 'card_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				),
                array(
                    'name'          => 'card_duration',
                    'label' => __( 'Transition duration', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        's' => [
                            'min' => 0,
                            'max' => 3,
                            'step' => 0.1,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .ui-card, {{WRAPPER}} .ui-card:hover' => 'transition: all {{SIZE}}s linear;',
                    ],
                ),
				array(
					'type'          => Controls_Manager::SELECT,
					'name'          => 'card_size',
					'label' => esc_html__( 'Card Size', 'uipro' ),
					'default' => '',
					'separator'     => 'before',
					'options' => [
						'' => esc_html__('Default', 'uipro'),
						'small' => esc_html__('Small', 'uipro'),
						'large' => esc_html__('Large', 'uipro'),
						'custom' => esc_html__('Custom', 'uipro'),
					],
				),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'card_radius',
                    'label'         => esc_html__( 'Border radius', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;',
                    ],
                ),
				array(
					'type'          => Controls_Manager::DIMENSIONS,
					'name'          =>  'card_padding',
					'label'         => esc_html__( 'Card Padding', 'uipro' ),
					'responsive'    =>  true,
					'size_units'    => [ 'px', 'em', '%' ],
					'selectors'     => [
						'{{WRAPPER}} .uk-card-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'conditions' => [
						'terms' => [
							['name' => 'card_size', 'operator' => '===', 'value' => 'custom'],
						],
					],
				),
                array(
                    'id'          => 'list_align_items',
                    'label' => esc_html__( 'List align items', 'uipro' ),
                    'type' => Controls_Manager::CHOOSE,
                    'default' => '',
                    'options' => [
                        'flex-start' => [
                            'title' => esc_html__( 'Start', 'elementor' ),
                            'icon' => 'eicon-flex eicon-align-start-v',
                        ],
                        'center' => [
                            'title' => esc_html__( 'Center', 'elementor' ),
                            'icon' => 'eicon-flex eicon-align-center-v',
                        ],
                        'flex-end' => [
                            'title' => esc_html__( 'End', 'elementor' ),
                            'icon' => 'eicon-flex eicon-align-end-v',
                        ],
                        'stretch' => [
                            'title' => esc_html__( 'Stretch', 'elementor' ),
                            'icon' => 'eicon-flex eicon-align-stretch-v',
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .uk-card-list' => 'align-items: {{VALUE}};',
                    ],
                    'responsive' => true,
                    'separator'     => 'before',
                    'start_section' => 'list',
                    'section_name'      => esc_html__('List Settings', 'uipro'),
                    'condition'     => array(
                        'layout'    => 'list'
                    ),
                ),
                array(
                    'id'          => 'meta_desktop_width',
                    'label' => esc_html__( 'Meta Title Width', 'uipro' ),
                    'type' => Controls_Manager::SELECT,
                    'options'       => array(
                        'uk-width-1-1'    => esc_html__('1/1', 'uipro'),
                        'uk-width-1-2'    => esc_html__('1/2', 'uipro'),
                        'uk-width-1-3'    => esc_html__('1/3', 'uipro'),
                        'uk-width-1-4'    => esc_html__('1/4', 'uipro'),
                        'uk-width-1-5'    => esc_html__('1/5', 'uipro'),
                        'uk-width-1-6'    => esc_html__('1/6', 'uipro'),
                        'uk-width-auto'    => esc_html__('auto', 'uipro'),
                        'uk-width-expand'    => esc_html__('expand', 'uipro'),
                    ),
                    'default'   => 'uk-width-1-6',
                    'separator'     => 'before',
                    'start_section' => 'list',
                    'section_name'      => esc_html__('List Settings', 'uipro'),
                    'condition'     => array(
                        'layout'    => 'list'
                    ),
                ),
                array(
                    'type'         => Controls_Manager::CHOOSE,
                    'label'         => esc_html__( 'Meta alignment', 'uipro' ),
                    'name'          => 'meta_list_align',
                    'responsive'    => true, /* this will be add in responsive layout */
                    'options'       => [
                        'left'      => [
                            'title' => esc_html__( 'Left', 'uipro' ),
                            'icon'  => 'eicon-text-align-left',
                        ],
                        'center'    => [
                            'title' => esc_html__( 'Center', 'uipro' ),
                            'icon'  => 'eicon-text-align-center',
                        ],
                        'right'     => [
                            'title' => esc_html__( 'Right', 'uipro' ),
                            'icon'  => 'eicon-text-align-right',
                        ],
                        'justify'   => [
                            'title' => esc_html__( 'Justified', 'uipro' ),
                            'icon'  => 'eicon-text-align-justify',
                        ],
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .uk-card-meta'   => 'text-align: {{VALUE}}; align-items: {{VALUE}};',
                    ],
                ),
                array(
                    'id'          => 'title_desktop_width',
                    'label' => esc_html__( 'Title Width', 'uipro' ),
                    'type' => Controls_Manager::SELECT,
                    'options'       => array(
                        'uk-width-1-1'    => esc_html__('1/1', 'uipro'),
                        'uk-width-1-2'    => esc_html__('1/2', 'uipro'),
                        'uk-width-1-3'    => esc_html__('1/3', 'uipro'),
                        'uk-width-1-4'    => esc_html__('1/4', 'uipro'),
                        'uk-width-1-5'    => esc_html__('1/5', 'uipro'),
                        'uk-width-1-6'    => esc_html__('1/6', 'uipro'),
                        'uk-width-auto'    => esc_html__('auto', 'uipro'),
                        'uk-width-expand'    => esc_html__('expand', 'uipro'),
                    ),
                    'default'   => 'uk-width-1-4',
                    'separator'     => 'before',
                    'start_section' => 'list',
                    'section_name'      => esc_html__('List Settings', 'uipro'),
                    'condition'     => array(
                        'layout'    => 'list'
                    ),
                ),
                array(
                    'type'         => Controls_Manager::CHOOSE,
                    'label'         => esc_html__( 'Title alignment', 'uipro' ),
                    'name'          => 'title_list_align',
                    'responsive'    => true, /* this will be add in responsive layout */
                    'options'       => [
                        'left'      => [
                            'title' => esc_html__( 'Left', 'uipro' ),
                            'icon'  => 'eicon-text-align-left',
                        ],
                        'center'    => [
                            'title' => esc_html__( 'Center', 'uipro' ),
                            'icon'  => 'eicon-text-align-center',
                        ],
                        'right'     => [
                            'title' => esc_html__( 'Right', 'uipro' ),
                            'icon'  => 'eicon-text-align-right',
                        ],
                        'justify'   => [
                            'title' => esc_html__( 'Justified', 'uipro' ),
                            'icon'  => 'eicon-text-align-justify',
                        ],
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .uk-card-title'   => 'text-align: {{VALUE}}; align-items: {{VALUE}};',
                    ],
                ),
                array(
                    'id'          => 'content_desktop_width',
                    'label' => esc_html__( 'Content Width', 'uipro' ),
                    'type' => Controls_Manager::SELECT,
                    'options'       => array(
                        'uk-width-1-1'    => esc_html__('1/1', 'uipro'),
                        'uk-width-1-2'    => esc_html__('1/2', 'uipro'),
                        'uk-width-1-3'    => esc_html__('1/3', 'uipro'),
                        'uk-width-1-4'    => esc_html__('1/4', 'uipro'),
                        'uk-width-1-5'    => esc_html__('1/5', 'uipro'),
                        'uk-width-1-6'    => esc_html__('1/6', 'uipro'),
                        'uk-width-auto'    => esc_html__('auto', 'uipro'),
                        'uk-width-expand'    => esc_html__('expand', 'uipro'),
                    ),
                    'default'   => 'uk-width-1-2',
                    'separator'     => 'before',
                    'start_section' => 'list',
                    'section_name'      => esc_html__('List Settings', 'uipro'),
                    'condition'     => array(
                        'layout'    => 'list'
                    ),
                ),
                array(
                    'type'         => Controls_Manager::CHOOSE,
                    'label'         => esc_html__( 'Content alignment', 'uipro' ),
                    'name'          => 'content_list_align',
                    'responsive'    => true, /* this will be add in responsive layout */
                    'options'       => [
                        'left'      => [
                            'title' => esc_html__( 'Left', 'uipro' ),
                            'icon'  => 'eicon-text-align-left',
                        ],
                        'center'    => [
                            'title' => esc_html__( 'Center', 'uipro' ),
                            'icon'  => 'eicon-text-align-center',
                        ],
                        'right'     => [
                            'title' => esc_html__( 'Right', 'uipro' ),
                            'icon'  => 'eicon-text-align-right',
                        ],
                        'justify'   => [
                            'title' => esc_html__( 'Justified', 'uipro' ),
                            'icon'  => 'eicon-text-align-justify',
                        ],
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-card-text'   => 'text-align: {{VALUE}}; align-items: {{VALUE}};',
                    ],
                ),
                array(
                    'id'          => 'button_desktop_width',
                    'label' => esc_html__( 'Button Width', 'uipro' ),
                    'type' => Controls_Manager::SELECT,
                    'options'       => array(
                        'uk-width-1-1'    => esc_html__('1/1', 'uipro'),
                        'uk-width-1-2'    => esc_html__('1/2', 'uipro'),
                        'uk-width-1-3'    => esc_html__('1/3', 'uipro'),
                        'uk-width-1-4'    => esc_html__('1/4', 'uipro'),
                        'uk-width-1-5'    => esc_html__('1/5', 'uipro'),
                        'uk-width-1-6'    => esc_html__('1/6', 'uipro'),
                        'uk-width-auto'    => esc_html__('auto', 'uipro'),
                        'uk-width-expand'    => esc_html__('expand', 'uipro'),
                    ),
                    'default'   => 'uk-width-1-6',
                    'separator'     => 'before',
                    'start_section' => 'list',
                    'section_name'      => esc_html__('List Settings', 'uipro'),
                    'condition'     => array(
                        'layout'    => 'list'
                    ),
                ),
                array(
                    'type'         => Controls_Manager::CHOOSE,
                    'label'         => esc_html__( 'Button alignment', 'uipro' ),
                    'name'          => 'button_list_align',
                    'responsive'    => true, /* this will be add in responsive layout */
                    'options'       => [
                        'left'      => [
                            'title' => esc_html__( 'Left', 'uipro' ),
                            'icon'  => 'eicon-text-align-left',
                        ],
                        'center'    => [
                            'title' => esc_html__( 'Center', 'uipro' ),
                            'icon'  => 'eicon-text-align-center',
                        ],
                        'right'     => [
                            'title' => esc_html__( 'Right', 'uipro' ),
                            'icon'  => 'eicon-text-align-right',
                        ],
                        'justify'   => [
                            'title' => esc_html__( 'Justified', 'uipro' ),
                            'icon'  => 'eicon-text-align-justify',
                        ],
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-button'   => 'text-align: {{VALUE}}; align-items: {{VALUE}};',
                    ],
                ),
				//Button Settings
				array(
					'type'          => Controls_Manager::TEXTAREA,
					'name'          => 'button_text',
					'label'         => esc_html__( 'Button Text', 'uipro' ),
					'description'   => esc_html__( 'Enter button texts here. Leave blank if no button is required.', 'uipro' ),
					'dynamic'       => [
						'active'    => true,
					],
					'start_section' => 'button',
					'section_name'      => esc_html__('Button Settings', 'uipro')
				),
				array(
                    'label'         => esc_html__( 'Icon Type', 'uipro' ),
                    'name'          => 'button_icon',
                    'type'          => Controls_Manager::SELECT,
                    'default'       => '',
                    'options'       => [
                        ''          => esc_html__( 'FontAwesome', 'uipro' ),
                        'uikit'     => esc_html__( 'UIKit', 'uipro' ),
                    ],
				),
				array(
                    'label'         => esc_html__( 'Select Icon:', 'uipro' ),
                    'name'          => 'fontawesome_icon',
                    'type'          => Controls_Manager::ICONS,
                    'conditions'    => [
                        'terms'     => [
                            ['name' => 'button_icon', 'operator' => '===', 'value' => ''],
                        ],
                    ],
				),
				array(
                    'label'         => esc_html__( 'Select Icon:', 'uipro' ),
                    'name'          => 'btn_uikit_icon',
                    'type'          => Controls_Manager::SELECT2,
                    'default'       => '',
                    'conditions'    => [
                        'terms'     => [
                            ['name' => 'button_icon', 'operator' => '===', 'value' => 'uikit'],
                        ],
                    ],
                    'options' => $this->get_font_uikit(),
				),
				array(
                    'label'         => esc_html__( 'Icon Position', 'uipro' ),
                    'name'          => 'icon_position',
                    'type'          => Controls_Manager::SELECT,
                    'default'       => '',
                    'options'       => [
                        ''          => esc_html__( 'Left', 'uipro' ),
                        'right'     => esc_html__( 'Right', 'uipro' ),
                    ],
                    'condition'     => array(
                        'button_text!'    => ''
                    ),
				),

				array(
					'type'          => Group_Control_Typography::get_type(),
					'name'          => 'button_typography',
					'label'         => esc_html__('Button Font', 'uipro'),
					'description'   => esc_html__('Select a font family, font size for button.', 'uipro'),
					'selector'      => '{{WRAPPER}} .ui-button .uk-button',

				),
				array(
					'name'          => 'button_style',
					'label' => esc_html__( 'Button Style', 'uipro' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => '',
					'options' => [
						'' => esc_html__('Default', 'uipro' ),
						'primary' => esc_html__('Primary', 'uipro') ,
						'secondary' => esc_html__('Secondary', 'uipro' ),
						'danger' => esc_html__('Danger', 'uipro' ),
						'text' => esc_html__('Text', 'uipro' ),
						'link' => esc_html__('Link', 'uipro' ),
						'link-muted' => esc_html__('Link Muted', 'uipro' ),
						'link-text' => esc_html__('Link Text', 'uipro' ),
						'custom' => esc_html__('Custom', 'uipro' ),
					],
				),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'button_padding',
                    'label'         => esc_html__( 'Button Padding', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .uk-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'button_style', 'operator' => '===', 'value' => 'custom'],
                        ],
                    ],
                ),
				array(
                    'label' => esc_html__( 'Background Color', 'uipro' ),
                    'name'          => 'button_background',
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'separator'     => 'before',
                    'selectors' => [
                        '{{WRAPPER}} .uk-button' => 'background-color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'button_style', 'operator' => '===', 'value' => 'custom'],
                        ],
                    ],
				),
				array(
                    'label' => esc_html__( 'Color', 'uipro' ),
                    'name'          => 'button_color',
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .uk-button' => 'color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'button_style', 'operator' => '===', 'value' => 'custom'],
                        ],
                    ],
				),
                array(
                    'id'          => 'border_radius',
                    'label' => __( 'Button Border Radius', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px','%' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 400,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 10,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .ui-button .uk-button' => 'border-radius: {{SIZE}}{{UNIT}} !important;',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'button_style', 'operator' => '===', 'value' => 'custom'],
                        ],
                    ],
                ),
				array(
                    'label' => esc_html__( 'Button Border', 'uipro' ),
                    'name'          => 'button_border',
                    'type' => \Elementor\Group_Control_Border::get_type(),
                    'selector' => '{{WRAPPER}} .uk-button',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'button_style', 'operator' => '===', 'value' => 'custom'],
                        ],
                    ],
				),
				array(
                    'label' => esc_html__( 'Hover Background Color', 'uipro' ),
                    'name'          => 'hover_button_background',
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'separator'     => 'before',
                    'selectors' => [
                        '{{WRAPPER}} .uk-button:hover' => 'background-color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'button_style', 'operator' => '===', 'value' => 'custom'],
                        ],
                    ],
				),
				array(
                    'label' => esc_html__( 'Hover Color', 'uipro' ),
                    'name'          => 'hover_button_color',
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .uk-button:hover' => 'color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'button_style', 'operator' => '===', 'value' => 'custom'],
                        ],
                    ],
				),
				array(
                    'label' => esc_html__( 'Hover Button Border', 'uipro' ),
                    'name'          => 'hover_button_border',
                    'type' => \Elementor\Group_Control_Border::get_type(),
                    'selector' => '{{WRAPPER}} .uk-button:hover',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'button_style', 'operator' => '===', 'value' => 'custom'],
                        ],
                    ],
				),
				array(
					'name'          => 'button_shape',
					'label' => esc_html__( 'Button Shape', 'uipro' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'rounded',
					'options' => [
						'rounded' => esc_html__('Rounded', 'uipro' ),
						'square' => esc_html__('Square', 'uipro' ),
						'circle' => esc_html__('Circle', 'uipro' ),
						'pill' => esc_html__('Pill', 'uipro' ),
					],
					'conditions' => [
						'relation' => 'and',
						'terms' => [
							['name' => 'button_style', 'operator' => '!==', 'value' => 'link'],
							['name' => 'button_style', 'operator' => '!==', 'value' => 'link-muted'],
							['name' => 'button_style', 'operator' => '!==', 'value' => 'link-text'],
							['name' => 'button_style', 'operator' => '!==', 'value' => 'text'],
						],
					],
				),
				array(
					'type'          => Controls_Manager::SELECT,
					'name'          => 'button_size',
					'label'         => esc_html__('Button Size', 'uipro'),
					'description'   => esc_html__('Set the size for multiple buttons.', 'uipro'),
					'options'       => array(
						'' => esc_html__('Default', 'uipro'),
						'small' => esc_html__('Small', 'uipro'),
						'large' => esc_html__('Large', 'uipro'),
						'full' => esc_html__('Full', 'uipro'),
					),
					'default'           => '',
				),
				array(
					'type'          =>  Controls_Manager::SELECT,
					'name'          => 'button_margin',
					'label'         => esc_html__('Button Margin', 'uipro'),
					'description'   => esc_html__('Set the vertical margin for Button.', 'uipro'),
					'options'       => array(
						''          => esc_html__('Inherit', 'uipro'),
						'default'   => esc_html__('Default', 'uipro'),
						'small'     => esc_html__('Small', 'uipro'),
						'medium'    => esc_html__('Medium', 'uipro'),
						'large'     => esc_html__('Large', 'uipro'),
						'xlarge'    => esc_html__('X-Large', 'uipro'),
						'custom'    => esc_html__('Custom', 'uipro'),
						'remove'    => esc_html__('None', 'uipro'),
					),
					'default'       => '',
				),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'button_custom_margin',
                    'label'         => esc_html__( 'Button custom margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px'],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition'     => array(
                        'button_margin'    => 'custom'
                    ),
                ),
                array(
                    'type'          =>  Controls_Manager::SELECT,
                    'name'          => 'button_position',
                    'label'         => esc_html__('Button Position', 'uipro'),
                    'options'       => array(
                        ''          => esc_html__('After Content', 'uipro'),
                        'after_media'   => esc_html__('After Media', 'uipro'),
                    ),
                    'default'       => '',
                ),
			);
            $options    = array_merge($options, $this->get_general_options());

            static::$cache[$store_id]   = $options;
		}

	}
}