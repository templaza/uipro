<?php
defined( 'ABSPATH' ) || exit;
$resource       = ( isset( $instance['resource'] ) && $instance['resource'] ) ? $instance['resource'] : 'post';
$layout         = (isset($instance[$pre_val.'layout'] ) && $instance[$pre_val.'layout'] ) ? $instance[$pre_val.'layout'] : '';
$tag_style 		= (isset($instance[$pre_val.'tag_style']) && $instance[$pre_val.'tag_style']) ? $instance[$pre_val.'tag_style'] : '';

//Card Style
$card_style 	= (isset($instance[$pre_val.'card_style']) && $instance[$pre_val.'card_style']) ? ' uk-card-'. $instance[$pre_val.'card_style'] : '';
$card_size 		= (isset($instance[$pre_val.'card_size']) && $instance[$pre_val.'card_size']) ? $instance[$pre_val.'card_size'] : '';
$card_size_cls  = $card_size ? ' uk-card-'.$card_size : '';
$uk_card_body   = $card_size != 'none' ? ' uk-card-body' : '';

//Title
$heading_selector = (isset($instance[$pre_val.'title_tag']) && $instance[$pre_val.'title_tag']) ? $instance[$pre_val.'title_tag'] : 'h3';
$title_heading_style    = (isset($instance[$pre_val.'title_heading_style']) && $instance[$pre_val.'title_heading_style']) ? ' uk-'. $instance[$pre_val.'title_heading_style'] : '';
$title_margin   = (isset($instance[$pre_val.'title_margin']) && $instance[$pre_val.'title_margin']) ? ' uk-margin-'. $instance[$pre_val.'title_margin'] .'-bottom' : ' uk-margin-bottom';
$title_maxwidth   = (isset($instance[$pre_val.'title_maxwidth']) && $instance[$pre_val.'title_maxwidth']) ?$instance[$pre_val.'title_maxwidth']: false;
$title_gradient   = (isset($instance[$pre_val.'custom_title_color_gradient']) && $instance[$pre_val.'custom_title_color_gradient']) ?$instance[$pre_val.'custom_title_color_gradient']: false;

//Image
$post_link = (isset($instance['post_link']) && $instance['post_link']) ? intval($instance['post_link']) : 0;
$hide_thumbnail = (isset($instance[$pre_val.'hide_thumbnail']) && $instance[$pre_val.'hide_thumbnail']) ? intval($instance[$pre_val.'hide_thumbnail']) : 0;
$thumbnail_size = (isset($instance[$pre_val.'thumbnail_size']) && $instance[$pre_val.'thumbnail_size']) ? $instance[$pre_val.'thumbnail_size'] : 'full';
$thumbnail_hover= (isset($instance[$pre_val.'thumbnail_hover']) && $instance[$pre_val.'thumbnail_hover']) ? intval($instance[$pre_val.'thumbnail_hover']) : 0;
$thumbnail_hover_transition= (isset($instance[$pre_val.'thumbnail_hover_transition']) && $instance[$pre_val.'thumbnail_hover_transition']) ? ' uk-transition-'. $instance[$pre_val.'thumbnail_hover_transition'] : '';
$image_position = (isset($instance[$pre_val.'image_position']) && $instance[$pre_val.'image_position']) ? $instance[$pre_val.'image_position'] : 'top';
$image_custom_width = (isset($instance['image_left_right_custom']) && $instance['image_left_right_custom']) ? $instance['image_left_right_custom'] : '0';

$image_width    = (isset($instance[$pre_val.'image_width']) && $instance[$pre_val.'image_width']) ? ' uk-width-'
    . $instance[$pre_val.'image_width'] : ' uk-width-1-2';
$image_width_xl    = (isset($instance[$pre_val.'image_width_xl']) && $instance[$pre_val.'image_width_xl']) ? ' uk-width-'
    . $instance[$pre_val.'image_width_xl'].'@xl' : ' uk-width-1-2@xl';
$image_width_l    = (isset($instance[$pre_val.'image_width_l']) && $instance[$pre_val.'image_width_l']) ? ' uk-width-'
    . $instance[$pre_val.'image_width_l'].'@l' : ' uk-width-1-2@l';
$image_width_m    = (isset($instance[$pre_val.'image_width_m']) && $instance[$pre_val.'image_width_m']) ? ' uk-width-'
    . $instance[$pre_val.'image_width_m'].'@m' : ' uk-width-1-2@m';
