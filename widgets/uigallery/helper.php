<?php

defined('UIPRO') or exit();

class UIPro_UIGallery_Helper extends UIPro_Helper {
    public static function get_post_meta_type() {
        return apply_filters( 'templaza-elements-builder/uigallery-meta-type',
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
        $meta_arr       =   array();
        $resource       = ( isset( $instance['resource'] ) && $instance['resource'] ) ? $instance['resource'] : 'post';
        if (in_array('date', $meta_type)) {
            $meta_arr[] = '<span class="ui-gallery-meta-date">' . get_the_date('', $item) . '</span>';
        }
        if (in_array('author', $meta_type)) {
            $authordata = get_userdata( $item->post_author );
            $link = sprintf(
                '<a href="%1$s" title="%2$s" rel="author">%3$s</a>',
                esc_url( get_author_posts_url( $item->post_author ) ),
                /* translators: %s: Author's display name. */
                esc_attr( sprintf( __( 'Posts by %s' ), $authordata->display_name ) ),
                $authordata->display_name
            );
            $meta_arr[] = '<span class="ui-gallery-meta-author">' . esc_html__('by', 'uipro') . ' ' . $link . '</span>';
        }
        if (in_array('category', $meta_type)) {
            if ($resource == 'post') {
                $meta_arr[]     = '<span class="ui-gallery-meta-category">' . get_the_category_list(', ', '', $item->ID) . '</span>';
            } elseif ( isset($args['cat_content']) && $args['cat_content'] ) {
                $meta_arr[]     .=  '<span class="ui-gallery-meta-category">' . $args['cat_content'] . '</span>';
            }
        }
        if (in_array('tags', $meta_type)) {
            if ( isset($args['tag_content']) && $args['tag_content'] ) {
                $meta_arr[] = '<span class="ui-gallery-tags">'. $args['tag_content'] .'</span>';
            }
        }
        return apply_filters( 'templaza-elements-builder/uigallery-meta-content', $meta_arr, $item);
    }
    public static function get_post_except( $item ) {
        return apply_filters( 'templaza-elements-builder/uigallery-post-except', $item->post_excerpt, $item);
    }
    public static function get_post_thumbnail( $item, $thumbnail_size ) {
        return apply_filters( 'templaza-elements-builder/uigallery-post-thumbnail', wp_get_attachment_image(get_post_thumbnail_id( $item->ID ), $thumbnail_size), $item);
    }
}