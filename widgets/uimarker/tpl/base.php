<?php

$_is_elementor      = (isset($args['page_builder']) && $args['page_builder'] == 'elementor')?true:false;
$uimarker_items     = isset($instance['uimarker_items']) ? $instance['uimarker_items'] : array();
$mobile_switcher    = isset($instance['mobile_switcher']) ? $instance['mobile_switcher'] : '0';

$popover_animation  = ( isset( $instance['popover_animation'] ) && $instance['popover_animation'] ) ? 'animation: uk-animation-' . $instance['popover_animation'] . ';' : '';
$popover_position   = ( isset( $instance['popover_position'] ) && $instance['popover_position'] ) ? 'pos: ' . $instance['popover_position'] . ';' : '';
$popover_mode       = ( isset( $instance['popover_mode'] ) && $instance['popover_mode'] ) ? ' mode: ' . $instance['popover_mode'] . ';' : '';

$card               = ( isset( $instance['card_styles'] ) && $instance['card_styles'] ) ? ' uk-card-' . $instance['card_styles'] : ' uk-card-default';
$card_size          = ( isset( $instance['card_size'] ) && $instance['card_size'] ) ? ' ' . $instance['card_size'] : '';

$meta_alignment = ( isset( $instance['meta_alignment'] ) && $instance['meta_alignment'] ) ? $instance['meta_alignment'] : '';
$meta_element   = ( isset( $instance['meta_element'] ) && $instance['meta_element'] ) ? $instance['meta_element'] : 'div';
$meta_style_cls = ( isset( $instance['meta_style'] ) && $instance['meta_style'] ) ? $instance['meta_style'] : '';

$meta_style  = ( isset( $instance['meta_style'] ) && $instance['meta_style'] ) ? ' uk-' . $instance['meta_style'] : '';
$meta_style .= ( isset( $instance['meta_color'] ) && $instance['meta_color'] ) ? ' uk-text-' . $instance['meta_color'] : '';
$meta_style .= ( isset( $instance['meta_text_transform'] ) && $instance['meta_text_transform'] ) ? ' uk-text-' . $instance['meta_text_transform'] : '';
$meta_style .= ( isset( $instance['meta_margin_top'] ) && $instance['meta_margin_top'] ) ? ' uk-margin-' . $instance['meta_margin_top'] . '-top' : ' uk-margin-top';

//Title style
$heading_selector = ( isset( $instance['heading_selector'] ) && $instance['heading_selector'] ) ? $instance['heading_selector'] : 'h3';
$heading_style    = ( isset( $instance['heading_style'] ) && $instance['heading_style'] ) ? ' uk-' . $instance['heading_style'] : '';
$heading_style   .= ( isset( $instance['title_color'] ) && $instance['title_color'] ) ? ' uk-text-' . $instance['title_color'] : '';
$heading_style   .= ( isset( $instance['title_text_transform'] ) && $instance['title_text_transform'] ) ? ' uk-text-' . $instance['title_text_transform'] : '';
$heading_style   .= ( isset( $instance['title_margin_top'] ) && $instance['title_margin_top'] ) ? ' uk-margin-' . $instance['title_margin_top'] . '-top' : ' uk-margin-top';
$title_decoration = ( isset( $instance['title_decoration'] ) && $instance['title_decoration'] ) ? ' ' . $instance['title_decoration'] : '';
$link_title       = ( isset( $instance['link_title'] ) && $instance['link_title'] ) ? 1 : 0;
$link_title_hover = ( isset( $instance['title_hover_style'] ) && $instance['title_hover_style'] ) ? ' class="uk-link-' . $instance['title_hover_style'] . '"' : '';

$heading_style_cls      = ( isset( $instance['heading_style'] ) && $instance['heading_style'] ) ? ' uk-' . $instance['heading_style'] : '';
$heading_style_cls_init = ( empty( $heading_style_cls ) ) ? ' uk-card-title' : '';

