<?php
/**
 * Load Plugin dependencies.
 *
 * @package miniOrange UL_Management
 */

namespace UL_Management;

require_once 'traits' . DIRECTORY_SEPARATOR . 'moul-mg-instance.php';

require_once 'handlers' . DIRECTORY_SEPARATOR . 'class-moul-mg-save-options-handler.php';
require_once 'handlers' . DIRECTORY_SEPARATOR . 'class-moul-mg-login-handler.php';
require_once 'handlers' . DIRECTORY_SEPARATOR . 'class-moul-mg-session-handler.php';
require_once 'handlers' . DIRECTORY_SEPARATOR . 'class-moul-mg-customer-setup-handler.php';
require_once 'handlers' . DIRECTORY_SEPARATOR . 'class-moul-mg-avatar-handler.php';

require_once 'utils' . DIRECTORY_SEPARATOR . 'class-moul-mg-util.php';
require_once 'utils' . DIRECTORY_SEPARATOR . 'class-moul-mg-time-zone.php';

use UL_Management\Traits\MoUL_Mg_Instance;

use UL_Management\Handlers\MoUL_Mg_Save_Options_Handler;
use UL_Management\Handlers\MoUL_Mg_Login_Handler;
use UL_Management\Handlers\MoUL_Mg_Customer_Setup_Handler;
use UL_Management\Handlers\MoUL_Mg_Session_Handler;
use UL_Management\Handlers\MoUL_Mg_Avatar_Handler;

