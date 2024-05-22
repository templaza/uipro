<?php

$_is_elementor      = (isset($args['page_builder']) && $args['page_builder'] == 'elementor')?true:false;

$general_styles     =   \UIPro_Elementor_Helper::get_general_styles($instance);

//responsive width
$large_desktop_columns    = ( isset( $instance['large_desktop_columns'] ) && $instance['large_desktop_columns'] ) ? $instance['large_desktop_columns'] : '4';
$desktop_columns    = ( isset( $instance['desktop_columns'] ) && $instance['desktop_columns'] ) ? $instance['desktop_columns'] : '4';
$laptop_columns     = ( isset( $instance['laptop_columns'] ) && $instance['laptop_columns'] ) ? $instance['laptop_columns'] : '3';
$tablet_columns     = ( isset( $instance['tablet_columns'] ) && $instance['tablet_columns'] ) ? $instance['tablet_columns'] : '2';
$mobile_columns     = ( isset( $instance['mobile_columns'] ) && $instance['mobile_columns'] ) ? $instance['mobile_columns'] : '1';
$column_grid_gap    = ( isset( $instance['column_grid_gap'] ) && $instance['column_grid_gap'] ) ? ' uk-grid-'. $instance['column_grid_gap'] : '';

$box_shadow   = ( isset( $instance['box_shadow'] ) && $instance['box_shadow'] ) ? ' uk-box-shadow-' . $instance['box_shadow'] : '';

$attrs_slideshow[] = '';
$attrs_slideshow[] = ( isset( $instance['ratio'] ) && $instance['ratio'] ) ? 'ratio: ' . $instance['ratio'] : '';
$attrs_slideshow[] = ( isset( $instance['min_height'] ) && isset( $instance['min_height']['size'] ) && $instance['min_height']['size'] ) ? 'min-height: ' . $instance['min_height']['size'] : 'min-height: 300';
$attrs_slideshow[] = ( isset( $instance['max_height'] ) && isset( $instance['max_height']['size'] ) && $instance['max_height']['size'] ) ? 'max-height: ' . $instance['max_height']['size'] : '';
$attrs_slideshow[] = ( isset( $instance['slider_set'] ) && $instance['slider_set'] ) ? 'sets: true' : '';
$attrs_slideshow[] = ( isset( $instance['slider_center'] ) && $instance['slider_center'] ) ? 'center: true' : '';
$attrs_slideshow[] = ( isset( $instance['autoplay'] ) && $instance['autoplay'] ) ? 'autoplay: 1' : '';
$attrs_slideshow[] = ( isset( $instance['autoplay'] ) && $instance['autoplay'] ) && ! ( isset( $instance['pause'] ) && $instance['pause'] ) ? 'pauseOnHover: false' : '';
$attrs_slideshow[] = ( isset( $instance['autoplay'] ) && $instance['autoplay'] ) && ( isset( $instance['autoplay_interval'] ) && isset( $instance['autoplay_interval']['size'] ) && $instance['autoplay_interval']['size'] ) ? 'autoplayInterval: ' . ( (int) $instance['autoplay_interval']['size'] * 1000 ) : '';
$attrs_slideshow[] = ( isset( $instance['velocity'] ) && isset( $instance['velocity']['size'] ) && $instance['velocity']['size'] ) ? 'velocity: ' . (int) $instance['velocity']['size'] / 100 : '';
$attrs_slideshow   = ' data-uk-slider="' . implode( '; ', array_filter( $attrs_slideshow ) ) . '"';

$kenburns_transition = ( isset( $instance['kenburns_transition'] ) && $instance['kenburns_transition'] ) ? ' uk-transform-origin-' . $instance['kenburns_transition'] : '';

$kenburns_duration = ( isset( $instance['kenburns_duration'] ) && isset( $instance['kenburns_duration']['size'] ) && $instance['kenburns_duration']['size'] ) ? $instance['kenburns_duration']['size'] : '';
if ( $kenburns_duration ) {
	$kenburns_duration = ' style="-webkit-animation-duration: ' . $kenburns_duration . 's; animation-duration: ' . $kenburns_duration . 's;"';
}

$min_height = ( isset( $instance['min_height'] ) && isset( $instance['min_height']['size'] ) && $instance['min_height']['size'] ) ? 'min-height: ' . $instance['min_height']['size'] . ';' : 'minHeight: 300;';
$height     = ( isset( $instance['height'] ) && $instance['height'] ) ? $instance['height'] : '';
$height_cls = '';
if ( $height == 'full' ) {
	$height_cls .= ' data-uk-height-viewport="offset-top: true; ' . $min_height . '"';
} elseif ( $height == 'percent' ) {
	$height_cls .= ' data-uk-height-viewport="offset-top: true; ' . $min_height . 'offset-bottom: 20"';
} elseif ( $height == 'section' ) {
	$height_cls .= ' data-uk-height-viewport="offset-top: true; ' . $min_height . 'offset-bottom: !.elementor-section +"';
}

// Navigation settings.
$navigation_control         = ( isset( $instance['navigation'] ) && $instance['navigation'] ) ? $instance['navigation'] : '';
$navigation_breakpoint      = ( isset( $instance['navigation_breakpoint'] ) && $instance['navigation_breakpoint'] ) ? $instance['navigation_breakpoint'] : '';
$navigation_breakpoint_cls  = '';
$navigation_breakpoint_cls .= ( $navigation_breakpoint ) ? ' uk-visible@' . $navigation_breakpoint . '' : '';

$navigation_margin = ( isset( $instance['navigation_margin'] ) && $instance['navigation_margin'] ) ? ' uk-position-' . $instance['navigation_margin'] : '';

$navigation = ( isset( $instance['navigation_position'] ) && $instance['navigation_position'] ) ? ' uk-position-' . $instance['navigation_position'] : '';

$navigation_title_selector   = ( isset( $instance['navigation_title_selector'] ) && $instance['navigation_title_selector'] ) ? $instance['navigation_title_selector'] : 'h5';

$navigation_cls  = ( $navigation == ' uk-position-bottom-center' ) ? ' uk-flex-center' : '';
$navigation_cls .= ( $navigation == ' uk-position-bottom-right' || $navigation == ' uk-position-center-right' || $navigation == ' uk-position-top-right' ) ? ' uk-flex-right' : '';

$navigation_below = ( isset( $instance['navigation_below'] ) && $instance['navigation_below'] ) ? 1 : 0;
$navigation_group = ( isset( $instance['navigation_dot_group'] ) && $instance['navigation_dot_group'] ) ? 1 : 0;

$navigation_below_cls        = ( $navigation_below ) ? ( ( isset( $instance['navigation_below_position'] ) && $instance['navigation_below_position'] ) ? ' uk-flex-' . $instance['navigation_below_position'] : '' ) : false;
$navigation_below_margin_cls = ( $navigation_below ) ? ( ( isset( $instance['navigation_below_margin'] ) && $instance['navigation_below_margin'] ) ? ' uk-margin-' . $instance['navigation_below_margin'] : '' ) : false;
$navigation_below_color_cls  = ( $navigation_below ) ? ( ( isset( $instance['navigation_color'] ) && $instance['navigation_color'] ) ? ' uk-' . $instance['navigation_color'] : '' ) : false;

$navigation_vertical       = ( ! $navigation_below ) ? ( ( isset( $instance['navigation_vertical'] ) && $instance['navigation_vertical'] ) ? ' uk-dotnav-vertical' : '' ) : '';
$navigation_vertical_thumb = ( ! $navigation_below ) ? ( ( isset( $instance['navigation_vertical'] ) && $instance['navigation_vertical'] ) ? ' uk-thumbnav-vertical' : '' ) : '';

$thumbnav_wrap     = ( isset( $instance['thumbnav_wrap'] ) && $instance['thumbnav_wrap'] ) ? 1 : 0;
$thumbnav_wrap_cls = ( $thumbnav_wrap ) ? ( ( isset( $instance['thumbnav_wrap'] ) && $instance['thumbnav_wrap'] ) ? ' uk-flex-nowrap' : '' ) : false;