$image_width_s    = (isset($instance[$pre_val.'image_width_s']) && $instance[$pre_val.'image_width_s']) ? ' uk-width-'
    . $instance[$pre_val.'image_width_s'].'@s' : ' uk-width-1-2@s';
if($image_custom_width == '1'){
    $image_width = $image_width_xl = $image_width_l = $image_width_m = $image_width_s = ' ';
}

$expand_width   = $image_width_xl == ' uk-width-1-1@xl' ? ' uk-width-1-1@xl' : ' uk-width-expand@xl';
$expand_width   .=$image_width_l == ' uk-width-1-1@l' ? ' uk-width-1-1@l' : ' uk-width-expand@l';
$expand_width   .=$image_width_m == ' uk-width-1-1@m' ? ' uk-width-1-1@m' : ' uk-width-expand@m';
$expand_width   .=$image_width_s == ' uk-width-1-1@s' ? ' uk-width-1-1@s' : ' uk-width-expand@s';
$expand_width   .=$image_width == ' uk-width-1-1' ? ' uk-width-1-1' : ' uk-width-expand';

$image_border   = (isset($instance[$pre_val.'image_border']) && $instance[$pre_val.'image_border']) ? ' uk-overflow-hidden '. $instance[$pre_val.'image_border'] : '';
$cover_image    = (isset($instance[$pre_val.'cover_image']) && $instance[$pre_val.'cover_image']) ? intval($instance[$pre_val.'cover_image']) : 0;
$image_margin   = ( isset( $instance[$pre_val.'image_margin'] ) && $instance[$pre_val.'image_margin'] ) ? ' uk-margin-'. $instance[$pre_val.'image_margin'] : ' uk-margin';
$cover_image    = $cover_image ? ' tz-image-cover uk-cover-container' : '';
//Intro
$show_intro 	= (isset($instance[$pre_val.'show_introtext']) && $instance[$pre_val.'show_introtext']) ? intval($instance[$pre_val.'show_introtext']) : 0;
$introtext_number   = (isset($instance[$pre_val.'introtext_number']) && $instance[$pre_val.'introtext_number']) ? intval($instance[$pre_val.'introtext_number']) : 0;
$dropcap        = (isset($instance[$pre_val.'content_dropcap']) && $instance[$pre_val.'content_dropcap']) ? ' uk-dropcap' : '';

//Button
$show_readmore 	= (isset($instance[$pre_val.'show_readmore']) && $instance[$pre_val.'show_readmore']) ? intval($instance[$pre_val.'show_readmore']) : 0;
$button_text    = (isset($instance[$pre_val.'all_button_title']) && $instance[$pre_val.'all_button_title']) ? $instance[$pre_val.'all_button_title'] : 'Read More';
$button_target  = (isset($instance[$pre_val.'target']) && $instance[$pre_val.'target']) ? ' target="'. esc_attr($instance[$pre_val.'target']) .'"' : '';
$button_class   = (isset($instance[$pre_val.'button_style']) && $instance[$pre_val.'button_style']) ? ' uk-button uk-button-' . $instance[$pre_val.'button_style'] : ' uk-button uk-button-default';
$button_class   .=(isset($instance[$pre_val.'button_size']) && $instance[$pre_val.'button_size']) ? ' ' . $instance[$pre_val.'button_size'] : '';
$button_class   .=(isset($instance[$pre_val.'button_margin_top']) && $instance[$pre_val.'button_margin_top']) ? ' uk-margin-' . $instance[$pre_val.'button_margin_top'].'-top' : ' uk-margin-top';
$button_class   .=(isset($instance[$pre_val.'button_shape']) && $instance[$pre_val.'button_shape']) ? ' uk-border-' . $instance[$pre_val.'button_shape'] : '';

$button_icon   = ( isset( $instance['button_icon'] ) && $instance['button_icon'] ) ? $instance['button_icon'] : array();
$button_position   = ( isset( $instance['button_icon'] ) && $instance['button_icon_position'] ) ? $instance['button_icon_position'] : 'before';
//Get post excerpt
$item->post_excerpt = apply_filters( 'the_excerpt', get_the_excerpt($item->ID) );
$item->post_excerpt = preg_replace('/<a class="more-link".*?<\/a>/i', '', $item->post_excerpt);
$flash_effect   =   isset($instance['flash_effect']) ? intval($instance['flash_effect']) : 0;
$imgclass         =  $flash_effect ? ' ui-image-flash-effect uk-position-relative uk-overflow-hidden' : '';
$image_transition   = ( isset( $instance['image_transition'] ) && $instance['image_transition'] ) ? ' uk-transition-' . $instance['image_transition'] . ' uk-transition-opaque' : '';
$thumb_effect = (isset($instance['image_transition']) && $instance['image_transition']) ? ($instance['image_transition']) : '';

