<?php
/**
 * Customer setup handler.
 *
 * @package miniOrange UL_Management
 * @subpackage handlers
 */

namespace UL_Management\Handlers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'MoUL_Mg_Customer_Setup_Handler' ) ) {
	/**
	 * Customer setup handler.
	 */
	class MoUL_Mg_Customer_Setup_Handler {

		/**
		 * API timeout value
		 *
		 * @var string
		 */
		private $api_timeout;
		/**
		 * Default customer key
		 *
		 * @var string
		 */
		private $default_customer_key;
		/**
		 * Default API key
		 *
		 * @var string
		 */
		private $default_api_key;
		/**
		 * Constructor.
		 */
		public function __construct() {
			$this->api_timeout          = ! empty( get_option( 'moul_mg_timeout_value' ) ) ? get_option( 'moul_mg_timeout_value' ) : '100';
			$this->default_customer_key = ! empty( get_option( 'moul_mg_default_customer_key' ) ) ? get_option( 'moul_mg_default_customer_key' ) : '16555';
			$this->default_api_key      = ! empty( get_option( 'moul_mg_default_api_key' ) ) ? get_option( 'moul_mg_default_api_key' ) : 'fFd2XcvTGDemZvbw1bcUesNJWEqKbbUq';
		}

		/**
		 * Get timestamp.
		 *
		 * @return object
		 */
		public function moul_mg_get_timestamp() {
			$url = MOUL_MG_HOST_NAME . '/moas/rest/mobile/get-timestamp';

			$response = wp_remote_post( $url );
			if ( is_wp_error( $response ) ) {
				$current_time_in_millis = round( microtime( true ) * 1000 );
				$current_time_in_millis = number_format( $current_time_in_millis, 0, '', '' );
				return $current_time_in_millis;
			} else {
				return $response['body'];
			}
		}
		/**
		 * Send the email.
		 *
		 * @param [string] $q_email Email.
		 * @param [string] $query Email body.
		 * @param [string] $subject Email subject.
		 * @return string
		 */
		public function moul_mg_send_email( $q_email, $query, $subject ) {
			$url = MOUL_MG_HOST_NAME . '/moas/api/notify/send';

			$customer_key = $this->default_customer_key;
			$api_key      = $this->default_api_key;
			$q_phone      = '';
			if ( empty( $q_phone ) && ! empty( get_option( 'moul_mg_admin_phone' ) ) ) {
				$q_phone = get_option( 'moul_mg_admin_phone' );
			}

			$current_time_in_millis = self::moul_mg_get_timestamp();
			$string_to_hash         = $customer_key . $current_time_in_millis . $api_key;
			$hash_value             = hash( 'sha512', $string_to_hash );
			$from_email             = $q_email;
			global $user;
			$user    = wp_get_current_user();
			$content = '<div >First Name :' . $user->user_firstname . '<br><br>Last  Name :' . $user->user_lastname . '   <br><br>Company :<a href="' . esc_url_raw( isset( $_SERVER['SERVER_NAME'] ) ? wp_unslash( $_SERVER['SERVER_NAME'] ) : '' ) . '" target="_blank" rel= "noopener noreferrer">' . sanitize_text_field( wp_unslash( $_SERVER['SERVER_NAME'] ) ) . '</a><br><br>Phone Number :' . $q_phone . '<br><br>Email :<a href="mailto:' . $from_email . '" target="_blank">' . $from_email . '</a><br><br>' . $query . '</div>';

			$fields       = array(
				'customerKey' => $customer_key,
				'sendEmail'   => true,
				'email'       => array(
					'customerKey' => $customer_key,
					'fromEmail'   => $q_email,
					'bccEmail'    => MOUL_MG_SUPPORT_EMAIL,
					'fromName'    => 'miniOrange',
					'toEmail'     => MOUL_MG_SUPPORT_EMAIL,
					'toName'      => MOUL_MG_SUPPORT_EMAIL,
					'subject'     => $subject,
					'content'     => $content,
				),
			);
			$field_string = wp_json_encode( $fields );
			$headers      = array(
				'Content-Type'  => 'application/json',
				'Customer-Key'  => $customer_key,
				'Timestamp'     => $current_time_in_millis,
				'Authorization' => $hash_value,
			);
			$args         = array(
				'method'      => 'POST',
				'body'        => $field_string,
				'timeout'     => $this->api_timeout,
				'redirection' => '5',
				'httpversion' => '1.0',
				'blocking'    => true,
				'headers'     => $headers,

			);

			$response = wp_remote_post( $url, $args );
			if ( is_wp_error( $response ) ) {
				return wp_json_encode( array( 'status' => 'ERROR' ) );
			}
			return $response['body'];
		}
	}
}
