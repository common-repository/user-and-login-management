<?php
/**
 * Display role capabilities tab.
 *
 * @package miniOrange UL_Management
 * @subpackage views
 */

?>
<div class="moul_mg_page_container">
	<?php
	$tab_names = array( 'Role Management' );
	moul_mg_show_subnavbar( 1, $tab_names );
	?>
	<div class="moul_mg_page_wrapper moul_mg_overflow_container" style="height: 475px;">
		<div class="moul_mg_overlay_back moul_mg_page_overlay_back d-none" id="moul_mg_page_overlay"></div>
		<div id="moul_mg_page_content_role_management" class="moul_mg_page_content">
		<h2>All Existing Roles</h2>
		<div class="moul_mg_display_flex moul_mg_right_sided_buttons_container">
			<button class="moul_mg_submit_button" id="moul_mg_new_role_button">New Role</button>
		</div>

		<div class="moul_mg_roles_table">
			<div class="moul_mg_roles_table_row moul_mg_roles_table_head">
				<div style="width: 10%;">SNo.</div>
				<div style="width: 30%;">Roles</div>
				<div class="moul_mg_display_flex moul_mg_role_action_box">Action</div>
			</div>
			<div class="moul_mg_roles_table moul_mg_overflow_container" style="height: 40vh;width:100%">
				<?php
				$count = 1;
				foreach ( $user_roles->role_names as $user_id => $user_role ) {
					?>
					<div class="moul_mg_roles_table_row">
						<div style="width: 10%;">
							<?php echo esc_html( $count ); ?>
						</div>
						<div style="width: 35%;">
							<?php echo esc_html( $user_role ); ?>
						</div>
						<?php if ( strcasecmp( $user_id, 'administrator' ) === 0 ) { ?>
							<div class="moul_mg_display_flex moul_mg_role_action_box">N/A</div>
						<?php } else { ?>
							<div class="moul_mg_display_flex moul_mg_role_action_box">
								<div data-hover="This feature is available in premium version only" class="mo_mg_premium_feature_hover"><p class="moul_mg_submit_button moul_mg_submit_button_disabled moul_mg_margin_none moul_mg_premium_feature_button">Edit</p></div>

								<?php if ( $count > 5 ) { ?>
									<a class="moul_mg_delete_custom_role moul_mg_margin_none moul_mg_red_button moul_mg_premium_feature_button" data-role-id="<?php echo esc_attr( $user_id ); ?>">Delete</a>
								<?php } ?>
							</div>
						<?php } ?>
					</div>
					<?php
					$count++;
				}
				?>
			</div>
		</div>

		<div id="moul_mg_create_custom_role_container" class="moul_mg_create_custom_role_container d-none">
			<h2>Create Custom Role</h2>
			<form action="" method="">
				<fieldset>
					<div class="moul_mg_create_custom_role_form">
						<input type="hidden" name="option" value="moul_mg_create_custom_role_option">
						<?php wp_nonce_field( 'moul_mg_create_custom_role_nonce' ); ?>
						<div>
							<label for="moul_mg_custom_role_id">Role ID:</label>
							<input type="text" class="moul_mg_input_box moul_mg_custom_input" id="moul_mg_custom_role_id" value="" name="moul_mg_custom_role_id" placeholder="subscriber" required>
						</div>

						<div>
							<label for="moul_mg_custom_role_name">Role Name:</label>
							<input type="text" class="moul_mg_input_box moul_mg_custom_input" id="moul_mg_custom_role_name" value="" name="moul_mg_custom_role_name" placeholder="Subscriber" required>
						</div>

						<div>
							<label for="moul_mg_custom_role_copy">Make it similar to:</label>
							<select name="moul_mg_custom_role_copy" class="moul_mg_input_box moul_mg_custom_input" id="moul_mg_custom_role_copy">
								<option value="0">None</option>
							</select>
						</div>

						<div style="justify-content: flex-end;">
							<button class="moul_mg_red_button" id="moul_mg_cancel_add_role_form_button">Cancel</button>
							<div data-hover="This feature is available in premium version only" class="mo_mg_premium_feature_hover"><input type="button" class="moul_mg_submit_button moul_mg_submit_button_disabled" value="Create Role"> </div>
						</div>
					</div>
				</fieldset>
			</form>
		</div>
	</div>
</div>
</div>


<script>
	var elements = [];

	elements.push(document.getElementById('mo_ldap_dir_search_lable_input_1'));
	elements.push(document.getElementById('mo_ldap_dir_search_lable_input_2'));
	elements.push(document.getElementById('mo_ldap_dir_search_lable_input_3'));

	let hiddenElement = document.getElementById('mo_ldap_dir_search_change_labels_premium');

	for (let i = 0; i < elements.length; i++) {
		elements[i].addEventListener('mouseover', function handleMouseOver() {
			hiddenElement.style.display = 'block';
		});

		elements[i].addEventListener('mouseout', function handleMouseOut() {
			hiddenElement.style.display = 'none';
		});
	}
</script>
