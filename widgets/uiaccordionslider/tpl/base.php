<?php

$_is_elementor  = (isset($args['page_builder']) && $args['page_builder'] == 'elementor')?true:false;
$uiaccordionslider   = isset($instance['uiaccordionslider']) ? $instance['uiaccordionslider'] : array();
$icon     = ( isset( $instance['icon'] ) && $instance['icon'] ) ? $instance['icon'] : array();
$general_styles     =   \UIPro_Elementor_Helper::get_general_styles($instance);

$output         =   '';

if (count($uiaccordionslider)) {
	$output     =   '<div class="ui-accordion'. $general_styles['container_cls'] .'"' . $general_styles['animation'] . '>';
	if ($uiaccordionslider > 1) $output .= '<div class="' . $general_styles['content_cls'] . '">';
    $output .='<div class="accordion-holder"><div class="accordion-slider">';
	foreach ($uiaccordionslider as $item) {
		$title     = ( isset( $item['title'] ) && $item['title'] ) ? $item['title'] : '';
		$button     = ( isset( $item['button'] ) && $item['button'] ) ? $item['button'] : '';
		$letter     = ( isset( $item['letter'] ) && $item['letter'] ) ? $item['letter'] : '';
		$meta     = ( isset( $item['meta'] ) && $item['meta'] ) ? $item['meta'] : '';
		$content   = ( isset( $item['content'] ) && $item['content'] ) ? $item['content'] : '';
		$image     = ( isset( $item['image'] ) && $item['image'] ) ? $item['image'] : '';
		$video     = ( isset( $item['video'] ) && $item['video'] ) ? $item['video'] : '';
		$link     = ( isset( $item['link'] ) && $item['link'] ) ? $item['link'] : '';

		$image_src = $image['url'];

        $output .='<div class="uiaccordion-slide">';
        $output .='<span class="letter">'.$letter.'</span>';

        if (is_array($icon['value']) && isset($icon['value']['url']) && $icon['value']['url']) {
            $output   .=  '<span class="slider-icon uk-position-center"><img src="'.$icon['value']['url'].'" alt="svg-icon" data-uk-svg /></span>';
        } elseif (is_string($icon['value']) && $icon['value']) {
            $output   .=  '<span class="slider-icon uk-position-center '.$icon["value"].'"></span>';
        }
        $output .='<div class="slider-caption">';
        $output .='<span class="category">'.$meta.'</span>';
        $output .='<h2>'.$title.'</h2>';
        if($content){
            $output .='<div class="uiaccordion-slider-content">'.$content.'</div>';
        }
        if($button && $link['url']){
            $output .='<div class="uk-flex"><a href="'.esc_url($link['url']).'" '.($link['is_external'] == 'on' ? 'target="_blank"' : '').' class="templaza-btn ui-accordion-slider-btn uk-flex-inline">'.$button.'</a></div>';
        }
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