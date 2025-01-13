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
$testimonials_visible      = !empty( $instance['testimonial_slider_wrap'] ) ? $instance['testimonial_slider_wrap'] : '';
$quote_icon = ( isset( $instance['quote_icon'] ) && $instance['quote_icon'] ) ? $instance['quote_icon'] : array();
$gap = ( isset( $instance['gap'] ) && $instance['gap'] ) ? $instance['gap'] : 'collapse';
$testimonial_slider_author_position = ( isset( $instance['testimonial_slider_author_position'] ) && $instance['testimonial_slider_author_position'] ) ? $instance['testimonial_slider_author_position'] : '';
if($gap =='default'){
    $gap = ' uk-grid';
}
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
if ( !empty( $instance['templaza-testimonial'] ) ) {
	$general_styles     =   \UIPro_Elementor_Helper::get_general_styles($instance);
?>
<div class="<?php echo $general_styles['container_cls']; ?>" <?php echo $general_styles['animation']; ?>>
    <div data-uk-slider="<?php echo esc_attr($slider_options);?>" class="templaza-testimonial<?php echo $general_styles['content_cls']. ' '.$testimonials_visible; ?>">
        <div class="uk-position-relative  uk-visible-toggle " tabindex="-1">
            <?php if($testimonials_visible ==''){ ?>
            <div class="uk-slider-container">
                <?php } ?>
                <ul class="uk-slider-items uk-child-width-1-1 uk-child-width-1-1@s uk-child-width-1-<?php echo esc_attr($testimonial_slider_number);?>@m uk-grid-<?php echo esc_attr($gap);?>">
					<?php
					foreach ($templaza_testimonials as $item){
					    $image  =   isset( $item['author_image'] ) && $item['author_image'] ? $item['author_image'] : array();
						?>
                        <li>
                            <div class="uk-flex-middle" data-uk-grid>
                                <div class="ui-testimonial-content uk-width-expand@m">
                                    <?php
                                    if($testimonial_slider_author_position == 'top-center'){
	                                    if (isset( $image['url'] ) && $image['url'] ) : ?>
                                            <div class="ui-testimonial-avatar uk-width-auto uk-position-top-center uk-position-z-index">
                                                <div class="uk-inline-clip<?php echo $avatar_border; ?>">
				                                    <?php echo \UIPro_Elementor_Helper::get_attachment_image_html( $item, 'author_image' ); ?>
                                                </div>
                                            </div>
	                                    <?php endif;
                                    }
                                    ?>
                                    <div class="tz-testimonial-inner uk-inline">
	                                <?php
                                    if($item['quote_title']){
                                        ?>
                                        <h3 class="templaza_quote_title">
                                            <?php echo esc_html($item['quote_title']); ?>
                                        </h3>
                                        <?php
                                    }
                                    if ($quote_icon && isset($quote_icon['value']) && !empty($quote_icon['value'])) {
                                        ?>
                                        <span class="quote-icon">
                                        <?php
                                        if (is_array($quote_icon['value']) && isset($quote_icon['value']['url']) && $quote_icon['value']['url']) {
                                            ?>
                                            <img src="<?php echo esc_attr($quote_icon['value']['url']);?>" alt="" data-uk-svg />
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

                                    if($testimonial_slider_author_position == 'before'){
                                        ?>
                                        <div class="uk-flex uk-flex-middle">
		                                    <?php if (isset( $image['url'] ) && $image['url'] ) : ?>
                                                <div class="ui-testimonial-avatar uk-width-auto">
                                                    <div class="uk-inline-clip<?php echo $avatar_border; ?>">
					                                    <?php echo \UIPro_Elementor_Helper::get_attachment_image_html( $item, 'author_image' ); ?>
                                                    </div>
                                                </div>
		                                    <?php endif; ?>
                                            <div class="">
			                                    <?php
			                                    if($item['author_rating']){
				                                    ?>
                                                    <div class="templaza_quote_author_rating">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                    </div>
				                                    <?php
			                                    }
			                                    if($item['quote_author']){
				                                    ?>
                                                    <div class="templaza_quote_author">
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
                                        <?Php
                                    }
                                    if($testimonial_slider_author_position == ''){
	                                    if($item['author_rating']){
		                                    ?>
                                            <div class="templaza_quote_author_rating">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
		                                    <?php
	                                    }
                                    }

	                                if($item['quote_content']){
		                                ?>
                                        <div class="templaza_quote_content">
			                                <?php echo esc_html($item['quote_content']); ?>
                                        </div>
		                                <?php
	                                }

						            if($testimonial_slider_author_position == ''){
	                                ?>

                                    <div class="uk-flex uk-flex-middle">
                                        <?php if (isset( $image['url'] ) && $image['url'] ) : ?>
                                            <div class="ui-testimonial-avatar uk-width-auto">
                                                <div class="uk-inline-clip<?php echo $avatar_border; ?>">
                                                    <?php echo \UIPro_Elementor_Helper::get_attachment_image_html( $item, 'author_image' ); ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="">
                                            <?php
                                            if($item['quote_author']){
                                                ?>
                                                <div class="templaza_quote_author">
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

						            if($testimonial_slider_author_position == 'top-center'){
	                                ?>

                                    <div class="ap-info-author-top-center">
                                        <?php
                                        if($item['author_rating']){
                                            ?>
                                            <div class="templaza_quote_author_rating">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <?php
                                        }
                                        if($item['quote_author']){
                                            ?>
                                            <div class="templaza_quote_author">
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
							            <?php
						            }
	                                ?>
                                    </div>
                                </div>
                            </div>
                        </li>
						<?php
					}
					?>
                </ul>
                <?php if($testimonials_visible ==''){ ?>
                </div>
                <?php } ?>
			<?php if($testimonial_slider_navigation=='yes'){?>
                <div class="uk-slidenav-container<?php echo $testimonial_slider_navigation_position; ?>">
                    <a class="<?php echo $testimonial_slider_navigation_position ? '' : esc_attr($preview) . ' uk-position-small';?>" href="#" data-uk-slidenav-previous data-uk-slider-item="previous"></a>
                    <a class="<?php echo $testimonial_slider_navigation_position ? '' : esc_attr($next) . ' uk-position-small';?>" href="#" data-uk-slidenav-next data-uk-slider-item="next"></a>
                </div>
				<?php
			}
			?>
        </div>
		<?php if($testimonial_slider_dot=='yes'){?>
            <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>
			<?php
		}
		?>
    </div>
</div>
<?php
}