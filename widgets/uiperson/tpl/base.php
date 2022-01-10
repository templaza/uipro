<?php

$_is_elementor  = (isset($args['page_builder']) && $args['page_builder'] == 'elementor')?true:false;
$name          = isset($instance['name']) ? $instance['name'] : '';
$name_tag      = isset($instance['name_tag']) ? $instance['name_tag'] : 'h3';
$name_style    = isset($instance['name_heading_style']) && $instance['name_heading_style'] ? ' uk-'. $instance['name_heading_style'] : '';
$name_style    .=isset($instance['name_heading_margin']) && $instance['name_heading_margin'] ? ($instance['name_heading_margin'] == 'default' ? ' uk-margin' : ' uk-margin-'. $instance['name_heading_margin']) : '';
$name_position = isset($instance['name_position']) && $instance['name_position'] ? $instance['name_position'] : 'after';
$text           = isset($instance['text']) && $instance['text'] ? $instance['text'] : '';

$social_items   = isset($instance['social_items']) ? $instance['social_items'] : array();

//Designation
$designation          = isset($instance['designation']) ? $instance['designation'] : '';
$designation_tag      = isset($instance['designation_tag']) ? $instance['designation_tag'] : 'meta';
$designation_style    = isset($instance['designation_margin']) && $instance['designation_margin'] ? ($instance['designation_margin'] == 'default' ? ' uk-margin' : ' uk-margin-'. $instance['designation_margin']) : '';
if ($designation_tag == 'lead' || $designation_tag == 'meta') {
	$designation_style  .=  ' uk-text-'.$designation_tag;
	$designation_tag    =   'p';
}

//Designation
$email          = isset($instance['email']) ? $instance['email'] : '';
$email_tag      = isset($instance['email_tag']) ? $instance['email_tag'] : 'meta';
$email_style    = isset($instance['email_margin']) && $instance['email_margin'] ? ($instance['email_margin'] == 'default' ? ' uk-margin' : ' uk-margin-'. $instance['email_margin']) : '';
if ($email_tag == 'lead' || $email_tag == 'meta') {
	$email_style  .=  ' uk-text-'.$email_tag;
	$email_tag    =   'p';
}

$media          = '';
$media_margin   = isset($instance['media_margin']) && $instance['media_margin'] ? ($instance['media_margin'] == 'default' ? ' uk-margin' : ' uk-margin-'. $instance['media_margin']) : '';
$image          =   ( isset( $instance['image'] ) && $instance['image']['url'] ) ? $instance['image']['url'] : '';
$media          .=  $image ? \UIPro_Elementor_Helper::get_attachment_image_html( $instance ) : '';
$image_appear   =   ( isset( $instance['image_appear'] ) && $instance['image_appear'] ) ? $instance['image_appear'] : '';

//Card Style
$card_style     = isset($instance['card_style']) ? ' uk-card-'. $instance['card_style'] : '';
$card_size      = isset($instance['card_size']) ? ' uk-card-'. $instance['card_size'] : '';

//Social Style
$overlay_positions      = isset($instance['overlay_positions']) && $instance['overlay_positions'] ? 'uk-position-'. $instance['overlay_positions'] : '';
$overlay_alignment      = isset($instance['overlay_alignment']) && $instance['overlay_alignment'] ? ' uk-text-'. $instance['overlay_alignment'].' uk-flex-'. $instance['overlay_alignment'] : '';
$vertical_icons         = isset($instance['vertical_icons']) && $instance['vertical_icons'] ? $instance['vertical_icons'] : '';
$vertical_icons         = ($vertical_icons == '1') ? ' uk-iconnav-vertical' : '';
$social_content =   '';
if (count($social_items)) {
	$social_content .=  '<div class="'.$overlay_positions.'">';
	$social_content .=  '<div class="uk-overlay uk-transition-fade uk-tile-muted uk-margin-remove-first-child">';
	$social_content .=  '<ul class="tz-social-list uk-iconnav'.$vertical_icons.$overlay_alignment.'">';
	foreach ($social_items as $item) {
		$social_icon    =   ( isset( $item['social_icon'] ) && $item['social_icon'] ) ? $item['social_icon'] : '';
		$link           =   ( isset( $item['link'] ) && $item['link'] ) ? $item['link'] : array();
		$attribs        =   \UIPro_Elementor_Helper::get_link_attribs($link);
		if ($social_icon) {
			$social_content     .=  '<li class="uk-margin-remove"><a href="'.$link['url'].'" class="uk-icon-link"'.$attribs.'><span class="uk-icon" data-uk-icon="icon: ' . $item['social_icon'] . '"></span></a></li>';
		}
	}
	$social_content .=  '</ul>';
	$social_content .=  '</div>';
	$social_content .=  '</div>';
}

$general_styles = \UIPro_Elementor_Helper::get_general_styles($instance);
$output         = '';

if ($name) {
	$name     =  '<'.$name_tag.' class="ui-name uk-card-title'.$name_style.'">'.$name.'</'.$name_tag.'>';
	$designation     =  '<'.$designation_tag.' class="ui-designation '.$designation_style.'">'.$designation.'</'.$designation_tag.'>';
	$email     =  '<'.$email_tag.' class="ui-email '.$email_style.'">'.$email.'</'.$email_tag.'>';
	$output     =   '<div class="ui-card uk-card'. $card_style . $card_size . $general_styles['container_cls'] .'"' . $general_styles['animation'] . '>';
	if ($media && $image_appear == 'top') {
		$output .=  '<div class="uk-card-media-top ui-media'.$media_margin.'"><div class="uk-inline-clip uk-transition-toggle" tabindex="0">';
		$output .=  $media.$social_content;
		$output .=  '</div></div>';
	}
	$output     .=  '<div class="uk-card-body' . $general_styles['content_cls'] . '">';
	if ($name_position == 'before') {
		$output         .=  $name.$designation.$email;
	}
	if ($image_appear == 'inside') {
		$output     .=  $media ? '<div class="ui-media'.$media_margin.'"><div class="uk-inline-clip uk-transition-toggle" tabindex="0">'.$media.$social_content.'</div></div>' : '';
	}
	if ($name_position == 'after') {
		$output         .=  $name.$designation.$email;
	}
	$output     .=  '<div class="ui-card-text">'.$text.'</div>';
	$output     .=  '</div>';
	if ($media && $image_appear == 'bottom') {
		$output .=  '<div class="uk-card-media-top ui-media'.$media_margin.'"><div class="uk-inline-clip uk-transition-toggle" tabindex="0">';
		$output .=  $media.$social_content;
		$output .=  '</div></div>';
	}
	$output     .=  '</div>';
	echo ent2ncr($output);
}