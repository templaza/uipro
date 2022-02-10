<?php

defined( 'ABSPATH' ) || exit;

use Advanced_Product\AP_Templates;

//global $wp_query;
//
//// Store current $wp_query to $wp_query_tmp
//$wp_query_tmp       = $wp_query;
//// Set $wp_query to new object
//$wp_query           = isset($instance['posts'])?$instance['posts']:$wp_query_tmp;

if(have_posts()) {

    $query_args     = (isset($instance['query_args']) && !empty($instance['query_args']))?$instance['query_args']:array();
    $pagination_type = (isset($instance['pagination_type']) && $instance['pagination_type']) ? $instance['pagination_type'] : 'none';

    $general_styles = \UIPro_Elementor_Helper::get_general_styles($instance);
    ?>
    <div class="ui-advanced-products<?php esc_attr($general_styles['container_cls']); ?>"<?php
    echo $general_styles['animation']; ?>>
        <?php
        //$output = apply_filters('uipro/widgets/uiadvancedproducts/products', '');
        AP_Templates::load_my_layout('archive.content');

        $output = '';
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

        echo $output;
        ?>

    </div>
    <?php
}

//// Assign $wp_query again
//$wp_query   = $wp_query_tmp;