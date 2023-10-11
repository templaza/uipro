<?php
/*
Plugin Name: UIPro
Plugin URI: https://github.com/templaza/uipro
Description: This plugin help you manage products.
Author: Templaza
Version: 1.0.6
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
    }
    public function ui_load_plugin_textdomain() {
        load_plugin_textdomain( 'uipro', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
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

        foreach ( $elements as $plugin => $group ) {
            foreach ( $group as $element ) {
                $file_config = UIPRO_WIDGETS_PATH.'/' . $element . "/config.php";
                if ( file_exists( $file_config ) ) {
                    require_once $file_config;
                }
            }
        }

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