<?php

$_is_elementor      =   (isset($args['page_builder']) && $args['page_builder'] == 'elementor')?true:false;
$link               =   isset($instance['link']) && $instance['link'] ? $instance['link'] : '';
$lightbox_width     =   isset($instance['lightbox_width']) && $instance['lightbox_width'] ? $instance['lightbox_width'] : array();
$lightbox_height    =   isset($instance['lightbox_height']) && $instance['lightbox_height'] ? $instance['lightbox_height'] : array();
$caption            =   isset($instance['caption']) && $instance['caption'] ? ' data-caption="'.$instance['caption'].'"' : '';
$icon               =   isset($instance['icon']) && $instance['icon'] ? $instance['icon'] : array();
$autoplay 	        =   (isset($instance['autoplay']) && $instance['autoplay']) ? intval($instance['autoplay']) : 0;
$ripple_effect 	    =   (isset($instance['ripple_effect']) && $instance['ripple_effect']) ? intval($instance['ripple_effect']) : 0;
$lightbox_options   =   $autoplay   ?   'video-autoplay:true;' : '';
$ripple_effect      =   $ripple_effect ? ' ui-lightbox-ripple' : '';
$data_attrs         =   isset($lightbox_width['size']) && $lightbox_width['size'] ? 'width: '. $lightbox_width['size'] .';' : '';
$data_attrs         .=  isset($lightbox_height['size']) && $lightbox_height['size'] ? 'height: '. $lightbox_height['size'] .';' : '';

$general_styles     =   \UIPro_Elementor_Helper::get_general_styles($instance);
$output             =   '';

if ($link && $icon && isset($icon['value'])) {
    $lightbox_icon  =   '';
    if (is_array($icon['value']) && isset($icon['value']['url']) && $icon['value']['url']) {
        $lightbox_icon   .=  '<img src="'.$icon['value']['url'].'" data-uk-svg />';
    } elseif (is_string($icon['value']) && $icon['value']) {
        $lightbox_icon   .=  '<i class="' . $icon['value'] . '" aria-hidden="true"></i>';
    }
	$output         =   '<div class="uilightbox'. $general_styles['container_cls'] .'"' . $general_styles['animation'] . '>';
	$output         .=  '<div class="uilightbox-inner' . $general_styles['content_cls'] . '" data-uk-lightbox="'.$lightbox_options.'">';
    $output         .=  '<a class="ui-lightbox uk-inline uk-border-pill uk-height-small uk-width-small'.$ripple_effect.'" data-elementor-open-lightbox="no" href="'.$link.'"'.$caption.' data-attrs="'.$data_attrs.'"><span class="uk-flex-inline uk-flex-middle uk-flex-center">'.$lightbox_icon.'</span></a>';
	$output         .=  '</div>';
	$output         .=  '</div>';
	echo ent2ncr($output);
}