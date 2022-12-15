<?php

$_is_elementor      = (isset($args['page_builder']) && $args['page_builder'] == 'elementor')?true:false;
$heading_style      = isset($instance['heading_style'])?$instance['heading_style']:'';
$highlight_title    = ( isset( $instance['highlight_title'] ) && $instance['highlight_title'] != '' ) ?$instance['highlight_title']: '';
$after_highlight_title    = ( isset( $instance['after_highlight_title'] ) && $instance['after_highlight_title'] != '' ) ?$instance['after_highlight_title']: '';
$addon_margin       = ( isset( $instance['addon_margin'] ) && $instance['addon_margin'] != '' ) ?$instance['addon_margin']: '';
$general            = ( $addon_margin ) ? ' uk-margin' . ( ( $addon_margin == 'default' ) ? '' : '-' . $addon_margin ) : '';
$general           .= ( isset( $instance['visibility'] ) && $instance['visibility'] != '' ) ?$instance['visibility']: '';

$title_style        = ( isset( $instance['title_heading_style'] ) && $instance['title_heading_style'] != '' ) ?' uk-'.$instance['title_heading_style']: '';
$title_style       .= ( isset($instance['title_heading_margin'] ) && $instance['title_heading_margin']) ? ' uk-margin-' . $instance['title_heading_margin'] : ' uk-margin';

$max_width_cfg      = ( isset( $instance['addon_max_width'] ) && $instance['addon_max_width'] ) ? ' uk-width-' . $instance['addon_max_width'] : '';

$addon_max_width_breakpoint = ( $max_width_cfg ) ? ( ( isset($instance['addon_max_width_breakpoint']) && $instance['addon_max_width_breakpoint'] ) ? '@' . $instance['addon_max_width_breakpoint'] : '' ) : '';
$block_align            = ( isset($instance['block_align']) && $instance['block_align']) ?$instance['block_align']: '';
$block_align_breakpoint = ( isset($instance['block_align_breakpoint']) && $instance['block_align_breakpoint'] ) ? '@' . $instance['block_align_breakpoint'] : '';
$block_align_fallback   = ( isset( $instance['block_align_fallback']) && $instance['block_align_fallback'] ) ? $instance['block_align_fallback'] : '';

$text_alignment          = ( isset($instance['text_align']) && $instance['text_align'] ) ? ' ' . $instance['text_align'] : '';
$text_breakpoint         = ( $text_alignment ) ? ( ( isset($instance['text_breakpoint']) && $instance['text_breakpoint'] ) ? '@' . $instance['text_breakpoint'] : '' ) : '';
$text_alignment_fallback = ( $text_alignment && $text_breakpoint ) ? ((isset($instance['text_alignment_fallback']) && $instance['text_alignment_fallback'] )?' uk-text-'.$instance['text_alignment_fallback']:'') : '';

$general_styles     =   \UIPro_Elementor_Helper::get_general_styles($instance);

$heading_line       = isset($instance['line_style'])?$instance['line_style']:'';
$heading_line_class = ($heading_line == 'uk-heading-bullet' || $heading_line == 'uk-heading-line')?' '.$heading_line:'';

// Text Background
$text_background    = isset($instance['text_background'])?filter_var($instance['text_background'], FILTER_VALIDATE_BOOLEAN):false;

$text_background_image = ( isset( $instance['text_background_image'] ) && $instance['text_background_image'] ) ? $instance['text_background_image'] : '';
$text_background_src   = isset( $text_background_image['url'] ) ? $text_background_image['url'] : $text_background_image;
//if ( strpos( $text_background_src, 'http://' ) !== false || strpos( $text_background_src, 'https://' ) !== false ) {
//    $text_background_src = $text_background_src;
//} elseif ( $text_background_src ) {
//    $text_background_src = JURI::base( true ) . '/' . $text_background_src;
//}

$text_background_image_effect  = ( isset( $instance['text_background_image_effect'] ) && $instance['text_background_image_effect'] ) ? $instance['text_background_image_effect'] : '';
$text_background_image_styles  = ( isset( $instance['text_background_image_size'] ) && $instance['text_background_image_size'] ) ? ' ' . $instance['text_background_image_size'] : '';

$text_background_horizontal_start = ( isset( $instance['text_background_horizontal_start'] ) && $instance['text_background_horizontal_start'] ) ? $instance['text_background_horizontal_start'] : '0';
$text_background_horizontal_end   = ( isset( $instance['text_background_horizontal_end'] ) && $instance['text_background_horizontal_end'] ) ? $instance['text_background_horizontal_end'] : '0';
$text_background_horizontal       = ( ! empty( $text_background_horizontal_start ) || ! empty( $text_background_horizontal_end ) ) ? 'bgx: ' . $text_background_horizontal_start . ',' . $text_background_horizontal_end . ';' : '';

