<?php
$templaza_testimonials      = !empty( $instance['templaza-testimonial'] ) ? $instance['templaza-testimonial'] : '';
$testimonial_slider_autoplay     = isset( $instance['testimonial_slider_autoplay'] ) ? $instance['testimonial_slider_autoplay'] : '';
$testimonial_slider_center    = !empty( $instance['testimonial_slider_center'] ) ? $instance['testimonial_slider_center'] : '';
$testimonial_slider_navigation    = !empty( $instance['testimonial_slider_navigation'] ) ? $instance['testimonial_slider_navigation'] : '';
$testimonial_slider_navigation_position    = !empty( $instance['testimonial_slider_style1_navigation_position'] ) ? $instance['testimonial_slider_style1_navigation_position'] : '';
$testimonial_slider_dot    = !empty( $instance['testimonial_slider_dot'] ) ? $instance['testimonial_slider_dot'] : '';
$testimonial_slider_number    = !empty( $instance['testimonial_slider_number'] ) ? $instance['testimonial_slider_number'] : 1;
$testimonial_quote_size    = isset( $instance['testimonial_quote_size'] ) && $instance['testimonial_quote_size']['size'] ? $instance['testimonial_quote_size']['size'] : 32;
$avatar_border    = isset( $instance['avatar_border'] ) && $instance['avatar_border'] ? ' '. $instance['avatar_border'] : '';
$quote_icon = ( isset( $instance['quote_icon'] ) && $instance['quote_icon'] ) ? $instance['quote_icon'] : array();
$prev_icon = ( isset( $instance['nav_preview_icon'] ) && $instance['nav_preview_icon'] ) ? $instance['nav_preview_icon'] : array();
$next_icon = ( isset( $instance['nav_next_icon'] ) && $instance['nav_next_icon'] ) ? $instance['nav_next_icon'] : array();

$slider_options = '';
if($testimonial_slider_dot=='yes'){
    $dot = 'true';
}else{
    $dot = 'false';
}
if($testimonial_slider_navigation=='yes'){
    $nav = 'true';
}else{
    $nav = 'false';
}
$nav_left = $nav_right = '';
if($testimonial_slider_navigation_position=='center'){
    $nav_left = ' uk-position-center-left';
    $nav_right = ' uk-position-center-right';
}
if($testimonial_slider_autoplay=='yes'){
    $slider_options .= 'autoplay: true; ';
}
if($testimonial_slider_center=='yes'){
    $slider_options.='center: true';
}

$btn_next = esc_html__('Next','uipro');
$btn_prev = esc_html__('Prev','uipro');
$pre_icon_html = '<span class="'. ($nav_left ? $nav_left : ' btn_prev').' slick-arrow"><i class="fas fa-arrow-left uk-margin-small-right"></i> '. $btn_prev.'</span>';
$next_icon_html = '<span class=" '. ($nav_right ? $nav_right : ' btn_next').' slick-arrow">'. $btn_next.' <i class="fas fa-arrow-right uk-margin-small-left"></i></span>';
if (is_array($next_icon['value']) && isset($next_icon['value']['url']) && $next_icon['value']['url']) {
    $next_icon_html='<span class=" '. ($nav_right ? $nav_right : ' btn_next').' slick-arrow"><img class="uk-preserve" src="'.esc_attr($next_icon['value']['url']).'" alt="" data-uk-svg /></span>';
} elseif (is_string($next_icon['value']) && $next_icon['value']) {
    $next_icon_html='<span class=" '. ($nav_right ? $nav_right : ' btn_next').' slick-arrow"><i class="'. esc_attr($next_icon['value']).'" aria-hidden="true"></i></span>';
}
if (is_array($prev_icon['value']) && isset($prev_icon['value']['url']) && $prev_icon['value']['url']) {
    $pre_icon_html='<span class="'. ($nav_left ? $nav_left : ' btn_prev').' slick-arrow"><img class="uk-preserve" src="'.esc_attr($prev_icon['value']['url']).'" alt="" data-uk-svg /></span>';
} elseif (is_string($prev_icon['value']) && $prev_icon['value']) {
    $pre_icon_html='<span class="'. ($nav_left ? $nav_left : ' btn_prev').' slick-arrow"><i class="'. esc_attr($prev_icon['value']).'" aria-hidden="true"></i></span>';
}

