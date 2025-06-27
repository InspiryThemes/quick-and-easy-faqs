<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 */

namespace Quick_And_Easy_FAQs\Admin;

use Quick_And_Easy_FAQs\Includes\Settings_API;

class Settings {

	/**
	 * FAQs options
	 *
	 * @var $options array options.
	 */
	public $options;

	/**
	 * All Settings Saved.
	 *
	 * @var $settings_api array settings.
	 */
	private $settings_api;


	/**
	 * Initializing the setting api.
	 */
	public function __construct() {

		$this->settings_api = new Settings_API();
	}

	/**
	 * Init Settings.
	 */
	public function settings_init() {

		// set the settings.
		$this->settings_api->set_sections( $this->get_settings_sections() );
		$this->settings_api->set_fields( $this->get_settings_fields() );

		// initialize settings.
		$this->settings_api->admin_init();
	}

	/**
	 * Add plugin settings page
	 */
	public function add_faqs_options_page() {

		/**
		 * Add FAQs settings page
		 */
		add_submenu_page(
			'edit.php?post_type=faq',
			__( 'Quick & Easy Settings', QAEF_TEXT_DOMAIN ),
			__( 'Settings', QAEF_TEXT_DOMAIN ),
			'manage_options',
			'quick_and_easy_faqs',
			array( $this, 'settings_page' )
		);

	}

	/**
	 * Returns all Sections for settings
	 *
	 * @return array section fields
	 */
	private function get_settings_sections() {
		$sections = array(
			array(
				'id'    => 'qaef_basics',
				'title' => __( 'Basic', QAEF_TEXT_DOMAIN ),
			),
			array(
				'id'    => 'qaef_typography',
				'title' => __( 'Typography', QAEF_TEXT_DOMAIN ),
				'desc'  => esc_html__( 'These settings only applies to FAQs with toggle style. As FAQs with list style use colors inherited from currently active theme.', QAEF_TEXT_DOMAIN ),
			),
		);

		return $sections;
	}

	/**
	 * Returns all the settings fields
	 *
	 * @return array settings fields
	 */
	private function get_settings_fields() {

		$settings_fields['qaef_basics'] = array(
			array(
				'name'  => 'faqs_fontawesome_style',
				'label' => __( 'FAQs Plugin Based Font Awesome Stylesheet', QAEF_TEXT_DOMAIN ),
				'desc'  => __( 'Disable', QAEF_TEXT_DOMAIN ),
				'type'  => 'checkbox',
			),
			array(
				'name'  => 'faqs_hide_back_index',
				'label' => __( 'Back to Index Link', QAEF_TEXT_DOMAIN ),
				'desc'  => __( 'Hide', QAEF_TEXT_DOMAIN ),
				'type'  => 'checkbox',
			),
		);

		$settings_fields['qaef_typography'] = array(
			array(
				'name'    => 'faqs_toggle_colors',
				'label'   => __( 'FAQs toggle colors', QAEF_TEXT_DOMAIN ),
				'default' => 'default',
				'desc'    => __( 'Choose custom colors to apply colors provided in options below.', QAEF_TEXT_DOMAIN ),
				'type'    => 'select',
				'options' => array(
					'default' => __( 'Default Colors', QAEF_TEXT_DOMAIN ),
					'custom'  => __( 'Custom Colors', QAEF_TEXT_DOMAIN ),
				),
			),
			array(
				'name'    => 'toggle_question_color',
				'label'   => __( 'Question text color', QAEF_TEXT_DOMAIN ),
				'type'    => 'color',
				'default' => '#333333',
			),
			array(
				'name'    => 'toggle_question_hover_color',
				'label'   => __( 'Question text color on mouse over', QAEF_TEXT_DOMAIN ),
				'type'    => 'color',
				'default' => '#333333',
			),
			array(
				'name'    => 'toggle_question_bg_color',
				'label'   => __( 'Question background color', QAEF_TEXT_DOMAIN ),
				'type'    => 'color',
				'default' => '#fafafa',
			),
			array(
				'name'    => 'toggle_question_hover_bg_color',
				'label'   => __( 'Question background color on mouse over', QAEF_TEXT_DOMAIN ),
				'type'    => 'color',
				'default' => '#eaeaea',
			),
			array(
				'name'    => 'toggle_answer_color',
				'label'   => __( 'Answer text color', QAEF_TEXT_DOMAIN ),
				'type'    => 'color',
				'default' => '#333333',
			),
			array(
				'name'    => 'toggle_answer_bg_color',
				'label'   => __( 'Answer background color', QAEF_TEXT_DOMAIN ),
				'type'    => 'color',
				'default' => '#ffffff',
			),
			array(
				'name'    => 'toggle_border_color',
				'label'   => __( 'Toggle Border color', QAEF_TEXT_DOMAIN ),
				'type'    => 'color',
				'default' => '#dddddd',
			),
			array(
				'name'  => 'faqs_custom_css',
				'label' => __( 'Custom CSS', QAEF_TEXT_DOMAIN ),
				'type'  => 'textarea',
			),
		);

		return $settings_fields;
	}


	/**
	 * Returns all setting page
	 */
	public function settings_page() {
		echo '<div class="wrap">';
		echo '<h2>' . esc_html__( 'Quick and Easy FAQs Settings', QAEF_TEXT_DOMAIN ) . '</h2><br />';
		settings_errors();
		$this->settings_api->show_navigation();
		echo '<div id="qaef-settings-wrapper">';
		$this->settings_api->show_forms();
		echo '</div>';
		echo '<div id="qaef-adv-section">';
		echo '</div>';
		echo '</div>';
	}

	/**
	 * Get all the pages
	 *
	 * @return array page names with key value pairs
	 */
	public function get_pages() {
		$pages         = get_pages();
		$pages_options = array();
		if ( $pages ) {
			foreach ( $pages as $page ) {
				$pages_options[ $page->ID ] = $page->post_title;
			}
		}

		return $pages_options;
	}
}

