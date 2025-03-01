<?php
/**
 * Template for displaying default element.
 *
 *
 * @author      TemPlaza.com
 * @package     Thim_Builder/Templates
 * @version     1.0.0
 * @author      Thimpress, tuanta
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit;

$template_path = 'gallery-posts/tpl/';
$layout        = ( isset( $instance['layout'] ) && $instance['layout'] != '' ) ? $instance['layout'] : 'base';
?>

<?php UIPro_Elementor_Helper::get_widget_template(
	$layout, array(
	'instance' => $instance,
), $template_path
); ?>
