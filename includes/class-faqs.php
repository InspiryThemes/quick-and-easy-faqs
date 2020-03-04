<?php

/**
 * The file that defines the core plugin class
 *
 * It includes attributes and functions used across both the
 * public-facing side of the site and the admin area. Also maintains the unique identifier
 * of this plugin as well as the current version of the plugin.
 */

namespace Quick_And_Easy_Faqs\Includes;

use Quick_And_Easy_Faqs\Admin\Admin;
use Quick_And_Easy_Faqs\Admin\Settings;
use Quick_And_Easy_Faqs\Admin\Gutenberg_Editor;
use Quick_And_Easy_Faqs\Admin\Classic_Editor;
use Quick_And_Easy_Faqs\Admin\Register_Post_And_Taxonomy;
use Quick_And_Easy_Faqs\Frontend\Frontend;
use Quick_And_Easy_Faqs\Frontend\Shortcode;
use Quick_And_Easy_Faqs\Includes\Utilities;

class Faqs  extends Utilities {

	/**
	 * The unique identifier of this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 */
	protected $version;

	/**
	 * The Self Instance of the plugin.
	 */
	protected static $qae_instance;

	/**
	 * Define the core functionality of the plugin.
	 */
	public function __construct() {

		$this->version = QUICK_AND_EASY_FAQS_VERSION;

		$this->plugin_name = 'quick-and-easy-faqs';

		$this->define_admin_hooks();
		$this->define_public_hooks();

		add_action( 'plugins_loaded', array( $this, 'set_locale' ) );

	}

	/**
	 * Define the instance functionality of the plugin.
	 */
	public static function instance() {
		if ( is_null( self::$qae_instance ) ) {
			self::$qae_instance = new self();
		}

		return self::$qae_instance;
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 */
	public function set_locale() {

		load_plugin_textdomain(
			'quick-and-easy-faqs',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);
	}

	/**
	 * Register all of the hooks related to the admin area functionality of the plugin.
	 */
	private function define_admin_hooks() {

		$post_type = new Register_Post_And_Taxonomy();
		add_action( 'init', array( $post_type, 'register_faqs_post_type' ) );
		add_action( 'init', array( $post_type, 'register_faqs_group_taxonomy' ) );

		$plugin_admin = new Admin( $this->plugin_name, $this->version );
		add_action( 'admin_enqueue_scripts', array( $plugin_admin, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $plugin_admin, 'enqueue_admin_scripts' ) );

		$classic_editor = new Classic_Editor();
		add_filter( 'mce_external_plugins', array( $classic_editor, 'enqueue_plugin_scripts' ) );
		add_filter( 'mce_buttons', array( $classic_editor, 'register_buttons_editor' ) );

		$gutenberg_button = new Gutenberg_Editor();
		if ( Admin::is_gutenberg_active() ) {
			add_filter( 'block_categories', array( $gutenberg_button, 'add_faqs_block_category' ) );
			add_action( 'init', array( $gutenberg_button, 'add_all_faqs_block' ) );
		}

		$faq_settings = new Settings();
		add_action( 'admin_menu', array( $faq_settings, 'settings_init' ) );
		add_action( 'admin_menu', array( $faq_settings, 'add_faqs_options_page' ) );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality of the plugin.
	 */
	private function define_public_hooks() {

		$plugin_public = new Frontend( $this->plugin_name, $this->version );
		add_action( 'wp_enqueue_scripts', array( $plugin_public, 'enqueue_public_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $plugin_public, 'enqueue_public_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $plugin_public, 'add_public_custom_styles' ) );

		$faqs_shortcodes = new Shortcode( $this->plugin_name, $this->version );
		add_action( 'init', array( $faqs_shortcodes, 'register_faqs_shortcodes' ) );

		if ( class_exists( 'Vc_Manager' ) ) {
			add_action( 'vc_before_init', array( $faqs_shortcodes, 'integrate_shortcode_with_vc' ) );
		}

	}


	/**
	 * Display faqs programmatically
	 *
	 * @param  array $style faq style.
	 * @param  array $filter faq filter.
	 * @param  array $orderby faq orderby.
	 * @param  array $order faq order.
	 *
	 * @return bool true on success or false on failure.
	 */
	public function do_shortcode( $style = '', $filter = 'false', $orderby = '', $order = '' ) {

		// faq groups filter.
		if ( isset( $filter ) && ! empty( $filter ) && 'true' != $filter ) {
			$filter = explode( ',', $filter );
		}

		ob_start();

		$faqs_fa_style = $this->get_option( 'faqs_fontawesome_style', 'qaef_basics' );

		if ( 'on' !== $faqs_fa_style ) {
			wp_enqueue_style(
				'font-awesome',
				dirname( plugin_dir_url( __FILE__ ) ) . '/frontend/css/font-awesome.min.css',
				array(),
				$this->version,
				'all'
			);
		}

		wp_enqueue_style(
			$this->plugin_name,
			dirname( plugin_dir_url( __FILE__ ) ) . '/frontend/css/styles-public.css',
			array(),
			$this->version,
			'all'
		);

		// if rtl is enabled.
		if ( is_rtl() ) {
			wp_enqueue_style(
				$this->plugin_name . '-rtl',
				dirname( plugin_dir_url( __FILE__ ) ) . '/public/css/styles-public-rtl.css',
				array(
					$this->plugin_name,
					'font-awesome',
				),
				$this->version,
				'all'
			);
		}

		$faqs_query = new Faqs_Query( $style, $filter, $orderby, $order );
		$faqs_query->render();

		wp_register_script(
			$this->plugin_name,
			dirname( plugin_dir_url( __FILE__ ) ) . '/frontend/js/scripts.js',
			array( 'jquery' ),
			$this->version,
			true
		);

		wp_localize_script(
			$this->plugin_name,
			'qaef_object',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'style'   => $style,
			)
		);
		wp_enqueue_script( $this->plugin_name );

		return ob_get_clean();

	}
}
