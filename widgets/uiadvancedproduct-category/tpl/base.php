<?php
//Get posts
use Advanced_Product\Helper\AP_Custom_Field_Helper;
$general_styles = \UIPro_Elementor_Helper::get_general_styles($instance);
$limit      = ( isset( $instance['limit'] ) && $instance['limit'] ) ? $instance['limit'] : 4;
$resource   = 'ap_product';
$source   = ( isset( $instance['source'] ) && $instance['source'] ) ? $instance['source'] : '';
$ordering   = ( isset( $instance['ordering'] ) && $instance['ordering'] ) ? $instance['ordering'] : 'latest';
$branch     = ( isset( $instance[$resource.'_branch'] ) && $instance[$resource.'_branch'] ) ? $instance[$resource.'_branch'] : array('0');
$image_size   = ( isset( $instance['image_size'] ) && $instance['image_size'] ) ? $instance['image_size'] : 'full';
$category   = ( isset( $instance['ap_product_category'] ) && $instance['ap_product_category'] ) ? $instance['ap_product_category'] : '';

$card_style    = ( isset( $instance['card_style'] ) && $instance['card_style'] ) ? $instance['card_style'] : '';
$card_size    = ( isset( $instance['card_size'] ) && $instance['card_size'] ) ? $instance['card_size'] : '';

$large_desktop_columns    = ( isset( $instance['large_desktop_columns'] ) && $instance['large_desktop_columns'] ) ? $instance['large_desktop_columns'] : '4';
$desktop_columns    = ( isset( $instance['desktop_columns'] ) && $instance['desktop_columns'] ) ? $instance['desktop_columns'] : '4';
$laptop_columns     = ( isset( $instance['laptop_columns'] ) && $instance['laptop_columns'] ) ? $instance['laptop_columns'] : '3';
$tablet_columns     = ( isset( $instance['tablet_columns'] ) && $instance['tablet_columns'] ) ? $instance['tablet_columns'] : '2';
$mobile_columns     = ( isset( $instance['mobile_columns'] ) && $instance['mobile_columns'] ) ? $instance['mobile_columns'] : '1';
$column_grid_gap    = ( isset( $instance['column_grid_gap'] ) && $instance['column_grid_gap'] ) ? ' uk-grid-'. $instance['column_grid_gap'] : '';
$hide_empty = (isset($instance['hide_empty']) && $instance['hide_empty']) ? ($instance['hide_empty']) : false;
$slider_nav = (isset($instance['show_nav']) && $instance['show_nav']) ? intval($instance['show_nav']) : 0;
$slider_dots = (isset($instance['show_dots']) && $instance['show_dots']) ? intval($instance['show_dots']) : 0;
$image_layout = (isset($instance['image_layout']) && $instance['image_layout']) ? ($instance['image_layout']) : '';
$image_cover = (isset($instance['image_cover']) && $instance['image_cover']) ? intval($instance['image_cover']) : 0;
$flash_effect   =   isset($instance['flash_effect']) ? intval($instance['flash_effect']) : 0;
$ripple_effect = (isset($instance['image_transition']) && $instance['image_transition']) ? ($instance['image_transition']) : '';
$show_product_count = (isset($instance['show_product_count']) && $instance['show_product_count']) ? intval($instance['show_product_count']) : 0;
$count_display = (isset($instance['count_display']) && $instance['count_display']) ? ($instance['count_display']) : '';
$product_single_label      = !empty( $instance['product_single_label'] ) ? $instance['product_single_label'] : '';
$product_label      = !empty( $instance['product_label'] ) ? $instance['product_label'] : '';

