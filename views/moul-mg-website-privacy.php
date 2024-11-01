<?php
/**
 * Display website privacy page.
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
	$tab_names = array( 'Restrict Page Access' );
	moul_mg_show_subnavbar( 1, $tab_names );
	?>
	<div class="moul_mg_page_wrapper moul_mg_overflow_container" style="height: 475px;">
		<div id=" moul_mg_page_content_restrict_page_access" class="moul_mg_page_content">
			<h2>Restrict access to your Pages</h2>
			<form action="" method="post">
				<?php wp_nonce_field( 'moul_mg_protect_content_by_login_nonce' ); ?>
				<input type="hidden" name="option" value="moul_mg_protect_content_by_login_option">
				<div class="moul_mg_input_field">
					<div class="moul_mg_input_label_container">
						<label for="moul_mg_protect_content_by_login_enable">Protect all content by Login</label>
					</div>
					<input type="checkbox" class="moul_mg_checkbox" name="moul_mg_protect_content_by_login_enable" value="1" <?php echo 1 === $protect_content_by_login_enabled ? 'checked' : ''; ?> id="moul_mg_protect_content_by_login_enable" onchange="this.form.submit()"	
					>
				</div>
				<div class="moul_mg_note">
					Select this option if you only want logged-in users to have access to the pages.
				</div>
			</form>


			<form action="" method="post" id="moul_mg_custom_page_restriction_form" <?php echo $protect_content_by_login_enabled ? '' : 'hidden'; ?>>
				<fieldset disabled>
					<div class="moul_mg_input_field">
							<div class="moul_mg_input_label_container">
								<label for="moul_mg_custom_page_restriction_check">Add Public Pages</label>
							</div>
						<div data-hover="This feature is available in premium version only" class="mo_mg_premium_feature_hover">
							<input type="checkbox" class="moul_mg_checkbox" id="moul_mg_custom_page_restriction_check" name="moul_mg_custom_page_restriction_check" value="1"  />
						</div>
					</div>
					<div class="moul_mg_note">
						Select this option if you want to remove the restriction for some page(s).
					</div>
					<div id="moul_mg_custom_pages_box" style="border-collapse: collapse; display:block;">
						<div>
							<div>
								<h3>Add Public Pages</h3>
							</div>
						</div>
						<div class="moul_mg_note">
							Enter URL of the pages to be made public.
						</div>
						<div id="row_1" class="moul_mg_public_page_input_row" style="margin: 1rem 0px;">
							<input type="hidden" name="option" value="moul_mg_enable_public_pages">
							<div>
								<div data-hover="This feature is available in premium version only" class="mo_mg_premium_feature_hover">
									<input type="text" class="moul_mg_custom_page_url moul_mg_input_box" id="moul_mg_custom_page_1" name="moul_mg_custom_page_1" placeholder='Type a page URL' style="width:295px;">
								</div>
								<div data-hover="This feature is available in premium version only" class="mo_mg_premium_feature_hover">
									<input type="button" class="moul_mg_small_button moul_mg_add_button moul_mg_submit_button_disabled" value="+">
								</div>
								<div data-hover="This feature is available in premium version only" class="mo_mg_premium_feature_hover">
									<input type="button" class="moul_mg_small_button moul_mg_remove_button moul_mg_submit_button_disabled" value='X'>
								</div>
							</div>

						</div>
						<div id="moul_mg_custom_page">
							<div></div>
						</div>
						<div>
							<div>
								<input type="submit" class="moul_mg_submit_button moul_mg_submit_button_disabled" value="Save" class="button button-primary ">
							</div>
						</div>
					</div>
				</fieldset>
			</form>
			<form action="" method="post" id="moul_mg_delete_public_page_form">
				<fieldset>
					<input type="hidden" name="option" value="moul_mg_delete_public_page">
					<input type="hidden" id="moul_mg_delete_public_page" name="moul_mg_delete_public_page_name" value="">
				</fieldset>
			</form>
		</div>
	</div>
</div>
