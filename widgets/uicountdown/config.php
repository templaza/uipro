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
                    'type'          => Group_Control_Typography::get_type(),
                    'name'          => 'countdown_number_typography',
                    'scheme'        => Typography::TYPOGRAPHY_1,
                    'label'         => esc_html__('Countdown Number Font', 'uipro'),
                    'description'   => esc_html__('Select a font family', 'uipro'),
                    'selector'      => '{{WRAPPER}} .uk-countdown-number',
                    'start_section' => 'style',
                    'section_tab'   => Controls_Manager::TAB_STYLE,
                    'section_name'  => esc_html__( self::$name, 'uipro' ),
                ),
                array(
                    'type'          => Group_Control_Typography::get_type(),
                    'name'          => 'countdown_label_typography',
                    'scheme'        => Typography::TYPOGRAPHY_1,
                    'label'         => esc_html__('Countdown Label Font', 'uipro'),
                    'description'   => esc_html__('Select a font family', 'uipro'),
                    'selector'      => '{{WRAPPER}} .uk-countdown-label',
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
                    'name'          => 'countdown_number_color',
                    'label'         => esc_html__('Number Color', 'uipro'),
                    'description'   => esc_html__('Set the color of Number.', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .uk-countdown-number ' => 'color: {{VALUE}};',
                    ],
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
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'countdown_separator_color',
                    'label'         => esc_html__('Separator Color', 'uipro'),
                    'description'   => esc_html__('Set the color of separator.', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .uk-countdown-separator ' => 'color: {{VALUE}};',
                    ],
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'button_color',
                    'label'         => esc_html__('Button Color', 'uipro'),
                    'description'   => esc_html__('Set the color of button.', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} form button.wpforms-submit, {{WRAPPER}} form input[type="button"], {{WRAPPER}} form input[type="submit"] ' => 'color: {{VALUE}} !important;',
                    ],
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'button_background_hover',
                    'label'         => esc_html__('Hover Button Background Color', 'uipro'),
                    'description'   => esc_html__('Set the hover background color of button.', 'uipro'),
                    'selectors' => [
                        '.templaza-section {{WRAPPER}} .wpforms-container form button.wpforms-submit:hover, {{WRAPPER}} form input[type="button"]:hover, {{WRAPPER}} form input[type="submit"]:hover ' => 'background-color: {{VALUE}} !important;',
                    ],
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'button_color_hover',
                    'label'         => esc_html__('Hover Button Color', 'uipro'),
                    'description'   => esc_html__('Set the hover color of button.', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} form button:hover, {{WRAPPER}} form input[type="button"]:hover, {{WRAPPER}} form input[type="submit"]:hover ' => 'color: {{VALUE}} !important;',
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