$imgclass         =  $flash_effect ? ' ui-image-flash-effect uk-position-relative uk-overflow-hidden' : '';
$image_thumb = $ripple_cl = $ripple_html =' ';
if($ripple_effect =='ripple'){
    $ripple_html = '<div class="templaza-ripple-circles uk-position-center uk-transition-fade">
                        <div class="circle1"></div>
                        <div class="circle2"></div>
                        <div class="circle3"></div>
                    </div>';
    $ripple_cl = ' templaza-thumb-ripple ';
}
if($source == 'ap_category'){
    if(empty($category) || $category == ''){
        $get_terms_attributes = array (
            'taxonomy' => 'ap_category', //empty string(''), false, 0 don't work, and return empty array
            'orderby' => 'name',
            'order' => 'ASC',
            'hide_empty' => true, //can be 1, '1' too
        );
        $cat_results = get_terms($get_terms_attributes);
    } else{
        $get_terms_attributes = array (
            'taxonomy' => $source, //empty string(''), false, 0 don't work, and return empty array
            'orderby' => 'name',
            'order' => 'ASC',
            'term_taxonomy_id'       => $category,
            'hide_empty' => $hide_empty, //can be 1, '1' too

        );
        $cat_results = get_terms($get_terms_attributes);
    }
}elseif($source == 'ap_branch'){
    if(empty($branch) || $branch == ''){
        $get_terms_attributes = array (
            'taxonomy' => 'ap_branch', //empty string(''), false, 0 don't work, and return empty array
            'orderby' => 'name',
            'order' => 'ASC',
            'hide_empty' => $hide_empty, //can be 1, '1' too
        );
        $cat_results = get_terms($get_terms_attributes);
    } else{
        $get_terms_attributes = array (
            'taxonomy' => $source, //empty string(''), false, 0 don't work, and return empty array
            'orderby' => 'name',
            'order' => 'ASC',
            'term_taxonomy_id'       => $branch,
            'hide_empty' => $hide_empty, //can be 1, '1' too

        );
        $cat_results = get_terms($get_terms_attributes);
    }
}else{
    $custom_tax = ( isset( $instance['ap_product_'.$source.''] ) && $instance['ap_product_'.$source.''] ) ? $instance['ap_product_'.$source.''] : '';
    if(empty($custom_tax) || $custom_tax == ''){
        $get_terms_attributes = array (
            'taxonomy' => $source, //empty string(''), false, 0 don't work, and return empty array
            'orderby' => 'name',
            'order' => 'ASC',
            'hide_empty' => true, //can be 1, '1' too
            'number' => 0, //can be 1, '1' too
        );
        $cat_results = get_terms($get_terms_attributes);
    } else{
        $get_terms_attributes = array (
            'taxonomy' => $source, //empty string(''), false, 0 don't work, and return empty array
            'orderby' => 'name',
            'order' => 'ASC',
            'term_ids'       => $custom_tax,
            'hide_empty' => false, //can be 1, '1' too

        );
        $cat_results = get_terms($get_terms_attributes);
    }
}
$image_gap = 'uk-grid-collapse ';
if($image_layout == 'thumbnail'){
    $image_thumb = ' uk-position-bottom ';
    $image_gap = ' ';
}
if($cat_results){
?>
<div class="ap_category_element<?php echo esc_attr($general_styles['container_cls'] . $general_styles['content_cls']);?>" <?php echo wp_kses($general_styles['animation'],'post');?>>
    <div class="uk-position-relative" data-uk-slider>
        <div class="uk-slider-container">
            <ul class="uk-slider-items tz-ap-category uk-child-width-1-<?php echo esc_attr($mobile_columns.$column_grid_gap);?> uk-child-width-1-<?php echo esc_attr($tablet_columns);?>@s
             uk-child-width-1-<?php echo esc_attr($laptop_columns);?>@m uk-child-width-1-<?php echo esc_attr($desktop_columns);?>@l uk-child-width-1-<?php echo esc_attr($large_desktop_columns);?>@xl uk-grid">
                <?php
                foreach ($cat_results as $cat){
                    $pd_label = '';
                    if($cat->count == 1 && $product_single_label !=''){
                        $pd_label = $product_single_label;
                    }else{
                        $pd_label =  $product_label;
                    }
                    if(is_object($cat)){
                    $att_id = (get_field('image','term_'.$cat->term_id));
                    ?>
                    <li>
                        <div class="uk-card uk-transition-toggle  <?php echo esc_attr($image_gap. $imgclass.$ripple_cl);  echo esc_attr('uk-card-'.$card_style.' uk-card-'.$card_size);?>">
                            <div class="uk-card-media-top">
                                <?php
                                if($att_id){
                                    ?>
                                    <div class="uk-cover-container ap-category-image">
                                        <?php if($image_cover){ ?>
                                            <a href="<?php echo esc_url(get_term_link($cat->term_id));?>">
                                                <canvas width="440" height="440"></canvas>
                                                <?php
                                                echo wp_get_attachment_image($att_id,$image_size,'',array( "data-uk-cover" => "", "class" => " $image_transition" ) );
                                                echo $ripple_html;
                                                ?>

                                            </a>
                                        <?php }else{ ?>
                                            <a href="<?php echo esc_url(get_term_link($cat->term_id));?>">
                                                <?php
                                                echo wp_get_attachment_image($att_id,$image_size,'','' );
                                                echo $ripple_html;
                                                ?>
                                            </a>
                                        <?php } ?>
                                        <?php
                                        if($image_layout == 'thumbnail'){
                                            ?>
                                            <a class="ap-thumb-cover" href="<?php echo esc_url(get_term_link($cat->term_id));?>">
                                                <div class="uk-position-cover uk-overlay"></div>
                                            </a>
                                            <?php
                                        }
                                        ?>

                                    </div>

                                    <?php
                                }
                                ?>
                            </div>
                            <div class="uk-card-body">
                                <?php
                                if($show_product_count){
                                    if($count_display=='before'){
                                        ?>
                                        <span class="ap-product-count uk-display-block ap-product-count-before">
                                    <span>
                                        <?php echo $cat->count.' '. $pd_label;?>
                                    </span>
                                </span>
                                        <?php
                                    }
                                }
                                ?>
                                <h3 class="ap-title">
                                    <a href="<?php echo esc_url(get_term_link($cat->term_id));?>">
                                        <?php echo esc_html($cat->name);?>
                                    </a>
                                    <?php
                                    if($show_product_count){
                                        if($count_display==''){
                                            ?>
                                            <span class="ap-product-count">
                                        <?php echo sprintf(__("(%s %s)", 'uipro'), $cat->count, $pd_label);?>
                                    </span>
                                            <?php
                                        }
                                    }
                                    ?>
                                </h3>
                                <?php
                                if($show_product_count){
                                    if($count_display=='after'){
                                        ?>
                                        <span class="ap-product-count uk-display-block ap-product-count-after">
                                    <span>
                                        <?php echo $cat->count.' '. $pd_label;?>
                                    </span>
                                </span>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </li>
                    <?php
                    }
                }
                ?>
            </ul>
        </div>

        <?php
        if($slider_nav){
            ?>
            <a class="uk-position-center-left-out " href="#" data-uk-slidenav-previous data-uk-slider-item="previous"></a>
            <a class="uk-position-center-right-out " href="#" data-uk-slidenav-next data-uk-slider-item="next"></a>
            <?php
        }
        if($slider_dots){
            ?>
            <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>
            <?php
        }
        ?>
    </div>
</div>
<?php
}