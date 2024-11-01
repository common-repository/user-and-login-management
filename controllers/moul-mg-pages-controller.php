<?php
/**
 * Page controller.
 *
 * @package miniOrange UL_Management
 * @subpackage controllers
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $wp_roles;

$default_login_redirect_url  = ! empty( get_option( 'moul_mg_default_redirect_after_login_url' ) ) ? get_option( 'moul_mg_default_redirect_after_login_url' ) : '';
$default_logout_redirect_url = ! empty( get_option( 'moul_mg_default_redirect_after_logout_url' ) ) ? get_option( 'moul_mg_default_redirect_after_logout_url' ) : '';

$active_wp_users = moul_mg_get_online_users();
$active_wp_users = ! empty( $active_wp_users ) ? $active_wp_users : array();

$user_roles   = wp_roles();
$all_wp_users = get_users();


$protect_content_by_login_enabled = ! empty( get_option( 'moul_mg_protect_content_by_login_enabled' ) ) ? 1 : 0;

switch ( $active_tab ) {
	case 'import-export':
		include_once MOUL_MG_VIEWS . 'moul-mg-import-export.php';
		break;
	case 'redirect-users':
		include_once MOUL_MG_VIEWS . 'moul-mg-redirect-users.php';
		break;
	case 'session-management':
		include_once MOUL_MG_VIEWS . 'moul-mg-session-management.php';
		break;
	case 'website-privacy':
		include_once MOUL_MG_VIEWS . 'moul-mg-website-privacy.php';
		break;
	case 'profile-picture':
		include_once MOUL_MG_VIEWS . 'moul-mg-profile-picture.php';
		break;
	case 'roles-capabilities':
		if ( ! isset( $_GET['action'] ) ) { //phpcs:ignore WordPress.Security.NonceVerification.Recommended, - Reading GET parameter from the URL for checking the action name, doesn't require nonce verification.
			include_once MOUL_MG_VIEWS . 'moul-mg-roles-capabilities.php';
		}
		break;
	case 'admin-notifications':
		require_once MOUL_MG_VIEWS . 'moul-mg-admin-notification-email.php';
		break;
	case 'other-products':
		include_once MOUL_MG_VIEWS . 'moul-mg-other-products.php';
		break;
}
/**
 * Get online users
 *
 * @return array
 */
function moul_mg_get_online_users() {
	global $wpdb;

	$moul_mg_online_users_list_cache = wp_cache_get( 'moul_mg_online_users_list' );

	if ( $moul_mg_online_users_list_cache ) {
		$result = $moul_mg_online_users_list_cache;
	} else {
		$result = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}moul_mg_users_online ORDER BY timestamp DESC", 'ARRAY_A' ); //phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, - Fetching data from a custom table.
		wp_cache_set( 'moul_mg_online_users_list', $result );
	}
	$total_records = count( $result );
	for ( $i = 0; $i < $total_records; $i++ ) {
		$user_id = $result[ $i ]['user_id'];
		if ( ! get_user_meta( $user_id, 'session_tokens' ) ) {
			$wpdb->delete( $wpdb->prefix . 'moul_mg_users_online', array( 'user_id' => $user_id ) ); //phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, - Modifying a custom table.
			wp_cache_delete( 'moul_mg_online_users_list' );
		}
		$j                  = $i + 1;
		$result[ $i ]['id'] = (string) $j;
	}

	return $result;
}
/**
 * Show sub navbar
 *
 * @param [int]   $number number of subtabs.
 * @param [array] $tab_names list of tab names.
 * @return void
 */
function moul_mg_show_subnavbar( $number, $tab_names ) {
	?>
	<div class="moul_mg_subnav_tabs">
		<?php
		$count = 0;
		foreach ( $tab_names as $tab ) {
			?>
			<div class="moul_mg_subnav_tab <?php echo 0 === $count ? 'moul_mg_subnav_tab_active' : ''; ?>" id="moul_mg_subnav_tab_<?php echo esc_attr( mb_strtolower( str_replace( ' ', '_', $tab ) ) ); ?>" onclick="moul_mg_display_subnav_tab_content(this)"><?php echo esc_html( $tab ); ?></div>
			<?php
			$count++;
		}
		?>
	</div>
	<?php
}
/**
 * Display integration cards.
 *
 * @param [string] $card_data Card data.
 * @return void
 */
function moul_mg_display_integration_cards( $card_data ) {
	?>
	<div>
		<img src="<?php echo esc_url( MOUL_MG_LOGO_URL ); ?>" height="100px" alt="<?php echo esc_attr( $card_data['title'] ); ?>">
	</div>
	<div class="moul_mg_login_integration_ad_title"><?php echo esc_html( $card_data['title'] ); ?></div>
	<div class="moul_mg_login_integration_description_box"><?php echo esc_html( $card_data['desc'] ); ?></div>
	<div class="moul_mg_display_flex">
		<a href="<?php echo esc_url( $card_data['download_link'] ); ?>" target="_blank" rel="noopener noreferrer" class="moul_mg_more_info_button">Download</a>
		<a href="<?php echo esc_url( $card_data['page_link'] ); ?>" target="_blank" rel="noopener noreferrer" class="moul_mg_more_info_button">More Information</a>
	</div>
	<?php
}
