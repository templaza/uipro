<?php
defined( 'ABSPATH' ) || exit;
$resource       = ( isset( $instance['resource'] ) && $instance['resource'] ) ? $instance['resource'] : 'post';
$layout         = (isset($instance['layout'] ) && $instance['layout'] ) ? $instance['layout'] : '';
$tag_style 		= (isset($instance['tag_style']) && $instance['tag_style']) ? $instance['tag_style'] : '';

//Card Style
$card_style 	= (isset($instance['card_style']) && $instance['card_style']) ? ' uk-card-'. $instance['card_style'] : '';
$card_size 		= (isset($instance['card_size']) && $instance['card_size']) ? $instance['card_size'] : '';
$card_size_cls  = $card_size ? ' uk-card-'.$card_size : '';
$uk_card_body   = $card_size != 'none' ? ' uk-card-body uk-inline' : '';

//Title
$heading_selector = (isset($instance['title_tag']) && $instance['title_tag']) ? $instance['title_tag'] : 'h3';
$title_heading_style    = (isset($instance['title_heading_style']) && $instance['title_heading_style']) ? ' uk-'. $instance['title_heading_style'] : '';
$title_margin   = (isset($instance['title_margin']) && $instance['title_margin']) ? ' uk-margin-'. $instance['title_margin'] .'-bottom' : ' uk-margin-bottom';

//Image
$pre_val = '';
$hide_thumbnail = (isset($instance[$pre_val.'hide_thumbnail']) && $instance[$pre_val.'hide_thumbnail']) ? intval($instance[$pre_val.'hide_thumbnail']) : 0;
$thumbnail_size = (isset($instance[$pre_val.'thumbnail_size']) && $instance[$pre_val.'thumbnail_size']) ? $instance[$pre_val.'thumbnail_size'] : 'full';
$thumbnail_hover= (isset($instance[$pre_val.'thumbnail_hover']) && $instance[$pre_val.'thumbnail_hover']) ? intval($instance[$pre_val.'thumbnail_hover']) : 0;
$thumbnail_hover_transition= (isset($instance[$pre_val.'thumbnail_hover_transition']) && $instance[$pre_val.'thumbnail_hover_transition']) ? ' uk-transition-'. $instance[$pre_val.'thumbnail_hover_transition'] : '';
$image_position = (isset($instance[$pre_val.'image_position']) && $instance[$pre_val.'image_position']) ? $instance[$pre_val.'image_position'] : 'top';
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
$show_intro 	    = (isset($instance['show_introtext']) && $instance['show_introtext']) ? intval($instance['show_introtext']) : 0;
$introtext_number   = (isset($instance['introtext_number']) && $instance['introtext_number']) ? intval($instance['introtext_number']) : 0;
$dropcap            = (isset($instance['content_dropcap']) && $instance['content_dropcap']) ? ' uk-dropcap' : '';

//Button
$show_readmore 	= (isset($instance['show_readmore']) && $instance['show_readmore']) ? intval($instance['show_readmore']) : 0;
$button_text    = (isset($instance['all_button_title']) && $instance['all_button_title']) ? $instance['all_button_title'] : 'Read More';
$button_target  = (isset($instance['target']) && $instance['target']) ? ' target="'. esc_attr($instance['target']) .'"' : '';
$button_class   = (isset($instance['button_style']) && $instance['button_style']) ? ' uk-button uk-button-' . $instance['button_style'] : ' uk-button uk-button-default';
$button_class   .=(isset($instance['button_size']) && $instance['button_size']) ? ' ' . $instance['button_size'] : '';
$button_class   .=(isset($instance['button_margin_top']) && $instance['button_margin_top']) ? ' uk-margin-' . $instance['button_margin_top'].'-top' : ' uk-margin-top';
$button_class   .=(isset($instance['button_shape']) && $instance['button_shape']) ? ' uk-border-' . $instance['button_shape'] : '';

$button_icon   = ( isset( $instance['button_icon'] ) && $instance['button_icon'] ) ? $instance['button_icon'] : array();
$button_position   = ( isset( $instance['button_icon'] ) && $instance['button_icon_position'] ) ? $instance['button_icon_position'] : 'before';
//Get post excerpt
$item->post_excerpt = apply_filters( 'the_excerpt', get_the_excerpt($item->ID) );
$item->post_excerpt = preg_replace('/<a class="more-link".*?<\/a>/i', '', $item->post_excerpt);
$flash_effect   =   isset($instance['flash_effect']) ? intval($instance['flash_effect']) : 0;
$imgclass         =  $flash_effect ? ' ui-image-flash-effect uk-position-relative uk-overflow-hidden' : '';
$image_transition   = ( isset( $instance['image_transition'] ) && $instance['image_transition'] ) ? ' uk-transition-' . $instance['image_transition'] . ' uk-transition-opaque' : '';
$thumb_effect = (isset($instance['image_transition']) && $instance['image_transition']) ? ($instance['image_transition']) : '';
$tran_toggle = $ripple_html = $ripple_wrap = $ripple_cl = $thumb_cl =' ';
if($thumb_effect =='ripple'){
    $ripple_html = '<div class="templaza-ripple-circles uk-position-center uk-transition-fade">
                        <div class="circle1"></div>
                        <div class="circle2"></div>
                        <div class="circle3"></div>
                    </div>';
    $ripple_cl = ' templaza-thumb-ripple ';
    $ripple_wrap = ' uk-position-relative ';
}
if($thumb_effect =='zoomin-roof'){
    $thumb_cl = ' templaza-thumb-roof ';
}
$tran_toggle = ' ';
if($image_transition){
    $tran_toggle = ' uk-transition-toggle ';
}
//Get Item Tags
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
if ($categories && is_array($categories)) {
	foreach ( $categories as $term ) {
		$term_link = $resource == 'post' ? get_term_link( $term, 'category' ) : get_term_link( $term, $resource.'-category' );
		if( is_wp_error( $term_link ) )
			continue;
		$cat_slugs[]    =   $term->slug;
		$cats[]         =   '<a href="'.esc_url($term_link).'">'.esc_attr($term->name).'</a>';
	}
	$cat_content        =   implode(', ', $cats);
}

