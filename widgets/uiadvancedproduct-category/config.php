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
require_once ABSPATH.'wp-content/plugins/uipro/widgets/uiadvancedproducts/helper.php';
if ( ! class_exists( 'UIPro_Config_Uiadvancedproduct_Category' ) ) {
	/**
	 * Class UIPro_Config_Uiadvancedproduct_Category
	 */
	class UIPro_Config_Uiadvancedproduct_Category extends UIPro_Abstract_Config {

		/**
		 * UIPro_Config_Uiadvancedproduct_Category constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'uiadvancedproduct-category';
			self::$name = esc_html__( 'TemPlaza: Advanced Product Category', 'uipro' );
			self::$desc = esc_html__( 'Display Advanced Product Category.', 'uipro' );
			self::$icon = 'eicon-apps';
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
        $store_id   = md5(__METHOD__);
        if(isset(static::$cache[$store_id])){
            return static::$cache[$store_id];
        }
        $slug_cat = array('ap_category' => esc_html__( 'Advanced Product Category', 'uipro' ));
        $slug_tax = array();
        if(!empty($categories) && count($categories)){
            foreach ($categories as $cat){
                $slug_tax   = array('ap_product_'.get_post_meta($cat -> ID, 'slug', true)=> $cat -> post_title);
            }
        }
        $all_tax = array_merge($slug_cat,$slug_tax);
        $all_thumbnails = get_intermediate_image_sizes();
        $arr_thumbnails = array();
        foreach ($all_thumbnails as $thumbnail){
            $arr_thumbnails[$thumbnail] = $thumbnail;
        }
        $arr_thumbnails['full'] = 'full';

        $options    = array(
            array(
                'type'          => Controls_Manager::SELECT,
                'name'          => 'layout',
                'show_label'    => true,
                'label'         => esc_html__( 'Category Layout', 'uipro' ),
                'options'       => array(
                    'base'      => esc_html__( 'Default', 'uipro' ),
                    'grid'      => esc_html__( 'Grid', 'uipro' ),
                ),
                'default'       => 'base',
            ),
            array(
                'type'          => Controls_Manager::SELECT,
                'name'          => 'source',
                'show_label'    => true,
                'label'         => esc_html__( 'Choose Source', 'uipro' ),
                'options'       => $all_tax,
                'default'       => 'ap_category',
            ),
            array(
                'type'          => Controls_Manager::SELECT2,
                'id'            => 'ap_product_category',
                'label'         => esc_html__( 'Select Category', 'uipro' ),
                'options'       => UIPro_Helper::get_cat_taxonomy( 'ap_category' ),
                'multiple'      => true,
                'condition'     => array(
                    'source'    => 'ap_category'
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
                        'source'    => 'ap_product_'.$slug.'',
                    ),
                );
            }
        }

            // options
            $options = array_merge($options,array(
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
                    'id'          => 'large_desktop_columns',
                    'label' => esc_html__( 'Large Desktop Columns', 'uipro' ),
                    'type' => Controls_Manager::SELECT,
                    'options'       => array(
                        '1'    => esc_html__('1 Column', 'uipro'),
                        '2'    => esc_html__('2 Columns', 'uipro'),
                        '3'    => esc_html__('3 Columns', 'uipro'),
                        '4'    => esc_html__('4 Columns', 'uipro'),
                        '5'    => esc_html__('5 Columns', 'uipro'),
                        '6'    => esc_html__('6 Columns', 'uipro'),
                    ),
                    'default'   => '3',
                    'separator'     => 'before',
                ),
                array(
                    'id'          => 'desktop_columns',
                    'label' => esc_html__( 'Desktop Columns', 'uipro' ),
                    'type' => Controls_Manager::SELECT,
                    'options'       => array(
                        '1'    => esc_html__('1 Column', 'uipro'),
                        '2'    => esc_html__('2 Columns', 'uipro'),
                        '3'    => esc_html__('3 Columns', 'uipro'),
                        '4'    => esc_html__('4 Columns', 'uipro'),
                        '5'    => esc_html__('5 Columns', 'uipro'),
                        '6'    => esc_html__('6 Columns', 'uipro'),
                    ),
                    'default'   => '3',
                ),
                array(
                    'id'          => 'laptop_columns',
                    'label' => esc_html__( 'Laptop Columns', 'uipro' ),
                    'type' => Controls_Manager::SELECT,
                    'options'       => array(
                        '1'    => esc_html__('1 Column', 'uipro'),
                        '2'    => esc_html__('2 Columns', 'uipro'),
                        '3'    => esc_html__('3 Columns', 'uipro'),
                        '4'    => esc_html__('4 Columns', 'uipro'),
                        '5'    => esc_html__('5 Columns', 'uipro'),
                        '6'    => esc_html__('6 Columns', 'uipro'),
                    ),
                    'default'   => '3'
                ),
                array(
                    'id'          => 'tablet_columns',
                    'label' => esc_html__( 'Tablet Columns', 'uipro' ),
                    'type' => Controls_Manager::SELECT,
                    'options'       => array(
                        '1'    => esc_html__('1 Column', 'uipro'),
                        '2'    => esc_html__('2 Columns', 'uipro'),
                        '3'    => esc_html__('3 Columns', 'uipro'),
                        '4'    => esc_html__('4 Columns', 'uipro'),
                        '5'    => esc_html__('5 Columns', 'uipro'),
                        '6'    => esc_html__('6 Columns', 'uipro'),
                    ),
                    'default'   => '2'
                ),
                array(
                    'id'          => 'mobile_columns',
                    'label' => esc_html__( 'Mobile Columns', 'uipro' ),
                    'type' => Controls_Manager::SELECT,
                    'options'       => array(
                        '1'    => esc_html__('1 Column', 'uipro'),
                        '2'    => esc_html__('2 Columns', 'uipro'),
                        '3'    => esc_html__('3 Columns', 'uipro'),
                        '4'    => esc_html__('4 Columns', 'uipro'),
                        '5'    => esc_html__('5 Columns', 'uipro'),
                        '6'    => esc_html__('6 Columns', 'uipro'),
                    ),
                    'default'   => '1'
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'id'            => 'column_grid_gap',
                    'label'         => esc_html__('Column Gap', 'uipro'),
                    'description'   => esc_html__('Modified Gap Column', 'uipro'),
                    'options'       => array(
                        '' => esc_html__('Default', 'uipro'),
                        'small' => esc_html__('Small', 'uipro'),
                        'medium' => esc_html__('Medium', 'uipro'),
                        'large' => esc_html__('Large', 'uipro'),
                        'collapse' => esc_html__('Collapse', 'uipro'),
                    ),
                    'default'           => '',
                ),
                //Card Settings
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'card_style',
                    'label' => esc_html__( 'Card Style', 'uipro' ),
                    'default' => '',
                    'options' => [
                        '' => esc_html__('None', 'uipro'),
                        'default' => esc_html__('Card Default', 'uipro'),
                        'primary' => esc_html__('Card Primary', 'uipro'),
                        'secondary' => esc_html__('Card Secondary', 'uipro'),
                        'hover' => esc_html__('Card Hover', 'uipro'),
                        'custom' => esc_html__('Custom', 'uipro'),
                    ],
                    'start_section' => 'card_settings',
                    'section_name'      => esc_html__('Card Settings', 'uipro')
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'card_background',
                    'label'         => esc_html__('Card Background', 'uipro'),
                    'description'   => esc_html__('Set the Background Color of Card.', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .uk-card' => 'background-color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'card_style', 'operator' => '===', 'value' => 'custom'],
                        ],
                    ],
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'card_color',
                    'label'         => esc_html__('Card Color', 'uipro'),
                    'description'   => esc_html__('Set the Color of Card.', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .uk-card' => 'color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'card_style', 'operator' => '===', 'value' => 'custom'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'id'            => 'card_size',
                    'label' => esc_html__( 'Card Size', 'uipro' ),
                    'default' => '',
                    'options' => [
                        '' => esc_html__('Default', 'uipro'),
                        'small' => esc_html__('Small', 'uipro'),
                        'large' => esc_html__('Large', 'uipro'),
                        'custom' => esc_html__('Custom', 'uipro'),
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'card_padding',
                    'label'         => esc_html__( 'Card Padding', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .uk-card .uk-card-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'card_size', 'operator' => '===', 'value' => 'custom'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'card_radius',
                    'label'         => esc_html__( 'Border radius', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .uk-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;',
                    ],
                ),
                // image settings
                array(
                    'type'          => Controls_Manager::SELECT,
                    'id'            => 'image_size',
                    'label'         => esc_html__( 'Select Image Size', 'uipro' ),
                    'options'       => $arr_thumbnails,
                    'multiple'      => true,
                    'start_section' => 'ap-image',
                    'section_name'      => esc_html__('Image Settings', 'uipro')
                ),
                array(
                    'id' => 'image_cover',
                    'type' => Controls_Manager::SWITCHER,
                    'label'     => esc_html__( 'Image cover', 'uipro' ),
                    'label_on' => esc_html__( 'Yes', 'uipro' ),
                    'label_off' => esc_html__( 'No', 'uipro' ),
                    'return_value' => '1',
                    'default' => '0',
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'image_radius',
                    'label'         => esc_html__( 'Image Border radius', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .tz-ap-category .ap-category-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;',
                    ],
                ),

                array(
                    'type'          => Group_Control_Typography::get_type(),
                    'name'          => 'title_typography',
                    'scheme'        => Typography::TYPOGRAPHY_1,
                    'label'         => esc_html__('Title Font', 'uipro'),
                    'description'   => esc_html__('Select a font family, font size for the addon title.', 'uipro'),
                    'selector'      => '{{WRAPPER}} .ap-title',
                    'start_section' => 'ap-title',
                    'section_name'      => esc_html__('Title Settings', 'uipro')
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'title_color',
                    'label'         => esc_html__('Title Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .ap-title a' => 'color: {{VALUE}}',
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
                    'start_section' => 'slider_settings',
                    'section_name'      => esc_html__('Slider Settings', 'uipro'),
                    'condition'     => array(
                        'layout'    => 'base'
                    ),
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
                    'condition'     => array(
                        'layout'    => 'base'
                    ),
                ),
                array(
                    'label' => esc_html__( 'Dots Slider Color', 'uipro' ),
                    'name'  => 'quote_dots_color',
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .uk-dotnav>*>*' => 'border-color: {{VALUE}}',
                        '{{WRAPPER}} .uk-dotnav>.uk-active>*, {{WRAPPER}} .uk-dotnav li:hover>*' => 'background-color: {{VALUE}}',
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