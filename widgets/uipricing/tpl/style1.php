<?php

$_is_elementor  = (isset($args['page_builder']) && $args['page_builder'] == 'elementor')?true:false;
$title          = isset($instance['title']) ? $instance['title'] : '';
$title_tag      = isset($instance['title_tag']) ? $instance['title_tag'] : 'h3';
$title_style    = isset($instance['title_heading_style']) && $instance['title_heading_style'] ? ' uk-'. $instance['title_heading_style'] : '';
$title_style    .=isset($instance['title_heading_margin']) && $instance['title_heading_margin'] ? ($instance['title_heading_margin'] == 'default' ? ' uk-margin' : ' uk-margin-'. $instance['title_heading_margin']) : '';
$text           = isset($instance['text']) && $instance['text'] ? $instance['text'] : '';
$link           = isset($instance['button_link']) && $instance['button_link'] ? $instance['button_link'] : array();
$url            = isset($link['url']) && $link['url'] ? $link['url'] : '';
$attribs        = \UIPro_Elementor_Helper::get_link_attribs($link);
$button_text    = isset($instance['button_title']) && $instance['button_title'] ? $instance['button_title'] : '';
$button_style   = isset($instance['button_style']) && $instance['button_style'] ? ' uk-button-'. $instance['button_style'] : ' uk-button-default';
$button_shape   = isset($instance['button_shape']) && $instance['button_shape'] ? ' uk-border-'. $instance['button_shape'] : ' uk-border-rounded';
$button_size    = isset($instance['button_size']) && $instance['button_size'] ? ' uk-button-'. $instance['button_size'] : '';
$button_full_width    = isset($instance['button_full_width']) && $instance['button_full_width'] ? intval($instance['button_full_width']) : 0;
$button_margin  = isset($instance['button_margin']) && $instance['button_margin'] ? ($instance['button_margin'] == 'default' ? ' uk-margin' : ' uk-margin-'. $instance['button_margin']) : '';
$label_text   = ( isset( $instance['label_text'] ) && $instance['label_text'] ) ? $instance['label_text'] : '';
$label_styles = ( isset( $instance['label_styles'] ) && $instance['label_styles'] ) ? ' ' . $instance['label_styles'] : ' uk-label';
$btn_style = '';
if($button_style == ' uk-button-custom'){
    $btn_style = 'custom';
}
// Meta
$meta_element   = ( isset( $instance['meta_tag'] ) && $instance['meta_tag'] ) ? $instance['meta_tag'] : 'div';
$meta_style_cls = ( isset( $instance['meta_style'] ) && $instance['meta_style'] ) ? $instance['meta_style'] : '';

$meta_style  = ( isset( $instance['meta_style'] ) && $instance['meta_style'] ) ? ' uk-' . $instance['meta_style'] : '';
$meta_style .= ( isset( $instance['meta_margin'] ) && $instance['meta_margin'] ) ? ' uk-margin-' . $instance['meta_margin'] . '-top' : ' uk-margin-top';
$price_meta        = ( isset( $instance['meta'] ) && $instance['meta'] ) ? $instance['meta'] : '';

$meta_alignment = ( isset( $instance['meta_alignment'] ) && $instance['meta_alignment'] ) ? $instance['meta_alignment'] : '';

// Remove margin for heading element
if ( $meta_element != 'div' || ( $meta_style_cls && $meta_style_cls != 'text-meta' ) ) {
	$meta_style .= ' uk-margin-remove-bottom';
}

$price_description = ( isset( $instance['description'] ) && $instance['description'] ) ? $instance['description'] : '';

$price        = ( isset( $instance['price'] ) && $instance['price'] ) ? $instance['price'] : '';
$symbol       = ( isset( $instance['symbol'] ) && $instance['symbol'] ) ? $instance['symbol'] : '';
$symbol_pos       = ( isset( $instance['symbol_pos'] ) && $instance['symbol_pos'] ) ? $instance['symbol_pos'] : '';

