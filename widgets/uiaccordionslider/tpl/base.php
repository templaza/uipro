<?php

$_is_elementor  = (isset($args['page_builder']) && $args['page_builder'] == 'elementor')?true:false;
$uiaccordionslider   = isset($instance['uiaccordionslider']) ? $instance['uiaccordionslider'] : array();
$icon     = ( isset( $instance['icon'] ) && $instance['icon'] ) ? $instance['icon'] : '';

$general_styles     =   \UIPro_Elementor_Helper::get_general_styles($instance);

$output         =   '';

if (count($uiaccordionslider)) {
	$output     =   '<div class="ui-accordion'. $general_styles['container_cls'] .'"' . $general_styles['animation'] . '>';
	if ($uiaccordionslider > 1) $output .= '<div class="' . $general_styles['content_cls'] . '">';
    $output .='<div class="accordion-holder"><div class="accordion-slider">';
	foreach ($uiaccordionslider as $item) {
		$title     = ( isset( $item['title'] ) && $item['title'] ) ? $item['title'] : '';
		$letter     = ( isset( $item['letter'] ) && $item['letter'] ) ? $item['letter'] : '';
		$meta     = ( isset( $item['meta'] ) && $item['meta'] ) ? $item['meta'] : '';
		$content   = ( isset( $item['content'] ) && $item['content'] ) ? $item['content'] : '';
		$image     = ( isset( $item['image'] ) && $item['image'] ) ? $item['image'] : '';
		$video     = ( isset( $item['video'] ) && $item['video'] ) ? $item['video'] : '';


		$image_src = $image['url'];

        $output .='<div class="slide">';
        $output .='<span class="letter">'.$letter.'</span>';
        if($icon['value'] !=''){
            $output .='<span class="slider-icon uk-position-center '.$icon["value"].'"></span>';
        }
        $output .='<div class="slider-caption">';
        $output .='<span class="category">'.$meta.'</span>';
        $output .='<h2>'.$title.'</h2>';
        $output .='</div>';
        $output .='<div class="overlay"></div>';
        if($item['video']['id'] !=''){
            $output .='<div class="image"><div class="video-wrapper">';
            $output .='<video playsinline loop="" muted="" >';
            $output .='<source src="'.esc_url($item['video']['url']).'" type="video/mp4">';
            $output .='</video>';
            $output .='</div></div>';
        }else{
            $output .='<div class="image" style="background-image: url('. esc_url($image_src).');"></div>';
        }

        $output .='</div>';
	}
    $output .='</div></div>';
	if ($uiaccordionslider > 1) $output .= '</div>';
	$output     .=  '</div>';
	echo ent2ncr($output);
}