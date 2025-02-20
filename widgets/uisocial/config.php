<?php
/**
 * UIPro Social config class
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

use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;


if ( ! class_exists( 'UIPro_Config_UISocial' ) ) {
	/**
	 * Class UIPro_Config_UISocial
	 */
	class UIPro_Config_UISocial extends UIPro_Abstract_Config {

		/**
		 * UIPro_Config_UISocial constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'uisocial';
			self::$name = esc_html__( 'TemPlaza: UI Social', 'uipro' );
			self::$desc = esc_html__( 'Add UI Social Icon.', 'uipro' );
			self::$icon = 'eicon-social-icons';
			parent::__construct();

		}

        public function get_styles() {
            return ['el-uisocial' => array(
                'src'   => 'style.css'
            )];
        }

		/**
		 * @return array
		 */
		public function get_options() {

            $store_id   = md5(__METHOD__);

            if(isset(static::$cache[$store_id])){
                return static::$cache[$store_id];
            }

            $repeater = new Repeater();

            $repeater->add_control(
                'title',
                [
                    'label' => esc_html__( 'Title', 'uipro' ),
                    'type' => Controls_Manager::TEXT,
                ]
            );
            $repeater->add_control(
                'social_icon',
                [
                    'label' => esc_html__( 'Icon', 'uipro' ),
                    'type' => Controls_Manager::ICONS,
                    'fa4compatibility' => 'social',
                    'default' => [
                        'value' => 'fab fa-wordpress',
                        'library' => 'fa-brands',
                    ],
                    'recommended' => [
                        'fa-brands' => [
                            'android',
                            'apple',
                            'behance',
                            'bitbucket',
                            'codepen',
                            'delicious',
                            'deviantart',
                            'digg',
                            'dribbble',
                            'elementor',
                            'facebook',
                            'flickr',
                            'foursquare',
                            'free-code-camp',
                            'github',
                            'gitlab',
                            'globe',
                            'houzz',
                            'instagram',
                            'jsfiddle',
                            'linkedin',
                            'medium',
                            'meetup',
                            'mix',
                            'mixcloud',
                            'odnoklassniki',
                            'pinterest',
                            'product-hunt',
                            'reddit',
                            'shopping-cart',
                            'skype',
                            'slideshare',
                            'snapchat',
                            'soundcloud',
                            'spotify',
                            'stack-overflow',
                            'steam',
                            'telegram',
                            'thumb-tack',
                            'tripadvisor',
                            'tumblr',
                            'twitch',
                            'twitter',
                            'viber',
                            'vimeo',
                            'vk',
                            'weibo',
                            'weixin',
                            'whatsapp',
                            'wordpress',
                            'xing',
                            'yelp',
                            'youtube',
                            '500px',
                        ],
                        'fa-solid' => [
                            'envelope',
                            'link',
                            'rss',
                        ],
                    ],
                ]
            );

            $repeater->add_control(
                'link',
                [
                    'label' => esc_html__( 'Link', 'uipro' ),
                    'type' => Controls_Manager::URL,
                    'default' => [
                        'is_external' => 'true',
                    ],
                    'dynamic' => [
                        'active' => true,
                    ],
                    'placeholder' => esc_html__( 'https://your-link.com', 'uipro' ),
                ]
            );

            $repeater->add_control(
                'item_icon_color',
                [
                    'label' => esc_html__( 'Color', 'uipro' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'default',
                    'options' => [
                        'default' => esc_html__( 'Official Color', 'uipro' ),
                        'custom' => esc_html__( 'Custom', 'uipro' ),
                    ],
                ]
            );
            $repeater->add_control(
                'item_background_color',
                [
                    'label' => esc_html__( 'Background', 'uipro' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .ui-social-item {{CURRENT_ITEM}}' => 'background-color: {{VALUE}};'
                    ],
                    'condition' => [
                        'item_icon_color' => 'custom',
                    ],
                ]
            );
            $repeater->add_control(
                'item_color',
                [
                    'label' => esc_html__( 'Color', 'uipro' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .ui-social-item {{CURRENT_ITEM}}' => 'color: {{VALUE}};',
                    ],
                    'condition' => [
                        'item_icon_color' => 'custom',
                    ],
                ]
            );
            $repeater->add_control(
                'item_color_hover',
                [
                    'label' => esc_html__( 'Hover Color', 'uipro' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .ui-social-item {{CURRENT_ITEM}}:hover' => 'color: {{VALUE}};',
                    ],
                    'condition' => [
                        'item_icon_color' => 'custom',
                    ],
                ]
            );
            $repeater->add_control(
                'item_background_hover',
                [
                    'label' => esc_html__( 'Hover Background', 'uipro' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .ui-social-item {{CURRENT_ITEM}}.ui-social-icon-link:hover' => 'background-color: {{VALUE}};',
                    ],
                    'condition' => [
                        'item_icon_color' => 'custom',
                    ],
                ]
            );

//            $repeater->add_control(
//                'item_icon_primary_color',
//                [
//                    'label' => esc_html__( 'Primary Color', 'uipro' ),
//                    'type' => Controls_Manager::COLOR,
//                    'condition' => [
//                        'item_icon_color' => 'custom',
//                    ],
//                    'selectors' => [
//                        '{{WRAPPER}} {{CURRENT_ITEM}}.elementor-social-icon' => 'background-color: {{VALUE}};',
//                    ],
//                ]
//            );
//
//            $repeater->add_control(
//                'item_icon_secondary_color',
//                [
//                    'label' => esc_html__( 'Secondary Color', 'uipro' ),
//                    'type' => Controls_Manager::COLOR,
//                    'condition' => [
//                        'item_icon_color' => 'custom',
//                    ],
//                    'selectors' => [
//                        '{{WRAPPER}} {{CURRENT_ITEM}}.elementor-social-icon i' => 'color: {{VALUE}};',
//                        '{{WRAPPER}} {{CURRENT_ITEM}}.elementor-social-icon svg' => 'fill: {{VALUE}};',
//                    ],
//                ]
//            );

			// options
			$options = array(
			    array(
			        'name'  => 'social_icon_list',
                    'label' => esc_html__( 'Social Icons', 'uipro' ),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'social_icon' => [
                                'value' => 'fab fa-facebook',
                                'library' => 'fa-brands',
                            ],
                        ],
                        [
                            'social_icon' => [
                                'value' => 'fab fa-twitter',
                                'library' => 'fa-brands',
                            ],
                        ],
                        [
                            'social_icon' => [
                                'value' => 'fab fa-youtube',
                                'library' => 'fa-brands',
                            ],
                        ],
                    ],
                    'title_field' => '<# var migrated = "undefined" !== typeof __fa4_migrated, social = ( "undefined" === typeof social ) ? false : social; #>{{{ elementor.helpers.getSocialNetworkNameFromIcon( social_icon, social, true, migrated, true ) }}}',
                ),
                array(
                    'name'  => 'social_style',
                    'label' => esc_html__( 'Social Style','uipro' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => '',
                    'options' => [
                        '' => esc_html__( 'Default','uipro' ),
                        'magazine' => esc_html__( 'Magazine','uipro' ),
                    ],
                ),
                array(
                    'name'  => 'shape',
                    'label' => esc_html__( 'Shape', 'uipro' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        '' => esc_html__( 'Default', 'uipro' ),
                        'rounded' => esc_html__( 'Rounded', 'uipro' ),
                        'circle' => esc_html__( 'Circle', 'uipro' ),
                        'pill' => esc_html__( 'Pill', 'uipro' ),
                    ],
                    'default' => '',
                ),
//                array(
//                    'name'  => 'columns',
//                    'label' => esc_html__( 'Columns', 'uipro' ),
//                    'type' => Controls_Manager::SELECT,
////                    'default' => '0',
//                    'options' => [
//                        '0' => esc_html__( 'Auto', 'uipro' ),
//                        '1' => '1',
//                        '2' => '2',
//                        '3' => '3',
//                        '4' => '4',
//                        '5' => '5',
//                        '6' => '6',
//                    ],
//                    'responsive'    => true,
////                    'prefix_class' => 'elementor-grid%s-',
////                    'selectors' => [
////                        '{{WRAPPER}}' => '--grid-template-columns: repeat({{VALUE}}, auto);',
////                    ],
//                ),
                array(
                    'name'  => 'align',
                    'label' => esc_html__( 'Alignment', 'uipro' ),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'left'    => [
                            'title' => esc_html__( 'Left', 'uipro' ),
                            'icon' => 'eicon-text-align-left',
                        ],
                        'center' => [
                            'title' => esc_html__( 'Center', 'uipro' ),
                            'icon' => 'eicon-text-align-center',
                        ],
                        'right' => [
                            'title' => esc_html__( 'Right', 'uipro' ),
                            'icon' => 'eicon-text-align-right',
                        ],
                    ],
                    'responsive'    => true,
                    'prefix_class' => 'e-grid-align%s-',
                    'default' => 'center',
                    'selectors' => [
                        '{{WRAPPER}} .ui-social' => 'text-align: {{VALUE}}',
                    ],
                ),
                array(
                    'name'  => 'view',
                    'label' => esc_html__( 'View', 'uipro' ),
                    'type' => Controls_Manager::HIDDEN,
                    'default' => 'traditional',
                ),
                array(
                    'name'  => 'columns_large_desktop',
                    'type' => Controls_Manager::SELECT,
                    'label' => esc_html__( 'Columns Large Desktop','uipro' ),
                    'description' => esc_html__( 'Set the grid gutter width.','uipro' ),
                    'options' => [
                        'auto' =>  esc_html__('Auto','uipro'),
                        '1-1' =>  esc_html__('1 Column','uipro'),
                        '1-2' =>  esc_html__('2 Columns','uipro'),
                        '1-3' =>  esc_html__('3 Columns','uipro'),
                        '1-4' =>  esc_html__('4 Columns','uipro'),
                        '1-5' =>  esc_html__('5 Columns','uipro'),
                        '1-6' =>  esc_html__('6 Columns','uipro'),
                    ],
                    'default' => 'auto',
//                    'start_section' => 'column_section_style',
//                    'section_tab'   => Controls_Manager::TAB_STYLE,
//                    'section_name'  => esc_html__( 'Column', 'uipro' ),
                ),
                array(
                    'name'  => 'columns_desktop',
                    'type' => Controls_Manager::SELECT,
                    'label' => esc_html__( 'Columns Desktop','uipro' ),
                    'description' => esc_html__( 'Set the grid gutter width.','uipro' ),
                    'options' => [
                        'auto' =>  esc_html__('Auto','uipro'),
                        '1-1' =>  esc_html__('1 Column','uipro'),
                        '1-2' =>  esc_html__('2 Columns','uipro'),
                        '1-3' =>  esc_html__('3 Columns','uipro'),
                        '1-4' =>  esc_html__('4 Columns','uipro'),
                        '1-5' =>  esc_html__('5 Columns','uipro'),
                        '1-6' =>  esc_html__('6 Columns','uipro'),
                    ],
                    'default' => 'auto',
                ),
                array(
                    'name'  => 'columns_laptop',
                    'type' => Controls_Manager::SELECT,
                    'label' => esc_html__( 'Columns Laptop','uipro' ),
                    'description' => esc_html__( 'Set the grid gutter width.','uipro' ),
                    'options' => [
                        'auto' =>  esc_html__('Auto','uipro'),
                        '1-1' =>  esc_html__('1 Column','uipro'),
                        '1-2' =>  esc_html__('2 Columns','uipro'),
                        '1-3' =>  esc_html__('3 Columns','uipro'),
                        '1-4' =>  esc_html__('4 Columns','uipro'),
                        '1-5' =>  esc_html__('5 Columns','uipro'),
                        '1-6' =>  esc_html__('6 Columns','uipro'),
                    ],
                    'default' => 'auto',
                ),
                array(
                    'name'  => 'columns_tablet',
                    'type' => Controls_Manager::SELECT,
                    'label' => esc_html__( 'Columns Tablet','uipro' ),
                    'description' => esc_html__( 'Set the grid gutter width.','uipro' ),
                    'options' => [
                        'auto' =>  esc_html__('Auto','uipro'),
                        '1-1' =>  esc_html__('1 Column','uipro'),
                        '1-2' =>  esc_html__('2 Columns','uipro'),
                        '1-3' =>  esc_html__('3 Columns','uipro'),
                        '1-4' =>  esc_html__('4 Columns','uipro'),
                        '1-5' =>  esc_html__('5 Columns','uipro'),
                        '1-6' =>  esc_html__('6 Columns','uipro'),
                    ],
                    'default' => 'auto',
                ),
                array(
                    'name'  => 'columns_mobile',
                    'type' => Controls_Manager::SELECT,
                    'label' => esc_html__( 'Columns Mobile','uipro' ),
                    'description' => esc_html__( 'Set the grid gutter width.','uipro' ),
                    'options' => [
                        'auto' =>  esc_html__('Auto','uipro'),
                        '1-1' =>  esc_html__('1 Column','uipro'),
                        '1-2' =>  esc_html__('2 Columns','uipro'),
                        '1-3' =>  esc_html__('3 Columns','uipro'),
                        '1-4' =>  esc_html__('4 Columns','uipro'),
                        '1-5' =>  esc_html__('5 Columns','uipro'),
                        '1-6' =>  esc_html__('6 Columns','uipro'),
                    ],
                    'default' => 'auto',
                ),
                array(
                    'name'  => 'gutter',
                    'type' => Controls_Manager::SELECT,
                    'label' => esc_html__( 'Gutter','uipro' ),
                    'description' => esc_html__( 'Set the grid gutter width.','uipro' ),
                    'options' => [
                        '' =>  esc_html__('Default','uipro'),
                        'small' =>  esc_html__('Small','uipro'),
                        'medium' =>  esc_html__('Medium','uipro'),
                        'large' =>  esc_html__('Large','uipro'),
                    ],
                    'default' => 'small',
                ),
                array(
                    'name'  => 'icon_color',
                    'label' => esc_html__( 'Color','uipro' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'default',
                    'options' => [
                        'default' => esc_html__( 'Official Color','uipro' ),
                        'custom' => esc_html__( 'Custom','uipro' ),
                    ],
                    'start_section' => 'icon_section_style',
                    'section_tab'   => Controls_Manager::TAB_STYLE,
                    'section_name'  => esc_html__( 'Icon', 'uipro' ),
                ),
                array(
                    'name'  => 'icon_primary_color',
                    'label' => esc_html__( 'Primary Color','uipro' ),
                    'type' => Controls_Manager::COLOR,
                    'condition' => [
                        'icon_color' => 'custom',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .ui-social-icon-link' => 'background-color: {{VALUE}};',
                    ],
                ),
                array(
                    'name'  => 'icon_secondary_color',
                    'label' => esc_html__( 'Secondary Color','uipro' ),
                    'type' => Controls_Manager::COLOR,
                    'condition' => [
                        'icon_color' => 'custom',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .ui-social-icon-link i' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .ui-social-icon-link svg' => 'fill: {{VALUE}};',
                    ],
                ),
                array(
                    'name'  => 'icon_size',
                    'label' => esc_html__( 'Size','uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'responsive'    => true,
                    'range' => [
                        'px' => [
                            'min' => 6,
                            'max' => 300,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}}' => '--icon-size: {{SIZE}}{{UNIT}}',
                    ],
                ),
                array(
                    'name'  => 'icon_padding',
                    'label' => esc_html__( 'Padding','uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'responsive'    => true,
                    'selectors' => [
                        '{{WRAPPER}} .elementor-social-icon' => '--icon-padding: {{SIZE}}{{UNIT}}',
                    ],
                    'default' => [
                        'unit' => 'em',
                    ],
                    'tablet_default' => [
                        'unit' => 'em',
                    ],
                    'mobile_default' => [
                        'unit' => 'em',
                    ],
                    'range' => [
                        'em' => [
                            'min' => 0,
                            'max' => 5,
                        ],
                    ],
                ),
                array(
                    'name'  => 'icon_spacing',
                    'label' => esc_html__( 'Spacing','uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'responsive'    => true,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'size' => 5,
                    ],
                    'selectors' => [
                        '{{WRAPPER}}' => '--grid-column-gap: {{SIZE}}{{UNIT}}',
                    ],
                ),
                array(
                    'name'  => 'row_gap',
                    'label' => esc_html__( 'Rows Gap','uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'responsive'    => true,
                    'default' => [
                        'size' => 0,
                    ],
                    'selectors' => [
                        '{{WRAPPER}}' => '--grid-row-gap: {{SIZE}}{{UNIT}}',
                    ],
                ),
                array(
                    'type'          =>  \Elementor\Group_Control_Border::get_type(),
                    'name' => 'image_border', // We know this mistake - TODO: 'icon_border' (for hover control condition also)
                    'selector' => '{{WRAPPER}} .elementor-social-icon',
                    'separator' => 'before',
                ),
                array(
                    'name'  => 'border_radius',
                    'label' => esc_html__( 'Border Radius','uipro' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .elementor-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ),

                // Hover
                array(
                    'name'  => 'hover_primary_color',
                    'label' => esc_html__( 'Primary Color','uipro' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'condition' => [
                        'icon_color' => 'custom',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .ui-social-icon-link:hover' => 'background-color: {{VALUE}};',
                    ],
                    'start_section' => 'icon_hover_section_style',
                    'section_tab'   => Controls_Manager::TAB_STYLE,
                    'section_name'  => esc_html__( 'Icon Hover', 'uipro' ),
                ),
                array(
                    'name'  => 'hover_secondary_color',
                    'label' => esc_html__( 'Secondary Color','uipro' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'condition' => [
                        'icon_color' => 'custom',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .ui-social-icon-link:hover i' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .ui-social-icon-link:hover svg' => 'fill: {{VALUE}};',
                    ],
                ),
                array(
                    'name'  => 'hover_border_color',
                    'label' => esc_html__( 'Border Color','uipro' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'condition' => [
                        'image_border_border!' => '',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .elementor-social-icon:hover' => 'border-color: {{VALUE}};',
                    ],
                ),
                array(
                    'name'  => 'hover_animation',
                    'label' => esc_html__( 'Hover Animation','uipro' ),
                    'type' => Controls_Manager::HOVER_ANIMATION,
                ),
            );
			$options    = array_merge($options, $this->get_general_options());

			static::$cache[$store_id]   = $options;

			return $options;
		}

		public function get_template_name() {
			return 'base';
		}
	}
}