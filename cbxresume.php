<?php

/**
 *
 * @link              https://codeboxr.com
 * @since             1.0.0
 * @package           CBXResume
 *
 * @wordpress-plugin
 * Plugin Name:       CBX Resume
 * Plugin URI:        https://codeboxr.com/product/cbxresume-for-wordpress/
 * Description:       Making resume easily .
 * Version:           1.0.0
 * Author:            Codeboxr
 * Author URI:        https://codeboxr.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       cbxresume
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


defined( 'CBXRESUME_PLUGIN_NAME' ) or define( 'CBXRESUME_PLUGIN_NAME', 'cbxresume' );
defined( 'CBXRESUME_PLUGIN_VERSION' ) or define( 'CBXRESUME_PLUGIN_VERSION', '1.0.0' );
defined( 'CBXRESUME_BASE_NAME' ) or define( 'CBXRESUME_BASE_NAME', plugin_basename( __FILE__ ) );
defined( 'CBXRESUME_ROOT_PATH' ) or define( 'CBXRESUME_ROOT_PATH', plugin_dir_path( __FILE__ ) );
defined( 'CBXRESUME_ROOT_URL' ) or define( 'CBXRESUME_ROOT_URL', plugin_dir_url( __FILE__ ) );


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-cbxresume-activator.php
 */
function activate_cbxresume() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-cbxresume-activator.php';
	CBXResume_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-cbxresume-deactivator.php
 */
function deactivate_cbxresume() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-cbxresume-deactivator.php';
	CBXResume_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_cbxresume' );
register_deactivation_hook( __FILE__, 'deactivate_cbxresume' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-cbxresume.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_cbxresume() {
	$plugin = new CBXResume();
	$plugin->run();
}

run_cbxresume();
