<?php

namespace Quick_And_Easy_Faqs\Includes;

/**
 * This class holds all the faqs query related members and methods.
 */
class Faqs_Query {

	/**
	 * Holds the query of faqs.
	 *
	 * @var array $faqs_query
	 */
	private $faqs_query;

	/**
	 * Holds the value of display type of faqs.
	 *
	 * @var string $display
	 */
	protected $display;

	/**
	 * The filters of this plugin.
	 *
	 * @var bool | array $filters
	 */
	protected $filters;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string       $display Display type of plugin.
	 * @param bool | array $filters The filters of this plugin.
	 */
	public function __construct( $display = '', $filters = false || [] ) {

		$this->display    = $display;
		$this->filters    = $filters;
		$this->faqs_query = $this->query_build();
	}

	/**
	 * Build the basic query for faqs.
	 */
	protected function query_build() {

		$query = [
			'post_type'      => 'faq',
			'posts_per_page' => - 1,
		];

		if ( is_array( $this->filters ) && ! empty( $this->filters ) ) {

			$query['tax_query'] = [

				[
					'taxonomy' => 'faq-group',
					'field'    => 'slug',
					'terms'    => $this->filters,
				],
			];
		} elseif ( $this->filters || 'grouped' === $this->display ) {

			$terms = get_terms(
				[
					'taxonomy' => 'faq-group',
					'fields'   => 'slugs',
				]
			);

			$this->filters = $terms;

			if ( ! empty( $terms ) ) {

				$query['tax_query'] = [
					[
						'taxonomy' => 'faq-group',
						'field'    => 'slug',
						'terms'    => $terms,
					],
				];
			}
		}

		return $query;
	}

	/**
	 * Build and render the faqs
	 *
	 * @param string $id Html Post ID.
	 * @param string $class Html class.
	 */
	protected function build_faqs_structure( $id, $class = 'faq-content' ) {
		?>
		<div id="qaef-<?php echo esc_attr( $id ); ?>" class="qe-<?php echo esc_attr( $class ); ?>">
			<div class="qe-toggle-title">
				<h4><i class="fa fa-plus-circle"></i><?php echo esc_html( get_the_title( $id ) ); ?></h4>
			</div>
			<div class="qe-<?php echo esc_attr( $class ); ?>"><?php echo get_the_content( $id ); ?></div>
		</div>
		<?php
	}


	/**
	 * Build and render the faqs
	 *
	 * @param array $faq_terms_posts Holds the faq terms as slug and faqs ids as associative array.
	 */
	protected function build_titles_structure( $faq_terms_posts ) {

		echo '<div id="qe-faqs-index" class="qe-faqs-index"><ol class="qe-faqs-index-list">';

		foreach ( $faq_terms_posts as $slug => $faq_ids ) {

			if ( is_array( $faq_ids ) ) {

				echo '<h4 class="qe-faqs-group-title">' . esc_html( ucwords( str_replace( '-', ' ', $slug ) ) ) . '</h4>';

				foreach ( $faq_ids as $id ) {
					?>
					<li>
						<a href="#qaef-<?php echo esc_attr( $id ); ?>"><?php echo esc_html( get_the_title( $id ) ); ?></a>
					</li>
					<?php
				}
			} else {
				?>
				<li>
					<a href="#qaef-<?php echo esc_attr( $faq_ids ); ?>"><?php echo esc_html( get_the_title( $faq_ids ) ); ?></a>
				</li>
				<?php
			}
		}
		echo '</ol></div>';
	}


	/**
	 * Render the faqs title
	 *
	 * @param array $faqs_posts_ids Faqs posts ids.
	 */
	protected function render_faqs_title( $faqs_posts_ids ) {

		if ( 'grouped' === $this->display ) {

			$faq_terms_posts = [];

			foreach ( $faqs_posts_ids as $id ) {

				$terms = get_the_terms( $id, 'faq-group' );

				if ( $terms && ! is_wp_error( $terms ) ) {

					foreach ( $terms as $term ) {
						$faq_terms_posts[ $term->slug ][] = $id;
					}
				}
			}

			$this->build_titles_structure( $faq_terms_posts );

		} else {
			$this->build_titles_structure( $faqs_posts_ids );
		}
	}

	/**
	 * Render the faqs
	 */
	public function render() {

		$faq_posts = new \WP_Query( $this->faqs_query );

		if ( $faq_posts->have_posts() ) :

			$faqs_array     = $faq_posts->posts;
			$faqs_posts_ids = wp_list_pluck( $faqs_array, 'ID' );
			$this->render_faqs_title( $faqs_posts_ids );

			while ( $faq_posts->have_posts() ) :
				$faq_posts->the_post();

				switch ( $this->display ) {

					case 'toggle':
						$this->build_faqs_structure( get_the_ID(), 'faq-toggle' );
						break;

					case 'accordion':
						$this->build_faqs_structure( get_the_ID(), 'faq-toggle' );
						break;

					default:
						$this->build_faqs_structure( get_the_ID() );
						break;
				};
			endwhile;
		endif;

		// All the custom loops ends here so reset the query.
		wp_reset_query();
	}

}
