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
                    'heading'          => esc_html__( 'Visible Items', 'uipro' ),
                    'param_name'       => 'items_visible',
                    'std'              => '4',
                    'admin_label'      => true,
                    'edit_field_class' => 'vc_col-xs-4',
                ),

                array(
                    'type'             => 'number',
                    'heading'          => esc_html__( 'Tablet Items', 'uipro' ),
                    'param_name'       => 'items_tablet',
                    'std'              => '2',
                    'admin_label'      => true,
                    'edit_field_class' => 'vc_col-xs-4',
                ),

                array(
                    'type'             => 'number',
                    'heading'          => esc_html__( 'Mobile Items', 'uipro' ),
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

            $options = array( esc_html__( 'All Category', 'uipro' ) => '' );
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
                esc_html__( 'Select', 'uipro' ) => '',
                esc_html__( 'Normal', 'uipro' ) => 'normal',
                esc_html__( 'Bold', 'uipro' )   => 'bold',
                esc_html__( '100', 'uipro' )    => '100',
                esc_html__( '200', 'uipro' )    => '200',
                esc_html__( '300', 'uipro' )    => '300',
                esc_html__( '400', 'uipro' )    => '400',
                esc_html__( '500', 'uipro' )    => '500',
                esc_html__( '600', 'uipro' )    => '600',
                esc_html__( '700', 'uipro' )    => '700',
                esc_html__( '800', 'uipro' )    => '800',
                esc_html__( '900', 'uipro' )    => '900'
            );

            return apply_filters( 'templaza-elements/settings-font-weight', $font_weight );
        }

        /**
         * @return mixed
         */
        protected function _setting_tags() {

            $tags = array(
                esc_html__( 'Select tag', 'uipro' ) => '',
                esc_html__( 'h1', 'uipro' )         => 'h1',
                esc_html__( 'h2', 'uipro' )         => 'h2',
                esc_html__( 'h3', 'uipro' )         => 'h3',
                esc_html__( 'h4', 'uipro' )         => 'h4',
                esc_html__( 'h5', 'uipro' )         => 'h5',
                esc_html__( 'h6', 'uipro' )         => 'h6'
            );

            return apply_filters( 'templaza-elements/settings-tags', $tags );
        }

        /**
         * @return mixed
         */
        protected function _setting_text_transform() {

            $text_transform = array(
                esc_html__( 'None', 'uipro' )       => 'none',
                esc_html__( 'Capitalize', 'uipro' ) => 'capitalize',
                esc_html__( 'Uppercase', 'uipro' )  => 'uppercase',
                esc_html__( 'Lowercase', 'uipro' )  => 'lowercase',
            );

            return apply_filters( 'templaza-elements/settings-text-transform', $text_transform );
        }

        public function get_font_uikit() {
            $store_id   = md5(__METHOD__);
            if(isset(static::$cache[$store_id])){
                return static::$cache[$store_id];
            }

            $font_uikit = [
                ''  => __( 'Choose an icon...', 'uipro' ),
                'home' => __( 'Home', 'uipro' ),
                'sign-in' => __( 'Sign-in', 'uipro' ),
                'sign-out' => __( 'Sign-out', 'uipro' ),
                'user' => __( 'User', 'uipro' ),
                'users' => __( 'Users', 'uipro' ),
                'lock' => __( 'Lock', 'uipro' ),
                'unlock' => __( 'Unlock', 'uipro' ),
                'settings' => __( 'Settings', 'uipro' ),
                'cog' => __( 'Cog', 'uipro' ),
                'nut' => __( 'Nut', 'uipro' ),
                'comment' => __( 'Comment', 'uipro' ),
                'commenting' => __( 'Commenting', 'uipro' ),
                'comments' => __( 'Comments', 'uipro' ),
                'hashtag' => __( 'Hashtag', 'uipro' ),
                'tag' => __( 'Tag', 'uipro' ),
                'cart' => __( 'Cart', 'uipro' ),
                'credit-card' => __( 'Credit-card', 'uipro' ),
                'mail' => __( 'Mail', 'uipro' ),
                'receiver' => __( 'Receiver', 'uipro' ),
                'search' => __( 'Search', 'uipro' ),
                'location' => __( 'Location', 'uipro' ),
                'bookmark' => __( 'Bookmark', 'uipro' ),
                'code' => __( 'Code', 'uipro' ),
                'paint-bucket' => __( 'Paint-bucket', 'uipro' ),
                'camera' => __( 'Camera', 'uipro' ),
                'bell' => __( 'Bell', 'uipro' ),
                'bolt' => __( 'Bolt', 'uipro' ),
                'star' => __( 'Star', 'uipro' ),
                'heart' => __( 'Heart', 'uipro' ),
                'happy' => __( 'Happy', 'uipro' ),
                'lifesaver' => __( 'Lifesaver', 'uipro' ),
                'rss' => __( 'Rss', 'uipro' ),
                'social' => __( 'Social', 'uipro' ),
                'git-branch' => __( 'Git-branch', 'uipro' ),
                'git-fork' => __( 'Git-fork', 'uipro' ),
                'world' => __( 'World', 'uipro' ),
                'calendar' => __( 'Calendar', 'uipro' ),
                'clock' => __( 'Clock', 'uipro' ),
                'history' => __( 'History', 'uipro' ),
                'future' => __( 'Future', 'uipro' ),
                'pencil' => __( 'Pencil', 'uipro' ),
                'trash' => __( 'Trash', 'uipro' ),
                'move' => __( 'Move', 'uipro' ),
                'link' => __( 'Link', 'uipro' ),
                'question' => __( 'Question', 'uipro' ),
                'info' => __( 'Info', 'uipro' ),
                'warning' => __( 'Warning', 'uipro' ),
                'image' => __( 'Image', 'uipro' ),
                'thumbnails' => __( 'Thumbnails', 'uipro' ),
                'table' => __( 'Table', 'uipro' ),
                'list' => __( 'List', 'uipro' ),
                'menu' => __( 'Menu', 'uipro' ),
                'grid' => __( 'Grid', 'uipro' ),
                'more' => __( 'More', 'uipro' ),
                'more-vertical' => __( 'More-vertical', 'uipro' ),
                'plus' => __( 'Plus', 'uipro' ),
                'plus-circle' => __( 'Plus-circle', 'uipro' ),
                'minus' => __( 'Minus', 'uipro' ),
                'minus-circle' => __( 'Minus-circle', 'uipro' ),
                'close' => __( 'Close', 'uipro' ),
                'check' => __( 'Check', 'uipro' ),
                'ban' => __( 'Ban', 'uipro' ),
                'refresh' => __( 'Refresh', 'uipro' ),
                'play' => __( 'Play', 'uipro' ),
                'play-circle' => __( 'Play-circle', 'uipro' ),
                'tv' => __( 'Tv', 'uipro' ),
                'desktop' => __( 'Desktop', 'uipro' ),
                'laptop' => __( 'Laptop', 'uipro' ),
                'tablet' => __( 'Tablet', 'uipro' ),
                'phone' => __( 'Phone', 'uipro' ),
                'tablet-landscape' => __( 'Tablet-landscape', 'uipro' ),
                'phone-landscape' => __( 'Phone-landscape', 'uipro' ),
                'file' => __( 'File', 'uipro' ),
                'copy' => __( 'Copy', 'uipro' ),
                'file-edit' => __( 'File-edit', 'uipro' ),
                'folder' => __( 'Folder', 'uipro' ),
                'album' => __( 'Album', 'uipro' ),
                'push' => __( 'Push', 'uipro' ),
                'pull' => __( 'Pull', 'uipro' ),
                'server' => __( 'Server', 'uipro' ),
                'database' => __( 'Database', 'uipro' ),
                'cloud-upload' => __( 'Cloud-upload', 'uipro' ),
                'cloud-download' => __( 'Cloud-download', 'uipro' ),
                'download' => __( 'Download', 'uipro' ),
                'upload' => __( 'Upload', 'uipro' ),
                'reply' => __( 'Reply', 'uipro' ),
                'forward' => __( 'Forward', 'uipro' ),
                'expand' => __( 'Expand', 'uipro' ),
                'shrink' => __( 'Shrink', 'uipro' ),
                'arrow-up' => __( 'Arrow-up', 'uipro' ),
                'arrow-down' => __( 'Arrow-down', 'uipro' ),
                'arrow-left' => __( 'Arrow-left', 'uipro' ),
                'arrow-right' => __( 'Arrow-right', 'uipro' ),
                'chevron-up' => __( 'Chevron-up', 'uipro' ),
                'chevron-down' => __( 'Chevron-down', 'uipro' ),
                'chevron-left' => __( 'Chevron-left', 'uipro' ),
                'chevron-right' => __( 'Chevron-right', 'uipro' ),
                'triangle-up' => __( 'Triangle-up', 'uipro' ),
                'triangle-down' => __( 'Triangle-down', 'uipro' ),
                'triangle-left' => __( 'Triangle-left', 'uipro' ),
                'triangle-right' => __( 'Triangle-right', 'uipro' ),
                'bold' => __( 'Bold', 'uipro' ),
                'italic' => __( 'Italic', 'uipro' ),
                'strikethrough' => __( 'Strikethrough', 'uipro' ),
                'video-camera' => __( 'Video-camera', 'uipro' ),
                'quote-right' => __( 'Quote-right', 'uipro' ),
                '500px' => __( '500px', 'uipro' ),
                'behance' => __( 'Behance', 'uipro' ),
                'dribbble' => __( 'Dribbble', 'uipro' ),
                'facebook' => __( 'Facebook', 'uipro' ),
                'flickr' => __( 'Flickr', 'uipro' ),
                'foursquare' => __( 'Foursquare', 'uipro' ),
                'github' => __( 'Github', 'uipro' ),
                'github-alt' => __( 'Github-alt', 'uipro' ),
                'gitter' => __( 'Gitter', 'uipro' ),
                'google' => __( 'Google', 'uipro' ),
                'google-plus' => __( 'Google-plus', 'uipro' ),
                'instagram' => __( 'Instagram', 'uipro' ),
                'joomla' => __( 'Joomla', 'uipro' ),
                'linkedin' => __( 'Linkedin', 'uipro' ),
                'pagekit' => __( 'Pagekit', 'uipro' ),
                'pinterest' => __( 'Pinterest', 'uipro' ),
                'soundcloud' => __( 'Soundcloud', 'uipro' ),
                'tripadvisor' => __( 'Tripadvisor', 'uipro' ),
                'tumblr' => __( 'Tumblr', 'uipro' ),
                'twitter' => __( 'Twitter', 'uipro' ),
                'uikit' => __( 'Uikit', 'uipro' ),
                'etsy' => __( 'Etsy', 'uipro' ),
                'vimeo' => __( 'Vimeo', 'uipro' ),
                'whatsapp' => __( 'Whatsapp', 'uipro' ),
                'wordpress' => __( 'Wordpress', 'uipro' ),
                'xing' => __( 'Xing', 'uipro' ),
                'yelp' => __( 'Yelp', 'uipro' ),
                'youtube' => __( 'Youtube', 'uipro' ),
                'print' => __( 'Print', 'uipro' ),
                'reddit' => __( 'Reddit', 'uipro' ),
                'file-text' => __( 'File Text', 'uipro' ),
                'file-pdf' => __( 'File Pdf', 'uipro' ),
                'chevron-double-left' => __( 'Chevron Double Left', 'uipro' ),
                'chevron-double-right' => __( 'Chevron Double Right', 'uipro' ),
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
                    'label'         => esc_html__('Margin Top', 'uipro'),
                    'description'   => esc_html__('Set the top margin.', 'uipro'),
                    'options'       => array(
                        '' => __('Keep existing', 'uipro'),
                        'small' => __('Small', 'uipro'),
                        'default' => __('Default', 'uipro'),
                        'medium' => __('Medium', 'uipro'),
                        'large' => __('Large', 'uipro'),
                        'xlarge' => __('X-Large', 'uipro'),
                        'remove' => __('None', 'uipro'),
                    ),
                    'default'           => '',
                    'start_section' => 'general',
                    'section_name'      => esc_html__('General Settings', 'uipro')
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'addon_margin_bottom',
                    'label'         => esc_html__('Margin Bottom', 'uipro'),
                    'description'   => esc_html__('Set the bottom margin.', 'uipro'),
                    'options'       => array(
                        '' => __('Keep existing', 'uipro'),
                        'small' => __('Small', 'uipro'),
                        'default' => __('Default', 'uipro'),
                        'medium' => __('Medium', 'uipro'),
                        'large' => __('Large', 'uipro'),
                        'xlarge' => __('X-Large', 'uipro'),
                        'remove' => __('None', 'uipro'),
                    ),
                    'default'           => '',
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'uk_container',
                    'label'         => esc_html__('Container', 'uipro'),
                    'description'   => esc_html__('Add the uk-container class to widget to give it a max-width and wrap the main content', 'uipro'),
                    'options'       => array(
                        '' => __('None', 'uipro'),
                        'default' => __('Default', 'uipro'),
                        'xsmall' => __('X-Small', 'uipro'),
                        'small' => __('Small', 'uipro'),
                        'large' => __('Large', 'uipro'),
                        'xlarge' => __('X-Large', 'uipro'),
                        'expand' => __('Expand', 'uipro'),
                    ),
                    'default'           => '',
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'addon_max_width',
                    'label'         => esc_html__('Max Width', 'uipro'),
                    'description'   => esc_html__('Set the maximum content width.', 'uipro'),
                    'options'       => array(
                        '' => __('None', 'uipro'),
                        'small' => __('Small', 'uipro'),
                        'medium' => __('Medium', 'uipro'),
                        'large' => __('Large', 'uipro'),
                        'xlarge' => __('X-Large', 'uipro'),
                        '2xlarge' => __('2X-Large', 'uipro'),
                    ),
                    'default'           => '',
                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'addon_max_width_breakpoint',
                    'label'         => esc_html__('Max Width Breakpoint', 'uipro'),
                    'description'   => esc_html__('Define the device width from which the element\'s max-width will apply.', 'uipro'),
                    'options'       => array(
                        '' => __('Always', 'uipro'),
                        's' => __('Small (Phone Landscape)', 'uipro'),
                        'm' => __('Medium (Tablet Landscape)', 'uipro'),
                        'l' => __('Large (Desktop)', 'uipro'),
                        'xl' => __('X-Large (Large Screens)', 'uipro'),
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
                    'label'         => esc_html__('Block Alignment', 'uipro'),
                    'description'   => esc_html__('Define the alignment in case the container exceeds the element\'s max-width.', 'uipro'),
                    'options'       => array(
                        ''=>__('Left', 'uipro'),
                        'center'=>__('Center', 'uipro'),
                        'right'=>__('Right', 'uipro'),
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
                    'label'         => esc_html__('Block Alignment Breakpoint', 'uipro'),
                    'description'   => esc_html__('Define the device width from which the alignment will apply.', 'uipro'),
                    'options'       => array(
                        ''=>__('Always', 'uipro'),
                        's'=>__('Small (Phone Landscape)', 'uipro'),
                        'm'=>__('Medium (Tablet Landscape)', 'uipro'),
                        'l'=>__('Large (Desktop)', 'uipro'),
                        'xl'=>__('X-Large (Large Screens)', 'uipro'),
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
                    'label'         => esc_html__('Block Alignment Fallback', 'uipro'),
                    'description'   => esc_html__('Define the alignment in case the container exceeds the element\'s max-width.', 'uipro'),
                    'options'       => array(
                        ''=>__('Left', 'uipro'),
                        'center'=>__('Center', 'uipro'),
                        'right'=>__('Right', 'uipro'),
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
                    'label'         => esc_html__('Text Alignment', 'uipro'),
                    'description'   => esc_html__('Center, left and right alignment may depend on a breakpoint and require a fallback.', 'uipro'),
                    'options'       => array(
                        '' => __('None', 'uipro'),
                        'left' => __('Left', 'uipro'),
                        'center' => __('Center', 'uipro'),
                        'right' => __('Right', 'uipro'),
                    ),
                    'default'           => '',

                ),
                array(
                    'type'          => Controls_Manager::SELECT,
                    'name'          => 'text_alignment_breakpoint',
                    'label'         => esc_html__('Text Alignment Breakpoint', 'uipro'),
                    'description'   => esc_html__('Display the button alignment only on this device width and larger', 'uipro'),
                    'options'       => array(
                        '' => __('Always', 'uipro'),
                        's' => __('Small (Phone Landscape)', 'uipro'),
                        'm' => __('Medium (Tablet Landscape)', 'uipro'),
                        'l' => __('Large (Desktop)', 'uipro'),
                        'xl' => __('X-Large (Large Screens)', 'uipro'),
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
                    'label'         => esc_html__('Text Alignment Fallback', 'uipro'),
                    'description'   => esc_html__('Define an alignment fallback for device widths below the breakpoint.', 'uipro'),
                    'options'       => array(
                        '' => __('None', 'uipro'),
                        'left' => __('Left', 'uipro'),
                        'center' => __('Center', 'uipro'),
                        'right' => __('Right', 'uipro'),
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
                    'label'         => esc_html__('Animation', 'uipro'),
                    'description'   => esc_html__('A collection of smooth animations to use within your page.', 'uipro'),
                    'options'       => array(
                        '' => __('Inherit', 'uipro'),
                        'fade' => __('Fade', 'uipro'),
                        'scale-up' => __('Scale Up', 'uipro'),
                        'scale-down' => __('Scale Down', 'uipro'),
                        'slide-top-small' => __('Slide Top Small', 'uipro'),
                        'slide-bottom-small' => __('Slide Bottom Small', 'uipro'),
                        'slide-left-small' => __('Slide Left Small', 'uipro'),
                        'slide-right-small' => __('Slide Right Small', 'uipro'),
                        'slide-top-medium' => __('Slide Top Medium', 'uipro'),
                        'slide-bottom-medium' => __('Slide Bottom Medium', 'uipro'),
                        'slide-left-medium' => __('Slide Left Medium', 'uipro'),
                        'slide-right-medium' => __('Slide Right Medium', 'uipro'),
                        'slide-top' => __('Slide Top 100%', 'uipro'),
                        'slide-bottom' => __('Slide Bottom 100%', 'uipro'),
                        'slide-left' => __('Slide Left 100%', 'uipro'),
                        'slide-right' => __('Slide Right 100%', 'uipro'),
                        'parallax' => __('Parallax', 'uipro'),
                    ),
                    'default'           => '',

                ),
                array(
                    'type'          => Controls_Manager::SWITCHER,
                    'name'          => 'uk_animation_repeat',
                    'label'         => esc_html__('Repeat Animation', 'uipro'),
                    'description'   => esc_html__('Applies the animation class every time the element is in view', 'uipro'),
                    'label_on' => __( 'Yes', 'uipro' ),
                    'label_off' => __( 'No', 'uipro' ),
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
                    'label'         => esc_html__('Delay Element Animations', 'uipro'),
                    'description'   => esc_html__('Delay element animations so that animations are slightly delayed and don\'t play all at the same time. Slide animations can come into effect with a fixed offset or at 100% of the element\’s own size.', 'uipro'),
                    'label_on' => __( 'Yes', 'uipro' ),
                    'label_off' => __( 'No', 'uipro' ),
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
                    'label' => __( 'Horizontal Start', 'uipro' ),
                    'description'   => esc_html__('Animate the horizontal position (translateX) in pixels.', 'uipro'),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => -2000,
                            'max' => 2000,
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
                    'label' => __( 'Horizontal End', 'uipro' ),
                    'description'   => esc_html__('Animate the horizontal position (translateX) in pixels.', 'uipro'),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => -2000,
                            'max' => 2000,
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
                    'label' => __( 'Vertical Start', 'uipro' ),
                    'description'   => esc_html__('Animate the vertical position (translateY) in pixels.', 'uipro'),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => -2000,
                            'max' => 2000,
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
                    'label' => __( 'Vertical End', 'uipro' ),
                    'description'   => esc_html__('Animate the vertical position (translateY) in pixels.', 'uipro'),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => -2000,
                            'max' => 2000,
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
                    'label' => __( 'Scale Start', 'uipro' ),
                    'description'   => esc_html__('Animate the scaling. Min: 50, Max: 200 =>  100 means 100% scale, 200 means 200% scale, and 50 means 50% scale.', 'uipro'),
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
                    'label' => __( 'Scale End', 'uipro' ),
                    'description'   => esc_html__('Animate the scaling. Min: 50, Max: 200 =>  100 means 100% scale, 200 means 200% scale, and 50 means 50% scale.', 'uipro'),
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
                    'label' => __( 'Rotate Start', 'uipro' ),
                    'description'   => esc_html__('Animate the rotation clockwise in degrees.', 'uipro'),
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
                    'label' => __( 'Rotate End', 'uipro' ),
                    'description'   => esc_html__('Animate the rotation clockwise in degrees.', 'uipro'),
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
                    'label' => __( 'Opacity Start', 'uipro' ),
                    'description'   => esc_html__('Animate the opacity. 100 means 100% opacity, and 0 means 0% opacity.', 'uipro'),
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
                    'label' => __( 'Opacity End', 'uipro' ),
                    'description'   => esc_html__('Animate the opacity. 100 means 100% opacity, and 0 means 0% opacity.', 'uipro'),
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
                    'label' => __( 'Easing', 'uipro' ),
                    'description'   => esc_html__('Set the animation easing. A value below 100 is faster in the beginning and slower towards the end while a value above 100 behaves inversely.', 'uipro'),
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
                    'label' => __( 'Viewport', 'uipro' ),
                    'description'   => esc_html__('Set the animation end point relative to viewport height, e.g. 50 for 50% of the viewport', 'uipro'),
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
                    'label'         => esc_html__('Target', 'uipro'),
                    'description'   => esc_html__('Animate the element as long as the section is visible.', 'uipro'),
                    'label_on' => __( 'Yes', 'uipro' ),
                    'label_off' => __( 'No', 'uipro' ),
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
                    'label'         => esc_html__('Z Index', 'uipro'),
                    'description'   => esc_html__('Set a higher stacking order.', 'uipro'),
                    'label_on' => __( 'Yes', 'uipro' ),
                    'label_off' => __( 'No', 'uipro' ),
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
                    'label'         => esc_html__('Breakpoint', 'uipro'),
                    'description'   => esc_html__('Display the parallax effect only on this device width and larger. It is useful to disable the parallax animation on small viewports.', 'uipro'),
                    'options'       => array(
                        '' => __('Always', 'uipro'),
                        's' => __('Small (Phone Landscape)', 'uipro'),
                        'm' => __('Medium (Tablet Landscape)', 'uipro'),
                        'l' => __('Large (Desktop)', 'uipro'),
                        'xl' => __('X-Large (Large Screens)', 'uipro'),
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
                    'label'         => esc_html__('Visibility', 'uipro'),
                    'description'   => esc_html__('Display the element only on this device width and larger.', 'uipro'),
                    'options'       => array(
                        '' => __('Always', 'uipro'),
                        'uk-visible@s' => __('Small (Phone Landscape)', 'uipro'),
                        'uk-visible@m' => __('Medium (Tablet Landscape)', 'uipro'),
                        'uk-visible@l' => __('Large (Desktop)', 'uipro'),
                        'uk-visible@xl' => __('X-Large (Large Screens)', 'uipro'),
                        'uk-hidden@s' => __('Hidden Small (Phone Landscape)', 'uipro'),
                        'uk-hidden@m' => __('Hidden Medium (Tablet Landscape)', 'uipro'),
                        'uk-hidden@l' => __('Hidden Large (Desktop)', 'uipro'),
                        'uk-hidden@xl' => __('Hidden X-Large (Large Screens)', 'uipro'),
                    ),
                    'default'           => '',

                ),
            );
            static::$cache[$store_id] = $options = apply_filters( 'templaza-elements/settings-general-options', $options );
            return $options;
        }
    }
}