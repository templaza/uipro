<?php

namespace UIPro\Elementor\Control\Helper;

use UIPro\UIPro_Functions;

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit;

if(!class_exists('UIPro\Elementor\Control\Helper\UIAutoComplete_Helper')) {
    class UIAutoComplete_Helper
    {
        /**
         * Post type Autocomplete
         *
         * @since 1.0.0
         *
         * @return array
         */
        public static function post_type_callback( $post_type = 'post', $query = '' ) {
//            $query  = $_POST && isset( $_POST['term'] ) ? trim( $_POST['term'] ) : '';
            $result = array();

            $args = array(
                'post_type'              => $post_type,
                'posts_per_page'         => - 1,
                'no_found_rows'          => true,
                'update_post_term_cache' => false,
                'update_post_meta_cache' => false,
                'ignore_sticky_posts'    => true,
                's'                      => $query
            );

            $posts = get_posts( $args );

            if ( is_array( $posts ) && ! empty( $posts ) ) {
                foreach ( $posts as $post ) {
                    $data          = array();
                    $data['value'] = $post->ID;
                    $data['label'] = esc_html__( 'Id', 'uipro' ) . ': ' . $post->ID . ' - ' . esc_html__( 'Title', 'razzi' ) . ': ' . $post->post_title;
                    $result[]      = $data;
                }
            } else {
                $result[] = array(
                    'value' => 'nothing-found',
                    'label' => esc_html__( 'Nothing Found', 'uipro' )
                );
            }

            return $result;
        }

        /**
         * Taxonomy Autocomplete
         *
         * @since 1.0.0
         *
         * @return array
         */
        public static function taxonomy_callback( $taxonomy = 'category', $query = '' ) {
//            $cat_id = $_POST && isset( $_POST['term'] ) ? $_POST['term'] : 0;
//            $query  = $_POST && isset( $_POST['term'] ) ? trim( $_POST['term'] ) : '';

            $cat_id = !empty($query)?$query : 0;

            $result = array();

            global $wpdb;

            $post_meta_infos = $wpdb->get_results(
                $wpdb->prepare(
                    "SELECT a.term_id AS id, b.name as name, b.slug AS slug
						FROM {$wpdb->term_taxonomy} AS a
						INNER JOIN {$wpdb->terms} AS b ON b.term_id = a.term_id
						WHERE a.taxonomy = %s AND (a.term_id = '%d' OR b.slug LIKE '%%%s%%' OR b.name LIKE '%%%s%%' )", $taxonomy, $cat_id > 0 ? $cat_id : - 1, stripslashes( $query ), stripslashes( $query )
                ), ARRAY_A
            );


            if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
                foreach ( $post_meta_infos as $value ) {
                    $data          = array();
                    $data['value'] = $value['slug'];
                    $data['label'] = esc_html__( 'Id', 'razzi' ) . ': ' . $value['id'] . ' - ' . esc_html__( 'Name', 'razzi' ) . ': ' . $value['name'];
                    $result[]      = $data;
                }
            } else {
                $result[] = array(
                    'value' => 'nothing-found',
                    'label' => esc_html__( 'Nothing Found', 'razzi' )
                );
            }

            return $result;
        }

        /**
         * Get
         * */
        public static function taxonomy_render($taxonomy, $query = ''){
//            $query = $_POST && isset( $_POST['term'] ) ? $_POST['term'] : '';

            if ( empty( $query ) ) {
                return false;
            }

            $data   = array();
            $values = explode( ',', $query );

            $terms = get_terms(
                array(
                    'taxonomy' => $taxonomy,
                    'slug'     => $values,
                    'orderby'  => 'slug__in'
                )
            );

            if ( is_wp_error( $terms ) || ! $terms ) {
                return false;
            }

            foreach ( $terms as $term ) {

                $data[] = sprintf(
                    '<li class="ui_autocomplete-label" data-value="%s">
					<span class="ui_autocomplete-data">%s%s - %s%s</span>
					<a href="#" class="ui_autocomplete-remove">&times;</a>
				</li>',
                    esc_attr( $term->slug ),
                    esc_html__( 'Id: ', 'uipro' ),
                    esc_html( $term->term_id ),
                    esc_html__( 'Name: ', 'uipro' ),
                    esc_html( $term->name )
                );
            }

            return $data;

        }
        public static function post_type_render($post_type, $query = ''){

//            $query = $_POST && isset( $_POST['term'] ) ? $_POST['term'] : '';

            if ( empty( $query ) ) {
                return false;
            }

            $values = explode( ',', $query );

            $data = [];

            $args = [
                'post_type'              => $post_type,
                'no_found_rows'          => true,
                'update_post_term_cache' => false,
                'update_post_meta_cache' => false,
                'ignore_sticky_posts'    => true,
                'post__in'               => $values,
                'orderby'                => 'post__in'
            ];

            $query = new \WP_Query( $args );
            while ( $query->have_posts() ) : $query->the_post();
                $data[] = sprintf(
                    '<li class="ui_autocomplete-label" data-value="%s">
					<span class="ui_autocomplete-data">%s%s - %s%s</span>
					<a href="#" class="ui_autocomplete-remove">&times;</a>
				</li>',
                    esc_attr( get_the_ID() ),
                    esc_html__( 'Id: ', 'uipro' ),
                    esc_html( get_the_ID() ),
                    esc_html__( 'Title: ', 'uipro' ),
                    esc_html( get_the_title() )
                );
            endwhile;
            wp_reset_postdata();

            return $data;
        }
    }
}