<?php
use TemPlaza_Woo_El\TemPlaza_Woo_El_Helper;
use TemPlazaFramework\Functions;
$attr = array(
    'product_source' 	=> isset($instance['product_source']) ? $instance['product_source'] : 'recent',
    'orderby'  			=> isset($instance['orderby']) ? $instance['orderby'] : '',
    'order'    			=> isset($instance['order']) ? $instance['order'] : '',
    'category'    	    => isset($instance['product_categories']) ? implode(",",$instance['product_categories']) : '',
    'tag'    	        => isset($instance['product_tags']) ? implode(",",$instance['product_tags']) : '',
    'product_brands'    => isset($instance['product_brands']) ? implode(",",$instance['product_brands']) : '',
    'limit'    			=> isset($instance['total_products']) ? $instance['total_products'] : '8',
    'columns'    		=> isset($instance['desktop_columns']) ? $instance['desktop_columns'] : '4',
    'product_loop'    	=> isset($instance['product_loop']) ? $instance['product_loop'] : 'layout-1',
);
$general_styles     =   \UIPro_Elementor_Helper::get_general_styles($instance);
if($instance['product_loop_hover']=='zoom'){
    wp_enqueue_script('zoom');
}
$results = TemPlaza_Woo_El_Helper::products_shortcode( $attr );
$results = ! empty($results) ? $results['ids'] : 0;
if ( ! $results ) {
    return;
}
$elementid = uniqid('templaza_');
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
add_filter('woocommerce_get_star_rating_html', array(
    TemPlaza_Woo_El\TemPlaza_Woo_El_Helper::get_instance(),
    'star_rating_html'
), 5,3);
add_filter( 'woocommerce_loop_add_to_cart_link', array(
    TemPlaza_Woo_El\TemPlaza_Woo_El_Helper::get_instance(),
    'add_to_cart_link'
), 15, 3 );