// Sidenav Settings.
$slidenav_position     = ( isset( $instance['slidenav_position'] ) && $instance['slidenav_position'] ) ? $instance['slidenav_position'] : '';
$slidenav_position_cls = ( ! empty( $slidenav_position ) || ( $slidenav_position != 'default' ) ) ? ' uk-position-' . $slidenav_position . '' : '';

$slidenav_margin = ( isset( $instance['slidenav_margin'] ) && $instance['slidenav_margin'] ) ? ' uk-position-' . $instance['slidenav_margin'] . '' : '';

$slidenav_on_hover       = ( isset( $instance['slidenav_on_hover'] ) && $instance['slidenav_on_hover'] ) ? 1 : 0;
$slidenav_breakpoint     = ( isset( $instance['slidenav_breakpoint'] ) && $instance['slidenav_breakpoint'] ) ? $instance['slidenav_breakpoint'] : '';
$slidenav_breakpoint_cls = ( $slidenav_breakpoint ) ? ' uk-visible@' . $slidenav_breakpoint . '' : '';

$slidenav_outside_breakpoint = ( isset( $instance['slidenav_outside_breakpoint'] ) && $instance['slidenav_outside_breakpoint'] ) ? ' @' . $instance['slidenav_outside_breakpoint'] : 'xl';

$slidenav_outside_color = ( isset( $instance['slidenav_outside_color'] ) && $instance['slidenav_outside_color'] ) ? ' uk-' . $instance['slidenav_outside_color'] : '';

$larger_style      = ( isset( $instance['larger_style'] ) && $instance['larger_style'] ) ? $instance['larger_style'] : '';
$larger_style_init = ( $larger_style ) ? ' uk-slidenav-large' : '';

$overlay_positions = ( isset( $instance['overlay_positions'] ) && $instance['overlay_positions'] ) ? $instance['overlay_positions'] : '';
$overlay_pos_int   = ( $overlay_positions == 'top' || $overlay_positions == 'bottom' ) ? ' uk-flex-1' : '';
if ( ( $overlay_positions == 'top' ) || ( $overlay_positions == 'left' ) || ( $overlay_positions == 'bottom' ) || ( $overlay_positions == 'right' ) ) {
	$overlay_positions = ' uk-flex-' . $overlay_positions;
} elseif ( $overlay_positions == 'top-left' ) {
	$overlay_positions = ' uk-flex-top uk-flex-left';
} elseif ( $overlay_positions == 'top-right' ) {
	$overlay_positions = ' uk-flex-top uk-flex-right';
} elseif ( $overlay_positions == 'top-center' ) {
	$overlay_positions = ' uk-flex-top uk-flex-center';
} elseif ( $overlay_positions == 'center-left' ) {
	$overlay_positions = ' uk-flex-left uk-flex-middle';
} elseif ( $overlay_positions == 'center-right' ) {
	$overlay_positions = ' uk-flex-right uk-flex-middle';
} elseif ( $overlay_positions == 'center' ) {
	$overlay_positions = ' uk-flex-center uk-flex-middle';
} elseif ( $overlay_positions == 'bottom-left' ) {
	$overlay_positions = ' uk-flex-bottom uk-flex-left';
} elseif ( $overlay_positions == 'bottom-center' ) {
	$overlay_positions = ' uk-flex-bottom uk-flex-center';
} elseif ( $overlay_positions == 'bottom-right' ) {
	$overlay_positions = ' uk-flex-bottom uk-flex-right';
}

$overlay_styles     = ( isset( $instance['overlay_styles'] ) && $instance['overlay_styles'] ) ? ' uk-' . $instance['overlay_styles'] . '' : '';
$overlay_styles_int = ( $overlay_styles ) ? 'uk-overlay' : 'uk-panel';

$overlay_container = ( isset( $instance['overlay_container'] ) && $instance['overlay_container'] ) ? $instance['overlay_container'] : '';

$overlay_container_cls = ( $overlay_container ) ? ' ' . ( ( $overlay_container == 'default' ) ? 'uk-container' : 'uk-container uk-container-' . $overlay_container ) : '';

$overlay_container_padding = ( $overlay_container ) ? ( ( isset( $instance['overlay_container_padding'] ) && $instance['overlay_container_padding'] ) ? ' uk-section-' . $instance['overlay_container_padding'] : '' ) : '';

$overlay_padding = ( $overlay_styles ) ? ( ( isset( $instance['overlay_padding'] ) && $instance['overlay_padding'] ) ? ' uk-padding-' . $instance['overlay_padding'] : '' ) : '';

$overlay_position_check = ( isset( $instance['overlay_positions'] ) && $instance['overlay_positions'] ) ? $instance['overlay_positions'] : '';

$overlay_width = '';

if ( $overlay_position_check != 'top' && $overlay_position_check != 'bottom' ) {
	$overlay_width = ( isset( $instance['overlay_width'] ) && $instance['overlay_width'] ) ? ' uk-width-' . $instance['overlay_width'] : '';
}

$overlay_margin = ( isset( $instance['overlay_margin'] ) && $instance['overlay_margin'] ) ? $instance['overlay_margin'] : '';

$overlay_margin_cls = ( empty( $overlay_container ) && ! empty( $overlay_margin ) ) ? ( ( $overlay_margin == 'none' ) ? '' : ' uk-padding-' . $overlay_margin ) : '';

$overlay_margin_cls .= ( empty( $overlay_container ) && empty( $overlay_margin ) ) ? ' uk-padding' : '';

$thumbnail_width     = ( isset( $instance['thumbnail_width'] ) && isset( $instance['thumbnail_width']['size'] ) && $instance['thumbnail_width']['size'] ) ? $instance['thumbnail_width']['size'] : '100';
$thumbnail_width_cls = ( $thumbnail_width ) ? ' width="' . $thumbnail_width . '"' : '';

$thumbnail_height     = ( isset( $instance['thumbnail_height'] ) && isset( $instance['thumbnail_height']['size'] ) && $instance['thumbnail_height']['size'] ) ? $instance['thumbnail_height']['size'] : '';
$thumbnail_height_cls = ( $thumbnail_height ) ? ' height="' . $thumbnail_height . '"' : '';

$item_color = ( isset( $instance['item_color'] ) && $instance['item_color'] ) ? ' uk-' . $instance['item_color'] : '';

$overlay_transition = ( isset( $instance['overlay_transition'] ) && $instance['overlay_transition'] ) ? ' uk-transition-' . $instance['overlay_transition'] : '';

$overlay_horizontal_start = ( isset( $instance['overlay_horizontal_start'] ) && isset( $instance['overlay_horizontal_start']['size'] ) && $instance['overlay_horizontal_start']['size'] ) ? $instance['overlay_horizontal_start']['size'] : '0';
$overlay_horizontal_end   = ( isset( $instance['overlay_horizontal_end'] ) && isset( $instance['overlay_horizontal_end']['size'] ) && $instance['overlay_horizontal_end']['size'] ) ? $instance['overlay_horizontal_end']['size'] : '0';

$overlay_horizontal = ( ! empty( $overlay_horizontal_start ) || ! empty( $overlay_horizontal_end ) ) ? 'x: ' . $overlay_horizontal_start . ',0,' . $overlay_horizontal_end . ';' : '';

$overlay_vertical_start = ( isset( $instance['overlay_vertical_start'] ) &&  isset( $instance['overlay_vertical_start']['size'] ) && $instance['overlay_vertical_start']['size'] ) ? $instance['overlay_vertical_start']['size'] : '0';
$overlay_vertical_end   = ( isset( $instance['overlay_vertical_end'] ) && isset( $instance['overlay_vertical_end']['size'] ) && $instance['overlay_vertical_end']['size'] ) ? $instance['overlay_vertical_end']['size'] : '0';

$overlay_vertical = ( ! empty( $overlay_vertical_start ) || ! empty( $overlay_vertical_end ) ) ? 'y: ' . $overlay_vertical_start . ',0,' . $overlay_vertical_end . ';' : '';

