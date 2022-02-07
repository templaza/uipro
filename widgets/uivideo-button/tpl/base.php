<?php

$_is_elementor      =   (isset($args['page_builder']) && $args['page_builder'] == 'elementor')?true:false;
$video_link         =   isset($instance['video_link']) && $instance['video_link'] ? $instance['video_link'] : '';

$general_styles     =   \UIPro_Elementor_Helper::get_general_styles($instance);
$output             =   '';

if ($video_link) {
    $output         =   '<div class="Button">$video_link</div>';
//	$output         =   '<div class="uivideo-button'. $general_styles['container_cls'] .'"' . $general_styles['animation'] . '>';
//	$output         .=  '<div class="uivideo-button-inner' . $general_styles['content_cls'] . '" data-uk-lightbox>';
//    $output         .=  '<a class="ui-button uk-inline uk-padding" data-elementor-open-lightbox="no" href="'.$video_link.'"><i class="fas fa-play"></i></a>';
//	$output         .=  '</div>';
//	$output         .=  '</div>';
	echo ent2ncr($output);
}