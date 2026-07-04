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

	// Reject known dangerous protocols.
	if ( preg_match( '/^(javascript|data):/i', $url ) ) {
		return $default;
	}

	// Relative URLs are safe.
	if ( strpos( $url, '/' ) === 0 ) {
		return $url;
	}

	// Parse the host from absolute URLs for validation.
	$parts = wp_parse_url( $url );
	if ( false !== $parts && isset( $parts['host'] ) ) {
		// Only allow the mock site domain.
		if ( 'example.com' === $parts['host'] ) {
			return $url;
		}
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

// phpcs:disable Universal.Files.SeparateFunctionsFromOO -- Test mock file; intentionally mixes functions and classes to mock WordPress.
/**
 * Mock WP_User_Query.
 *
 * Simulates a batch user query. Only 'testuser' is treated as existing.
 * Validates the 'fields' parameter against real wp_users column names.
 *
 * @phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedClassFound
 */
class WP_User_Query {

	/**
	 * Valid wp_users column names that WP_User_Query accepts as 'fields'.
	 *
	 * @var string[]
	 */
	private const VALID_FIELDS = array(
		'ID',
		'user_login',
		'user_pass',
		'user_nicename',
		'user_email',
		'user_url',
		'user_registered',
		'user_activation_key',
		'user_status',
		'display_name',
	);

	/**
	 * Query results.
	 *
	 * @var array
	 */
	private $results = array();

	/**
	 * Constructor.
	 *
	 * @param array $args Query arguments. Supports 'login__in' and 'fields' keys.
	 */
	public function __construct( $args ) {
		$fields = isset( $args['fields'] ) ? $args['fields'] : 'all';
		$input_logins  = isset( $args['login__in'] ) ? (array) $args['login__in'] : array();

		// Reject invalid column names — real WP_User_Query would produce an SQL error.
		if ( ! in_array( $fields, self::VALID_FIELDS, true ) ) {
			$this->results = array();
			return;
		}

		// Only 'testuser' exists in the mock database.
		$this->results = array_values( array_intersect( $input_logins, array( 'testuser' ) ) );
	}

	/**
	 * Get query results.
	 *
	 * @return array Matching user logins.
	 */
	public function get_results() {
		return $this->results;
	}
}

// Include the core file.
require_once ABSPATH . 'includes/core.php';
