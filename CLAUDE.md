# Admin Only Plugin - Development Guide

# Specs:

- WordPress 6.8.2
- PHP 8.2.27
- MySQL 8.0

## Coding Standards
- Follow the WordPress coding standards: https://developer.wordpress.org/coding-standards/
- Use context7 tool to check latest coding standard
- Use PHP 8.2 features and syntax where applicable.
- Use strict typing and return types in PHP 8.2.
- Follow best practices for security and performance.
- Test every newly added function using PHPCS and fix using PHP CodeSniffer (PHPCBF).

## Testing
- Write unit tests for all new features and bug fixes.
- Use PHPUnit for testing.

## Process
- Always split tasks into small manageable pieces.
- Whenever you done with one task, check the task 
- Then stage all changes
- Commit the changes with clear and concise commit messages. Follow the Conventional Commits specification: https://www.conventionalcommits.org/en/v1.0.0/
- Then stop, and ask me if I want to review current implementation or execute next task.
- If the implementation is approved, then push the changes to remote repository.
- If the implementation is not approved, then fix the issues and repeat the process.
- If a feature requires Setting UI, build the UI using WordPress Settings API and follow WordPress admin design guidelines. Then build the backend functionality.

---

# Admin Only Dashboard Plugin - Feature Enhancement PRD

## Overview
Enhance the existing Admin Only Dashboard plugin with three targeted features that maintain the plugin's core philosophy of simple, secure admin access control.

## Current State
- Plugin restricts dashboard access to administrators only
- Non-admin users redirected to homepage
- Admin toolbar hidden for non-admin users
- Zero configuration required
- Developer-friendly filters available

## Problem Statement
Users need more flexibility in access control while maintaining simplicity:
1. **Whitelist specific users**: Need to grant dashboard access to trusted individuals without making them administrators
2. **Session security**: Risk of unauthorized access through forgotten login sessions
3. **Better user experience**: Generic homepage redirect doesn't provide context for blocked users

## Feature Requirements

### 1. Allow Specific Users Access
**User Story**: As a site owner, I want to allow specific trusted users (developers, VAs, contractors) to access the dashboard without giving them full administrator privileges.

**Acceptance Criteria**:
- Simple text field in settings to add usernames (comma-separated)
- Users in whitelist can access dashboard regardless of their role
- Whitelist users still subject to auto-logout (if enabled)
- Admin toolbar visible for whitelisted users
- **Administrator users are always whitelisted by default**
- Empty whitelist = administrator users only (current admin behavior)

**Technical Notes**:
- Modify existing `admon_access_capability` filter logic
- Add username validation
- Store whitelist in WordPress options table
- **Always include administrator users in whitelist logic**
- Check user roles for administrator capabilities

### 2. Session Expiration Control
**User Story**: As a site owner, I want to control session duration to enhance security by automatically logging out users after a configurable period.

**Acceptance Criteria**:
- Setting to configure session expiration interval
- Configurable timeout options (1, 2, 4, 8, 12, 24 hours)
- Maximum interval of 24 hours (1 day)
- Option to apply to all users or exclude administrators
- Uses WordPress built-in authentication system

**Technical Notes**:
- Filter the `auth_cookie_expiration` hook
- Store settings in WordPress options
- Validate interval values
- Respect WordPress security practices

### 3. Custom Redirect URL
**User Story**: As a site owner, I want to redirect blocked users to a custom page instead of the homepage to provide better context or branding.

**Acceptance Criteria**:
- URL input field in settings
- Validate URL format (internal/external)
- Fallback to homepage if URL invalid
- Support for relative and absolute URLs
- Clear field = default homepage behavior

**Technical Notes**:
- Modify existing `admon_redirect_page` filter
- URL validation using WordPress functions
- Settings sanitization

## Settings Page Design

### Location
WordPress Admin → Settings → Admin Only Dashboard

### Layout
```
Admin Only Dashboard Settings

Session Expiration: [Dropdown: 1/2/4/8/12/24 hours]
  □ Apply to administrators

Allowed Users (comma-separated usernames):
[Text field: username1, username2, username3]
Help text: Administrator users are always allowed

Custom Redirect URL:
[Text field: https://example.com/access-denied]
Help text: Leave blank to redirect to homepage

[Save Settings]
```

## Technical Implementation

### Database
- Single option: `admin_only_settings`

### Backward Compatibility
- All existing filters remain functional
- Settings override filters if both present
- No breaking changes to existing functionality

### Security Considerations
- Sanitize and validate all input
- Use WordPress nonces for settings
- Escape output in admin interface
- Validate usernames exist in database

## Success Metrics
- Maintain plugin simplicity (< 5 settings)
- Zero configuration still works (all settings optional)
- No performance impact on frontend
- Settings save/load correctly
- Auto logout functions reliably