// Meta Positions
$meta_thumb_position    =   $meta_top_position =   $meta_middle_position = $meta_bottom_position = array();
$meta_thumb_type        =   ( isset( $instance['meta_thumb_position'] ) ) ? $instance['meta_thumb_position'] : array();
$meta_thumb_position    =   UIPro_UIPosts_Helper::get_post_meta_content($meta_thumb_type, $item, $instance, array('cat_content' => $cat_content, 'tag_content' => $tag_content));
$meta_top_position      =   $meta_middle_position = $meta_bottom_position = array();
$meta_top_type          =   ( isset( $instance['meta_top_position'] ) ) ? $instance['meta_top_position'] : array();
$meta_top_position      =   UIPro_UIPosts_Helper::get_post_meta_content($meta_top_type, $item, $instance, array('cat_content' => $cat_content, 'tag_content' => $tag_content));
$meta_middle_type       =   ( isset( $instance['meta_middle_position'] ) ) ? $instance['meta_middle_position'] : array('date', 'author', 'category');
$meta_middle_position   =   UIPro_UIPosts_Helper::get_post_meta_content($meta_middle_type, $item, $instance, array('cat_content' => $cat_content, 'tag_content' => $tag_content));
$meta_bottom_type       =   ( isset( $instance['meta_bottom_position'] ) ) ? $instance['meta_bottom_position'] : array('tags');
$meta_bottom_position   =   UIPro_UIPosts_Helper::get_post_meta_content($meta_bottom_type, $item, $instance, array('cat_content' => $cat_content, 'tag_content' => $tag_content));
$meta_footer_type       =   ( isset( $instance['meta_footer_position'] ) ) ? $instance['meta_footer_position'] : array();
$meta_footer_position   =   UIPro_UIPosts_Helper::get_post_meta_content($meta_footer_type, $item, $instance, array('cat_content' => $cat_content, 'tag_content' => $tag_content));

// Meta Margin
$meta_top_margin        =   ( isset( $instance['meta_top_margin'] ) && $instance['meta_top_margin'] ) ? ' uk-margin-'. $instance['meta_top_margin'] : ' uk-margin';
$meta_middle_margin     =   ( isset( $instance['meta_middle_margin'] ) && $instance['meta_middle_margin'] ) ? ' uk-margin-'. $instance['meta_middle_margin'] : ' uk-margin';
$meta_bottom_margin     =   ( isset( $instance['meta_bottom_margin'] ) && $instance['meta_bottom_margin'] ) ? ' uk-margin-'. $instance['meta_bottom_margin'] .'-top' : ' uk-margin-top';
$meta_footer_margin     =   ( isset( $instance['meta_footer_margin'] ) && $instance['meta_footer_margin'] ) ? ' uk-margin-'. $instance['meta_footer_margin'] : ' uk-margin';
$meta_on_thumb_pos     =   ( isset( $instance['meta_on_thumb_position'] ) && $instance['meta_on_thumb_position'] ) ? $instance['meta_on_thumb_position'] : ' default';
$uk_cover   = (!empty($cover_image)? array('data-uk-cover' => '') : '');
if($image_transition){
    $tran_cl = array('class'=>''.$image_transition.'');
    if(is_array($uk_cover) && !empty($uk_cover)){
        $uk_cover = array_merge($uk_cover,$tran_cl);
    }else{
        $uk_cover = $tran_cl;
    }
}