use UL_Management\Utils\MoUL_Mg_Util;
use UL_Management\Utils\MoUL_Mg_Time_Zone;


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'MoUL_Management' ) ) {
	/**
	 * Plugin functions.
	 */
	final class MoUL_Management {

		use MoUL_Mg_Instance;
		/**
		 * Time zone
		 *
		 * @var [array]
		 */
		private $time_zone;

		/**
		 * Remove nonce
		 *
		 * @var string
		 */
		private $remove_avatar_nonce;

		/**
		 * Constructor
		 */
		private function __construct() {
			$this->moul_mg_initialize_hooks();
			$this->moul_mg_initialize_handlers();
			$this->moul_mg_initialize_utils();
		}
		/**
		 * Initialize hooks
		 *
		 * @return void
		 */
		private function moul_mg_initialize_hooks() {
			add_action( 'admin_menu', array( $this, 'moul_mg_admin_menu' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'moul_mg_registration_plugin_settings_style' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'moul_mg_registration_plugin_settings_script' ) );

			add_action( 'plugin_action_links_' . MOUL_MG_PLUGIN_NAME, array( $this, 'moul_mg_plugin_action_links' ), 10, 1 );

			add_action( 'show_user_profile', array( $this, 'moul_mg_edit_user_profile' ) );
			add_action( 'edit_user_profile', array( $this, 'moul_mg_edit_user_profile' ) );
		}
		/**
		 * Initialize handlers
		 *
		 * @return void
		 */
		private function moul_mg_initialize_handlers() {
			$var            = new MoUL_Mg_Save_Options_Handler();
			$login          = new MoUL_Mg_Login_Handler();
			$session        = new MoUL_Mg_Session_Handler();
			$customer_setup = new MoUL_Mg_Customer_Setup_Handler();
			$avatar         = new MoUL_Mg_Avatar_Handler();
		}
		/**
		 * Initialize utilities
		 *
		 * @return void
		 */
		private function moul_mg_initialize_utils() {
			$util            = new MoUL_Mg_Util();
			$this->time_zone = new MoUL_Mg_Time_Zone();
		}
		/**
		 * Admin menu
		 *
		 * @return void
		 */
		public function moul_mg_admin_menu() {
			add_menu_page( 'User and Login Management', 'User and Login Management', 'manage_options', 'mouserloginmanagement', array( $this, 'moul_mg_options' ), MOUL_MG_IMAGES . 'miniorange_icon.webp' );
			add_submenu_page( 'mouserloginmanagement', 'Pricing Plans', 'Pricing Plans', 'manage_options', 'moul-mg-pricing', array( $this, 'moul_mg_options' ) );
		}
		/**
		 * Plugin option
		 *
		 * @return void
		 */
		public function moul_mg_options() {
			$time_zone = $this->time_zone;
			require_once MOUL_MG_DIR . 'controllers' . DIRECTORY_SEPARATOR . 'moul-mg-main-controller.php';
		}

		/**
		 * Function moul_mg_registration_plugin_settings_style
		 *
		 * @param  string $page Current page.
		 * @return void
		 */
		public function moul_mg_registration_plugin_settings_style( $page ) {
			if ( strcasecmp( $page, 'toplevel_page_mouserloginmanagement' ) !== 0 && strcasecmp( $page, 'user-and-login-management_page_moul-mg-pricing' ) !== 0 ) {
				return;
			}
			wp_enqueue_style( 'moul_mg_main_style', MOUL_MG_MAIN_CSS, array(), MOUL_MG_STYLE_VERSION );
			wp_enqueue_style( 'moul_mg_intellInput_style', MOUL_MG_URL . 'includes/css/moul-mg-phone.min.css', array(), MOUL_MG_STYLE_VERSION );
		}
		/**
		 * Enqueue scripts
		 *
		 * @return void
		 */
		public function moul_mg_registration_plugin_settings_script() {
			wp_enqueue_media();
			wp_enqueue_script( 'moul_mg_intellInput_scripts', MOUL_MG_URL . 'includes/js/moul-mg-phone.min.js', array(), MOUL_MG_SCRIPT_VERSION, true );
			wp_enqueue_script( 'moul_mg_main_scripts', MOUL_MG_MAIN_JS, array(), MOUL_MG_SCRIPT_VERSION, true );

			$this->remove_avatar_nonce = wp_create_nonce( 'remove_user_mg_local_avatar_nonce' );

			wp_enqueue_script( 'moul_mg_avatar_scripts', MOUL_MG_URL . 'includes/js/moul-mg-local-avatars.min.js', array(), MOUL_MG_SCRIPT_VERSION, true );
			wp_localize_script(
				'moul_mg_avatar_scripts',
				'moUserMgLocalAvatars',
				array(
					'ajaxurl'           => admin_url( 'admin-ajax.php' ),
					'selectCrop'        => 'Select image',
					'removeAvatarNonce' => $this->remove_avatar_nonce,
					'mediaNonce'        => wp_create_nonce( 'assign_user_mg_local_avatar_nonce' ),
				)
			);
		}
		/**
		 * Edit user profile.
		 *
		 * @param  object $user_profile Profile object.
		 * @return void
		 */
		public function moul_mg_edit_user_profile( $user_profile ) { ?>
			<div id="moul_mg_avatar_section">
				<h3>Profile Picture</h3>
				<?php wp_nonce_field( 'moul_mg_local_avatar_nonce', '_moul_mg_local_avatar_nonce' ); ?>
				<table class="form-table">
					<tr class="upload-avatar-row">
						<th scope="row"><label>Profile Picture</label></th>
						<td style="width: 120px;">
							<?php
							echo wp_kses_post( get_avatar( $user_profile->ID ) );
							?>
						</td>
						<td>
							<?php
							$remove_url = add_query_arg(
								array(
									'action'   => 'remove_user_mg_local_avatar',
									'user_id'  => $user_profile->ID,
									'_wpnonce' => $this->remove_avatar_nonce,
								)
							);

							if ( ! current_user_can( 'upload_files' ) ) {
								?>
								<p style="display: inline-block; width: 26em;">
									<span class="description">Choose an image from your computer:</span><br />
									<input type="file" name="moul_mg_local_avatar" id="moul_mg_local_avatar" class="standard-text" />
								</p>
							<?php } ?>
							<p>
								<?php if ( current_user_can( 'upload_files' ) && did_action( 'wp_enqueue_media' ) ) { ?>
									<a href="#" class="moul_mg_button moul_mg_active_user_time moul_mg_upload_profile_picture" data-user-id = <?php echo esc_attr( $user_profile->ID ); ?>>Upload Profile Picture</a> &nbsp;
								<?php } ?>
								<a href="<?php echo esc_url( $remove_url ); ?>" class="moul_mg_button moul_mg_active_user_time moul_mg_remove_profile_picture" id="moul_mg_avatar_remove" data-user-id = <?php echo esc_attr( $user_profile->ID ); ?>>
									Delete Profile Picture
								</a>
							</p>
						</td>
					</tr>		
				</table>
			</div>
			<?php
		}


		/**
		 * Plugin links
		 *
		 * @param [string] $links URL.
		 * @return string
		 */
		public function moul_mg_plugin_action_links( $links ) {
			if ( is_plugin_active( MOUL_MG_PLUGIN_NAME ) ) {
				$filtered_current_page_url = remove_query_arg( array( 'tab', 'role', 'action' ) );

				$links = array_merge(
					array(
						'<a href="' . esc_url( add_query_arg( array( 'page' => 'mouserloginmanagement' ), $filtered_current_page_url ) ) . '">Settings</a>',
					),
					$links
				);
			}
			return $links;
		}
	}
}
