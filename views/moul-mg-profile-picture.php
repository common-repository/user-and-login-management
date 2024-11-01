<?php
/**
 * Display profile picture tab.
 *
 * @package miniOrange UL_Management
 * @subpackage views
 */

?>
<div class="moul_mg_page_container">
	<?php
	$tab_names = array( 'Upload Profile Picture' );
	moul_mg_show_subnavbar( 1, $tab_names );
	?>
	<div class="moul_mg_page_wrapper moul_mg_overflow_container" style="height: 475px;">
		<div class="moul_mg_overlay_back moul_mg_page_overlay_back d-none" id="moul_mg_page_overlay"></div>
		<div id="moul_mg_page_content_upload_profile_picture" class="moul_mg_page_content">
			<h2>All Users</h2>
			<div>
				<input id="moul_mg_searchbar" class="moul_mg_searchbar moul_mg_input_box" onkeyup="moul_mg_search_users()" type="text" name="search" placeholder="Search Users..">
			</div>
			<div class="moul_mg_active_wp_users_container">
				<div class="moul_mg_active_wp_user_row moul_mg_active_wp_user_heading_row">
					<div class="moul_mg_active_wp_user_row_column_1">
						<div class="moul_mg_active_user_details_container">Name</div>
					</div>
					<div class="moul_mg_active_user_time">Action</div>
				</div>
				<div class="moul_mg_overflow_container" style="height: 40vh;">
					<?php
					foreach ( $all_wp_users as $user ) {
						$url           = get_avatar_url( $user->ID );
						$edit_page_url = get_edit_user_link( $user->ID );
						?>
						<div class="moul_mg_active_wp_user_row">
							<div class="moul_mg_active_wp_user_row_column_1">
								<div class="moul_mg_active_user_image_container"><img src="<?php echo esc_url( $url ); ?>" height="45px" width="45px" alt=""></div>
								<div class="moul_mg_active_user_details_container">
									<a href="<?php echo esc_url( $edit_page_url ); ?>" class="moul_mg_user_name"><?php echo esc_attr( $user->user_login ); ?></a>
									<div class="moul_mg_disabled_text">#<?php echo esc_html( $user->ID ); ?></div>
								</div>
							</div>
							<div class="moul_mg_profile_picture_action_btns_container">
								<div class="moul_mg_active_user_time moul_mg_upload_profile_picture moul_mg_premium_feature_button" data-user-id="<?php echo esc_attr( $user->ID ); ?>">Upload Profile Picture</div>
								<div class="moul_mg_active_user_time moul_mg_remove_profile_picture moul_mg_premium_feature_button" data-user-id="<?php echo esc_attr( $user->ID ); ?>">Remove Profile Picture</div>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>
