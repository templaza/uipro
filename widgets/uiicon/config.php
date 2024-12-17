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


if ( ! class_exists( 'UIPro_Config_UIIcon' ) ) {
	/**
	 * Class UIPro_Config_UI_Button
	 */
	class UIPro_Config_UIIcon extends UIPro_Abstract_Config {

		/**
		 * UIPro_Config_Heading constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'uiicon';
			self::$name = esc_html__( 'TemPlaza: UI Icon', 'uipro' );
			self::$desc = esc_html__( 'Add UI Icon.', 'uipro' );
			self::$icon = 'eicon-star';
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

			$repeater = new \Elementor\Repeater();
			$repeater->add_control(
				'icon_type',
				[
					'label' => __( 'Icon Type', 'uipro' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => '',
					'options' => [
						''  => __( 'FontAwesome', 'uipro' ),
						'uikit' => __( 'UIKit', 'uipro' ),
					],
				]
			);
			$repeater->add_control(
				'icon',
				[
					'label' => __( 'Select Icon:', 'uipro' ),
					'type' => \Elementor\Controls_Manager::ICONS,
					'conditions' => [
						'terms' => [
							['name' => 'icon_type', 'operator' => '===', 'value' => ''],
						],
					],
				]
			);
			$repeater->add_control(
				'uikit_icon',
				[
					'label' => __( 'Select Icon:', 'uipro' ),
					'type' => \Elementor\Controls_Manager::SELECT2,
					'default' => '',
					'conditions' => [
						'terms' => [
							['name' => 'icon_type', 'operator' => '===', 'value' => 'uikit'],
						],
					],
					'options' => $this->get_font_uikit(),
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
			// options
			$options = array(
				array(
					'type'      => Controls_Manager::REPEATER,
					'id'      => 'uiicons',
					'label'     => esc_html__( 'Icons', 'uipro' ),
					'fields' => $repeater->get_controls(),
					'default' => [
						[
							'text' => 'Icon Item',
						],
					],
					'title_field' => __( 'Icon Item', 'uipro' ),
				),
				array(
					'name'          => 'icon_size',
					'label' => __( 'Icon Size', 'uipro' ),
					'type' => Controls_Manager::SLIDER,
					'responsive' => true,
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
						'{{WRAPPER}} a.ui-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					],
					'start_section' => 'misc',
					'section_name'      => esc_html__('Misc Settings', 'uipro')
				),
				array(
					'type'          => Controls_Manager::SELECT,
					'name'          => 'hover_animation',
					'label'         => esc_html__('Hover Animation', 'uipro'),
					'description'   => esc_html__('A collection of smooth animations to use within your page.', 'uipro'),
					'options'       => array(
						'' => __('Inherit', 'uipro'),
						'fade' => __('Fade', 'uipro'),
						'scale-up' => __('Scale Up', 'uipro'),
						'scale-down' => __('Scale Down', 'uipro'),
						'slide-top-small' => __('Slide Top Small', 'uipro'),
						'slide-bottom-small' => __('Slide Bottom Small', 'uipro'),
						'slide-left-small' => __('Slide Left Small', 'uipro'),
						'slide-right-small' => __('Slide Right Small', 'uipro'),
						'slide-top-medium' => __('Slide Top Medium', 'uipro'),
						'slide-bottom-medium' => __('Slide Bottom Medium', 'uipro'),
						'slide-left-medium' => __('Slide Left Medium', 'uipro'),
						'slide-right-medium' => __('Slide Right Medium', 'uipro'),
						'slide-top' => __('Slide Top 100%', 'uipro'),
						'slide-bottom' => __('Slide Bottom 100%', 'uipro'),
						'slide-left' => __('Slide Left 100%', 'uipro'),
						'slide-right' => __('Slide Right 100%', 'uipro'),
					),
					'default'           => '',
				),
				array(
					'id'    =>  'background_color',
					'label' => __( 'Background Color', 'uipro' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'separator'     => 'before',
					'selectors' => [
						'{{WRAPPER}} a.ui-icon' => 'background-color: {{VALUE}}',
					],
				),
				array(
					'id'    =>  'color',
					'label' => __( 'Color', 'uipro' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} a.ui-icon' => 'color: {{VALUE}}',
					],
				),
				array(
					'type' => \Elementor\Group_Control_Border::get_type(),
					'name' => 'border',
					'label' => __( 'Border', 'uipro' ),
					'selector' => '{{WRAPPER}} a.ui-icon',
				),
				array(
					'id'          => 'border_radius',
					'label' => __( 'Border Radius', 'uipro' ),
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
						'size' => 10,
					],
					'selectors' => [
						'{{WRAPPER}} a.ui-icon' => 'border-radius: {{SIZE}}{{UNIT}};',
					],
				),
				array(
					'id'          => 'padding',
					'label' => __( 'Padding', 'uipro' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} a.ui-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				),
				array(
					'id'    =>  'hover_background_color',
					'label' => __( 'Hover Background Color', 'uipro' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'separator'     => 'before',
					'selectors' => [
						'{{WRAPPER}} a.ui-icon:hover' => 'background-color: {{VALUE}}',
					],
				),
				array(
					'id'    =>  'hover_color',
					'label' => __( 'Hover Color', 'uipro' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} a.ui-icon:hover' => 'color: {{VALUE}}',
					],
				),
				array(
					'type' => \Elementor\Group_Control_Border::get_type(),
					'name' => 'hover_border',
					'label' => __( 'Hover Border', 'uipro' ),
					'selector' => '{{WRAPPER}} a.ui-icon:hover',
				),
				array(
					'id'          => 'hover_border_radius',
					'label' => __( 'Hover Border Radius', 'uipro' ),
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
						'size' => 10,
					],
					'selectors' => [
						'{{WRAPPER}} a.ui-icon:hover' => 'border-radius: {{SIZE}}{{UNIT}};',
					],
				),
				array(
					'id'          => 'hover_padding',
					'label' => __( 'Hover Padding', 'uipro' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} a.ui-icon:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				),
				array(
					'type'          => Controls_Manager::SELECT,
					'name'          => 'grid_column_gap',
					'label'         => esc_html__('Column Gap', 'uipro'),
					'description'   => esc_html__('Set the size of the column gap between multiple buttons.', 'uipro'),
					'options'       => array(
						'small' => __('Small', 'uipro'),
						'medium' => __('Medium', 'uipro'),
						'' => __('Default', 'uipro'),
						'large' => __('Large', 'uipro'),
					),
					'separator'     => 'before',
					'default'           => 'small',
				),
				array(
					'type'          => Controls_Manager::SELECT,
					'name'          => 'grid_row_gap',
					'label'         => esc_html__('Row Gap', 'uipro'),
					'description'   => esc_html__('Set the size of the row gap between multiple buttons.', 'uipro'),
					'options'       => array(
						'small' => __('Small', 'uipro'),
						'medium' => __('Medium', 'uipro'),
						'' => __('Default', 'uipro'),
						'large' => __('Large', 'uipro'),
					),
					'default'           => 'small',
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