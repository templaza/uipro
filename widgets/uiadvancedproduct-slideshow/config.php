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
use TemPlaza_Woo_El\TemPlaza_Woo_El_Helper;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;

if ( ! class_exists( 'UIPro_Config_AdvancedProduct_Slideshow' ) ) {
	/**
	 * Class UIPro_Config_AdvancedProduct_Slideshow
	 */
	class UIPro_Config_AdvancedProduct_Slideshow extends UIPro_Abstract_Config {

		/**
		 * UIPro_Config_Heading constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'uiadvancedproduct-slideshow';
			self::$name = esc_html__( 'TemPlaza: Advanced Product Slideshow', 'uipro' );
			self::$desc = esc_html__( 'Display products Slideshow.', 'uipro' );
			self::$icon = 'eicon-post-slider';
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
                    'id'          => 'layout',
                    'label' => esc_html__( 'Layout', 'uipro' ),
                    'type' => Controls_Manager::SELECT,
                    'options'       => array(
                        'base'    => esc_html__('Inherit Theme Style', 'uipro'),
                        'style1'    => esc_html__('Custom style 1', 'uipro'),
                        'style2'    => esc_html__('Custom style 2', 'uipro'),
                    ),
                    'default'   => 'base',
                ),
                array(
                    'id'          => 'product_source',
                    'label' => esc_html__( 'Product Source', 'uipro' ),
                    'type' => Controls_Manager::SELECT,
                    'options'       => array(
                        'default'    => esc_html__('Inherit', 'uipro'),
                        'custom'    => esc_html__('Custom', 'uipro'),
                    ),
                    'default'   => 'default',
                ),
                array(
                    'type'          => Controls_Manager::NUMBER,
                    'name'          => 'total_products',
                    'show_label'    => true,
                    'label'         => esc_html__( 'Total Products', 'uipro' ),
                    'default'       => '8',
                    'condition'     => array(
                        'product_source!'    => 'custom',
                    )
                ),

                array(
                    'id'          => 'column_gap',
                    'label' => esc_html__( 'Column Gap', 'uipro' ),
                    'type' => Controls_Manager::SELECT,
                    'options'       => array(
                        'default' => esc_html__('Default','uipro'),
                        'small' => esc_html__('Small','uipro'),
                        'medium' => esc_html__('Medium','uipro'),
                        'large' => esc_html__('Large','uipro'),
                        'collapse' => esc_html__('Collapse','uipro'),
                    ),
                    'default'   => 'default'
                ),
				array(
					'type'          => Controls_Manager::SELECT,
					'name'          => 'product_source',
					'label'         => esc_html__( 'Product source', 'uipro' ),
					'options'       => array(
                        'recent'       => esc_html__( 'Recent', 'uipro' ),
                        'featured'     => esc_html__( 'Featured', 'uipro' ),
                        'best_selling' => esc_html__( 'Best Selling', 'uipro' ),
                        'top_rated'    => esc_html__( 'Top Rated', 'uipro' ),
                        'sale'         => esc_html__( 'On Sale', 'uipro' ),
					),
					'default'       => 'recent',
					'admin_label' => false,
				),
                array(
                    'type'          => Controls_Manager::SELECT2,
                    'name'            => 'product_categories',
                    'label'         => esc_html__( 'Select Category', 'uipro' ),
                    'options'       => TemPlaza_Woo_El_Helper::taxonomy_list( 'product_cat'),
                    'default'       => array(),
                    'multiple' => true,
                ),
                array(
                    'type'          => Controls_Manager::SELECT2,
                    'name'            => 'product_brands',
                    'label'         => esc_html__( 'Select Brand', 'uipro' ),
                    'options'       => TemPlaza_Woo_El_Helper::taxonomy_list( 'product_brand'),
                    'default'       => array(),
                    'multiple' => true,
                ),
                array(
                    'type'          => Controls_Manager::SELECT2,
                    'name'            => 'product_tags',
                    'label'         => esc_html__( 'Select Tag', 'uipro' ),
                    'options'       => TemPlaza_Woo_El_Helper::taxonomy_list( 'product_tag'),
                    'default'       => array(),
                    'multiple' => true,
                ),
				array(
					'type'          => Controls_Manager::SELECT,
					'name'          => 'orderby',
					'label'         => esc_html__( 'Order By', 'uipro' ),
					'options'       => array(
                        ''           => esc_html__( 'Default', 'uipro' ),
                        'date'       => esc_html__( 'Date', 'uipro' ),
                        'title'      => esc_html__( 'Title', 'uipro' ),
                        'menu_order' => esc_html__( 'Menu Order', 'uipro' ),
                        'rand'       => esc_html__( 'Random', 'uipro' ),
					),
					'default'       => '',
					'admin_label' => false,
                    'condition'     => array(
                        'product_source'    => array('top_rated', 'sale', 'featured')
                    )
				),
				array(
					'type'          => Controls_Manager::SELECT,
					'name'          => 'order',
					'label'         => esc_html__( 'Order', 'uipro' ),
					'options'       => array(
                        ''     => esc_html__( 'Default', 'uipro' ),
                        'asc'  => esc_html__( 'Ascending', 'uipro' ),
                        'desc' => esc_html__( 'Descending', 'uipro' ),
					),
					'default'       => '',
					'admin_label' => false,
                    'condition'     => array(
                        'product_source'    => array('top_rated', 'sale', 'featured')
                    )
				),
                array(
                    'name'            => 'item_border',
                    'type'          =>  \Elementor\Group_Control_Border::get_type(),
                    'label' => esc_html__( 'Item Border', 'uipro' ),
                    'selector' => '{{WRAPPER}} .product .product-inner',
                    'start_section' => 'item_settings',
                    'section_name'      => esc_html__('Item Settings', 'uipro')
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'item_border_radius',
                    'label'         => esc_html__( 'Item border radius', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .product .product-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'item_margin',
                    'label'         => esc_html__( 'Item Margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .woo-grid-style2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition'     => array(
                        'layout'    => 'style2',
                    ),
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'title_margin',
                    'label'         => esc_html__( 'Title Margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .woocommerce-loop-product__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'price_margin',
                    'label'         => esc_html__( 'Price Margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .tz-product-price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ),

				array(
					'type'          => Controls_Manager::SELECT,
					'name'          => 'image_size',
					'label'         => esc_html__( 'Image Size', 'uipro' ),
					'options'       => array(
                        'inherit'  => esc_html__( 'Inherit Theme Settings', 'uipro' ),
					),
					'default'       => 'inherit',
					'admin_label' => false,
                    'condition'     => array(
                        'layout'    => 'base'
                    ),
                    'start_section' => 'image_settings',
                    'section_name'      => esc_html__('Image Settings', 'uipro')
				),
				array(
					'type'          => Controls_Manager::SELECT,
					'name'          => 'image_size_custom',
					'label'         => esc_html__( 'Image Size', 'uipro' ),
					'options'       => array(
                        'inherit'  => esc_html__( 'Inherit Theme Settings', 'uipro' ),
                        'custom'  => esc_html__( 'Custom Size', 'uipro' ),
					),
					'default'       => 'inherit',
					'admin_label' => false,
                    'condition'     => array(
                        'layout!'    => 'base',
                    ),
                    'start_section' => 'image_settings',
                    'section_name'      => esc_html__('Images Settings', 'uipro')
				),
                array(
                    'type'          => \Elementor\Group_Control_Image_Size::get_type(),
                    'name' => 'thumbnail', // // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
                    'exclude' => [ 'custom' ],
                    'include' => [],
                    'default' => 'woocommerce_thumbnail',
                    'condition'     => array(
                        'image_size_custom'    => 'custom',
                    ),
                ),
                array(
                    'name'            => 'image_box_width_custom',
                    'label'         => esc_html__( 'Image box custom width', 'uipro' ),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'responsive'    => true,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => '%',
                        'size' => 50,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .image-box-style2' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                    'condition'     => array(
                        'layout'    => 'style2'
                    ),
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'image_box_margin',
                    'label'         => esc_html__( 'Image box Margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .image-box-style2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition'     => array(
                        'layout'    => 'style2'
                    ),
                ),


                /* Style tab */

                array(
                    'type'          => Group_Control_Typography::get_type(),
                    'name'          => 'heading_typography',
                    'label'         => esc_html__('Title Typography'),
                    'scheme'        => Typography::TYPOGRAPHY_1,
                    'start_section' => 'style',
                    'section_tab'   => Controls_Manager::TAB_STYLE,
                    'section_name'  => esc_html__( self::$name, 'uipro' ),
                    'selector'      => '{{WRAPPER}} .woocommerce-loop-product__title',
                ),
                array(
                    'type'          => Group_Control_Typography::get_type(),
                    'name'          => 'category_typography',
                    'label'         => esc_html__('Category Typography'),
                    'scheme'        => Typography::TYPOGRAPHY_1,
                    'section_name'  => esc_html__( self::$name, 'uipro' ),
                    'selector'      => '{{WRAPPER}} .meta-cat',
                ),
                array(
                    'type'          => Group_Control_Typography::get_type(),
                    'name'          => 'price_typography',
                    'label'         => esc_html__('Price Typography'),
                    'scheme'        => Typography::TYPOGRAPHY_1,
                    'section_name'  => esc_html__( self::$name, 'uipro' ),
                    'selector'      => '{{WRAPPER}} .price ins, {{WRAPPER}} .price bdi',
                ),
                array(
                    'name'            => 'rating_size',
                    'label'         => esc_html__( 'Rating size', 'uipro' ),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units' => [ 'px'],
                    'responsive'    => true,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1000,
                            'step' => 1,
                        ],

                    ],
                    'selectors' => [
                        '{{WRAPPER}} .product-rating i' => 'font-size: {{SIZE}}{{UNIT}};',
                    ],

                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'info_bg_color',
                    'label'         => esc_html__('Info box background Color', 'uipro'),
                    'description'   => esc_html__('Set the color of title.', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .product-info' => 'background-color: {{VALUE}}',
                    ],
                    'separator'     => 'before',
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'title_color',
                    'label'         => esc_html__('Title Color', 'uipro'),
                    'description'   => esc_html__('Set the color of title.', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce-loop-product__title' => 'color: {{VALUE}}',
                    ],
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'category_color',
                    'label'         => esc_html__('Category Color', 'uipro'),
                    'description'   => esc_html__('Set the color of category.', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .meta-cat' => 'color: {{VALUE}}',
                    ],
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'price_color',
                    'label'         => esc_html__('Price Color', 'uipro'),
                    'description'   => esc_html__('Set the color of price.', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .price bdi' => 'color: {{VALUE}}',
                    ],
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'price_del_color',
                    'label'         => esc_html__('Price Del Color', 'uipro'),
                    'description'   => esc_html__('Set the color of del price.', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .price ins' => 'color: {{VALUE}}',
                    ],
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'btn_loop_bg',
                    'label'         => esc_html__('Button background', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .tz-product-cart a' => 'background-color: {{VALUE}}',
                    ],
                    'separator'     => 'before',
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'btn_loop_color',
                    'label'         => esc_html__('Button Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .tz-product-cart a' => 'color: {{VALUE}}',
                    ],
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'btn_loop_bg_hover',
                    'label'         => esc_html__('Hover Button background', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .tz-product-cart a:hover' => 'background-color: {{VALUE}}',
                    ],
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'btn_loop_color_hover',
                    'label'         => esc_html__('Hover Button Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .tz-product-cart a:hover' => 'color: {{VALUE}}',
                    ],
                ),

			);
			$options    = array_merge($options, $this->get_general_options());

			static::$cache[$store_id]   = $options;

			return $options;
		}

	}
}