$content_style  = ( isset( $instance['content_style'] ) && $instance['content_style'] ) ? ' uk-' . $instance['content_style'] : '';
$content_style .= ( isset( $instance['content_text_transform'] ) && $instance['content_text_transform'] ) ? ' uk-text-' . $instance['content_text_transform'] : '';
$content_style .= ( isset( $instance['content_margin_top'] ) && $instance['content_margin_top'] ) ? ' uk-margin-' . $instance['content_margin_top'] . '-top' : ' uk-margin-top';

$btn_margin_top = ( isset( $instance['button_margin_top'] ) && $instance['button_margin_top'] ) ? 'uk-margin-' . $instance['button_margin_top'] . '-top' : 'uk-margin-top';
$button_style = ( isset( $instance['link_button_style'] ) && $instance['link_button_style'] ) ? $instance['link_button_style'] : '';
$button_size  = ( isset( $instance['link_button_size'] ) && $instance['link_button_size'] ) ? ' ' . $instance['link_button_size'] : '';
$button_style_cls = '';
if ( empty( $button_style ) ) {
	$button_style_cls .= 'uk-button uk-button-default' . $button_size;
} elseif ( $button_style == 'link' || $button_style == 'link-muted' || $button_style == 'link-text' ) {
	$button_style_cls .= 'uk-' . $button_style;
} else {
	$button_style_cls .= 'uk-button uk-button-' . $button_style . $button_size;
}

// Remove margin for heading element
if ( $meta_element != 'div' || ( $meta_style_cls && $meta_style_cls != 'text-meta' ) ) {
	$meta_style .= ' uk-margin-remove-bottom';
}

$general_styles     =   \UIPro_Elementor_Helper::get_general_styles($instance);

