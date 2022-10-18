<?php
$templaza_testimonials      = !empty( $instance['templaza-testimonial'] ) ? $instance['templaza-testimonial'] : '';
$testimonials_layout      = !empty( $instance['layout'] ) ? $instance['layout'] : '';
$testimonial_slider_autoplay     = isset( $instance['testimonial_slider_autoplay'] ) ? $instance['testimonial_slider_autoplay'] : '';
$testimonial_slider_center    = !empty( $instance['testimonial_slider_center'] ) ? $instance['testimonial_slider_center'] : '';
$testimonial_slider_navigation    = !empty( $instance['testimonial_slider_navigation'] ) ? $instance['testimonial_slider_navigation'] : '';
$testimonial_slider_navigation_outside    = !empty( $instance['testimonial_slider_navigation_outside'] ) ? $instance['testimonial_slider_navigation_outside'] : '';
$testimonial_slider_navigation_position    = !empty( $instance['testimonial_slider_navigation_position'] ) ? ' '. $instance['testimonial_slider_navigation_position'] : '';
$testimonial_slider_dot    = !empty( $instance['testimonial_slider_dot'] ) ? $instance['testimonial_slider_dot'] : '';
$testimonial_slider_effect    = !empty( $instance['testimonial_slider_effect'] ) ? $instance['testimonial_slider_effect'] : '';
$testimonial_slider_number    = !empty( $instance['testimonial_slider_number'] ) ? $instance['testimonial_slider_number'] : 1;
$testimonial_quote_size    = isset( $instance['testimonial_quote_size'] ) && $instance['testimonial_quote_size']['size'] ? $instance['testimonial_quote_size']['size'] : 32;
$avatar_border    = isset( $instance['avatar_border'] ) && $instance['avatar_border'] ? ' '. $instance['avatar_border'] : '';
$quote_icon = ( isset( $instance['quote_icon'] ) && $instance['quote_icon'] ) ? $instance['quote_icon'] : array();
$nav_next_icon = ( isset( $instance['nav_next_icon'] ) && $instance['nav_next_icon'] ) ? $instance['nav_next_icon'] : array();
$nav_preview_icon = ( isset( $instance['nav_preview_icon'] ) && $instance['nav_preview_icon'] ) ? $instance['nav_preview_icon'] : array();
$nav_next_html='';
$nav_preview_html='';
if ($nav_next_icon && isset($nav_next_icon['value'])) {
    if (is_array($nav_next_icon['value']) && isset($nav_next_icon['value']['url']) && $nav_next_icon['value']['url']) {
        $nav_next_html .='<img class="uk-preserve" src="'.esc_attr($nav_next_icon['value']['url']).'" alt="" data-uk-svg />';
    } elseif (is_string($nav_next_icon['value']) && $nav_next_icon['value']) {
        $nav_next_html .='<i class="'. esc_attr($nav_next_icon['value']) .'" aria-hidden="true"></i>';
    }else{
        $nav_next_html .='<i class="fas fa-angle-right"></i>';
    }
}
if ($nav_preview_icon && isset($nav_preview_icon['value'])) {
    if (is_array($nav_preview_icon['value']) && isset($nav_preview_icon['value']['url']) && $nav_preview_icon['value']['url']) {
        $nav_preview_html .='<img class="uk-preserve" src="'.esc_attr($nav_preview_icon['value']['url']).'" alt="" data-uk-svg />';
    } elseif (is_string($nav_preview_icon['value']) && $nav_preview_icon['value']) {
        $nav_preview_html .='<i class="'. esc_attr($nav_preview_icon['value']) .'" aria-hidden="true"></i>';
    }else{
        $nav_preview_html .='<i class="fas fa-angle-left"></i>';
    }
}
if($testimonial_slider_navigation_outside=='yes'){
    $next = 'uk-position-center-right-out';
    $preview = 'uk-position-center-left-out';
}else{
    $next = 'uk-position-center-right';
    $preview = 'uk-position-center-left';
}
if($testimonial_slider_navigation == 'yes'){
    $testimonial_slider_navigation = 'true';
}else{
    $testimonial_slider_navigation = 'false';
}
if($testimonial_slider_effect == 'yes'){
    $testimonial_slider_effect = 'true';
}else{
    $testimonial_slider_effect = 'false';
}
if($testimonial_slider_center == 'yes'){
    $testimonial_slider_center = 'true';
}else{
    $testimonial_slider_center = 'false';
}
if($testimonial_slider_autoplay == 'yes'){
    $testimonial_slider_autoplay = 'true';
}else{
    $testimonial_slider_autoplay = 'false';
}
if($testimonial_slider_dot == 'yes'){
    $testimonial_slider_dot = 'true';
}else{
    $testimonial_slider_dot = 'false';
}
$btn_next = esc_html__('Next','uipro');
$btn_prev = esc_html__('Prev','uipro');
$module_id = uniqid('templaza_testimonial_');
if ( !empty( $instance['templaza-testimonial'] ) ) {
	$general_styles     =   \UIPro_Elementor_Helper::get_general_styles($instance);
?>
<div class="<?php echo $general_styles['container_cls']; ?> uk-position-relative" <?php echo $general_styles['animation']; ?>>
    <div id="<?php echo $module_id;?>" class="templaza-testimonial <?php echo $general_styles['content_cls'];?> <?php echo esc_attr($testimonials_layout);?>">
        <?php
        foreach ($templaza_testimonials as $item){
        ?>
        <div class="templaza-testimonial-item<?php echo esc_attr($image_class); ?>">
            <?php
            $image  =   isset( $item['author_image'] ) && $item['author_image'] ? $item['author_image'] : array();
             if (isset( $image['url'] ) && $image['url'] ) : ?>
                <div class="ui-testimonial-avatar ">
                    <div class="uk-inline-clip<?php echo $avatar_border; ?> ui-testimonial-image-box">
                        <?php echo \UIPro_Elementor_Helper::get_attachment_image_html( $item, 'author_image' ); ?>
                    </div>
                </div>
            <?php endif;

            if($item['quote_content'] || $item['quote_author'] || $item['author_position']){
            ?>
                <div class="ui-quote-info">
                    <?php
                    if ($quote_icon && isset($quote_icon['value'])) {
                        ?>
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
                        <?php
                    }
                    if($item['quote_content']){
                        ?>
                        <div class="templaza_quote_content">
                            <?php echo esc_html($item['quote_content']); ?>
                        </div>
                    <?php
                    }
                    if($item['quote_author']){
                        ?>
                        <div class="templaza_quote_author">
                            <?php echo esc_html($item['quote_author']);?>
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
                <?php
            }
            ?>
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
                    centerMode: <?php echo esc_attr($testimonial_slider_center); ?>,
                    centerPadding: '0px',
                    slidesToShow: <?php echo esc_attr($testimonial_slider_number);?>,
                    autoplay:<?php echo esc_attr($testimonial_slider_autoplay);?>,
                    autoplaySpeed:3000,
                    arrows:<?php echo esc_attr($testimonial_slider_navigation); ?>,
                    fade: <?php echo esc_attr($testimonial_slider_effect); ?>,
                    dots:<?php echo esc_attr($testimonial_slider_dot);?>,
                    nextArrow:'<span class="btn_next slick-next slick-arrow"><?php echo $nav_next_html;?> </span>',
                    prevArrow:'<span class="btn_prev slick-prev slick-arrow"><?php echo $nav_preview_html;?></span>',
                    infinite:true,
                    focusOnSelect: true,
                    adaptiveHeight: true,
                    responsive: [
                        {
                            breakpoint: 1199,
                            settings: {
                                centerPadding: '0px',
                                slidesToShow: 5
                            }
                        },
                        {
                            breakpoint: 992,
                            settings: {
                                centerMode: <?php echo esc_attr($testimonial_slider_center); ?>,
                                centerPadding: '0px',
                                slidesToShow: 3
                            }
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                centerMode: <?php echo esc_attr($testimonial_slider_center); ?>,
                                centerPadding: '0px',
                                slidesToShow: 3
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                centerMode: <?php echo esc_attr($testimonial_slider_center); ?>,
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