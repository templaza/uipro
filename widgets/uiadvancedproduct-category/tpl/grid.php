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

$slider_nav = (isset($instance['show_nav']) && $instance['show_nav']) ? intval($instance['show_nav']) : 0;
$slider_dots = (isset($instance['show_dots']) && $instance['show_dots']) ? intval($instance['show_dots']) : 0;
$image_cover = (isset($instance['image_cover']) && $instance['image_cover']) ? intval($instance['image_cover']) : 0;
$show_product_count = (isset($instance['show_product_count']) && $instance['show_product_count']) ? intval($instance['show_product_count']) : 0;
$hide_empty = (isset($instance['hide_empty']) && $instance['hide_empty']) ? ($instance['hide_empty']) : false;
$image_position = (isset($instance['image_position']) && $instance['image_position']) ? ($instance['image_position']) : 'uk-card-media-top';
if($source == 'ap_category'){
    if(empty($category) || $category == ''){
        $get_terms_attributes = array (
            'taxonomy' => 'ap_category', //empty string(''), false, 0 don't work, and return empty array
            'orderby' => 'name',
            'order' => 'ASC',
            'hide_empty' => $hide_empty, //can be 1, '1' too
        );
        $cat_results = get_terms($get_terms_attributes);
    } else{
        $cat_results = '';
    }
}else{
    $custom_tax = ( isset( $instance['ap_product_'.$source.''] ) && $instance['ap_product_'.$source.''] ) ? $instance['ap_product_'.$source.''] : '';
    if(empty($custom_tax) || $custom_tax == ''){
        $get_terms_attributes = array (
            'taxonomy' => $source, //empty string(''), false, 0 don't work, and return empty array
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
            'term_taxonomy_id'       => $custom_tax,
            'hide_empty' => $hide_empty, //can be 1, '1' too

        );
        $cat_results = get_terms($get_terms_attributes);
    }
}
if($cat_results){
?>
<div class="ap_category_element<?php echo esc_attr($general_styles['container_cls'] . $general_styles['content_cls']);?>" <?php echo wp_kses($general_styles['animation'],'post');?>>
    <div class=" tz-ap-category uk-child-width-1-<?php echo esc_attr($mobile_columns.$column_grid_gap);?> uk-child-width-1-<?php echo esc_attr($tablet_columns);?>@s
     uk-child-width-1-<?php echo esc_attr($laptop_columns);?>@m uk-child-width-1-<?php echo esc_attr($desktop_columns);?>@l uk-child-width-1-<?php echo esc_attr($large_desktop_columns);?>@xl uk-grid">
        <?php
        foreach ($cat_results as $cat){
            $att_id = (get_field('image','term_'.$cat->term_id));
            ?>
            <div>
                <div class="uk-card uk-grid-collapse<?php echo esc_attr('uk-card-'.$card_style.' uk-card-'.$card_size);?>" <?php if($image_position =='uk-card-media-left'){ echo 'data-uk-grid';}?>>
                    <?php if($image_position == 'uk-card-media-top' || $image_position == 'uk-card-media-left' ){
                        ?>
                        <div class="<?php echo esc_attr($image_position);?> <?php if($image_position =='uk-card-media-left'){ echo 'uk-width-auto';}?>">
                            <?php
                            if($att_id){
                                ?>
                                <div class="uk-cover-container ap-category-image">
                                    <?php if($image_cover){ ?>
                                        <a href="<?php echo esc_url(get_term_link($cat->term_id));?>">
                                            <canvas width="440" height="440"></canvas>
                                            <?php
                                            echo wp_get_attachment_image($att_id,$image_size,'',array( "data-uk-cover" => "" ) );
                                            ?>
                                        </a>
                                    <?php }else{ ?>
                                        <a href="<?php echo esc_url(get_term_link($cat->term_id));?>">
                                            <?php
                                            echo wp_get_attachment_image($att_id,$image_size,'','' );
                                            ?>
                                        </a>
                                    <?php } ?>
                                </div>

                                <?php
                            }
                            ?>
                        </div>
                    <?php
                    }
                    ?>

                    <div class="uk-card-body <?php if($image_position =='uk-card-media-left'){ echo 'uk-width-expand';}?>">
                        <h3 class="ap-title">
                            <a href="<?php echo esc_url(get_term_link($cat->term_id));?>">
                                <?php echo esc_html($cat->name);?>
                            </a>
                            <?php
                            if($show_product_count){
                                ?>
                                <span class="ap-product-count">
                                    <?php echo sprintf(__("(%s)", 'uipro'), $cat->count);?>
                                </span>
                                <?php
                            }
                            ?>
                        </h3>
                    </div>
                    <?php if($image_position == 'uk-card-media-bottom'){
                        ?>
                        <div class="<?php echo esc_attr($image_position);?>">
                            <?php
                            if($att_id){
                                ?>
                                <div class="uk-cover-container ap-category-image">
                                    <?php if($image_cover){ ?>
                                        <a href="<?php echo esc_url(get_term_link($cat->term_id));?>">
                                            <canvas width="440" height="440"></canvas>
                                            <?php
                                            echo wp_get_attachment_image($att_id,$image_size,'',array( "data-uk-cover" => "" ) );
                                            ?>
                                        </a>
                                    <?php }else{ ?>
                                        <a href="<?php echo esc_url(get_term_link($cat->term_id));?>">
                                            <?php
                                            echo wp_get_attachment_image($att_id,$image_size,'','' );
                                            ?>
                                        </a>
                                    <?php } ?>
                                </div>

                                <?php
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>
<?php
}