<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if(!defined('UIPRO_PATH')){
    define('UIPRO_PATH', dirname( dirname(__FILE__)));
}
if(!defined('UIPRO')){
    define('UIPRO', basename(UIPRO_PATH));
}
if(!defined('UIPRO_CORE_PATH')){
    define('UIPRO_CORE_PATH', UIPRO_PATH.'/core');
}
if(!defined('UIPRO_INCLUDES_PATH')){
    define('UIPRO_INCLUDES_PATH', UIPRO_PATH.'/includes');
}
if(!defined('UIPRO_CLASSES_PATH')){
    define('UIPRO_CLASSES_PATH', UIPRO_PATH.'/includes/classes');
}
if(!defined('UIPRO_HELPERS_PATH')){
    define('UIPRO_HELPERS_PATH', UIPRO_INCLUDES_PATH.'/helpers');
}
if(!defined('UIPRO_LIBRARIES_PATH')){
    define('UIPRO_LIBRARIES_PATH', UIPRO_INCLUDES_PATH.'/libraries');
}
if(!defined('UIPRO_WIDGETS_PATH')){
    define('UIPRO_WIDGETS_PATH', UIPRO_PATH.'/widgets');
}
if(!defined('UIPRO_CONTROLS_PATH')){
    define('UIPRO_CONTROLS_PATH', UIPRO_PATH.'/controls');
}