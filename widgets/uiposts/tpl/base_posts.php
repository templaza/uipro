<?php
defined( 'ABSPATH' ) || exit;

$args           = isset($args)?(array) $args:array();
$posts          = isset($posts)?(array) $posts:array();
$instance       = isset($instance)?(array) $instance:array();
$template_path  = isset($template_path)?$template_path:'';
$lead_items     = isset($posts['lead_items'])?$posts['lead_items']:array();
$last_items     = isset($posts['last_items'])?$posts['last_items']:array();
$first_items    = isset($posts['first_items'])?$posts['first_items']:array();

$lead_position          = ( isset( $instance['lead_position'] ) && $instance['lead_position'] ) ? $instance['lead_position'] : 'top';
$lead_column_gutter     = ( isset( $instance['lead_column_gutter'] ) && $instance['lead_column_gutter'] ) ? ' uk-grid-'.$instance['lead_column_gutter'] : '';
$lead_column_divider    = (isset($instance['lead_column_divider']) && $instance['lead_column_divider']) ? filter_var($instance['lead_column_divider'], FILTER_VALIDATE_BOOLEAN) : 0;
$lead_width    = (isset($instance['lead_width']) && $instance['lead_width']) ? ' uk-width-'
    . $instance['lead_width'] : ' uk-width-1-1';
$lead_width_xl    = (isset($instance['lead_width_xl']) && $instance['lead_width_xl']) ? ' uk-width-'
    . $instance['lead_width_xl'].'@xl' : ' uk-width-1-2@xl';
$lead_width_l    = (isset($instance['lead_width_l']) && $instance['lead_width_l']) ? ' uk-width-'
    . $instance['lead_width_l'].'@l' : ' uk-width-1-2@l';
$lead_width_m    = (isset($instance['lead_width_m']) && $instance['lead_width_m']) ? ' uk-width-'
    . $instance['lead_width_m'].'@m' : ' uk-width-1-2@m';
$lead_width_s    = (isset($instance['lead_width_s']) && $instance['lead_width_s']) ? ' uk-width-'
    . $instance['lead_width_s'].'@s' : ' uk-width-1-2@s';
$expand_width   = $lead_width_xl == ' uk-width-1-1@xl' ? ' uk-width-1-1@xl' : ' uk-width-expand@xl';
$expand_width   .=$lead_width_l == ' uk-width-1-1@l' ? ' uk-width-1-1@l' : ' uk-width-expand@l';
$expand_width   .=$lead_width_m == ' uk-width-1-1@m' ? ' uk-width-1-1@m' : ' uk-width-expand@m';
$expand_width   .=$lead_width_s == ' uk-width-1-1@s' ? ' uk-width-1-1@s' : ' uk-width-expand@s';
$expand_width   .=$lead_width == ' uk-width-1-1' ? ' uk-width-1-1' : ' uk-width-expand';

if(empty($template_path) && isset($instance['template_path'])){
    $template_path  = $instance['template_path'];
}

$output = '';
if (!empty($lead_items)) {
    $output     .=  '<div class="ui-posts-lead-item'.($lead_position == 'right' ? ' uk-flex-last@l' : '').($lead_position == 'left' || $lead_position == 'right' || $lead_position == 'between' ? $lead_width_xl.$lead_width_l.$lead_width_m.$lead_width_s.$lead_width : ' uk-width-1-1').'">';
    ob_start();
    \UIPro_Elementor_Helper::get_widget_template('base_posts_item',
        array('instance' => $instance, 'pre_val' => 'lead_', 'output' => '', 'posts' => $lead_items, 'args' => $args), $template_path);
    $output     .= ob_get_contents();
    ob_end_clean();
    $output     .=  '</div>';
}
if (!empty($first_items)) {
    $output     .=  '<div class="ui-posts-intro-item'.(($lead_position == 'between') ? $expand_width.' uk-flex-first@m ui-posts-intro-first' : ' uk-width-1-1').'">';
    ob_start();
    \UIPro_Elementor_Helper::get_widget_template('base_posts_item',
        array('instance' => $instance, 'pre_val' => '', 'output' => '', 'posts' => $first_items, 'args' => $args), $template_path);
    $output     .= ob_get_contents();
    ob_end_clean();
    $output     .=  '</div>';
}
if (!empty($last_items)) {
    $output     .=  '<div class="ui-posts-intro-item'.(($lead_position == 'left' || $lead_position == 'right' || $lead_position == 'between') ? $expand_width : ' uk-width-1-1').'">';
    ob_start();
    \UIPro_Elementor_Helper::get_widget_template('base_posts_item',
        array('instance' => $instance, 'pre_val' => '', 'output' => '', 'posts' => $last_items, 'args' => $args), $template_path);
    $output     .= ob_get_contents();
    ob_end_clean();
    $output     .=  '</div>';
}

echo ent2ncr($output);