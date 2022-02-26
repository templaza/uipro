<?php
use TemPlaza_Woo_El\TemPlaza_Woo_El_Helper;

$categories = isset($instance['product_categories']) ? $instance['product_categories'] : array();
if(empty($categories)){
    $categories = array();
    $categories_all = get_terms('product_cat');
    foreach ($categories_all as $item){
        $categories[]= $item->slug;
    }
}

$general_styles = \UIPro_Elementor_Helper::get_general_styles($instance);
?>
<div class=" <?php echo esc_attr($general_styles['container_cls'] . $general_styles['content_cls']);?>" <?php echo wp_kses($general_styles['animation'],'post');?>>
    <div class="categories-wrap
    uk-child-width-1-<?php echo esc_attr($instance['mobile_columns']);?>
    uk-child-width-1-<?php echo esc_attr($instance['tablet_columns']);?>@s
    uk-child-width-1-<?php echo esc_attr($instance['laptop_columns']);?>@m
    uk-child-width-1-<?php echo esc_attr($instance['desktop_columns']);?>@l
    uk-child-width-1-<?php echo esc_attr($instance['large_desktop_columns']);?>@xl
    uk-grid-<?php echo esc_attr($instance['column_gap']);?>"
         data-uk-grid>
        <?php
            if($categories){
                foreach ($categories as $cat){
                    $term = get_term_by( 'slug', $cat, 'product_cat' );
                    $term_url = get_term_link($cat, 'product_cat');
                    $thumbnail_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
                    // get the image URL
                    $image = wp_get_attachment_url( $thumbnail_id );
                    ?>
                    <div class="woo-cat-item-wrap">
                        <div class="woo-cat-item">
                            <?php if($thumbnail_id) { ?>
                            <a href="<?php echo esc_url($term_url);?>">
                                <img src="<?php echo esc_url($image);?>" alt="<?php echo esc_attr($term->name);?>"/>
                            </a>
                            <?php } ?>
                            <h3 class="woo-cat-title">
                                <a href="<?php echo esc_url($term_url);?>">
                                    <?php echo esc_html($term->name);?>
                                </a>
                            </h3>
                        </div>
                    </div>
                    <?php
                }
            }
        ?>

    </div>
</div>