?>
<div class=" <?php echo esc_attr($general_styles['container_cls'] . $general_styles['content_cls']);?>" <?php echo wp_kses($general_styles['animation'],'post');?>>
    <div class="product-content">
    <?php
    update_meta_cache( 'post', $results );
    update_object_term_cache( $results, 'product' );

    $original_post = $GLOBALS['post'];
    if ( !class_exists( 'TemPlazaFramework\TemPlazaFramework' )){
        $templaza_options = array();
    }else{
        $templaza_options = Functions::get_theme_options();
    }

    $classes = array(
        'products'
    );
    $featured_icons       = isset($templaza_options['templaza-shop-loop-featured-icons'])?$templaza_options['templaza-shop-loop-featured-icons']:'';
    $featured_icons = apply_filters( 'templaza_get_product_loop_featured_icons', $featured_icons );

    $attributes = isset($templaza_options['templaza-shop-loop-attributes'])?$templaza_options['templaza-shop-loop-attributes']:'';
    $loop_desc     = isset($templaza_options['templaza-shop-loop-description'])?filter_var($templaza_options['templaza-shop-loop-description'], FILTER_VALIDATE_BOOLEAN):true;
    $loop_variation     = isset($templaza_options['templaza-shop-loop-variation'])?filter_var($templaza_options['templaza-shop-loop-variation'], FILTER_VALIDATE_BOOLEAN):true;
    $loop_variation_ajax     = isset($templaza_options['templaza-shop-loop-variation-ajax'])?filter_var($templaza_options['templaza-shop-loop-variation-ajax'], FILTER_VALIDATE_BOOLEAN):true;
    $loop_layout = isset($instance['product_loop']) ? $instance['product_loop'] : 'layout-1';
    switch ($loop_layout) {

        // Icons & Quick view button
        case 'layout-2':
            add_action('templaza_product_loop_thumbnail_element_'.$loop_layout, array(
                TemPlaza_Woo_El\TemPlaza_Woo_El_Helper::get_instance(),
                'product_loop_buttons_open'
            ), 5);
            if (!empty($featured_icons) && $featured_icons['wishlist'] == '1') {
                add_action('templaza_product_loop_thumbnail_element_'.$loop_layout, array(
                    TemPlaza_Woo_El\TemPlaza_Woo_El_Helper::get_instance(),
                    'templaza_wishlist_button'
                ), 10);
            }
            if (!empty($featured_icons) && $featured_icons['cart'] == '1') {
                if(function_exists('woocommerce_template_loop_add_to_cart')) {
                    add_action('templaza_product_loop_thumbnail_element_'.$loop_layout, 'woocommerce_template_loop_add_to_cart', 20);
                }
            }

            add_action('templaza_product_loop_thumbnail_element_'.$loop_layout, array(
                TemPlaza_Woo_El\TemPlaza_Woo_El_Helper::get_instance(),
                'product_loop_buttons_close'
            ), 20);

            if (!empty($featured_icons) && $featured_icons['quickview'] == '1') {
                add_action('templaza_product_loop_thumbnail_element_'.$loop_layout, array(
                    TemPlaza_Woo_El\TemPlaza_Woo_El_Helper::get_instance(),
                    'templaza_quick_view_button'
                ), 100);
            }

            if (intval(get_option('mobile_product_loop_atc')) && function_exists('woocommerce_template_loop_add_to_cart')) {
                add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 50);
            }

            break;
        // Icons over thumbnail on hover
        case 'layout-3':
            add_action('templaza_product_loop_thumbnail_element_'.$loop_layout, array(
                TemPlaza_Woo_El\TemPlaza_Woo_El_Helper::get_instance(),
                'product_loop_buttons_open'
            ), 10);
            if (!empty($featured_icons) && $featured_icons['wishlist'] == '1') {
                add_action('templaza_product_loop_thumbnail_element_'.$loop_layout, array(
                    TemPlaza_Woo_El\TemPlaza_Woo_El_Helper::get_instance(),
                    'templaza_wishlist_button'
                ), 10);
            }
            if (!empty($featured_icons) && $featured_icons['quickview'] == '1') {
                add_action('templaza_product_loop_thumbnail_element_'.$loop_layout, array(
                    TemPlaza_Woo_El\TemPlaza_Woo_El_Helper::get_instance(),
                    'templaza_quick_view_button'
                ), 10);
            }
            add_action('templaza_product_loop_thumbnail_element_'.$loop_layout, array(
                TemPlaza_Woo_El\TemPlaza_Woo_El_Helper::get_instance(),
                'product_loop_buttons_close'
            ), 15);

            if (!empty($featured_icons) && $featured_icons['cart']=='1' && function_exists('woocommerce_template_loop_add_to_cart') ) {
                add_action( 'templaza_product_loop_thumbnail_element_'.$loop_layout, 'woocommerce_template_loop_add_to_cart', 110 );
                add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 50 );

            }

            break;
        // Icons on the bottom
        case 'layout-4':

            break;
        // Simple
        case 'layout-5':
            break;
        // Standard button
        case 'layout-6':
            add_action('templaza_product_loop_thumbnail_element_'.$loop_layout, array(
                TemPlaza_Woo_El\TemPlaza_Woo_El_Helper::get_instance(),
                'product_loop_buttons_open'
            ), 10);
            if (!empty($featured_icons) && $featured_icons['quickview'] == '1') {
                add_action('templaza_product_loop_thumbnail_element_'.$loop_layout, array(
                    TemPlaza_Woo_El\TemPlaza_Woo_El_Helper::get_instance(),
                    'templaza_quick_view_button'
                ), 15);
            }
            if (!empty($featured_icons) && $featured_icons['wishlist'] == '1') {
                add_action('templaza_product_loop_thumbnail_element_'.$loop_layout, array(
                    TemPlaza_Woo_El\TemPlaza_Woo_El_Helper::get_instance(),
                    'templaza_wishlist_button'
                ), 20);
            }
            add_action('templaza_product_loop_thumbnail_element_'.$loop_layout, array(
                TemPlaza_Woo_El\TemPlaza_Woo_El_Helper::get_instance(),
                'product_loop_buttons_close'
            ), 25);
            if (!empty($featured_icons) && $featured_icons['cart']=='1' ) {
                if(function_exists('woocommerce_template_loop_add_to_cart')) {
                    add_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 20);
                }
            }
            if ( $loop_desc ) {
                add_action( 'woocommerce_after_shop_loop_item_title', array(
                    TemPlaza_Woo_El\TemPlaza_Woo_El_Helper::get_instance(),
                    'product_loop_desc'
                ), 30 );
            }

            break;

        // Info on hover
        case 'layout-7':

            if (intval(get_option('mobile_product_loop_atc'))) {
                add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 50);
            }
            break;

        // Icons over thumbnail on hover
        default:
            add_action('templaza_product_loop_thumbnail_element_'.$loop_layout, array(
                TemPlaza_Woo_El\TemPlaza_Woo_El_Helper::get_instance(),
                'product_loop_buttons_open'
            ), 5);

            if (!empty($featured_icons) && $featured_icons['cart'] == '1') {
                if (function_exists('woocommerce_template_loop_add_to_cart')) {
                    add_action('templaza_product_loop_thumbnail_element_'.$loop_layout, 'woocommerce_template_loop_add_to_cart', 10);
                }
            }

            if (!empty($featured_icons) && $featured_icons['quickview'] == '1') {
                add_action('templaza_product_loop_thumbnail_element_'.$loop_layout, array(
                    TemPlaza_Woo_El\TemPlaza_Woo_El_Helper::get_instance(),
                    'templaza_quick_view_button'
                ), 10);
            }
            if (!empty($featured_icons) && $featured_icons['wishlist'] == '1') {
                add_action('templaza_product_loop_thumbnail_element_'.$loop_layout, array(
                    TemPlaza_Woo_El\TemPlaza_Woo_El_Helper::get_instance(),
                    'templaza_wishlist_button'
                ), 10);
            }
            add_action('templaza_product_loop_thumbnail_element_'.$loop_layout, array(
                TemPlaza_Woo_El\TemPlaza_Woo_El_Helper::get_instance(),
                'product_loop_buttons_close'
            ), 100);

            if (intval(get_option('mobile_product_loop_atc'))) {
                if (function_exists('woocommerce_template_loop_add_to_cart')) {
                    add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 50);
                }
            }

            break;
    }

    $class_layout = $loop_layout == 'layout-3' ? 'layout-2' : $loop_layout;

    $classes[] = 'product-loop-' . $class_layout;

    if ( $loop_layout == 'layout-3' ) {
        $classes[] = 'product-loop-layout-3';
    }

    $classes[] = $loop_layout == 'layout-3' ? 'has-quick-view' : '';

    $classes[] = in_array( $loop_layout, array( 'layout-2', 'layout-3', 'layout-4', 'layout-5', 'layout-6', 'layout-7' ) ) ? 'product-loop-center' : '';

    if ( in_array( $loop_layout, array( 'layout-2', 'layout-3', 'layout-9' ) ) ) {
        $loop_wishlist           = isset($templaza_options['templaza-shop-loop-wishlist'])?filter_var($templaza_options['templaza-shop-loop-wishlist'], FILTER_VALIDATE_BOOLEAN):true;
        if($loop_wishlist){
            $classes[] = 'show-wishlist';
        }else{
            $classes[] = ' ';
        }
    }

    if ( in_array( $loop_layout, array( 'layout-8', 'layout-9' ) ) ) {
        $loop_variation           = isset($templaza_options['templaza-shop-loop-variation'])?filter_var($templaza_options['templaza-shop-loop-variation'], FILTER_VALIDATE_BOOLEAN):true;
        if($loop_variation){
            $classes[] = 'has-variations-form';
        }else{
            $classes[] = ' ';
        }
    }
    $shop_col_tablet       = isset($templaza_options['templaza-shop-column-tablet'])?$templaza_options['templaza-shop-column-tablet']:2;
    $shop_col_mobile       = isset($templaza_options['templaza-shop-column-mobile'])?$templaza_options['templaza-shop-column-mobile']:1;
    $shop_col_gap          = isset($templaza_options['templaza-shop-column-gap'])?$templaza_options['templaza-shop-column-gap']:'';


        $product_columns = isset($instance['desktop_columns']) ? $instance['desktop_columns'] : '4';
        $product_columns_large = isset($instance['large_desktop_columns']) ? $instance['large_desktop_columns'] : '4';
        $product_columns_laptop = isset($instance['laptop_columns']) ? $instance['laptop_columns'] : '3';
        $product_columns_tablet = isset($instance['tablet_columns']) ? $instance['tablet_columns'] : '2';
        $product_columns_mobile = isset($instance['mobile_columns']) ? $instance['mobile_columns'] : '1';
        $product_gap = isset($instance['column_gap']) ? $instance['column_gap'] : 'default';


    $classes[] = 'columns-' . $product_columns;
    $classes[] = 'uk-child-width-1-' .$product_columns.'@l';
    $classes[] = 'uk-child-width-1-' .$product_columns_large.'@xl';
    $classes[] = 'uk-child-width-1-' .$product_columns_laptop.'@m';
    $classes[] = 'uk-child-width-1-' .$product_columns_tablet.'@s';
    $classes[] = 'uk-child-width-1-' .$product_columns_mobile.'';
    $classes[] = 'uk-grid-' . $product_gap.'';

    if ( $mobile_pl_col = intval( get_option( 'mobile_landscape_product_columns' ) ) ) {
        $classes[] = 'mobile-pl-col-' . $mobile_pl_col;
    }

    if ( $mobile_pp_col = intval( get_option( 'mobile_portrait_product_columns' ) ) ) {
        $classes[] = 'mobile-pp-col-' . $mobile_pp_col;
    }

    if ( intval( get_option( 'mobile_product_loop_atc' ) )
        || in_array( $loop_layout, array(
            'layout-3',
            'layout-6',
            'layout-8',
        ) ) ) {
        $classes[] = 'mobile-show-atc';
    }

    if ( intval( get_option( 'mobile_product_featured_icons' ) ) ) {
        $classes[] = 'mobile-show-featured-icons';
    }

    echo '<ul  class=" uk-grid-'.esc_attr($shop_col_gap).' ' . esc_attr( implode( ' ', $classes ) ) . '" data-uk-grid> ';
    foreach ( $results as $product_id ) {
        $GLOBALS['post'] = get_post( $product_id );
        setup_postdata( $GLOBALS['post'] );
        global $product;

        // Ensure visibility.
        if ( empty( $product ) || ! $product->is_visible() ) {
            return;
        }
        ?>
        <li <?php wc_product_class( '', $product ); ?>>
            <div class="product-inner">
                <?php
                $loop_hover = isset($instance['product_loop_hover']) ? $instance['product_loop_hover'] : 'classic';
                $product_hover = $loop_layout == 'layout-7' ? 'classic' : $loop_hover;
                $product_hover = apply_filters( 'templaza_get_product_loop_hover', $product_hover );

                switch ( $product_hover ) {
                    case 'slider':
                        $image_ids  = $product->get_gallery_image_ids();
                        $image_size = apply_filters( 'single_product_archive_thumbnail_size', 'woocommerce_thumbnail' );

                        if ( $image_ids ) {
                            echo '<div id="'.esc_attr($elementid).'" class="product-thumbnail product-thumbnails--slider swiper-container">';
                            echo '<div class="swiper-wrapper">';
                        } else {
                            echo '<div class="product-thumbnail">';
                        }

                        woocommerce_template_loop_product_link_open();
                        woocommerce_template_loop_product_thumbnail();
                        woocommerce_template_loop_product_link_close();

                        foreach ( $image_ids as $image_id ) {
                            $src = wp_get_attachment_image_src( $image_id, $image_size );

                            if ( ! $src ) {
                                continue;
                            }

                            woocommerce_template_loop_product_link_open();

                            printf(
                                '<img data-src="%s" width="%s" height="%s" alt="%s" class="swiper-lazy">',
                                esc_url( $src[0] ),
                                esc_attr( $src[1] ),
                                esc_attr( $src[2] ),
                                esc_attr( $product->get_title() )
                            );

                            woocommerce_template_loop_product_link_close();
                        }
                        if ( $image_ids ) {
                            echo '</div>';
                            echo '<span class="templaza-product-loop-swiper-prev templaza-swiper-button"><i class="fas fa-chevron-left"></i></span>';
                            echo '<span class="templaza-product-loop-swiper-next templaza-swiper-button"><i class="fas fa-chevron-right"></i></span>';
                        }
                        do_action( 'templaza_product_loop_thumbnail_element_'.$loop_layout );
                        echo '</div>';
                        break;
                    case 'fadein':
                        $image_ids = $product->get_gallery_image_ids();

                        if ( ! empty( $image_ids ) ) {
                            echo '<div class="product-thumbnail">';
                            echo '<div class="product-thumbnails--hover">';
                        } else {
                            echo '<div class="product-thumbnail">';
                        }

                        woocommerce_template_loop_product_link_open();
                        woocommerce_template_loop_product_thumbnail();

                        if ( ! empty( $image_ids ) ) {
                            $image_size = apply_filters( 'single_product_archive_thumbnail_size', 'woocommerce_thumbnail' );
                            echo wp_get_attachment_image( $image_ids[0], $image_size, false, array( 'class' => 'attachment-woocommerce_thumbnail size-woocommerce_thumbnail hover-image' ) );
                        }

                        woocommerce_template_loop_product_link_close();
                        if ( ! empty( $image_ids ) ) {
                            echo '</div>';
                        }
                        do_action( 'templaza_product_loop_thumbnail_element_'.$loop_layout );
                        echo '</div>';
                        break;
                    case 'zoom';
                        echo '<div class="product-thumbnail">';
                        $image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );

                        if ( $image ) {
                            $link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );
                            echo '<a href="' . esc_url( $link ) . '" class="woocommerce-LoopProduct-link product-thumbnail-zoom" data-zoom_image="' . esc_attr( $image[0] ) . '">';
                        } else {
                            woocommerce_template_loop_product_link_open();
                        }
                        woocommerce_template_loop_product_thumbnail();
                        woocommerce_template_loop_product_link_close();
                        do_action( 'templaza_product_loop_thumbnail_element_'.$loop_layout );
                        echo '</div>';
                        break;
                    default:
                        echo '<div class="product-thumbnail">';
                        woocommerce_template_loop_product_link_open();
                        woocommerce_template_loop_product_thumbnail();
                        woocommerce_template_loop_product_link_close();
                        do_action( 'templaza_product_loop_thumbnail_element_'.$loop_layout );
                        echo '</div>';
                        break;
                }
                ?>
                <div class="product-summary">
                    <?php
                    switch ( $loop_layout ) {
                        case 'layout-2':
                            TemPlaza_Woo_El\TemPlaza_Woo_El_Helper::templaza_product_taxonomy();
                            echo '<h2 class="woocommerce-loop-product__title">';
                            woocommerce_template_loop_product_link_open();
                            the_title();
                            woocommerce_template_loop_product_link_close();
                            echo '</h2>';
                            woocommerce_template_loop_price();
                            woocommerce_template_loop_rating();
                            break;
                        case 'layout-3':
                            TemPlaza_Woo_El\TemPlaza_Woo_El_Helper::templaza_product_taxonomy();
                            echo '<h2 class="woocommerce-loop-product__title">';
                            woocommerce_template_loop_product_link_open();
                            the_title();
                            woocommerce_template_loop_product_link_close();
                            echo '</h2>';
                            woocommerce_template_loop_rating();
                            woocommerce_template_loop_price();
                            break;
                        case 'layout-4';
                            TemPlaza_Woo_El\TemPlaza_Woo_El_Helper::templaza_product_taxonomy();
                            echo '<h2 class="woocommerce-loop-product__title">';
                            woocommerce_template_loop_product_link_open();
                            the_title();
                            woocommerce_template_loop_product_link_close();
                            echo '</h2>';
                            woocommerce_template_loop_price();
                            woocommerce_template_loop_rating();
                            echo '<div class="product-loop__buttons">';
                            if (!empty($featured_icons) && $featured_icons['cart'] == '1') {
                                woocommerce_template_loop_add_to_cart();
                            }
                            if (!empty($featured_icons) && $featured_icons['quickview'] == '1') {
                                    TemPlaza_Woo_El\TemPlaza_Woo_El_Helper::templaza_quick_view_button();
                            }
                            if (!empty($featured_icons) && $featured_icons['wishlist'] == '1') {
                                TemPlaza_Woo_El\TemPlaza_Woo_El_Helper::templaza_wishlist_button();
                            }
                            echo '</div>';
                            break;
                        case 'layout-5':
                            TemPlaza_Woo_El\TemPlaza_Woo_El_Helper::templaza_product_taxonomy();
                            echo '<h2 class="woocommerce-loop-product__title">';
                            woocommerce_template_loop_product_link_open();
                            the_title();
                            woocommerce_template_loop_product_link_close();
                            echo '</h2>';
                            woocommerce_template_loop_price();
                            woocommerce_template_loop_rating();
                            break;
                        case 'layout-6':
                            TemPlaza_Woo_El\TemPlaza_Woo_El_Helper::templaza_product_taxonomy();
                            echo '<h2 class="woocommerce-loop-product__title">';
                            woocommerce_template_loop_product_link_open();
                            the_title();
                            woocommerce_template_loop_product_link_close();
                            echo '</h2>';
                            woocommerce_template_loop_price();
                            woocommerce_template_loop_rating();
                            echo '<div class="woocommerce-product-loop_space"></div>';
                            if ($loop_desc) {
                                TemPlaza_Woo_El\TemPlaza_Woo_El_Helper::product_loop_desc();
                            }
                            woocommerce_template_loop_add_to_cart();
                            break;
                        case 'layout-7':
                            TemPlaza_Woo_El\TemPlaza_Woo_El_Helper::templaza_product_taxonomy();
                            echo '<h2 class="woocommerce-loop-product__title">';
                            woocommerce_template_loop_product_link_open();
                            the_title();
                            woocommerce_template_loop_product_link_close();
                            echo '</h2>';
                            woocommerce_template_loop_price();
                            woocommerce_template_loop_rating();
                            echo '<div class="product-loop__buttons">';
                            if (!empty($featured_icons) && $featured_icons['cart'] == '1') {
                                woocommerce_template_loop_add_to_cart();
                            }
                            if (!empty($featured_icons) && $featured_icons['quickview'] == '1') {
                                TemPlaza_Woo_El\TemPlaza_Woo_El_Helper::templaza_quick_view_button();
                            }
                            if (!empty($featured_icons) && $featured_icons['wishlist'] == '1') {
                                TemPlaza_Woo_El\TemPlaza_Woo_El_Helper::templaza_wishlist_button();
                            }
                            echo '</div>';
                            break;
                        default:
                            woocommerce_template_loop_rating();
                            TemPlaza_Woo_El\TemPlaza_Woo_El_Helper::templaza_product_taxonomy();
                            echo '<h2 class="woocommerce-loop-product__title">';
                            woocommerce_template_loop_product_link_open();
                            the_title();
                            woocommerce_template_loop_product_link_close();
                            echo '</h2>';
                            woocommerce_template_loop_price();
                            break;
                    }
                    ?>
                </div>
            </div>
        </li>
        <?php
    }

    $GLOBALS['post'] = $original_post;

    woocommerce_product_loop_end();

    wp_reset_postdata();
    wc_reset_loop();


    ?>
    </div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function(){
        if(jQuery('.product-thumbnails--slider').length){
            var options = {
                loop: false,
                autoplay: false,
                speed: 800,
                watchOverflow: true,
                lazy: true,
                breakpoints: {}
            };
            jQuery('.product-thumbnails--slider').each(function(){
                jQuery(this).find('.woocommerce-loop-product__link').addClass('swiper-slide');

                options.navigation = {
                    nextEl: jQuery(this).find('.templaza-product-loop-swiper-next'),
                    prevEl: jQuery(this).find('.templaza-product-loop-swiper-prev'),
                }
                new Swiper(jQuery(this), options);
            })
        }
        if(jQuery('.product-thumbnail-zoom').length){
            jQuery('.product-thumbnail-zoom').each(function(){
                jQuery(this).zoom({
                    url: jQuery(this).attr('data-zoom_image')
                });
            })
        }
    })
</script>