<?php
$shape      = ( isset(  $instance['uishape_type'] ) &&  $instance['uishape_type'] ) ?  $instance['uishape_type'] : '';
$align      = ( isset(  $instance['text_align'] ) &&  $instance['text_align'] ) ?  $instance['text_align'] : '';
if(!empty($shape)){
?>
<div class="shape-wrap uk-flex <?php echo esc_attr($align);?>">
    <div class="tz-shape <?php echo esc_attr($shape);?>"></div>
    <?php
    }
?>
</div>