$tran_toggle = $ripple_html = $flash_cl = $ripple_wrap = $thumb_cl = ' ';
if($thumb_effect =='ripple'){
    $ripple_html = '<div class="templaza-ripple-circles uk-position-center uk-transition-fade">
                        <div class="circle1"></div>
                        <div class="circle2"></div>
                        <div class="circle3"></div>
                    </div>';
    $thumb_cl = ' templaza-thumb-ripple ';
    $ripple_wrap = ' uk-position-relative ';
}

if($thumb_effect =='zoomin-roof'){
    $thumb_cl = ' templaza-thumb-roof ';
}
if($image_transition){
    $tran_toggle = ' uk-transition-toggle ';
}
if($flash_effect){
    $flash_cl = ' flash-effect';
}
if($image_border !=''){
	$thumb_cl .= ' img_radius';
}
$tags = wp_get_post_terms( $item->ID , $resource. '_tag' );
$i = 1;
$tag_content    =   '';
$tag_slugs      =   array();
if($tags){
    foreach ( $tags as $term ) {
        $tag_link = get_term_link( $term, array( $resource. '_tag' ) );
        if( is_wp_error( $tag_link ) )
            continue;
        $tag_slugs[]    =   $term -> slug;
        if ($tag_style == 'plain-text') {
            if($i < count($tags)){
                if ( $i == count($tags) - 1 ) {
                    $tag_content .= esc_attr($term->name.' & ');
                } else {
                    $tag_content .= esc_attr($term->name.', ');
                }
            } else {
                $tag_content .= esc_attr($term->name);
            }
        } else {
            $tag_content    .=  '<a href="'.esc_url($tag_link).'">#'.esc_attr($term->name).'</a>';
            if ( $i < count($tags) ) {
                $tag_content    .=  ' ';
            }
        }
        $i++;
    }
//	$tag_content    =   $tag_style == '' ? '<span class="uk-grid-small" data-uk-grid>'.$tag_content.'</span>' : $tag_content;
}

//Category
$categories = $resource == 'post' ? wp_get_post_terms( $item->ID , 'category' ) : wp_get_post_terms( $item->ID , $resource.'-category' );
// init counter
$cats  =   array();
$cat_content    =   '';
$cat_slugs      =   array();
if ($categories && count($categories)) {
    foreach ( $categories as $term ) {
        $term_link = $resource == 'post' ? get_term_link( $term, 'category' ) : get_term_link( $term, $resource.'-category' );
        if( is_wp_error( $term_link ) )
            continue;
        $cat_slugs[]    =   $term->slug;
        if($post_link){
            $cats[]         =   '<span >'.esc_attr($term->name).'</span>';
        }else{
            $cats[]         =   '<a href="'.esc_url($term_link).'">'.esc_attr($term->name).'</a>';
        }


    }
    $cat_content        =   implode(', ', $cats);
}

// Meta Positions
$meta_top_position      =   $meta_middle_position = $meta_bottom_position = array();
$meta_top_type          =   ( isset( $instance[$pre_val.'meta_top_position'] ) ) ? $instance[$pre_val.'meta_top_position'] : array();
$meta_top_position      =   UIPro_UIPosts_Helper::get_post_meta_content($meta_top_type, $item, $instance, array('cat_content' => $cat_content, 'tag_content' => $tag_content));
$meta_middle_type       =   ( isset( $instance[$pre_val.'meta_middle_position'] ) ) ? $instance[$pre_val.'meta_middle_position'] : array('date', 'author', 'category');
$meta_middle_position   =   UIPro_UIPosts_Helper::get_post_meta_content($meta_middle_type, $item, $instance, array('cat_content' => $cat_content, 'tag_content' => $tag_content));
$meta_bottom_type       =   ( isset( $instance[$pre_val.'meta_bottom_position'] ) ) ? $instance[$pre_val.'meta_bottom_position'] : array('tags');
$meta_bottom_position   =   UIPro_UIPosts_Helper::get_post_meta_content($meta_bottom_type, $item, $instance, array('cat_content' => $cat_content, 'tag_content' => $tag_content));
$meta_footer_type       =   ( isset( $instance[$pre_val.'meta_footer_position'] ) ) ? $instance[$pre_val.'meta_footer_position'] : array();
$meta_footer_position   =   UIPro_UIPosts_Helper::get_post_meta_content($meta_footer_type, $item, $instance, array('cat_content' => $cat_content, 'tag_content' => $tag_content));

