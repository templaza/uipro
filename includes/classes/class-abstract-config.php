<?php
/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;

if ( ! class_exists( 'UIPro_Abstract_Config' ) ) {
    /**
     * Class UIPro_Abstract_Config
     */
    abstract class UIPro_Abstract_Config {

        /**
         * @var string
         */
        public static $group = '';
        /**
         * @var string
         */
        public static $template_name = '';

        /**
         * @var string
         */
        public static $base = '';

        /**
         * @var string
         */
        public static $name = '';

        /**
         * @var string
         */
        public static $desc = '';
        /**
         * @var string
         */
        public static $icon = '';
        /**
         * @var array
         */
        public static $options = array();

        /**
         * @var string
         */
        public static $assets_url = '';

        /**
         * @var string
         */
        public static $assets_path = '';

        /**
         * @var array
         */
        public static $styles = array();

        /**
         * @var array
         */
        public static $scripts = array();

        /**
         * @var array
         */
        public static $queue_assets = array();

        /**
         * @var array
         */
        public static $localize = array();

        protected static $cache = array();

        /**
         * UIPro_Abstract_Config constructor.
         */
        public function __construct() {

            // set group
            self::$group = '';

            self::$assets_url  = plugin_dir_url(UIPRO_WIDGETS_PATH).'widgets' . self::$group . '/' . self::$base . '/assets/';
            self::$assets_path = UIPRO_WIDGETS_PATH . self::$group . '/' . self::$base . '/assets/';

            // set options
            $options    = $this->get_options();
            self::$options = is_array( $options ) ? $options : array();
            // set template name
            $_template_name = $this->get_template_name();
            self::$template_name =  !empty($_template_name) ? $_template_name : '';
            // handle std, add default options
            self::$options = apply_filters( "templaza-elements/" . self::$base . '/config-options', $this->_handle_options( self::$options ) );

            // set styles
            self::$styles = apply_filters( 'templaza-elements/' . self::$base . '/styles', $this->get_styles() );
            // set scripts
            self::$scripts = apply_filters( 'templaza-elements/' . self::$base . '/scripts', $this->get_scripts() );
            // set localize
            self::$localize = apply_filters( 'templaza-elements/' . self::$base . '/localize', $this->get_localize() );
        }

        /**
         * @param $options
         *
         * @return mixed
         */
        protected function _handle_options( $options ) {

            foreach ( $options as $key => $option ) {
                if ( ! isset( $option['std'] ) ) {
                    $type = $option['type'];

                    switch ( $type ) {
                        case 'dropdown':
                            $values                 = ( ! empty( $option['value'] ) && is_array( $option['value'] ) ) ? array_values( $option['value'] ) : '';
                            $options[ $key ]['std'] = $values ? reset( $values ) : '';
                            break;
                        case 'param_group':
                            $options[ $key ]['params'] = $this->_handle_options( $option['params'] );
                            break;
                        case 'radio_image':
                            $values                 = ( ! empty( $option['options'] ) && is_array( $option['options'] ) ) ? array_values( $option['options'] ) : '';
                            $options[ $key ]['std'] = $values ? reset( $values ) : '';
                            break;
                        default:
                            $options[ $key ]['std'] = '';
                            break;
                    }
                }
            }

            return $options;
        }

        /**
         * @return array
         */
        public function get_options() {
            return array();
        }

//		abstract function get_template_name( $instance );
        public function get_template_name() {

        }

        /**
         * @return array
         */
        public function get_styles() {
            return array();
        }

        /**
         * @return array
         */
        public function get_scripts() {
            return array();
        }

        /**
         * @return array
         */
        public function get_localize() {
            return array();
        }

        /**
         * @return array
         */
        public static function _get_assets() {
            $store_id   = __METHOD__;
            $store_id  .= '::'.get_called_class();
            $store_id   = md5($store_id);

            if(isset(static::$cache[$store_id])){
                return static::$cache[$store_id];
            }

            $queue_assets = array();

            $prefix = apply_filters( 'templaza-elements/prefix-assets', 'templaza-' );

            if ( self::$styles ) {
                // allow hook default folder
                $default_folder_css = apply_filters( 'templaza-elements/default-assets-folder', self::$assets_path . 'css/', self::$base );
                $default_url_css    = apply_filters( 'templaza-elements/default-assets-folder', self::$assets_url . 'css/', self::$base );

                foreach ( self::$styles as $handle => $args ) {
                    $src      = $args['src'];
                    $depends  = ( isset( $args['deps'] ) && is_array( $args['deps'] ) ) ? $args['deps'] : array();
                    $media    = ! empty( $args['media'] ) ? $args['media'] : 'all';
                    $deps_src = isset( $args['deps_src'] ) ? $args['deps_src'] : array();

                    if ( file_exists( $default_folder_css . $src ) ) {
                        // enqueue depends
                        if ( $depends ) {
                            foreach ( $depends as $depend ) {
                                if ( wp_script_is( $depend ) ) {

                                    wp_enqueue_style( $depend );
                                } else {
                                    do_action( 'templaza-elements/enqueue-depends-styles', self::$base, $depend );
                                }
                            }
                        }

                        // add to queue
                        $queue_assets['styles'][ $prefix . $handle ] = array(
                            'url'      => $default_url_css . $src,
                            'deps'     => $depends,
                            'media'    => $media,
                            'deps_src' => $deps_src
                        );
                    }
                }
            }

            if ( !empty(self::$scripts) ) {
                // allow hook default folder
                $default_folder_js = apply_filters( 'templaza-elements/default-assets-folder', self::$assets_path . 'js/', self::$base );
                $default_url_js    = apply_filters( 'templaza-elements/default-assets-folder', self::$assets_url . 'js/', self::$base );
                $localized         = false;

                foreach ( self::$scripts as $handle => $args ) {
                    $src       = $args['src'];
                    $depends   = ! empty( $args['deps'] ) ? $args['deps'] : array();
                    $in_footer = isset( $args['in_footer'] ) ? $args['in_footer'] : true;
                    $deps_src = isset( $args['deps_src'] ) ? $args['deps_src'] : array();

                    if ( file_exists( $default_folder_js . $src ) ) {
                        // enqueue depends
                        if ( $depends ) {
                            foreach ( $depends as $depend ) {
                                if ( wp_script_is( $depend ) && $depend != 'jquery' ) {
                                    wp_enqueue_script( $depend );
                                } else {
                                    do_action( 'templaza-elements/enqueue-depends-scripts', self::$base, $depend );
                                }
                            }
                        }
                        // add to queue
                        $queue_assets['scripts'][ $prefix . $handle ] = array(
                            'url'       => $default_url_js . $src,
                            'deps'      => $depends,
                            'in_footer' => $in_footer,
                            'deps_src' => $deps_src
                        );

                        if ( self::$localize ) {
                            foreach ( self::$localize as $name => $data ) {
                                $queue_assets['scripts'][ $prefix . $handle ]['localize'][ $name ] = $data;
                            }
                        }
//						if ( ! $localized && self::$localize ) {
//							$localized = true;
//							foreach ( self::$localize as $name => $data ) {
//								wp_localize_script( $prefix . $handle, $name, $data );
//							}
//						}
                    }
                }
            }

            if(!empty($queue_assets)){
                static::$cache[$store_id]   = $queue_assets;
            }

            return $queue_assets;
        }

        /**
         * Register scripts
         */
        public static function register_scripts() {

            $store_id   = __METHOD__;
            $store_id  .= '::'.get_called_class();
            $store_id   = md5($store_id);

            if(isset(static::$cache[$store_id])){
                return static::$cache[$store_id];
            }

            $queue = self::_get_assets();
            $localized = false;
            if ( $queue ) {
                foreach ( $queue as $key => $assets ) {
                    if ( $key == 'styles' ) {
                        if ( ! empty( $args['deps_src'] ) ) {
                            foreach ( $args['deps_src'] as $deps_name => $deps_src ) {
                                if ( ! wp_script_is( $deps_name, 'registered' ) ) {
                                    wp_register_style( $deps_name, $deps_src );
                                }
                            }
                        }
                        foreach ( $assets as $name => $args ) {
                            wp_register_style( $name, $args['url'], $args['deps'], '', $args['media'] );
                        }
                    } else if ( $key == 'scripts' ) {
                        foreach ( $assets as $name => $args ) {
                            if ( ! empty( $args['deps_src'] ) ) {
                                foreach ( $args['deps_src'] as $deps_name => $deps_src ) {
                                    if ( ! wp_script_is( $deps_name, 'registered' ) ) {
                                        wp_register_script( $deps_name, $deps_src );
                                    }
                                }
                            }
                            if (! wp_script_is($name, 'registered')) {
                                wp_register_script( $name, $args['url'], $args['deps'], '', $args['in_footer'] );
                                // localize scripts
                                if ( ! $localized && isset( $args['localize'] )  ) {
                                    foreach ( $args['localize'] as $index => $data ) {
                                        wp_localize_script( $name, $index, $data );
                                    }
                                    $localized = true;
                                }
                            }
                        }
                    }
                }

                static::$cache[$store_id]   = true;
            }
        }

        /**
         * Enqueue scripts.
         */
        public static function enqueue_scripts() {

            $store_id   = __METHOD__;
            $store_id  .= '::'.get_called_class();
            $store_id   = md5($store_id);

            if(isset(static::$cache[$store_id])){
                return static::$cache[$store_id];
            }

            $queue = self::_get_assets();

            if ( $queue ) {
                foreach ( $queue as $key => $assets ) {
                    if ( $key == 'styles' ) {
                        foreach ( $assets as $name => $args ) {
                            if ( ! empty( $args['deps_src'] ) ) {
                                foreach ( $args['deps_src'] as $deps_name => $deps_src ) {
                                    if ( ! wp_script_is( $deps_name, 'registered' ) ) {
                                        wp_register_style( $deps_name, $deps_src );
                                    }
                                }
                            }
                            wp_enqueue_style( $name );
                        }
                    } else if ( $key == 'scripts' ) {
                        foreach ( $assets as $name => $args ) {
                            if ( ! empty( $args['deps_src'] ) ) {
                                foreach ( $args['deps_src'] as $deps_name => $deps_src ) {
                                    if ( ! wp_script_is( $deps_name, 'registered' ) ) {
                                        wp_register_script( $deps_name, $deps_src );
                                    }
                                }
                            }
                            wp_enqueue_script( $name );
                        }
                    }
                }
                static::$cache[$store_id]   = true;
            }
        }

        /**
         * Options to config number items in slider.
         *
         * @param array $default
         * @param array $depends
         *
         * @return mixed
         */
        protected function _number_items_options( $default = array(), $depends = array() ) {

            $options = apply_filters( 'templaza-elements/element-default-number-items-slider', array(
                array(
                    'type'             => 'number',
                    'heading'          => esc_html__( 'Visible Items', 'templaza-elements' ),
                    'param_name'       => 'items_visible',
                    'std'              => '4',
                    'admin_label'      => true,
                    'edit_field_class' => 'vc_col-xs-4',
                ),

                array(
                    'type'             => 'number',
                    'heading'          => esc_html__( 'Tablet Items', 'templaza-elements' ),
                    'param_name'       => 'items_tablet',
                    'std'              => '2',
                    'admin_label'      => true,
                    'edit_field_class' => 'vc_col-xs-4',
                ),

                array(
                    'type'             => 'number',
                    'heading'          => esc_html__( 'Mobile Items', 'templaza-elements' ),
                    'param_name'       => 'items_mobile',
                    'std'              => '1',
                    'admin_label'      => true,
                    'edit_field_class' => 'vc_col-xs-4',
                )
            ) );

            // handle default value
            if ( $default ) {
                foreach ( $options as $key => $item ) {
                    $name = $item['param_name'];
                    if ( array_key_exists( $name, $default ) ) {
                        $options[ $key ]['std'] = $default[ $name ];
                    }
                }
            }

            // handle dependency
            if ( $depends ) {
                foreach ( $options as $key => $item ) {
                    $options[ $key ]['dependency'] = $depends;
                }
            }

            return $options;
        }

        /**
         * Get all Post type categories.
         *
         * @param       $category_name
         *
         * @return array
         */
        protected function _post_type_categories( $category_name ) {

            global $wpdb;
            $categories = $wpdb->get_results( $wpdb->prepare(
                "
				  SELECT      t2.slug, t2.name
				  FROM        $wpdb->term_taxonomy AS t1
				  INNER JOIN $wpdb->terms AS t2 ON t1.term_id = t2.term_id
				  WHERE t1.taxonomy = %s
				  ",
                $category_name
            ) );

            $options = array( esc_html__( 'All Category', 'templaza-elements' ) => '' );
            foreach ( $categories as $category ) {

                $options[ html_entity_decode( $category->name ) ] = $category->slug;
            }

            return $options;
        }

        /**
         * @return mixed
         */
        protected function _setting_font_weights() {

            $font_weight = array(
                esc_html__( 'Select', 'templaza-elements' ) => '',
                esc_html__( 'Normal', 'templaza-elements' ) => 'normal',
                esc_html__( 'Bold', 'templaza-elements' )   => 'bold',
                esc_html__( '100', 'templaza-elements' )    => '100',
                esc_html__( '200', 'templaza-elements' )    => '200',
                esc_html__( '300', 'templaza-elements' )    => '300',
                esc_html__( '400', 'templaza-elements' )    => '400',
                esc_html__( '500', 'templaza-elements' )    => '500',
                esc_html__( '600', 'templaza-elements' )    => '600',
                esc_html__( '700', 'templaza-elements' )    => '700',
                esc_html__( '800', 'templaza-elements' )    => '800',
                esc_html__( '900', 'templaza-elements' )    => '900'
            );

            return apply_filters( 'templaza-elements/settings-font-weight', $font_weight );
        }

        /**
         * @return mixed
         */
        protected function _setting_tags() {

            $tags = array(
                esc_html__( 'Select tag', 'templaza-elements' ) => '',
                esc_html__( 'h1', 'templaza-elements' )         => 'h1',
                esc_html__( 'h2', 'templaza-elements' )         => 'h2',
                esc_html__( 'h3', 'templaza-elements' )         => 'h3',
                esc_html__( 'h4', 'templaza-elements' )         => 'h4',
                esc_html__( 'h5', 'templaza-elements' )         => 'h5',
                esc_html__( 'h6', 'templaza-elements' )         => 'h6'
            );

            return apply_filters( 'templaza-elements/settings-tags', $tags );
        }

        /**
         * @return mixed
         */
        protected function _setting_text_transform() {

            $text_transform = array(
                esc_html__( 'None', 'templaza-elements' )       => 'none',
                esc_html__( 'Capitalize', 'templaza-elements' ) => 'capitalize',
                esc_html__( 'Uppercase', 'templaza-elements' )  => 'uppercase',
                esc_html__( 'Lowercase', 'templaza-elements' )  => 'lowercase',
            );

            return apply_filters( 'templaza-elements/settings-text-transform', $text_transform );
        }

        public function get_font_uikit() {
            $store_id   = md5(__METHOD__);
            if(isset(static::$cache[$store_id])){
                return static::$cache[$store_id];
            }

            $font_uikit = [
                ''  => __( 'Choose an icon...', 'templaza-elements' ),
                'home' => __( 'Home', 'templaza-elements' ),
                'sign-in' => __( 'Sign-in', 'templaza-elements' ),
                'sign-out' => __( 'Sign-out', 'templaza-elements' ),
                'user' => __( 'User', 'templaza-elements' ),
                'users' => __( 'Users', 'templaza-elements' ),
                'lock' => __( 'Lock', 'templaza-elements' ),
                'unlock' => __( 'Unlock', 'templaza-elements' ),
                'settings' => __( 'Settings', 'templaza-elements' ),
                'cog' => __( 'Cog', 'templaza-elements' ),
                'nut' => __( 'Nut', 'templaza-elements' ),
                'comment' => __( 'Comment', 'templaza-elements' ),
                'commenting' => __( 'Commenting', 'templaza-elements' ),
                'comments' => __( 'Comments', 'templaza-elements' ),
                'hashtag' => __( 'Hashtag', 'templaza-elements' ),
                'tag' => __( 'Tag', 'templaza-elements' ),
                'cart' => __( 'Cart', 'templaza-elements' ),
                'credit-card' => __( 'Credit-card', 'templaza-elements' ),
                'mail' => __( 'Mail', 'templaza-elements' ),
                'receiver' => __( 'Receiver', 'templaza-elements' ),
                'search' => __( 'Search', 'templaza-elements' ),
                'location' => __( 'Location', 'templaza-elements' ),
                'bookmark' => __( 'Bookmark', 'templaza-elements' ),
                'code' => __( 'Code', 'templaza-elements' ),
                'paint-bucket' => __( 'Paint-bucket', 'templaza-elements' ),
                'camera' => __( 'Camera', 'templaza-elements' ),
                'bell' => __( 'Bell', 'templaza-elements' ),
                'bolt' => __( 'Bolt', 'templaza-elements' ),
                'star' => __( 'Star', 'templaza-elements' ),
                'heart' => __( 'Heart', 'templaza-elements' ),
                'happy' => __( 'Happy', 'templaza-elements' ),
                'lifesaver' => __( 'Lifesaver', 'templaza-elements' ),
                'rss' => __( 'Rss', 'templaza-elements' ),
                'social' => __( 'Social', 'templaza-elements' ),
                'git-branch' => __( 'Git-branch', 'templaza-elements' ),
                'git-fork' => __( 'Git-fork', 'templaza-elements' ),
                'world' => __( 'World', 'templaza-elements' ),
                'calendar' => __( 'Calendar', 'templaza-elements' ),
                'clock' => __( 'Clock', 'templaza-elements' ),
                'history' => __( 'History', 'templaza-elements' ),
                'future' => __( 'Future', 'templaza-elements' ),
                'pencil' => __( 'Pencil', 'templaza-elements' ),
                'trash' => __( 'Trash', 'templaza-elements' ),
                'move' => __( 'Move', 'templaza-elements' ),
                'link' => __( 'Link', 'templaza-elements' ),
                'question' => __( 'Question', 'templaza-elements' ),
                'info' => __( 'Info', 'templaza-elements' ),
                'warning' => __( 'Warning', 'templaza-elements' ),
                'image' => __( 'Image', 'templaza-elements' ),
                'thumbnails' => __( 'Thumbnails', 'templaza-elements' ),
                'table' => __( 'Table', 'templaza-elements' ),
                'list' => __( 'List', 'templaza-elements' ),
                'menu' => __( 'Menu', 'templaza-elements' ),
                'grid' => __( 'Grid', 'templaza-elements' ),
                'more' => __( 'More', 'templaza-elements' ),
                'more-vertical' => __( 'More-vertical', 'templaza-elements' ),
                'plus' => __( 'Plus', 'templaza-elements' ),
                'plus-circle' => __( 'Plus-circle', 'templaza-elements' ),
                'minus' => __( 'Minus', 'templaza-elements' ),
                'minus-circle' => __( 'Minus-circle', 'templaza-elements' ),
                'close' => __( 'Close', 'templaza-elements' ),
                'check' => __( 'Check', 'templaza-elements' ),
                'ban' => __( 'Ban', 'templaza-elements' ),
                'refresh' => __( 'Refresh', 'templaza-elements' ),
                'play' => __( 'Play', 'templaza-elements' ),
                'play-circle' => __( 'Play-circle', 'templaza-elements' ),
                'tv' => __( 'Tv', 'templaza-elements' ),
                'desktop' => __( 'Desktop', 'templaza-elements' ),
                'laptop' => __( 'Laptop', 'templaza-elements' ),
                'tablet' => __( 'Tablet', 'templaza-elements' ),
                'phone' => __( 'Phone', 'templaza-elements' ),
                'tablet-landscape' => __( 'Tablet-landscape', 'templaza-elements' ),
                'phone-landscape' => __( 'Phone-landscape', 'templaza-elements' ),
                'file' => __( 'File', 'templaza-elements' ),
                'copy' => __( 'Copy', 'templaza-elements' ),
                'file-edit' => __( 'File-edit', 'templaza-elements' ),
                'folder' => __( 'Folder', 'templaza-elements' ),
                'album' => __( 'Album', 'templaza-elements' ),
                'push' => __( 'Push', 'templaza-elements' ),
                'pull' => __( 'Pull', 'templaza-elements' ),
                'server' => __( 'Server', 'templaza-elements' ),
                'database' => __( 'Database', 'templaza-elements' ),
                'cloud-upload' => __( 'Cloud-upload', 'templaza-elements' ),
                'cloud-download' => __( 'Cloud-download', 'templaza-elements' ),
                'download' => __( 'Download', 'templaza-elements' ),
                'upload' => __( 'Upload', 'templaza-elements' ),
                'reply' => __( 'Reply', 'templaza-elements' ),
                'forward' => __( 'Forward', 'templaza-elements' ),
                'expand' => __( 'Expand', 'templaza-elements' ),
                'shrink' => __( 'Shrink', 'templaza-elements' ),
                'arrow-up' => __( 'Arrow-up', 'templaza-elements' ),
                'arrow-down' => __( 'Arrow-down', 'templaza-elements' ),
                'arrow-left' => __( 'Arrow-left', 'templaza-elements' ),
                'arrow-right' => __( 'Arrow-right', 'templaza-elements' ),
                'chevron-up' => __( 'Chevron-up', 'templaza-elements' ),
                'chevron-down' => __( 'Chevron-down', 'templaza-elements' ),
                'chevron-left' => __( 'Chevron-left', 'templaza-elements' ),
                'chevron-right' => __( 'Chevron-right', 'templaza-elements' ),
                'triangle-up' => __( 'Triangle-up', 'templaza-elements' ),
                'triangle-down' => __( 'Triangle-down', 'templaza-elements' ),
                'triangle-left' => __( 'Triangle-left', 'templaza-elements' ),
                'triangle-right' => __( 'Triangle-right', 'templaza-elements' ),
                'bold' => __( 'Bold', 'templaza-elements' ),
                'italic' => __( 'Italic', 'templaza-elements' ),
                'strikethrough' => __( 'Strikethrough', 'templaza-elements' ),
                'video-camera' => __( 'Video-camera', 'templaza-elements' ),
                'quote-right' => __( 'Quote-right', 'templaza-elements' ),
                '500px' => __( '500px', 'templaza-elements' ),
                'behance' => __( 'Behance', 'templaza-elements' ),
                'dribbble' => __( 'Dribbble', 'templaza-elements' ),
                'facebook' => __( 'Facebook', 'templaza-elements' ),
                'flickr' => __( 'Flickr', 'templaza-elements' ),
                'foursquare' => __( 'Foursquare', 'templaza-elements' ),
                'github' => __( 'Github', 'templaza-elements' ),
                'github-alt' => __( 'Github-alt', 'templaza-elements' ),
                'gitter' => __( 'Gitter', 'templaza-elements' ),
                'google' => __( 'Google', 'templaza-elements' ),
                'google-plus' => __( 'Google-plus', 'templaza-elements' ),
                'instagram' => __( 'Instagram', 'templaza-elements' ),
                'joomla' => __( 'Joomla', 'templaza-elements' ),
                'linkedin' => __( 'Linkedin', 'templaza-elements' ),
                'pagekit' => __( 'Pagekit', 'templaza-elements' ),
                'pinterest' => __( 'Pinterest', 'templaza-elements' ),
                'soundcloud' => __( 'Soundcloud', 'templaza-elements' ),
                'tripadvisor' => __( 'Tripadvisor', 'templaza-elements' ),
                'tumblr' => __( 'Tumblr', 'templaza-elements' ),
                'twitter' => __( 'Twitter', 'templaza-elements' ),
                'uikit' => __( 'Uikit', 'templaza-elements' ),
                'etsy' => __( 'Etsy', 'templaza-elements' ),
                'vimeo' => __( 'Vimeo', 'templaza-elements' ),
                'whatsapp' => __( 'Whatsapp', 'templaza-elements' ),
                'wordpress' => __( 'Wordpress', 'templaza-elements' ),
                'xing' => __( 'Xing', 'templaza-elements' ),
                'yelp' => __( 'Yelp', 'templaza-elements' ),
                'youtube' => __( 'Youtube', 'templaza-elements' ),
                'print' => __( 'Print', 'templaza-elements' ),
                'reddit' => __( 'Reddit', 'templaza-elements' ),
                'file-text' => __( 'File Text', 'templaza-elements' ),
                'file-pdf' => __( 'File Pdf', 'templaza-elements' ),
                'chevron-double-left' => __( 'Chevron Double Left', 'templaza-elements' ),
                'chevron-double-right' => __( 'Chevron Double Right', 'templaza-elements' ),
            ];
            static::$cache[$store_id] = $font_uikit  = apply_filters( 'templaza-elements/settings-font-uikit', $font_uikit );
            return $font_uikit;
        }

        public function get_general_options() {
            $store_id   = md5(__METHOD__);
            if(isset(static::$cache[$store_id])){
                return static::$cache[$store_id];
            }

            $options = array(
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'addon_margin_top',
                    'label'         => esc_html__('Margin Top', 'templaza-elements'),
                    'description'   => esc_html__('Set the top margin.', 'templaza-elements'),
                    'options'       => array(
                        '' => __('Keep existing', 'templaza-elements'),
                        'small' => __('Small', 'templaza-elements'),
                        'default' => __('Default', 'templaza-elements'),
                        'medium' => __('Medium', 'templaza-elements'),
                        'large' => __('Large', 'templaza-elements'),
                        'xlarge' => __('X-Large', 'templaza-elements'),
                        'remove' => __('None', 'templaza-elements'),
                    ),
                    'default'           => '',
                    'start_section' => 'general',
                    'section_name'      => esc_html__('General Settings', 'templaza-elements')
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'addon_margin_bottom',
                    'label'         => esc_html__('Margin Bottom', 'templaza-elements'),
                    'description'   => esc_html__('Set the bottom margin.', 'templaza-elements'),
                    'options'       => array(
                        '' => __('Keep existing', 'templaza-elements'),
                        'small' => __('Small', 'templaza-elements'),
                        'default' => __('Default', 'templaza-elements'),
                        'medium' => __('Medium', 'templaza-elements'),
                        'large' => __('Large', 'templaza-elements'),
                        'xlarge' => __('X-Large', 'templaza-elements'),
                        'remove' => __('None', 'templaza-elements'),
                    ),
                    'default'           => '',
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'uk_container',
                    'label'         => esc_html__('Container', 'templaza-elements'),
                    'description'   => esc_html__('Add the uk-container class to widget to give it a max-width and wrap the main content', 'templaza-elements'),
                    'options'       => array(
                        '' => __('None', 'templaza-elements'),
                        'default' => __('Default', 'templaza-elements'),
                        'xsmall' => __('X-Small', 'templaza-elements'),
                        'small' => __('Small', 'templaza-elements'),
                        'large' => __('Large', 'templaza-elements'),
                        'xlarge' => __('X-Large', 'templaza-elements'),
                        'expand' => __('Expand', 'templaza-elements'),
                    ),
                    'default'           => '',
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'addon_max_width',
                    'label'         => esc_html__('Max Width', 'templaza-elements'),
                    'description'   => esc_html__('Set the maximum content width.', 'templaza-elements'),
                    'options'       => array(
                        '' => __('None', 'templaza-elements'),
                        'small' => __('Small', 'templaza-elements'),
                        'medium' => __('Medium', 'templaza-elements'),
                        'large' => __('Large', 'templaza-elements'),
                        'xlarge' => __('X-Large', 'templaza-elements'),
                        '2xlarge' => __('2X-Large', 'templaza-elements'),
                    ),
                    'default'           => '',
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'addon_max_width_breakpoint',
                    'label'         => esc_html__('Max Width Breakpoint', 'templaza-elements'),
                    'description'   => esc_html__('Define the device width from which the element\'s max-width will apply.', 'templaza-elements'),
                    'options'       => array(
                        '' => __('Always', 'templaza-elements'),
                        's' => __('Small (Phone Landscape)', 'templaza-elements'),
                        'm' => __('Medium (Tablet Landscape)', 'templaza-elements'),
                        'l' => __('Large (Desktop)', 'templaza-elements'),
                        'xl' => __('X-Large (Large Screens)', 'templaza-elements'),
                    ),
                    'default'           => '',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'addon_max_width', 'operator' => '!==', 'value' => ''],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'block_align',
                    'label'         => esc_html__('Block Alignment', 'templaza-elements'),
                    'description'   => esc_html__('Define the alignment in case the container exceeds the element\'s max-width.', 'templaza-elements'),
                    'options'       => array(
                        ''=>__('Left', 'templaza-elements'),
                        'center'=>__('Center', 'templaza-elements'),
                        'right'=>__('Right', 'templaza-elements'),
                    ),
                    'default'           => '',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'addon_max_width', 'operator' => '!==', 'value' => ''],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'block_align_breakpoint',
                    'label'         => esc_html__('Block Alignment Breakpoint', 'templaza-elements'),
                    'description'   => esc_html__('Define the device width from which the alignment will apply.', 'templaza-elements'),
                    'options'       => array(
                        ''=>__('Always', 'templaza-elements'),
                        's'=>__('Small (Phone Landscape)', 'templaza-elements'),
                        'm'=>__('Medium (Tablet Landscape)', 'templaza-elements'),
                        'l'=>__('Large (Desktop)', 'templaza-elements'),
                        'xl'=>__('X-Large (Large Screens)', 'templaza-elements'),
                    ),
                    'default'           => '',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'addon_max_width', 'operator' => '!==', 'value' => ''],
                        ],
                    ],
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'block_align_fallback',
                    'label'         => esc_html__('Block Alignment Fallback', 'templaza-elements'),
                    'description'   => esc_html__('Define the alignment in case the container exceeds the element\'s max-width.', 'templaza-elements'),
                    'options'       => array(
                        ''=>__('Left', 'templaza-elements'),
                        'center'=>__('Center', 'templaza-elements'),
                        'right'=>__('Right', 'templaza-elements'),
                    ),
                    'default'           => '',
                    'conditions' => [
                        'relation' => 'and',
                        'terms' => [
                            ['name' => 'addon_max_width', 'operator' => '!==', 'value' => ''],
                            ['name' => 'block_align_breakpoint', 'operator' => '!==', 'value' => ''],
                        ],
                    ],

                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'text_alignment',
                    'label'         => esc_html__('Text Alignment', 'templaza-elements'),
                    'description'   => esc_html__('Center, left and right alignment may depend on a breakpoint and require a fallback.', 'templaza-elements'),
                    'options'       => array(
                        '' => __('None', 'templaza-elements'),
                        'left' => __('Left', 'templaza-elements'),
                        'center' => __('Center', 'templaza-elements'),
                        'right' => __('Right', 'templaza-elements'),
                    ),
                    'default'           => '',

                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'text_alignment_breakpoint',
                    'label'         => esc_html__('Text Alignment Breakpoint', 'templaza-elements'),
                    'description'   => esc_html__('Display the button alignment only on this device width and larger', 'templaza-elements'),
                    'options'       => array(
                        '' => __('Always', 'templaza-elements'),
                        's' => __('Small (Phone Landscape)', 'templaza-elements'),
                        'm' => __('Medium (Tablet Landscape)', 'templaza-elements'),
                        'l' => __('Large (Desktop)', 'templaza-elements'),
                        'xl' => __('X-Large (Large Screens)', 'templaza-elements'),
                    ),
                    'default'           => '',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'text_alignment', 'operator' => '!==', 'value' => ''],
                        ],
                    ],

                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'text_alignment_fallback',
                    'label'         => esc_html__('Text Alignment Fallback', 'templaza-elements'),
                    'description'   => esc_html__('Define an alignment fallback for device widths below the breakpoint.', 'templaza-elements'),
                    'options'       => array(
                        '' => __('None', 'templaza-elements'),
                        'left' => __('Left', 'templaza-elements'),
                        'center' => __('Center', 'templaza-elements'),
                        'right' => __('Right', 'templaza-elements'),
                    ),
                    'default'           => '',
                    'conditions' => [
                        'relation' => 'and',
                        'terms' => [
                            ['name' => 'text_alignment', 'operator' => '!==', 'value' => ''],
                            ['name' => 'text_alignment_breakpoint', 'operator' => '!==', 'value' => ''],
                        ],
                    ],

                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'uk_animation',
                    'label'         => esc_html__('Animation', 'templaza-elements'),
                    'description'   => esc_html__('A collection of smooth animations to use within your page.', 'templaza-elements'),
                    'options'       => array(
                        '' => __('Inherit', 'templaza-elements'),
                        'fade' => __('Fade', 'templaza-elements'),
                        'scale-up' => __('Scale Up', 'templaza-elements'),
                        'scale-down' => __('Scale Down', 'templaza-elements'),
                        'slide-top-small' => __('Slide Top Small', 'templaza-elements'),
                        'slide-bottom-small' => __('Slide Bottom Small', 'templaza-elements'),
                        'slide-left-small' => __('Slide Left Small', 'templaza-elements'),
                        'slide-right-small' => __('Slide Right Small', 'templaza-elements'),
                        'slide-top-medium' => __('Slide Top Medium', 'templaza-elements'),
                        'slide-bottom-medium' => __('Slide Bottom Medium', 'templaza-elements'),
                        'slide-left-medium' => __('Slide Left Medium', 'templaza-elements'),
                        'slide-right-medium' => __('Slide Right Medium', 'templaza-elements'),
                        'slide-top' => __('Slide Top 100%', 'templaza-elements'),
                        'slide-bottom' => __('Slide Bottom 100%', 'templaza-elements'),
                        'slide-left' => __('Slide Left 100%', 'templaza-elements'),
                        'slide-right' => __('Slide Right 100%', 'templaza-elements'),
                        'parallax' => __('Parallax', 'templaza-elements'),
                    ),
                    'default'           => '',

                ),
                array(
                    'type'          => Controls_Manager::SWITCHER,
                    'name'          => 'uk_animation_repeat',
                    'label'         => esc_html__('Repeat Animation', 'templaza-elements'),
                    'description'   => esc_html__('Applies the animation class every time the element is in view', 'templaza-elements'),
                    'label_on' => __( 'Yes', 'templaza-elements' ),
                    'label_off' => __( 'No', 'templaza-elements' ),
                    'return_value' => '1',
                    'default' => '0',
                    'conditions' => [
                        'relation' => 'and',
                        'terms' => [
                            ['name' => 'uk_animation', 'operator' => '!==', 'value' => ''],
                            ['name' => 'uk_animation', 'operator' => '!==', 'value' => 'parallax'],
                        ],
                    ],

                ),
                array(
                    'type'          => Controls_Manager::SWITCHER,
                    'name'          => 'uk_delay_element_animations',
                    'label'         => esc_html__('Delay Element Animations', 'templaza-elements'),
                    'description'   => esc_html__('Delay element animations so that animations are slightly delayed and don\'t play all at the same time. Slide animations can come into effect with a fixed offset or at 100% of the element\’s own size.', 'templaza-elements'),
                    'label_on' => __( 'Yes', 'templaza-elements' ),
                    'label_off' => __( 'No', 'templaza-elements' ),
                    'return_value' => '1',
                    'default' => '0',
                    'conditions' => [
                        'relation' => 'and',
                        'terms' => [
                            ['name' => 'uk_animation', 'operator' => '!==', 'value' => ''],
                            ['name' => 'uk_animation', 'operator' => '!==', 'value' => 'parallax'],
                        ],
                    ],

                ),
                array(
                    'name'          => 'horizontal_start',
                    'label' => __( 'Horizontal Start', 'templaza-elements' ),
                    'description'   => esc_html__('Animate the horizontal position (translateX) in pixels.', 'templaza-elements'),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => -600,
                            'max' => 600,
                            'step' => 1,
                        ],
                    ],
                    'separator'     => 'before',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'uk_animation', 'operator' => '===', 'value' => 'parallax'],
                        ],
                    ],

                ),
                array(
                    'name'          => 'horizontal_end',
                    'label' => __( 'Horizontal End', 'templaza-elements' ),
                    'description'   => esc_html__('Animate the horizontal position (translateX) in pixels.', 'templaza-elements'),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => -600,
                            'max' => 600,
                            'step' => 1,
                        ],
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'uk_animation', 'operator' => '===', 'value' => 'parallax'],
                        ],
                    ],

                ),
                array(
                    'name'          => 'vertical_start',
                    'label' => __( 'Vertical Start', 'templaza-elements' ),
                    'description'   => esc_html__('Animate the vertical position (translateY) in pixels.', 'templaza-elements'),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => -600,
                            'max' => 600,
                            'step' => 1,
                        ],
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'uk_animation', 'operator' => '===', 'value' => 'parallax'],
                        ],
                    ],

                ),
                array(
                    'name'          => 'vertical_end',
                    'label' => __( 'Vertical End', 'templaza-elements' ),
                    'description'   => esc_html__('Animate the vertical position (translateY) in pixels.', 'templaza-elements'),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => -600,
                            'max' => 600,
                            'step' => 1,
                        ],
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'uk_animation', 'operator' => '===', 'value' => 'parallax'],
                        ],
                    ],

                ),
                array(
                    'name'          => 'scale_start',
                    'label' => __( 'Scale Start', 'templaza-elements' ),
                    'description'   => esc_html__('Animate the scaling. Min: 50, Max: 200 =>  100 means 100% scale, 200 means 200% scale, and 50 means 50% scale.', 'templaza-elements'),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ '%'],
                    'range' => [
                        'px' => [
                            'min' => 50,
                            'max' => 200,
                            'step' => 1,
                        ],
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'uk_animation', 'operator' => '===', 'value' => 'parallax'],
                        ],
                    ],

                ),
                array(
                    'name'          => 'scale_end',
                    'label' => __( 'Scale End', 'templaza-elements' ),
                    'description'   => esc_html__('Animate the scaling. Min: 50, Max: 200 =>  100 means 100% scale, 200 means 200% scale, and 50 means 50% scale.', 'templaza-elements'),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ '%'],
                    'range' => [
                        'px' => [
                            'min' => 50,
                            'max' => 200,
                            'step' => 1,
                        ],
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'uk_animation', 'operator' => '===', 'value' => 'parallax'],
                        ],
                    ],

                ),
                array(
                    'name'          => 'rotate_start',
                    'label' => __( 'Rotate Start', 'templaza-elements' ),
                    'description'   => esc_html__('Animate the rotation clockwise in degrees.', 'templaza-elements'),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 360,
                            'step' => 1,
                        ],
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'uk_animation', 'operator' => '===', 'value' => 'parallax'],
                        ],
                    ],

                ),
                array(
                    'name'          => 'rotate_end',
                    'label' => __( 'Rotate End', 'templaza-elements' ),
                    'description'   => esc_html__('Animate the rotation clockwise in degrees.', 'templaza-elements'),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 360,
                            'step' => 1,
                        ],
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'uk_animation', 'operator' => '===', 'value' => 'parallax'],
                        ],
                    ],

                ),
                array(
                    'name'          => 'opacity_start',
                    'label' => __( 'Opacity Start', 'templaza-elements' ),
                    'description'   => esc_html__('Animate the opacity. 100 means 100% opacity, and 0 means 0% opacity.', 'templaza-elements'),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ '%'],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                            'step' => 1,
                        ],
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'uk_animation', 'operator' => '===', 'value' => 'parallax'],
                        ],
                    ],

                ),
                array(
                    'name'          => 'opacity_end',
                    'label' => __( 'Opacity End', 'templaza-elements' ),
                    'description'   => esc_html__('Animate the opacity. 100 means 100% opacity, and 0 means 0% opacity.', 'templaza-elements'),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ '%'],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                            'step' => 1,
                        ],
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'uk_animation', 'operator' => '===', 'value' => 'parallax'],
                        ],
                    ],

                ),
                array(
                    'name'          => 'easing',
                    'label' => __( 'Easing', 'templaza-elements' ),
                    'description'   => esc_html__('Set the animation easing. A value below 100 is faster in the beginning and slower towards the end while a value above 100 behaves inversely.', 'templaza-elements'),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => -200,
                            'max' => 200,
                            'step' => 1,
                        ],
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'uk_animation', 'operator' => '===', 'value' => 'parallax'],
                        ],
                    ],

                ),
                array(
                    'name'          => 'uk-viewport',
                    'label' => __( 'Viewport', 'templaza-elements' ),
                    'description'   => esc_html__('Set the animation end point relative to viewport height, e.g. 50 for 50% of the viewport', 'templaza-elements'),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ '%'],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                            'step' => 1,
                        ],
                    ],
                    'conditions' => [
                        'terms' => [
                            ['name' => 'uk_animation', 'operator' => '===', 'value' => 'parallax'],
                        ],
                    ],

                ),
                array(
                    'type'          => Controls_Manager::SWITCHER,
                    'name'          => 'parallax_target',
                    'label'         => esc_html__('Target', 'templaza-elements'),
                    'description'   => esc_html__('Animate the element as long as the section is visible.', 'templaza-elements'),
                    'label_on' => __( 'Yes', 'templaza-elements' ),
                    'label_off' => __( 'No', 'templaza-elements' ),
                    'return_value' => '1',
                    'default' => '0',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'uk_animation', 'operator' => '===', 'value' => 'parallax'],
                        ],
                    ],

                ),
                array(
                    'type'          => Controls_Manager::SWITCHER,
                    'name'          => 'parallax_zindex',
                    'label'         => esc_html__('Z Index', 'templaza-elements'),
                    'description'   => esc_html__('Set a higher stacking order.', 'templaza-elements'),
                    'label_on' => __( 'Yes', 'templaza-elements' ),
                    'label_off' => __( 'No', 'templaza-elements' ),
                    'return_value' => '1',
                    'default' => '0',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'uk_animation', 'operator' => '===', 'value' => 'parallax'],
                        ],
                    ],

                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'uk_breakpoint',
                    'label'         => esc_html__('Breakpoint', 'templaza-elements'),
                    'description'   => esc_html__('Display the parallax effect only on this device width and larger. It is useful to disable the parallax animation on small viewports.', 'templaza-elements'),
                    'options'       => array(
                        '' => __('Always', 'templaza-elements'),
                        's' => __('Small (Phone Landscape)', 'templaza-elements'),
                        'm' => __('Medium (Tablet Landscape)', 'templaza-elements'),
                        'l' => __('Large (Desktop)', 'templaza-elements'),
                        'xl' => __('X-Large (Large Screens)', 'templaza-elements'),
                    ),
                    'default'           => '',
                    'conditions' => [
                        'terms' => [
                            ['name' => 'uk_animation', 'operator' => '===', 'value' => 'parallax'],
                        ],
                    ],

                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'uk_visibility',
                    'label'         => esc_html__('Visibility', 'templaza-elements'),
                    'description'   => esc_html__('Display the element only on this device width and larger.', 'templaza-elements'),
                    'options'       => array(
                        '' => __('Always', 'templaza-elements'),
                        'uk-visible@s' => __('Small (Phone Landscape)', 'templaza-elements'),
                        'uk-visible@m' => __('Medium (Tablet Landscape)', 'templaza-elements'),
                        'uk-visible@l' => __('Large (Desktop)', 'templaza-elements'),
                        'uk-visible@xl' => __('X-Large (Large Screens)', 'templaza-elements'),
                        'uk-hidden@s' => __('Hidden Small (Phone Landscape)', 'templaza-elements'),
                        'uk-hidden@m' => __('Hidden Medium (Tablet Landscape)', 'templaza-elements'),
                        'uk-hidden@l' => __('Hidden Large (Desktop)', 'templaza-elements'),
                        'uk-hidden@xl' => __('Hidden X-Large (Large Screens)', 'templaza-elements'),
                    ),
                    'default'           => '',

                ),
            );
            static::$cache[$store_id] = $options = apply_filters( 'templaza-elements/settings-general-options', $options );
            return $options;
        }
    }
}