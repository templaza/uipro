<?php
defined( 'ABSPATH' ) || exit;
$_is_elementor  = (isset($args['page_builder']) && $args['page_builder'] == 'elementor')?true:false;

$pagination_type    = (isset($instance['pagination_type']) && $instance['pagination_type']) ? $instance['pagination_type'] : 'none';
$masonry            = (isset($instance['masonry']) && $instance['masonry']) ? intval($instance['masonry']) : 0;

//Get gallery
$gallery            = ( isset( $instance['gallery'] ) && $instance['gallery'] ) ? $instance['gallery'] : array();
$limit              = ( isset( $instance['limit'] ) && $instance['limit'] ) ? $instance['limit'] : 4;
$max_num_pages      = intdiv(count($gallery), $limit);
if ( count($gallery) % $limit ) {
    $max_num_pages++;
}
if ($pagination_type == 'default' || $pagination_type == 'ajax') {
    $paged          = max( 1, get_query_var('paged') );
    $gallery        = array_slice($gallery, ($paged-1)*$limit, $limit);
}

//responsive width
$large_desktop_columns    = ( isset( $instance['large_desktop_columns'] ) && $instance['large_desktop_columns'] ) ? $instance['large_desktop_columns'] : '4';
$desktop_columns    = ( isset( $instance['desktop_columns'] ) && $instance['desktop_columns'] ) ? $instance['desktop_columns'] : '4';
$laptop_columns     = ( isset( $instance['laptop_columns'] ) && $instance['laptop_columns'] ) ? $instance['laptop_columns'] : '3';
$tablet_columns     = ( isset( $instance['tablet_columns'] ) && $instance['tablet_columns'] ) ? $instance['tablet_columns'] : '2';
$mobile_columns     = ( isset( $instance['mobile_columns'] ) && $instance['mobile_columns'] ) ? $instance['mobile_columns'] : '1';
$column_grid_gap    = ( isset( $instance['column_grid_gap'] ) && $instance['column_grid_gap'] ) ? ' uk-grid-'. $instance['column_grid_gap'] : '';

//Slider
$use_slider 	    = (isset($instance['use_slider']) && $instance['use_slider']) ? intval($instance['use_slider']) : 0;
$enable_navigation	= (isset($instance['enable_navigation']) && $instance['enable_navigation']) ? intval($instance['enable_navigation']) : 0;
$enable_dotnav	    = (isset($instance['enable_dotnav']) && $instance['enable_dotnav']) ? intval($instance['enable_dotnav']) : 0;
$center_slider	    = (isset($instance['center_slider']) && $instance['center_slider']) ? intval($instance['center_slider']) : 0;
$navigation_position= (isset($instance['navigation_position']) && $instance['navigation_position']) ? $instance['navigation_position'] : '';

//Filter
$use_filter 	    = (isset($instance['use_filter']) && $instance['use_filter']) ? intval($instance['use_filter']) : 0;
$filter_position 	= (isset($instance['filter_position']) && $instance['filter_position']) ? $instance['filter_position'] : 'top';
$filter_container	= (isset($instance['filter_container']) && $instance['filter_container']) ? ' uk-container-'. $instance['filter_container'] : '';
$filter_grid_gap	= (isset($instance['filter_grid_gap']) && $instance['filter_grid_gap']) ? ' uk-grid-'. $instance['filter_grid_gap'] : '';
$display_filter_header 	= (isset($instance['display_filter_header']) && $instance['display_filter_header']) ? intval($instance['display_filter_header']) : 0;
$filter_animate 	= (isset($instance['filter_animate']) && $instance['filter_animate']) ? $instance['filter_animate'] : 'slide';
$filter_margin 	    = (isset($instance['filter_margin']) && $instance['filter_margin']) ? ' uk-margin-'. $instance['filter_margin'] : ' uk-margin';
$filter_visibility 	= (isset($instance['filter_visibility']) && $instance['filter_visibility']) ? $instance['filter_visibility'] : '';

$flex_alignment          = ( isset( $instance['filter_text_alignment'] ) && $instance['filter_text_alignment'] ) ? ' uk-flex-' . $instance['filter_text_alignment'] : '';
$flex_breakpoint         = ( $flex_alignment ) ? ( ( isset( $instance['filter_text_alignment_breakpoint'] ) && $instance['filter_text_alignment_breakpoint'] ) ? '@' . $instance['filter_text_alignment_breakpoint'] : '' ) : '';
$flex_alignment_fallback = ( $flex_alignment && $flex_breakpoint ) ? ( ( isset( $instance['filter_text_alignment_fallback'] ) && $instance['filter_text_alignment_fallback'] ) ? ' uk-flex-' . $instance['filter_text_alignment_fallback'] : '' ) : '';
$flex_alignment          .=$flex_breakpoint. $flex_alignment_fallback;

