<?php
/**
 * Display session management page.
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
	$tab_names = array( 'View Active Users', 'User Registration Manager' );
	moul_mg_show_subnavbar( 2, $tab_names );
	?>
	<div class="moul_mg_page_wrapper moul_mg_overflow_container" style="height: 475px;">
		<div id="moul_mg_page_content_view_active_users" class="moul_mg_page_content">
			<h2>View Active Users</h2>
			<form action="" method="post">
				<div class="moul_mg_active_wp_users_container">
					<div class="moul_mg_active_wp_user_row moul_mg_active_wp_user_heading_row">
						<div class="moul_mg_active_wp_user_row_column_1">
							<div class="moul_mg_active_user_details_container">Name</div>
						</div>
						<div class="moul_mg_active_user_time">Activity</div>
						<div class="moul_mg_active_user_action_box">Action</div>
					</div>
					<?php
					foreach ( $active_wp_users as $user ) {
						$url = get_avatar_url( $user['user_id'] );
						?>
							<div class="moul_mg_active_wp_user_row">
								<div class="moul_mg_active_wp_user_row_column_1">
									<div class="moul_mg_active_user_image_container"><img src="<?php echo esc_url( $url ); ?>" height="45px" width="45px" alt=""></div>
									<div class="moul_mg_active_user_details_container">
										<div><?php echo esc_html( $user['user_name'] ); ?></div>
										<div class="moul_mg_disabled_text">#<?php echo esc_html( $user['user_id'] ); ?></div>
									</div>
								</div>
								<div class="moul_mg_active_user_time">Today</div>
								<div data-hover="This feature is available in premium version only" class="mo_mg_premium_feature_hover"> <div class="moul_mg_active_user_action_box moul_mg_active_user_action_button">Logout</div></div>
							</div>
							<?php
					}
					?>
				</div>
			</form>
		</div>
		<div id="moul_mg_page_content_user_registration_manager" class="moul_mg_page_content moul_mg_page_content_urm d-none">
			<div class="moul_mg_premium_button">
				<span>
				<img class="moul_mg_blur_icons" src="<?php echo esc_url( MOUL_MG_ICONS ) . 'crown.svg'; ?>" alt="" height="20px" width="20px">
				</span>
				Premium Feature
			</div>

			<h2>Manage User Registrations</h2>
			<form action="" method="post">
				<fieldset disabled>
					<?php wp_nonce_field( 'moul_mg_user_registration_mng_enable_nonce' ); ?>
					<input type="hidden" name="option" value="moul_mg_user_registration_mng">
					<div class="moul_mg_input_field">
						<div class="moul_mg_input_label_container">
							<label for="moul_mg_user_registration_mng_enable">Enable User Registration Manager</label>
						</div>
						<input type="checkbox" class="moul_mg_checkbox" name="moul_mg_user_registration_mng_enable" value="1" id="moul_mg_user_registration_mng_enable" onchange="this.form.submit()">
					</div>
				</fieldset>
			</form>

			<div>
				<h2>Approve/Deny Users</h2>
				<div style="background-color: #e0ddff;">
					<div class="moul_mg_user_registration_tabs">
						<div class="moul_mg_user_registration_tab"><span>Pending Users</span></div>
						<div class="moul_mg_user_registration_tab moul_mg_user_registration_tab_active"><span>Approved Users</span></div>
						<div class="moul_mg_user_registration_tab"><span>Denied Users</span></div>
					</div>
					<div class="moul_mg_active_wp_users_container">
						<div class="moul_mg_active_wp_user_row moul_mg_active_wp_user_heading_row">
							<div class="moul_mg_user_registration_row_1">
								<div class="moul_mg_active_user_details_container">Username</div>
							</div>
							<div class="moul_mg_user_registration_row_1">
								<div class="moul_mg_active_user_details_container">User Email</div>
							</div>
							<div class="moul_mg_user_registration_row_1">
								<div class="moul_mg_active_user_details_container">Approve/Deny</div>
							</div>
						</div>
						<div class="moul_mg_overflow_container" style="height: 100%;">
							<?php
							foreach ( $all_wp_users as $user ) {
								$url = get_avatar_url( $user->ID );
								?>
								<div class="moul_mg_active_wp_user_row">
									<div class="moul_mg_user_registration_row_1">
										<div class="moul_mg_approve_deny_container">
											<div class="moul_mg_active_user_image_container moul_mg_unset_width">
												<img src="<?php echo esc_url( $url ); ?>" height="45px" width="45px" alt="">
											</div>
											<div class="moul_mg_username_container">
												<div><?php echo esc_html( $user->user_login ); ?></div>
											</div>
										</div>
									</div>
									<div class="moul_mg_user_registration_row_1"><div><?php echo esc_html( $user->user_email ); ?></div></div>
									<div>
										<div class="moul_mg_active_user_action_button" style="margin-left:120px;">Deny</div>
									</div>
								</div>
								<?php
							}
							?>
						</div>
					</div>
				</div>
			</div>
			<form id="moul_mg_approve_user_form" method="post">
				<?php wp_nonce_field( 'moul_mg_approve_user_nonce' ); ?>
				<input type="hidden" name="option" value="moul_mg_approve_user" />
				<input type="hidden" id="moul_mg_approve_user_id" name="moul_mg_approve_user_id" value=""/>
			</form>
			<form id="moul_mg_deny_user_form" method="post">
				<?php wp_nonce_field( 'moul_mg_deny_user_nonce' ); ?>
				<input type="hidden" name="option" value="moul_mg_deny_user" />
				<input type="hidden" id="moul_mg_deny_user_id" name="moul_mg_deny_user_id" value=""/>
			</form>
			<form id="moul_mg_subnav_user_manager_tab_form" method="post">
				<?php wp_nonce_field( 'moul_mg_subnav_user_manager_tab_nonce' ); ?>
				<input type="hidden" name="option" value="moul_mg_subnav_user_manager_tab" />
				<input type="hidden" id="moul_mg_subnav_user_manager_tab_val" name="moul_mg_subnav_user_manager_tab_val" value=""/>
			</form>
			<script>
				function setRequest( subnav ) {
					jQuery('#moul_mg_subnav_user_manager_tab_val').val(subnav);
					jQuery('#moul_mg_subnav_user_manager_tab_form').submit();
				}
				function denyUser( userID ) {
					jQuery('#moul_mg_deny_user_id').val(userID);
					jQuery('#moul_mg_deny_user_form').submit();
				} 
				function approveUser( userID ) {
					jQuery('#moul_mg_approve_user_id').val(userID);
					jQuery('#moul_mg_approve_user_form').submit();
				} 
			</script>
		</div>
	</div>
</div>
