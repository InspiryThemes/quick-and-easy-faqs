<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/saqibsarwar/quick-and-easy-faqs
 * @since      1.0.0
 *
 * @package    Quick_And_Easy_FAQs
 * @subpackage Quick_And_Easy_FAQs/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Quick_And_Easy_FAQs
 * @subpackage Quick_And_Easy_FAQs/includes
 * @author     M Saqib Sarwar <saqib@inspirythemes.com>
 */
class Quick_And_Easy_FAQs {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Quick_And_Easy_FAQs_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'quick-and-easy-faqs';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Quick_And_Easy_FAQs_Loader. Orchestrates the hooks of the plugin.
	 * - Quick_And_Easy_FAQs_i18n. Defines internationalization functionality.
	 * - Quick_And_Easy_FAQs_Admin. Defines all hooks for the admin area.
	 * - Quick_And_Easy_FAQs_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-quick-and-easy-faqs-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-quick-and-easy-faqs-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-quick-and-easy-faqs-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-quick-and-easy-faqs-public.php';

		$this->loader = new Quick_And_Easy_FAQs_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Quick_And_Easy_FAQs_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Quick_And_Easy_FAQs_i18n();
		$plugin_i18n->set_domain( $this->get_plugin_name() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Quick_And_Easy_FAQs_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Quick_And_Easy_FAQs_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {

        $this->loader->add_action( 'init', $this, 'register_faqs_post_type' );
        $this->loader->add_action( 'init', $this, 'register_faqs_group_taxonomy' );
        $this->loader->add_action( 'init', $this, 'register_faqs_shortcodes' );

        $this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Quick_And_Easy_FAQs_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
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

    /**
     * Register FAQs shortcodes
     *
     * @since   1.0.0
     */
    public function register_faqs_shortcodes() {

        add_shortcode( 'faqs', array( $this, 'display_faqs_list') );

    }

    /**
     * Display faqs in a list
     *
     * @since   1.0.0
     * @param   array   $attributes     Array of attributes
     * @return  string  generated html by shortcode
     */
    public function display_faqs_list( $attributes ) {

        extract( shortcode_atts( array(
                                    'style' => 'list',
                                    'grouped' => 'no',
                                    'filter' => null,
                                    ), $attributes ) );

        $filter_array = array();

        // faq groups filter
        if ( ! empty ( $filter ) ) {
            $filter_array = explode( ',', $filter );
        }

        ob_start();

        if ( $style == 'toggle' ) {
            $this->all_faqs_in_toggles( $filter_array );
        } else {
            if ( $grouped == 'yes' ) {
                $this->list_grouped_faqs( $filter_array );
            } else {
                $this->list_all_faqs( $filter_array );
            }
        }

        return ob_get_clean();

    }

    /**
     * Display FAQs in list style
     *
     * @since   1.0.0
     * @param   Array   $filter_array   Array of faq groups slugs
     */
    private function list_all_faqs( $filter_array ) {

        $faqs_query = new WP_Query(array(
            'post_type' => 'faq',
            'posts_per_page' => -1,
        ));

        if ( ! empty ( $filter_array ) ) {
            $faqs_query['tax_query'] = array(
                array (
                    'taxonomy' => 'faq-group',
                    'field'    => 'slug',
                    'terms'    => $filter_array,
                ),
            );
        }

        // FAQs index
        if ( $faqs_query->have_posts() ) :

            echo '<div id="qe-faqs-index" class="qe-faqs-index">';
            echo '<ol class="qe-faqs-index-list">';
            while ( $faqs_query-> have_posts() ) :
                $faqs_query->the_post();
                ?><li><a href="#qe-faq-<?php echo the_ID(); ?>"><?php the_title(); ?></a></li><?php
            endwhile;
            echo '</ol>';
            echo '</div>';
        endif;

        // rewind faqs loop
        $faqs_query->rewind_posts();

        // FAQs Contents
        if ( $faqs_query->have_posts() ) :
            while ( $faqs_query->have_posts() ) :
                $faqs_query->the_post();
                ?>
                <div id="qe-faq-<?php the_ID(); ?>" class="qe-faq-content">
                    <h4><i class="fa fa-question-circle"></i> <?php the_title(); ?></h4>
                    <?php the_content(); ?>
                    <a class="qe-faq-top" href="#qe-faqs-index"><i class="fa fa-angle-up"></i> <?php _e( 'Back to Index', 'quick-and-easy-faqs'); ?></a>
                </div>
            <?php
            endwhile;
        endif;

        // All the custom loops ends here so reset the query
        wp_reset_query();

    }

    /**
     * Display FAQs in list style
     *
     * @since   1.0.0
     * @param   Array   $filter_array   Array of faq groups slugs
     */
    private function list_grouped_faqs( $filter_array ) {

        $faq_groups = get_terms( 'faq-group' );

        if ( ! empty( $faq_groups ) && ! is_wp_error( $faq_groups ) ) {

            $faqs_queries_array = array();
            $query_index =  0;

            /**
             * Create Index
             */
            echo '<div id="qe-faqs-index" class="qe-faqs-index">';

            foreach ( $faq_groups as $faq_group ) {

                // display all if filter array is empty OR display only specified groups if filter array contains group slugs
                if ( empty( $filter_array ) || in_array ( $faq_group->slug , $filter_array ) ) {

                    $faqs_queries_array[ $query_index ] = new WP_Query( array(
                            'post_type' => 'faq',
                            'posts_per_page' => -1,
                            'tax_query' => array(
                                array (
                                    'taxonomy' => 'faq-group',
                                    'field'    => 'slug',
                                    'terms'    => $faq_group->slug,
                                )
                            ),
                        )
                    );

                    // FAQs index
                    if ( $faqs_queries_array[ $query_index ]->have_posts() ) :
                        echo '<h4>' . $faq_group->name . '</h4>';
                        echo '<ol id="qe-faqs-group-index" class="qe-faqs-group-index qe-faqs-index-list">';
                        while ( $faqs_queries_array[ $query_index ]-> have_posts() ) :
                            $faqs_queries_array[ $query_index ]->the_post();
                            ?><li><a href="#qe-faq-<?php echo the_ID(); ?>"><?php the_title(); ?></a></li><?php
                        endwhile;
                        echo '</ol>';
                    endif;

                    $query_index++;

                }

            }

            echo '</div>';


            /**
             * Create Contents
             */
            foreach ( $faqs_queries_array as $faqs_query ) {

                    $faqs_query->rewind_posts();

                    if ( $faqs_query->have_posts() ) :
                        while ( $faqs_query-> have_posts() ) :
                            $faqs_query->the_post();
                            ?>
                            <div id="qe-faq-<?php the_ID(); ?>" class="qe-faq-content">
                                <h4><i class="fa fa-question-circle"></i> <?php the_title(); ?></h4>
                                <?php the_content(); ?>
                                <a class="qe-faq-top" href="#qe-faqs-index"><i class="fa fa-angle-up"></i> <?php _e( 'Back to Index', 'quick-and-easy-faqs'); ?></a>
                            </div>
                            <?php
                        endwhile;
                    endif;

            }

            // All the custom loops ends here so reset the query
            wp_reset_query();

        }

    }

    /**
     * Display FAQs in list style
     *
     * @since   1.0.0
     * @param   Array   $filter_array   Array of faq groups slugs
     */
    private function all_faqs_in_toggles( $filter_array ) {


        $faqs_query = new WP_Query(array(
            'post_type' => 'faq',
            'posts_per_page' => -1,
        ));

        if ( ! empty ( $filter_array ) ) {
            $faqs_query['tax_query'] = array(
                array (
                    'taxonomy' => 'faq-group',
                    'field'    => 'slug',
                    'terms'    => $filter_array,
                ),
            );
        }

        // FAQs Toggles
        if ( $faqs_query->have_posts() ) :
            while ( $faqs_query->have_posts() ) :
                $faqs_query->the_post();
                ?>
                <div class="qe-faq-toggle">
                    <div class="qe-toggle-title">
                        <h4><i class="fa fa-plus-circle"></i> <?php the_title(); ?></h4>
                    </div>
                    <div class="qe-toggle-content">
                        <?php the_content(); ?>
                    </div>
                </div>
                <?php
            endwhile;
        endif;

        // All the custom loops ends here so reset the query
        wp_reset_query();

    }

    /**
     * To log any thing for debugging purpose
     *
     * @since   1.0.0
     *
     * @param   mixed   $message    message to be logged
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
