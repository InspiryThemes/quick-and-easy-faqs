<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 */
if ( ! class_exists( 'Quick_And_Easy_FAQs_Admin' ) ) {

    class Quick_And_Easy_FAQs_Admin {

        /**
         * The ID of this plugin.
         */
        private $plugin_name;

        /**
         * The version of this plugin.
         */
        private $version;

        /**
         * The domain specified for this plugin.
         */
        private $domain;

        protected static $_instance;

        /**
         * Initialize the class and set its properties.
         */
        public function __construct() {

            $this->plugin_name = QE_FAQS_PLUGIN_NAME;
            $this->version = QE_FAQS_PLUGIN_VERSION;
            $this->domain = QE_FAQS_PLUGIN_NAME;
            $this->admin_hooks_execution();

        }

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        public function admin_hooks_execution() {
            register_activation_hook( __FILE__, array( $this, 'faqs_activation' ) ); 
            register_deactivation_hook( __FILE__, array( $this, 'faqs_deactivation' ) );

            add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_styles' ) );
            add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
            add_action( 'plugins_loaded', array( $this, 'faqs_load_textdomain' ) );
        }

        /**
         * The code that runs during plugin activation.
         * This action is documented in includes/class-quick-and-easy-faqs-activator.php
         */
        public function faqs_activation() {
            
        }

        /**
         * The code that runs during plugin deactivation.
         * This action is documented in includes/class-quick-and-easy-faqs-deactivator.php
         */
        public function faqs_deactivation() {
            
        }

        /**
         * Load the plugin text domain for translation.
         */
        public function faqs_load_textdomain() {

            load_plugin_textdomain(
                $this->domain,
                false, 
                dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
            );

        }

        /**
         * Register the stylesheets for the admin area.
         */
        public function admin_enqueue_styles() {
            // Add the color picker css file
            wp_enqueue_style( 'wp-color-picker' );
            // plugin custom css file
            wp_enqueue_style( $this->plugin_name, dirname( plugin_dir_url( __FILE__ ) ) . '/css/styles-admin.css', array( 'wp-color-picker' ), $this->version, 'all' );
        }

        /**
         * Register the JavaScript for the admin area.
         */
        public function admin_enqueue_scripts() {
            wp_enqueue_script( $this->plugin_name, dirname( plugin_dir_url( __FILE__ ) ) . '/js/admin-scripts.js', array( 'jquery' , 'wp-color-picker' ), $this->version, false );
        }
        
        /**
         * To log any thing for debugging purposes
         */
        public static function log( $message ) {
            if( WP_DEBUG === true ){
                if( is_array( $message ) || is_object( $message ) ){
                    error_log( print_r( $message, true ) );
                } else {
                    error_log( $message );
                }
            }
        }

    }
}

/**
 * Returns the main instance of Quick_And_Easy_FAQs_Admin to prevent the need to use globals.
 */
function init_qe_faqs_admin() {
	return Quick_And_Easy_FAQs_Admin::instance();
}

/**
 * Get it running
 */
init_qe_faqs_admin();

add_action('pre_get_posts', 'inspiry_push_faq_to_search_results', 99);

function inspiry_push_faq_to_search_results( $query ) {

    if ( is_search() && $query->is_main_query() && $query->get( 's' ) ) :

        $post_types = $query->get('post_type');

            if ( empty( $post_types ) ) {
                $post_types = array(
                    'post',
                    'page',
                );
                array_push( $post_types, 'faq' );
            } else {
                if ( is_array( $post_types ) && ! empty( $post_types ) ) {
                    array_push( $post_types, 'faq' );
                }
            }

        $post_types = array_filter( $post_types );
        $query->set('post_type', $post_types);
        
    endif;

    return $query;

}