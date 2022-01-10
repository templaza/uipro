<?php

$_is_elementor  = (isset($args['page_builder']) && $args['page_builder'] == 'elementor')?true:false;
$uiaccordions   = isset($instance['uiaccordions']) ? $instance['uiaccordions'] : array();

$multiple     = ( isset( $instance['multiple'] ) && $instance['multiple']=='1' ) ? 1 : 0;
$multiple_cls = ( $multiple ) ? ' multiple: true' : '';
$closed       = ( isset( $instance['closed'] ) && $instance['closed']=='1' ) ? 1 : 0;
$closed_cls   = ( $closed ) ? 'collapsible: true;' : 'collapsible: false;';

$card      = ( isset( $instance['accordion_style'] ) && $instance['accordion_style'] ) ? ' uk-card-' . $instance['accordion_style'] : '';
$card_size = ( isset( $instance['card_size'] ) && $instance['card_size'] ) ? ' uk-card-' . $instance['card_size'] : '';

$positions = ( isset( $instance['positions'] ) && $instance['positions'] ) ? $instance['positions'] : '';

$grid_cls    = ( isset( $instance['grid_width'] ) && $instance['grid_width'] ) ? ' uk-width-' . $instance['grid_width'] : '';
$grid_cls_bp = ( isset( $instance['grid_breakpoint'] ) && $instance['grid_breakpoint'] ) ? '@' . $instance['grid_breakpoint'] : '';

$vertical_alignment = ( isset( $instance['vertical_alignment'] ) && $instance['vertical_alignment'] ) ? 1 : 0;

$image_grid_column_gap = ( isset( $instance['image_grid_column_gap'] ) && $instance['image_grid_column_gap'] ) ? $instance['image_grid_column_gap'] : '';
$image_grid_row_gap    = ( isset( $instance['image_grid_row_gap'] ) && $instance['image_grid_row_gap'] ) ? $instance['image_grid_row_gap'] : '';

$image_grid_cr_gap = '';
if ( $image_grid_column_gap == $image_grid_row_gap ) {
	$image_grid_cr_gap .= ( ! empty( $image_grid_column_gap ) && ! empty( $image_grid_row_gap ) ) ? ' uk-grid-' . $image_grid_column_gap : '';
} else {
	$image_grid_cr_gap .= ! empty( $image_grid_column_gap ) ? ' uk-grid-column-' . $image_grid_column_gap : '';
	$image_grid_cr_gap .= ! empty( $image_grid_row_gap ) ? ' uk-grid-row-' . $image_grid_row_gap : '';
}

$image_grid_cr_gap .= ( $vertical_alignment ) ? ' uk-flex-middle' : '';

$heading_style  = ( isset( $instance['title_color'] ) && $instance['title_color'] ) ? ' uk-text-' . $instance['title_color'] : '';
$heading_style .= ( isset( $instance['title_text_transform'] ) && $instance['title_text_transform'] ) ? ' uk-text-' . $instance['title_text_transform'] : '';

$content_style             = ( isset( $instance['content_style'] ) && $instance['content_style'] ) ? ' uk-' . $instance['content_style'] : '';
$content_dropcap           = ( isset( $instance['content_dropcap'] ) && $instance['content_dropcap'] ) ? 1 : 0;
$content_style            .= ( $content_dropcap ) ? ' uk-dropcap' : '';
$content_style            .= ( isset( $instance['content_text_transform'] ) && $instance['content_text_transform'] ) ? ' uk-text-' . $instance['content_text_transform'] : '';
$content_column            = ( isset( $instance['content_column'] ) && $instance['content_column'] ) ? ' uk-column-' . $instance['content_column'] : '';
$content_column_breakpoint = ( $content_column ) ? ( ( isset( $instance['content_column_breakpoint'] ) && $instance['content_column_breakpoint'] ) ? '@' . $instance['content_column_breakpoint'] : '' ) : '';
$content_column_divider    = ( $content_column ) ? ( ( isset( $instance['content_column_divider'] ) && $instance['content_column_divider'] ) ? ' uk-column-divider' : false ) : '';

$content_style .= $content_column . $content_column_breakpoint . $content_column_divider;
$content_style .= ( isset( $instance['content_margin_top'] ) && $instance['content_margin_top'] ) ? ' uk-margin-' . $instance['content_margin_top'] . '-top' : ' uk-margin-top';

$img_class = ( $positions == 'right' ) ? ' uk-flex-last' . $grid_cls_bp . '' : '';

$attribs     = ( isset( $instance['target'] ) && $instance['target'] ) ? ' target="' . $instance['target'] . '"' : '';
$btn_styles  = ( isset( $instance['button_style'] ) && $instance['button_style'] ) ? $instance['button_style'] : '';
$button_size = ( isset( $instance['button_size'] ) && $instance['button_size'] ) ? ' ' . $instance['button_size'] : '';

$button_style_cls = '';
if ( empty( $btn_styles ) ) {
	$button_style_cls .= 'uk-button uk-button-default' . $button_size;
} elseif ( $btn_styles == 'link' || $btn_styles == 'link-muted' || $btn_styles == 'link-text' ) {
	$button_style_cls .= 'uk-' . $btn_styles;
} else {
	$button_style_cls .= 'uk-button uk-button-' . $btn_styles . $button_size;
}

