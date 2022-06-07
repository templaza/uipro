<?php
//Get posts
use Advanced_Product\Helper\AP_Custom_Field_Helper;
$general_styles = \UIPro_Elementor_Helper::get_general_styles($instance);
$limit      = ( isset( $instance['limit'] ) && $instance['limit'] ) ? $instance['limit'] : 4;
//$resource       = ( isset( $instance['resource'] ) && $instance['resource'] ) ? $instance['resource'] : 'post';
$resource   = 'ap_product';
$ap_product_source   = ( isset( $instance['ap_product_source'] ) && $instance['ap_product_source'] ) ? $instance['ap_product_source'] : '';
$ordering   = ( isset( $instance['ordering'] ) && $instance['ordering'] ) ? $instance['ordering'] : 'latest';
$branch     = ( isset( $instance[$resource.'_branch'] ) && $instance[$resource.'_branch'] ) ? $instance[$resource.'_branch'] : array('0');
$category   = ( isset( $instance[$resource.'_category'] ) && $instance[$resource.'_category'] ) ? $instance[$resource.'_category'] : array('0');

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
    $slide_option .='animation: '.$instance['slideshow_transition'].'';
}
$custom_fields   = isset($instance['custom_fields']) ? $instance['custom_fields'] : array();
if($products){
    ?>
<div class="ap_slideshow uk-slider <?php echo esc_attr($general_styles['container_cls'] . $general_styles['content_cls']);?>" <?php echo wp_kses($general_styles['animation'],'post');?>>
    <div class="ap_tiny_slideshow_wrap">
        <?php
        foreach ($products as $item) {
            if ($post = get_page_by_path($item['ap_products'], OBJECT, 'ap_product')){
                $product_id = $post->ID;
            }
            if( $product_id ) {
                ?>
                <div class="ap_slideshow-tiny-item">
                    <div class="ap_slideshow-item uk-flex uk-flex-middle" data-uk-grid>
                        <div class="ap-slideshow-image uk-flex-last@m uk-width-1-2@m">
                            <?php
                            if($item['image']['id'] ==''){
                                echo get_the_post_thumbnail($product_id,'full');
                            }else{
                                ?>
                                <img src="<?php echo esc_url($item['image']['url']);?>" alt="<?php echo esc_attr(get_the_title($product_id)); ?>"/>
                            <?php } ?>
                        </div>
                        <div class="ap-slideshow-info uk-width-1-2@m">
                            <h3 class="ap-slideshow-title">
                                <?php echo esc_html(get_the_title($product_id)); ?>
                            </h3>
                            <div class="uk-flex uk-flex-between ap-single-top-fields">
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
                            <div class="ap-single-desc">
                                <?php
                                if($item['ap_description']){
                                    echo $item['ap_description'];
                                }else{
                                    echo get_the_excerpt($product_id);
                                }
                                ?>
                            </div>
                            <?php if($instance['button_text']){
                                ?>
                                <div class="ap-slideshow-readmore uk-flex">
                                    <a class="ui-button" href="<?php echo esc_url(get_permalink($product_id));?>">
                                        <?php echo esc_html($instance['button_text']);?>
                                    </a>
                                </div>
                            <?php
                            }
                            ?>
                            <div class="ap-custom-text">
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
                    </div>
                </div>
            <?php
            }
        }
        ?>
    </div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function(){
        var slider = tns({
            container: '.ap_tiny_slideshow_wrap',
            items: 1,
            mode: 'gallery',
            animateIn: 'tns-fadeIn',
            animateOut: 'tns-fadeOut',
            speed: 1000,
            mouseDrag: true,
            slideBy: 'page',
            center: true,
            loop: false,
            nav:false,
            controlsText:["<span data-uk-icon='icon:chevron-left; ratio:1.2'></span>", "<span data-uk-icon='icon:chevron-right; ratio:1.2'></span>"],
        });
    })
</script>
<?php
}