$text_alignment          = ( isset( $instance['filter_text_alignment'] ) && $instance['filter_text_alignment'] ) ? ' uk-text-' . $instance['filter_text_alignment'] : '';
$text_breakpoint         = ( $text_alignment ) ? ( ( isset( $instance['filter_text_alignment_breakpoint'] ) && $instance['filter_text_alignment_breakpoint'] ) ? '@' . $instance['filter_text_alignment_breakpoint'] : '' ) : '';
$text_alignment_fallback = ( $text_alignment && $text_breakpoint ) ? ( ( isset( $instance['filter_text_alignment_fallback'] ) && $instance['filter_text_alignment_fallback'] ) ? ' uk-text-' . $instance['filter_text_alignment_fallback'] : '' ) : '';
$text_alignment          .=$text_breakpoint. $text_alignment_fallback;

$filter_align           =   $flex_alignment.$text_alignment;

$block_align            = ( isset( $instance['filter_block_align'] ) && $instance['filter_block_align'] ) ? $instance['filter_block_align'] : '';
$block_align_breakpoint = ( isset( $instance['filter_block_align_breakpoint'] ) && $instance['filter_block_align_breakpoint'] ) ? '@' . $instance['filter_block_align_breakpoint'] : '';
$block_align_fallback   = ( isset( $instance['filter_block_align_fallback'] ) && $instance['filter_block_align_fallback'] ) ? $instance['filter_block_align_fallback'] : '';

// Block Alignment CLS.
$filter_block_cls[] = '';

if ( empty( $block_align ) ) {
	if ( ! empty( $block_align_breakpoint ) && ! empty( $block_align_fallback ) ) {
		$filter_block_cls[] = ' uk-margin-auto-right' . $block_align_breakpoint;
		$filter_block_cls[] = 'uk-margin-remove-left' . $block_align_breakpoint . ( $block_align_fallback == 'center' ? ' uk-margin-auto' : ' uk-margin-auto-left' );
	}
}

if ( $block_align == 'center' ) {
	$filter_block_cls[] = ' uk-margin-auto' . $block_align_breakpoint;
	if ( ! empty( $block_align_breakpoint ) && ! empty( $block_align_fallback ) ) {
		$filter_block_cls[] = 'uk-margin-auto' . ( $block_align_fallback == 'right' ? '-left' : '' );
	}
}

if ( $block_align == 'right' ) {
	$filter_block_cls[] = ' uk-margin-auto-left' . $block_align_breakpoint;
	if ( ! empty( $block_align_breakpoint ) && ! empty( $block_align_fallback ) ) {
		$filter_block_cls[] = $block_align_fallback == 'center' ? 'uk-margin-remove-right' . $block_align_breakpoint . ' uk-margin-auto' : 'uk-margin-auto-left';
	}
}

$filter_block_cls = implode( ' ', array_filter( $filter_block_cls ) );

$general_styles     =   \UIPro_Elementor_Helper::get_general_styles($instance);

$output         =   '';

