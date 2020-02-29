<?php
/**
 * It includes basic methods which will be used across both the
 * public-facing side of the site and the admin area.
 */

namespace Quick_And_Easy_Faqs\Includes;

class Utilities {

	/**
	 * Get the value of a settings field
	 *
	 * @param string $option settings field name.
	 * @param string $section the section name this field belongs to.
	 * @param string $default default text if it's not found.
	 *
	 * @return mixed
	 */
	protected function get_option( $option, $section, $default = '' ) {

		$options = get_option( $section );

		if ( isset( $options[ $option ] ) ) {
			return $options[ $option ];
		}

		return $default;
	}
}
