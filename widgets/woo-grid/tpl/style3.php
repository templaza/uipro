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
    <ul class="product-content products
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
        <li <?php wc_product_class( '', $product ); ?>>
            <div class="product-inner uk-inline">
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
                ?>
                <div class="product-loop__buttons tz-product-cart">
                    <?php
                    woocommerce_template_loop_add_to_cart();

                    if ( shortcode_exists( 'yith_wcwl_add_to_wishlist' ) ) {
                        echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
                    }
                    echo sprintf(
                        '<a href="%s" class="quick-view-button tz-loop-button" data-target="quick-view-modal" data-toggle="modal" data-id="%d" data-text="%s">
				%s<span class="quick-view-text loop_button-text">%s</span>
			</a>',
                        is_customize_preview() ? '#' : esc_url( get_permalink() ),
                        esc_attr( $product->get_id() ),
                        esc_attr__( 'Quick View', 'agruco' ),
                        '<i class="fas fa-eye"></i>',
                        esc_html__( 'Quick View', 'agruco' )
                    );
                    ?>
                </div>
                <?php
                echo '</div>';
                ?>
                <div class="product-summary product-info">
                    <div class="product-rating">
                    <?php woocommerce_template_loop_rating(); ?>
                    </div>
                    <?php
                    $taxonomy = empty($taxonomy) ? 'product_cat' : $taxonomy;
                    $terms = get_the_terms( $product->get_id(), $taxonomy );

                    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {

                        echo sprintf(
                            '<a class="meta-cat uk-display-block" href="%s">%s</a>',
                            esc_url( get_term_link( $terms[0] ), $taxonomy ),
                            esc_html( $terms[0]->name ) );
                    }
                    ?>
                    <h2 class="woocommerce-loop-product__title">
                        <a href="<?php the_permalink();?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
                            <?php the_title(); ?>
                        </a>
                    </h2>
                    <div class="tz-product-price">
                    <?php
                    woocommerce_template_loop_price();
                    ?>
                    </div>

                </div>
            </div>
        </li>

        <?php
    }
    wp_reset_postdata();
    wc_reset_loop();
    ?>
    </ul>
</div>