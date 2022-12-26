<?php
defined( 'ABSPATH' ) || exit;

$_is_elementor  = (isset($args['page_builder']) && $args['page_builder'] == 'elementor')?true:false;

$color_mode         = (isset($instance['color_mode'] ) && $instance['color_mode'] ) ? ' uk-'. $instance['color_mode'] : '';
$pagination_type    = (isset($instance['pagination_type']) && $instance['pagination_type']) ? $instance['pagination_type'] : 'none';
$masonry            = (isset($instance['masonry']) && $instance['masonry']) ? intval($instance['masonry']) : 0;

//Get posts
$limit          = ( isset( $instance['limit'] ) && $instance['limit'] ) ? $instance['limit'] : 4;
$resource       = ( isset( $instance['resource'] ) && $instance['resource'] ) ? $instance['resource'] : 'post';
$ordering       = ( isset( $instance['ordering'] ) && $instance['ordering'] ) ? $instance['ordering'] : 'latest';
$category   = ( isset( $instance[$resource.'_category'] ) && $instance[$resource.'_category'] ) ? $instance[$resource.'_category'] : array('0');
$query_args = array(
    'post_type'         => $resource,
    'posts_per_page'    => $limit,
);
switch ($ordering) {
	case 'latest':
		$query_args['orderby'] = 'date';
		$query_args['order'] = 'DESC';
		break;
	case 'oldest':
		$query_args['orderby'] = 'date';
		$query_args['order'] = 'ASC';
		break;
	case 'random':
		$query_args['orderby'] = 'rand';
		break;
	case 'popular':
		$query_args['orderby'] = 'meta_value_num';
		$query_args['order'] = 'DESC';
		$query_args['meta_key'] = 'post_views_count';
		break;
	case 'sticky':
		$query_args['post__in'] = get_option( 'sticky_posts' );
		$query_args['ignore_sticky_posts'] = 1;
		break;
}
if ($resource == 'post') {
	$query_args['category']  =   implode(',', $category);
} else {
	if (count($category) && $category[0] != '0') {
		$query_args['tax_query'] =   array(
			array(
				'taxonomy' => $resource.'-category',
				'field' => 'id',
				'operator' => 'IN',
				'terms' => $category,
			)
		);
	}
}
if ($pagination_type == 'default') {
    $query_args['paged'] = max( 1, get_query_var('paged') );
}

// Based on WP get_posts() default function
$defaults = array(
    'numberposts'      => 5,
    'category'         => 0,
    'orderby'          => 'date',
    'order'            => 'DESC',
    'include'          => array(),
    'exclude'          => array(),
    'meta_key'         => '',
    'meta_value'       => '',
    'post_type'        => 'post',
    'suppress_filters' => true,
);

$parsed_args = wp_parse_args( $query_args, $defaults );
if ( empty( $parsed_args['post_status'] ) ) {
    $parsed_args['post_status'] = ( 'attachment' === $parsed_args['post_type'] ) ? 'inherit' : 'publish';
}
if ( ! empty( $parsed_args['numberposts'] ) && empty( $parsed_args['posts_per_page'] ) ) {
    $parsed_args['posts_per_page'] = $parsed_args['numberposts'];
}
if ( ! empty( $parsed_args['category'] ) ) {
    $parsed_args['cat'] = $parsed_args['category'];
}
if ( ! empty( $parsed_args['include'] ) ) {
    $incposts                      = wp_parse_id_list( $parsed_args['include'] );
    $parsed_args['posts_per_page'] = count( $incposts );  // Only the number of posts included.
    $parsed_args['post__in']       = $incposts;
} elseif ( ! empty( $parsed_args['exclude'] ) ) {
    $parsed_args['post__not_in'] = wp_parse_id_list( $parsed_args['exclude'] );
}

$parsed_args['ignore_sticky_posts'] = true;
if ($pagination_type == 'none') {
    $parsed_args['no_found_rows']       = true;
}

$post_query = new WP_Query($parsed_args);
$posts = $post_query->posts;
/*
 * End of WP get_posts() default function
 * Replace with original function
 * $posts      =   get_posts($query_args);
 */
wp_reset_postdata();

$layout_mode    = (isset($instance['layout_mode'])) ? $instance['layout_mode'] : 'ticker';
$show_shape		= (isset($instance['show_shape'])) ? filter_var($instance['show_shape'], FILTER_VALIDATE_BOOLEAN) : true;
$heading_shape 	= (isset($instance['heading_shape'])) ? $instance['heading_shape'] : 'arrow';

$show_introtext = (isset($instance['show_introtext'])) ? filter_var($instance['show_introtext'], FILTER_VALIDATE_BOOLEAN) : true;

$ticker_heading = (isset($instance['ticker_heading'])) ? $instance['ticker_heading'] : esc_html__('Breaking News', 'uipro');

