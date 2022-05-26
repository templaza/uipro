<?php
defined( 'UIPRO' ) || exit;

// Get custom fields
$newsletter_btn  = isset($instance['newsletter_button'])?$instance['newsletter_button']:'Subscribe';

$general_styles = \UIPro_Elementor_Helper::get_general_styles($instance);

$newsletter_email      =   isset($instance['newsletter_email_placeholder']) ? $instance['newsletter_email_placeholder'] : 'Your Email...';
$title_tag      =   isset($instance['title_tag']) ? $instance['title_tag'] : 'h3';
$title_display  =   isset($instance['title_display']) ? $instance['title_display'] : 'uk-display-block';
$submit_text    =   isset($instance['uiap_submit_text']) ? $instance['uiap_submit_text'] : esc_html__('Search', 'uipro');
$submit_icon    =   isset($instance['uiap_submit_icon']) ? $instance['uiap_submit_icon'] : '';
$submit_icon_pos=   isset($instance['uiap_submit_icon_position']) ? $instance['uiap_submit_icon_position'] : 'before';
$ui_form =   isset($instance['uiform_form']) ? $instance['uiform_form'] : '';
$ui_form_custom =   isset($instance['uiform_custom']) ? $instance['uiform_custom'] : '';

$shortcode  = '[newsletter_form button_label="'.$newsletter_btn.'"]';

$shortcode .= '[newsletter_field name="email" label="" placeholder="'.$newsletter_email.'"]';

$shortcode .= '[/newsletter_form]';
?>
<div class=" <?php echo esc_attr($general_styles['container_cls'] . $general_styles['content_cls'] . $instance['form_style']);?>" <?php echo wp_kses($general_styles['animation'],'post');?>>
    <?php
    if($ui_form == 'custom'){
        echo do_shortcode($ui_form_custom);
    }else{
        if(function_exists('wpforms')) {
            echo do_shortcode('[wpforms id="' . $ui_form . '"]');
        }
    }
    ?>
</div>