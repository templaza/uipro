<?php

$_is_elementor  = (isset($args['page_builder']) && $args['page_builder'] == 'elementor') ? true : false;

$number_events  = isset($instance['number_events_calendars']) ? (int)$instance['number_events_calendars'] : 4;
$cat_id         = isset($instance['cat_id']) ? $instance['cat_id'] : 'all';
$button_text    = isset($instance['button_text']) && $instance['button_text'] ? $instance['button_text'] : esc_html__('View More', 'uipro');
$button_style   = isset($instance['button_style']) && $instance['button_style'] ? ' uk-button-' . $instance['button_style'] : ' uk-button-default';
$button_shape   = isset($instance['button_shape']) && $instance['button_shape'] ? ' uk-border-' . $instance['button_shape'] : ' uk-border-rounded';
$button_size    = isset($instance['button_size']) && $instance['button_size'] ? ' uk-button-' . $instance['button_size'] : '';
$card_style     = isset($instance['card_style']) && $instance['card_style'] ? ' uk-card-' . $instance['card_style'] : '';
$card_size      = isset($instance['card_size']) && $instance['card_size'] ? ' uk-card-' . $instance['card_size'] : '';
$general_styles = \UIPro_Elementor_Helper::get_general_styles($instance);

$args_query = [
    'events_per_page' => $number_events,
    'event_status'    => 'publish',
];
if ($cat_id !== 'all') {
    $args_query['tax_query'] = [
        [
            'taxonomy' => 'tribe_events_cat',
            'field'    => 'term_id',
            'terms'    => $cat_id,
        ],
    ];
}

$events = tribe_get_events($args_query);
$output = '';

if ($events) {
    $output .= '<div class="templaza-list-events ui-card-list ' . $general_styles['container_cls'] . '" ' . $general_styles['animation'] . '>';

    foreach ($events as $event) {
        $event_id   = $event->ID;
        $title      = get_the_title($event_id);
        $url        = get_permalink($event_id);
        $image_url  = get_the_post_thumbnail_url($event_id, 'large');
        $start_date = tribe_get_start_date($event_id, false, 'F j, Y g:i a');
        $end_date   = tribe_get_end_date($event_id, false, 'F j, Y g:i a');
        $price      = tribe_get_cost($event_id, true);
        $day        = tribe_get_start_date($event_id, false, 'd');
        $month_year = tribe_get_start_date($event_id, false, 'M Y');

        $output .= '<div class="ui-card uk-card' . $card_style . $card_size . ' uk-card-custom">';
        $output .= '<div class="uk-grid uk-card-list as-image-hover-menu" data-uk-grid>';

        //Ngày/Tháng
        $output .= '<div class="uk-card-meta uk-first-column">';
        $output .= '<div class="event-date-box uk-inline-block">';
        $output .= '<div class="event-day uk-text-bold uk-text-large">' . esc_html($day) . '</div>';
        $output .= '<div class="event-month uk-text-meta">' . esc_html($month_year) . '</div>';
        $output .= '</div></div>';

        //Ảnh
        if ($image_url) {
            $output .= '<div class="ui-media-wrap ui-media">';
            $output .= '<a href="' . esc_url($url) . '" class="event-thumb">';
            $output .= '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($title) . '" />';
            $output .= '</a></div>';
        }

        //Content
        $heading_tag = isset($instance['title_heading_style']) && $instance['title_heading_style']
            ? $instance['title_heading_style']
            : 'h4';

        $output .= '<div class="ui-card-text">';
        $output .= '<' . esc_attr($heading_tag) . ' class="uk-margin-remove uk-card-title">';
        $output .= '<a href="' . esc_url($url) . '" class="uk-text-bold uk-link-reset">' . esc_html($title) . '</a>';
        $output .= '</' . esc_attr($heading_tag) . '>';

        $output .= '<div class="event-date">' . esc_html($start_date) . ' – ' . esc_html($end_date) . '</div>';

        if ($price) {
            $output .= '<div class="uk-price"><span class="uk-margin-small-right">Price:</span><span>' . esc_html($price) . '</span></div>';
        }

        $output .= '</div>';

        // Button
        $output .= '<div class="ui-button">';
        $output .= '<a href="' . esc_url($url) . '" class="uk-button' . $button_style . $button_shape . $button_size . '">';
        $output .= esc_html($button_text);
        $output .= '</a></div>';

        $output .= '</div>';
        $output .= '</div>';
    }

    $output .= '</div>';
} else {
    $output .= '<p>' . esc_html__('No events found.', 'uipro') . '</p>';
}

echo ent2ncr($output);
wp_reset_postdata();
?>
