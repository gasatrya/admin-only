# UserFlow - Disable Dashboard Access for Non-Admins

[![WordPress Plugin](https://img.shields.io/wordpress/plugin/v/admin-only-dashboard.svg)](https://wordpress.org/plugins/admin-only-dashboard/)
[![License](https://img.shields.io/badge/license-GPL--2.0-blue.svg)](LICENSE)
[![PHP Version](https://img.shields.io/badge/php-%3E%3D7.4-8892bf.svg)](composer.json)

**UserFlow** (formerly *Disable Dashboard Access*) is a lightweight, secure WordPress plugin designed to restrict dashboard access to administrators and authorized users. It provides robust session management and whitelisting capabilities to keep your site's backend secure.

## 🚀 Features

- **Dashboard Restriction:** Automatically block non-admin users from accessing `/wp-admin`.
- **User Whitelisting:** Easily grant access to specific trusted users (developers, VAs, contractors) by username.
- **Session Expiration Controls:** Configure session timeouts from 1 to 24 hours (or custom durations up to 168 hours).
- **Admin Session Security:** Option to apply session timeouts to administrators for maximum security.
- **Custom Redirects:** Redirect blocked users to a specific internal page (e.g., custom login or welcome page) instead of the homepage.
- **"Remember Me" Override:** Enforce session timeouts even when users check the "Remember Me" box.
- **Clean UI:** Simple, native-feeling settings page for easy configuration.

## Installation

### From WordPress.org
1. Go to **Plugins > Add New** in your WordPress dashboard.
2. Search for `UserFlow` or `Disable Dashboard Access`.
3. Click **Install Now** and then **Activate**.

### Manual Installation
1. Download the [latest release](https://github.com/gasatrya/admin-only/releases).
2. Upload the `admin-only` folder to your `/wp-content/plugins/` directory.
3. Activate the plugin through the 'Plugins' menu in WordPress.

## For Developers

UserFlow is built with extensibility in mind.

### Custom Access Capability
Change the required capability to access the dashboard or settings page:

```php
add_filter( 'admon_access_capability', function( $capability ) {
    return 'edit_posts'; // Allow editors to access the dashboard
} );
```

## Requirements

- **WordPress:** 6.0 or higher (Tested up to 7.0)
- **PHP:** 7.4 or higher

## License

This project is licensed under the GPLv2 or later License. See the [LICENSE](LICENSE) file for details.

---
Built with ❤️ by [Ga Satrya](https://www.ctaflow.com/)