// Meta Margin
$meta_top_margin        =   ( isset( $instance[$pre_val.'meta_top_margin'] ) && $instance[$pre_val.'meta_top_margin'] ) ? ' uk-margin-'. $instance[$pre_val.'meta_top_margin'] : ' uk-margin';
$meta_middle_margin     =   ( isset( $instance[$pre_val.'meta_middle_margin'] ) && $instance[$pre_val.'meta_middle_margin'] ) ? ' uk-margin-'. $instance[$pre_val.'meta_middle_margin'] : ' uk-margin';
$meta_bottom_margin     =   ( isset( $instance[$pre_val.'meta_bottom_margin'] ) && $instance[$pre_val.'meta_bottom_margin'] ) ? ' uk-margin-'. $instance[$pre_val.'meta_bottom_margin'] .'-top' : ' uk-margin-top';
$meta_footer_margin     =   ( isset( $instance[$pre_val.'meta_footer_margin'] ) && $instance[$pre_val.'meta_footer_margin'] ) ? ' uk-margin-'. $instance[$pre_val.'meta_footer_margin'] : ' uk-margin';
$roof_top_class = '';
if ($layout == 'thumbnail') {

    if($thumb_effect =='zoomin-roof'){
        $roof_top_class = ' ui-post-roof-effect ';
    }else{
        $roof_top_class = '';
    }
}
if($thumb_effect =='zoomin-roof' && $layout != 'thumbnail'){
    $roof_class = ' ui-post-roof-effect ';
}else{
    $roof_class = '';
}
$restaurant_cl = $restaurant_cl_wrap ='';
if($resource == 'restaurant'){
    $restaurant_cl = ' restaurant_source ';
    $restaurant_cl_wrap = ' restaurant_source_wrap ';
}
$output .=  '<article class="'.$restaurant_cl_wrap.' article-item" data-tag="'.esc_attr(implode(' ', $tag_slugs)).'" data-cat="'.esc_attr(implode(' ', $cat_slugs)).'" data-date="'.esc_attr(get_the_date('Y-m-d', $item)).'" data-hits="'.esc_attr(get_post_meta($item->ID, 'post_views_count', true)).'">';
$output .= '<div class="uk-article uk-card '.esc_attr($layout.$restaurant_cl.$thumb_cl.$roof_top_class.$card_style.$tran_toggle.$card_size_cls.( $thumbnail_hover ? ' uk-transition-toggle uk-overflow-hidden' : '' ).(!$hide_thumbnail && has_post_thumbnail( $item->ID ) && ($image_position == 'left' || $image_position == 'right') ? ' uk-grid-collapse' : '')).'"'.(!$hide_thumbnail && has_post_thumbnail( $item->ID ) && ($image_position == 'left' || $image_position == 'right') ? ' data-uk-grid' : '').'>';
if (!$hide_thumbnail && has_post_thumbnail( $item->ID ) && ($image_position == 'top' || $image_position == 'left' || $image_position == 'right') ) :
    if ($image_position == 'left' || $image_position == 'right') {
        $output .=  '<div class="uk-card-media-'.$image_position.$roof_class.' uk-cover-container'.($image_position == 'right' ? ' uk-flex-last@s' : '').$image_width_xl.$image_width_l.$image_width_m.$image_width_s.$image_width.'">';
    }
    $uk_cover   = ($image_position == 'left' || $image_position == 'right' || !empty($cover_image)? array('data-uk-cover' => '') : '');
    if($image_transition){
        $tran_cl = array('class'=>''.$image_transition.'');
        if(is_array($uk_cover) && !empty($uk_cover)){
            $uk_cover = array_merge($uk_cover,$tran_cl);
        }else{
            $uk_cover = $tran_cl;
        }
    }
    if($image_position == 'left' || $image_position == 'right'){
        $cover_image = '  tz-image-cover ';
    }
    if($thumb_effect =='zoomin-roof' && $image_position !='left'  && $image_position !='right' ){
        $output .='<div class="'.$roof_class.' uk-cover-container">';
    }
    if($post_link){
        $output .=  '<a class="tz-img '.$imgclass.$ripple_wrap.' uk-height-1-1 ui-post-thumbnail uk-display-block uk-card-media-top'
            .esc_attr($cover_image.$image_border).'" href="javascript:">'
            . UIPro_UIPosts_Helper::get_post_thumbnail($item, $thumbnail_size, $uk_cover) .$ripple_html.'</a>';
    }else{
        $output .=  '<a class="tz-img '.$imgclass.$ripple_wrap.' uk-height-1-1 ui-post-thumbnail uk-display-block uk-card-media-top'
            .esc_attr($cover_image.$image_border).'" href="'. get_permalink( $item->ID ) .'">'
            . UIPro_UIPosts_Helper::get_post_thumbnail($item, $thumbnail_size, $uk_cover) .$ripple_html.'</a>';
    }
    if ($layout == 'thumbnail' && $thumb_effect =='zoomin-roof') {
        if($post_link){
            $output .= '<div class="ui-post-thumb-box '.$flash_cl.'" ><div class="uk-position-cover uk-overlay uk-overlay-primary'.esc_attr( $thumbnail_hover ? ' uk-transition-fade' : '' ).'"></div></div>';
        }else{
            $output .= '<a class="tz-img uk-position-absolute ui-post-thumb-box '.$flash_cl.'" href="'. get_permalink( $item->ID ) .'"><div class="uk-position-cover uk-overlay uk-overlay-primary'.esc_attr( $thumbnail_hover ? ' uk-transition-fade' : '' ).'"></div></a>';
        }
    }
    if($thumb_effect =='zoomin-roof' && $image_position !='left'  && $image_position !='right' ){
        $output .='</div>';
    }

    if ($image_position == 'left' || $image_position == 'right') {
        if($thumb_effect !='zoomin-roof'){
            $output .=  '<canvas width="600" height="400"></canvas>';
        }
        $output .=  '</div>';
    }
