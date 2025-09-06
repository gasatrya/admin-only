<?php
/**
 * Settings functionality for Admin Only Dashboard plugin
 *
 * @package Admin_Only_Dashboard
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Include core functionality for validation.
require_once ADMON_PLUGIN_DIR . 'includes/core.php';

/**
 * Initialize plugin settings
 */
function admon_settings_init() {
	// Register settings.
	register_setting(
		'admin_only_settings',
		'admin_only_settings',
		array(
			'sanitize_callback' => 'admon_sanitize_settings',
			'default'           => array(
				'session_timeout' => '',
				'apply_to_admins' => 0,
				'allowed_users'   => '',
				'custom_redirect' => '',
			),
		)
	);

	// Add settings section.
	add_settings_section(
		'admin_only_main_section',
		__( 'Admin Only Dashboard Settings', 'admin-only' ),
		'admon_settings_section_callback',
		'admin_only_settings'
	);

	// Session timeout field.
	add_settings_field(
		'session_timeout',
		__( 'Session Expiration', 'admin-only' ),
		'admon_session_timeout_callback',
		'admin_only_settings',
		'admin_only_main_section'
	);

	// Apply to admins field.
	add_settings_field(
		'apply_to_admins',
		__( 'Apply to Administrators', 'admin-only' ),
		'admon_apply_to_admins_callback',
		'admin_only_settings',
		'admin_only_main_section'
	);

	// Allowed users field.
	add_settings_field(
		'allowed_users',
		__( 'Allowed Users', 'admin-only' ),
		'admon_allowed_users_callback',
		'admin_only_settings',
		'admin_only_main_section'
	);

	// Custom redirect field.
	add_settings_field(
		'custom_redirect',
		__( 'Custom Redirect URL', 'admin-only' ),
		'admon_custom_redirect_callback',
		'admin_only_settings',
		'admin_only_main_section'
	);
}
add_action( 'admin_init', 'admon_settings_init' );

/**
 * Sanitize settings
 *
 * @param array $input Raw settings input.
 * @return array Sanitized settings.
 */
function admon_sanitize_settings( $input ) {
	$sanitized = array();

	// Sanitize session timeout.
	if ( isset( $input['session_timeout'] ) ) {
		$timeout                      = absint( $input['session_timeout'] );
		$allowed_timeouts             = array( 1, 2, 4, 8, 12, 24 );
		$sanitized['session_timeout'] = in_array( $timeout, $allowed_timeouts, true ) ? $timeout : '';
	}

	// Sanitize apply to admins.
	$sanitized['apply_to_admins'] = ! empty( $input['apply_to_admins'] ) ? 1 : 0;

	// Sanitize and validate allowed users.
	if ( isset( $input['allowed_users'] ) ) {
		$raw_usernames              = sanitize_text_field( $input['allowed_users'] );
		$validation_result          = admon_validate_usernames_with_feedback( $raw_usernames );
		$sanitized['allowed_users'] = $validation_result['valid_usernames'];

		// Show error message for invalid usernames.
		if ( ! empty( $validation_result['invalid_usernames'] ) ) {
			$invalid_count  = count( $validation_result['invalid_usernames'] );
			$usernames_list = implode( ', ', $validation_result['invalid_usernames'] );

			add_settings_error(
				'admin_only_settings',
				'invalid_usernames',
				sprintf(
					// translators: %s: List of invalid usernames.
					_n(
						'Username not found and removed: %s',
						'Usernames not found and removed: %s',
						$invalid_count,
						'admin-only'
					),
					$usernames_list
				),
				'warning'
			);
		}
	}

	// Sanitize custom redirect.
	if ( isset( $input['custom_redirect'] ) ) {
		$url = trim( $input['custom_redirect'] );
		if ( ! empty( $url ) ) {
			// Validate that URL is within the same WordPress installation
			$sanitized_url                = admon_validate_same_site_url( $url );
			$sanitized['custom_redirect'] = ! empty( $sanitized_url ) ? $sanitized_url : '';

			// Show error if URL is external
			if ( empty( $sanitized_url ) && ! empty( $url ) ) {
				add_settings_error(
					'admin_only_settings',
					'invalid_redirect_url',
					__( 'Custom redirect URL must be within this WordPress site.', 'admin-only' ),
					'error'
				);
			}
		} else {
			$sanitized['custom_redirect'] = '';
		}
	}

	return $sanitized;
}

