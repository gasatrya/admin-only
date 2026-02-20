<?php
/**
 * Simple test runner
 */

require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/TestRedirect.php';

$testClass = new TestRedirect();
$methods = get_class_methods( $testClass );
$passCount = 0;
$failCount = 0;

echo "Running tests...\n";

foreach ( $methods as $method ) {
    if ( strpos( $method, 'test_' ) === 0 ) {
        try {
            if ( method_exists( $testClass, 'setUp' ) ) {
                $testClass->setUp();
            }
            $testClass->$method();
            echo "✔ $method passed\n";
            $passCount++;
        } catch ( Exception $e ) {
            echo "✘ $method failed: " . $e->getMessage() . "\n";
            $failCount++;
        }
    }
}

echo "\nSummary:\n";
echo "Passed: $passCount\n";
echo "Failed: $failCount\n";

if ( $failCount > 0 ) {
    exit( 1 );
}
exit( 0 );