$overlay_scale_start = ( isset( $instance['overlay_scale_start'] ) && isset( $instance['overlay_scale_start']['size'] ) && $instance['overlay_scale_start']['size'] ) ? ( (int) $instance['overlay_scale_start']['size'] / 100 ) : '';
$overlay_scale_end   = ( isset( $instance['overlay_scale_end'] ) && isset( $instance['overlay_scale_end']['size'] ) && $instance['overlay_scale_end']['size'] ) ? ( (int) $instance['overlay_scale_end']['size'] / 100 ) : '';
$overlay_scale       = '';

if ( ! empty( $overlay_scale_start ) && empty( $overlay_scale_end ) ) {
	$overlay_scale .= 'scale: ' . $overlay_scale_start . ',1,1;';
} elseif ( empty( $overlay_scale_start ) && ! empty( $overlay_scale_end ) ) {
	$overlay_scale .= 'scale: 1,1,' . $overlay_scale_end . ';';
} elseif ( empty( $overlay_scale_start ) && empty( $overlay_scale_end ) ) {
	$overlay_scale .= '';
} else {
	$overlay_scale .= 'scale: ' . $overlay_scale_start . ',1,' . $overlay_scale_end . ';';
}

$overlay_rotate_start = ( isset( $instance['overlay_rotate_start'] ) && isset( $instance['overlay_rotate_start']['size'] ) && $instance['overlay_rotate_start']['size'] ) ? $instance['overlay_rotate_start']['size'] : '0';
$overlay_rotate_end   = ( isset( $instance['overlay_rotate_end'] ) && isset( $instance['overlay_rotate_end']['size'] ) && $instance['overlay_rotate_end']['size'] ) ? $instance['overlay_rotate_end']['size'] : '0';
$overlay_rotate       = ( ! empty( $overlay_rotate_start ) || ! empty( $overlay_rotate_end ) ) ? 'rotate: ' . $overlay_rotate_start . ',0,' . $overlay_rotate_end . ';' : '';

$overlay_opacity_start = ( isset( $instance['overlay_opacity_start'] ) && isset( $instance['overlay_opacity_start']['size'] ) && $instance['overlay_opacity_start']['size'] ) ? ( (int) $instance['overlay_opacity_start']['size'] / 100 ) : '';
$overlay_opacity_end   = ( isset( $instance['overlay_opacity_end'] ) && isset( $instance['overlay_opacity_end']['size'] ) && $instance['overlay_opacity_end']['size'] ) ? ( (int) $instance['overlay_opacity_end']['size'] / 100 ) : '';
$overlay_opacity       = '';

if ( ! empty( $overlay_opacity_start ) && empty( $overlay_opacity_end ) ) {
	$overlay_opacity .= 'opacity: ' . $overlay_opacity_start . ',1,1;';
} elseif ( empty( $overlay_opacity_start ) && ! empty( $overlay_opacity_end ) ) {
	$overlay_opacity .= 'opacity: 1,1,' . $overlay_opacity_end . ';';
} elseif ( empty( $overlay_opacity_start ) && empty( $overlay_opacity_end ) ) {
	$overlay_opacity .= '';
} else {
	$overlay_opacity .= 'opacity: ' . $overlay_opacity_start . ',1,' . $overlay_opacity_end . ';';
}
$overlay_parallax_cls = '';

if ( ! empty( $overlay_horizontal ) || ! empty( $overlay_vertical ) || ! empty( $overlay_scale ) || ! empty( $overlay_rotate ) || ! empty( $overlay_opacity ) ) {
	$overlay_parallax_cls .= ' data-uk-slideshow-parallax="' . $overlay_horizontal . $overlay_vertical . $overlay_scale . $overlay_rotate . $overlay_opacity . '"';
}

$image_transition   = ( isset( $instance['image_transition'] ) && $instance['image_transition'] ) ? ' uk-transition-' . $instance['image_transition'] . ' uk-transition-opaque' : '';
$ripple_effect = (isset($instance['image_transition']) && $instance['image_transition']) ? ($instance['image_transition']) : '';
$image_open = (isset($instance['image_open']) && $instance['image_open']) ? ($instance['image_open']) : '';
$ripple_cl = $ripple_html = $img_tran_cl = ' ';
if($ripple_effect =='ripple'){
    $ripple_html = '<div class="templaza-ripple-circles uk-position-center uk-transition-fade">
                        <div class="circle1"></div>
                        <div class="circle2"></div>
                        <div class="circle3"></div>
                    </div>';
    $ripple_cl = ' templaza-thumb-ripple ';
}
if($image_transition){
    $img_tran_cl =' uk-transition-toggle '.$ripple_cl.' ';
}
$gallery_id   = isset($instance['element_id'])?$instance['element_id']:uniqid();

// Title Parallax.
$title_horizontal_start = ( isset( $instance['title_horizontal_start'] ) && isset( $instance['title_horizontal_start']['size'] ) && $instance['title_horizontal_start']['size'] ) ? $instance['title_horizontal_start']['size'] : '0';
$title_horizontal_end   = ( isset( $instance['title_horizontal_end'] ) && isset( $instance['title_horizontal_end']['size'] ) && $instance['title_horizontal_end']['size'] ) ? $instance['title_horizontal_end']['size'] : '0';
$title_horizontal       = ( ! empty( $title_horizontal_start ) || ! empty( $title_horizontal_end ) ) ? 'x: ' . $title_horizontal_start . ',0,' . $title_horizontal_end . ';' : '';

$title_vertical_start = ( isset( $instance['title_vertical_start'] ) && isset( $instance['title_vertical_start']['size'] ) && $instance['title_vertical_start']['size'] ) ? $instance['title_vertical_start']['size'] : '0';
$title_vertical_end   = ( isset( $instance['title_vertical_end'] ) && isset( $instance['title_vertical_end']['size'] ) && $instance['title_vertical_end']['size'] ) ? $instance['title_vertical_end']['size'] : '0';
$title_vertical       = ( ! empty( $title_vertical_start ) || ! empty( $title_vertical_end ) ) ? 'y: ' . $title_vertical_start . ',0,' . $title_vertical_end . ';' : '';

$title_scale_start = ( isset( $instance['title_scale_start'] ) && isset( $instance['title_scale_start']['size'] ) && $instance['title_scale_start']['size'] ) ? ( (int) $instance['title_scale_start']['size'] / 100 ) : '';
$title_scale_end   = ( isset( $instance['title_scale_end'] ) && isset( $instance['title_scale_end']['size'] ) && $instance['title_scale_end']['size'] ) ? ( (int) $instance['title_scale_end']['size'] / 100 ) : '';
$title_scale       = '';

if ( ! empty( $title_scale_start ) && empty( $title_scale_end ) ) {
	$title_scale .= 'scale: ' . $title_scale_start . ',1,1;';
} elseif ( empty( $title_scale_start ) && ! empty( $title_scale_end ) ) {
	$title_scale .= 'scale: 1,1,' . $title_scale_end . ';';
} elseif ( empty( $title_scale_start ) && empty( $title_scale_end ) ) {
	$title_scale .= '';
} else {
	$title_scale .= 'scale: ' . $title_scale_start . ',1,' . $title_scale_end . ';';
}

$title_rotate_start = ( isset( $instance['title_rotate_start'] ) && isset( $instance['title_rotate_start']['size'] ) && $instance['title_rotate_start']['size'] ) ? $instance['title_rotate_start']['size'] : '0';
$title_rotate_end   = ( isset( $instance['title_rotate_end'] ) && isset( $instance['title_rotate_end']['size'] ) && $instance['title_rotate_end']['size'] ) ? $instance['title_rotate_end']['size'] : '0';
$title_rotate       = ( ! empty( $title_rotate_start ) || ! empty( $title_rotate_end ) ) ? 'rotate: ' . $title_rotate_start . ',0,' . $title_rotate_end . ';' : '';

