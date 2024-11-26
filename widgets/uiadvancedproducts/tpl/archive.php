<?php

defined( 'ABSPATH' ) || exit;

use Advanced_Product\AP_Templates;
$limit      = ( isset( $instance['limit'] ) && $instance['limit'] ) ? $instance['limit'] : 4;
$branch     = ( isset( $instance['ap_product_branch'] ) && $instance['ap_product_branch'] ) ? $instance['ap_product_branch'] : '';
$category   = ( isset( $instance['ap_product_category'] ) && $instance['ap_product_category'] ) ? $instance['ap_product_category'] : '';
$product_type   = ( isset( $instance['uiap_product_type'] ) && $instance['uiap_product_type'] ) ? $instance['uiap_product_type'] : '';
$ordering   = ( isset( $instance['ordering'] ) && $instance['ordering'] ) ? $instance['ordering'] : 'latest';
$pagination_type    = (isset($instance['pagination_type']) && $instance['pagination_type']) ? $instance['pagination_type'] : 'none';
$main_layout    = (isset($instance['main_layout']) && $instance['main_layout']) ? $instance['main_layout'] : '';

$query_args = array(
    'post_type'         => 'ap_product',
    'post_status'       => 'publish',
    'posts_per_page'    => $limit,
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
    case 'price_low':
        $query_args['orderby'] = 'meta_value_num';
        $query_args['order'] = 'DESC';
        $query_args['meta_key'] = 'ap_price';
        break;
    case 'price':
        $query_args['orderby'] = 'meta_value_num';
        $query_args['order'] = 'ASC';
        $query_args['meta_key'] = 'ap_price';
        break;
    case 'price_rental':
    case 'price_rental_low':
        $query_args['order']      = 'ASC';
        $query_args['orderby']   = 'meta_value_num';
        $query_args['meta_key'] = 'ap_rental_price';
        break;
    case 'rprice_rental':
    case 'price_rental_high':
        $query_args['order']      = 'DESC';
        $query_args['orderby']   = 'meta_value_num';
        $query_args['meta_key'] = 'ap_rental_price';
        break;
}
$tax_query  = array();
if(isset($branch) && !empty($branch)){
    $tax_query[] = array(
        'taxonomy'  => 'ap_branch',
        'field'     => 'slug',
        'terms'     => $branch,
    );
}
if(isset($category) && !empty($category)){
    $tax_query[] = array(
        'taxonomy'  => 'ap_category',
        'field'     => 'slug',
        'terms'     => $category,
    );
}

// Custom categories
$categories = UIPro_UIAdvancedProducts_Helper::get_custom_categories();
if (!empty($categories) && count($categories)) {
    foreach ($categories as $cat) {
        $slug = get_post_meta($cat->ID, 'slug', true);

        if (!taxonomy_exists($slug)) {
            continue;
        }

        $custom_cat = (isset($instance['ap_product_'.$slug]) && $instance['ap_product_'.$slug]) ? $instance['ap_product_'.$slug] : array();
        $custom_cat_filter = (isset($instance['ap_product_'.$slug.'_filter']) && $instance['ap_product_'.$slug.'_filter']) ? $instance['ap_product_'.$slug.'_filter'] : array();

        if (!empty($custom_cat) && count($custom_cat)) {
            $tax_query[] = array(
                'taxonomy' => $slug,
                'field' => 'slug',
                'terms' => $custom_cat,
            );
        }

    }
}

if (!empty($tax_query) && count($tax_query)) {
    $query_args['tax_query'] = $tax_query;
}

if(isset($product_type) && !empty($product_type)){
    if(is_array($product_type)){
        if(count($product_type) >= 2){
            $type_meta['relation'] = 'OR';
        }
        foreach ($product_type as $type_item){
            $type_meta[] = array(
                'key' => 'ap_product_type',
                'value' => $type_item,
                'compare' => 'LIKE',
            );
        }
    }
    $query_args['meta_query']= $type_meta;
}

