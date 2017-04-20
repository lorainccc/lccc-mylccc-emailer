<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.lorainccc.edu
 * @since             1.0.0
 * @package           Mylccc_Emailer
 *
 * @wordpress-plugin
 * Plugin Name:       MyLCCC Emailer
 * Plugin URI:        http://www.lorainccc.edu
 * Description:       Allows the daily activity email post to be built and scheduled for mailing.
 * Version:           1.0.0
 * Author:            LCCC Web Dev Team
 * Author URI:        http://www.lorainccc.edu
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       mylccc-emailer
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-mylccc-emailer-activator.php
 */
function activate_mylccc_emailer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mylccc-emailer-activator.php';
	Mylccc_Emailer_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-mylccc-emailer-deactivator.php
 */
function deactivate_mylccc_emailer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mylccc-emailer-deactivator.php';
	Mylccc_Emailer_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_mylccc_emailer' );
register_deactivation_hook( __FILE__, 'deactivate_mylccc_emailer' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-mylccc-emailer.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_mylccc_emailer() {

	$plugin = new Mylccc_Emailer();
	$plugin->run();

}
run_mylccc_emailer();

/**
	*	Emailer Custom Post Type
	*
	*	@since 1.0.0
	*/

/* Check if scripts are enqueued or not */
	if ( wp_script_is( 'jquery-ui-datepicker', 'enqueued' ) ) {
		return;
	} else {
		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
	}


 /* Load Plugin logic */

	require_once( plugin_dir_path( __FILE__ ) . 'php/email-post-type.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'php/email-metabox.php' );
