<?php
/**
 * Plugin Name:       Quick and Easy FAQs
 * Plugin URI:        https://github.com/inspirythemes/quick-and-easy-faqs
 * Description:       A quick and easy way to add FAQs to your site.
 * Version:           1.1.3
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

/**
 * Global Constants to be used throughout the plugin
 */
define( 'QE_FAQS_PLUGIN_BASENAME', plugin_basename(__FILE__) );
define( 'QE_FAQS_PLUGIN_NAME', 'quick-and-easy-faqs' );
define( 'QE_FAQS_PLUGIN_VERSION', '1.1.3' );

/**
 * Loading core class for the admin (backend) side
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-quick-and-easy-faqs-admin.php';

/**
 * Loading core class for the public (frontend) side
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-quick-and-easy-faqs-public.php';
