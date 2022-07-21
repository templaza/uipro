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
$category   = ( isset( $instance['ap_category'] ) && $instance['ap_category'] ) ? $instance['ap_category'] : '';

$card_style    = ( isset( $instance['card_style'] ) && $instance['card_style'] ) ? $instance['card_style'] : '';
$card_size    = ( isset( $instance['card_size'] ) && $instance['card_size'] ) ? $instance['card_size'] : '';

$large_desktop_columns    = ( isset( $instance['large_desktop_columns'] ) && $instance['large_desktop_columns'] ) ? $instance['large_desktop_columns'] : '4';
$desktop_columns    = ( isset( $instance['desktop_columns'] ) && $instance['desktop_columns'] ) ? $instance['desktop_columns'] : '4';
$laptop_columns     = ( isset( $instance['laptop_columns'] ) && $instance['laptop_columns'] ) ? $instance['laptop_columns'] : '3';
$tablet_columns     = ( isset( $instance['tablet_columns'] ) && $instance['tablet_columns'] ) ? $instance['tablet_columns'] : '2';
$mobile_columns     = ( isset( $instance['mobile_columns'] ) && $instance['mobile_columns'] ) ? $instance['mobile_columns'] : '1';
$column_grid_gap    = ( isset( $instance['column_grid_gap'] ) && $instance['column_grid_gap'] ) ? ' uk-grid-'. $instance['column_grid_gap'] : '';

$slider_nav = (isset($instance['show_nav']) && $instance['show_nav']) ? intval($instance['show_nav']) : 0;
$slider_dots = (isset($instance['show_dots']) && $instance['show_dots']) ? intval($instance['show_dots']) : 0;

if($source = 'ap_category'){
    if(empty($category) || $category == ''){
        $get_terms_attributes = array (
            'taxonomy' => 'ap_category', //empty string(''), false, 0 don't work, and return empty array
            'orderby' => 'name',
            'order' => 'ASC',
            'hide_empty' => true, //can be 1, '1' too
        );
        $cat_results = get_terms($get_terms_attributes);
    } else{
        $cat_results = $category;
    }
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
                    $att_id = (get_field('image','term_'.$cat->term_id));
                    ?>
                    <li>
                        <div class="uk-card <?php echo esc_attr('uk-card-'.$card_style.' uk-card-'.$card_size);?>">
                            <div class="uk-card-media-top">
                                <?php
                                if($att_id){
                                    ?>
                                    <div class="uk-cover-container ap-category-image">
                                        <a href="<?php echo esc_url(get_term_link($cat->term_id));?>">
                                            <canvas width="440" height="440"></canvas>
                                            <?php
                                            echo wp_get_attachment_image($att_id,$image_size,'',array( "data-uk-cover" => "" ) );
                                            ?>
                                        </a>
                                    </div>

                                    <?php
                                }
                                ?>
                            </div>
                            <div class="uk-card-body">
                                <h3 class="ap-title">
                                    <a href="<?php echo esc_url(get_term_link($cat->term_id));?>">
                                        <?php echo esc_html($cat->name);?>
                                    </a>
                                </h3>
                            </div>
                        </div>
                    </li>
                    <?php
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