<?php
/**
 * Admin Only Dashboard
 *
 * @package           Admin Only Dashboard
 * @author            Ga Satrya
 * @copyright         2023 - 2024 Ga Satrya
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Admin Only Dashboard
 * Plugin URI:        https://wordpress.org/plugins/admin-only/
 * Description:       This plugin allows you to restrict access to the dashboard area, ensuring that only administrators have the privilege to manage and control your site's backend.
 * Version:           1.0.0
 * Requires at least: 3.3
 * Requires PHP:      7.0
 * Author:            Ga Satrya
 * Author URI:        https://gasatrya.dev/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Redirects the user to the home page if they do not have the
 * capability to manage options.
 */
function admon_dashboard_redirect() {
	if ( ! current_user_can( apply_filters( 'admon_access_capability', 'manage_options' ) ) && ! wp_doing_ajax() ) {
		wp_safe_redirect( apply_filters( 'admon_redirect_page', home_url( '/' ) ) );
		exit;
	}
}
add_action( 'admin_init', 'admon_dashboard_redirect' );

/**
 * Hides the toolbar for non-admin users.
 *
 * @param bool $show_admin_bar Whether to show the admin toolbar.
 * @return bool Whether to show the admin toolbar.
 */
function admon_hide_toolbar( $show_admin_bar ) {
	return ( current_user_can( apply_filters( 'admon_access_capability', 'manage_options' ) ) ) ? $show_admin_bar : false;
}
add_filter( 'show_admin_bar', 'admon_hide_toolbar' );
