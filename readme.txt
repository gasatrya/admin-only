=== UserFlow - Disable Dashboard Access for Non Admin ===
Contributors: gasatrya
Tags: restrict, dashboard, login, access, membership
Requires at least: 5.0
Tested up to: 7.0
Stable tag: 1.3.1
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

UserFlow: Only admins can access the dashboard by default. Whitelist trusted users easily, quick setup, and secure.

== Description ==

Remove dashboard access to non-admin users and easily control who can access your WordPress dashboard with simple configuration. By default, only administrators are allowed, but you can now whitelist specific trusted users by username—perfect for developers, VAs, or contractors.

**Features include**:

- Whitelist specific users by username
- Session expiration controls (1-24 hours)
- Option to apply session timeout to administrators
- Custom redirect URL for blocked users
- Secure, validated, and sanitized settings
- Hide admin toolbar for non-authorized users
- Developer-friendly filters for advanced customization

**Why Choose UserFlow?**

* **Maximum Protection**: Instantly block unauthorized users from accessing sensitive dashboard areas.
* **Effortless Whitelisting**: Grant dashboard access to trusted users (developers, VAs, contractors) without changing their roles. Just add their usernames!
* **Session Security**: Automatically log out users after a set period for bulletproof session management. Choose from multiple timeout intervals and apply to all users or just non-admins.
* **Custom Redirects**: Guide blocked users to a branded page or helpful resource instead of the generic homepage.
* **Zero Configuration Needed**: Works out of the box—only administrators can access the dashboard until you customize settings.

**Perfect For:**

* Website owners who want peace of mind
* Agencies and developers managing multiple sites
* Teams needing granular dashboard access
* Anyone serious about WordPress security

Protect your site, empower your workflow, and deliver a professional experience—all with one lightweight plugin.


[Read more detail](https://www.ctaflow.com/plugins/admin-only-dashboard/)

== Screenshots ==

1. Plugin settings

== Changelog ==


= 1.3.1 =
* Security: Hardened settings reset handler with request-method check and nonce improvements.
* Improved: Replaced per-username DB queries with single batched query for settings save performance.
* Improved: Added explicit access-control fallthrough logic and removed stale static cache.
* Improved: Separated settings-page capability filter from dashboard-access filter.
* Improved: Settings sanitization now guarantees consistent option shape on save.
* Improved: Added meta-refresh fallback when redirect headers cannot be sent.
* Improved: Username validation errors now show count only to prevent enumeration.
* Added: Plugin uninstall handler to clean up stored options on deletion.
* Added: AJAX bypass behavior documented in settings help tab.
* Added: Sidebar promotion box for developer services.
* Dev: Improved test mock fidelity for wp_validate_redirect and WP_User_Query.
* Dev: Fixed Composer license to valid SPDX identifier.

= 1.3.0 =
* Rebranding: Formally renamed the plugin to **UserFlow**.
* Added: Support for WordPress 7.0.
* Refactor: Moved inline JavaScript and CSS to external files for better security and maintainability.
* Improved: Updated settings sidebar to connect with the developer on LinkedIn.
* Improved: Settings page formatting and code structure.
* Improved: Updated settings labels for better clarity.
* Improved: Use `wp_validate_redirect` for more robust same-site URL validation.
* Added: `admon_access_capability` filter for developer customization of access rights.
* Fix: Updated `make-pot` composer script for Windows compatibility.

= 1.2.5 =
* Performance: Optimized access checks with static caching (memoization) to reduce redundant processing.
* Fix: Ensured settings errors and success messages are correctly displayed on the settings page.
* Improved: Better UI feedback when saving or resetting settings.
* Improved: Added GitHub Actions automated deployment for WordPress.org SVN.
* Assets: Added new plugin banners and icons for the WordPress.org repository.

= 1.1.1 =
* Security Fix: Patched Open Redirect vulnerability in URL validation logic.
* Improved: Stricter validation for custom redirect URLs.
* Improved: Added Contextual Help tabs in settings page.

= 1.1.0 =
* Added session timeout management with configurable intervals (1-24 hours)
* Added custom timeout duration option (1-168 hours)
* Added username whitelist for granting dashboard access to specific non-admin users
* Added custom redirect URL for blocked users
* Added option to apply session timeout to administrators
* Added "Remember Me" override functionality
* Enhanced security with proper input sanitization and validation
* Improved user interface with comprehensive settings page
* Added reset to defaults functionality
* Updated to follow WordPress coding standards

= 1.0.0 =
* First version
