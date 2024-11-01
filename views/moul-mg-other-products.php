<?php
/**
 * Display login integration page.
 *
 * @package miniOrange UL_Management
 * @subpackage views
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="moul_mg_page_container">
	<?php
	$tab_names = array( 'Other Products' );
	moul_mg_show_subnavbar( 1, $tab_names );

	$integration_card_data = array(
		'proctopress'             => array(
			'title'         => 'ProctoPress : Quiz/Exam Proctoring For LMS',
			'desc'          => 'Monitoring candidates during online exams is made easy for educational institutions with the fully customizable ProctoPress Plugin. The WordPress proctoring plugin comprises various features, such as browsing limitation, real-time candidate monitoring, candidate verification, integration with popular LMS, etc.',
			'download_link' => 'https://wordpress.org/plugins/exam-and-quiz-online-proctoring-with-lms-integration/',
			'page_link'     => 'https://plugins.miniorange.com/wp-online-proctoring-for-lms',
		),
		'ldap_intranet'           => array(
			'title'         => 'Active Directory Integration / LDAP Integration',
			'desc'          => 'This plugin allows you to authenticate your users using their Active Directory/LDAP credentials into your WordPress site.',
			'download_link' => 'https://wordpress.org/plugins/ldap-login-for-intranet-sites/',
			'page_link'     => 'https://plugins.miniorange.com/wordpress-ldap-login-intranet-sites',
		),
		'saml'                    => array(
			'title'         => 'SAML Single Sign On - SSO Login',
			'desc'          => 'SAML SP Single Sign On ( WordPress SSO ) provides SAML authentication for WordPress allowing your users to log in to the WP site.',
			'download_link' => 'https://wordpress.org/plugins/miniorange-saml-20-single-sign-on/',
			'page_link'     => 'https://plugins.miniorange.com/wordpress-single-sign-on-(sso)',
		),
		'oauth'                   => array(
			'title'         => 'OAuth Single Sign On - SSO (OAuth Client)',
			'desc'          => 'WordPress Single Sign-On ( WordPress SSO ) allows users to login into any site / application using a single set of credentials of another app / site.',
			'download_link' => 'https://wordpress.org/plugins/miniorange-login-with-eve-online-google-facebook/',
			'page_link'     => 'https://plugins.miniorange.com/wordpress-sso',
		),
		'ldap_cloud'              => array(
			'title'         => 'Active Directory / LDAP Integration for cloud & shared Hosting Platforms',
			'desc'          => 'This plugin allows you to log in to WordPress sites hosted on shared hosting platforms using Active Directory and LDAP Directory credentials without enabling the PHP LDAP extension.',
			'download_link' => 'https://wordpress.org/plugins/miniorange-wp-ldap-login/',
			'page_link'     => 'https://plugins.miniorange.com/wordpress-ldap-login-cloud',
		),
		'wp_security_pro'         => array(
			'title'         => 'WordPress Security - Firewall, Malware Scanner, Secure Login and Backup',
			'desc'          => 'A malware scanner and endpoint firewall that was created specifically for WordPress is included in Wp security pro. To keep your website secure, our Threat Defense Feed provides Wp Security Pro with the most recent firewall rules, malware signatures, and dangerous IP addresses.',
			'download_link' => 'https://wordpress.org/plugins/wp-security-pro/',
			'page_link'     => 'https://plugins.miniorange.com/wp-security-pro',
		),
		'limit_login_attempts'    => array(
			'title'         => 'Limit Login Attempts',
			'desc'          => 'Limit Login Attempts provides a comprehensive security package to secure your site. Limit Login Attempts will protect from the advanced brute force by Limit login, Ip blocking, renaming login URL, and protection from spam/bot by Google Recaptcha.',
			'download_link' => 'https://wordpress.org/plugins/miniorange-limit-login-attempts/',
			'page_link'     => 'https://plugins.miniorange.com/wordpress-limit-login-attempts',
		),
		'password_policy_manager' => array(
			'title'         => 'Password Policy Manager | Password Manager',
			'desc'          => 'Makes it easy to create and enforce strong and secure password policies with features like password score, reset the password, force password change etc.',
			'download_link' => 'https://wordpress.org/plugins/password-policy-manager/',
			'page_link'     => 'https://plugins.miniorange.com/password-policy-manager',
		),
		'2fa'                     => array(
			'title'         => 'Two Factor Authentication (2FA, MFA, OTP SMS and Email)',
			'desc'          => 'Multi-factor authentication can be configured for any TOTP-based authentication method like Google Authenticator, etc to secure your WordPress website. It also supports OTP Over SMS, Email, WhatsApp, Telegram, and many more authentication methods.',
			'download_link' => 'https://wordpress.org/plugins/miniorange-login-security/',
			'page_link'     => 'https://plugins.miniorange.com/2-factor-authentication-for-wordpress-wp-2fa',
		),
		'otp'                     => array(
			'title'         => 'Email Verification / SMS Verification / OTP Verification / OTP Authentication',
			'desc'          => 'WordPress OTP Verification plugin sends OTP Verification Codes and SMS Notifications for Email Address and Phone Number Verification. It helps the site to prevent fake users by verifying their mobile number/Email Address',
			'download_link' => 'https://wordpress.org/plugins/miniorange-otp-verification/',
			'page_link'     => 'https://plugins.miniorange.com/wordpress-otp-verification',
		),
	)

	?>
	<div class="moul_mg_page_wrapper moul_mg_overflow_container" style="height: 475px;">
		<div id="moul_mg_page_content_wordpress_login_integration" class="moul_mg_page_content">
			<div class="moul_mg_login_integration_wrapper">
				<?php
				foreach ( $integration_card_data as $key => $value ) {
					?>
					<div class="moul_mg_login_integration_box <?php echo esc_attr( $key ); ?>_ad_box">
						<?php echo esc_html( moul_mg_display_integration_cards( $value ) ); ?>
					</div>
					<?php
				}
				?>
			</div>
		</div>
	</div>
</div>
