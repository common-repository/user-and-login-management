<?php
/**
 * Avatar handler.
 *
 * @package miniOrange UL_Management
 * @subpackage handlers
 */

namespace UL_Management\Handlers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use UL_Management\Utils\MoUL_Mg_Util;

if ( ! class_exists( 'MoUL_Mg_Avatar_Handler' ) ) {
	/**
	 * MoUL_Mg_Avatar_Handler
	 */
	class MoUL_Mg_Avatar_Handler {

		/**
		 * Var user_key
		 *
		 * @var mixed
		 */
		private $user_key;

		/**
		 * The user ID.
		 *
		 * @var int.
		 */
		private $user_id_being_edited;

		/**
		 * Utility object.
		 *
		 * @var [object]
		 */
		private $util;

		/**
		 * __construct
		 *
		 * @return void
		 */
		public function __construct() {
			$this->util     = new MoUL_Mg_Util();
			$this->user_key = 'moul_mg_local_avatar';
			add_action( 'personal_options_update', array( $this, 'edit_user_profile_update' ) );
			add_action( 'edit_user_profile_update', array( $this, 'edit_user_profile_update' ) );

			add_action( 'user_edit_form_tag', array( $this, 'user_edit_form_tag' ) );

			add_filter( 'pre_get_avatar_data', array( $this, 'get_avatar_data' ), 11, 2 );
			add_action( 'wp_ajax_assign_user_mg_local_avatar_media', array( $this, 'ajax_assign_user_mg_local_avatar_media' ) );
			add_action( 'wp_ajax_remove_user_mg_local_avatar', array( $this, 'action_remove_user_mg_local_avatar' ) );
		}

		/**
		 * Ensure that the profile form has proper encoding type
		 */
		public function user_edit_form_tag() {
			echo 'enctype="multipart/form-data"';
		}

		/**
		 * Save any changes to the user profile
		 *
		 * @param int $user_id ID of user being updated.
		 */
		public function edit_user_profile_update( $user_id ) {
			if ( empty( $_POST['_moul_mg_local_avatar_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_moul_mg_local_avatar_nonce'] ) ), 'moul_mg_local_avatar_nonce' ) ) {
				return;
			}

			if ( ! empty( $_FILES['moul_mg_local_avatar']['name'] ) && isset( $_FILES['moul_mg_local_avatar']['error'] ) && 0 === $_FILES['moul_mg_local_avatar']['error'] ) {
				$allowed_mime_types = wp_get_mime_types();
				$file_mime_type     = isset( $_FILES['moul_mg_local_avatar']['type'] ) ? strtolower( sanitize_text_field( wp_unslash( $_FILES['moul_mg_local_avatar']['type'] ) ) ) : '';

				if ( ! ( 0 === strpos( $file_mime_type, 'image/' ) ) || ! in_array( $file_mime_type, $allowed_mime_types, true ) ) {
					$this->util->moul_mg_display_error( 'Only images can be uploaded as an avatar' );
					return;
				}

				// front end (theme my profile etc) support.
				if ( ! function_exists( 'media_handle_upload' ) ) {
					include_once ABSPATH . 'wp-admin/includes/media.php';
				}

				// front end (plugin bbPress etc) support.
				if ( ! function_exists( 'wp_handle_upload' ) ) {
					include_once ABSPATH . 'wp-admin/includes/file.php';
				}
				if ( ! function_exists( 'wp_generate_attachment_metadata' ) ) {
					include_once ABSPATH . 'wp-admin/includes/image.php';
				}

				$this->user_id_being_edited = $user_id; // make user_id known to unique_filename_callback function.
				$avatar_id                  = media_handle_upload(
					'moul_mg_local_avatar',
					0,
					array(),
					array(
						'mimes'                    => array(
							'jpg|jpeg|jpe' => 'image/jpeg',
							'gif'          => 'image/gif',
							'png'          => 'image/png',
						),
						'test_form'                => false,
						'unique_filename_callback' => array( $this, 'unique_filename_callback' ),
					)
				);

				if ( is_wp_error( $avatar_id ) ) { // handle failures.
					$this->util->moul_mg_display_error( 'There was an error uploading the avatar' );
					return;
				}
				$this->assign_new_user_avatar( $avatar_id, $user_id );
			}
		}

		/**
		 * Creates a unique, meaningful file name for uploaded avatars.
		 *
		 * @param  string $dir  Path for file.
		 * @param  string $name Filename.
		 * @param  string $ext  File extension (e.g. ".jpg").
		 * @return string Final filename
		 */
		public function unique_filename_callback( $dir, $name, $ext ) {
			$user      = get_user_by( 'id', (int) $this->user_id_being_edited );
			$base_name = sanitize_file_name( $user->display_name . '_avatar_' . time() );
			$name      = $base_name;

			$number = 1;
			while ( file_exists( $dir . "/$name$ext" ) ) {
				$name = $base_name . '_' . $number;
				$number ++;
			}

			return $name . $ext;
		}

		/**
		 * Function get_avatar_data
		 *
		 * @param  array $args Arguments.
		 * @param  mixed $id_or_email Id or email.
		 * @return array
		 */
		public function get_avatar_data( $args, $id_or_email ) {
			if ( ! empty( $args['force_default'] ) ) {
				return $args;
			}

			$avatar_url = $this->moul_mg_get_avatar_url( $id_or_email, $args['size'] );
			if ( $avatar_url ) {
				$args['url'] = $avatar_url;
			}

			if ( ! empty( $args['url'] ) ) {
				$args['found_avatar'] = true;

				// If custom alt text isn't passed, pull alt text from the local image.
				if ( empty( $args['alt'] ) ) {
					$args['alt'] = '';
				}
			}

			return $args;
		}

		/**
		 * Function ajax_assign_user_mg_local_avatar_media
		 *
		 * @return void
		 */
		public function ajax_assign_user_mg_local_avatar_media() {
			if ( empty( $_POST['user_id'] ) || empty( $_POST['media_id'] ) || empty( $_POST['_wpnonce'] ) || ! check_admin_referer( 'assign_user_mg_local_avatar_nonce' ) ) {
				die;
			}

			$media_id = (int) $_POST['media_id'];
			$user_id  = (int) $_POST['user_id'];

			// ensure the media is real is an image.
			if ( wp_attachment_is_image( $media_id ) ) {
				$this->assign_new_user_avatar( $media_id, $user_id );
			}

			die;
		}

		/**
		 * Function action_remove_user_mg_local_avatar : Remove avatar.
		 *
		 * @return void
		 */
		public function action_remove_user_mg_local_avatar() {
			if ( ! empty( $_GET['user_id'] ) && ! empty( $_GET['_wpnonce'] ) && check_admin_referer( 'remove_user_mg_local_avatar_nonce' ) ) {
				$user_id = (int) $_GET['user_id'];

				delete_user_meta( $user_id, $this->user_key );
			}

			die;
		}

		/**
		 * Function assign_new_user_avatar: Assign new avatar.
		 *
		 * @param  int $url_or_media_id media id.
		 * @param  int $user_id user id.
		 * @return void
		 */
		public function assign_new_user_avatar( $url_or_media_id, $user_id ) {

			$meta_value = array();

			// set the new avatar.
			if ( is_int( $url_or_media_id + 0 ) ) {
				$meta_value['media_id'] = $url_or_media_id;
				$url_or_media_id        = wp_get_attachment_url( $url_or_media_id );
			}

			$meta_value['full']    = $url_or_media_id;
			$meta_value['blog_id'] = get_current_blog_id();

			update_user_meta( $user_id, $this->user_key, $meta_value ); // save user information (overwriting old).
		}

		/**
		 * Function moul_mg_get_avatar_url
		 *
		 * @param  mixed $id_or_email id.
		 * @param  int   $size image size.
		 * @return string
		 */
		public function moul_mg_get_avatar_url( $id_or_email, $size = 96 ) {
			$user_id = $this->get_user_id( $id_or_email );

			if ( empty( $user_id ) ) {
				return '';
			}

			// Fetch local avatar from meta and make sure it's properly set.
			$local_avatars = get_user_meta( $user_id, $this->user_key, true );
			if ( empty( $local_avatars['full'] ) ) {
				return '';
			}

			// handle "real" media.
			if ( ! empty( $local_avatars['media_id'] ) ) {
				$avatar_full_path = get_attached_file( $local_avatars['media_id'] );

				// check if the media is deleted.
				if ( ! $avatar_full_path ) {
					return '';
				}
			}

			$size = (int) $size;

			// Generate a new size.
			if ( ! array_key_exists( $size, $local_avatars ) ) {
				$local_avatars[ $size ] = $local_avatars['full']; // just in case of failure elsewhere.

				$upload_path = wp_upload_dir();

				// get path for image by converting URL, unless its already been set, thanks to using media library approach.
				if ( ! isset( $avatar_full_path ) ) {
					$avatar_full_path = str_replace( $upload_path['baseurl'], $upload_path['basedir'], $local_avatars['full'] );
				}

				// generate the new size.
				$editor = wp_get_image_editor( $avatar_full_path );
				if ( ! is_wp_error( $editor ) ) {
					$resized = $editor->resize( $size, $size, true );
					if ( ! is_wp_error( $resized ) ) {
						$dest_file = $editor->generate_filename();
						$saved     = $editor->save( $dest_file );
						if ( ! is_wp_error( $saved ) ) {
							// Transform the destination file path into URL.
							$dest_file_url = '';
							if ( false !== strpos( $dest_file, $upload_path['basedir'] ) ) {
								$dest_file_url = str_replace( $upload_path['basedir'], $upload_path['baseurl'], $dest_file );
							} elseif ( is_multisite() && false !== strpos( $dest_file, ABSPATH . 'wp-content/uploads' ) ) {
								$dest_file_url = str_replace( ABSPATH . 'wp-content/uploads', network_site_url( '/wp-content/uploads' ), $dest_file );
							}

							$local_avatars[ $size ] = $dest_file_url;
						}
					}
				}

				// save updated avatar sizes.
				update_user_meta( $user_id, $this->user_key, $local_avatars );
			}

			if ( 'http' !== substr( $local_avatars[ $size ], 0, 4 ) ) {
				$local_avatars[ $size ] = home_url( $local_avatars[ $size ] );
			}

			return esc_url( $local_avatars[ $size ] );
		}

		/**
		 * Function get_user_id
		 *
		 * @param  mixed $id_or_email id or email.
		 * @return string
		 */
		public function get_user_id( $id_or_email ) {
			$user_id = false;

			if ( is_numeric( $id_or_email ) ) {
				$user_id = (int) $id_or_email;
			} elseif ( is_object( $id_or_email ) && ! empty( $id_or_email->user_id ) ) {
				$user_id = (int) $id_or_email->user_id;
			} elseif ( is_string( $id_or_email ) ) {
				$user    = get_user_by( 'email', $id_or_email );
				$user_id = $user ? $user->ID : '';
			}

			return $user_id;
		}
	}
}
