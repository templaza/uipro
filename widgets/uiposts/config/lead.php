<?php

defined( 'UIPRO' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

return array(
    // Lead posts
    array(
        'type'          => Controls_Manager::NUMBER,
        'id'            => 'lead_limit',
        'label'         => esc_html__( 'Lead Limit', 'uipro' ),
        'description'   => esc_html__( 'Set the number of articles you want to display.', 'uipro' ),
        'min' => 0,
        'max' => 90,
        'step' => 1,
        'default' => 0,
        'separator'     => 'before',
    ),
    // Lead Settings
    array(
        'type'          => Controls_Manager::SWITCHER,
        'id'            => 'lead_column_divider',
        'label'         => esc_html__( 'Lead Column Divider', 'uipro' ),
        'return_value'  => '1',
        'default'       => '0',
        'start_section' => 'lead-options',
        'section_name'  => esc_html__( 'Lead Settings', 'uipro' ),
    ),
    array(
        'type'          => Controls_Manager::SELECT,
        'id'            => 'lead_position',
        'label'         => esc_html__( 'Lead Position', 'uipro' ),
        'options'       => array(
            'top'       => esc_html__('Top', 'uipro'),
            'left'      => esc_html__('Left', 'uipro'),
            'right'     => esc_html__('Right', 'uipro'),
            'between'   => esc_html__('Between', 'uipro'),
        ),
        'default'   => 'top'
    ),
    array(
        'type'          => Controls_Manager::SELECT,
        'id'            => 'lead_width_xl',
        'label'         => esc_html__( 'Lead Width Large Desktop', 'uipro' ),
        'options'       => array(
            '1-1'       => esc_html__('1-1', 'uipro'),
            '1-2'       => esc_html__('1-2', 'uipro'),
            '1-3'       => esc_html__('1-3', 'uipro'),
            '2-3'       => esc_html__('2-3', 'uipro'),
            '1-4'       => esc_html__('1-4', 'uipro'),
            '3-4'       => esc_html__('3-4', 'uipro'),
            '1-5'       => esc_html__('1-5', 'uipro'),
            '2-5'       => esc_html__('2-5', 'uipro'),
            '3-5'       => esc_html__('3-5', 'uipro'),
            '4-5'       => esc_html__('4-5', 'uipro'),
            '1-6'       => esc_html__('1-6', 'uipro'),
            '5-6'       => esc_html__('5-6', 'uipro'),
        ),
        'default'       => '1-2',
        'condition'    => array(
            'lead_position!' => 'top'
        ),
    ),
    array(
        'type'          => Controls_Manager::SELECT,
        'id'            => 'lead_width_l',
        'label'         => esc_html__( 'Lead Width Desktop', 'uipro' ),
        'options'       => array(
            '1-1'       => esc_html__('1-1', 'uipro'),
            '1-2'       => esc_html__('1-2', 'uipro'),
            '1-3'       => esc_html__('1-3', 'uipro'),
            '2-3'       => esc_html__('2-3', 'uipro'),
            '1-4'       => esc_html__('1-4', 'uipro'),
            '3-4'       => esc_html__('3-4', 'uipro'),
            '1-5'       => esc_html__('1-5', 'uipro'),
            '2-5'       => esc_html__('2-5', 'uipro'),
            '3-5'       => esc_html__('3-5', 'uipro'),
            '4-5'       => esc_html__('4-5', 'uipro'),
            '1-6'       => esc_html__('1-6', 'uipro'),
            '5-6'       => esc_html__('5-6', 'uipro'),
        ),
        'default'       => '1-2',
        'condition'    => array(
            'lead_position!' => 'top'
        ),
    ),
    array(
        'type'          => Controls_Manager::SELECT,
        'id'            => 'lead_width_m',
        'label'         => esc_html__( 'Lead Width Laptop', 'uipro' ),
        'options'       => array(
            '1-1'       => esc_html__('1-1', 'uipro'),
            '1-2'       => esc_html__('1-2', 'uipro'),
            '1-3'       => esc_html__('1-3', 'uipro'),
            '2-3'       => esc_html__('2-3', 'uipro'),
            '1-4'       => esc_html__('1-4', 'uipro'),
            '3-4'       => esc_html__('3-4', 'uipro'),
            '1-5'       => esc_html__('1-5', 'uipro'),
            '2-5'       => esc_html__('2-5', 'uipro'),
            '3-5'       => esc_html__('3-5', 'uipro'),
            '4-5'       => esc_html__('4-5', 'uipro'),
            '1-6'       => esc_html__('1-6', 'uipro'),
            '5-6'       => esc_html__('5-6', 'uipro'),
        ),
        'default'       => '1-2',
        'condition'    => array(
            'lead_position!' => 'top'
        ),
    ),
    array(
        'type'          => Controls_Manager::SELECT,
        'id'            => 'lead_width_s',
        'label'         => esc_html__( 'Lead Width Tablet', 'uipro' ),
        'options'       => array(
            '1-1'       => esc_html__('1-1', 'uipro'),
            '1-2'       => esc_html__('1-2', 'uipro'),
            '1-3'       => esc_html__('1-3', 'uipro'),
            '2-3'       => esc_html__('2-3', 'uipro'),
            '1-4'       => esc_html__('1-4', 'uipro'),
            '3-4'       => esc_html__('3-4', 'uipro'),
            '1-5'       => esc_html__('1-5', 'uipro'),
            '2-5'       => esc_html__('2-5', 'uipro'),
            '3-5'       => esc_html__('3-5', 'uipro'),
            '4-5'       => esc_html__('4-5', 'uipro'),
            '1-6'       => esc_html__('1-6', 'uipro'),
            '5-6'       => esc_html__('5-6', 'uipro'),
        ),
        'default'       => '1-2',
        'condition'    => array(
            'lead_position!' => 'top'
        ),
    ),
    array(
        'type'          => Controls_Manager::SELECT,
        'id'            => 'lead_width',
        'label'         => esc_html__( 'Lead Width Mobile', 'uipro' ),
        'options'       => array(
            '1-1'       => esc_html__('1-1', 'uipro'),
            '1-2'       => esc_html__('1-2', 'uipro'),
            '1-3'       => esc_html__('1-3', 'uipro'),
            '2-3'       => esc_html__('2-3', 'uipro'),
            '1-4'       => esc_html__('1-4', 'uipro'),
            '3-4'       => esc_html__('3-4', 'uipro'),
            '1-5'       => esc_html__('1-5', 'uipro'),
            '2-5'       => esc_html__('2-5', 'uipro'),
            '3-5'       => esc_html__('3-5', 'uipro'),
            '4-5'       => esc_html__('4-5', 'uipro'),
            '1-6'       => esc_html__('1-6', 'uipro'),
            '5-6'       => esc_html__('5-6', 'uipro'),
        ),
        'default'       => '1-2',
        'condition'    => array(
            'lead_position!' => 'top'
        ),
    ),
    array(
        'type'          => Controls_Manager::SELECT,
        'id'            => 'lead_column_gutter',
        'label'         => esc_html__( 'Lead Column Gutter', 'uipro' ),
        'options'       => array(
            ''          => esc_html__('Default', 'uipro'),
            'small'     => esc_html__('Small', 'uipro'),
            'medium'    => esc_html__('Medium', 'uipro'),
            'large'     => esc_html__('Large', 'uipro'),
            'collapse'  => esc_html__('Collapse', 'uipro'),
        ),
        'default'       => '',
    ),
    array(
        'type'          => Controls_Manager::SELECT,
        'id'            => 'lead_color_mode',
        'label'         => esc_html__( 'Color Mode', 'uipro' ),
        'options'       => array(
            'dark'      => esc_html__('Dark', 'uipro'),
            'light'     => esc_html__('Light', 'uipro'),
        ),
        'default'       => 'dark',
    ),
    // Lead image settings
    array(
        'type'          => Controls_Manager::HEADING,
        'id'            => 'lead_image_settings',
        'label'         => esc_html__('Image Settings', 'uipro'),
        'separator'     => 'before',
    ),
    array(
        'type'          => Controls_Manager::SWITCHER,
        'id'            => 'lead_hide_thumbnail',
        'label'         => esc_html__('Hide Thumbnail', 'uipro'),
        'description'   => esc_html__( 'Whether to hide article thumbnail.', 'uipro' ),
        'label_on'      => esc_html__( 'Yes', 'uipro' ),
        'label_off'     => esc_html__( 'No', 'uipro' ),
        'return_value'  => '1',
        'default'       => '0',
    ),
    array(
        'type'          => Controls_Manager::SELECT,
        'id'            => 'lead_layout',
        'label' => esc_html__( 'Layout', 'uipro' ),
        'default' => '',
        'options' => [
            '' => esc_html__('Default', 'uipro'),
            'thumbnail' => esc_html__('Thumbnail', 'uipro')
        ],
        'conditions' => [
            'terms' => [
                ['name' => 'lead_hide_thumbnail', 'operator' => '!==', 'value' => '1'],
            ],
        ],
    ),
    array(
        'type'          => \Elementor\Group_Control_Background::get_type(),
        'name'          => 'lead_image_background_overlay',
        'label'         => __( 'Image Overlay Background', 'uipro' ),
        'default'       => '',
        'types'         => [ 'classic', 'gradient' ],
        'selector'      => '{{WRAPPER}} .ui-posts-lead-item .uk-overlay-primary',
        'conditions'    => [
            'terms' => [
                ['name' => 'lead_hide_thumbnail', 'operator' => '!==', 'value' => '1'],
                ['name' => 'lead_layout', 'operator' => '===', 'value' => 'thumbnail'],
            ],
        ],
    ),
    array(
        'type'          => Controls_Manager::SWITCHER,
        'id'            => 'lead_thumbnail_hover',
        'label'         => esc_html__('Content display on hover', 'uipro'),
        'description'   => esc_html__( 'Whether to enable on hover content article with thumbnail.', 'uipro' ),
        'label_on'      => esc_html__( 'Yes', 'uipro' ),
        'label_off'     => esc_html__( 'No', 'uipro' ),
        'return_value'  => '1',
        'default'       => '0',
        'conditions' => [
            'terms' => [
                ['name' => 'lead_hide_thumbnail', 'operator' => '!==', 'value' => '1'],
                ['name' => 'lead_layout', 'operator' => '===', 'value' => 'thumbnail'],
            ],
        ],
    ),
    array(
        'type'          => Controls_Manager::SELECT,
        'id'            => 'lead_thumbnail_hover_transition',
        'label' => esc_html__( 'Hover Transition', 'uipro' ),
        'default' => 'fade',
        'options' => [
            'fade' => esc_html__('Fade', 'uipro'),
            'scale-up' => esc_html__('Scale Up', 'uipro'),
            'scale-down' => esc_html__('Scale Down', 'uipro'),
            'slide-top' => esc_html__('Slide Top', 'uipro'),
            'slide-bottom' => esc_html__('Slide Bottom', 'uipro'),
            'slide-left' => esc_html__('Slide Left', 'uipro'),
            'slide-right' => esc_html__('Slide Right', 'uipro'),
            'slide-top-small' => esc_html__('Slide Top Small', 'uipro'),
            'slide-bottom-small' => esc_html__('Slide Bottom Small', 'uipro'),
            'slide-left-small' => esc_html__('Slide Left Small', 'uipro'),
            'slide-right-small' => esc_html__('Slide Right Small', 'uipro'),
            'slide-top-medium' => esc_html__('Slide Top Medium', 'uipro'),
            'slide-bottom-medium' => esc_html__('Slide Bottom Medium', 'uipro'),
            'slide-left-medium' => esc_html__('Slide Left Medium', 'uipro'),
            'slide-right-medium' => esc_html__('Slide Right Medium', 'uipro'),
        ],
        'conditions' => [
            'terms' => [
                ['name' => 'lead_hide_thumbnail', 'operator' => '!==', 'value' => '1'],
                ['name' => 'lead_layout', 'operator' => '===', 'value' => 'thumbnail'],
                ['name' => 'lead_thumbnail_hover', 'operator' => '===', 'value' => '1'],
            ],
        ],
    ),
    array(
        'type'          => Controls_Manager::SELECT,
        'id'            => 'lead_image_position',
        'label'         => esc_html__( 'Image Position', 'uipro' ),
        'description'   => esc_html__( 'Select the image\'s position.', 'uipro' ),
        'options'       => array(
            'top'       => esc_html__('Top', 'uipro'),
            'left'      => esc_html__('Left', 'uipro'),
            'right'     => esc_html__('Right', 'uipro'),
            'bottom'    => esc_html__('Bottom', 'uipro'),
            'inside'    => esc_html__('Inside Body', 'uipro'),
        ),
        'default'       => 'top',
        'conditions' => [
            'terms' => [
                ['name' => 'lead_hide_thumbnail', 'operator' => '!==', 'value' => '1'],
                ['name' => 'lead_layout', 'operator' => '===', 'value' => ''],
                ['name' => 'lead_hide_thumbnail', 'operator' => '!==', 'value' => '1'],
            ],
        ],
    ),
    array(
        'id'          => 'lead_image_width_xl',
        'label' => esc_html__( 'Image Width Large Desktop', 'uipro' ),
        'type' => Controls_Manager::SELECT,
        'options'       => array(
            '1-1'    => esc_html__('1-1', 'uipro'),
            '1-2'    => esc_html__('1-2', 'uipro'),
            '1-3'    => esc_html__('1-3', 'uipro'),
            '2-3'    => esc_html__('2-3', 'uipro'),
            '1-4'    => esc_html__('1-4', 'uipro'),
            '3-4'    => esc_html__('3-4', 'uipro'),
            '1-5'    => esc_html__('1-5', 'uipro'),
            '2-5'    => esc_html__('2-5', 'uipro'),
            '3-5'    => esc_html__('3-5', 'uipro'),
            '4-5'    => esc_html__('4-5', 'uipro'),
            '1-6'    => esc_html__('1-6', 'uipro'),
            '5-6'    => esc_html__('5-6', 'uipro'),
        ),
        'default'   => '1-2',
        'conditions' => [
            'terms' =>[
                ['name' => 'lead_hide_thumbnail', 'operator' => '!==', 'value' => '1'],
                ['name' => 'lead_layout', 'operator' => '===', 'value' => ''],
                ['name' => 'lead_image_position', 'operator' => 'in', 'value' => ['left','right']],
            ],
        ],
    ),
    array(
        'id'          => 'lead_image_width_l',
        'label' => esc_html__( 'Image Width Desktop', 'uipro' ),
        'type' => Controls_Manager::SELECT,
        'options'       => array(
            '1-1'    => esc_html__('1-1', 'uipro'),
            '1-2'    => esc_html__('1-2', 'uipro'),
            '1-3'    => esc_html__('1-3', 'uipro'),
            '2-3'    => esc_html__('2-3', 'uipro'),
            '1-4'    => esc_html__('1-4', 'uipro'),
            '3-4'    => esc_html__('3-4', 'uipro'),
            '1-5'    => esc_html__('1-5', 'uipro'),
            '2-5'    => esc_html__('2-5', 'uipro'),
            '3-5'    => esc_html__('3-5', 'uipro'),
            '4-5'    => esc_html__('4-5', 'uipro'),
            '1-6'    => esc_html__('1-6', 'uipro'),
            '5-6'    => esc_html__('5-6', 'uipro'),
        ),
        'default'   => '1-2',
        'conditions' => [
            'terms' =>[
                ['name' => 'lead_hide_thumbnail', 'operator' => '!==', 'value' => '1'],
                ['name' => 'lead_layout', 'operator' => '===', 'value' => ''],
                ['name' => 'lead_image_position', 'operator' => 'in', 'value' => ['left','right']],
            ],
        ],
    ),
    array(
        'id'          => 'lead_image_width_m',
        'label' => esc_html__( 'Image Width Laptop', 'uipro' ),
        'type' => Controls_Manager::SELECT,
        'options'       => array(
            '1-1'    => esc_html__('1-1', 'uipro'),
            '1-2'    => esc_html__('1-2', 'uipro'),
            '1-3'    => esc_html__('1-3', 'uipro'),
            '2-3'    => esc_html__('2-3', 'uipro'),
            '1-4'    => esc_html__('1-4', 'uipro'),
            '3-4'    => esc_html__('3-4', 'uipro'),
            '1-5'    => esc_html__('1-5', 'uipro'),
            '2-5'    => esc_html__('2-5', 'uipro'),
            '3-5'    => esc_html__('3-5', 'uipro'),
            '4-5'    => esc_html__('4-5', 'uipro'),
            '1-6'    => esc_html__('1-6', 'uipro'),
            '5-6'    => esc_html__('5-6', 'uipro'),
        ),
        'default'   => '1-2',
        'conditions' => [
            'terms' =>[
                ['name' => 'lead_hide_thumbnail', 'operator' => '!==', 'value' => '1'],
                ['name' => 'lead_layout', 'operator' => '===', 'value' => ''],
                ['name' => 'lead_image_position', 'operator' => 'in', 'value' => ['left','right']],
            ],
        ],
    ),
    array(
        'id'          => 'lead_image_width_s',
        'label' => esc_html__( 'Image Width Tablet', 'uipro' ),
        'type' => Controls_Manager::SELECT,
        'options'       => array(
            '1-1'    => esc_html__('1-1', 'uipro'),
            '1-2'    => esc_html__('1-2', 'uipro'),
            '1-3'    => esc_html__('1-3', 'uipro'),
            '2-3'    => esc_html__('2-3', 'uipro'),
            '1-4'    => esc_html__('1-4', 'uipro'),
            '3-4'    => esc_html__('3-4', 'uipro'),
            '1-5'    => esc_html__('1-5', 'uipro'),
            '2-5'    => esc_html__('2-5', 'uipro'),
            '3-5'    => esc_html__('3-5', 'uipro'),
            '4-5'    => esc_html__('4-5', 'uipro'),
            '1-6'    => esc_html__('1-6', 'uipro'),
            '5-6'    => esc_html__('5-6', 'uipro'),
        ),
        'default'   => '1-2',
        'conditions' => [
            'terms' =>[
                ['name' => 'lead_hide_thumbnail', 'operator' => '!==', 'value' => '1'],
                ['name' => 'lead_layout', 'operator' => '===', 'value' => ''],
                ['name' => 'lead_image_position', 'operator' => 'in', 'value' => ['left','right']],
            ],
        ],
    ),
    array(
        'id'          => 'lead_image_width',
        'label' => esc_html__( 'Image Width Mobile', 'uipro' ),
        'type' => Controls_Manager::SELECT,
        'options'       => array(
            '1-1'    => esc_html__('1-1', 'uipro'),
            '1-2'    => esc_html__('1-2', 'uipro'),
            '1-3'    => esc_html__('1-3', 'uipro'),
            '2-3'    => esc_html__('2-3', 'uipro'),
            '1-4'    => esc_html__('1-4', 'uipro'),
            '3-4'    => esc_html__('3-4', 'uipro'),
            '1-5'    => esc_html__('1-5', 'uipro'),
            '2-5'    => esc_html__('2-5', 'uipro'),
            '3-5'    => esc_html__('3-5', 'uipro'),
            '4-5'    => esc_html__('4-5', 'uipro'),
            '1-6'    => esc_html__('1-6', 'uipro'),
            '5-6'    => esc_html__('5-6', 'uipro'),
        ),
        'default'   => '1-2',
        'conditions' => [
            'terms' =>[
                ['name' => 'lead_hide_thumbnail', 'operator' => '!==', 'value' => '1'],
                ['name' => 'lead_layout', 'operator' => '===', 'value' => ''],
                ['name' => 'lead_image_position', 'operator' => 'in', 'value' => ['left','right']],
            ],
        ],
    ),
    array(
        'type'          => Controls_Manager::SELECT,
        'id'            => 'lead_image_margin',
        'label'         => esc_html__('Image Margin', 'uipro'),
        'description'   => esc_html__('Set the image margin.', 'uipro'),
        'options'       => array(
            '' => esc_html__('Default', 'uipro'),
            'small' => esc_html__('Small', 'uipro'),
            'medium' => esc_html__('Medium', 'uipro'),
            'large' => esc_html__('Large', 'uipro'),
            'xlarge' => esc_html__('X-Large', 'uipro'),
            'remove-vertical' => esc_html__('None', 'uipro'),
        ),
        'default'           => '',
        'conditions' => [
            'terms' => [
                ['name' => 'lead_hide_thumbnail', 'operator' => '!==', 'value' => '1'],
                ['name' => 'lead_layout', 'operator' => '===', 'value' => ''],
                ['name' => 'lead_image_position', 'operator' => '===', 'value' => 'inside'],
            ],
        ],
    ),
    array(
        'type'          => Controls_Manager::SWITCHER,
        'id'            => 'lead_cover_image',
        'label'         => esc_html__('Cover Image', 'uipro'),
        'description'   => esc_html__( 'Whether to display image cover.', 'uipro' ),
        'label_on'      => esc_html__( 'Yes', 'uipro' ),
        'label_off'     => esc_html__( 'No', 'uipro' ),
        'return_value'  => '1',
        'default'       => '0',
        'conditions' => [
            'terms' => [
                ['name' => 'lead_hide_thumbnail', 'operator' => '!==', 'value' => '1'],
            ],
        ],
    ),
    array(
        'name'            => 'lead_thumbnail_height',
        'label'         => esc_html__( 'Thumbnail Height', 'uipro' ),
        'type'          => Controls_Manager::SLIDER,
        'responsive'    => true,
        'range' => [
            'px' => [
                'min' => 1,
                'max' => 1000
            ],
        ],
        'desktop_default' => [
            'size' => 220,
            'unit' => 'px',
        ],
        'tablet_default' => [
            'size' => 220,
            'unit' => 'px',
        ],
        'mobile_default' => [
            'size' => 220,
            'unit' => 'px',
        ],
        'selectors' => [
            '{{WRAPPER}} .ui-posts-lead-item .tz-image-cover' => 'height: {{SIZE}}{{UNIT}};',
        ],
        'conditions' => [
            'terms' => [
                ['name' => 'lead_hide_thumbnail', 'operator' => '!==', 'value' => '1'],
//                ['name' => 'lead_cover_image', 'operator' => '===', 'value' => '1'],
            ],
        ],
    ),
    array(
        'type'          => Controls_Manager::SELECT,
        'id'            => 'lead_image_border',
        'label'         => esc_html__( 'Border', 'uipro' ),
        'description'   => esc_html__( 'Select the image\'s border style.', 'uipro' ),
        'options'       => array(
            '' => esc_html__('None', 'uipro'),
            'uk-border-circle' => esc_html__('Circle', 'uipro'),
            'uk-border-rounded' => esc_html__('Rounded', 'uipro'),
            'uk-border-pill' => esc_html__('Pill', 'uipro'),
            'custom' => esc_html__('Custom', 'uipro'),
        ),
        'default'       => '',
        'conditions' => [
            'terms' => [
                ['name' => 'lead_hide_thumbnail', 'operator' => '!==', 'value' => '1'],
            ],
        ],
    ),
    array(
        'type'          => Controls_Manager::DIMENSIONS,
        'name'          =>  'lead_image_border_radius',
        'label'         => esc_html__( 'Image border radius', 'uipro' ),
        'responsive'    =>  true,
        'size_units'    => [ 'px', 'em', '%' ],
        'selectors'     => [
            '{{WRAPPER}} .ui-posts-lead-item .ui-post-thumbnail > img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;',
        ],
        'condition'     => array(
            'image_border'    => 'custom'
        ),
        'conditions' => [
            'terms' => [
                ['name' => 'lead_hide_thumbnail', 'operator' => '!==', 'value' => '1'],
            ],
        ],
    ),
    array(
        'type'          => \Elementor\Group_Control_Image_Size::get_type(),
        'name' => 'lead_thumbnail', // // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
        'exclude' => [ 'custom' ],
        'include' => [],
        'default' => 'large',
        'conditions' => [
            'terms' => [
                ['name' => 'lead_hide_thumbnail', 'operator' => '!==', 'value' => '1'],
            ],
        ],
    ),
    // Lead column settings
    array(
        'type'          => Controls_Manager::HEADING,
        'id'            => 'lead_column_settings',
        'label'         => esc_html__('Column Settings', 'uipro'),
        'separator'     => 'before',
    ),
    array(
        'id'          => 'lead_large_desktop_columns',
        'label' => esc_html__( 'Large Desktop Columns', 'uipro' ),
        'type' => Controls_Manager::SELECT,
        'options'       => array(
            '1'    => esc_html__('1 Column', 'uipro'),
            '2'    => esc_html__('2 Columns', 'uipro'),
            '3'    => esc_html__('3 Columns', 'uipro'),
            '4'    => esc_html__('4 Columns', 'uipro'),
            '5'    => esc_html__('5 Columns', 'uipro'),
            '6'    => esc_html__('6 Columns', 'uipro'),
        ),
        'default'   => '3',
    ),
    array(
        'id'          => 'lead_desktop_columns',
        'label' => esc_html__( 'Desktop Columns', 'uipro' ),
        'type' => Controls_Manager::SELECT,
        'options'       => array(
            '1'    => esc_html__('1 Column', 'uipro'),
            '2'    => esc_html__('2 Columns', 'uipro'),
            '3'    => esc_html__('3 Columns', 'uipro'),
            '4'    => esc_html__('4 Columns', 'uipro'),
            '5'    => esc_html__('5 Columns', 'uipro'),
            '6'    => esc_html__('6 Columns', 'uipro'),
        ),
        'default'   => '3',
    ),
    array(
        'id'          => 'lead_laptop_columns',
        'label' => esc_html__( 'Laptop Columns', 'uipro' ),
        'type' => Controls_Manager::SELECT,
        'options'       => array(
            '1'    => esc_html__('1 Column', 'uipro'),
            '2'    => esc_html__('2 Columns', 'uipro'),
            '3'    => esc_html__('3 Columns', 'uipro'),
            '4'    => esc_html__('4 Columns', 'uipro'),
            '5'    => esc_html__('5 Columns', 'uipro'),
            '6'    => esc_html__('6 Columns', 'uipro'),
        ),
        'default'   => '3'
    ),
    array(
        'id'          => 'lead_tablet_columns',
        'label' => esc_html__( 'Tablet Columns', 'uipro' ),
        'type' => Controls_Manager::SELECT,
        'options'       => array(
            '1'    => esc_html__('1 Column', 'uipro'),
            '2'    => esc_html__('2 Columns', 'uipro'),
            '3'    => esc_html__('3 Columns', 'uipro'),
            '4'    => esc_html__('4 Columns', 'uipro'),
            '5'    => esc_html__('5 Columns', 'uipro'),
            '6'    => esc_html__('6 Columns', 'uipro'),
        ),
        'default'   => '2'
    ),
    array(
        'id'          => 'lead_mobile_columns',
        'label' => esc_html__( 'Mobile Columns', 'uipro' ),
        'type' => Controls_Manager::SELECT,
        'options'       => array(
            '1'    => esc_html__('1 Column', 'uipro'),
            '2'    => esc_html__('2 Columns', 'uipro'),
            '3'    => esc_html__('3 Columns', 'uipro'),
            '4'    => esc_html__('4 Columns', 'uipro'),
            '5'    => esc_html__('5 Columns', 'uipro'),
            '6'    => esc_html__('6 Columns', 'uipro'),
        ),
        'default'   => '1'
    ),
    // Lead Card Settings
    array(
        'type'          => Controls_Manager::HEADING,
        'id'            => 'lead_card_settings',
        'label'         => esc_html__('Card Settings', 'uipro'),
        'separator'     => 'before',
    ),
    array(
        'type'          => Controls_Manager::SELECT,
        'name'          => 'lead_card_style',
        'label' => esc_html__( 'Card Style', 'uipro' ),
        'default' => '',
        'options' => [
            '' => esc_html__('None', 'uipro'),
            'default' => esc_html__('Card Default', 'uipro'),
            'primary' => esc_html__('Card Primary', 'uipro'),
            'secondary' => esc_html__('Card Secondary', 'uipro'),
            'hover' => esc_html__('Card Hover', 'uipro'),
            'custom' => esc_html__('Custom', 'uipro'),
        ],
    ),
    array(
        'type'          =>  Controls_Manager::COLOR,
        'name'          => 'lead_card_background',
        'label'         => esc_html__('Card Background', 'uipro'),
        'description'   => esc_html__('Set the Background Color of Card.', 'uipro'),
        'selectors' => [
            '{{WRAPPER}} .ui-posts-lead-item .uk-card' => 'background-color: {{VALUE}}',
        ],
        'conditions' => [
            'terms' => [
                ['name' => 'lead_card_style', 'operator' => '===', 'value' => 'custom'],
            ],
        ],
    ),
    array(
        'type'          =>  Controls_Manager::COLOR,
        'name'          => 'lead_card_color',
        'label'         => esc_html__('Card Color', 'uipro'),
        'description'   => esc_html__('Set the Color of Card.', 'uipro'),
        'selectors' => [
            '{{WRAPPER}} .ui-posts-lead-item .uk-card' => 'color: {{VALUE}}',
        ],
        'conditions' => [
            'terms' => [
                ['name' => 'lead_card_style', 'operator' => '===', 'value' => 'custom'],
            ],
        ],
    ),
    array(
        'type'          => Controls_Manager::SELECT,
        'id'            => 'lead_card_size',
        'label' => esc_html__( 'Card Size', 'uipro' ),
        'default' => '',
        'options' => [
            'none' => esc_html__('None', 'uipro'),
            '' => esc_html__('Default', 'uipro'),
            'small' => esc_html__('Small', 'uipro'),
            'large' => esc_html__('Large', 'uipro'),
            'custom' => esc_html__('Custom', 'uipro'),
        ],
    ),
    array(
        'type'          => Controls_Manager::DIMENSIONS,
        'name'          =>  'lead_card_padding',
        'label'         => esc_html__( 'Card Padding', 'uipro' ),
        'responsive'    =>  true,
        'size_units'    => [ 'px', 'em', '%' ],
        'selectors'     => [
            '{{WRAPPER}} .ui-posts-lead-item .ui-post-info-wrap .uk-card-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            '{{WRAPPER}} .ui-posts-lead-item .ui-post-info-wrap .uk-card-footer' => 'padding: 20px {{RIGHT}}{{UNIT}} 20px {{LEFT}}{{UNIT}};',
        ],
        'conditions' => [
            'terms' => [
                ['name' => 'lead_card_size', 'operator' => '===', 'value' => 'custom'],
            ],
        ],
    ),
    array(
        'type'          => Controls_Manager::DIMENSIONS,
        'name'          =>  'lead_card_radius',
        'label'         => esc_html__( 'Border radius', 'uipro' ),
        'responsive'    =>  true,
        'size_units'    => [ 'px', 'em', '%' ],
        'selectors'     => [
            '{{WRAPPER}} .ui-posts-lead-item .uk-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;',
        ],
    ),
    array(
        'type'          =>  \Elementor\Group_Control_Border::get_type(),
        'name'          => 'lead_card_border',
        'label'         => esc_html__('Card Border', 'uipro'),
        'description'   => esc_html__('Set the Border of Card.', 'uipro'),
        'selector' => '{{WRAPPER}} .ui-posts-lead-item .uk-card',
    ),
    array(
        'type'          =>  \Elementor\Group_Control_Box_Shadow::get_type(),
        'name'          => 'lead_card_box_shadow',
        'label'         => esc_html__('Card Box Shadow', 'uipro'),
        'description'   => esc_html__('Set the Box Shadow of Card.', 'uipro'),
        'selector' => '{{WRAPPER}} .ui-posts-lead-item .uk-card',
    ),

    // Lead filter Settings
    array(
        'type'          => Controls_Manager::HEADING,
        'id'            => 'lead_filter_settings',
        'label'         => esc_html__('Filter Settings', 'uipro'),
        'separator'     => 'before',
    ),
    array(
        'type'          => Controls_Manager::SWITCHER,
        'id'            => 'lead_use_filter',
        'label'         => esc_html__('Use Filter', 'uipro'),
        'description'   => esc_html__( 'Display filter articles', 'uipro' ),
        'label_on'      => esc_html__( 'Yes', 'uipro' ),
        'label_off'     => esc_html__( 'No', 'uipro' ),
        'return_value'  => '1',
        'default'       => '0',
    ),
    array(
        'type'          => Controls_Manager::SELECT,
        'id'            => 'lead_filter_position',
        'label' => esc_html__( 'Filter Position', 'uipro' ),
        'default' => 'top',
        'options' => [
            'top' => esc_html__('Top', 'uipro'),
            'left' => esc_html__('Left', 'uipro'),
            'right' => esc_html__('Right', 'uipro'),
        ],
    ),
    array(
        'id'            => 'lead_filter_width',
        'label'         => esc_html__( 'Filter Width', 'uipro' ),
        'type'          => Controls_Manager::SLIDER,
        'responsive'    => true,
        'range' => [
            'px' => [
                'min' => 1,
                'max' => 1000,
                'step'=> 1,
            ],
        ],
        'desktop_default' => [
            'size' => 250,
            'unit' => 'px',
        ],
        'tablet_default' => [
            'size' => 250,
            'unit' => 'px',
        ],
        'mobile_default' => [
            'size' => 250,
            'unit' => 'px',
        ],
        'selectors' => [
            '{{WRAPPER}} .ui-posts-lead-item .ui-post-filter' => 'width: {{SIZE}}{{UNIT}};',
        ],
        'conditions' => [
            'terms' => [
                ['name' => 'lead_filter_position', 'operator' => '!==', 'value' => 'top'],
            ],
        ],
    ),
    array(
        'type'          => Controls_Manager::SELECT2,
        'id'            => 'lead_filter_type',
        'label' => esc_html__( 'Filter Type', 'uipro' ),
        'default' => 'tag',
        'multiple' => true,
        'options' => [
            'tag' => esc_html__('Tags', 'uipro'),
            'category' => esc_html__('Categories', 'uipro'),
        ],
    ),
    array(
        'type'          => Controls_Manager::SELECT,
        'id'            => 'lead_filter_grid_gap',
        'label'         => esc_html__('Filter Gap', 'uipro'),
        'description'   => esc_html__('Modified Filter Gap Column', 'uipro'),
        'options'       => array(
            '' => esc_html__('Default', 'uipro'),
            'small' => esc_html__('Small', 'uipro'),
            'medium' => esc_html__('Medium', 'uipro'),
            'large' => esc_html__('Large', 'uipro'),
            'collapse' => esc_html__('Collapse', 'uipro'),
        ),
        'default'           => '',
        'conditions' => [
            'terms' => [
                ['name' => 'lead_filter_position', 'operator' => '!==', 'value' => 'top'],
            ],
        ],
    ),
    array(
        'type'          => Controls_Manager::SWITCHER,
        'id'            => 'lead_use_filter_sort',
        'label'         => esc_html__('Use Filter Sort', 'uipro'),
        'description'   => esc_html__( 'Display filter sort', 'uipro' ),
        'label_on'      => esc_html__( 'Yes', 'uipro' ),
        'label_off'     => esc_html__( 'No', 'uipro' ),
        'return_value'  => '1',
        'default'       => '0',
    ),
    array(
        'type'          => Controls_Manager::SWITCHER,
        'id'            => 'lead_display_filter_header',
        'label'         => esc_html__('Display Header', 'uipro'),
        'description'   => esc_html__( 'Whether display filter header', 'uipro' ),
        'label_on'      => esc_html__( 'Yes', 'uipro' ),
        'label_off'     => esc_html__( 'No', 'uipro' ),
        'return_value'  => '1',
        'default'       => '1',
    ),
    array(
        'type'          => Controls_Manager::SELECT,
        'id'            => 'lead_filter_container',
        'label'         => esc_html__('Filter Container', 'uipro'),
        'description'   => esc_html__('Add the uk-container class to widget to give it a max-width and wrap the main content', 'uipro'),
        'options'       => array(
            '' => esc_html__('None', 'uipro'),
            'default' => esc_html__('Default', 'uipro'),
            'xsmall' => esc_html__('X-Small', 'uipro'),
            'small' => esc_html__('Small', 'uipro'),
            'large' => esc_html__('Large', 'uipro'),
            'xlarge' => esc_html__('X-Large', 'uipro'),
            'expand' => esc_html__('Expand', 'uipro'),
        ),
        'default'           => '',
        'conditions' => [
            'terms' => [
                ['name' => 'lead_filter_position', 'operator' => '===', 'value' => 'top'],
            ],
        ],
    ),
    array(
        'type'          => Controls_Manager::SELECT,
        'name'          => 'lead_filter_block_align',
        'label'         => esc_html__('Block Alignment', 'uipro'),
        'description'   => esc_html__('Define the alignment in case the container exceeds the element\'s max-width.', 'uipro'),
        'options'       => array(
            ''=>__('Left', 'uipro'),
            'center'=>__('Center', 'uipro'),
            'right'=>__('Right', 'uipro'),
        ),
        'default'           => '',
        'conditions' => [
            'terms' => [
                ['name' => 'lead_filter_container', 'operator' => '!==', 'value' => ''],
                ['name' => 'lead_filter_position', 'operator' => '===', 'value' => 'top'],
            ],
        ],
    ),
    array(
        'type'          => Controls_Manager::SELECT,
        'name'          => 'lead_filter_block_align_breakpoint',
        'label'         => esc_html__('Block Alignment Breakpoint', 'uipro'),
        'description'   => esc_html__('Define the device width from which the alignment will apply.', 'uipro'),
        'options'       => array(
            ''=>__('Always', 'uipro'),
            's'=>__('Small (Phone Landscape)', 'uipro'),
            'm'=>__('Medium (Tablet Landscape)', 'uipro'),
            'l'=>__('Large (Desktop)', 'uipro'),
            'xl'=>__('X-Large (Large Screens)', 'uipro'),
        ),
        'default'           => '',
        'conditions' => [
            'terms' => [
                ['name' => 'lead_filter_position', 'operator' => '===', 'value' => 'top'],
                ['name' => 'lead_filter_container', 'operator' => '!==', 'value' => ''],
            ],
        ],
    ),
    array(
        'type'          => Controls_Manager::SELECT,
        'name'          => 'lead_filter_block_align_fallback',
        'label'         => esc_html__('Block Alignment Fallback', 'uipro'),
        'description'   => esc_html__('Define the alignment in case the container exceeds the element\'s max-width.', 'uipro'),
        'options'       => array(
            ''=>__('Left', 'uipro'),
            'center'=>__('Center', 'uipro'),
            'right'=>__('Right', 'uipro'),
        ),
        'default'           => '',
        'conditions' => [
            'relation' => 'and',
            'terms' => [
                ['name' => 'lead_filter_position', 'operator' => '===', 'value' => 'top'],
                ['name' => 'lead_filter_container', 'operator' => '!==', 'value' => ''],
                ['name' => 'lead_filter_block_align_breakpoint', 'operator' => '!==', 'value' => ''],
            ],
        ],

    ),
    array(
        'type'          => Controls_Manager::SELECT,
        'id'            => 'lead_filter_text_alignment',
        'label' => esc_html__( 'Text Alignment', 'uipro' ),
        'options'       => array(
            '' => esc_html__('None', 'uipro'),
            'left' => esc_html__('Left', 'uipro'),
            'center' => esc_html__('Center', 'uipro'),
            'right' => esc_html__('Right', 'uipro'),
        ),
        'default'           => '',
    ),
    array(
        'type'          => Controls_Manager::SELECT,
        'name'          => 'lead_filter_text_alignment_breakpoint',
        'label'         => esc_html__('Text Alignment Breakpoint', 'uipro'),
        'description'   => esc_html__('Display the button alignment only on this device width and larger', 'uipro'),
        'options'       => array(
            '' => esc_html__('Always', 'uipro'),
            's' => esc_html__('Small (Phone Landscape)', 'uipro'),
            'm' => esc_html__('Medium (Tablet Landscape)', 'uipro'),
            'l' => esc_html__('Large (Desktop)', 'uipro'),
            'xl' => esc_html__('X-Large (Large Screens)', 'uipro'),
        ),
        'default'           => '',
        'conditions' => [
            'terms' => [
                ['name' => 'lead_filter_text_alignment', 'operator' => '!==', 'value' => ''],
            ],
        ],

    ),
    array(
        'type'          => Controls_Manager::SELECT,
        'name'          => 'lead_filter_text_alignment_fallback',
        'label'         => esc_html__('Text Alignment Fallback', 'uipro'),
        'description'   => esc_html__('Define an alignment fallback for device widths below the breakpoint.', 'uipro'),
        'options'       => array(
            '' => esc_html__('None', 'uipro'),
            'left' => esc_html__('Left', 'uipro'),
            'center' => esc_html__('Center', 'uipro'),
            'right' => esc_html__('Right', 'uipro'),
        ),
        'default'           => '',
        'conditions' => [
            'relation' => 'and',
            'terms' => [
                ['name' => 'lead_filter_text_alignment', 'operator' => '!==', 'value' => ''],
                ['name' => 'lead_filter_text_alignment_breakpoint', 'operator' => '!==', 'value' => ''],
            ],
        ],

    ),
    array(
        'type'          => Controls_Manager::SELECT,
        'id'            => 'lead_filter_animate',
        'label'         => esc_html__( 'Filter Animate', 'uipro' ),
        'options'       => array(
            'slide'     => esc_html__('Slide', 'uipro'),
            'fade'      => esc_html__('Fade', 'uipro'),
            'delayed-fade'    => esc_html__('Delayed Fade', 'uipro'),
        ),
        'default'       => 'slide',
    ),
    array(
        'type'          => Controls_Manager::SELECT,
        'id'            => 'lead_filter_margin',
        'label'         => esc_html__('Margin Bottom', 'uipro'),
        'description'   => esc_html__('Set the bottom margin.', 'uipro'),
        'options'       => array(
            '' => esc_html__('Default', 'uipro'),
            'small' => esc_html__('Small', 'uipro'),
            'medium' => esc_html__('Medium', 'uipro'),
            'large' => esc_html__('Large', 'uipro'),
            'xlarge' => esc_html__('X-Large', 'uipro'),
            'remove' => esc_html__('None', 'uipro'),
        ),
        'default'           => '',
        'conditions' => [
            'terms' => [
                ['name' => 'lead_filter_position', 'operator' => '===', 'value' => 'top'],
            ],
        ],
    ),
    array(
        'type'          => Controls_Manager::SELECT,
        'id'            => 'lead_filter_visibility',
        'label'         => esc_html__('Visibility', 'uipro'),
        'description'   => esc_html__('Display the element only on this device width and larger.', 'uipro'),
        'options'       => array(
            '' => esc_html__('Always', 'uipro'),
            '@s' => esc_html__('Small (Phone Landscape)', 'uipro'),
            '@m' => esc_html__('Medium (Tablet Landscape)', 'uipro'),
            '@l' => esc_html__('Large (Desktop)', 'uipro'),
            '@xl' => esc_html__('X-Large (Large Screens)', 'uipro'),
        ),
        'default'           => '',
    ),

    // Lead slider Settings
    array(
        'type'          => Controls_Manager::HEADING,
        'id'            => 'lead_slider_settings',
        'label'         => esc_html__('Slider Settings', 'uipro'),
        'separator'     => 'before',
    ),
    array(
        'type'          => Controls_Manager::SWITCHER,
        'id'            => 'lead_use_slider',
        'label'         => esc_html__('Display Articles as Slider', 'uipro'),
        'description'   => esc_html__( 'Display Articles as Carousel Slider', 'uipro' ),
        'label_on'      => esc_html__( 'Yes', 'uipro' ),
        'label_off'     => esc_html__( 'No', 'uipro' ),
        'return_value'  => '1',
        'default'       => '0',
    ),
    array(
        'type'          => Controls_Manager::DIMENSIONS,
        'name'          =>  'lead_slider_padding',
        'label'         => esc_html__( 'Slider Padding', 'uipro' ),
        'responsive'    =>  true,
        'size_units'    => [ 'px', 'em', '%' ],
        'selectors'     => [
            '{{WRAPPER}} .ui-posts-lead-item .uk-slider-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        'condition' => array(
            'lead_use_slider'    => '1'
        ),
    ),
    array(
        'type'          => Controls_Manager::SWITCHER,
        'id'            => 'lead_enable_navigation',
        'label'         => esc_html__('Navigation', 'uipro'),
        'description'   => esc_html__( 'Enable Navigation', 'uipro' ),
        'label_on'      => esc_html__( 'Yes', 'uipro' ),
        'label_off'     => esc_html__( 'No', 'uipro' ),
        'return_value'  => '1',
        'default'       => '1',
        'conditions' => [
            'terms' => [
                ['name' => 'lead_use_slider', 'operator' => '===', 'value' => '1'],
            ],
        ],
    ),
    array(
        'type'          => Controls_Manager::SELECT,
        'id'            => 'lead_navigation_position',
        'label' => esc_html__( 'Navigation Position', 'uipro' ),
        'default' => '',
        'options' => [
            '' => esc_html__('Outside', 'uipro'),
            'inside' => esc_html__('Inside', 'uipro'),
        ],
        'conditions' => [
            'terms' => [
                ['name' => 'lead_use_slider', 'operator' => '===', 'value' => '1'],
                ['name' => 'lead_enable_navigation', 'operator' => '===', 'value' => '1'],
            ],
        ],
    ),
    array(
        'type'          => Controls_Manager::SWITCHER,
        'id'            => 'lead_enable_dotnav',
        'label'         => esc_html__('Dot Navigation', 'uipro'),
        'description'   => esc_html__( 'Enable Dot Navigation', 'uipro' ),
        'label_on'      => esc_html__( 'Yes', 'uipro' ),
        'label_off'     => esc_html__( 'No', 'uipro' ),
        'return_value'  => '1',
        'default'       => '1',
        'conditions' => [
            'terms' => [
                ['name' => 'lead_use_slider', 'operator' => '===', 'value' => '1'],
            ],
        ],
    ),
    array(
        'type'          => Controls_Manager::DIMENSIONS,
        'name'          =>  'lead_dotnav_margin',
        'label'         => esc_html__( 'Dot Margin', 'uipro' ),
        'responsive'    =>  true,
        'size_units'    => [ 'px', 'em', '%' ],
        'selectors'     => [
            '{{WRAPPER}} .ui-posts-lead-item .uk-dotnav' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
        ],
        'conditions' => [
            'terms' => [
                ['name' => 'lead_use_slider', 'operator' => '===', 'value' => '1'],
                ['name' => 'lead_enable_dotnav', 'operator' => '===', 'value' => '1'],
            ],
        ],
    ),
    array(
        'label' => esc_html__( 'Dot Navigation Color', 'uipro' ),
        'name'  => 'lead_dotnav_color',
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .ui-posts-lead-item .uk-dotnav li > * ' => 'border-color: {{VALUE}}',
        ],
        'conditions' => [
            'terms' => [
                ['name' => 'lead_use_slider', 'operator' => '===', 'value' => '1'],
                ['name' => 'lead_enable_dotnav', 'operator' => '===', 'value' => '1'],
            ],
        ],
    ),
    array(
        'label' => esc_html__( 'Dot Navigation Active Color', 'uipro' ),
        'name'  => 'lead_dotnav_active_color',
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .ui-posts-lead-item .uk-dotnav > .uk-active > *, {{WRAPPER}} .ui-posts-lead-item .uk-dotnav li:hover > * ' => 'background-color: {{VALUE}}',
        ],
        'conditions' => [
            'terms' => [
                ['name' => 'lead_use_slider', 'operator' => '===', 'value' => '1'],
                ['name' => 'lead_enable_dotnav', 'operator' => '===', 'value' => '1'],
            ],
        ],
    ),
    array(
        'type'          => Controls_Manager::SWITCHER,
        'id'            => 'lead_center_slider',
        'label'         => esc_html__('Center Slider', 'uipro'),
        'description'   => esc_html__( 'To center the list items', 'uipro' ),
        'label_on'      => esc_html__( 'Yes', 'uipro' ),
        'label_off'     => esc_html__( 'No', 'uipro' ),
        'return_value'  => '1',
        'default'       => '0',
        'conditions' => [
            'terms' => [
                ['name' => 'lead_use_slider', 'operator' => '===', 'value' => '1'],
            ],
        ],
    ),

    // Lead title settings
    array(
        'type'          => Controls_Manager::HEADING,
        'id'            => 'lead_title_settings',
        'label'         => esc_html__('Title Settings', 'uipro'),
        'separator'     => 'before',
    ),
    array(
        'type'          => Controls_Manager::SELECT,
        'name'          => 'lead_title_tag',
        'label'         => esc_html__( 'Title tag', 'uipro' ),
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
    ),
    array(
        'name'            => 'lead_title_font_family',
        'type'          => Group_Control_Typography::get_type(),
        'scheme'        => Typography::TYPOGRAPHY_1,
        'label'         => esc_html__('Title Font', 'uipro'),
        'description'   => esc_html__('Select a font family, font size for the addon content.', 'uipro'),
        'selector'      => '{{WRAPPER}} .ui-posts-lead-item .ui-title',
    ),
    array(
        'type'          => Controls_Manager::SELECT,
        'name'          => 'lead_title_heading_style',
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
    ),
    array(
        'id'            => 'lead_custom_title_color',
        'type'          =>  Controls_Manager::COLOR,
        'label'         => esc_html__('Title Color', 'uipro'),
        'selectors' => [
            '{{WRAPPER}} .ui-posts-lead-item .ui-title > a' => 'color: {{VALUE}}',
        ],
    ),
    array(
        'id'            => 'lead_custom_title_hover_color',
        'type'          =>  Controls_Manager::COLOR,
        'label'         => esc_html__('Title Hover Color', 'uipro'),
        'selectors' => [
            '{{WRAPPER}} .ui-posts-lead-item .ui-title > a:hover' => 'color: {{VALUE}}',
        ],
    ),
    array(
        'type'          => Controls_Manager::SELECT,
        'id'            => 'lead_title_margin',
        'label'         => esc_html__('Title Margin', 'uipro'),
        'description'   => esc_html__('Set the title margin.', 'uipro'),
        'options'       => array(
            '' => esc_html__('Default', 'uipro'),
            'small' => esc_html__('Small', 'uipro'),
            'medium' => esc_html__('Medium', 'uipro'),
            'large' => esc_html__('Large', 'uipro'),
            'xlarge' => esc_html__('X-Large', 'uipro'),
            'custom' => esc_html__('Custom', 'uipro'),
            'remove' => esc_html__('None', 'uipro'),
        ),
        'default'           => '',
    ),
    array(
        'type'          => Controls_Manager::DIMENSIONS,
        'name'          =>  'lead_title_margin_custom',
        'label'         => esc_html__( 'Title Margin', 'uipro' ),
        'responsive'    =>  true,
        'size_units'    => [ 'px', 'em', '%' ],
        'selectors'     => [
            '{{WRAPPER}} .ui-posts-lead-item .ui-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
        ],
        'conditions' => [
            'terms' => [
                ['name' => 'lead_title_margin', 'operator' => '===', 'value' => 'custom'],
            ],
        ],
    ),
    // Lead Content style
    array(
        'type'      => Controls_Manager::HEADING,
        'id'        => 'lead_content_settings',
        'label'     => esc_html__('Content Settings', 'uipro'),
        'separator' => 'before'
    ),
    array(
        'type'          => Controls_Manager::SWITCHER,
        'id'            => 'lead_show_introtext',
        'label'         => esc_html__('Show Introtext', 'uipro'),
        'description'   => esc_html__( 'Whether to show introtext.', 'uipro' ),
        'label_on' => esc_html__( 'Yes', 'uipro' ),
        'label_off' => esc_html__( 'No', 'uipro' ),
        'return_value' => '1',
        'default' => '1',
    ),
    array(
        'type'      => Controls_Manager::NUMBER,
        'name'      => 'lead_introtext_number',
        'label'     => esc_html__( 'Limit Words', 'uipro' ),
        'conditions' => [
            'terms' => [
                ['name' => 'lead_show_introtext', 'operator' => '===', 'value' => '1'],
            ],
        ],
    ),
    array(
        'type'          => Controls_Manager::SELECT,
        'id'            => 'lead_intro_position',
        'label'         => esc_html__( 'Border', 'uipro' ),
        'description'   => esc_html__( 'Select the image\'s border style.', 'uipro' ),
        'options'       => array(
            'absolute' => esc_html__('Absolute', 'uipro'),
            'relative' => esc_html__('Relative', 'uipro'),
        ),
        'default'       => 'absolute',
        'conditions' => [
            'terms' => [
                ['name' => 'lead_show_introtext', 'operator' => '===', 'value' => '1'],
                ['name' => 'uipost_layout', 'operator' => '===', 'value' => 'style1'],
            ],
        ],
        'selectors' => [
            '{{WRAPPER}} .ui-posts-lead-item .ui-posts.style1 .uk-card-body' => 'position: {{VALUE}}',
        ],
    ),
    array(
        'name'          => 'lead_content_font_family',
        'type'          => Group_Control_Typography::get_type(),
        'scheme'        => Typography::TYPOGRAPHY_1,
        'label'         => esc_html__('Content Font', 'uipro'),
        'description'   => esc_html__('Select a font family, font size for the addon content.', 'uipro'),
        'selector'      => '{{WRAPPER}} .ui-posts-lead-item .ui-post-introtext',
    ),
    array(
        'id'            => 'lead_content_color',
        'type'          =>  Controls_Manager::COLOR,
        'label'         => esc_html__('Custom Color', 'uipro'),
        'selectors' => [
            '{{WRAPPER}} .ui-posts-lead-item .ui-post-introtext' => 'color: {{VALUE}}',
        ],
    ),
    array(
        'id'            => 'lead_content_bg_color',
        'type'          =>  Controls_Manager::COLOR,
        'label'         => esc_html__('Background Color', 'uipro'),
        'selectors' => [
            '{{WRAPPER}} .ui-posts-lead-item .ui-posts.style1 .uk-card-body' => 'background-color: {{VALUE}}',
        ],
        'conditions' => [
            'terms' => [
                ['name' => 'lead_show_introtext', 'operator' => '===', 'value' => '1'],
                ['name' => 'uipost_layout', 'operator' => '===', 'value' => 'style1'],
            ],
        ],
    ),
    array(
        'type'          => Controls_Manager::SWITCHER,
        'id'            => 'lead_content_dropcap',
        'label'         => esc_html__('Drop Cap', 'uipro'),
        'description'   => esc_html__('Display the first letter of the paragraph as a large initial.', 'uipro'),
        'label_on'      => esc_html__( 'Yes', 'uipro' ),
        'label_off'     => esc_html__( 'No', 'uipro' ),
        'return_value'  => '1',
        'default'       => '0',
    ),
    array(
        'type'          => Controls_Manager::DIMENSIONS,
        'name'          =>  'lead_wrap_content_margin',
        'label'         => esc_html__( 'Wrap Content Margin', 'uipro' ),
        'responsive'    =>  true,
        'size_units'    => [ 'px', 'em', '%' ],
        'selectors'     => [
            '{{WRAPPER}} .ui-posts-lead-item .ui-post-info-wrap .uk-card-body' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        'conditions' => [
            'terms' => [
                ['name' => 'uipost_layout', 'operator' => '===', 'value' => 'style1'],
            ],
        ],
    ),
    array(
        'type'          => Controls_Manager::DIMENSIONS,
        'name'          =>  'lead_wrap_content_hover_margin',
        'label'         => esc_html__( 'Wrap Content Hover Margin', 'uipro' ),
        'responsive'    =>  true,
        'size_units'    => [ 'px', 'em', '%' ],
        'selectors'     => [
            '{{WRAPPER}} .ui-posts-lead-item .uk-article:hover .uk-card-body' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        'conditions' => [
            'terms' => [
                ['name' => 'uipost_layout', 'operator' => '===', 'value' => 'style1'],
            ],
        ],
    ),
    array(
        'type'          =>  Group_Control_Box_Shadow::get_type(),
        'name'          => 'lead_wrap_content_box_shadow',
        'label'         => esc_html__('Wrap Content Box Shadow', 'uipro'),
        'description'   => esc_html__('Set the Box Shadow of Wrap Content.', 'uipro'),
        'selector' => '{{WRAPPER}} .ui-posts-lead-item .ui-post-info-wrap .uk-card-body',
    ),

    // Lead Meta settings
    array(
        'type'          => Controls_Manager::HEADING,
        'id'            => 'lead_meta_settings',
        'label'         => esc_html__('Meta Settings', 'uipro'),
        'separator'     => 'before',
    ),
    array(
        'type'          => Controls_Manager::SELECT,
        'id'            => 'lead_meta_icon_type',
        'label'         => esc_html__( 'Icon Type', 'uipro' ),
        'default'       => 'none',
        'options'       => [
            ''  => esc_html__( 'FontAwesome', 'uipro' ),
            'uikit' => esc_html__( 'UIKit', 'uipro' ),
            'none' => esc_html__( 'None', 'uipro' ),
        ],
    ),
    array(
        'type'          => Controls_Manager::ICONS,
        'name'          => 'lead_date_icon',
        'label'         => esc_html__('Date Icon:', 'uipro'),
        'conditions' => [
            'terms' => [
                ['name' => 'lead_meta_icon_type', 'operator' => '===', 'value' => ''],
            ],
        ],
    ),
    array(
        'type'          => Controls_Manager::SELECT2,
        'name'          => 'lead_date_uikit_icon',
        'label'         => esc_html__('Date Icon:', 'uipro'),
        'default' => '',
        'conditions' => [
            'terms' => [
                ['name' => 'lead_meta_icon_type', 'operator' => '===', 'value' => 'uikit'],
            ],
        ],
        'options' => $this->get_font_uikit(),
    ),
    array(
        'type'          => Controls_Manager::ICONS,
        'name'          => 'lead_author_icon',
        'label'         => esc_html__('Author Icon:', 'uipro'),
        'conditions' => [
            'terms' => [
                ['name' => 'lead_meta_icon_type', 'operator' => '===', 'value' => ''],
            ],
        ],
    ),
    array(
        'type'          => Controls_Manager::SELECT2,
        'name'          => 'lead_author_uikit_icon',
        'label'         => esc_html__('Author Icon:', 'uipro'),
        'default' => '',
        'conditions' => [
            'terms' => [
                ['name' => 'lead_meta_icon_type', 'operator' => '===', 'value' => 'uikit'],
            ],
        ],
        'options' => $this->get_font_uikit(),
    ),
    array(
        'type'          => Controls_Manager::ICONS,
        'name'          => 'lead_category_icon',
        'label'         => esc_html__('Category Icon:', 'uipro'),
        'conditions' => [
            'terms' => [
                ['name' => 'lead_meta_icon_type', 'operator' => '===', 'value' => ''],
            ],
        ],
    ),
    array(
        'type'          => Controls_Manager::SELECT2,
        'name'          => 'lead_category_uikit_icon',
        'label'         => esc_html__('Category Icon:', 'uipro'),
        'default' => '',
        'conditions' => [
            'terms' => [
                ['name' => 'lead_meta_icon_type', 'operator' => '===', 'value' => 'uikit'],
            ],
        ],
        'options' => $this->get_font_uikit(),
    ),
    array(
        'type'          => Controls_Manager::ICONS,
        'name'          => 'lead_tag_icon',
        'label'         => esc_html__('Tag Icon:', 'uipro'),
        'conditions' => [
            'terms' => [
                ['name' => 'lead_meta_icon_type', 'operator' => '===', 'value' => ''],
            ],
        ],
    ),
    array(
        'type'          => Controls_Manager::SELECT2,
        'name'          => 'lead_tag_uikit_icon',
        'label'         => esc_html__('Tag Icon:', 'uipro'),
        'default' => '',
        'conditions' => [
            'terms' => [
                ['name' => 'lead_meta_icon_type', 'operator' => '===', 'value' => 'uikit'],
            ],
        ],
        'options' => $this->get_font_uikit(),
    ),
    array(
        'type'          => Controls_Manager::ICONS,
        'name'          => 'lead_comment_icon',
        'label'         => esc_html__('Comment Icon:', 'uipro'),
        'conditions' => [
            'terms' => [
                ['name' => 'lead_meta_icon_type', 'operator' => '===', 'value' => ''],
            ],
        ],
    ),
    array(
        'type'          => Controls_Manager::SELECT2,
        'name'          => 'lead_comment_uikit_icon',
        'label'         => esc_html__('Comment Icon:', 'uipro'),
        'default' => '',
        'conditions' => [
            'terms' => [
                ['name' => 'lead_meta_icon_type', 'operator' => '===', 'value' => 'uikit'],
            ],
        ],
        'options' => $this->get_font_uikit(),
    ),
    array(
        'type'          => Controls_Manager::ICONS,
        'name'          => 'lead_view_icon',
        'label'         => esc_html__('Post View Icon:', 'uipro'),
        'conditions' => [
            'terms' => [
                ['name' => 'lead_meta_icon_type', 'operator' => '===', 'value' => ''],
            ],
        ],
    ),
    array(
        'type'          => Controls_Manager::SELECT2,
        'name'          => 'lead_view_uikit_icon',
        'label'         => esc_html__('Post View Icon:', 'uipro'),
        'default' => '',
        'conditions' => [
            'terms' => [
                ['name' => 'lead_meta_icon_type', 'operator' => '===', 'value' => 'uikit'],
            ],
        ],
        'options' => $this->get_font_uikit(),
    ),
    array(
        'id'            => 'lead_meta_icon_color',
        'type'          =>  Controls_Manager::COLOR,
        'label'         => esc_html__('Icon Color', 'uipro'),
        'selectors' => [
            '{{WRAPPER}} .ui-posts-lead-item .uk-article-meta i' => 'color: {{VALUE}}',
        ],
        'conditions' => [
            'terms' => [
                ['name' => 'lead_meta_icon_type', 'operator' => '!=', 'value' => 'none'],
            ],
        ],
    ),
    array(
        'type'      => Controls_Manager::SWITCHER,
        'name'      => 'lead_meta_author_avatar',
        'label'     => esc_html__( 'Show author avatar', 'uipro' ),
        'return_value'  => '1',
        'default'       => '0',
        'conditions' => [
            'terms' => [
                ['name' => 'uipost_layout', 'operator' => '===', 'value' => 'style1'],
            ],
        ],
    ),
    array(
        'id'            => 'lead_meta_author_avatar_size',
        'label'         => __( 'Avatar Width', 'uipro' ),
        'type'          => Controls_Manager::SLIDER,
        'responsive'    =>  true,
        'size_units'    => [ 'px', 'em', '%' ],
        'range' => [
            'px' => [
                'min' => 0,
                'max' => 500,
                'step' => 1,
            ],
        ],
        'selectors' => [
            '{{WRAPPER}} .ui-posts-lead-item .ui-post-meta-author img' => 'width: {{SIZE}}{{UNIT}};',
        ],
        'conditions' => [
            'terms' => [
                ['name' => 'uipost_layout', 'operator' => '===', 'value' => 'style1'],
                ['name' => 'lead_meta_author_avatar', 'operator' => '===', 'value' => '1'],
            ],
        ],
    ),
    array(
        'type'          => Controls_Manager::DIMENSIONS,
        'id'            => 'lead_meta_author_avatar_border',
        'label'         => esc_html__( 'Avatar Border Radius', 'uipro' ),
        'responsive'    =>  true,
        'size_units'    => [ 'px', 'em', '%' ],
        'selectors'     => [
            '{{WRAPPER}} .ui-posts-lead-item .ui-post-meta-author img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;',
        ],
        'conditions' => [
            'terms' => [
                ['name' => 'uipost_layout', 'operator' => '===', 'value' => 'style1'],
                ['name' => 'lead_meta_author_avatar', 'operator' => '===', 'value' => '1'],
            ],
        ],
    ),
    array(
        'label' => esc_html__( 'Avatar Border Custom', 'uipro' ),
        'name'          => 'lead_meta_author_avatar_border_custom',
        'type' => \Elementor\Group_Control_Border::get_type(),
        'selector' => '{{WRAPPER}} .ui-posts-lead-item .ui-post-meta-author img',
        'conditions' => [
            'terms' => [
                ['name' => 'uipost_layout', 'operator' => '===', 'value' => 'style1'],
                ['name' => 'lead_meta_author_avatar', 'operator' => '===', 'value' => '1'],
            ],
        ],
    ),

    array(
        'type'          => Controls_Manager::SELECT2,
        'id'            => 'lead_meta_thumb_position',
        'label'         => esc_html__( 'Meta On Thumbnail', 'uipro' ),
        'options'       => UIPro_UIPosts_Helper::get_post_meta_type( 'category' ),
        'multiple'      => true,
        'conditions' => [
            'terms' => [
                ['name' => 'uipost_layout', 'operator' => '===', 'value' => 'style1'],
            ],
        ],
    ),

    array(
        'type'          => Controls_Manager::SELECT2,
        'id'            => 'lead_meta_top_position',
        'label'         => esc_html__( 'Before Title', 'uipro' ),
        'options'       => UIPro_UIPosts_Helper::get_post_meta_type( 'category' ),
        'multiple'      => true,
    ),
    array(
        'type'          => Controls_Manager::SELECT2,
        'id'            => 'lead_meta_middle_position',
        'label'         => esc_html__( 'After Title', 'uipro' ),
        'options'       => UIPro_UIPosts_Helper::get_post_meta_type( 'category' ),
        'multiple'      => true,
        'default' => [ 'date', 'author', 'category' ],
    ),
    array(
        'type'          => Controls_Manager::SELECT2,
        'id'            => 'lead_meta_bottom_position',
        'label'         => esc_html__( 'After Description', 'uipro' ),
        'options'       => UIPro_UIPosts_Helper::get_post_meta_type( 'category' ),
        'multiple'      => true,
        'default' => [ 'tags' ],
    ),
    array(
        'type'          => Controls_Manager::SELECT2,
        'id'            => 'lead_meta_footer_position',
        'label'         => esc_html__( 'In the footer', 'uipro' ),
        'options'       => UIPro_UIPosts_Helper::get_post_meta_type( 'category' ),
        'multiple'      => true,
    ),
    array(
        'id'    => 'lead_tag_style',
        'type' => Controls_Manager::SELECT,
        'label' => esc_html__('Tag Style', 'uipro'),
        'description' => esc_html__('Select a predefined tag style.', 'uipro'),
        'options' => array(
            '' => esc_html__('Default', 'uipro'),
            'plain-text' => esc_html__('Plain Text', 'uipro'),
        ),
        'default' => '',
        'separator'     => 'before',
    ),
    array(
        'id'            => 'lead_meta_thumb_background_color',
        'type'          =>  Controls_Manager::COLOR,
        'label'         => esc_html__('Meta Thumb Background Color', 'uipro'),
        'selectors' => [
            '{{WRAPPER}} .ui-posts-lead-item .ui-post-meta-thumb' => 'background-color: {{VALUE}}',
        ],
        'conditions' => [
            'terms' => [
                ['name' => 'uipost_layout', 'operator' => 'in', 'value' => ['style1']],
                ['name' => 'lead_meta_thumb_position', 'operator' => '!=', 'value' => ''],
            ],
        ],
    ),
    array(
        'id'            => 'lead_meta_thumb_color',
        'type'          =>  Controls_Manager::COLOR,
        'label'         => esc_html__('Meta Thumb Title Color', 'uipro'),
        'selectors' => [
            '{{WRAPPER}} .ui-posts-lead-item .ui-post-meta-thumb' => 'color: {{VALUE}}',
        ],
        'conditions' => [
            'terms' => [
                ['name' => 'uipost_layout', 'operator' => 'in', 'value' => ['style1']],
                ['name' => 'lead_meta_thumb_position', 'operator' => '!=', 'value' => ''],
            ],
        ],
    ),
    array(
        'id'            => 'lead_meta_thumb_link_color',
        'type'          =>  Controls_Manager::COLOR,
        'label'         => esc_html__('Meta Thumb Link Color', 'uipro'),
        'selectors' => [
            '{{WRAPPER}} .ui-posts-lead-item .ui-post-meta-thumb a' => 'color: {{VALUE}}',
        ],
        'conditions' => [
            'terms' => [
                ['name' => 'uipost_layout', 'operator' => 'in', 'value' => ['style1']],
                ['name' => 'lead_meta_thumb_position', 'operator' => '!=', 'value' => ''],
            ],
        ],
    ),
    array(
        'id'            => 'lead_meta_thumb_link_hover_color',
        'type'          =>  Controls_Manager::COLOR,
        'label'         => esc_html__('Meta Thumb Link Hover Color', 'uipro'),
        'selectors' => [
            '{{WRAPPER}} .ui-posts-lead-item .ui-post-meta-thumb a:hover' => 'color: {{VALUE}}',
        ],
        'conditions' => [
            'terms' => [
                ['name' => 'uipost_layout', 'operator' => 'in', 'value' => ['style1']],
                ['name' => 'lead_meta_thumb_position', 'operator' => '!=', 'value' => ''],
            ],
        ],
    ),
    array(
        'name'          => 'lead_meta_top_font_family',
        'type'          => Group_Control_Typography::get_type(),
        'scheme'        => Typography::TYPOGRAPHY_1,
        'label'         => esc_html__('Before Title Font', 'uipro'),
        'description'   => esc_html__('Select a font family, font size for the addon content.', 'uipro'),
        'selector'      => '{{WRAPPER}} .ui-posts-lead-item .ui-post-meta-top',
        'separator'     => 'before',
        'conditions' => [
            'terms' => [
                ['name' => 'lead_meta_top_position', 'operator' => '!=', 'value' => ''],
            ],
        ],
    ),
    array(
        'id'            => 'lead_meta_top_color',
        'type'          =>  Controls_Manager::COLOR,
        'label'         => esc_html__('Before Title Color', 'uipro'),
        'selectors' => [
            '{{WRAPPER}} .ui-posts-lead-item .ui-post-meta-top' => 'color: {{VALUE}}',
        ],
        'conditions' => [
            'terms' => [
                ['name' => 'lead_meta_top_position', 'operator' => '!=', 'value' => ''],
            ],
        ],
    ),
    array(
        'id'            => 'lead_meta_top_link_color',
        'type'          =>  Controls_Manager::COLOR,
        'label'         => esc_html__('Before Title Link Color', 'uipro'),
        'selectors' => [
            '{{WRAPPER}} .ui-posts-lead-item .ui-post-meta-top a' => 'color: {{VALUE}}',
        ],
        'conditions' => [
            'terms' => [
                ['name' => 'lead_meta_top_position', 'operator' => '!=', 'value' => ''],
            ],
        ],
    ),
    array(
        'id'            => 'lead_meta_top_link_hover_color',
        'type'          =>  Controls_Manager::COLOR,
        'label'         => esc_html__('Before Title Link Hover Color', 'uipro'),
        'selectors' => [
            '{{WRAPPER}} .ui-posts-lead-item .ui-post-meta-top a:hover' => 'color: {{VALUE}}',
        ],
        'conditions' => [
            'terms' => [
                ['name' => 'lead_meta_top_position', 'operator' => '!=', 'value' => ''],
            ],
        ],
    ),
    array(
        'type'          => Controls_Manager::SELECT,
        'id'            => 'lead_meta_top_margin',
        'label'         => esc_html__('Before Title Position Margin', 'uipro'),
        'description'   => esc_html__('Set the before title margin.', 'uipro'),
        'options'       => array(
            '' => esc_html__('Default', 'uipro'),
            'small' => esc_html__('Small', 'uipro'),
            'medium' => esc_html__('Medium', 'uipro'),
            'large' => esc_html__('Large', 'uipro'),
            'xlarge' => esc_html__('X-Large', 'uipro'),
            'custom' => esc_html__('Custom', 'uipro'),
            'remove-vertical' => esc_html__('None', 'uipro'),
        ),
        'default'           => '',
        'conditions' => [
            'terms' => [
                ['name' => 'lead_meta_top_position', 'operator' => '!=', 'value' => ''],
            ],
        ],
    ),
    array(
        'type'          => Controls_Manager::DIMENSIONS,
        'name'          =>  'lead_meta_top_margin_custom',
        'label'         => esc_html__( 'Before Title Position Margin', 'uipro' ),
        'responsive'    =>  true,
        'size_units'    => [ 'px', 'em', '%' ],
        'selectors'     => [
            '{{WRAPPER}} .ui-posts-lead-item .ui-post-meta-top' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        'conditions' => [
            'terms' => [
                ['name' => 'lead_meta_top_margin', 'operator' => '===', 'value' => 'custom'],
            ],
        ],
    ),
    array(
        'name'          => 'lead_meta_middle_font_family',
        'type'          => Group_Control_Typography::get_type(),
        'scheme'        => Typography::TYPOGRAPHY_1,
        'label'         => esc_html__('After Title Font', 'uipro'),
        'description'   => esc_html__('Select a font family, font size for the addon content.', 'uipro'),
        'selector'      => '{{WRAPPER}} .ui-posts-lead-item .ui-post-meta-middle',
        'separator'     => 'before',
        'conditions' => [
            'terms' => [
                ['name' => 'lead_meta_middle_position', 'operator' => '!=', 'value' => ''],
            ],
        ],
    ),
    array(
        'id'            => 'lead_meta_middle_color',
        'type'          =>  Controls_Manager::COLOR,
        'label'         => esc_html__('After Title Color', 'uipro'),
        'selectors' => [
            '{{WRAPPER}} .ui-posts-lead-item .ui-post-meta-middle' => 'color: {{VALUE}}',
        ],
        'conditions' => [
            'terms' => [
                ['name' => 'lead_meta_middle_position', 'operator' => '!=', 'value' => ''],
            ],
        ],
    ),
    array(
        'id'            => 'lead_meta_middle_link_color',
        'type'          =>  Controls_Manager::COLOR,
        'label'         => esc_html__('After Title Link Color', 'uipro'),
        'selectors' => [
            '{{WRAPPER}} .ui-posts-lead-item .ui-post-meta-middle a' => 'color: {{VALUE}}',
        ],
        'conditions' => [
            'terms' => [
                ['name' => 'lead_meta_middle_position', 'operator' => '!=', 'value' => ''],
            ],
        ],
    ),
    array(
        'id'            => 'lead_meta_middle_link_hover_color',
        'type'          =>  Controls_Manager::COLOR,
        'label'         => esc_html__('After Title Link Hover Color', 'uipro'),
        'selectors' => [
            '{{WRAPPER}} .ui-posts-lead-item .ui-post-meta-middle a:hover' => 'color: {{VALUE}}',
        ],
        'conditions' => [
            'terms' => [
                ['name' => 'lead_meta_middle_position', 'operator' => '!=', 'value' => ''],
            ],
        ],
    ),
    array(
        'type'          => Controls_Manager::SELECT,
        'id'            => 'lead_meta_middle_margin',
        'label'         => esc_html__('After Title Position Margin', 'uipro'),
        'description'   => esc_html__('Set the after title margin.', 'uipro'),
        'options'       => array(
            '' => esc_html__('Default', 'uipro'),
            'small' => esc_html__('Small', 'uipro'),
            'medium' => esc_html__('Medium', 'uipro'),
            'large' => esc_html__('Large', 'uipro'),
            'xlarge' => esc_html__('X-Large', 'uipro'),
            'custom' => esc_html__('Custom', 'uipro'),
            'remove-vertical' => esc_html__('None', 'uipro'),
        ),
        'default'           => '',
        'conditions' => [
            'terms' => [
                ['name' => 'lead_meta_middle_position', 'operator' => '!=', 'value' => ''],
            ],
        ],
    ),
    array(
        'type'          => Controls_Manager::DIMENSIONS,
        'name'          =>  'lead_meta_middle_margin_custom',
        'label'         => esc_html__( 'After Title Position Margin', 'uipro' ),
        'responsive'    =>  true,
        'size_units'    => [ 'px', 'em', '%' ],
        'selectors'     => [
            '{{WRAPPER}} .ui-posts-lead-item .ui-post-meta-middle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        'conditions' => [
            'terms' => [
                ['name' => 'lead_meta_middle_margin', 'operator' => '===', 'value' => 'custom'],
            ],
        ],
    ),
    array(
        'name'          => 'lead_meta_bottom_font_family',
        'type'          => Group_Control_Typography::get_type(),
        'scheme'        => Typography::TYPOGRAPHY_1,
        'label'         => esc_html__('After Description Font', 'uipro'),
        'description'   => esc_html__('Select a font family, font size for the addon content.', 'uipro'),
        'selector'      => '{{WRAPPER}} .ui-posts-lead-item .ui-post-meta-bottom',
        'separator'     => 'before',
        'conditions' => [
            'terms' => [
                ['name' => 'lead_meta_bottom_position', 'operator' => '!=', 'value' => ''],
            ],
        ],
    ),
    array(
        'id'            => 'lead_meta_bottom_color',
        'type'          =>  Controls_Manager::COLOR,
        'label'         => esc_html__('After Description Color', 'uipro'),
        'selectors' => [
            '{{WRAPPER}} .ui-posts-lead-item .ui-post-meta-bottom' => 'color: {{VALUE}}',
        ],
        'conditions' => [
            'terms' => [
                ['name' => 'lead_meta_bottom_position', 'operator' => '!=', 'value' => ''],
            ],
        ],
    ),
    array(
        'id'            => 'lead_meta_bottom_link_color',
        'type'          =>  Controls_Manager::COLOR,
        'label'         => esc_html__('After Description Link Color', 'uipro'),
        'selectors' => [
            '{{WRAPPER}} .ui-posts-lead-item .ui-post-meta-bottom a' => 'color: {{VALUE}}',
        ],
        'conditions' => [
            'terms' => [
                ['name' => 'lead_meta_bottom_position', 'operator' => '!=', 'value' => ''],
            ],
        ],
    ),
    array(
        'id'            => 'lead_meta_bottom_link_hover_color',
        'type'          =>  Controls_Manager::COLOR,
        'label'         => esc_html__('After Description Link Hover Color', 'uipro'),
        'selectors' => [
            '{{WRAPPER}} .ui-posts-lead-item .ui-post-meta-bottom a:hover' => 'color: {{VALUE}}',
        ],
        'conditions' => [
            'terms' => [
                ['name' => 'lead_meta_bottom_position', 'operator' => '!=', 'value' => ''],
            ],
        ],
    ),
    array(
        'type'          => Controls_Manager::SELECT,
        'id'            => 'lead_meta_bottom_margin',
        'label'         => esc_html__('After Description Position Margin', 'uipro'),
        'description'   => esc_html__('Set the after description margin.', 'uipro'),
        'options'       => array(
            '' => esc_html__('Default', 'uipro'),
            'small' => esc_html__('Small', 'uipro'),
            'medium' => esc_html__('Medium', 'uipro'),
            'large' => esc_html__('Large', 'uipro'),
            'xlarge' => esc_html__('X-Large', 'uipro'),
            'remove-vertical' => esc_html__('None', 'uipro'),
        ),
        'default'           => '',
        'conditions' => [
            'terms' => [
                ['name' => 'lead_meta_bottom_position', 'operator' => '!=', 'value' => ''],
            ],
        ],
    ),
    array(
        'name'          => 'lead_meta_footer_font_family',
        'type'          => Group_Control_Typography::get_type(),
        'scheme'        => Typography::TYPOGRAPHY_1,
        'label'         => esc_html__('Footer Font', 'uipro'),
        'description'   => esc_html__('Select a font family, font size for the addon content.', 'uipro'),
        'selector'      => '{{WRAPPER}} .ui-posts-lead-item .ui-post-meta-footer',
        'separator'     => 'before',
        'conditions' => [
            'terms' => [
                ['name' => 'lead_meta_footer_position', 'operator' => '!=', 'value' => ''],
            ],
        ],
    ),
    array(
        'id'            => 'lead_meta_footer_color',
        'type'          =>  Controls_Manager::COLOR,
        'label'         => esc_html__('Footer Color', 'uipro'),
        'selectors' => [
            '{{WRAPPER}} .ui-posts-lead-item .ui-post-meta-footer' => 'color: {{VALUE}}',
        ],
        'conditions' => [
            'terms' => [
                ['name' => 'lead_meta_footer_position', 'operator' => '!=', 'value' => ''],
            ],
        ],
    ),
    array(
        'id'            => 'lead_meta_footer_link_color',
        'type'          =>  Controls_Manager::COLOR,
        'label'         => esc_html__('Footer Link Color', 'uipro'),
        'selectors' => [
            '{{WRAPPER}} .ui-posts-lead-item .ui-post-meta-footer a' => 'color: {{VALUE}}',
        ],
        'conditions' => [
            'terms' => [
                ['name' => 'lead_meta_footer_position', 'operator' => '!=', 'value' => ''],
            ],
        ],
    ),
    array(
        'type'          => Controls_Manager::SELECT,
        'id'            => 'lead_meta_footer_margin',
        'label'         => esc_html__('Footer Margin', 'uipro'),
        'description'   => esc_html__('Set the after description margin.', 'uipro'),
        'options'       => array(
            '' => esc_html__('Default', 'uipro'),
            'small' => esc_html__('Small', 'uipro'),
            'medium' => esc_html__('Medium', 'uipro'),
            'large' => esc_html__('Large', 'uipro'),
            'xlarge' => esc_html__('X-Large', 'uipro'),
            'remove-vertical' => esc_html__('None', 'uipro'),
        ),
        'default'           => '',
        'conditions' => [
            'terms' => [
                ['name' => 'lead_meta_footer_position', 'operator' => '!=', 'value' => ''],
            ],
        ],
    ),
    // Lead Button settings
    array(
        'type'          => Controls_Manager::HEADING,
        'id'            => 'lead_button_settings',
        'label'         => esc_html__('Button Settings', 'uipro'),
        'separator'     => 'before',
    ),
    array(
        'type'          => Controls_Manager::SWITCHER,
        'id'            => 'lead_show_readmore',
        'label'         => esc_html__('Show Readmore', 'uipro'),
        'description'   => esc_html__('Display the first letter of the paragraph as a large initial.', 'uipro'),
        'label_on'      => esc_html__( 'Yes', 'uipro' ),
        'label_off'     => esc_html__( 'No', 'uipro' ),
        'return_value'  => '1',
        'default'       => '0',
    ),
    array(
        'id'    => 'lead_all_button_title',
        'label' => esc_html__( 'Text', 'uipro' ),
        'type' => Controls_Manager::TEXT,
        'default' => esc_html__( 'Read more' , 'uipro' ),
        'label_block' => true,
    ),
    array(
        'id'    => 'lead_target',
        'type' => Controls_Manager::SELECT,
        'label' => esc_html__('Link New Tab', 'uipro'),
        'options' => array(
            '' => esc_html__('Same Window', 'uipro'),
            '_blank' => esc_html__('New Window', 'uipro'),
        ),
    ),
    array(
        'id'    => 'lead_button_style',
        'type' => Controls_Manager::SELECT,
        'label' => esc_html__('Style', 'uipro'),
        'description' => esc_html__('Set the button style.', 'uipro'),
        'options' => array(
            '' => esc_html__('Button Default', 'uipro'),
            'primary' => esc_html__('Button Primary', 'uipro'),
            'secondary' => esc_html__('Button Secondary', 'uipro'),
            'danger' => esc_html__('Button Danger', 'uipro'),
            'text' => esc_html__('Button Text', 'uipro'),
            'link' => esc_html__('Link', 'uipro'),
            'link-muted' => esc_html__('Link Muted', 'uipro'),
            'link-text' => esc_html__('Link Text', 'uipro'),
            'custom' => esc_html__('Custom', 'uipro'),
        ),
        'default' => '',
    ),
    array(
        'name'          => 'lead_button_font_family',
        'type'          => Group_Control_Typography::get_type(),
        'scheme'        => Typography::TYPOGRAPHY_1,
        'label'         => esc_html__('Button Font', 'uipro'),
        'description'   => esc_html__('Select a font family, font size for the addon content.', 'uipro'),
        'selector'      => '{{WRAPPER}} .ui-posts-lead-item .ui-post-button',
        'condition' => array(
            'lead_button_style'    => 'custom'
        ),
    ),
    array(
        'id'            => 'lead_button_background',
        'type'          =>  Controls_Manager::COLOR,
        'label'         => esc_html__('Background Color', 'uipro'),
        'selectors' => [
            '{{WRAPPER}} .ui-posts-lead-item .ui-post-button' => 'background-color: {{VALUE}}',
        ],
        'separator'     => 'before',
        'default' => '#1e87f0',
        'condition' => array(
            'lead_button_style'    => 'custom'
        ),
    ),
    array(
        'id'            => 'lead_button_color',
        'type'          =>  Controls_Manager::COLOR,
        'label'         => esc_html__('Button Color', 'uipro'),
        'selectors' => [
            '{{WRAPPER}} .ui-posts-lead-item .ui-post-button' => 'color: {{VALUE}}',
        ],
        'condition' => array(
            'lead_button_style'    => 'custom'
        ),
    ),
    array(
        'type'          => Controls_Manager::DIMENSIONS,
        'name'          =>  'lead_button_padding',
        'label'         => esc_html__( 'Button Padding', 'uipro' ),
        'responsive'    =>  true,
        'size_units'    => [ 'px', 'em', '%' ],
        'selectors'     => [
            '{{WRAPPER}} .ui-posts-lead-item .ui-post-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        'condition' => array(
            'lead_button_style'    => 'custom'
        ),
    ),
    array(
        'name'            => 'lead_button_border',
        'type'          =>  \Elementor\Group_Control_Border::get_type(),
        'label' => esc_html__( 'Button Border', 'uipro' ),
        'selector' => '{{WRAPPER}} .ui-posts-lead-item .ui-post-button',
        'conditions' => [
            'terms' => [
                ['name' => 'lead_button_style', 'operator' => '===', 'value' => 'custom'],
            ],
        ],
    ),
    array(
        'id'            => 'lead_button_background_hover',
        'type'          =>  Controls_Manager::COLOR,
        'label'         => esc_html__('Hover Background Color', 'uipro'),
        'selectors' => [
            '{{WRAPPER}} .ui-posts-lead-item .ui-post-button:hover' => 'background-color: {{VALUE}}',
        ],
        'default' => '#0f7ae5',
        'separator'     => 'before',
        'condition' => array(
            'lead_button_style'    => 'custom'
        ),
    ),
    array(
        'id'            => 'lead_button_hover_color',
        'type'          =>  Controls_Manager::COLOR,
        'label'         => esc_html__('Hover Button Color', 'uipro'),
        'selectors' => [
            '{{WRAPPER}} .ui-posts-lead-item .ui-post-button:hover' => 'color: {{VALUE}}',
        ],
        'condition' => array(
            'lead_button_style'    => 'custom'
        ),
    ),
    array(
        'name'            => 'lead_button_border_hover',
        'type'          =>  \Elementor\Group_Control_Border::get_type(),
        'label' => esc_html__( 'Button Border', 'uipro' ),
        'selector' => '{{WRAPPER}} .ui-posts-lead-item .ui-post-button:hover',
        'conditions' => [
            'terms' => [
                ['name' => 'lead_button_style', 'operator' => '===', 'value' => 'custom'],
            ],
        ],
    ),
    array(
        'id'    => 'lead_button_size',
        'type' => Controls_Manager::SELECT,
        'label' => esc_html__('Button Size', 'uipro'),
        'options' => array(
            '' => esc_html__('Default', 'uipro'),
            'uk-button-small' => esc_html__('Small', 'uipro'),
            'uk-button-large' => esc_html__('Large', 'uipro'),
            'uk-padding-remove' => esc_html__('None', 'uipro'),
        ),
        'separator'     => 'before',
    ),
    array(
        'id'    => 'lead_button_shape',
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
                ['name' => 'lead_button_style', 'operator' => '!==', 'value' => ['link','link-muted','link-text','text']],
//                ['name' => 'button_style', 'operator' => '!==', 'value' => 'link-muted'],
//                ['name' => 'button_style', 'operator' => '!==', 'value' => 'link-text'],
//                ['name' => 'button_style', 'operator' => '!==', 'value' => 'text'],
            ],
        ],
    ),
    array(
        'id'    => 'lead_button_margin_top',
        'type' => Controls_Manager::SELECT,
        'label' => esc_html__('Margin', 'uipro'),
        'description' => esc_html__('Set the margin.', 'uipro'),
        'options' => array(
            '' => esc_html__('Default', 'uipro'),
            'small' => esc_html__('Small', 'uipro'),
            'medium' => esc_html__('Medium', 'uipro'),
            'large' => esc_html__('Large', 'uipro'),
            'xlarge' => esc_html__('X-Large', 'uipro'),
            'remove' => esc_html__('None', 'uipro'),
            'custom' => esc_html__('Custom', 'uipro'),
        ),
        'default' => '',
    ),
    array(
        'type'          => Controls_Manager::DIMENSIONS,
        'name'          =>  'lead_button_margin',
        'label'         => esc_html__( 'Button Margin', 'uipro' ),
        'responsive'    =>  true,
        'size_units'    => [ 'px', 'em', '%' ],
        'selectors'     => [
            '{{WRAPPER}} .ui-posts-lead-item .ui-post-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        'condition' => array(
            'lead_button_margin_top'    => 'custom'
        ),
    ),
);