<?php
$templaza_image      = !empty( $instance['templaza_image'] ) ? $instance['templaza_image'] : '';
$parallax_enable      = !empty( $instance['parallax_enable'] ) ? $instance['parallax_enable'] : '';
$parallax_x      = !empty( $instance['parallax_x'] ) ? $instance['parallax_x'] : '';
$parallax_y      = !empty( $instance['parallax_y'] ) ? $instance['parallax_y'] : '';
$parallax_scaling      = !empty( $instance['parallax_scaling'] ) ? $instance['parallax_scaling'] : '';
$parallax_opacity      = !empty( $instance['parallax_opacity'] ) ? $instance['parallax_opacity'] : '';
$parallax_blur      = !empty( $instance['parallax_blur'] ) ? $instance['parallax_blur'] : '';
$parallax_option='';
if($parallax_x){
    $parallax_option .= 'x: '.$parallax_x.';';
}
if($parallax_y){
    $parallax_option .= 'y: '.$parallax_y.';';
}
if($parallax_scaling){
    $parallax_option .= 'scale: '.$parallax_scaling.';';
}
if($parallax_opacity){
    $parallax_option .= 'opacity: '.$parallax_opacity.';';
}
if($parallax_blur){
    $parallax_option .= 'blur: '.$parallax_blur.';';
}

if(!empty($templaza_image)){
?>
<div class="templaza-image" <?php if($parallax_enable=='yes'){?>data-uk-parallax="<?php echo esc_attr($parallax_option);?> media: @m" <?php } ?>>
    <img  src="<?php echo esc_url($templaza_image['url']);?>" data-src="<?php echo esc_url($templaza_image['url']);?>"  alt="" data-uk-img>
    <?php
    }
?>
</div>
