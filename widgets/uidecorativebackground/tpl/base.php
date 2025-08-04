<?php
$_is_elementor = ( isset($args['page_builder']) && $args['page_builder'] == 'elementor')?true:false;

$background_style          = isset($instance['background_style']) && $instance['background_style'] ? $instance['background_style'] : 'physics';
$first_color          = isset($instance['color1']) && $instance['color1'] ? $instance['color1'] : '#000000';
$second_color          = isset($instance['color2']) && $instance['color2'] ? $instance['color2'] : '#000000';
$general_styles = \UIPro_Elementor_Helper::get_general_styles($instance);
$attrs = 'as-animation-background-hello';

?>
<div class="<?php echo $general_styles['container_cls']; ?>" <?php echo $general_styles['animation']; ?>>
    <?php
    echo  '<div class="'. $attrs.'"><canvas class="as-animation-background" data-type="'.$background_style.'" data-color1="'.$first_color.'" data-color2="'.$second_color.'"></canvas></div>';
    ?>
</div>
<script>
    jQuery(document).ready(function(){
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.as-animation-background').forEach(function(el) {
                const animation = new AnimationBackground(el);
                animation.init();
            });
        });
    })

</script>