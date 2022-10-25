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
                'comment_count'      => esc_html__('Comment count', 'uipro'),
                'post_view'      => esc_html__('Post view', 'uipro'),
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
        $author_show_avatar  =   ( isset( $instance['meta_author_avatar'] ) && $instance['meta_author_avatar'] ) ? $instance['meta_author_avatar'] : '';
        $category_icon       =   ( isset( $instance['category_icon'] ) && $instance['category_icon'] ) ? $instance['category_icon'] : array();
        $category_uikit_icon =   ( isset( $instance['category_uikit_icon'] ) && $instance['category_uikit_icon'] ) ? $instance['category_uikit_icon'] : '';
        $tag_icon       =   ( isset( $instance['tag_icon'] ) && $instance['tag_icon'] ) ? $instance['tag_icon'] : array();
        $tag_uikit_icon =   ( isset( $instance['tag_uikit_icon'] ) && $instance['tag_uikit_icon'] ) ? $instance['tag_uikit_icon'] : '';
        $comment_icon       =   ( isset( $instance['comment_icon'] ) && $instance['comment_icon'] ) ? $instance['comment_icon'] : array();
        $comment_uikit_icon =   ( isset( $instance['comment_uikit_icon'] ) && $instance['comment_uikit_icon'] ) ? $instance['comment_uikit_icon'] : '';
        $view_icon       =   ( isset( $instance['view_icon'] ) && $instance['view_icon'] ) ? $instance['view_icon'] : array();
        $view_uikit_icon =   ( isset( $instance['view_uikit_icon'] ) && $instance['view_uikit_icon'] ) ? $instance['view_uikit_icon'] : '';
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
            if($author_show_avatar =='1'){
                $author_avatar = '<a class="ui-author-avatar" href="'. esc_url(get_author_posts_url(get_the_author_meta('ID'))).'">
                <img src="'.esc_url( get_avatar_url( get_the_author_meta('ID'),100) ) .'" alt=""/>
            </a>';
            }else{
                $author_avatar = '';
            }

            $authordata = get_userdata( $item->post_author );
            $link = sprintf(
                '<a href="%1$s" title="%2$s" rel="author">%3$s</a>',
                esc_url( get_author_posts_url( $item->post_author ) ),
                /* translators: %s: Author's display name. */
                esc_attr( sprintf( __( 'Posts by %s' ), $authordata->display_name ) ),
                $authordata->display_name
            );
            $meta_arr[] = '<span class="ui-post-meta-author">' .$author_avatar . $media . esc_html__('by', 'uipro') . ' ' . $link . '</span>';
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
        if (in_array('comment_count', $meta_type)) {
            $media ='';
            if ($icon_type == 'uikit' && $comment_uikit_icon) {
                $media   .=  '<span class="uk-icon" data-uk-icon="icon: ' . $comment_uikit_icon . '"></span>';
            } elseif ($comment_icon && isset($comment_icon['value'])) {
                if (is_array($comment_icon['value']) && isset($comment_icon['value']['url']) && $comment_icon['value']['url']) {
                    $media   .=  '<img src="'.$comment_icon['value']['url'].'" alt="" data-uk-svg />';
                } elseif (is_string($comment_icon['value']) && $comment_icon['value']) {
                    $media   .=  '<i class="' . $comment_icon['value'] .'" aria-hidden="true"></i>';
                }
            }
            $templaza_comment_count = wp_count_comments($item->ID);
            if ($templaza_comment_count->approved == 1) {
                $comment_html= '<span>'.esc_html__('Comment:','uipro').'</span> '.esc_html($templaza_comment_count->approved);
            }else{
                $comment_html= '<span>'.esc_html__('Comments:','uipro').'</span> '.esc_html($templaza_comment_count->approved);
            }
                $meta_arr[] = '<span class="ui-post-comment-count">'. $media.$comment_html .'</span>';
        }
        if (in_array('post_view', $meta_type)) {
            $media ='';
            if ($icon_type == 'uikit' && $view_uikit_icon) {
                $media   .=  '<span class="uk-icon" data-uk-icon="icon: ' . $view_uikit_icon . '"></span>';
            } elseif ($view_icon && isset($view_icon['value'])) {
                if (is_array($view_icon['value']) && isset($view_icon['value']['url']) && $view_icon['value']['url']) {
                    $media   .=  '<img src="'.$view_icon['value']['url'].'" alt="" data-uk-svg />';
                } elseif (is_string($view_icon['value']) && $view_icon['value']) {
                    $media   .=  '<i class="' . $view_icon['value'] .'" aria-hidden="true"></i>';
                }
            }
            $count = get_post_meta($item->ID, 'post_views_count', true);
            if ($count == '' || empty($count)) { // If such views are not
                $view_html = '<span>'.esc_html__('View:','uipro').'</span> '.esc_html__('0','uipro').''; // return value of 0
            }else{
                $view_html = '<span>'.esc_html__('Views:','uipro').'</span> '.$count;
            }
                $meta_arr[] = '<span class="ui-post-views">'. $media.$view_html .'</span>';
        }
        return apply_filters( 'templaza-elements-builder/uipost-meta-content', $meta_arr, $item);
    }
    public static function get_post_except( $item,$instance ) {
        $intro_number       =   ( isset( $instance['introtext_number'] ) && $instance['introtext_number'] ) ? $instance['introtext_number'] : '';
        if(isset($intro_number) && $intro_number !=''){
         $intro_text = wp_trim_words($item->post_excerpt,$intro_number);
        return apply_filters( 'templaza-elements-builder/uipost-post-except',$intro_text, $item);
        }else{
            return apply_filters( 'templaza-elements-builder/uipost-post-except', $item->post_excerpt, $item);
        }
    }
    public static function get_post_thumbnail( $item, $thumbnail_size, $attrs = '' ) {
        return apply_filters( 'templaza-elements-builder/uipost-post-thumbnail', wp_get_attachment_image(get_post_thumbnail_id( $item->ID ), $thumbnail_size, false, $attrs), $item);
    }
}