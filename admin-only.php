<?php
/**
 * Admin Only Dashboard
 *
 * @package           Admin Only Dashboard
 * @author            Ga Satrya
 * @copyright         2023 - 2025 Ga Satrya
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Disable Dashboard Access
 * Plugin URI:        https://wordpress.org/plugins/admin-only/
 * Description:       Disable Dashboard Access: Only administrators can access the WordPress dashboard by default. Easily allow specific users to log in via a simple whitelist. Quick and easy setup.
 * Version:           1.1.1
 * Requires at least: 6.5
 * Requires PHP:      7.0
 * Author:            Ga Satrya
 * Author URI:        https://www.ctaflow.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define plugin constants.
define( 'ADMON_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'ADMON_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * Load plugin functionality.
 */
function admon_load_plugin() {
	// Load core functionality.
	require_once ADMON_PLUGIN_DIR . 'includes/core.php';

	// Load session functionality.
	require_once ADMON_PLUGIN_DIR . 'includes/session.php';

	// Load admin functionality.
	if ( is_admin() ) {
		require_once ADMON_PLUGIN_DIR . 'admin/settings.php';
	}
}
add_action( 'plugins_loaded', 'admon_load_plugin' );
