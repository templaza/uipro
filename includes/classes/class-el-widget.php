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

        protected $config_loaded    = array();

        protected $cache    = array();

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

            /**
             * @var $config_class Templaza_Elements_Abstract_Config
             */
//            if(!isset($this -> config_loaded[$this -> config_class]) || !$this -> config_loaded[$this -> config_class]) {
            $config_class = new $this->config_class();
            $config_class::register_scripts();
//                $this -> config_loaded[$this -> config_class]  = $config_class;
//            }

            parent::__construct( $data, $args );
        }

        public function preview_scripts() {
            /**
             * @var $config_class UIPro_Abstract_Config
             */
//            // config class
//            if(!isset($this -> config_loaded[$this -> config_class]) || !$this -> config_loaded[$this -> config_class]) {
            // config class
            $config_class = new $this->config_class();
//            }else{
//                $config_class   = $this -> config_loaded[$this -> config_class];
//            }

            $config_class::register_scripts();
//            $config_class::enqueue_scripts();
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
//                if(!isset($this -> config_loaded[$this -> config_class]) || !$this -> config_loaded[$this -> config_class]) {
                // config class
                $config_class = new $this->config_class();
//                }else{
//                    $config_class   = $this -> config_loaded[$this -> config_class];
//                }

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
//            if(!isset($this -> config_loaded[$this -> config_class]) || !$this -> config_loaded[$this -> config_class]) {
//                // config class
//                $config_class = new $this->config_class();
//            }else{
//                $config_class   = $this -> config_loaded[$this -> config_class];
//            }

            return $config_class::$icon;
        }

        /**
         * @return string
         */
        public function get_base() {
            if ( ! $this->config_class ) {
                return '';
            }

//            // config class
//            if(!isset($this -> config_loaded[$this -> config_class]) || !$this -> config_loaded[$this -> config_class]) {
            // config class
            $config_class = new $this->config_class();
//            }else{
//                $config_class   = $this -> config_loaded[$this -> config_class];
//            }

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
//            if(!isset($this -> config_loaded[$this -> config_class]) || !$this -> config_loaded[$this -> config_class]) {
//                // config class
//                $config_class = new $this->config_class();
//            }else{
//                $config_class   = $this -> config_loaded[$this -> config_class];
//            }

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
//            if(!isset($this -> config_loaded[$this -> config_class]) || !$this -> config_loaded[$this -> config_class]) {
//                // config class
//                $config_class = new $this->config_class();
//            }else{
//                $config_class   = $this -> config_loaded[$this -> config_class];
//            }

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
//            if(!isset($this -> config_loaded[$this -> config_class]) || !$this -> config_loaded[$this -> config_class]) {
//                // config class
//                $config_class = new $this->config_class();
//            }else{
//                $config_class   = $this -> config_loaded[$this -> config_class];
//            }

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
            $keywords = array_merge( $this->keywords, array( $this->get_name(), 'uipro' ) );

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
                $id    = isset($control['id'])?$control['id']:(isset($control['name'])?$control['name']:'');
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
                elseif(isset($control['type']) && in_array($control['type'], array('control_tabs', 'control_tab'))){
                    if(isset($control['indent']) && !$control['indent']){
                        if($control['type'] == 'control_tabs') {
                            $this->end_controls_tabs();
                        }elseif($control['type'] == 'control_tab'){
                            $this -> end_controls_tab();
                        }
                    }else {
                        if($control['type'] == 'control_tabs') {
                            $this->start_controls_tabs($id);
                        }elseif($control['type'] == 'control_tab'){
                            $this -> start_controls_tab($id, $control);
//                            $this -> start_controls_tab($id, [
//                                'label' => $control['label']
//                            ]);
                        }
                    }
                    continue;
                }
                elseif(isset($control['type']) && $control['type'] == 'control_popover'){
                    // Popovers control
                    if(isset($control['indent']) && !$control['indent']){
                        $this->end_popover();
                    }else{
                        $this->start_popover();
                    }
                    continue;
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
            $store_id   = __METHOD__;
            $store_id  .= '::'.get_called_class();
            $store_id   = md5($store_id);

            if(isset($this -> cache[$store_id])){
                return $this -> cache[$store_id];
            }

            /**
             * @var $config_class Templaza_Elements_Abstract_Config
             */
            if(!isset($this -> config_loaded[$this -> config_class]) || !$this -> config_loaded[$this -> config_class]) {
                // config class
                $config_class = new $this->config_class();
            }else{
                $config_class   = $this -> config_loaded[$this -> config_class];
            }

            $assets = $config_class::_get_assets();

            $depends = array();
            if ( ! empty( $assets['scripts'] ) ) {
                foreach ( $assets['scripts'] as $key => $script ) {
                    if(isset($script['deps_src']) && !empty($script['deps_src'])){
                        foreach ($script['deps_src'] as $dep_name => $dep_src){
                            $depends[]  = $dep_name;
                        }
                    }
                    $depends[] = $key;
                }
            }

            if(count($depends)){
                $this -> cache[$store_id]   = $depends;
            }

            return $depends;
        }

        /**
         * @return array
         */
        public function get_style_depends() {
            $store_id   = __METHOD__;
            $store_id  .= '::'.get_called_class();
            $store_id   = md5($store_id);

            if(isset($this -> cache[$store_id])){
                return $this -> cache[$store_id];
            }

//            /**
//             * @var $config_class Templaza_Elements_Abstract_Config
//             */
//            if(!isset($this -> config_loaded[$this -> config_class]) || !$this -> config_loaded[$this -> config_class]) {
            // config class
            $config_class = new $this->config_class();
//            }else{
//                $config_class   = $this -> config_loaded[$this -> config_class];
//            }

            $assets = $config_class::_get_assets();

            $depends = array();
            if ( ! empty( $assets['styles'] ) ) {
                foreach ( $assets['styles'] as $key => $style ) {
                    if(isset($style['deps_src']) && !empty($style['deps_src'])){
                        foreach ($style['deps_src'] as $dep_name => $dep_src){
                            $depends[]  = $dep_name;
                        }
                    }
                    $depends[] = $key;
                }
            }

            if(count($depends)){
                $this -> cache[$store_id]   = $depends;
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
            $settings = $this->convert_setting( $settings );

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

            $parallax  =   isset($settings['templaza_parallax_image']) && $settings['templaza_parallax_image'] ? $settings['templaza_parallax_image'] : '';
            if($parallax["url"]){
                echo '<div class="uk-cover-container uk-position-cover"><div data-uk-scrollspy="" data-uk-parallax="bgy: 100; bgx:0;" class="uk-cover-container uk-background-cover uk-position-cover" style="background-image:url('.esc_url($parallax["url"]).')">
            </div><div class="uk-overlay uk-position-cover templaza-parallax-overlay"></div></div>';
            }

            $base_file = $this->get_template_name() ? $this->get_template_name() : $this->get_base();
            echo '<div class="templaza-parallax templaza-widget-' . $this->get_base() . ' template-' . $base_file . $container . $margin_top . $margin_bottom . '">';

            \UIPro_Elementor_Helper::get_widget_template( $base_file,
                array( $params => $settings, 'args' => $args, 'el' => $this ), $settings['template_path'] );

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

            return $settings;
        }

        /**
         * @return array
         */
        public function options() {
            if ( ! $this->config_class ) {
                return array();
            }

//            if(!isset($this -> config_loaded[$this -> config_class]) || !$this -> config_loaded[$this -> config_class]) {
            // config class
            $config_class = new $this->config_class();
//            }else{
//                $config_class   = $this -> config_loaded[$this -> config_class];
//            }

            $options      = $config_class::$options;

            return $options;
        }

        /**
         * @return string
         */
        public function assets_url() {
            if ( ! $this->config_class ) {
                return '';
            }

//            if(!isset($this -> config_loaded[$this -> config_class]) || !$this -> config_loaded[$this -> config_class]) {
            // config class
            $config_class = new $this->config_class();
//            }else{
//                $config_class   = $this -> config_loaded[$this -> config_class];
//            }

            return $config_class::$assets_url;
        }

        // convert setting
        public function convert_setting( $settings ) {
            return $settings;
        }
    }

}