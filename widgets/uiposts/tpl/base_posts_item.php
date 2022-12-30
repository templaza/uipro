<?php
defined( 'ABSPATH' ) || exit;

$color_mode         = (isset($instance[$pre_val.'color_mode'] ) && $instance[$pre_val.'color_mode'] ) ? ' uk-'. $instance[$pre_val.'color_mode'] : '';
$pagination_type    = (isset($instance['pagination_type']) && $instance['pagination_type']) ? $instance['pagination_type'] : 'none';
$masonry            = (isset($instance[$pre_val.'masonry']) && $instance[$pre_val.'masonry']) ? intval($instance[$pre_val.'masonry']) : 0;

$card_divider       = (isset($instance[$pre_val.'card_divider'])) ? filter_var($instance[$pre_val.'card_divider'], FILTER_VALIDATE_BOOLEAN) : false;

//Get posts
//$limit          = ( isset( $instance['limit'] ) && $instance['limit'] ) ? $instance['limit'] : 4;
//$lead_limit     = ( isset( $instance[$pre_val.'lead_limit'] ) && $instance[$pre_val.'lead_limit'] ) ? $instance[$pre_val.'lead_limit'] : 0;
$resource       = ( isset( $instance['resource'] ) && $instance['resource'] ) ? $instance['resource'] : 'post';
//$ordering       = ( isset( $instance['ordering'] ) && $instance['ordering'] ) ? $instance['ordering'] : 'latest';
//$category   = ( isset( $instance[$resource.'_category'] ) && $instance[$resource.'_category'] ) ? $instance[$resource.'_category'] : array('0');

//responsive width
$large_desktop_columns    = ( isset( $instance[$pre_val.'large_desktop_columns'] ) && $instance[$pre_val.'large_desktop_columns'] ) ? $instance[$pre_val.'large_desktop_columns'] : '4';
$desktop_columns    = ( isset( $instance[$pre_val.'desktop_columns'] ) && $instance[$pre_val.'desktop_columns'] ) ? $instance[$pre_val.'desktop_columns'] : '4';
$laptop_columns     = ( isset( $instance[$pre_val.'laptop_columns'] ) && $instance[$pre_val.'laptop_columns'] ) ? $instance[$pre_val.'laptop_columns'] : '3';
$tablet_columns     = ( isset( $instance[$pre_val.'tablet_columns'] ) && $instance[$pre_val.'tablet_columns'] ) ? $instance[$pre_val.'tablet_columns'] : '2';
$mobile_columns     = ( isset( $instance[$pre_val.'mobile_columns'] ) && $instance[$pre_val.'mobile_columns'] ) ? $instance[$pre_val.'mobile_columns'] : '1';
$column_grid_gap    = ( isset( $instance[$pre_val.'column_grid_gap'] ) && $instance[$pre_val.'column_grid_gap'] ) ? ' uk-grid-'. $instance[$pre_val.'column_grid_gap'] : '';

//Slider
$use_slider 	    = (isset($instance[$pre_val.'use_slider']) && $instance[$pre_val.'use_slider']) ? intval($instance[$pre_val.'use_slider']) : 0;
$enable_navigation	= (isset($instance[$pre_val.'enable_navigation']) && $instance[$pre_val.'enable_navigation']) ? intval($instance[$pre_val.'enable_navigation']) : 0;
$enable_dotnav	    = (isset($instance[$pre_val.'enable_dotnav']) && $instance[$pre_val.'enable_dotnav']) ? intval($instance[$pre_val.'enable_dotnav']) : 0;
$center_slider	    = (isset($instance[$pre_val.'center_slider']) && $instance[$pre_val.'center_slider']) ? intval($instance[$pre_val.'center_slider']) : 0;
$navigation_position= (isset($instance[$pre_val.'navigation_position']) && $instance[$pre_val.'navigation_position']) ? $instance[$pre_val.'navigation_position'] : '';

//Filter
$use_filter 	    = (isset($instance[$pre_val.'use_filter']) && $instance[$pre_val.'use_filter']) ? intval($instance[$pre_val.'use_filter']) : 0;
$filter_type 	    = (isset($instance[$pre_val.'filter_type']) && $instance[$pre_val.'filter_type']) ? $instance[$pre_val.'filter_type'] : 'tag';
$filter_position 	= (isset($instance[$pre_val.'filter_position']) && $instance[$pre_val.'filter_position']) ? $instance[$pre_val.'filter_position'] : 'top';
$filter_container	= (isset($instance[$pre_val.'filter_container']) && $instance[$pre_val.'filter_container']) ? ' uk-container-'. $instance[$pre_val.'filter_container'] : '';
$filter_grid_gap	= (isset($instance[$pre_val.'filter_grid_gap']) && $instance[$pre_val.'filter_grid_gap']) ? ' uk-grid-'. $instance[$pre_val.'filter_grid_gap'] : '';
$use_filter_sort 	= (isset($instance[$pre_val.'use_filter_sort']) && $instance[$pre_val.'use_filter_sort']) ? intval($instance[$pre_val.'use_filter_sort']) : 0;
$display_filter_header 	= (isset($instance[$pre_val.'display_filter_header']) && $instance[$pre_val.'display_filter_header']) ? intval($instance[$pre_val.'display_filter_header']) : 0;
$filter_animate 	= (isset($instance[$pre_val.'filter_animate']) && $instance[$pre_val.'filter_animate']) ? $instance[$pre_val.'filter_animate'] : 'slide';
$filter_margin 	    = (isset($instance[$pre_val.'filter_margin']) && $instance[$pre_val.'filter_margin']) ? ' uk-margin-'. $instance[$pre_val.'filter_margin'] : ' uk-margin';
$filter_visibility 	= (isset($instance[$pre_val.'filter_visibility']) && $instance[$pre_val.'filter_visibility']) ? $instance[$pre_val.'filter_visibility'] : '';

