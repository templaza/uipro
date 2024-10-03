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
use Elementor\Core\Schemes\Typography;

if ( ! class_exists( 'UIPro_Config_UILightbox' ) ) {
	/**
	 * Class UIPro_Config_UI_Button
	 */
	class UIPro_Config_UILightbox extends UIPro_Abstract_Config {

		/**
		 * UIPro_Config_Heading constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'uilightbox';
			self::$name = esc_html__( 'TemPlaza: UI Video', 'uipro' );
			self::$desc = esc_html__( 'Add UI Video.', 'uipro' );
			self::$icon = 'eicon-click';
			parent::__construct();

		}

        public function get_styles() {
            return array(
                'ui-lightbox' => array(
                    'src'   =>  'style.css'
                )
            );
        }

		/**
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
                    'id'        => 'layout',
                    'label'     => esc_html__( 'Layout', 'uipro' ),
                    'type'      => Controls_Manager::SELECT,
                    'options'   => array(
                        'base'      => esc_html__('Default', 'uipro'),
                        'cover'    => esc_html__('Video Background', 'uipro'),
                    ),
                    'default'   => 'base',
                ),
                array(
                    'type'          => Controls_Manager::TEXT,
                    'name'          => 'title',
                    'label'         => esc_html__( 'Title', 'uipro' ),
                ),
                array(
                    'type'          => Controls_Manager::TEXT,
                    'name'          => 'caption',
                    'label'         => esc_html__( 'Caption', 'uipro' ),
                    'description'   => esc_html__( 'Insert URL Caption', 'uipro' ),
                    'dynamic'       => [
                        'active'    => true,
                    ],
                    /* vc */
                    'admin_label'   => true,
                ),
                array(
                    'type'          => Controls_Manager::TEXT,
                    'name'          => 'link',
                    'label'         => esc_html__( 'Url', 'uipro' ),
                    'description'   => esc_html__( 'Insert your url. Supports Image, Video, Youtube, Vimeo, Google Map URL', 'uipro' ),
                    'dynamic'       => [
                        'active'    => true,
                    ],
                    /* vc */
                    'admin_label'   => true,
                ),
                array(
                    'name'          => 'icon',
                    'label'         => esc_html__( 'Icon', 'uipro' ),
                    'type' => \Elementor\Controls_Manager::ICONS,
                    'default' => [
                        'value' => 'fas fa-play',
                        'library' => 'solid',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::SWITCHER,
                    'id'            => 'ripple_effect',
                    'label'         => esc_html__('Ripple Effect', 'uipro'),
                    'label_on'      => esc_html__( 'Yes', 'uipro' ),
                    'label_off'     => esc_html__( 'No', 'uipro' ),
                    'return_value'  => '1',
                    'default'       => '1'
                ),
                array(
                    'type'          => Controls_Manager::SWITCHER,
                    'id'            => 'ripple_effect_hover',
                    'label'         => esc_html__('Ripple Effect on Hover', 'uipro'),
                    'label_on'      => esc_html__( 'Yes', 'uipro' ),
                    'label_off'     => esc_html__( 'No', 'uipro' ),
                    'return_value'  => '1',
                    'default'       => '0'
                ),
                array(
                    'name'          => 'width',
                    'label'         => esc_html__( 'Button Width', 'uipro' ),
                    'type'          => Controls_Manager::SLIDER,
                    'responsive'    => true,
                    'range' => [
                        'px' => [
                            'min' => 1,
                            'max' => 1000
                        ],
                    ],
                    'desktop_default' => [
                        'size' => 120,
                        'unit' => 'px',
                    ],
                    'tablet_default' => [
                        'size' => 80,
                        'unit' => 'px',
                    ],
                    'mobile_default' => [
                        'size' => 50,
                        'unit' => 'px',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .ui-lightbox' => 'width: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .ui-lightbox:before, {{WRAPPER}} .ui-lightbox:after' => 'width: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .ui-title-lightbox .icon' => 'width: {{SIZE}}{{UNIT}};',
                    ],

                ),
                array(
                    'name'          => 'height',
                    'label'         => esc_html__( 'Button Height', 'uipro' ),
                    'type'          => Controls_Manager::SLIDER,
                    'responsive'    => true,
                    'range' => [
                        'px' => [
                            'min' => 1,
                            'max' => 1000
                        ],
                    ],
                    'desktop_default' => [
                        'size' => 120,
                        'unit' => 'px',
                    ],
                    'tablet_default' => [
                        'size' => 80,
                        'unit' => 'px',
                    ],
                    'mobile_default' => [
                        'size' => 50,
                        'unit' => 'px',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .ui-lightbox' => 'height: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .ui-lightbox:before, {{WRAPPER}} .ui-lightbox:after' => 'height: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .ui-title-lightbox .icon' => 'height: {{SIZE}}{{UNIT}};',
                    ],
                ),
                array(
                    'name'          => 'size',
                    'label'         => esc_html__( 'Button Size', 'uipro' ),
                    'type'          => Controls_Manager::SLIDER,
                    'responsive'    => true,
                    'range' => [
                        'px' => [
                            'min' => 1,
                            'max' => 1000
                        ],
                    ],
                    'desktop_default' => [
                        'size' => 30,
                        'unit' => 'px',
                    ],
                    'tablet_default' => [
                        'size' => 20,
                        'unit' => 'px',
                    ],
                    'mobile_default' => [
                        'size' => 18,
                        'unit' => 'px',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .ui-lightbox' => 'font-size: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .ui-title-lightbox .icon' => 'font-size: {{SIZE}}{{UNIT}};',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'button_margin',
                    'label'         => esc_html__( 'Button Margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-title-lightbox .icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition'     => array(
                        'title!'    => ''
                    ),
                ),
                array(
                    'type'          => Controls_Manager::SWITCHER,
                    'id'            => 'autoplay',
                    'label'         => esc_html__('Lightbox videos autoplay', 'uipro'),
                    'label_on'      => esc_html__( 'Yes', 'uipro' ),
                    'label_off'     => esc_html__( 'No', 'uipro' ),
                    'return_value'  => '1',
                    'default'       => '0',
                    'start_section' => 'lightbox-settings',
                    'section_name'  => esc_html__('Lightbox Settings', 'uipro')
                ),
                array(
                    'name'          => 'lightbox_width',
                    'label'         => esc_html__( 'Lightbox Width', 'uipro' ),
                    'type'          => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 1,
                            'max' => 3000
                        ],
                    ],
                ),
                array(
                    'name'          => 'lightbox_height',
                    'label'         => esc_html__( 'Lightbox Height', 'uipro' ),
                    'type'          => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 1,
                            'max' => 3000
                        ],
                    ],
                ),
                array(
                    'type'          => Group_Control_Typography::get_type(),
                    'name'          => 'title_typography',
                    'scheme'        => Typography::TYPOGRAPHY_1,
                    'label'         => esc_html__('Title Font', 'uipro'),
                    'description'   => esc_html__('Select a font family.', 'uipro'),
                    'selector'      => '{{WRAPPER}} .ui-title-lightbox, {{WRAPPER}} .circletext textPath',
                    'start_section' => 'title-style-settings',
                    'section_name'  => esc_html__('Title Settings', 'uipro'),
                    'condition'     => array(
                        'title!'    => ''
                    ),
                ),
                array(
                    'type'          => Controls_Manager::SWITCHER,
                    'id'            => 'title_circle',
                    'label'         => esc_html__('Circle text', 'uipro'),
                    'label_on'      => esc_html__( 'Yes', 'uipro' ),
                    'label_off'     => esc_html__( 'No', 'uipro' ),
                    'return_value'  => '1',
                    'default'       => '0'
                ),
                array(
                    'type'          => Controls_Manager::SLIDER,
                    'name'            => 'text_width',
                    'label'         => esc_html__( 'Width', 'uipro' ),
                    'responsive'    => true,
                    'size_units'    => ['px', '%'],
                    'range'         => [
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                        'px' => [
                            'min' => 0,
                            'max' => 1000,
                        ],
                    ],
                    'default'   => [
                        'unit' => 'px',
                        'size' => 150,
                    ],
                    'selectors'  => ['{{WRAPPER}} svg.circletext' => 'max-width: {{SIZE}}{{UNIT}};'],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'title_circle', 'operator' => '===', 'value' => '1'],
                        ],
                    ],
                ),
                array(
                    'type'      => Controls_Manager::SWITCHER,
                    'name'      => 'text_hover_rotate',
                    'label'     => esc_html__( 'Rotate when hover', 'uipro' ),
                    'conditions' => [
                        'terms' => [
                            ['name' => 'title_circle', 'operator' => '===', 'value' => '1'],
                        ],
                    ],
                ),
                array(
                    'type'      => Controls_Manager::SWITCHER,
                    'name'      => 'auto_rotate',
                    'label'     => esc_html__( 'Auto rotate', 'uipro' ),
                    'conditions' => [
                        'terms' => [
                            ['name' => 'title_circle', 'operator' => '===', 'value' => '1'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::SLIDER,
                    'name'            => 'text_hover_duration',
                    'label'         => esc_html__( 'Duration', 'uipro' ),
                    'description'   => esc_html__( 'Duration (s)', 'uipro' ),
                    'responsive'    => true,
                    'size_units'    => ['s'],
                    'range'         => [
                        's' => [
                            'min' => 0,
                            'max' => 10,
                        ],
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'text_hover_rotate', 'operator' => '===', 'value' => 'yes'],
                            ['name' => 'title_circle', 'operator' => '===', 'value' => '1'],
                        ],
                    ],
                    'selectors'  => ['{{WRAPPER}} svg.circletext' => 'animation-duration: {{SIZE}}s;']
                ),
                array(
                    'type'          => \Elementor\Group_Control_Border::get_type(),
                    'name'          => 'circle_border',
                    'label'         => esc_html__( 'Circle Border', 'uipro' ),
                    'selector'      => '{{WRAPPER}} .rotate .uilightbox-inner ',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'title_circle', 'operator' => '===', 'value' => '1'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'circle_padding',
                    'label'         => esc_html__( 'Circle padding', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .rotate .uilightbox-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'title_circle', 'operator' => '===', 'value' => '1'],
                        ],
                    ],
                ),
                array(
                    'id'            => 'title-color',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('Title Color', 'uipro'),
                    'description'   => esc_html__( 'Choose title color', 'uipro' ),
                    'selectors' => [
                        '{{WRAPPER}} .ui-title-lightbox' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .circletext textPath' => 'color: {{VALUE}}',
                    ],
                    'separator'     => 'before',
                    'start_section' => 'color-style-settings',
                    'section_name'  => esc_html__('Color Style', 'uipro'),
                    'condition'     => array(
                        'title!'    => ''
                    ),
                ),
                array(
                    'id'            => 'color',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('Icon Color', 'uipro'),
                    'description'   => esc_html__( 'Choose icon color', 'uipro' ),
                    'selectors' => [
                        '{{WRAPPER}} .ui-lightbox' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .ui-title-lightbox .icon' => 'color: {{VALUE}}',
                    ],
                    'separator'     => 'before',
                    'start_section' => 'color-style-settings',
                    'section_name'  => esc_html__('Color Style', 'uipro')
                ),
                array(
                    'name'          => 'background_color',
                    'type'          =>  \Elementor\Group_Control_Background::get_type(),
                    'label'         => esc_html__( 'Background Color', 'uipro' ),
                    'description'   => esc_html__( 'Choose icon background color', 'uipro' ),
                    'types'         => [ 'classic', 'gradient', 'video' ],
                    'selector'      => '{{WRAPPER}} .ui-lightbox, {{WRAPPER}} .ui-title-lightbox .icon',
                    'separator'     => 'before',
                ),
                array(
                    'type'          => \Elementor\Group_Control_Border::get_type(),
                    'name'          => 'border',
                    'label'         => esc_html__( 'Border', 'uipro' ),
                    'selector'      => '{{WRAPPER}} .ui-lightbox, {{WRAPPER}} .ui-title-lightbox .icon',
                    'separator'     => 'before',
                ),
                array(
                    'type'          => \Elementor\Group_Control_Box_Shadow::get_type(),
                    'name'          => 'box_shadow',
                    'label'         => esc_html__( 'Box Shadow', 'uipro' ),
                    'selector'      => '{{WRAPPER}} .ui-lightbox, {{WRAPPER}} .ui-title-lightbox .icon',
                    'separator'     => 'before',
                ),
                array(
                    'id'            => 'color_hover',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('Icon Color Hover', 'uipro'),
                    'description'   => esc_html__( 'Choose icon color on hover', 'uipro' ),
                    'selectors' => [
                        '{{WRAPPER}} .ui-lightbox:hover' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .ui-title-lightbox:hover .icon' => 'color: {{VALUE}}',
                    ],
                    'separator'     => 'before',
                    'start_section' => 'color-style-hover-settings',
                    'section_name'  => esc_html__('Color Style Hover', 'uipro')
                ),
                array(
                    'id'            => 'title-color-hover',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('Title Color Hover', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ui-title-lightbox:hover' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .rotate:hover textPath' => 'color: {{VALUE}}',
                    ],
                    'separator'     => 'before',
                    'condition'     => array(
                        'title!'    => ''
                    ),

                ),
                array(
                    'name'          => 'background_color_hover',
                    'type'          =>  \Elementor\Group_Control_Background::get_type(),
                    'label'         => esc_html__( 'Background Color Hover', 'uipro' ),
                    'description'   => esc_html__( 'Choose icon background color on hover', 'uipro' ),
                    'types'         => [ 'classic', 'gradient', 'video' ],
                    'selector'      => '{{WRAPPER}} .ui-lightbox:hover, {{WRAPPER}} .ui-title-lightbox:hover .icon',
                    'separator'     => 'before',
                ),
                array(
                    'type'          => \Elementor\Group_Control_Border::get_type(),
                    'name'          => 'border_hover',
                    'label'         => esc_html__( 'Border Hover', 'uipro' ),
                    'selector'      => '{{WRAPPER}} .ui-lightbox:hover, {{WRAPPER}} .ui-title-lightbox :hover .icon',
                    'separator'     => 'before',
                ),
                array(
                    'type'          => \Elementor\Group_Control_Box_Shadow::get_type(),
                    'name'          => 'box_shadow_hover',
                    'label'         => esc_html__( 'Box Shadow Hover', 'uipro' ),
                    'selector'      => '{{WRAPPER}} .ui-lightbox:hover, {{WRAPPER}} .ui-title-lightbox:hover .icon',
                    'separator'     => 'before',
                ),
			);
			$options    = array_merge($options, $this->get_general_options());

			static::$cache[$store_id]   = $options;

			return $options;
		}

	}
}