<?php

/**
 * Custom Post Type & Taxonomy
 */

namespace Quick_And_Easy_FAQs\Admin;

class Register_Post_And_Taxonomy {

	/**
	 * Register FAQs custom post type
	 */
	public function register_faqs_post_type() {

		$labels = array(
			'name'               => _x( 'FAQs', 'Post Type General Name', QAEF_TEXT_DOMAIN ),
			'singular_name'      => _x( 'FAQ', 'Post Type Singular Name', QAEF_TEXT_DOMAIN ),
			'menu_name'          => __( 'FAQs', QAEF_TEXT_DOMAIN ),
			'name_admin_bar'     => __( 'FAQ', QAEF_TEXT_DOMAIN ),
			'parent_item_colon'  => __( 'Parent FAQ:', QAEF_TEXT_DOMAIN ),
			'all_items'          => __( 'FAQs', QAEF_TEXT_DOMAIN ),
			'add_new_item'       => __( 'Add New FAQ', QAEF_TEXT_DOMAIN ),
			'add_new'            => __( 'Add New', QAEF_TEXT_DOMAIN ),
			'new_item'           => __( 'New FAQ', QAEF_TEXT_DOMAIN ),
			'edit_item'          => __( 'Edit FAQ', QAEF_TEXT_DOMAIN ),
			'update_item'        => __( 'Update FAQ', QAEF_TEXT_DOMAIN ),
			'view_item'          => __( 'View FAQ', QAEF_TEXT_DOMAIN ),
			'search_items'       => __( 'Search FAQ', QAEF_TEXT_DOMAIN ),
			'not_found'          => __( 'Not found', QAEF_TEXT_DOMAIN ),
			'not_found_in_trash' => __( 'Not found in Trash', QAEF_TEXT_DOMAIN ),
		);

		$args = array(
			'label'               => __( 'faq', QAEF_TEXT_DOMAIN ),
			'description'         => __( 'Frequently Asked Questions', QAEF_TEXT_DOMAIN ),
			'labels'              => apply_filters( 'inspiry_faq_labels', $labels ),
			'supports'            => apply_filters( 'inspiry_faq_supports', array( 'title', 'editor', 'author' ) ),
			'hierarchical'        => false,
			'public'              => true,
			'exclude_from_search' => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 10,
			'menu_icon'           => 'dashicons-format-chat',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'show_in_rest'        => true,
			'rest_base'           => apply_filters( 'inspiry_faq_rest_base', __( 'faqs', QAEF_TEXT_DOMAIN ) ),
		);

		register_post_type( 'faq', apply_filters( 'inspiry_register_faq_arguments', $args ) );

	}

	/**
	 * Register FAQ Group custom taxonomy
	 */
	public function register_faqs_group_taxonomy() {

		$labels = array(
			'name'                       => _x( 'FAQ Groups', 'Taxonomy General Name', QAEF_TEXT_DOMAIN ),
			'singular_name'              => _x( 'FAQ Group', 'Taxonomy Singular Name', QAEF_TEXT_DOMAIN ),
			'menu_name'                  => __( 'Groups', QAEF_TEXT_DOMAIN ),
			'all_items'                  => __( 'All FAQ Groups', QAEF_TEXT_DOMAIN ),
			'parent_item'                => __( 'Parent FAQ Group', QAEF_TEXT_DOMAIN ),
			'parent_item_colon'          => __( 'Parent FAQ Group:', QAEF_TEXT_DOMAIN ),
			'new_item_name'              => __( 'New FAQ Group Name', QAEF_TEXT_DOMAIN ),
			'add_new_item'               => __( 'Add New FAQ Group', QAEF_TEXT_DOMAIN ),
			'edit_item'                  => __( 'Edit FAQ Group', QAEF_TEXT_DOMAIN ),
			'update_item'                => __( 'Update FAQ Group', QAEF_TEXT_DOMAIN ),
			'view_item'                  => __( 'View FAQ Group', QAEF_TEXT_DOMAIN ),
			'separate_items_with_commas' => __( 'Separate FAQ Groups with commas', QAEF_TEXT_DOMAIN ),
			'add_or_remove_items'        => __( 'Add or remove FAQ Groups', QAEF_TEXT_DOMAIN ),
			'choose_from_most_used'      => __( 'Choose from the most used', QAEF_TEXT_DOMAIN ),
			'popular_items'              => __( 'Popular FAQ Groups', QAEF_TEXT_DOMAIN ),
			'search_items'               => __( 'Search FAQ Groups', QAEF_TEXT_DOMAIN ),
			'not_found'                  => __( 'Not Found', QAEF_TEXT_DOMAIN ),
		);

		$args = array(
			'labels'              => apply_filters( 'inspiry_faq_group_labels', $labels ),
			'hierarchical'        => true,
			'public'              => true,
			'exclude_from_search' => false,
			'rewrite'             => false,
			'show_ui'             => true,
			'show_in_menu'        => 'edit.php?post_type=faq',
			'show_admin_column'   => true,
			'show_in_nav_menus'   => true,
			'show_tagcloud'       => false,
			'show_in_rest'        => true,
			'rest_base'           => apply_filters( 'inspiry_faq_group_rest_base', __( 'faq_groups', QAEF_TEXT_DOMAIN ) ),
		);

		register_taxonomy( 'faq-group', array( 'faq' ), apply_filters( 'inspiry_register_faq_group_arguments', $args ) );

	}

}
