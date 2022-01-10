<?php

$_is_elementor    = (isset($args['page_builder']) && $args['page_builder'] == 'elementor')?true:false;
$title_uppercase    = isset( $instance['title_uppercase'] ) ? $instance['title_uppercase'] : '';
$title_main         = ( isset( $instance['main_title'] ) && $instance['main_title'] != '' ) ? ' <span class="templaza-color">' . $instance['main_title'] . '</span>' : '';
$templaza_animation = $sub_heading = $sub_heading_css = $html = $css = $color_clone
    = $clone_css = $line = $clone_title = $line_css = '';
//$templaza_animation  .= thim_getCSSAnimation( $instance['css_animation'] );


//wp_add_inline_style('templaza-el-heading','.templaza-widget-heading{background: '.$instance['main_title_color'].';}');
//wp_add_inline_style('style-handle','.templaza-widget-heading{background: '.$instance['main_title_color'].';}');

if ( $title_uppercase ) {
	$css .= 'text-transform: uppercase;';
}

if ( $instance['textcolor'] ) {
	$css            .= 'color:' . $instance['textcolor'] . ';';
    $clone_css      = 'color:' . $instance['textcolor'] . ';';
//	$color_clone = 'style="color:' . $instance['textcolor'] . ';"';
}

$clone_css  .= isset($instance['clone_opacity']) && $instance['clone_opacity']?'opacity: '.$instance['opacity']:'';

//foreach ( $instance['custom_font_heading'] as $i => $feature ) :
if ( $instance['font_heading'] == 'custom' ) {
	if ( $instance['custom_font_heading']['custom_font_size'] <> '' ) {
		$css .= 'font-size:' . $instance['custom_font_heading']['custom_font_size'] . 'px;';
	}
	if ( $instance['custom_font_heading']['custom_font_weight'] <> '' ) {
		$css .= 'font-weight:' . $instance['custom_font_heading']['custom_font_weight'] . ';';
	}
	if ( $instance['custom_font_heading']['custom_font_style'] <> '' ) {
		$css .= 'font-style:' . $instance['custom_font_heading']['custom_font_style'] . ';';
	}
}

//endforeach;

if ( $css ) {
//    wp_add_inline_style('templaza-el-heading', '.sc_heading .title{'.$css.'}');
//	$css = ' style="' . $css . '"';
}

if ( $instance['sub_heading'] && $instance['sub_heading'] <> '' ) {
	if ( $instance['sub_heading_color'] ) {
		$sub_heading_css = 'color:' . $instance['sub_heading_color'] . ';';
	}

	$sub_heading = '<p class="sub-heading" style="' . $sub_heading_css . '">' . $instance['sub_heading'] . '</p>';
}

if ( $instance['line'] && $instance['line'] <> '' ) {
	if ( $instance['bg_line'] ) {
		$line_css = ' style="background-color:' . $instance['bg_line'] . '"';
	}
	$line = '<span' . (!$_is_elementor?$line_css:'') . ' class="line"></span>';
}

$clone_title = ! empty( $instance['clone_title'] ) ? 'clone_title' : '';

$text_align = '';
if ( $instance['text_align'] && $instance['text_align'] <> '' ) {
	$text_align = $instance['text_align'];
}


if ( $css ) {
    $id = '';
    if(isset($args['element_id']) && $args['element_id']){
        $id = $_is_elementor?' .elementor-element-'.$args['element_id']:'';
        $css    = $id . ' .sc_heading .title{' . $css . '}';

        $css   .= $color_clone?$id.' .src_heading .clone{'.$clone_css.'}':'';
    }

//    var_dump($id.' .sc_heading .title{'.$css.'}'); die();
//    if(!$_is_elementor) {
        wp_add_inline_style('templaza-el-heading',  $css );
//    }
//	$css = ' style="' . $css . '"';
}

$html .= '<div class="sc_heading ' . $clone_title . ' ' . $templaza_animation . ' ' . $text_align . '">';
$html .= '<' . $instance['size'] . (!$_is_elementor?$css:'') . ' class="title">' . $instance['title'] . $title_main
    . ($clone_title?'<span class="clone" ' . (!$_is_elementor?$color_clone:'') . '>' . $instance['title'] . '</span>':'')
    . '</' . $instance['size'] . '>';
//if ( $clone_title ) {
//	$html .= '<div class="clone h3" ' . $color_clone . '>' . $instance['title'] . '</div>';
//}
$html .= $sub_heading;
$html .= $line;
$html .= '</div>';

echo ent2ncr( $html );