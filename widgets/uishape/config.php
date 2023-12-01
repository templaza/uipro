<?php
/**
 * UIPro UIShape config class
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
use Elementor\Group_Control_Box_Shadow;

if ( ! class_exists( 'UIPro_Config_UIShape' ) ) {
	/**
	 * Class UIPro_Config_UIShape
	 */
	class UIPro_Config_UIShape extends UIPro_Abstract_Config {

		/**
		 * UIPro_Config_UIShape constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'uishape';
			self::$name = esc_html__( 'TemPlaza: Shape', 'uipro' );
			self::$desc = esc_html__( 'Display Shape.', 'uipro' );
			self::$icon = 'eicon-shape';
			parent::__construct();
		}
        public function get_styles() {
            return ['ui-shape' => array(
                'src'   => 'style.css'
            )];
        }

		/**
		 * @return array
		 */
		public function get_options() {
			// options
			return array(
                array(
                    'type' => Controls_Manager::SELECT,
                    'name'      => 'uishape_type',
                    'label'     => esc_html__( 'Choose Shape', 'uipro' ),
                    'section_name'  => esc_html__( self::$name, 'uipro' ),
                    'default' => '',
                    'options' => [
                        '' => esc_html__( 'None','uipro' ),
                        'truck' => esc_html__( 'Truck','uipro' ),
                    ],
                ),
                array(
                    'name'          => 'width',
                    'label'         => esc_html__( 'Shape Width', 'uipro' ),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'responsive'    => true,
                    'range' => [
                        'px' => [
                            'min' => 1,
                            'max' => 2000
                        ],
                    ],
                    'desktop_default' => [
                        'size' => 50,
                        'unit' => '%',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .tz-shape' => 'width: {{SIZE}}{{UNIT}};',
                    ],

                ),
                array(
                    'name'          => 'height',
                    'label'         => esc_html__( 'Shape Height', 'uipro' ),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'responsive'    => true,
                    'range' => [
                        'px' => [
                            'min' => 1,
                            'max' => 2000
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .tz-shape' => 'height: {{SIZE}}{{UNIT}};',
                    ],

                ),
                array(
                    'name'          => 'shape_skew',
                    'label'         => esc_html__( 'Shape Skew', 'uipro' ),
                    'type'          => Controls_Manager::SLIDER,
                    'responsive'    => true,
                    'selectors' => [
                        '{{WRAPPER}} .truck' => 'transform: skew({{SIZE}}deg);',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'uishape_type', 'operator' => '===', 'value' => 'truck'],
                        ],
                    ],

                ),
                array(
                    'type'         => Controls_Manager::CHOOSE,
                    'label'         => esc_html__( 'Alignment', 'uipro' ),
                    'name'          => 'text_align',
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
                        '{{WRAPPER}} .shape-wrap'   => 'justify-content: {{VALUE}}; align-items: {{VALUE}};',
                    ],
                    /*vc*/
                    'admin_label'   => false,
                ),
                array(
                    'name'  => 'shape_bg_color',
                    'label' => esc_html__( 'Shape Background Color','uipro' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                            '{{WRAPPER}} .tz-shape' => 'background-color: {{VALUE}};',
                        '{{WRAPPER}} .truck:before' => 'background-color: {{VALUE}};',
                    ],
                    'start_section' => 'icon_section_style',
                    'section_tab'   => Controls_Manager::TAB_STYLE,
                    'section_name'  => esc_html__( self::$name, 'uipro' ),
                ),
                array(
                    'name' => 'border',
                    'type' => \Elementor\Group_Control_Border::get_type(),
                    'label' => __( 'Border', 'uipro' ),
                    'selector' => '{{WRAPPER}} .tz-shape',
                ),

			);
		}

        public function get_template_name() {
            return 'base';
        }
	}
}