$output             =   '<div class="ui-addon-marker'. $general_styles['container_cls'] . $general_styles['content_cls'] .'"' . $general_styles['animation'] . '>';
$output             .=  '<div class="uk-inline">';
$output             .=  \UIPro_Elementor_Helper::get_attachment_image_html( $instance );
if (count($uimarker_items)) {
	if ($uimarker_items > 1) $output .= '<div class="ui-popover-items' . ( $mobile_switcher == '1' ? ' uk-visible@s' : '' ) . '">';
	foreach ($uimarker_items as $item) {
		$marker_title   = ( isset( $item['marker_title'] ) && $item['marker_title'] ) ? $item['marker_title'] : '';
		$marker_meta    = ( isset( $item['marker_meta'] ) && $item['marker_meta'] ) ? $item['marker_meta'] : '';
		$marker_content = ( isset( $item['marker_content'] ) && $item['marker_content'] ) ? $item['marker_content'] : '';
		$marker_point_image =   isset( $item['marker_point_image'] ) && $item['marker_point_image'] ? $item['marker_point_image'] : array();

		$use_animation	    = (isset($item['use_animation']) && $item['use_animation']) ? intval($item['use_animation']) : 0;
		$animation_attribs  = (isset($item['repeat_animation']) && intval($item['repeat_animation'])) ? ' repeat: true;' : '';
		$animation_attribs  .=(isset($item['delay']) && $item['delay']) ? ' delay: '. $item['delay'].';' : '';

		$button_title = ( isset( $item['button_title'] ) && $item['button_title'] ) ? $item['button_title'] : '';
		if ( empty( $button_title ) ) {
			$button_title .= ( isset( $instance['all_button_title'] ) && $instance['all_button_title'] ) ? $instance['all_button_title'] : '';
		}

		$title_link = ( isset( $item['link'] ) && $item['link'] ) ? $item['link'] : array();
		$attribs    =   \UIPro_Elementor_Helper::get_link_attribs($title_link);
		$marker_position = ( isset( $item['marker_position'] ) && $item['marker_position'] ) ? 'pos: ' . $item['marker_position'] . ';' : '';
		if (isset( $marker_point_image['url'] ) && $marker_point_image['url'] ) {
			$output .= '<a class="ui-marker ui-marker-image uk-position-absolute uk-transform-center uk-overflow-hidden uk-border-circle elementor-repeater-item-'. $item['_id'] .'" href="#"'.($use_animation ? ' data-uk-scrollspy="cls: uk-animation-fade;'.$animation_attribs.'"' : '').'>'.\UIPro_Elementor_Helper::get_attachment_image_html( $item, 'marker_point_image' ).'</a>';
		} else {
			$output .= '<a class="ui-marker uk-position-absolute uk-transform-center elementor-repeater-item-'. $item['_id'] .'" data-uk-marker href="#"'.($use_animation ? ' data-uk-scrollspy="cls: uk-animation-fade;'.$animation_attribs.'"' : '').'></a>';
		}


		$output .= $mobile_switcher ? '<div data-uk-drop="' . $popover_animation . ( $marker_position ? $marker_position : $popover_position ) . $popover_mode . '">' : '<div data-uk-drop="' . $popover_animation . ( $marker_position ? $marker_position : $popover_position ) . $popover_mode . '">';

		$output .= '<div class="uk-card' . $card . $card_size . '">';

		$output .= '<div class="uk-card-media-top">';

		$output  .=  \UIPro_Elementor_Helper::get_attachment_image_html( $item, 'marker_image' );

		$output .= '</div>';

		$output .= '<div class="uk-card-body uk-margin-remove-first-child">';

		if ( $meta_alignment == 'top' && $marker_meta ) {
			$output .= '<' . $meta_element . ' class="ui-meta' . $meta_style . '">';
			$output .= $marker_meta;
			$output .= '</' . $meta_element . '>';
		}

		if ( $marker_title ) {
			$output .= '<' . $heading_selector . ' class="ui-title uk-margin-remove-bottom' . $heading_style . $heading_style_cls_init . $title_decoration . '">';
			$output .= ( $title_decoration == ' uk-heading-line' ) ? '<span>' : '';
			if ( $link_title && $title_link['url'] ) {
				$output .= '<a' . $link_title_hover . ' href="' . $title_link['url'] . '"' . $attribs . '>';
			}
			$output .= $marker_title;
			if ( $link_title && $title_link['url'] ) {
				$output .= '</a>';
			}
			$output .= ( $title_decoration == ' uk-heading-line' ) ? '</span>' : '';
			$output .= '</' . $heading_selector . '>';
		}

		if ( empty( $meta_alignment ) && $marker_meta ) {
			$output .= '<' . $meta_element . ' class="ui-meta' . $meta_style . '">';
			$output .= $marker_meta;
			$output .= '</' . $meta_element . '>';
		}

		if ( $meta_alignment == 'above' && $marker_meta ) {
			$output .= '<' . $meta_element . ' class="ui-meta' . $meta_style . '">';
			$output .= $marker_meta;
			$output .= '</' . $meta_element . '>';
		}

		if ( $marker_content ) {
			$output .= '<div class="ui-content uk-panel' . $content_style . '">';
			$output .= $marker_content;
			$output .= '</div>';
		}

		if ( $meta_alignment == 'content' && $marker_meta ) {
			$output .= '<' . $meta_element . ' class="ui-meta' . $meta_style . '">';
			$output .= $marker_meta;
			$output .= '</' . $meta_element . '>';
		}

		if ( $button_title && $title_link ) {
			$output .= '<div class="' . $btn_margin_top . '">';
			$output .= '<a class="' . $button_style_cls . '" href="' . $title_link['url'] . '"' . $attribs . '>' . $button_title . '</a>';
			$output .= '</div>';
		}

		$output .= '</div>';
		$output .= '</div>';

		$output .= '</div>'; // End Drop.
	}
	if ($uimarker_items > 1) $output .= '</div>';
}
$output     .=  '</div>';
$output     .=  '</div>';
echo ent2ncr($output);