<?php

defined( 'ABSPATH' ) || exit;

use Advanced_Product\AP_Templates;

//global $wp_query;
//
//// Store current $wp_query to $wp_query_tmp
//$wp_query_tmp       = $wp_query;
//// Set $wp_query to new object
//$wp_query           = isset($instance['posts'])?$instance['posts']:$wp_query_tmp;

$ap_posts   = isset($instance['ap_posts'])?$instance['ap_posts']:false;

if($ap_posts && $ap_posts -> have_posts()) {

//responsive width
    $large_desktop_columns    = ( isset( $instance['large_desktop_columns'] ) && $instance['large_desktop_columns'] ) ? $instance['large_desktop_columns'] : '4';
    $desktop_columns    = ( isset( $instance['desktop_columns'] ) && $instance['desktop_columns'] ) ? $instance['desktop_columns'] : '4';
    $laptop_columns     = ( isset( $instance['laptop_columns'] ) && $instance['laptop_columns'] ) ? $instance['laptop_columns'] : '3';
    $tablet_columns     = ( isset( $instance['tablet_columns'] ) && $instance['tablet_columns'] ) ? $instance['tablet_columns'] : '2';
    $mobile_columns     = ( isset( $instance['mobile_columns'] ) && $instance['mobile_columns'] ) ? $instance['mobile_columns'] : '1';
    $column_grid_gap    = ( isset( $instance['column_grid_gap'] ) && $instance['column_grid_gap'] ) ? ' uk-grid-'. $instance['column_grid_gap'] : '';

    $query_args         = (isset($instance['query_args']) && !empty($instance['query_args']))?$instance['query_args']:array();
    $pagination_type    = (isset($instance['pagination_type']) && $instance['pagination_type']) ? $instance['pagination_type'] : 'none';
    $masonry            = (isset($instance['masonry']) && $instance['masonry']) ? intval($instance['masonry']) : 0;

    $use_slider 	    = (isset($instance['use_slider']) && $instance['use_slider']) ? intval($instance['use_slider']) : 0;
    $enable_navigation	= (isset($instance['enable_navigation']) && $instance['enable_navigation']) ? intval($instance['enable_navigation']) : 0;
    $enable_dotnav	    = (isset($instance['enable_dotnav']) && $instance['enable_dotnav']) ? intval($instance['enable_dotnav']) : 0;
    $center_slider	    = (isset($instance['center_slider']) && $instance['center_slider']) ? intval($instance['center_slider']) : 0;
    $navigation_position= (isset($instance['navigation_position']) && $instance['navigation_position']) ? $instance['navigation_position'] : '';

    $general_styles = \UIPro_Elementor_Helper::get_general_styles($instance);
    $output = '';
    ?>
    <div class="ui-advanced-products <?php echo esc_attr($general_styles['container_cls']) .' '.$general_styles['animation'];?>">
    <?php
    if ($use_slider) {
        ?>
        <div data-uk-slider="<?php echo $center_slider ? 'center: true' : ''; ?>">
        <div class="uk-position-relative">
        <div class="uk-slider-container">
    <?php
    }
    ?>
    <div class="ui-post-items uk-child-width-1-<?php echo $large_desktop_columns;?>@xl
    uk-child-width-1-<?php echo $desktop_columns;?>@l
    uk-child-width-1-<?php echo $laptop_columns;?>@m
    uk-child-width-1-<?php echo $tablet_columns;?>@s
    uk-child-width-1-<?php echo $mobile_columns . $column_grid_gap . ($use_slider ? ' uk-slider-items': '');?>" data-uk-grid="<?php echo $masonry ? 'masonry:true;' : '';?>">
        <?php
        while ($ap_posts -> have_posts()) {
            $ap_posts -> the_post();
            AP_Templates::load_my_layout('archive.content-item');
        }
        ?>
    </div>
    <?php
    wp_reset_postdata();
    if ($use_slider) {
        // End Slider Container
        ?>
        </div>
        <?php
        if ($enable_navigation) {
            if($navigation_position == 'inside'){ ?>
            <div class="<?php echo $navigation_position == 'inside' ? '' : 'uk-hidden@l'; ?> uk-light">
                <a class="uk-position-center-left uk-position-small" href="#" data-uk-slidenav-previous data-uk-slider-item="previous"></a>
                <a class="uk-position-center-right uk-position-small" href="#" data-uk-slidenav-next data-uk-slider-item="next"></a>
            </div>
            <?php } ?>
            <div class="uk-visible@l">
                <a class="uk-position-center-left-out uk-position-small" href="#" data-uk-slidenav-previous data-uk-slider-item="previous"></a>
                <a class="uk-position-center-right-out uk-position-small" href="#" data-uk-slidenav-next data-uk-slider-item="next"></a>
            </div>
        <?php
        }
        ?>
        </div>
        <?php
        if ($enable_dotnav) {
            ?>
            <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>
            <?php
        }
        ?>
        </div>
        <?php
    }

        // Pagination section
        switch ($pagination_type) {
            case 'ajax':
                $output .= '<div class="ui-post-loading uk-text-center uk-margin-large-top">';
                $output .= '<div data-uk-spinner class="uk-margin-right"></div>';
                $output .= '<span class="loading">' . esc_html__('Loading more posts...', 'uipro') . '</span>';
                $output .= '</div>';
                break;
            case 'default':
                $big = 999999999; // need an unlikely integer
                $output .= '<div class="ui-post-pagination uk-text-center uk-margin-large-top">';
                $output .= paginate_links(array(
                    'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                    'format' => '?paged=%#%',
                    'current' => max(1, get_query_var('paged')),
                    'total' => $post_query->max_num_pages,
                    'prev_text' => '<span data-uk-icon="arrow-left"></span>',
                    'next_text' => '<span data-uk-icon="arrow-right"></span>',
                ));
                $output .= '</div>';
                break;
        }

        if ($pagination_type == 'ajax') {
            $output     .=  '<input type="hidden" class="ui-post-paging" value="'.base64_encode(json_encode($query_args)).'" />';
            $output     .=  '<input type="hidden" class="ui-current-page" value="'.(get_query_var( 'paged' ) ? get_query_var('paged') : 1).'" />';
            $output     .=  '<input type="hidden" class="ui-post-settings" value="'.base64_encode(json_encode($instance)).'" />';
        }
    echo ent2ncr($output);
    ?>
</div>
<?php
}
