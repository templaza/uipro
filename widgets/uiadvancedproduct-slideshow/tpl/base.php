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
    'columns'    		=> isset($instance['desktop_columns']) ? $instance['desktop_columns'] : '4',
);

$general_styles = \UIPro_Elementor_Helper::get_general_styles($instance);
$results = TemPlaza_Woo_El_Helper::products_shortcode( $attr );
$results = ! empty($results) ? $results['ids'] : 0;
if ( ! $results ) {
    return;
}
?>
<div class=" <?php echo esc_attr($general_styles['container_cls'] . $general_styles['content_cls']);?>" <?php echo wp_kses($general_styles['animation'],'post');?>>
    <div class="product-content">
    <?php
    wc_setup_loop(
        array(
            'large_columns'       => isset($instance['large_desktop_columns']) ? $instance['large_desktop_columns'] : '4',
            'columns'             => isset($instance['desktop_columns']) ? $instance['desktop_columns'] : '4',
            'laptop_columns'      => isset($instance['laptop_columns']) ? $instance['laptop_columns'] : '3',
            'tablet_columns'      => isset($instance['tablet_columns']) ? $instance['tablet_columns'] : '2',
            'mobile_columns'      => isset($instance['mobile_columns']) ? $instance['mobile_columns'] : '1',
            'column_gap'          => isset($instance['column_gap']) ? $instance['column_gap'] : 'default',
        )
    );
    TemPlaza_Woo_El_Helper::get_template_loop( $results );
    ?>
    </div>
</div>