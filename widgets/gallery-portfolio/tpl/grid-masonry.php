<?php
$limit      = !empty( $instance['limit'] ) ? $instance['limit'] : 8;
$filter     = isset( $instance['filter'] ) ? $instance['filter'] : true;
$columns    = !empty( $instance['columns'] ) ? $instance['columns'] : 3;

$query_args = array(
	'post_type'      => 'portfolio',
	'tax_query'      => array(
		array(
			'taxonomy' => 'post_format',
			'field'    => 'slug',
			'terms'    => array( 'post-format-gallery' ),
		)
	),
	'posts_per_page' => $limit
);

if ( !empty( $instance['cat'] ) ) {
	if ( '' != get_cat_name( $instance['cat'] ) ) {
		$query_args['cat'] = $instance['cat'];
	}
}

switch ( $columns ) {
	case 2:
		$class_col = "col-sm-6";
		break;
	case 3:
		$class_col = "col-sm-4";
		break;
	case 4:
		$class_col = "col-sm-3";
		break;
	case 5:
		$class_col = "thim-col-5";
		break;
	case 6:
		$class_col = "col-sm-2";
		break;
	default:
		$class_col = "col-sm-4";
}

$class_col .= ' item_post';

$posts_display = new WP_Query( $query_args );


if ( $posts_display->have_posts() ) {
//	wp_enqueue_script( 'magnific-popup');
//	wp_enqueue_script('isotope');
//	wp_enqueue_script('templaza-element-fancybox');
    $categories = array();
    $html = '';
    while ($posts_display->have_posts()) : $posts_display->the_post();

        $src    = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
//        $img    = UIPro_Helper::get_feature_image(get_post_thumbnail_id(), 'full',
//            apply_filters('templaza_gallery_post_thumbnail_width', 440),
//            apply_filters('templaza_gallery_post_thumbnail_height', 440), get_the_title());
        $img    = UIPro_Helper::get_feature_image(get_post_thumbnail_id(), 'full');
        $cat_filter = '';
        $cats = get_the_category();
        if (!empty($cats)) {
            foreach ($cats as $key => $value) {
                $cat_filter .= ' filter-'.$value->term_id;
                $categories[$value->term_id] = $value->name;
            }
        }

        $html   .= '<li data-filter="'.trim($cat_filter).'">';
        $html   .= '<a href="'.$src[0].'" data-fancybox="images" class="uk-transition-toggle" data-caption="'
            .get_the_title().'">';
        $html   .= '<div class="uk-inline uk-dark">';
        $html   .= $img;
        $html   .= '<div class="uk-position-cover uk-overlay-primary uk-transition-fade">
                <div class="uk-position-center uk-text-center">
                    <span class="eicon-frame-expand uk-transition-slide-top-small"></span>
                    <h3 class="ui-title uk-margin-remove-top uk-transition-slide-bottom-small">'.get_the_title().'</h3>';
        $html   .= '</div></div>';
        $html   .= '</div>';
        $html   .= '</a>';
        $html   .= '</li>';
    endwhile;

    ?>
    <div uk-filter="target: .js-filter">
        <?php if ($filter){
            ?>
            <ul class="uk-subnav uk-subnav-pill">
                <li class="uk-active" uk-filter-control><a href="#"><?php echo esc_html_e('All', 'uipro');?></a></li>
                <?php
                if (!empty($categories)) {
                    foreach ($categories as $key => $value) { ?>
                        <li uk-filter-control="[data-filter~='filter-<?php echo $key;?>']"><a href="#"><?php echo $value ?></a></li>
                        <?php
                    }
                }
                ?>
            </ul>
        <?php } ?>

        <ul class="js-filter<?php echo $columns ? ' uk-child-width-1-2@s uk-child-width-1-' . $columns . '@m' : ''; ?>"
            data-uk-grid="masonry: true">
            <?php echo $html; ?>
        </ul>
    </div>

    <?php
}
wp_reset_postdata();
