<?php
/**
 * Test for admon_validate_same_site_url function.
 *
 * @package Admin_Only_Dashboard
 */

// Helper function to mock the logic.
admon_assert( false === admon_validate_same_site_url( '' ), 'Empty string should return false' );
admon_assert( false === admon_validate_same_site_url( null ), 'Null should return false' );

// Internal relative URLs.
admon_assert( '/dashboard' === admon_validate_same_site_url( '/dashboard' ), 'Relative URL should be valid' );
admon_assert( '/wp-admin/settings.php' === admon_validate_same_site_url( '/wp-admin/settings.php' ), 'Deeper relative URL should be valid' );

// Internal absolute URLs.
admon_assert( 'https://example.com/dashboard' === admon_validate_same_site_url( 'https://example.com/dashboard' ), 'Internal absolute URL should be valid' );

// External URLs.
admon_assert( false === admon_validate_same_site_url( 'https://malicious.com' ), 'External URL should return false' );
admon_assert( false === admon_validate_same_site_url( 'http://another-site.com/evil' ), 'External URL with path should return false' );

// Malicious/Invalid URLs.
admon_assert( false === admon_validate_same_site_url( 'javascript:alert(1)' ), 'JavaScript protocol should return false' );
admon_assert( false === admon_validate_same_site_url( 'data:text/html;base64,PHNjcmlwdD5hbGVydCgxKTwvc2NyaXB0Pg==' ), 'Data URI should return false' );

// Test with special characters (sanitization check).
admon_assert( 'https://example.com/path?param=value' === admon_validate_same_site_url( 'https://example.com/path?param=value' ), 'Internal URL with query params should be valid' );
admon_assert( 'https://example.com/pathscript' === admon_validate_same_site_url( 'https://example.com/path<script>' ), 'Special characters (brackets) should be stripped' );
admon_assert( 'https://example.com/pathalert1' === admon_validate_same_site_url( 'https://example.com/pathalert(1)' ), 'Special characters (parentheses) should be stripped' );
