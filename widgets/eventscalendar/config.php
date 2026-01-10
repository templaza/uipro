<?php
/**
 * UIPro Events Calendar config class
 *
 * @version     1.0.0
 * @author      TemPlaza.com
 * @package     UIPro/Classes
 * @category    Classes
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;


if ( ! class_exists( 'UIPro_Config_EventsCalendar' ) ) {
	/**
	 * Class UIPro_Config_Accordion
	 */
	class UIPro_Config_EventsCalendar extends UIPro_Abstract_Config {

		/**
		 * UIPro_Config_EventsCalendar constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'eventscalendar';
			self::$name = esc_html__( 'TemPlaza: Events Calendars', 'uipro' );
			self::$desc = esc_html__( 'Display Events Calendars.', 'uipro' );
			self::$icon = 'eicon-calendar';
			parent::__construct();
		}

		/**
		 * @return array
		 */
		public function get_options() {
            $store_id   = md5(__METHOD__);

            if(isset(static::$cache[$store_id])){
                return static::$cache[$store_id];
            }

            $options = array(
                //Content Setting
                array(
                    'id'          => 'layout',
                    'label' => esc_html__( 'Layout', 'uipro' ),
                    'type' => Controls_Manager::SELECT,
                    'options'       => array(
                        'base'    => esc_html__('Default', 'uipro'),
                        'list'    => esc_html__('List', 'uipro'),
                    ),
                    'default'   => 'base',
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'cat_id',
                    'label'         => esc_html__( 'Select Category', 'uipro' ),
                    'options'       => UIPro_Helper::get_cat_taxonomy(
                        'tribe_events_cat',
                        array( 'all'  => esc_html__( 'All', 'uipro' ))
                    ),
                    'default'       => 'all'
                ),
                array(
                    'type'          => Controls_Manager::NUMBER,
                    'name'          => 'number_events_calendars',
                    'show_label'    => true,
                    'label'         => esc_html__( 'Number Events Calendars', 'uipro' ),
                    'default'       => '4',
                ),

                //Title
                array(
                    'type'          => Group_Control_Typography::get_type(),
                    'name'          => 'title_typography',
                    'label'         => esc_html__('Title Font', 'uipro'),
                    'description'   => esc_html__('Select a font family, font size for the event title.', 'uipro'),
                    'selector'      => '{{WRAPPER}} .uk-card-title a',
                ),
                array(
                    'type'          => Controls_Manager::COLOR,
                    'name'          => 'title_color',
                    'label'         => esc_html__('Title Color', 'uipro'),
                    'description'   => esc_html__('Set the color of event title.', 'uipro'),
                    'selectors'     => [
                        '{{WRAPPER}} .uk-card-title, {{WRAPPER}} .uk-card-title a' => 'color: {{VALUE}}',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'title_heading_style',
                    'default'       => 'h4',
                    'label'         => esc_html__('Heading Style', 'uipro'),
                    'options'       => array(
                        'h1' => esc_html__('H1', 'uipro'),
                        'h2' => esc_html__('H2', 'uipro'),
                        'h3' => esc_html__('H3', 'uipro'),
                        'h4' => esc_html__('H4', 'uipro'),
                        'h5' => esc_html__('H5', 'uipro'),
                        'h6' => esc_html__('H6', 'uipro'),
                    ),
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'title_heading_margin',
                    'label'         => esc_html__('Title Margin', 'uipro'),
                    'options'       => array(
                        ''          => esc_html__('Inherit', 'uipro'),
                        'small'     => esc_html__('Small', 'uipro'),
                        'medium'    => esc_html__('Medium', 'uipro'),
                        'large'     => esc_html__('Large', 'uipro'),
                        'xlarge'    => esc_html__('X-Large', 'uipro'),
                        'custom'    => esc_html__('Custom', 'uipro'),
                        'remove'    => esc_html__('None', 'uipro'),
                    ),
                    'default'       => '',
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'title_custom_margin',
                    'label'         => esc_html__('Custom Title Margin', 'uipro'),
                    'responsive'    => true,
                    'size_units'    => ['px'],
                    'selectors'     => [
                        '{{WRAPPER}} .uk-card-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition'     => [
                        'title_heading_margin' => 'custom',
                    ],
                ),

                //star date -> end-date
                array(
                    'type'          => Group_Control_Typography::get_type(),
                    'name'          => 'date_typography',
                    'label'         => esc_html__('Star, End Date Font', 'uipro'),
                    'description'   => esc_html__('Select font family and size for the event date/time.', 'uipro'),
                    'selector'      => '{{WRAPPER}} .event-date',
                ),
                array(
                    'type'          => Controls_Manager::COLOR,
                    'name'          => 'date_color',
                    'label'         => esc_html__('Star, End Date Color', 'uipro'),
                    'description'   => esc_html__('Set the color of the event date/time.', 'uipro'),
                    'selectors'     => [
                        '{{WRAPPER}} .event-date' => 'color: {{VALUE}}',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'date_margin_style',
                    'label'         => esc_html__('Star, End Date Margin', 'uipro'),
                    'options'       => array(
                        ''          => esc_html__('Inherit', 'uipro'),
                        'small'     => esc_html__('Small', 'uipro'),
                        'medium'    => esc_html__('Medium', 'uipro'),
                        'large'     => esc_html__('Large', 'uipro'),
                        'xlarge'    => esc_html__('X-Large', 'uipro'),
                        'custom'    => esc_html__('Custom', 'uipro'),
                        'remove'    => esc_html__('None', 'uipro'),
                    ),
                    'default'       => '',
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'date_custom_margin',
                    'label'         => esc_html__('Custom Star, End Date Margin', 'uipro'),
                    'responsive'    => true,
                    'size_units'    => ['px'],
                    'selectors'     => [
                        '{{WRAPPER}} .event-date' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition'     => [
                        'date_margin_style' => 'custom',
                    ],
                ),

                //price
                array(
                    'type'          => Group_Control_Typography::get_type(),
                    'name'          => 'price_typography',
                    'label'         => esc_html__('Price Font', 'uipro'),
                    'description'   => esc_html__('Select font family and size for the event price.', 'uipro'),
                    'selector'      => '{{WRAPPER}} .uk-price',
                ),
                array(
                    'type'          => Controls_Manager::COLOR,
                    'name'          => 'price_color',
                    'label'         => esc_html__('Price Color', 'uipro'),
                    'description'   => esc_html__('Set the color of the event Price.', 'uipro'),
                    'selectors'     => [
                        '{{WRAPPER}} .uk-price' => 'color: {{VALUE}}',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'price_margin_style',
                    'label'         => esc_html__('Price Margin', 'uipro'),
                    'options'       => array(
                        ''          => esc_html__('Inherit', 'uipro'),
                        'small'     => esc_html__('Small', 'uipro'),
                        'medium'    => esc_html__('Medium', 'uipro'),
                        'large'     => esc_html__('Large', 'uipro'),
                        'xlarge'    => esc_html__('X-Large', 'uipro'),
                        'custom'    => esc_html__('Custom', 'uipro'),
                        'remove'    => esc_html__('None', 'uipro'),
                    ),
                    'default'       => '',
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'price_custom_margin',
                    'label'         => esc_html__('Custom Price Margin', 'uipro'),
                    'responsive'    => true,
                    'size_units'    => ['px'],
                    'selectors'     => [
                        '{{WRAPPER}} .uk-price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition'     => [
                        'date_margin_style' => 'custom',
                    ],
                ),


                //day
                array(
                    'type'          => Group_Control_Typography::get_type(),
                    'name'          => 'day_typography',
                    'label'         => esc_html__('Day Font', 'uipro'),
                    'description'   => esc_html__('Set typography for the day number.', 'uipro'),
                    'selector'      => '{{WRAPPER}} .event-day',
                ),
                array(
                    'type'          => Controls_Manager::COLOR,
                    'name'          => 'day_color',
                    'label'         => esc_html__('Day Color', 'uipro'),
                    'description'   => esc_html__('Set color for the day number.', 'uipro'),
                    'selectors'     => [
                        '{{WRAPPER}} .event-day' => 'color: {{VALUE}}',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'day_custom_margin',
                    'label'         => esc_html__('Day Margin', 'uipro'),
                    'responsive'    => true,
                    'size_units'    => ['px'],
                    'selectors'     => [
                        '{{WRAPPER}} .event-day' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ),


                //month
                array(
                    'type'          => Group_Control_Typography::get_type(),
                    'name'          => 'month_typography',
                    'label'         => esc_html__('Month & Year Font', 'uipro'),
                    'description'   => esc_html__('Set typography for month and year text.', 'uipro'),
                    'selector'      => '{{WRAPPER}} .event-month',
                ),
                array(
                    'type'          => Controls_Manager::COLOR,
                    'name'          => 'month_color',
                    'label'         => esc_html__('Month & Year Color', 'uipro'),
                    'description'   => esc_html__('Set color for month and year text.', 'uipro'),
                    'selectors'     => [
                        '{{WRAPPER}} .event-month' => 'color: {{VALUE}}',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'month_custom_margin',
                    'label'         => esc_html__('Month & Year Margin', 'uipro'),
                    'responsive'    => true,
                    'size_units'    => ['px'],
                    'selectors'     => [
                        '{{WRAPPER}} .event-month' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ),



                //Events Calendar Settings
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'event_style',
                    'label'         => esc_html__( 'Card Style', 'uipro' ),
                    'default'       => '',
                    'options'       => [
                        '' => esc_html__('None', 'uipro'),
                        'default' => esc_html__('Card Default', 'uipro'),
                        'primary' => esc_html__('Card Primary', 'uipro'),
                        'secondary' => esc_html__('Card Secondary', 'uipro'),
                        'hover' => esc_html__('Card Hover', 'uipro'),
                        'custom' => esc_html__('Custom', 'uipro'),
                    ],
                    'start_section' => 'card_settings',
                    'section_name'  => esc_html__('Card Settings', 'uipro')
                ),
                array(
                    'type'        => Controls_Manager::COLOR,
                    'name'        => 'card_background',
                    'label'       => esc_html__('Card Background', 'uipro'),
                    'selectors'   => [
                        '{{WRAPPER}} .templaza-list-events .uk-card' => 'background-color: {{VALUE}};',
                    ],
                    'condition' => [
                        'card_style' => 'custom',
                    ],
                ),
                array(
                    'type'        => Controls_Manager::COLOR,
                    'name'        => 'card_color',
                    'label'       => esc_html__('Card Color', 'uipro'),
                    'selectors'   => [
                        '{{WRAPPER}} .templaza-list-events .uk-card' => 'color: {{VALUE}};',
                    ],
                    'condition' => [
                        'card_style' => 'custom',
                    ],
                ),
                array(
                    'type'        => Controls_Manager::SELECT,
                    'name'        => 'card_size',
                    'label'       => esc_html__( 'Card Size', 'uipro' ),
                    'default'     => '',
                    'options'     => [
                        'none' => esc_html__('None', 'uipro'),
                        '' => esc_html__('Default', 'uipro'),
                        'small' => esc_html__('Small', 'uipro'),
                        'large' => esc_html__('Large', 'uipro'),
                        'custom' => esc_html__('Custom', 'uipro'),
                    ],
                ),
                array(
                    'type'       => Controls_Manager::COLOR,
                    'name'       => 'card_title_color_hover',
                    'label'      => esc_html__('Card Hover Title Color', 'uipro'),
                    'selectors'  => [
                        '{{WRAPPER}} .templaza-list-events .uk-card:hover .uk-card-title' => 'color: {{VALUE}};',
                    ],
                    'condition'  => [
                        'card_style' => 'custom',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          => 'card_padding',
                    'label'         => esc_html__( 'Card Padding', 'uipro' ),
                    'responsive'    => true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .templaza-list-events .uk-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition' => [
                        'card_size' => 'custom',
                    ],
                ),
                array(
                    'type'        => Controls_Manager::DIMENSIONS,
                    'name'        => 'card_radius',
                    'label'       => esc_html__( 'Border Radius', 'uipro' ),
                    'responsive'  => true,
                    'size_units'  => [ 'px', 'em', '%' ],
                    'selectors'   => [
                        '{{WRAPPER}} .templaza-list-events .uk-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;',
                    ],
                ),
                array(
                    'type'        => \Elementor\Group_Control_Border::get_type(),
                    'name'        => 'card_border',
                    'selector'    => '{{WRAPPER}} .templaza-list-events .uk-card',
                ),
                array(
                    'type'        => \Elementor\Group_Control_Box_Shadow::get_type(),
                    'name'        => 'card_box_shadow',
                    'selector'    => '{{WRAPPER}} .templaza-list-events .uk-card',
                ),
                array(
                    'type'        => Controls_Manager::DIMENSIONS,
                    'name'        => 'image_border_radius',
                    'label'       => esc_html__( 'Image Border Radius', 'uipro' ),
                    'responsive'  => true,
                    'size_units'  => [ 'px', 'em', '%' ],
                    'selectors'   => [
                        '{{WRAPPER}} .templaza-list-events .ui-media img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition'   => [
                        'layout' => 'list', // hoặc bỏ hẳn dòng này để hiện cho mọi layout
                    ],
                ),
                array(
                    'type'          => \Elementor\Group_Control_Border::get_type(),
                    'name'          => 'card_border_hover',
                    'label'         => esc_html__('Card Border Hover', 'uipro'),
                    'description'   => esc_html__('Set the border style of the card on mouse hover.', 'uipro'),
                    'selector'      => '{{WRAPPER}} .templaza-list-events .uk-card:hover',
                    'condition'     => [
                        'card_style' => 'custom',
                    ],
                ),



                //Content style
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
                    'section_name'  => esc_html__('Content Settings', 'uipro')
                ),
                array(
                    'type'      => Controls_Manager::NUMBER,
                    'name'      => 'introtext_number',
                    'label'     => esc_html__( 'Limit Words', 'uipro' ),
                    'conditions' => [
                        'terms' => [
                            ['name' => 'show_introtext', 'operator' => '===', 'value' => '1'],
                        ],
                    ],
                ),
                array(
                    'name'          => 'content_font_family',
                    'type'          => Group_Control_Typography::get_type(),
                    'label'         => esc_html__('Content Font', 'uipro'),
                    'description'   => esc_html__('Select a font family, font size for the addon content.', 'uipro'),
                    'selector'      => '{{WRAPPER}} .templaza-list-events .ui-post-introtext',
                ),
                array(
                    'id'            => 'content_color',
                    'type'          =>  Controls_Manager::COLOR,
                    'label'         => esc_html__('Custom Color', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .templaza-list-events' => 'color: {{VALUE}}',
                    ],
                ),
                array(
                    'type'          => Controls_Manager::SWITCHER,
                    'id'            => 'content_dropcap',
                    'label'         => esc_html__('Drop Cap', 'uipro'),
                    'description'   => esc_html__('Display the first letter of the paragraph as a large initial.', 'uipro'),
                    'label_on'      => esc_html__( 'Yes', 'uipro' ),
                    'label_off'     => esc_html__( 'No', 'uipro' ),
                    'return_value'  => '1',
                    'default'       => '0',
                ),

                //List Setting
                array(
                    'id'          => 'list_align_items',
                    'label' => esc_html__( 'List align items', 'uipro' ),
                    'type' => Controls_Manager::CHOOSE,
                    'default' => '',
                    'options' => [
                        'flex-start' => [
                            'title' => esc_html__( 'Start', 'elementor' ),
                            'icon' => 'eicon-flex eicon-align-start-v',
                        ],
                        'center' => [
                            'title' => esc_html__( 'Center', 'elementor' ),
                            'icon' => 'eicon-flex eicon-align-center-v',
                        ],
                        'flex-end' => [
                            'title' => esc_html__( 'End', 'elementor' ),
                            'icon' => 'eicon-flex eicon-align-end-v',
                        ],
                        'stretch' => [
                            'title' => esc_html__( 'Stretch', 'elementor' ),
                            'icon' => 'eicon-flex eicon-align-stretch-v',
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .uk-card-list' => 'align-items: {{VALUE}};',
                    ],
                    'responsive' => true,
                    'separator'     => 'before',
                    'start_section' => 'list',
                    'section_name'      => esc_html__('List Settings', 'uipro'),
                    'condition'     => array(
                        'layout'    => 'list'
                    ),
                ),
                array(
                    'id'          => 'meta_desktop_width',
                    'label' => esc_html__( 'Meta Title Width', 'uipro' ),
                    'type' => Controls_Manager::SELECT,
                    'options'       => array(
                        'uk-width-1-1'    => esc_html__('1/1', 'uipro'),
                        'uk-width-1-2'    => esc_html__('1/2', 'uipro'),
                        'uk-width-1-3'    => esc_html__('1/3', 'uipro'),
                        'uk-width-1-4'    => esc_html__('1/4', 'uipro'),
                        'uk-width-1-5'    => esc_html__('1/5', 'uipro'),
                        'uk-width-1-6'    => esc_html__('1/6', 'uipro'),
                        'uk-width-auto'    => esc_html__('auto', 'uipro'),
                        'uk-width-expand'    => esc_html__('expand', 'uipro'),
                        'custom'    => esc_html__('Custom', 'uipro'),
                    ),
                    'default'   => 'uk-width-1-6',
                    'separator'     => 'before',
                    'start_section' => 'list',
                    'section_name'      => esc_html__('List Settings', 'uipro'),
                    'condition'     => array(
                        'layout'    => 'list'
                    ),
                ),
                array(
                    'id'          => 'meta_width_custom',
                    'label' => __( 'Meta custom width', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px','%' ],
                    'responsive'    =>  true,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'unit' => '%',
                        'size' => 10,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .uk-card-meta' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'meta_desktop_width', 'operator' => '===', 'value' => 'custom'],
                        ],
                    ],
                ),
                array(
                    'type'         => Controls_Manager::CHOOSE,
                    'label'         => esc_html__( 'Meta alignment', 'uipro' ),
                    'name'          => 'meta_list_align',
                    'responsive'    => true, /* this will be add in responsive layout */
                    'options'       => [
                        'left'      => [
                            'title' => esc_html__( 'Left', 'uipro' ),
                            'icon'  => 'eicon-text-align-left',
                        ],
                        'center'    => [
                            'title' => esc_html__( 'Center', 'uipro' ),
                            'icon'  => 'eicon-text-align-center',
                        ],
                        'right'     => [
                            'title' => esc_html__( 'Right', 'uipro' ),
                            'icon'  => 'eicon-text-align-right',
                        ],
                        'justify'   => [
                            'title' => esc_html__( 'Justified', 'uipro' ),
                            'icon'  => 'eicon-text-align-justify',
                        ],
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .uk-card-meta'   => 'text-align: {{VALUE}}; align-items: {{VALUE}};',
                    ],
                ),
                array(
                    'id'          => 'image_desktop_width',
                    'label' => esc_html__( 'Image Width', 'uipro' ),
                    'type' => Controls_Manager::SELECT,
                    'options'       => array(
                        'uk-width-1-1'    => esc_html__('1/1', 'uipro'),
                        'uk-width-1-2'    => esc_html__('1/2', 'uipro'),
                        'uk-width-1-3'    => esc_html__('1/3', 'uipro'),
                        'uk-width-1-4'    => esc_html__('1/4', 'uipro'),
                        'uk-width-1-5'    => esc_html__('1/5', 'uipro'),
                        'uk-width-1-6'    => esc_html__('1/6', 'uipro'),
                        'uk-width-auto'    => esc_html__('auto', 'uipro'),
                        'uk-width-expand'    => esc_html__('expand', 'uipro'),
                        'custom'    => esc_html__('Custom', 'uipro'),
                    ),
                    'default'   => 'uk-width-1-6',
                    'separator'     => 'before',
                    'start_section' => 'list',
                    'section_name'      => esc_html__('List Settings', 'uipro'),
                    'condition'     => array(
                        'layout'    => 'list'
                    ),
                ),
                array(
                    'id'          => 'image_width_custom',
                    'label' => __( 'Image custom width', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px','%' ],
                    'responsive'    =>  true,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'unit' => '%',
                        'size' => 20,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .ui-media-wrap' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'image_desktop_width', 'operator' => '===', 'value' => 'custom'],
                        ],
                    ],
                ),
                array(
                    'type'         => Controls_Manager::CHOOSE,
                    'label'         => esc_html__( 'Image alignment', 'uipro' ),
                    'name'          => 'image_list_align',
                    'responsive'    => true, /* this will be add in responsive layout */
                    'options'       => [
                        'left'      => [
                            'title' => esc_html__( 'Left', 'uipro' ),
                            'icon'  => 'eicon-text-align-left',
                        ],
                        'center'    => [
                            'title' => esc_html__( 'Center', 'uipro' ),
                            'icon'  => 'eicon-text-align-center',
                        ],
                        'right'     => [
                            'title' => esc_html__( 'Right', 'uipro' ),
                            'icon'  => 'eicon-text-align-right',
                        ],
                        'justify'   => [
                            'title' => esc_html__( 'Justified', 'uipro' ),
                            'icon'  => 'eicon-text-align-justify',
                        ],
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .uk-card-meta'   => 'text-align: {{VALUE}}; align-items: {{VALUE}};',
                    ],
                ),
                array(
                    'id'          => 'content_desktop_width',
                    'label' => esc_html__( 'Content Width', 'uipro' ),
                    'type' => Controls_Manager::SELECT,
                    'options'       => array(
                        'uk-width-1-1'    => esc_html__('1/1', 'uipro'),
                        'uk-width-1-2'    => esc_html__('1/2', 'uipro'),
                        'uk-width-1-3'    => esc_html__('1/3', 'uipro'),
                        'uk-width-1-4'    => esc_html__('1/4', 'uipro'),
                        'uk-width-1-5'    => esc_html__('1/5', 'uipro'),
                        'uk-width-1-6'    => esc_html__('1/6', 'uipro'),
                        'uk-width-auto'    => esc_html__('auto', 'uipro'),
                        'uk-width-expand'    => esc_html__('expand', 'uipro'),
                        'custom'    => esc_html__('Custom', 'uipro'),
                    ),
                    'default'   => 'uk-width-1-2',
                    'separator'     => 'before',
                    'start_section' => 'list',
                    'section_name'      => esc_html__('List Settings', 'uipro'),
                    'condition'     => array(
                        'layout'    => 'list'
                    ),
                ),
                array(
                    'id'          => 'content_width_custom',
                    'label' => __( 'Content custom width', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px','%' ],
                    'responsive'    =>  true,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'unit' => '%',
                        'size' => 40,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .ui-card-text' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'content_desktop_width', 'operator' => '===', 'value' => 'custom'],
                        ],
                    ],
                ),
                array(
                    'type'         => Controls_Manager::CHOOSE,
                    'label'         => esc_html__( 'Content alignment', 'uipro' ),
                    'name'          => 'content_list_align',
                    'responsive'    => true, /* this will be add in responsive layout */
                    'options'       => [
                        'left'      => [
                            'title' => esc_html__( 'Left', 'uipro' ),
                            'icon'  => 'eicon-text-align-left',
                        ],
                        'center'    => [
                            'title' => esc_html__( 'Center', 'uipro' ),
                            'icon'  => 'eicon-text-align-center',
                        ],
                        'right'     => [
                            'title' => esc_html__( 'Right', 'uipro' ),
                            'icon'  => 'eicon-text-align-right',
                        ],
                        'justify'   => [
                            'title' => esc_html__( 'Justified', 'uipro' ),
                            'icon'  => 'eicon-text-align-justify',
                        ],
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-card-text'   => 'text-align: {{VALUE}}; align-items: {{VALUE}};',
                    ],
                ),
                array(
                    'id'          => 'button_desktop_width',
                    'label' => esc_html__( 'Button Width', 'uipro' ),
                    'type' => Controls_Manager::SELECT,
                    'options'       => array(
                        'uk-width-1-1'    => esc_html__('1/1', 'uipro'),
                        'uk-width-1-2'    => esc_html__('1/2', 'uipro'),
                        'uk-width-1-3'    => esc_html__('1/3', 'uipro'),
                        'uk-width-1-4'    => esc_html__('1/4', 'uipro'),
                        'uk-width-1-5'    => esc_html__('1/5', 'uipro'),
                        'uk-width-1-6'    => esc_html__('1/6', 'uipro'),
                        'uk-width-auto'    => esc_html__('auto', 'uipro'),
                        'uk-width-expand'    => esc_html__('expand', 'uipro'),
                        'custom'    => esc_html__('Custom', 'uipro'),
                    ),
                    'default'   => 'uk-width-1-6',
                    'separator'     => 'before',
                    'start_section' => 'list',
                    'section_name'      => esc_html__('List Settings', 'uipro'),
                    'condition'     => array(
                        'layout'    => 'list'
                    ),
                ),
                array(
                    'id'          => 'button_width_custom',
                    'label' => __( 'Button custom width', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px','%' ],
                    'responsive'    =>  true,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'unit' => '%',
                        'size' => 10,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .ui-button' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'button_desktop_width', 'operator' => '===', 'value' => 'custom'],
                        ],
                    ],
                ),
                array(
                    'type'         => Controls_Manager::CHOOSE,
                    'label'         => esc_html__( 'Button alignment', 'uipro' ),
                    'name'          => 'button_list_align',
                    'responsive'    => true, /* this will be add in responsive layout */
                    'options'       => [
                        'left'      => [
                            'title' => esc_html__( 'Left', 'uipro' ),
                            'icon'  => 'eicon-text-align-left',
                        ],
                        'center'    => [
                            'title' => esc_html__( 'Center', 'uipro' ),
                            'icon'  => 'eicon-text-align-center',
                        ],
                        'right'     => [
                            'title' => esc_html__( 'Right', 'uipro' ),
                            'icon'  => 'eicon-text-align-right',
                        ],
                        'justify'   => [
                            'title' => esc_html__( 'Justified', 'uipro' ),
                            'icon'  => 'eicon-text-align-justify',
                        ],
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-button'   => 'text-align: {{VALUE}}; align-items: {{VALUE}};',
                    ],
                ),



                //Button Settings
                array(
                    'type'          => Controls_Manager::TEXTAREA,
                    'name'          => 'button_text',
                    'label'         => esc_html__( 'Button Text', 'uipro' ),
                    'description'   => esc_html__( 'Enter button texts here. Leave blank if no button is required.', 'uipro' ),
                    'dynamic'       => [
                        'active'    => true,
                    ],
                    'start_section' => 'button',
                    'section_name'      => esc_html__('Button Settings', 'uipro')
                ),
                array(
                    'label'         => esc_html__( 'Icon Type', 'uipro' ),
                    'name'          => 'button_icon',
                    'type'          => Controls_Manager::SELECT,
                    'default'       => '',
                    'options'       => [
                        ''          => esc_html__( 'FontAwesome', 'uipro' ),
                        'uikit'     => esc_html__( 'UIKit', 'uipro' ),
                    ],
                ),
                array(
                    'label'         => esc_html__( 'Select Icon:', 'uipro' ),
                    'name'          => 'fontawesome_icon',
                    'type'          => Controls_Manager::ICONS,
                    'conditions'    => [
                        'terms'     => [
                            ['name' => 'button_icon', 'operator' => '===', 'value' => ''],
                        ],
                    ],
                ),
                array(
                    'label'         => esc_html__( 'Select Icon:', 'uipro' ),
                    'name'          => 'btn_uikit_icon',
                    'type'          => Controls_Manager::SELECT2,
                    'default'       => '',
                    'conditions'    => [
                        'terms'     => [
                            ['name' => 'button_icon', 'operator' => '===', 'value' => 'uikit'],
                        ],
                    ],
                    'options' => $this->get_font_uikit(),
                ),
                array(
                    'label'         => esc_html__( 'Icon Position', 'uipro' ),
                    'name'          => 'icon_position',
                    'type'          => Controls_Manager::SELECT,
                    'default'       => '',
                    'options'       => [
                        ''          => esc_html__( 'Left', 'uipro' ),
                        'right'     => esc_html__( 'Right', 'uipro' ),
                    ],
                    'condition'     => array(
                        'button_text!'    => ''
                    ),
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'button_icon_margin',
                    'label'         => esc_html__( 'Icon margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .uk-button .uk-margin-small-left' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    ],

                ),

                array(
                    'type'          => Group_Control_Typography::get_type(),
                    'name'          => 'button_typography',
                    'label'         => esc_html__('Button Font', 'uipro'),
                    'description'   => esc_html__('Select a font family, font size for button.', 'uipro'),
                    'selector'      => '{{WRAPPER}} .ui-button .uk-button',

                ),
                array(
                    'name'          => 'button_style',
                    'label' => esc_html__( 'Button Style', 'uipro' ),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => '',
                    'options' => [
                        '' => esc_html__('Default', 'uipro' ),
                        'primary' => esc_html__('Primary', 'uipro') ,
                        'secondary' => esc_html__('Secondary', 'uipro' ),
                        'danger' => esc_html__('Danger', 'uipro' ),
                        'text' => esc_html__('Text', 'uipro' ),
                        'link' => esc_html__('Link', 'uipro' ),
                        'link-muted' => esc_html__('Link Muted', 'uipro' ),
                        'link-text' => esc_html__('Link Text', 'uipro' ),
                        'custom' => esc_html__('Custom', 'uipro' ),
                    ],
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'button_padding',
                    'label'         => esc_html__( 'Button Padding', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .uk-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'button_style', 'operator' => '===', 'value' => 'custom'],
                        ],
                    ],
                ),
                array(
                    'label' => esc_html__( 'Background Color', 'uipro' ),
                    'name'          => 'button_background',
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'separator'     => 'before',
                    'selectors' => [
                        '{{WRAPPER}} .uk-button' => 'background-color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'button_style', 'operator' => '===', 'value' => 'custom'],
                        ],
                    ],
                ),
                array(
                    'label' => esc_html__( 'Color', 'uipro' ),
                    'name'          => 'button_color',
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .uk-button' => 'color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'button_style', 'operator' => '===', 'value' => 'custom'],
                        ],
                    ],
                ),
                array(
                    'id'          => 'border_radius',
                    'label' => __( 'Button Border Radius', 'uipro' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px','%' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 400,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 10,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .ui-button .uk-button' => 'border-radius: {{SIZE}}{{UNIT}} !important;',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'button_style', 'operator' => '===', 'value' => 'custom'],
                        ],
                    ],
                ),
                array(
                    'label' => esc_html__( 'Button Border', 'uipro' ),
                    'name'          => 'button_border',
                    'type' => \Elementor\Group_Control_Border::get_type(),
                    'selector' => '{{WRAPPER}} .uk-button',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'button_style', 'operator' => '===', 'value' => 'custom'],
                        ],
                    ],
                ),
                array(
                    'label' => esc_html__( 'Hover Background Color', 'uipro' ),
                    'name'          => 'hover_button_background',
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'separator'     => 'before',
                    'selectors' => [
                        '{{WRAPPER}} .uk-button:hover' => 'background-color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'button_style', 'operator' => '===', 'value' => 'custom'],
                        ],
                    ],
                ),
                array(
                    'label' => esc_html__( 'Hover Color', 'uipro' ),
                    'name'          => 'hover_button_color',
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .uk-button:hover' => 'color: {{VALUE}}',
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'button_style', 'operator' => '===', 'value' => 'custom'],
                        ],
                    ],
                ),
                array(
                    'label' => esc_html__( 'Hover Button Border', 'uipro' ),
                    'name'          => 'hover_button_border',
                    'type' => \Elementor\Group_Control_Border::get_type(),
                    'selector' => '{{WRAPPER}} .uk-button:hover',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'button_style', 'operator' => '===', 'value' => 'custom'],
                        ],
                    ],
                ),
                array(
                    'name'          => 'button_shape',
                    'label' => esc_html__( 'Button Shape', 'uipro' ),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => 'rounded',
                    'options' => [
                        'rounded' => esc_html__('Rounded', 'uipro' ),
                        'square' => esc_html__('Square', 'uipro' ),
                        'circle' => esc_html__('Circle', 'uipro' ),
                        'pill' => esc_html__('Pill', 'uipro' ),
                    ],
                    'conditions' => [
                        'relation' => 'and',
                        'terms' => [
                            ['name' => 'button_style', 'operator' => '!==', 'value' => 'link'],
                            ['name' => 'button_style', 'operator' => '!==', 'value' => 'link-muted'],
                            ['name' => 'button_style', 'operator' => '!==', 'value' => 'link-text'],
                            ['name' => 'button_style', 'operator' => '!==', 'value' => 'text'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'button_size',
                    'label'         => esc_html__('Button Size', 'uipro'),
                    'description'   => esc_html__('Set the size for multiple buttons.', 'uipro'),
                    'options'       => array(
                        '' => esc_html__('Default', 'uipro'),
                        'small' => esc_html__('Small', 'uipro'),
                        'large' => esc_html__('Large', 'uipro'),
                        'full' => esc_html__('Full', 'uipro'),
                    ),
                    'default'           => '',
                ),
                array(
                    'type'          =>  Controls_Manager::SELECT,
                    'name'          => 'button_margin',
                    'label'         => esc_html__('Button Margin', 'uipro'),
                    'description'   => esc_html__('Set the vertical margin for Button.', 'uipro'),
                    'options'       => array(
                        ''          => esc_html__('Inherit', 'uipro'),
                        'default'   => esc_html__('Default', 'uipro'),
                        'small'     => esc_html__('Small', 'uipro'),
                        'medium'    => esc_html__('Medium', 'uipro'),
                        'large'     => esc_html__('Large', 'uipro'),
                        'xlarge'    => esc_html__('X-Large', 'uipro'),
                        'custom'    => esc_html__('Custom', 'uipro'),
                        'remove'    => esc_html__('None', 'uipro'),
                    ),
                    'default'       => '',
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'button_custom_margin',
                    'label'         => esc_html__( 'Button custom margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px'],
                    'selectors'     => [
                        '{{WRAPPER}} .ui-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition'     => array(
                        'button_margin'    => 'custom'
                    ),
                ),
                array(
                    'type'          =>  Controls_Manager::SELECT,
                    'name'          => 'button_position',
                    'label'         => esc_html__('Button Position', 'uipro'),
                    'options'       => array(
                        ''          => esc_html__('After Content', 'uipro'),
                        'after_media'   => esc_html__('After Media', 'uipro'),
                    ),
                    'default'       => '',
                ),
            );
            $options    = array_merge($options, $this->get_general_options());

            static::$cache[$store_id]   = $options;

            return $options;

		}

	}
}