// Slider setting
$slider_speed       = isset($instance['slider_speed'])?$instance['slider_speed']:50;
$carousel_autoplay  = isset($instance['carousel_autoplay'])?filter_var($instance['carousel_autoplay'], FILTER_VALIDATE_BOOLEAN):false;
$carousel_touch     = isset($instance['carousel_touch'])?filter_var($instance['carousel_touch'], FILTER_VALIDATE_BOOLEAN):false;
$carousel_arrow     = isset($instance['carousel_arrow'])?filter_var($instance['carousel_arrow'], FILTER_VALIDATE_BOOLEAN):false;

$move_slide         = isset($instance['move_slide'])?$instance['move_slide']:1;
$number_of_items    = isset($instance['number_of_items'])?$instance['number_of_items']:3;

$breakpoints    = \Elementor\Plugin::instance() -> breakpoints ->get_active_breakpoints();
$minSlides      = array();
if($breakpoints){
    foreach ($breakpoints as $breakpoint){
        $key = 'number_of_items_' . $breakpoint->get_name();
        if(isset($instance[$key])){
            $minSlides[$breakpoint->get_name()]    = $instance[$key];
        }
    }
}
if(!empty($minSlides)){
    $minSlides['__desktop']    = $number_of_items;
}else{
    $minSlides  = $number_of_items;
}

$slider_setting = array(
    'speed'      => $slider_speed,
    'auto' => $carousel_autoplay,
    'autoStart' => $carousel_autoplay,
    'touchEnabled'    => $carousel_touch,
    'controls'    => $carousel_arrow,
);

if($layout_mode == 'ticker' || $layout_mode == 'scroller'){
    $slider_setting['mode'] = 'vertical';
    if($layout_mode == 'scroller' && !empty($minSlides)){
        $slider_setting['minSlides']    = $minSlides;
        $slider_setting['moveSlides']   = $move_slide;
    }
}

?>
<div class="ui-posts-scroller<?php echo $layout_mode == 'ticker'?' uk-flex':'';?> layout-mode-<?php
echo $layout_mode; ?>" data-ui-slider-setting="<?php
echo esc_attr(json_encode($slider_setting)); ?>">

    <?php if($layout_mode == 'ticker'){ ?>
	<div class="ticker-heading">
		<?php echo $ticker_heading; ?>
		<?php
		if($show_shape){
			if($heading_shape == 'slanted-left'){
			    ?>
            <svg class="ticker-shape-left" width="50" height="100%" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" shape-rendering="geometricPrecision">
                <path d="M0 50h50L25 0H0z" fill="#E91E63"/>
            </svg>
            <?php } elseif ($heading_shape == 'slanted-right') { ?>
            <svg class="ticker-shape-right" width="50" height="100%" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" shape-rendering="geometricPrecision">
                <path d="M0 0h50L25 50H0z" fill="#E91E63"/>
            </svg>
            <?php } else { ?>
            <svg class="ticker-shape-arrow" width="50" height="100%" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" shape-rendering="geometricPrecision">
               <path d="M0 0h25l25 25-25 25H0z" fill="#E91E63"/>
            </svg>
            <?php
			}
		}
		?>
	</div>
    <?php } ?>
    <div class="uiposts-scroller-ticker uk-flex uk-flex-middle uk-width-1-1">
        <div class="ticker-content">
            <?php
            $item_class = $layout_mode == 'ticker'?' uk-flex uk-flex-middle':'';
            $item_class = $layout_mode == 'scroller'?' uk-flex uk-flex-stretch':$item_class;
            foreach ($posts as $i => $item) {
                ?>
                <div class="slider-item<?php echo esc_attr($item_class); ?>">
                    <div class="slider-item-content uk-width-expand<?php echo $layout_mode == 'scroller'?' uk-flex-last':'';
                    ?>">
                        <a class="ticker-title uk-h3" href="<?php
                        echo get_permalink( $item->ID ) ;?>"><?php echo $item -> post_title; ?></a>
                        <?php if($show_introtext){ ?>
                        <div class="ticker-introtext">
                            <?php echo get_the_excerpt($item -> ID); ?>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="ticker-date-time<?php echo $layout_mode=='scroller'?' uk-flex uk-flex-middle uk-width-1-5 uk-text-center':'';?>">
                        <div class="ticker-date-meta<?php echo $layout_mode == 'scroller'?' uk-text-center uk-width-1-1':''; ?>">
                            <span class="ticker-day"><?php echo date_i18n( __( 'd', 'uipro' ), strtotime($item -> post_date));?></span>
                            <span class="ticker-month"><?php echo date_i18n( __( 'M', 'uipro' ), strtotime($item -> post_date));?></span>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <?php if($carousel_arrow){ ?>
        <div class="ticker-controller">
            <span class="ticker-left-control"></span>
            <span class="ticker-right-control"></span>
        </div>
        <?php } ?>
	</div>
</div>
