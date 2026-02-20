<?php
/**
 * Bootstrap for tests
 */

define( 'ABSPATH', true );

// Mock WordPress functions
$wp_options = [];
$wp_filters = [];
$wp_home_url = 'https://example.com';

if ( ! function_exists( 'get_option' ) ) {
    function get_option( $name, $default = false ) {
        global $wp_options;
        return isset( $wp_options[ $name ] ) ? $wp_options[ $name ] : $default;
    }
}

if ( ! function_exists( 'home_url' ) ) {
    function home_url( $path = '' ) {
        global $wp_home_url;
        return $wp_home_url . $path;
    }
}

if ( ! function_exists( 'apply_filters' ) ) {
    function apply_filters( $tag, $value ) {
        global $wp_filters;
        if ( isset( $wp_filters[ $tag ] ) ) {
            return call_user_func( $wp_filters[ $tag ], $value );
        }
        return $value;
    }
}

if ( ! function_exists( 'wp_parse_url' ) ) {
    function wp_parse_url( $url ) {
        $parts = parse_url( $url );
        return $parts === false ? null : $parts;
    }
}

if ( ! function_exists( 'esc_url_raw' ) ) {
    /**
     * Mock for esc_url_raw.
     * Note: This is a no-op implementation for unit testing purposes.
     * It does not perform actual URL sanitization.
     */
    function esc_url_raw( $url ) {
        return $url;
    }
}

if ( ! function_exists( 'add_action' ) ) {
    function add_action( $tag, $function_to_add, $priority = 10, $accepted_args = 1 ) {}
}

if ( ! function_exists( 'add_filter' ) ) {
    function add_filter( $tag, $function_to_add, $priority = 10, $accepted_args = 1 ) {}
}

if ( ! function_exists( 'current_user_can' ) ) {
    function current_user_can( $capability ) { return true; }
}

if ( ! function_exists( 'wp_get_current_user' ) ) {
    function wp_get_current_user() { return (object) [ 'user_login' => 'admin' ]; }
}

if ( ! function_exists( 'get_user_by' ) ) {
    function get_user_by( $field, $value ) { return false; }
}

if ( ! function_exists( 'wp_doing_ajax' ) ) {
    function wp_doing_ajax() { return false; }
}

if ( ! function_exists( 'wp_safe_redirect' ) ) {
    function wp_safe_redirect( $location, $status = 302 ) {}
}

// Include the file to test
require_once __DIR__ . '/../includes/core.php';
