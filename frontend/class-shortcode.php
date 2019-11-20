<?php
/**
 * The public-facing functionality of the plugin.
 */

namespace Quick_And_Easy_Faqs\Frontend;

use Quick_And_Easy_Faqs\Includes\Faqs_Query;

class Shortcode {

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

		if ( isset( $attr['grouped'] ) && 'yes' === $attr['grouped'] ) {
			$attr['style'] = 'grouped';
			unset( $attr['grouped'] );
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
					'style'  => '',
					'filter' => false,
				],
				$attributes,
				'faqs'
			)
		);

		// faq groups filter.
		if ( isset( $filter ) && ! empty( $filter ) && true !== $filter ) {
			$filter = explode( ',', $filter );
		}

		ob_start();

		wp_enqueue_style( 'font-awesome' );
		wp_enqueue_style( $this->plugin_name );

		if ( is_rtl() ) {
			wp_enqueue_style( $this->plugin_name . '-rtl' );
		}

		$faqs_query = new Faqs_Query( $style, $filter );
		$faqs_query->render();

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
							'Simple List'       => 'list',
							'Toggle'            => 'toggle',
							'Filterable Toggle' => 'filterable-toggle',
						],
						'admin_label' => true,
					],
					[
						'type'        => 'dropdown',
						'heading'     => __( 'Display FAQs in Groups', 'quick-and-easy-faqs' ),
						'param_name'  => 'grouped',
						'value'       => [
							__( 'Yes', 'framework' ) => 'yes',
							__( 'No', 'framework' )  => 'no',
						],
						'admin_label' => true,
					],
				],
			]
		);

	}
}
