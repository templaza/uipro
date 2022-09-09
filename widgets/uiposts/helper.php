<?php

defined('UIPRO') or exit();

class UIPro_UIPosts_Helper extends UIPro_Helper {
    public static function get_post_meta_type() {
        return apply_filters( 'templaza-elements-builder/uipost-meta-type',
            array(
                'date'      => esc_html__('Date', 'uipro'),
                'author'    => esc_html__('Author', 'uipro'),
                'category'  => esc_html__('Category', 'uipro'),
                'tags'      => esc_html__('Tags', 'uipro'),
            ));
    }
    public static function get_post_meta_content( $meta_type, $item, $instance, $args = array() ) {
        if (empty($meta_type) || !is_array($meta_type) || !count($meta_type)) {
            return array();
        }
        $icon_type       =   ( isset( $instance['meta_icon_type'] ) && $instance['meta_icon_type'] ) ? $instance['meta_icon_type'] : 'none';
        $date_icon       =   ( isset( $instance['date_icon'] ) && $instance['date_icon'] ) ? $instance['date_icon'] : array();
        $date_uikit_icon =   ( isset( $instance['date_uikit_icon'] ) && $instance['date_uikit_icon'] ) ? $instance['date_uikit_icon'] : '';
        $author_icon       =   ( isset( $instance['author_icon'] ) && $instance['author_icon'] ) ? $instance['author_icon'] : array();
        $author_uikit_icon =   ( isset( $instance['author_uikit_icon'] ) && $instance['author_uikit_icon'] ) ? $instance['author_uikit_icon'] : '';
        $category_icon       =   ( isset( $instance['category_icon'] ) && $instance['category_icon'] ) ? $instance['category_icon'] : array();
        $category_uikit_icon =   ( isset( $instance['category_uikit_icon'] ) && $instance['category_uikit_icon'] ) ? $instance['category_uikit_icon'] : '';
        $tag_icon       =   ( isset( $instance['tag_icon'] ) && $instance['tag_icon'] ) ? $instance['tag_icon'] : array();
        $tag_uikit_icon =   ( isset( $instance['tag_uikit_icon'] ) && $instance['tag_uikit_icon'] ) ? $instance['tag_uikit_icon'] : '';
        $meta_arr       =   array();
        $resource       = ( isset( $instance['resource'] ) && $instance['resource'] ) ? $instance['resource'] : 'post';

        if (in_array('date', $meta_type)) {
            $media ='';
            if ($icon_type == 'uikit' && $date_uikit_icon) {
                $media   .=  '<span class="uk-icon" data-uk-icon="icon: ' . $date_uikit_icon . '"></span>';
            } elseif ($date_icon && isset($date_icon['value'])) {
                if (is_array($date_icon['value']) && isset($date_icon['value']['url']) && $date_icon['value']['url']) {
                    $media   .=  '<img src="'.$date_icon['value']['url'].'" alt="" data-uk-svg />';
                } elseif (is_string($date_icon['value']) && $date_icon['value']) {
                    $media   .=  '<i class="' . $date_icon['value'] .'" aria-hidden="true"></i>';
                }
            }
            $meta_arr[] = '<span class="ui-post-meta-date">' .$media. get_the_date('', $item) . '</span>';
        }
        if (in_array('author', $meta_type)) {
            $media ='';
            if ($icon_type == 'uikit' && $author_uikit_icon) {
                $media   .=  '<span class="uk-icon" data-uk-icon="icon: ' . $author_uikit_icon . '"></span>';
            } elseif ($author_icon && isset($author_icon['value'])) {
                if (is_array($author_icon['value']) && isset($author_icon['value']['url']) && $author_icon['value']['url']) {
                    $media   .=  '<img src="'.$author_icon['value']['url'].'" alt="" data-uk-svg />';
                } elseif (is_string($author_icon['value']) && $author_icon['value']) {
                    $media   .=  '<i class="' . $author_icon['value'] .'" aria-hidden="true"></i>';
                }
            }
            $authordata = get_userdata( $item->post_author );
            $link = sprintf(
                '<a href="%1$s" title="%2$s" rel="author">%3$s</a>',
                esc_url( get_author_posts_url( $item->post_author ) ),
                /* translators: %s: Author's display name. */
                esc_attr( sprintf( __( 'Posts by %s' ), $authordata->display_name ) ),
                $authordata->display_name
            );
            $meta_arr[] = '<span class="ui-post-meta-author">' . $media . esc_html__('by', 'uipro') . ' ' . $link . '</span>';
        }
        if (in_array('category', $meta_type)) {
            $media ='';
            if ($icon_type == 'uikit' && $category_uikit_icon) {
                $media   .=  '<span class="uk-icon" data-uk-icon="icon: ' . $category_uikit_icon . '"></span>';
            } elseif ($category_icon && isset($category_icon['value'])) {
                if (is_array($category_icon['value']) && isset($category_icon['value']['url']) && $category_icon['value']['url']) {
                    $media   .=  '<img src="'.$category_icon['value']['url'].'" alt="" data-uk-svg />';
                } elseif (is_string($category_icon['value']) && $category_icon['value']) {
                    $media   .=  '<i class="' . $category_icon['value'] .'" aria-hidden="true"></i>';
                }
            }
            if ($resource == 'post') {
                $meta_arr[]     = '<span class="ui-post-meta-category">' .$media. get_the_category_list(', ', '', $item->ID) . '</span>';
            } elseif ( isset($args['cat_content']) && $args['cat_content'] ) {
                $meta_arr[]     .=  '<span class="ui-post-meta-category">' . $media .$args['cat_content'] . '</span>';
            }
        }
        if (in_array('tags', $meta_type)) {
            $media ='';
            if ($icon_type == 'uikit' && $tag_uikit_icon) {
                $media   .=  '<span class="uk-icon" data-uk-icon="icon: ' . $tag_uikit_icon . '"></span>';
            } elseif ($tag_icon && isset($tag_icon['value'])) {
                if (is_array($tag_icon['value']) && isset($tag_icon['value']['url']) && $tag_icon['value']['url']) {
                    $media   .=  '<img src="'.$tag_icon['value']['url'].'" alt="" data-uk-svg />';
                } elseif (is_string($tag_icon['value']) && $tag_icon['value']) {
                    $media   .=  '<i class="' . $tag_icon['value'] .'" aria-hidden="true"></i>';
                }
            }
            if ( isset($args['tag_content']) && $args['tag_content'] ) {
                $meta_arr[] = '<span class="ui-post-tags">'. $media.$args['tag_content'] .'</span>';
            }
        }
        return apply_filters( 'templaza-elements-builder/uipost-meta-content', $meta_arr, $item);
    }
    public static function get_post_except( $item ) {
        return apply_filters( 'templaza-elements-builder/uipost-post-except', $item->post_excerpt, $item);
    }
    public static function get_post_thumbnail( $item, $thumbnail_size, $attrs = '' ) {
        return apply_filters( 'templaza-elements-builder/uipost-post-thumbnail', wp_get_attachment_image(get_post_thumbnail_id( $item->ID ), $thumbnail_size, false, $attrs), $item);
    }
}