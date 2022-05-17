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
$cover_image            = (isset($instance['image_cover']) && $instance['image_cover']) ? intval($instance['image_cover']) : 0;
$image_position         = (isset($instance['image_position']) && $instance['image_position']) ? $instance['image_position'] : 'uk-card-media-left';
$image_class            = " attachment-$image_size size-$image_size";
$general_styles         =   \UIPro_Elementor_Helper::get_general_styles($instance);
$cover_image_container  = $cover_image ? ' uk-cover-container' : '';
$output         =   '';
$image_position_cl = 'uk-card-media-left';
if ($image_position =='right'){
    $image_position_cl = 'uk-card-media-right uk-flex-last@m';
}
if (count($timeline)) {
	$output     =   '<div class="ui-timeline'. $general_styles['container_cls'] .'"' . $general_styles['animation'] . '>';
	$output     .=  '<div class="ui-timeline-inner' . $general_styles['content_cls'] . '">';
	$dateline   =   '';
	$content    =   '';
	$active_key =   0;
    foreach ($timeline as $key => $item) {
        $dateline .=  '<li>';
        $dateline .=  '<div class="ui-timeline-date uk-flex uk-flex-center"><a class="uk-flex uk-flex-column uk-flex-middle'.($key == $active_key ? ' active' : '').'" data-item-index="'.esc_attr($key).'" href="#">'.esc_attr($item['date']).'</a></div>';
        $dateline .=  '</li>';

        $content .=  '<li>';
        $content .=  '<div class="uk-card uk-card-default uk-grid-collapse uk-flex uk-flex-middle uk-child-width-1-2@m" data-uk-grid>';
        $content .=  '<div class="'.$image_position_cl.'">';
        $content .=  '<div class="image-box '.$cover_image_container.'">';
        if($cover_image){
            $content .=  wp_get_attachment_image( $item['image']['id'], $image_size, false, array('class' => trim( $image_class ), 'data-uk-cover' => '') ). '<canvas width="600" height="400"></canvas>';
        }else{
            $content .=  wp_get_attachment_image( $item['image']['id'], $image_size, false, array('class' => trim( $image_class )) ). '';
        }
        $content .=  '</div>';
        $content .=  '</div>';
        $content .=  '<div class="uk-flex uk-flex-middle"><div class="uk-card-body ui-timeline-content-wrap">';
        $meta_content   =  isset($item['meta']) && $item['meta'] ? '<'.$meta_tag.' class="ui-timeline-meta uk-margin-remove-top '.esc_attr($meta_heading_style.$meta_margin).'">'.$item['meta'].'</'.$meta_tag.'>' : '';
        $content .=  ($meta_position == 'before-title') ? $meta_content : '';
        $content .=  '<'.$title_tag.' class="ui-timeline-title uk-card-title uk-margin-remove-top '.esc_attr($title_heading_style.$title_margin).'">'. esc_html($item['title']) .'</'.$title_tag.'>';
        $content .=  ($meta_position == 'after-title') ? $meta_content : '';
        $content .=  isset($item['content']) && $item['content'] ? '<div class="ui-timeline-description'.esc_attr($dropcap).'">'. wp_kses($item['content'], wp_kses_allowed_html('post')) .'</div>' : '';
        $content .=  '</div></div>';
        $content .=  '</div>';
        $content .=  '</li>';
    }

    $output     .=  '<div id="dateline-'.$args['element_id'].'" class="ui-dateline uk-position-relative'.$timeframe_margin.'" data-uk-slider="finite:true">';
    $output     .=  '<ul class="uk-slider-items uk-grid uk-child-width-1-'.$large_desktop_columns.'@xl uk-child-width-1-'.$desktop_columns.'@l uk-child-width-1-'.$laptop_columns.'@m uk-child-width-1-'.$tablet_columns.'@s uk-child-width-1-'. $mobile_columns.'">';
    $output     .=  $dateline;
    $output     .=  '</ul>';
    $output     .=  '</div>';

    $output     .=  '<div id="content-'.$args['element_id'].'" class="ui-timeline-content" data-uk-slider="">';
	$output     .=  '<div class="uk-position-relative">';
	$output     .=  '<div class="uk-slider-container">';
	$output     .=  '<ul class="uk-slider-items uk-child-width-1-1 uk-grid">';
	$output     .=  $content;
	$output     .=  '</ul>';
	$output     .=  '</div>';
	$output     .=  '<div class="uk-hidden@s uk-light">
            <a class="uk-position-center-left uk-position-small" href="#" data-uk-slidenav-previous data-uk-slider-item="previous"></a>
            <a class="uk-position-center-right uk-position-small" href="#" data-uk-slidenav-next data-uk-slider-item="next"></a>
        </div>

        <div class="uk-visible@s">
            <a class="uk-position-center-left-out uk-position-small" href="#" data-uk-slidenav-previous data-uk-slider-item="previous"></a>
            <a class="uk-position-center-right-out uk-position-small" href="#" data-uk-slidenav-next data-uk-slider-item="next"></a>
        </div>';
	$output     .=  '</div>';
	$output     .=  '</div>';

	$output     .=  '</div>';
	$output     .=  '</div>';
    if (! wp_script_is('ui-timeline-script-'.$args['element_id'], 'registered')) {
        wp_register_script('ui-timeline-script-'.$args['element_id'], false, array("jquery"),'', true);
        wp_enqueue_script( 'ui-timeline-script-'.$args['element_id']);
        wp_add_inline_script('ui-timeline-script-'.$args['element_id'], 'jQuery(function($){
            $(document).ready(function(){
                UIkit.util.on("#content-'.$args['element_id'].'", "itemshow", function () {
                    UIkit.slider("#dateline-'.$args['element_id'].'").show(UIkit.slider("#content-'.$args['element_id'].'").index);
                    $("#dateline-'.$args['element_id'].' .ui-timeline-date > a.active").removeClass("active");
                    $("#dateline-'.$args['element_id'].' .ui-timeline-date > a[data-item-index="+UIkit.slider("#content-'.$args['element_id'].'").index+"]").addClass("active");
                });
                $("#dateline-'.$args['element_id'].' .ui-timeline-date > a").on("click", function(e){
                    e.preventDefault();
                    UIkit.slider("#content-'.$args['element_id'].'").show($(this).data("item-index"));
                });
            });
        });');
    }
	echo ent2ncr($output);
}