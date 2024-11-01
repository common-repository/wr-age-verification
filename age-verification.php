<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.webriderz.com/
 * @since             2.0.0
 * @package           Age_Verification
 *
 * @wordpress-plugin
 * Plugin Name:       Wr Age Verification
 * Plugin URI:        https://www.webriderz.com/
 * Description:       Verify a visitors age before allowing them to view your website.
 * Version:           2.0.0
 * Author:            Webriderz
 * Author URI:        https://www.webriderz.com/company
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wr-age-verification
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'AGE_VERIFICATION_VERSION', '1.0.0' );
define( 'AGE_VERIFICATION_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-age-verification-activator.php
 */
function activate_age_verification() {
	require_once( AGE_VERIFICATION_PLUGIN_PATH . 'includes/class-age-verification-activator.php' );
	Age_Verification_Activator::activate();
	Age_Verification_Activator::insert_av_country();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-age-verification-deactivator.php
 */
function deactivate_age_verification() {
	require_once( AGE_VERIFICATION_PLUGIN_PATH . 'includes/class-age-verification-deactivator.php' );
	Age_Verification_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_age_verification' );
register_deactivation_hook( __FILE__, 'deactivate_age_verification' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require( AGE_VERIFICATION_PLUGIN_PATH . 'includes/class-age-verification.php' );

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_age_verification() {

	$plugin = new Age_Verification();
	$plugin->run();

}
run_age_verification();