$title_opacity_start = ( isset( $instance['title_opacity_start'] ) && isset( $instance['title_opacity_start']['size'] ) && $instance['title_opacity_start']['size'] ) ? ( (int) $instance['title_opacity_start']['size'] / 100 ) : '';
$title_opacity_end   = ( isset( $instance['title_opacity_end'] ) && isset( $instance['title_opacity_end']['size'] ) && $instance['title_opacity_end']['size'] ) ? ( (int) $instance['title_opacity_end']['size'] / 100 ) : '';
$title_opacity       = '';

if ( ! empty( $title_opacity_start ) && empty( $title_opacity_end ) ) {
	$title_opacity .= 'opacity: ' . $title_opacity_start . ',1,1;';
} elseif ( empty( $title_opacity_start ) && ! empty( $title_opacity_end ) ) {
	$title_opacity .= 'opacity: 1,1,' . $title_opacity_end . ';';
} elseif ( empty( $title_opacity_start ) && empty( $title_opacity_end ) ) {
	$title_opacity .= '';
} else {
	$title_opacity .= 'opacity: ' . $title_opacity_start . ',1,' . $title_opacity_end . ';';
}

$use_title_parallax = ( isset( $instance['use_title_parallax'] ) && $instance['use_title_parallax'] ) ? 1 : 0;
$title_transition   = '';
if ( empty( $overlay_transition ) && $use_title_parallax ) {
	if ( ! empty( $title_horizontal ) || ! empty( $title_vertical ) || ! empty( $title_scale ) || ! empty( $title_rotate ) || ! empty( $title_opacity ) ) {
		$title_transition .= ' data-uk-slideshow-parallax="' . $title_horizontal . $title_vertical . $title_scale . $title_rotate . $title_opacity . '"';
	}
}

// Meta Parallax.
$meta_horizontal_start = ( isset( $instance['meta_horizontal_start'] ) && isset( $instance['meta_horizontal_start']['size'] ) && $instance['meta_horizontal_start']['size'] ) ? $instance['meta_horizontal_start']['size'] : '0';
$meta_horizontal_end   = ( isset( $instance['meta_horizontal_end'] ) && isset( $instance['meta_horizontal_end']['size'] ) && $instance['meta_horizontal_end']['size'] ) ? $instance['meta_horizontal_end']['size'] : '0';
$meta_horizontal       = ( ! empty( $meta_horizontal_start ) || ! empty( $meta_horizontal_end ) ) ? 'x: ' . $meta_horizontal_start . ',0,' . $meta_horizontal_end . ';' : '';

$meta_vertical_start = ( isset( $instance['meta_vertical_start'] ) && isset( $instance['meta_vertical_start']['size'] ) && $instance['meta_vertical_start']['size'] ) ? $instance['meta_vertical_start']['size'] : '0';
$meta_vertical_end   = ( isset( $instance['meta_vertical_end'] ) && isset( $instance['meta_vertical_end']['size'] ) && $instance['meta_vertical_end']['size'] ) ? $instance['meta_vertical_end']['size'] : '0';
$meta_vertical       = ( ! empty( $meta_vertical_start ) || ! empty( $meta_vertical_end ) ) ? 'y: ' . $meta_vertical_start . ',0,' . $meta_vertical_end . ';' : '';

$meta_scale_start = ( isset( $instance['meta_scale_start'] ) && isset( $instance['meta_scale_start']['size'] ) && $instance['meta_scale_start']['size'] ) ? ( (int) $instance['meta_scale_start']['size'] / 100 ) : '';
$meta_scale_end   = ( isset( $instance['meta_scale_end'] ) && isset( $instance['meta_scale_end']['size'] ) && $instance['meta_scale_end']['size'] ) ? ( (int) $instance['meta_scale_end']['size'] / 100 ) : '';
$meta_scale       = '';

if ( ! empty( $meta_scale_start ) && empty( $meta_scale_end ) ) {
	$meta_scale .= 'scale: ' . $meta_scale_start . ',1,1;';
} elseif ( empty( $meta_scale_start ) && ! empty( $meta_scale_end ) ) {
	$meta_scale .= 'scale: 1,1,' . $meta_scale_end . ';';
} elseif ( empty( $meta_scale_start ) && empty( $meta_scale_end ) ) {
	$meta_scale .= '';
} else {
	$meta_scale .= 'scale: ' . $meta_scale_start . ',1,' . $meta_scale_end . ';';
}

$meta_rotate_start = ( isset( $instance['meta_rotate_start'] ) && isset( $instance['meta_rotate_start']['size'] ) && $instance['meta_rotate_start']['size'] ) ? $instance['meta_rotate_start']['size'] : '0';
$meta_rotate_end   = ( isset( $instance['meta_rotate_end'] ) && isset( $instance['meta_rotate_end']['size'] ) && $instance['meta_rotate_end']['size'] ) ? $instance['meta_rotate_end']['size'] : '0';
$meta_rotate       = ( ! empty( $meta_rotate_start ) || ! empty( $meta_rotate_end ) ) ? 'rotate: ' . $meta_rotate_start . ',0,' . $meta_rotate_end . ';' : '';

$meta_opacity_start = ( isset( $instance['meta_opacity_start'] ) && isset( $instance['meta_opacity_start']['size'] ) && $instance['meta_opacity_start']['size'] ) ? ( (int) $instance['meta_opacity_start']['size'] / 100 ) : '';
$meta_opacity_end   = ( isset( $instance['meta_opacity_end'] ) && isset( $instance['meta_opacity_end']['size'] ) && $instance['meta_opacity_end']['size'] ) ? ( (int) $instance['meta_opacity_end']['size'] / 100 ) : '';
$meta_opacity       = '';

if ( ! empty( $meta_opacity_start ) && empty( $meta_opacity_end ) ) {
	$meta_opacity .= 'opacity: ' . $meta_opacity_start . ',1,1;';
} elseif ( empty( $meta_opacity_start ) && ! empty( $meta_opacity_end ) ) {
	$meta_opacity .= 'opacity: 1,1,' . $meta_opacity_end . ';';
} elseif ( empty( $meta_opacity_start ) && empty( $meta_opacity_end ) ) {
	$meta_opacity .= '';
} else {
	$meta_opacity .= 'opacity: ' . $meta_opacity_start . ',1,' . $meta_opacity_end . ';';
}

$use_meta_parallax = ( isset( $instance['use_meta_parallax'] ) && $instance['use_meta_parallax'] ) ? 1 : 0;

$meta_transition = '';
if ( empty( $overlay_transition ) && $use_meta_parallax ) {
	if ( ! empty( $meta_horizontal ) || ! empty( $meta_vertical ) || ! empty( $meta_scale ) || ! empty( $meta_rotate ) || ! empty( $meta_opacity ) ) {
		$meta_transition .= ' data-uk-slideshow-parallax="' . $meta_horizontal . $meta_vertical . $meta_scale . $meta_rotate . $meta_opacity . '"';
	}
}

// Content Parallax.
$content_horizontal_start = ( isset( $instance['content_horizontal_start'] ) && isset( $instance['content_horizontal_start']['size'] ) && $instance['content_horizontal_start']['size'] ) ? $instance['content_horizontal_start']['size'] : '0';
$content_horizontal_end   = ( isset( $instance['content_horizontal_end'] ) && isset( $instance['content_horizontal_end']['size'] ) && $instance['content_horizontal_end']['size'] ) ? $instance['content_horizontal_end']['size'] : '0';
$content_horizontal       = ( ! empty( $content_horizontal_start ) || ! empty( $content_horizontal_end ) ) ? 'x: ' . $content_horizontal_start . ',0,' . $content_horizontal_end . ';' : '';

$content_vertical_start = ( isset( $instance['content_vertical_start'] ) && isset( $instance['content_vertical_start']['size'] ) && $instance['content_vertical_start']['size'] ) ? $instance['content_vertical_start']['size'] : '0';
$content_vertical_end   = ( isset( $instance['content_vertical_end'] ) && isset( $instance['content_vertical_end']['size'] ) && $instance['content_vertical_end']['size'] ) ? $instance['content_vertical_end']['size'] : '0';
$content_vertical       = ( ! empty( $content_vertical_start ) || ! empty( $content_vertical_end ) ) ? 'y: ' . $content_vertical_start . ',0,' . $content_vertical_end . ';' : '';

