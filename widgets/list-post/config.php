<?php
/**
 * UIPro List Post config class
 *
 * @version     1.0.0
 * @author      TemPlaza.com
 * @package     UIPro/Classes
 * @category    Classes
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;

if ( ! class_exists( 'UIPro_Config_List_Post' ) ) {
	/**
	 * Class UIPro_Config_Accordion
	 */
	class UIPro_Config_List_Post extends UIPro_Abstract_Config {

		/**
		 * UIPro_Config_List_Post constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'list-post';
			self::$name = esc_html__( 'TemPlaza: List Posts', 'uipro' );
			self::$desc = esc_html__( 'Display list posts.', 'uipro' );
			self::$icon = 'eicon-post-list';
			parent::__construct();
		}

		/**
		 * @return array
		 */
		public function get_options() {

//		    var_dump(UIPro_Helper::get_cat_taxonomy( 'category',
//                array( esc_html__( 'All', 'uipro' ) => 'all' ))); die();
		    // Options
            return array(
                array(
                    'type'          => Controls_Manager::TEXT,
                    'name'          => 'title',
                    'show_label'    => true,
                    'label'         => esc_html__( 'Title', 'uipro' ),
                    'default'       => '',
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'            => 'cat_id',
                    'label'         => esc_html__( 'Select Category', 'uipro' ),
                    'options'       => UIPro_Helper::get_cat_taxonomy( 'category',
                        array( 'all'  => esc_html__( 'All', 'uipro' )) ),
                    'default'       => 'all'
                ),
                array(
                    'type'          => Controls_Manager::NUMBER,
                    'name'          => 'number_posts',
                    'show_label'    => true,
                    'label'         => esc_html__( 'Number posts', 'uipro' ),
                    'default'       => '4',
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'orderby',
                    'show_label'    => true,
                    'label'         => esc_html__( 'Order by', 'uipro' ),
                    'options'       => array(
                        ''          => esc_html__( 'Select', 'uipro' ),
                        'popular'   => esc_html__( 'Popular', 'uipro' ),
                        'recent'    => esc_html__( 'Recent', 'uipro' ),
                        'title'     => esc_html__( 'Title', 'uipro' ),
                        'random'    => esc_html__( 'Random', 'uipro' ),
                    ),
                    'default'       => 'popular'
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'order',
                    'show_label'    => true,
                    'label'         => esc_html__( 'Order', 'uipro' ),
                    'options'       => array(
                        ''      => esc_html__( 'Select', 'uipro' ),
                        'asc'   => esc_html__( 'ASC', 'uipro' ),
                        'desc'  => esc_html__( 'DESC', 'uipro' ),
                    ),
                    'default'         => 'asc'
                ),
                array(
                    'type'      => Controls_Manager::SELECT,
                    'name'      => 'post_size',
                    'label'     => __( 'Post Title Tag', 'uipro' ),
                    'options'   => [
                        'h1' => 'H1',
                        'h2' => 'H2',
                        'h3' => 'H3',
                        'h4' => 'H4',
                        'h5' => 'H5',
                        'h6' => 'H6',
                        'div' => 'div',
                        'span' => 'span',
                        'p' => 'p',
                    ],
                    'default'   => 'h3',
                ),
                array(
                    'type'          => Controls_Manager::SELECT2,
                    'name'          => 'post_heading_style',
                    'default'       => '',
                    'label'         => esc_html__('Post Title Style', 'uipro'),
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
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'layout',
                    'show_label'    => true,
                    'label'         => esc_html__( 'Layout', 'uipro' ),
                    'options'       => array(
                        'base'  => esc_html__( 'Default', 'uipro' ),
                        'grid'  => esc_html__( 'Grid', 'uipro' ),
                    ),
                    'default'       => 'base',
                ),
                array(
                    'type'          => Controls_Manager::SWITCHER,
                    'name'          => 'show_date',
                    'label'         => esc_html__( 'Show Date', 'uipro' ),
                    'default'       => 'yes',
                    'separator'     => 'before',
                    /* vc params */
                    'value'         => array(
                        esc_html__( 'Yes', 'uipro' ) => true,
                    ),
                    'save_always'   => true,
                ),
                array(
                    'type'          => Controls_Manager::SWITCHER,
                    'name'          => 'show_author',
                    'label'         => esc_html__( 'Show Author', 'uipro' ),
                    'default'       => 'yes',
                    /* vc params */
                    'value'         => array(
                        esc_html__( 'Yes', 'uipro' ) => true,
                    ),
                    'save_always'   => true,
                ),
                array(
                    'type'          => Controls_Manager::SWITCHER,
                    'name'          => 'show_category',
                    'label'         => esc_html__( 'Show Category', 'uipro' ),
                    'default'       => 'yes',
                    /* vc params */
                    'value'         => array(
                        esc_html__( 'Yes', 'uipro' ) => true,
                    ),
                    'save_always'   => true,
                ),
                array(
                    'type'          => Controls_Manager::SWITCHER,
                    'name'          => 'show_post_count',
                    'label'         => esc_html__( 'Show Post Count', 'uipro' ),
                    'default'       => 'yes',
                    'condition'     => array(
                        'layout'    => 'base'
                    ),
                    /* vc params */
                    'value'         => array(
                        esc_html__( 'Yes', 'uipro' ) => true,
                    ),
                    'save_always'   => true,
                ),
                array(
                    'type'          => Controls_Manager::SWITCHER,
                    'name'          => 'show_description',
                    'label'         => esc_html__( 'Show Description', 'uipro' ),
                    'default'       => 'yes',
                    /* vc params */
                    'value'         => array(
                        esc_html__( 'Yes', 'uipro' ) => true,
                    ),
                    'save_always'   => true,
                ),
                array(
                    'type'          => Controls_Manager::NUMBER,
                    'name'          => 'description_limit',
                    'label'         => esc_html__('Description Limit', 'uipro'),
                    'min'           => 0,
                    'default'       => 13,
                    'condition'     => ['show_description' => 'yes'],
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'image_size',
                    'label'         => esc_html__( 'Select Image Size', 'uipro' ),
                    'options'       => UIPro_Helper::get_list_image_size(),
                    'default'       => 'none',
                    'condition'     => ['layout' => 'base'],
                ),
                array(
                    'type'          => Controls_Manager::ICONS,
                    'name'          => 'list_icon',
                    'label'         => esc_html__( 'Post List Icon', 'uipro' ),
                    /* vc params */
                    'value'         => '',
                    'admin_label'   => true,
                ),

                /* Grid settings */
                array(
                    'type'          => Controls_Manager::SWITCHER,
                    'name'          => 'item_horizontal',
                    'label'         => esc_html__( 'Horizontal Alignment', 'uipro' ),
                    'condition'     => array(
                        'layout'    => 'grid',
                    ),
                    'start_section'     => 'grid_settings',
                    'section_name'      => esc_html__( 'Grid Settings', 'uipro' ),
                    /* vc param */
                    'value'         => '',
                    'admin_label'   => true,
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'img_h_align',
                    'label'         => esc_html__( 'Image Align', 'uipro' ),
                    'options'       => [
                        'left'      => __( 'Left', 'uipro' ),
                        'right'     => __( 'Right', 'uipro' ),
                    ],
                    'default'       => 'left',
                    'condition'     => array(
                        'layout'            => 'grid',
                        'item_horizontal'   => 'yes',
                    ),
                    'section_name'      => esc_html__( 'Grid Settings', 'uipro' ),
                    /* vc param */
                    'value'         => '',
                    'admin_label'   => true,
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'img_align',
                    'label'         => esc_html__( 'Image Align', 'uipro' ),
                    'options'       => [
                        'top'       => __( 'Top', 'uipro' ),
                        'bottom'    => __( 'Bottom', 'uipro' ),
                    ],
                    'default'       => 'top',
                    'condition'     => array(
                        'layout'            => 'grid',
                        'item_horizontal!'  => 'yes',
                    ),
                    'section_name'      => esc_html__( 'Grid Settings', 'uipro' ),
                    /* vc param */
                    'value'         => '',
                    'admin_label'   => true,
                ),

                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'column',
                    'label'         => esc_html__( 'Columns', 'uipro' ),
                    'options'       => array(
                        1     => esc_html__( '1', 'uipro' ),
                        2     => esc_html__( '2', 'uipro' ),
                        3     => esc_html__( '3', 'uipro' ),
                        4     => esc_html__( '4', 'uipro' ),
                        5     => esc_html__( '5', 'uipro' ),
                        6     => esc_html__( '6', 'uipro' ),
                    ),
                    'desktop_default'       => 3,
                    'tablet_default'        => 2,
                    'mobile_default'        => 1,
                    'responsive'            => true,
                    'condition'             => array(
                        'layout'            => 'grid',
                        'item_horizontal!'  => 'yes',
                    ),
                    'section_name'          => esc_html__( 'Grid Settings', 'uipro' ),
                    /* vc param */
                    'admin_label'           => true,
                ),
                array(
                    'type'          => Controls_Manager::TEXT,
                    'name'          => 'img_w',
                    'show_label'    => true,
                    'label'         => esc_html__( 'Image width', 'uipro' ),
                    'condition'     => array(
                        'layout'    => 'grid',
                    ),
                    'section_name'  => esc_html__( 'Grid Settings', 'uipro' ),
//                    /* vc param */
//                    'group'         => esc_html__( 'Grid Settings', 'uipro' ),
                ),

                array(
                    'type'          => Controls_Manager::TEXT,
                    'name'          => 'img_h',
                    'label'         => esc_html__( 'Image height', 'uipro' ),
                    'condition'     => array(
                        'layout'    => 'grid',
                    ),
                    'section_name'  => esc_html__( 'Grid Settings', 'uipro' ),
                    /* vc param */
                    'value'         => '',
                    'admin_label'   => true,
                ),

//                array(
//                    'type'          => Controls_Manager::SWITCHER,
//                    'name'          => 'display_feature',
//                    'label'         => esc_html__( 'Show feature posts', 'uipro' ),
//                    'condition'     => array(
//                        'layout'    => 'grid',
//                    ),
//                    'start_section' => 'grid_settings',
//                    'section_name'  => esc_html__( 'Grid Settings', 'uipro' ),
//                    /* vc params */
//                    'value'         => array(
//                        esc_html__( 'Yes', 'uipro' ) => 'yes',
//                    ),
////                    'group'         => esc_html__( 'Grid Settings', 'uipro' ),
//                ),

//                array(
//                    'type'          => Controls_Manager::NUMBER,
//                    'name'          => 'item_vertical',
//                    'show_label'    => true,
//                    'label'         => esc_html__( 'Items vertical', 'uipro' ),
//                    'default'       => '0',
//                    'condition'     => array(
//                        'layout'    => 'grid',
//                    ),
//                    'start_section' => 'grid_settings',
//                    'section_name'  => esc_html__( 'Grid Settings', 'uipro' ),
//                    /* vc params */
////                    'group'         => esc_html__( 'Grid Settings', 'uipro' ),
//                ),

                /* Start Link */
                array(
                    'type'          => Controls_Manager::TEXT,
                    'name'          => 'link',
                    'label'         => esc_html__( 'Link All Posts', 'uipro' ),
                    'start_section' => 'tz_link',
                    'section_name'  => esc_html__( 'Link', 'uipro' ),
                    /* vc params */
                    'value'         => '',
                    'admin_label'   => true,
                ),

                array(
                    'type'          => Controls_Manager::TEXT,
                    'name'          => 'text_link',
                    'label'         => esc_html__( 'Text All Posts', 'uipro' ),
                    'section_name'  => esc_html__( 'Link', 'uipro' ),
                    /* vc params */
                    'value'         => '',
                    'admin_label'   => true,
                ),

                array(
                    'type'          => Controls_Manager::ICONS,
                    'name'          => 'link_icon',
                    'label'         => esc_html__( 'Link All Icon', 'uipro' ),
                    'section_name'  => esc_html__( 'Link', 'uipro' ),
                    /* vc params */
                    'value'         => '',
                    'admin_label'   => true,
                ),

                /* Style tab */
                array(
                    'type'          => Group_Control_Typography::get_type(),
                    'name'          => 'typography',
                    'label'         => esc_html__('Typography'),
                    'scheme'        => Typography::TYPOGRAPHY_1,
                    'start_section' => 'style',
                    'section_tab'   => Controls_Manager::TAB_STYLE,
                    'section_name'  => esc_html__( self::$name, 'uipro' ),
                    'selector'      => '{{WRAPPER}}',
                ),
                array(
                    'type'          => Group_Control_Typography::get_type(),
                    'name'          => 'meta_typography',
                    'label'         => esc_html__('Post Count Typography'),
                    'scheme'        => Typography::TYPOGRAPHY_1,
                    'section_name'  => esc_html__( self::$name, 'uipro' ),
                    'selector'      => '{{WRAPPER}} .number-posts',
                ),
                array(
                    'type'          => Group_Control_Typography::get_type(),
                    'name'          => 'post_title_typography',
                    'label'         => esc_html__('Post Title Typography'),
                    'scheme'        => Typography::TYPOGRAPHY_1,
                    'section_name'  => esc_html__( self::$name, 'uipro' ),
                    'selector'      => '{{WRAPPER}} .article-heading',
                ),
                array(
                    'type'          => Group_Control_Typography::get_type(),
                    'name'          => 'link_all_typography',
                    'label'         => esc_html__('Link All Typography'),
                    'scheme'        => Typography::TYPOGRAPHY_1,
                    'section_name'  => esc_html__( self::$name, 'uipro' ),
                    'selector'      => '{{WRAPPER}} .read-more',
                ),
            );
		}

	}
}