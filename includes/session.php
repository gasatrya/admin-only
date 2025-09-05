<?php
/**
 * Session expiration functionality for Admin Only Dashboard plugin
 *
 * @package Admin_Only_Dashboard
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Set session expiration based on plugin settings
 *
 * @param int  $expiration Current expiration time in seconds.
 * @param int  $user_id User ID.
 * @param bool $remember Whether to remember the user.
 * @return int Modified expiration time
 */
function admon_set_session_expiration( $expiration, $user_id, $remember ) {
	$settings = get_option( 'admin_only_settings', array() );

	// Check if session timeout is enabled.
	if ( empty( $settings['session_timeout'] ) ) {
		return $expiration;
	}

	// Check if we should apply to administrators.
	$apply_to_admins = ! empty( $settings['apply_to_admins'] );
	$user            = get_userdata( $user_id );

	// Skip if user is admin and we're not applying to admins.
	if ( $user && $user->has_cap( 'manage_options' ) && ! $apply_to_admins ) {
		return $expiration;
	}

	// Convert hours to seconds.
	$timeout_hours   = absint( $settings['session_timeout'] );
	$timeout_seconds = $timeout_hours * HOUR_IN_SECONDS;

	// Return the custom timeout.
	return $timeout_seconds;
}
add_filter( 'auth_cookie_expiration', 'admon_set_session_expiration', 10, 3 );
