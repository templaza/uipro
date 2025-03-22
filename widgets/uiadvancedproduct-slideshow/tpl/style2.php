<?php
//Get posts
use Advanced_Product\Helper\AP_Custom_Field_Helper;
use Advanced_Product\AP_Templates;
$general_styles = \UIPro_Elementor_Helper::get_general_styles($instance);
$limit      = ( isset( $instance['limit'] ) && $instance['limit'] ) ? $instance['limit'] : 4;
//$resource       = ( isset( $instance['resource'] ) && $instance['resource'] ) ? $instance['resource'] : 'post';
$resource   = 'ap_product';
$ap_product_source   = ( isset( $instance['ap_product_source'] ) && $instance['ap_product_source'] ) ? $instance['ap_product_source'] : '';
$ordering   = ( isset( $instance['ordering'] ) && $instance['ordering'] ) ? $instance['ordering'] : 'latest';
$branch     = ( isset( $instance[$resource.'_branch'] ) && $instance[$resource.'_branch'] ) ? $instance[$resource.'_branch'] : array('0');
$category   = ( isset( $instance[$resource.'_category'] ) && $instance[$resource.'_category'] ) ? $instance[$resource.'_category'] : array('0');
$show_price    = isset($instance['show_price'])?filter_var($instance['show_price'], FILTER_VALIDATE_BOOLEAN):true;
$show_dots    = isset($instance['show_dots'])?filter_var($instance['show_dots'], FILTER_VALIDATE_BOOLEAN):true;
$group_nav_dot    = isset($instance['group_nav_dot'])?filter_var($instance['group_nav_dot'], FILTER_VALIDATE_BOOLEAN):false;
$nav_dot_container  = isset($instance['group_nav_dot_container']) ? $instance['group_nav_dot_container'] : '';
$nav_dot_position  = isset($instance['group_nav_dot_position']) ? $instance['group_nav_dot_position'] : '';
$nav_dot_position_mobile  = isset($instance['group_nav_dot_position_mobile']) ? $instance['group_nav_dot_position_mobile'] : '';
if($ap_product_source !='custom') {
    $query_args = array(
        'post_type' => $resource,
        'posts_per_page' => $limit,
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
            $query_args['post__in'] = get_option('sticky_posts');
            $query_args['ignore_sticky_posts'] = 1;
            break;
    }
    $tax_query = array();

    if (!empty($branch) && count($branch) && $branch[0] != '0') {
        $tax_query[] = array(
            'taxonomy' => 'ap_branch',
            'field' => 'id',
            'operator' => 'IN',
            'terms' => $branch,
        );
    }
    if (count($category) && $category[0] != '0') {
        $tax_query[] = array(
            'taxonomy' => 'ap_category',
            'field' => 'id',
            'operator' => 'IN',
            'terms' => $category,
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

            $custom_cat = (isset($instance[$slug]) && $instance[$slug]) ? $instance[$slug] : array();

            if (!empty($custom_cat) && count($custom_cat)) {
                $tax_query[] = array(
                    'taxonomy' => $slug,
                    'field' => 'id',
                    'operator' => 'IN',
                    'terms' => $custom_cat,
                );
            }

        }
    }

    if (!empty($tax_query) && count($tax_query)) {
        $query_args['tax_query'] = $tax_query;
    }

// Based on WP get_posts() default function
    $defaults = array(
        'numberposts' => 5,
        'category' => 0,
        'orderby' => 'date',
        'order' => 'DESC',
        'include' => array(),
        'exclude' => array(),
        'meta_key' => '',
        'meta_value' => '',
        'post_type' => 'post',
        'suppress_filters' => true,
    );

    $parsed_args = wp_parse_args($query_args, $defaults);
    if (empty($parsed_args['post_status'])) {
        $parsed_args['post_status'] = ('attachment' === $parsed_args['post_type']) ? 'inherit' : 'publish';
    }
    if (!empty($parsed_args['numberposts']) && empty($parsed_args['posts_per_page'])) {
        $parsed_args['posts_per_page'] = $parsed_args['numberposts'];
    }
    if (!empty($parsed_args['category'])) {
        $parsed_args['cat'] = $parsed_args['category'];
    }
    if (!empty($parsed_args['include'])) {
        $incposts = wp_parse_id_list($parsed_args['include']);
        $parsed_args['posts_per_page'] = count($incposts);  // Only the number of posts included.
        $parsed_args['post__in'] = $incposts;
    } elseif (!empty($parsed_args['exclude'])) {
        $parsed_args['post__not_in'] = wp_parse_id_list($parsed_args['exclude']);
    }

    $parsed_args['ignore_sticky_posts'] = true;
    if ($pagination_type == 'none') {
        $parsed_args['no_found_rows'] = true;
    }

    $post_query = new WP_Query($parsed_args);
    $products = $post_query->posts;
}else{
    $products   = isset($instance['ap_products_custom']) ? $instance['ap_products_custom'] : array();
}
$slide_option = '';
if($instance['slideshow_transition']){
    $slide_option .='animation: '.$instance['slideshow_transition'].'; ';
}
$custom_fields   = isset($instance['custom_fields']) ? $instance['custom_fields'] : array();
$ap_container   = isset($instance['ap_style1_container']) ? $instance['ap_style1_container'] : '';
$ap_ratio   = isset($instance['slideshow_ratio']) ? $instance['slideshow_ratio'] : '16:9';
$ap_min_height   = isset($instance['slideshow_min_height']) ? $instance['slideshow_min_height'] : '';
$ap_max_height   = isset($instance['slideshow_max_height']) ? $instance['slideshow_max_height'] : '';
$dots_positions = ( isset( $instance['dots_positions'] ) && $instance['dots_positions'] ) ? $instance['dots_positions'] : '';

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
$group_positions = '';
if($nav_dot_position == 'uk-position-top-left'){
	$group_positions = ' uk-flex uk-flex-middle uk-flex-left@s';
}elseif($nav_dot_position == 'uk-position-top-right'){
	$group_positions = ' uk-flex uk-flex-middle uk-flex-right@s';
}elseif($nav_dot_position == 'uk-position-center-left'){
	$group_positions = ' uk-flex uk-flex-middle uk-flex-left@s';
}elseif($nav_dot_position == 'uk-position-center-right'){
	$group_positions = ' uk-flex uk-flex-middle uk-flex-right@s';
}elseif($nav_dot_position == 'uk-position-bottom-right'){
	$group_positions = ' uk-flex uk-flex-middle uk-flex-right@s';
}elseif($nav_dot_position == 'uk-position-bottom-left'){
	$group_positions = ' uk-flex uk-flex-middle uk-flex-left@s';
}elseif($nav_dot_position == 'uk-position-bottom-center'){
	$group_positions = ' uk-flex  uk-flex-middle uk-flex-center@s';
}
if($nav_dot_position_mobile == 'uk-position-top-left'){
	$group_positions .= ' uk-flex-left';
}elseif($nav_dot_position_mobile == 'uk-position-top-right'){
	$group_positions .= ' uk-flex-right';
}elseif($nav_dot_position_mobile == 'uk-position-center-left'){
	$group_positions .= ' uk-flex-left';
}elseif($nav_dot_position_mobile == 'uk-position-center-right'){
	$group_positions .= ' uk-flex-right';
}elseif($nav_dot_position_mobile == 'uk-position-bottom-right'){
	$group_positions .= ' uk-flex-right';
}elseif($nav_dot_position_mobile == 'uk-position-bottom-left'){
	$group_positions .= ' uk-flex-left';
}elseif($nav_dot_position_mobile == 'uk-position-bottom-center'){
	$group_positions .= ' uk-flex-center';
}
if($ap_ratio){
	$slide_option .='ratio: '.$ap_ratio.'; ';
}
if($ap_min_height){
	$slide_option .='min-height: '.$ap_min_height.'; ';
}
if($ap_max_height){
	$slide_option .='max-height: '.$ap_max_height.'; ';
}
$btn_icon = $btn_icon_left = $btn_icon_right = $btn2_icon = $btn2_icon_left = $btn2_icon_right ='';

