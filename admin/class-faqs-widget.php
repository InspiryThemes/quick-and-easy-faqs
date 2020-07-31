<?php
/**
 * Widget: Featured Properties Widget
 *
 * @since 3.0.0
 * @package RH/modern
 */

namespace Quick_And_Easy_FAQs\Admin;

use Quick_And_Easy_FAQs\Includes\FAQs_Query;
use Quick_And_Easy_FAQs\Includes\Utilities;

	/**
	 * FAQs_Widget.
	 *
	 * Widget of FAQs.
	 *
	 * @since 3.0.0
	 */
class FAQs_Widget extends \WP_Widget {

	/**
	 * Method: Constructor
	 *
	 * @since  1.0.0
	 */
	function __construct() {
		$widget_ops = array(
			'classname'                   => 'FAQs_Widget',
			'description'                 => esc_html__( 'Displays FAQs list with filters.', 'quick-and-easy-faqs' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct(
			'FAQs_Widget',
			__( 'Quick and Easy FAQs', 'quick-and-easy-faqs' ),
			$widget_ops
		);
	}

	/**
	 * Method: Widget Front-End
	 *
	 * @param array $args - Arguments of the widget.
	 * @param array $instance - Instance of the widget.
	 */
	function widget( $args, $instance ) {

		extract( $args );

		// Title.
		if ( isset( $instance['title'] ) ) {
			$title = apply_filters( 'widget_title', $instance['title'] );
		}

		if ( empty( $title ) ) {
			$title = false;
		}

		// Order by.
		if ( isset( $instance['sort_by'] ) ) {
			$sort_by = $instance['sort_by'];
		}

		// Order.
		if ( isset( $instance['sort'] ) ) {
			$sort = $instance['sort'];
		}

		// Style.
		if ( isset( $instance['style'] ) ) {
			$style = $instance['style'];
		}

		// Filters.
		if ( isset( $instance['filter'] ) ) {
				$filter = $instance['filter'];
		}

			echo $before_widget;

		if ( $title ) :
			echo $before_title;
			echo $title;
			echo $after_title;
			endif;

			$utilities = new Utilities();

			$faqs_fa_style = $utilities->get_option( 'faqs_fontawesome_style', 'qaef_basics' );

		if ( 'on' !== $faqs_fa_style ) {
			wp_enqueue_style(
				'font-awesome',
				dirname( plugin_dir_url( __FILE__ ) ) . '/frontend/css/all.min.css',
				array(),
				$this->version,
				'all'
			);
		}

		wp_enqueue_style(
			'quick-and-easy-faqs',
			dirname( plugin_dir_url( __FILE__ ) ) . '/frontend/css/styles-public.css',
			array(),
			$this->version,
			'all'
		);

		wp_register_script(
			'quick-and-easy-faqs',
			dirname( plugin_dir_url( __FILE__ ) ) . '/frontend/js/scripts.js',
			array( 'jquery' ),
			$this->version,
			true
		);

		wp_localize_script(
			'quick-and-easy-faqs',
			'qaef_object',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'style'   => $style,
			)
		);
		wp_enqueue_script( 'quick-and-easy-faqs' );

		// if rtl is enabled.
		if ( is_rtl() ) {
			wp_enqueue_style(
				'quick-and-easy-faqs-rtl',
				dirname( plugin_dir_url( __FILE__ ) ) . '/public/css/styles-public-rtl.css',
				array(
					$this->plugin_name,
					'font-awesome',
				),
				$this->version,
				'all'
			);
		}

			$faqs_query = new FAQs_Query( $style, $filter, $sort_by, $sort );
			$faqs_query->render();

			echo $after_widget;
	}

	/**
	 * Method: Widget Backend Form
	 *
	 * @param array $instance - Instance of the widget.
	 *
	 * @return void
	 */
	function form( $instance ) {

		$instance = wp_parse_args(
			(array) $instance,
			array(
				'title'   => 'FAQs',
				'sort_by' => 'date',
				'sort'    => 'DESC',
				'style'   => 'toggle',
				'filter'  => false,
			)
		);

		$title   = esc_attr( $instance['title'] );
		$sort_by = $instance['sort_by'];
		$sort    = $instance['sort'];
		$style   = $instance['style'];
		$filter  = $instance['filter'];
		?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Widget Title', 'quick-and-easy-faqs' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
					   name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
					   value="<?php echo esc_attr( $title ); ?>"/>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'sort_by' ) ); ?>"><?php esc_html_e( 'Order By:', 'quick-and-easy-faqs' ); ?></label>
				<select name="<?php echo esc_attr( $this->get_field_name( 'sort_by' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'sort_by' ) ); ?>" class="widefat">
					<option value="date" <?php selected( $sort_by, 'date' ); ?>><?php esc_html_e( 'Date', 'quick-and-easy-faqs' ); ?></option>
					<option value="id" <?php selected( $sort_by, 'id' ); ?>><?php esc_html_e( 'ID', 'quick-and-easy-faqs' ); ?></option>
					<option value="author" <?php selected( $sort_by, 'author' ); ?>><?php esc_html_e( 'Author', 'quick-and-easy-faqs' ); ?></option>
					<option value="name" <?php selected( $sort_by, 'name' ); ?>><?php esc_html_e( 'Name', 'quick-and-easy-faqs' ); ?></option>
					<option value="modified" <?php selected( $sort_by, 'modified' ); ?>><?php esc_html_e( 'Modified', 'quick-and-easy-faqs' ); ?></option>
					<option value="rand" <?php selected( $sort_by, 'rand' ); ?>><?php esc_html_e( 'Rand', 'quick-and-easy-faqs' ); ?></option>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'sort' ) ); ?>"><?php esc_html_e( 'Order:', 'quick-and-easy-faqs' ); ?></label>
				<select name="<?php echo esc_attr( $this->get_field_name( 'sort' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'sort' ) ); ?>" class="widefat">
					<option value="ASC" <?php selected( $sort, 'ASC' ); ?>><?php esc_html_e( 'Ascending', 'quick-and-easy-faqs' ); ?></option>
					<option value="DESC" <?php selected( $sort, 'DESC' ); ?>><?php esc_html_e( 'Descending', 'quick-and-easy-faqs' ); ?></option>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'filter' ) ); ?>"><?php esc_html_e( 'Filters:', 'quick-and-easy-faqs' ); ?></label>
				<select multiple="multiple" name="<?php echo esc_attr( $this->get_field_name( 'filter' ) ) . '[]'; ?>" id="<?php echo esc_attr( $this->get_field_id( 'filter' ) ); ?>" class="widefat" size="5">
					<?php

					$terms = get_terms(
						array(
							'taxonomy'   => 'faq-group',
							'hide_empty' => false,
						)
					);

					if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
						foreach ( $terms as $term ) {

							printf(
								'<option value="%s" class="hot-topic" %s style="margin-bottom:3px;">%s</option>',
								$term->slug,
								in_array(  $term->slug, $filter) ? 'selected="selected"' : '',
								$term->name
							);
						
						}
					}

					?>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'style' ) ); ?>"><?php esc_html_e( 'Style:', 'quick-and-easy-faqs' ); ?></label>
				<select name="<?php echo esc_attr( $this->get_field_name( 'style' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'style' ) ); ?>" class="widefat">
					<option value="" <?php selected( $style, '' ); ?>><?php esc_html_e( 'List', 'quick-and-easy-faqs' ); ?></option>
					<option value="toggle" <?php selected( $style, 'toggle' ); ?>><?php esc_html_e( 'Toggle', 'quick-and-easy-faqs' ); ?></option>
					<option value="accordion" <?php selected( $style, 'accordion' ); ?>><?php esc_html_e( 'Accordion', 'quick-and-easy-faqs' ); ?></option>
					<option value="grouped" <?php selected( $style, 'grouped' ); ?>><?php esc_html_e( 'Grouped', 'quick-and-easy-faqs' ); ?></option>
					<option value="toggle-grouped" <?php selected( $style, 'toggle-grouped' ); ?>><?php esc_html_e( 'Toggle Grouped', 'quick-and-easy-faqs' ); ?></option>
					<option value="accordion-grouped" <?php selected( $style, 'accordion-grouped' ); ?>><?php esc_html_e( 'Accordion Grouped', 'quick-and-easy-faqs' ); ?></option>
				</select>
			</p>
			<?php
	}

	/**
	 * Method: Widget Update Function
	 *
	 * @param array $new_instance - New instance of the widget.
	 * @param array $old_instance - Old instance of the widget.
	 *
	 * @return array
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']   = strip_tags( $new_instance['title'] );
		$instance['sort_by'] = $new_instance['sort_by'];
		$instance['sort']    = $new_instance['sort'];
		$instance['style']   = $new_instance['style'];
		$instance['filter']  = $new_instance['filter'];

		return $instance;
	}

	function register_faqs_widget() {
		register_widget( 'Quick_And_Easy_FAQs\Admin\FAQs_Widget' );
	}

}
