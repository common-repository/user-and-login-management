<?php
/**
 * Display import-export page.
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
	$tab_names = array( 'Import Users', 'Export Users' );
	moul_mg_show_subnavbar( 2, $tab_names );
	?>
	<div class="moul_mg_page_wrapper moul_mg_overflow_container" style="height: 475px;">
		<div id="moul_mg_page_content_import_users" class="moul_mg_page_content">
			<form action="" method="post" enctype="multipart/form-data">
				<h2>Import WordPress users from CSV file</h2>
				<?php wp_nonce_field( 'moul_mg_import_users_csv_nonce' ); ?>
				<input type="hidden" name="option" value="moul_mg_import_users_csv">
				<br>
				<div class="moul_mg_input_field">
					<div class="moul_mg_input_label_container">
						<label for="moul_mg_import_user_csv_file">Upload CSV File:</label>
					</div>
					<input type="file" class="moul_mg_input_file" id="moul_mg_import_user_csv_file" name="moul_mg_import_user_csv_file" onchange="moul_mg_file_validation()">
				</div>
				<div class="moul_mg_note">
					Columns in the csv file should be the username, email, and roles in the same sequence.
				</div>
				<div class="moul_mg_input_field">
					<div class="moul_mg_input_label_container">
						<label for="moul_mg_role_for_imported_users">Default User Role:</label>
					</div>
					<select class="moul_mg_select" name="moul_mg_role_for_imported_users" id="moul_mg_role_for_imported_users">
						<?php
						foreach ( $wp_roles->get_names() as $role_name ) {
							$selected = ( strcasecmp( $role_name, 'Subscriber' ) === 0 ) ? 'selected' : '';
							echo '<option value="' . esc_attr( $role_name ) . '" ' . esc_attr( $selected ) . '>' . esc_html( $role_name ) . '</option>';
						}
						?>
					</select>
				</div>
				<div class="moul_mg_note">
					Users will be assigned the default role when a role is not specified in the CSV file.
				</div>
				<div class="moul_mg_input_field">
					<div class="moul_mg_input_label_container">
						<label for="moul_mg_overwrite_users">Overwrite Existing Users:</label>
					</div>
					<input type="checkbox" class="moul_mg_checkbox" id="moul_mg_overwrite_users" value="1" name="moul_mg_overwrite_users">
				</div>
				<div class="moul_mg_note">
					Select this option if you want to replace the current user information with the data from the CSV file.
				</div>
				<input type="submit" class="moul_mg_submit_button" value="Import">
			</form>
			<div class="moul_mg_page_content_download_sample_csv">
					<form action="" method="post">
						<input type="hidden" name="option" value="moul_mg_download_sample_csv_option">
						<?php wp_nonce_field( 'moul_mg_download_sample_csv_nonce' ); ?>
						<input class="moul_mg_page_content_button" type="submit" value="Download Demo File">
					</form>
				</div>
		</div>

		<div id="moul_mg_page_content_export_users" class="moul_mg_page_content d-none">
			<form action="" method="post">
				<h2>Export WordPress users to CSV file</h2>
				<br>
				<?php wp_nonce_field( 'moul_mg_export_users_csv_nonce' ); ?>
				<input type="hidden" name="option" value="moul_mg_export_users_csv">
				<input type="submit" class="moul_mg_submit_button" value="Export">
			</form>
		</div>
	</div>
</div>
