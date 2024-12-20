<?php
/**
 * Plugin Name:       Quick and Easy FAQs
 * Plugin URI:        https://wordpress.org/plugins/quick-and-easy-faqs/
 * Description:       A quick and easy way to add FAQs to your site.
 * Version:           1.3.12
 * Tested up to:      6.7.1
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * Author:            InspiryThemes
 * Author URI:        https://inspirythemes.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       quick-and-easy-faqs
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'QUICK_AND_EASY_FAQS_VERSION', qefaq_get_plugin_details() );
define( 'QUICK_AND_EASY_FAQS_BASENAME', plugin_basename( __FILE__ ) );

/**
 * Get plugin details safely
 *
 * @since 1.3.12
 *
 * @param string $key   Key to fetch plugin detail
 *
 * @return string|mixed
 */
function qefaq_get_plugin_details( $key = 'Version' ) {
	require_once ABSPATH . 'wp-admin/includes/plugin.php';

	// Prevent early translation call by setting $translate to false.
	$plugin_data = get_plugin_data( __FILE__,false,false );

	return $plugin_data[$key];
}

/**
 * The core plugin class that is used to define all site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/autoload.php';

use Quick_And_Easy_FAQs\Includes\FAQs;

/**
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does not affect the page life cycle.
 */
function run_quick_and_easy_faqs() {

	return FAQs::instance();

}

run_quick_and_easy_faqs();