//Pricing
$price_heading         = ( isset( $instance['price_style'] ) && $instance['price_style'] ) ? ' uk-' . $instance['price_style'] : '';
$price_margin_top      = ( isset( $instance['price_margin'] ) && $instance['price_margin'] ) ? ' uk-margin-' . $instance['price_margin'] . '-top' : ' uk-margin-top';
$feature_margin_top    = ( isset( $instance['feature_margin_top'] ) && $instance['feature_margin_top'] ) ? ' uk-margin-' . $instance['feature_margin_top'] . '-top' : ' uk-margin-top';
$price_symbol_heading  = ( isset( $instance['symbol_style'] ) && $instance['symbol_style'] ) ? ' uk-' . $instance['symbol_style'] : '';

//Description
$description_style  = ( isset( $instance['description_style'] ) && $instance['description_style'] ) ? ' uk-' . $instance['description_style'] : '';
$description_style .= ( isset( $instance['description_color'] ) && $instance['description_color'] ) ? ' uk-text-' . $instance['description_color'] : '';
$description_style .= ( isset( $instance['description_text_transform'] ) && $instance['description_text_transform'] ) ? ' uk-text-' . $instance['description_text_transform'] : '';
$description_style .= ( isset( $instance['description_margin'] ) && $instance['description_margin'] ) ? ' uk-margin-' . $instance['description_margin'] . '-top' : ' uk-margin-top';

//Card Style
$card_style     = isset($instance['card_style']) && $instance['card_style'] ? ' uk-card-'. $instance['card_style'] : '';
$card_size      = isset($instance['card_size']) && $instance['card_size'] ? ' uk-card-'. $instance['card_size'] : '';
$text_alignment          = ( isset( $instance['text_alignment'] ) && $instance['text_alignment'] ) ? ' uk-text-' . $instance['text_alignment'] : '';
$text_breakpoint         = ( $text_alignment ) ? ( ( isset( $instance['text_alignment_breakpoint'] ) && $instance['text_alignment_breakpoint'] ) ? '@' . $instance['text_alignment_breakpoint'] : '' ) : '';
$text_alignment_fallback = ( $text_alignment && $text_breakpoint ) ? ( ( isset( $instance['text_alignment_fallback'] ) && $instance['text_alignment_fallback'] ) ? ' uk-text-' . $instance['text_alignment_fallback'] : '' ) : '';
$text_alignment          .=$text_breakpoint. $text_alignment_fallback;
$icon_media    = ( isset( $instance['icon_price'] ) && $instance['icon_price'] ) ? $instance['icon_price'] : array();
$icon_on_price = '';
$align = '';
if($text_alignment ==' uk-text-right'){
    $align = ' uk-flex-last';
}
if(isset($icon_media['value'])){
    if (is_array($icon_media['value']) && isset($icon_media['value']['url']) && $icon_media['value']['url']) {
        $icon_on_price   .=  '<div class="ui_icon_on_price "><img src="'.$icon_media['value']['url'].'" alt="'.$title.'" data-uk-svg /></div>';
    } elseif (is_string($icon_media['value']) && $icon_media['value']) {
        $icon_on_price   .=  '<div class="ui_icon_on_price"><i class="' . $icon_media['value'] .'" aria-hidden="true"></i></div>';
    }
}
$general_styles = \UIPro_Elementor_Helper::get_general_styles($instance);
$output         = '';

