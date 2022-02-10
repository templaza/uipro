<?php

defined( 'UIPRO' ) || exit;
use TemPlaza_Woo_El\TemPlaza_Woo_El_Helper;
use Advanced_Product\Helper\AP_Custom_Field_Helper;

// Get custom fields
$enable_keyword  = isset($instance['uiap_enable_keyword'])?$instance['uiap_enable_keyword']:'yes';
$fields_include  = isset($instance['uiap_custom_fields'])?$instance['uiap_custom_fields']:array();

$enable_keyword = filter_var($enable_keyword, FILTER_VALIDATE_BOOLEAN);

$general_styles = \UIPro_Elementor_Helper::get_general_styles($instance);
$title          =   isset($instance['title']) ? $instance['title'] : '';
$title_tag      =   isset($instance['title_tag']) ? $instance['title_tag'] : 'h3';
$title_display  =   isset($instance['title_display']) ? $instance['title_display'] : 'uk-display-block';
$submit_text    =   isset($instance['uiap_submit_text']) ? $instance['uiap_submit_text'] : esc_html__('Search', 'uipro');
$submit_icon    =   isset($instance['uiap_submit_icon']) ? $instance['uiap_submit_icon'] : '';
$submit_icon_pos=   isset($instance['uiap_submit_icon_position']) ? $instance['uiap_submit_icon_position'] : 'before';

$shortcode  = '[advanced-product-form';
if(!empty($fields_include) && count($fields_include)) {
    $shortcode .= ' include="'.implode(',', $fields_include).'"';
}else{
    $shortcode .= ' include=""';
}
if(!empty($submit_text)){
    $shortcode  .= ' submit_text="'.$submit_text.'"';
}
if(!empty($submit_icon)){
    if ($submit_icon['library'] == 'svg'){
        $shortcode  .= ' submit_icon="'.$submit_icon['value']['url'].'"';
    }else{
        $shortcode  .= ' submit_icon="'.$submit_icon['value'].'"';
    }
}
if(!empty($submit_icon_pos)){
    $shortcode  .= ' submit_icon_position="'.$submit_icon_pos.'"';
}
$shortcode .= ' enable_keyword="'.($enable_keyword?1:0).'"]';
?>
<div class=" <?php echo esc_attr($general_styles['container_cls'] . $general_styles['content_cls']);?>" <?php echo wp_kses($general_styles['animation'],'post');?>>
    <?php
    if($title){
    echo '<'.esc_html($title_tag).' class="inventory-title-search '.esc_html($title_display).'"> '.esc_html($title).'</'.esc_html($title_tag).'>';
    }
    do_shortcode($shortcode);
    ?>
</div>