$flex_alignment          = ( isset( $instance[$pre_val.'filter_text_alignment'] ) && $instance[$pre_val.'filter_text_alignment'] ) ? ' uk-flex-' . $instance[$pre_val.'filter_text_alignment'] : '';
$flex_breakpoint         = ( $flex_alignment ) ? ( ( isset( $instance[$pre_val.'filter_text_alignment_breakpoint'] ) && $instance[$pre_val.'filter_text_alignment_breakpoint'] ) ? '@' . $instance[$pre_val.'filter_text_alignment_breakpoint'] : '' ) : '';
$flex_alignment_fallback = ( $flex_alignment && $flex_breakpoint ) ? ( ( isset( $instance[$pre_val.'filter_text_alignment_fallback'] ) && $instance[$pre_val.'filter_text_alignment_fallback'] ) ? ' uk-flex-' . $instance[$pre_val.'filter_text_alignment_fallback'] : '' ) : '';
$flex_alignment          .=$flex_breakpoint. $flex_alignment_fallback;

$text_alignment          = ( isset( $instance[$pre_val.'filter_text_alignment'] ) && $instance[$pre_val.'filter_text_alignment'] ) ? ' uk-text-' . $instance[$pre_val.'filter_text_alignment'] : '';
$text_breakpoint         = ( $text_alignment ) ? ( ( isset( $instance[$pre_val.'filter_text_alignment_breakpoint'] ) && $instance[$pre_val.'filter_text_alignment_breakpoint'] ) ? '@' . $instance[$pre_val.'filter_text_alignment_breakpoint'] : '' ) : '';
$text_alignment_fallback = ( $text_alignment && $text_breakpoint ) ? ( ( isset( $instance[$pre_val.'filter_text_alignment_fallback'] ) && $instance[$pre_val.'filter_text_alignment_fallback'] ) ? ' uk-text-' . $instance[$pre_val.'filter_text_alignment_fallback'] : '' ) : '';
$text_alignment          .=$text_breakpoint. $text_alignment_fallback;

$filter_align           =   $flex_alignment.$text_alignment;

$block_align            = ( isset( $instance[$pre_val.'filter_block_align'] ) && $instance[$pre_val.'filter_block_align'] ) ? $instance[$pre_val.'filter_block_align'] : '';
$block_align_breakpoint = ( isset( $instance[$pre_val.'filter_block_align_breakpoint'] ) && $instance[$pre_val.'filter_block_align_breakpoint'] ) ? '@' . $instance[$pre_val.'filter_block_align_breakpoint'] : '';
$block_align_fallback   = ( isset( $instance[$pre_val.'filter_block_align_fallback'] ) && $instance[$pre_val.'filter_block_align_fallback'] ) ? $instance[$pre_val.'filter_block_align_fallback'] : '';
$uipost_layout   = ( isset( $instance['uipost_layout'] ) && $instance['uipost_layout'] ) ? $instance['uipost_layout'] : '';

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

