<?php
$_is_elementor = ( isset($args['page_builder']) && $args['page_builder'] == 'elementor')?true:false;

$image1          = isset($instance['image1']) && $instance['image1'] ? $instance['image1'] : array();
$image2          = isset($instance['image2']) && $instance['image2'] ? $instance['image2'] : array();
$image_transition = isset($instance['image_transition_style']) && $instance['image_transition_style'] ? $instance['image_transition_style'] :'8';
$image_easing = isset($instance['image_easing']) && $instance['image_easing'] ? $instance['image_easing'] :'Sine.easeOut';
$image_intensity = isset($instance['image_intensity']) && $instance['image_intensity'] ? $instance['image_intensity'] :array();
$image_speedin = isset($instance['image_speedin']) && $instance['image_speedin'] ? $instance['image_speedin'] :array();
$image_speedout = isset($instance['image_speedout']) && $instance['image_speedout'] ? $instance['image_speedout'] :array();

$general_styles = \UIPro_Elementor_Helper::get_general_styles($instance);

$img= plugins_url( '/uipro/widgets/uiimagetransition/assets/img/'.$image_transition.'.jpg');
?>
<svg class="hidden">
    <symbol id="icon-arrow" viewBox="0 0 24 24">
        <title>arrow</title>
        <polygon points="6.3,12.8 20.9,12.8 20.9,11.2 6.3,11.2 10.2,7.2 9,6 3.1,12 9,18 10.2,16.8 "/>
    </symbol>
    <symbol id="icon-drop" viewBox="0 0 24 24">
        <title>drop</title>
        <path d="M12,21c-3.6,0-6.6-3-6.6-6.6C5.4,11,10.8,4,11.4,3.2C11.6,3.1,11.8,3,12,3s0.4,0.1,0.6,0.3c0.6,0.8,6.1,7.8,6.1,11.2C18.6,18.1,15.6,21,12,21zM12,4.8c-1.8,2.4-5.2,7.4-5.2,9.6c0,2.9,2.3,5.2,5.2,5.2s5.2-2.3,5.2-5.2C17.2,12.2,13.8,7.3,12,4.8z"/><path d="M12,18.2c-0.4,0-0.7-0.3-0.7-0.7s0.3-0.7,0.7-0.7c1.3,0,2.4-1.1,2.4-2.4c0-0.4,0.3-0.7,0.7-0.7c0.4,0,0.7,0.3,0.7,0.7C15.8,16.5,14.1,18.2,12,18.2z"/>
    </symbol>
    <svg id="icon-github" viewBox="0 0 33 33">
        <title>github</title>
        <path d="M16.608.455C7.614.455.32 7.748.32 16.745c0 7.197 4.667 13.302 11.14 15.456.815.15 1.112-.353 1.112-.785 0-.386-.014-1.411-.022-2.77-4.531.984-5.487-2.184-5.487-2.184-.741-1.882-1.809-2.383-1.809-2.383-1.479-1.01.112-.99.112-.99 1.635.115 2.495 1.679 2.495 1.679 1.453 2.489 3.813 1.77 4.741 1.353.148-1.052.569-1.77 1.034-2.177-3.617-.411-7.42-1.809-7.42-8.051 0-1.778.635-3.233 1.677-4.371-.168-.412-.727-2.069.16-4.311 0 0 1.367-.438 4.479 1.67a15.602 15.602 0 0 1 4.078-.549 15.62 15.62 0 0 1 4.078.549c3.11-2.108 4.475-1.67 4.475-1.67.889 2.242.33 3.899.163 4.311C26.37 12.66 27 14.115 27 15.893c0 6.258-3.809 7.635-7.437 8.038.584.503 1.105 1.497 1.105 3.017 0 2.177-.02 3.934-.02 4.468 0 .436.294.943 1.12.784 6.468-2.159 11.131-8.26 11.131-15.455 0-8.997-7.294-16.29-16.291-16.29"></path>
    </svg>
</svg>

    <div class="grid__item grid__item--bg theme-15">
        <div class="grid__item-img" data-easing="<?php echo esc_attr($image_easing);?>" data-displacement="<?php echo esc_url($img);?>" data-intensity="<?php echo esc_attr($image_intensity['size']);?>" data-speedIn="<?php echo esc_attr($image_speedin['size']);?>" data-speedOut="<?php echo esc_attr($image_speedout['size']);?>">
            <img src="<?php echo esc_url($image1['url']);?>" alt="Image"/>
            <img src="<?php echo esc_url($image2['url']);?>" alt="Image"/>
        </div>
    </div>

<script>
    jQuery(document).ready(function(){
        Array.from(document.querySelectorAll('.grid__item-img')).forEach((el) => {
            const imgs = Array.from(el.querySelectorAll('img'));
            new hoverEffect({
                parent: el,
                intensity: el.dataset.intensity || undefined,
                speedIn: el.dataset.speedin || undefined,
                speedOut: el.dataset.speedout || undefined,
                easing: el.dataset.easing || undefined,
                hover: el.dataset.hover || undefined,
                image1: imgs[0].getAttribute('src'),
                image2: imgs[1].getAttribute('src'),
                displacementImage: el.dataset.displacement
            });
        });
    })

</script>