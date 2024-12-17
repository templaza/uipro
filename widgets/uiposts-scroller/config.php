<?php
/**
 * UIPro Heading config class
 *
 * @version     1.0.0
 * @author      TemPlaza
 * @package     UIPro/Classes
 * @category    Classes
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;


require_once __DIR__.'/helper.php';
if ( ! class_exists( 'UIPro_Config_UIPosts_Scroller' ) ) {
	/**
	 * Class UIPro_Config_UIPosts
	 */
	class UIPro_Config_UIPosts_Scroller extends UIPro_Abstract_Config {

		/**
		 * UIPro_Config_Heading constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'uiposts-scroller';
			self::$name = esc_html__( 'TemPlaza: UI Posts Scroller', 'uipro' );
			self::$desc = esc_html__( 'Add UI Posts Scroller Box.', 'uipro' );
			self::$icon = 'eicon-posts-group';
			self::$assets_path  =   plugin_dir_url(__FILE__). 'assets/';
			parent::__construct();

            add_action( 'elementor/preview/enqueue_scripts', array($this, 'editor_enqueue_scripts') );
            add_action( 'elementor/editor/after_enqueue_scripts', array($this, 'editor_enqueue_scripts') );
//            add_action( 'elementor/editor/before_enqueue_styles', array($this, 'editor_enqueue_styles') );
//            add_action( 'elementor/preview/enqueue_scripts', array($this, 'editor_enqueue_scripts') );
		}

		public function get_styles() {
            return array(
                'uiposts-scroller' => array(
                    'src'   =>  'style.css',
                    'deps_src'  => array(
                        'uiposts-scroller-bxslider' => static::$assets_url.'/vendor/bxslider/jquery.bxslider.min.css'
                    )
                ),
//                'ui-post-bxslider' => array(
//                    'src'   =>  'jquery.bxslider.css',
//                    'deps_src'  => array(
//
//                    )
//                )
            );
        }

		public function get_scripts() {
			return array(
				'uiposts-scroller' => array(
					'src'   =>  'script.min.js',
					'deps'  =>  array('jquery'),
                    'deps_src'  => array(
                        'uiposts-scroller-bxslider' => static::$assets_url.'vendor/bxslider/jquery.bxslider.min.js'
                    )
				)
			);
		}

//		public function get_localize() {
//			global $wp_query;
//			// get settings
//			return array(
//				'ui_post_loadmore_params'   =>  array(
//					'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
//					'current_page' => get_query_var( 'paged' ) ? get_query_var('paged') : 1,
//				)
//			);
//		}

		/**
		 * @return array
		 */
		public function get_options() {
		    $post_types =   UIPro_Helper::get_post_type( 'category' );

            $store_id   = __METHOD__;
            $store_id  .= '::'.serialize($post_types);
            $store_id   = md5($store_id);

            if(isset(static::$cache[$store_id])){
                return static::$cache[$store_id];
            }

			// options
			$options = array(
                array(
                    'name'        => 'layout_mode',
                    'label'     => esc_html__( 'Layout Mode', 'uipro' ),
                    'type'      => Controls_Manager::SELECT,
                    'options'   => array(
                        'ticker'      => esc_html__('Ticker', 'uipro'),
                        'scroller'    => esc_html__('Scroller', 'uipro'),
                        'carousel'    => esc_html__('Carousel', 'uipro'),
                    ),
                    'default'   => 'ticker',
                ),
				array(
					'type'          => Controls_Manager::SELECT,
					'name'            => 'resource',
					'label'         => esc_html__( 'Choose Resource', 'uipro' ),
					'options'       => $post_types,
					'default'       => 'post',
					'description'   => esc_html__( 'Select a content resource from the list. if you choose Portfolio then you must have to installed Portfolio post type.', 'uipro' ),
				),
				array(
					'type'          => Controls_Manager::SELECT2,
					'name'            => 'post_category',
					'label'         => esc_html__( 'Select Category', 'uipro' ),
					'options'       => UIPro_Helper::get_cat_taxonomy( 'category' ),
					'multiple'      => true,
					'conditions' => [
						'terms' => [
							['name' => 'resource', 'operator' => '===', 'value' => 'post'],
						],
					],
				),
				array(
					'type'          => Controls_Manager::SWITCHER,
					'name'            => 'include_subcagories',
					'label'         => esc_html__('Include subcagories', 'uipro'),
					'description'   => esc_html__( 'Select yes to include sub categories', 'uipro' ),
					'label_on' => esc_html__( 'Yes', 'uipro' ),
					'label_off' => esc_html__( 'No', 'uipro' ),
					'return_value' => '1',
					'default' => '0',
				),
				array(
					'type'          => Controls_Manager::SELECT,
					'name'            => 'ordering',
					'label'         => esc_html__( 'Ordering', 'uipro' ),
					'options'       => array(
						'latest'    => esc_html__('Latest', 'uipro'),
						'oldest'    => esc_html__('Oldest', 'uipro'),
						'popular'   => esc_html__('Popular', 'uipro'),
						'sticky'   => esc_html__('Sticky Only', 'uipro'),
						'random'    => esc_html__('Random', 'uipro'),
					),
					'default'       => 'latest',
					'description'   => esc_html__( 'Select articles ordering from the list.', 'uipro' ),
				),
				array(
					'type'          => Controls_Manager::NUMBER,
					'name'            => 'limit',
					'label'         => esc_html__( 'Limit', 'uipro' ),
					'description'   => esc_html__( 'Set the number of articles you want to display.', 'uipro' ),
					'min' => 1,
					'max' => 90,
					'step' => 1,
					'default' => 3,
				),

				// Slider settings
//				array(
//					'type'          => Controls_Manager::NUMBER,
//					'name'            => 'slider_limit',
//					'label'         => esc_html__( 'Number Of Posts To Show', 'uipro' ),
//					'description'   => esc_html__( 'Set number of posts to show for \'News Scroller\'.', 'uipro' ),
//					'responsive'    => true,
//					'min' => 1,
//					'max' => 90,
//					'step' => 1,
//                    'desktop_default' => 3,
//                    'tablet_default' => 2,
//                    'mobile_default' => 1,
////					'default' => 3,
//                    'start_section' => 'slider_settings',
//                    'section_name'  =>  esc_html__('Slider Settings', 'uipro'),
//				),
				array(
					'type'          => Controls_Manager::NUMBER,
					'name'            => 'number_of_items',
					'label'         => esc_html__( 'Number Of Posts To Show', 'uipro' ),
					'description'   => esc_html__( 'Set number of posts to show for \'News Scroller\'.', 'uipro' ),
//					'responsive'    => true,
//                    'desktop_default' => [3],
                    Elementor\Core\Breakpoints\Manager::BREAKPOINT_KEY_DESKTOP.'_default' => 4,
                    Elementor\Core\Breakpoints\Manager::BREAKPOINT_KEY_TABLET.'_default' => 2,
                    Elementor\Core\Breakpoints\Manager::BREAKPOINT_KEY_MOBILE.'_default' => 1,
//					'default'       => [
//					    'desktop' => 3,
//					    'tablet' => 2,
//					    'mobile' => 1,
//                        ],
                    'start_section' => 'slider_settings',
                    'section_name'  =>  esc_html__('Slider Settings', 'uipro'),
                    'condition'     => [
                        'layout_mode!'   => 'ticker'
                    ],
				),
				array(
					'type'          => Controls_Manager::NUMBER,
					'name'          => 'move_slide',
					'label'         => esc_html__( 'Number Of Posts To Slide', 'uipro' ),
					'description'   => esc_html__( 'Set number of posts to slide for every slide.', 'uipro' ),
					'default' => 1,
                    'condition'     => [
                        'layout_mode!'   => ['ticker', 'carousel']
                    ],
                    'separator' => 'after',
				),
				array(
					'type'          => Controls_Manager::NUMBER,
					'name'            => 'slider_speed',
					'label'         => esc_html__( 'Ticker/Scroller/Carousel Speed', 'uipro' ),
					'description'   => esc_html__( 'Set sliding speed for ticker/scroller/carousel default is 500', 'uipro' ),
					'min' => 1,
					'step' => 1,
					'default' => 500,
				),
				array(
					'type'          => Controls_Manager::SWITCHER,
					'name'            => 'carousel_autoplay',
					'label'         => esc_html__( 'Autoplay', 'uipro' ),
					'description'   => esc_html__( 'Select \'Yes\' if you want to autoplay slider.', 'uipro' ),
                    'default'       => 'no',
				),
				array(
					'type'          => Controls_Manager::SWITCHER,
					'name'            => 'carousel_touch',
					'label'         => esc_html__( 'Enable Drag', 'uipro' ),
					'description'   => esc_html__( 'If you want to drag carousel by mouse or touch then enable this option.', 'uipro' ),
                    'default'       => 'no',
				),
				array(
					'type'          => Controls_Manager::SWITCHER,
					'name'            => 'carousel_arrow',
					'label'         => esc_html__( 'Enable Arrow Controllers', 'uipro' ),
					'description'   => esc_html__( 'Select \'Yes\' for showing arrow controllers.', 'uipro' ),
                    'default'       => 'no',
				),
                array(
                    'type'          => Controls_Manager::COLOR,
                    'name'            => 'carousel_arrow_color',
                    'label'         => esc_html__( 'Arrow Color', 'uipro' ),
                    'condition'     => [
                        'carousel_arrow'  => 'yes',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .ticker-controller .bx-prev, {{WRAPPER}} .ticker-controller .bx-next' => 'color: {{VALUE}};',
                    ],
                ),

				// Ticker heading settings
				array(
					'type'          => Controls_Manager::TEXT,
					'name'            => 'ticker_heading',
					'label'         => esc_html__( 'Ticker Heading', 'uipro' ),
					'description'   => esc_html__( 'Set news ticker heading', 'uipro' ),
                    'default'       => esc_html__( 'Breaking News', 'uipro'),
                    'condition'     => [
                        'layout_mode!'   => ['scroller', 'carousel']
                    ],
                    'start_section' => 'ticker_heading_settings',
                    'section_name'  =>  esc_html__('Ticker Heading Settings', 'uipro'),
				),
				array(
					'type'          => Controls_Manager::SLIDER,
					'name'            => 'ticker_heading_width',
					'label'         => esc_html__( 'Heading/Date Width', 'uipro' ),
					'description'   => esc_html__( 'Heading/Date Width', 'uipro' ),
                    'responsive'    => true,
                    'size_units'    => ['px', '%'],
                    'range'         => [
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'condition'     => [
                        'layout_mode!'   => 'carousel',
                    ],
                    'default'   => [
                        'unit' => '%',
                    ],
                    'selectors'  => ['{{WRAPPER}} .ui-posts-scroller .ticker-heading' => 'flex: 0 0 {{SIZE}}{{UNIT}};',]
				),
                array(
                    'name'            => 'title_font',
                    'type'          => Group_Control_Typography::get_type(),
                    'label'         => esc_html__('Heading/Date Font', 'uipro'),
                    'description'   => esc_html__('Set Heading/Date font here.', 'uipro'),
                    'selector'      => '{{WRAPPER}} .ticker-heading',
                ),
                array(
                    'type'          => Controls_Manager::SWITCHER,
                    'name'            => 'show_shape',
                    'label'         => esc_html__( 'Show Heading Right Shape', 'uipro' ),
                    'description'   => esc_html__( 'Select \'Yes\' or \'No\' to show or hide shape right of the ticker heading.', 'uipro' ),
                    'default'       => 'yes',
                    'condition'     => [
                        'layout_mode!'   => ['scroller', 'carousel'],
                    ]
                ),
				array(
					'type'          => Controls_Manager::SELECT,
					'name'            => 'heading_shape',
					'label'         => esc_html__( 'Heading Shape', 'uipro' ),
					'description'   => esc_html__( 'There are three shape for heading like: arrow and left/right slanted. Select your desired one.', 'uipro' ),
                    'options'=>array(
                        'arrow'=> esc_html__('Arrow', 'uipro'),
                        'slanted-left'=> esc_html__('Slanted Left', 'uipro'),
                        'slanted-right'=> esc_html__('Slanted Right', 'uipro'),
                    ),
                    'default'       => 'arrow',
                    'condition'     => [
                        'layout_mode!'  => ['scroller', 'carousel'],
                        'show_shape'    => 'yes'
                    ]
				),
				array(
					'type'          => Controls_Manager::COLOR,
					'name'            => 'left_side_bg',
					'label'         => esc_html__( 'Heading/Date Background Color', 'uipro' ),
                    'condition'     => [
                        'layout_mode!'  => 'carousel',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .ticker-heading' => 'background-color: {{VALUE}};',
                        '{{WRAPPER}} .ticker-heading svg path' => 'fill: {{VALUE}};',
                        '{{WRAPPER}} .uiposts-scroller-ticker .ticker-date-time' => 'background-color: {{VALUE}};',
                    ],
				),
				array(
					'type'          => Controls_Manager::COLOR,
					'name'            => 'left_text_color',
					'label'         => esc_html__( 'Heading/Date Color', 'uipro' ),
                    'condition'     => [
                        'layout_mode!'  => 'carousel',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .ticker-heading' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .uiposts-scroller-ticker .ticker-date-time' => 'color: {{VALUE}}',
                    ],
				),
				array(
					'type'          => Controls_Manager::SWITCHER,
					'name'            => 'overlap_date_text',
					'label'         => esc_html__( 'Date Text Overlap', 'uipro' ),
					'description'   => esc_html__( 'If you want to overlap date text so that select \'Yes\'.', 'uipro' ),
                    'condition'     => [
                        'layout_mode!'  => ['ticker','carousel'],
                    ],
                    'default'       => 'no'
				),
				array(
					'type'          => Controls_Manager::COLOR,
					'name'            => 'overlap_text_color',
					'label'         => esc_html__( 'Right Side Background Color', 'uipro' ),
                    'condition'     => [
                        'layout_mode!'  => ['ticker','carousel'],
                        'overlap_date_text'  => 'yes',
                    ],
                    'selectors' => ['{{WRAPPER}} .ticker-heading' => 'color: {{VALUE}}'],
				),
				array(
                    'name'            => 'overlap_text_font',
                    'type'          => Group_Control_Typography::get_type(),
					'label'         => esc_html__( 'Right Side Title Font', 'uipro' ),
                    'condition'     => [
                        'layout_mode!'  => ['ticker','carousel'],
                        'overlap_date_text'  => 'yes',
                    ],
                    'selector' => '{{WRAPPER}} .slider-item .ticker-title',
				),

                // Content settings
                array(
                    'type'          => Controls_Manager::SWITCHER,
                    'id'            => 'show_introtext',
                    'label'         => esc_html__('Show Introtext', 'uipro'),
                    'description'   => esc_html__( 'Whether to show introtext.', 'uipro' ),
                    'label_on' => esc_html__( 'Yes', 'uipro' ),
                    'label_off' => esc_html__( 'No', 'uipro' ),
                    'return_value' => '1',
                    'default' => '1',
                    'start_section' => 'content_settings',
                    'section_name'  =>  esc_html__('Content Settings', 'uipro'),
                ),
                array(
                    'type'          => Controls_Manager::COLOR,
                    'name'            => 'content_introtext_color',
                    'label'         => esc_html__( 'Introtext Color', 'uipro' ),
                    'condition'     => ['show_introtext'  => '1'],
                    'selectors' => [
                        '{{WRAPPER}} .slider-item .ticker-introtext' => 'color: {{VALUE}}'
                    ],
                ),
                array(
                    'type'          => Controls_Manager::COLOR,
                    'name'            => 'content_bg',
                    'label'         => esc_html__( 'Background Color', 'uipro' ),
//                    'condition'     => [
//                        'layout_mode!'  => 'carousel',
//                    ],
                    'selectors' => ['{{WRAPPER}} .ticker-content' => 'background-color: {{VALUE}}'],
                ),
                array(
                    'type'          => Controls_Manager::COLOR,
                    'name'            => 'content_title_color',
                    'label'         => esc_html__( 'Title Color', 'uipro' ),
//                    'condition'     => [
//                        'layout_mode!'  => 'carousel',
//                    ],
                    'selectors' => [
                        '{{WRAPPER}} .slider-item .ticker-title' => 'color: {{VALUE}}'
                    ],
                ),
                array(
                    'type'          => Controls_Manager::COLOR,
                    'name'            => 'content_title_hover_color',
                    'label'         => esc_html__( 'Title Hover Color', 'uipro' ),
//                    'condition'     => [
//                        'layout_mode!'  => 'carousel',
//                    ],
                    'selectors' => [
                        '{{WRAPPER}} .slider-item .ticker-title:hover' => 'color: {{VALUE}}'
                    ],
                ),
                array(
                    'name'            => 'content_title_font',
                    'type'          => Group_Control_Typography::get_type(),
                    'label'         => esc_html__( 'Title Font', 'uipro' ),
//                    'condition'     => [
//                        'layout_mode!'  => 'carousel',
//                    ],
                    'selector' => '{{WRAPPER}} .slider-item .ticker-title',
                ),
                array(
                    'name'          => 'content_font',
                    'type'          => Group_Control_Typography::get_type(),
                    'label'         => esc_html__( 'Content Font', 'uipro' ),
                    'selector' => '{{WRAPPER}} .slider-item .ticker-introtext',
                ),
                array(
                    'name'          => 'content_date_font',
                    'type'          => Group_Control_Typography::get_type(),
                    'label'         => esc_html__( 'Content Date Font', 'uipro' ),
                    'selector' => '{{WRAPPER}} .slider-item .ticker-date-meta',
                ),
			);
			unset($post_types['post']);
            foreach ($post_types as $key => $value) {
                $post_type_category = array(
                    array(
                        'type'          => Controls_Manager::SELECT2,
                        'name'            => $key.'_category',
                        'label'         => esc_html__( 'Select Category', 'uipro' ),
                        'options'       => UIPro_Helper::get_cat_taxonomy( $key.'-category'),
                        'multiple'      => true,
                        'conditions' => [
                            'terms' => [
                                ['name' => 'resource', 'operator' => '===', 'value' => $key],
                            ],
                        ],
                    )
                );
                array_splice($options, 2, 0, $post_type_category);
            }
			$options    = array_merge($options, $this->get_general_options());

            static::$cache[$store_id]   = $options;

            return $options;
		}

        public function get_template_name() {
            return 'base';
        }

        public function editor_enqueue_scripts(){
            self::enqueue_scripts();
        }

	}
}