endif;
if ($layout == 'thumbnail' && $thumb_effect !='zoomin-roof') {
    if($post_link){
        $output .= '<div class="ui-post-thumb-box '.$flash_cl.'" ><div class="uk-position-cover uk-overlay uk-overlay-primary'.esc_attr( $thumbnail_hover ? ' uk-transition-fade' : '' ).'"></div></div>';
    }else{
        $output .= '<a class="tz-img ui-post-thumb-box '.$flash_cl.'" href="'. get_permalink( $item->ID ) .'"><div class="uk-position-cover uk-overlay uk-overlay-primary'.esc_attr( $thumbnail_hover ? ' uk-transition-fade' : '' ).'"></div></a>';
    }
}

$output .= '<div class="ui-post-info-wrap '.esc_attr(($layout == 'thumbnail' ? ' uk-position-bottom uk-position-z-index uk-light' : '').( $thumbnail_hover && $thumbnail_hover_transition ? $thumbnail_hover_transition : '' ).(!$hide_thumbnail && has_post_thumbnail( $item->ID ) && ($image_position == 'left' || $image_position == 'right') ? $expand_width : '')).'">';
$output .= '<div class="'.esc_attr($uk_card_body).'">';
if (!$hide_thumbnail && has_post_thumbnail( $item->ID ) && $image_position == 'inside' ):
    if($post_link){
        $output .=  '<div class="ui-post-thumbnail uk-display-block'.esc_attr($ripple_wrap.$cover_image.$image_border.$image_margin).'" >'. UIPro_UIPosts_Helper::get_post_thumbnail($item, $thumbnail_size) .$ripple_html.'</div>';
    }else{
        $output .=  '<a class="tz-img ui-post-thumbnail uk-display-block'.esc_attr($ripple_wrap.$cover_image.$image_border.$image_margin).'" href="'. get_permalink( $item->ID ) .'">'. UIPro_UIPosts_Helper::get_post_thumbnail($item, $thumbnail_size) .$ripple_html.'</a>';
    }

endif;
if(count($meta_top_position)) {
    $output .= '<div class="ui-post-meta-top uk-article-meta'.esc_attr($meta_top_margin).'" data-uk-margin>';
    $output .= wp_kses(implode('', $meta_top_position), wp_kses_allowed_html('post'));
    $output .= '</div>';
}
$_title_class   = '';
if($title_gradient){
    $_title_class   .= ' tz-title-gradient';
}

