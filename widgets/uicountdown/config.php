<?php
/**
 * UIPro Count Down config class
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

if ( ! class_exists( 'UIPro_Config_UiCountDown' ) ) {
	/**
	 * Class UIPro_Config_CountDown
	 */
	class UIPro_Config_UiCountDown extends UIPro_Abstract_Config {

		/**
		 * UIPro_Config_CountDown constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'uicountdown';
			self::$name = esc_html__( 'TemPlaza: UI Countdown', 'uipro' );
			self::$desc = esc_html__( 'Add UI Countdown.', 'uipro' );
			self::$icon = 'eicon-countdown';
			self::$assets_path  =   plugin_dir_url(__FILE__). 'assets/';
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
                    'id'            => 'title',
                    'label'         => esc_html__( 'Title', 'uipro' ),
                ),
                array(
                    'type'          => Controls_Manager::DATE_TIME,
                    'name'          => 'countdown_date',
                    'label'         => esc_html__( 'Choose End Date', 'uipro' ),
                    'description'   => esc_html__( 'Choose date to countdown ', 'uipro' ),
                ),
                array(
                    'type'          => Controls_Manager::SWITCHER,
                    'id'            => 'countdown_label',
                    'label'         => esc_html__( 'Show Label', 'uipro' ),
                    'default'       => 'yes'
                ),
                array(
                    'type'          => Controls_Manager::TEXT,
                    'id'            => 'day_label',
                    'label'         => esc_html__( 'Day Label', 'uipro' ),
                    'default'       => esc_html__('Days', 'uipro'),
                    'conditions' => [
                        'terms' => [
                            ['name' => 'countdown_label', 'operator' => '===', 'value' => 'yes'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::TEXT,
                    'id'            => 'hour_label',
                    'label'         => esc_html__( 'Hour Label', 'uipro' ),
                    'default'       => esc_html__('Hours', 'uipro'),
                    'conditions' => [
                        'terms' => [
                            ['name' => 'countdown_label', 'operator' => '===', 'value' => 'yes'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::TEXT,
                    'id'            => 'minute_label',
                    'label'         => esc_html__( 'Minute Label', 'uipro' ),
                    'default'       => esc_html__('Minutes', 'uipro'),
                    'conditions' => [
                        'terms' => [
                            ['name' => 'countdown_label', 'operator' => '===', 'value' => 'yes'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::TEXT,
                    'id'            => 'second_label',
                    'label'         => esc_html__( 'Second Label', 'uipro' ),
                    'default'       => esc_html__('Seconds', 'uipro'),
                    'conditions' => [
                        'terms' => [
                            ['name' => 'countdown_label', 'operator' => '===', 'value' => 'yes'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::SWITCHER,
                    'id'            => 'countdown_separator',
                    'label'         => esc_html__( 'Show Separator', 'uipro' ),
                    'default'       => 'yes'
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'id'            => 'separator',
                    'label'         => esc_html__( 'Separator Type', 'uipro' ),
                    'options'       => array(
                        'string'        => esc_html__('String', 'uipro'),
                        'icon'          => esc_html__('Icon', 'uipro'),
                    ),
                    'default'       => 'string',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'countdown_separator', 'operator' => '===', 'value' => 'yes'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::TEXT,
                    'id'            => 'separator_label',
                    'label'         => esc_html__( 'Separator', 'uipro' ),
                    'default'       => esc_html__(':', 'uipro'),
                    'conditions' => [
                        'terms' => [
                            ['name' => 'separator', 'operator' => '===', 'value' => 'string'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::ICONS,
                    'id'            => 'separator_icon',
                    'label'         => esc_html__( 'Separator Icon', 'uipro' ),
                    'conditions' => [
                        'terms' => [
                            ['name' => 'separator', 'operator' => '===', 'value' => 'icon'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'id'            => 'countdown_vertical',
                    'label'         => esc_html__( 'Vertical align', 'uipro' ),
                    'options'       => array(
                        'top'        => esc_html__('Top', 'uipro'),
                        'middle'          => esc_html__('Middle', 'uipro'),
                        'bottom'          => esc_html__('Bottom', 'uipro'),
                    ),
                    'default'       => 'middle',
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'id'            => 'countdown_gap',
                    'label'         => esc_html__( 'Countdown Gap', 'uipro' ),
                    'options'       => array(
                        'small'        => esc_html__('Small', 'uipro'),
                        'medium'          => esc_html__('Medium', 'uipro'),
                        'large'          => esc_html__('Large', 'uipro'),
                        'collapse'          => esc_html__('Collapse', 'uipro'),
                    ),
                    'default'       => 'default',
                ),
                array(
                    'type'          => Group_Control_Typography::get_type(),
                    'name'          => 'countdown_number_typography',
                    'scheme'        => Typography::TYPOGRAPHY_1,
                    'label'         => esc_html__('Countdown Number Font', 'uipro'),
                    'description'   => esc_html__('Select a font family', 'uipro'),
                    'selector'      => '{{WRAPPER}} .uk-countdown-number',
                    'start_section' => 'number',
                    'section_name'      => esc_html__('Number Settings', 'uipro')
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'countdown_number_color',
                    'label'         => esc_html__('Number Color', 'uipro'),
                    'description'   => esc_html__('Set the color of Number.', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .uk-countdown-number ' => 'color: {{VALUE}};',
                    ],
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'countdown_number_bg_color',
                    'label'         => esc_html__('Number Background Color', 'uipro'),
                    'description'   => esc_html__('Set the background color of Number.', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .uk-countdown-number ' => 'background-color: {{VALUE}};',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'number_padding',
                    'label'         => esc_html__( 'Number Padding', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .uk-countdown-number' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ),
                array(
                    'type'          =>  \Elementor\Group_Control_Border::get_type(),
                    'name'          => 'number_border',
                    'label'         => esc_html__('Number Border', 'uipro'),
                    'description'   => esc_html__('Set the Border of Number.', 'uipro'),
                    'selector' => '{{WRAPPER}} .uk-countdown-number',
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'number_radius',
                    'label'         => esc_html__( 'Border radius', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .uk-countdown-number' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;',
                    ],
                ),


                array(
                    'type'          => Group_Control_Typography::get_type(),
                    'name'          => 'countdown_label_typography',
                    'scheme'        => Typography::TYPOGRAPHY_1,
                    'label'         => esc_html__('Countdown Label Font', 'uipro'),
                    'description'   => esc_html__('Select a font family', 'uipro'),
                    'selector'      => '{{WRAPPER}} .uk-countdown-label',
                    'start_section' => 'label',
                    'section_name'      => esc_html__('Label Settings', 'uipro')
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'countdown_label_color',
                    'label'         => esc_html__('Label Color', 'uipro'),
                    'description'   => esc_html__('Set the color of label.', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .uk-countdown-label ' => 'color: {{VALUE}};',
                    ],
                ),
                array(
                    'type'          => Group_Control_Typography::get_type(),
                    'name'          => 'countdown_separator_typography',
                    'scheme'        => Typography::TYPOGRAPHY_1,
                    'label'         => esc_html__('Separator Font', 'uipro'),
                    'description'   => esc_html__('Select a font family', 'uipro'),
                    'selector'      => '{{WRAPPER}} .uk-countdown-separator',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'separator', 'operator' => '===', 'value' => 'string'],
                        ],
                    ],
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'countdown_separator_color',
                    'label'         => esc_html__('Separator Color', 'uipro'),
                    'description'   => esc_html__('Set the color of separator.', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .uk-countdown-separator ' => 'color: {{VALUE}};',
                    ],
                ),
                array(
                    'type'          => Group_Control_Typography::get_type(),
                    'name'          => 'countdown_title_typography',
                    'scheme'        => Typography::TYPOGRAPHY_1,
                    'label'         => esc_html__('Title Font', 'uipro'),
                    'description'   => esc_html__('Select a font family', 'uipro'),
                    'selector'      => '{{WRAPPER}} .countdowwn-title',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'title', 'operator' => '!=', 'value' => ''],
                        ],
                    ],
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'countdown_title_color',
                    'label'         => esc_html__('Title Color', 'uipro'),
                    'description'   => esc_html__('Set the color of separator.', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .countdowwn-title ' => 'color: {{VALUE}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'title', 'operator' => '!=', 'value' => ''],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'separator_padding',
                    'label'         => esc_html__( 'Separator Padding', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .uk-countdown-separator' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ),


			) ;
			$options    = array_merge($options, $this->get_general_options());

			static::$cache[$store_id]   = $options;

			return $options;
		}

		public function get_template_name() {
			return 'base';
		}

	}
}