<?php
/**
 * Session handler.
 *
 * @package miniOrange UL_Management
 * @subpackage handlers
 */

namespace UL_Management\Handlers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
use UL_Management\Utils\MoUL_Mg_Util;

if ( ! class_exists( 'MoUL_Mg_Session_Handler' ) ) {
	/**
	 * Session handler class.
	 */
	class MoUL_Mg_Session_Handler {
		/**
		 * Utility object.
		 *
		 * @var [object]
		 */
		private $util;
		/**
		 * Constructor.
		 */
		public function __construct() {
			$this->util = new MoUL_Mg_Util();
			add_action( 'admin_head', array( $this, 'moul_mg_record' ) );
			add_action( 'wp_head', array( $this, 'moul_mg_record' ) );
		}
		/**
		 * Record active users.
		 *
		 * @param string $page_url Page URL.
		 * @param string $page_title Page title.
		 * @return void
		 */
		public static function moul_mg_record( $page_url = '', $page_title = '' ) {
			global $wpdb;
			$charset_collate = $wpdb->get_charset_collate();
			$sql             = "CREATE TABLE if not exists`{$wpdb->base_prefix}moul_mg_users_online` (
									timestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
									user_type varchar( 20 ) NOT NULL default 'guest',
									user_id bigint( 20 ) NOT NULL default 0,
									user_name varchar( 250 ) NOT NULL default '',
									user_ip varchar( 39 ) NOT NULL default '',
									page_title text NOT NULL,
									page_url varchar( 255 ) NOT NULL default '',
									UNIQUE KEY useronline_id ( timestamp, user_type, user_ip )
								) $charset_collate;";

			if ( ! function_exists( 'dbDelta' ) ) {
				include_once ABSPATH . 'wp-admin' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'upgrade.php';
			}
			dbDelta( $sql );

			global $wpdb;

			$current_user = wp_get_current_user();

			if ( is_user_logged_in() ) {
				$user_ip = self::moul_mg_get_ip();

				if ( $current_user->ID ) {
					$user_id   = $current_user->ID;
					$user_name = $current_user->display_name;
					$user_type = 'member';
					$where     = $wpdb->prepare( 'WHERE user_id = %d', $user_id );
				}

				$timestamp = current_time( 'mysql' );

				$wpdb->query( $wpdb->prepare( "DELETE FROM `{$wpdb->base_prefix}moul_mg_users_online` WHERE (user_id <> 0 AND user_id = %d) OR (user_id = 0 AND user_ip = %s) OR (timestamp < DATE_SUB(%s, INTERVAL %d SECOND))", $user_id, $user_ip, $timestamp, 300 ) ); //phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- Custom Table data needs to be updated without cache.

				$data = compact( 'timestamp', 'user_type', 'user_id', 'user_name', 'user_ip', 'page_title', 'page_url' );
				$data = stripslashes_deep( $data );
				$wpdb->replace( $wpdb->base_prefix . 'moul_mg_users_online', $data ); //phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- Custom Table data needs to be updated without cache.
			}
		}
		/**
		 * Get IP address.
		 *
		 * @return string
		 */
		private static function moul_mg_get_ip() {
			if ( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
				$ip_address = sanitize_text_field( wp_unslash( $_SERVER['HTTP_X_FORWARDED_FOR'] ) );
			} else {
				$ip_address = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
			}

			list($ip_address) = explode( ',', $ip_address );

			return $ip_address;
		}
	}
}
