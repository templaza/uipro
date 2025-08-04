<?php
defined( 'ABSPATH' ) || exit;

use TemPlazaFramework\Functions as TemplazaFramework_Functions;

$_is_elementor  = (isset($args['page_builder']) && $args['page_builder'] == 'elementor')?true:false;

$color_mode         = (isset($instance['color_mode'] ) && $instance['color_mode'] ) ? ' uk-'. $instance['color_mode'] : '';
$pagination_type    = (isset($instance['pagination_type']) && $instance['pagination_type']) ? $instance['pagination_type'] : 'none';
$masonry            = (isset($instance['masonry']) && $instance['masonry']) ? intval($instance['masonry']) : 0;

//Get posts
$limit          = ( isset( $instance['limit'] ) && $instance['limit'] ) ? $instance['limit'] : 4;
$lead_limit     = ( isset( $instance['lead_limit'] ) && $instance['lead_limit'] ) ? $instance['lead_limit'] : 0;
$resource       = ( isset( $instance['resource'] ) && $instance['resource'] ) ? $instance['resource'] : 'post';
$ordering       = ( isset( $instance['ordering'] ) && $instance['ordering'] ) ? $instance['ordering'] : 'latest';
$category   = ( isset( $instance[$resource.'_category'] ) && $instance[$resource.'_category'] ) ? $instance[$resource.'_category'] : array('0');

$show_featured  = isset( $instance['show_featured'] ) ? $instance['show_featured'] : '';

// Disable show featured option if post type doesn't support this feature in templaza framework
if(class_exists('TemPlazaFramework\Functions')){
    $options     = TemplazaFramework_Functions::get_global_settings();
    $featured_posttypes = array();
    if(isset($options['enable-featured-for-posttypes'])&& !empty($options['enable-featured-for-posttypes'])){
        $featured_posttypes = $options['enable-featured-for-posttypes'];
    }
    if(!in_array($resource, $featured_posttypes)){
        $show_featured  = '';
    }
}

$query_args = array(
    'post_type'         => $resource,
    'posts_per_page'    => $limit + $lead_limit,
);
switch ($ordering) {
    case 'latest':
        $query_args['orderby'] = 'date';
        $query_args['order'] = 'DESC';
        break;
    case 'oldest':
        $query_args['orderby'] = 'date';
        $query_args['order'] = 'ASC';
        break;
    case 'random':
        $query_args['orderby'] = 'rand';
        break;
    case 'popular':
        $query_args['orderby'] = 'meta_value_num';
        $query_args['order'] = 'DESC';
        $query_args['meta_key'] = 'post_views_count';
        break;
    case 'sticky':
        $query_args['post__in'] = get_option( 'sticky_posts' );
        $query_args['ignore_sticky_posts'] = 1;
        break;
}
if ($resource == 'post') {
    $query_args['category']  =   implode(',', $category);
} else {
    if (count($category) && $category[0] != '0') {
        $query_args['tax_query'] =   array(
            array(
                'taxonomy' => $resource.'-category',
                'field' => 'id',
                'operator' => 'IN',
                'terms' => $category,
            )
        );
    }
}
if ($pagination_type == 'default') {
    $query_args['paged'] = max( 1, get_query_var('paged') );
}
if($show_featured == '1') {
    $query_args['meta_query'] = array(
        array(
            'key' => 'templaza-featured',
            'value' => '1'
        )
    );
}elseif($show_featured == '0'){
    $query_args['meta_query'] = array(
        'relation' => 'OR',
        array(
            'key'       => 'templaza-featured',
            'compare'   => '!=',
            'value'     => '1'
        ),
        array(
            'key' => 'templaza-featured',
            'compare' => 'NOT EXISTS',
            'value' => 'null',
        )
    );
}

// Based on WP get_posts() default function
$defaults = array(
    'numberposts'      => 5,
    'category'         => 0,
    'orderby'          => 'date',
    'order'            => 'DESC',
    'include'          => array(),
    'exclude'          => array(),
    'meta_key'         => '',
    'meta_value'       => '',
    'post_type'        => 'post',
    'suppress_filters' => true,
);

$parsed_args = wp_parse_args( $query_args, $defaults );
if ( empty( $parsed_args['post_status'] ) ) {
    $parsed_args['post_status'] = ( 'attachment' === $parsed_args['post_type'] ) ? 'inherit' : 'publish';
}
if ( ! empty( $parsed_args['numberposts'] ) && empty( $parsed_args['posts_per_page'] ) ) {
    $parsed_args['posts_per_page'] = $parsed_args['numberposts'];
}
if ( ! empty( $parsed_args['category'] ) ) {
    $parsed_args['cat'] = $parsed_args['category'];
}
if ( ! empty( $parsed_args['include'] ) ) {
    $incposts                      = wp_parse_id_list( $parsed_args['include'] );
    $parsed_args['posts_per_page'] = count( $incposts );  // Only the number of posts included.
    $parsed_args['post__in']       = $incposts;
} elseif ( ! empty( $parsed_args['exclude'] ) ) {
    $parsed_args['post__not_in'] = wp_parse_id_list( $parsed_args['exclude'] );
}

$parsed_args['ignore_sticky_posts'] = true;
if ($pagination_type == 'none') {
    $parsed_args['no_found_rows']       = true;
}

$post_query = new WP_Query($parsed_args);
$posts = $post_query->posts;
/*
 * End of WP get_posts() default function
 * Replace with original function
 * $posts      =   get_posts($query_args);
 */
