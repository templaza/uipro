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
                        AP_Templates::load_my_layout('archive.content-item');
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