$content_scale_start = ( isset( $instance['content_scale_start'] ) && isset( $instance['content_scale_start']['size'] ) && $instance['content_scale_start']['size'] ) ? ( (int) $instance['content_scale_start']['size'] / 100 ) : '';
$content_scale_end   = ( isset( $instance['content_scale_end'] ) && isset( $instance['content_scale_end']['size'] ) && $instance['content_scale_end']['size'] ) ? ( (int) $instance['content_scale_end']['size'] / 100 ) : '';
$content_scale       = '';

if ( ! empty( $content_scale_start ) && empty( $content_scale_end ) ) {
	$content_scale .= 'scale: ' . $content_scale_start . ',1,1;';
} elseif ( empty( $content_scale_start ) && ! empty( $content_scale_end ) ) {
	$content_scale .= 'scale: 1,1,' . $content_scale_end . ';';
} elseif ( empty( $content_scale_start ) && empty( $content_scale_end ) ) {
	$content_scale .= '';
} else {
	$content_scale .= 'scale: ' . $content_scale_start . ',1,' . $content_scale_end . ';';
}

$content_rotate_start = ( isset( $instance['content_rotate_start'] ) && isset( $instance['content_rotate_start']['size'] ) && $instance['content_rotate_start']['size'] ) ? $instance['content_rotate_start']['size'] : '0';
$content_rotate_end   = ( isset( $instance['content_rotate_end'] ) && isset( $instance['content_rotate_end']['size'] ) && $instance['content_rotate_end']['size'] ) ? $instance['content_rotate_end']['size'] : '0';
$content_rotate       = ( ! empty( $content_rotate_start ) || ! empty( $content_rotate_end ) ) ? 'rotate: ' . $content_rotate_start . ',0,' . $content_rotate_end . ';' : '';

$content_opacity_start = ( isset( $instance['content_opacity_start'] ) && isset( $instance['content_opacity_start']['size'] ) && $instance['content_opacity_start']['size'] ) ? ( (int) $instance['content_opacity_start']['size'] / 100 ) : '';
$content_opacity_end   = ( isset( $instance['content_opacity_end'] ) && isset( $instance['content_opacity_end']['size'] ) && $instance['content_opacity_end']['size'] ) ? ( (int) $instance['content_opacity_end']['size'] / 100 ) : '';
$content_opacity       = '';

if ( ! empty( $content_opacity_start ) && empty( $content_opacity_end ) ) {
	$content_opacity .= 'opacity: ' . $content_opacity_start . ',1,1;';
} elseif ( empty( $content_opacity_start ) && ! empty( $content_opacity_end ) ) {
	$content_opacity .= 'opacity: 1,1,' . $content_opacity_end . ';';
} elseif ( empty( $content_opacity_start ) && empty( $content_opacity_end ) ) {
	$content_opacity .= '';
} else {
	$content_opacity .= 'opacity: ' . $content_opacity_start . ',1,' . $content_opacity_end . ';';
}

$use_content_parallax = ( isset( $instance['use_content_parallax'] ) && $instance['use_content_parallax'] ) ? 1 : 0;

$content_transition = '';
if ( empty( $overlay_transition ) && $use_content_parallax ) {
	if ( ! empty( $content_horizontal ) || ! empty( $content_vertical ) || ! empty( $content_scale ) || ! empty( $content_rotate ) || ! empty( $content_opacity ) ) {
		$content_transition .= ' data-uk-slideshow-parallax="' . $content_horizontal . $content_vertical . $content_scale . $content_rotate . $content_opacity . '"';
	}
}

// Button Parallax.
$button_horizontal_start = ( isset( $instance['button_horizontal_start'] ) && isset( $instance['button_horizontal_start']['size'] ) && $instance['button_horizontal_start']['size'] ) ? $instance['button_horizontal_start']['size'] : '0';
$button_horizontal_end   = ( isset( $instance['button_horizontal_end'] ) && isset( $instance['button_horizontal_end']['size'] ) && $instance['button_horizontal_end']['size'] ) ? $instance['button_horizontal_end']['size'] : '0';
$button_horizontal       = ( ! empty( $button_horizontal_start ) || ! empty( $button_horizontal_end ) ) ? 'x: ' . $button_horizontal_start . ',0,' . $button_horizontal_end . ';' : '';

$button_vertical_start = ( isset( $instance['button_vertical_start'] ) && isset( $instance['button_vertical_start']['size'] ) && $instance['button_vertical_start']['size'] ) ? $instance['button_vertical_start']['size'] : '0';
$button_vertical_end   = ( isset( $instance['button_vertical_end'] ) && isset( $instance['button_vertical_end']['size'] ) && $instance['button_vertical_end']['size'] ) ? $instance['button_vertical_end']['size'] : '0';
$button_vertical       = ( ! empty( $button_vertical_start ) || ! empty( $button_vertical_end ) ) ? 'y: ' . $button_vertical_start . ',0,' . $button_vertical_end . ';' : '';

$button_scale_start = ( isset( $instance['button_scale_start'] ) && isset( $instance['button_scale_start']['size'] ) && $instance['button_scale_start']['size'] ) ? ( (int) $instance['button_scale_start']['size'] / 100 ) : '';
$button_scale_end   = ( isset( $instance['button_scale_end'] ) && isset( $instance['button_scale_end']['size'] ) && $instance['button_scale_end']['size'] ) ? ( (int) $instance['button_scale_end']['size'] / 100 ) : '';
$button_scale       = '';

if ( ! empty( $button_scale_start ) && empty( $button_scale_end ) ) {
	$button_scale .= 'scale: ' . $button_scale_start . ',1,1;';
} elseif ( empty( $button_scale_start ) && ! empty( $button_scale_end ) ) {
	$button_scale .= 'scale: 1,1,' . $button_scale_end . ';';
} elseif ( empty( $button_scale_start ) && empty( $button_scale_end ) ) {
	$button_scale .= '';
} else {
	$button_scale .= 'scale: ' . $button_scale_start . ',1,' . $button_scale_end . ';';
}

$button_rotate_start = ( isset( $instance['button_rotate_start'] ) && isset( $instance['button_rotate_start']['size'] ) && $instance['button_rotate_start']['size'] ) ? $instance['button_rotate_start']['size'] : '0';
$button_rotate_end   = ( isset( $instance['button_rotate_end'] ) && isset( $instance['button_rotate_end']['size'] ) && $instance['button_rotate_end']['size'] ) ? $instance['button_rotate_end']['size'] : '0';
$button_rotate       = ( ! empty( $button_rotate_start ) || ! empty( $button_rotate_end ) ) ? 'rotate: ' . $button_rotate_start . ',0,' . $button_rotate_end . ';' : '';

$button_opacity_start = ( isset( $instance['button_opacity_start'] ) && isset( $instance['button_opacity_start']['size'] ) && $instance['button_opacity_start']['size'] ) ? ( (int) $instance['button_opacity_start']['size'] / 100 ) : '';
$button_opacity_end   = ( isset( $instance['button_opacity_end'] ) && isset( $instance['button_opacity_end']['size'] ) && $instance['button_opacity_end']['size'] ) ? ( (int) $instance['button_opacity_end']['size'] / 100 ) : '';
$button_opacity       = '';

