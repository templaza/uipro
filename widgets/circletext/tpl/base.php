<?php

$_is_elementor  =   (isset($args['page_builder']) && $args['page_builder'] == 'elementor')?true:false;

$text           = isset($instance['text']) && $instance['text'] ? $instance['text'] : '';
$hover_rotate   = isset($instance['text_hover_rotate']) && $instance['text_hover_rotate'] ? $instance['text_hover_rotate'] : '';
$general_styles = \UIPro_Elementor_Helper::get_general_styles($instance);
$output = $cl        = '';
if($hover_rotate == 'yes'){
    $cl = ' rotate';
}
if ($text) {
    echo '<div class="ui-text'. $general_styles['container_cls'] . $general_styles['content_cls'] .$cl.'"' . $general_styles['animation'] . '>';
?>
<svg class="circletext" viewBox="0 0 100 100" >
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
<?php
    echo '</div>';
}