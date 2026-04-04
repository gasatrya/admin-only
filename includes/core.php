<?php
/**
 * Core functionality for Admin Only Dashboard plugin
 *
 * @package Admin_Only_Dashboard
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get default plugin settings.
 *
 * @return array Default settings.
 */
function admon_get_default_settings() {
	return array(
		'session_timeout'      => '',
		'custom_timeout_hours' => '',
		'apply_to_admins'      => 0,
		'override_remember_me' => 0,
		'allowed_users'        => '',
		'custom_redirect'      => '',
	);
}

/**
 * Get plugin settings.
 *
 * @return array Plugin settings.
 */
function admon_get_settings() {
	static $settings = null;

	if ( null === $settings ) {
		$settings = get_option( 'admin_only_settings', array() );
		$settings = wp_parse_args( $settings, admon_get_default_settings() );
	}

	return $settings;
}

/**
 * Validate usernames in whitelist and return validation results.
 *
 * @param string $usernames Comma-separated usernames.
 * @return array Validation results with 'valid_usernames' and 'invalid_usernames'.
 */
function admon_validate_usernames_with_feedback( $usernames ) {
	if ( empty( $usernames ) ) {
		return array(
			'valid_usernames'   => '',
			'invalid_usernames' => array(),
		);
	}

	$username_list     = array_map( 'trim', explode( ',', $usernames ) );
	$valid_usernames   = array();
	$invalid_usernames = array();

	foreach ( $username_list as $username ) {
		if ( ! empty( $username ) ) {
			// Check if username exists in database.
			$user = get_user_by( 'login', $username );
			if ( $user ) {
				$valid_usernames[] = $username;
			} else {
				$invalid_usernames[] = $username;
			}
		}
	}

	return array(
		'valid_usernames'   => implode( ', ', $valid_usernames ),
		'invalid_usernames' => $invalid_usernames,
	);
}

/**
 * Redirects the user to the home page if they do not have the
 * capability to manage options.
 */
function admon_dashboard_redirect() {
	if ( ! admon_user_has_access() && ! wp_doing_ajax() ) {
		wp_safe_redirect( admon_get_redirect_url() );
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
	return admon_user_has_access() ? $show_admin_bar : false;
}
add_filter( 'show_admin_bar', 'admon_hide_toolbar' );

/**
 * Check if current user has access to dashboard
 *
 * @return bool True if user has access, false otherwise
 */
function admon_user_has_access() {
	static $has_access = null;

	if ( null !== $has_access ) {
		return $has_access;
	}

	$has_access = current_user_can( apply_filters( 'admon_access_capability', 'manage_options' ) );

	// Apply whitelist logic if settings exist.
	$settings = admon_get_settings();
	if ( ! empty( $settings['allowed_users'] ) ) {
		$current_user  = wp_get_current_user();
		$allowed_users = array_map( 'trim', explode( ',', $settings['allowed_users'] ) );

		// Always allow administrators.
		if ( current_user_can( apply_filters( 'admon_access_capability', 'manage_options' ) ) ) {
			$has_access = true;
		} elseif ( in_array( $current_user->user_login, $allowed_users, true ) ) {
			// Check if user is in whitelist.
			$has_access = true;
		}
	}

	$has_access = apply_filters( 'admon_user_has_access', $has_access );

	return $has_access;
}

/**
 * Validate if URL is within the same WordPress site
 *
 * @param string $url URL to validate.
 * @return string|false Sanitized URL if valid, false otherwise.
 */
function admon_validate_same_site_url( $url ) {
	if ( empty( $url ) ) {
		return false;
	}

	// Use WordPress's built-in redirect validation to ensure the URL is safe.
	$validated_url = wp_validate_redirect( $url, false );

	// If wp_validate_redirect returns false, it's not a safe internal/same-site URL.
	if ( false === $validated_url ) {
		return false;
	}

	return esc_url_raw( $validated_url );
}

/**
 * Get redirect URL for blocked users
 *
 * @return string Redirect URL
 */
function admon_get_redirect_url() {
	$settings     = admon_get_settings();
	$redirect_url = home_url( '/' );

	// Use custom redirect URL if set and valid.
	if ( ! empty( $settings['custom_redirect'] ) ) {
		$custom_url = admon_validate_same_site_url( $settings['custom_redirect'] );
		if ( ! empty( $custom_url ) ) {
			$redirect_url = $custom_url;
		}
	}

	return apply_filters( 'admon_redirect_page', $redirect_url );
}
