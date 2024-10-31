<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.90lines.com
 * @since             1.0.0
 * @package           wcrp
 *
 * @wordpress-plugin
 * Plugin Name:       Woo Custom Related product by SKU
 * Plugin URI:        https://www.wcrp.90lines.com
 * Description:       Choose the products you want to set as related.

 * Version:           1.0.0
 * Author:            90Lines
 * Author URI:        https://www.90lines.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wcrp
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
define( 'WCRP_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wcrp-activator.php
 */
function activate_wcrp() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wcrp-activator.php';
	Wcrp_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wcrp-deactivator.php
 */
function deactivate_wcrp() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wcrp-deactivator.php';
	Wcrp_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wcrp' );
register_deactivation_hook( __FILE__, 'deactivate_wcrp' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wcrp.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wcrp() {

	$plugin = new Wcrp();
	$plugin->run();

}
run_wcrp();
