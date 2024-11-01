<?php
/**
 * Delete options upon uninstall.
 *
 * @package miniOrange UL_Management
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

delete_option( 'moul_mg_local_message' );
delete_option( 'moul_mg_default_redirect_after_login_url' );
delete_option( 'moul_mg_default_redirect_after_logout_url' );
delete_option( 'moul_mg_protect_content_by_login_enabled' );
delete_option( 'moul_mg_public_pages_enable' );
delete_option( 'moul_mg_public_pages_list' );
delete_option( 'moul_mg_password' );
delete_option( 'moul_mg_admin_customer_key' );

global $wpdb;
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->base_prefix}moul_mg_users_online" ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.SchemaChange, WordPress.DB.DirectDatabaseQuery.NoCaching, - Modifying a custom table.
wp_cache_delete( 'moul_mg_online_users_list' );