if ( ! empty( $button_opacity_start ) && empty( $button_opacity_end ) ) {
	$button_opacity .= 'opacity: ' . $button_opacity_start . ',1,1;';
} elseif ( empty( $button_opacity_start ) && ! empty( $button_opacity_end ) ) {
	$button_opacity .= 'opacity: 1,1,' . $button_opacity_end . ';';
} elseif ( empty( $button_opacity_start ) && empty( $button_opacity_end ) ) {
	$button_opacity .= '';
} else {
	$button_opacity .= 'opacity: ' . $button_opacity_start . ',1,' . $button_opacity_end . ';';
}
$use_button_parallax = ( isset( $instance['use_button_parallax'] ) && $instance['use_button_parallax'] ) ? 1 : 0;
$button_transition   = '';
if ( empty( $overlay_transition ) && $use_button_parallax ) {
	if ( ! empty( $button_horizontal ) || ! empty( $button_vertical ) || ! empty( $button_scale ) || ! empty( $button_rotate ) || ! empty( $button_opacity ) ) {
		$button_transition .= ' data-uk-slideshow-parallax="' . $button_horizontal . $button_vertical . $button_scale . $button_rotate . $button_opacity . '"';
	}
}

// New style options.

$heading_selector = ( isset( $instance['heading_selector'] ) && $instance['heading_selector'] ) ? $instance['heading_selector'] : 'h3';
$heading_style    = ( isset( $instance['heading_style'] ) && $instance['heading_style'] ) ? ' uk-' . $instance['heading_style'] : '';
$heading_style   .= ( isset( $instance['title_color'] ) && $instance['title_color'] ) ? ' uk-text-' . $instance['title_color'] : '';
$heading_style   .= ( isset( $instance['title_text_transform'] ) && $instance['title_text_transform'] ) ? ' uk-text-' . $instance['title_text_transform'] : '';
$heading_style   .= ( isset( $instance['title_margin_top'] ) && $instance['title_margin_top'] ) ? ' uk-margin-' . $instance['title_margin_top'] . '-top' : ' uk-margin-top';
$title_decoration = ( isset( $instance['title_decoration'] ) && $instance['title_decoration'] ) ? ' ' . $instance['title_decoration'] : '';

$content_style  = ( isset( $instance['content_style'] ) && $instance['content_style'] ) ? ' uk-' . $instance['content_style'] : '';
$content_style .= ( isset( $instance['content_text_transform'] ) && $instance['content_text_transform'] ) ? ' uk-text-' . $instance['content_text_transform'] : '';
$content_style .= ( isset( $instance['content_margin_top'] ) && $instance['content_margin_top'] ) ? ' uk-margin-' . $instance['content_margin_top'] . '-top' : ' uk-margin-top';

$meta_element   = ( isset( $instance['meta_element'] ) && $instance['meta_element'] ) ? $instance['meta_element'] : 'div';
$meta_style_cls = ( isset( $instance['meta_style'] ) && $instance['meta_style'] ) ? $instance['meta_style'] : '';

$meta_style  = ( isset( $instance['meta_style'] ) && $instance['meta_style'] ) ? ' uk-' . $instance['meta_style'] : '';
$meta_style .= ( isset( $instance['meta_color'] ) && $instance['meta_color'] ) ? ' uk-text-' . $instance['meta_color'] : '';
$meta_style .= ( isset( $instance['meta_text_transform'] ) && $instance['meta_text_transform'] ) ? ' uk-text-' . $instance['meta_text_transform'] : '';
$meta_style .= ( isset( $instance['meta_margin_top'] ) && $instance['meta_margin_top'] ) ? ' uk-margin-' . $instance['meta_margin_top'] . '-top' : ' uk-margin-top';

// Remove margin for heading element
if ( $meta_element != 'div' || ( $meta_style_cls && $meta_style_cls != 'text-meta' ) ) {
	$meta_style .= ' uk-margin-remove-bottom';
}

$meta_alignment = ( isset( $instance['meta_alignment'] ) && $instance['meta_alignment'] ) ? $instance['meta_alignment'] : '';

$attribs          = ( isset( $instance['link_new_tab'] ) && $instance['link_new_tab'] ) ? ' target="' . $instance['link_new_tab'] . '"' : '';
$btn_styles       = ( isset( $instance['link_button_style'] ) && $instance['link_button_style'] ) ? '' . $instance['link_button_style'] : '';
$link_button_size = ( isset( $instance['link_button_size'] ) && $instance['link_button_size'] ) ? ' ' . $instance['link_button_size'] : '';
$link_button_shape = (isset( $instance['link_button_shape'] ) && $instance['link_button_shape'] ) ? ' uk-border-' . $instance['link_button_shape'] : '';

$button_style_cls = '';
if ( empty( $btn_styles ) ) {
	$button_style_cls .= 'uk-button uk-button-default' . $link_button_size.$link_button_shape;
} elseif ( $btn_styles == 'link' || $btn_styles == 'link-muted' || $btn_styles == 'link-text' ) {
	$button_style_cls .= 'uk-' . $btn_styles;
} else {
	$button_style_cls .= 'uk-button uk-button-' . $btn_styles . $link_button_size.$link_button_shape;
}

$btn_margin_top   = ( isset( $instance['button_margin_top'] ) && $instance['button_margin_top'] ) ? 'uk-margin-' . $instance['button_margin_top'] . '-top' : 'uk-margin-top';
$all_button_title = ( isset( $instance['all_button_title'] ) && $instance['all_button_title'] ) ? $instance['all_button_title'] : 'Learn more';
$image_cover = ( isset( $instance['cover_image'] ) && $instance['cover_image'] ) ? 'data-uk-cover' : '';
$image_svg_inline     = ( isset( $instance['image_svg_inline'] ) && $instance['image_svg_inline'] ) ? $instance['image_svg_inline'] : false;
$image_svg_inline_cls = ( $image_svg_inline ) ? ' uk-svg' : '';

$image_svg_color = ( $image_svg_inline ) ? ( ( isset( $instance['image_svg_color'] ) && $instance['image_svg_color'] ) ? ' uk-text-' . $instance['image_svg_color'] : '' ) : false;

$font_weight = ( isset( $instance['font_weight'] ) && $instance['font_weight'] ) ? ' uk-text-' . $instance['font_weight'] : '';
$output      = '';

$output .= '<div class="ui-sliders-wrapper' . esc_attr($general_styles['container_cls']) . '"' . $general_styles['animation'] . '>';
$output .= '<div class="ui-sliders-wrapper-inner' . esc_attr($general_styles['content_cls']) . '">';

$output .= '<div class="ui-sliders"' . $attrs_slideshow . '>';

$output .= ( $slidenav_on_hover ) ? '<div class="uk-position-relative uk-visible-toggle" tabindex="-1">' : '<div class="uk-position-relative">';

