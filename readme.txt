=== User and Login Management===
Contributors: miniOrange
Donate link: https://miniorange.com
Tags: user management, session management, wp login, login redirect, avatar, bulk import, bulk export, user activity tracking, page restriction, website privacy, session control, role manager
Requires at least: 5.0
Tested up to: 6.6
Requires PHP: 5.4.0
Stable tag: 1.0.7
License: MIT/Expat
License URI: https://docs.miniorange.com/mit-license

This plugin provides bulk user import/export, users session & login activity management, page privacy & security, and user redirection in one place
== Description ==
The [User and Login Management plugin](https://plugins.miniorange.com/wordpress-login-and-user-management-plugin) allows you to effortlessly handle bulk user import/export, efficiently manage user roles, redirect users based on their WordPress roles, track and manage user activity and sessions, enable time-driven users auto-logout, and control the privacy of pages or posts. Simplify your user management process and enhance the security and customization of your WordPress website with our powerful User and Login Management plugin.

= Free Version Features =

* <strong>Bulk User Creation</strong>: You can create multiple user accounts at once for users not registered in WordPress simply by importing them through a CSV file.

* <strong>Bulk User Modification</strong>: Existing WordPress users' information, such as their name, email, role, etc., can be modified/updated for multiple users simultaneously. Using our interactive plugin interface, you can import and manage various attributes of WordPress users in just a single step.

* <strong>Bulk Users Role Management</strong>: You can assign roles to new WordPress users or modify/overwrite the existing users' roles by importing them through a single file.

* <strong>Export WordPress Users</strong>: You can export profile information of your WordPress, such as name, email, role, etc., to a CSV file.

* <strong>User Activity & Session Tracking</strong>: Activity information about your WordPress users, such as session time and active/inactive status, can be easily viewed from the WordPress admin dashboard using our plugin.

* <strong>Default Redirection on Login and Logout</strong>: A default redirection URL can be set for all WordPress users on login and logout.

* <strong>Manage access to the website</strong>: Make your website publicly or privately accessible as per your requirements.

* <strong>User profile picture management</strong>: Manage WordPress user profile pictures from the plugin and the WordPress edit profile section. These user profile pictures can be easily uploaded and deleted from the plugin interface in just one click.

= Premium Version Features (Check out the Licensing tab to know more):- =

* <strong>Role-Based Redirection on Login</strong>: The admin can decide the page to which particular users will be redirected based on their role after login. The information about the URL for the page to be redirected needs to be provided. However, this is an optional feature, and the users will be redirected to the default URL if no role-based redirection is provided

* <strong> Create Custom WordPress Role </strong>: You can create and assign a custom WordPress role to all users imported through a CSV file with no preassigned roles.

* <strong> Manage all WordPress role capabilities </strong>: Manage capabilities of default as well custom WordPress roles as required apart from the administrator.
 
* <strong> Delete WordPress Users on Import </strong>: Delete users if not present in CSV or other file formats of your choice.
		
* <strong> Role-Based Restriction </strong>: Restrict users' access to a page based on their role.

* <strong>Auto Logout users</strong>: Manage the session of your WordPress users by providing the auto-logout time, after which the user session will be terminated.

* <strong>Make a Page/Post Private using custom attributes</strong>: Make a particular page, post, image, etc., on a private site publicly accessible by providing a URL, Page/Post ID, Page Name, or other custom attributes.

* <strong>Admin email notification</strong>:  Notify the site admin on every failed login attempt through an email.

* <strong>User Registration Manager</strong>: Admin can easily approve/deny user accounts from the plugin interface.

* <strong>Advanced User Activity Tracking</strong>: On the WordPress website track wide range of user activities such as successful logins, unsuccessful login attempts, logouts, display user's access status and many more.

= Use Cases Supported By Our Plugin =

* Manage multiple users simultaneously by importing and creating WordPress users from CSV. A new user account will be created for users not already registered in WordPress, and the existing users' information can also be modified.
* Bulk user roles can be managed by setting default roles that need to be assigned to all the newly created users or the existing users for which the role is not specified. The roles for existing users can also be overwritten.
* If an admin wants to redirect the users with a specific role to a particular page, this can be done simply by providing the URL to which the user with that role needs to be redirected.
* Information regarding the session activity, such as active and inactive WordPress users, can be viewed. The admin can use this information to delete or remove inactive users.
* Restrict access to publicly accessible websites by making them private. This website will be accessible only to logged-in users.
For a private website, if there is a need to make a specific page/post publicly accessible, this can be achieved by providing the URL that needs to be made public.

= Other Use-Cases we support:- =
* <strong>[miniOrange WP LDAP/AD Login for Intranet sites plugin](https://plugins.miniorange.com/wordpress-ldap-login-intranet-sites)</strong> supports LDAP login to WordPress sites using credentials stored in active directory and LDAP Directory systems. Only if you have access to <strong>[LDAP Extension](https://faq.miniorange.com/knowledgebase/how-to-enable-php-ldap-extension/)</strong> on your site.
* <strong>[miniOrange Active Directory/LDAP Integration for Cloud & Shared Hosting Platforms Plugin](https://plugins.miniorange.com/wordpress-ldap-login-cloud)</strong> supports login to WordPress sites hosted on a shared hosting platform using credentials stored in active directory and LDAP Directory systems in case you are not able to enable <strong>[LDAP Extension](https://faq.miniorange.com/knowledgebase/how-to-enable-php-ldap-extension/)</strong> on your site.
* <strong> [Search Staff/Employee present in your Active Directory](https://plugins.miniorange.com/wordpress-ldap-directory-search)</strong>: allows you to search and display the users present in your Active Directory / LDAP Server on a WordPress page using a shortcode.
* miniOrange supports <Strong>[API Security use cases](https://apisecurity.miniorange.com)</Strong> to protect and secure your APIs using our product <strong>[XecureAPI](https://apiconsole.miniorange.com)</strong> which helps you to enable Authentication methods ( like OAuth, SAML, LDAP, API Key Authentication, JWT Authentication etc ), Rate Limiting, IP restriction and much more on your APIs for complete protection.
* miniOrange also supports <Strong>[VPN use cases](https://www.miniorange.com/solutions/vpn-mfa-multi-factor-authentication)</Strong> Log in to your VPN client using Active Directory /other LDAP Directory credentials and <strong>[Multi-Factor Authentication](https://www.miniorange.com/products/multi-factor-authentication-mfa)</strong>.
* miniOrange supports <strong>[Single-Sign-On (SSO)](https://www.miniorange.com/products/single-sign-on-sso)</strong> into a plethora of applications and supports various protocols like(<strong>[RADIUS](https://blog.miniorange.com/radius-server-authentication/), [SAML](https://plugins.miniorange.com/wordpress-single-sign-on-sso), [OAuth](https://plugins.miniorange.com/wordpress-sso), [LDAP/LDAPS](https://plugins.miniorange.com/wordpress-ldap-login-intranet-sites)</strong>, using various IDPs like <strong>Azure Active Directory, Microsoft On-Premise Active Directory, Octa, ADFS</strong>, etc.
* Contact us at info@xecurify.com to know more.

= Why you should go with our solution =

* <strong> Support</strong>: With search being one of the essential functions of a website, our priority support ensures that any issues you face on a live production site can be resolved in a timely manner.
* <strong>Regular updates</strong>: We regularly update our plugin and ensure it is compatible with the latest WordPress versions. These updates include security and bug fixes that <strong>ensure you have the latest security fixes</strong>.
* Ensure timely updates for <strong>new WordPress/PHP releases</strong> with our premium plugins and compatibility updates to ensure you have adequate support for smooth transitions to new versions of WordPress and PHP.
* <strong>Reasonable pricing</strong>: Various plans are tailored to suit your needs. We provide discounts to educational and non-profit organizations and bulk discounts on large purchases.
* <strong>Easy to set up </strong>: High-quality, easy-to-understand documentation will help you in setting up our plugin. Our developers can also help you by walking you through the setup process of the plugin.
* High level of <strong>customization</strong> and <strong>add-ons</strong> to support specific requirements.

= Need support? =
Please email us at info@xecurify.com or <a href="https://xecurify.com/contact" target="_blank">Contact us</a>

= Minimum Requirements =

* Compatible with WordPress version 5.0 or higher
* Compatible with PHP version 5.2.0 or higher

== Installation ==

= Prerequisites =

I. To install the User and Login Management plugin, the minimum requirements are:
<ol>
<li>**WordPress version 5.0**</li>
<li>**PHP version 5.2.0**</li>
</ol>
= From your WordPress dashboard =
1. Visit `Plugins > Add New`.
2. Search for `miniOrange User and Login Management`. Find and install the `User and Login Management plugin`.
3. Activate the plugin from your Plugins section.

= From WordPress.org =
<ol>
<li>Download the User and Login Management.</li>
<li>Unzip and upload the `login-and-user-management` directory to your `/wp-content/plugins/` directory.</li>
<li>Activate the User and Login Management plugin from your Plugins section.</li>
</ol>
== Frequently Asked Questions ==

= How to get the default CSV file format template? =

To get the default CSV file format for importing users to your WordPress site, follow the below steps:
<ol>
<li> Go to the <strong>Import/Export Users</strong> tab inside the Plugin. Click on the <strong>Export Users</strong> Tab.</li>
<li> Click on the <strong>Export</strong> Button inside <strong>Export Users</strong> section a default CSV file will get downloaded.</li>
<li> Enter the users' details as per file format and import users to WordPress.</li>
</ol>
If you have any queries or need assistance configuring our plugin, contact us at info@xecurify.com. Our customer support team is available 24x7 to assist you in any way possible.

= How does page privacy work? =
Using page privacy, you can make a specific page publicly accessible inside a private website.
<ol>
<li>Go to the <strong>Page Privacy</strong> tab in the plugin. And enable  <strong>Protect all content by login </strong> by clicking on the checkbox.</li>
<li>A check box will appear, <strong>Add Public Pages</strong>. Enable the checkbox, and a box will appear to add the URL of pages to be made public.</li>
<li>Enter the URL of the page that you want to make public and click on the â€˜Saveâ€™ button. The page will now be publicly accessed.</li>
</ol>
If you have any queries or need assistance configuring our plugin, contact us at info@xecurify.com. Our customer support team is available 24x7 to assist you in any way possible.

Click [here](https://plugins.miniorange.com/) to view our other products.

For support or troubleshooting help, please email us at info@xecurify.com or [Contact us](https://miniorange.com/contact).

= Can I import and export users in bulk using this plugin? =
Yes, the User and Login Management plugin allows you to import and export users in bulk. You can easily add or remove multiple users at once, saving you time and effort.

= How can I assign user roles to multiple users simultaneously? =
With the bulk user role management feature of the User and Login Management plugin, you can assign roles to multiple users at once. This streamlines the process and makes role assignments more efficient.

= Is it possible to redirect users based on their WordPress roles? =
Absolutely! The User and Login Management plugin enables you to redirect users to specific pages based on their WordPress roles. This feature helps create a personalized user experience and guides users to relevant content.

= Can I track user activity and manage their sessions with this plugin? =
Yes, the User and Login Management plugin allows you to track user activity and manage sessions effectively. You can gain insights into user behavior, such as login/logout times, session durations, and page visits, helping optimize your website's performance.


== Screenshots ==

1. Import / Export Users
2. Redirect User
3. User Session Management
4. Page Privacy

== Changelog ==

= 1.0.7 =
* Compatibility with WordPress 6.6

= 1.0.6 =
* UI Improvements
* Compatibility with WordPress 6.5

= 1.0.5 =
* Usability Improvements

= 1.0.4 =
*User and Login Management
 * Bug fixes.
 * Compatibility with WordPress 6.4

= 1.0.3 =
*User and Login Management
 * Added option to download csv template for user(s) import.
 * UI Improvements.

= 1.0.2 =
*User and Login Management
 * Compatibility with WordPress 6.3

= 1.0.1 =
*User and Login Management
 * Added User profile picture management feature.
 * UI Improvements.

= 1.0.0 =
This is the first version of the plugin.

== Upgrade Notice ==

= 1.0.7 =
* Compatibility with WordPress 6.6

= 1.0.6 =
* UI Improvements
* Compatibility with WordPress 6.5

= 1.0.5 =
* Usability Improvements

= 1.0.4 =
*User and Login Management
 * Bug fixes.
 * Compatibility with WordPress 6.4

= 1.0.3 =
*User and Login Management
 * Added option to download csv template for user(s) import.
 * UI Improvements.

= 1.0.2 =
*User and Login Management
 * Compatibility with WordPress 6.3

= 1.0.1 =
*User and Login Management
 * Added User profile picture management feature.
 * UI Improvements.

= 1.0.0 =
This is the first version of the plugin.
