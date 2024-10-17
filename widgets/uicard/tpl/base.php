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
$button_shape   = isset($instance['button_shape']) && $instance['button_shape'] ? ' uk-border-'. $instance['button_shape'] : ' uk-border-rounded';
$button_size    = isset($instance['button_size']) && $instance['button_size'] ? ' uk-button-'. $instance['button_size'] : '';
$button_margin  = isset($instance['button_margin']) && $instance['button_margin'] ? ($instance['button_margin'] == 'default' ? ' uk-margin' : ' uk-margin-'. $instance['button_margin']) : '';
$button_position = isset($instance['button_position']) && $instance['button_position'] ? $instance['button_position'] : '';
$meta_position = isset($instance['meta_position']) && $instance['meta_position'] ? $instance['meta_position'] : 'after';
$meta           = isset($instance['meta_title']) && $instance['meta_title'] ? $instance['meta_title'] : '';
$image_content  = isset($instance['image_content']) && $instance['image_content'] ? $instance['image_content'] : '';
$image_transition  = isset($instance['media_transition']) && $instance['media_transition'] ? $instance['media_transition'] : '';
//Layout Type
$layout_type    = isset($instance['layout_type']) ? $instance['layout_type'] : 'icon';
$icon_arrow    = isset($instance['icon_arrow']) ? $instance['icon_arrow'] : '';
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
			$media   .=  '<img src="'.$icon['value']['url'].'" alt="'.$title.'" data-uk-svg />';
		} elseif (is_string($icon['value']) && $icon['value']) {
			$media   .=  '<i class="' . $icon['value'] .'" aria-hidden="true"></i>';
		}
	}
} else {
	$image          =   ( isset( $instance['image'] ) && $instance['image']['url'] ) ? $instance['image']['url'] : '';
	$media          .=  $image ? '<img class="uk-transition-opaque uk-transition-'.$image_transition.'" src="'.$image.'" alt="'.$title.'" />' : '';
}
$image_appear   =   ( isset( $instance['image_appear'] ) && $instance['image_appear'] ) ? $instance['image_appear'] : '';

$media_class = '';
if($image_transition !=''){
    $media_class = ' uk-transition-toggle';
}
$link_class = $media_class_wrap = '';
if($image_transition =='zoomin-roof'){
    $media_class_wrap = ' uk-cover-container zoomin-roof';
    $link_class = 'uk-display-block';
    if($image_appear != 'thumbnail'){
        $image_transition = 'zoomin-roof-wrap';
    }

}
$icon_on_media = '';
$icon_media    = ( isset( $instance['icon_media'] ) && $instance['icon_media'] ) ? $instance['icon_media'] : array();
if(isset($icon_media['value'])){
    if (is_array($icon_media['value']) && isset($icon_media['value']['url']) && $icon_media['value']['url']) {
        $icon_on_media   .=  '<div class="ui_icon_on_media uk-position-top-center"><img src="'.$icon_media['value']['url'].'" alt="'.$title.'" data-uk-svg /></div>';
    } elseif (is_string($icon_media['value']) && $icon_media['value']) {
        $icon_on_media   .=  '<div class="ui_icon_on_media uk-position-top-center"><i class="' . $icon_media['value'] .'" aria-hidden="true"></i></div>';
    }
}

if($instance['button_size'] =='full'){
    $button_size .=' uk-width-1-1';
}

//Card Style
$card_style     = isset($instance['card_style']) && $instance['card_style'] ? ' uk-card-'. $instance['card_style'] : '';
$card_size      = isset($instance['card_size']) && $instance['card_size'] ? ' uk-card-'. $instance['card_size'] : '';

$general_styles = \UIPro_Elementor_Helper::get_general_styles($instance);
$output         = '';

$button_icon          = ( isset( $instance['button_icon'] ) && $instance['button_icon'] ) ? $instance['button_icon'] : '';
$btn_uikit_icon         = ( isset( $instance['btn_uikit_icon'] ) && $instance['btn_uikit_icon'] ) ? $instance['btn_uikit_icon'] : '';
$fontawesome_icon   = ( isset( $instance['fontawesome_icon'] ) && $instance['fontawesome_icon'] ) ? $instance['fontawesome_icon'] : array();

