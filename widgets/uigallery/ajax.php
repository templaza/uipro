<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'UIPro_El_UIGallery_Ajax' ) ) {
    require_once __DIR__.'/helper.php';
    class UIPro_El_UIGallery_Ajax{
        protected static $instance;

        public function __construct()
        {
            $this -> hooks();
        }

        public function hooks(){
            add_action('wp_ajax_templaza_ui_gallery_loadmore', array($this,'templaza_ui_gallery_loadmore_ajax_handler') ); // wp_ajax_{action}
            add_action('wp_ajax_nopriv_templaza_ui_gallery_loadmore', array($this,'templaza_ui_gallery_loadmore_ajax_handler')); // wp_ajax_nopriv_{action}
        }

        public function templaza_ui_gallery_loadmore_ajax_handler(){
            // prepare our arguments for the query
            $instance   =   json_decode(base64_decode($_POST['settings']), true) ;
            $gallery            = ( isset( $instance['gallery'] ) && $instance['gallery'] ) ? $instance['gallery'] : array();
            $limit              = ( isset( $instance['limit'] ) && $instance['limit'] ) ? $instance['limit'] : 4;
            $max_num_pages      = intdiv(count($gallery), $limit);
            if ( count($gallery) % $limit ) {
                $max_num_pages++;
            }
            $paged          = $_POST['page'] + 1; // we need next page to be loaded
            $gallery        = array_slice($gallery, ($paged-1)*$limit, $limit);
            $output         =   '';
            foreach ($gallery as $item) {
                include plugin_dir_path(__FILE__).'tpl/post_item.php';
            }
            echo $output;
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

UIPro_El_UIGallery_Ajax::instance();