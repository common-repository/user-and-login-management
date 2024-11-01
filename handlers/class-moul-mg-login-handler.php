<?php
/**
 * Handles login process.
 *
 * @package miniOrange UL_Management
 * @subpackage handlers
 */

namespace UL_Management\Handlers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'MoUL_Mg_Login_Handler' ) ) {
	/**
	 * Login handler class.
	 */
	class MoUL_Mg_Login_Handler {
		/**
		 * Constructor.
		 */
		public function __construct() {
			add_filter( 'login_redirect', array( $this, 'moul_mg_login_redirect' ), 10, 3 );
			add_filter( 'logout_redirect', array( $this, 'moul_mg_logout_redirect' ), 10, 3 );

			$protect_content_by_login_enabled = ! empty( get_option( 'moul_mg_protect_content_by_login_enabled' ) ) ? 1 : 0;

			if ( $protect_content_by_login_enabled ) {
				add_action( 'wp', array( $this, 'moul_mg_local_login_redirect' ) );
			}
		}
		/**
		 * Redirection upon login.
		 *
		 * @param [string] $redirect_to URL where to redirect.
		 * @param [string] $request Request.
		 * @param [object] $user WP_User object.
		 * @return string
		 */
		public function moul_mg_login_redirect( $redirect_to, $request, $user ) {
			$default_login_redirect_url = ! empty( get_option( 'moul_mg_default_redirect_after_login_url' ) ) ? get_option( 'moul_mg_default_redirect_after_login_url' ) : '';

			if ( ! empty( $default_login_redirect_url ) ) {
				return $default_login_redirect_url;
			}
			if ( isset( $user->roles ) && strcasecmp( $user->roles[0], 'administrator' ) === 0 ) {
				return get_admin_url();
			}
			return home_url();
		}
		/**
		 * Redirection upon logout.
		 *
		 * @param [string] $redirect_to URL where to redirect.
		 * @param [string] $request Request.
		 * @param [object] $user WP_User object.
		 * @return string
		 */
		public function moul_mg_logout_redirect( $redirect_to, $request, $user ) {
			$default_logout_redirect_url = ! empty( get_option( 'moul_mg_default_redirect_after_logout_url' ) ) ? get_option( 'moul_mg_default_redirect_after_logout_url' ) : '';
			if ( ! empty( $default_logout_redirect_url ) ) {
				return $default_logout_redirect_url;
			}
			return wp_login_url();
		}
		/**
		 * Login restriction.
		 *
		 * @return void
		 */
		public function moul_mg_local_login_redirect() {
			if ( ! is_user_logged_in() ) {
				auth_redirect();
			}
		}
	}
}