$button_icon   = ( isset( $instance['button_icon'] ) && $instance['button_icon'] ) ? $instance['button_icon'] : array();
$button_icon_pos=   isset($instance['button_icon_position']) ? $instance['button_icon_position'] : 'before';
if($button_icon_pos =='before'){
	$ic_pos = 'uk-margin-small-right';
}else{
	$ic_pos = 'uk-margin-small-left';
}
if ($button_icon && isset($button_icon['value'])) {
	if ( is_array( $button_icon['value'] ) && isset( $button_icon['value']['url'] ) && $button_icon['value']['url'] ) {
		$btn_icon .= '<img src="' . $button_icon['value']['url'] . '" class="' . $ic_pos . '" alt="' . $instance['button_text'] . '" data-uk-svg />';
	} elseif ( is_string( $button_icon['value'] ) && $button_icon['value'] ) {
		$btn_icon .= '<i class="' . $button_icon['value'] . ' ' . $ic_pos . '" aria-hidden="true"></i>';
	}
}
if ($btn_icon) {
	if ($button_icon_pos == 'after') {
		$btn_icon_right     =   $btn_icon;
	} else {
		$btn_icon_left      =   $btn_icon;
	}
}

$button2_icon   = ( isset( $instance['button2_icon'] ) && $instance['button2_icon'] ) ? $instance['button2_icon'] : array();
$button2_icon_pos=   isset($instance['button2_icon_position']) ? $instance['button2_icon_position'] : 'before';
if($button2_icon_pos =='before'){
	$ic2_pos = 'uk-margin-small-right';
}else{
	$ic2_pos = 'uk-margin-small-left';
}
if ($button2_icon && isset($button2_icon['value'])) {
	if ( is_array( $button2_icon['value'] ) && isset( $button2_icon['value']['url'] ) && $button2_icon['value']['url'] ) {
		$btn2_icon .= '<img src="' . $button2_icon['value']['url'] . '" class="' . $ic2_pos . '" alt="' . $instance['button2_text'] . '" data-uk-svg />';
	} elseif ( is_string( $button2_icon['value'] ) && $button2_icon['value'] ) {
		$btn2_icon .= '<i class="' . $button2_icon['value'] . ' ' . $ic2_pos . '" aria-hidden="true"></i>';
	}
}
if ($btn2_icon) {
	if ($button2_icon_pos == 'after') {
		$btn2_icon_right     =   $btn2_icon;
	} else {
		$btn2_icon_left      =   $btn2_icon;
	}
}

