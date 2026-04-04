<?php
/**
 * Simple test runner for Admin Only Dashboard.
 *
 * @package Admin_Only_Dashboard
 */

// Load the bootstrap.
require_once __DIR__ . '/bootstrap.php';

$test_files = glob( __DIR__ . '/test-*.php' );
$failed     = false;

foreach ( $test_files as $test_file ) {
	echo "Running test: " . basename( $test_file ) . PHP_EOL;
	require $test_file;
}

if ( $failed ) {
	echo "Some tests failed!" . PHP_EOL;
	exit( 1 );
}

echo "All tests passed!" . PHP_EOL;
exit( 0 );

/**
 * Basic assertion function.
 *
 * @param bool   $condition The condition to assert.
 * @param string $message   The message if assertion fails.
 */
function admon_assert( $condition, $message ) {
	global $failed;
	if ( ! $condition ) {
		echo "[FAIL] $message" . PHP_EOL;
		$failed = true;
	} else {
		echo "[PASS] $message" . PHP_EOL;
	}
}
