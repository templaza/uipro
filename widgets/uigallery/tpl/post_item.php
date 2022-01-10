<?php
defined( 'ABSPATH' ) || exit;
$resource       = ( isset( $instance['resource'] ) && $instance['resource'] ) ? $instance['resource'] : 'post';
$tag_style 		= (isset($instance['tag_style']) && $instance['tag_style']) ? $instance['tag_style'] : '';

//Card Style
$card_size 		= (isset($instance['card_size']) && $instance['card_size']) ? $instance['card_size'] : '';
$card_size_cls  = $card_size ? ' uk-card-'.$card_size : '';
$uk_card_body   = $card_size != 'none' ? ' uk-card-body' : '';

//Title
$heading_selector = (isset($instance['title_tag']) && $instance['title_tag']) ? $instance['title_tag'] : 'h3';
$title_heading_style    = (isset($instance['title_heading_style']) && $instance['title_heading_style']) ? ' uk-'. $instance['title_heading_style'] : '';
$title_margin   = (isset($instance['title_margin']) && $instance['title_margin']) ? ' uk-margin-'. $instance['title_margin'] .'-bottom' : ' uk-margin-bottom';

//Image
$thumbnail_size = (isset($instance['thumbnail_size']) && $instance['thumbnail_size']) ? $instance['thumbnail_size'] : 'full';
$thumbnail_hover= (isset($instance['thumbnail_hover']) && $instance['thumbnail_hover']) ? intval($instance['thumbnail_hover']) : 0;
$thumbnail_hover_transition= (isset($instance['thumbnail_hover_transition']) && $instance['thumbnail_hover_transition']) ? ' uk-transition-'. $instance['thumbnail_hover_transition'] : '';
$image_border   = (isset($instance['image_border_radius']) && $instance['image_border_radius']) ? ' '. $instance['image_border_radius'] : '';
$cover_image    = (isset($instance['cover_image']) && $instance['cover_image']) ? intval($instance['cover_image']) : 0;
$image_margin   = ( isset( $instance['image_margin'] ) && $instance['image_margin'] ) ? ' uk-margin-'. $instance['image_margin'] : ' uk-margin';
$cover_image    = $cover_image ? ' tz-image-cover' : '';

//Intro
$show_intro 	= (isset($instance['show_introtext']) && $instance['show_introtext']) ? intval($instance['show_introtext']) : 0;
$dropcap        = (isset($instance['content_dropcap']) && $instance['content_dropcap']) ? ' uk-dropcap' : '';

$image          =   get_post($item['id']);

//Get Item Tags
$tag_slugs      =   array();
$tags = get_post_meta( $item['id'], '_wp_attachment_image_alt', true );
if ($tags) {
    $tags   =   explode(',', $tags);
    foreach ($tags as $tag) {
        if (trim($tag)) {
            $tag_slugs[]    =   sanitize_title(trim($tag));
        }
    }
}

// Meta Positions
$caption_position           =   ( isset( $instance['caption_position'] ) ) ? $instance['caption_position'] : 'before_title';
$caption_margin             =   ( isset( $instance['caption_top_margin'] ) && $instance['caption_top_margin'] ) ? ' uk-margin-'. $instance['caption_top_margin'].'-top' : ' uk-margin-top';
$caption_margin             .=  ( isset( $instance['caption_bottom_margin'] ) && $instance['caption_bottom_margin'] ) ? ' uk-margin-'. $instance['caption_bottom_margin'].'-bottom' : ' uk-margin-bottom';
$use_lightbox               = (isset($instance['lightbox']) && $instance['lightbox']) ? intval($instance['lightbox']) : 0;

$output .= '<article data-tag="'.esc_attr(implode(' ', $tag_slugs)).'">';
$output .= '<div class="uk-article uk-card uk-overflow-hidden'.esc_attr($card_size_cls.$image_border.( $thumbnail_hover ? ' uk-transition-toggle' : '' )).'">';
$output .= '<div class="ui-gallery-thumbnail uk-display-block uk-card-media-top'.esc_attr($cover_image).'">'. wp_get_attachment_image( $item['id'], $thumbnail_size, false ) .'</div>';
$output .= '<div class="uk-position-cover uk-overlay uk-overlay-primary'.esc_attr( $thumbnail_hover ? ' uk-transition-fade' : '' ).'"></div>';

$output .= '<div class="ui-gallery-info-wrap  uk-position-bottom uk-light'.esc_attr(( $thumbnail_hover && $thumbnail_hover_transition ? $thumbnail_hover_transition : '' )).'">';
$output .= '<div class="'.esc_attr($uk_card_body).'">';
if($caption_position == 'before_title') {
    $output .= '<div class="ui-gallery-item-caption uk-article-meta'.esc_attr($caption_margin).'">';
    $output .= wp_kses($image->post_excerpt, wp_kses_allowed_html('post'));
    $output .= '</div>';
}
$output .= '<'.$heading_selector.' class="ui-title uk-margin-remove-top'.$title_heading_style.$title_margin.'">' . esc_html($image->post_title) . '</'.$heading_selector.'>';

if($caption_position == 'after_title') {
    $output .= '<div class="ui-gallery-item-caption uk-article-meta'.esc_attr($caption_margin).'">';
    $output .= wp_kses($image->post_excerpt, wp_kses_allowed_html('post'));
    $output .= '</div>';
}

if ($show_intro && $image->post_content) {
	$output .= '<div class="ui-gallery-introtext'.esc_attr($dropcap).'">'. wp_kses($image->post_content, wp_kses_allowed_html('post')) .'</div>';
}

if($caption_position == 'after_description') {
    $output .= '<div class="ui-gallery-item-caption uk-article-meta'.esc_attr($caption_margin).'">';
    $output .= wp_kses($image->post_excerpt, wp_kses_allowed_html('post'));
    $output .= '</div>';
}

$output .= '</div>'; // End card body

$output .= '</div>'; //.ui-gallery-article-info-wrap
$output .= ($use_lightbox ? '<a class="uk-position-cover" href="'. esc_url($item['url']) .'" data-elementor-open-lightbox="yes" data-elementor-lightbox-slideshow="'.$args['element_id'].'" data-elementor-lightbox-title="'.esc_attr($image->post_title).'" data-elementor-lightbox-description="'.esc_attr($image->post_content).'"></a>' : '');
$output .=  '</div>';
$output .=  '</article>';