<?php

$_is_elementor  =   (isset($args['page_builder']) && $args['page_builder'] == 'elementor')?true:false;
$title          =   isset($instance['title']) ? $instance['title'] : '';
$title_tag      =   isset($instance['title_tag']) ? $instance['title_tag'] : 'h3';
$title_style    =   isset($instance['title_heading_style']) && $instance['title_heading_style'] ? ' uk-'. $instance['title_heading_style'] : '';
$title_heading_extra_style    =  isset($instance['title_heading_extra_style']) && $instance['title_heading_extra_style'] ? $instance['title_heading_extra_style'] : '';
$title_style    .=  isset($instance['title_heading_margin']) && $instance['title_heading_margin'] ? ($instance['title_heading_margin'] == 'default' ? ' uk-margin' : ' uk-margin-'. $instance['title_heading_margin']) : '';

$sub_title          = isset($instance['sub_title']) ? $instance['sub_title'] : '';
$sub_title_tag      = isset($instance['sub_title_tag']) ? $instance['sub_title_tag'] : 'lead';
$sub_title_margin   = isset($instance['sub_title_margin']) && $instance['sub_title_margin'] ? ($instance['sub_title_margin'] == 'default' ? ' uk-margin' : ' uk-margin-'. $instance['sub_title_margin']) : '';
$sub_title_style    = '';
if ($sub_title_tag == 'lead' || $sub_title_tag == 'meta') {
	$sub_title_style .= ' uk-text-'. $sub_title_tag;
	$sub_title_tag = 'p';
}
$sub_title_style    .= $sub_title_margin;

$text           = isset($instance['text']) && $instance['text'] ? $instance['text'] : '';

$general_styles = \UIPro_Elementor_Helper::get_general_styles($instance);
$output         = '';

if ($title || $sub_title || $text) {
	$output     =   '<div class="ui-text'. $general_styles['container_cls'] . $general_styles['content_cls'] .'"' . $general_styles['animation'] . '>';
	$output     .=  $title ? '<'.$title_tag.' class="ui-text-title'.$title_style.($title_heading_extra_style ? ' uk-heading-'.$title_heading_extra_style : '').'">'.($title_heading_extra_style ? '<span>' : '').$title.($title_heading_extra_style ? '</span>' : '').'</'.$title_tag.'>' : '';
	$output     .=  $sub_title ? '<'.$sub_title_tag.' class="ui-text-subtitle'.$sub_title_style.'">'.$sub_title.'</'.$sub_title_tag.'>' : '';
	$output     .=  $text ? '<div class="ui-text-desc">'.$text.'</div>' : '';
	$output     .=  '</div>';
	echo ent2ncr($output);
}