$module_id = uniqid('templaza_testimonial_');
if ( !empty( $instance['templaza-testimonial'] ) ) {
	$general_styles     =   \UIPro_Elementor_Helper::get_general_styles($instance);
?>
<div class="<?php echo $general_styles['container_cls']; ?> uk-position-relative" <?php echo $general_styles['animation']; ?>>
    <?php
    if ($quote_icon && isset($quote_icon['value'])) {
        ?>
    <div class="<?php echo $general_styles['content_cls']; ?>">
        <span class="quote-icon uk-inline uk-margin-small-bottom">
            <?php
            if (is_array($quote_icon['value']) && isset($quote_icon['value']['url']) && $quote_icon['value']['url']) {
                ?>
                <img class="uk-preserve" src="<?php echo esc_attr($quote_icon['value']['url']);?>" alt="" data-uk-svg />
                <?php
            } elseif (is_string($quote_icon['value']) && $quote_icon['value']) {
                ?>
                <i class="<?php echo esc_attr($quote_icon['value']);?>" aria-hidden="true"></i>
                <?Php
            }
            ?>
        </span>
    </div>
    <?php
    }
    ?>
    <div id="<?php echo esc_attr($module_id);?>" class="templaza-testimonial <?php echo $general_styles['content_cls']. ' '.$instance['layout']; ?>">

        <?php
        foreach ($templaza_testimonials as $item){
            $image  =   isset( $item['author_image'] ) && $item['author_image'] ? $item['author_image'] : array();
            ?>
            <div class="ui-testimonial-content templaza-testimonial-item">
                <?php
                if($item['quote_title']){
                    ?>
                    <h3 class="templaza_quote_title">
                        <?php echo esc_html($item['quote_title']); ?>
                    </h3>
                    <?php
                }
                if($item['quote_content']){
                    ?>
                    <div class="templaza_quote_content">
                        <?php echo esc_html($item['quote_content']); ?>
                    </div>
                    <?php
                }
                ?>
                <div class="auto-info uk-margin-medium-top">
                    <?php if (isset( $image['url'] ) && $image['url'] ) : ?>
                        <div class="ui-testimonial-avatar">
                            <div class="uk-inline-clip<?php echo $avatar_border; ?>">
                                <?php echo \UIPro_Elementor_Helper::get_attachment_image_html( $item, 'author_image' ); ?>
                            </div>
                        </div>
                    <?php endif;
                    ?>
                    <?php
                    if($item['quote_author']){
                        ?>
                        <div class="templaza_quote_author uk-margin-top">
                            <?php echo esc_html($item['quote_author']); ?>
                        </div>
                        <?php
                    }
                    if($item['author_position']){
                        ?>
                        <span class="templaza_quote_author_position">
                        <?php echo esc_html($item['author_position']); ?>
                        </span>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <?php
        }
        ?>

    </div>
</div>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            "use strict";
            jQuery("#<?php echo $module_id;?>").each(function(){
                jQuery(this).slick({
                    centerMode: true,
                    centerPadding: '0px',
                    slidesToShow: 1,
                    autoplay:false,
                    autoplaySpeed:3000,
                    arrows:<?php echo $nav; ?>,
                    fade: true,
                    dots:<?php echo $dot; ?>,
                    nextArrow:'<?php echo $next_icon_html;?>',
                    prevArrow:'<?php echo $pre_icon_html;?>',
                    infinite:true,
                    focusOnSelect: true,
                    adaptiveHeight: true,
                    responsive: [
                        {
                            breakpoint: 1199,
                            settings: {
                                centerMode: true,
                                centerPadding: '0px',
                                slidesToShow: 1
                            }
                        },
                        {
                            breakpoint: 992,
                            settings: {
                                centerMode: true,
                                centerPadding: '0px',
                                slidesToShow: 1
                            }
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                centerMode: true,
                                centerPadding: '0px',
                                slidesToShow: 1
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                centerMode: true,
                                centerPadding: '0px',
                                slidesToShow: 1
                            }
                        }
                    ]
                });
            });
        });
    </script><!--end script testimonial -->
<?php
}