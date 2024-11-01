<?php
/**
 * Handle all the options.
 *
 * @package miniOrange UL_Management
 * @subpackage handlers
 */

namespace UL_Management\Handlers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
use UL_Management\Utils\MoUL_Mg_Util;

if ( ! class_exists( 'MoUL_Mg_Save_Options_Handler' ) ) {
	/**
	 * Save options handler class.
	 */
	class MoUL_Mg_Save_Options_Handler {
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
			add_action( 'admin_init', array( $this, 'moul_mg_redirect_home_page' ) );
			add_action( 'admin_init', array( $this, 'moul_mg_save_options' ) );

			$this->util = new MoUL_Mg_Util();
		}
		/**
		 * Redirect to the home page.
		 *
		 * @return void
		 */
		public function moul_mg_redirect_home_page() {
			if ( ! isset( $_GET['tab'] ) && isset( $_GET['page'] ) ) { //phpcs:ignore WordPress.Security.NonceVerification.Recommended, - Reading the GET parameter from the URL for checking the sub-tab name, doesn't require nonce verification.
				$current_page              = sanitize_text_field( wp_unslash( $_GET['page'] ) ); //phpcs:ignore WordPress.Security.NonceVerification.Recommended, - Reading the GET parameter from the URL for checking the sub-tab name, doesn't require nonce verification.
				$filtered_current_page_url = remove_query_arg( array( 'tab', 'role', 'action' ) );
				if ( strcasecmp( $current_page, 'mouserloginmanagement' ) === 0 ) {
					$redirect_to = add_query_arg(
						array(
							'page' => 'mouserloginmanagement',
							'tab'  => 'import-export',
						),
						$filtered_current_page_url
					);
					wp_safe_redirect( $redirect_to );
					exit();
				}
			}
		}
		/**
		 * Handle all the post requests.
		 *
		 * @return void
		 */
		public function moul_mg_save_options() {
			$post_option = isset( $_POST['option'] ) ? sanitize_text_field( wp_unslash( $_POST['option'] ) ) : ''; //phpcs:ignore WordPress.Security.NonceVerification.Missing, - Nonce verification is applied while before reading post options.
			if ( ! empty( $post_option ) ) {
				switch ( $post_option ) {
					case 'moul_mg_setup_call_option':
						$this->moul_mg_submit_setup_call_form();
						break;
					case 'moul_mg_contact_us_option':
						$this->moul_mg_submit_contact_us_form();
						break;
					case 'moul_mg_import_users_csv':
						$this->moul_mg_import_users();
						break;
					case 'moul_mg_export_users_csv':
						$this->moul_mg_export_users();
						break;
					case 'moul_mg_default_redirect_after_login_option':
						$this->moul_mg_default_redirect_save_option();
						break;
					case 'moul_mg_protect_content_by_login_option':
						$this->moul_mg_save_protect_content_by_login_option();
						break;
					case 'moul_mg_download_sample_csv_option':
						$this->moul_mg_download_sample_csv();
						break;

				}
			}
		}

		/**
		 * Download Sample CSV File.
		 *
		 * @return void
		 */
		private function moul_mg_download_sample_csv() {
			if ( check_admin_referer( 'moul_mg_download_sample_csv_nonce' ) ) {
				$sample_data =
				array(
					array( 'Username', 'Email', 'Roles' ),
					array( 'James', 'james@yourdomain.com', 'editor, contributor' ),
					array( 'Emily', 'emily@yourdomain.com', 'subscriber' ),
				);
				$file        = fopen( 'php://output', 'w' );
				header( 'Content-Disposition: attachment; filename="sample-file.csv"' );
				header( 'Content-Type: text/csv' );
				foreach ( $sample_data as $data ) {
					fputcsv( $file, $data );
				}
				exit;
			} else {
				$this->util->moul_mg_display_error( 'Unauthorized request.' );
			}
		}



		/**
		 * Export Users.
		 *
		 * @return void
		 */
		private function moul_mg_export_users() {
			if ( check_admin_referer( 'moul_mg_export_users_csv_nonce' ) ) {
				$user_details = get_users();

				$url   = wp_nonce_url( 'admin.php?page=mouserloginmanagement&tab=import-export', 'mouserloginmanagement' );
				$creds = request_filesystem_credentials( $url, '', false, false, null );
				if ( false === $creds ) {
					return;
				}
				if ( ! WP_Filesystem( $creds ) ) {
					request_filesystem_credentials( $url, '', true, false, null );
					return;
				}
				global $wp_filesystem;

				if ( ! empty( $user_details ) ) {
					$contentdir = trailingslashit( $wp_filesystem->wp_content_dir() );
					$in         = "Username, Email, Role, Id, Display Name\n";
					foreach ( $user_details as $user ) {
						$roles = '"';
						foreach ( $user->roles as $role ) {
							$roles = $roles . $role . ', ';
						}
						$roles = substr( $roles, 0, -1 );
						$roles = $roles . '"';
						if ( strpos( $roles, ',' ) === false ) {
							$roles = substr( $roles, 1 );
							$roles = substr( $roles, 0, -1 );
						}
						$in .= $user->get( 'user_login' ) . ',' . $user->get( 'user_email' ) . ',' . $roles . ',' . $user->get( 'ID' ) . ',' . $user->get( 'display_name' ) . "\n";
					}
					mb_convert_encoding( $in, 'ISO-8859-1', 'UTF-8' );
					if ( ! $wp_filesystem->put_contents( $contentdir . 'wordpress-users-details.csv', $in, FS_CHMOD_FILE ) ) {
						echo 'Failed saving file';
					}
				} else {
					$message = 'No users Available';
					$this->util->moul_mg_display_error( $message );
					return;
				}

				wp_safe_redirect( content_url() . '/wordpress-users-details.csv' );
				exit;
			} else {
				$this->util->moul_mg_display_error( 'Unauthorized request.' );
			}
		}
		/**
		 * Import users.
		 *
		 * @return void
		 */
		private function moul_mg_import_users() {
			if ( check_admin_referer( 'moul_mg_import_users_csv_nonce' ) ) {
				$mimes = array(
					'text/csv',
				);

				if ( isset( $_FILES['moul_mg_import_user_csv_file']['type'] ) && ! in_array( $_FILES['moul_mg_import_user_csv_file']['type'], $mimes, true ) ) {
					die( 'Sorry, mime type not allowed' );
				}
				$file_handler = 'moul_mg_import_user_csv_file';

				include_once ABSPATH . 'wp-admin' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'image.php';
				include_once ABSPATH . 'wp-admin' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'file.php';
				include_once ABSPATH . 'wp-admin' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'media.php';

				$attach_id = media_handle_upload( $file_handler, 0 );

				$csv_file_id = $attach_id;

				$user_import_data = array();

				$user_import_data['file']            = get_attached_file( $csv_file_id );
				$user_import_data['role']            = isset( $_POST['moul_mg_role_for_imported_users'] ) ? strtolower( sanitize_text_field( wp_unslash( $_POST['moul_mg_role_for_imported_users'] ) ) ) : '';
				$user_import_data['overwrite_users'] = isset( $_POST['moul_mg_overwrite_users'] ) ? true : false;

				$this->util->moul_mg_create_users( $user_import_data );

				wp_delete_attachment( $csv_file_id, true );
			} else {
				$this->util->moul_mg_display_error( 'Unauthorized request.' );
			}
		}
		/**
		 * Save the default redirection setting.
		 *
		 * @return void
		 */
		private function moul_mg_default_redirect_save_option() {
			if ( check_admin_referer( 'moul_mg_default_redirect_after_login_nonce' ) ) {
				$default_login_redirect_url  = isset( $_POST['moul_mg_default_redirect_after_login_url'] ) ? sanitize_text_field( wp_unslash( $_POST['moul_mg_default_redirect_after_login_url'] ) ) : '';
				$default_logout_redirect_url = isset( $_POST['moul_mg_default_redirect_after_logout_url'] ) ? sanitize_text_field( wp_unslash( $_POST['moul_mg_default_redirect_after_logout_url'] ) ) : '';
				update_option( 'moul_mg_default_redirect_after_login_url', $default_login_redirect_url );
				update_option( 'moul_mg_default_redirect_after_logout_url', $default_logout_redirect_url );
				$message = 'Default Role Based Redirection settings saved successfully.';
				$this->util->moul_mg_display_success( $message );
			} else {
				$this->util->moul_mg_display_error( 'Unauthorized request.' );
			}
		}
		/**
		 * Save and protect content by login setting.
		 *
		 * @return void
		 */
		private function moul_mg_save_protect_content_by_login_option() {
			if ( check_admin_referer( 'moul_mg_protect_content_by_login_nonce' ) ) {
				$enable_protect_all_content_by_login = isset( $_POST['moul_mg_protect_content_by_login_enable'] ) ? sanitize_text_field( wp_unslash( $_POST['moul_mg_protect_content_by_login_enable'] ) ) : '0';
				update_option( 'moul_mg_protect_content_by_login_enabled', $enable_protect_all_content_by_login );
				$message = 'All website content is now accessible to all the non-logged in users as well.';

				if ( '1' === $enable_protect_all_content_by_login ) {
					$message = 'All content of the website is only accessible to logged-in users.';
				}
				$this->util->moul_mg_display_success( $message );
			} else {
				$this->util->moul_mg_display_error( 'Unauthorized request.' );
			}
		}
		/**
		 * Submit the contact us form.
		 *
		 * @return void
		 */
		private function moul_mg_submit_contact_us_form() {
			if ( check_admin_referer( 'moul_mg_contact_us_nonce' ) ) {
				if ( ! isset( $_POST['moul_mg_contact_us_email'] ) || ! isset( $_POST['moul_mg_contact_us_query'] ) || ! filter_var( sanitize_email( wp_unslash( $_POST['moul_mg_contact_us_email'] ) ), FILTER_VALIDATE_EMAIL ) ) {
					$this->util->moul_mg_display_error( 'Please submit your query along with valid email.' );
					return;
				} else {
					$email = ! empty( $_POST['moul_mg_contact_us_email'] ) ? sanitize_email( wp_unslash( $_POST['moul_mg_contact_us_email'] ) ) : get_bloginfo( 'admin_email' );
					$phone = isset( $_POST['moul_mg_contact_us_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['moul_mg_contact_us_phone'] ) ) : '';
					$query = sanitize_text_field( wp_unslash( $_POST['moul_mg_contact_us_query'] ) );

					if ( ! empty( $phone ) ) {
						update_option( 'moul_mg_admin_phone', $phone );
					}

					$contact_us = new MoUL_Mg_Customer_Setup_Handler();
					$query      = 'Query : ' . $query . '<br><br>Current Version Installed: ' . MOUL_MG_VERSION;
					$subject    = 'Query For User and Login Management Plugin - ' . $email;
					$submitted  = '';

					$submitted = json_decode( $contact_us->moul_mg_send_email( $email, $query, $subject ), true );

					if ( isset( $submitted['status'] ) && strcasecmp( $submitted['status'], 'CURL_ERROR' ) === 0 ) {
						$this->util->moul_mg_display_error( $submitted['statusMessage'] );
					} elseif ( ! $submitted ) {
						$this->util->moul_mg_display_error( 'There was an error in sending query. Please send us an email on <a href=mailto:info@xecurify.com><b>info@xecurify.com</b></a>.' );
					} else {
						$this->util->moul_mg_display_success( "Your query successfully sent.<br>In case we don't get back to you, there might be email delivery failures. You can send us email on <a href=mailto:info@xecurify.com><b>info@xecurify.com</b></a> in that case." );
					}
				}
			} else {
				$this->util->moul_mg_display_error( 'Unauthorized request.' );
			}
		}
		/**
		 * Submit setup call form.
		 *
		 * @return void
		 */
		private function moul_mg_submit_setup_call_form() {
			if ( check_admin_referer( 'moul_mg_setup_call_nonce' ) ) {
				if ( ! isset( $_POST['moul_mg_setup_call_email'] ) || ! isset( $_POST['moul_mg_setup_call_time'] ) || ! isset( $_POST['moul_mg_setup_call_date'] ) || ! isset( $_POST['moul_mg_setup_call_query'] ) || ! filter_var( sanitize_text_field( wp_unslash( $_POST['moul_mg_setup_call_email'] ) ), FILTER_VALIDATE_EMAIL ) ) {
					$this->util->moul_mg_display_error( 'Please submit your setup call request along with valid email.' );
					return;
				} else {
					$email    = ! empty( sanitize_text_field( wp_unslash( $_POST['moul_mg_setup_call_email'] ) ) ) ? sanitize_text_field( wp_unslash( $_POST['moul_mg_setup_call_email'] ) ) : get_bloginfo( 'admin_email' );
					$query    = sanitize_text_field( wp_unslash( $_POST['moul_mg_setup_call_query'] ) );
					$timezone = ! empty( $_POST['moul_mg_setup_call_timezone'] ) ? sanitize_text_field( wp_unslash( $_POST['moul_mg_setup_call_timezone'] ) ) : '';
					$date     = sanitize_text_field( wp_unslash( $_POST['moul_mg_setup_call_date'] ) );
					$time     = sanitize_text_field( wp_unslash( $_POST['moul_mg_setup_call_time'] ) );

					$contact_us = new MoUL_Mg_Customer_Setup_Handler();
					$query      = 'Timezone: ' . $timezone . '<br><br>Date: ' . $date . '<br><br>Time: ' . $time . '<br><br>Query : ' . $query . '<br><br>Current Version Installed: ' . MOUL_MG_VERSION;
					$subject    = 'Setup a Call For User and Login Management Plugin - ' . $email;
					$submitted  = '';

					$submitted = json_decode( $contact_us->moul_mg_send_email( $email, $query, $subject ), true );

					if ( isset( $submitted['status'] ) && strcasecmp( $submitted['status'], 'CURL_ERROR' ) === 0 ) {
						$this->util->moul_mg_display_error( $submitted['statusMessage'] );
					} elseif ( ! $submitted ) {
						$this->util->moul_mg_display_error( 'There was an error in sending query. Please send us an email on <a href=mailto:info@xecurify.com><b>info@xecurify.com</b></a>.' );
					} else {
						$this->util->moul_mg_display_success( "Your query successfully sent.<br>In case we don't get back to you, there might be email delivery failures. You can send us email on <a href=mailto:info@xecurify.com><b>info@xecurify.com</b></a> in that case." );
					}
				}
			} else {
				$this->util->moul_mg_display_error( 'Unauthorized request.' );
			}
		}
	}
}
