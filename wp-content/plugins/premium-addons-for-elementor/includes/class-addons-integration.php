<?php

namespace PremiumAddons;

if( ! defined( 'ABSPATH' ) ) exit();

class Premium_Addons_Integration {
    
    private static $instance = null;
    
    public static $frontend = null;
    
    /**
    * Initialize integration hooks
    *
    * @return void
    */
    public function __construct() {
        
        add_action( 'elementor/editor/before_enqueue_styles', array( $this, 'premium_font_setup' ) );
        
        add_action( 'elementor/widgets/widgets_registered', array( $this, 'widgets_area' ) );
        
        add_action( 'elementor/editor/before_enqueue_scripts', array( $this,'enqueue_editor_scripts') );
        
        add_action( 'elementor/preview/enqueue_styles', array( $this, 'enqueue_preview_styles' ) );
        
        add_action( 'elementor/frontend/after_register_styles', array( $this, 'register_frontend_styles' ) );
        
        add_action( 'elementor/frontend/after_enqueue_styles', array( $this, 'enqueue_frontend_styles' ) );
        
        add_action( 'elementor/frontend/after_register_scripts', array( $this, 'register_frontend_scripts' ) );
            
        //add_action( 'wp_enqueue_scripts', array( $this, 'premium_maps_required_script' ) );
        
        
        add_action( 'wp_ajax_get_elementor_template_content', array( $this, 'get_template_content' ) );
        
//        if( defined('ELEMENTOR_VERSION') ) {
//            self::$frontend = new \Elementor\Frontend;
//        }
    }
    
    /**
    * Loads plugin icons font
    * @since 1.0.0
    * @access public
    * @return void
    */
    public function premium_font_setup() {
        wp_enqueue_style(
            'premium-addons-font',
            PREMIUM_ADDONS_URL . 'admin/assets/pa-elements-font/css/pa-elements.css'
        );
        
        $badge_text = \PremiumAddons\Helper_Functions::get_badge();
        
        $dynamic_css = sprintf( '[class^="pa-"]::after, [class*=" pa-"]::after { content: "%s"; }', $badge_text ) ;

        wp_add_inline_style( 'premium-addons-font',  $dynamic_css );
        
    }
    
    /** 
    * Register Frontend CSS files
    * @since 2.9.0
    * @access public
    */
    public function register_frontend_styles() {
        
        wp_register_style(
            'pa-prettyphoto',
            PREMIUM_ADDONS_URL . 'assets/css/prettyphoto.css',
            array(),
            PREMIUM_ADDONS_VERSION,
            'all'
        );
        
    }
    
    /**
     * Enqueue Preview CSS files
     * 
     * @since 2.9.0
     * @access public
     * 
     */
    public function enqueue_preview_styles() {
        
        wp_enqueue_style('pa-prettyphoto');
     
    }
    
    /** 
     * Enqueue Widgets` CSS file
     * 
     * @since 2.9.0
     * @access public
     */
    public function enqueue_frontend_styles() {
        
        wp_enqueue_style(
            'premium-addons',
            PREMIUM_ADDONS_URL . 'assets/css/premium-addons.css',
            array(),
            PREMIUM_ADDONS_VERSION,
            'all'
        );
        
    }
    
    /** 
     * Load widgets require function
     * 
     * @since 1.0.0
     * @access public
     * 
     */
    public function widgets_area() {
        $this->widgets_register();
    }
    
    /**
     * Requires widgets files
     * 
     * @since 1.0.0
     * @access private
     */
    private function widgets_register() {

        $check_component_active = PA_Elements_Settings::get_enabled_keys();
        
        foreach ( glob( PREMIUM_ADDONS_PATH . 'widgets/' . '*.php' ) as $file ) {
            
            $slug = basename( $file, '.php' );
            
            $enabled = isset( $check_component_active[ $slug ] ) ? $check_component_active[ $slug ] : '';
            
            if ( filter_var( $enabled, FILTER_VALIDATE_BOOLEAN ) || ! $check_component_active ) {
                $this->register_addon( $file );
            }
        }

    }
    
