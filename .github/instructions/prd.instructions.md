---
applyTo: '**'
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
- Empty whitelist = current behavior (admin only)

**Technical Notes**:
- Modify existing `admon_access_capability` filter logic
- Add username validation
- Store whitelist in WordPress options table

### 2. Auto Logout Interval
**User Story**: As a site owner, I want users to be automatically logged out after a period of inactivity to prevent unauthorized access from unattended sessions.

**Acceptance Criteria**:
- Setting to enable/disable auto logout
- Configurable timeout interval (15, 30, 60, 120 minutes)
- Warning message 2 minutes before logout
- Option to apply to admins or exclude them
- Graceful logout (no data loss warnings)

**Technical Notes**:
- Use JavaScript for countdown and warning
- WordPress AJAX for logout action
- Store last activity timestamp
- Respect WordPress nonces for security

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

□ Enable Auto Logout
  Logout Interval: [Dropdown: 15/30/60/120 minutes]
  □ Apply to administrators

Allowed Users (comma-separated usernames):
[Text field: username1, username2, username3]

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

