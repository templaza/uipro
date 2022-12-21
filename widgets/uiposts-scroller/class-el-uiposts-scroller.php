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

require_once __DIR__.'/helper.php';

if ( ! class_exists( 'UIPro_El_UIPosts_Scroller' ) ) {
	/**
	 * Class UIPro_El_Heading
	 */
	class UIPro_El_UIPosts_Scroller extends UIPro_El_Widget {

		/**
		 * @var string
		 */
		protected $config_class = 'UIPro_Config_UIPosts_Scroller';

//        public function __construct( array $data = [], array $args = null ) {
//            parent::__construct($data, $args);
//
//            add_action( 'elementor/preview/enqueue_scripts', array($this, 'editor_enqueue_scripts') );
////            add_action( 'elementor/preview/enqueue_scripts', array($this, 'editor_enqueue_styles') );
////            add_action('wp_ajax_templaza_ui_post_loadmore', array($this,'templaza_ui_post_loadmore_ajax_handler') ); // wp_ajax_{action}
////            add_action('wp_ajax_nopriv_templaza_ui_post_loadmore', array($this,'templaza_ui_post_loadmore_ajax_handler')); // wp_ajax_nopriv_{action}
//        }

        public function convert_setting($settings){

            if(isset($settings['link']['custom_attributes']) && !empty($settings['link']['custom_attributes'])) {
                $attributes = Utils::parse_custom_attributes($settings['link']['custom_attributes']);

                $settings['link']['custom_class']  = isset($attributes['class'])?' '.$attributes['class']:'';

                unset($attributes['class']);

                $this -> set_render_attribute('link_attributes', $attributes);

                $settings['link']['custom_attributes'] = $this -> get_render_attribute_string('link_attributes');
            }

		    return $settings;
        }
//        public function get_template_name() {
//            $template_name  = parent::get_template_name();
//
//            $settings       = $this -> get_settings_for_display();
//            if(!$template_name) {
//                $template_name = (isset($settings['uipost_layout']) && $settings['uipost_layout'] != '') ? $settings['uipost_layout'] : 'base';
//            }
//
//            return $template_name;
//
//        }

        public function templaza_ui_post_loadmore_ajax_handler(){
            // prepare our arguments for the query
            $query_args     =   json_decode(base64_decode($_POST['query']), true) ;
            $query_args['paged'] = $_POST['page'] + 1; // we need next page to be loaded
            $query_args['post_status'] = 'publish';
            $instance   =   json_decode(base64_decode($_POST['settings']), true) ;
            $posts      =   get_posts($query_args);
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
            foreach ($posts as $item) {
                include plugin_dir_path(__FILE__).'../widgets/'.$this -> get_name().'/tpl/post_item.php';
            }
            echo $output;
            wp_reset_postdata();
            die; // here we exit the script and even no wp_reset_query() required!
        }


    }
}