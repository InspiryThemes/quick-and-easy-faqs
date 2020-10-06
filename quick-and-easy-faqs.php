<?php
/**
 * Plugin Name:       Quick and Easy FAQs
 * Plugin URI:        https://github.com/inspirythemes/quick-and-easy-faqs
 * Description:       A quick and easy way to add FAQs to your site.
 * Version:           1.3.4
 * Author:            Inspiry Themes
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


if ( ! function_exists( 'qaef_fs' ) ) {
	// Create a helper function for easy SDK access.
	function qaef_fs() {
		global $qaef_fs;

		if ( ! isset( $qaef_fs ) ) {
			// Include Freemius SDK.
			require_once dirname( __FILE__ ) . '/freemius/start.php';

			$qaef_fs = fs_dynamic_init(
				array(
					'id'                  => '6081',
					'slug'                => 'quick-and-easy-faqs',
					'type'                => 'plugin',
					'public_key'          => 'pk_265e73b44a00b79f42a7a6ec9669d',
					'is_premium'          => true,
					'premium_suffix'      => 'FAQs Professional',
					// If your plugin is a serviceware, set this option to false.
					'has_premium_version' => true,
					'has_addons'          => false,
					'has_paid_plans'      => true,
					'menu'                => array(
						'slug'           => 'quick_and_easy_faqs',
						'override_exact' => true,
						'contact'        => false,
						'support'        => false,
						'parent'         => array(
							'slug' => 'edit.php?post_type=faq',
						),
					),
					// Set the SDK to work in a sandbox mode (for development & testing).
					// IMPORTANT: MAKE SURE TO REMOVE SECRET KEY BEFORE DEPLOYMENT.
					'secret_key'          => 'sk_A?n{p.Me7ucudS?0{!Vo^]D7<.aw#',
				)
			);
		}

		return $qaef_fs;
	}

	// Init Freemius.
	qaef_fs();
	// Signal that SDK was initiated.
	do_action( 'qaef_fs_loaded' );

	function qaef_fs_settings_url() {
		return admin_url( 'edit.php?post_type=faq&page=quick_and_easy_faqs' );
	}

	qaef_fs()->add_filter( 'connect_url', 'qaef_fs_settings_url' );
	qaef_fs()->add_filter( 'after_skip_url', 'qaef_fs_settings_url' );
	qaef_fs()->add_filter( 'after_connect_url', 'qaef_fs_settings_url' );
	qaef_fs()->add_filter( 'after_pending_connect_url', 'qaef_fs_settings_url' );
}

/**
 * Global Constants to be used throughout the plugin
 */
define( 'QUICK_AND_EASY_FAQS_VERSION', '1.3.4' );

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

