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

            add_action( 'elementor/editor/before_enqueue_styles', array($this, 'editor_enqueue_styles') );
            add_action( 'elementor/preview/enqueue_scripts', array($this, 'editor_enqueue_scripts') );
		}

		/**
		 * @return array
		 */
		public function get_options() {

            // Custom fields option
            $custom_fields  = UIPro_UIAdvancedProducts_Helper::get_custom_field_options();

            $store_id   = __METHOD__;
            $store_id  .= '::'.serialize($custom_fields);
            $store_id   = md5($store_id);

            if(isset(static::$cache[$store_id])){
                return static::$cache[$store_id];
            }

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
                    'name'            => 'title_border',
                    'type'          =>  \Elementor\Group_Control_Border::get_type(),
                    'label' => esc_html__( 'Title Border', 'uipro' ),
                    'description'   => esc_html__( 'Title Border.', 'uipro' ),
                    'selector' => '{{WRAPPER}} .inventory-title-search',
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
                    'label_block'   => true,
                ),
                array(
                    'type'          => Controls_Manager::SWITCHER,
                    'id'            => 'uiap_enable_keyword',
                    'label'         => esc_html__( 'Filter By Keyword', 'uipro' ),
                    'default'       => 'yes'
                ),
                array(
                    'type'          => Controls_Manager::SWITCHER,
                    'id'            => 'uiap_enable_label',
                    'label'         => esc_html__( 'Show Label', 'uipro' ),
                    'default'       => 'yes'
                ),
                array(
                    'type'          => Controls_Manager::SWITCHER,
                    'id'            => 'uiap_enable_ajax',
                    'label'         => esc_html__( 'Enable Ajax Search', 'uipro' ),
                    'default'       => 'no'
                ),
                array(
                    'type'          => Controls_Manager::SWITCHER,
                    'id'            => 'uiap_ajax_no_button',
                    'label'         => esc_html__( 'Filtering instantly (no buttons required)', 'uipro' ),
                    'default'       => 'no',
                    'condition'     => array(
                        'uiap_enable_ajax'    => 'yes'
                    ),
                ),
                array(
                    'type'          => Controls_Manager::SWITCHER,
                    'id'            => 'uiap_ajax_update_url',
                    'label'         => esc_html__( 'Update Url', 'uipro' ),
                    'default'       => 'no',
                    'condition'     => array(
                        'uiap_enable_ajax'    => 'yes'
                    ),
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'label_padding',
                    'label'         => esc_html__( 'Label Padding', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .advanced-product-search-form .search-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition'     => array(
                        'uiap_enable_label'    => 'yes'
                    ),
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'label_margin',
                    'label'         => esc_html__( 'Label margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .advanced-product-search-form .search-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition'     => array(
                        'uiap_enable_label'    => 'yes'
                    ),
                ),
                array(
                    'type'          => Controls_Manager::TEXT,
                    'id'            => 'uiap_submit_text',
                    'label'         => esc_html__( 'Submit Text', 'uipro' ),
                    'default'       => esc_html__('Search', 'uipro')
                ),
                array(
                    'type'          => Controls_Manager::ICONS,
                    'id'            => 'uiap_submit_icon',
                    'label'         => esc_html__( 'Submit Icon', 'uipro' ),
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'id'            => 'uiap_submit_icon_position',
                    'label'         => esc_html__( 'Submit Icon Position', 'uipro' ),
                    'options'       => array(
                        'before'    => esc_html__('Before', 'uipro'),
                        'after'     => esc_html__('After', 'uipro')
                    ),
                    'default'       => 'before'
                ),
                array(
                    'name'          => 'uiap_submit_icon_spacing',
                    'label' => esc_html__( 'Icon Spacing', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px'],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 200,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'size' => 5,
                    ],
                    'condition'     => array(
                        'uiap_submit_icon_position'    => 'after'
                    ),
                    'selectors' => [
                        '{{WRAPPER}} .advanced-product-search-form button span' => 'margin-left: {{SIZE}}{{UNIT}};',
                    ],
                ),
                array(
                    'name'          => 'uiap_submit_icon_spacing_right',
                    'label' => esc_html__( 'Icon Spacing', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px'],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 200,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'size' => 5,
                    ],
                    'condition'     => array(
                        'uiap_submit_icon_position'    => 'before'
                    ),
                    'selectors' => [
                        '{{WRAPPER}} .advanced-product-search-form button span' => 'margin-right: {{SIZE}}{{UNIT}};',
                    ],
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
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'form_margin',
                    'label'         => esc_html__( 'Form Margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .advanced-product-search-form' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ),
                array(
                    'name'            => 'form_border',
                    'type'          =>  \Elementor\Group_Control_Border::get_type(),
                    'label' => esc_html__( 'Form Border', 'uipro' ),
                    'selector' => '{{WRAPPER}} .advanced-product-search-form',
                ),
                array(
                    'type'      => Controls_Manager::SLIDER,
                    'name'      => 'form_input_width',
                    'label'     => esc_html__('Form item Width', 'uipro'),
                    'size_units'    => [ 'px', '%' ],
                    'responsive'    =>  true,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 2000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => '%',
                        'size' => 100,
                    ],
                    'selectors' => array(
                        '{{WRAPPER}} .advanced-product-search-form' => 'display:flex; flex-wrap:wrap',
                        '{{WRAPPER}} .advanced-product-search-form .ap-search-item' => 'width: {{SIZE}}{{UNIT}};',
                    )
                ),
                array(
                    'name'            => 'form_input_border',
                    'type'          =>  \Elementor\Group_Control_Border::get_type(),
                    'label' => esc_html__( 'Form Input Border', 'uipro' ),
                    'selector' => '{{WRAPPER}} .advanced-product-search-form .ap-search-item input, {{WRAPPER}} .advanced-product-search-form .ap-search-item select',
                ),
                array(
                    'type'      => Controls_Manager::SLIDER,
                    'name'      => 'form_input_height',
                    'label'     => esc_html__('Form input height', 'uipro'),
                    'size_units'    => [ 'px' ],
                    'responsive'    =>  true,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 50,
                    ],
                    'selectors' => array(
                        '{{WRAPPER}} .advanced-product-search-form .ap-search-item input, {{WRAPPER}} .advanced-product-search-form .ap-search-item select' => 'height: {{SIZE}}{{UNIT}};',
                    )
                ),
                array(
                    'type'      => Controls_Manager::SLIDER,
                    'name'      => 'form_button_width',
                    'label'     => esc_html__('Form Button Width', 'uipro'),
                    'size_units'    => [ 'px', '%' ],
                    'responsive'    =>  true,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 2000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => '%',
                        'size' => 100,
                    ],
                    'selectors' => array(
                        '{{WRAPPER}} .advanced-product-search-form .ap-search-item.ap-search-button' => 'width: {{SIZE}}{{UNIT}};',
                    )
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'form_button_padding',
                    'label'         => esc_html__( 'Button Padding', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .advanced-product-search-form .ap-search-item.ap-search-button .templaza-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important; margin:0 !important;',
                    ],
                ),
                array(
                    'type'      => Controls_Manager::SLIDER,
                    'name'      => 'form_button_height',
                    'label'     => esc_html__('Form button height', 'uipro'),
                    'size_units'    => [ 'px' ],
                    'responsive'    =>  true,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 50,
                    ],
                    'selectors' => array(
                        '{{WRAPPER}} .advanced-product-search-form .ap-search-item button' => 'height: {{SIZE}}{{UNIT}}; line-height: 1em;',
                    )
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'form_input_margin',
                    'label'         => esc_html__( 'Form item Margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .advanced-product-search-form .ap-search-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important; margin:0 !important;',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'form_button_margin',
                    'label'         => esc_html__( 'Form Button Margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .advanced-product-search-form .ap-search-item.ap-search-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                        '{{WRAPPER}} .advanced-product-search-form .ap-search-item.ap-search-button button' => 'margin: 0 !important;',
                    ],
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
                    'type'          => Group_Control_Typography::get_type(),
                    'name'          => 'label_typography',
                    'scheme'        => Typography::TYPOGRAPHY_1,
                    'label'         => esc_html__('Label Font', 'uipro'),
                    'description'   => esc_html__('Select a font family for label.', 'uipro'),
                    'selector'      => '{{WRAPPER}} .advanced-product-search-form .search-label',
                    'condition'     => array(
                        'uiap_enable_label'    => 'yes'
                    ),
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
                    'name'          => 'label_color',
                    'label'         => esc_html__('Label Color', 'uipro'),
                    'description'   => esc_html__('Set the color of label.', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .advanced-product-search-form .search-label' => 'color: {{VALUE}}',
                    ],
                    'condition'     => array(
                        'uiap_enable_label'    => 'yes'
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
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'form_bg_input',
                    'label'         => esc_html__('Input background Color', 'uipro'),
                    'description'   => esc_html__('Set the background color of input form.', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .advanced-product-search-form .ap-search-item input' => 'background-color: {{VALUE}}',
                        '{{WRAPPER}} .advanced-product-search-form .ap-search-item select' => 'background-color: {{VALUE}}',
                    ],
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'form_color_input',
                    'label'         => esc_html__('Input Color', 'uipro'),
                    'description'   => esc_html__('Set the color of input form.', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .advanced-product-search-form .ap-search-item input' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .advanced-product-search-form .ap-search-item select' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .advanced-product-search-form .ap-search-item select option' => 'color: {{VALUE}}',
                    ],
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'form_bg_button',
                    'label'         => esc_html__('Button background Color', 'uipro'),
                    'description'   => esc_html__('Set the background color of Button form.', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .advanced-product-search-form .ap-search-item.ap-search-button .templaza-btn' => 'background-color: {{VALUE}}',
                    ],
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'form_color_button',
                    'label'         => esc_html__('Button Color', 'uipro'),
                    'description'   => esc_html__('Set the color of Button form.', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .advanced-product-search-form .ap-search-item.ap-search-button .templaza-btn' => 'color: {{VALUE}}',
                    ],
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'form_bg_button_hover',
                    'label'         => esc_html__('Hover Button background Color', 'uipro'),
                    'description'   => esc_html__('Set the hover background color of Button form.', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .advanced-product-search-form .ap-search-item.ap-search-button .templaza-btn:hover' => 'background-color: {{VALUE}}',
                    ],
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'form_color_button_hover',
                    'label'         => esc_html__('Hover Button Color', 'uipro'),
                    'description'   => esc_html__('Set the hover color of Button form.', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .advanced-product-search-form .ap-search-item.ap-search-button .templaza-btn:hover' => 'color: {{VALUE}}',
                    ],
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'form_bg_button_overlay',
                    'label'         => esc_html__('Button Overlay Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .advanced-product-search-form .ap-search-button button:before' => 'background-color: {{VALUE}}',
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

//        public function get_scripts() {
//            return array(
//                'ui-advanced-product-filter' => array(
//                    'src'   =>  'script.min.js',
//                    'deps'  =>  array('jquery','elementor-frontend')
//                )
//            );
//        }

        public function editor_enqueue_scripts(){
            wp_register_script( 'ui-advanced-products-filter-editor',
                plugins_url( 'assets/js/editor.min.js', __FILE__ ), array('jquery'));
            wp_enqueue_script('ui-advanced-products-filter-editor');
        }

        public function editor_enqueue_styles(){
            wp_register_style( 'ui-advanced-products-filter-editor',
                plugins_url( 'assets/css/editor.css', __FILE__ ) );
            wp_enqueue_style('ui-advanced-products-filter-editor');
        }
	}
}