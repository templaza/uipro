<?php
/**
 * UIPro Image config class
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
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;

if ( ! class_exists( 'UIPro_Config_Templaza_Image' ) ) {
	/**
	 * Class UIPro_Config_Templaza_Image
	 */
	class UIPro_Config_Templaza_Image extends UIPro_Abstract_Config {

		/**
		 * UIPro_Config_Templaza_Image constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'templaza-image';
			self::$name = esc_html__( 'TemPlaza: Image', 'uipro' );
			self::$desc = esc_html__( 'Display Image.', 'uipro' );
			self::$icon = 'eicon-image';
			parent::__construct();
		}

		/**
		 * @return array
		 */
		public function get_options() {
			// options
			return array(
                array(
                    'type'      => Controls_Manager::MEDIA,
                    'name'      => 'templaza_image',
                    'label'     => esc_html__( 'Image', 'uipro' ),
                    'section_name'  => esc_html__( self::$name, 'uipro' ),
                ),
                array(
                    'type'      => Controls_Manager::SWITCHER,
                    'name'      => 'parallax_enable',
                    'label'     => esc_html__( 'Enable parallax', 'uipro' ),
                    'start_section' => 'parallax-options',
                    'section_name'  => esc_html__( 'Parallax options', 'uipro' ),
                ),
                array(
                    'type'      => Controls_Manager::TEXT,
                    'name'      => 'parallax_x',
                    'label'     => esc_html__( 'Animate translateX', 'uipro' ),
                    'section_name'  => esc_html__( 'Parallax options', 'uipro' ),
                    'condition'     => array('parallax_enable' => 'yes'),
                ),
                array(
                    'type'      => Controls_Manager::TEXT,
                    'name'      => 'parallax_y',
                    'label'     => esc_html__( 'Animate translateY', 'uipro' ),
                    'section_name'  => esc_html__( 'Parallax options', 'uipro' ),
                    'condition'     => array('parallax_enable' => 'yes'),
                ),
                array(
                    'type'      => Controls_Manager::TEXT,
                    'name'      => 'parallax_scaling',
                    'label'     => esc_html__( 'Animate scaling', 'uipro' ),
                    'section_name'  => esc_html__( 'Parallax options', 'uipro' ),
                    'condition'     => array('parallax_enable' => 'yes'),
                ),
                array(
                    'type'      => Controls_Manager::TEXT,
                    'name'      => 'parallax_opacity',
                    'label'     => esc_html__( 'Animate the opacity', 'uipro' ),
                    'start_section' => 'parallax-options',
                    'section_name'  => esc_html__( 'Parallax options', 'uipro' ),
                    'condition'     => array('parallax_enable' => 'yes'),
                ),
                array(
                    'type'      => Controls_Manager::TEXT,
                    'name'      => 'parallax_blur',
                    'label'     => esc_html__( 'Animate the blur filter', 'uipro' ),
                    'section_name'  => esc_html__( 'Parallax options', 'uipro' ),
                    'condition'     => array('parallax_enable' => 'yes'),
                ),
                array(
                    'type'          => Group_Control_Box_Shadow::get_type(),
                    'name'          => 'box_shadow',
                    'label'         => esc_html__('Box shadow', 'uipro'),
                    'selector'      => '{{WRAPPER}} .templaza-image',
                    'start_section' => 'style',
                    'section_tab'   => Controls_Manager::TAB_STYLE,
                    'section_name'  => esc_html__( self::$name, 'uipro' ),

                ),

			);
		}

        public function get_template_name() {
            return 'base';
        }
	}
}