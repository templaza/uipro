<?php
defined( 'ABSPATH' ) || exit;

use Advanced_Product\AP_Templates;

if ( ! class_exists( 'UIPro_El_UIAdvancedProducts_Ajax' ) ) {
    require_once __DIR__.'/helper.php';
    class UIPro_El_UIAdvancedProducts_Ajax{
        protected static $instance;

        public function __construct()
        {
            $this -> hooks();
        }

        public function hooks(){
            add_action('wp_ajax_templaza_ui_ap_products_loadmore', array($this,'templaza_ui_ap_products_loadmore_ajax_handler') ); // wp_ajax_{action}
            add_action('wp_ajax_nopriv_templaza_ui_ap_products_loadmore', array($this,'templaza_ui_ap_products_loadmore_ajax_handler')); // wp_ajax_nopriv_{action}
            add_action('wp_ajax_templaza_ui_ap_products_filter', array($this,'templaza_ui_ap_products_filter') );
            add_action('wp_ajax_nopriv_templaza_ui_ap_products_filter', array($this,'templaza_ui_ap_products_filter'));
        }

        public function templaza_ui_ap_products_loadmore_ajax_handler(){

            // prepare our arguments for the query
            $query_args     =   json_decode(base64_decode($_POST['query']), true) ;
            $query_args['paged'] = $_POST['page'] + 1; // we need next page to be loaded
            $query_args['post_status'] = 'publish';
            $instance   =   json_decode(base64_decode($_POST['settings']), true) ;
            $output         =   '';

            $tmp_name   = isset($instance['main_layout'])?$instance['main_layout']:'archive';
            if($tmp_name == 'archive'){
                $ap_posts       =   new WP_Query($query_args);
                if($ap_posts -> have_posts()){
                    while ($ap_posts -> have_posts()) { $ap_posts -> the_post();
                        if(is_plugin_active('advanced-product/advanced-product.php')) {
                            AP_Templates::load_my_layout('archive.content-item');
                        }
                    }
                }
            }else {
                $posts      =   get_posts($query_args);
                foreach ($posts as $item) {
                    include plugin_dir_path(__FILE__).'tpl/post_item.php';
                }
                echo $output;
            }
            wp_reset_postdata();
            die; // here we exit the script and even no wp_reset_query() required!
        }
        public function templaza_ui_ap_products_filter(){

            // prepare our arguments for the query
            $instance   =   json_decode(base64_decode($_POST['settings']), true) ;
            $output         =   '';
            $ordering   = ( isset( $instance['ordering'] ) && $instance['ordering'] ) ? $instance['ordering'] : 'latest';
            $limit      = ( isset( $instance['limit'] ) && $instance['limit'] ) ? $instance['limit'] : 4;
            $show_author 	    = (isset($instance['show_author']) && $instance['show_author']) ? intval($instance['show_author']) : 0;
            $tmp_name   = isset($instance['main_layout'])?$instance['main_layout']:'archive';
            $args['show_author'] = $show_author;
            $args['ap_class'] = 'templazaFadeInUp';
            $query_args = array(
                'post_type'         => 'ap_product',
                'post_status'       => 'publish',
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
            }
            $ap_tax_val = $_POST['filter_value'];
            $ap_tax = $_POST['filter_by'];
            if($ap_tax_val != '0' || $ap_tax_val != 0){
                $query_args['tax_query'] = array(
                    array(
                        'taxonomy' => $ap_tax,
                        'field' => 'slug',
                        'terms' => $ap_tax_val
                    )
                );
            }

            if($tmp_name == 'archive'){
                $ap_posts = new WP_Query($query_args);
                if($ap_posts -> have_posts()){
                    while ($ap_posts -> have_posts()) {
                        $ap_posts -> the_post();
                        if(is_plugin_active('advanced-product/advanced-product.php')) {
                            AP_Templates::load_my_layout('archive.content-item', true, false, $args);
                        }
                    }
                    wp_reset_postdata();
                }else{
                    echo '<div class="uk-text-center uk-width-1-1"> '.esc_html__('No products','uipro').'</div>';
                }
            }else {
                $posts      =   get_posts($query_args);
                foreach ($posts as $item) {
                    include plugin_dir_path(__FILE__).'tpl/post_item.php';
                }
                echo $output;
                wp_reset_postdata();
            }
            die; // here we exit the script and even no wp_reset_query() required!
        }

        /**
         * Instance.
         */
        public static function instance() {
            if ( is_null( self::$instance ) ) {
                self::$instance = new self();
            }
        }
    }
}

UIPro_El_UIAdvancedProducts_Ajax::instance();