if ($title) {
	$output     =   '<div class="ui-pricing ui-pricing-body ui-pricing-style1 uk-card'. $card_style . $card_size . $general_styles['container_cls'] .'"' . $general_styles['animation'] . '>';

    if ( $title || $price_meta) {
        $output .= '<div class="ui-pricing-header '.$text_alignment.'">';
        if ( $meta_alignment == 'top' ) {
            $output .= ( $price_meta ) ? '<span class="plan-period' . $meta_style . '">' . $price_meta . '</span>' : '';
        }
        $output .= '<'.$title_tag.' class="uk-card-title'.$title_style.'">'.$title.'</'.$title_tag.'>';
        if ( $meta_alignment == 'inline' ) {
            $output .= ( $price_meta ) ? '<span class="plan-period' . $meta_style . '">' . $price_meta . '</span>' : '';
        }
        if ( empty( $meta_alignment ) ) {
            $output .= ( $price_meta ) ? '<span class="plan-period' . $meta_style . '">' . $price_meta . '</span>' : '';
        }
        $output .= '</div>';
    }

	$output     .=  '<div class=" uk-margin-remove-first-child'.(isset($instance['card_size']) && $instance['card_size'] != 'none' ? ' uk-card-body' : '') . $general_styles['content_cls'] . '">';

    $output .= $icon_on_price;
	$output .= '<div class="pricing-value' . $price_margin_top . '">';
    if($symbol_pos !='right'){
        $output .= ( $symbol ) ? '<span class="pricing-symbol' . $price_symbol_heading . '">' . $symbol . '</span>' : '';
    }
	$output .= ( $price ) ? '<span class="pricing-amount' . $price_heading . '">' . $price . '</span>' : '';
    if($symbol_pos =='right'){
        $output .= ( $symbol ) ? '<span class="pricing-symbol' . $price_symbol_heading . '">' . $symbol . '</span>' : '';
    }
	$output .= ( $label_text ) ? '<div class="tz-price-table_featured f-2"><div class="tz-price-table_featured-inner' . $label_styles . '">' . $label_text . '</div></div>' : '';
	$output .= '</div>';

	$output .= ( $price_description ) ? '<div class="plan-description' . $description_style . '">' . $price_description . '</div>' : '';


	if ( isset( $instance['price_items'] ) && count( (array) $instance['price_items'] ) ) {
		$output .= '<div class="pricing-features' . $feature_margin_top . '">';

		$output .= '<ul class="uk-list">';

		foreach ( $instance['price_items'] as $key => $item ) {
			$title_link  = ( isset( $item['link'] ) && $item['link'] ) ? $item['link'] : array();
			$attribs     = \UIPro_Elementor_Helper::get_link_attribs($title_link);
			$text       = ( isset( $item['text'] ) && $item['text'] ) ? $item['text'] : '';
			$key++;

			//Icon style
			$icon_type          = ( isset( $item['icon_type'] ) && $item['icon_type'] ) ? $item['icon_type'] : '';
			$uikit_icon         = ( isset( $item['uikit_icon'] ) && $item['uikit_icon'] ) ? $item['uikit_icon'] : '';
			$icon_size          = ( isset( $item['icon_size'] ) && $item['icon_size']['size'] ) ? $item['icon_size']['size'] : '';
			$icon               = ( isset( $item['icon'] ) && $item['icon'] ) ? $item['icon'] : array();
			$media              = '';
			if ($icon_type == 'uikit' && $uikit_icon) {
				$media   .=  '<span class="uk-icon" data-uk-icon="icon: ' . $uikit_icon . '; width: '.$icon_size.'"></span>';
			} elseif ($icon && isset($icon['value'])) {
				if (is_array($icon['value']) && isset($icon['value']['url']) && $icon['value']['url']) {
					$media   .=  '<img src="'.$icon['value']['url'].'" data-uk-svg />';
				} elseif (is_string($icon['value']) && $icon['value']) {
					$media   .=  '<i class="' . $icon['value'] .'" aria-hidden="true"></i>';
				}
			}

			$output .= '<li class="ui-item elementor-repeater-item-' . $item['_id'].'">';
			if ( $media ) {
				$output .= '<div class="uk-grid-small uk-child-width-expand uk-flex-nowrap uk-flex-middle" data-uk-grid>';
				$output .= '<div class="uk-width-auto pricing-icon uk-flex uk-flex-middle ' .$align.'">';
				$output .= $media;
				$output .= '</div>';
				$output .= '<div>';
			}

			$output .= '<div class="el-content uk-panel">';
			$output .= ( isset($title_link['url']) && $title_link['url'] ) ? '<a class="el-link uk-margin-remove-last-child" href="' . $title_link['url'] . '" ' . $attribs . '>' : '';
			$output .= $text;
			$output .= ( isset($title_link['url']) && $title_link['url'] ) ? '</a>' : '';
			$output .= '</div>';

			if ( $media ) {
				$output .= '</div>';
				$output .= '</div>';
			}

			$output .= '</li>';
		}
		$output .= '</ul>';

		$output .= '</div>';
	}

	$output     .=  $button_text ? '<div class="ui-button'.$button_margin.' '.$btn_style.'"><a class="uk-button'.$button_style.$button_shape.$button_size.($button_full_width ? ' uk-width-1-1' : '').'" href="'.$url.'"'.$attribs.'>'.$button_text.'</a></div>' : '';

	$output     .=  '</div>';

	$output     .=  '</div>';
	echo ent2ncr($output);
}