if(!empty($title_maxwidth) && !empty($title_maxwidth['size'])){
    $_title_class   .= ' uk-flex uk-flex-center';
}
if($post_link){
    if($resource == 'restaurant'){
        $output .='<div class="uk-flex uk-flex-between"><'.$heading_selector.' class="ui-title uk-margin-remove-top'.$title_heading_style.$title_margin.$_title_class
            .'">' . $item->post_title . '</'.$heading_selector.'><span class="restaurant_price uk-flex-last">'.get_field('price',$item->ID).' </span></div>';
    }else{
        $output .= '<'.$heading_selector.' class="ui-title uk-margin-remove-top'.$title_heading_style.$title_margin.$_title_class
            .'">' . $item->post_title . '</'.$heading_selector.'>';
    }
}else{
    if($resource == 'restaurant'){
        $output .='<div class="uk-flex uk-flex-between"><' . $heading_selector . ' class="ui-title uk-margin-remove-top' . $title_heading_style . $title_margin . $_title_class
            . '"><a href="' . get_permalink($item->ID) . '">' . $item->post_title . '</a></' . $heading_selector . '><span class="restaurant_price uk-flex-last">'.get_field('price',$item->ID).' </span></div>';
    }else {
        $output .= '<' . $heading_selector . ' class="ui-title uk-margin-remove-top' . $title_heading_style . $title_margin . $_title_class
            . '"><a href="' . get_permalink($item->ID) . '">' . $item->post_title . '</a></' . $heading_selector . '>';
    }
}


if(count($meta_middle_position)) {
    $output .= '<div class="ui-post-meta-middle uk-article-meta'.esc_attr($meta_middle_margin).'" data-uk-margin>';
    $output .= wp_kses(implode('', $meta_middle_position), wp_kses_allowed_html('post'));
    $output .= '</div>';
}

if ($show_intro && $item->post_excerpt) {
    $output .= '<div class="ui-post-introtext'.esc_attr($dropcap).'">'. wp_kses(UIPro_UIPosts_Helper::get_post_except($item,$introtext_number), wp_kses_allowed_html('post')) .'</div>';
}

if(count($meta_bottom_position)) {
    $output .= '<div class="ui-post-meta-bottom uk-article-meta'.esc_attr($meta_bottom_margin).'" data-uk-margin>';
    $output .= wp_kses(implode('', $meta_bottom_position), wp_kses_allowed_html('post'));
    $output .= '</div>';
}

if($show_readmore) {
    $icon = '';
    if ($button_icon && isset($button_icon['value'])) {
        if (is_array($button_icon['value']) && isset($button_icon['value']['url']) && $button_icon['value']['url']) {
            $icon  .=  '<span class="uipost-btn-icon-box"><img src="'.$button_icon['value']['url'].'" class="uipost-btn-icon" data-uk-svg /></span>';
        } elseif (is_string($button_icon['value']) && $button_icon['value']) {
            $icon  .=  '<span class="uipost-btn-icon-box"><i class="' . $button_icon['value'] .' uipost-btn-icon" aria-hidden="true"></i></span>';
        }
    }
    $output .= '<a class="ui-post-button' . esc_attr($button_class) . '" href="'. get_permalink( $item->ID ) .'"'.$button_target.'>'.($button_position == 'before' ? ''.$icon.'' : ''). esc_html($button_text) .($button_position == 'after' ? ''.$icon.'' : '').'</a>';
}

$output .= '</div>'; // End card body

if(count($meta_footer_position)) {
    $output .= '<div class="uk-card-footer">';
    $output .= '<div class="ui-post-meta-footer uk-article-meta'.esc_attr($meta_footer_margin).'" data-uk-margin>';
    $output .= wp_kses(implode('', $meta_footer_position), wp_kses_allowed_html('post'));
    $output .= '</div>';
    $output .=  '</div>'; //End card footer
}

$output .= '</div>'; //.ui-post-article-info-wrap

if (!$hide_thumbnail && has_post_thumbnail( $item->ID ) && $image_position == 'bottom' ):
    $output .=  '<a class="tz-img ui-post-thumbnail uk-display-block uk-card-media-bottom'.esc_attr($ripple_wrap.$cover_image.$image_border).'" href="'. get_permalink( $item->ID ) .'">'. UIPro_UIPosts_Helper::get_post_thumbnail($item, $thumbnail_size) .$ripple_html.'</a>';
endif;

$output .=  '</div>';
$output .= apply_filters( 'templaza-elements-builder/uipost-post-after-content', '',$item);
$output .=  '</article>';

echo ent2ncr($output);