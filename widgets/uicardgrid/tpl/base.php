<?php

$_is_elementor  = (isset($args['page_builder']) && $args['page_builder'] == 'elementor')?true:false;

$image_content  = isset($instance['image_content']) && $instance['image_content'] ? $instance['image_content'] : '';
$image_transition  = isset($instance['media_transition']) && $instance['media_transition'] ? $instance['media_transition'] : '';

$large_desktop_columns    = ( isset( $instance['large_desktop_columns'] ) && $instance['large_desktop_columns'] ) ? $instance['large_desktop_columns'] : '3';
$desktop_columns    = ( isset( $instance['desktop_columns'] ) && $instance['desktop_columns'] ) ? $instance['desktop_columns'] : '3';
$laptop_columns     = ( isset( $instance['laptop_columns'] ) && $instance['laptop_columns'] ) ? $instance['laptop_columns'] : '3';
$tablet_columns     = ( isset( $instance['tablet_columns'] ) && $instance['tablet_columns'] ) ? $instance['tablet_columns'] : '2';
$mobile_columns     = ( isset( $instance['mobile_columns'] ) && $instance['mobile_columns'] ) ? $instance['mobile_columns'] : '1';
$column_grid_gap    = ( isset( $instance['column_grid_gap'] ) && $instance['column_grid_gap'] ) ? ' uk-grid-'. $instance['column_grid_gap'] : '';

$uicardgrids   = isset($instance['uicardgrid']) ? $instance['uicardgrid'] : array();

$media_overlay = '<div class="card-overlay uk-position-cover"></div>';

//Layout Type
$layout_type    = isset($instance['layout_type']) ? $instance['layout_type'] : 'icon';
$icon_arrow    = isset($instance['icon_arrow']) ? $instance['icon_arrow'] : '';
$media          = '';
$media_margin   = isset($instance['media_margin']) && $instance['media_margin'] ? ($instance['media_margin'] == 'default' ? ' uk-margin' : ' uk-margin-'. $instance['media_margin']) : '';

$image_appear   =   ( isset( $instance['image_appear'] ) && $instance['image_appear'] ) ? $instance['image_appear'] : '';
$first_active   =   ( isset( $instance['first_active'] ) && $instance['first_active'] ) ? $instance['first_active'] : 1;

$media_class = '';
if($image_transition !=''){
    $media_class = ' uk-transition-toggle';
}
$link_class = $media_class_wrap = '';
if($image_transition =='zoomin-roof'){
    $media_class_wrap = ' uk-cover-container zoomin-roof';
    $link_class = 'uk-display-block';
    if($image_appear != 'thumbnail'){
        $image_transition = 'zoomin-roof-wrap';
    }

}

//Card Style
$card_style     = isset($instance['card_style']) && $instance['card_style'] ? ' uk-card-'. $instance['card_style'] : '';
$card_size      = isset($instance['card_size']) && $instance['card_size'] ? ' uk-card-'. $instance['card_size'] : '';

$general_styles = \UIPro_Elementor_Helper::get_general_styles($instance);
$output         = '';
$card_cl = $active_f = '';
if($first_active ==1){
    $active_f = ' grid_active ';
}
if (count($uicardgrids)) {
    $output     .=  '<div class="ui-cards-grid '.$active_f.' uk-child-width-1-'.$large_desktop_columns.'@xl uk-child-width-1-'
        .$desktop_columns.'@l uk-child-width-1-'.$laptop_columns.'@m uk-child-width-1-'.$tablet_columns
        .'@s uk-child-width-1-'. $mobile_columns . $column_grid_gap.' uk-grid" data-uk-grid>';
    $d=0;
    foreach ($uicardgrids as $item) {
            if($first_active ==1 && $d==0){
                $f_active = ' active ';
                $f_active_se = '';
            }else{
                $f_active = '';
                $f_active_se = ' uk-width-expand@m ';
            }

        $title     = ( isset( $item['title'] ) && $item['title'] ) ? $item['title'] : '';
        $meta_title     = ( isset( $item['meta_title'] ) && $item['meta_title'] ) ? $item['meta_title'] : '';
        $content   = ( isset( $item['content'] ) && $item['content'] ) ? $item['content'] : '';
        $link   = ( isset( $item['link'] ) && $item['link'] ) ? $item['link'] : '';
        $image     = ( isset( $item['image'] ) && $item['image'] ) ? $item['image'] : '';
        $image_src = $image['url'];
        $output .= '<div class="'.$f_active.$f_active_se.' cardgrid-item">';
        $output     .=   '<div class="ui-card '.$media_class.' '.$card_cl.' '.$image_transition.' uk-card'. $card_style .' '.$icon_arrow.' '. $card_size . $general_styles['container_cls'] .'"' . $general_styles['animation'] . '>';
        if ($image && ($image_appear == 'top'|| $image_appear == 'thumbnail')) {
            $media = '<img  class="uk-transition-opaque uk-width-1-1 uk-transition-'.$image_transition.'" src="'.$image_src.'" alt="'.$title.'" />';

            if ($link['url']) {
                $output     .=  '<div class="uk-card-media-top ui-media'.$media_margin.' '.$media_class_wrap.'"><a class="tz-img '.$link_class.'" href="'.$link['url'].'">'.$media.$media_overlay.'</a></div>';
            } else {
                $output     .=  '<div class="uk-card-media-top ui-media'.$media_margin.' '.$media_class_wrap.'">'.$media.$media_overlay.'</div>';
            }
            $output     .=  '<div class="uk-card-meta uk-position-top-left"> '.$meta_title.'</div>';
            $output     .=  '<div class="uk-card-body '.$image_content. $general_styles['content_cls'] . '">';

            $output     .=  '<h3 class="uk-card-title uk-h3">'.$title.'</h3>';
            $output     .=  '<div class="ui-card-text">'.$content.'</div>';

            $output     .=  '</div>';
        }

        $output     .=  '</div>';
        $output     .=  '</div>';
        $d++;
    }

    $output     .=  '</div>';

    echo ent2ncr($output);
}
?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('.cardgrid-item').hover(function() {
            jQuery('.cardgrid-item.active').removeClass('active');
            jQuery('.cardgrid-item').addClass('uk-width-expand@m');
            jQuery(this).removeClass('uk-width-expand@m');
            jQuery(this).addClass('active');

        });
    })

</script>