if (count($gallery)) {
	$output     .=   '<div class="ui-gallery'. esc_attr($general_styles['container_cls']) .'"' . $general_styles['animation'] . '>';
	$output     .=   '<div class="ui-gallery-inner' . esc_attr( ( $filter_position != 'top' ? $filter_grid_gap : '' ) . $general_styles['content_cls']) . '"'. ( $use_filter ? ' data-uk-filter="target: .ui-gallery-items; animation: '.esc_attr($filter_animate).'"' : '' ) . ( $filter_position != 'top' ? ' data-uk-grid' : '' ) .'>';
	if ($use_filter) {
		$output .=  '<div class="ui-gallery-filter'. $filter_container. $filter_block_cls . $filter_margin . $filter_align . ($filter_visibility ? ' uk-visible'. $filter_visibility : ''). ($filter_position == 'right' ? ' uk-flex-last' : '') .'">';
		$tag_arg    =   array();
        foreach ($gallery as $item) {
            $tags = get_post_meta( $item['id'], '_wp_attachment_image_alt', true );
            if ($tags) {
                $tags   =   explode(',', $tags);
                foreach ($tags as $tag) {
                    if (trim($tag)) {
                        $tag_arg[sanitize_title(trim($tag))]    =   trim($tag);
                    }
                }
            }
        }

		$tags_content   =   '<ul class="'.($filter_position != 'top' ? 'uk-nav uk-nav-default' : 'uk-subnav').$filter_align.'"'.($filter_position == 'top' ? ' data-uk-margin' : '').'>';
		if ($display_filter_header) {
			$tags_content   =   '<h5>'.__('Topic', 'uipro').'</h5>'. $tags_content;
		}
		if (count($tag_arg)) {
			$tags_content .=  '<li class="uk-active" data-uk-filter-control><a class="uk-button-text" href="#">'.esc_html__('Show All', 'uipro').'</a></li>';
			foreach ($tag_arg as $tag_key => $tag_name) {
				$tags_content .=  '<li data-uk-filter-control="[data-tag*='.$tag_key.']"><a class="uk-button-text" href="#">'.esc_attr($tag_name).'</a></li>';
			}
		}
		$tags_content   .=   '</ul>';

		if ( $tags_content ) {
			$output     .=   $tags_content;
		}
		$output .=  '</div>';
	}
	if ($use_slider) {
		$output .= '<div data-uk-slider="'.($center_slider ? 'center: true' : '').'">';
		$output .= '<div class="uk-position-relative">';
		$output .= '<div class="uk-slider-container">';
	}
	$output     .=  '<div class="'.( $filter_position != 'top' ? 'uk-width-expand'.$filter_visibility : '' ).'">';
	$output     .=  '<div class="ui-gallery-items uk-child-width-1-'.$large_desktop_columns.'@xl uk-child-width-1-'.$desktop_columns.'@l uk-child-width-1-'.$laptop_columns.'@m uk-child-width-1-'.$tablet_columns.'@s uk-child-width-1-'. $mobile_columns . $column_grid_gap . ($use_slider ? ' uk-slider-items': '') .'" data-uk-grid="'.($masonry ? 'masonry:true;' : '').'">';
	foreach ($gallery as $item) {
		include plugin_dir_path(__FILE__).'post_item.php';
	}
	$output     .=  '</div>';
	//end grid

    // Pagination section
    switch ($pagination_type) {
        case 'ajax':
            $output .=  '<div class="ui-gallery-loading uk-text-center uk-margin-large-top">';
            $output .=  '<div data-uk-spinner class="uk-margin-right"></div>';
            $output .=  '<span class="loading">'.esc_html__('Loading more posts...','uipro').'</span>';
            $output .=  '</div>';
            break;
        case 'default':
            $big = 999999999; // need an unlikely integer
            $output .= '<div class="ui-gallery-pagination uk-text-center uk-margin-large-top">';
            $output .= paginate_links( array(
                'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                'format' => '?paged=%#%',
                'current' => max( 1, get_query_var('paged') ),
                'total' => $max_num_pages,
                'prev_text' => '<span data-uk-icon="arrow-left"></span>',
                'next_text' => '<span data-uk-icon="arrow-right"></span>',
            ) );
            $output .=  '</div>';
            break;
    }

	$output     .=  '</div>';
	if ($use_slider) {
		// End Slider Container
		$output  .= '</div>';
		if ($enable_navigation) {
			// Nav
			$output .= '<div class="'.($navigation_position == 'inside' ? '' : 'uk-hidden@l ').'uk-light"><a class="uk-position-center-left uk-position-small" href="#" data-uk-slidenav-previous data-uk-slider-item="previous"></a><a class="uk-position-center-right uk-position-small" href="#" data-uk-slidenav-next data-uk-slider-item="next"></a></div>';
			$output .= $navigation_position == 'inside' ? '' : '<div class="uk-visible@l"><a class="uk-position-center-left-out uk-position-small" href="#" data-uk-slidenav-previous data-uk-slider-item="previous"></a><a class="uk-position-center-right-out uk-position-small" href="#" data-uk-slidenav-next data-uk-slider-item="next"></a></div>';
		}
		$output  .= '</div>';
		if ($enable_dotnav) {
			// Dot nav
			$output .= '<ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>';
		}
		// End Slider
		$output  .= '</div>';
	}

	$output     .=  '</div>';
	if ($pagination_type == 'ajax') {
		$output     .=  '<input type="hidden" class="ui-current-page" value="'.(get_query_var( 'paged' ) ? get_query_var('paged') : 1).'" />';
		$output     .=  '<input type="hidden" class="ui-gallery-settings" value="'.base64_encode(json_encode($instance)).'" />';
	}

	$output     .=  '</div>';

	echo ent2ncr($output);
}