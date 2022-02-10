<?php
/**
 * UIPro Elementor Heading widget
 *
 * @version     1.0.0
 * @author      ThimPress
 * @package     UIPro/Classes
 * @category    Classes
 */

use Elementor\Utils;

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit;

use Advanced_Product\AP_Templates;

require_once __DIR__.'/helper.php';

if ( ! class_exists( 'UIPro_El_UIAdvancedProducts' ) ) {
	/**
	 * Class UIPro_El_Heading
	 */
	class UIPro_El_UIAdvancedProducts extends UIPro_El_Widget {

		/**
		 * @var string
		 */
		protected $config_class = 'UIPro_Config_UIAdvancedProducts';

        function __construct( array $data = [], array $args = null ) {
            parent::__construct($data, $args);
            add_action('wp_ajax_templaza_ui_advanced_products_loadmore', array($this,'templaza_ui_post_loadmore_ajax_handler') ); // wp_ajax_{action}
            add_action('wp_ajax_nopriv_templaza_ui_post_loadmore', array($this,'templaza_ui_post_loadmore_ajax_handler')); // wp_ajax_nopriv_{action}
        }

        public function get_template_name()
        {
            $temp       = parent::get_template_name();
            $settings   = $this -> get_settings_for_display();

            $temp   = (isset($settings['main_layout']) && $settings['main_layout'])?$settings['main_layout']:$temp;

            return $temp;
        }

        public function convert_setting($settings){
            $settings['posts']      = $this -> get_posts($settings);
            $settings['query_args'] = $this -> get_query_args($settings);

            if(isset($settings['link']['custom_attributes']) && !empty($settings['link']['custom_attributes'])) {
                $attributes = Utils::parse_custom_attributes($settings['link']['custom_attributes']);

                $settings['link']['custom_class']  = isset($attributes['class'])?' '.$attributes['class']:'';

                unset($attributes['class']);

                $this -> set_render_attribute('link_attributes', $attributes);

                $settings['link']['custom_attributes'] = $this -> get_render_attribute_string('link_attributes');
            }

		    return $settings;
        }

        public function templaza_ui_post_loadmore_ajax_handler(){
            // prepare our arguments for the query
            $query_args     =   json_decode(base64_decode($_POST['query']), true) ;
            $query_args['paged'] = $_POST['page'] + 1; // we need next page to be loaded
            $query_args['post_status'] = 'publish';
            $instance   =   json_decode(base64_decode($_POST['settings']), true) ;
            $ap_posts       =   get_posts($query_args);
            $layout         = (isset($instance['layout'] ) && $instance['layout'] ) ? $instance['layout'] : '';
            $color_mode     = (isset($instance['color_mode'] ) && $instance['color_mode'] ) ? ' uk-'. $instance['color_mode'] : '';
            $resource       = ( isset( $instance['resource'] ) && $instance['resource'] ) ? $instance['resource'] : 'post';

            //Card size
            $card_style 	= (isset($instance['card_style']) && $instance['card_style']) ? ' uk-card-'. $instance['card_style'] : '';
            $card_size 		= (isset($instance['card_size']) && $instance['card_size']) ? $instance['card_size'] : '';
            $card_size_cls  = $card_size ? ' uk-card-'.$card_size : '';
            $uk_card_body   = $card_size != 'none' ? ' uk-card-body' : '';

            //Title
            $heading_selector = (isset($instance['title_tag']) && $instance['title_tag']) ? $instance['title_tag'] : 'h3';
            $title_heading_style    = (isset($instance['title_heading_style']) && $instance['title_heading_style']) ? ' uk-'. $instance['title_heading_style'] : '';
            $title_margin   = (isset($instance['title_margin']) && $instance['title_margin']) ? ' uk-margin-'. $instance['title_margin'] .'-bottom' : ' uk-margin-bottom';

            //Image
            $hide_thumbnail = (isset($instance['hide_thumbnail']) && $instance['hide_thumbnail']) ? intval($instance['hide_thumbnail']) : 0;
            $thumbnail_size = (isset($instance['thumbnail_size']) && $instance['thumbnail_size']) ? $instance['thumbnail_size'] : 'full';
            $image_position = (isset($instance['image_position']) && $instance['image_position']) ? $instance['image_position'] : 'top';
            $image_border   = (isset($instance['image_border']) && $instance['image_border']) ? ' uk-overflow-hidden '. $instance['image_border'] : '';
            $thumbnail_hover= (isset($instance['thumbnail_hover']) && $instance['thumbnail_hover']) ? intval($instance['thumbnail_hover']) : 0;
            $thumbnail_hover_transition= (isset($instance['thumbnail_hover_transition']) && $instance['thumbnail_hover_transition']) ? ' uk-transition-'. $instance['thumbnail_hover_transition'] : '';
            $cover_image    = (isset($instance['cover_image']) && $instance['cover_image']) ? intval($instance['cover_image']) : 0;
            $cover_image    =   $cover_image ? ' tz-image-cover' : '';

            $show_intro 	= (isset($instance['show_introtext']) && $instance['show_introtext']) ? intval($instance['show_introtext']) : 0;
            $dropcap        = (isset($instance['content_dropcap']) && $instance['content_dropcap']) ? ' uk-dropcap' : '';
            $show_author 	= (isset($instance['show_author']) && $instance['show_author']) ? intval($instance['show_author']) : 0;
            $show_category 	= (isset($instance['show_category']) && $instance['show_category']) ? intval($instance['show_category']) : 0;
            $show_date 		= (isset($instance['show_date']) && $instance['show_date']) ? intval($instance['show_date']) : 0;
            $show_tags 		= (isset($instance['show_tags']) && $instance['show_tags']) ? intval($instance['show_tags']) : 0;
            $tag_style 		= (isset($instance['tag_style']) && $instance['tag_style']) ? $instance['tag_style'] : '';
            $tag_margin 	= (isset($instance['tag_margin']) && $instance['tag_margin']) ? ' uk-margin-'. $instance['tag_margin'] : ' uk-margin';

            $show_readmore 	= (isset($instance['show_readmore']) && $instance['show_readmore']) ? intval($instance['show_readmore']) : 0;
            $button_text    = (isset($instance['all_button_title']) && $instance['all_button_title']) ? $instance['all_button_title'] : 'Read More';
            $button_target  = (isset($instance['target']) && $instance['target']) ? ' target="'. $instance['target'] .'"' : '';
            $button_class   = (isset($instance['button_style']) && $instance['button_style']) ? ' uk-button uk-button-' . $instance['button_style'] : ' uk-button uk-button-default';
            $button_class   .=(isset($instance['button_size']) && $instance['button_size']) ? ' ' . $instance['button_size'] : '';
            $button_class   .=(isset($instance['button_margin_top']) && $instance['button_margin_top']) ? ' uk-margin-' . $instance['button_margin_top'].'-top' : ' uk-margin-top';
            $button_class   .=(isset($instance['button_shape']) && $instance['button_shape']) ? ' uk-button-' . $instance['button_shape'] : '';
            $output         =   '';


            global $wp_query;

            $tmp_name   = $this -> get_template_name();
            if($tmp_name == 'archive'){
                // Store current $wp_query to $wp_query_tmp
                $wp_query_tmp       = $wp_query;
                // Set $wp_query to new object
                $wp_query           = !empty($ap_posts)?$ap_posts:$wp_query_tmp;

                AP_Templates::load_my_layout('archive.content');

                // Assign $wp_query again
                $wp_query = $wp_query_tmp;
            }else {
                foreach ($ap_posts as $item) {
                    include plugin_dir_path(__FILE__).'../widgets/uiposts/tpl/post_item.php';
                }
                echo $output;
            }
            wp_reset_postdata();
            die; // here we exit the script and even no wp_reset_query() required!
        }

        protected function render()
        {
            if ( ! $this->config_class ) {
                return;
            }

            global $wp_query;

            $tmp_name   = $this -> get_template_name();
            if($tmp_name == 'archive'){

                // Get settings
                $settings = $this->get_settings_for_display();

                // Get posts
                $ap_posts   = $this -> get_posts($settings);

                // Store current $wp_query to $wp_query_tmp
                $wp_query_tmp       = $wp_query;
                // Set $wp_query to new object
                $wp_query           = !empty($ap_posts)?$ap_posts:$wp_query_tmp;
            }

            parent::render(); // TODO: Change the autogenerated stub

            if($tmp_name == 'archive' && isset($wp_query_tmp) && !empty($wp_query_tmp)) {
                // Assign $wp_query again
                $wp_query = $wp_query_tmp;
            }
            wp_reset_postdata();
        }

        protected function get_query_args($instance){
            $resource   = 'ap_product';
            $limit      = ( isset( $instance['limit'] ) && $instance['limit'] ) ? $instance['limit'] : 4;
            $ordering   = ( isset( $instance['ordering'] ) && $instance['ordering'] ) ? $instance['ordering'] : 'latest';
            $branch     = ( isset( $instance[$resource.'_branch'] ) && $instance[$resource.'_branch'] ) ? $instance[$resource.'_branch'] : array('0');
            $category   = ( isset( $instance[$resource.'_category'] ) && $instance[$resource.'_category'] ) ? $instance[$resource.'_category'] : array('0');

            $pagination_type    = (isset($instance['pagination_type']) && $instance['pagination_type']) ? $instance['pagination_type'] : 'none';

            $query_args = array(
                'post_type'         => $resource,
                'posts_per_page'    => $limit,
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
                    $query_args['post__in'] = get_option( 'sticky_posts' );
                    $query_args['ignore_sticky_posts'] = 1;
                    break;
            }
//            if ($resource == 'post') {
//                $query_args['category']  =   implode(',', $category);
//            } else {

                $tax_query  = array();

                if (!empty($branch) && count($branch) && $branch[0] != '0') {
                    $tax_query[] = array(
                        'taxonomy'  => 'ap_branch',
                        'field'     => 'id',
                        'operator'  => 'IN',
                        'terms'     => $branch,
                    );
                }
                if (count($category) && $category[0] != '0') {
                    $tax_query[] = array(
                        'taxonomy'  => 'ap_category',
                        'field'     => 'id',
                        'operator'  => 'IN',
                        'terms'     => $category,
                    );
                }

                // Custom categories
                $categories = UIPro_UIAdvancedProducts_Helper::get_custom_categories();
                if(!empty($categories) && count($categories)) {
                    foreach ($categories as $cat) {
                        $slug = get_post_meta($cat->ID, 'slug', true);

                        if (!taxonomy_exists($slug)) {
                            continue;
                        }

                        $custom_cat   = ( isset( $instance[$slug] ) && $instance[$slug] ) ? $instance[$slug] : array();

                        if(!empty($custom_cat) && count($custom_cat)) {
                            $tax_query[] = array(
                                'taxonomy' => $slug,
                                'field' => 'id',
                                'operator' => 'IN',
                                'terms' => $custom_cat,
                            );
                        }

                    }
                }

                if(!empty($tax_query) && count($tax_query)){
                    $query_args['tax_query']    = $tax_query;
                }
//            }
            if ($pagination_type == 'default') {
                $query_args['paged'] = max( 1, get_query_var('paged') );
            }
            return $query_args;
        }

        protected function get_posts($instance){
//            $_is_elementor  = (isset($args['page_builder']) && $args['page_builder'] == 'elementor')?true:false;

//            $color_mode         = (isset($instance['color_mode'] ) && $instance['color_mode'] ) ? ' uk-'. $instance['color_mode'] : '';
            $pagination_type    = (isset($instance['pagination_type']) && $instance['pagination_type']) ? $instance['pagination_type'] : 'none';

            //Get posts
//            $limit      = ( isset( $instance['limit'] ) && $instance['limit'] ) ? $instance['limit'] : 4;
            $resource   = 'ap_product';
//            $ordering   = ( isset( $instance['ordering'] ) && $instance['ordering'] ) ? $instance['ordering'] : 'latest';
//            $branch     = ( isset( $instance[$resource.'_branch'] ) && $instance[$resource.'_branch'] ) ? $instance[$resource.'_branch'] : array('0');
//            $category   = ( isset( $instance[$resource.'_category'] ) && $instance[$resource.'_category'] ) ? $instance[$resource.'_category'] : array('0');

            $query_args = $this -> get_query_args($instance);

//            $query_args = array(
//                'post_type'         => $resource,
//                'posts_per_page'    => $limit,
//            );
//            switch ($ordering) {
//                case 'latest':
//                    $query_args['orderby'] = 'date';
//                    $query_args['order'] = 'DESC';
//                    break;
//                case 'oldest':
//                    $query_args['orderby'] = 'date';
//                    $query_args['order'] = 'ASC';
//                    break;
//                case 'random':
//                    $query_args['orderby'] = 'rand';
//                    break;
//                case 'popular':
//                    $query_args['orderby'] = 'meta_value_num';
//                    $query_args['order'] = 'DESC';
//                    $query_args['meta_key'] = 'post_views_count';
//                    break;
//                case 'sticky':
//                    $query_args['post__in'] = get_option( 'sticky_posts' );
//                    $query_args['ignore_sticky_posts'] = 1;
//                    break;
//            }
//            if ($resource == 'post') {
//                $query_args['category']  =   implode(',', $category);
//            } else {
//                $tax_query  = array();
//
//                if (!empty($branch) && count($branch) && $branch[0] != '0') {
//                    $tax_query[] = array(
//                        'taxonomy'  => 'ap_branch',
//                        'field'     => 'id',
//                        'operator'  => 'IN',
//                        'terms'     => $branch,
//                    );
//                }
//                if (count($category) && $category[0] != '0') {
//                    $tax_query[] = array(
//                        'taxonomy'  => 'ap_category',
//                        'field'     => 'id',
//                        'operator'  => 'IN',
//                        'terms'     => $category,
//                    );
//                }
//
//                // Custom categories
//                $categories = UIPro_UIAdvancedProducts_Helper::get_custom_categories();
//                if(!empty($categories) && count($categories)) {
//                    foreach ($categories as $cat) {
//                        $slug = get_post_meta($cat->ID, 'slug', true);
//
//                        if (!taxonomy_exists($slug)) {
//                            continue;
//                        }
//
//                        $custom_cat   = ( isset( $instance[$slug] ) && $instance[$slug] ) ? $instance[$slug] : array();
//
//                        if(!empty($custom_cat) && count($custom_cat)) {
//                            $tax_query[] = array(
//                                'taxonomy' => $slug,
//                                'field' => 'id',
//                                'operator' => 'IN',
//                                'terms' => $custom_cat,
//                            );
//                        }
//
//                    }
//                }
//
//                if(!empty($tax_query) && count($tax_query)){
//                    $query_args['tax_query']    = $tax_query;
//                }
//            }
//            if ($pagination_type == 'default') {
//                $query_args['paged'] = max( 1, get_query_var('paged') );
//            }

            // Based on WP get_posts() default function
            $defaults = array(
                'numberposts'      => 5,
                'category'         => 0,
                'orderby'          => 'date',
                'order'            => 'DESC',
                'include'          => array(),
                'exclude'          => array(),
                'meta_key'         => '',
                'meta_value'       => '',
                'post_type'        => 'post',
                'suppress_filters' => true,
            );

            $parsed_args = wp_parse_args( $query_args, $defaults );
            if ( empty( $parsed_args['post_status'] ) ) {
                $parsed_args['post_status'] = ( 'attachment' === $parsed_args['post_type'] ) ? 'inherit' : 'publish';
            }
            if ( ! empty( $parsed_args['numberposts'] ) && empty( $parsed_args['posts_per_page'] ) ) {
                $parsed_args['posts_per_page'] = $parsed_args['numberposts'];
            }
            if ( ! empty( $parsed_args['category'] ) ) {
                $parsed_args['cat'] = $parsed_args['category'];
            }
            if ( ! empty( $parsed_args['include'] ) ) {
                $incposts                      = wp_parse_id_list( $parsed_args['include'] );
                $parsed_args['posts_per_page'] = count( $incposts );  // Only the number of posts included.
                $parsed_args['post__in']       = $incposts;
            } elseif ( ! empty( $parsed_args['exclude'] ) ) {
                $parsed_args['post__not_in'] = wp_parse_id_list( $parsed_args['exclude'] );
            }

            $parsed_args['ignore_sticky_posts'] = true;
            if ($pagination_type == 'none') {
                $parsed_args['no_found_rows']       = true;
            }

            return $post_query = new WP_Query($parsed_args);
        }

    }
}