<?php

defined('ADVANCED_PRODUCT') or exit();

use Advanced_Product\AP_Functions;
use Advanced_Product\Helper\AP_Custom_Field_Helper;

// Get custom fields
$field_ids  = isset($instance['uiap_custom_fields'])?$instance['uiap_custom_fields']:array();

$fields     = UIPro_UIAdvancedProducts_Helper::get_custom_fields($field_ids);
if(!empty($fields)){
    $output .= '<div class="ap-specification uk-text-meta uk-text-emphasis">';
    ?>

        <?php foreach($fields as $field){

            $f_attr             = AP_Custom_Field_Helper::get_custom_field_option_by_id($field -> ID);
            $f_value            = (!empty($f_attr) && isset($f_attr['name']))?\get_field($f_attr['name'], $item -> ID):null;

            $f_val_html = '';
            if(!empty($f_value)){
                $html   = apply_filters('advanced-product/field/value_html/type='.$f_attr['type'], '', $f_value, $f_attr, $field);
                if(!empty($html)){
                    $f_val_html = trim($html);
                }elseif(is_string($f_value)){
                    $f_val_html = '<span>'.$f_value.'</span>';
                }elseif(is_array($f_value)){

                    $f_value    = array_values($f_value);
                    $f_val_html = '<span>'.join(',', $f_value).'</span>';
                }
//                if($f_attr['type'] == 'file'){
//                    $file_url   = '';
//                    $f_value    = get_field($f_attr['name'], $item->ID);
//                    if(is_array($f_value)){
//                        $file_url   = $f_value['url'];
//                    }elseif(is_numeric($f_value)){
//                        $file_url   = wp_get_attachment_url($f_value);
//                    }else{
//                        $file_url   = $f_value;
//                    }
//                    $f_val_html = '<a href="'.esc_attr($file_url).'" download>'
//                        .esc_html__('Download', 'uipro').'</a>';
//                }else{
//                    if(is_array($f_value)){
//                        $f_val_html = '<span>'.implode(',', $f_value).'</span>';
//                    }else{
//                        $f_val_html = '<span>'.$f_value.'</span>';
//                    }
//                }
            }
            if(!empty($f_val_html)){
                $output .= '<div class="uk-grid-small" data-uk-grid>';
                $output .= '<span class="ap-field-label uk-width-expand" data-uk-leader>'.$f_attr['label'].':</span>';
                $output .= $f_val_html;
                $output .= '</div>';
            }
        }
    $output .= '</div>';
}?>