$output .= '<ul class="uk-slider-items ' . $box_shadow . 'uk-grid uk-child-width-1-'.$large_desktop_columns.'@xl uk-child-width-1-'.$desktop_columns.'@l uk-child-width-1-'.$laptop_columns.'@m uk-child-width-1-'.$tablet_columns.'@s uk-child-width-1-'. $mobile_columns . $column_grid_gap.' "' . $height_cls . '>';
if ( isset( $instance['uisliders_items'] ) && count( (array) $instance['uisliders_items'] ) ) {
	foreach ( $instance['uisliders_items'] as $key => $value ) {
		$media_type = ( isset( $value['media_type'] ) && $value['media_type'] ) ? $value['media_type'] : '';
		$video      = ( isset( $value['video'] ) && $value['video'] ) ? $value['video'] : '';
		$video_fallback = ( isset( $value['video_fallback'] ) && isset( $value['video_fallback']['url'] ) && $value['video_fallback']['url'] ) ? $value['video_fallback']['url'] : '';

		$media_item = ( isset( $value['image'] ) && $value['image'] ) ? $value['image'] : '';
		$image_src  = isset( $media_item['url'] ) ? $media_item['url'] : '';

		$text_item_color = ( isset( $value['color_mode'] ) && $value['color_mode'] ) ? ' uk-' . $value['color_mode'] : '';
		$item_title      = ( isset( $value['title'] ) && $value['title'] ) ? $value['title'] : '';
		$item_meta       = ( isset( $value['meta'] ) && $value['meta'] ) ? $value['meta'] : '';
		$item_content    = ( isset( $value['content'] ) && $value['content'] ) ? $value['content'] : '';
		$image_panel     = ( isset( $value['image_panel'] ) && $value['image_panel'] ) ? 1 : 0;
		$button_shape    = ( isset( $value['button_shape'] ) && $value['button_shape'] ) ? ' uk-border-'. $value['button_shape'] : '';

		$media_background = ($media_type == 'video') ? ($video_fallback ? ' style="background: url(\''.$video_fallback.'\')" 50% 50%; background-size: cover;' : '') : '';

		$media_overlay    = ( $image_panel ) ? '<div class="ui-background-cover uk-position-cover elementor-repeater-item-'. $value['_id'] .'"></div>' : '';

		$image_alt      = ( isset( $value['image_alt'] ) && $value['image_alt'] ) ? $value['image_alt'] : '';
		$title_alt_text = ( isset( $value['title'] ) && $value['title'] ) ? $value['title'] : '';

		$image_alt_init = ( empty( $image_alt ) ) ? 'alt="' . esc_attr(str_replace( '"', '', $title_alt_text )) . '"' : 'alt="' . esc_attr(str_replace( '"', '', $image_alt )) . '"';

		$text_item_color_cls = '';

		if ( empty( $text_item_color ) ) {
			$text_item_color_cls .= $item_color;
		} else {
			$text_item_color_cls .= $text_item_color;
		}

		$button_link    =   $value['link'];
		$button_title   =   ( isset( $value['button_title'] ) && $value['button_title'] ) ? $value['button_title'] : '';


		$check_target = ( isset( $instance['link_new_tab'] ) && $instance['link_new_tab'] ) ? $instance['link_new_tab'] : '';

		$render_linkscroll = ( empty( $check_target ) && isset($button_link['url']) && strpos( $button_link['url'], '#' ) === 0 ) ? ' uk-scroll' : '';

		$output .= '<li class="el-item uk-margin-remove item-' . $key . '"' . $media_background . '>';
		$output .= '<div class="el-item-inner '.$img_tran_cl.' ">';
		$output .= ( $kenburns_transition ) ? '<div class="ui-media uk-position-cover uk-animation-kenburns uk-animation-reverse' . $kenburns_transition . '"' . $kenburns_duration . '>' : '';
        if($image_open=='light_box'){
            $output .='<a class="uk-position-z-index uk-transition-toggle uk-position-cover" href="' . esc_url($image_src) . '" data-elementor-open-lightbox="yes" data-elementor-lightbox-slideshow="'.$gallery_id.'"></a>';
        }
        if($image_cover){
            $output .='<div class="uk-cover-container tz-image-cover">';
        }
		if ($media_type == 'video') {
			$video_parse = parse_url( $video );
			switch ( $video_parse['host'] ) {
				case 'youtu.be':
					$id  = trim( $video_parse['path'], '/' );
					$src = '//www.youtube.com/embed/' . $id;
					$output .= '<iframe src="'.esc_url($src).'?iv_load_policy=3&amp;autoplay=1&amp;controls=0&amp;showinfo=0&amp;rel=0&amp;loop=1&amp;modestbranding=1&amp;wmode=transparent&amp;playsinline=1" width="1920" height="1080"  allowfullscreen data-uk-cover></iframe>';
					break;

				case 'www.youtube.com':
				case 'youtube.com':
					parse_str( $video_parse['query'], $query );
					$id  = $query['v'];
					$src = '//www.youtube.com/embed/' . $id;
					$output .= '<iframe src="'.esc_url($src).'?iv_load_policy=3&amp;autoplay=1&amp;controls=0&amp;showinfo=0&amp;rel=0&amp;loop=1&amp;modestbranding=1&amp;wmode=transparent&amp;playsinline=1" width="1920" height="1080" allowfullscreen data-uk-cover></iframe>';
					break;

				case 'vimeo.com':
				case 'www.vimeo.com':
					$id  = trim( $video_parse['path'], '/' );
					$src = '//player.vimeo.com/video/' . $id;
					$output .= '<iframe src="'.esc_url($src).'?autoplay=1&amp;loop=1&amp;muted=1&amp;autopause=0&amp;title=0&amp;byline=0&amp;portrait=0&amp;controls=0" width="1920" height="1080"  allowfullscreen data-uk-cover></iframe>';
					break;
				default :
					$output .= '<video src="'.esc_url($video).'" autoplay loop muted playsinline data-uk-cover></video>';
					break;
			}
		} else {
			$output .= '<img class="ui-image" src="' . esc_url($image_src) . '" ' . $image_alt_init .' '. $image_cover .'>';
			$output .= $ripple_html;
		}
        $output .='<div class="uk-overlay-default uk-transition-toggle uk-position-cover"></div>';
        if($image_cover){
            $output .='</div>';
        }

		$output .= ( $kenburns_transition ) ? '</div>' : '';

		$output .= $media_overlay;

		$output .= '<div class="ui-content uk-position-cover  uk-flex' . $overlay_positions . $overlay_container_cls . $overlay_container_padding . $overlay_margin_cls . '">';

		$output .= '<div class="' . $overlay_styles_int . $overlay_pos_int . $overlay_width . $overlay_transition . $text_item_color_cls . $overlay_styles . $overlay_padding . ( ! empty( $overlay_transition ) ? $overlay_transition : '' ) . ' "' . ( empty( $overlay_transition ) ? $overlay_parallax_cls : '' ) . '>';

		if ( $meta_alignment == 'top' && $item_meta ) {
			$output .= '<' . $meta_element . ' class="ui-meta' . $meta_style . '"' . $meta_transition . '>';
			$output .= $item_meta;
			$output .= '</' . $meta_element . '>';
		}

		if ( $item_title ) {
			$output .= '<' . $heading_selector . ' class="ui-title uk-margin-remove-bottom' . $heading_style . $title_decoration . $font_weight . '"' . $title_transition . '>';
            $output .= '<a class="" href="' . $button_link['url'] . '"' . ( $attribs ) . '>';
			$output .= ( $title_decoration == ' uk-heading-line' ) ? '<span>' : '';
			$output .= $item_title;
			$output .= ( $title_decoration == ' uk-heading-line' ) ? '</span>' : '';
			$output .= '</a>';
			$output .= '</' . $heading_selector . '>';
		}

		if ( empty( $meta_alignment ) && $item_meta ) {
			$output .= '<' . $meta_element . ' class="ui-meta' . $meta_style . '"' . $meta_transition . '>';
			$output .= $item_meta;
			$output .= '</' . $meta_element . '>';
		}

		if ( $item_content ) {
			$output .= '<div class="ui-content uk-panel' . $content_style . '"' . $content_transition . '>';
			$output .= $item_content;
			$output .= '</div>';
		}

		if ( $meta_alignment == 'content' && $item_meta ) {
			$output .= '<' . $meta_element . ' class="ui-meta' . $meta_style . '"' . $meta_transition . '>';
			$output .= $item_meta;
			$output .= '</' . $meta_element . '>';
		}

		if ( ! empty( $button_title ) && isset($button_link['url']) && $button_link['url']) {
			$button_attribs    =   \UIPro_Elementor_Helper::get_link_attribs($button_link);
			$output .= '<div class="ui-buttons"><div class="elementor-repeater-item-'. $value['_id'] .' ' . $btn_margin_top . '">';
			$output .= '<a class="' . $button_style_cls . $button_shape . '" href="' . $button_link['url'] . '"' . ( $button_attribs ? $button_attribs : $attribs ) . $render_linkscroll . $button_transition . '>' . $button_title . '</a>';
			$output .= '</div></div>';
		}

		$output .= '</div>';

		$output .= '</div>';
		$output .= '</div>';

		$output .= '</li>';
	}
}

$output .= '</ul>';
if($navigation_group){
    $output .= '<div class="ui-navigation-group">';
}

