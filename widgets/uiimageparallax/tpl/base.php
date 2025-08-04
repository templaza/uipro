<?php
$_is_elementor = ( isset($args['page_builder']) && $args['page_builder'] == 'elementor')?true:false;

$image          = isset($instance['image']) && $instance['image'] ? $instance['image'] : array();
$title          = isset($instance['title']) && $instance['title'] ? $instance['title'] : '';
$button_text    = isset($instance['button_text']) && $instance['button_text'] ? $instance['button_text'] : '';

$general_styles = \UIPro_Elementor_Helper::get_general_styles($instance);
if ($image && isset($image['url']) && $image['url']) {
?>
<div class="<?php echo $general_styles['container_cls']; ?>" <?php echo $general_styles['animation']; ?>>
    <div class="uiimage-parallax-wrap">
        <div class="uiimage-parallax">
            <div class="uiimage-parallax-media">
                <a class="uk-position-cover" href="<?php echo esc_url($image['url']);?>" data-elementor-open-lightbox="yes" data-elementor-lightbox-slideshow="uiimageparallax" data-elementor-lightbox-title="<?php echo esc_attr($image['alt']);?>" >
                    <img class="uiimage_image" src="<?php echo esc_url($image['url']);?>" alt="<?php echo esc_attr($image['alt']);?>">
                </a>
            </div>
            <?php if($title || $button_text){ ?>
            <div class=" uiimage-parallax_content">
                <h2 class="uiimage-parallax-title"><?php echo esc_html($title);?></h2>
                <?php if($button_text){ ?>
                <button class="templaza-btn uiimage-parallax-btn"><?php echo esc_html($button_text);?></button>
                <?php } ?>
            </div>
            <?php } ?>
        </div>
    </div>

</div>
<?php
}