/**
 * Settings section callback
 */
function admon_settings_section_callback() {
	echo '<p>' . esc_html__( 'Configure access control settings for the Admin Only Dashboard plugin.', 'admin-only' ) . '</p>';
}

/**
 * Session timeout field callback
 */
function admon_session_timeout_callback() {
	$settings        = get_option( 'admin_only_settings' );
	$current_timeout = $settings['session_timeout'] ?? '';
	$timeout_options = array(
		''  => __( 'Default WordPress', 'admin-only' ),
		1   => __( '1 hour', 'admin-only' ),
		2   => __( '2 hours', 'admin-only' ),
		4   => __( '4 hours', 'admin-only' ),
		8   => __( '8 hours', 'admin-only' ),
		12  => __( '12 hours', 'admin-only' ),
		24  => __( '24 hours', 'admin-only' ),
	);

	?>
	<select name="admin_only_settings[session_timeout]" id="session_timeout">
		<?php foreach ( $timeout_options as $value => $label ) : ?>
			<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $current_timeout, $value ); ?>>
				<?php echo esc_html( $label ); ?>
			</option>
		<?php endforeach; ?>
	</select>
	<p class="description"><?php esc_html_e( 'Automatically log out users after this period.', 'admin-only' ); ?></p>
	<?php
}

/**
 * Apply to admins field callback
 */
function admon_apply_to_admins_callback() {
	$settings        = get_option( 'admin_only_settings' );
	$apply_to_admins = $settings['apply_to_admins'] ?? 0;
	?>
	<label>
		<input type="checkbox" name="admin_only_settings[apply_to_admins]" value="1" <?php checked( $apply_to_admins, 1 ); ?> />
		<?php esc_html_e( 'Apply session expiration to administrators', 'admin-only' ); ?>
	</label>
	<?php
}

/**
 * Allowed users field callback
 */
function admon_allowed_users_callback() {
	$settings      = get_option( 'admin_only_settings' );
	$allowed_users = $settings['allowed_users'] ?? '';
	?>
	<input type="text" name="admin_only_settings[allowed_users]" value="<?php echo esc_attr( $allowed_users ); ?>"
		class="regular-text" />
	<p class="description">
		<?php esc_html_e( 'Comma-separated usernames. Administrator users are always allowed.', 'admin-only' ); ?>
	</p>
	<?php
}

/**
 * Custom redirect field callback
 */
function admon_custom_redirect_callback() {
	$settings        = get_option( 'admin_only_settings' );
	$custom_redirect = $settings['custom_redirect'] ?? '';
	?>
	<input type="url" name="admin_only_settings[custom_redirect]" value="<?php echo esc_attr( $custom_redirect ); ?>"
		class="regular-text" placeholder="https://example.com/access-denied" />
	<p class="description">
		<?php esc_html_e( 'Leave blank to redirect to homepage.', 'admin-only' ); ?>
	</p>
	<?php
}

/**
 * Add settings page to admin menu
 */
function admon_add_settings_page() {
	add_options_page(
		__( 'Admin Only Dashboard Settings', 'admin-only' ),
		__( 'Admin Only Dashboard', 'admin-only' ),
		'manage_options',
		'admin-only-settings',
		'admon_settings_page_callback'
	);
}
add_action( 'admin_menu', 'admon_add_settings_page' );

/**
 * Settings page callback
 */
function admon_settings_page_callback() {
	// Check user capabilities.
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// Error/update messages are automatically displayed by WordPress
	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form action="options.php" method="post">
			<?php
			// Output security fields.
			settings_fields( 'admin_only_settings' );
			// Output settings sections.
			do_settings_sections( 'admin_only_settings' );
			// Output save button.
			submit_button( __( 'Save Settings', 'admin-only' ) );
			?>
		</form>
	</div>
	<?php
}