if (count($posts)) {
    $output     .=   '<div class="ui-posts-items-outer' . esc_attr($color_mode . ( $filter_position != 'top' ? $filter_grid_gap : '' ) . $general_styles['content_cls']) . '"'. ( $use_filter ? ' data-uk-filter="target: .ui-post-items; animation: '.esc_attr($filter_animate).'"' : '' ) . ( $filter_position != 'top' ? ' data-uk-grid' : '' ) .'>';
    if ($use_filter) {
        $output .=  '<div class="ui-post-filter'. $filter_container. $filter_block_cls . $filter_margin . $filter_align . ($filter_visibility ? ' uk-visible'. $filter_visibility : ''). ($filter_position == 'right' ? ' uk-flex-last' : '') .'">';
        $tag_arg    =   array();
        $cat_arg    =   array();
        if ($pagination_type == 'ajax') {
            $tags   =   get_terms( array ('taxonomy' => $resource. '_tag') );
            if ($tags) {
                foreach ( $tags as $term ) {
                    $tag_arg[$term->slug]	=   $term->name;
                }
            }
            $cat_portfolio = $resource == 'post' ? get_terms( array ('taxonomy' => 'category') ) : get_terms( array ('taxonomy' => $resource.'-category') );
            if ($cat_portfolio && count($cat_portfolio)) {
                foreach ( $cat_portfolio as $term ) {
                    $cat_arg[$term->slug]   =   $term->name;
                }
            }
        } else {
            foreach ($posts as $item) {
                $tags = wp_get_post_terms( $item->ID , $resource. '_tag' );
                if ($tags) {
                    foreach ( $tags as $term ) {
                        $tag_arg[$term->slug]	=   $term->name;
                    }
                }
                $cat_portfolio = $resource == 'post' ? wp_get_post_terms( $item->ID , 'category' ) : wp_get_post_terms( $item->ID , $resource.'-category' );
                if ($cat_portfolio && count($cat_portfolio)) {
                    foreach ( $cat_portfolio as $term ) {
                        $cat_arg[$term->slug]   =   $term->name;
                    }
                }
            }
        }

        $tags_content   =   $cats_content   =   '<ul class="'.($filter_position != 'top' ? 'uk-nav uk-nav-default' : 'uk-subnav').$filter_align.'"'.($filter_position == 'top' ? ' data-uk-margin' : '').'>';
        if ($display_filter_header) {
            $tags_content   =   '<h5>'.__('Topic', 'uipro').'</h5>'. $tags_content;
            $cats_content   =   '<h5>'.__('Category', 'uipro').'</h5>'. $cats_content;
        }
        if (count($tag_arg)) {
            $tags_content .=  '<li class="uk-active" data-uk-filter-control><a class="uk-button-text" href="#">'.esc_html__('Show All', 'uipro').'</a></li>';
            foreach ($tag_arg as $tag_key => $tag_name) {
                $tags_content .=  '<li data-uk-filter-control="[data-tag*='.$tag_key.']"><a class="uk-button-text" href="#">'.esc_attr($tag_name).'</a></li>';
            }
        }
        if (count($cat_arg)) {
            $cats_content .=  '<li class="uk-active" data-uk-filter-control><a class="uk-button-text" href="#">'.esc_html__('Show All', 'uipro').'</a></li>';
            foreach ($cat_arg as $cat_key => $cat_name) {
                $cats_content .=  '<li data-uk-filter-control="[data-cat*='.$cat_key.']"><a class="uk-button-text" href="#">'.esc_attr($cat_name).'</a></li>';
            }
        }
        $tags_content   .=   '</ul>';
        $cats_content   .=   '</ul>';

        if ( ( is_array($filter_type) && in_array('tag', $filter_type) ) || (is_string($filter_type) && $filter_type == 'tag') ) {
            $output     .=   $tags_content;
        }
        if ( ( is_array($filter_type) && in_array('category', $filter_type) ) || (is_string($filter_type) && $filter_type == 'category') ) {
            $output     .=   $cats_content;
        }
        if ($use_filter_sort) {
            $output     .=   $display_filter_header ? '<h5>'.__('Sort', 'uipro').'</h5>' : '';
            $output     .=   '<ul class="'.($filter_position != 'top' ? 'uk-nav uk-nav-default' : 'uk-subnav').$filter_align.'">';
            $output     .=   '<li data-uk-filter-control="sort: data-date; order: desc"><a class="uk-button-text" href="#">'.__('Newest', 'uipro').'</a></li>';
            $output     .=   '<li data-uk-filter-control="sort: data-date"><a class="uk-button-text" href="#">'.__('Oldest', 'uipro').'</a></li>';
            $output     .=   '<li data-uk-filter-control="sort: data-hits; order: desc"><a class="uk-button-text" href="#">'.__('Most Popular', 'uipro').'</a></li>';
            $output     .=   '</ul>';
        }
        $output .=  '</div>';
    }
    if ($use_slider) {
        $output .= '<div data-uk-slider="'.($center_slider ? 'center: true' : '').'">';
        $output .= '<div class="uk-position-relative">';
        $output .= '<div class="uk-slider-container">';
    }
    $output     .=  '<div class="'.( $filter_position != 'top' ? 'uk-width-expand'.$filter_visibility : '' ).'">';
    $output     .=  '<div class="ui-post-items uk-child-width-1-'.$large_desktop_columns.'@xl uk-child-width-1-'
        .$desktop_columns.'@l uk-child-width-1-'.$laptop_columns.'@m uk-child-width-1-'.$tablet_columns
        .'@s uk-child-width-1-'. $mobile_columns . $column_grid_gap . ($use_slider ? ' uk-slider-items': '')
        .($card_divider?' uk-grid-divider':'')
        .'" data-uk-grid="'.($masonry ? 'masonry:true;' : '').'">';

    foreach ($posts as $i => $item) {
        ob_start();
            \UIPro_Elementor_Helper::get_widget_template('post_item',
                array('instance' => $instance, 'pre_val' => $pre_val, 'output' => '', 'item' => $item, 'args' => $args), $template_path);
            $output .= ob_get_contents();
            ob_end_clean();
    }
    $output     .=  '</div>';
    //end grid

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

    echo ent2ncr($output);
}