$kenburns_transition = ( isset( $instance['kenburns_transition'] ) && $instance['kenburns_transition'] ) ? ' uk-transform-origin-' . $instance['kenburns_transition'] : '';

$kenburns_duration = ( isset( $instance['kenburns_duration'] ) && isset( $instance['kenburns_duration']['size'] ) && $instance['kenburns_duration']['size'] ) ? $instance['kenburns_duration']['size'] : '';
if ( $kenburns_duration ) {
    $kenburns_duration = ' style="-webkit-animation-duration: ' . $kenburns_duration . 's; animation-duration: ' . $kenburns_duration . 's;"';
}

$output = '';

$slidenav_position     = ( isset( $instance['slidenav_position'] ) && $instance['slidenav_position'] ) ? $instance['slidenav_position'] : '';
$slidenav_position_cls = ( ! empty( $slidenav_position ) || ( $slidenav_position != 'default' ) ) ? ' uk-position-' . $slidenav_position . '' : '';

if ( $slidenav_position == 'default' ) {
	$output .= '<div class="tz-sidenav">';
	$output .= '<a class="ui-slidenav  uk-position-center-left" href="#" data-uk-slidenav-previous data-uk-slideshow-item="previous"></a>';
	$output .= '<a class="ui-slidenav  uk-position-center-right" href="#" data-uk-slidenav-next data-uk-slideshow-item="next"></a>';
	$output .= '</div> ';
} elseif ( $slidenav_position == 'outside' ) {
	$output .='<div class="ui-sidenav-outside">';
	$output .= '<a class="ui-slidenav uk-position-center-left-out" href="#" data-uk-slidenav-previous data-uk-slideshow-item="previous" data-uk-toggle="cls: uk-position-center-left-out uk-position-center-left; mode: media;"></a>';
	$output .= '<a class="ui-slidenav uk-position-center-right-out" href="#" data-uk-slidenav-next data-uk-slideshow-item="next" data-uk-toggle="cls: uk-position-center-right-out uk-position-center-right; mode: media; "></a>';
	$output .= '</div> ';
} elseif ( $slidenav_position != '' ) {
	$output .= '<div class="uk-slidenav-container' . $slidenav_position_cls .'">';
	$output .= '<a class="ui-slidenav" href="#" data-uk-slidenav-previous data-uk-slideshow-item="previous"></a>';
	$output .= '<a class="ui-slidenav" href="#" data-uk-slidenav-next data-uk-slideshow-item="next"></a>';
	$output .= '</div>';
}
if($group_nav_dot){
	$output .= '<div class="uk-slidenav-container">';
	$output .= '<a class="ui-slidenav" href="#" data-uk-slidenav-previous data-uk-slideshow-item="previous"></a>';
	$output .= '<a class="ui-slidenav" href="#" data-uk-slidenav-next data-uk-slideshow-item="next"></a>';
	$output .= '</div>';
}
if($products){
    ?>
    <div data-uk-slideshow=" <?php echo esc_attr($slide_option); ?>" class="ap_slideshow uk-slider <?php echo esc_attr($general_styles['container_cls'] . $general_styles['content_cls']);?>" <?php echo wp_kses($general_styles['animation'],'post');?>>
    <ul class="uk-slideshow-items">
        <?php
        foreach ($products as $item) {
            if ($post = get_page_by_path($item['ap_products'], OBJECT, 'ap_product')){
                $product_id = $post->ID;
            }
            if( $product_id ) {
                ?>
                <li class="ap_slideshow-item uk-margin-remove">
	                <?php
                    if($kenburns_transition){
                        echo '<div class="uk-position-cover uk-animation-kenburns uk-animation-reverse' . $kenburns_transition . '"' . $kenburns_duration . '>';
                    }
                    if($item['video']['id'] !=''){
                        ?>
                        <video src="<?php echo esc_url($item['video']['url']);?>" autoplay loop muted playsinline uk-cover></video>
                        <?php
                    }else{
                        if($item['image']['id'] ==''){
                            echo get_the_post_thumbnail($product_id,'full','data-uk-cover');
                        }else{
                            ?>
                            <img data-uk-cover src="<?php echo esc_url($item['image']['url']);?>" alt="<?php echo esc_attr(get_the_title($product_id)); ?>"/>
                        <?php }
                    }
                    if($kenburns_transition){
                        echo '</div>';
                    }
	                ?>
                    <div class="uk-overlay uk-position-cover ap_slideshow_overlay"></div>
                    <div class=" uk-container <?php echo esc_attr($ap_container);?> uk-position-cover uk-flex <?php echo esc_attr($overlay_positions);?>">
                        <div class="ap_slider_content_inner uk-flex <?php echo esc_attr($overlay_positions);?>" data-uk-grid>
                            <div class="ap-slider-info-left uk-width-1-2@m uk-width-1-1">
                                <?php
                                if($item['ap_text_meta']){
                                    ?>
                                    <span class="ap-custom-meta">
                                                <?php
                                                echo $item['ap_text_meta'];
                                                ?>
                                            </span>
                                    <?php
                                }
                                ?>
                                <h3 class="ap-slideshow-title">
                                    <?php echo esc_html(get_the_title($product_id)); ?>
                                </h3>
                                <?php
                                if($show_price || $instance['button_text'] || $instance['button2_text']){
                                    ?>
                                    <div class="ap-slideshow-info">
                                        <?php
                                    if($show_price) {
                                        $args['product_id'] = $product_id;
                                        AP_Templates::load_my_layout('archive.price', true, false, $args);
                                    }
                                    if($instance['button_text'] || $instance['button2_text']){
                                        ?>
                                        <div class="ap-slideshow-readmore uk-flex flex-align uk-flex-middle">
                                            <?php
                                            if($instance['button_text']){
                                                ?>
                                                <a class="ui-button templaza-btn" href="<?php echo esc_url(get_permalink($product_id));?>">
                                                    <?php echo $btn_icon_left.esc_html($instance['button_text']). $btn_icon_right;?>
                                                </a>
                                                <?php
                                            }
                                            if($instance['button2_text']){
                                                ?>
                                                <a class="ui-button2 templaza-btn" href="<?php echo esc_url(get_permalink($product_id));?>">
                                                    <?php echo $btn2_icon_left.esc_html($instance['button2_text']). $btn2_icon_right;?>
                                                </a>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="ap-slider-info-right uk-width-1-2@m uk-width-1-1">
                                <div class="ap-slideshow-info">
                                    <div class="ap-single-desc ap-top-info">
                                        <?php
                                        if($item['ap_description']){
                                            echo $item['ap_description'];
                                        }else{
                                            echo get_the_excerpt($product_id);
                                        }
                                        ?>
                                        <div class="ap-custom-text">
                                            <?php
                                            if($item['ap_text_custom']){
                                                ?>
                                                <div class="ap-custom-desc">
                                                    <?php
                                                    echo $item['ap_text_custom'];
                                                    ?>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="ap-bottom-info">
                                        <div class="ap-slideshow-bottom-fields ap-single-top-fields flex-align">
                                            <?php
                                            if($custom_fields){
                                                foreach ($custom_fields as $field_item){
                                                    $ap_item = AP_Custom_Field_Helper::get_custom_field_option_by_field_name($field_item);
                                                    $f_value    = get_field($ap_item['name'], $product_id);
                                                    if(!empty($f_value)){
                                                        if($ap_item['type'] !='taxonomy'){
                                                            ?>
                                                            <div class="ap-custom-fields">
                                                                <div class="ap-field-label"><?php echo esc_html($ap_item['label']); ?></div>
                                                                <div class="ap-field-value">
                                                                    <?php
                                                                    if($ap_item['type'] == 'file'){
                                                                        $file_url   = '';
                                                                        if(is_array($f_value)){
                                                                            $file_url   = $f_value['url'];
                                                                        }elseif(is_numeric($f_value)){
                                                                            $file_url   = wp_get_attachment_url($f_value);
                                                                        }else{
                                                                            $file_url   = $f_value;
                                                                        }
                                                                        ?>
                                                                        <a href="<?php echo esc_url($file_url); ?>" download><?php
                                                                            echo esc_html__('Download', 'uipro')?></a>
                                                                        <?php
                                                                    }else{
                                                                        ?><?php echo esc_html(the_field($ap_item['name'], $product_id)); ?>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                </li>
            <?php
            }
        }
        ?>
    </ul>
    <?php
    if($group_nav_dot){
        ?>
            <div class="ap_slideshow-nav_group uk-width-1-1 <?php echo esc_attr($nav_dot_position);?>">
        <?php
    }
    ?>
        <div class=" uk-container <?php echo esc_attr($nav_dot_container.' '. $group_positions);?>">
            <?php
            echo $output;
            if($show_dots){
                ?>
                <ul class="uk-slideshow-nav uk-dotnav  uk-flex uk-flex-middle uk-position-<?php echo esc_attr($dots_positions);?>"></ul>
                <?php
            }
            ?>
        </div>
    <?php
    if($group_nav_dot){
        ?>
            </div>
        <?php
    }
    ?>
</div>
<?php
}