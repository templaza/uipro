<?php

$_is_elementor  =   (isset($args['page_builder']) && $args['page_builder'] == 'elementor')?true:false;

$text           = isset($instance['text']) && $instance['text'] ? $instance['text'] : '';
$hover_rotate   = isset($instance['text_hover_rotate']) && $instance['text_hover_rotate'] ? $instance['text_hover_rotate'] : '';
$auto_rotate   = isset($instance['text_hover_rotate_automatic']) && $instance['text_hover_rotate_automatic'] ? $instance['text_hover_rotate_automatic'] : '';
$icon               = ( isset( $instance['icon'] ) && $instance['icon'] ) ? $instance['icon'] : array();
$general_styles = \UIPro_Elementor_Helper::get_general_styles($instance);
$output = $cl  = $auto_rot ='';
if($hover_rotate == 'yes'){
    $cl = ' rotate';
}
if($auto_rotate == 'yes'){
    $auto_rot = ' auto_rotate ';
}
$media = '';
if ($icon && isset($icon['value'])) {
    if (is_array($icon['value']) && isset($icon['value']['url']) && $icon['value']['url']) {
        $media .= '<img src="' . $icon['value']['url'] . '" alt="" data-uk-svg />';
    } elseif (is_string($icon['value']) && $icon['value']) {
        $media .= '<i class="' . $icon['value'] . '" aria-hidden="true"></i>';
    }
}
if ($text) {
    echo '<div class="ui-text'. $general_styles['container_cls'] . $general_styles['content_cls'] .$cl.'"' . $general_styles['animation'] . '>';
?>
<svg class="circletext <?php echo esc_attr($auto_rot);?>" viewBox="0 0 100 100" >
    <defs>
        <path id="circle"
              d="
        M 50, 50
        m -37, 0
        a 37,37 0 1,1 74,0
        a 37,37 0 1,1 -74,0"/>
    </defs>
    <text>
        <textPath xlink:href="#circle">
            <?php
                echo ent2ncr($text);
            ?>
        </textPath>
    </text>

</svg>
    <div class="circletext-icon uk-position-cover">
        <div class="uk-position-center"><?php echo $media; ?></div>
    </div>
<?php
    echo '</div>';
}