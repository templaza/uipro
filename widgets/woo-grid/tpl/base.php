<?php
use TemPlaza_Woo_El\TemPlaza_Woo_El_Helper;
use TemPlazaFramework\Functions;
$general_styles = \UIPro_Elementor_Helper::get_general_styles($instance);
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
if($instance['product_loop_hover']=='zoom'){
    wp_enqueue_script('zoom');
}
$results = TemPlaza_Woo_El_Helper::products_shortcode( $attr );
$results = ! empty($results) ? $results['ids'] : 0;
if ( ! $results ) {
    return;
}
$elementid = uniqid('templaza_');

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
            add_action('templaza_product_loop_thumbnail_element', 'product_loop_buttons_element_open');
            if (!empty($featured_icons) && $featured_icons['wishlist'] == '1') {
                add_action('templaza_product_loop_thumbnail_element', array(
                    TemPlaza_Woo_El\TemPlaza_Woo_El_Helper::get_instance(),
                    'templaza_wishlist_button'
                ), 10);
            }
            if (!empty($featured_icons) && $featured_icons['cart'] == '1') {
                if (function_exists('woocommerce_template_loop_add_to_cart')) {
                    add_action('templaza_product_loop_thumbnail_element', 'woocommerce_template_loop_add_to_cart', 10);
                }
            }

            add_action('templaza_product_loop_thumbnail_element', 'product_loop_buttons_element_close',100);

            if (!empty($featured_icons) && $featured_icons['quickview'] == '1') {
                add_action('templaza_product_loop_thumbnail_element', array(
                    TemPlaza_Woo\Templaza_Woo_Helper::instance(),
                    'templaza_quick_view_button'
                ), 115);
            }

            if (intval(get_option('mobile_product_loop_atc')) && function_exists('woocommerce_template_loop_add_to_cart')) {
                add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 50);
            }

            break;
        // Icons over thumbnail on hover
        case 'layout-3':
            add_action('templaza_product_loop_thumbnail_element', 'product_loop_buttons_element_open');
            if (!empty($featured_icons) && $featured_icons['wishlist'] == '1') {
                add_action('templaza_product_loop_thumbnail_element', array(
                    TemPlaza_Woo_El\TemPlaza_Woo_El_Helper::get_instance(),
                    'templaza_wishlist_button'
                ), 10);
            }
            if (!empty($featured_icons) && $featured_icons['quickview'] == '1') {
                add_action('templaza_product_loop_thumbnail_element', array(
                    TemPlaza_Woo_El\TemPlaza_Woo_El_Helper::get_instance(),
                    'templaza_quick_view_button'
                ), 10);
            }

            add_action('templaza_product_loop_thumbnail_element', 'product_loop_buttons_element_close',100);

            break;
        // Icons on the bottom
        case 'layout-4':

            break;
        // Simple
        case 'layout-5':
            break;
        // Standard button
        case 'layout-6':
            add_action('templaza_product_loop_thumbnail_element', 'product_loop_buttons_element_open');

            if (!empty($featured_icons) && $featured_icons['quickview'] == '1') {
                add_action('templaza_product_loop_thumbnail_element', array(
                    TemPlaza_Woo_El\TemPlaza_Woo_El_Helper::get_instance(),
                    'templaza_quick_view_button'
                ), 15);
            }
            if (!empty($featured_icons) && $featured_icons['wishlist'] == '1') {
                add_action('templaza_product_loop_thumbnail_element', array(
                    TemPlaza_Woo_El\TemPlaza_Woo_El_Helper::get_instance(),
                    'templaza_wishlist_button'
                ), 20);
            }

            add_action('templaza_product_loop_thumbnail_element', 'product_loop_buttons_element_close',100);

            break;

        // Info on hover
        case 'layout-7':

            if (intval(get_option('mobile_product_loop_atc'))) {
                add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 50);
            }
            break;

        // Icons over thumbnail on hover
        default:
            add_action('templaza_product_loop_thumbnail_element', 'product_loop_buttons_element_open');

            if (!empty($featured_icons) && $featured_icons['cart'] == '1') {
                if (function_exists('woocommerce_template_loop_add_to_cart')) {
                    add_action('templaza_product_loop_thumbnail_element', 'woocommerce_template_loop_add_to_cart', 10);
                }
            }

            if (!empty($featured_icons) && $featured_icons['quickview'] == '1') {
                add_action('templaza_product_loop_thumbnail_element', array(
                    TemPlaza_Woo_El\TemPlaza_Woo_El_Helper::get_instance(),
                    'templaza_quick_view_button'
                ), 10);
            }
            if (!empty($featured_icons) && $featured_icons['wishlist'] == '1') {
                add_action('templaza_product_loop_thumbnail_element', array(
                    TemPlaza_Woo_El\TemPlaza_Woo_El_Helper::get_instance(),
                    'templaza_wishlist_button'
                ), 10);
            }

            add_action('templaza_product_loop_thumbnail_element', 'product_loop_buttons_element_close',100);

            if (!empty($attributes) && $attributes['rating'] == '1') {
                add_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
                remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 20);
            }

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
                        do_action( 'templaza_product_loop_thumbnail_element' );
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
                        do_action( 'templaza_product_loop_thumbnail_element' );
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
                        do_action( 'templaza_product_loop_thumbnail_element' );
                        echo '</div>';
                        break;
                    default:
                        echo '<div class="product-thumbnail">';
                        woocommerce_template_loop_product_link_open();
                        woocommerce_template_loop_product_thumbnail();
                        woocommerce_template_loop_product_link_close();
                        do_action( 'templaza_product_loop_thumbnail_element' );
                        echo '</div>';
                        break;
                }
                ?>
                <div class="product-summary">
                    <?php
                    switch ( $loop_layout ) {
                        case 'layout-2':
                            templaza_product_taxonomy();
                            echo '<h2 class="woocommerce-loop-product__title">';
                            woocommerce_template_loop_product_link_open();
                            the_title();
                            woocommerce_template_loop_product_link_close();
                            echo '</h2>';
                            woocommerce_template_loop_price();
                            woocommerce_template_loop_rating();
                            break;
                        case 'layout-3':
                            templaza_product_taxonomy();
                            echo '<h2 class="woocommerce-loop-product__title">';
                            woocommerce_template_loop_product_link_open();
                            the_title();
                            woocommerce_template_loop_product_link_close();
                            echo '</h2>';
                            woocommerce_template_loop_rating();
                            woocommerce_template_loop_price();
                            break;
                        case 'layout-4';
                            templaza_product_taxonomy();
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
                            templaza_product_taxonomy();
                            echo '<h2 class="woocommerce-loop-product__title">';
                            woocommerce_template_loop_product_link_open();
                            the_title();
                            woocommerce_template_loop_product_link_close();
                            echo '</h2>';
                            woocommerce_template_loop_price();
                            woocommerce_template_loop_rating();
                            break;
                        case 'layout-6':
                            templaza_product_taxonomy();
                            echo '<h2 class="woocommerce-loop-product__title">';
                            woocommerce_template_loop_product_link_open();
                            the_title();
                            woocommerce_template_loop_product_link_close();
                            echo '</h2>';
                            woocommerce_template_loop_price();
                            woocommerce_template_loop_rating();
                            echo '<div class="woocommerce-product-loop_space"></div>';
                            if ($loop_desc) {
                                product_loop_desc();
                            }
                            woocommerce_template_loop_add_to_cart();
                            break;
                        case 'layout-7':
                            templaza_product_taxonomy();
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
                            templaza_product_taxonomy();
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

    function product_loop_buttons_element_open() {
		echo '<div class="product-loop__buttons">';
	}
	function product_loop_buttons_element_close() {
		echo '</div>';
	}
    function add_to_cart_link( $html, $product, $args ) {
        return sprintf(
            '<a href="%s" data-quantity="%s" class="%s tz-loop-button tz-loop_atc_button" %s data-text="%s" data-title="%s" >%s<span class="add-to-cart-text loop_button-text">%s</span></a>',
            esc_url( $product->add_to_cart_url() ),
            esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
            esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
            isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
            esc_html( $product->add_to_cart_text() ),
            esc_html( $product->get_title() ),
            '<i class="fas fa-shopping-cart"></i>',
            esc_html( $product->add_to_cart_text() )
        );
    }
    function product_loop_category() {
        if ( !class_exists( 'TemPlazaFramework\TemPlazaFramework' )){
            $templaza_options = array();
        }else{
            $templaza_options = Functions::get_theme_options();
        }

        $taxonomy = isset($templaza_options['templaza-shop-loop-taxonomy'])?$templaza_options['templaza-shop-loop-taxonomy']:'';
        TemPlaza_Woo\Templaza_Woo_Helper::templaza_product_taxonomy( $taxonomy );
    }
    function product_loop_form_ajax() {
		if ( empty( $_POST['product_id'] ) ) {
			exit;
		}
		$original_post   = $GLOBALS['post'];
		$product         = wc_get_product( $_POST['product_id'] );
		$GLOBALS['post'] = get_post( $_POST['product_id'] );
		setup_postdata( $GLOBALS['post'] );
		ob_start();

		// Get Available variations?
		$get_variations = count( $product->get_children() ) <= apply_filters( 'woocommerce_ajax_variation_threshold', 30, $product );

		// Load the template.
        wc_get_template(
            'loop/add-to-cart-variable.php',
            array(
                'available_variations' => $get_variations ? $product->get_available_variations() : false,
                'attributes'           => $product->get_variation_attributes(),
                'selected_attributes'  => $product->get_default_attributes(),
            )
        );
		$output = ob_get_clean();

		$GLOBALS['post'] = $original_post; // WPCS: override ok.
		wp_reset_postdata();

		wp_send_json_success( $output );
		exit;
	}

    function templaza_product_taxonomy( $taxonomy = 'product_cat', $show_thumbnail = false ) {
        global $product;

        $taxonomy = empty($taxonomy) ? 'product_cat' : $taxonomy;
        $terms = get_the_terms( $product->get_id(), $taxonomy );

        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
            if( $show_thumbnail ) {
                $thumbnail_id   = get_term_meta( $terms[0]->term_id, 'brand_thumbnail_id', true );
                $image = $thumbnail_id ? wp_get_attachment_image( $thumbnail_id, 'full' ) : '';
                echo sprintf(
                    '<a class="meta-cat" href="%s">%s</a>',
                    esc_url( get_term_link( $terms[0] ), $taxonomy ),
                    $image);
            } else {
                echo sprintf(
                    '<a class="meta-cat" href="%s">%s</a>',
                    esc_url( get_term_link( $terms[0] ), $taxonomy ),
                    esc_html( $terms[0]->name ) );
            }
        }
    }
    function product_loop_desc() {
        global $post;

        $short_description = $post ? $post->post_excerpt : '';

        if ( ! $short_description ) {
            return;
        }
        if ( !class_exists( 'TemPlazaFramework\TemPlazaFramework' )){
            $templaza_options = array();
        }else{
            $templaza_options = Functions::get_theme_options();
        }
        $loop_desc_length       = isset($templaza_options['templaza-shop-loop-description-length'])?$templaza_options['templaza-shop-loop-description-length']:'10';

        $length = intval( $loop_desc_length );
        if ( $length ) {
            $short_description = wp_trim_words( $short_description, $length, '...');
        }

        echo sprintf( '<div class="woocommerce-product-details__short-description"> %s</div>', $short_description );
    }
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