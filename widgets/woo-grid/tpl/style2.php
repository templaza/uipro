<?php
use TemPlaza_Woo_El\TemPlaza_Woo_El_Helper;
$attr = array(
    'product_source' 	=> isset($instance['product_source']) ? $instance['product_source'] : 'recent',
    'orderby'  			=> isset($instance['orderby']) ? $instance['orderby'] : '',
    'order'    			=> isset($instance['order']) ? $instance['order'] : '',
    'category'    	    => isset($instance['product_categories']) ? implode(",",$instance['product_categories']) : '',
    'tag'    	        => isset($instance['product_tags']) ? implode(",",$instance['product_tags']) : '',
    'product_brands'    => isset($instance['product_brands']) ? implode(",",$instance['product_brands']) : '',
    'limit'    			=> isset($instance['total_products']) ? $instance['total_products'] : '8',
    'large_columns'       => isset($instance['large_desktop_columns']) ? $instance['large_desktop_columns'] : '4',
    'columns'             => isset($instance['desktop_columns']) ? $instance['desktop_columns'] : '4',
    'laptop_columns'      => isset($instance['laptop_columns']) ? $instance['laptop_columns'] : '3',
    'tablet_columns'      => isset($instance['tablet_columns']) ? $instance['tablet_columns'] : '2',
    'mobile_columns'      => isset($instance['mobile_columns']) ? $instance['mobile_columns'] : '1',
    'column_gap'          => isset($instance['column_gap']) ? $instance['column_gap'] : 'default',
);

$general_styles = \UIPro_Elementor_Helper::get_general_styles($instance);
$results = TemPlaza_Woo_El_Helper::products_shortcode( $attr );
$results = ! empty($results) ? $results['ids'] : 0;
if ( ! $results ) {
    return;
}
?>
<div class="tz-woo-grid <?php echo esc_attr($general_styles['container_cls'] . $general_styles['content_cls']);?>" <?php echo wp_kses($general_styles['animation'],'post');?>>
    <div class="product-content
    uk-child-width-1-<?php echo esc_attr($instance['mobile_columns']);?>
    uk-child-width-1-<?php echo esc_attr($instance['tablet_columns']);?>@s
    uk-child-width-1-<?php echo esc_attr($instance['laptop_columns']);?>@m
    uk-child-width-1-<?php echo esc_attr($instance['desktop_columns']);?>@l
    uk-child-width-1-<?php echo esc_attr($instance['large_desktop_columns']);?>@xl
    uk-grid-<?php echo esc_attr($instance['column_gap']);?>"
    data-uk-grid>
    <?php
    foreach ( $results as $product_id ) {
        $GLOBALS['post'] = get_post( $product_id );
        setup_postdata( $GLOBALS['post'] );
        global $product;
        $image_ids = $product->get_gallery_image_ids();
        ?>
        <div <?php wc_product_class( 'woo-grid-style2', $product ); ?>>
            <div class="product-inner uk-inline">
                <div class="uk-card  uk-grid-collapse uk-flex uk-flex-middle uk-child-width-1-2 " data-uk-grid>
                    <div class="uk-card-media-left uk-width-auto image-box-style2">
                        <?php
                        if ( ! empty( $image_ids ) ) {
                            echo '<div class="product-thumbnail">';
                            echo '<div class="product-thumbnails-hover">';
                        } else {
                            echo '<div class="product-thumbnail">';
                        }
                        ?>
                        <a href="<?php echo esc_url(get_permalink( $product_id ));?>">
                            <?php
                            if(isset($instance['image_size_custom']) &&  $instance['image_size_custom'] == 'custom'){
                                $image_size = isset($instance['thumbnail_size']) ? $instance['thumbnail_size'] : 'woocommerce_thumbnail';
                            }else{
                                $image_size = apply_filters( 'single_product_archive_thumbnail_size', 'woocommerce_thumbnail' );
                            }
                            echo woocommerce_get_product_thumbnail($image_size);
                            if ( ! empty( $image_ids ) ) {
                                echo wp_get_attachment_image( $image_ids[0], $image_size, false, array( 'class' => 'attachment-woocommerce_thumbnail size-woocommerce_thumbnail hover-image' ) );
                            }
                            ?>
                        </a>
                        <?php
                        if ( ! empty( $image_ids ) ) {
                            echo '</div>';
                        }
                        echo '</div>';
                        ?>
                    </div>
                    <div class="uk-width-expand">
                        <div class="woo-info-style2">
                            <div class="tz-product-title">
                                <h2 class="product-title woocommerce-loop-product__title">
                                    <?php the_title(); ?>
                                </h2>
                            </div>
                            <div class="product-rating">
                                <?php woocommerce_template_loop_rating(); ?>
                            </div>
                            <div class="tz-product-price">
                                <?php
                                woocommerce_template_loop_price();
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
    }
    wp_reset_postdata();
    wc_reset_loop();
    ?>
    </div>
</div>