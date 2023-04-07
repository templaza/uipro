<?php
/**
 * UIPro Advanced Product Slideshow config class
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
require_once plugin_dir_path( __DIR__ ).'uiadvancedproducts/helper.php';
if ( ! class_exists( 'UIPro_Config_Uiadvancedproduct_Slideshow' ) ) {
	/**
	 * Class UIPro_Config_Uiadvancedproduct_Slideshow
	 */
	class UIPro_Config_Uiadvancedproduct_Slideshow extends UIPro_Abstract_Config {

		/**
		 * UIPro_Config_Uiadvancedproduct_Slideshow constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'uiadvancedproduct-slideshow';
			self::$name = esc_html__( 'TemPlaza: Advanced Product Slideshow', 'uipro' );
			self::$desc = esc_html__( 'Display products Slideshow.', 'uipro' );
			self::$icon = 'eicon-post-slider';
            self::$assets_path  =   plugin_dir_url(__FILE__). 'assets/';
			parent::__construct();

		}
        public function get_styles() {
            return array(
                'templaza-tiny-style' => array(
                    'src'   =>  'tiny-slider.css'
                )
            );
        }
        public function get_scripts() {
            return array(
                'templaza-tiny-script' => array(
                    'src'   =>  'tiny-slider.js',
                    'deps'  =>  array('jquery')
                )
            );
        }

		/**
		 * @return array
		 */

        public function get_options() {

        $categories = UIPro_UIAdvancedProducts_Helper::get_custom_categories();
        // Custom fields option
        $custom_fields  = UIPro_UIAdvancedProducts_Helper::get_custom_field_options();


        $store_id   = md5(__METHOD__);

        if(isset(static::$cache[$store_id])){
            return static::$cache[$store_id];
        }
            $arr_fields = array();
            if(is_plugin_active( 'advanced-product/advanced-product.php' )) {
                $args = array(
                    'numberposts' => -1,
                    'post_type'   => 'ap_custom_field'
                );

                $wpfields = get_posts( $args );
                if ( $wpfields ) {
                    foreach ( $wpfields as $post ){
                        $arr_fields[$post->post_excerpt] = $post->post_title;
                    }
                    wp_reset_postdata();
                }
            }
        $options    = array(
            array(
                'type'          => Controls_Manager::SELECT,
                'name'          => 'layout',
                'show_label'    => true,
                'label'         => esc_html__( 'Slideshow Layout', 'uipro' ),
                'options'       => array(
                    'base'      => esc_html__( 'Default', 'uipro' ),
                    'style1'   => esc_html__( 'Style 1', 'uipro' ),
                ),
                'default'       => 'base',
            ),
            array(
                'type'          => Controls_Manager::SELECT,
                'name'          => 'ap_product_source',
                'show_label'    => true,
                'label'         => esc_html__( 'Product Source', 'uipro' ),
                'options'       => array(
                    'default'      => esc_html__( 'Default', 'uipro' ),
                    'custom'   => esc_html__( 'Custom', 'uipro' ),
                ),
                'default'       => 'default',
            ),
            array(
                'type'          => Controls_Manager::SELECT2,
                'id'            => 'ap_product_branch',
                'label'         => esc_html__( 'Select Branch', 'uipro' ),
                'options'       => UIPro_Helper::get_cat_taxonomy( 'ap_branch' ),
                'multiple'      => true,
                'condition'     => array(
                    'ap_product_source!'    => 'custom'
                ),
            ),
            array(
                'type'          => Controls_Manager::SELECT2,
                'id'            => 'ap_product_category',
                'label'         => esc_html__( 'Select Category', 'uipro' ),
                'options'       => UIPro_Helper::get_cat_taxonomy( 'ap_category' ),
                'multiple'      => true,
                'condition'     => array(
                    'ap_product_source!'    => 'custom'
                ),
            ),
        );

        if(!empty($categories) && count($categories)){
            foreach ($categories as $cat){
                $slug           = get_post_meta($cat -> ID, 'slug', true);

                if(!taxonomy_exists($slug)){
                    continue;
                }

                $cat_options    = UIPro_Helper::get_cat_taxonomy( $slug );
                if(empty($cat_options) || !count($cat_options)){
                    continue;
                }
                $options[]      = array(
                    'type'          => Controls_Manager::SELECT2,
                    'id'            => 'ap_product_'.$slug,
                    'label'         => sprintf(esc_html__( 'Select %s', 'uipro' ), $cat -> post_title),
                    'options'       => $cat_options,
                    'multiple'      => true,
                    'condition'     => array(
                        'ap_product_source!'    => 'custom'
                    ),
                );
            }
        }

        // Custom fields option

        $options[]      = array(
            'type'          => Controls_Manager::SELECT2,
            'id'            => 'uiap_custom_fields',
            'label'         => esc_html__( 'Select Custom Field', 'uipro' ),
            'options'       => $custom_fields,
            'multiple'      => true,
            'condition'     => array(
                'ap_product_source!'    => 'custom'
            ),
        );

            $repeater = new \Elementor\Repeater();
            $repeater->add_control(
                'ap_products', [
                    'type'          => 'uiautocomplete',
                    'label_block' => true,
                    'multiple'    => true,
                    'source'      => 'ap_product',
                    'sortable'    => true,
                    'placeholder' => esc_html( 'Click here and start typing...', 'uipro' ),
                ]
            );
            $repeater->add_control(
                'image',
                [
                    'type'          =>  Controls_Manager::MEDIA,
                    'label'         => esc_html__('Select Image:', 'uipro'),
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                ]
            );
            $repeater->add_control(
                'ap_description', [
                    'label' => esc_html__( 'Product Description', 'uipro' ),
                    'type' => \Elementor\Controls_Manager::WYSIWYG,
                    'default' => esc_html__( '' , 'uipro' ),
                    'label_block' => true,
                ]
            );
            $repeater->add_control(
                'ap_text_meta', [
                    'label' => esc_html__( 'Meta text', 'uipro' ),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => esc_html__( '' , 'uipro' ),
                    'label_block' => true,
                ]
            );
            $repeater->add_control(
                'ap_text_custom', [
                    'label' => esc_html__( 'Custom text', 'uipro' ),
                    'type' => \Elementor\Controls_Manager::WYSIWYG,
                    'default' => esc_html__( '' , 'uipro' ),
                    'label_block' => true,

                ]
            );

            // options
            $options = array_merge($options,array(
                array(
                    'type'          => Controls_Manager::SWITCHER,
                    'id'            => 'include_subcagories',
                    'label'         => esc_html__('Include subcagories', 'uipro'),
                    'description'   => esc_html__( 'Select yes to include sub categories', 'uipro' ),
                    'label_on' => esc_html__( 'Yes', 'uipro' ),
                    'label_off' => esc_html__( 'No', 'uipro' ),
                    'return_value' => '1',
                    'default' => '0',
                    'condition'     => array(
                        'ap_product_source!'    => 'custom'
                    ),
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'id'            => 'ordering',
                    'label'         => esc_html__( 'Ordering', 'uipro' ),
                    'options'       => array(
                        'latest'    => esc_html__('Latest', 'uipro'),
                        'oldest'    => esc_html__('Oldest', 'uipro'),
                        'popular'   => esc_html__('Popular', 'uipro'),
                        'sticky'   => esc_html__('Sticky Only', 'uipro'),
                        'random'    => esc_html__('Random', 'uipro'),
                    ),
                    'default'       => 'latest',
                    'description'   => esc_html__( 'Select Product ordering from the list.', 'uipro' ),
                    'condition'     => array(
                        'ap_product_source!'    => 'custom'
                    ),
                ),
                array(
                    'type'          => Controls_Manager::NUMBER,
                    'id'            => 'limit',
                    'label'         => esc_html__( 'Limit', 'uipro' ),
                    'description'   => esc_html__( 'Set the number of articles you want to display.', 'uipro' ),
                    'min' => 1,
                    'max' => 90,
                    'step' => 1,
                    'default' => 3,
                    'condition'     => array(
                        'ap_product_source!'    => 'custom'
                    ),
                ),
                array(
                    'type'      => Controls_Manager::REPEATER,
                    'name'      => 'ap_products_custom',
                    'label'     => esc_html__( 'Product Items', 'uipro' ),
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'title' => 'Item',
                        ],
                    ],
                    'title_field' => __( 'Item', 'uipro' ),
                    'condition'     => array(
                        'ap_product_source'    => 'custom'
                    ),
                ),
                array(
                    'type'          => Controls_Manager::SELECT2,
                    'id'            => 'custom_fields',
                    'label'         => esc_html__( 'Custom Fields', 'uipro' ),
                    'options'       => $arr_fields,
                    'multiple'      => true,
                ),
                array(
                    'type'          => Controls_Manager::SELECT2,
                    'id'            => 'custom_fields_bottom',
                    'label'         => esc_html__( 'Custom Fields in Bottom', 'uipro' ),
                    'options'       => $arr_fields,
                    'multiple'      => true,
                    'condition'     => array(
                        'layout'    => 'style1'
                    ),
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'id'            => 'ap_style1_container',
                    'label'         => esc_html__( 'Container Content', 'uipro' ),
                    'options'       => array(
                        'boxed'    => esc_html__('Boxed', 'uipro'),
                        'full_width'    => esc_html__('Full Width', 'uipro'),
                    ),
                    'default'       => 'boxed',
                    'description'   => esc_html__( 'Select container content.', 'uipro' ),
                    'condition'     => array(
                        'layout'    => 'style1'
                    ),
                    'start_section' => 'ap-slideshow-box',
                    'section_name'      => esc_html__('Slideshow Box Settings', 'uipro')
                ),

                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'slideshow_padding',
                    'label'         => esc_html__( 'Slideshow Padding', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px','%'],
                    'selectors'     => [
                        '{{WRAPPER}} .ap_slideshow' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'slideshow_info_padding',
                    'label'         => esc_html__( 'Info Box Padding', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px','%'],
                    'selectors'     => [
                        '{{WRAPPER}} .ap-slideshow-info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'slideshow_image_padding',
                    'label'         => esc_html__( 'Image Box Padding', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px','%'],
                    'selectors'     => [
                        '{{WRAPPER}} .ap-slideshow-image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'layout', 'operator' => 'in', 'value' => ['base']],
                        ],
                    ],
                ),

                array(
                    'type'          => Group_Control_Typography::get_type(),
                    'name'          => 'title_typography',
                    'scheme'        => Typography::TYPOGRAPHY_1,
                    'label'         => esc_html__('Title Font', 'uipro'),
                    'description'   => esc_html__('Select a font family, font size for the addon title.', 'uipro'),
                    'selector'      => '{{WRAPPER}} .ap-slideshow-title',
                    'start_section' => 'ap-title',
                    'section_name'      => esc_html__('Title Settings', 'uipro')
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'title_color',
                    'label'         => esc_html__('Title Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ap-slideshow-title' => 'color: {{VALUE}}',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'custom_fields_margin',
                    'label'         => esc_html__( 'Custom Fields margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px'],
                    'selectors'     => [
                        '{{WRAPPER}} .ap-single-top-fields' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'start_section' => 'ap-custom-fields',
                    'section_name'      => esc_html__('Custom Fields Settings', 'uipro')
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'custom_fields_padding',
                    'label'         => esc_html__( 'Custom Fields Padding', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px'],
                    'selectors'     => [
                        '{{WRAPPER}} .ap-single-top-fields' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ),
                array(
                    'type'          =>  \Elementor\Group_Control_Border::get_type(),
                    'name'          => 'custom_fields_border',
                    'label'         => esc_html__('Custom Fields Border', 'uipro'),
                    'selector' => '{{WRAPPER}} .ap-single-top-fields',
                ),
                array(
                    'type'          => Group_Control_Typography::get_type(),
                    'name'          => 'field_label_typography',
                    'scheme'        => Typography::TYPOGRAPHY_1,
                    'label'         => esc_html__('Field Label Font', 'uipro'),
                    'selector'      => '{{WRAPPER}} .ap-field-label',
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'field_label_color',
                    'label'         => esc_html__('Label Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ap-field-label' => 'color: {{VALUE}}',
                    ],
                ),
                array(
                    'type'          => Group_Control_Typography::get_type(),
                    'name'          => 'field_value_typography',
                    'scheme'        => Typography::TYPOGRAPHY_1,
                    'label'         => esc_html__('Field Value Font', 'uipro'),
                    'selector'      => '{{WRAPPER}} .ap-field-value',
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'field_value_color',
                    'label'         => esc_html__('Value Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ap-field-value' => 'color: {{VALUE}}',
                    ],
                ),
                array(
                    'type'          => Group_Control_Typography::get_type(),
                    'name'          => 'desc_typography',
                    'scheme'        => Typography::TYPOGRAPHY_1,
                    'label'         => esc_html__('Description Font', 'uipro'),
                    'selector'      => '{{WRAPPER}} .ap-single-desc',
                    'start_section' => 'ap-desc',
                    'section_name'      => esc_html__('Description Settings', 'uipro')
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'desc_color',
                    'label'         => esc_html__('Description Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ap-single-desc' => 'color: {{VALUE}}',
                    ],
                ),
                array(
                    'type'          => Group_Control_Typography::get_type(),
                    'name'          => 'custom_meta_desc_typography',
                    'scheme'        => Typography::TYPOGRAPHY_1,
                    'label'         => esc_html__('Custom Meta Description Font', 'uipro'),
                    'selector'      => '{{WRAPPER}} .ap-custom-meta',
                    'start_section' => 'ap-desc-custom',
                    'section_name'      => esc_html__('Custom Description Settings', 'uipro')
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'custom_meta_desc_color',
                    'label'         => esc_html__('Custom Meta Description Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ap-custom-meta' => 'color: {{VALUE}}',
                    ],
                ),
                array(
                    'type'          => Group_Control_Typography::get_type(),
                    'name'          => 'custom_desc_typography',
                    'scheme'        => Typography::TYPOGRAPHY_1,
                    'label'         => esc_html__('Custom Description Font', 'uipro'),
                    'selector'      => '{{WRAPPER}} .ap-custom-desc',
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'custom_desc_color',
                    'label'         => esc_html__('Custom Description Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ap-custom-desc' => 'color: {{VALUE}}',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'custom_desc_margin',
                    'label'         => esc_html__( 'Custom Description margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px'],
                    'selectors'     => [
                        '{{WRAPPER}} .ap-custom-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ),

                array(
                    'name'          => 'button_text',
                    'label' => esc_html__( 'Button Title', 'uipro' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => '',
                    'label_block' => true,
                    'start_section' => 'button',
                    'section_name'      => esc_html__('Button Settings', 'uipro')
                ),

                array(
                    'type'          => Group_Control_Typography::get_type(),
                    'name'          => 'button_typography',
                    'scheme'        => Typography::TYPOGRAPHY_1,
                    'label'         => esc_html__('Button Font', 'uipro'),
                    'selector'      => '{{WRAPPER}} .ui-button',
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'button_margin',
                    'label'         => esc_html__( 'Button margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px'],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'button_padding',
                    'label'         => esc_html__( 'Button Padding', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ),
                array(
                    'label' => esc_html__( 'Background Color', 'uipro' ),
                    'name'          => 'button_background',
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'separator'     => 'before',
                    'selectors' => [
                        '{{WRAPPER}} .ui-button' => 'background-color: {{VALUE}}',
                    ],
                ),
                array(
                    'label' => esc_html__( 'Color', 'uipro' ),
                    'name'          => 'button_color',
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .ui-button' => 'color: {{VALUE}}',
                    ],
                ),
                array(
                    'id'          => 'border_radius',
                    'label' => __( 'Button Border Radius', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px','%' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 400,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 0,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .ui-button' => 'border-radius: {{SIZE}}{{UNIT}} !important;',
                    ],

                ),
                array(
                    'label' => esc_html__( 'Button Border', 'uipro' ),
                    'name'          => 'button_border',
                    'type' => \Elementor\Group_Control_Border::get_type(),
                    'selector' => '{{WRAPPER}} .ui-button',

                ),
                array(
                    'label' => esc_html__( 'Hover Background Color', 'uipro' ),
                    'name'          => 'hover_button_background',
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'separator'     => 'before',
                    'selectors' => [
                        '{{WRAPPER}} .ui-button:hover' => 'background-color: {{VALUE}}',
                    ],
                ),
                array(
                    'label' => esc_html__( 'Hover Color', 'uipro' ),
                    'name'          => 'hover_button_color',
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .ui-button:hover' => 'color: {{VALUE}}',
                    ],
                ),
                array(
                    'label' => esc_html__( 'Hover Button Border', 'uipro' ),
                    'name'          => 'hover_button_border',
                    'type' => \Elementor\Group_Control_Border::get_type(),
                    'selector' => '{{WRAPPER}} .ui-button:hover',
                ),
                array(
                    'id' => 'slideshow_transition',
                    'type' => Controls_Manager::SELECT,
                    'label'     => esc_html__( 'Transition', 'uipro' ),
                    'description' => esc_html__( 'Select the transition between two slides', 'uipro' ),
                    'options'         => array(
                        '' => esc_html__( 'Slide', 'uipro' ),
                        'pull' => esc_html__( 'Pull', 'uipro' ),
                        'push' => esc_html__( 'Push', 'uipro' ),
                        'fade' => esc_html__( 'Fade', 'uipro' ),
                        'scale' => esc_html__( 'Scale', 'uipro' ),
                    ),
                    'default' => '',
                    'start_section' => 'slideshow_settings',
                    'section_name'      => esc_html__('Slideshow Settings', 'uipro')
                ),
                array(
                    'id' => 'show_nav',
                    'type' => Controls_Manager::SWITCHER,
                    'label'     => esc_html__( 'Enable Nav', 'uipro' ),
                    'label_on' => esc_html__( 'Yes', 'uipro' ),
                    'label_off' => esc_html__( 'No', 'uipro' ),
                    'return_value' => '1',
                    'default' => '0',
                ),
                array(
                    'id' => 'show_dots',
                    'type' => Controls_Manager::SWITCHER,
                    'label'     => esc_html__( 'Enable Dots', 'uipro' ),
                    'label_on' => esc_html__( 'Yes', 'uipro' ),
                    'label_off' => esc_html__( 'No', 'uipro' ),
                    'return_value' => '1',
                    'default' => '0',
                ),

            ));
            $options    = array_merge($options, $this->get_general_options());

            static::$cache[$store_id]   = $options;

            return $options;
        }

	}
}