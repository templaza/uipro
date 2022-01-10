<?php
$_is_elementor = ( isset($args['page_builder']) && $args['page_builder'] == 'elementor')?true:false;

$image          = isset($instance['image']) && $instance['image'] ? $instance['image'] : array();
$caption        = isset($instance['caption']) && $instance['caption'] ? $instance['caption'] : '';
$flash_effect   =   isset($instance['flash_effect']) ? intval($instance['flash_effect']) : 0;
$class          =   isset($instance['image_border']) && $instance['image_border'] ? ' '. $instance['image_border'] : '';
$class          .=  $flash_effect ? ' ui-image-flash-effect' : '';

$general_styles = \UIPro_Elementor_Helper::get_general_styles($instance);
$output         = '';
if ($image && isset($image['url']) && $image['url']) {
	$output     =   '<div class="ui-image'. $general_styles['container_cls'] . $general_styles['content_cls'] .'"' . $general_styles['animation']  .'>';
	if ($caption) {
		$output .=  '<figure class="wp-caption">';
	}
	$output     .=  '<div class="uk-inline uk-overflow-hidden ui-image-detail'.$class.'">'. \UIPro_Elementor_Helper::get_attachment_image_html( $instance ).'</div>';
	if ($caption) {
		$output .=  '<figcaption class="widget-image-caption wp-caption-text">'.$caption.'</figcaption>';
		$output .=  '</figure>';
	}
	$output     .=  '</div>';
	echo ent2ncr($output);
}