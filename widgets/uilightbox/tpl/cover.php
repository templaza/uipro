<?php

$_is_elementor      =   (isset($args['page_builder']) && $args['page_builder'] == 'elementor')?true:false;
$link               =   isset($instance['link']) && $instance['link'] ? $instance['link'] : '';
$lightbox_width     =   isset($instance['lightbox_width']) && $instance['lightbox_width'] ? $instance['lightbox_width'] : array();
$lightbox_height    =   isset($instance['lightbox_height']) && $instance['lightbox_height'] ? $instance['lightbox_height'] : array();
$caption            =   isset($instance['caption']) && $instance['caption'] ? ' data-caption="'.$instance['caption'].'"' : '';
$title              =   isset($instance['title']) && $instance['title'] ? $instance['title'] : '';
$icon               =   isset($instance['icon']) && $instance['icon'] ? $instance['icon'] : array();
$autoplay 	        =   (isset($instance['autoplay']) && $instance['autoplay']) ? intval($instance['autoplay']) : 0;
$ripple_effect 	    =   (isset($instance['ripple_effect']) && $instance['ripple_effect']) ? intval($instance['ripple_effect']) : 0;
$ripple_effect_hover	    =   (isset($instance['ripple_effect_hover']) && $instance['ripple_effect_hover']) ? intval($instance['ripple_effect_hover']) : 0;
$lightbox_options   =   $autoplay   ?   'video-autoplay:true;' : '';
$ripple_effect      =   $ripple_effect ? ' ui-lightbox-ripple' : '';
$ripple_effect_hover      =   $ripple_effect_hover ? ' ui-lightbox-ripple-hover' : '';
$data_attrs         =   isset($lightbox_width['size']) && $lightbox_width['size'] ? 'width: '. $lightbox_width['size'] .';' : '';
$data_attrs         .=  isset($lightbox_height['size']) && $lightbox_height['size'] ? 'height: '. $lightbox_height['size'] .';' : '';
$circle_title 	    =   (isset($instance['title_circle']) && $instance['title_circle']) ? intval($instance['title_circle']) : 0;
$hover_rotate   = isset($instance['text_hover_rotate']) && $instance['text_hover_rotate'] ? $instance['text_hover_rotate'] : '';
$auto_rotate   = isset($instance['auto_rotate']) && $instance['auto_rotate'] ? $instance['auto_rotate'] : '';
$general_styles     =   \UIPro_Elementor_Helper::get_general_styles($instance);
$output = $cl = $auto_rt ='';
if($hover_rotate == 'yes'){
    $cl = ' rotate uk-position-relative';
}
if($auto_rotate == 'yes'){
    $auto_rt = ' auto_rotate';
}
if ($link && $icon && isset($icon['value'])) {
    $lightbox_icon  =   '';
    if (is_array($icon['value']) && isset($icon['value']['url']) && $icon['value']['url']) {
        $lightbox_icon   .=  '<img src="'.$icon['value']['url'].'" data-uk-svg />';
    } elseif (is_string($icon['value']) && $icon['value']) {
        $lightbox_icon   .=  '<i class="' . $icon['value'] . '" aria-hidden="true"></i>';
    }

	$output  ='<div class="uilightbox-cover '. $general_styles['container_cls'] .'"' .$general_styles['animation'] . '>';
    $output .='<div class="uk-cover-container uk-height-medium">';
    $output .='<iframe src="https://www.youtube-nocookie.com/embed/c2pz2mlSfXA?autoplay=0&amp;controls=0&amp;showinfo=0&amp;rel=0&amp;loop=1&amp;modestbranding=1&amp;wmode=transparent" width="1920" height="1080" allowfullscreen uk-cover></iframe>';
    $output .='<div class=" uilightbox '.$cl.'">';
    $output .='<div class=" uilightbox-inner">';
    if($title !=''){
        if($circle_title){
            $output .= '<svg class="circletext '.$auto_rt.'" viewBox="0 0 100 100" >
                <defs>
                    <path id="circle"
                          d="
        M 50, 50
        m -37, 0
        a 37,37 0 1,1 74,0
        a 37,37 0 1,1 -74,0"/>
                </defs>
                <text>
                    <textPath xlink:href="#circle">
                         '. ent2ncr($title) .'
                    </textPath>
                </text>                
            </svg>';
            $output .= '<a class="uk-position-center ui-lightbox uk-inline uk-border-pill uk-height-small uk-width-small' . $ripple_effect . $ripple_effect_hover . '" data-elementor-open-lightbox="no" href="' . $link . '"' . $caption . ' data-attrs="' . $data_attrs . '"><span class="uk-flex-inline uk-flex-middle uk-flex-center">' . $lightbox_icon . '</span></a>';
        }else{
            $output .= '<a class="ui-title-lightbox" data-elementor-open-lightbox="no" href="' . $link . '"' . $caption . ' data-attrs="' . $data_attrs . '"><span class="uk-flex-inline icon uk-flex-middle uk-flex-center uk-inline uk-border-pill uk-height-small uk-width-small ' . $ripple_effect . $ripple_effect_hover .'">' . $lightbox_icon . '</span>' . $title . '</a>';
        }
    }else {
        $output .= '<a class="ui-lightbox uk-inline uk-border-pill uk-height-small uk-width-small' . $ripple_effect . $ripple_effect_hover. '" data-elementor-open-lightbox="no" href="' . $link . '"' . $caption . ' data-attrs="' . $data_attrs . '"><span class="uk-flex-inline uk-flex-middle uk-flex-center">' . $lightbox_icon . '</span></a>';
    }
	$output         .=  '</div>';
	$output         .=  '</div>';
	$output         .=  '</div>';
	$output         .=  '</div>';
	echo ent2ncr($output);
}