<?php

$_is_elementor  = (isset($args['page_builder']) && $args['page_builder'] == 'elementor')?true:false;
$icons          = isset($instance['uiicons']) ? $instance['uiicons'] : array();
$grid_column_gap    = ( isset( $instance['grid_column_gap'] ) && $instance['grid_column_gap'] ) ? $instance['grid_column_gap'] : '';
$grid_row_gap       = ( isset( $instance['grid_row_gap'] ) && $instance['grid_row_gap'] ) ? $instance['grid_row_gap'] : '';
$hover_animation    = ( isset( $instance['hover_animation'] ) && $instance['hover_animation'] ) ? $instance['hover_animation'] : '';
$icon_size          = ( isset( $instance['icon_size'] ) && $instance['icon_size']['size'] ) ? $instance['icon_size']['size'] : '';

$grid_cr = '';
if ( $grid_column_gap == $grid_row_gap ) {
	$grid_cr .= ( ! empty( $grid_column_gap ) && ! empty( $grid_row_gap ) ) ? ' uk-grid-' . $grid_column_gap : '';
} else {
	$grid_cr .= ! empty( $grid_column_gap ) ? ' uk-grid-column-' . $grid_column_gap : '';
	$grid_cr .= ! empty( $grid_row_gap ) ? ' uk-grid-row-' . $grid_row_gap : '';
}
$grid_cr .= ' uk-child-width-auto';

$general_styles     =   \UIPro_Elementor_Helper::get_general_styles($instance);

$class          =   'ui-icon uk-flex uk-flex-middle';
$class          .=  $hover_animation ? ' uk-animation-'. $hover_animation : '';
$output         =   '';

if (count($icons)) {
	$output     =   '<div class="ui-icons'. $general_styles['container_cls'] .'"' . $general_styles['animation'] . '>';
	if ($icons > 1) $output .= '<div class="uk-flex-middle' . $grid_cr . $general_styles['content_cls'] . '" data-uk-grid>';
	foreach ($icons as $item) {
		$link       =   $item['link'];
		$attribs    =   \UIPro_Elementor_Helper::get_link_attribs($link);
		$icon_type          = ( isset( $item['icon_type'] ) && $item['icon_type'] ) ? $item['icon_type'] : '';
		$uikit_icon         = ( isset( $item['uikit_icon'] ) && $item['uikit_icon'] ) ? $item['uikit_icon'] : '';
		$general_icon       = ( isset( $item['icon'] ) && $item['icon'] ) ? $item['icon'] : array();
		$icon_position      = ( isset( $item['icon_position'] ) && $item['icon_position'] ) ? $item['icon_position'] : '';
		$icon               = '';
		if ($icon_type == 'uikit' && $uikit_icon) {
			$icon   .=  '<span class="uk-icon" data-uk-icon="icon: ' . $uikit_icon . '; width: '.$icon_size.'"></span>';
		} elseif ($general_icon && isset($general_icon['value'])) {
			if (is_array($general_icon['value']) && isset($general_icon['value']['url']) && $general_icon['value']['url']) {
				$icon   .=  '<img src="'.$general_icon['value']['url'].'" alt="svg-icon" data-uk-svg />';
			} elseif (is_string($general_icon['value']) && $general_icon['value']) {
				$icon   .=  '<i class="' . $general_icon['value'] . '" aria-hidden="true"></i>';
			}
		}
		$output     .=  '<div class="elementor-repeater-item-'. $item['_id'] . ($hover_animation ? ' uk-animation-toggle' : '') .'">';
		$output     .=  '<a href="'.$link['url'].'" class="'.$class.'"'.$attribs.'>' . $icon . '</a>';
		$output     .=  '</div>';
	}
	if ($icons > 1) $output .= '</div>';
	$output     .=  '</div>';
	echo ent2ncr($output);
}