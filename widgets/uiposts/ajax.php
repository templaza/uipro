<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'UIPro_El_UIPosts_Ajax' ) ) {
    require_once __DIR__.'/helper.php';
    class UIPro_El_UIPosts_Ajax{
        protected static $instance;

        public function __construct()
        {
            $this -> hooks();
        }

        public function hooks(){
            add_action('wp_ajax_templaza_ui_post_loadmore', array($this,'templaza_ui_post_loadmore_ajax_handler') ); // wp_ajax_{action}
            add_action('wp_ajax_nopriv_templaza_ui_post_loadmore', array($this,'templaza_ui_post_loadmore_ajax_handler')); // wp_ajax_nopriv_{action}
        }

        public function templaza_ui_post_loadmore_ajax_handler(){

            // prepare our arguments for the query
            $query_args     =   json_decode(base64_decode($_POST['query']), true) ;
            $query_args['paged'] = $_POST['page'] + 1; // we need next page to be loaded
            $query_args['post_status'] = 'publish';
            $instance   =   json_decode(base64_decode($_POST['settings']), true) ;
            $posts      =   get_posts($query_args);

            $output = '';

            if($instance['uipost_layout'] == 'base') {
                $icount         = isset($_POST['icount'])?$_POST['icount']:0;
                $limit          = (isset($instance['limit']) && $instance['limit']) ? $instance['limit'] : 4;
                $lead_limit     = (isset($instance['lead_limit']) && $instance['lead_limit']) ? $instance['lead_limit'] : 0;
                $lead_position  = (isset($instance['lead_position']) && $instance['lead_position']) ? $instance['lead_position'] : 'top';

                if(empty($posts)){
                    echo '';
                    wp_reset_postdata();
                    die; // here we exit the script and even no wp_reset_query() required!
                }

                $lead_items     = array();
                $first_items    = array();

                if ($lead_limit) {
                    $icount -= $lead_limit;
                    $fclimit    = round($icount /2);
                    $lclimit    = $icount - $fclimit;
                    if($fclimit != $lclimit){
                        $flimit = round($limit/2) - abs($fclimit - $lclimit);
                    }

                    $lead_items     =   array_slice($posts, 0, $lead_limit);
                    if ($limit) {
                        if ($lead_position == 'between' && $limit>2) {
                            $first_items    =   array_slice($posts, $lead_limit, $flimit);
                            $posts          =   array_slice($posts, $lead_limit+$flimit);
                        } else {
                            $posts      =   array_slice($posts, $lead_limit);
                        }
                    }
                }

                ob_start();
                \UIPro_Elementor_Helper::get_widget_template('base_posts',
                    array('instance' => $instance, 'output' => '', 'posts' => array(
                        'first_items' => $first_items,
                        'lead_items' => $lead_items,
                        'last_items' => $posts,
                    ), 'args' => array()),
                    $instance['template_path']);
                $output = ob_get_contents();
                ob_end_clean();

                echo $output;
            }else {
                foreach ($posts as $item) {
                    ob_start();
                    \UIPro_Elementor_Helper::get_widget_template('post_item',
                        array('instance' => $instance, 'pre_val' => '', 'output' => '',
                            'item' => $item, 'args' => array()), $instance['template_path']);
                    $output .= ob_get_contents();
                    ob_end_clean();
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

UIPro_El_UIPosts_Ajax::instance();