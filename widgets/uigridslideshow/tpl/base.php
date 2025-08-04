<?php

$_is_elementor      = (isset($args['page_builder']) && $args['page_builder'] == 'elementor')?true:false;

$general_styles     =   \UIPro_Elementor_Helper::get_general_styles($instance);

$large_desktop_columns    = ( isset( $instance['large_desktop_columns'] ) && $instance['large_desktop_columns'] ) ? $instance['large_desktop_columns'] : '4';
$desktop_columns    = ( isset( $instance['desktop_columns'] ) && $instance['desktop_columns'] ) ? $instance['desktop_columns'] : '4';
$laptop_columns     = ( isset( $instance['laptop_columns'] ) && $instance['laptop_columns'] ) ? $instance['laptop_columns'] : '2';
$tablet_columns     = ( isset( $instance['tablet_columns'] ) && $instance['tablet_columns'] ) ? $instance['tablet_columns'] : '2';
$mobile_columns     = ( isset( $instance['mobile_columns'] ) && $instance['mobile_columns'] ) ? $instance['mobile_columns'] : '1';

echo '<div class="ui-grid-slider'. $general_styles['container_cls'] . $general_styles['content_cls'] .'"' . $general_styles['animation'] . '>';
?>
<div class="uigrid-slideshow uk-grid-collapse  uk-child-width-1-<?php echo $large_desktop_columns;?>@xl
 uk-child-width-1-<?php echo $desktop_columns;?>@l uk-child-width-1-<?php echo $laptop_columns;?>@m
  uk-child-width-1-<?php echo $tablet_columns;?>@s uk-child-width-1-<?php echo $mobile_columns;?> " data-uk-grid style="background-image:url(<?php echo esc_url($instance['uislideshow_items'][0]['image']['url']);?>)">
    <?php
if ( isset( $instance['uislideshow_items'] ) && count( (array) $instance['uislideshow_items'] ) ) {
    foreach ($instance['uislideshow_items'] as $key => $value) {

        $media_item = ( isset( $value['image'] ) && $value['image'] ) ? $value['image'] : '';
        $image_src  = isset( $media_item['url'] ) ? $media_item['url'] : '';

        $item_title      = ( isset( $value['title'] ) && $value['title'] ) ? $value['title'] : '';
        $item_meta       = ( isset( $value['meta'] ) && $value['meta'] ) ? $value['meta'] : '';
        ?>
            <div>
                <div class="uigrid-slideshow-item uk-height-1-1 uk-flex uk-flex-bottom" data-bg="<?php echo esc_url($image_src);?>">
                    <div class="uigrid-slideshow-content">
                        <span class="uigrid-meta"><?php echo $item_meta;?></span>
                        <h3 class="uigrid-title"><?php echo $item_title;?> </h3>
                    </div>
                </div>
            </div>

        <?php
    }
}
    ?>
</div>
<?php
echo '</div>';