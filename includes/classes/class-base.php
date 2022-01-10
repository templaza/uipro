<?php

defined('UIPRO') or exit();

use UIPro\UIPro_Functions;

abstract class UIPro_Base{
    protected $core;
    protected $theme;
    protected $post_type;
    protected $text_domain;

    protected $cache    = array();

    public function __construct()
    {
        $this -> theme          = \wp_get_theme();
        $this -> text_domain    = UIPro_Functions::get_my_text_domain();
    }

    public function get_name(){
        $class_name = get_called_class();
        $meta_name  = preg_replace('#^(.*?[\\\\])+#i', '', $class_name);
        return strtolower($meta_name);
    }

    public function get_property($name, $default = ''){
        if(isset($this -> {$name})){
            return $this -> {$name};
        }
        return $default;
    }

    protected function _get_store_id($args = array()){
        $_args      = \func_get_args();
        $store_id   = serialize($_args);

        return md5($store_id);
    }
}