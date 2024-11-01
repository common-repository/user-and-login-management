<?php
/**
 * Display admin notification feature tab.
 *
 * @package miniOrange UL_Management
 * @subpackage views
 */

?>
<div class="moul_mg_page_container">
	<?php
	$tab_names = array( 'Admin Email Notification' );
	moul_mg_show_subnavbar( 1, $tab_names );

	$admin_emails = get_option( 'moul_mg_admin_notification_emails' );
	?>
	<div class="moul_mg_page_wrapper moul_mg_overflow_container" style="height: 475px;">
		<div class="moul_mg_overlay_back moul_mg_page_overlay_back d-none" id="moul_mg_page_overlay"></div>
		<div id="moul_mg_page_content_admin_email_notification" class="moul_mg_page_content">
			<h2>Admin Email Notification</h2>
			<form action="" method="post">
				<fieldset disabled>
					<?php wp_nonce_field( 'moul_mg_admin_email_notifications_nonce' ); ?>
					<input type="hidden" name="option" value="moul_mg_admin_email_notifications">
					<div class="moul_mg_input_field">
						<div class="moul_mg_input_label_container">
							<label for="moul_mg_admin_emails">Add Admin Email Addresses: </label>
						</div>
						<input type="text" class="moul_mg_url_input_box moul_mg_input_box" id="moul_mg_admin_emails" value="<?php echo esc_attr( $admin_emails ); ?>" name="moul_mg_admin_emails" placeholder="admin@xyz.com">
					</div>
					<div class="moul_mg_note">
						Upon an unsuccessful login attempt, a notification email will be sent to this email address.
					</div>		
					<div data-hover="This feature is available in premium version only" class="mo_mg_premium_feature_hover" style="width:30%;"><input type="button" class="moul_mg_submit_button moul_mg_submit_button_disabled" value="Save"/> </div>
				</fieldset>
			</form>
		</div>
	</div>
</div>
