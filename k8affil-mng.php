<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           K8affil_Mng
 *
 * @wordpress-plugin
 * Plugin Name:       Sync
 * Description:       This plugin helps syncronize data between anbieter websites, as well as Affiliates coupons data between different websites
 * Version:           1.0.0
 * Author:            Krapivko Dmitrii
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       k8affil-mng
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
define( 'K8AFFIL_MNG_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-k8affil-mng-activator.php
 */
function activate_k8affil_mng() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-k8affil-mng-activator.php';
	K8affil_Mng_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-k8affil-mng-deactivator.php
 */
function deactivate_k8affil_mng() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-k8affil-mng-deactivator.php';
	K8affil_Mng_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_k8affil_mng' );
register_deactivation_hook( __FILE__, 'deactivate_k8affil_mng' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-k8affil-mng.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_k8affil_mng() {

	$plugin = new K8affil_Mng();
	$plugin->run();

}
run_k8affil_mng();
