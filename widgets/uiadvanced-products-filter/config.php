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

//require_once __DIR__.'/helper.php';

if ( ! class_exists( 'UIPro_Config_UIAdvanced_Products_Filter' ) ) {
	/**
	 * Class UIPro_Config_UIPosts
	 */
	class UIPro_Config_UIAdvanced_Products_Filter extends UIPro_Abstract_Config {

		/**
		 * UIPro_Config_Heading constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'uiadvanced-products-filter';
			self::$name = esc_html__( 'TemPlaza: UI Advanced Products Filter', 'uipro' );
			self::$desc = esc_html__( 'Add UI Advanced Products Filter Box.', 'uipro' );
			self::$icon = 'eicon-posts-grid';
			self::$assets_path  =   plugin_dir_url(__FILE__). 'assets/';
			parent::__construct();
		}

		/**
		 * @return array
		 */
		public function get_options() {

            // Custom fields option
            $custom_fields  = UIPro_UIAdvancedProducts_Helper::get_custom_field_options();

			// options
			$options = array(
                array(
                    'type'          => Controls_Manager::TEXT,
                    'name'          => 'title',
                    'label'         => esc_html__( 'Title', 'uipro' ),
                    'default'       => esc_html__('Inventory Search', 'uipro'),
                    'description'   => esc_html__( 'Write the title for Search form.', 'uipro' ),
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'title_display',
                    'label'         => esc_html__( 'Title display', 'uipro' ),
                    'options'       => array(
                        'uk-display-inline'       => esc_html__( 'Inline', 'uipro' ),
                        'uk-display-block'        => esc_html__( 'Block', 'uipro' ),
                        'uk-display-inline-block' => esc_html__( 'Inline Block', 'uipro' ),
                    ),
                    'default'       => 'uk-display-block',
                    'condition'     => array(
                        'title!'    => ''
                    ),
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'title_padding',
                    'label'         => esc_html__( 'Title Padding', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .inventory-title-search' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition'     => array(
                        'title!'    => ''
                    ),
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'title_margin',
                    'label'         => esc_html__( 'Title Margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .inventory-title-search' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition'     => array(
                        'title!'    => ''
                    ),
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
                ),
                array(
                    'type'          => Controls_Manager::SELECT2,
                    'id'            => 'uiap_custom_fields',
                    'label'         => esc_html__( 'Select Custom Field', 'uipro' ),
                    'options'       => $custom_fields,
                    'multiple'      => true,
                ),
                array(
                    'type'          => Controls_Manager::SWITCHER,
                    'id'            => 'uiap_enable_keyword',
                    'label'         => esc_html__( 'Filter By Keyword', 'uipro' ),
                    'default'       => 'yes'
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'form_padding',
                    'label'         => esc_html__( 'Form Padding', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .advanced-product-search-form' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ),
                array(
                    'name'            => 'form_border',
                    'type'          =>  \Elementor\Group_Control_Border::get_type(),
                    'label' => esc_html__( 'Form Border', 'uipro' ),
                    'selector' => '{{WRAPPER}} .advanced-product-search-form',
                ),
                array(
                    'type'          => Group_Control_Typography::get_type(),
                    'name'          => 'title_typography',
                    'scheme'        => Typography::TYPOGRAPHY_1,
                    'label'         => esc_html__('Title Font', 'uipro'),
                    'description'   => esc_html__('Select a font family, font size for the addon title.', 'uipro'),
                    'selector'      => '{{WRAPPER}} .inventory-title-search',
                    'condition'     => array(
                        'title!'    => ''
                    ),
                    'start_section' => 'style',
                    'section_tab'   => Controls_Manager::TAB_STYLE,
                    'section_name'  => esc_html__( self::$name, 'uipro' ),
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'title_color',
                    'label'         => esc_html__('Title Color', 'uipro'),
                    'description'   => esc_html__('Set the color of title.', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .inventory-title-search' => 'color: {{VALUE}}',
                    ],
                    'condition'     => array(
                        'title!'    => ''
                    ),
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'title_bg_color',
                    'label'         => esc_html__('Title background Color', 'uipro'),
                    'description'   => esc_html__('Set the background color of title.', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .inventory-title-search' => 'background-color: {{VALUE}}',
                    ],
                    'condition'     => array(
                        'title!'    => ''
                    ),
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'form_bg_color',
                    'label'         => esc_html__('Form background Color', 'uipro'),
                    'description'   => esc_html__('Set the background color of form.', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .advanced-product-search-form' => 'background-color: {{VALUE}}',
                    ],
                ),
			) ;
			return array_merge($options, $this->get_general_options());
		}

		public function get_template_name() {
			return 'base';
		}
	}
}