if ( $slidenav_position == 'default' ) {
	$output .= ( $slidenav_on_hover ) ? '<div class="uk-hidden-hover uk-hidden-touch' . $slidenav_breakpoint_cls . $item_color . '">' : '<div class="tz-sidenav' . $slidenav_breakpoint_cls . $item_color . '">';
	$output .= '<a class="ui-slidenav ' . $slidenav_margin . $larger_style_init . ' uk-position-center-left" href="#" data-uk-slidenav-previous data-uk-slider-item="previous"></a>';
	$output .= '<a class="ui-slidenav ' . $slidenav_margin . $larger_style_init . ' uk-position-center-right" href="#" data-uk-slidenav-next data-uk-slider-item="next"></a>';
	$output .= '</div> ';
} elseif ( $slidenav_position == 'outside' ) {
	$output .= ( $slidenav_on_hover ) ? '<div class="ui-sidenav-outside uk-hidden-hover uk-hidden-touch' . $slidenav_breakpoint_cls . $slidenav_outside_color . '">' : '<div class="ui-sidenav-outside' . $slidenav_breakpoint_cls . $slidenav_outside_color . '">';
	$output .= '<a class="ui-slidenav ' . $slidenav_margin . $larger_style_init . ' uk-position-center-left-out" href="#" data-uk-slidenav-previous data-uk-slider-item="previous" data-uk-toggle="cls: uk-position-center-left-out uk-position-center-left; mode: media; media:' . $slidenav_outside_breakpoint . '"></a>';
	$output .= '<a class="ui-slidenav ' . $slidenav_margin . $larger_style_init . ' uk-position-center-right-out" href="#" data-uk-slidenav-next data-uk-slider-item="next" data-uk-toggle="cls: uk-position-center-right-out uk-position-center-right; mode: media; media:' . $slidenav_outside_breakpoint . '"></a>';
	$output .= '</div> ';
} elseif ( $slidenav_position != '' ) {
	$output .= ( $slidenav_on_hover ) ? '<div class="uk-slidenav-container uk-hidden-hover uk-hidden-touch' . $slidenav_position_cls . $slidenav_margin . $slidenav_breakpoint_cls . $item_color . '">' : '<div class="uk-slidenav-container' . $slidenav_position_cls . $slidenav_margin . $slidenav_breakpoint_cls . $item_color . '">';
	$output .= '<a class="ui-slidenav' . $larger_style_init . '" href="#" data-uk-slidenav-previous data-uk-slider-item="previous"></a>';
	$output .= '<a class="ui-slidenav' . $larger_style_init . '" href="#" data-uk-slidenav-next data-uk-slider-item="next"></a>';
	$output .= '</div>';
}

if ( $navigation_below ) {
	$output .= '</div>';
}

if ( $navigation_control == 'dotnav' ) {
	if ( $navigation_below ) {
		$output .= ( $navigation_below_color_cls ) ? '<div class="ui-nav-control' . $navigation_below_margin_cls . $navigation_breakpoint_cls . $navigation_below_color_cls . '">' : '';
		$output .= ( $navigation_below_color_cls ) ? '<ul class="uk-slideshow-nav uk-dotnav' . $navigation_below_cls . '"></ul>' : '<ul class="uk-slideshow-nav uk-dotnav' . $navigation_below_cls . $navigation_below_margin_cls . $navigation_breakpoint_cls . '"></ul>';
		$output .= ( $navigation_below_color_cls ) ? '</div>' : '';
	} else {
		$output .= '<div class="ui-nav-control' . $navigation_margin . $navigation . $navigation_breakpoint_cls . $item_color . '"> ';
		$output .= '<ul class="uk-slideshow-nav uk-dotnav' . $navigation_vertical . $navigation_cls . '"></ul>';
		$output .= '</div> ';
	}
} elseif ( $navigation_control == 'thumbnav' ) {
	if ( $navigation_below ) {
		$output .= ( $navigation_below_color_cls ) ? '<div class="ui-nav-control' . $navigation_below_margin_cls . $navigation_breakpoint_cls . $navigation_below_color_cls . '">' : '';
		$output .= ( $navigation_below_color_cls ) ? '<ul class="uk-thumbnav' . $thumbnav_wrap_cls . '">' : '<ul class="uk-thumbnav' . $thumbnav_wrap_cls . $navigation_below_cls . $navigation_below_margin_cls . $navigation_breakpoint_cls . '">';
	} else {
		$output .= '<div class="ui-nav-control' . $navigation_margin . $navigation . $navigation_breakpoint_cls . '"> ';
		$output .= '<ul class="uk-thumbnav' . $navigation_vertical_thumb . $thumbnav_wrap_cls . $navigation_cls . '">';
	}

	if ( isset( $instance['uisliders_items'] ) && count( (array) $instance['uisliders_items'] ) ) {
		foreach ( $instance['uisliders_items'] as $key => $value ) {
			$media_item = ( isset( $value['image'] ) && $value['image'] ) ? $value['image'] : '';
			$image_src  = isset( $media_item['url'] ) ? $media_item['url'] : '';

			$nav_image     = ( isset( $value['thumbnail'] ) && $value['thumbnail'] ) ? $value['thumbnail'] : '';
			if($nav_image !=''){
                $nav_image_src = isset( $nav_image['url'] ) ? $nav_image['url'] : '';
            }else{
                $nav_image_src = isset( $media_item['url'] ) ? $media_item['url'] : '';
            }


			$image_alt      = ( isset( $value['image_alt'] ) && $value['image_alt'] ) ? $value['image_alt'] : '';
			$title_alt_text = ( isset( $value['title'] ) && $value['title'] ) ? $value['title'] : '';
			$image_alt_init = ( empty( $image_alt ) ) ? 'alt="' . str_replace( '"', '', $title_alt_text ) . '"' : 'alt="' . str_replace( '"', '', $image_alt ) . '"';

			$output .= '<li uk-slideshow-item="' . $key . '">';
			if ( $nav_image_src ) {
				$output .= '<a href="#"><img class="img-thumb' . $image_svg_color . '" src="' . $nav_image_src . '" ' . $thumbnail_width_cls . $thumbnail_height_cls . $image_alt . $image_svg_inline_cls . '></a>';
			} else {
				$output .= '<a href="#"><img class="img-thumb' . $image_svg_color . '" src="' . $image_src . '" ' . $thumbnail_width_cls . $thumbnail_height_cls . $image_alt . $image_svg_inline_cls . '></a>';
			}

			$output .= '</li>';
		}
	}
	if ( $navigation_below ) {
		$output .= '</ul>';
		$output .= ( $navigation_below_color_cls ) ? '</div>' : '';
	} else {
		$output .= '</ul>';
		$output .= '</div> ';
	}
} elseif ( $navigation_control == 'title' ) {
	if ( isset( $instance['uisliders_items'] ) && count( (array) $instance['uisliders_items'] ) ) {
		$output .= '<div class="ui-nav-control ui-nav-title uk-position-bottom-center' . $navigation_margin . $navigation_breakpoint_cls . '"> ';
		$output .= '<div class="'.$overlay_container_cls.'"><ul class="ui-nav-title-items uk-light uk-child-width-1-'.count( (array) $instance['uisliders_items'] ).' uk-flex-center uk-thumbnav">';
		foreach ( $instance['uisliders_items'] as $key => $value ) {
			$image_title    = ( isset( $value['title'] ) && $value['title'] ) ? $value['title'] : '';
			$output .= '<li>';
			$output .= '<a data-uk-slideshow-item="' . $key . '" href="#" class="uk-padding-small"><div class="uk-grid-small" data-uk-grid><h2 class="ui-nav-title-num uk-width-auto@l uk-width-1-1">'.($key+1).'.</h2><'.$navigation_title_selector.' class="uk-width-expand">'.$image_title.'</'.$navigation_title_selector.'></div></a>';
			$output .= '</li>';
		}
		$output .= '</ul></div>';
		$output .= '</div> ';
	}
}
if($navigation_group){
    $output .= '</div>';
}
if ( ! $navigation_below ) {
	$output .= '</div>';
}
$output .= '</div>';
$output .= '</div>';
$output .= '</div>';
echo ent2ncr($output);