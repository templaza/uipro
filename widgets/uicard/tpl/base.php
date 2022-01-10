<?php

$_is_elementor  = (isset($args['page_builder']) && $args['page_builder'] == 'elementor')?true:false;
$title          = isset($instance['title']) ? $instance['title'] : '';
$title_tag      = isset($instance['title_tag']) ? $instance['title_tag'] : 'h3';
$title_style    = isset($instance['title_heading_style']) && $instance['title_heading_style'] ? ' uk-'. $instance['title_heading_style'] : '';
$title_style    .=isset($instance['title_heading_margin']) && $instance['title_heading_margin'] ? ($instance['title_heading_margin'] == 'default' ? ' uk-margin' : ' uk-margin-'. $instance['title_heading_margin']) : '';
$title_position = isset($instance['title_position']) && $instance['title_position'] ? $instance['title_position'] : 'after';
$text           = isset($instance['text']) && $instance['text'] ? $instance['text'] : '';
$link           = isset($instance['link']) && $instance['link'] ? $instance['link'] : array();
$url            = isset($link['url']) && $link['url'] ? $link['url'] : '';
$url_appear     = isset($instance['url_appear']) && $instance['url_appear'] ? $instance['url_appear'] : 'button';
$attribs        = \UIPro_Elementor_Helper::get_link_attribs($link);
$button_text    = isset($instance['button_text']) && $instance['button_text'] ? $instance['button_text'] : '';
$button_style   = isset($instance['button_style']) && $instance['button_style'] ? ' uk-button-'. $instance['button_style'] : ' uk-button-default';
$button_shape   = isset($instance['button_shape']) && $instance['button_shape'] ? ' uk-button-'. $instance['button_shape'] : ' uk-button-rounded';
$button_size    = isset($instance['button_size']) && $instance['button_size'] ? ' uk-button-'. $instance['button_size'] : '';
$button_margin  = isset($instance['button_margin']) && $instance['button_margin'] ? ($instance['button_margin'] == 'default' ? ' uk-margin' : ' uk-margin-'. $instance['button_margin']) : '';

//Layout Type
$layout_type    = isset($instance['layout_type']) ? $instance['layout_type'] : 'icon';
$media          = '';
$media_margin   = isset($instance['media_margin']) && $instance['media_margin'] ? ($instance['media_margin'] == 'default' ? ' uk-margin' : ' uk-margin-'. $instance['media_margin']) : '';
if ($layout_type == 'icon') {
	//Icon style
	$icon_type          = ( isset( $instance['icon_type'] ) && $instance['icon_type'] ) ? $instance['icon_type'] : '';
	$uikit_icon         = ( isset( $instance['uikit_icon'] ) && $instance['uikit_icon'] ) ? $instance['uikit_icon'] : '';
	$icon_size          = ( isset( $instance['icon_size'] ) && $instance['icon_size']['size'] ) ? $instance['icon_size']['size'] : '';
	$icon               = ( isset( $instance['icon'] ) && $instance['icon'] ) ? $instance['icon'] : array();
	if ($icon_type == 'uikit' && $uikit_icon) {
		$media   .=  '<span class="uk-icon" data-uk-icon="icon: ' . $uikit_icon . '; width: '.$icon_size.'"></span>';
	} elseif ($icon && isset($icon['value'])) {
		if (is_array($icon['value']) && isset($icon['value']['url']) && $icon['value']['url']) {
			$media   .=  '<img src="'.$icon['value']['url'].'" data-uk-svg />';
		} elseif (is_string($icon['value']) && $icon['value']) {
			$media   .=  '<i class="' . $icon['value'] .'" aria-hidden="true"></i>';
		}
	}
} else {
	$image          =   ( isset( $instance['image'] ) && $instance['image']['url'] ) ? $instance['image']['url'] : '';
	$media          .=  $image ? '<img src="'.$image.'" alt="'.$title.'" />' : '';
}
$image_appear   =   ( isset( $instance['image_appear'] ) && $instance['image_appear'] ) ? $instance['image_appear'] : '';

//Card Style
$card_style     = isset($instance['card_style']) && $instance['card_style'] ? ' uk-card-'. $instance['card_style'] : '';
$card_size      = isset($instance['card_size']) && $instance['card_size'] ? ' uk-card-'. $instance['card_size'] : '';

$general_styles = \UIPro_Elementor_Helper::get_general_styles($instance);
$output         = '';

if ($title) {
	if ($url && ($url_appear=='button_title' || $url_appear == 'all')) {
		$title     =  '<'.$title_tag.' class="uk-card-title'.$title_style.'"><a href="'.$url.'"'.$attribs.'>'.$title.'</a></'.$title_tag.'>';
	} else {
		$title     =  '<'.$title_tag.' class="uk-card-title'.$title_style.'">'.$title.'</'.$title_tag.'>';
	}
	$output     =   '<div class="ui-card uk-card'. $card_style . $card_size . $general_styles['container_cls'] .'"' . $general_styles['animation'] . '>';
	if ($media && $layout_type == 'image' && $image_appear == 'top') {
		$output .=  '<div class="uk-card-media-top ui-media'.$media_margin.'">'.$media.'</div>';
	}
	$output     .=  '<div class="uk-card-body'. $general_styles['content_cls'] . '">';
	if ($title_position == 'before') {
		$output         .=  $title;
	}
	if ($layout_type == 'icon' || ($layout_type == 'image' && $image_appear == 'inside')) {
		if ($url && ($url_appear=='button_media' || $url_appear == 'all')) {
			$output     .=  $media ? '<div class="ui-media'.$media_margin.'"><a href="'.$url.'"'.$attribs.'>'.$media.'</a></div>' : '';
		} else {
			$output     .=  $media ? '<div class="ui-media'.$media_margin.'">'.$media.'</div>' : '';
		}
	}
	if ($title_position == 'after') {
		$output         .=  $title;
	}
	$output     .=  '<div class="ui-card-text">'.$text.'</div>';
	$output     .=  $button_text ? '<div class="ui-button'.$button_margin.'"><a class="uk-button'.$button_style.$button_shape.$button_size.'" href="'.$url.'"'.$attribs.'>'.$button_text.'</a></div>' : '';
	$output     .=  '</div>';
	if ($media && $layout_type == 'image' && $image_appear == 'bottom') {
		$output .=  '<div class="uk-card-media-top ui-media'.$media_margin.'">'.$media.'</div>';
	}
	$output     .=  '</div>';
	echo ent2ncr($output);
}