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
			self::$name = esc_html__( 'TemPlaza: UI Lightbox', 'uipro' );
			self::$desc = esc_html__( 'Add UI Lightbox.', 'uipro' );
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
			// options
			$options = array(
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
                    'name'          => 'width',
                    'label'         => esc_html__( 'Button Width', 'uipro' ),
                    'type'          => Controls_Manager::SLIDER,
                    'devices'       => [ 'desktop', 'tablet', 'mobile' ],
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
                    ],
                ),
                array(
                    'name'          => 'height',
                    'label'         => esc_html__( 'Button Height', 'uipro' ),
                    'type'          => Controls_Manager::SLIDER,
                    'devices'       => [ 'desktop', 'tablet', 'mobile' ],
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
                    ],
                ),
                array(
                    'name'          => 'size',
                    'label'         => esc_html__( 'Button Size', 'uipro' ),
                    'type'          => Controls_Manager::SLIDER,
                    'devices'       => [ 'desktop', 'tablet', 'mobile' ],
                    'responsive'    => true,
                    'range' => [
                        'px' => [
                            'min' => 1,
                            'max' => 1000
                        ],
                    ],
                    'desktop_default' => [
                        'size' => 48,
                        'unit' => 'px',
                    ],
                    'tablet_default' => [
                        'size' => 32,
                        'unit' => 'px',
                    ],
                    'mobile_default' => [
                        'size' => 24,
                        'unit' => 'px',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .ui-lightbox' => 'font-size: {{SIZE}}{{UNIT}};',
                    ],
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
                    'id'            => 'color',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('Icon Color', 'uipro'),
                    'description'   => esc_html__( 'Choose icon color', 'uipro' ),
                    'selectors' => [
                        '{{WRAPPER}} .ui-lightbox' => 'color: {{VALUE}}',
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
                    'selector'      => '{{WRAPPER}} .ui-lightbox',
                    'separator'     => 'before',
                ),
                array(
                    'type'          => \Elementor\Group_Control_Border::get_type(),
                    'name'          => 'border',
                    'label'         => esc_html__( 'Border', 'uipro' ),
                    'selector'      => '{{WRAPPER}} .ui-lightbox',
                    'separator'     => 'before',
                ),
                array(
                    'type'          => \Elementor\Group_Control_Box_Shadow::get_type(),
                    'name'          => 'box_shadow',
                    'label'         => esc_html__( 'Box Shadow', 'uipro' ),
                    'selector'      => '{{WRAPPER}} .ui-lightbox',
                    'separator'     => 'before',
                ),
                array(
                    'id'            => 'color_hover',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('Icon Color Hover', 'uipro'),
                    'description'   => esc_html__( 'Choose icon color on hover', 'uipro' ),
                    'selectors' => [
                        '{{WRAPPER}} .ui-lightbox:hover' => 'color: {{VALUE}}',
                    ],
                    'separator'     => 'before',
                    'start_section' => 'color-style-hover-settings',
                    'section_name'  => esc_html__('Color Style Hover', 'uipro')
                ),
                array(
                    'name'          => 'background_color_hover',
                    'type'          =>  \Elementor\Group_Control_Background::get_type(),
                    'label'         => esc_html__( 'Background Color Hover', 'uipro' ),
                    'description'   => esc_html__( 'Choose icon background color on hover', 'uipro' ),
                    'types'         => [ 'classic', 'gradient', 'video' ],
                    'selector'      => '{{WRAPPER}} .ui-lightbox:hover',
                    'separator'     => 'before',
                ),
                array(
                    'type'          => \Elementor\Group_Control_Border::get_type(),
                    'name'          => 'border_hover',
                    'label'         => esc_html__( 'Border Hover', 'uipro' ),
                    'selector'      => '{{WRAPPER}} .ui-lightbox:hover',
                    'separator'     => 'before',
                ),
                array(
                    'type'          => \Elementor\Group_Control_Box_Shadow::get_type(),
                    'name'          => 'box_shadow_hover',
                    'label'         => esc_html__( 'Box Shadow Hover', 'uipro' ),
                    'selector'      => '{{WRAPPER}} .ui-lightbox:hover',
                    'separator'     => 'before',
                ),
			);
			return array_merge($options, $this->get_general_options());
		}

		public function get_template_name() {
			return 'base';
		}
	}
}