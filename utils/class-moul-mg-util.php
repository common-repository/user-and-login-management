<?php
/**
 * Plugin utilities.
 *
 * @package miniOrange UL_Management
 * @subpackage utils
 */

namespace UL_Management\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'MoUL_Mg_Util' ) ) {
	/**
	 * Utility class.
	 */
	class MoUL_Mg_Util {
		/**
		 * Constructor.
		 */
		public function __construct() {
			add_option( 'moul_mg_timeout_value', '100' );
			add_option( 'moul_mg_default_customer_key', '16555' );
			add_option( 'moul_mg_default_api_key', 'fFd2XcvTGDemZvbw1bcUesNJWEqKbbUq' );
		}
		/**
		 * HTML variables allowed to be escaped.
		 *
		 * @var array
		 */
		private $esc_allowed = array(
			'a'      => array(
				'href'  => array(),
				'title' => array(),
			),
			'br'     => array(),
			'em'     => array(),
			'strong' => array(),
			'b'      => array(),
			'h1'     => array(),
			'h2'     => array(),
			'h3'     => array(),
			'h4'     => array(),
			'h5'     => array(),
			'h6'     => array(),
			'i'      => array(
				'class' => array(),
			),
			'button' => array(
				'id'    => array(),
				'class' => array(),
			),
		);
		/**
		 * Display success message.
		 *
		 * @param [string] $message Message to be displayed.
		 * @return void
		 */
		public function moul_mg_display_success( $message ) {
			update_option( 'moul_mg_local_message', $message );
			remove_action( 'admin_notices', array( $this, 'moul_mg_error_message' ) );
			add_action( 'admin_notices', array( $this, 'moul_mg_success_message' ) );
		}
		/**
		 * Display error message.
		 *
		 * @param [string] $message Message to be displayed.
		 * @return void
		 */
		public function moul_mg_display_error( $message ) {
			update_option( 'moul_mg_local_message', $message );
			remove_action( 'admin_notices', array( $this, 'moul_mg_success_message' ) );
			add_action( 'admin_notices', array( $this, 'moul_mg_error_message' ) );
		}

		/**
		 * Create users in WordPress.
		 *
		 * @param [object] $user_import_data User data.
		 * @return void
		 */
		public function moul_mg_create_users( $user_import_data ) {
			ob_clean();
			ini_set( 'auto_detect_line_endings', true );

			$csv_file = file( $user_import_data['file'] );

			$csv_content = array_map( 'str_getcsv', $csv_file );

			$csv_heading = $csv_content[0];

			$role_index     = -1;
			$total_headings = count( $csv_heading );

			for ( $i = 0; $i < $total_headings; $i++ ) {
				$csv_heading[ $i ] = trim( preg_replace( '/[\x00-\x1F\x80-\xFF]/', '', $csv_heading[ $i ] ) );
				if ( strcasecmp( $csv_heading[ $i ], 'role' ) === 0 || strcasecmp( $csv_heading[ $i ], 'roles' ) === 0 ) {
					$role_index = $i;
				}
			}

			if ( strcasecmp( $csv_heading[0], 'username' ) === 0 && strcasecmp( $csv_heading[1], 'email' ) === 0 ) {
				array_shift( $csv_content );
				foreach ( $csv_content as $data ) {
					$roles   = array();
					$user_id = -1;
					if ( -1 !== $role_index && ! empty( $data[ $role_index ] ) ) {
						$roles = explode( ',', $data[ $role_index ] );
					} else {
						array_push( $roles, $user_import_data['role'] );
					}

					$admin_email = get_bloginfo( 'admin_email' );
					if ( strcasecmp( $data[1], $admin_email ) === 0 ) {
						continue;
					}

					if ( username_exists( $data[0] ) || email_exists( $data[1] ) ) {
						if ( $user_import_data['overwrite_users'] ) {
							if ( username_exists( $data[0] ) ) {
								$user = get_user_by( 'login', $data[0] );
							} else {
								$user = get_user_by( 'email', $data[1] );
							}
							$user_data               = array( 'ID' => $user->ID );
							$user_data['user_email'] = $data[1];
							$user_data['role']       = trim( $roles[0] );

							$user_id = wp_update_user( $user_data );

							if ( is_wp_error( $user_id ) ) {
								wp_die( 'Error while updating users' );
							}

							$updated_user = get_user_by( 'id', $user_id );
							if ( count( $roles ) > 1 ) {
								foreach ( $roles as $role ) {
									$updated_user->add_role( trim( $role ) );
								}
							}
						}
					} else {
						$user_data = array(
							'user_login' => $data[0],
							'user_pass'  => wp_generate_password(),
							'user_email' => $data[1],
							'role'       => $roles[0],
						);
						$user_id   = wp_insert_user( $user_data );

						if ( is_wp_error( $user_id ) ) {
							wp_die( 'Error while creating users' );
						}

						$created_user = get_user_by( 'id', $user_id );
						if ( count( $roles ) > 1 ) {
							foreach ( $roles as $role ) {
								$created_user->add_role( trim( $role ) );
							}
						}
					}
				}
				$message = 'Users Imported Successfully.';
				$this->moul_mg_display_success( $message );
			} else {
				$message = 'File headings are not in proper format.';
				$this->moul_mg_display_error( $message );
			}
		}

		/**
		 * Render error message.
		 *
		 * @return void
		 */
		public function moul_mg_error_message() {
			$message = get_option( 'moul_mg_local_message' );

			$error_list = explode( '<br>', $message );
			$wrong_icon = MOUL_MG_IMAGES . 'error_msg.webp';
			$button     = ( count( $error_list ) > 1 ) ? "<button id='moul_mg_view_more_button' class='moul_mg_view_more_button'><i class='fa fa-angle-double-up'></i></button>" : '';
			echo "<div id='error' class='moul_mg_message_container'>
				<div class='moul_mg_message moul_mg_error_message'>
					<div class='moul_mg_message_left'>
						<img width='26px' height='26px' src='" . esc_url( $wrong_icon ) . "'/>
						<p id='moul_mg_message_title' class='moul_mg_message_content'>" . wp_kses( $error_list[0], $this->esc_allowed ) . "</p>
						<p id='moul_mg_message_desc' class='moul_mg_message_content_desc d-none'>" . wp_kses( $message, $this->esc_allowed ) . '</p>
					</div>
					' . wp_kses( $button, $this->esc_allowed ) . '
				</div>
			</div>';
		}

		/**
		 * Render success message.
		 *
		 * @return void
		 */
		public function moul_mg_success_message() {
			$message = get_option( 'moul_mg_local_message' );

			$success_list = explode( '<br>', $message );
			$right_icon   = MOUL_MG_IMAGES . 'success_msg.webp';
			$button       = ( count( $success_list ) > 1 ) ? "<button id='moul_mg_view_more_button' class='moul_mg_view_more_button'><i class='fa fa-angle-double-up'></i></button>" : '';
			echo "<div id='success' class='moul_mg_message_container'>
                <div class='moul_mg_message moul_mg_message_desc'>
                    <div class='moul_mg_message_left'>
                        <img width='26px' height='26px' src='" . esc_url( $right_icon ) . "'/>
                        <p id='moul_mg_message_title' class='moul_mg_message_content'>" . wp_kses( $success_list[0], $this->esc_allowed ) . "</p>
                        <p id='moul_mg_message_desc' class='moul_mg_message_content_desc d-none'>" . wp_kses( $message, $this->esc_allowed ) . '</p>
                    </div>
                    ' . wp_kses( $button, $this->esc_allowed ) . '
                </div>
            </div>';
		}
	}
}
