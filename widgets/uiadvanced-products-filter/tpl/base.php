<?php

defined( 'UIPRO' ) || exit;

use Advanced_Product\Helper\AP_Custom_Field_Helper;
// Get custom fields
$enable_keyword  = isset($instance['uiap_enable_keyword'])?$instance['uiap_enable_keyword']:'yes';
$fields_include  = isset($instance['uiap_custom_fields'])?$instance['uiap_custom_fields']:array();

$enable_keyword = filter_var($enable_keyword, FILTER_VALIDATE_BOOLEAN);

if(!empty($fields_include) && count($fields_include)) {

//    $fields = AP_Custom_Field_Helper::get_custom_fields(array(), $fields_include);

    $shortcode  = '[advanced-product-form include="';
    $shortcode .= implode(',', $fields_include);
    $shortcode .= '" enable_keyword="'.($enable_keyword?1:0).'"]';
    do_shortcode($shortcode);
}