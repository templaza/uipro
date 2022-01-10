<?php

$_is_elementor  = (isset($args['page_builder']) && $args['page_builder'] == 'elementor')?true:false;
$buttons        = isset($instance['templaza-uibuttons']) ? $instance['templaza-uibuttons'] : array();

$btn_fullwidth      = ( isset( $instance['grid_width'] ) && $instance['grid_width'] ) ? $instance['grid_width'] : 'no';
$grid_column_gap    = ( isset( $instance['grid_column_gap'] ) && $instance['grid_column_gap'] ) ? $instance['grid_column_gap'] : '';
$grid_row_gap       = ( isset( $instance['grid_row_gap'] ) && $instance['grid_row_gap'] ) ? $instance['grid_row_gap'] : '';
$font_weight        = ( isset( $instance['font_weight'] ) && $instance['font_weight'] ) ? ' uk-text-' . $instance['font_weight'] : '';

$grid_cr = '';
if ( $grid_column_gap == $grid_row_gap ) {
	$grid_cr .= ( ! empty( $grid_column_gap ) && ! empty( $grid_row_gap ) ) ? ' uk-grid-' . $grid_column_gap : '';
} else {
	$grid_cr .= ! empty( $grid_column_gap ) ? ' uk-grid-column-' . $grid_column_gap : '';
	$grid_cr .= ! empty( $grid_row_gap ) ? ' uk-grid-row-' . $grid_row_gap : '';
}
$grid_cr .= ( $btn_fullwidth == 'yes' ) ? ' uk-child-width-1-1' : ' uk-child-width-auto';

$general_styles     =   \UIPro_Elementor_Helper::get_general_styles($instance);

$class          =   'ui-button uk-button uk-flex uk-flex-middle';
$class          .=  ( isset( $instance['button_size'] ) && $instance['button_size'] ) ? ' uk-button-' . $instance['button_size'] : '';
$output         =   '';

if (count($buttons)) {
	$output     =   '<div class="ui-buttons'. $general_styles['container_cls'] .'"' . $general_styles['animation'] . '>';
	if ($buttons > 1) $output .= '<div class="uk-flex-middle' . $grid_cr . $general_styles['content_cls'] . '" data-uk-grid>';
	foreach ($buttons as $button) {
		$link       =   $button['link'];
		$attribs    =   \UIPro_Elementor_Helper::get_link_attribs($link);
		$cls        =   isset($button['button_style']) && $button['button_style'] ? ' uk-button-'. $button['button_style'] : ' uk-button-default';
		$cls        .=  isset($button['button_shape']) && $button['button_shape'] ? ' uk-border-'. $button['button_shape'] : ' uk-border-rounded';
		$cls        .=  ( $btn_fullwidth == 'yes' ) ? ' uk-width-1-1' : '';
		$attribs    .=  isset($button['link_title']) && $button['link_title'] ? ' title="'.$button['link_title'].'"' : '';
		$icon_type          = ( isset( $button['icon_type'] ) && $button['icon_type'] ) ? $button['icon_type'] : '';
		$uikit_icon         = ( isset( $button['uikit_icon'] ) && $button['uikit_icon'] ) ? $button['uikit_icon'] : '';
		$general_icon   = ( isset( $button['icon'] ) && $button['icon'] ) ? $button['icon'] : array();
		$icon_position      = ( isset( $button['icon_position'] ) && $button['icon_position'] ) ? $button['icon_position'] : '';
		$icon               = '';
		$icon_left          = '';
		$icon_right         = '';
		if ($icon_type == 'uikit' && $uikit_icon) {
			$icon   .=  '<span class="uk-icon '. ($icon_position == 'right' ? 'uk-margin-small-left' : 'uk-margin-small-right') .'" data-uk-icon="icon: ' . $uikit_icon . '"></span>';
		} elseif ($general_icon && isset($general_icon['value'])) {
			if (is_array($general_icon['value']) && isset($general_icon['value']['url']) && $general_icon['value']['url']) {
				$icon   .=  '<img src="'.$general_icon['value']['url'].'" class="'.($icon_position == 'right' ? 'uk-margin-small-left' : 'uk-margin-small-right') .'" data-uk-svg />';
			} elseif (is_string($general_icon['value']) && $general_icon['value']) {
				$icon   .=  '<i class="' . $general_icon['value'] . ' '. ($icon_position == 'right' ? 'uk-margin-small-left' : 'uk-margin-small-right') .'" aria-hidden="true"></i>';
			}
		}
		if ($icon) {
			if ($icon_position == 'right') {
				$icon_right     =   $icon;
			} else {
				$icon_left      =   $icon;
			}
		}
		$output     .=  '<div class="elementor-repeater-item-'. $button['_id'] .'">';
		$output     .=  '<a href="'.$link['url'].'" class="'.$class.$cls.$font_weight.'"'.$attribs.'>' . $icon_left . $button['text'] . $icon_right . '</a>';
		$output     .=  '</div>';
	}
	if ($buttons > 1) $output .= '</div>';
	$output     .=  '</div>';
	echo ent2ncr($output);
}