$btn_icon               = '';
$btn_icon_left          = '';
$btn_icon_right         = '';
if($button_text){
    $icon_position      = ( isset( $instance['icon_position'] ) && $instance['icon_position'] ) ? $instance['icon_position'] : '';
    if($icon_position =='right'){
        $ic_pos = 'uk-margin-small-left';
    }else{
        $ic_pos = 'uk-margin-small-right';
    }
}else{
    $icon_position = '';
    $ic_pos = '';
}
if ($button_icon == 'uikit' && $btn_uikit_icon) {
    $btn_icon   .=  '<span class="uk-icon '. $ic_pos .'" data-uk-icon="icon: ' . $btn_uikit_icon . '"></span>';
} elseif ($fontawesome_icon && isset($fontawesome_icon['value'])) {
    if (is_array($fontawesome_icon['value']) && isset($fontawesome_icon['value']['url']) && $fontawesome_icon['value']['url']) {
        $btn_icon   .=  '<img src="'.$fontawesome_icon['value']['url'].'" class="'.$ic_pos .'" alt="'.$title.'" data-uk-svg />';
    } elseif (is_string($fontawesome_icon['value']) && $fontawesome_icon['value']) {
        $btn_icon   .=  '<i class="' . $fontawesome_icon['value'] . ' '. $ic_pos .'" aria-hidden="true"></i>';
    }
}
if ($btn_icon) {
    if ($icon_position == 'right') {
        $btn_icon_right     =   $btn_icon;
    } else {
        $btn_icon_left      =   $btn_icon;
    }
}

if ($title) {
	if ($url && ($url_appear=='button_title' || $url_appear == 'all')) {
		$title     =  '<'.$title_tag.' class="uk-card-title'.$title_style.'"><a href="'.$url.'"'.$attribs.'>'.$title.'</a></'.$title_tag.'>';
	} else {
		$title     =  '<'.$title_tag.' class="uk-card-title'.$title_style.'">'.$title.'</'.$title_tag.'>';
	}
	$output     =   '<div class="ui-card '.$media_class.' '.$image_transition.' uk-card'. $card_style .' '.$icon_arrow.' '. $card_size . $general_styles['container_cls'] .'"' . $general_styles['animation'] . '>';
	if ($media && $layout_type == 'image' && ($image_appear == 'top'|| $image_appear == 'thumbnail')) {
        if ($url && ($url_appear=='button_media' || $url_appear == 'all')) {
            $output     .=  $media ? '<div class="uk-card-media-top ui-media'.$media_margin.' '.$media_class_wrap.'"><a class="tz-img '.$link_class.'" href="'.$url.'"'.$attribs.'>'.$media.'</a></div>' : '';
        } else {
            $output     .=  $media ? '<div class="uk-card-media-top ui-media'.$media_margin.' '.$media_class_wrap.'">'.$media.'</div>' : '';
        }
	}
	$output     .=  '<div class="uk-card-body '.$image_content. $general_styles['content_cls'] . '">';
	if ($title_position == 'before') {
        if($meta_position == 'before'){
            $output     .=  '<div class="uk-card-meta">'.$meta.'</div>';
        }
        $output         .=  $title;
        if($meta_position == 'after'){
            $output     .=  '<div class="uk-card-meta">'.$meta.'</div>';
        }
	}
	if ($layout_type == 'icon' || ($layout_type == 'image' && $image_appear == 'inside')) {
		if ($url && ($url_appear=='button_media' || $url_appear == 'all')) {
			$output     .=  $media ? '<div class="ui-media'.$media_margin.' '.$media_class_wrap.'"><a class="tz-img '.$link_class.'" href="'.$url.'"'.$attribs.'>'.$media.'</a></div>' : '';
		} else {
			$output     .=  $media ? '<div class="ui-media'.$media_margin.' '.$media_class_wrap.'">'.$media.'</div>' : '';
		}
	}
	if ($title_position == 'after') {
        if($meta_position == 'before'){
            $output     .=  '<div class="uk-card-meta">'.$meta.'</div>';
        }
		$output         .=  $title;
		if($meta_position == 'after'){
            $output     .=  '<div class="uk-card-meta">'.$meta.'</div>';
        }
	}
    $output     .=  '<div class="ui-card-text">'.$text.'</div>';
    if($button_position == '') {
        $output .= $button_text || $btn_icon ? '<div class="ui-button' . $button_margin . '"><a class="uk-button' . $button_style . $button_shape . $button_size . '" href="' . $url . '"' . $attribs . '>' . $btn_icon_left . $button_text . $btn_icon_right . '</a></div>' : '';
    }
    $output     .=  '</div>';
	if ($media && $layout_type == 'image' && $image_appear == 'bottom') {
		$output .=  '<div class="uk-card-media-top uk-position-relative ui-media'.$media_margin.'">'.$media.$icon_on_media.'</div>';
	}
    if($button_position == 'after_media'){
        $output     .=  $button_text || $btn_icon ? '<div class="ui-button'.$button_margin.'"><a class="uk-button'.$button_style.$button_shape.$button_size.'" href="'.$url.'"'.$attribs.'>'.$btn_icon_left . $button_text . $btn_icon_right.'</a></div>' : '';
    }
	$output     .=  '</div>';
	echo ent2ncr($output);
}