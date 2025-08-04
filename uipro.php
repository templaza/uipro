<?php
/*
Plugin Name: UIPro
Plugin URI: https://github.com/templaza/uipro
Description: This plugin help you manage products.
Author: Templaza
Version: 1.1.4
Text Domain: uipro
Author URI: http://templaza.com
Forum: https://www.templaza.com/Forums.html
Ticket: https://www.templaza.com/tz_membership/addticket.html
FanPage: https://www.facebook.com/templaza
Twitter: https://twitter.com/templazavn
Google+: https://plus.google.com/+Templaza
*/

namespace UIPro;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class UIPro{

    protected static $instance;
    protected static $_core_els    = array();

    protected $cache    = array();

    public function __construct()
    {
        require_once dirname(__FILE__).'/includes/autoloader.php';

        self::$_core_els  = array(
            'general' => array(
                'list-post'
            )
        );
    }

    public static function instance(){
        if(static::$instance){
            return static::$instance;
        }

        $instance   = new UIPro();

        static::$instance   = $instance;
        return $instance;
    }

    public function init(){
        $this -> hooks();
    }

    protected function hooks(){
        add_action( 'after_setup_theme', array( $this, 'init_elements' ) );
        if(is_admin()) {
            add_action('admin_init', array($this, 'update_checker'));
        }
        add_action( 'init', array( $this, 'ui_load_plugin_textdomain' ) );
        add_action( 'elementor/element/container/section_layout/after_section_end', array($this,'uipro_elementor'),10,2 );

    }
    public function ui_load_plugin_textdomain() {
        load_plugin_textdomain( 'uipro', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
        wp_enqueue_style( 'uipro-style', plugins_url( '/assets/css/style.css', __FILE__ ));
        wp_enqueue_script( 'three-js', plugins_url( '/assets/vendor/three/three.min.js', __FILE__ ), array(), time(), true );
        wp_enqueue_script( 'gsap-js', 'https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/gsap.min.js', array(), false, true );
    }
    function uipro_elementor($element, $args){
        $element->start_controls_section(
            'custom_section_settings',
            [
                'label' => __('UiPro Section Setting', 'uipro'),
                'tab' => \Elementor\Controls_Manager::TAB_ADVANCED,
            ]
        );

        $element->add_control(
            'custom_toggle_option',
            [
                'label' => __('Smooth Scroll', 'uipro'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Enable', 'uipro'),
                'label_off' => __('Disable', 'uipro'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $element->add_control(
            'custom_text_option',
            [
                'label' => __('Tiêu đề tùy chỉnh', 'text-domain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Nhập tiêu đề...', 'text-domain'),
                'placeholder' => __('Nhập nội dung...', 'text-domain'),
                'condition' => [
                    'custom_toggle_option' => 'yes',
                ],
            ]
        );
        $element->end_controls_section();
    }

    /**
     * Init elements config.
     */
    public function init_elements() {

        if (!function_exists('is_plugin_active')) {
            include_once(ABSPATH . 'wp-admin/includes/plugin.php');
        }

        if ( !is_plugin_active( 'elementor/elementor.php' ) ) {
            return;
        }

        $elements = self::get_elements();

        if ( empty( $elements ) ) {
            return;
        }

        require_once( UIPRO_CLASSES_PATH . '/class-abstract-config.php' );

        // elementor
        if ( is_plugin_active( 'elementor/elementor.php' ) ) {
            if(file_exists(UIPRO_CLASSES_PATH . '/class-el.php')) {
                require_once(UIPRO_CLASSES_PATH . '/class-el.php');
            }
        }
        // widgets
        if(file_exists(UIPRO_CLASSES_PATH . '/siteorigin/class-so.php')) {
            require_once(UIPRO_CLASSES_PATH . '/siteorigin/class-so.php');
        }

        // visual composer
        if ( is_plugin_active( 'js_composer/js_composer.php' ) ) {
            if(file_exists(UIPRO_CLASSES_PATH . '/visual-composer/class-vc.php')) {
                require_once( UIPRO_CLASSES_PATH . '/visual-composer/class-vc.php' );
            }
        }

        $store_id   = __METHOD__;
        $store_id  .= '::'.serialize($elements);
        $store_id   = md5($store_id);

        if(isset($this -> cache[$store_id])){
            return $this -> cache[$store_id];
        }
        foreach ( $elements as $plugin => $group ) {
            for ($i=0;$i<count( $group);$i++) {
                $element    = $group[$i];
                $file_config = UIPRO_WIDGETS_PATH.'/' . $element . "/config.php";
                if ( file_exists( $file_config ) ) {
                    require_once $file_config;
                }
            }
        }

        return $this -> cache[$store_id] = true;
    }

    /**
     * Get all features.
     *
     * @return mixed
     */
    public static function get_elements() {
        $elements = apply_filters( 'uipro_register_shortcode', self::get_elements_from_path() );

        // disable elements when depends plugin not active
        foreach ( $elements as $plugin => $_elements ) {
            if ( $plugin == 'general' || $plugin == 'widgets' ) {
                continue;
            }

            if ( ! class_exists( $plugin ) ) {
                unset( $elements[$plugin] );
            }
        }

        return $elements;
    }

    /*
     * Get all widgets from path
     * return mixed
     * */
    public static function get_elements_from_path(){
        $core_path  = UIPRO_WIDGETS_PATH;
        $folders = glob( $core_path . '/*', GLOB_ONLYDIR );

        if(count($folders)) {
            foreach ( $folders as $path ) {
                $folder = basename($path);
                if(!in_array($folder, self::$_core_els['general'])) {
                    self::$_core_els['general'][] = $folder;
                }
            }
        }
        return self::$_core_els;
    }

    public function update_checker(){
        require_once UIPRO_LIBRARIES_PATH.'/plugin-updates/plugin-update-checker.php';
        $TemplazaFrameworkUpdateChecker = \Puc_v4_Factory::buildUpdateChecker(
            'https://github.com/templaza/uipro/',
            UIPRO_PATH.'/'.UIPRO.'.php', //Full path to the main plugin file or functions.php.
            'uipro'
        );

        //Set the branch that contains the stable release.
        $TemplazaFrameworkUpdateChecker->setBranch('master');

        //Optional: If you're using a private repository, specify the access token like this:
//        $TemplazaFrameworkUpdateChecker->setAuthentication('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');
        $TemplazaFrameworkUpdateChecker ->clearCachedTranslationUpdates();
    }
}

$GLOBALS['UIPro']   = $uipro = UIPro::instance();
$uipro -> init();