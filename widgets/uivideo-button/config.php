<?php
/**
 * UIPro video button config class
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

if ( ! class_exists( 'UIPro_Config_UIVideo_Button' ) ) {
	/**
	 * Class UIPro_Config_UI_Button
	 */
	class UIPro_Config_UIVideo_Button extends UIPro_Abstract_Config {

		/**
		 * UIPro_Config_Heading constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'uivideo-button';
			self::$name = esc_html__( 'TemPlaza: UI Video Button', 'uipro' );
			self::$desc = esc_html__( 'Add UI Video Button.', 'uipro' );
			self::$icon = 'eicon-play';
			parent::__construct();

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
                    'type'          => Controls_Manager::TEXT,
                    'name'          => 'video_link',
                    'label'         => esc_html__( 'Video Button Url', 'uipro' ),
                    'description'   => esc_html__( 'Insert your youtube/vimeo url.', 'uipro' ),
                    'dynamic'       => [
                        'active'    => true,
                    ],
                    /* vc */
                    'admin_label'   => true,
                ),
                array(
                    'name'          => 'size',
                    'label'         => esc_html__( 'Button Size', 'uipro' ),
                    'type'          => Controls_Manager::SLIDER,
                    'devices'       => [ 'desktop', 'tablet', 'mobile' ],
                    'responsive'    => true,
                    'separator'     => 'before',
                    'range' => [
                        'px' => [
                            'min' => 1,
                            'max' => 1000
                        ],
                    ],
                    'desktop_default' => [
                        'size' => 220,
                        'unit' => 'px',
                    ],
                    'tablet_default' => [
                        'size' => 220,
                        'unit' => 'px',
                    ],
                    'mobile_default' => [
                        'size' => 220,
                        'unit' => 'px',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .tz-image-cover' => 'height: {{SIZE}}{{UNIT}};',
                    ],
                ),
                array(
                    'id'            => 'color',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('Button Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ui-button' => 'color: {{VALUE}}',
                    ],
                ),
                array(
                    'id'            => 'background_color',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('Button Background Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ui-button' => 'background-color: {{VALUE}}',
                    ],
                ),
                array(
                    'type'          => \Elementor\Group_Control_Border::get_type(),
                    'name'          => 'border',
                    'label'         => esc_html__( 'Border', 'uipro' ),
                    'selector'      => '{{WRAPPER}} .ui-button',
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'padding',
                    'label'         => esc_html__( 'Video Button Padding', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} ui-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ),
			);
			$options    = array_merge($options, $this->get_general_options());

			static::$cache[$store_id]   = $options;

			return $options;
		}

		public function get_template_name() {
			return 'base';
		}
	}
}