$text_background_vertical_start = ( isset( $instance['text_background_vertical_start'] ) && $instance['text_background_vertical_start'] ) ? $instance['text_background_vertical_start'] : '0';
$text_background_vertical_end   = ( isset( $instance['text_background_vertical_end'] ) && $instance['text_background_vertical_end'] ) ? $instance['text_background_vertical_end'] : '0';
$text_background_vertical       = ( ! empty( $text_background_vertical_start ) || ! empty( $text_background_vertical_end ) ) ? 'bgy: ' . $text_background_vertical_start . ',' . $text_background_vertical_end . ';' : '';

$text_background_easing     = ( isset( $instance['text_background_easing'] ) && $instance['text_background_easing'] ) ? ( (int) $instance['text_background_easing'] / 100 ) : '';
$text_background_easing_cls = ( ! empty( $text_background_easing ) ) ? 'easing:' . $text_background_easing . ';' : '';

$parallax_background_init = ( $text_background_image_effect == 'parallax' ) ? ' uk-parallax="' . $text_background_horizontal . $text_background_vertical . $text_background_easing_cls . '"' : '';
$parallax_background_cls  = ( $text_background_image_effect == 'fixed' ) ? ' uk-background-fixed' : '';

$text_background_class  = $text_background?' uk-text-background'.$parallax_background_cls.$text_background_image_styles.'"':'';
$text_background_attrib = $text_background?' style="background-image: url('.$text_background_src.');"'. $parallax_background_init:'';

// Block Alignment CLS.
$block_cls = array();

if ( empty( $block_align ) ) {
    if ( ! empty( $block_align_breakpoint ) && ! empty( $block_align_fallback ) ) {
        $block_cls[] = ' uk-margin-auto-right' . $block_align_breakpoint;
        $block_cls[] = 'uk-margin-remove-left' . $block_align_breakpoint . ( $block_align_fallback == 'center' ? ' uk-margin-auto' : ' uk-margin-auto-left' );
    }
}

if ( $block_align == 'center' ) {
    $block_cls[] = ' uk-margin-auto' . $block_align_breakpoint;
    if ( ! empty( $block_align_breakpoint ) && ! empty( $block_align_fallback ) ) {
        $block_cls[] = 'uk-margin-auto' . ( $block_align_fallback == 'right' ? '-left' : '' );
    }
}

if ( $block_align == 'right' ) {
    $block_cls[] = ' uk-margin-auto-left' . $block_align_breakpoint;
    if ( ! empty( $block_align_breakpoint ) && ! empty( $block_align_fallback ) ) {
        $block_cls[] = $block_align_fallback == 'center' ? 'uk-margin-remove-right' . $block_align_breakpoint . ' uk-margin-auto' : 'uk-margin-auto-left';
    }
}

$block_cls      = implode( ' ', array_filter( $block_cls ) );

$max_width_cfg .= $addon_max_width_breakpoint . ( $max_width_cfg ? $block_cls : '' );

$general       .= $text_breakpoint . $text_alignment_fallback . $max_width_cfg;

$templaza_animation = $sub_heading = $sub_heading_css = $html = $css = $color_clone
    = $clone_css = $line = $clone_title = $line_css = '';

if ( $instance['textcolor'] ) {
	$css            .= 'color:' . $instance['textcolor'] . ';';
    $clone_css      = 'color:' . $instance['textcolor'] . ';';
//	$color_clone = 'style="color:' . $instance['textcolor'] . ';"';
}

$clone_css  .= isset($instance['clone_opacity']) && $instance['clone_opacity']?'opacity: '.$instance['opacity']:'';

if ( $css ) {
//    wp_add_inline_style('templaza-el-heading', '.sc_heading .title{'.$css.'}');
//	$css = ' style="' . $css . '"';
}

if ( $instance['sub_heading'] && $instance['sub_heading'] <> '' ) {
	$sub_heading = '<span class="sub-heading uk-flex uk-flex-inline">' . $instance['sub_heading'] . '</span>';
}

if ( $instance['line'] && $instance['line'] <> '' ) {
	if ( $instance['bg_line'] ) {
		$line_css = ' style="background-color:' . $instance['bg_line'] . '"';
	}
	if($instance['line_style'] == 'line_style1'){
        $line = '<div class="'.$instance['line_style'].' uk-flex uk-flex-middle"><span class="line-before"></span> <span' . (!$_is_elementor?$line_css:'') . ' class="line"></span><span class="line-after"></span> </div>';
    }elseif($instance['line_style'] == 'line_style2'){
        $line = '<div class="'.$instance['line_style'].' uk-flex uk-flex-column "><span class="line-before"></span> <span' . (!$_is_elementor?$line_css:'') . ' class="line"></span><span class="line-after"></span> </div>';
    }else{
        $line = '<span' . (!$_is_elementor?$line_css:'') . ' class="line uk-flex uk-flex-inline"></span>';
    }
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

    if(!$_is_elementor) {
        wp_add_inline_style('templaza-el-heading',  $css );
    }
}

