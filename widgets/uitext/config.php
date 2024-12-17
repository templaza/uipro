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


if ( ! class_exists( 'UIPro_Config_UIText' ) ) {
	/**
	 * Class UIPro_Config_UIText
	 */
	class UIPro_Config_UIText extends UIPro_Abstract_Config {

		/**
		 * UIPro_Config_Heading constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'uitext';
			self::$name = esc_html__( 'TemPlaza: UI Text', 'uipro' );
			self::$desc = esc_html__( 'Add UI Text Box.', 'uipro' );
			self::$icon = 'eicon-t-letter-bold';
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
					'type'          => Controls_Manager::TEXTAREA,
					'name'          => 'title',
					'label'         => esc_html__( 'Title', 'uipro' ),
					'default'       => __('Your Heading Text Here', 'uipro'),
					'description'   => esc_html__( 'Write the title for the heading.', 'uipro' ),
					'dynamic'       => [
						'active'    => true,
					],
					/* vc */
					'admin_label'   => true,
				),
				array(
					'type'          => Controls_Manager::SELECT,
					'name'          => 'title_tag',
					'label'         => esc_html__( 'Title tag', 'uipro' ),
					'options'       => array(
						'h1'        => 'h1',
						'h2'        => 'h2',
						'h3'        => 'h3',
						'h4'        => 'h4',
						'h5'        => 'h5',
						'h6'        => 'h6',
						'div'       => 'div',
						'span'      => 'span',
						'p'         => 'p',
					),
					'default'       => 'h3',
					'description'   => esc_html__( 'Choose heading element.', 'uipro' ),
					'condition'     => array(
						'title!'    => ''
					),
					/* vc */
					'admin_label' => false,
				),
				array(
					'type'          => Group_Control_Typography::get_type(),
					'name'          => 'title_typography',
					'label'         => esc_html__('Title Font', 'uipro'),
					'description'   => esc_html__('Select a font family, font size for the addon title.', 'uipro'),
					'selector'      => '{{WRAPPER}} .ui-text .ui-text-title',
					'condition'     => array(
						'title!'    => ''
					),
				),
				array(
					'type'          =>  Controls_Manager::COLOR,
					'name'          => 'title_color',
					'label'         => esc_html__('Title Color', 'uipro'),
					'description'   => esc_html__('Set the color of title.', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .ui-text .ui-text-title' => 'color: {{VALUE}}',
					],
					'condition'     => array(
						'title!'    => ''
					),
				),
				array(
					'type'          => Controls_Manager::SELECT,
					'name'          => 'title_heading_style',
					'default'       => '',
					'label'         => esc_html__('Style', 'uipro'),
					'description'   => esc_html__('Heading styles differ in font-size but may also come with a predefined color, size and font', 'uipro'),
					'options'       => array(
						''                  => esc_html__('None', 'uipro'),
						'heading-2xlarge'   => esc_html__('2XLarge', 'uipro'),
						'heading-xlarge'    => esc_html__('XLarge', 'uipro'),
						'heading-large'     => esc_html__('Large', 'uipro'),
						'heading-medium'    => esc_html__('Medium', 'uipro'),
						'heading-small'     => esc_html__('Small', 'uipro'),
						'h1'                => esc_html__('H1', 'uipro'),
						'h2'                => esc_html__('H2', 'uipro'),
						'h3'                => esc_html__('H3', 'uipro'),
						'h4'                => esc_html__('H4', 'uipro'),
						'h5'                => esc_html__('H5', 'uipro'),
						'h6'                => esc_html__('H6', 'uipro'),
					),
					'condition'     => array(
						'title!'    => ''
					),
				),
				array(
					'type'          => Controls_Manager::SELECT,
					'name'          => 'title_heading_extra_style',
					'default'       => '',
					'label'         => esc_html__('Extra Style', 'uipro'),
					'description'   => esc_html__('Heading extra styles differ in font-size but may also come with a predefined color, size and font', 'uipro'),
					'options'       => array(
						''          => esc_html__('None', 'uipro'),
						'divider'   => esc_html__('Divider', 'uipro'),
						'bullet'    => esc_html__('Bullet', 'uipro'),
						'line'      => esc_html__('Line', 'uipro'),
					),
					'condition'     => array(
						'title!'    => ''
					),
				),
				array(
					'type'          =>  Controls_Manager::SELECT,
					'name'          => 'title_heading_margin',
					'label'         => esc_html__('Title Margin', 'uipro'),
					'description'   => esc_html__('Set the vertical margin for title.', 'uipro'),
					'options'       => array(
						''          => esc_html__('Inherit', 'uipro'),
						'default'   => esc_html__('Default', 'uipro'),
						'small'     => esc_html__('Small', 'uipro'),
						'medium'    => esc_html__('Medium', 'uipro'),
						'large'     => esc_html__('Large', 'uipro'),
						'xlarge'    => esc_html__('X-Large', 'uipro'),
						'remove'    => esc_html__('None', 'uipro'),
					),
					'default'       => '',
					'condition'     => array(
						'title!'    => ''
					),
				),
				//Sub Title Settings
				array(
					'type'          => Controls_Manager::TEXTAREA,
					'name'          => 'sub_title',
					'label'         => esc_html__( 'Sub Title', 'uipro' ),
					'placeholder'       => __('Your Sub Heading Text Here', 'uipro'),
					'description'   => esc_html__( 'Write the title for the sub heading.', 'uipro' ),
					'dynamic'       => [
						'active'    => true,
					],
					'separator'     => 'before',
					/* vc */
					'admin_label'   => true,
				),
				array(
					'type'          => Controls_Manager::SELECT,
					'name'          => 'sub_title_tag',
					'label'         => esc_html__( 'Title tag', 'uipro' ),
					'options'       => array(
						'h1'        => 'h1',
						'h2'        => 'h2',
						'h3'        => 'h3',
						'h4'        => 'h4',
						'h5'        => 'h5',
						'h6'        => 'h6',
						'div'       => 'div',
						'span'      => 'span',
						'p'         => 'p',
						'lead'      => 'lead',
						'meta'      => 'meta'
					),
					'default'       => 'lead',
					'description'   => esc_html__( 'Choose sub heading element.', 'uipro' ),
					'condition'     => array(
						'sub_title!'    => ''
					),
					/* vc */
					'admin_label' => false,
				),
				array(
					'type'          => Group_Control_Typography::get_type(),
					'name'          => 'sub_title_typography',
					'label'         => esc_html__('Sub Title Font', 'uipro'),
					'description'   => esc_html__('Select a font family, font size for the addon content.', 'uipro'),
					'selector'      => '{{WRAPPER}} .ui-text .ui-text-subtitle',
					'condition'     => array(
						'sub_title!'    => ''
					),
				),
				array(
					'type'          =>  Controls_Manager::COLOR,
					'name'          => 'sub_title_color',
					'label'         => esc_html__('Sub Title Color', 'uipro'),
					'description'   => esc_html__('Set the color of sub title.', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .ui-text .ui-text-subtitle' => 'color: {{VALUE}}',
					],
					'condition'     => array(
						'sub_title!'    => ''
					),
				),
				array(
					'type'          =>  Controls_Manager::SELECT,
					'name'          => 'sub_title_margin',
					'label'         => esc_html__('Sub Title Margin', 'uipro'),
					'description'   => esc_html__('Set the vertical margin for sub title.', 'uipro'),
					'options'       => array(
						''          => esc_html__('Inherit', 'uipro'),
						'default'   => esc_html__('Default', 'uipro'),
						'small'     => esc_html__('Small', 'uipro'),
						'medium'    => esc_html__('Medium', 'uipro'),
						'large'     => esc_html__('Large', 'uipro'),
						'xlarge'    => esc_html__('X-Large', 'uipro'),
						'remove'    => esc_html__('None', 'uipro'),
					),
					'default'       => '',
					'condition'     => array(
						'sub_title!'    => ''
					),
				),
				//Content Settings
				array(
					'name'          => 'text',
					'label'         => esc_html__('Content', 'uipro'),
					'type' => Controls_Manager::WYSIWYG,
					'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras in semper sem. Praesent elit erat, suscipit sed varius ut, porta sit amet lorem. Duis eget vulputate turpis. Vivamus maximus ac nisl vel suscipit. Donec felis lacus, tristique in ante nec, varius ultrices felis. Quisque eget tellus magna. Sed hendrerit odio sit amet risus lobortis lobortis.', 'uipro' ),
					'placeholder' => __( 'Type your description here', 'uipro' ),
					'separator'     => 'before',
				),
				array(
					'type'          => Group_Control_Typography::get_type(),
					'name'          => 'text_typography',
					'label'         => esc_html__('Content Font', 'uipro'),
					'description'   => esc_html__('Select a font family, font size for the addon content.', 'uipro'),
					'selector'      => '{{WRAPPER}} .ui-text .ui-text-desc',
					'condition'     => array(
						'text!'    => ''
					),
				),
				array(
					'type'          =>  Controls_Manager::COLOR,
					'name'          => 'text_color',
					'label'         => esc_html__('Text Color', 'uipro'),
					'description'   => esc_html__('Set the color of content.', 'uipro'),
					'selectors' => [
						'{{WRAPPER}} .ui-text .ui-text-desc' => 'color: {{VALUE}}',
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