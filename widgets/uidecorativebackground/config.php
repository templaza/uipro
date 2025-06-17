<?php
/**
 * UIPro Decorative Background config class
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


if ( ! class_exists( 'UIPro_Config_UIDecorativeBackground' ) ) {
	/**
	 * Class UIPro_Config_UIDecorativeBackground
	 */
	class UIPro_Config_UIDecorativeBackground extends UIPro_Abstract_Config {

		/**
		 * UIPro_Config_Heading constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'uidecorativebackground';
			self::$name = esc_html__( 'TemPlaza: UI Decorative Background', 'uipro' );
			self::$desc = esc_html__( 'Add UI Decorative Background.', 'uipro' );
			self::$icon = 'eicon-background';
			parent::__construct();

            wp_enqueue_script('uidecorativebackground-perlin');
            wp_enqueue_script_module('uidecorativebackground-index');

		}

        public function get_styles() {
            return array(
                'uidecorativebackground' => array(
                    'src'   =>  'style.css'
                )
            );
        }



		/**
		 * @return array
		 */
		public function get_options() {

            $store_id   = md5(__METHOD__);

            if(isset(static::$cache[$store_id])){
                return static::$cache[$store_id];
            }

			$options = array(
                array(
                    'name'          => 'background_style',
                    'label' => esc_html__( 'Background Style', 'uipro' ),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => 'physics',
                    'options' => [
                        'physics' => esc_html__('Physics', 'uipro' ),
                        'quantum' => esc_html__('Quantum', 'uipro') ,
                        'hawking' => esc_html__('Hawking', 'uipro') ,
                        'heuristics' => esc_html__('Heuristics', 'uipro') ,
                    ],
                ),

                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'color1',
                    'global'          => array('active' => false,),
                    'label'         => esc_html__('Color1', 'uipro'),
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'color2',
                    'global'          => array('active' => false,),
                    'label'         => esc_html__('Color2', 'uipro'),
                ),

			);
			$options    = array_merge($options, $this->get_general_options());

			static::$cache[$store_id]   = $options;

			return $options;
		}

		public function get_template_name() {
			return 'base';
		}
	}
}