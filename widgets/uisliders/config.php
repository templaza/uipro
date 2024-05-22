<?php
/**
 * UIPro Sliders config class
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
use Elementor\Core\Schemes\Typography;

if ( ! class_exists( 'UIPro_Config_UISliders' ) ) {
	/**
	 * Class UIPro_Config_UISliders
	 */
	class UIPro_Config_UISliders extends UIPro_Abstract_Config {

		/**
		 * UIPro_Config_Heading constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'uisliders';
			self::$name = esc_html__( 'TemPlaza: UI Sliders', 'uipro' );
			self::$desc = esc_html__( 'Create a Slider that can be displayed on your site.', 'uipro' );
			self::$icon = 'eicon-slider-album';
			parent::__construct();

		}
        public function get_styles() {
            return ['el-uisliders' => array(
                'src'   => 'style.css'
            )];
        }

		/**
		 * @return array
		 */
		public function get_options() {

            $store_id   = md5(__METHOD__);

            if(isset(static::$cache[$store_id])){
                return static::$cache[$store_id];
            }

			$repeater = new \Elementor\Repeater();
			$repeater->add_control(
				'media_type',
				[
					'label' => esc_html__( 'Media Type', 'uipro' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => '',
					'options' => [
						''  => esc_html__( 'Image', 'uipro' ),
						'video' => esc_html__( 'Video', 'uipro' ),
					],
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
					'conditions' => [
						'terms' => [
							['name' => 'media_type', 'operator' => '===', 'value' => ''],
						],
					],
				]
			);
			$repeater->add_group_control(
				\Elementor\Group_Control_Image_Size::get_type(),
				[
					'name' => 'image', // // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
					'exclude' => [ 'custom' ],
					'include' => [],
					'default' => 'full',
					'conditions' => [
						'terms' => [
							['name' => 'media_type', 'operator' => '===', 'value' => ''],
						],
					],
				]
			);

			$repeater->add_control(
				'video',
				[
					'label' => esc_html__( 'video', 'uipro' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => __( '' , 'uipro' ),
					'dynamic'       => [
						'active'    => true,
					],
					'label_block' => true,
					'conditions' => [
						'terms' => [
							['name' => 'media_type', 'operator' => '===', 'value' => 'video'],
						],
					],
				]
			);

			$repeater->add_control(
				'video_fallback',
				[
					'type'          =>  Controls_Manager::MEDIA,
					'label'         => esc_html__('Background Fallback', 'uipro'),
					'default' => [
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					],
					'conditions' => [
						'terms' => [
							['name' => 'media_type', 'operator' => '===', 'value' => 'video'],
						],
					],
				]
			);

			$repeater->add_control(
				'image_panel',
				[
					'label' => __( 'Blend Mode Settings', 'uipro' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'Show', 'uipro' ),
					'label_off' => __( 'Hide', 'uipro' ),
					'return_value' => '1',
					'default' => '0',
				]
			);

			$repeater->add_group_control(
				\Elementor\Group_Control_Background::get_type(),
				[
					'name' => 'background',
					'label' => esc_html__( 'Background', 'uipro' ),
					'types' => [ 'classic', 'gradient' ],
					'selector' => '{{WRAPPER}} .ui-background-cover{{CURRENT_ITEM}}',
					'conditions' => [
						'terms' => [
							['name' => 'image_panel', 'operator' => '===', 'value' => '1'],
						],
					],
				]
			);

			$repeater->add_control(
				'title', [
					'label' => esc_html__( 'Title', 'uipro' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => __( '' , 'uipro' ),
					'label_block' => true,
					'separator'     => 'before',
				]
			);
			$repeater->add_control(
				'meta', [
					'label' => esc_html__( 'Meta', 'uipro' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => __( '' , 'uipro' ),
					'label_block' => true,
				]
			);
			$repeater->add_control(
				'content', [
					'label'         => esc_html__('Content', 'uipro'),
					'type' => Controls_Manager::WYSIWYG,
					'default' => esc_html__( 'Default description', 'uipro' ),
					'placeholder' => esc_html__( 'Type your description here', 'uipro' ),
					/* vc */
					'admin_label'   => true,
				]
			);
			$repeater->add_control(
				'thumbnail',
				[
					'type'          =>  Controls_Manager::MEDIA,
					'label'         => esc_html__('Select Thumbnail:', 'uipro'),
				]
			);
			$repeater->add_group_control(
				\Elementor\Group_Control_Image_Size::get_type(),
				[
					'name' => 'thumbnail', // // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
					'exclude' => [ 'custom' ],
					'include' => [],
					'default' => 'full',
				]
			);
			$repeater->add_control(
				'color_mode',
				[
					'label' => esc_html__( 'Text Color Mode', 'uipro' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => '',
					'options' => [
						''  => esc_html__( 'None', 'uipro' ),
						'light' => esc_html__( 'Light', 'uipro' ),
						'dark' => esc_html__( 'Dark', 'uipro' ),
					],
				]
			);
			$repeater->add_control(
				'link',
				[
					'label' => esc_html__( 'Link', 'uipro' ),
					'type' => Controls_Manager::URL,
					'placeholder' => esc_html__( 'https://your-link.com', 'uipro' ),
					'show_external' => true,
					'default' => [
						'url' => '',
						'is_external' => false,
						'nofollow' => false,
					],
				]
			);
			$repeater->add_control(
				'button_title', [
					'label' => esc_html__( 'Button Title', 'uipro' ),
					'type' => Controls_Manager::TEXT,
					'default' => '',
					'label_block' => true,
				]
			);
			$repeater->add_control(
				'button_style',
				[
					'label' => esc_html__( 'Button Style', 'uipro' ),
					'type' => Controls_Manager::SELECT,
					'default' => '',
					'options' => [
						'' => esc_html__( 'Default', 'uipro' ),
						'primary' => esc_html__( 'Primary', 'uipro' ) ,
						'secondary' => esc_html__( 'Secondary', 'uipro' ),
						'danger' => esc_html__( 'Danger', 'uipro' ),
						'text' => esc_html__( 'Text', 'uipro' ),
						'link' => esc_html__( 'Link', 'uipro' ),
						'link-muted' => esc_html__( 'Link Muted', 'uipro' ),
						'link-text' => esc_html__( 'Link Text', 'uipro' ),
						'custom' => esc_html__( 'Custom', 'uipro' ),
					],
					'conditions' => [
						'terms' => [
							['name' => 'button_title', 'operator' => '!==', 'value' => ''],
						],
					],
				]
			);
			$repeater->add_control(
				'button_shape',
				[
					'label' => esc_html__( 'Button Shape', 'uipro' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'rounded',
					'options' => [
						'rounded' => esc_html__( 'Rounded', 'uipro' ),
						'square' => esc_html__( 'Squared', 'uipro' ),
						'circle' => esc_html__( 'Circle', 'uipro' ),
						'pill' => esc_html__( 'Pill', 'uipro' ),
					],
					'conditions' => [
						'relation' => 'and',
						'terms' => [
							['name' => 'button_title', 'operator' => '!==', 'value' => ''],
							['name' => 'button_style', 'operator' => '!==', 'value' => 'link'],
							['name' => 'button_style', 'operator' => '!==', 'value' => 'link-muted'],
							['name' => 'button_style', 'operator' => '!==', 'value' => 'link-text'],
							['name' => 'button_style', 'operator' => '!==', 'value' => 'text'],
						],
					],
				]
			);
			$repeater->add_control(
				'button_background_color',
				[
					'label' => esc_html__( 'Button Background Color', 'uipro' ),
					'type' => Controls_Manager::COLOR,
					'separator'     => 'before',
					'selectors' => [
						'{{WRAPPER}} .ui-buttons {{CURRENT_ITEM}} > a' => 'background-color: {{VALUE}}',
					],
					'conditions' => [
						'terms' => [
							['name' => 'button_title', 'operator' => '!==', 'value' => ''],
							['name' => 'button_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				]
			);
			$repeater->add_control(
				'button_color',
				[
					'label' => esc_html__( 'Button Color', 'uipro' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ui-buttons {{CURRENT_ITEM}} > a' => 'color: {{VALUE}}',
					],
					'conditions' => [
						'terms' => [
							['name' => 'button_title', 'operator' => '!==', 'value' => ''],
							['name' => 'button_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				]
			);
			$repeater->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'button_border',
					'label' => esc_html__( 'Button Border', 'uipro' ),
					'selector' => '{{WRAPPER}} .ui-buttons {{CURRENT_ITEM}} > a',
					'conditions' => [
						'terms' => [
							['name' => 'button_title', 'operator' => '!==', 'value' => ''],
							['name' => 'button_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				]
			);
			$repeater->add_control(
				'button_hover_background_color',
				[
					'label' => esc_html__( 'Button Hover Background Color', 'uipro' ),
					'type' => Controls_Manager::COLOR,
					'separator'     => 'before',
					'selectors' => [
						'{{WRAPPER}} .ui-buttons {{CURRENT_ITEM}} > a:hover' => 'background-color: {{VALUE}}',
					],
					'conditions' => [
						'terms' => [
							['name' => 'button_title', 'operator' => '!==', 'value' => ''],
							['name' => 'button_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				]
			);
			$repeater->add_control(
				'button_hover_color',
				[
					'label' => esc_html__( 'Button Hover Color', 'uipro' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ui-buttons {{CURRENT_ITEM}} > a:hover' => 'color: {{VALUE}}',
					],
					'conditions' => [
						'terms' => [
							['name' => 'button_title', 'operator' => '!==', 'value' => ''],
							['name' => 'button_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				]
			);
			$repeater->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'button_hover_border',
					'label' => esc_html__( 'Button Hover Border', 'uipro' ),
					'selector' => '{{WRAPPER}} .ui-buttons {{CURRENT_ITEM}} > a:hover',
					'conditions' => [
						'terms' => [
							['name' => 'button_title', 'operator' => '!==', 'value' => ''],
							['name' => 'button_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
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
					'id'        => 'uisliders_items',
					'label'     => esc_html__( 'Slider Items', 'uipro' ),
					'fields'    => $repeater->get_controls(),
					'default' => [
						[
							'title' => 'Slider Item',
						],
					],
					'title_field' => esc_html__( 'Slider Item', 'uipro' ),
				),
				array(
					'id' => 'height',
					'type' => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Height', 'uipro' ),
					'description' => esc_html__( 'The slideshow always takes up fullwidth, and  the height will adapt automatically based on the defined ratio. Alternatively, the height can adapt to the height of the viewport.<br/> Note: Make sure, no height is set in the section settings when using one of the viewport options.', 'uipro' ),
					'options'         => array(
						'' => esc_html__( 'Auto', 'uipro' ),
						'full' => esc_html__( 'Viewport', 'uipro' ),
						'percent' => esc_html__( 'Viewport (Minus 20%)', 'uipro' ),
						'section' => esc_html__( 'Viewport (Minus the following section)', 'uipro' ),
					),
					'default' => '',
					'start_section' => 'slider_settings',
					'section_name'      => esc_html__('Slider Settings', 'uipro')
				),
                array(
                    'id' => 'ratio',
                    'type'          => Controls_Manager::TEXT,
                    'label'     => esc_html__( 'Ratio', 'uipro' ),
                    'description' => esc_html__( 'Set a ratio. It\'s recommended to use the same ratio of the background image. Just use its width and height, like 1600:900', 'uipro' ),
                    'default' => '',
                    'placeholder' => '16:9',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'height', 'operator' => '===', 'value' => ''],
                        ],
                    ],
                ),
                array(
                    'name' => 'min_height',
                    'type'          => Controls_Manager::SLIDER,
                    'label'     => esc_html__( 'Min Height', 'uipro' ),
                    'description' => esc_html__( 'Use an optional minimum height to prevent the slideshow from becoming smaller than its content on small devices.', 'uipro' ),
                    'size_units' => [ 'px' ],
                    'range' => [
                        'px' => [
                            'min' => 200,
                            'max' => 800,
                            'step'=> 1,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 300,
                    ],
                ),
                array(
                    'name' => 'max_height',
                    'type'          => Controls_Manager::SLIDER,
                    'label'     => esc_html__( 'Max Height', 'uipro' ),
                    'size_units' => [ 'px' ],
                    'range' => [
                        'px' => [
                            'min' => 500,
                            'max' => 1600,
                            'step'=> 1,
                        ],
                    ],
                    'description' => esc_html__( 'Set the maximum height', 'uipro' ),
                    'conditions' => [
                        'terms' => [
                            ['name' => 'height', 'operator' => '===', 'value' => ''],
                        ],
                    ],
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
                    'id' => 'slider_set',
                    'type' => Controls_Manager::SWITCHER,
                    'label'     => esc_html__( 'Slide Sets', 'uipro' ),
                    'description' => esc_html__( 'To loop through a set of slides instead of single items', 'uipro' ),
                    'label_on' => esc_html__( 'Yes', 'uipro' ),
                    'label_off' => esc_html__( 'No', 'uipro' ),
                    'return_value' => '1',
                    'default' => '0',
                ),
                array(
                    'id' => 'slider_center',
                    'type' => Controls_Manager::SWITCHER,
                    'label'     => esc_html__( 'Center', 'uipro' ),
                    'description' => esc_html__( 'By default, items of the slider always are aligned to the left. To center the list items', 'uipro' ),
                    'label_on' => esc_html__( 'Yes', 'uipro' ),
                    'label_off' => esc_html__( 'No', 'uipro' ),
                    'return_value' => '1',
                    'default' => '0',
                ),

                array(
                    'type'          => Controls_Manager::SWITCHER,
                    'id'            => 'cover_image',
                    'label'         => esc_html__('Cover Image', 'uipro'),
                    'description'   => esc_html__( 'Whether to display image cover.', 'uipro' ),
                    'label_on'      => esc_html__( 'Yes', 'uipro' ),
                    'label_off'     => esc_html__( 'No', 'uipro' ),
                    'return_value'  => '1',
                    'default'       => '0',
                    'start_section' => 'image_settings',
                    'section_name'      => esc_html__('Image Settings', 'uipro')
                ),
                array(
                    'name'            => 'image_cover_height',
                    'label'         => esc_html__( 'Image Cover Height', 'uipro' ),
                    'type'          => Controls_Manager::SLIDER,
                    'responsive'    => true,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 1,
                            'max' => 1500
                        ],
                        '%' => [
                            'min' => 1,
                            'max' => 100
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .uk-slider-items .tz-image-cover' => 'height: {{SIZE}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'cover_image', 'operator' => '===', 'value' => '1'],
                        ],
                    ],
                ),
                array(
                    'name' => 'image_overlay_background',
                    'type' => Controls_Manager::COLOR,
                    'label'     => esc_html__( 'Image Overlay Color', 'uipro' ),
                    'selectors' => [
                        '{{WRAPPER}} .uk-overlay-default' => 'background-color: {{VALUE}}',
                    ],
                ),
                array(
                    'name' => 'image_hover_overlay_background',
                    'type' => Controls_Manager::COLOR,
                    'label'     => esc_html__( 'Image Hover Overlay Color', 'uipro' ),
                    'selectors' => [
                        '{{WRAPPER}} .el-item:hover .uk-overlay-default' => 'background-color: {{VALUE}}',
                    ],
                ),
                array(
                    'name' => 'image_overlay_transition',
                    'type'          => Controls_Manager::SLIDER,
                    'label'     => esc_html__( 'Overlay Transition', 'uipro' ),
                    'size_units'    => ['s'],
                    'range' => [
                        's' => [
                            'min' => 0,
                            'max' => 10,
                            'step' => 0.1,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .el-item:hover .uk-overlay-default, {{WRAPPER}} .uk-overlay-default' => 'transition: all {{SIZE}}s linear',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'image_border_radius',
                    'label'         => esc_html__( 'Image border radius', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .el-item-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'id'            => 'image_transition',
                    'label'         => esc_html__( 'Transition', 'uipro' ),
                    'description'   => esc_html__( 'Select the image\'s transition style.', 'uipro' ),
                    'options'       => array(
                        '' => __('None', 'uipro'),
                        'scale-up' => __('Scales Up', 'uipro'),
                        'scale-down' => __('Scales Down', 'uipro'),
                        'ripple' => __('Ripple', 'uipro'),
                    ),
                    'default'       => '',

                ),
                array(
                    'id'            => 'ripple_width',
                    'label'         => __( 'Ripple Width', 'uipro' ),
                    'type'          => Controls_Manager::SLIDER,
                    'responsive'    =>  true,
                    'size_units'    => [ 'px','%' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 2000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 200,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 200,
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'image_transition', 'operator' => '===', 'value' => 'ripple'],
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .templaza-ripple-circles' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                ),
                array(
                    'id'            => 'ripple_height',
                    'label'         => __( 'Ripple Height', 'uipro' ),
                    'type'          => Controls_Manager::SLIDER,
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 2000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 200,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 200,
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'image_transition', 'operator' => '===', 'value' => 'ripple'],
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .templaza-ripple-circles' => 'height: {{SIZE}}{{UNIT}};',
                    ],
                ),
                array(
                    'label' => esc_html__( 'Ripple background color', 'uipro' ),
                    'name'  => 'ripple_bg',
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .templaza-ripple-circles > div' => 'background-color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'image_transition', 'operator' => '===', 'value' => 'ripple'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'id'            => 'image_open',
                    'label'         => esc_html__( 'Open Image', 'uipro' ),
                    'options'       => array(
                        '' => __('None', 'uipro'),
                        'light_box' => __('Light box', 'uipro'),
                    ),
                    'default'       => '',

                ),
				array(
					'name' => 'velocity',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Velocity', 'uipro' ),
					'description' => esc_html__( 'Set the velocity in pixels per milliseconds.', 'uipro' ),
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 20,
							'max' => 300,
							'step'=> 1,
						],
					],
                    'start_section' => 'separator_animations_options',
                    'section_name'      => esc_html__('Animation Settings', 'uipro')
				),
				array(
					'id' => 'autoplay',
					'type' => Controls_Manager::SWITCHER,
					'label'     => esc_html__( 'Autoplay', 'uipro' ),
					'label_on' => esc_html__( 'Yes', 'uipro' ),
					'label_off' => esc_html__( 'No', 'uipro' ),
					'return_value' => '1',
					'default' => '0',

				),
				array(
					'id' => 'pause',
					'type' => Controls_Manager::SWITCHER,
					'label'     => esc_html__( 'Pause autoplay on hover', 'uipro' ),
					'label_on' => esc_html__( 'Yes', 'uipro' ),
					'label_off' => esc_html__( 'No', 'uipro' ),
					'return_value' => '1',
					'default' => 1,
					'conditions' => [
						'terms' => [
							['name' => 'autoplay', 'operator' => '===', 'value' => '1'],
						],
					],
				),
				array(
					'name' => 'autoplay_interval',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Interval', 'uipro' ),
					'description' => esc_html__( 'Set the autoplay interval in seconds.', 'uipro' ),
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 5,
							'max' => 15,
							'step'=> 1,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 7,
					],
					'conditions' => [
						'terms' => [
							['name' => 'autoplay', 'operator' => '===', 'value' => '1'],
						],
					],
				),
				array(
					'id' => 'kenburns_transition',
					'type' => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Ken Burns Effect', 'uipro' ),
					'description' => esc_html__( 'Select the transformation origin for the Ken Burns animation', 'uipro' ),
					'options'         => array(
						'' => esc_html__( 'None', 'uipro' ),
						'top-left' => esc_html__( 'Top Left', 'uipro' ),
						'top-center' => esc_html__( 'Top Center', 'uipro' ),
						'top-right' => esc_html__( 'Top Right', 'uipro' ),
						'center-left' => esc_html__( 'Center Left', 'uipro' ),
						'center-center' => esc_html__( 'Center Center', 'uipro' ),
						'center-right' => esc_html__( 'Center Right', 'uipro' ),
						'bottom-left' => esc_html__( 'Bottom Left', 'uipro' ),
						'bottom-center' => esc_html__( 'Bottom Center', 'uipro' ),
						'bottom-right' => esc_html__( 'Bottom Right', 'uipro' ),
					),
					'default' => '',
				),
				array(
					'name' => 'kenburns_duration',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Duration', 'uipro' ),
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 30,
							'step'=> 1,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 15,
					],
					'description' => esc_html__( 'Set the duration for the Ken Burns effect in seconds.', 'uipro' ),
					'conditions' => [
						'terms' => [
							['name' => 'kenburns_transition', 'operator' => '!==', 'value' => ''],
						],
					],
				),
                array(
                    'id' => 'navigation_dot_group',
                    'type' => Controls_Manager::SWITCHER,
                    'label'     => esc_html__( 'Dots & Nav in one box', 'uipro' ),
                    'label_on' => esc_html__( 'Yes', 'uipro' ),
                    'label_off' => esc_html__( 'No', 'uipro' ),
                    'return_value' => '1',
                    'default' => 0,
                    'start_section' => 'separator_navigation_group_options',
                    'section_name'      => esc_html__('Nav & Dots Group Settings', 'uipro')
                ),
                array(
                    'id' => 'navigation_dot_group_position',
                    'type' => Controls_Manager::SELECT,
                    'label'     => esc_html__( 'Box Position', 'uipro' ),
                    'options'         => array(
                        '' => esc_html__( 'Inherit', 'uipro' ),
                        'relative' => esc_html__( 'Relative', 'uipro' ),
                        'absolute' => esc_html__( 'Absolute', 'uipro' ),
                    ),
                    'selectors' => [
                        '{{WRAPPER}} .ui-navigation-group' => 'position: {{VALUE}}',
                    ],
                    'condition'     => array(
                        'navigation_dot_group'    => '1'
                    ),
                    'default' => 'relative',
                ),
                array(
                    'type'          => Controls_Manager::CHOOSE,
                    'id'            => 'navigation_dot_group_position_x',
                    'label'         => esc_html__( 'Box Horizontal Orientation', 'uipro' ),
                    'options' => [
                        'left' => [
                            'title' => esc_html__( 'Left', 'uipro' ),
                            'icon' => 'eicon-h-align-left',
                        ],
                        'right' => [
                            'title' => esc_html__( 'Right', 'uipro' ),
                            'icon' => 'eicon-h-align-right',
                        ],
                    ],
                    'default'       => 'left',
                    'condition'     => array(
                        'navigation_dot_group_position'    => 'absolute'
                    ),
                ),
                array(
                    'name'          => 'navigation_dot_group_offsetx',
                    'label' => esc_html__( 'Offset', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'responsive'    =>  true,
                    'range' => [
                        'px' => [
                            'min' => -2000,
                            'max' => 2000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => -200,
                            'max' => 200,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'size' => 0,
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'navigation_dot_group_position', 'operator' => '===', 'value' => 'absolute'],
                            ['name' => 'navigation_dot_group_position_x', 'operator' => '===', 'value' => 'left'],
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .ui-navigation-group' => 'left: {{SIZE}}{{UNIT}};',
                    ],
                ),
                array(
                    'name'          => 'navigation_dot_group_offsetx_right',
                    'label' => esc_html__( 'Offset', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'responsive'    =>  true,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => -2000,
                            'max' => 2000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => -200,
                            'max' => 200,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'size' => 0,
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'navigation_dot_group_position', 'operator' => '===', 'value' => 'absolute'],
                            ['name' => 'navigation_dot_group_position_x', 'operator' => '===', 'value' => 'right'],
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .ui-navigation-group' => 'right: {{SIZE}}{{UNIT}}; left: auto;',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::CHOOSE,
                    'id'            => 'navigation_dot_group_position_y',
                    'label'         => esc_html__( 'Box Vertical Orientation', 'uipro' ),
                    'options' => [
                        'top' => [
                            'title' => esc_html__( 'Top', 'uipro' ),
                            'icon' => 'eicon-v-align-top',
                        ],
                        'bottom' => [
                            'title' => esc_html__( 'Bottom', 'uipro' ),
                            'icon' => 'eicon-v-align-bottom',
                        ],
                    ],
                    'default'       => 'bottom',
                    'condition'     => array(
                        'navigation_dot_group_position'    => 'absolute'
                    ),
                ),
                array(
                    'name'          => 'navigation_dot_group_offsety',
                    'label' => esc_html__( 'Offset', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'responsive'    =>  true,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => -2000,
                            'max' => 2000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => -200,
                            'max' => 200,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'size' => 0,
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'navigation_dot_group_position', 'operator' => '===', 'value' => 'absolute'],
                            ['name' => 'navigation_dot_group_position_y', 'operator' => '===', 'value' => 'top'],
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .ui-navigation-group' => 'top: {{SIZE}}{{UNIT}};',
                    ],
                ),
                array(
                    'name'          => 'navigation_dot_group_offsety_bottom',
                    'label' => esc_html__( 'Offset', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'responsive'    =>  true,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => -2000,
                            'max' => 2000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => -200,
                            'max' => 200,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'size' => 0,
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'navigation_dot_group_position', 'operator' => '===', 'value' => 'absolute'],
                            ['name' => 'navigation_dot_group_position_y', 'operator' => '===', 'value' => 'bottom'],
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .ui-navigation-group' => 'bottom: {{SIZE}}{{UNIT}}; top:auto;',
                    ],
                ),
                array(
                    'name'            => 'navigation_dot_group_width',
                    'label'         => esc_html__( 'Box Width', 'uipro' ),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'responsive'    => true,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 2000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => '%',
                        'size' => 100,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .ui-navigation-group' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                    'condition'     => array(
                        'navigation_dot_group'    => '1'
                    ),
                ),
                array(
                    'name' => 'navigation_dot_group_background',
                    'type' => Controls_Manager::COLOR,
                    'label'     => esc_html__( 'Box Background Color', 'uipro' ),
                    'selectors' => [
                        '{{WRAPPER}} .ui-navigation-group' => 'background-color: {{VALUE}}',
                    ],
                    'condition'     => array(
                        'navigation_dot_group'    => '1'
                    ),
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'navigation_dot_group_margin',
                    'label'         => esc_html__( 'Box Margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-navigation-group' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition'     => array(
                        'navigation_dot_group'    => '1'
                    ),
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'navigation_dot_group_padding',
                    'label'         => esc_html__( 'Box Padding', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-navigation-group' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition'     => array(
                        'navigation_dot_group'    => '1'
                    ),
                ),
				array(
					'id' => 'navigation',
					'type' => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Display', 'uipro' ),
					'description' => esc_html__( 'Select the navigation type.', 'uipro' ),
					'options'         => array(
						'' => esc_html__( 'None', 'uipro' ),
						'dotnav' => esc_html__( 'Dotnav', 'uipro' ),
						'thumbnav' => esc_html__( 'Thumbnav', 'uipro' ),
						'title' => esc_html__( 'Title', 'uipro' )
					),
					'default' => 'dotnav',
					'start_section' => 'separator_navigation_options',
					'section_name'      => esc_html__('Navigation Settings', 'uipro')
				),
                array(
                    'id' => 'navigation_below',
                    'type' => Controls_Manager::SWITCHER,
                    'label'     => esc_html__( 'Show below slideshow', 'uipro' ),
                    'label_on' => esc_html__( 'Yes', 'uipro' ),
                    'label_off' => esc_html__( 'No', 'uipro' ),
                    'return_value' => '1',
                    'default' => 0,
                    'conditions' => [
                        'terms' => [
                            ['name' => 'navigation', 'operator' => '!==', 'value' => ''],
                            ['name' => 'navigation', 'operator' => '!==', 'value' => 'title'],
                        ],
                    ],
                ),
				array(
					'id' => 'navigation_vertical',
					'type' => Controls_Manager::SWITCHER,
					'label'     => esc_html__( 'Vertical navigation', 'uipro' ),
					'label_on' => esc_html__( 'Yes', 'uipro' ),
					'label_off' => esc_html__( 'No', 'uipro' ),
					'return_value' => '1',
					'default' => 0,
					'conditions' => [
						'terms' => [
							['name' => 'navigation_below', 'operator' => '!==', 'value' => '1'],
							['name' => 'navigation', 'operator' => '!==', 'value' => ''],
							['name' => 'navigation', 'operator' => '!==', 'value' => 'title'],
						],
					],
				),
				array(
					'id' => 'navigation_below_position',
					'type' => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Position', 'uipro' ),
					'description' => esc_html__( 'Select the position of the navigation.', 'uipro' ),
					'options'         => array(
						'left' => esc_html__( 'Left', 'uipro' ),
						'center' => esc_html__( 'Center', 'uipro' ),
						'right' => esc_html__( 'Right', 'uipro' ),
					),
					'default' => 'center',
					'conditions' => [
						'terms' => [
							['name' => 'navigation_below', 'operator' => '!==', 'value' => '1'],
							['name' => 'navigation', 'operator' => '!==', 'value' => ''],
							['name' => 'navigation', 'operator' => '!==', 'value' => 'title'],
						],
					],
				),
				array(
					'id' => 'navigation_position',
					'type' => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Position', 'uipro' ),
					'description' => esc_html__( 'Select the position of the navigation.', 'uipro' ),
					'options'         => array(
						'top-left' => esc_html__( 'Top Left', 'uipro' ),
						'top-right' => esc_html__( 'Top Right', 'uipro' ),
						'center-left' => esc_html__( 'Center Left', 'uipro' ),
						'center-right' => esc_html__( 'Center Right', 'uipro' ),
						'bottom-left' => esc_html__( 'Bottom Left', 'uipro' ),
						'bottom-center' => esc_html__( 'Bottom Center', 'uipro' ),
						'bottom-right' => esc_html__( 'Bottom Right', 'uipro' ),
					),
					'default' => 'bottom-center',
					'conditions' => [
						'terms' => [
							['name' => 'navigation_below', 'operator' => '!==', 'value' => '1'],
							['name' => 'navigation', 'operator' => '!==', 'value' => ''],
							['name' => 'navigation', 'operator' => '!==', 'value' => 'title'],
						],
					],
				),
				array(
					'id' => 'navigation_title_selector',
					'type' => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Navigation Title HTML Element', 'uipro' ),
					'description' => esc_html__( 'Choose one of the HTML elements to fit your semantic structure.', 'uipro' ),
					'options'         => array(
						'h1' => esc_html__( 'h1', 'uipro' ),
						'h2' => esc_html__( 'h2', 'uipro' ),
						'h3' => esc_html__( 'h3', 'uipro' ),
						'h4' => esc_html__( 'h4', 'uipro' ),
						'h5' => esc_html__( 'h5', 'uipro' ),
						'h6' => esc_html__( 'h6', 'uipro' ),
						'div' => esc_html__( 'div', 'uipro' ),
					),
					'default' => 'h5',
					'conditions' => [
						'terms' => [
							['name' => 'navigation', 'operator' => '===', 'value' => 'title'],
						],
					],
				),
				array(
					'id' => 'navigation_below_margin',
					'type' => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Margin', 'uipro' ),
					'options'         => array(
						'small-top' => esc_html__( 'Small', 'uipro' ),
						'top' => esc_html__( 'Default', 'uipro' ),
						'medium-top' => esc_html__( 'Medium', 'uipro' ),
					),
					'default' => 'top',
					'conditions' => [
						'terms' => [
							['name' => 'navigation_below', 'operator' => '===', 'value' => '1'],
							['name' => 'navigation', 'operator' => '!==', 'value' => ''],
							['name' => 'navigation', 'operator' => '!==', 'value' => 'title'],
						],
					],
				),
				array(
					'id' => 'navigation_margin',
					'type' => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Margin', 'uipro' ),
					'options'         => array(
						'' => esc_html__( 'None', 'uipro' ),
						'small' => esc_html__( 'Small', 'uipro' ),
						'medium' => esc_html__( 'Medium', 'uipro' ),
						'large' => esc_html__( 'Large', 'uipro' ),
					),
					'default' => 'medium',
					'conditions' => [
						'terms' => [
							['name' => 'navigation_below', 'operator' => '!==', 'value' => '1'],
							['name' => 'navigation', 'operator' => '!==', 'value' => ''],
						],
					],
				),
				array(
					'id' => 'navigation_breakpoint',
					'type' => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Breakpoint', 'uipro' ),
					'description' => esc_html__( 'Display the navigation only on this device width and larger', 'uipro' ),
					'options'         => array(
						'' => esc_html__( 'Always', 'uipro' ),
						's' => esc_html__( 'Small (Phone Landscape)', 'uipro' ),
						'm' => esc_html__( 'Medium (Tablet Landscape)', 'uipro' ),
						'l' => esc_html__( 'Large (Desktop)', 'uipro' ),
						'xl' => esc_html__( 'X-Large (Large Screens)', 'uipro' ),
					),
					'default' => 's',
					'conditions' => [
						'terms' => [
							['name' => 'navigation', 'operator' => '!==', 'value' => ''],
						],
					],
				),
				array(
					'id' => 'navigation_color',
					'type' => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Color', 'uipro' ),
					'description' => esc_html__( 'Set light or dark color if the navigation is below the slideshow.', 'uipro' ),
					'options'         => array(
						'light' => esc_html__( 'Light', 'uipro' ),
						'' => esc_html__( 'None', 'uipro' ),
						'dark' => esc_html__( 'Dark', 'uipro' ),
					),
					'default' => '',
					'conditions' => [
						'terms' => [
							['name' => 'navigation_below', 'operator' => '!==', 'value' => '1'],
							['name' => 'navigation', 'operator' => '!==', 'value' => ''],
						],
					],
				),
				array(
					'id' => 'thumbnav_wrap',
					'type' => Controls_Manager::SWITCHER,
					'label'     => esc_html__( 'Thumbnav Wrap', 'uipro' ),
					'description' => esc_html__( 'Don\'t wrap into multiple lines. Define whether thumbnails wrap into multiple lines or not if the container is too small.', 'uipro' ),
					'label_on' => esc_html__( 'Yes', 'uipro' ),
					'label_off' => esc_html__( 'No', 'uipro' ),
					'return_value' => '1',
					'default' => 0,
					'conditions' => [
						'terms' => [
							['name' => 'navigation', 'operator' => '===', 'value' => 'thumbnav'],
						],
					],
				),
				array(
					'name' => 'thumbnail_width',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Thumbnail Width', 'uipro' ),
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 400,
						],
					],
					'description' => esc_html__( 'Settings just one value preserves the original proportions. The image will be resized and croped automatically, and where possible, high resolution images will be auto-generated.', 'uipro' ),
					'default' => [
						'size' => 100,
						'unit' => 'px',
					],
					'conditions' => [
						'terms' => [
							['name' => 'navigation', 'operator' => '===', 'value' => 'thumbnav'],
						],
					],
				),

				array(
					'name' => 'thumbnail_height',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Thumbnail Height', 'uipro' ),
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 400,
						],
					],
					'description' => esc_html__( 'Settings just one value preserves the original proportions. The image will be resized and croped automatically, and where possible, high resolution images will be auto-generated.', 'uipro' ),
					'default' => [
						'size' => 75,
						'unit' => 'px',
					],
					'conditions' => [
						'terms' => [
							['name' => 'navigation', 'operator' => '===', 'value' => 'thumbnav'],
						],
					],
				),
				array(
					'id' => 'image_svg_inline',
					'type' => Controls_Manager::SWITCHER,
					'label'     => esc_html__( 'Make SVG stylable with CSS', 'uipro' ),
					'description' => esc_html__( 'Inject SVG images into the page markup, so that they can easily be styled with CSS.', 'uipro' ),
					'label_on' => esc_html__( 'Yes', 'uipro' ),
					'label_off' => esc_html__( 'No', 'uipro' ),
					'return_value' => '1',
					'default' => 0,
					'conditions' => [
						'terms' => [
							['name' => 'navigation', 'operator' => '===', 'value' => 'thumbnav'],
						],
					],
				),
				array(
					'id' => 'image_svg_color',
					'type' => Controls_Manager::SELECT,
					'label'     => esc_html__( 'SVG Color', 'uipro' ),
					'description' => esc_html__( 'Select the SVG color. It will only apply to supported elements defined in the SVG.', 'uipro' ),
					'options'         => array(
						'' => esc_html__( 'None', 'uipro' ),
						'muted' => esc_html__( 'Muted', 'uipro' ),
						'emphasis' => esc_html__( 'Emphasis', 'uipro' ),
						'primary' => esc_html__( 'Primary', 'uipro' ),
						'secondary' => esc_html__( 'Secondary', 'uipro' ),
						'success' => esc_html__( 'Success', 'uipro' ),
						'warning' => esc_html__( 'Warning', 'uipro' ),
						'danger' => esc_html__( 'Danger', 'uipro' ),
					),
					'default' => '',
					'conditions' => [
						'terms' => [
							['name' => 'navigation', 'operator' => '===', 'value' => 'thumbnav'],
							['name' => 'image_svg_inline', 'operator' => '===', 'value' => '1'],
						],
					],
				),
				array(
					'id' => 'slidenav_position',
					'type' => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Position', 'uipro' ),
					'description' => esc_html__( 'Select the position of the slidenav.', 'uipro' ),
					'options'         => array(
						'' => esc_html__( 'None', 'uipro' ),
						'default' => esc_html__( 'Default', 'uipro' ),
						'outside' => esc_html__( 'Outside', 'uipro' ),
						'top-left' => esc_html__( 'Top Left', 'uipro' ),
						'top-right' => esc_html__( 'Top Right', 'uipro' ),
						'center-left' => esc_html__( 'Center Left', 'uipro' ),
						'center-right' => esc_html__( 'Center Right', 'uipro' ),
						'bottom-left' => esc_html__( 'Bottom Left', 'uipro' ),
						'bottom-center' => esc_html__( 'Bottom Center', 'uipro' ),
						'bottom-right' => esc_html__( 'Bottom Right', 'uipro' ),
					),
					'default' => 'default',
					'start_section' => 'separator_slidenav_options',
					'section_name'      => esc_html__('SlideNav Settings', 'uipro')
				),
				array(
					'id' => 'slidenav_on_hover',
					'type' => Controls_Manager::SWITCHER,
					'label'     => esc_html__( 'Show on hover only', 'uipro' ),
					'label_on' => esc_html__( 'Yes', 'uipro' ),
					'label_off' => esc_html__( 'No', 'uipro' ),
					'return_value' => '1',
					'default' => 0,
					'conditions' => [
						'terms' => [
							['name' => 'slidenav_position', 'operator' => '!==', 'value' => ''],
						],
					],
				),
                array(
                    'name' => 'slidenav_color',
                    'type'=>Controls_Manager::COLOR,
                    'label'=>__( 'Color', 'uipro' ),
                    'selectors' => [
                        '{{WRAPPER}} .ui-slidenav' => 'color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'slidenav_position', 'operator' => '!==', 'value' => ''],
                        ],
                    ],
                ),
                array(
                    'name' => 'slidenav_color_hover',
                    'type'=>Controls_Manager::COLOR,
                    'label'=>__( 'Color Hover', 'uipro' ),
                    'selectors' => [
                        '{{WRAPPER}} .ui-slidenav:hover' => 'color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'slidenav_position', 'operator' => '!==', 'value' => ''],
                        ],
                    ],
                ),
                array(
                    'name' => 'slidenav_bg_color',
                    'type'=>Controls_Manager::COLOR,
                    'label'=>__( 'Background Color', 'uipro' ),
                    'selectors' => [
                        '{{WRAPPER}} .uk-slider .uk-slidenav' => 'background-color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'slidenav_position', 'operator' => '!==', 'value' => ''],
                        ],
                    ],
                ),
                array(
                    'name' => 'slidenav_bg_hover_color',
                    'type'=>Controls_Manager::COLOR,
                    'label'=>__( 'Background Hover Color', 'uipro' ),
                    'selectors' => [
                        '{{WRAPPER}} .uk-slider .uk-slidenav:hover' => 'background-color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'slidenav_position', 'operator' => '!==', 'value' => ''],
                        ],
                    ],
                ),
                array(
                    'name' => 'slidenav_border_color',
                    'type'=>Controls_Manager::COLOR,
                    'label'=>__( 'Border Color', 'uipro' ),
                    'selectors' => [
                        '{{WRAPPER}} .uk-slider .uk-slidenav' => 'border-color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'slidenav_position', 'operator' => '!==', 'value' => ''],
                        ],
                    ],
                ),
                array(
                    'name' => 'slidenav_border_hover_color',
                    'type'=>Controls_Manager::COLOR,
                    'label'=>__( 'Border Hover Color', 'uipro' ),
                    'selectors' => [
                        '{{WRAPPER}} .uk-slider .uk-slidenav:hover' => 'border-color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'slidenav_position', 'operator' => '!==', 'value' => ''],
                        ],
                    ],
                ),
				array(
					'id' => 'larger_style',
					'type' => Controls_Manager::SWITCHER,
					'label'     => esc_html__( 'Larger style', 'uipro' ),
					'description' => esc_html__( 'To increase the size of the slidenav icons', 'uipro' ),
					'label_on' => esc_html__( 'Yes', 'uipro' ),
					'label_off' => esc_html__( 'No', 'uipro' ),
					'return_value' => '1',
					'default' => '0',
					'conditions' => [
						'terms' => [
							['name' => 'slidenav_position', 'operator' => '!==', 'value' => ''],
						],
					],
				),
				array(
					'id' => 'slidenav_margin',
					'type' => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Margin', 'uipro' ),
					'description' => esc_html__( 'Apply a margin between the slidnav and the slideshow container.', 'uipro' ),
					'options'         => array(
						'' => esc_html__( 'None', 'uipro' ),
						'small' => esc_html__( 'Small', 'uipro' ),
						'medium' => esc_html__( 'Medium', 'uipro' ),
						'large' => esc_html__( 'Large', 'uipro' ),
					),
					'default' => 'medium',
					'conditions' => [
						'terms' => [
							['name' => 'slidenav_position', 'operator' => '!==', 'value' => ''],
						],
					],
				),
				array(
					'id' => 'slidenav_breakpoint',
					'type' => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Breakpoint', 'uipro' ),
					'description' => esc_html__( 'Display the slidenav on this device width and larger.', 'uipro' ),
					'options'         => array(
						'' => esc_html__( 'Always', 'uipro' ),
						's' => esc_html__( 'Small (Phone Landscape)', 'uipro' ),
						'm' => esc_html__( 'Medium (Tablet Landscape)', 'uipro' ),
						'l' => esc_html__( 'Large (Desktop)', 'uipro' ),
						'xl' => esc_html__( 'X-Large (Large Screens)', 'uipro' ),
					),
					'default' => 's',
					'conditions' => [
						'terms' => [
							['name' => 'slidenav_position', 'operator' => '!==', 'value' => ''],
						],
					],
				),

				array(
					'id' => 'slidenav_outside_breakpoint',
					'type' => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Outside Breakpoint', 'uipro' ),
					'description' => esc_html__( 'Display the slidenav only outside on this device width and larger. Otherwise it will be displayed inside', 'uipro' ),
					'options'         => array(
						's' => esc_html__( 'Small (Phone Landscape)', 'uipro' ),
						'm' => esc_html__( 'Medium (Tablet Landscape)', 'uipro' ),
						'l' => esc_html__( 'Large (Desktop)', 'uipro' ),
						'xl' => esc_html__( 'X-Large (Large Screens)', 'uipro' ),
					),
					'default' => 'xl',
					'conditions' => [
						'terms' => [
							['name' => 'slidenav_position', 'operator' => '!==', 'value' => ''],
							['name' => 'slidenav_position', 'operator' => '!==', 'value' => 'default'],
						],
					],
				),
				array(
					'id' => 'slidenav_outside_color',
					'type' => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Outside Color', 'uipro' ),
					'description' => esc_html__( 'Set light or dark color if the slidenav is outside of the slider', 'uipro' ),
					'options'         => array(
						'' => esc_html__( 'None', 'uipro' ),
						'light' => esc_html__( 'Light', 'uipro' ),
						'dark' => esc_html__( 'Dark', 'uipro' ),
					),
					'default' => '',
					'conditions' => [
						'terms' => [
							['name' => 'slidenav_position', 'operator' => '!==', 'value' => ''],
							['name' => 'slidenav_position', 'operator' => '!==', 'value' => 'default'],
						],
					],
				),
				array(
					'id' => 'overlay_container',
					'type' => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Container Width', 'uipro' ),
					'description' => esc_html__( 'Set the maximum content width. Note: The section may already have a maximum width, which you cannot exceed.', 'uipro' ),
					'options'         => array(
						'' => esc_html__( 'None', 'uipro' ),
						'default' => esc_html__( 'Default', 'uipro' ),
						'small' => esc_html__( 'Small', 'uipro' ),
						'large' => esc_html__( 'Large', 'uipro' ),
						'xlarge' => esc_html__( 'XLarge', 'uipro' ),
						'expand' => esc_html__( 'Expand', 'uipro' ),
					),
					'default' => '',
                    'start_section' => 'separator_overlay_style_options',
                    'section_name'   => esc_html__('Overlay Settings','uipro')
				),
				array(
					'id' => 'overlay_container_padding',
					'type' => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Container Padding', 'uipro' ),
					'description' => esc_html__( 'Set the vertical container padding to position the overlay.', 'uipro' ),
					'options'         => array(
						'' => esc_html__( 'Default', 'uipro' ),
						'xsmall' => esc_html__( 'X-Small', 'uipro' ),
						'small' => esc_html__( 'Small', 'uipro' ),
						'large' => esc_html__( 'Large', 'uipro' ),
						'xlarge' => esc_html__( 'X-Large', 'uipro' ),
					),
					'default' => '',
					'conditions' => [
						'terms' => [
							['name' => 'overlay_container', 'operator' => '!==', 'value' => ''],
						],
					],
				),
				array(
					'id' => 'overlay_margin',
					'type' => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Margin', 'uipro' ),
					'description' => esc_html__( 'Set the margin between the overlay and the slideshow container.', 'uipro' ),
					'options'         => array(
						'' => esc_html__( 'Default', 'uipro' ),
						'small' => esc_html__( 'Small', 'uipro' ),
						'large' => esc_html__( 'Large', 'uipro' ),
						'none' => esc_html__( 'None', 'uipro' ),
					),
					'default' => '',
					'conditions' => [
						'terms' => [
							['name' => 'overlay_container', 'operator' => '!==', 'value' => 'default'],
							['name' => 'overlay_container', 'operator' => '!==', 'value' => 'small'],
							['name' => 'overlay_container', 'operator' => '!==', 'value' => 'large'],
							['name' => 'overlay_container', 'operator' => '!==', 'value' => 'xlarge'],
							['name' => 'overlay_container', 'operator' => '!==', 'value' => 'expand'],
						],
					],
				),
				array(
					'id' => 'overlay_positions',
					'type' => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Positions', 'uipro' ),
					'description' => esc_html__( 'Select the content position.', 'uipro' ),
					'options'         => array(
						'top' => esc_html__( 'Top', 'uipro' ),
						'bottom' => esc_html__( 'Bottom', 'uipro' ),
						'left' => esc_html__( 'Left', 'uipro' ),
						'right' => esc_html__( 'Right', 'uipro' ),
						'top-left' => esc_html__( 'Top Left', 'uipro' ),
						'top-center' => esc_html__( 'Top Center', 'uipro' ),
						'top-right' => esc_html__( 'Top Right', 'uipro' ),
						'center-left' => esc_html__( 'Center Left', 'uipro' ),
						'center' => esc_html__( 'Center Center', 'uipro' ),
						'center-right' => esc_html__( 'Center Right', 'uipro' ),
						'bottom-left' => esc_html__( 'Bottom Left', 'uipro' ),
						'bottom-center' => esc_html__( 'Bottom Center', 'uipro' ),
						'bottom-right' => esc_html__( 'Bottom Right', 'uipro' ),
					),
					'default' => 'center-left',
				),
				array(
					'id' => 'overlay_styles',
					'type' => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Style', 'uipro' ),
					'description' => esc_html__( 'Select a style for the overlay.', 'uipro' ),
					'options'         => array(
						'' => esc_html__( 'None', 'uipro' ),
						'overlay-default' => esc_html__( 'Overlay Default', 'uipro' ),
						'overlay-primary' => esc_html__( 'Overlay Primary', 'uipro' ),
						'tile-default' => esc_html__( 'Tile Default', 'uipro' ),
						'tile-muted' => esc_html__( 'Tile Muted', 'uipro' ),
						'tile-primary' => esc_html__( 'Tile Primary', 'uipro' ),
						'tile-secondary' => esc_html__( 'Tile Secondary', 'uipro' ),
						'overlay-custom' => esc_html__( 'Custom', 'uipro' ),
					),
					'default' => '',
				),
				array(
					'name' => 'overlay_background',
					'type' => Controls_Manager::COLOR,
					'label'     => esc_html__( 'Background Color', 'uipro' ),
					'default' => '#ffd49b',
					'conditions' => [
						'terms' => [
							['name' => 'overlay_styles', 'operator' => '===', 'value' => 'overlay-custom'],
						],
					],
				),
				array(
					'id' => 'overlay_padding',
					'type' => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Padding', 'uipro' ),
					'description' => esc_html__( 'Set the padding between the overlay and its content.', 'uipro' ),
					'options'         => array(
						'' => esc_html__( 'Default', 'uipro' ),
						'small' => esc_html__( 'Small', 'uipro' ),
						'large' => esc_html__( 'Large', 'uipro' ),
					),
					'default' => '',
					'conditions' => [
						'terms' => [
							['name' => 'overlay_styles', 'operator' => '!==', 'value' => ''],
						],
					],
				),
				array(
					'id' => 'overlay_width',
					'type' => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Width', 'uipro' ),
					'description' => esc_html__( 'Set a fixed width.', 'uipro' ),
					'options'         => array(
						'' => esc_html__( 'None', 'uipro' ),
						'small' => esc_html__( 'Small', 'uipro' ),
						'medium' => esc_html__( 'Medium', 'uipro' ),
						'large' => esc_html__( 'Large', 'uipro' ),
						'xlarge' => esc_html__( 'X-Large', 'uipro' ),
						'2xlarge' => esc_html__( '2X-Large', 'uipro' ),
						'custom' => esc_html__( 'Custom', 'uipro' ),
					),
					'default' => '',
					'conditions' => [
						'terms' => [
							['name' => 'overlay_positions', 'operator' => '!==', 'value' => 'top'],
							['name' => 'overlay_positions', 'operator' => '!==', 'value' => 'bottom'],
						],
					],
				),
                array(
                    'name'            => 'overlay_width_custom',
                    'label'         => esc_html__( 'Overlay Custom Width', 'uipro' ),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'responsive'    => true,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 2000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => '%',
                        'size' => 100,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .uk-panel' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                    'condition'     => array(
                        'overlay_width'    => 'custom'
                    ),
                ),

				array(
					'id' => 'overlay_transition',
					'type' => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Animation', 'uipro' ),
					'description' => esc_html__( 'Choose between a parallax depending on the scroll position or an animation, which is applied once the slide is active.', 'uipro' ),
					'options'         => array(
						'' => esc_html__( 'Parallax', 'uipro' ),
						'fade' => esc_html__( 'Fade', 'uipro' ),
						'scale-up' => esc_html__( 'Scale Up', 'uipro' ),
						'scale-down' => esc_html__( 'Scale Down', 'uipro' ),
						'slide-top-small' => esc_html__( 'Slide Top Small', 'uipro' ),
						'slide-bottom-small' => esc_html__( 'Slide Bottom Small', 'uipro' ),
						'slide-left-small' => esc_html__( 'Slide Left Small', 'uipro' ),
						'slide-right-small' => esc_html__( 'Slide Right Small', 'uipro' ),
						'slide-top-medium' => esc_html__( 'Slide Top Medium', 'uipro' ),
						'slide-bottom-medium' => esc_html__( 'Slide Bottom Medium', 'uipro' ),
						'slide-left-medium' => esc_html__( 'Slide Left Medium', 'uipro' ),
						'slide-right-medium' => esc_html__( 'Slide Right Medium', 'uipro' ),
						'slide-top' => esc_html__( 'Slide Top 100%', 'uipro' ),
						'slide-bottom' => esc_html__( 'Slide Bottom 100%', 'uipro' ),
						'slide-left' => esc_html__( 'Slide Left 100%', 'uipro' ),
						'slide-right' => esc_html__( 'Slide Right 100%', 'uipro' ),
					),
					'default' => '',
				),

				array(
					'name' => 'overlay_horizontal_start',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Horizontal Start', 'uipro' ),
					'range' => [
						'px' => [
							'min' => -600,
							'max' => 600,
						],
					],
					'description' => esc_html__( 'Animate the horizontal position (translateX) in pixels.', 'uipro' ),
					'conditions' => [
						'terms' => [
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'overlay_horizontal_end',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Horizontal End', 'uipro' ),
					'range' => [
						'px' => [
							'min' => -600,
							'max' => 600,
						],
					],
					'description' => esc_html__( 'Animate the horizontal position (translateX) in pixels.', 'uipro' ),
					'conditions' => [
						'terms' => [
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'overlay_vertical_start',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Vertical Start', 'uipro' ),
					'range' => [
						'px' => [
							'min' => -600,
							'max' => 600,
						],
					],
					'description' => esc_html__( 'Animate the vertical position (translateY) in pixels.', 'uipro' ),
					'conditions' => [
						'terms' => [
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'overlay_vertical_end',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Vertical End', 'uipro' ),
					'range' => [
						'px' => [
							'min' => -600,
							'max' => 600,
						],
					],
					'description' => esc_html__( 'Animate the vertical position (translateY) in pixels.', 'uipro' ),
					'conditions' => [
						'terms' => [
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'overlay_scale_start',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Scale Start', 'uipro' ),
					'range' => [
						'px' => [
							'min' => 30,
							'max' => 400,
						],
					],
					'conditions' => [
						'terms' => [
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'overlay_scale_end',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Scale End', 'uipro' ),
					'range' => [
						'px' => [
							'min' => 30,
							'max' => 400,
						],
					],
					'conditions' => [
						'terms' => [
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'overlay_rotate_start',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Rotate Start', 'uipro' ),
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 360,
						],
					],
					'description' => esc_html__( 'Animate the rotation clockwise in degrees.', 'uipro' ),
					'conditions' => [
						'terms' => [
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'overlay_rotate_end',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Rotate End', 'uipro' ),
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 360,
						],
					],
					'description' => esc_html__( 'Animate the rotation clockwise in degrees.', 'uipro' ),
					'conditions' => [
						'terms' => [
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'overlay_opacity_start',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Opacity Start', 'uipro' ),
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'description' => esc_html__( 'Animate the opacity. 100 means 100% opacity, and 0 means 0% opacity.', 'uipro' ),
					'conditions' => [
						'terms' => [
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'overlay_opacity_end',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Opacity End', 'uipro' ),
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'description' => esc_html__( 'Animate the opacity. 100 means 100% opacity, and 0 means 0% opacity.', 'uipro' ),
					'conditions' => [
						'terms' => [
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'id' => 'heading_style',
					'type' => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Style', 'uipro' ),
					'description' => esc_html__( 'Heading styles differ in font-size but may also come with a predefined color, size and font', 'uipro' ),
					'options'         => array(
						'' => esc_html__( 'None', 'uipro' ),
						'heading-2xlarge' => esc_html__( '2XLarge', 'uipro' ),
						'heading-xlarge' => esc_html__( 'XLarge', 'uipro' ),
						'heading-large' => esc_html__( 'Large', 'uipro' ),
						'heading-medium' => esc_html__( 'Medium', 'uipro' ),
						'heading-small' => esc_html__( 'Small', 'uipro' ),
						'h1' => esc_html__( 'H1', 'uipro' ),
						'h2' => esc_html__( 'H2', 'uipro' ),
						'h3' => esc_html__( 'H3', 'uipro' ),
						'h4' => esc_html__( 'H4', 'uipro' ),
						'h5' => esc_html__( 'H5', 'uipro' ),
						'h6' => esc_html__( 'H6', 'uipro' ),
					),
					'default' => '',
					'start_section' => 'separator_title_style_options',
					'section_name'      => esc_html__('Title Settings', 'uipro')
				),
				array(
					'id' => 'title_decoration',
					'type' => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Decoration', 'uipro' ),
					'description' => esc_html__( 'Decorate the title with a divider, bullet or a line that is vertically centered to the title', 'uipro' ),
					'options'         => array(
						'' => esc_html__( 'None', 'uipro' ),
						'uk-heading-divider' => esc_html__( 'Divider', 'uipro' ),
						'uk-heading-bullet' => esc_html__( 'Bullet', 'uipro' ),
						'uk-heading-line' => esc_html__( 'Line', 'uipro' ),
					),
					'default' => '',
				),
				array(
					'name' => 'title_font_family',
					'type'          => Group_Control_Typography::get_type(),
					'scheme'        => Typography::TYPOGRAPHY_1,
					'label'=>__( 'Font Family', 'uipro' ),
					'selector'      => '{{WRAPPER}} .ui-title',
				),
				array(
					'id' => 'font_weight',
					'type' => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Font weight', 'uipro' ),
					'description' => esc_html__( 'Add one of the following classes to modify the font weight of your text.', 'uipro' ),
					'options'         => array(
						'' => esc_html__( 'Default', 'uipro' ),
						'light' => esc_html__( 'Light', 'uipro' ),
						'normal' => esc_html__( 'Normal', 'uipro' ),
						'bold' => esc_html__( 'Bold', 'uipro' ),
						'lighter' => esc_html__( 'Lighter', 'uipro' ),
						'bolder' => esc_html__( 'Bolder', 'uipro' ),
					),
				),
				array(
					'id' => 'title_color',
					'type' => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Predefined Color', 'uipro' ),
					'description' => esc_html__( 'Select the predefined title text color.', 'uipro' ),
					'options'         => array(
						'' => esc_html__( 'None', 'uipro' ),
						'muted' => esc_html__( 'Muted', 'uipro' ),
						'emphasis' => esc_html__( 'Emphasis', 'uipro' ),
						'primary' => esc_html__( 'Primary', 'uipro' ),
						'secondary' => esc_html__( 'Secondary', 'uipro' ),
						'success' => esc_html__( 'Success', 'uipro' ),
						'warning' => esc_html__( 'Warning', 'uipro' ),
						'danger' => esc_html__( 'Danger', 'uipro' ),
					),
					'default' => '',
				),
				array(
					'name' => 'custom_title_color',
					'type'=>Controls_Manager::COLOR,
					'label'=>__( 'Custom Color', 'uipro' ),
					'selectors' => [
						'{{WRAPPER}} .ui-title' => 'color: {{VALUE}}',
					],
					'conditions' => [
						'terms' => [
							['name' => 'title_color', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array( 'id' => 'title_text_transform',
					'type' => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Transform', 'uipro' ),
					'description' => esc_html__( 'The following options will transform text into uppercased, capitalized or lowercased characters.', 'uipro' ),
					'options'         => array(
						'' => esc_html__( 'Inherit', 'uipro' ),
						'uppercase' => esc_html__( 'Uppercase', 'uipro' ),
						'capitalize' => esc_html__( 'Capitalize', 'uipro' ),
						'lowercase' => esc_html__( 'Lowercase', 'uipro' ),
					),
					'default' => '',
				),
				array( 'id' => 'heading_selector',
					'type' => Controls_Manager::SELECT,
					'label'     => esc_html__( 'HTML Element', 'uipro' ),
					'description' => esc_html__( 'Choose one of the HTML elements to fit your semantic structure.', 'uipro' ),
					'options'         => array(
						'h1' => esc_html__( 'h1', 'uipro' ),
						'h2' => esc_html__( 'h2', 'uipro' ),
						'h3' => esc_html__( 'h3', 'uipro' ),
						'h4' => esc_html__( 'h4', 'uipro' ),
						'h5' => esc_html__( 'h5', 'uipro' ),
						'h6' => esc_html__( 'h6', 'uipro' ),
						'div' => esc_html__( 'div', 'uipro' ),
					),
					'default' => 'h3',
				),
				array(
					'id' => 'title_margin_top',
					'type' => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Margin Top', 'uipro' ),
					'description' => esc_html__( 'Set the top margin.', 'uipro' ),
					'options'         => array(
						'' => esc_html__( 'Default', 'uipro' ),
						'small' => esc_html__( 'Small', 'uipro' ),
						'medium' => esc_html__( 'Medium', 'uipro' ),
						'large' => esc_html__( 'Large', 'uipro' ),
						'xlarge' => esc_html__( 'X-Large', 'uipro' ),
						'custom' => esc_html__( 'Custom', 'uipro' ),
						'remove' => esc_html__( 'None', 'uipro' ),
					),
					'default' => '',
				),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'title_margin_top_custom',
                    'label'         => esc_html__( 'Title Margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    ],
                    'condition'     => array(
                        'title_margin_top'    => 'custom'
                    ),
                ),
				array(
					'id' => 'use_title_parallax',
					'type' => Controls_Manager::SWITCHER,
					'label'     => esc_html__( 'Parallax Settings', 'uipro' ),
					'description' => esc_html__( 'Add a parallax effect.', 'uipro' ),
					'label_on' => esc_html__( 'Yes', 'uipro' ),
					'label_off' => esc_html__( 'No', 'uipro' ),
					'return_value' => '1',
					'default' => 0,
					'conditions' => [
						'terms' => [
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'title_horizontal_start',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Horizontal Start', 'uipro' ),
					'range' => [
						'px' => [
							'min' => -600,
							'max' => 600,
						],
					],
					'conditions' => [
						'terms' => [
							['name' => 'use_title_parallax', 'operator' => '===', 'value' => '1'],
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'title_horizontal_end',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Horizontal End', 'uipro' ),
					'range' => [
						'px' => [
							'min' => -600,
							'max' => 600,
						],
					],
					'conditions' => [
						'terms' => [
							['name' => 'use_title_parallax', 'operator' => '===', 'value' => '1'],
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'title_vertical_start',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Vertical Start', 'uipro' ),
					'range' => [
						'px' => [
							'min' => -600,
							'max' => 600,
						],
					],
					'conditions' => [
						'terms' => [
							['name' => 'use_title_parallax', 'operator' => '===', 'value' => '1'],
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'title_vertical_end',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Vertical End', 'uipro' ),
					'range' => [
						'px' => [
							'min' => -600,
							'max' => 600,
						],
					],
					'conditions' => [
						'terms' => [
							['name' => 'use_title_parallax', 'operator' => '===', 'value' => '1'],
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'title_scale_start',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Scale Start', 'uipro' ),
					'range' => [
						'px' => [
							'min' => 30,
							'max' => 400,
						],
					],
					'conditions' => [
						'terms' => [
							['name' => 'use_title_parallax', 'operator' => '===', 'value' => '1'],
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'title_scale_end',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Scale End', 'uipro' ),
					'range' => [
						'px' => [
							'min' => 30,
							'max' => 400,
						],
					],
					'conditions' => [
						'terms' => [
							['name' => 'use_title_parallax', 'operator' => '===', 'value' => '1'],
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'title_rotate_start',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Rotate Start', 'uipro' ),
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 360,
						],
					],
					'conditions' => [
						'terms' => [
							['name' => 'use_title_parallax', 'operator' => '===', 'value' => '1'],
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'title_rotate_end',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Rotate End', 'uipro' ),
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 360,
						],
					],
					'conditions' => [
						'terms' => [
							['name' => 'use_title_parallax', 'operator' => '===', 'value' => '1'],
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'title_opacity_start',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Opacity Start', 'uipro' ),
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'conditions' => [
						'terms' => [
							['name' => 'use_title_parallax', 'operator' => '===', 'value' => '1'],
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'title_opacity_end',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Opacity End', 'uipro' ),
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'conditions' => [
						'terms' => [
							['name' => 'use_title_parallax', 'operator' => '===', 'value' => '1'],
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'meta_font_family',
					'type'          => Group_Control_Typography::get_type(),
					'scheme'        => Typography::TYPOGRAPHY_1,
					'label'=>__( 'Font Family', 'uipro' ),
					'selector'      => '{{WRAPPER}} .ui-meta',
					'start_section' => 'separator_meta_style_options',
					'section_name'      => esc_html__('Meta Settings', 'uipro')
				),
				array(
					'id' => 'meta_style',
					'type' => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Style', 'uipro' ),
					'description' => esc_html__( 'Select a predefined meta text style, including color, size and font-family', 'uipro' ),
					'options'         => array(
						'' => esc_html__( 'None', 'uipro' ),
						'text-meta' => esc_html__( 'Meta', 'uipro' ),
						'heading-2xlarge' => esc_html__( '2XLarge', 'uipro' ),
						'heading-xlarge' => esc_html__( 'XLarge', 'uipro' ),
						'heading-large' => esc_html__( 'Large', 'uipro' ),
						'heading-medium' => esc_html__( 'Medium', 'uipro' ),
						'heading-small' => esc_html__( 'Small', 'uipro' ),
						'h1' => esc_html__( 'H1', 'uipro' ),
						'h2' => esc_html__( 'H2', 'uipro' ),
						'h3' => esc_html__( 'H3', 'uipro' ),
						'h4' => esc_html__( 'H4', 'uipro' ),
						'h5' => esc_html__( 'H5', 'uipro' ),
						'h6' => esc_html__( 'H6', 'uipro' ),
					),
					'default' => '',
				),
				array(
					'id' => 'meta_color',
					'type' => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Predefined Color', 'uipro' ),
					'description' => esc_html__( 'Select the predefined meta text color.', 'uipro' ),
					'options'         => array(
						'' => esc_html__( 'None', 'uipro' ),
						'muted' => esc_html__( 'Muted', 'uipro' ),
						'emphasis' => esc_html__( 'Emphasis', 'uipro' ),
						'primary' => esc_html__( 'Primary', 'uipro' ),
						'secondary' => esc_html__( 'Secondary', 'uipro' ),
						'success' => esc_html__( 'Success', 'uipro' ),
						'warning' => esc_html__( 'Warning', 'uipro' ),
						'danger' => esc_html__( 'Danger', 'uipro' ),
					),
					'default' => '',
				),
				array(
					'name' => 'custom_meta_color',
					'type'=>Controls_Manager::COLOR,
					'label'=>__( 'Custom Color', 'uipro' ),
					'selectors' => [
						'{{WRAPPER}} .ui-meta' => 'color: {{VALUE}}',
					],
					'conditions' => [
						'terms' => [
							['name' => 'meta_color', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'id' => 'meta_text_transform',
					'type' => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Transform', 'uipro' ),
					'description' => esc_html__( 'The following options will transform text into uppercased, capitalized or lowercased characters.', 'uipro' ),
					'options'         => array(
						'' => esc_html__( 'Inherit', 'uipro' ),
						'uppercase' => esc_html__( 'Uppercase', 'uipro' ),
						'capitalize' => esc_html__( 'Capitalize', 'uipro' ),
						'lowercase' => esc_html__( 'Lowercase', 'uipro' ),
					),
					'default' => '',
				),
				array(
					'id' => 'meta_alignment',
					'type' => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Alignment', 'uipro' ),
					'description' => esc_html__( 'Align the meta text above or below the title.', 'uipro' ),
					'options'         => array(
						'top' => esc_html__( 'Above Title', 'uipro' ),
						'' => esc_html__( 'Below Title', 'uipro' ),
						'content' => esc_html__( 'Below Content', 'uipro' ),
					),
					'default' => '',
				),
				array(
					'id' => 'meta_element',
					'type' => Controls_Manager::SELECT,
					'label'     => esc_html__( 'HTML Element', 'uipro' ),
					'description' => esc_html__( 'Choose one of the HTML elements to fit your semantic structure.', 'uipro' ),
					'options'         => array(
						'h1' => esc_html__( 'h1', 'uipro' ),
						'h2' => esc_html__( 'h2', 'uipro' ),
						'h3' => esc_html__( 'h3', 'uipro' ),
						'h4' => esc_html__( 'h4', 'uipro' ),
						'h5' => esc_html__( 'h5', 'uipro' ),
						'h6' => esc_html__( 'h6', 'uipro' ),
						'div' => esc_html__( 'div', 'uipro' ),
					),
					'default' => 'div',
				),
				array(
					'id' => 'meta_margin_top',
					'type' => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Margin', 'uipro' ),
					'description' => esc_html__( 'Set the margin.', 'uipro' ),
					'options'         => array(
						'' => esc_html__( 'Default', 'uipro' ),
						'small' => esc_html__( 'Small', 'uipro' ),
						'medium' => esc_html__( 'Medium', 'uipro' ),
						'large' => esc_html__( 'Large', 'uipro' ),
						'xlarge' => esc_html__( 'X-Large', 'uipro' ),
						'custom' => esc_html__( 'Custom', 'uipro' ),
						'remove' => esc_html__( 'None', 'uipro' ),
					),
					'default' => '',
				),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'meta_margin_top_custom',
                    'label'         => esc_html__( 'Meta Margin Custom', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    ],
                    'condition'     => array(
                        'meta_margin_top'    => 'custom'
                    ),
                ),
				array(
					'id' => 'use_meta_parallax',
					'type' => Controls_Manager::SWITCHER,
					'label'     => esc_html__( 'Parallax Settings', 'uipro' ),
					'description' => esc_html__( 'Add a parallax effect.', 'uipro' ),
					'label_on' => esc_html__( 'Yes', 'uipro' ),
					'label_off' => esc_html__( 'No', 'uipro' ),
					'return_value' => '1',
					'default' => 0,
					'conditions' => [
						'terms' => [
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'meta_horizontal_start',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Horizontal Start', 'uipro' ),
					'range' => [
						'px' => [
							'min' => -600,
							'max' => 600,
						],
					],
					'conditions' => [
						'terms' => [
							['name' => 'use_meta_parallax', 'operator' => '===', 'value' => '1'],
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'meta_horizontal_end',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Horizontal End', 'uipro' ),
					'range' => [
						'px' => [
							'min' => -600,
							'max' => 600,
						],
					],
					'conditions' => [
						'terms' => [
							['name' => 'use_meta_parallax', 'operator' => '===', 'value' => '1'],
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'meta_vertical_start',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Vertical Start', 'uipro' ),
					'range' => [
						'px' => [
							'min' => -600,
							'max' => 600,
						],
					],
					'conditions' => [
						'terms' => [
							['name' => 'use_meta_parallax', 'operator' => '===', 'value' => '1'],
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'meta_vertical_end',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Vertical End', 'uipro' ),
					'range' => [
						'px' => [
							'min' => -600,
							'max' => 600,
						],
					],
					'conditions' => [
						'terms' => [
							['name' => 'use_meta_parallax', 'operator' => '===', 'value' => '1'],
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'meta_scale_start',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Scale Start', 'uipro' ),
					'range' => [
						'px' => [
							'min' => 30,
							'max' => 400,
						],
					],
					'conditions' => [
						'terms' => [
							['name' => 'use_meta_parallax', 'operator' => '===', 'value' => '1'],
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'meta_scale_end',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Scale End', 'uipro' ),
					'range' => [
						'px' => [
							'min' => 30,
							'max' => 400,
						],
					],
					'conditions' => [
						'terms' => [
							['name' => 'use_meta_parallax', 'operator' => '===', 'value' => '1'],
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'meta_rotate_start',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Rotate Start', 'uipro' ),
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 360,
						],
					],
					'conditions' => [
						'terms' => [
							['name' => 'use_meta_parallax', 'operator' => '===', 'value' => '1'],
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'meta_rotate_end',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Rotate End', 'uipro' ),
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 360,
						],
					],
					'conditions' => [
						'terms' => [
							['name' => 'use_meta_parallax', 'operator' => '===', 'value' => '1'],
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'meta_opacity_start',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Opacity Start', 'uipro' ),
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'conditions' => [
						'terms' => [
							['name' => 'use_meta_parallax', 'operator' => '===', 'value' => '1'],
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'meta_opacity_end',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Opacity End', 'uipro' ),
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'conditions' => [
						'terms' => [
							['name' => 'use_meta_parallax', 'operator' => '===', 'value' => '1'],
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'content_font_family',
					'type'          => Group_Control_Typography::get_type(),
					'scheme'        => Typography::TYPOGRAPHY_1,
					'label'=>__( 'Font Family', 'uipro' ),
					'selector'      => '{{WRAPPER}} .ui-content',
					'start_section' => 'separator_content_style_options',
					'section_name'      => esc_html__('Content Settings', 'uipro')
				),
				array(
					'id' => 'content_style',
					'type' => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Style', 'uipro' ),
					'description' => esc_html__( 'Select a predefined meta text style, including color, size and font-family', 'uipro' ),
					'options'         => array(
						'' => esc_html__( 'None', 'uipro' ),
						'text-lead' => esc_html__( 'Lead', 'uipro' ),
						'text-meta' => esc_html__( 'Meta', 'uipro' ),
					),
					'default' => '',
				),
				array(
					'name' => 'content_color',
					'type'=>Controls_Manager::COLOR,
					'label'=>__( 'Color', 'uipro' ),
					'selectors' => [
						'{{WRAPPER}} .ui-content' => 'color: {{VALUE}}',
					],
				),
				array( 'id' => 'content_text_transform',
					'type' => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Transform', 'uipro' ),
					'description' => esc_html__( 'The following options will transform text into uppercased, capitalized or lowercased characters.', 'uipro' ),
					'options'         => array(
						'' => esc_html__( 'Inherit', 'uipro' ),
						'uppercase' => esc_html__( 'Uppercase', 'uipro' ),
						'capitalize' => esc_html__( 'Capitalize', 'uipro' ),
						'lowercase' => esc_html__( 'Lowercase', 'uipro' ),
					),
					'default' => '',
				),
				array( 'id' => 'content_margin_top',
					'type' => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Margin Top', 'uipro' ),
					'description' => esc_html__( 'Set the top margin.', 'uipro' ),
					'options'         => array(
						'' => esc_html__( 'Default', 'uipro' ),
						'small' => esc_html__( 'Small', 'uipro' ),
						'medium' => esc_html__( 'Medium', 'uipro' ),
						'large' => esc_html__( 'Large', 'uipro' ),
						'xlarge' => esc_html__( 'X-Large', 'uipro' ),
						'custom' => esc_html__( 'Custom', 'uipro' ),
						'remove' => esc_html__( 'None', 'uipro' ),
					),
					'default' => '',
				),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'content_margin_top_custom',
                    'label'         => esc_html__( 'Content Margin Custom', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    ],
                    'condition'     => array(
                        'content_margin_top'    => 'custom'
                    ),
                ),
				array(
					'id' => 'use_content_parallax',
					'type' => Controls_Manager::SWITCHER,
					'label'     => esc_html__( 'Parallax Settings', 'uipro' ),
					'description' => esc_html__( 'Add a parallax effect.', 'uipro' ),
					'label_on' => esc_html__( 'Yes', 'uipro' ),
					'label_off' => esc_html__( 'No', 'uipro' ),
					'return_value' => '1',
					'default' => 0,
					'conditions' => [
						'terms' => [
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'content_horizontal_start',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Horizontal Start', 'uipro' ),
					'range' => [
						'px' => [
							'min' => -600,
							'max' => 600,
						],
					],
					'conditions' => [
						'terms' => [
							['name' => 'use_content_parallax', 'operator' => '===', 'value' => '1'],
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'content_horizontal_end',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Horizontal End', 'uipro' ),
					'range' => [
						'px' => [
							'min' => -600,
							'max' => 600,
						],
					],
					'conditions' => [
						'terms' => [
							['name' => 'use_content_parallax', 'operator' => '===', 'value' => '1'],
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'content_vertical_start',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Vertical Start', 'uipro' ),
					'range' => [
						'px' => [
							'min' => -600,
							'max' => 600,
						],
					],
					'conditions' => [
						'terms' => [
							['name' => 'use_content_parallax', 'operator' => '===', 'value' => '1'],
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'content_vertical_end',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Vertical End', 'uipro' ),
					'range' => [
						'px' => [
							'min' => -600,
							'max' => 600,
						],
					],
					'conditions' => [
						'terms' => [
							['name' => 'use_content_parallax', 'operator' => '===', 'value' => '1'],
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'content_scale_start',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Scale Start', 'uipro' ),
					'range' => [
						'px' => [
							'min' => 30,
							'max' => 400,
						],
					],
					'conditions' => [
						'terms' => [
							['name' => 'use_content_parallax', 'operator' => '===', 'value' => '1'],
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'content_scale_end',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Scale End', 'uipro' ),
					'range' => [
						'px' => [
							'min' => 30,
							'max' => 400,
						],
					],
					'conditions' => [
						'terms' => [
							['name' => 'use_content_parallax', 'operator' => '===', 'value' => '1'],
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'content_rotate_start',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Rotate Start', 'uipro' ),
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 360,
						],
					],
					'conditions' => [
						'terms' => [
							['name' => 'use_content_parallax', 'operator' => '===', 'value' => '1'],
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'content_rotate_end',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Rotate End', 'uipro' ),
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 360,
						],
					],
					'conditions' => [
						'terms' => [
							['name' => 'use_content_parallax', 'operator' => '===', 'value' => '1'],
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'content_opacity_start',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Opacity Start', 'uipro' ),
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'conditions' => [
						'terms' => [
							['name' => 'use_content_parallax', 'operator' => '===', 'value' => '1'],
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'content_opacity_end',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Opacity End', 'uipro' ),
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'conditions' => [
						'terms' => [
							['name' => 'use_content_parallax', 'operator' => '===', 'value' => '1'],
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'id' => 'all_button_title',
					'type'          => Controls_Manager::TEXT,
					'label'     => esc_html__( 'Text', 'uipro' ),
					'default' => 'Read more',
					'start_section' => 'separator_button_style_options',
					'section_name'      => esc_html__('Link Settings', 'uipro')
				),
				array(
					'id' => 'link_new_tab',
					'type' => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Link New Tab', 'uipro' ),
					'description' => esc_html__( 'Choose whether or not your link opens in a new window.', 'uipro' ),
					'options'         => array(
						'' => esc_html__( 'Same Window', 'uipro' ),
						'_blank' => esc_html__( 'New Window', 'uipro' ),
					),
				),
				array(
					'id' => 'link_button_style',
					'type' => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Style', 'uipro' ),
					'description' => esc_html__( 'Set the button style.', 'uipro' ),
					'options'         => array(
						'' => esc_html__( 'Button Default', 'uipro' ),
						'primary' => esc_html__( 'Button Primary', 'uipro' ),
						'secondary' => esc_html__( 'Button Secondary', 'uipro' ),
						'danger' => esc_html__( 'Button Danger', 'uipro' ),
						'text' => esc_html__( 'Button Text', 'uipro' ),
						'link' => esc_html__( 'Link', 'uipro' ),
						'link-muted' => esc_html__( 'Link Muted', 'uipro' ),
						'link-text' => esc_html__( 'Link Text', 'uipro' ),
						'custom' => esc_html__( 'Custom', 'uipro' ),
					),
					'default' => '',
				),
				array(
					'name' => 'button_font_family',
					'type'          => Group_Control_Typography::get_type(),
					'scheme'        => Typography::TYPOGRAPHY_1,
					'label'     => esc_html__( 'Font Family', 'uipro' ),
					'conditions' => [
						'terms' => [
							['name' => 'link_button_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
					'selector'      => '{{WRAPPER}} .uk-button-custom',
				),
				array(
					'name' => 'button_background',
					'type' => Controls_Manager::COLOR,
					'label'     => esc_html__( 'Background Color', 'uipro' ),
					'default' => '#1e87f0',
                    'selectors'     => [
                        '{{WRAPPER}} .ui-buttons .uk-button' => 'background-color: {{VALUE}};',
                    ],
					'conditions' => [
						'terms' => [
							['name' => 'link_button_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				),
				array(
					'name' => 'button_gl_color',
					'type'=>Controls_Manager::COLOR,
					'label'=>__( 'Button Color', 'uipro' ),
					'conditions' => [
						'terms' => [
							['name' => 'link_button_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-buttons .uk-button' => 'color: {{VALUE}};',
                    ],
				),
				array(
					'name' => 'button_background_hover',
					'type' => Controls_Manager::COLOR,
					'label'     => esc_html__( 'Hover Background Color', 'uipro' ),
					'default' => '#0f7ae5',
					'conditions' => [
						'terms' => [
							['name' => 'link_button_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-buttons .uk-button:hover' => 'background-color: {{VALUE}};',
                    ],
				),
				array(
					'name' => 'button_gl_hover_color',
					'type'=>Controls_Manager::COLOR,
					'label'=>__( 'Hover Button Color', 'uipro' ),
					'conditions' => [
						'terms' => [
							['name' => 'link_button_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-buttons .uk-button:hover' => 'color: {{VALUE}};',
                    ],
				),

				array(
					'id' => 'link_button_size',
					'type' => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Button Size', 'uipro' ),
					'options'         => array(
						'' => esc_html__( 'Default', 'uipro' ),
						'uk-button-small' => esc_html__( 'Small', 'uipro' ),
						'uk-button-large' => esc_html__( 'Large', 'uipro' ),
						'custom' => esc_html__( 'Custom', 'uipro' ),
					),
				),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'link_button_padding',
                    'label'         => esc_html__( 'Button Padding', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-buttons .uk-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition'     => array(
                        'link_button_size'    => 'custom'
                    ),
                ),
				array(
					'id' => 'link_button_shape',
					'type' => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Button Shape', 'uipro' ),
					'description' => esc_html__( 'Choose a button shape from the list.', 'uipro' ),
					'options'         => array(
						'rounded' => esc_html__( 'Rounded', 'uipro' ),
						'square' => esc_html__( 'Squared', 'uipro' ),
						'circle' => esc_html__( 'Circle', 'uipro' ),
						'pill' => esc_html__( 'Pill', 'uipro' ),
					),
					'conditions' => [
						'terms' => [
							['name' => 'link_button_style', 'operator' => '!==', 'value' => 'link'],
							['name' => 'link_button_style', 'operator' => '!==', 'value' => 'link-muted'],
							['name' => 'link_button_style', 'operator' => '!==', 'value' => 'link-text'],
							['name' => 'link_button_style', 'operator' => '!==', 'value' => 'text'],
						],
					],
				),
				array(
					'id' => 'button_margin_top',
					'type' => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Margin Top', 'uipro' ),
					'description' => esc_html__( 'Set the top margin. Note that the margin will only apply if the content field immediately follows another content field.', 'uipro' ),
					'options'         => array(
						'' => esc_html__( 'Default', 'uipro' ),
						'small' => esc_html__( 'Small', 'uipro' ),
						'medium' => esc_html__( 'Medium', 'uipro' ),
						'large' => esc_html__( 'Large', 'uipro' ),
						'xlarge' => esc_html__( 'X-Large', 'uipro' ),
						'custom' => esc_html__( 'Custom', 'uipro' ),
						'remove' => esc_html__( 'None', 'uipro' ),
					),
					'default' => '',
				),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'button_margin_top_custom',
                    'label'         => esc_html__( 'Button Margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-buttons' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition'     => array(
                        'button_margin_top'    => 'custom'
                    ),
                ),
				array(
					'id' => 'use_button_parallax',
					'type' => Controls_Manager::SWITCHER,
					'label'     => esc_html__( 'Parallax Settings', 'uipro' ),
					'description' => esc_html__( 'Add a parallax effect.', 'uipro' ),
					'label_on' => esc_html__( 'Yes', 'uipro' ),
					'label_off' => esc_html__( 'No', 'uipro' ),
					'return_value' => '1',
					'default' => 0,
					'conditions' => [
						'terms' => [
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'button_horizontal_start',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Horizontal Start', 'uipro' ),
					'range' => [
						'px' => [
							'min' => -600,
							'max' => 600,
						],
					],
					'conditions' => [
						'terms' => [
							['name' => 'use_button_parallax', 'operator' => '===', 'value' => '1'],
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'button_horizontal_end',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Horizontal End', 'uipro' ),
					'range' => [
						'px' => [
							'min' => -600,
							'max' => 600,
						],
					],
					'conditions' => [
						'terms' => [
							['name' => 'use_button_parallax', 'operator' => '===', 'value' => '1'],
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'button_vertical_start',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Vertical Start', 'uipro' ),
					'range' => [
						'px' => [
							'min' => -600,
							'max' => 600,
						],
					],
					'conditions' => [
						'terms' => [
							['name' => 'use_button_parallax', 'operator' => '===', 'value' => '1'],
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'button_vertical_end',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Vertical End', 'uipro' ),
					'range' => [
						'px' => [
							'min' => -600,
							'max' => 600,
						],
					],
					'conditions' => [
						'terms' => [
							['name' => 'use_button_parallax', 'operator' => '===', 'value' => '1'],
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'button_scale_start',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Scale Start', 'uipro' ),
					'range' => [
						'px' => [
							'min' => 30,
							'max' => 400,
						],
					],
					'conditions' => [
						'terms' => [
							['name' => 'use_button_parallax', 'operator' => '===', 'value' => '1'],
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'button_scale_end',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Scale End', 'uipro' ),
					'range' => [
						'px' => [
							'min' => 30,
							'max' => 400,
						],
					],
					'conditions' => [
						'terms' => [
							['name' => 'use_button_parallax', 'operator' => '===', 'value' => '1'],
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'button_rotate_start',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Rotate Start', 'uipro' ),
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 360,
						],
					],
					'conditions' => [
						'terms' => [
							['name' => 'use_button_parallax', 'operator' => '===', 'value' => '1'],
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'button_rotate_end',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Rotate End', 'uipro' ),
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 360,
						],
					],
					'conditions' => [
						'terms' => [
							['name' => 'use_button_parallax', 'operator' => '===', 'value' => '1'],
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'button_opacity_start',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Opacity Start', 'uipro' ),
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'conditions' => [
						'terms' => [
							['name' => 'use_button_parallax', 'operator' => '===', 'value' => '1'],
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
				array(
					'name' => 'button_opacity_end',
					'type'          => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Opacity End', 'uipro' ),
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'conditions' => [
						'terms' => [
							['name' => 'use_button_parallax', 'operator' => '===', 'value' => '1'],
							['name' => 'overlay_transition', 'operator' => '===', 'value' => ''],
						],
					],
				),
			);
			$options    = array_merge($options, $this->get_general_options());

			static::$cache[$store_id]   = $options;

			return $options;
		}
	}
}