$btn_margin_top   = ( isset( $instance['button_margin_top'] ) && $instance['button_margin_top'] ) ? 'uk-margin-' . $instance['button_margin_top'] . '-top' : 'uk-margin-top';
$all_button_title = ( isset( $instance['all_button_title'] ) && $instance['all_button_title'] ) ? $instance['all_button_title'] : 'Learn more';

$image_styles     = ( isset( $instance['image_border'] ) && $instance['image_border'] ) ? ' uk-border-' . $instance['image_border'] : '';
$image_margin_top = ( isset( $instance['image_margin_top'] ) && $instance['image_margin_top'] ) ? ' uk-margin-' . $instance['image_margin_top'] . '-top' : ' uk-margin-top';

$general_styles     =   \UIPro_Elementor_Helper::get_general_styles($instance);

$output         =   '';

if (count($uiaccordions)) {
	$output     =   '<div class="ui-accordion'. $general_styles['container_cls'] .'"' . $general_styles['animation'] . '>';
	if ($uiaccordions > 1) $output .= '<div class="' . $general_styles['content_cls'] . '" data-uk-accordion="'. $closed_cls . $multiple_cls .'">';
	foreach ($uiaccordions as $item) {
		$title     = ( isset( $item['title'] ) && $item['title'] ) ? $item['title'] : '';
		$content   = ( isset( $item['content'] ) && $item['content'] ) ? $item['content'] : '';
		$image     = ( isset( $item['image'] ) && $item['image'] ) ? $item['image'] : '';
		$image_src = $image['url'];

		$alt_text       = ( isset( $item['alt_text'] ) && $item['alt_text'] ) ? $item['alt_text'] : '';
		$title_alt_text = ( isset( $item['title'] ) && $item['title'] ) ? $item['title'] : '';
		$alt_text_init  = ( empty( $alt_text ) ) ? 'alt="' . str_replace( '"', '', $title_alt_text ) . '"' : 'alt="' . str_replace( '"', '', $alt_text ) . '"';

		$title_link     = ( isset( $item['link'] ) && $item['link'] ) ? $item['link'] : '';
		$check_target   = ( isset( $instance['target'] ) && $instance['target'] ) ? $instance['target'] : '';
		$render_linkscroll = ( empty( $check_target ) && strpos( $title_link['url'], '#' ) === 0 ) ? ' uk-scroll' : '';

		$button_title = ( isset( $item['link_title'] ) && $item['link_title'] ) ? $item['link_title'] : '';
		if ( empty( $button_title ) ) {
			$button_title .= $all_button_title;
		}
		if ( ! empty( $card ) ) {
			$output .= '<div class="tz-item uk-card uk-card-body' . $card . $card_size . '">';
			$output .= '<a class="tz-title uk-accordion-title' . $heading_style . '" href="#">';
		} else {
			$output .= '<div class="uk-panel">';
			$output .= '<a class="tz-title uk-accordion-title' . $heading_style . '" href="#">';
		}

		$output .= $title;
		$output .= '</a>';

		$output .= '<div class="uk-accordion-content uk-margin-remove-first-child">';

		if ( ( $positions == 'left' || $positions == 'right' ) && $image_src ) {

			$output .= '<div class="uk-child-width-expand' . $image_grid_cr_gap . '" uk-grid>';

			$output .= '<div class="' . $grid_cls . $grid_cls_bp . $img_class . '">';

//			$output .= '<img class="tz-image' . $image_styles . '" src="' . $image_src . '" ' . $alt_text_init . '>';
			$output .= \UIPro_Elementor_Helper::get_attachment_image_html( $item );

			$output .= '</div>';

			$output .= '<div>';

		}

		if ( $positions == 'top' && $image_src ) {
			$output .= \UIPro_Elementor_Helper::get_attachment_image_html( $item );
		}

		if ( $content ) {
			$output .= '<div class="ui-content uk-panel' . $content_style . '">';
			$output .= $content;
			$output .= '</div>';
		}

		$output .= ( $title_link['url'] ) ? '<div class="' . $btn_margin_top . '"><a class="' . $button_style_cls . '" href="' . $title_link['url'] . '"' . $attribs . $render_linkscroll . '>' . $button_title . '</a></div>' : '';

		if ( $positions == 'bottom' && $image_src ) {
//			$output .= '<img class="tz-image' . $image_styles . $image_margin_top . '" src="' . $image_src . '" ' . $alt_text_init . '>';
			$output .= \UIPro_Elementor_Helper::get_attachment_image_html( $item );
		}

		if ( ( $positions == 'left' || $positions == 'right' ) && $image_src ) {
			$output .= '</div>';
			$output .= '</div>';
		}
		$output .= '</div>'; // end acc content div

		$output .= '</div>';
	}
	if ($uiaccordions > 1) $output .= '</div>';
	$output     .=  '</div>';
	echo ent2ncr($output);
}