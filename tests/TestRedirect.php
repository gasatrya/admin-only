<?php
/**
 * Test cases for redirect functionality
 */

class TestRedirect {
    public function setup() {
        global $wp_options, $wp_filters, $wp_home_url;
        $wp_options = [];
        $wp_filters = [];
        $wp_home_url = 'https://example.com';
    }

    public function test_get_redirect_url_default() {
        $this->setup();
        $url = admon_get_redirect_url();
        $this->assertEquals( 'https://example.com/', $url, 'Default redirect URL should be home URL' );
    }

    public function test_get_redirect_url_custom_valid() {
        $this->setup();
        global $wp_options;
        $wp_options['admin_only_settings'] = [
            'custom_redirect' => 'https://example.com/blocked'
        ];

        $url = admon_get_redirect_url();
        $this->assertEquals( 'https://example.com/blocked', $url, 'Custom redirect URL should be used if valid' );
    }

    public function test_get_redirect_url_custom_invalid_external() {
        $this->setup();
        global $wp_options;
        $wp_options['admin_only_settings'] = [
            'custom_redirect' => 'https://malicious.com/blocked'
        ];

        $url = admon_get_redirect_url();
        $this->assertEquals( 'https://example.com/', $url, 'Custom redirect URL should be ignored if external' );
    }

    public function test_get_redirect_url_custom_relative() {
        $this->setup();
        global $wp_options;
        $wp_options['admin_only_settings'] = [
            'custom_redirect' => '/blocked'
        ];

        $url = admon_get_redirect_url();
        $this->assertEquals( '/blocked', $url, 'Relative custom redirect URL should be allowed' );
    }

    public function test_get_redirect_url_filtered() {
        $this->setup();
        global $wp_filters;
        $wp_filters['admon_redirect_page'] = function( $url ) {
            return 'https://filtered.com';
        };

        $url = admon_get_redirect_url();
        $this->assertEquals( 'https://filtered.com', $url, 'Redirect URL should be filterable' );
    }

    public function test_validate_same_site_url_subdomain() {
        $this->setup();
        $url = 'https://sub.example.com/blocked';
        $result = admon_validate_same_site_url( $url );
        $this->assertEquals( $url, $result, 'Subdomains of the same base domain should be allowed' );
    }

    public function test_validate_same_site_url_different_domain() {
        $this->setup();
        $url = 'https://another-domain.com/blocked';
        $result = admon_validate_same_site_url( $url );
        $this->assertFalse( $result, 'Different domains should be disallowed' );
    }

    // Helper assertions
    private function assertEquals( $expected, $actual, $message ) {
        if ( $expected !== $actual ) {
            throw new Exception( "Assertion failed: expected " . var_export($expected, true) . ", got " . var_export($actual, true) . ". $message" );
        }
    }

    private function assertFalse( $actual, $message ) {
        if ( $actual !== false ) {
            throw new Exception( "Assertion failed: expected false, got " . var_export($actual, true) . ". $message" );
        }
    }
}
