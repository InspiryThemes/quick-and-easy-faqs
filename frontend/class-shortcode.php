<?php
/**
 * The public-facing functionality of the plugin.
 */

namespace Quick_And_Easy_Faqs\Frontend;

use Quick_And_Easy_Faqs\Includes\Faqs_Query;
use Quick_And_Easy_Faqs\Includes\Utilities;

class Shortcode extends Utilities {

	/**
	 * The ID of this plugin.
	 *
	 * @var string $plugin_name
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @var string $version
	 */
	private $version;

	/**
	 * The version of this plugin.
	 *
	 * @var bool $shortcode_being_used
	 */
	private $shortcode_being_used;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @var string $plugin_name
	 * @var string $version
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name          = $plugin_name;
		$this->version              = $version;
		$this->shortcode_being_used = false;
	}

	/**
	 * Check if shortcode is added in the post.
	 *
	 * @return bool
	 */
	public function is_shortcode_being_used() {

		if ( $this->shortcode_being_used ) {
			return true;
		} else {
			global $post;
			if ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'faqs' ) ) {
				$this->shortcode_being_used = true;

				return true;
			}

			return false;
		}
	}

	/**
	 * Check if old short code is used.
	 *
	 * @param  array $attr short code attr values.
	 *
	 * @return array Modified array is user using old short codes.
	 */
	public function old_shortcode_fallback( $attr ) {

		if ( isset( $attr['style'] ) && 'filterable-toggle' === $attr['style'] ) {
			$attr['style']  = 'toggle';
			$attr['filter'] = true;
		}

		if ( isset( $attr['style'] ) && 'toggle' === $attr['style'] && isset( $attr['grouped'] ) && 'yes' === $attr['grouped'] ) {
			$attr['style'] = 'toggle-grouped';
			unset( $attr['grouped'] );
		}

		if ( isset( $attr['grouped'] ) && 'yes' === $attr['grouped'] ) {
			$attr['style'] = 'grouped';
			unset( $attr['grouped'] );
		}

		if ( isset( $attr['filter'] ) && 'group-slug' === $attr['filter'] ) {
			$attr['filter'] = true;
		}

		return $attr;
	}

	/**
	 * Display faqs in a list
	 *
	 * @param  array $attributes short code attr values.
	 *
	 * @return bool true on success or false on failure.
	 */
	public function display_faqs_list( $attributes ) {

		$attributes = $this->old_shortcode_fallback( $attributes );

		extract(
			shortcode_atts(
				[
					'style'   => '',    // Possible Values: toggle, accordion, toggle-grouped, accordion-grouped
					'filter'  => false,
					'orderby' => 'date',
					'order'   => 'DESC',
				],
				$attributes,
				'faqs'
			)
		);

		// faq groups filter.
		if ( isset( $filter ) && ! empty( $filter ) && 'true' != $filter ) {
			$filter = explode( ',', $filter );
		}

		ob_start();

		$faqs_fa_style = $this->get_option( 'faqs_fontawesome_style', 'qaef_basics' );
		if ( 'on' !== $faqs_fa_style ) {
			wp_enqueue_style( 'font-awesome' );
		}

		wp_enqueue_style( $this->plugin_name );

		if ( is_rtl() ) {
			wp_enqueue_style( $this->plugin_name . '-rtl' );
		}

		$faqs_query = new Faqs_Query( $style, $filter, $orderby, $order );
		$faqs_query->render();

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

	/**
	 * Register FAQs short codes
	 */
	public function register_faqs_shortcodes() {
		add_shortcode( 'faqs', array( $this, 'display_faqs_list' ) );
	}

	/**
	 * Integrate shortcode with Visual Composer
	 */
	public function integrate_shortcode_with_vc() {

		vc_map(
			[
				'name'        => __( 'Quick and Easy FAQs', 'quick-and-easy-faqs' ),
				'description' => __( 'Quick and Easy FAQs Plugin', 'quick-and-easy-faqs' ),
				'base'        => 'faqs',
				'category'    => __( 'Content', 'quick-and-easy-faqs' ),
				'params'      => [
					[
						'type'        => 'dropdown',
						'heading'     => __( 'Display Style', 'quick-and-easy-faqs' ),
						'param_name'  => 'style',
						'value'       => [
							'Default'           => '',
							'Toggle'            => 'toggle',
							'Accordion'         => 'accordion',
							'Grouped'         => 'grouped',
							'Toggle Grouped'    => 'toggle-grouped',
							'Accordion Grouped' => 'accordion-grouped',
						],
						'admin_label' => true,
					],
					[
						'type'        => 'dropdown',
						'heading'     => __( 'FAQs Filters', 'quick-and-easy-faqs' ),
						'param_name'  => 'filter',
						'value'       => [
							'Default'  => '',
							'Yes'  => 'true',
							'No'  => 'false',
						],
						'admin_label' => true,
					],
					[
						'type'        => 'dropdown',
						'heading'     => __( 'FAQs Order', 'quick-and-easy-faqs' ),
						'param_name'  => 'order',
						'value'       => [
							'Default'  => '',
							'Ascending'  => 'ASC',
							'Descending'  => 'DESC',
						],
						'admin_label' => true,
					],
					[
						'type'        => 'dropdown',
						'heading'     => __( 'FAQs Order By', 'quick-and-easy-faqs' ),
						'param_name'  => 'orderby',
						'value'       => [
							'Default'  => '',
							'ID'  => 'ID',
							'Author'  => 'author',
							'Title'  => 'title',
							'Name'  => 'name',
							'Type'  => 'type',
							'Date'  => 'date',
							'Modified'  => 'modified',
							'Parent'  => 'parent',
							'Random'  => 'rand',
						],
						'admin_label' => true,
					],
				],
			]
		);

	}
}
