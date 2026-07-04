<?php
/**
 * Uninstall handler for UserFlow (Admin Only Dashboard).
 *
 * Cleans up the plugin option when the plugin is deleted.
 *
 * @package Admin_Only_Dashboard
 */

// Exit if not called from WordPress uninstaller.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

delete_option( 'admin_only_settings' );
