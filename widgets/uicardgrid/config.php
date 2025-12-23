<?php
/**
 * UIPro Card Grid config class
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


if ( ! class_exists( 'UIPro_Config_UICardGrid' ) ) {
	/**
	 * Class UIPro_Config_UICardGrid
	 */
	class UIPro_Config_UICardGrid extends UIPro_Abstract_Config {

		/**
		 * UIPro_Config_Heading constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'uicardgrid';
			self::$name = esc_html__( 'TemPlaza: UI Card Grid', 'uipro' );
			self::$desc = esc_html__( 'Add UI Card Grid Box.', 'uipro' );
			self::$icon = 'eicon-featured-image';
			parent::__construct();

		}

        public function get_styles() {
            return array(
                'templaza-uicardgrid-style' => array(
                    'src'   =>  'style.css',
                    'ver'   =>  time(),
                )
            );
        }

		/*
		 * @return array
		 */
		public function get_options() {
		    $store_id   = md5(__METHOD__);

		    if(isset(static::$cache[$store_id])){
		        return static::$cache[$store_id];
            }
            $repeater = new \Elementor\Repeater();
            $repeater->add_control(
                'title', [
                    'label' => __( 'Title', 'uipro' ),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => '',
                    'label_block' => true,
                ]
            );
            $repeater->add_control(
                'meta_title', [
                    'label' => __( 'Meta Title', 'uipro' ),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => '',
                    'label_block' => true,
                ]
            );
            $repeater->add_control(
                'content',
                [
                    'label'         => esc_html__('Content', 'uipro'),
                    'type' => Controls_Manager::WYSIWYG,
                    'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras in semper sem. Praesent elit erat, suscipit sed varius ut, porta sit amet lorem. Duis eget vulputate turpis. Vivamus maximus ac nisl vel suscipit.', 'uipro' ),
                    'placeholder' => __( 'Type your description here', 'uipro' ),
                ]
            );
            $repeater->add_control(
                'image',
                [
                    'type'          =>  Controls_Manager::MEDIA,
                    'label'         => esc_html__('Select Image:', 'uipro'),
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                ]
            );
            $repeater->add_control(
                \Elementor\Group_Control_Image_Size::get_type(),
                [
                    'name' => 'image', // // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
                    'exclude' => [],
                    'include' => [],
                    'default' => 'large',
                ]
            );
            $repeater->add_control(
                'link',
                [
                    'label' => __( 'Link', 'uipro' ),
                    'type' => \Elementor\Controls_Manager::URL,
                    'placeholder' => __( 'https://your-link.com', 'uipro' ),
                    'show_external' => true,
                    'default' => [
                        'url' => '',
                        'is_external' => false,
                        'nofollow' => false,
                    ],
                ]
            );
            $repeater->add_control(
                'link_title', [
                    'label' => __( 'Link Title', 'uipro' ),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => '',
                    'label_block' => true,
                ]
            );


			// options
			$options = array(
                array(
                    'id'          => 'layout',
                    'label' => esc_html__( 'Layout', 'uipro' ),
                    'type' => Controls_Manager::SELECT,
                    'options'       => array(
                        'base'    => esc_html__('Default', 'uipro'),
                    ),
                    'default'   => 'base',
                ),
                array(
                    'type'      => Controls_Manager::REPEATER,
                    'name'      => 'uicardgrid',
                    'label'     => esc_html__( 'Items', 'uipro' ),
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'title' => 'Item',
                        ],
                    ],
                    'title_field' => '{{{ title }}}',
                ),
                array(
                    'id'          => 'large_desktop_columns',
                    'label' => esc_html__( 'Large Desktop Columns', 'uipro' ),
                    'type' => Controls_Manager::SELECT,
                    'options'       => array(
                        '1'    => esc_html__('1 Column', 'uipro'),
                        '2'    => esc_html__('2 Columns', 'uipro'),
                        '3'    => esc_html__('3 Columns', 'uipro'),
                        '4'    => esc_html__('4 Columns', 'uipro'),
                        '5'    => esc_html__('5 Columns', 'uipro'),
                        '6'    => esc_html__('6 Columns', 'uipro'),
                    ),
                    'default'   => '3',
                    'separator'     => 'before',
                ),
                array(
                    'id'          => 'desktop_columns',
                    'label' => esc_html__( 'Desktop Columns', 'uipro' ),
                    'type' => Controls_Manager::SELECT,
                    'options'       => array(
                        '1'    => esc_html__('1 Column', 'uipro'),
                        '2'    => esc_html__('2 Columns', 'uipro'),
                        '3'    => esc_html__('3 Columns', 'uipro'),
                        '4'    => esc_html__('4 Columns', 'uipro'),
                        '5'    => esc_html__('5 Columns', 'uipro'),
                        '6'    => esc_html__('6 Columns', 'uipro'),
                    ),
                    'default'   => '3',
                ),
                array(
                    'id'          => 'laptop_columns',
                    'label' => esc_html__( 'Laptop Columns', 'uipro' ),
                    'type' => Controls_Manager::SELECT,
                    'options'       => array(
                        '1'    => esc_html__('1 Column', 'uipro'),
                        '2'    => esc_html__('2 Columns', 'uipro'),
                        '3'    => esc_html__('3 Columns', 'uipro'),
                        '4'    => esc_html__('4 Columns', 'uipro'),
                        '5'    => esc_html__('5 Columns', 'uipro'),
                        '6'    => esc_html__('6 Columns', 'uipro'),
                    ),
                    'default'   => '3'
                ),
                array(
                    'id'          => 'tablet_columns',
                    'label' => esc_html__( 'Tablet Columns', 'uipro' ),
                    'type' => Controls_Manager::SELECT,
                    'options'       => array(
                        '1'    => esc_html__('1 Column', 'uipro'),
                        '2'    => esc_html__('2 Columns', 'uipro'),
                        '3'    => esc_html__('3 Columns', 'uipro'),
                        '4'    => esc_html__('4 Columns', 'uipro'),
                        '5'    => esc_html__('5 Columns', 'uipro'),
                        '6'    => esc_html__('6 Columns', 'uipro'),
                    ),
                    'default'   => '2'
                ),
                array(
                    'id'          => 'mobile_columns',
                    'label' => esc_html__( 'Mobile Columns', 'uipro' ),
                    'type' => Controls_Manager::SELECT,
                    'options'       => array(
                        '1'    => esc_html__('1 Column', 'uipro'),
                        '2'    => esc_html__('2 Columns', 'uipro'),
                        '3'    => esc_html__('3 Columns', 'uipro'),
                        '4'    => esc_html__('4 Columns', 'uipro'),
                        '5'    => esc_html__('5 Columns', 'uipro'),
                        '6'    => esc_html__('6 Columns', 'uipro'),
                    ),
                    'default'   => '1'
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'id'            => 'column_grid_gap',
                    'label'         => esc_html__('Column Gap', 'uipro'),
                    'description'   => esc_html__('Modified Gap Column', 'uipro'),
                    'options'       => array(
                        '' => esc_html__('Default', 'uipro'),
                        'small' => esc_html__('Small', 'uipro'),
                        'medium' => esc_html__('Medium', 'uipro'),
                        'large' => esc_html__('Large', 'uipro'),
                        'collapse' => esc_html__('Collapse', 'uipro'),
                    ),
                    'default'           => '',
                ),

				array(
					'type'          => Group_Control_Typography::get_type(),
					'name'          => 'title_typography',
					'label'         => esc_html__('Title Font', 'uipro'),
					'description'   => esc_html__('Select a font family, font size for the addon title.', 'uipro'),
					'selector'      => '{{WRAPPER}} .ui-card .uk-card-title',
                    'start_section' => 'content-options',
                    'section_name'  => esc_html__( 'Content options', 'uipro' ),
				),
				array(
					'type'          =>  Controls_Manager::COLOR,
					'name'          => 'title_color',
					'label'         => esc_html__('Title Color', 'uipro'),
					'description'   => esc_html__('Set the color of title.', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .ui-card .uk-card-title, {{WRAPPER}} .ui-card .uk-card-title a' => 'color: {{VALUE}}',
					],
				),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'title_custom_margin',
                    'label'         => esc_html__( 'Title custom margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px'],
                    'selectors'     => [
                        '{{WRAPPER}} .uk-card-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ]
                ),
                array(
                    'type'          => Group_Control_Typography::get_type(),
                    'name'          => 'meta_typography',
                    'label'         => esc_html__('Meta Font', 'uipro'),
                    'description'   => esc_html__('Select a font family.', 'uipro'),
                    'selector'      => '{{WRAPPER}} .uk-card-meta',
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'meta_color',
                    'label'         => esc_html__('Meta Color', 'uipro'),
                    'description'   => esc_html__('Set the color of meta.', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .uk-card-meta' => 'color: {{VALUE}}',
                    ],

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
                ),
				array(
					'type'          => Group_Control_Typography::get_type(),
					'name'          => 'text_typography',
					'label'         => esc_html__('Content Font', 'uipro'),
					'description'   => esc_html__('Select a font family, font size for the addon content.', 'uipro'),
					'selector'      => '{{WRAPPER}} .ui-card .ui-card-text',
				),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'content_color',
                    'label'         => esc_html__('Content Color', 'uipro'),
                    'description'   => esc_html__('Set the color of content.', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ui-card-text' => 'color: {{VALUE}}',
                    ],

                ),
				//Image Settings

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
						'bottom_all'   => __( 'After Description', 'uipro' ),
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
							['name' => 'image_appear', 'operator' => '===', 'value' => 'thumbnail'],
						],
					],
				),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'image_overlay',
                    'label'         => esc_html__('Image Overlay Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .card-overlay' => 'background-color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'layout_type', 'operator' => '===', 'value' => 'image'],
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
						'{{WRAPPER}} .ui-card .ui-media' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;',
					],
				),
				array(
					'type'          => \Elementor\Group_Control_Background::get_type(),
					'name'          => 'image_content_bg',
					'label' => __( 'Image Content Background', 'uipro' ),
					'default' => '',
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .uk-card-body',

				),
                array(
                    'type'          => Controls_Manager::SWITCHER,
                    'id'            => 'image_custom_height',
                    'label'         => esc_html__('Image Custom Height', 'uipro'),
                    'label_on'      => esc_html__( 'Yes', 'uipro' ),
                    'label_off'     => esc_html__( 'No', 'uipro' ),
                    'return_value'  => '1',
                    'default'       => '0',
                ),
                array(
                    'name'            => 'image_custom_height_option',
                    'label'         => esc_html__( 'Image Custom Height', 'uipro' ),
                    'type'          => Controls_Manager::SLIDER,
                    'responsive'    => true,
                    'range' => [
                        'px' => [
                            'min' => 1,
                            'max' => 1000
                        ],
                    ],
                    'desktop_default' => [
                        'size' => 450,
                        'unit' => 'px',
                    ],
                    'tablet_default' => [
                        'size' => 300,
                        'unit' => 'px',
                    ],
                    'mobile_default' => [
                        'size' => 220,
                        'unit' => 'px',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .ui-media' => 'height: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .ui-media img' => 'height: 100%; width:100%; object-fit:cover;',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'image_custom_height', 'operator' => '===', 'value' => '1'],
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
                        'image-title-zoomin' => __('Image and Title Transition', 'uipro'),
                    ),
                    'default'       => '',

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
						'{{WRAPPER}} .ui-card:hover, {{WRAPPER}} .ui-card:hover .ui-card-text' => 'color: {{VALUE}}',
					],
					'conditions' => [
						'terms' => [
							['name' => 'card_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				),
				array(
					'type'          =>  Controls_Manager::COLOR,
					'name'          => 'card_meta_color_hover',
					'label'         => esc_html__('Card Hover Meta Color', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .ui-card:hover .uk-card-meta' => 'color: {{VALUE}}',
					],
					'conditions' => [
						'terms' => [
							['name' => 'card_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				),
				array(
					'type'          =>  Controls_Manager::COLOR,
					'name'          => 'card_icon_color_hover',
					'label'         => esc_html__('Card Hover Icon Color', 'uipro'),
					'selectors' => [
                        '{{WRAPPER}} .ui-card:hover .ui-media' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .ui-card:hover .ui-media svg' => 'fill: {{VALUE}}',
					],
					'conditions' => [
						'terms' => [
							['name' => 'card_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				),
				array(
					'type'          =>  Controls_Manager::COLOR,
					'name'          => 'card_title_color_hover',
					'label'         => esc_html__('Card Hover Title Color', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .ui-card:hover .uk-card-title' => 'color: {{VALUE}}',
					],
					'conditions' => [
						'terms' => [
							['name' => 'card_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				),
				array(
					'type'          =>  Controls_Manager::COLOR,
					'name'          => 'card_button_color_hover',
					'label'         => esc_html__('Card Hover Button Color', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .ui-card:hover .uk-button' => 'color: {{VALUE}}',
					],
					'conditions' => [
						'terms' => [
							['name' => 'card_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				),
				array(
					'type'          =>  Controls_Manager::COLOR,
					'name'          => 'card_button_bgcolor_hover',
					'label'         => esc_html__('Card Hover Button Background Color', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .ui-card:hover .uk-button' => 'background-color: {{VALUE}}',
					],
					'conditions' => [
						'terms' => [
							['name' => 'card_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				),
				array(
					'type'          =>  Controls_Manager::COLOR,
					'name'          => 'card_button_bordercolor_hover',
					'label'         => esc_html__('Card Hover Button Border Color', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .ui-card:hover .uk-button' => 'border-color: {{VALUE}}',
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
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'card_hover_padding',
                    'label'         => esc_html__( 'Card Hover Padding', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-card:hover .uk-card-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'card_size', 'operator' => '===', 'value' => 'custom'],
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
                        '{{WRAPPER}} .ui-card, {{WRAPPER}} .uk-card-body, {{WRAPPER}} .ui-card:hover, {{WRAPPER}} .ui-card:hover .uk-card-body' => 'transition: all {{SIZE}}s linear;',
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

			);
            $options    = array_merge($options, $this->get_general_options());

            static::$cache[$store_id]   = $options;
		}

	}
}