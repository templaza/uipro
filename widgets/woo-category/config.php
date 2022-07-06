<?php
/**
 * UIPro Woocommerce Category config class
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

if ( ! class_exists( 'UIPro_Config_Woo_Category' ) ) {
	/**
	 * Class UIPro_Config_Woo_Category
	 */
	class UIPro_Config_Woo_Category extends UIPro_Abstract_Config {

		/**
		 * UIPro_Config_Heading constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'woo-category';
			self::$name = esc_html__( 'TemPlaza: Woocommerce Category', 'uipro' );
			self::$desc = esc_html__( 'Display Woocommerce Categories.', 'uipro' );
			self::$icon = 'eicon-gallery-grid';
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
                        'base'    => esc_html__('Default', 'uipro'),
                        'style1'    => esc_html__('Custom style 1', 'uipro'),
                    ),
                    'default'   => 'base',
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
                /* Item settings */
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'cat_box_padding',
                    'label'         => esc_html__( 'Item Padding', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .woo-cat-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'start_section' => 'item-options',
                    'section_name'  => esc_html__( 'Item Settings', 'uipro' ),
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'cat_title_margin',
                    'label'         => esc_html__( 'Title margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .woo-cat-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],

                ),
                array(
                    'type'          =>  \Elementor\Group_Control_Border::get_type(),
                    'name'          => 'card_border',
                    'label'         => esc_html__('Item Border', 'uipro'),
                    'description'   => esc_html__('Set the Border of Box.', 'uipro'),
                    'selector' => '{{WRAPPER}} .woo-cat-item',
                ),
                array(
                    'type'          =>  \Elementor\Group_Control_Box_Shadow::get_type(),
                    'name'          => 'card_box_shadow',
                    'label'         => esc_html__('Item Box Shadow', 'uipro'),
                    'description'   => esc_html__('Set the Box Shadow of Box.', 'uipro'),
                    'selector' => '{{WRAPPER}} .woo-cat-item',
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'card_radius',
                    'label'         => esc_html__( 'Border radius', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .woo-cat-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;',
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
                    'name'          => 'category_typography',
                    'label'         => esc_html__('Category Typography'),
                    'scheme'        => Typography::TYPOGRAPHY_1,
                    'start_section' => 'style',
                    'section_tab'   => Controls_Manager::TAB_STYLE,
                    'section_name'  => esc_html__( self::$name, 'uipro' ),
                    'selector'      => '{{WRAPPER}} .woo-cat-title',
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'info_bg_color',
                    'label'         => esc_html__('Box background Color', 'uipro'),
                    'description'   => esc_html__('Set the background color of box.', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .woo-cat-item' => 'background-color: {{VALUE}}',
                    ],
                    'separator'     => 'before',
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'category_color',
                    'label'         => esc_html__('Category Color', 'uipro'),
                    'description'   => esc_html__('Set the color of category.', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .woo-cat-title' => 'color: {{VALUE}}',
                    ],
                ),
			);
			$options    = array_merge($options, $this->get_general_options());

			static::$cache[$store_id]   = $options;

			return $options;
		}

	}
}