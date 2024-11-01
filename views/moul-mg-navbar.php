<?php
/**
 * Display navbar.
 *
 * @package miniOrange UL_Management
 * @subpackage views
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="moul_mg_mainnav">
	<a class="<?php echo strcasecmp( $active_tab, 'import-export' ) === 0 ? 'moul_mg_active_tab' : ''; ?>" href="<?php echo esc_url( add_query_arg( array( 'tab' => 'import-export' ), $filtered_current_page_url ) ); ?>">
		<img class="moul_mg_blur_icons" src="<?php echo esc_url( MOUL_MG_ICONS . 'import-export.webp' ); ?>" alt="">
		<span>Import/Export Users</span>
	</a>
	<a class="<?php echo strcasecmp( $active_tab, 'redirect-users' ) === 0 ? 'moul_mg_active_tab' : ''; ?>" href="<?php echo esc_url( add_query_arg( array( 'tab' => 'redirect-users' ), $filtered_current_page_url ) ); ?>">
		<img class="moul_mg_blur_icons" src="<?php echo esc_url( MOUL_MG_ICONS . 'redirection.webp' ); ?>" alt="">
		<span>Redirect User</span>
	</a>
	<a class="<?php echo strcasecmp( $active_tab, 'session-management' ) === 0 ? 'moul_mg_active_tab' : ''; ?>" href="<?php echo esc_url( add_query_arg( array( 'tab' => 'session-management' ), $filtered_current_page_url ) ); ?>">
		<img class="moul_mg_blur_icons" src="<?php echo esc_url( MOUL_MG_ICONS . 'user-session.webp' ); ?>" alt="">
		<span>Session Management</span>
	</a>
	<a class="<?php echo strcasecmp( $active_tab, 'website-privacy' ) === 0 ? 'moul_mg_active_tab' : ''; ?>" href="<?php echo esc_url( add_query_arg( array( 'tab' => 'website-privacy' ), $filtered_current_page_url ) ); ?>">
		<img class="moul_mg_blur_icons" src="<?php echo esc_url( MOUL_MG_ICONS . 'website-privacy.webp' ); ?>" alt="">
		<span>Website Privacy</span>
	</a>
	<a class="<?php echo strcasecmp( $active_tab, 'profile-picture' ) === 0 ? 'moul_mg_active_tab' : ''; ?>" href="<?php echo esc_url( add_query_arg( array( 'tab' => 'profile-picture' ), $filtered_current_page_url ) ); ?>">
		<img class="moul_mg_blur_icons" src="<?php echo esc_url( MOUL_MG_ICONS ) . 'profile.webp'; ?>" alt="">
		<span>Profile Picture</span>
	</a>
	<a class="<?php echo strcasecmp( $active_tab, 'roles-capabilities' ) === 0 ? 'moul_mg_active_tab' : ''; ?>" href="<?php echo esc_url( add_query_arg( array( 'tab' => 'roles-capabilities' ), $filtered_current_page_url ) ); ?>">
		<img class="moul_mg_blur_icons" src="<?php echo esc_url( MOUL_MG_ICONS ) . 'roles.webp'; ?>" alt="">	
		<span>Roles & Capabilities</span>
	</a>
	<a class="<?php echo strcasecmp( $active_tab, 'admin-notifications' ) === 0 ? 'moul_mg_active_tab' : ''; ?>" href="<?php echo esc_url( add_query_arg( array( 'tab' => 'admin-notifications' ), $filtered_current_page_url ) ); ?>">
		<img class="moul_mg_blur_icons" src="<?php echo esc_url( MOUL_MG_ICONS ) . 'email.webp'; ?>" alt="">	
		<span>Email Notifications</span>
	</a>
	<a class="<?php echo strcasecmp( $active_tab, 'other-products' ) === 0 ? 'moul_mg_active_tab' : ''; ?>" href="<?php echo esc_url( add_query_arg( array( 'tab' => 'other-products' ), $filtered_current_page_url ) ); ?>">
		<img class="moul_mg_blur_icons" src="<?php echo esc_url( MOUL_MG_ICONS . 'login.webp' ); ?>" alt="">
		<span>Other Products</span>
	</a>
	</a>
</div>
