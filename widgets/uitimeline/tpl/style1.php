<?php

$_is_elementor          = (isset($args['page_builder']) && $args['page_builder'] == 'elementor')?true:false;
$timeline               = isset($instance['timeline']) ? $instance['timeline'] : array();
$image_size             = isset($instance['image_size']) ? $instance['image_size'] : '';
$title_tag              = isset($instance['title_tag']) && $instance['title_tag'] ? $instance['title_tag'] : 'h3';
$title_heading_style    = isset($instance['title_heading_style']) && $instance['title_heading_style'] ? 'uk-'.$instance['title_heading_style'] : '';
$title_margin           = isset($instance['title_margin']) && $instance['title_margin'] ? ' uk-margin-'.$instance['title_margin'].'-bottom' : ' uk-margin-bottom';
$meta_tag               = isset($instance['meta_tag']) && $instance['meta_tag'] ? $instance['meta_tag'] : 'h5';
$meta_heading_style     = isset($instance['meta_heading_style']) && $instance['meta_heading_style'] ? 'uk-'.$instance['meta_heading_style'] : '';
$meta_margin            = isset($instance['meta_margin']) && $instance['meta_margin'] ? ' uk-margin-'.$instance['meta_margin'].'-bottom' : ' uk-margin-bottom';
$meta_position          = isset($instance['meta_position']) && $instance['meta_position'] ? $instance['meta_position'] : 'before-title';
$dropcap                = (isset($instance['content_dropcap']) && $instance['content_dropcap']) ? ' uk-dropcap' : '';
$large_desktop_columns  = ( isset( $instance['large_desktop_columns'] ) && $instance['large_desktop_columns'] ) ? $instance['large_desktop_columns'] : '5';
$desktop_columns        = ( isset( $instance['desktop_columns'] ) && $instance['desktop_columns'] ) ? $instance['desktop_columns'] : '4';
$laptop_columns         = ( isset( $instance['laptop_columns'] ) && $instance['laptop_columns'] ) ? $instance['laptop_columns'] : '3';
$tablet_columns         = ( isset( $instance['tablet_columns'] ) && $instance['tablet_columns'] ) ? $instance['tablet_columns'] : '2';
$mobile_columns         = ( isset( $instance['mobile_columns'] ) && $instance['mobile_columns'] ) ? $instance['mobile_columns'] : '1';
$timeframe_margin       = isset($instance['timeframe_margin']) && $instance['timeframe_margin'] ? ' uk-margin-'.$instance['timeframe_margin'].'-bottom' : ' uk-margin-bottom';
$image_class            = " attachment-$image_size size-$image_size";
$general_styles         =   \UIPro_Elementor_Helper::get_general_styles($instance);
$output         =   '';
if (count($timeline)) {
	$output     =   '<div class="ui-timeline'. $general_styles['container_cls'] .'"' . $general_styles['animation'] . '>';
	$output     .=  '<div class="ui-timeline-inner' . $general_styles['content_cls'] . '">';
	$dateline   =   '';
	$content    =   '';
	$active_key =   0;
	$d=1;
    foreach ($timeline as $key => $item) {
        if($d % 2==0){
            $content .=  '<div class="uk-card frame-even uk-grid-collapse uk-child-width-1-2" data-uk-grid>';
            $content .=  '<div class="uk-card-media-left tz-timeline-img-box uk-width-expand uk-width-1-2@s uk-grid-collapse" data-uk-grid>';
            $line_cl = 'uk-flex-last@s';
            $time_cl = 'uk-flex-left@s uk-flex-right uk-flex-center';
        }else{
            $content .=  '<div class="uk-card frame-old uk-grid-collapse uk-child-width-1-2" data-uk-grid>';
            $content .=  '<div class="uk-flex-last@s frame-old uk-width-expand tz-timeline-img-box uk-grid-collapse uk-card-media-right" data-uk-grid>';
            $line_cl = '';
            $time_cl = 'uk-flex-right uk-flex-center';
        }
        $content .=  '<div class="line-box '.$line_cl.' uk-flex uk-flex-middle uk-position-relative "><div class="line  uk-position-relative"></div></div>';
        $content .=  '<div class="image-box uk-width-expand"> <div class="uitimeline-img">';
        $content .=  wp_get_attachment_image( $item['image']['id'], $image_size, false, array('class' => trim( $image_class )) ). '';
        $content .=  '</div>';
        $meta_content   =  isset($item['meta']) && $item['meta'] ? '<'.$meta_tag.' class="ui-timeline-meta uk-margin-remove-top '.esc_attr($meta_heading_style.$meta_margin).'">'.$item['meta'].'</'.$meta_tag.'>' : '';
        $content .=  ($meta_position == 'before-title') ? $meta_content : '';
        $content .=  '<'.$title_tag.' class="ui-timeline-title uk-card-title  '.esc_attr($title_heading_style.$title_margin).'">'. esc_html($item['title']) .'</'.$title_tag.'>';
        $content .=  ($meta_position == 'after-title') ? $meta_content : '';
        $content .=  isset($item['content']) && $item['content'] ? '<div class="ui-timeline-description'.esc_attr($dropcap).'">'. wp_kses($item['content'], wp_kses_allowed_html('post')) .'</div>' : '';
        $content .=  '</div></div>';
        $content .=  '<div class="uk-flex tz-timeline-date-box uk-width-1-4 uk-width-1-2@s  uk-flex-middle '.$time_cl.' ">';
        $content .=  '<div class="ui-timeline-date">'.esc_attr($item['date']).'</div>';
        $content .=  '</div>';
        $content .=  '</div>';
        $d++;
    }
	$output     .=  $content;
	$output     .=  '</div>';
	$output     .=  '</div>';

	echo ent2ncr($output);
}