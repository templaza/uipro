<?php
/**
 * Template for displaying default element.
 *
 *
 * @author      TemPlaza.com
 * @package     UIPro/Templates
 * @version     1.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit;

$template_path = 'eventscalendar/tpl/';
$layout        = ( isset( $instance['layout'] ) && $instance['layout'] != '' ) ? $instance['layout'] : 'base';
$args                 = array();
$args['before_title'] = '<h3 class="widget-title">';
$args['after_title']  = '</h3>';

?>

<?php \UIPro_Elementor_Helper::get_widget_template(
	$layout, array(
	'instance' => $instance,
	'args'     => $args
), $template_path
); ?>
