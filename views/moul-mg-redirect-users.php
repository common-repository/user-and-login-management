<?php
/**
 * Display redirect users page.
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
	$tab_names = array( 'Default Redirection' );
	moul_mg_show_subnavbar( 1, $tab_names );
	?>
	<div class="moul_mg_page_wrapper moul_mg_overflow_container" style="height: 475px;">
		<div id=" moul_mg_page_content_default_redirection" class="moul_mg_page_content">
			<div class="moul_mg_default_redirect_after_login">
				<h2>Default Redirection Settings</h2>
				<form action="" method="post">
					<?php wp_nonce_field( 'moul_mg_default_redirect_after_login_nonce' ); ?>
					<input type="hidden" name="option" value="moul_mg_default_redirect_after_login_option">
					<div class="moul_mg_input_field">
						<div class="moul_mg_input_label_container">
							<label for="moul_mg_default_redirect_after_login_url">Redirect User After Login: </label>
						</div>
						<input type="url" class="moul_mg_url_input_box moul_mg_input_box" id="moul_mg_default_redirect_after_login_url" value="<?php echo esc_attr( $default_login_redirect_url ); ?>" name="moul_mg_default_redirect_after_login_url" placeholder="URL">
					</div>
					<div class="moul_mg_note">
						Users will by default be redirected to the above URL upon logging in.
					</div>
					<br>
					<div class="moul_mg_input_field">
						<div class="moul_mg_input_label_container">
							<label for="moul_mg_default_redirect_after_logout_url">Redirect User After Logout: </label>
						</div>
						<input type="url" class="moul_mg_url_input_box moul_mg_input_box" id="moul_mg_default_redirect_after_logout_url" value="<?php echo esc_attr( $default_logout_redirect_url ); ?>" name="moul_mg_default_redirect_after_logout_url" placeholder="URL">
					</div>
					<div class="moul_mg_note">
						Users will by default be redirected to the above URL upon logging out.
					</div>
					<input type="submit" class="moul_mg_submit_button" value="Save">
				</form>
			</div>
		</div>
	</div>
</div>
