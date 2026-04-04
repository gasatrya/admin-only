<?php
/**
 * Test bootstrap for Admin Only Dashboard.
 *
 * @package Admin_Only_Dashboard
 */

// Define ABSPATH if not defined.
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __DIR__ ) . '/' );
}

/**
 * Mock wp_validate_redirect.
 *
 * This function validates if a URL is safe to redirect to.
 * We'll mock it to return the input URL if it starts with '/' or contains the 'example.com' host,
 * and false otherwise (representing an external/malicious URL).
 *
 * @param string $url The URL to validate.
 * @param string $default The default URL to return if invalid.
 * @return string The validated URL or default.
 */
function wp_validate_redirect( $url, $default = '' ) {
	if ( empty( $url ) ) {
		return $default;
	}

	// Simple mock: if it starts with '/' or contains 'example.com', consider it safe.
	// But reject known dangerous protocols.
	if ( preg_match( '/^(javascript|data):/i', $url ) ) {
		return $default;
	}

	if ( strpos( $url, '/' ) === 0 || strpos( $url, 'example.com' ) !== false ) {
		return $url;
	}

	return $default;
}

/**
 * Mock wp_parse_url.
 *
 * @param string $url The URL to parse.
 * @return array|false The URL components or false if malformed.
 */
function wp_parse_url( $url ) {
	$parts = parse_url( $url );
	return is_array( $parts ) ? $parts : false;
}

/**
 * Mock esc_url_raw.
 *
 * @param string $url The URL to sanitize.
 * @return string The sanitized URL.
 */
function esc_url_raw( $url ) {
	// Simple mock that returns the URL as-is, but removes potentially dangerous characters.
	return str_replace( array( '<', '>', '"', "'", '(', ')' ), '', $url );
}

/**
 * Mock home_url.
 *
 * @param string $path Optional path.
 * @return string The home URL.
 */
function home_url( $path = '' ) {
	return 'https://example.com' . $path;
}

/**
 * Mock get_option.
 *
 * @param string $option Option name.
 * @param mixed  $default Default value.
 * @return mixed Option value.
 */
function get_option( $option, $default = false ) {
	return $default;
}

/**
 * Mock apply_filters.
 *
 * @param string $tag Filter tag.
 * @param mixed  $value Filter value.
 * @return mixed Filtered value.
 */
function apply_filters( $tag, $value ) {
	return $value;
}

/**
 * Mock add_action.
 *
 * @param string   $tag      Action tag.
 * @param callable $function Function to call.
 */
function add_action( $tag, $function ) {
	// Simple mock: do nothing.
}

/**
 * Mock add_filter.
 *
 * @param string   $tag      Filter tag.
 * @param callable $function Function to call.
 */
function add_filter( $tag, $function ) {
	// Simple mock: do nothing.
}

/**
 * Mock wp_doing_ajax.
 *
 * @return bool Whether it's an AJAX request.
 */
function wp_doing_ajax() {
	return false;
}

/**
 * Mock esc_url.
 *
 * @param string $url The URL to sanitize.
 * @return string The sanitized URL.
 */
function esc_url( $url ) {
	return esc_url_raw( $url );
}

/**
 * Mock wp_get_current_user.
 *
 * @return object The current user object.
 */
function wp_get_current_user() {
	return (object) array( 'user_login' => 'testuser' );
}

/**
 * Mock current_user_can.
 *
 * @param string $capability The capability to check.
 * @return bool Whether the user has the capability.
 */
function current_user_can( $capability ) {
	return false;
}

/**
 * Mock get_user_by.
 *
 * @param string $field The field to check.
 * @param string $value The value to check.
 * @return object|false The user object or false.
 */
function get_user_by( $field, $value ) {
	if ( 'login' === $field && 'testuser' === $value ) {
		return (object) array( 'user_login' => 'testuser' );
	}
	return false;
}

// Include the core file.
require_once ABSPATH . 'includes/core.php';