    /**
     * Registers required JS files
     * 
     * @since 1.0.0
     * @access public
    */
    public function register_frontend_scripts() {
        
        $maps_settings = PA_Maps::get_enabled_keys();
        
        wp_register_script(
            'premium-addons-js',
            PREMIUM_ADDONS_URL . 'assets/js/premium-addons.js',
            array('jquery'),
            PREMIUM_ADDONS_VERSION,
            true
        );
        
        wp_register_script(
            'prettyPhoto-js',
            PREMIUM_ADDONS_URL . 'assets/js/lib/prettyPhoto.js',
            array('jquery'),
            PREMIUM_ADDONS_VERSION,
            true
        );
        
        wp_register_script(
            'vticker-js',
            PREMIUM_ADDONS_URL . 'assets/js/lib/Vticker.js',
            array('jquery'),
            PREMIUM_ADDONS_VERSION,
            true
        );
        wp_register_script(
            'typed-js',
            PREMIUM_ADDONS_URL . 'assets/js/lib/typedmin.js',
            array('jquery'),
            PREMIUM_ADDONS_VERSION,
            true
        );
        
        wp_register_script(
            'count-down-timer-js',
            PREMIUM_ADDONS_URL . 'assets/js/lib/jquerycountdown.js',
            array('jquery'),
            PREMIUM_ADDONS_VERSION,
            true
        );
       
        wp_register_script(
            'isotope-js',
            PREMIUM_ADDONS_URL . 'assets/js/lib/isotope.js',
            array('jquery'),
            PREMIUM_ADDONS_VERSION,
            true
        );

        wp_register_script(
            'modal-js',
            PREMIUM_ADDONS_URL . 'assets/js/lib/modal.js',
            array('jquery'),
            PREMIUM_ADDONS_VERSION,
            true
        );
        
        if( $maps_settings['premium-map-cluster'] ) {
            wp_register_script(
                'google-maps-cluster',
                'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js',
                array(),
                PREMIUM_ADDONS_VERSION,
                false
            );
        }
        
        
        wp_register_script(
            'premium-maps-api-js',
            'https://maps.googleapis.com/maps/api/js?key=' . $maps_settings['premium-map-api'],
            array(),
            PREMIUM_ADDONS_VERSION,
            false
        );

        wp_register_script(
            'premium-maps-js',
            PREMIUM_ADDONS_URL . 'assets/js/premium-maps.js',
            array( 'jquery', 'premium-maps-api-js' ),
            PREMIUM_ADDONS_VERSION,
            true
        );

        wp_register_script( 
            'vscroll-js',
            PREMIUM_ADDONS_URL . 'assets/js/premium-vscroll.js',
            array('jquery'),
            PREMIUM_ADDONS_VERSION,
            true
        );
        
//        wp_register_script( 
//            'scrollify-js',
//            PREMIUM_ADDONS_URL . 'assets/js/lib/scrollify.js',
//            array('jquery'),
//            PREMIUM_ADDONS_VERSION,
//            true
//        );
        
    }
    
    /*
     * Enqueue editor scripts
     * 
     * @since 3.2.5
     * @access public
     */
    public function enqueue_editor_scripts() {
        
        $premium_maps_api = PA_Maps::get_enabled_keys()['premium-map-api'];

        $premium_maps_disable_api = PA_Maps::get_enabled_keys()['premium-map-disable-api'];
        
        $map_enabled = PA_Elements_Settings::get_enabled_keys()['premium-maps'];
        
        $premium_maps_enabled = isset( $map_enabled ) ? $map_enabled : 1;

        if ( $premium_maps_disable_api ) {

            wp_enqueue_script(
                'premium-maps-api-js',
                'https://maps.googleapis.com/maps/api/js?key=' . $premium_maps_api,
                array(),
                PREMIUM_ADDONS_VERSION,
                false
            );

        }

        if( $premium_maps_enabled ) {

            wp_enqueue_script(
                'premium-maps-address',
                PREMIUM_ADDONS_URL . 'assets/js/premium-maps-address.js',
                array( 'jquery' ),
                PREMIUM_ADDONS_VERSION,
                true
            );

        }

    }
    
    /*
     * Get Template Content
     * 
     * Get Elementor template HTML content.
     * 
     * @since 3.2.6
     * @access public
     * 
     */
    public function get_template_content() {
        
        self::$frontend = new \Elementor\Frontend;
        
        $template_id = $_GET['templateID'];
        
        if( ! isset( $template_id ) ) {
            return;
        }
        
        $template_content = self::$frontend->get_builder_content( $template_id, true );
        
        if ( empty ( $template_content ) || ! isset( $template_content ) ) {
            wp_send_json_error();
        }
        
        $data = array(
            'template_content'  => $template_content
        );
        
        wp_send_json_success( $data );
        
    }
    
    /**
     * 
     * Register addon by file name.
     * 
     * @access public
     *
     * @param  string $file            File name.
     * @param  object $widgets_manager Widgets manager instance.
     * 
     * @return void
     */
    public function register_addon( $file ) {
        
        $base  = basename( str_replace( '.php', '', $file ) );
        $class = ucwords( str_replace( '-', ' ', $base ) );
        $class = str_replace( ' ', '_', $class );
        $class = sprintf( 'Elementor\%s', $class );
        
        if( 'Elementor\Premium_Contactform' != $class ){
            require $file;
        } else {
            if( function_exists('wpcf7') ) {
                require $file;
            }
        }
        
        if ( 'Elementor\Premium_Blog' == $class ) {
            require_once ( PREMIUM_ADDONS_PATH . 'queries.php' );
        }

        if ( class_exists( $class ) ) {
            \Elementor\PLUGIN::instance()->widgets_manager->register_widget_type( new $class );
        }
    }
    
    /**
     * 
     * Creates and returns an instance of the class
     * 
     * @since 1.0.0
     * @access public
     * 
     * @return object
     * 
     */
   public static function get_instance() {
       if( self::$instance == null ) {
           self::$instance = new self;
       }
       return self::$instance;
   }
}
    

if ( ! function_exists( 'premium_addons_integration' ) ) {

	/**
	 * Returns an instance of the plugin class.
	 * @since  1.0.0
	 * @return object
	 */
	function premium_addons_integration() {
		return Premium_Addons_Integration::get_instance();
	}
}
premium_addons_integration();