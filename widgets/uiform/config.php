<?php
/**
 * UIPro Form config class
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

if ( ! class_exists( 'UIPro_Config_UIForm' ) ) {
	/**
	 * Class UIPro_Config_UIForm
	 */
	class UIPro_Config_UIForm extends UIPro_Abstract_Config {

		/**
		 * UIPro_Config_UIForm constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'uiform';
			self::$name = esc_html__( 'TemPlaza: UI Form', 'uipro' );
			self::$desc = esc_html__( 'Add UI Form.', 'uipro' );
			self::$icon = 'eicon-envelope';
			self::$assets_path  =   plugin_dir_url(__FILE__). 'assets/';
			parent::__construct();

            add_action( 'elementor/editor/before_enqueue_styles', array($this, 'editor_enqueue_styles') );
		}

		/**
		 * @return array
		 */
		public function get_options() {

            $store_id   = md5(__METHOD__);

            if(isset(static::$cache[$store_id])){
                return static::$cache[$store_id];
            }
            $arr_wpform = array();
            if(function_exists('wpforms')){
                $args = array(
                    'numberposts' => -1,
                    'post_type'   => 'wpforms'
                );

                $wpforms = get_posts( $args );
                if ( $wpforms ) {
                    foreach ( $wpforms as $post ){
                        $arr_wpform[$post->ID] = $post->post_title;
                    }
                }
                $arr_wpform['custom'] = esc_html__('Custom','baressco');
            }

			// options
			$options = array(
                array(
                    'type'          => Controls_Manager::SELECT,
                    'id'            => 'uiform_form',
                    'label'         => esc_html__( 'Choose Form', 'uipro' ),
                    'options'       => $arr_wpform,
                ),
                array(
                    'type'          => Controls_Manager::TEXT,
                    'name'          => 'uiform_custom',
                    'label'         => esc_html__( 'Custom Form', 'uipro' ),
                    'description'   => esc_html__( 'Enter Form Shortcode ', 'uipro' ),
                    'condition'     => array(
                        'uiform_form'    => 'custom'
                    ),
                ),
                array(
                    'name'          => 'form_style',
                    'label' => esc_html__( 'Form Style', 'uipro' ),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => 'block',
                    'options' => [
                        'block' => esc_html__('Block', 'uipro' ),
                        'inline' => esc_html__('Inline', 'uipro') ,
                    ],
                ),
                array(
                    'type'      => Controls_Manager::SLIDER,
                    'name'      => 'form_input_height',
                    'label'     => esc_html__('Input Height', 'uipro'),
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
                        '{{WRAPPER}} .wpforms-form input, {{WRAPPER}} .wpforms-form select' => 'height: {{SIZE}}{{UNIT}} !important; line-height: {{SIZE}}{{UNIT}} !important;',
                    )
                ),
                array(
                    'label' => esc_html__( 'Input Border', 'uipro' ),
                    'name'          => 'input_border',
                    'type' => \Elementor\Group_Control_Border::get_type(),
                    'selector' => '{{WRAPPER}} .wpforms-form input, {{WRAPPER}} .wpforms-form select, {{WRAPPER}} form textarea',
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'input_radius',
                    'label'         => esc_html__( 'Input Border radius', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .wpforms-form input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'form_input_margin',
                    'label'         => esc_html__( 'Form item Margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .wpforms-field-container .wpforms-field' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important; padding:0 !important;',
                    ],
                ),
                array(
                    'type'      => Controls_Manager::SLIDER,
                    'name'      => 'form_button_height_custom',
                    'label'     => esc_html__('Button Height', 'uipro'),
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
                    'selectors'     => [
                        '.templaza-section {{WRAPPER}} .wpforms-container form button.wpforms-submit, {{WRAPPER}} form input[type="button"]' => 'height: {{SIZE}}{{UNIT}} !important;',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'button_padding',
                    'label'         => esc_html__( 'Button Padding', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '.templaza-section {{WRAPPER}} .wpforms-container form button.wpforms-submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ),
                array(
                    'label' => esc_html__( 'Button Border', 'uipro' ),
                    'name'          => 'button_border',
                    'type' => \Elementor\Group_Control_Border::get_type(),
                    'selector' => '.templaza-section {{WRAPPER}} .wpforms-container form button.wpforms-submit, {{WRAPPER}} form input[type="button"]',
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'button_radius',
                    'label'         => esc_html__( 'Button Border radius', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .wpforms-form button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;',
                    ],
                ),
                array(
                    'type'          => Group_Control_Typography::get_type(),
                    'name'          => 'input_typography',
                    'scheme'        => Typography::TYPOGRAPHY_1,
                    'label'         => esc_html__('Input Font', 'uipro'),
                    'description'   => esc_html__('Select a font family', 'uipro'),
                    'selector'      => '{{WRAPPER}} form input, {{WRAPPER}} form select, {{WRAPPER}} form textarea ',
                    'start_section' => 'style',
                    'section_tab'   => Controls_Manager::TAB_STYLE,
                    'section_name'  => esc_html__( self::$name, 'uipro' ),
                ),
                array(
                    'type'          => Group_Control_Typography::get_type(),
                    'name'          => 'button_typography',
                    'scheme'        => Typography::TYPOGRAPHY_1,
                    'label'         => esc_html__('Button Font', 'uipro'),
                    'description'   => esc_html__('Select a font family', 'uipro'),
                    'selector'      => '{{WRAPPER}} form button, {{WRAPPER}} form input[type="button"], {{WRAPPER}} form input[type="submit"]',
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'input_color',
                    'label'         => esc_html__('Input Color', 'uipro'),
                    'description'   => esc_html__('Set the color of input.', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} form input, {{WRAPPER}} form select, {{WRAPPER}} form textarea ' => 'color: {{VALUE}} !important;',
                    ],
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'input_bg_color',
                    'label'         => esc_html__('Input Background Color', 'uipro'),
                    'description'   => esc_html__('Set the background color of input.', 'uipro'),
                    'selectors' => [
                        'body {{WRAPPER}} div.wpforms-container-full form input, {{WRAPPER}} form select, {{WRAPPER}} form textarea ' => 'background-color: {{VALUE}} !important;',
                    ],
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'button_background',
                    'label'         => esc_html__('Button Background Color', 'uipro'),
                    'description'   => esc_html__('Set the background color of button.', 'uipro'),
                    'selectors' => [
                        '.templaza-section {{WRAPPER}} .wpforms-container form button.wpforms-submit:not(:hover), {{WRAPPER}} form input[type="button"], {{WRAPPER}} form input[type="submit"] ' => 'background-color: {{VALUE}}!important;',
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

        public function editor_enqueue_styles(){
            wp_register_style( 'ui-form',
                plugins_url( 'assets/css/editor.css', __FILE__ ) );
            wp_enqueue_style('ui-form');
        }
	}
}