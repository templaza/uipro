<?php
/**
 * TemPlaza Elements Elementor List Post widget
 *
 * @version     1.0.0
 * @author      TemPlaza
 * @package     TemPlaza/Classes
 * @category    Classes
 */

use Elementor\Controls_Manager;

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'UIPro_El_List_Post' ) ) {
	/**
	 * Class UIPro_El_List_Post
	 */
	class UIPro_El_List_Post extends UIPro_El_Widget {

		/**
		 * @var string
		 */
		protected $config_class = 'UIPro_Config_List_Post';

		public function render()
        {
            $return = parent::render();

            // Reset post query after render
            wp_reset_postdata();

            return$return;
        }

        // convert setting
        function convert_setting( $settings ) {

            $settings['posts']      = $this -> get_posts($settings);
            $settings['list_icon']  = $settings['list_icon']['value'];
            $settings['link_icon']  = $settings['link_icon']['value'];

            return $settings;
        }

        public function get_template_name()
        {
            $temp       = parent::get_template_name();
            $settings   = $this -> get_settings_for_display();

            $temp   = (isset($settings['layout'])) && $settings['layout']?$settings['layout']:$temp;

            return $temp;
        }

        protected $cache    = array();

        protected function get_posts($settings){

		    $store_id   = __METHOD__;
		    $store_id  .= '::'.serialize($settings);
		    $store_id   = md5($store_id);

		    if(isset($this -> cache[$store_id])){
		        return $this -> cache[$store_id];
            }

            $number_posts   = $settings['number_posts'] != ''?$settings['number_posts']:4;

            $query_args     = array(
                'post_type'           => 'post',
                'posts_per_page'      => $number_posts,
                'order'               => ( 'asc' == $settings['order'] ) ? 'asc' : 'desc',
                'ignore_sticky_posts' => true
            );

            if ( $settings['cat_id'] && $settings['cat_id'] != 'all' ) {
                $query_args['cat'] = $settings['cat_id'];
            }
            switch ( $settings['orderby'] ) {
                case 'recent' :
                    $query_args['orderby'] = 'post_date';
                    break;
                case 'title' :
                    $query_args['orderby'] = 'post_title';
                    break;
                case 'popular' :
                    $query_args['orderby'] = 'comment_count';
                    break;
                default : //random
                    $query_args['orderby'] = 'rand';
            }

            $myposts    = new WP_Query( $query_args );

            if(!empty($myposts) && !is_wp_error($myposts)){
                return $this -> cache[$store_id]    = $myposts;
            }

            return false;

//            return new WP_Query( $query_args );
        }
    }
}