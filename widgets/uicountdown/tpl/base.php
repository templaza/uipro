<?php
defined( 'UIPRO' ) || exit;

// Get custom fields

$general_styles = \UIPro_Elementor_Helper::get_general_styles($instance);

$countdown_date      =   isset($instance['countdown_date']) ? $instance['countdown_date'] : '';
$show_label      =   isset($instance['countdown_label']) ? $instance['countdown_label'] : 'yes';
$day_label      =   isset($instance['day_label']) ? $instance['day_label'] : 'Days';
$hour_label      =   isset($instance['hour_label']) ? $instance['hour_label'] : 'Hours';
$minute_label      =   isset($instance['minute_label']) ? $instance['minute_label'] : 'Minutes';
$second_label      =   isset($instance['second_label']) ? $instance['second_label'] : 'Seconds';
$countdown_separator      =   isset($instance['countdown_separator']) ? $instance['countdown_separator'] : 'yes';
$separator     =   isset($instance['separator']) ? $instance['separator'] : 'string';
$separator_icon     =   isset($instance['separator_icon']) ? $instance['separator_icon'] : '';
$text_align     =   isset($instance['text_alignment']) ? $instance['text_alignment'] : 'left';
$countdown_vertical     =   isset($instance['countdown_vertical']) ? $instance['countdown_vertical'] : 'middle';
$countdown_gap     =   isset($instance['countdown_gap']) ? $instance['countdown_gap'] : '';

if($separator == 'string'){
    $separtor_value = isset($instance['separator_label']) ? $instance['separator_label'] : ':';
}else{
    if ($separator_icon && isset($separator_icon['value'])) {
        ?>
            <?php
            if (is_array($separator_icon['value']) && isset($separator_icon['value']['url']) && $separator_icon['value']['url']) {
                $separtor_value = '<img src="'. esc_attr($separator_icon['value']['url']).'" alt="" data-uk-svg />';
            } elseif (is_string($separator_icon['value']) && $separator_icon['value']) {
                $separtor_value = '<i class="'. esc_attr($separator_icon['value']).'" aria-hidden="true"></i>';
            }
            ?>
        <?php
    }
}
?>
<div class=" <?php echo esc_attr($general_styles['container_cls'] . $general_styles['content_cls'] . ' ');?>" <?php echo wp_kses($general_styles['animation'],'post');?>>
    <div class="uk-grid-<?php echo esc_attr($countdown_gap);?> uk-flex uk-flex-<?php echo esc_attr($countdown_vertical);?> uk-flex-<?php echo esc_attr($text_align);?> uk-child-width-auto" data-uk-grid data-uk-countdown="date: <?php echo esc_attr($countdown_date);?>+00:00">
        <?php
        if($instance['title']){
            ?>
        <div class="countdowwn-title"><?php echo esc_html($instance['title']);?></div>
        <?php
        }
        ?>
        <div>
            <div class="uk-countdown-number uk-countdown-days"></div>
            <?php if($show_label=='yes'){ ?>
            <div class="uk-countdown-label uk-margin-small uk-text-center "><?php echo esc_html($day_label);?></div>
            <?php } ?>
        </div>
        <?php if($countdown_separator == 'yes'){ ?>
        <div class="uk-countdown-separator"><?php echo $separtor_value; ?></div>
        <?php } ?>
        <div>
            <div class="uk-countdown-number uk-countdown-hours"></div>
            <?php if($show_label=='yes'){ ?>
                <div class="uk-countdown-label uk-margin-small uk-text-center "><?php echo esc_html($hour_label);?></div>
            <?php } ?>
        </div>
        <?php if($countdown_separator == 'yes'){ ?>
            <div class="uk-countdown-separator"><?php echo $separtor_value; ?></div>
        <?php } ?>
        <div>
            <div class="uk-countdown-number uk-countdown-minutes"></div>
            <?php if($show_label=='yes'){ ?>
                <div class="uk-countdown-label uk-margin-small uk-text-center "><?php echo esc_html($minute_label);?></div>
            <?php } ?>
        </div>
        <?php if($countdown_separator == 'yes'){ ?>
            <div class="uk-countdown-separator"><?php echo $separtor_value; ?></div>
        <?php } ?>
        <div>
            <div class="uk-countdown-number uk-countdown-seconds"></div>
            <?php if($show_label=='yes'){ ?>
                <div class="uk-countdown-label uk-margin-small uk-text-center "><?php echo esc_html($second_label);?></div>
            <?php } ?>
        </div>
    </div>
</div>