switch ($heading_style){
    case 'circle':
        $heading_style  = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M325,18C228.7-8.3,118.5,8.3,78,21C22.4,38.4,4.6,54.6,5.6,77.6c1.4,32.4,52.2,54,142.6,63.7 c66.2,7.1,212.2,7.5,273.5-8.3c64.4-16.6,104.3-57.6,33.8-98.2C386.7-4.9,179.4-1.4,126.3,20.7"></path></svg>';
        break;
    case 'curly-line':
        $heading_style  = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M3,146.1c17.1-8.8,33.5-17.8,51.4-17.8c15.6,0,17.1,18.1,30.2,18.1c22.9,0,36-18.6,53.9-18.6 c17.1,0,21.3,18.5,37.5,18.5c21.3,0,31.8-18.6,49-18.6c22.1,0,18.8,18.8,36.8,18.8c18.8,0,37.5-18.6,49-18.6c20.4,0,17.1,19,36.8,19 c22.9,0,36.8-20.6,54.7-18.6c17.7,1.4,7.1,19.5,33.5,18.8c17.1,0,47.2-6.5,61.1-15.6"></path></svg>';
        break;
    case 'double':
        $heading_style  = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M8.4,143.1c14.2-8,97.6-8.8,200.6-9.2c122.3-0.4,287.5,7.2,287.5,7.2"></path><path d="M8,19.4c72.3-5.3,162-7.8,216-7.8c54,0,136.2,0,267,7.8"></path></svg>';
        break;
    case 'double-line':
        $heading_style  = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M5,125.4c30.5-3.8,137.9-7.6,177.3-7.6c117.2,0,252.2,4.7,312.7,7.6"></path><path d="M26.9,143.8c55.1-6.1,126-6.3,162.2-6.1c46.5,0.2,203.9,3.2,268.9,6.4"></path></svg>';
        break;
    case 'zigzag':
        $heading_style  = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M9.3,127.3c49.3-3,150.7-7.6,199.7-7.4c121.9,0.4,189.9,0.4,282.3,7.2C380.1,129.6,181.2,130.6,70,139 c82.6-2.9,254.2-1,335.9,1.3c-56,1.4-137.2-0.3-197.1,9"></path></svg>';
        break;
    case 'diagonal':
        $heading_style  = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M13.5,15.5c131,13.7,289.3,55.5,475,125.5"></path></svg>';
        break;
    case 'underline':
        $heading_style  = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M7.7,145.6C109,125,299.9,116.2,401,121.3c42.1,2.2,87.6,11.8,87.3,25.7"></path></svg>';
        break;
    case 'delete':
        $heading_style  = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M497.4,23.9C301.6,40,155.9,80.6,4,144.4"></path><path d="M14.1,27.6c204.5,20.3,393.8,74,467.3,111.7"></path></svg>';
        break;
    case 'strike':
        $heading_style  = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M3,75h493.5"></path></svg>';
        break;
}

if(!empty($instance['title'])) {
    $html .= '<div class="sc_heading uk-flex uk-flex-column uk-position-relative' . $text_alignment . $clone_title . $general_styles['container_cls'] . $general_styles['content_cls'] . '"' . $general_styles['animation'] . '>';
    if($instance['sub_heading_position']=='before_title'){
        $html .= $sub_heading;
    }
    $html .= '<' . $instance['header_size'] . (!$_is_elementor ? $css : '') . ' class="title' . $general
        . $title_style.$heading_line_class . '">';
    $html .= '<span class="heading-highlighted-wrapper">';

    if(isset($instance['link']['url']) && !empty($instance['link']['url'])) {
        $target     = $instance['link']['is_external'] ? ' target="_blank"' : '';
        $nofollow   = $instance['link']['nofollow'] ? ' rel="nofollow"' : '';
        $attribs    = $instance['link']['custom_attributes'] ? ' '.$instance['link']['custom_attributes'] : '';
        $link_class = 'uk-link-heading';
        $link_class.= isset($instance['link']['custom_class'])?$instance['link']['custom_class']:'';

        $html .= '<a class="'.$link_class.'" href="' . $instance['link']['url'] . '"'.$target.$nofollow.$attribs.'>';
    }

    $html .= '<span class="heading-plain-text'.$text_background_class.'"'.$text_background_attrib.'>' . $instance['title'] . '</span>';
    if ($highlight_title) {
        $html .= '<span class="heading-highlighted-text heading-highlighted-text-active">' . $highlight_title . $heading_style . '</span>';
    }
    if ($after_highlight_title) {
	    $html .= '<span class="heading-plain-text">' . $after_highlight_title . '</span>';
    }
    $html .= ($clone_title ? '<span class="clone" ' . (!$_is_elementor ? $color_clone : '') . '>' . $instance['title'] . '</span>' : '');

    if(isset($instance['link']['url']) && !empty($instance['link']['url'])) {
        $html .= '</a>';
    }

    $html .= '</span>';
    $html .= '</' . $instance['header_size'] . '>';
    if($instance['sub_heading_position']=='after_title'){
        $html .= $sub_heading;
    }
    if($heading_line != 'uk-heading-bullet' && $heading_line != 'uk-heading-line') {
        $html .= $line;
    }
    $html .= '</div>';

    echo ent2ncr($html);
}