wp_reset_postdata();

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
$filter_type 	    = (isset($instance['filter_type']) && $instance['filter_type']) ? $instance['filter_type'] : 'tag';
$filter_position 	= (isset($instance['filter_position']) && $instance['filter_position']) ? $instance['filter_position'] : 'top';
$filter_container	= (isset($instance['filter_container']) && $instance['filter_container']) ? ' uk-container-'. $instance['filter_container'] : '';
$filter_grid_gap	= (isset($instance['filter_grid_gap']) && $instance['filter_grid_gap']) ? ' uk-grid-'. $instance['filter_grid_gap'] : '';
$use_filter_sort 	= (isset($instance['use_filter_sort']) && $instance['use_filter_sort']) ? intval($instance['use_filter_sort']) : 0;
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
    $lead_position          = ( isset( $instance['lead_position'] ) && $instance['lead_position'] ) ? $instance['lead_position'] : 'top';
    $lead_column_gutter     = ( isset( $instance['lead_column_gutter'] ) && $instance['lead_column_gutter'] ) ? ' uk-grid-'.$instance['lead_column_gutter'] : '';
    $lead_column_divider    = (isset($instance['lead_column_divider']) && $instance['lead_column_divider']) ? filter_var($instance['lead_column_divider'], FILTER_VALIDATE_BOOLEAN) : 0;
    $lead_width    = (isset($instance['image_width']) && $instance['image_width']) ? ' uk-width-'
        . $instance['image_width'] : ' uk-width-1-2';
    $lead_width_xl    = (isset($instance['lead_width_xl']) && $instance['lead_width_xl']) ? ' uk-width-'
        . $instance['lead_width_xl'].'@xl' : ' uk-width-1-2@xl';
    $lead_width_l    = (isset($instance['lead_width_l']) && $instance['lead_width_l']) ? ' uk-width-'
        . $instance['lead_width_l'].'@l' : ' uk-width-1-2@l';
    $lead_width_m    = (isset($instance['lead_width_m']) && $instance['lead_width_m']) ? ' uk-width-'
        . $instance['lead_width_m'].'@m' : ' uk-width-1-2@m';
    $lead_width_s    = (isset($instance['lead_width_s']) && $instance['lead_width_s']) ? ' uk-width-'
        . $instance['lead_width_s'].'@s' : ' uk-width-1-2@s';
    $expand_width   = $lead_width_xl == ' uk-width-1-1@xl' ? ' uk-width-1-1@xl' : ' uk-width-expand@xl';
    $expand_width   .=$lead_width_l == ' uk-width-1-1@l' ? ' uk-width-1-1@l' : ' uk-width-expand@l';
    $expand_width   .=$lead_width_m == ' uk-width-1-1@m' ? ' uk-width-1-1@m' : ' uk-width-expand@m';
    $expand_width   .=$lead_width_s == ' uk-width-1-1@s' ? ' uk-width-1-1@s' : ' uk-width-expand@s';
    $expand_width   .=$lead_width == ' uk-width-1-1' ? ' uk-width-1-1' : ' uk-width-expand';

    //Get lead items and items
    $lead_items     = array();
    $first_items    = array();
    $first_limit    = 0;
    if ($lead_limit) {
        $lead_items     =   array_slice($posts, 0, $lead_limit);
        if ($limit) {
            if ($lead_position == 'between' && $limit>2) {
                $first_items    =   array_slice($posts, $lead_limit, round($limit/2));
                $posts          =   array_slice($posts, $lead_limit+round($limit/2));
                $first_limit    =   round($limit/2);
                $limit          =   $limit - round($limit/2);
            } else {
                $posts      =   array_slice($posts, $lead_limit);
            }
        }
    }

    $output     .=   '<div data-scroll class="ui-posts'. esc_attr($general_styles['container_cls']) .' '.$uipost_layout.' '.$resource.'"' . $general_styles['animation'] . '>';
    $output .=  '<div class="ui-posts-list-items '.$lead_column_gutter.($lead_column_divider ? ' uk-grid-divider' : '').'" data-uk-grid>';

    ob_start();
    \UIPro_Elementor_Helper::get_widget_template('base_posts',
        array('instance' => $instance, 'pre_val' => '', 'output' => '', 'posts' => array(
            'first_items'   => $first_items,
            'lead_items'    => $lead_items,
            'last_items'    => $posts,
        ), 'args' => $args), $template_path);
    $output .= ob_get_contents();
    ob_end_clean();
    $output     .=  '</div>'; // End ui-posts-list-items


    // Pagination section
    switch ($pagination_type) {
        case 'ajax':
            $output .=  '<div class="ui-post-loading uk-text-center uk-margin-large-top">';
            $output .=  '<div data-uk-spinner class="uk-margin-right"></div>';
            $output .=  '<span class="loading">'.esc_html__('Loading more posts...','uipro').'</span>';
            $output .=  '</div>';
            break;
        case 'default':
            $big = 999999999; // need an unlikely integer
            $output .= '<div class="ui-post-pagination uk-text-center uk-margin-large-top">';
            $output .= paginate_links( array(
                'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                'format' => '?paged=%#%',
                'current' => max( 1, get_query_var('paged') ),
                'total' => $post_query->max_num_pages,
                'prev_text' => '<span data-uk-icon="arrow-left"></span>',
                'next_text' => '<span data-uk-icon="arrow-right"></span>',
            ) );
            $output .=  '</div>';
            break;
    }

//    $output     .=  '</div>';

//	$output     .=  '</div>';
    if ($pagination_type == 'ajax') {
        $output     .=  '<input type="hidden" class="ui-post-paging" value="'.base64_encode(json_encode($query_args)).'" />';
        $output     .=  '<input type="hidden" class="ui-current-page" value="'.(get_query_var( 'paged' ) ? get_query_var('paged') : 1).'" />';
        $output     .=  '<input type="hidden" class="ui-post-settings" value="'.base64_encode(json_encode($instance)).'" />';
    }

	$output     .=  '</div>';

    echo ent2ncr($output);
}