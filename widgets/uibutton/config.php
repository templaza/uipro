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

if ( ! class_exists( 'UIPro_Config_UIButton' ) ) {
	/**
	 * Class UIPro_Config_UI_Button
	 */
	class UIPro_Config_UIButton extends UIPro_Abstract_Config {

		/**
		 * UIPro_Config_Heading constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'uibutton';
			self::$name = esc_html__( 'TemPlaza: UI Button', 'uipro' );
			self::$desc = esc_html__( 'Add UI Button.', 'uipro' );
			self::$icon = 'eicon-button';
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
				'text', [
					'label' => __( 'Text', 'uipro' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => __( '' , 'uipro' ),
					'label_block' => true,
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
					'default' => __( '' , 'uipro' ),
					'label_block' => true,
				]
			);
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
				'icon_position',
				[
					'label' => __( 'Icon Position', 'uipro' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => '',
					'options' => [
						''  => __( 'Left', 'uipro' ),
						'right' => __( 'Right', 'uipro' ),
					],
				]
			);
			$repeater->add_control(
				'button_style',
				[
					'label' => __( 'Button Style', 'uipro' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => '',
					'options' => [
						'' => __('Default', 'uipro' ),
						'primary' => __('Primary', 'uipro') ,
						'secondary' => __('Secondary', 'uipro' ),
						'danger' => __('Danger', 'uipro' ),
						'text' => __('Text', 'uipro' ),
						'link' => __('Link', 'uipro' ),
						'link-muted' => __('Link Muted', 'uipro' ),
						'link-text' => __('Link Text', 'uipro' ),
						'custom' => __('Custom', 'uipro' ),
					],
				]
			);
			$repeater->add_control(
				'button_shape',
				[
					'label' => __( 'Button Shape', 'uipro' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'rounded',
					'options' => [
						'rounded' => __('Rounded', 'uipro' ),
						'square' => __('Square', 'uipro' ),
						'circle' => __('Circle', 'uipro' ),
						'pill' => __('Pill', 'uipro' ),
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
				]
			);
			$repeater->add_control(
				'background_color',
				[
					'label' => __( 'Background Color', 'uipro' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'separator'     => 'before',
					'selectors' => [
						'{{WRAPPER}} .ui-buttons {{CURRENT_ITEM}} > a' => 'background-color: {{VALUE}}',
					],
					'conditions' => [
						'terms' => [
							['name' => 'button_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				]
			);
			$repeater->add_control(
				'color',
				[
					'label' => __( 'Color', 'uipro' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ui-buttons {{CURRENT_ITEM}} > a' => 'color: {{VALUE}}',
					],
					'conditions' => [
						'terms' => [
							['name' => 'button_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				]
			);
			$repeater->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'border',
					'label' => __( 'Border', 'uipro' ),
					'selector' => '{{WRAPPER}} .ui-buttons {{CURRENT_ITEM}} > a',
					'conditions' => [
						'terms' => [
							['name' => 'button_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				]
			);
			$repeater->add_control(
				'hover_background_color',
				[
					'label' => __( 'Hover Background Color', 'uipro' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'separator'     => 'before',
					'selectors' => [
						'{{WRAPPER}} .ui-buttons {{CURRENT_ITEM}} > a:hover' => 'background-color: {{VALUE}}',
					],
					'conditions' => [
						'terms' => [
							['name' => 'button_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				]
			);
			$repeater->add_control(
				'hover_color',
				[
					'label' => __( 'Hover Color', 'uipro' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ui-buttons {{CURRENT_ITEM}} > a:hover' => 'color: {{VALUE}}',
					],
					'conditions' => [
						'terms' => [
							['name' => 'button_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				]
			);
			$repeater->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'hover_border',
					'label' => __( 'Hover Border', 'uipro' ),
					'selector' => '{{WRAPPER}} .ui-buttons {{CURRENT_ITEM}} > a:hover',
					'conditions' => [
						'terms' => [
							['name' => 'button_style', 'operator' => '===', 'value' => 'custom'],
						],
					],
				]
			);
			// options
			$options = array(
				array(
					'type'      => Controls_Manager::REPEATER,
					'name'      => 'templaza-uibuttons',
					'label'     => esc_html__( 'Buttons', 'uipro' ),
					'fields' => $repeater->get_controls(),
					'default' => [
						[
							'text' => 'Button Item',
						],
					],
					'title_field' => __( 'Button Item', 'uipro' ),
				),
				array(
					'type'          => Controls_Manager::SELECT,
					'name'          => 'font_weight',
					'label'         => esc_html__('Font Weight', 'uipro'),
					'description'   => esc_html__('Add one of the following classes to modify the font weight of your button.', 'uipro'),
					'options'       => array(
						'' => __('Default', 'uipro'),
						'light' => __('Light', 'uipro'),
						'normal' => __('Normal', 'uipro'),
						'bold' => __('Bold', 'uipro'),
						'lighter' => __('Lighter', 'uipro'),
						'bolder' => __('Bolder', 'uipro'),
					),
					'default'           => '',
					'start_section' => 'misc',
					'section_name'      => esc_html__('Misc Settings', 'uipro')
				),
				array(
					'type'          => Controls_Manager::SELECT,
					'name'          => 'button_size',
					'label'         => esc_html__('Button Size', 'uipro'),
					'description'   => esc_html__('Set the size for multiple buttons.', 'uipro'),
					'options'       => array(
						'' => __('Default', 'uipro'),
						'small' => __('Small', 'uipro'),
						'large' => __('Large', 'uipro'),
					),
					'default'           => '',
					'start_section' => 'misc',
				),
				array(
					'type'          => Controls_Manager::SWITCHER,
					'name'          => 'grid_width',
					'label'         => esc_html__('Full width button', 'uipro'),
					'label_on' => __( 'Yes', 'uipro' ),
					'label_off' => __( 'No', 'uipro' ),
					'return_value' => 'yes',
					'default' => 'no',
					'start_section' => 'misc',
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
					'default'           => 'small',
					'start_section' => 'misc',
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
					'start_section' => 'misc',
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