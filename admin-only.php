<?php
/**
 * Admin Only
 *
 * @package           Admin Only
 * @author            Ga Satrya
 * @copyright         2023 Ga Satrya
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Admin Only
 * Plugin URI:        https://gasatrya.dev/
 * Description:       Restrict admin access to administrator only.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.4
 * Author:            Ga Satrya
 * Author URI:        https://gasatrya.dev/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       admin-only
 * Domain Path:       /languages
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Redirects the user to the home page if they do not have the
 * capability to manage options.
 */
function ao_dashboard_redirect() {
	if ( ! current_user_can( apply_filters( 'ao_access_capability', 'manage_options' ) ) ) {
		wp_safe_redirect( apply_filters( 'ao_redirect_page', home_url( '/' ) ) );
		exit;
	}
}
add_action( 'admin_init', 'ao_dashboard_redirect' );

/**
 * Hides the toolbar for non-admin users.
 *
 * @param bool $show_admin_bar Whether to show the admin toolbar.
 * @return bool Whether to show the admin toolbar.
 */
function ao_hide_toolbar( $show_admin_bar ) {
	return ( current_user_can( apply_filters( 'ao_access_capability', 'manage_options' ) ) ) ? $show_admin_bar : false;
}
add_filter( 'show_admin_bar', 'ao_hide_toolbar' );
