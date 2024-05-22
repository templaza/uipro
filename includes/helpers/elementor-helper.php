<?php

use Elementor\Control_Media;
use Elementor\Group_Control_Image_Size;
use Elementor\Plugin;

defined('UIPRO') or exit();

class UIPro_Elementor_Helper{
    public static function get_widget_template( $template_name, $args = array(), $template_path = '', $default_path = ''  ) {

        if ( is_array( $args ) && isset( $args ) ) {
            extract( $args );
        }

        if ( false === strpos( $template_name, '.php' ) ) {
            $template_name .= '.php';
        }
        $template_file = self::locate_template( $template_name, $template_path, $default_path );

//        var_dump($template_file); die();

        if ( ! file_exists( $template_file ) ) {
            _doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $template_file ), '1.0.0' );

            return;
        }

        include $template_file;
    }

    /**
     * @param        $template_name
     * @param string $template_path
     * @param string $default_path
     *
     * @return mixed
     */
    public static function locate_template( $template_name, $template_path = '', $default_path = '' ) {

        // Set default plugin templates path.
        if ( ! $default_path ) {
            $default_path = trailingslashit(UIPRO_WIDGETS_PATH ). $template_path; // Path to the template folder
        }

        $base = str_replace( '/tpl/', '', $template_path );

        // Get template file.
        $template = $default_path . $template_name;

        //check file overwritten file in child theme
        $child_template_path = trailingslashit(UIPRO_WIDGETS_PATH ). $base . "/" . $template_name;
        if ( file_exists( $child_template_path ) ) {
            $template = $child_template_path;
        }

        return apply_filters( 'uipro-elementor/locate-template', $template, $template_name, $template_path, $default_path );
    }

	/**
	 * Return General configuration
	 * @param array $instance
	 *
	 * @return array
	 */
	public static function get_general_styles($instance = array()) {
		//General Options
		$general      = '';
		$general     .= ( isset( $instance['uk_visibility'] ) && $instance['uk_visibility'] ) ? ' ' . $instance['uk_visibility'] : '';

		$flex_alignment          = ( isset( $instance['text_alignment'] ) && $instance['text_alignment'] ) ? ' uk-flex-' . $instance['text_alignment'] : '';
		$flex_breakpoint         = ( $flex_alignment ) ? ( ( isset( $instance['text_alignment_breakpoint'] ) && $instance['text_alignment_breakpoint'] ) ? '@' . $instance['text_alignment_breakpoint'] : '' ) : '';
		$flex_alignment_fallback = ( $flex_alignment && $flex_breakpoint ) ? ( ( isset( $instance['text_alignment_fallback'] ) && $instance['text_alignment_fallback'] ) ? ' uk-flex-' . $instance['text_alignment_fallback'] : '' ) : '';
		$flex_alignment          .=$flex_breakpoint. $flex_alignment_fallback;

		$text_alignment          = ( isset( $instance['text_alignment'] ) && $instance['text_alignment'] ) ? ' uk-text-' . $instance['text_alignment'] : '';
		$text_breakpoint         = ( $text_alignment ) ? ( ( isset( $instance['text_alignment_breakpoint'] ) && $instance['text_alignment_breakpoint'] ) ? '@' . $instance['text_alignment_breakpoint'] : '' ) : '';
		$text_alignment_fallback = ( $text_alignment && $text_breakpoint ) ? ( ( isset( $instance['text_alignment_fallback'] ) && $instance['text_alignment_fallback'] ) ? ' uk-text-' . $instance['text_alignment_fallback'] : '' ) : '';
		$text_alignment          .=$text_breakpoint. $text_alignment_fallback;

		$max_width_cfg              = ( isset( $instance['addon_max_width'] ) && $instance['addon_max_width'] ) ? ' uk-width-' . $instance['addon_max_width'] : '';
		$addon_max_width_breakpoint = ( $max_width_cfg ) ? ( ( isset( $instance['addon_max_width_breakpoint'] ) && $instance['addon_max_width_breakpoint'] ) ? '@' . $instance['addon_max_width_breakpoint'] : '' ) : '';

		$block_align            = ( isset( $instance['block_align'] ) && $instance['block_align'] ) ? $instance['block_align'] : '';
		$block_align_breakpoint = ( isset( $instance['block_align_breakpoint'] ) && $instance['block_align_breakpoint'] ) ? '@' . $instance['block_align_breakpoint'] : '';
		$block_align_fallback   = ( isset( $instance['block_align_fallback'] ) && $instance['block_align_fallback'] ) ? $instance['block_align_fallback'] : '';

		// Block Alignment CLS.
		$block_cls[] = '';

		if ( empty( $block_align ) ) {
			if ( ! empty( $block_align_breakpoint ) && ! empty( $block_align_fallback ) ) {
				$block_cls[] = ' uk-margin-auto-right' . $block_align_breakpoint;
				$block_cls[] = 'uk-margin-remove-left' . $block_align_breakpoint . ( $block_align_fallback == 'center' ? ' uk-margin-auto' : ' uk-margin-auto-left' );
			}
		}

		if ( $block_align == 'center' ) {
			$block_cls[] = ' uk-margin-auto' . $block_align_breakpoint;
			if ( ! empty( $block_align_breakpoint ) && ! empty( $block_align_fallback ) ) {
				$block_cls[] = 'uk-margin-auto' . ( $block_align_fallback == 'right' ? '-left' : '' );
			}
		}

		if ( $block_align == 'right' ) {
			$block_cls[] = ' uk-margin-auto-left' . $block_align_breakpoint;
			if ( ! empty( $block_align_breakpoint ) && ! empty( $block_align_fallback ) ) {
				$block_cls[] = $block_align_fallback == 'center' ? 'uk-margin-remove-right' . $block_align_breakpoint . ' uk-margin-auto' : 'uk-margin-auto-left';
			}
		}

		$block_cls = implode( ' ', array_filter( $block_cls ) );
		$max_width_cfg .= $addon_max_width_breakpoint . ( $max_width_cfg ? $block_cls : '' );

		$general .= $max_width_cfg;

		// Parallax Animation.
		$horizontal_start = ( isset( $instance['horizontal_start']['size'] ) && $instance['horizontal_start']['size'] ) ? $instance['horizontal_start']['size'] : '0';
		$horizontal_end   = ( isset( $instance['horizontal_end']['size'] ) && $instance['horizontal_end']['size'] ) ? $instance['horizontal_end']['size'] : '0';
		$horizontal       = ( ! empty( $horizontal_start ) || ! empty( $horizontal_end ) ) ? 'x: ' . $horizontal_start . ',' . $horizontal_end . ';' : '';

		$vertical_start = ( isset( $instance['vertical_start']['size'] ) && $instance['vertical_start']['size'] ) ? $instance['vertical_start']['size'] : '0';
		$vertical_end   = ( isset( $instance['vertical_end']['size'] ) && $instance['vertical_end']['size'] ) ? $instance['vertical_end']['size'] : '0';
		$vertical       = ( ! empty( $vertical_start ) || ! empty( $vertical_end ) ) ? 'y: ' . $vertical_start . ',' . $vertical_end . ';' : '';

		$scale_start = ( isset( $instance['scale_start']['size'] ) && $instance['scale_start']['size'] ) ? ( (int) $instance['scale_start']['size'] / 100 ) : 1;
		$scale_end   = ( isset( $instance['scale_end']['size'] ) && $instance['scale_end']['size'] ) ? ( (int) $instance['scale_end']['size'] / 100 ) : 1;
		$scale       = ( ! empty( $scale_start ) || ! empty( $scale_end ) ) ? 'scale: ' . $scale_start . ',' . $scale_end . ';' : '';

		$rotate_start = ( isset( $instance['rotate_start']['size'] ) && $instance['rotate_start']['size'] ) ? $instance['rotate_start']['size'] : '0';
		$rotate_end   = ( isset( $instance['rotate_end']['size'] ) && $instance['rotate_end']['size'] ) ? $instance['rotate_end']['size'] : '0';
		$rotate       = ( ! empty( $rotate_start ) || ! empty( $rotate_end ) ) ? 'rotate: ' . $rotate_start . ',' . $rotate_end . ';' : '';

		$opacity_start = ( isset( $instance['opacity_start']['size'] ) && $instance['opacity_start']['size'] ) ? ( (int) $instance['opacity_start']['size'] / 100 ) : 1;
		$opacity_end   = ( isset( $instance['opacity_end']['size'] ) && $instance['opacity_end']['size'] ) ? ( (int) $instance['opacity_end']['size'] / 100 ) : 1;
		$opacity       = ( ! empty( $opacity_start ) || ! empty( $opacity_end ) ) ? 'opacity: ' . $opacity_start . ',' . $opacity_end . ';' : '';

		$easing     = ( isset( $instance['easing']['size'] ) && $instance['easing']['size'] ) ? ( (int) $instance['easing']['size'] / 100 ) : '';
		$easing_cls = ( ! empty( $easing ) ) ? 'easing:' . $easing . ';' : '';

		$breakpoint     = ( isset( $instance['uk_breakpoint'] ) && $instance['uk_breakpoint'] ) ? $instance['uk_breakpoint'] : '';
		$breakpoint_cls = ( ! empty( $breakpoint ) ) ? 'media: @' . $breakpoint . ';' : '';

		$viewport     = ( isset( $instance['uk-viewport']['size'] ) && $instance['uk-viewport']['size'] ) ? ( (int) $instance['uk-viewport']['size'] / 100 ) : '';
		$viewport_cls = ( ! empty( $viewport ) ) ? 'viewport:' . $viewport . ';' : '';

		$parallax_target = ( isset( $instance['parallax_target'] ) && $instance['parallax_target'] ) ? $instance['parallax_target'] : false;
		$target_cls      = ( $parallax_target ) ? ' target: !.elementor-section;' : '';

		// Default Animation.
		$animation = ( isset( $instance['uk_animation'] ) && $instance['uk_animation'] ) ? $instance['uk_animation'] : '';

		$parallax_zindex = ( isset( $instance['parallax_zindex'] ) && $instance['parallax_zindex'] ) ? $instance['parallax_zindex'] : false;
		$zindex_cls      = ( $parallax_zindex && $animation == 'parallax' ) ? ' uk-position-z-index uk-position-relative' : '';

		$animation_repeat         = ( $animation ) ? ( ( isset( $instance['uk_animation_repeat'] ) && $instance['uk_animation_repeat'] ) ? ' repeat: true;' : '' ) : '';
		$delay_element_animations = ( isset( $instance['uk_delay_element_animations'] ) && $instance['uk_delay_element_animations'] ) ? $instance['uk_delay_element_animations'] : '';
		$scrollspy_cls            = ( $delay_element_animations ) ? ' uk-scrollspy-class' : '';
		$scrollspy_target         = ( $delay_element_animations ) ? 'target: .uk-scrollspy-class; ' : '';
		$animation_delay          = ( $delay_element_animations ) ? ' delay: 200;' : '';

		if ( $animation == 'parallax' ) {
			$animation = ' data-uk-parallax="' . $horizontal . $vertical . $scale . $rotate . $opacity . $easing_cls . $viewport_cls . $breakpoint_cls . $target_cls . '"';
		} elseif ( ! empty( $animation ) ) {
			$animation = ' data-uk-scrollspy="' . $scrollspy_target . 'cls: uk-animation-' . $animation . ';' . $animation_repeat . $animation_delay . '"';
		}

		return array('container_cls' => $general . $zindex_cls, 'content_cls' => $text_alignment . $flex_alignment . $scrollspy_cls, 'animation' => $animation);
	}

	/**
	 * Return attribs from URL Elementor Widget
	 * @param array $link
	 *
	 * @return string
	 */
	public static function get_link_attribs ($link = array()) {
		$attribs    =   isset($link['is_external']) && $link['is_external'] ? ' target="_blank"' : '';
		$attribs    .=  isset($link['nofollow']) && $link['nofollow'] ? ' rel="nofollow"' : '';
		if (isset($link['custom_attributes']) && $link['custom_attributes']) {
			$custom_attrs   =   explode(',', $link['custom_attributes']);
			foreach ($custom_attrs as $custom_attr) {
				list($key,$value) = explode('|', $custom_attr);
				if ($key && $value) {
					$attribs    .=  ' '.$key.'="'.$value.'"';
				}
			}
		}
		return $attribs;
	}

	/**
	 * Get attachment image HTML.
	 *
	 * Retrieve the attachment image HTML code.
	 *
	 * Note that some widgets use the same key for the media control that allows
	 * the image selection and for the image size control that allows the user
	 * to select the image size, in this case the third parameter should be null
	 * or the same as the second parameter. But when the widget uses different
	 * keys for the media control and the image size control, when calling this
	 * method you should pass the keys.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @param array  $settings       Control settings.
	 * @param string $image_size_key Optional. Settings key for image size.
	 *                               Default is `image`.
	 * @param string $image_key      Optional. Settings key for image. Default
	 *                               is null. If not defined uses image size key
	 *                               as the image key.
	 *
	 * @return string Image HTML.
	 */
	public static function get_attachment_image_html( $settings, $image_size_key = 'image', $image_key = null, $image_class = '' ) {
		if ( ! $image_key ) {
			$image_key = $image_size_key;
		}

		$image = $settings[ $image_key ];

		// Old version of image settings.
		if ( ! isset( $settings[ $image_size_key . '_size' ] ) ) {
			$settings[ $image_size_key . '_size' ] = '';
		}

		$size = $settings[ $image_size_key . '_size' ];

		$image_class        .=  ! empty( $settings['hover_animation'] ) ? ' elementor-animation-' . $settings['hover_animation'] : '';
		$image_class        .=  isset($settings['image_border']) && $settings['image_border'] ? ' '. $settings['image_border'] : '';
		$image_class        .=  isset($settings['box_shadow']) && $settings['box_shadow'] ? ' '. $settings['box_shadow'] : '';
		$image_class        .=  isset($settings['hover_box_shadow']) && $settings['hover_box_shadow'] ? ' '. $settings['hover_box_shadow'] : '';
		$image_transition   = ( isset( $settings['image_transition'] ) && $settings['image_transition'] ) ? ' uk-transition-' . $settings['image_transition'] . ' uk-transition-opaque' : '';
		$image_panel        =   isset($settings['image_panel']) ? intval($settings['image_panel']) : 0;
        $ripple_effect      = (isset($settings['image_transition']) && $settings['image_transition']) ? ($settings['image_transition']) : '';
		$media_background   = ( $image_panel ) ? ( ( isset( $settings['blend_bg_color'] ) && $settings['blend_bg_color'] ) ? $settings['blend_bg_color'] : '' ) : '';
		$image_class        .= ( $image_panel && $media_background ) ? ( ( isset( $settings['image_blend_modes'] ) && $settings['image_blend_modes'] ) ? ' ' . $settings['image_blend_modes'] : '' ) : '';
		$image_class        .=  $image_transition;
		$html = '';
        if($ripple_effect =='ripple'){
            $ripple_html = '<div class="templaza-ripple-circles uk-position-center uk-transition-fade">
                        <div class="circle1"></div>
                        <div class="circle2"></div>
                        <div class="circle3"></div>
                    </div>';
            $ripple_cl = ' templaza-thumb-ripple ';
        }
		// If is the new version - with image size.
		$image_sizes = get_intermediate_image_sizes();
		$image_sizes[] = 'full';

		if ( ! empty( $image['id'] ) && ! wp_attachment_is_image( $image['id'] ) ) {
			$image['id'] = '';
		}

		$is_static_render_mode = Plugin::$instance->frontend->is_static_render_mode();

		// On static mode don't use WP responsive images.
		if ( ! empty( $image['id'] ) && in_array( $size, $image_sizes ) && ! $is_static_render_mode ) {
			$image_class .= " attachment-$size size-$size";
			$image_attr = [
				'class' => trim( $image_class ),
			];
            if(isset($settings['link_type']) && $settings['link_type'] == 'use_link'){
                $html .='<a href='.$settings['link']['url'].'>';
            }
            if(isset($settings['link_type']) && $settings['link_type'] == 'use_modal'){
                $html .='<a href="'. esc_url($image['url']) .'" data-elementor-open-lightbox="yes" >';
            }
			$html .= wp_get_attachment_image( $image['id'], $size, false, $image_attr );
            $html .= $ripple_html;
            if(isset($settings['link_type']) && $settings['link_type'] == 'use_modal'){
                $html .='</a>';
            }
            if(isset($settings['link_type']) && $settings['link_type'] == 'use_link'){
                $html .='</a>';
            }
		} else {
			$image_src = Group_Control_Image_Size::get_attachment_image_src( $image['id'], $image_size_key, $settings );
			$size      = $settings[ $image_size_key . '_size' ];
			$attribs   = '';
			if ($size == 'custom') {
				$custom_dimension = $settings[ $image_size_key . '_custom_dimension' ];
				$attribs    .=  ! empty( $custom_dimension['width']) ? ' data-width="'.$custom_dimension['width'].'"' : '';
				$attribs    .=  ! empty( $custom_dimension['height']) ? ' data-height="'.$custom_dimension['height'].'"' : '';
			}


			if ( ! $image_src && isset( $image['url'] ) ) {
				$image_src = $image['url'];
			}

			if ( ! empty( $image_src ) ) {
				$image_class_html = ! empty( $image_class ) ? ' class="' . $image_class . '"' : '';

				$html .= sprintf( '<img src="%s" data-src="%s"'.$attribs.' title="%s" alt="%s"%s data-uk-img />', esc_attr( $image_src ), esc_attr( $image_src ), Control_Media::get_image_title( $image ), Control_Media::get_image_alt( $image ), $image_class_html );
			}
		}

		if ($media_background || $image_transition) {
			$html   =   '<div class="ui-blend uk-inline'.($image_transition ? ' uk-transition-toggle' : '').'">'. $html . '</div>';
		}

		/**
		 * Get Attachment Image HTML
		 *
		 * Filters the Attachment Image HTML
		 *
		 * @since 2.4.0
		 * @param string $html the attachment image HTML string
		 * @param array  $settings       Control settings.
		 * @param string $image_size_key Optional. Settings key for image size.
		 *                               Default is `image`.
		 * @param string $image_key      Optional. Settings key for image. Default
		 *                               is null. If not defined uses image size key
		 *                               as the image key.
		 */
		return apply_filters( 'uipro-elementor/get_attachment_image_html', $html, $settings, $image_size_key, $image_key );
	}
}