    <?php
/**
 * UIPro Woocommerce Grid config class
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

if ( ! class_exists( 'UIPro_Config_Woo_Grid' ) ) {
	/**
	 * Class UIPro_Config_Woo_Grid
	 */
	class UIPro_Config_Woo_Grid extends UIPro_Abstract_Config {

		/**
		 * UIPro_Config_Heading constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'woo-grid';
			self::$name = esc_html__( 'TemPlaza: Woocommerce Grid', 'uipro' );
			self::$desc = esc_html__( 'Display products grid style.', 'uipro' );
			self::$icon = 'eicon-gallery-grid';
			parent::__construct();

		}

		/**
		 * @return array
		 */
		public function get_options() {
			// options
			$options = array(
                array(
                    'type'          => Controls_Manager::NUMBER,
                    'name'          => 'total_products',
                    'show_label'    => true,
                    'label'         => esc_html__( 'Total Products', 'uipro' ),
                    'default'       => '8',
                    'condition'     => array(
                        'product_source'    => array('recent', 'top_rated', 'sale', 'featured', 'best_selling')
                    )

                ),
                array(
                    'id'          => 'layout',
                    'label' => esc_html__( 'Layout', 'uipro' ),
                    'type' => Controls_Manager::SELECT,
                    'options'       => array(
                        'base'    => esc_html__('Inherit Theme Style', 'uipro'),
                        'style1'    => esc_html__('Custom style 1', 'uipro'),
                    ),
                    'default'   => 'base',
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
                    'default'   => '4',
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
                    'default'   => '4',
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
                    'section_name'      => esc_html__('Images Settings', 'uipro')
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
			return array_merge($options, $this->get_general_options());
		}

	}
}