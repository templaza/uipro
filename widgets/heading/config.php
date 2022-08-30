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
use Elementor\Core\Schemes\Typography;

if ( ! class_exists( 'UIPro_Config_Heading' ) ) {
	/**
	 * Class UIPro_Config_Heading
	 */
	class UIPro_Config_Heading extends UIPro_Abstract_Config {

		/**
		 * UIPro_Config_Heading constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'heading';
			self::$name = esc_html__( 'TemPlaza: Heading', 'uipro' );
			self::$desc = esc_html__( 'Add heading text.', 'uipro' );
			self::$icon = 'eicon-heading';
			parent::__construct();
		}

        public function get_styles() {
            return ['el-heading' => array(
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

			// options
			$options    =    array(
				array(
					'type'          => Controls_Manager::TEXTAREA,
                    'name'          => 'title',
					'label'         => esc_html__( 'Title', 'uipro' ),
					'default'       => __('Add Your Heading Text Here', 'uipro'),
					'description'   => esc_html__( 'Write the title for the heading.', 'uipro' ),
                    'dynamic'       => [
                        'active'    => true,
                    ],
                    /* vc */
					'admin_label'   => true,
				),
                array(
                    'type'          => Controls_Manager::URL,
                    'name'          => 'link',
                    'label'         => __( 'Link', 'uipro' ),
                    'dynamic'       => [
                        'active'    => true,
                    ],
                    'default'       => [
                        'url'       => '',
                    ],
                ),

                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'header_size',
                    'label'         => esc_html__( 'Heading tag', 'uipro' ),
                    'options'       => array(
                        'h1'        => 'h1',
                        'h2'        => 'h2',
                        'h3'        => 'h3',
                        'h4'        => 'h4',
                        'h5'        => 'h5',
                        'h6'        => 'h6',
                        'div'       => 'div',
                        'span'      => 'span',
                        'p'         => 'p',
                    ),
                    'default'       => 'h3',
                    'description'   => esc_html__( 'Choose heading element.', 'uipro' ),
                    'condition'     => array(
                        'title!'    => ''
                    ),
                    /* vc */
                    'admin_label' => false,
                ),

                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'title_heading_style',
                    'default'       => 'h3',
                    'label'         => esc_html__('Style', 'uipro'),
                    'description'   => esc_html__('Heading styles differ in font-size but may also come with a predefined color, size and font', 'uipro'),
                    'options'       => array(
                        ''                  => esc_html__('None', 'uipro'),
                        'heading-2xlarge'   => esc_html__('2XLarge', 'uipro'),
                        'heading-xlarge'    => esc_html__('XLarge', 'uipro'),
                        'heading-large'     => esc_html__('Large', 'uipro'),
                        'heading-medium'    => esc_html__('Medium', 'uipro'),
                        'heading-small'     => esc_html__('Small', 'uipro'),
                        'h1'                => esc_html__('H1', 'uipro'),
                        'h2'                => esc_html__('H2', 'uipro'),
                        'h3'                => esc_html__('H3', 'uipro'),
                        'h4'                => esc_html__('H4', 'uipro'),
                        'h5'                => esc_html__('H5', 'uipro'),
                        'h6'                => esc_html__('H6', 'uipro'),
                    ),
                    'condition'     => array(
                        'title!'    => ''
                    ),
                ),
                array(
                    'type'          =>  Controls_Manager::SELECT,
                    'name'          => 'title_heading_margin',
                    'label'         => esc_html__('Title Margin', 'uipro'),
                    'description'   => esc_html__('Set the vertical margin for title.', 'uipro'),
                    'options'       => array(
                        ''          => esc_html__('Default', 'uipro'),
                        'small'     => esc_html__('Small', 'uipro'),
                        'medium'    => esc_html__('Medium', 'uipro'),
                        'large'     => esc_html__('Large', 'uipro'),
                        'xlarge'    => esc_html__('X-Large', 'uipro'),
                        'remove'    => esc_html__('None', 'uipro'),
                        'custom'    => esc_html__('Custom', 'uipro'),
                    ),
                    'default'       => '',
                    'condition'     => array(
                        'title!'    => ''
                    ),
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'title_heading_margin_custom',
                    'label'         => esc_html__( 'Title custom margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition'     => array(
                        'title_heading_margin'      => 'custom'
                    ),
                ),

				// Highlight text
				array(
					'type'          => Controls_Manager::TEXTAREA,
                    'name'          => 'highlight_title',
					'label'         => esc_html__( 'Highlighted Title', 'uipro' ),
					'default'       => '',
					'description'   => esc_html__( 'Write the Highlighted title for the heading.', 'uipro' ),
                    'separator'     => 'before',
					/* vc */
					'admin_label'    => true,
				),
				array(
					'type'          => Controls_Manager::SELECT,
                    'name'          => 'heading_style',
                    'default'       => '',
					'label'         => esc_html__( 'Highlight Effect', 'uipro' ),
					'description'   => esc_html__( 'Create attractive headlines that help keep your visitors interested and engaged.', 'uipro' ),
					'options'       => array(
                        ''              => esc_html__('None', 'uipro'),
                        'circle'        => esc_html__('Circle', 'uipro'),
                        'curly-line'    => esc_html__('Curly Line', 'uipro'),
                        'double'        => esc_html__('Double', 'uipro'),
                        'double-line'   => esc_html__('Double Line', 'uipro'),
                        'zigzag'        => esc_html__('Zigzag', 'uipro'),
                        'diagonal'      => esc_html__('Diagonal', 'uipro'),
                        'underline'     => esc_html__('Underline', 'uipro'),
                        'delete'        => esc_html__('Delete', 'uipro'),
                        'strike'        => esc_html__('Strikethrough', 'uipro'),
                    ),
					'condition'     => array(
					    'highlight_title!'    => ''
                    ),
					/* vc */
					'admin_label'    => true,
				),
                array(
                    'type'      => Controls_Manager::SLIDER,
                    'name'      => 'shapes_width',
                    'label'     => esc_html__('Shapes Width', 'uipro'),
                    'default'   => array(
                        'size'  => 9,
                        'unit'  => 'px'
                    ),
                    'range'     => array(
                        'min'       => 0,
                        'max'       => 100,
                    ),
                    'condition' => array(
                        'highlight_title!'  => '',
                        'heading_style!'    => '',
                    ),
                    'selectors' => array(
                        '{{WRAPPER}} svg path' => 'stroke-width: {{SIZE}};'
                    )
                ),

				array(
					'type'          => Controls_Manager::TEXTAREA,
					'name'          => 'after_highlight_title',
					'label'         => esc_html__( 'After Highlighted Title', 'uipro' ),
					'default'       => '',
					'description'   => esc_html__( 'Write the text after Highlighted title for the heading.', 'uipro' ),
					'admin_label'    => true,
				),

				// Sub heading
				array(
					'type'          => Controls_Manager::TEXTAREA,
					'label'         => esc_html__( 'Sub heading', 'uipro' ),
					'name'          => 'sub_heading',
					'default'       => '',
					'description'   => esc_html__( 'Enter sub heading.', 'uipro' ),
                    'separator'     => 'before',
				),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'sub_heading_position',
                    'default'       => 'before_title',
                    'label'         => esc_html__( 'Sub heading position', 'uipro' ),
                    'description'   => esc_html__( 'Position to display Sub heading.', 'uipro' ),
                    'options'       => array(
                        'before_title'       => esc_html__('Before Title', 'uipro'),
                        'after_title'        => esc_html__('After Title', 'uipro'),
                    ),
                    'condition'     => array(
                        'sub_heading!'    => ''
                    ),
                    /* vc */
                    'admin_label'    => true,
                    'separator'     => 'before',
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'sub_heading_margin',
                    'label'         => esc_html__( 'Sub Heading margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .sub-heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition'     => array(
                        'sub_heading!'    => ''
                    ),
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'sub_heading_padding',
                    'label'         => esc_html__( 'Sub Heading padding', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .sub-heading' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition'     => array(
                        'sub_heading!'    => ''
                    ),
                ),

				// Config
				array(
					'type'          => Controls_Manager::SWITCHER,
                    'name'          => 'clone_title',
                    'default'       => false,
					'label'         => esc_html__( 'Clone Title?', 'uipro' ),
					'description'   => esc_html__( 'Clone Title.', 'uipro' ),
                    'separator'     => 'before',
                    /*vc*/
                    'admin_label'   => false,
				),
				array(
					'type'          => Controls_Manager::SLIDER,
                    'name'          => 'clone_opacity',
                    'size_units'    => ['px'],
                    'range'         => [
                        'px' => [
                            'max' => 1,
                            'min' => 0.10,
                            'step' => 0.01,
                        ],
                    ],
                    'default'       => [
                        'size' => 0.05,
                    ],
					'label'         => esc_html__( 'Clone Title Opacity', 'uipro' ),
					'description'   => esc_html__( 'Clone Title Opacity.', 'uipro' ),
                    'condition'     => ['clone_title'  => 'yes'],
                    'selectors' => [
                        '{{WRAPPER}} .clone' => 'opacity: {{SIZE}};',
                    ],
                    /*vc*/
                    'admin_label'   => false,
				),
				//Show separator?
				array(
					'type'          => Controls_Manager::SWITCHER,
                    'name'            => 'line',
					'label'         => esc_html__( 'Show Separator?', 'uipro' ),
                    'default'       => 'yes',
					'description'   => esc_html__( 'Tick it to show the separator between title and description.', 'uipro' ),
                    /*vc*/
                    'admin_label'   => false,
				),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'line_style',
                    'default'       => '',
                    'label'         => esc_html__( 'Separator Style', 'uipro' ),
                    'options'       => array(
                        ''              => esc_html__('Default', 'uipro'),
                        'line_style1'   => esc_html__('Style1', 'uipro'),

                    ),
                    'condition'     => array(
                        'line'    => 'yes'
                    ),
                    /* vc */
                    'admin_label'    => true,
                ),
                array(
                    'type'          => Controls_Manager::SLIDER,
                    'name'          =>  'line_before_width',
                    'label'         => esc_html__( 'Before Separator width', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 30,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .line-before' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'relation' => 'and',
                        'terms' => [
                            ['name' => 'line_style', 'operator' => '===', 'value' => 'line_style1'],
                            ['name' => 'line', 'operator' => '===', 'value' => 'yes'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::SLIDER,
                    'name'          =>  'line_before_height',
                    'label'         => esc_html__( 'Before Separator height', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 2,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .line-before' => 'height: {{SIZE}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'relation' => 'and',
                        'terms' => [
                            ['name' => 'line_style', 'operator' => '===', 'value' => 'line_style1'],
                            ['name' => 'line', 'operator' => '===', 'value' => 'yes'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::SLIDER,
                    'name'          =>  'line_width',
                    'label'         => esc_html__( 'Separator width', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 50,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .line' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                    'condition'     => array(
                        'line'    => 'yes'
                    ),
                ),
                array(
                    'type'          => Controls_Manager::SLIDER,
                    'name'          =>  'line_height',
                    'label'         => esc_html__( 'Separator height', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 2,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .line' => 'height: {{SIZE}}{{UNIT}};',
                    ],
                    'condition'     => array(
                        'line'    => 'yes'
                    ),
                ),
                array(
                    'type'          => Controls_Manager::DIMENSIONS,
                    'name'          =>  'line_margin_custom',
                    'label'         => esc_html__( 'Separator margin', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .line' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'relation' => 'and',
                        'terms' => [
                            ['name' => 'line_style', 'operator' => '===', 'value' => 'line_style1'],
                            ['name' => 'line', 'operator' => '===', 'value' => 'yes'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::SLIDER,
                    'name'          =>  'line_after_width',
                    'label'         => esc_html__( 'After Separator width', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 30,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .line-after' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'relation' => 'and',
                        'terms' => [
                            ['name' => 'line_style', 'operator' => '===', 'value' => 'line_style1'],
                            ['name' => 'line', 'operator' => '===', 'value' => 'yes'],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::SLIDER,
                    'name'          =>  'line_after_height',
                    'label'         => esc_html__( 'After Separator height', 'uipro' ),
                    'responsive'    =>  true,
                    'size_units'    => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 2,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .line-after' => 'height: {{SIZE}}{{UNIT}};',
                    ],
                    'conditions' => [
                        'relation' => 'and',
                        'terms' => [
                            ['name' => 'line_style', 'operator' => '===', 'value' => 'line_style1'],
                            ['name' => 'line', 'operator' => '===', 'value' => 'yes'],
                        ],
                    ],
                ),


				//Alignment
				array(
                    'type'         => Controls_Manager::CHOOSE,
					'label'         => esc_html__( 'Text alignment', 'uipro' ),
					'name'          => 'text_align',
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
                        '{{WRAPPER}} .sc_heading'   => 'text-align: {{VALUE}}; align-items: {{VALUE}};',
                    ],
                    /*vc*/
                    'admin_label'   => false,
				),

                /* Style tab */
                // Typo
                array(
                    'type'          => Group_Control_Typography::get_type(),
                    'name'          => 'typography',
                    'scheme'        => Typography::TYPOGRAPHY_1,
                    'selector'      => '{{WRAPPER}} .heading-highlighted-wrapper',
                    'start_section' => 'style',
                    'section_tab'   => Controls_Manager::TAB_STYLE,
                    'section_name'  => esc_html__( self::$name, 'uipro' ),

                ),
                array(
                    'type'          => Group_Control_Typography::get_type(),
                    'name'          => 'sub_heading_typography',
                    'scheme'        => Typography::TYPOGRAPHY_1,
                    'label'         => esc_html__('Sub Heading Typography', 'uipro'),
                    'selector'      => '{{WRAPPER}} .sub-heading',
                    'section_name'  => esc_html__( self::$name, 'uipro' ),

                ),

                //Title color
                array(
                    'type'          => Controls_Manager::COLOR,
                    'name'          => 'textcolor',
                    'label'         => esc_html__( 'Heading color', 'uipro' ),
                    'default'       => '',
                    'description'   => esc_html__( 'Select the title color.', 'uipro' ),
                    'section_name'  => esc_html__( self::$name, 'uipro' ),
                    'selectors'     => [
                        '{{WRAPPER}} .title' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .clone' => 'color: {{VALUE}};',
                    ],
                    'separator'     => 'before',
                ),
                //Link color
                array(
                    'type'          => Controls_Manager::COLOR,
                    'name'          => 'link_hover_color',
                    'label'         => esc_html__( 'Heading Link Hover Color', 'uipro' ),
                    'default'       => '',
                    'description'   => esc_html__( 'Select the link hover color.', 'uipro' ),
                    'section_name'  => esc_html__( self::$name, 'uipro' ),
                    'selectors'     => [
                        '{{WRAPPER}} .title a:hover' => 'color: {{VALUE}};',
                    ],
                ),
                //Main color
                array(
                    'type'          => Controls_Manager::COLOR,
                    'name'          => 'highlight_title_color',
                    'label'         => esc_html__( 'Highlight title color ', 'uipro' ),
                    'default'       => '',
                    'description'   => esc_html__( 'Select the title color.', 'uipro' ),
                    'selectors'     => [
                        '{{WRAPPER}} .heading-highlighted-text' => 'color: {{VALUE}};',
                    ],
//                    'start_section' => 'style',
                    'section_tab'   => Controls_Manager::TAB_STYLE,
                    'section_name'  => esc_html__( self::$name, 'uipro' ),
                ),
                //Sub heading color
                array(
                    'type'          => Controls_Manager::COLOR,
                    'label'         => esc_html__( 'Sub heading color ', 'uipro' ),
                    'name'          => 'sub_heading_color',
                    'default'       => '',
                    'description'   => esc_html__( 'Select the sub heading color.', 'uipro' ),
                    'selectors'     => [
                        '{{WRAPPER}} .sub-heading' => 'color: {{VALUE}};',
                    ],
                    'condition'     => array(
                        'sub_heading!'    => ''
                    ),
                ),
                array(
                    'type'          =>  Controls_Manager::COLOR,
                    'name'          => 'sub_heading_bg',
                    'label'         => esc_html__('Sub heading background', 'uipro'),
                    'description'   => esc_html__('Choose sub heading background.', 'uipro'),
                    'selectors' => [
                        '{{WRAPPER}} .sub-heading' => 'background-color: {{VALUE}}',
                    ],
                    'condition'     => array(
                        'sub_heading!'    => ''
                    ),
                ),
                //Separator color
                array(
                    'type'          => Controls_Manager::COLOR,
                    'name'          => 'bg_before_line',
                    'label'         => esc_html__( 'Before Separator color', 'uipro' ),
                    'default'       => '',
                    'description'   => esc_html__( 'Choose the before separator color.', 'uipro' ),
                    'selectors'     => [
                        '{{WRAPPER}} .line-before' => 'background-color: {{VALUE}};',
                    ],
                    /*vc*/
                    'admin_label'   => false,
                    'conditions' => [
                        'relation' => 'and',
                        'terms' => [
                            ['name' => 'line_style', 'operator' => '===', 'value' => 'line_style1'],
                            ['name' => 'line', 'operator' => '===', 'value' => 'yes'],
                        ],
                    ],
                ),array(
                    'type'          => Controls_Manager::COLOR,
                    'name'          => 'bg_line',
                    'label'         => esc_html__( 'Separator color', 'uipro' ),
                    'default'       => '',
                    'description'   => esc_html__( 'Choose the separator color.', 'uipro' ),
                    'selectors'     => [
                        '{{WRAPPER}} .line' => 'background-color: {{VALUE}};',
                    ],
                    /*vc*/
                    'admin_label'   => false,
                    'condition'     => array(
                        'line'    => 'yes'
                    ),
                ),array(
                    'type'          => Controls_Manager::COLOR,
                    'name'          => 'bg_after_line',
                    'label'         => esc_html__( 'After Separator color', 'uipro' ),
                    'default'       => '',
                    'description'   => esc_html__( 'Choose the after separator color.', 'uipro' ),
                    'selectors'     => [
                        '{{WRAPPER}} .line-after' => 'background-color: {{VALUE}};',
                    ],
                    /*vc*/
                    'admin_label'   => false,
                    'conditions' => [
                        'relation' => 'and',
                        'terms' => [
                            ['name' => 'line_style', 'operator' => '===', 'value' => 'line_style1'],
                            ['name' => 'line', 'operator' => '===', 'value' => 'yes'],
                        ],
                    ],
                ),
                array(
                    'type'      => Controls_Manager::COLOR,
                    'name'      => 'shapes_color',
                    'label'     => esc_html__('Shapes Color', 'uipro'),
                    'selectors' => array(
                        '{{WRAPPER}} svg path' => 'stroke: {{VALUE}};'
                    ),
                    'separator'     => 'before',
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