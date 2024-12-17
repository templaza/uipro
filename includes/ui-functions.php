<?php

namespace UIPro;

defined( 'UIPRO' ) || exit;

if(!class_exists('UIPro\UIPro_Functions')){

    class UIPro_Functions{
        protected static $cache         = array();
        protected static $shortcode = '';

        public static function get_my_data(){
            $storeId    = md5(__METHOD__);

            if(isset(self::$cache[$storeId])){
                return self::$cache[$storeId];
            }

            $file   = UIPRO_PATH.'/'.UIPRO.'.php';

            if(!file_exists($file)){
                return false;
            }
            if( !function_exists('get_plugin_data') ){
                require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
            }

            if($plugin = \get_plugin_data( $file, true, true )){

                $other_data = get_file_data( $file,
                    array(
                        'Forum' => 'Forum',
                        'Ticket' => 'Ticket',
                        'FanPage' => 'FanPage',
                        'Twitter' => 'Twitter',
                        'Google' => 'Google+'
                    ),
                    'plugin' );
                $plugin = array_merge($plugin, $other_data);

                self::$cache[$storeId]  = $plugin;
                return $plugin;
            }
            return false;
        }

        public static function get_my_url(){
            return untrailingslashit(plugins_url().'/'.UIPRO);
        }

//        public static function get_my_frame_url(){
//            return plugins_url().'/'.UIPRO.'/framework';
//        }

        public static function get_my_version(){
            $plugin = self::get_my_data();

            return $plugin['Version'];
        }

        public static function get_my_theme_css_uri(){
            return get_template_directory_uri().'/'.UIPRO.'/css';
        }

        public static function get_attribute_value($key='attribute', $attrib_key = ''){
            $attributes = self::get_attributes($key);

            if(isset($attributes[$attrib_key])){
                return $attributes[$attrib_key];
            }

            return false;
        }
        public static function get_attributes($key='attribute'){
            $store_id   = __CLASS__;
            $store_id  .= ':'.$key;
            $store_id   = md5($store_id);
            if(isset(self::$cache[$store_id])){
                return self::$cache[$store_id];
            }
            return false;
        }
        public static function add_attributes($key='attribute', $attributes = array()){
            $store_id   = __CLASS__;
            $store_id  .= ':'.$key;
            $store_id   = md5($store_id);

            self::$cache[$store_id] = $attributes;
        }


        /**
         * Check url is external
         * @param string $url
         * @return bool true|false
         * */
        public static function is_external_url($url){
            if(!$url){
                return false;
            }

            $url_host       = parse_url($url, PHP_URL_HOST);
            $internal_host  = parse_url(get_site_url(), PHP_URL_HOST);

            if($url_host != $internal_host){
                return true;
            }
            return false;
        }

        /**
         * Check extension of a file
         * @param string $file
         * @param string $ext_check The extension of file to check
         * @return bool true|false|null
         * */
        public static function file_ext_exists($file, $ext_check){
            if(!$file || !$ext_check){
                return null;
            }

            $file_type  = wp_check_filetype($file);
            if(!$file_type['ext']){
                return null;
            }
            if(is_array($ext_check) && in_array($file_type['ext'], $ext_check)){
                return true;
            }
            return (is_string($ext_check) && $file_type['ext'] == $ext_check);
        }

    }
}