<?php
/**
 * Elementor Helper init
 * @package Templaza
 */

namespace TemPlaza_Woo_El;
use Elementor\Group_Control_Image_Size;
use TemPlazaFramework\Functions;
use TemPlaza_Woo\Templaza_Woo_Helper;
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class TemPlaza_Woo_El_Helper {

	/**
	 * Instance
	 *
	 * @var $instance
	 */
	private static $instance;

	/**
	 * Initiator
	 *
	 * @since 1.0.0
	 * @return object
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Render link control output
	 *
	 * @since 1.0.0
	 *
	 * @param       $link_key
	 * @param       $url
	 * @param       $content
	 * @param array $attr
	 *
	 * @return string
	 */
	public static function control_url( $link_key, $url, $content, $attr = [] ) {
		$attr_default = [];
		if ( isset( $url['url'] ) && $url['url'] ) {
			$attr_default['href'] = $url['url'];
		}

		if ( isset( $url['is_external'] ) && $url['is_external'] ) {
			$attr_default['target'] = '_blank';
		}

		if ( isset( $url['nofollow'] ) && $url['nofollow'] ) {
			$attr_default['rel'] = 'nofollow';
		}

		$attr = wp_parse_args( $attr, $attr_default );

		$tag = 'a';

		if ( empty( $attr['href'] ) ) {
			$tag = 'span';
		}

		$attributes = [];

		foreach ( $attr as $name => $v ) {
			$attributes[] = $name . '="' . esc_attr( $v ) . '"';
		}

		return sprintf( '<%1$s %2$s>%3$s</%1$s>', $tag, implode( ' ', $attributes ), $content );
	}

	/**
	 * Retrieve the list of taxonomy
	 *
	 * @since 1.0.0
	 *
	 * @return array Widget categories.
	 */
	public static function taxonomy_list( $taxonomy = 'product_cat' ) {
		$output = array();
		$categories = get_categories(
			array(
				'taxonomy' => $taxonomy,
			)
		);

		foreach ( $categories as $category ) {
			$output[ $category->slug ] = $category->name;
		}

		return $output;
	}

	/**
	 * Retrieve the list of taxonomy
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function get_product_sub_categories_list( $settings, $term_id ) {
		$args = array(
			'taxonomy' => 'product_cat',
			'child_of' => $term_id,
			'orderby'  => $settings['orderby'],
			'order'    => $settings['order']
		);

		$termchildren = get_terms( $args );

		$class_empty = '';
		if ( $termchildren == array() ) {
			$class_empty = 'category-empty';
		}

		$cat_child   = [];
		$cat_child[] = '<ul class="category-list swiper-wrapper ' . $class_empty . '">';
		$count_item  = 0;
		foreach ( $termchildren as $child ) {
			$term = get_term_by( 'id', $child->term_id, 'product_cat' );

			$thumbnail_id = absint( get_term_meta( $term->term_id, 'thumbnail_id', true ) );

			$settings['image']['url'] = wp_get_attachment_image_src( $thumbnail_id );
			$settings['image']['id']  = $thumbnail_id;
			$image                    = Group_Control_Image_Size::get_attachment_image_html( $settings );

			$add_class = $thumbnail_html = $count = '';
			if ( $thumbnail_id ) {
				$thumbnail_html = sprintf( '<a class="cat-thumb image-zoom" href="%s">%s</a>', esc_url( get_term_link( $term->term_id, 'product_cat' ) ), $image );
				$add_class      = 'has-thumbnail';
			}

			if ( $settings['cats_count'] == 'yes' ) {
				$count = '<span class="cat-count">';
				$count .= sprintf( _n( '(%s)', '(%s)', $term->count, 'uipro' ), number_format_i18n( $term->count ) );
				$count .= '</span>';
			}

			$cat_child[] = sprintf(
				'<li class="cat-item %s">
								%s
								<a class="cat-name" href="%s">%s%s</a>
							</li>',
				esc_attr( $add_class ),
				$thumbnail_html,
				esc_url( get_term_link( $term->term_id, 'product_cat' ) ),
				$term->name,
				$count
			);
			$count_item ++;
		}
		$cat_child[] = '</ul>';

		return implode( '', $cat_child );
	}

	/**
	 * Product shortcode
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function get_products( $atts ) {
		$params   = '';
		$order    = $atts['order'];
		$order_by = $atts['orderby'];
		if ( $atts['products'] == 'featured' ) {
			$params = 'visibility="featured"';
		} elseif ( $atts['products'] == 'best_selling' ) {
			$params = 'best_selling="true"';
		} elseif ( $atts['products'] == 'sale' ) {
			$params = 'on_sale="true"';
		} elseif ( $atts['products'] == 'recent' ) {
			$order    = $order ? $order : 'desc';
			$order_by = $order_by ? $order_by : 'date';
		} elseif ( $atts['products'] == 'top_rated' ) {
			$params = 'top_rated="true"';
		}

		if ( ! empty( $atts['ids'] ) ) {
			$params   .= ' ids="' . $atts['ids'] . '" ';
			$order_by = 'post__in';
		}

		$params .= ' columns="' . intval( $atts['columns'] ) . '" limit="' . intval( $atts['per_page'] ) . '" order="' . $order . '" orderby ="' . $order_by . '"';

		if ( ! empty( $atts['product_cats'] ) ) {
			$cats = $atts['product_cats'];
			if ( is_array( $cats ) ) {
				$cats = implode( ',', $cats );
			}

			$params .= ' category="' . $cats . '" ';
		}

		if ( ! empty( $atts['product_tags'] ) ) {
			$params .= ' tag="' . $atts['product_tags'] . '" ';
		}

		if ( isset( $atts['product_brands'] ) && ! empty( $atts['product_brands'] ) ) {
			$params .= ' class="sc_brand,' . $atts['product_brands'] . '" ';
		}

		return do_shortcode( '[products ' . $params . ']' );
	}

	/**
	 * Get products loop content for shortcode.
	 *
	 * @since 1.0.0
	 *
	 * @param array $atts Shortcode attributes
	 *
	 * @return array
	 */
	public static function products_shortcode( $atts ) {
		if ( ! class_exists( 'WC_Shortcode_Products' ) ) {
			return;
		}

		$type = $atts['product_source'];

		if ( $type == 'custom' ) {

			$results = array(
				'ids'          => $atts['product_ids'],
				'total'        => 0,
				'total_pages'  => 0,
				'current_page' => 0
			);

			return $results;
		}
        if ( isset( $atts['product_brands'] ) && ! empty( $atts['product_brands'] ) ) {
            $atts['class'] = 'all_brand,' . $atts['product_brands'];
        }
		$shortcode  = new \WC_Shortcode_Products( $atts, $type );
		$query_args = $shortcode->get_query_args();

		
		if ( $type && ! in_array( $type, array( 'day', 'week', 'month', 'deals' ) ) ) {
			self::{"set_{$type}_products_query_args"}( $query_args );
		}

		if ( in_array( $type, array( 'day', 'week', 'month' ) ) ) {
			$date = '+1 day';
			if ( $type == 'week' ) {
				$date = '+7 day';
			} else if ( $type == 'month' ) {
				$date = '+1 month';
			}
			$query_args['meta_query'] = apply_filters(
				'templaza_product_deals_meta_query', array_merge(
					WC()->query->get_meta_query(), array(
						array(
							'key'     => '_deal_quantity',
							'value'   => 0,
							'compare' => '>',
						),
						array(
							'key'     => '_sale_price_dates_to',
							'value'   => 0,
							'compare' => '>',
						),
						array(
							'key'     => '_sale_price_dates_to',
							'value'   => strtotime( $date ),
							'compare' => '<=',
						),
					)
				)
			);
		} elseif ( $type == 'deals' ) {
			$query_args['meta_query'] = apply_filters(
				'templaza_product_deals_meta_query', array_merge(
					WC()->query->get_meta_query(), array(
						array(
							'key'     => '_deal_quantity',
							'value'   => 0,
							'compare' => '>',
						)
					)
				)
			);
		}

		if ( isset( $atts['page'] ) ) {
			$query_args['paged'] = isset( $atts['page'] ) ? absint( $atts['page'] ) : 1;
		}
		return self::get_query_results( $query_args, $type );
	}

	/**
	 * Run the query and return an array of data, including queried ids.
	 *
	 * @since 1.0.0
	 *
	 * @return array with the following props; ids
	 */
	public static function get_query_results( $query_args, $type ) {
		$transient_name    = self::get_transient_name( $query_args, $type );
		$transient_version = \WC_Cache_Helper::get_transient_version( 'product_query' );
		$transient_value   = get_transient( $transient_name );

		if ( isset( $transient_value['value'], $transient_value['version'] ) && $transient_value['version'] === $transient_version ) {
			$results = $transient_value['value'];
		} else {

			$query = new \WP_Query( $query_args );

			$paginated = ! $query->get( 'no_found_rows' );

			$results = array(
				'ids'          => wp_parse_id_list( $query->posts ),
				'total'        => $paginated ? (int) $query->found_posts : count( $query->posts ),
				'total_pages'  => $paginated ? (int) $query->max_num_pages : 1,
				'current_page' => $paginated ? (int) max( 1, $query->get( 'paged', 1 ) ) : 1,
			);
			wp_reset_postdata();

			$transient_value = array(
				'version' => $transient_version,
				'value'   => $results,
			);
			set_transient( $transient_name, $transient_value, DAY_IN_SECONDS * 30 );
		}

		// Remove ordering query arguments which may have been added by get_catalog_ordering_args.
		WC()->query->remove_ordering_args();

		return $results;
	}

	/**
	 * Generate and return the transient name for this shortcode based on the query args.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function get_transient_name( $query_args, $type ) {
		$transient_name = 'templaza_product_loop_' . md5( wp_json_encode( $query_args ) . $type );

		if ( 'rand' === $query_args['orderby'] ) {
			// When using rand, we'll cache a number of random queries and pull those to avoid querying rand on each page load.
			$rand_index     = wp_rand( 0, max( 1, absint( apply_filters( 'woocommerce_product_query_max_rand_cache_count', 5 ) ) ) );
			$transient_name .= $rand_index;
		}

		return $transient_name;
	}

	/**
	 * Loop over products
	 *
	 * @since 1.0.0
	 *
	 * @param string
	 */
	public static function get_template_loop( $products_ids, $template = 'product' ) {
		update_meta_cache( 'post', $products_ids );
		update_object_term_cache( $products_ids, 'product' );

		$original_post = $GLOBALS['post'];
        if ( !class_exists( 'TemPlazaFramework\TemPlazaFramework' )){
            $templaza_options = array();
        }else{
            $templaza_options = Functions::get_theme_options();
        }

        $classes = array(
            'products'
        );
        if (wc_get_loop_prop('product_loop')) {
            $loop_layout = wc_get_loop_prop('product_loop');
        }else{
            $loop_layout = isset($templaza_options['templaza-shop-loop-layout'])?$templaza_options['templaza-shop-loop-layout']:'layout-1';
        }
        $class_layout = $loop_layout == 'layout-3' ? 'layout-2' : $loop_layout;

        $classes[] = 'product-loop-' . $class_layout;

        if ( $loop_layout == 'layout-3' ) {
            $classes[] = 'product-loop-layout-3';
        }

        $classes[] = $loop_layout == 'layout-3' ? 'has-quick-view' : '';

        $classes[] = in_array( $loop_layout, array( 'layout-2', 'layout-3', 'layout-4', 'layout-5', 'layout-6', 'layout-7' ) ) ? 'product-loop-center' : '';

        if ( in_array( $loop_layout, array( 'layout-2', 'layout-3', 'layout-9' ) ) ) {
            $loop_wishlist           = isset($templaza_options['templaza-shop-loop-wishlist'])?filter_var($templaza_options['templaza-shop-loop-wishlist'], FILTER_VALIDATE_BOOLEAN):true;
            if($loop_wishlist){
                $classes[] = 'show-wishlist';
            }else{
                $classes[] = ' ';
            }
        }

        if ( in_array( $loop_layout, array( 'layout-8', 'layout-9' ) ) ) {
            $loop_variation           = isset($templaza_options['templaza-shop-loop-variation'])?filter_var($templaza_options['templaza-shop-loop-variation'], FILTER_VALIDATE_BOOLEAN):true;
            if($loop_variation){
                $classes[] = 'has-variations-form';
            }else{
                $classes[] = ' ';
            }
        }
        $shop_col_tablet       = isset($templaza_options['templaza-shop-column-tablet'])?$templaza_options['templaza-shop-column-tablet']:2;
        $shop_col_mobile       = isset($templaza_options['templaza-shop-column-mobile'])?$templaza_options['templaza-shop-column-mobile']:1;
        $shop_col_gap          = isset($templaza_options['templaza-shop-column-gap'])?$templaza_options['templaza-shop-column-gap']:'';
        if(is_product()) {
            $product_columns = $product_columns_large =$product_columns_laptop =4;
            $product_columns_tablet = 2;
            $product_columns_mobile = 1;
            $product_gap = '';
        }else{

            if (wc_get_loop_prop('columns')) {
                $product_columns = wc_get_loop_prop('columns');
            } else {
                $product_columns = isset($templaza_options['templaza-shop-column']) ? $templaza_options['templaza-shop-column'] : 4;
            }
            if (wc_get_loop_prop('large_columns')) {
                $product_columns_large = wc_get_loop_prop('large_columns');
            } else {
                $product_columns_large = isset($templaza_options['templaza-shop-column-large']) ? $templaza_options['templaza-shop-column-large'] : 4;
            }
            if (wc_get_loop_prop('laptop_columns')) {
                $product_columns_laptop = wc_get_loop_prop('laptop_columns');
            } else {
                $product_columns_laptop = isset($templaza_options['templaza-shop-column-laptop']) ? $templaza_options['templaza-shop-column-laptop'] : 3;
            }
            if (wc_get_loop_prop('tablet_columns')) {
                $product_columns_tablet = wc_get_loop_prop('tablet_columns');
            } else {
                $product_columns_tablet = isset($templaza_options['templaza-shop-column-tablet']) ? $templaza_options['templaza-shop-column-tablet'] : 2;
            }
            if (wc_get_loop_prop('mobile_columns')) {
                $product_columns_mobile = wc_get_loop_prop('mobile_columns');
            } else {
                $product_columns_mobile = isset($templaza_options['templaza-shop-column-mobile']) ? $templaza_options['templaza-shop-column-mobile'] : 2;
            }
            if (wc_get_loop_prop('column_gap')) {
                $product_gap = wc_get_loop_prop('column_gap');
            } else {
                $product_gap = isset($templaza_options['templaza-shop-column-gap']) ? $templaza_options['templaza-shop-column-gap'] : '';
            }
        }
        $classes[] = 'columns-' . $product_columns;
        $classes[] = 'uk-child-width-1-' .$product_columns.'@l';
        $classes[] = 'uk-child-width-1-' .$product_columns_large.'@xl';
        $classes[] = 'uk-child-width-1-' .$product_columns_laptop.'@m';
        $classes[] = 'uk-child-width-1-' .$product_columns_tablet.'@s';
        $classes[] = 'uk-child-width-1-' .$product_columns_mobile.'';
        $classes[] = 'uk-grid-' . $product_gap.'';

        if ( $mobile_pl_col = intval( get_option( 'mobile_landscape_product_columns' ) ) ) {
            $classes[] = 'mobile-pl-col-' . $mobile_pl_col;
        }

        if ( $mobile_pp_col = intval( get_option( 'mobile_portrait_product_columns' ) ) ) {
            $classes[] = 'mobile-pp-col-' . $mobile_pp_col;
        }

        if ( intval( get_option( 'mobile_product_loop_atc' ) )
            || in_array( $loop_layout, array(
                'layout-3',
                'layout-6',
                'layout-8',
            ) ) ) {
            $classes[] = 'mobile-show-atc';
        }

        if ( intval( get_option( 'mobile_product_featured_icons' ) ) ) {
            $classes[] = 'mobile-show-featured-icons';
        }

        echo '<ul  class=" uk-grid-'.esc_attr($shop_col_gap).' ' . esc_attr( implode( ' ', $classes ) ) . '" data-uk-grid> ';
		foreach ( $products_ids as $product_id ) {
			$GLOBALS['post'] = get_post( $product_id ); // WPCS: override ok.
			setup_postdata( $GLOBALS['post'] );
			wc_get_template_part( 'content', $template );
		}

		$GLOBALS['post'] = $original_post; // WPCS: override ok.

		woocommerce_product_loop_end();

		wp_reset_postdata();
		wc_reset_loop();
	}

	/**
	 * Set ids query args.
	 *
	 * @since 1.0.0
	 *
	 * @param array $query_args Query args.
	 */
	protected static function set_recent_products_query_args( &$query_args ) {
		$query_args['order']   = 'DESC';
		$query_args['orderby'] = 'date';
	}

	/**
	 * Set sale products query args.
	 *
	 * @since 1.0.0
	 *
	 * @param array $query_args Query args.
	 */
	protected static function set_sale_products_query_args( &$query_args ) {
		$query_args['post__in'] = array_merge( array( 0 ), wc_get_product_ids_on_sale() );
	}

	/**
	 * Set best selling products query args.
	 *
	 * @since 1.0.0
	 *
	 * @param array $query_args Query args.
	 */
	protected static function set_best_selling_products_query_args( &$query_args ) {
		$query_args['meta_key'] = 'total_sales'; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
		$query_args['order']    = 'DESC';
		$query_args['orderby']  = 'meta_value_num';
	}

	/**
	 * Set top rated products query args.
	 *
	 * @since 1.0.0
	 *
	 * @param array $query_args Query args.
	 */
	protected static function set_top_rated_products_query_args( &$query_args ) {
		$query_args['meta_key'] = '_wc_average_rating'; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
		$query_args['order']    = 'DESC';
		$query_args['orderby']  = 'meta_value_num';
	}

	/**
	 * Set visibility as featured.
	 *
	 * @since 1.0.0
	 *
	 * @param array $query_args Query args.
	 */
	protected static function set_featured_products_query_args( &$query_args ) {
		$query_args['tax_query'] = array_merge( $query_args['tax_query'], WC()->query->get_tax_query() ); // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query

		$query_args['tax_query'][] = array(
			'taxonomy'         => 'product_visibility',
			'terms'            => 'featured',
			'field'            => 'name',
			'operator'         => 'IN',
			'include_children' => false,
		);
	}

	/**
	 * Get recently viewed ids
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function get_product_recently_viewed_ids() {
		$viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', $_COOKIE['woocommerce_recently_viewed'] ) : array();

		return array_reverse( array_filter( array_map( 'absint', $viewed_products ) ) );
	}

	/**
	 * Get products recently viewed
	 *
	 * @since 1.0.0
	 *
	 * @param $settings
	 */
	public static function get_recently_viewed_products( $settings ) {
		$product_ids = self::get_product_recently_viewed_ids();
		if ( empty( $product_ids ) ) {

			printf(
				'<ul class="product-list no-products">' .
				'<li class="text-center">%s <br> %s</li>' .
				'</ul>',
				wp_kses( $settings['desc'], wp_kses_allowed_html( 'post' ) ),
				self::control_url( 'empty_button', $settings['button_link'], $settings['button_text'], [ 'class' => 'templaza-button' ] )
			);

		} else {
			if ( 'default' == $settings['layout'] ) {

				woocommerce_product_loop_start();
				$original_post = $GLOBALS['post'];

				$index = 1;
				foreach ( $product_ids as $post_id ) {
					if ( $index > $settings['limit'] ) {
						break;
					}

					$index ++;

					$GLOBALS['post'] = get_post( $post_id );
					setup_postdata( $GLOBALS['post'] );
					wc_get_template_part( 'content', 'product' );
				}
				$GLOBALS['post'] = $original_post;
				woocommerce_product_loop_end();
				wc_reset_loop();

			} else {
				printf( '<ul class="product-list products">' );

				$original_post = $GLOBALS['post'];
				$index         = 1;
				foreach ( $product_ids as $post_id ) {
					if ( $index > $settings['limit'] ) {
						break;
					}

					$index ++;

					$GLOBALS['post'] = get_post( $post_id );
					setup_postdata( $GLOBALS['post'] );
					wc_get_template_part( 'content', 'product-recently-viewed' );
				}
				$GLOBALS['post'] = $original_post;
				printf( '</ul>' );

			}
			wp_reset_postdata();
		}
	}
    public static function templaza_wishlist_button() {
        if ( shortcode_exists( 'yith_wcwl_add_to_wishlist' ) ) {
            echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
        }

    }
    public static function templaza_quick_view_button() {
        global $product;

        echo sprintf(
            '<a href="%s" class="quick-view-button tz-loop-button" data-target="quick-view-modal" data-toggle="modal" data-id="%d" data-text="%s">
				%s<span class="quick-view-text loop_button-text">%s</span>
			</a>',
            is_customize_preview() ? '#' : esc_url( get_permalink() ),
            esc_attr( $product->get_id() ),
            esc_attr__( 'Quick View', 'uipro' ),
            '<i class="fas fa-eye"></i>',
            esc_html__( 'Quick View', 'uipro' )
        );
    }
    public static function templaza_product_loop_title() {
        echo '<h2 class="woocommerce-loop-product__title">';
        woocommerce_template_loop_product_link_open();
        the_title();
        woocommerce_template_loop_product_link_close();
        echo '</h2>';
    }

    public static function add_to_cart_link( $html, $product, $args ) {
        return sprintf(
            '<a href="%s" data-quantity="%s" class="%s tz-loop-button tz-loop_atc_button" %s data-text="%s" data-title="%s" >%s<span class="add-to-cart-text loop_button-text">%s</span></a>',
            esc_url( $product->add_to_cart_url() ),
            esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
            esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
            isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
            esc_html( $product->add_to_cart_text() ),
            esc_html( $product->get_title() ),
            '<i class="fas fa-shopping-cart"></i>',
            esc_html( $product->add_to_cart_text() )
        );
    }
    public static function star_rating_html( $html, $rating, $count ) {
        $html = '<span class="max-rating rating-stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            </span>';
        $html .= '<span class="user-rating rating-stars" style="width:' . ( ( $rating / 5 ) * 100 ) . '%">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            </span>';

        $html .= '<span class="screen-reader-text">';

        if ( 0 < $count ) {
            /* translators: 1: rating 2: rating count */
            $html .= sprintf( _n( 'Rated %1$s out of 5 based on %2$s customer rating', 'Rated %1$s out of 5 based on %2$s customer ratings', $count, 'uipro' ), '<strong class="rating">' . esc_html( $rating ) . '</strong>', '<span class="rating">' . esc_html( $count ) . '</span>' );
        } else {
            /* translators: %s: rating */
            $html .= sprintf( esc_html__( 'Rated %s out of 5', 'uipro' ), '<strong class="rating">' . esc_html( $rating ) . '</strong>' );
        }

        $html .= '</span>';

        return $html;
    }
    public static function templaza_product_taxonomy( $taxonomy = 'product_cat', $show_thumbnail = false ) {
        global $product;

        $taxonomy = empty($taxonomy) ? 'product_cat' : $taxonomy;
        $terms = get_the_terms( $product->get_id(), $taxonomy );

        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
            if( $show_thumbnail ) {
                $thumbnail_id   = get_term_meta( $terms[0]->term_id, 'brand_thumbnail_id', true );
                $image = $thumbnail_id ? wp_get_attachment_image( $thumbnail_id, 'full' ) : '';
                echo sprintf(
                    '<a class="meta-cat" href="%s">%s</a>',
                    esc_url( get_term_link( $terms[0] ), $taxonomy ),
                    $image);
            } else {
                echo sprintf(
                    '<a class="meta-cat" href="%s">%s</a>',
                    esc_url( get_term_link( $terms[0] ), $taxonomy ),
                    esc_html( $terms[0]->name ) );
            }
        }
    }
    public static function product_loop_desc() {
        global $post;

        $short_description = $post ? $post->post_excerpt : '';

        if ( ! $short_description ) {
            return;
        }
        if ( !class_exists( 'TemPlazaFramework\TemPlazaFramework' )){
            $templaza_options = array();
        }else{
            $templaza_options = Functions::get_theme_options();
        }
        $loop_desc_length       = isset($templaza_options['templaza-shop-loop-description-length'])?$templaza_options['templaza-shop-loop-description-length']:'10';

        $length = intval( $loop_desc_length );
        if ( $length ) {
            $short_description = wp_trim_words( $short_description, $length, '...');
        }

        echo sprintf( '<div class="woocommerce-product-details__short-description"> %s</div>', $short_description );
    }
    public function product_loop_buttons_open() {
        echo '<div class="product-loop__buttons">';
    }
    public function product_loop_buttons_close() {

        echo '</div>';
    }
    /**
     * Open product Loop form.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public static function product_loop_form_open() {
        global $product;

        if ( ! $product->is_type( 'variable' ) ) {
            return;
        }

        echo '<div class="product-loop__form">';
    }

    /**
     * Close product Loop form.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public static function product_loop_form_close() {
        global $product;

        if ( ! $product->is_type( 'variable' ) ) {
            return;
        }
        echo '</div>';
    }
    /**
     * Variation loop
     *
     * @since 1.0.0
     *
     * @return void
     */
    public static function display_variation_dropdown() {
        global $product;

        if ( ! $product->is_type( 'variable' ) ) {
            return;
        }

        // Get Available variations?
        $get_variations = count( $product->get_children() ) <= apply_filters( 'woocommerce_ajax_variation_threshold', 30, $product );

        // Load the template.
        wc_get_template(
            'loop/add-to-cart-variable.php',
            array(
                'available_variations' => $get_variations ? $product->get_available_variations() : false,
                'attributes'           => $product->get_variation_attributes(),
                'selected_attributes'  => $product->get_default_attributes(),
            )
        );
    }
    /**
     * Variable add to cart loop
     *
     * @since 1.0.0
     *
     * @return string
     */
    public static function product_variable_add_to_cart_text( $text ) {
        global $product;

        if ( ! $product->is_type( 'variable' ) ) {
            return $text;
        }

        if ( $product->is_purchasable() ) {
            $text = esc_html__( 'Add to cart', 'uipro' );

        }

        return $text;
    }
    /**
     * Close variation form
     *
     * @since 1.0.0
     *
     * @return void
     */
    public static function close_variation_form() {
        global $product;

        if ( ! $product->is_type( 'variable' ) ) {
            return;
        }

        echo sprintf(
            '<a href="#" class="product-close-variations-form ">%s</a>',
            '<i class="fas fa-close"></i>'
        );
    }
    /**
     * Quick shop button.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public static function product_loop_quick_shop() {
        global $product;

        if ( ! $product->is_type( 'variable' ) ) {
            return;
        }

        echo sprintf(
            '<a href="#" class="product-quick-shop-button templaza-btn" data-product_id="%s" >%s%s</a>',
            esc_attr( $product->get_id() ),
            '<i class="fas fa-shopping-cart"></i>',
            esc_html__( 'Quick Shop', 'uipro' )
        );
    }
}
TemPlaza_Woo_El_Helper::get_instance();