if ($pagination_type == 'default') {
    $query_args['paged'] = max( 1, get_query_var('paged') );
}
$ap_posts = new WP_Query($query_args);
$module_id = uniqid('templaza_');
if($main_layout){
    $args['product_loop'] = $main_layout;
}
if($ap_posts && $ap_posts -> have_posts()) {

//responsive width
    $large_desktop_columns    = ( isset( $instance['large_desktop_columns'] ) && $instance['large_desktop_columns'] ) ? $instance['large_desktop_columns'] : '4';
    $desktop_columns    = ( isset( $instance['desktop_columns'] ) && $instance['desktop_columns'] ) ? $instance['desktop_columns'] : '4';
    $laptop_columns     = ( isset( $instance['laptop_columns'] ) && $instance['laptop_columns'] ) ? $instance['laptop_columns'] : '3';
    $tablet_columns     = ( isset( $instance['tablet_columns'] ) && $instance['tablet_columns'] ) ? $instance['tablet_columns'] : '2';
    $mobile_columns     = ( isset( $instance['mobile_columns'] ) && $instance['mobile_columns'] ) ? $instance['mobile_columns'] : '1';
    $column_grid_gap    = ( isset( $instance['column_grid_gap'] ) && $instance['column_grid_gap'] ) ? ' uk-grid-'. $instance['column_grid_gap'] : '';

    //Filter
    $use_filter 	    = (isset($instance['use_filter']) && $instance['use_filter']) ? intval($instance['use_filter']) : 0;
    $filter_type 	    = (isset($instance['filter_type']) && $instance['filter_type']) ? $instance['filter_type'] : 'tag';
    $filter_position 	= (isset($instance['filter_position']) && $instance['filter_position']) ? $instance['filter_position'] : 'top';
    $filter_container	= (isset($instance['filter_container']) && $instance['filter_container']) ? ' uk-container-'. $instance['filter_container'] : '';
    $filter_grid_gap	= (isset($instance['filter_grid_gap']) && $instance['filter_grid_gap']) ? ' uk-grid-'. $instance['filter_grid_gap'] : '';
    $use_filter_sort 	= (isset($instance['use_filter_sort']) && $instance['use_filter_sort']) ? intval($instance['use_filter_sort']) : 0;
    $display_filter_header 	= (isset($instance['display_filter_header']) && $instance['display_filter_header']) ? intval($instance['display_filter_header']) : 0;
    $filter_animate 	= (isset($instance['filter_animate']) && $instance['filter_animate']) ? $instance['filter_animate'] : 'slide';
    $filter_visibility 	= (isset($instance['filter_visibility']) && $instance['filter_visibility']) ? $instance['filter_visibility'] : '';

    $filter_all 	    = (isset($instance['filter_all']) && $instance['filter_all']) ? intval($instance['filter_all']) : 0;
    $filter_all_text 	= (isset($instance['filter_all_text']) && $instance['filter_all_text']) ? $instance['filter_all_text'] : '';

    $query_args         = (isset($instance['query_args']) && !empty($instance['query_args']))?$instance['query_args']:array();
    $pagination_type    = (isset($instance['pagination_type']) && $instance['pagination_type']) ? $instance['pagination_type'] : 'none';
    $masonry            = (isset($instance['masonry']) && $instance['masonry']) ? intval($instance['masonry']) : 0;

    $use_slider 	    = (isset($instance['use_slider']) && $instance['use_slider']) ? intval($instance['use_slider']) : 0;
    $autoplay	        = (isset($instance['enable_autoplay']) && $instance['enable_autoplay']) ? intval($instance['enable_autoplay']) : 0;
    $enable_navigation	= (isset($instance['enable_navigation']) && $instance['enable_navigation']) ? intval($instance['enable_navigation']) : 0;
    $navigation_in_group	= (isset($instance['navigation_in_group']) && $instance['navigation_in_group']) ? intval($instance['navigation_in_group']) : 0;
    $enable_dotnav	    = (isset($instance['enable_dotnav']) && $instance['enable_dotnav']) ? intval($instance['enable_dotnav']) : 0;
    $center_slider	    = (isset($instance['center_slider']) && $instance['center_slider']) ? intval($instance['center_slider']) : 0;
    $navigation_position= (isset($instance['navigation_position']) && $instance['navigation_position']) ? $instance['navigation_position'] : '';
    $slider_visible     = (isset($instance['slider_visible']) && $instance['slider_visible']) ? $instance['slider_visible'] : '';
    $slider_start       = (isset($instance['slider_item_start']) && $instance['slider_item_start']) ? $instance['slider_item_start'] : '0';

    $show_author 	    = (isset($instance['show_author']) && $instance['show_author']) ? intval($instance['show_author']) : 0;
    $show_intro 	    = (isset($instance['show_introtext']) && $instance['show_introtext']) ? intval($instance['show_introtext']) : 0;
    $args['show_author'] = $show_author;
    $args['show_intro'] = $show_intro;
    $args['ap_class'] = 'templazaFadeInUp';

    $general_styles = \UIPro_Elementor_Helper::get_general_styles($instance);
    $output = '';
    ?>
    <div  class="ui-advanced-products <?php echo esc_attr($general_styles['container_cls']) .' '.$general_styles['animation'].' ui-'.$slider_visible;?>">
    <?php
    if ($use_slider) {
        ?>
        <div data-uk-slider="<?php echo $center_slider ? 'center: true; ' : ''; echo $autoplay ? 'autoplay: true; autoplay-interval: 5000; ' : '';  echo 'index: '.$slider_start.''; ?>">
        <div class="uk-position-relative">
        <div class="uk-slider-container">
    <?php
    }
    if($use_filter){
        $filter_by = (isset($instance['filter_by']) && $instance['filter_by']) ? $instance['filter_by'] : 'ap_category';
        $filter_value = (isset($instance['ap_product_'.$filter_by.'_filter']) && $instance['ap_product_'.$filter_by.'_filter']) ? $instance['ap_product_'.$filter_by.'_filter'] : '';

        if(isset($filter_value) && !empty($filter_value)){
        ?>

        <div class="ap-filter" data-module="<?php echo esc_attr($module_id);?>" data-order="<?php echo esc_attr($ordering);?>" data-filter="<?php echo esc_attr($filter_by);?>">
            <?php
            if($filter_all){
                ?>
                <a href="javascript:" class="active" data-value="0"><?php echo esc_html($filter_all_text);?></a>
                <?php
            }
            foreach ($filter_value as $item){
                $ap_tax = get_term_by( 'slug', $item, $filter_by );
                if($ap_tax){
                    ?>
                    <a href="javascript:" data-value="<?php echo esc_attr($item);?>"><?php echo esc_html($ap_tax->name);?></a>
                    <?php
                }
            }
            ?>
        </div>
        <?php
        }
    }
    ?>
    <div data-grid-second class="ui-post-items templaza-ap-archive ap-product-container uk-position-relative <?php echo esc_attr($module_id);?> uk-child-width-1-<?php echo $large_desktop_columns;?>@xl
    uk-child-width-1-<?php echo $desktop_columns;?>@l
    uk-child-width-1-<?php echo $laptop_columns;?>@m
    uk-child-width-1-<?php echo $tablet_columns;?>@s
    uk-child-width-1-<?php echo $mobile_columns . $column_grid_gap . ($use_slider ? ' uk-slider-items': '');?>" data-uk-grid="<?php echo $masonry ? 'masonry:true;' : '';?>" >
        <?php
        while ($ap_posts -> have_posts()) {
            $ap_posts -> the_post();
                if(is_plugin_active('advanced-product/advanced-product.php')){
                AP_Templates::load_my_layout('archive.content-item',true,false,$args);
                }
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
            if($navigation_in_group){
                ?>
                <div class="tz-nav-group">
                <?php
            }
            if($navigation_position == 'inside'){ ?>
            <div class="<?php echo $navigation_position == 'inside' ? '' : 'uk-hidden@l'; ?> uk-light">
                <a class="uk-position-center-left uk-slidernav uk-position-small" href="#" data-uk-slidenav-previous data-uk-slider-item="previous"></a>
                <a class="uk-position-center-right uk-slidernav uk-position-small" href="#" data-uk-slidenav-next data-uk-slider-item="next"></a>
            </div>
            <?php }elseif($navigation_position == ''){ ?>
            <div class="uk-visible@l">
                <a class="uk-position-center-left-out uk-slidernav uk-position-small" href="#" data-uk-slidenav-previous data-uk-slider-item="previous"></a>
                <a class="uk-position-center-right-out uk-slidernav uk-position-small" href="#" data-uk-slidenav-next data-uk-slider-item="next"></a>
            </div>
        <?php
            }else{
                ?>
                <div class="uk-nav-wrap uk-flex uk-position-<?php echo esc_attr($navigation_position);?>">
                    <a class="uk-slidernav" href="#" data-uk-slidenav-previous data-uk-slider-item="previous"></a>
                    <a class="uk-slidernav" href="#" data-uk-slidenav-next data-uk-slider-item="next"></a>
                </div>
                <?php
            }
            if($navigation_in_group){
            ?>
                </div>
            <?php
            }
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
                $output .= '<div class="templaza-blog-pagenavi ui-post-pagination uk-text-center uk-margin-large-top"><nav class="navigation pagination"><div class="nav-links">';
                $output .= paginate_links(array(
                    'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                    'format' => '?paged=%#%',
                    'current' => max(1, get_query_var('paged')),
                    'total' => $ap_posts->max_num_pages,
                    'prev_text' => '<span data-uk-icon="arrow-left"></span>',
                    'next_text' => '<span data-uk-icon="arrow-right"></span>',
                ));
                $output .= '</div></nav></div>';
                break;
        }

        if ($pagination_type == 'ajax'|| $use_filter =='1') {
            $output     .=  '<input type="hidden" class="ui-post-paging" value="'.base64_encode(json_encode($query_args)).'" />';
            $output     .=  '<input type="hidden" class="ui-current-page" value="'.(get_query_var( 'paged' ) ? get_query_var('paged') : 1).'" />';
            $output     .=  '<input type="hidden" class="ui-post-settings" value="'.base64_encode(json_encode($instance)).'" />';
        }
    echo ent2ncr($output);
    ?>
</div>
<?php
}
