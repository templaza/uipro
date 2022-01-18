<?php
/**
 * TemPlaza Elements Elementor widget class
 *
 * @version     1.0.0
 * @author      TemPlaza
 * @package     TemPlaza/Classes
 * @category    Classes
 */

use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Text_Shadow;
use \Elementor\Widget_Base;
use UIPro\UIPro_Functions;

/**
 * Prevent loading this file directly
 */
defined( 'UIPRO' ) || exit;

if ( ! class_exists( 'UIPro_El_Widget' ) ) {
    /**
     * Class UIPro_El_Widget
     */
    abstract class UIPro_El_Widget extends Widget_Base {

        /**
         * @var string
         */
        protected $config_class = '';
        /**
         * @var string
         */
        protected $config_base = '';
        /**
         * @var null
         */
        protected $keywords = array();

        /**
         * @var null
         */
        protected $class = null;
        /**
         * @var null
         */
        protected $text_domain = null;

        /**
         * Thim_Builder_El_Widget constructor.
         *
         * @param array      $data
         * @param array|null $args
         *
         * @throws Exception
         */
        public function __construct( array $data = [], array $args = null ) {

            if ( ! $this->config_class ) {
                return;
            }

            $this -> text_domain    = UIPro_Functions::get_my_text_domain();

            /**
             * @var $config_class UIPro_Abstract_Config
             */
            $config_class = new $this->config_class();
            $config_class::register_scripts();

            parent::__construct( $data, $args );
        }

        public function preview_scripts() {
            /**
             * @var $config_class UIPro_Abstract_Config
             */
            $config_class = new $this->config_class();

            $config_class::register_scripts();
        }

        /**
         * Register scripts
         */

        /**
         * @return mixed|string
         */
        public function get_name() {
            if ( ! empty( $this->config_base ) ) {
                return 'uipro-' . $this->config_base;
            } else {
                if ( ! $this->config_class ) {
                    return '';
                }
                // config class
                $config_class = new $this->config_class();

                return 'uipro-' . $config_class::$base;
            }
        }

        /**
         * @return mixed|string
         */
        public function get_icon() {
            if ( ! $this->config_class ) {
                return '';
            }
            // config class
            $config_class = new $this->config_class();

            return $config_class::$icon;
        }

        /**
         * @return string
         */
        public function get_base() {
            if ( ! $this->config_class ) {
                return '';
            }

            // config class
            $config_class = new $this->config_class();

            return $config_class::$base;
        }

        /**
         * @return mixed|string
         */
        public function get_title() {

            if ( ! $this->config_class ) {
                return '';
            }

            // config class
            $config_class = new $this->config_class();

            return $config_class::$name;
        }

        /**
         * @return string
         */
        public function get_group() {

            if ( ! $this->config_class ) {
                return '';
            }

            // config class
            $config_class = new $this->config_class();

            return $config_class::$group;
        }

        /**
         * @return string
         */
        public function get_template_name() {

            if ( ! $this->config_class ) {
                return '';
            }

            // config class
            $config_class = new $this->config_class();

            return $config_class::$template_name;
        }

        /**
         * @return array
         */
        public function get_categories() {
            return array( UIPRO );
        }

        /**
         * @return array
         */
        public function get_keywords() {
            $keywords = array_merge( $this->keywords, array( $this->get_name(), $this -> text_domain ) );

            return $keywords;
        }

        /**
         * Register controls.
         */
        protected function register_controls() {

            $this->start_controls_section(
                'el-'.$this -> get_base(), [ 'label' => $this -> get_title() ]
            );

            $controls =  $this->options();
//            $controls = \UIPro_Builder_El_Mapping::mapping( $this->options() );
            $current_section    = '';
            foreach ( $controls as $index => $control ) {
                $id    = isset($control['id'])?$control['id']:$control['name'];
                if (isset( $control['start_section'] ) && $current_section != $control['start_section']) {

                    $sec_args   = ['label' => $control['section_name']];
                    if(isset($control['section_tab']) && $control['section_tab']){
                        $sec_args['tab']    = $control['section_tab'];
                    }

                    $this->end_controls_section();
                    $this->start_controls_section(
                        $control['start_section'], $sec_args
                    );

                    $current_section = $control['start_section'];
                }
				
                if(isset($control['id'])){
                    unset($control['id']);
                }

                $group_controls = array(Group_Control_Background::get_type(), Group_Control_Typography::get_type(),
                    Group_Control_Text_Shadow::get_type(), Group_Control_Border::get_type(),
                    Group_Control_Image_Size::get_type(), Group_Control_Box_Shadow::get_type());
                if(isset($control['responsive']) && $control['responsive']){
                    unset($control['responsive']);
                    $this->add_responsive_control($id, $control);
                }elseif(isset($control['type']) && in_array($control['type'], $group_controls)){
                    $this -> add_group_control($control['type'], $control);
                }
                else {
                    $this->add_control( $id, $control );
                }
            }

            $this->end_controls_section();
        }

        /**
         * @return array
         */
        public function get_script_depends() {
            /**
             * @var $config_class UIPro_Abstract_Config
             */
            $config_class = new $this->config_class();

            $assets = $config_class::_get_assets();

            $depends = array();
            if ( ! empty( $assets['scripts'] ) ) {
                foreach ( $assets['scripts'] as $key => $script ) {
                    $depends[] = $key;
                }
            }

            return $depends;
        }

        /**
         * @return array
         */
        public function get_style_depends() {
            /**
             * @var $config_class UIPro_Abstract_Config
             */
            $config_class = new $this->config_class();

            $assets = $config_class::_get_assets();

            $depends = array();
            if ( ! empty( $assets['styles'] ) ) {
                foreach ( $assets['styles'] as $key => $style ) {
                    $depends[] = $key;
                }
            }

            return $depends;
        }

        /**
         * Render.
         */
        protected function render() {
            if ( ! $this->config_class ) {
                return;
            }

            // allow hook before template
            do_action( 'templaza-elements/before-element-template', $this->get_name() );

            // get settings
            $settings = $this->get_settings_for_display();

            // handle settings
            $settings = $this->_handle_settings( $this->convert_setting( $settings ) );

            // fix for old themes by tuanta
//            $params       = thim_builder_folder_group() ? 'params' : 'instance';
//            $group_folder = thim_builder_folder_group() ? $this->get_group() . '/' : '';
            $params       = 'instance';
            $group_folder = '';

            $args                 = array();
            $args['before_title'] = '<h3 class="widget-title">';
            $args['after_title']  = '</h3>';
            $args['element_id']   = $this -> get_id();
            $args['page_builder'] = 'elementor';

            $settings = array_merge(
                $settings, array(
                    'group'         => $this->get_group(),
                    'base'          => $this->get_base(),
                    'template_path' => $group_folder . $this->get_base() . '/tpl/'
                )
            );
			$container  =   isset($settings['uk_container']) && $settings['uk_container'] ? $settings['uk_container'] : '';
			if ($container) {
				if ($container == 'default') {
					$container = ' uk-container';
				} else {
					$container = ' uk-container uk-container-'.$container;
				}
			}
	        $margin_top = ( isset( $settings['addon_margin_top'] ) && $settings['addon_margin_top'] ) ? $settings['addon_margin_top'] : '';
	        $margin_top = ( $margin_top ) ? ' uk-margin' . ( ( $margin_top == 'default' ) ? '-top' : '-' . $margin_top .'-top' ) : '';

	        $margin_bottom = ( isset( $settings['addon_margin_bottom'] ) && $settings['addon_margin_bottom'] ) ? $settings['addon_margin_bottom'] : '';
	        $margin_bottom = ( $margin_bottom ) ? ' uk-margin' . ( ( $margin_bottom == 'default' ) ? '-bottom' : '-' . $margin_bottom .'-bottom' ) : '';

            $base_file = $this->get_template_name() ? $this->get_template_name() : $this->get_base();
            echo '<div class="templaza-widget-' . $this->get_base() . ' template-' . $base_file . $container . $margin_top . $margin_bottom . '">';

//            var_dump($base_file,
//                array( $params => $settings, 'args' => $args ), $settings['template_path'] ); die();
//            \UIPro_Elementor_Helper::get_widget_template( $base_file,
//                array( $params => $settings ), $settings['template_path'] );
            \UIPro_Elementor_Helper::get_widget_template( $base_file,
                array( $params => $settings, 'args' => $args ), $settings['template_path'] );

            echo '</div>';
        }

        /**
         * @param      $settings
         * @param null $controlsx
         *
         * @return mixed
         */
        private function _handle_settings( $settings, $controls = null ) {

            if ( ! $controls ) {
                $controls = $this->options();
            }

//            foreach ( $controls as $key => $control ) {
//                if (isset($control['param_name']) &&  array_key_exists( $control['param_name'], $settings ) ) {
//
//                    $type  = $control['type'];
//                    $value = $settings[$control['param_name']];
//                    switch ( $type ) {
//                        case 'param_group':
//                            if ( isset( $value ) ) {
//                                foreach ( $value as $_key => $_value ) {
//                                    $settings[$control['param_name']][$_key] = $this->_handle_settings( $_value, $control['params'] );
//                                }
//                            }
//                            break;
//
//                        case 'vc_link':
//                            $settings[$control['param_name']] = array(
//                                'url'    => $value['url'],
//                                'target' => $value['is_external'] == 'on' ? '_blank' : '',
//                                'rel'    => $value['nofollow'] == 'on' ? 'nofollow' : '',
//                                'title'  => ''
//                            );
//                            break;
//                        case 'attach_image':
//                            $settings[$control['param_name']] = isset( $value ) ? $value['id'] : '';
//                            break;
//                        default:
//                            // fix for param group
//                            //							if ( isset( $control['group_id'] ) ) {
//                            //								$settings[$control['group_id']][$control['param_name']] =  $value;
//                            //							}
//                            break;
//                    }
//                }
//            }

            return $settings;
        }

        /**
         * @return array
         */
        public function options() {
            if ( ! $this->config_class ) {
                return array();
            }

            // config class
            $config_class = new $this->config_class();
            $options      = $config_class::$options;
//            foreach ( $options as $key_lv1 => $value_lv1 ) {
//                if ( $value_lv1['type'] != 'param_group' ) {
//                    continue;
//                }
//                $params_lv1 = $value_lv1['params'];
//                foreach ( $params_lv1 as $key_lv2 => $value_lv2 ) {
//                    if ( $value_lv2['type'] != 'param_group' ) {
//                        continue;
//                    }
//                    if ( isset( $value_lv2['max_el_items'] ) && $value_lv2['max_el_items'] > 0 ) {
//                        $params_lv2    = $value_lv2['params'];
//                        $separate_text = $params_lv1[$key_lv2]['heading'];
//                        unset( $params_lv1[$key_lv2] );
//                        $params_lv1 = array_values( $params_lv1 );
//                        $i          = 0;
//                        while ( $i < $value_lv2['max_el_items'] ) {
//                            $i ++;
//                            $default_hidden = array();
//                            foreach ( $params_lv2 as $key_lv3 => $value_lv3 ) {
//                                $horizon = array(
//                                    'type'       => 'bp_heading',
//                                    'heading'    => $separate_text . ' #' . $i,
//                                    'param_name' => 'horizon_line' . ' #' . $i
//                                );
//                                if ( $i === 1 ) {
//                                    $default_hidden[] = $value_lv3['param_name'];
//                                    $hidden           = array(
//                                        'type'       => 'bp_hidden',
//                                        'param_name' => $value_lv2['param_name'],
//                                        'std'        => $value_lv2['max_el_items'] . '|' . implode( ',', $default_hidden )
//                                    );
//                                    $params_lv1[]     = $hidden;
//                                }
//                                $params_lv1[]            = $horizon;
//                                $value_lv3['param_name'] = $value_lv3['param_name'] . $i;
//                                if ( isset( $value_lv3['dependency'] ) && $value_lv3['dependency']['element'] != '' ) {
//                                    $value_lv3['dependency']['element'] = $value_lv3['dependency']['element'] . $i;
//                                }
//                                $params_lv1[] = $value_lv3;
//                            }
//                        }
//                    }
//                }
//                $options[$key_lv1]['params'] = $params_lv1;
//            }

            return $options;
        }

        /**
         * @return string
         */
        public function assets_url() {
            if ( ! $this->config_class ) {
                return '';
            }

            // config class
            $config_class = new $this->config_class();

            return $config_class::$assets_url;
        }

        // convert setting
        public function convert_setting( $settings ) {
            return $settings;
        }
    }

}