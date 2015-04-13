<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/saqibsarwar/quick-and-easy-faqs
 * @since      1.0.0
 *
 * @package    Quick_And_Easy_FAQs
 * @subpackage Quick_And_Easy_FAQs/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Quick_And_Easy_FAQs
 * @subpackage Quick_And_Easy_FAQs/admin
 * @author     M Saqib Sarwar <saqib@inspirythemes.com>
 */
class Quick_And_Easy_FAQs_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Quick_And_Easy_FAQs_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Quick_And_Easy_FAQs_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/quick-and-easy-faqs-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Quick_And_Easy_FAQs_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Quick_And_Easy_FAQs_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/quick-and-easy-faqs-admin.js', array( 'jquery' ), $this->version, false );

	}


    /**
     * Register FAQs custom post type
     *
     * @since     1.0.0
     */
    public function register_faqs_post_type() {

        $labels = array(
            'name'                => _x( 'FAQs', 'Post Type General Name', 'quick-and-easy-faqs' ),
            'singular_name'       => _x( 'FAQ', 'Post Type Singular Name', 'quick-and-easy-faqs' ),
            'menu_name'           => __( 'FAQs', 'quick-and-easy-faqs' ),
            'name_admin_bar'      => __( 'FAQs', 'quick-and-easy-faqs' ),
            'parent_item_colon'   => __( 'Parent FAQ:', 'quick-and-easy-faqs' ),
            'all_items'           => __( 'All FAQs', 'quick-and-easy-faqs' ),
            'add_new_item'        => __( 'Add New FAQ', 'quick-and-easy-faqs' ),
            'add_new'             => __( 'Add New', 'quick-and-easy-faqs' ),
            'new_item'            => __( 'New FAQ', 'quick-and-easy-faqs' ),
            'edit_item'           => __( 'Edit FAQ', 'quick-and-easy-faqs' ),
            'update_item'         => __( 'Update FAQ', 'quick-and-easy-faqs' ),
            'view_item'           => __( 'View FAQ', 'quick-and-easy-faqs' ),
            'search_items'        => __( 'Search FAQ', 'quick-and-easy-faqs' ),
            'not_found'           => __( 'Not found', 'quick-and-easy-faqs' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'quick-and-easy-faqs' ),
        );

        $args = array(
            'label'               => __( 'faq', 'quick-and-easy-faqs' ),
            'description'         => __( 'Frequently Asked Questions', 'quick-and-easy-faqs' ),
            'labels'              => apply_filters( 'qe_faq_labels', $labels),
            'supports'            => apply_filters( 'qe_faq_supports', array( 'title', 'editor' ) ),
            'hierarchical'        => false,
            'public'              => false,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_position'       => 10,
            'menu_icon'           => 'dashicons-format-chat',
            'show_in_admin_bar'   => false,
            'show_in_nav_menus'   => false,
            'can_export'          => true,
            'has_archive'         => false,
            'exclude_from_search' => true,
            'publicly_queryable'  => false,
            'capability_type'     => 'post',
        );

        register_post_type( 'faq', apply_filters( 'qe_register_faq_arguments', $args) );

    }

    /**
     * Register FAQ Group custom taxonomy
     *
     * @since     1.0.0
     */
    public function register_faqs_group_taxonomy() {

        $labels = array(
            'name'                       => _x( 'FAQ Groups', 'Taxonomy General Name', 'quick-and-easy-faqs' ),
            'singular_name'              => _x( 'FAQ Group', 'Taxonomy Singular Name', 'quick-and-easy-faqs' ),
            'menu_name'                  => __( 'FAQ Group', 'quick-and-easy-faqs' ),
            'all_items'                  => __( 'All FAQ Groups', 'quick-and-easy-faqs' ),
            'parent_item'                => __( 'Parent FAQ Group', 'quick-and-easy-faqs' ),
            'parent_item_colon'          => __( 'Parent FAQ Group:', 'quick-and-easy-faqs' ),
            'new_item_name'              => __( 'New FAQ Group Name', 'quick-and-easy-faqs' ),
            'add_new_item'               => __( 'Add New FAQ Group', 'quick-and-easy-faqs' ),
            'edit_item'                  => __( 'Edit FAQ Group', 'quick-and-easy-faqs' ),
            'update_item'                => __( 'Update FAQ Group', 'quick-and-easy-faqs' ),
            'view_item'                  => __( 'View FAQ Group', 'quick-and-easy-faqs' ),
            'separate_items_with_commas' => __( 'Separate FAQ Groups with commas', 'quick-and-easy-faqs' ),
            'add_or_remove_items'        => __( 'Add or remove FAQ Groups', 'quick-and-easy-faqs' ),
            'choose_from_most_used'      => __( 'Choose from the most used', 'quick-and-easy-faqs' ),
            'popular_items'              => __( 'Popular FAQ Groups', 'quick-and-easy-faqs' ),
            'search_items'               => __( 'Search FAQ Groups', 'quick-and-easy-faqs' ),
            'not_found'                  => __( 'Not Found', 'quick-and-easy-faqs' ),
        );

        $args = array(
            'labels'                     => apply_filters( 'qe_faq_group_labels', $labels ),
            'hierarchical'               => true,
            'public'                     => false,
            'rewrite'                    => false,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => false,
            'show_tagcloud'              => false,
        );

        register_taxonomy( 'faq-group', array( 'faq' ), apply_filters( 'qe_register_faq_group_arguments', $args ) );

    }


}
