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
			__( 'Quick & Easy Settings', 'quick-and-easy-faqs' ),
			__( 'Settings', 'quick-and-easy-faqs' ),
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
				'title' => __( 'Basic', 'quick-and-easy-faqs' ),
			),
			array(
				'id'    => 'qaef_sortable_list',
				'title' => __( 'FAQs Sorting', 'quick-and-easy-faqs' ),
				'desc'  => esc_html__( 'You can sort the faqs by just drag and drop. You can also deselect the faqs which you don"t want to list.', 'quick-and-easy-faqs' ),
			),
			array(
				'id'    => 'qaef_typography',
				'title' => __( 'Typography', 'quick-and-easy-faqs' ),
				'desc'  => esc_html__( 'These settings only applies to FAQs with toggle style. As FAQs with list style use colors inherited from currently active theme.', 'quick-and-easy-faqs' ),
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

		$free_settings = array(
			array(
				'name'  => 'faqs_fontawesome_style',
				'label' => __( 'FAQs Plugin Based Font Awesome Stylesheet', 'quick-and-easy-faqs' ),
				'desc'  => __( 'Disable', 'quick-and-easy-faqs' ),
				'type'  => 'checkbox',
			),
			array(
				'name'  => 'faqs_hide_back_index',
				'label' => __( 'Back to Index Link', 'quick-and-easy-faqs' ),
				'desc'  => __( 'Hide', 'quick-and-easy-faqs' ),
				'type'  => 'checkbox',
			),
		);

		$premium_settings = array();
		if ( qaef_fs()->is__premium_only() ) {
			$premium_settings = array(
				array(
					'name'  => 'faqs_hide_filters_manually',
					'label' => __( 'Hide Filters Manually', 'quick-and-easy-faqs' ),
					'desc'  => __( 'Hide', 'quick-and-easy-faqs' ),
					'type'  => 'checkbox',
				),
				array(
					'name'  => 'faqs_question_icon',
					'label' => __( 'Faqs Question Icon', 'quick-and-easy-faqs' ),
					'desc'  => sprintf( __( 'You can choose any free icon by visiting the %s. You just need to add the Class like %s', 'quick-and-easy-faqs' ), '<a target="_blank" href="https://fontawesome.com/icons?d=gallery&m=free"><strong>' . __('Fontawesome Website', 'quick-and-easy-faqs') . '</strong></a><strong>', '<strong>fa fa-star<strong>'  ),
					'type'  => 'text',
				),
				
			);
		}

		$settings_fields['qaef_basics'] = array_merge( $free_settings, $premium_settings );

		if ( qaef_fs()->is__premium_only() ) {

			$post_type_query  = new \WP_Query(  
				array (  
					'post_type'      => 'faq',  
					'posts_per_page' => -1  
				)  
			);   
			
			$posts_array      = $post_type_query->posts;   
			$post_title_array = wp_list_pluck( $posts_array, 'post_title', 'ID' );

			$settings_fields['qaef_sortable_list'] = array(
				array(
					'name'    => 'faqs_order_list',
					'label'   => __( 'FAQs reorder', 'quick-and-easy-faqs' ),
					'class'   => 'faqs-reorder-list',
					'type' => 'multicheck',
					'options' => $post_title_array,
				),
			);
		}

		$settings_fields['qaef_typography'] = array(
			array(
				'name'    => 'faqs_toggle_colors',
				'label'   => __( 'FAQs toggle colors', 'quick-and-easy-faqs' ),
				'default' => 'default',
				'desc'    => __( 'Choose custom colors to apply colors provided in options below.', 'quick-and-easy-faqs' ),
				'type'    => 'select',
				'options' => array(
					'default' => __( 'Default Colors', 'quick-and-easy-faqs' ),
					'custom'  => __( 'Custom Colors', 'quick-and-easy-faqs' ),
				),
			),
			array(
				'name'    => 'toggle_question_color',
				'label'   => __( 'Question text color', 'quick-and-easy-faqs' ),
				'type'    => 'color',
				'default' => '#333333',
			),
			array(
				'name'    => 'toggle_question_hover_color',
				'label'   => __( 'Question text color on mouse over', 'quick-and-easy-faqs' ),
				'type'    => 'color',
				'default' => '#333333',
			),
			array(
				'name'    => 'toggle_question_bg_color',
				'label'   => __( 'Question background color', 'quick-and-easy-faqs' ),
				'type'    => 'color',
				'default' => '#fafafa',
			),
			array(
				'name'    => 'toggle_question_hover_bg_color',
				'label'   => __( 'Question background color on mouse over', 'quick-and-easy-faqs' ),
				'type'    => 'color',
				'default' => '#eaeaea',
			),
			array(
				'name'    => 'toggle_answer_color',
				'label'   => __( 'Answer text color', 'quick-and-easy-faqs' ),
				'type'    => 'color',
				'default' => '#333333',
			),
			array(
				'name'    => 'toggle_answer_bg_color',
				'label'   => __( 'Answer background color', 'quick-and-easy-faqs' ),
				'type'    => 'color',
				'default' => '#ffffff',
			),
			array(
				'name'    => 'toggle_border_color',
				'label'   => __( 'Toggle Border color', 'quick-and-easy-faqs' ),
				'type'    => 'color',
				'default' => '#dddddd',
			),
			array(
				'name'  => 'faqs_custom_css',
				'label' => __( 'Custom CSS', 'quick-and-easy-faqs' ),
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
		echo '<h2>' . esc_html__( 'Quick and Easy FAQs Settings', 'quick-and-easy-faqs' ) . '</h2><br />';
		settings_errors();
		$this->settings_api->show_navigation();
		echo '<div id="qaef-settings-wrapper">';
		$this->settings_api->show_forms();
		echo '</div>';
		echo '<div id="qaef-adv-section">';
		if ( qaef_fs()->is_not_paying() ) {
			?>
			<section>
			<h2><?php esc_html_e( ' Upgrade to FAQs PRO', 'quick-and-easy-faqs' ); ?></h2>
			<p><?php esc_html_e( 'Please upgrade to the PRO plan to unlock more awesome features.', 'quick-and-easy-faqs' ); ?>  </p>
			<ul class="features-list clearfix">
				<li><?php esc_html_e( 'Show/Hide filters manually', 'quick-and-easy-faqs' ); ?></li>
				<li><?php esc_html_e( 'Question icon change option', 'quick-and-easy-faqs' ); ?></li>
				<li><?php esc_html_e( 'Tabs format in filtered faqs display', 'quick-and-easy-faqs' ); ?></li>
				<li><?php esc_html_e( 'Custom Order Support', 'quick-and-easy-faqs' ); ?></li>
				<li><?php esc_html_e( 'Font change options for heading and text', 'quick-and-easy-faqs' ); ?></li>
				<li><?php esc_html_e( 'Social Sharing options', 'quick-and-easy-faqs' ); ?></li>
				<li><?php esc_html_e( 'WordPress Default FAQs Widget', 'quick-and-easy-faqs' ); ?></li>
			</ul>	
			
			<a class="upgrade-now button button-primary" href="<?php echo esc_url( qaef_fs()->get_upgrade_url() ); ?>"> <?php esc_html_e( 'Upgrade Now!', 'quick-and-easy-faqs' ); ?> </a>
			
		</section>
			<?php
		}
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

