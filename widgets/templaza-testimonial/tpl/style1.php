<?php
$templaza_testimonials      = !empty( $instance['templaza-testimonial'] ) ? $instance['templaza-testimonial'] : '';
$testimonial_slider_autoplay     = isset( $instance['testimonial_slider_autoplay'] ) ? $instance['testimonial_slider_autoplay'] : '';
$testimonial_slider_center    = !empty( $instance['testimonial_slider_center'] ) ? $instance['testimonial_slider_center'] : '';
$testimonial_slider_navigation    = !empty( $instance['testimonial_slider_navigation'] ) ? $instance['testimonial_slider_navigation'] : '';
$testimonial_slider_navigation_outside    = !empty( $instance['testimonial_slider_navigation_outside'] ) ? $instance['testimonial_slider_navigation_outside'] : '';
$testimonial_slider_navigation_position    = !empty( $instance['testimonial_slider_navigation_position'] ) ? ' '. $instance['testimonial_slider_navigation_position'] : '';
$testimonial_slider_dot    = !empty( $instance['testimonial_slider_dot'] ) ? $instance['testimonial_slider_dot'] : '';
$testimonial_slider_number    = !empty( $instance['testimonial_slider_number'] ) ? $instance['testimonial_slider_number'] : 1;
$testimonial_quote_size    = isset( $instance['testimonial_quote_size'] ) && $instance['testimonial_quote_size']['size'] ? $instance['testimonial_quote_size']['size'] : 32;
$avatar_border    = isset( $instance['avatar_border'] ) && $instance['avatar_border'] ? ' '. $instance['avatar_border'] : '';

$slider_options = '';
if($testimonial_slider_autoplay=='yes'){
    $slider_options .= 'autoplay: true; ';
}
if($testimonial_slider_center=='yes'){
    $slider_options.='center: true';
}
if($testimonial_slider_navigation_outside=='yes'){
    $next = 'uk-position-center-right-out';
    $preview = 'uk-position-center-left-out';
}else{
    $next = 'uk-position-center-right';
    $preview = 'uk-position-center-left';
}
$btn_next = esc_html__('Next','uipro');
$btn_prev = esc_html__('Prev','uipro');
$module_id = uniqid('templaza_testimonial_');
if ( !empty( $instance['templaza-testimonial'] ) ) {
	$general_styles     =   \UIPro_Elementor_Helper::get_general_styles($instance);
?>
<div class="<?php echo $general_styles['container_cls']; ?> uk-position-relative" <?php echo $general_styles['animation']; ?>>
    <span class="quote-icon"><i class="fas fa-quote-left"></i></span>
    <div id="<?php echo esc_attr($module_id);?>" class="templaza-testimonial <?php echo $general_styles['content_cls']. ' '.$instance['layout']; ?>">

        <?php
        foreach ($templaza_testimonials as $item){
            $image  =   isset( $item['author_image'] ) && $item['author_image'] ? $item['author_image'] : array();
            ?>
            <div class="ui-testimonial-content templaza-testimonial-item">
                <?php
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
                    arrows:true,
                    fade: true,
                    dots:false,
                    nextArrow:'<span class="btn_next slick-arrow"><?php echo $btn_next;?> <i class="fas fa-arrow-right uk-margin-small-left"></i></span>',
                    prevArrow:'<span class="btn_prev slick-arrow"><i class="fas fa-arrow-left uk-margin-small-right"></i> <?php echo $btn_prev;?></span>',
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