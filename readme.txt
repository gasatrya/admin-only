=== Admin Only Dashboard ===
Contributors: gasatrya
Tags: restrict, dashboard, administration, membership, roles
Requires at least: 3.3
Tested up to: 6.5
Stable tag: 1.0.0
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

It allows you to restrict access to the dashboard area, ensuring that only administrators have the privilege to manage and control your site.

== Description ==

Introducing the **Admin Only Dashboard** WordPress plugin - the simple yet powerful solution for securing your website's backend. This feature-rich plugin offers the following capabilities:

* **No Configuration Needed**: Enjoy a hassle-free setup process. The plugin works out of the box, requiring no additional configuration.
* **Administrator-Only Access**: Ensure that only administrators have access to the dashboard area. This prevents unauthorized users from making changes to your website.
* **Redirect Non-Administrators**: Automatically redirect non-administrator users to the home page, providing a seamless user experience while maintaining security.
* **Disable Admin Toolbars**: The plugin automatically disables admin toolbars for non-administrator users, further enhancing security and preventing unauthorized actions.
* **Enhanced Security**: Protect your website from potential security threats by restricting access to sensitive areas and ensuring that only authorized personnel can manage your site.
* **Developer-Friendly Filters**: Developers can easily customize the plugin's behavior by using filters. For example, you can modify the allowed roles to include administrators and editors, or change the redirection page to a custom URL.

== Changelog ==

= 1.0.0 =
* First version

== Filters ==

**Filter capability**

`function admon_capability() {
 	return 'unfiltered_html'; // Allow administrator and editor to access dashboard
}
add_filter( 'admon_access_capability', 'admon_capability' );`

**Filter redirection page**

`function admon_redirect() {
 	return home_url( '/user-account/' );
}
add_filter( 'admon_redirect_page', 'admon_redirect' );`
