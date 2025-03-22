<?php

$_is_elementor  =   (isset($args['page_builder']) && $args['page_builder'] == 'elementor')?true:false;

$ui_runtext      = !empty( $instance['uiruntext'] ) ? $instance['uiruntext'] : '';
$direction_style      = !empty( $instance['direction_style'] ) ? $instance['direction_style'] : 'left';
$scrollamount      = !empty( $instance['scrollamount'] ) ? $instance['scrollamount'] : '6';
$text_stroke      = !empty( $instance['text_stroke'] ) ? $instance['text_stroke'] : '';
$stroke = '';
if($text_stroke=='1'){
    $stroke = ' text-stroke';
}
$general_styles = \UIPro_Elementor_Helper::get_general_styles($instance);
$output = $cl = '';

if ($ui_runtext) {
    echo '<div class="ui-text'. $general_styles['container_cls'] . $general_styles['content_cls'] .$cl.'"' . $general_styles['animation'] . '>';
?>
    <div class="runtext-container">
        <div class="main-runtext">
            <marquee direction="<?php echo esc_attr($direction_style);?>" scrollamount="<?php echo esc_attr($scrollamount);?>" behavior="alternate">
                <div class="uk-flex uk-flex-middle">
                <?php
                    foreach ($ui_runtext as $item){
                        $image  =   isset( $item['text_image'] ) && $item['text_image'] ? $item['text_image'] : array();
                        ?>
                    <div class="holder">
                        <div class="uk-flex uk-flex-middle" data-uk-height-match>
                            <?php
                            if($item['text_title']){
                                echo '<div class="text-inner '.$stroke.'">'.wp_kses($item['text_title'],'post').'</div>';
                            }
                            $media = '';
                            if ($image && isset($image['value'])) {
                                if (is_array($image['value']) && isset($image['value']['url']) && $image['value']['url']) {
                                    $media .= '<img src="' . $image['value']['url'] . '" alt="" data-uk-svg />';
                                } elseif (is_string($image['value']) && $image['value']) {
                                    $media .= '<i class="' . $image['value'] . '" aria-hidden="true"></i>';
                                }
                                echo '<div class="text-icon">'.$media.'</div>';
                            }
                        ?>
                        </div>
                    </div>
                        <?php
                    }
                ?>
                </div>
            </marquee>
        </div>
    </div>
<?php
    echo '</div>';
}
?>