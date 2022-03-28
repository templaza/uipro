<?php

defined('UIPRO') or exit();

use Advanced_Product\Helper\FieldHelper;
use Advanced_Product\Helper\AP_Custom_Field_Helper;

class UIPro_UIAdvancedProducts_Helper extends UIPro_Helper {
    public static function get_post_meta_type() {
        return apply_filters( 'uipro/uiadvancedproducts-meta-type',
            array(
                'date'      => esc_html__('Date', 'uipro'),
                'author'    => esc_html__('Author', 'uipro'),
                'category'  => esc_html__('Category', 'uipro'),
                'tags'      => esc_html__('Tags', 'uipro'),
            ));
    }
    public static function get_custom_categories(){
        $args = array(
            'order'       => 'ASC',
            'orderby'     => 'ID',
            'post_status' => 'publish',
            'post_type'   => 'ap_custom_category'
        );

        $categories = get_posts( $args );
        return $categories;
    }
    public static function get_custom_fields($ids = array()){
        $args = array(
            'order'       => 'ASC',
            'orderby'     => 'ID',
            'post_status' => 'publish',
            'post_type'   => 'ap_custom_field',
            'numberposts' => -1
        );

        if(!empty($ids) && count($ids)){
            $args['include']    = $ids;
        }

        wp_reset_postdata();
        $fields = get_posts( $args );

        wp_reset_postdata();

        return $fields;
    }
//    public static function get_custom_field_by_ids($ids = array()){
//        if(empty($ids) || !count($ids)){
//            return false;
//        }
//
//        $args = array(
////            'order'       => 'ASC',
////            'orderby'     => 'ID',
//            'post_status' => 'publish',
//            'post_type'   => 'ap_custom_field',
//            'include'     => $ids
//        );
//
//        $fields = get_posts( $args );
//        return $fields;
//    }
    public static function get_custom_field_options(){

        $data   = array();
        $fields = self::get_custom_fields();

        if(empty($fields) || !count($fields)){
            return $data;
        }
        foreach ( $fields as $field ) {
            $f_attr             = FieldHelper::get_custom_field_option_by_id($field -> ID);
            $key    = $field -> ID;
            if(!empty($f_attr)) {
                $key = isset($f_attr['_name']) ? $f_attr['_name'] : (isset($f_attr['name'])?$f_attr['name']:$key);
            }
            $data[$key] = $field->post_title;
        }
        return $data;
    }
    public static function get_post_meta_content( $meta_type, $item, $instance, $args = array() ) {
        if (empty($meta_type) || !is_array($meta_type) || !count($meta_type)) {
            return array();
        }
        $meta_arr       =   array();
//        $resource       = ( isset( $instance['resource'] ) && $instance['resource'] ) ? $instance['resource'] : 'post';
        $resource       = 'ap_product';
        if (in_array('date', $meta_type)) {
            $meta_arr[] = '<span class="ui-post-meta-date">' . get_the_date('', $item) . '</span>';
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
            $meta_arr[] = '<span class="ui-post-meta-author">' . esc_html__('by', 'uipro') . ' ' . $link . '</span>';
        }
        if (in_array('category', $meta_type)) {
            if ($resource == 'post') {
                $meta_arr[]     = '<span class="ui-post-meta-category">' . get_the_category_list(', ', '', $item->ID) . '</span>';
            } elseif ( isset($args['cat_content']) && $args['cat_content'] ) {
                $meta_arr[]     .=  '<span class="ui-post-meta-category">' . $args['cat_content'] . '</span>';
            }
        }
        if (in_array('tags', $meta_type)) {
            if ( isset($args['tag_content']) && $args['tag_content'] ) {
                $meta_arr[] = '<span class="ui-post-tags">'. $args['tag_content'] .'</span>';
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