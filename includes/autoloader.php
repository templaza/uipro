<?php

defined('ABSPATH') or exit();

require_once __DIR__.'/defines.php';
require_once __DIR__.'/ui-functions.php';
require_once UIPRO_HELPERS_PATH.'/uipro-helper.php';

if ( is_plugin_active( 'elementor/elementor.php' ) ) {
    require_once UIPRO_HELPERS_PATH.'/elementor-helper.php';
}