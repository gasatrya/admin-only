# Agent Context: Disable Dashboard Access

This project is a WordPress plugin designed to restrict dashboard access to administrators and whitelisted users, with added session management features.

## Project Overview

- **Name:** Disable Dashboard Access (Internal Slug: `admin-only`)
- **Type:** WordPress Plugin
- **Tech Stack:**
  - PHP 8.2 (Strict Typing, Return Types)
  - WordPress 6.8.2
  - MySQL 8.0
- **Architecture:**
  - `admin-only.php`: Plugin entry point and constant definitions.
  - `admin/settings.php`: Admin settings page implementation.
  - `includes/core.php`: Core logic for access validation, user whitelisting, and redirects.
  - `includes/session.php`: Session expiration and "Remember Me" override logic.

## Building and Running

### Prerequisites
- WordPress environment (e.g., LocalWP, DevKinsta, or manual LAMP/LEMP stack).
- PHP 8.2+.
- Composer (for development tools).

### Key Commands
- **Install Dependencies:** `composer install`
- **Linting (PHPCS):** `composer run phpcs` (Uses WordPress Coding Standards)
- **Auto-fix Linting (PHPCBF):** `composer run phpcbf`
- **Build Package:** `composer run zip` (Creates `admin-only.zip`)
- **Testing:** `phpunit` (Ensure PHPUnit is configured in your environment as per `AGENTS.md`)

## Development Conventions

### Coding Standards
- **WordPress Coding Standards:** Strictly follow WPCS as defined in `phpcs.xml.dist`.
- **Prefixing:** All functions and constants must be prefixed with `admon_` to avoid collisions.
- **Security:** Always use `defined( 'ABSPATH' ) || exit;` at the top of PHP files. Use `esc_html`, `esc_attr`, `wp_kses`, and `check_admin_referer`/`check_ajax_referer` for data handling.
- **PHP 8.2:** Use strict typing (`declare(strict_types=1);` if appropriate, though not currently seen in files) and explicit return types for new functions.

### File Structure
- `admin/`: Backend-specific code (UI, settings).
- `includes/`: Core plugin logic and shared utilities.
- `vendor/`: Composer dependencies (ignored by Git).

### Testing Practices
- Run PHPCS/PHPCBF on every change to ensure compliance with WordPress standards.
