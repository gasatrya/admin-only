<?php
/**
 * Test for admon_validate_usernames_with_feedback function.
 *
 * @package Admin_Only_Dashboard
 */

// Test empty input.
$result = admon_validate_usernames_with_feedback( '' );
admon_assert( '' === $result['valid_usernames'], 'Empty input should have no valid usernames' );
admon_assert( array() === $result['invalid_usernames'], 'Empty input should have no invalid usernames' );

// Test single valid user.
$result = admon_validate_usernames_with_feedback( 'testuser' );
admon_assert( 'testuser' === $result['valid_usernames'], 'Valid user should be returned in valid_usernames' );
admon_assert( array() === $result['invalid_usernames'], 'Valid user should not be in invalid_usernames' );

// Test single invalid user.
$result = admon_validate_usernames_with_feedback( 'nonexistent' );
admon_assert( '' === $result['valid_usernames'], 'Invalid user should not be in valid_usernames' );
admon_assert( array( 'nonexistent' ) === $result['invalid_usernames'], 'Invalid user should be in invalid_usernames' );

// Test mixed users.
$result = admon_validate_usernames_with_feedback( 'testuser, nonexistent, another-invalid' );
admon_assert( 'testuser' === $result['valid_usernames'], 'Mixed input: valid user should be returned' );
admon_assert( array( 'nonexistent', 'another-invalid' ) === $result['invalid_usernames'], 'Mixed input: invalid users should be returned' );

// Test with extra spaces.
$result = admon_validate_usernames_with_feedback( ' testuser ,  nonexistent ' );
admon_assert( 'testuser' === $result['valid_usernames'], 'Input with spaces should be trimmed (valid)' );
admon_assert( array( 'nonexistent' ) === $result['invalid_usernames'], 'Input with spaces should be trimmed (invalid)' );