$output .=  '<article data-tag="'.esc_attr(implode(' ', $tag_slugs)).'" data-cat="'.esc_attr(implode(' ', $cat_slugs)).'" data-date="'.esc_attr(get_the_date('Y-m-d', $item)).'" data-hits="'.esc_attr(get_post_meta($item->ID, 'post_views_count', true)).'">';
$output .= '<div class="uk-article uk-card'.esc_attr($thumb_cl.$ripple_cl.' '.$image_transition.' '.$card_style.$tran_toggle.$card_size_cls.( $thumbnail_hover ? ' uk-transition-toggle uk-overflow-hidden' : '' ).(!$hide_thumbnail && has_post_thumbnail( $item->ID ) && ($image_position == 'left' || $image_position == 'right') ? ' uk-grid-collapse' : '')).'"'.(!$hide_thumbnail && has_post_thumbnail( $item->ID ) && ($image_position == 'left' || $image_position == 'right') ? ' data-uk-grid' : '').'>';
if (!$hide_thumbnail && has_post_thumbnail( $item->ID ) && ($image_position == 'top' || $image_position == 'left' || $image_position == 'right') ) :
    if ($image_position == 'left' || $image_position == 'right') {
        $output .=  '<div class="uk-card-media-'.$image_position.' uk-cover-container'.($image_position == 'right' ? ' uk-flex-last@m' : '').$image_width_xl.$image_width_l.$image_width_m.$image_width_s.$image_width.'">';
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
    if($thumb_effect =='zoomin-roof'){
        $output .='<div class="ui-post-roof-effect uk-cover-container">';
    }
    $output .=  '<a class="tz-img '.$imgclass.$ripple_wrap.' uk-height-1-1 ui-post-thumbnail uk-position-relative uk-display-block uk-card-media-top'
        .esc_attr($cover_image.$image_border).'" href="'. get_permalink( $item->ID ) .'">'
        . UIPro_UIPosts_Helper::get_post_thumbnail($item, $thumbnail_size, $uk_cover) .$ripple_html.'' ;
        if(!empty($cover_image)){
            $output .=  '<canvas width="600" height="400"></canvas>';
        }
        if(count($meta_thumb_position)) {
            $output .= '<span class="ui-post-meta-thumb uk-article-meta uk-flex uk-flex-middle ' . $meta_on_thumb_pos . '">';
            $output .= wp_kses(implode('', $meta_thumb_position), wp_kses_allowed_html('post'));
            $output .= '</span>';
        }
        $output .= '</a>';

    if($thumb_effect =='zoomin-roof'){
        $output .='</div>';
    }


    if ($image_position == 'left' || $image_position == 'right') {
        if($thumb_effect !='zoomin-roof'){
            $output .=  '<canvas width="600" height="400"></canvas>';
        }
        $output .=  '</div>';
    }

endif;
if ($layout == 'thumbnail') {
    $output .= '<a class="ui-post-thumb-box" href="'. get_permalink( $item->ID ) .'"><div class="uk-position-cover uk-overlay uk-overlay-primary'.esc_attr( $thumbnail_hover ? ' uk-transition-fade' : '' ).'"></div></a>';
}
$output .= '<div class="ui-post-info-wrap'.esc_attr(($layout == 'thumbnail' ? ' uk-position-bottom uk-light' : '').( $thumbnail_hover && $thumbnail_hover_transition ? $thumbnail_hover_transition : '' ).(!$hide_thumbnail && has_post_thumbnail( $item->ID ) && ($image_position == 'left' || $image_position == 'right') ? ' uk-width-expand@m' : '')).'">';
$output .= '<div class="'.esc_attr($uk_card_body).'">';
if (!$hide_thumbnail && has_post_thumbnail( $item->ID ) && $image_position == 'inside' ):
	$output .=  '<a class="'.$imgclass.$ripple_wrap.' ui-post-thumbnail uk-display-block'.esc_attr($cover_image.$image_border.$image_margin).'" href="'. get_permalink( $item->ID ) .'">'. UIPro_UIPosts_Helper::get_post_thumbnail($item, $thumbnail_size,$uk_cover) .$ripple_html.'</a>';
endif;
if(count($meta_top_position)) {
    $output .= '<div class="ui-post-meta-top uk-article-meta'.esc_attr($meta_top_margin).'" data-uk-margin>';
    $output .= wp_kses(implode('', $meta_top_position), wp_kses_allowed_html('post'));
    $output .= '</div>';
}
$output .= '<'.$heading_selector.' class="ui-title uk-margin-remove-top'.$title_heading_style.$title_margin.'"><a href="'. get_permalink( $item->ID ) .'">' . $item->post_title . '</a></'.$heading_selector.'>';

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
    $output .= '<div class="ui-post-meta-footer uk-article-meta'.esc_attr($meta_footer_margin).'">';
    $output .= wp_kses(implode('', $meta_footer_position), wp_kses_allowed_html('post'));
    $output .= '</div>';
    $output .=  '</div>'; //End card footer
}

$output .= '</div>'; //.ui-post-article-info-wrap

if (!$hide_thumbnail && has_post_thumbnail( $item->ID ) && $image_position == 'bottom' ):

    $output .=  '<a class="'.$imgclass.$ripple_wrap.' ui-post-thumbnail uk-display-block uk-card-media-bottom'.esc_attr($cover_image.$image_border).'" href="'. get_permalink( $item->ID ) .'">'. UIPro_UIPosts_Helper::get_post_thumbnail($item, $thumbnail_size,$uk_cover) .$ripple_html.'</a>';
endif;

$output .=  '</div>';
$output .=  '</article>';