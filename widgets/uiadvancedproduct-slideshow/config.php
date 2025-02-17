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
                    'style2'   => esc_html__( 'Style 2', 'uipro' ),
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
                'video',
                [
                    'type'          =>  Controls_Manager::MEDIA,
                    'label'         => esc_html__('Select Video:', 'uipro'),
                    'media_types'   => ['video'],
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
		            'id' => 'show_price',
		            'type' => Controls_Manager::SWITCHER,
		            'label'     => esc_html__( 'Show Price', 'uipro' ),
		            'label_on' => esc_html__( 'Yes', 'uipro' ),
		            'label_off' => esc_html__( 'No', 'uipro' ),
		            'return_value' => '1',
		            'default' => '1',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'layout', 'operator' => 'in', 'value' => ['style1','style2']],
                        ],
                    ],
	            ),
                array(
                    'type'          => Controls_Manager::SELECT2,
                    'id'            => 'custom_fields',
                    'label'         => esc_html__( 'Custom Fields', 'uipro' ),
                    'options'       => $arr_fields,
                    'multiple'      => true,
                ),

                array(
                    'type'          => Controls_Manager::SELECT,
                    'id'            => 'ap_style1_container',
                    'label'         => esc_html__( 'Container Content', 'uipro' ),
                    'options'       => array(
                        'uk-container-large'    => esc_html__('Large', 'uipro'),
                        'uk-container-expand'    => esc_html__('Expand', 'uipro'),
                    ),
                    'default'       => 'boxed',
                    'description'   => esc_html__( 'Select container content.', 'uipro' ),
                    'conditions' => [
                        'terms' => [
                            ['name' => 'layout', 'operator' => 'in', 'value' => ['style1','style2']],
                        ],
                    ],
                    'start_section' => 'ap-slideshow-box',
                    'section_name'      => esc_html__('Slideshow Box Settings', 'uipro')
                ),
	            array(
		            'type'          => Controls_Manager::SLIDER,
		            'name'            => 'ap_content_width',
		            'label'         => esc_html__( 'Overlay Width', 'uipro' ),
		            'responsive'    => true,
		            'size_units'    => ['px', '%'],
		            'range'         => [
			            '%' => [
				            'min' => 0,
				            'max' => 100,
			            ],
			            'px' => [
				            'min' => 0,
				            'max' => 2000,
			            ],
		            ],
		            'default'   => [
			            'unit' => 'px',
		            ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'layout', 'operator' => 'in', 'value' => ['style1','style2']],
                        ],
                    ],
		            'selectors'  => ['{{WRAPPER}} .ap_slider_content_inner' => 'max-width: {{SIZE}}{{UNIT}};']
	            ),
	            array(
		            'id' => 'overlay_positions',
		            'type' => Controls_Manager::SELECT,
		            'label'     => esc_html__( 'Positions', 'uipro' ),
		            'description' => esc_html__( 'Select the content position.', 'uipro' ),
		            'options'         => array(
			            'top' => esc_html__( 'Top', 'uipro' ),
			            'bottom' => esc_html__( 'Bottom', 'uipro' ),
			            'left' => esc_html__( 'Left', 'uipro' ),
			            'right' => esc_html__( 'Right', 'uipro' ),
			            'top-left' => esc_html__( 'Top Left', 'uipro' ),
			            'top-center' => esc_html__( 'Top Center', 'uipro' ),
			            'top-right' => esc_html__( 'Top Right', 'uipro' ),
			            'center-left' => esc_html__( 'Center Left', 'uipro' ),
			            'center' => esc_html__( 'Center Center', 'uipro' ),
			            'center-right' => esc_html__( 'Center Right', 'uipro' ),
			            'bottom-left' => esc_html__( 'Bottom Left', 'uipro' ),
			            'bottom-center' => esc_html__( 'Bottom Center', 'uipro' ),
			            'bottom-right' => esc_html__( 'Bottom Right', 'uipro' ),
		            ),
		            'default' => 'center-left',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'layout', 'operator' => 'in', 'value' => ['style1','style2']],
                        ],
                    ],
	            ),
	            array(
		            'type'          => \Elementor\Group_Control_Background::get_type(),
		            'name'          => 'overlay_bg',
		            'label' => __( 'Overlay Background', 'uipro' ),
		            'default' => '',
		            'types' => [ 'classic', 'gradient' ],
		            'selector' => '{{WRAPPER}} .ap_slideshow_overlay',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'layout', 'operator' => 'in', 'value' => ['style1','style2']],
                        ],
                    ],
	            ),
	            array(
		            'type'         => Controls_Manager::CHOOSE,
		            'label'         => esc_html__( 'Overlay Text alignment', 'uipro' ),
		            'name'          => 'overlay_text_align',
		            'responsive'    => true,
		            'options'       => [
			            'left'      => [
				            'title' => esc_html__( 'Left', 'uipro' ),
				            'icon'  => 'eicon-text-align-left',
			            ],
			            'center'    => [
				            'title' => esc_html__( 'Center', 'uipro' ),
				            'icon'  => 'eicon-text-align-center',
			            ],
			            'right'     => [
				            'title' => esc_html__( 'Right', 'uipro' ),
				            'icon'  => 'eicon-text-align-right',
			            ],
			            'justify'   => [
				            'title' => esc_html__( 'Justified', 'uipro' ),
				            'icon'  => 'eicon-text-align-justify',
			            ],
		            ],
		            'selectors'     => [
			            '{{WRAPPER}} .ap_slider_content_inner'   => 'text-align: {{VALUE}}; justify-content: {{VALUE}};',
			            '{{WRAPPER}} .flex-align'   => 'text-align: {{VALUE}}; justify-content: {{VALUE}};',
		            ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'layout', 'operator' => 'in', 'value' => ['style1','style2']],
                        ],
                    ],
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
                    'label'         => esc_html__('Title Font', 'uipro'),
                    'description'   => esc_html__('Select a font family, font size for the addon title.', 'uipro'),
                    'selector'      => '{{WRAPPER}} .ap-slideshow-title',
                    'start_section' => 'ap-title',
                    'section_name'      => esc_html__('Title, Meta Settings', 'uipro')
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
                    'name'          =>  'title_margin',
                    'label'         => esc_html__( 'Title margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px'],
                    'selectors'     => [
                        '{{WRAPPER}} .ap-slideshow-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'layout', 'operator' => 'in', 'value' => ['style1','style2']],
                        ],
                    ],
                ),
                array(
                    'type'          => Group_Control_Typography::get_type(),
                    'name'          => 'meta_typography',
                    'label'         => esc_html__('Meta Font', 'uipro'),
                    'description'   => esc_html__('Select a font family, font size for the meta.', 'uipro'),
                    'selector'      => '{{WRAPPER}} .ap-custom-meta',
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'meta_color',
                    'label'         => esc_html__('Meta Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ap-custom-meta' => 'color: {{VALUE}}',
                    ],
                ),
	            array(
                    'type'          => Group_Control_Typography::get_type(),
                    'name'          => 'label_typography',
                    'label'         => esc_html__('Label Font', 'uipro'),
                    'description'   => esc_html__('Select a font family.', 'uipro'),
                    'selector'      => '{{WRAPPER}} .ap-slideshow-info .ap-price-box .ap-field-label',
                    'start_section' => 'ap-price',
                    'section_name'      => esc_html__('Price Settings', 'uipro')
                ),
	            array(
                    'type'          => Group_Control_Typography::get_type(),
                    'name'          => 'price_typography',
                    'label'         => esc_html__('Price Font', 'uipro'),
                    'description'   => esc_html__('Select a font family.', 'uipro'),
                    'selector'      => '{{WRAPPER}} .ap-slideshow-info .ap-price-box .ap-price',
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'label_color',
                    'label'         => esc_html__('Label Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ap-slideshow-info .ap-price-box .ap-field-label' => 'color: {{VALUE}}',
                    ],
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'Price_color',
                    'label'         => esc_html__('Price Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ap-slideshow-info .ap-price-box .ap-price' => 'color: {{VALUE}}',
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
		            'type'          => Controls_Manager::SLIDER,
		            'name'            => 'custom_fields_gap',
		            'label'         => esc_html__( 'Custom Fields Gap', 'uipro' ),
		            'responsive'    => true,
		            'size_units'    => ['px', '%'],
		            'range'         => [
			            '%' => [
				            'min' => 0,
				            'max' => 100,
			            ],
			            'px' => [
				            'min' => 0,
				            'max' => 500,
			            ],
		            ],
		            'default'   => [
			            'unit' => 'px',
		            ],
		            'selectors'  => ['{{WRAPPER}} .ap-slideshow-bottom-fields' => 'gap: {{SIZE}}{{UNIT}};']
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
		            'type'          => Controls_Manager::DIMENSIONS,
		            'name'          =>  'desc_padding',
		            'label'         => esc_html__( 'Description Padding', 'uipro' ),
		            'responsive'    =>  true,
		            'size_units'    => [ 'px', 'em', '%' ],
		            'selectors'     => [
			            '{{WRAPPER}} .ap-single-desc' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		            ],
	            ),
                array(
                    'type'          => Group_Control_Typography::get_type(),
                    'name'          => 'custom_meta_desc_typography',
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
                    'label'         => esc_html__('Button Font', 'uipro'),
                    'selector'      => '{{WRAPPER}} .ui-button',
                ),
	            array(
		            'type'          => Controls_Manager::ICONS,
		            'id'            => 'button_icon',
		            'label'         => esc_html__( 'Button Icon', 'uipro' ),
	            ),
	            array(
		            'type'          => Controls_Manager::SELECT,
		            'id'            => 'button_icon_position',
		            'label'         => esc_html__( 'Button Icon Position', 'uipro' ),
		            'options'       => array(
			            'before'    => esc_html__('Before', 'uipro'),
			            'after'     => esc_html__('After', 'uipro')
		            ),
		            'condition'     => array(
			            'button_icon!'    => ''
		            ),
		            'default'       => 'before'
	            ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'button_icon_margin',
                    'label'         => esc_html__( 'Button Icon margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px'],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-button i, {{WRAPPER}} .ui-button svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    ],
                    'condition'     => array(
	                    'button_icon!'    => ''
                    ),
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
                        '{{WRAPPER}} .ui-button' => 'background-color: {{VALUE}} !important;',
                    ],
                ),
                array(
                    'label' => esc_html__( 'Color', 'uipro' ),
                    'name'          => 'button_color',
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .ui-button' => 'color: {{VALUE}} !important',
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
                        '{{WRAPPER}} .ui-button:hover' => 'background-color: {{VALUE}} !important',
                    ],
                ),
                array(
                    'label' => esc_html__( 'Hover Color', 'uipro' ),
                    'name'          => 'hover_button_color',
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .ui-button:hover' => 'color: {{VALUE}} !important',
                    ],
                ),
                array(
                    'label' => esc_html__( 'Hover Button Border', 'uipro' ),
                    'name'          => 'hover_button_border',
                    'type' => \Elementor\Group_Control_Border::get_type(),
                    'selector' => '{{WRAPPER}} .ui-button:hover',
                ),
	            array(
                    'name'          => 'button2_text',
                    'label' => esc_html__( 'Button Title', 'uipro' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => '',
                    'label_block' => true,
                    'start_section' => 'button2',
                    'section_name'      => esc_html__('Button2 Settings', 'uipro')
                ),

                array(
                    'type'          => Group_Control_Typography::get_type(),
                    'name'          => 'button2_typography',
                    'label'         => esc_html__('Button Font', 'uipro'),
                    'selector'      => '{{WRAPPER}} .ui-button2',
                ),
	            array(
		            'type'          => Controls_Manager::ICONS,
		            'id'            => 'button2_icon',
		            'label'         => esc_html__( 'Button Icon', 'uipro' ),
	            ),
	            array(
		            'type'          => Controls_Manager::SELECT,
		            'id'            => 'button2_icon_position',
		            'label'         => esc_html__( 'Button Icon Position', 'uipro' ),
		            'options'       => array(
			            'before'    => esc_html__('Before', 'uipro'),
			            'after'     => esc_html__('After', 'uipro')
		            ),
		            'condition'     => array(
			            'button2_icon!'    => ''
		            ),
		            'default'       => 'before'
	            ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'button2_icon_margin',
                    'label'         => esc_html__( 'Button Icon margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px'],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-button2 i, {{WRAPPER}} .ui-button2 svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    ],
                    'condition'     => array(
	                    'button2_icon!'    => ''
                    ),
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'button2_margin',
                    'label'         => esc_html__( 'Button margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px'],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-button2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'button2_padding',
                    'label'         => esc_html__( 'Button Padding', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-button2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ),
                array(
                    'label' => esc_html__( 'Background Color', 'uipro' ),
                    'name'          => 'button2_background',
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'separator'     => 'before',
                    'selectors' => [
                        '{{WRAPPER}} .ui-button2' => 'background-color: {{VALUE}} !important;',
                    ],
                ),
                array(
                    'label' => esc_html__( 'Color', 'uipro' ),
                    'name'          => 'button2_color',
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .ui-button2' => 'color: {{VALUE}} !important',
                    ],
                ),
                array(
                    'id'          => 'button2_border_radius',
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
                        '{{WRAPPER}} .ui-button2' => 'border-radius: {{SIZE}}{{UNIT}} !important;',
                    ],

                ),
                array(
                    'label' => esc_html__( 'Button Border', 'uipro' ),
                    'name'          => 'button2_border',
                    'type' => \Elementor\Group_Control_Border::get_type(),
                    'selector' => '{{WRAPPER}} .ui-button2',

                ),
                array(
                    'label' => esc_html__( 'Hover Background Color', 'uipro' ),
                    'name'          => 'hover_button2_background',
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'separator'     => 'before',
                    'selectors' => [
                        '{{WRAPPER}} .ui-button2:hover' => 'background-color: {{VALUE}} !important',
                    ],
                ),
                array(
                    'label' => esc_html__( 'Hover Color', 'uipro' ),
                    'name'          => 'hover_button2_color',
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .ui-button2:hover' => 'color: {{VALUE}} !important',
                    ],
                ),
                array(
                    'label' => esc_html__( 'Hover Button Border', 'uipro' ),
                    'name'          => 'hover_button2_border',
                    'type' => \Elementor\Group_Control_Border::get_type(),
                    'selector' => '{{WRAPPER}} .ui-button2:hover',
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
		            'name'          => 'slideshow_ratio',
		            'label' => esc_html__( 'Ratio', 'uipro' ),
		            'type' => Controls_Manager::TEXT,
		            'default' => '16:9',
		            'label_block' => true,
	            ),
	            array(
		            'type'          => Controls_Manager::NUMBER,
		            'id'            => 'slideshow_min_height',
		            'label'         => esc_html__( 'Min Height', 'uipro' ),
		            'description'   => esc_html__( 'Set the min height slideshow.', 'uipro' ),
		            'min' => 1,
		            'step' => 1,
                    'conditions' => [
                        'terms' => [
                            ['name' => 'layout', 'operator' => 'in', 'value' => ['style1','style2']],
                        ],
                    ],
	            ),
	            array(
		            'type'          => Controls_Manager::NUMBER,
		            'id'            => 'slideshow_max_height',
		            'label'         => esc_html__( 'Max Height', 'uipro' ),
		            'description'   => esc_html__( 'Set the max height slideshow.', 'uipro' ),
		            'min' => 1,
		            'step' => 1,
                    'conditions' => [
                        'terms' => [
                            ['name' => 'layout', 'operator' => 'in', 'value' => ['style1','style2']],
                        ],
                    ],
	            ),
                array(
                    'id' => 'group_nav_dot',
                    'type' => Controls_Manager::SWITCHER,
                    'label'     => esc_html__( 'Nav & Dot in Group', 'uipro' ),
                    'label_on' => esc_html__( 'Yes', 'uipro' ),
                    'label_off' => esc_html__( 'No', 'uipro' ),
                    'return_value' => '1',
                    'default' => '0',
                ),
	            array(
		            'type'          => Controls_Manager::SELECT,
		            'id'            => 'group_nav_dot_container',
		            'label'         => esc_html__( 'Container Group', 'uipro' ),
		            'options'       => array(
			            'uk-container-large'    => esc_html__('Large', 'uipro'),
			            'uk-container-expand'    => esc_html__('Expand', 'uipro'),
		            ),
		            'condition'     => array(
			            'group_nav_dot'    => '1'
		            ),
	            ),
	            array(
		            'id' => 'group_nav_dot_position',
		            'type' => Controls_Manager::SELECT,
		            'label'     => esc_html__( 'Group Position', 'uipro' ),
		            'description' => esc_html__( 'Select the position of the Group Nav & Dot.', 'uipro' ),
		            'options'         => array(
			            '' => esc_html__( 'Default', 'uipro' ),
			            'uk-position-top-left' => esc_html__( 'Top Left', 'uipro' ),
			            'uk-position-top-right' => esc_html__( 'Top Right', 'uipro' ),
			            'uk-position-center-left' => esc_html__( 'Center Left', 'uipro' ),
			            'uk-position-center-right' => esc_html__( 'Center Right', 'uipro' ),
			            'uk-position-bottom-left' => esc_html__( 'Bottom Left', 'uipro' ),
			            'uk-position-bottom-center' => esc_html__( 'Bottom Center', 'uipro' ),
			            'uk-position-bottom-right' => esc_html__( 'Bottom Right', 'uipro' ),
		            ),
		            'default' => '',
		            'conditions' => [
			            'terms' => [
				            ['name' => 'group_nav_dot', 'operator' => '===', 'value' => '1'],
			            ],
		            ],
	            ),
	            array(
		            'id' => 'group_nav_dot_position_mobile',
		            'type' => Controls_Manager::SELECT,
		            'label'     => esc_html__( 'Group Position in Mobile', 'uipro' ),
		            'options'         => array(
			            '' => esc_html__( 'Default', 'uipro' ),
			            'uk-position-top-left' => esc_html__( 'Top Left', 'uipro' ),
			            'uk-position-top-right' => esc_html__( 'Top Right', 'uipro' ),
			            'uk-position-center-left' => esc_html__( 'Center Left', 'uipro' ),
			            'uk-position-center-right' => esc_html__( 'Center Right', 'uipro' ),
			            'uk-position-bottom-left' => esc_html__( 'Bottom Left', 'uipro' ),
			            'uk-position-bottom-center' => esc_html__( 'Bottom Center', 'uipro' ),
			            'uk-position-bottom-right' => esc_html__( 'Bottom Right', 'uipro' ),
		            ),
		            'default' => '',
		            'conditions' => [
			            'terms' => [
				            ['name' => 'group_nav_dot', 'operator' => '===', 'value' => '1'],
			            ],
		            ],
	            ),
	            array(
		            'type'          => Controls_Manager::DIMENSIONS,
		            'name'          =>  'group_nav_dot_margin',
		            'label'         => esc_html__( 'Group margin', 'uipro' ),
		            'responsive'    =>  true,
		            'size_units'    => [ 'px'],
		            'selectors'     => [
			            '{{WRAPPER}} .ap_slideshow-nav_group' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		            ],
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
		            'id' => 'slidenav_position',
		            'type' => Controls_Manager::SELECT,
		            'label'     => esc_html__( 'Position', 'uipro' ),
		            'description' => esc_html__( 'Select the position of the slidenav.', 'uipro' ),
		            'options'         => array(
			            '' => esc_html__( 'None', 'uipro' ),
			            'default' => esc_html__( 'Default', 'uipro' ),
			            'outside' => esc_html__( 'Outside', 'uipro' ),
			            'top-left' => esc_html__( 'Top Left', 'uipro' ),
			            'top-right' => esc_html__( 'Top Right', 'uipro' ),
			            'center-left' => esc_html__( 'Center Left', 'uipro' ),
			            'center-right' => esc_html__( 'Center Right', 'uipro' ),
			            'bottom-left' => esc_html__( 'Bottom Left', 'uipro' ),
			            'bottom-center' => esc_html__( 'Bottom Center', 'uipro' ),
			            'bottom-right' => esc_html__( 'Bottom Right', 'uipro' ),
		            ),
		            'default' => 'default',
		            'conditions' => [
			            'terms' => [
				            ['name' => 'show_nav', 'operator' => '===', 'value' => '1'],
				            ['name' => 'group_nav_dot', 'operator' => '!=', 'value' => '1'],
			            ],
		            ],
	            ),
	            array(
		            'type'          => Controls_Manager::DIMENSIONS,
		            'name'          => 'navigation_pos_margin',
		            'label'         => esc_html__( 'Next Margin', 'uipro' ),
		            'responsive'    =>  true,
		            'size_units'    => [ 'px', 'em', '%' ],
		            'selectors'     => [
			            '{{WRAPPER}} .uk-slidenav-next' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
		            ],
		            'conditions' => [
			            'terms' => [
				            ['name' => 'show_nav', 'operator' => '===', 'value' => '1'],
			            ],
		            ],
	            ),
	            array(
		            'type'          => Controls_Manager::DIMENSIONS,
		            'name'          => 'navigation_pos_margin_pre',
		            'label'         => esc_html__( 'Preview Margin', 'uipro' ),
		            'responsive'    =>  true,
		            'size_units'    => [ 'px', 'em', '%' ],
		            'selectors'     => [
			            '{{WRAPPER}} .uk-slidenav-previous' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
		            ],
		            'conditions' => [
			            'terms' => [
				            ['name' => 'show_nav', 'operator' => '===', 'value' => '1'],
			            ],
		            ],
	            ),
	            array(
		            'type'          => Controls_Manager::DIMENSIONS,
		            'name'          => 'navigation_margin_custom',
		            'label'         => esc_html__( 'Navigation Margin', 'uipro' ),
		            'responsive'    =>  true,
		            'size_units'    => [ 'px', 'em', '%' ],
		            'selectors'     => [
			            '{{WRAPPER}} .uk-slidenav-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
		            ],
		            'conditions' => [
			            'terms' => [
				            ['name' => 'show_nav', 'operator' => '===', 'value' => '1'],
			            ],
		            ],
	            ),
	            array(
		            'type'          =>  \Elementor\Group_Control_Border::get_type(),
		            'name'          => 'nav_border',
		            'label'         => esc_html__('Nav Border', 'uipro'),
		            'selector' => '{{WRAPPER}} .uk-slider .uk-slidenav',
		            'condition'     => array(
			            'show_nav'    => '1'
		            ),
	            ),
	            array(
		            'type'          =>  \Elementor\Group_Control_Box_Shadow::get_type(),
		            'name'          => 'nav_shadow',
		            'label'         => esc_html__('Nav Shadow', 'uipro'),
		            'selector' => '{{WRAPPER}} .uk-slidenav',
		            'conditions' => [
			            'terms' => [
				            ['name' => 'show_nav', 'operator' => '===', 'value' => '1'],
			            ],
		            ],
	            ),
	            array(
		            'type'          => Controls_Manager::SLIDER,
		            'name'            => 'nav_width',
		            'label'         => esc_html__( 'Nav Width', 'uipro' ),
		            'responsive'    => true,
		            'size_units'    => ['px'],
		            'range'         => [
			            'px' => [
				            'min' => 0,
				            'max' => 500,
			            ],
		            ],
		            'default'   => [
			            'unit' => 'px',
		            ],
		            'condition'     => array(
			            'show_nav'    => '1'
		            ),
		            'selectors'  => ['{{WRAPPER}} .uk-slider .uk-slidenav' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};']
	            ),
	            array(
		            'type'          => Controls_Manager::DIMENSIONS,
		            'name'          =>  'nav_radius',
		            'label'         => esc_html__( 'Nav radius', 'uipro' ),
		            'responsive'    =>  true,
		            'size_units'    => [ 'px', 'em', '%' ],
		            'selectors'     => [
			            '{{WRAPPER}} .uk-slider .uk-slidenav' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;',
		            ],
		            'condition'     => array(
			            'show_nav'    => '1'
		            ),
	            ),
	            array(
		            'label' => esc_html__( 'Nav background color', 'uipro' ),
		            'name'  => 'nav_bg',
		            'type' => \Elementor\Controls_Manager::COLOR,
		            'selectors' => [
			            '{{WRAPPER}} .uk-slider .uk-slidenav' => 'background-color: {{VALUE}}',
		            ],
		            'condition'     => array(
			            'show_nav'    => '1'
		            ),
	            ),
	            array(
		            'label' => esc_html__( 'Nav color', 'uipro' ),
		            'name'  => 'nav_color',
		            'type' => \Elementor\Controls_Manager::COLOR,
		            'selectors' => [
			            '{{WRAPPER}} .uk-slider .uk-slidenav' => 'color: {{VALUE}}',
		            ],
		            'condition'     => array(
			            'show_nav'    => '1'
		            ),
	            ),
	            array(
		            'label' => esc_html__( 'Nav Hover background color', 'uipro' ),
		            'name'  => 'nav_bg_hover',
		            'type' => \Elementor\Controls_Manager::COLOR,
		            'selectors' => [
			            '{{WRAPPER}} .uk-slider .uk-slidenav:hover' => 'background-color: {{VALUE}}',
		            ],
		            'condition'     => array(
			            'show_nav'    => '1'
		            ),
	            ),
	            array(
		            'label' => esc_html__( 'Nav Hover color', 'uipro' ),
		            'name'  => 'nav_color_hover',
		            'type' => \Elementor\Controls_Manager::COLOR,
		            'selectors' => [
			            '{{WRAPPER}} .uk-slider .uk-slidenav:hover' => 'color: {{VALUE}}',
		            ],
		            'condition'     => array(
			            'show_nav'    => '1'
		            ),
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
	            array(
		            'type'          => Controls_Manager::SELECT,
		            'id'            => 'dots_positions',
		            'label' => esc_html__( 'Dots Position', 'uipro' ),
		            'default' => '',
		            'options' => [
			            '' => esc_html__('Default', 'uipro'),
			            'top-left' => esc_html__( 'Top Left', 'uipro' ),
			            'top-right' => esc_html__( 'Top Right', 'uipro' ),
			            'center-left' => esc_html__( 'Center Left', 'uipro' ),
			            'center-right' => esc_html__( 'Center Right', 'uipro' ),
			            'bottom-left' => esc_html__( 'Bottom Left', 'uipro' ),
			            'bottom-center' => esc_html__( 'Bottom Center', 'uipro' ),
			            'bottom-right' => esc_html__( 'Bottom Right', 'uipro' ),
		            ],
		            'conditions' => [
			            'terms' => [
				            ['name' => 'show_dots', 'operator' => '===', 'value' => '1'],
				            ['name' => 'group_nav_dot', 'operator' => '!=', 'value' => '1'],
			            ],
		            ],
	            ),
	            array(
		            'type'          => Controls_Manager::DIMENSIONS,
		            'name'          =>  'dots_margin',
		            'label'         => esc_html__( 'Dots margin', 'uipro' ),
		            'responsive'    =>  true,
		            'size_units'    => [ 'px'],
		            'selectors'     => [
			            '{{WRAPPER}} .uk-dotnav' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		            ],
		            'condition'     => array(
			            'show_dots'    => '1'
		            ),
	            ),
	            array(
		            'type'          =>  \Elementor\Group_Control_Border::get_type(),
		            'name'          => 'dots_border',
		            'label'         => esc_html__('Dot Border', 'uipro'),
		            'selector' => '{{WRAPPER}} .uk-dotnav li>*',
		            'condition'     => array(
			            'show_dots'    => '1'
		            ),
	            ),
	            array(
		            'type'          =>  \Elementor\Group_Control_Box_Shadow::get_type(),
		            'name'          => 'dots_shadow',
		            'label'         => esc_html__('Dot Shadow', 'uipro'),
		            'selector' => '{{WRAPPER}} .uk-dotnav li>*',
		            'conditions' => [
			            'terms' => [
				            ['name' => 'show_dots', 'operator' => '===', 'value' => '1'],
			            ],
		            ],
	            ),
	            array(
		            'type'          => Controls_Manager::SLIDER,
		            'name'            => 'dot_wrap_width',
		            'label'         => esc_html__( 'Dot Wrap Width', 'uipro' ),
		            'responsive'    => true,
		            'size_units'    => ['px'],
		            'range'         => [
			            'px' => [
				            'min' => 0,
				            'max' => 500,
			            ],
		            ],
		            'default'   => [
			            'unit' => 'px',
		            ],
		            'condition'     => array(
			            'show_dots'    => '1'
		            ),
		            'selectors'  => ['{{WRAPPER}} .uk-dotnav li>*' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};']
	            ),
	            array(
		            'type'          => Controls_Manager::SLIDER,
		            'name'            => 'dot_width',
		            'label'         => esc_html__( 'Dot Width', 'uipro' ),
		            'responsive'    => true,
		            'size_units'    => ['px'],
		            'range'         => [
			            'px' => [
				            'min' => 0,
				            'max' => 500,
			            ],
		            ],
		            'default'   => [
			            'unit' => 'px',
		            ],
		            'condition'     => array(
			            'show_dots'    => '1'
		            ),
		            'selectors'  => ['{{WRAPPER}} .uk-dotnav li>*:before' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};']
	            ),
	            array(
		            'type'          => Controls_Manager::DIMENSIONS,
		            'name'          =>  'dots_radius',
		            'label'         => esc_html__( 'Dot radius', 'uipro' ),
		            'responsive'    =>  true,
		            'size_units'    => [ 'px', 'em', '%' ],
		            'selectors'     => [
			            '{{WRAPPER}} .uk-dotnav li>*' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;',
		            ],
		            'condition'     => array(
			            'show_dots'    => '1'
		            ),
	            ),
	            array(
		            'label' => esc_html__( 'Dot background color', 'uipro' ),
		            'name'  => 'dots_bg',
		            'type' => \Elementor\Controls_Manager::COLOR,
		            'selectors' => [
			            '{{WRAPPER}} .uk-dotnav li>*' => 'background-color: {{VALUE}}',
		            ],
		            'condition'     => array(
			            'show_dots'    => '1'
		            ),
	            ),
	            array(
		            'label' => esc_html__( 'Dot color', 'uipro' ),
		            'name'  => 'dots_color',
		            'type' => \Elementor\Controls_Manager::COLOR,
		            'selectors' => [
			            '{{WRAPPER}} .uk-dotnav li>*:before' => 'background-color: {{VALUE}}',
		            ],
		            'condition'     => array(
			            'show_dots'    => '1'
		            ),
	            ),
	            array(
		            'type'          =>  \Elementor\Group_Control_Border::get_type(),
		            'name'          => 'dots_border_hover',
		            'label'         => esc_html__('Dot Hover Border', 'uipro'),
		            'selector' => '{{WRAPPER}} .uk-dotnav li>*:hover, {{WRAPPER}} .uk-dotnav>.uk-active>*',
		            'condition'     => array(
			            'show_dots'    => '1'
		            ),
	            ),
	            array(
		            'label' => esc_html__( 'Dot Hover background color', 'uipro' ),
		            'name'  => 'dots_bg_hover',
		            'type' => \Elementor\Controls_Manager::COLOR,
		            'selectors' => [
			            '{{WRAPPER}} .uk-dotnav li>*:hover, {{WRAPPER}} .uk-dotnav>.uk-active>*' => 'background-color: {{VALUE}}',
		            ],
		            'condition'     => array(
			            'show_dots'    => '1'
		            ),
	            ),
	            array(
		            'label' => esc_html__( 'Dot Hover color', 'uipro' ),
		            'name'  => 'dots_color_hover',
		            'type' => \Elementor\Controls_Manager::COLOR,
		            'selectors' => [
			            '{{WRAPPER}} .uk-dotnav li>*:hover:before, {{WRAPPER}} .uk-dotnav .uk-active>*:before' => 'background-color: {{VALUE}}',
		            ],
		            'condition'     => array(
			            'show_dots'    => '1'
		            ),
	            ),

            ));
            $options    = array_merge($options, $this->get_general_options());

            static::$cache[$store_id]   = $options;

            return $options;
        }

	}
}