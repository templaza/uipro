<?php

namespace UIPro\Elementor\Control;

use UIPro\Elementor\Control\Helper\UIAutoComplete_Helper;
use UIPro\UIPro_Functions;

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit;

class UIAutoComplete extends \Elementor\Base_Data_Control {
    /**
     * Instance
     *
     * @access private
     */
    private static $_instance = null;

    /**
     * Instance
     *
     * Ensures only one instance of the class is loaded or can be loaded.
     *
     * @return object.
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function __construct()
    {
        parent::__construct();

        add_action( 'wp_ajax_ui_get_autocomplete_suggest', [ $this, 'ui_get_autocomplete_suggest' ] );
        add_action( 'wp_ajax_ui_get_autocomplete_render', [ $this, 'ui_get_autocomplete_render' ] );
    }

    /**
     * Get heading control type.
     *
     * Retrieve the control type, in this case `heading`.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Control type.
     */
    public function get_type() {
        return 'uiautocomplete';
    }

    /**
     * Enqueue Script & Style
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function enqueue() {
        // Styles
        wp_register_style( 'uiautocomplete', UIPro_Functions::get_my_url().'/controls/'
            .$this -> get_type(). '/assets/css/style.css', [], UIPro_Functions::get_my_version() );
        wp_enqueue_style( 'uiautocomplete' );

        // Scripts
        wp_register_script( 'uiautocomplete', UIPro_Functions::get_my_url().'/controls/'
            .$this -> get_type(). '/assets/js/script.js', [
            'jquery',
            'jquery-ui-autocomplete',
            'jquery-ui-sortable'
        ], UIPro_Functions::get_my_version(), true );
        wp_enqueue_script( 'uiautocomplete' );
    }

    /**
     * Get heading control default settings.
     *
     * Retrieve the default settings of the heading control. Used to return the
     * default settings while initializing the heading control.
     *
     * @since  1.0.0
     * @access protected
     *
     * @return array Control default settings.
     */
    protected function get_default_settings() {
        return [
            'multiple'      => false,
            'sortable'      => false,
//            'source'   => array(
//                'taxonomy'  => 'category',
//                'post_type' => 'posts',
//            ) // post type or taxonomy
            'source'        => 'post', // post type or taxonomy
            'source_type'   => 'post_type'
        ];
    }

    /**
     * Render heading control output in the editor.
     *
     * Used to generate the control HTML in the editor using Underscore JS
     * template. The variables for the class are available using `data` JS
     * object.
     *
     * @since  1.0.0
     * @access public
     */
    public function content_template() {
        $control_uid = $this->get_control_uid();
        ?>
        <div class="elementor-control-field">
            <# if ( data.label ) {#>
            <label for="<?php echo $control_uid; ?>" class="elementor-control-title">{{{ data.label }}}</label>
            <# } #>
            <div class="elementor-control-input-wrapper">
                <ul class="ui_autocomplete">
                    <li class="ui_autocomplete-input">
                        <input class="ui_autocomplete_param" type="text" placeholder="{{ data.placeholder }}"/>
                        <input class="ui_autocomplete_value" type="hidden" data-source="{{data.source}}"
                               data-source_type="{{data.source_type}}"
                               data-multiple="{{data.multiple}}"
                               data-sortable="{{data.sortable}}" value="{{data.controlValue}}"/>
                        <span class="loading"></span>
                    </li>

                    <li class="ui_autocomplete-loading">
                        <span class="loading"></span>
                    </li>
                    <?php
                    ?>
                </ul>

            </div>
        </div>
        <# if ( data.description ) { #>
        <div class="elementor-control-field-description">{{{ data.description }}}</div>
        <# } #>
        <?php
    }

    public function ui_get_autocomplete_suggest(){

        require_once __DIR__.'/helpers/uiautocomplete_helper.php';

        $source         = $_POST && isset( $_POST['source'] ) ? $_POST['source'] : '';
        $source_type    = $_POST && isset( $_POST['source_type'] ) ? $_POST['source_type'] : '';
        $query          = $_POST && isset( $_POST['term'] ) ? $_POST['term'] : '';

        $data   = call_user_func_array('UIPro\Elementor\Control\Helper\UIAutoComplete_Helper::'
            . $source_type.'_callback', array($source, $query));

        $data   = !empty($data)?$data:array();

        wp_send_json_success( $data );

        die();
    }

    public function ui_get_autocomplete_render(){

        require_once __DIR__.'/helpers/uiautocomplete_helper.php';

        $source         = $_POST && isset( $_POST['source'] ) ? $_POST['source'] : '';
        $source_type    = $_POST && isset( $_POST['source_type'] ) ? $_POST['source_type'] : '';
        $query          = $_POST && isset( $_POST['term'] ) ? $_POST['term'] : '';

        $data   = call_user_func_array('UIPro\Elementor\Control\Helper\UIAutoComplete_Helper::'
            .$source_type.'_render', array($source, $query));

        $data   = !empty($data)?$data:array();

        wp_send_json_success( $data );

        die();
    }
}
