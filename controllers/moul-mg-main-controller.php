<?php
/**
 * Main Controller.
 *
 * @package miniOrange UL_Management
 * @subpackage controllers
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$controller   = MOUL_MG_DIR . 'controllers/';
$current_page = ! empty( $_GET['page'] ) ? sanitize_text_field( wp_unslash( $_GET['page'] ) ) : ''; //phpcs:ignore WordPress.Security.NonceVerification.Recommended, - Reading GET parameter from the URL for checking the sub-tab name, doesn't require nonce verification.
$active_tab   = ! empty( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : ''; //phpcs:ignore WordPress.Security.NonceVerification.Recommended, - Reading GET parameter from the URL for checking the sub-tab name, doesn't require nonce verification.

$filtered_current_page_url = remove_query_arg( array( 'tab', 'role', 'action' ) );

$zones                   = $time_zone::$zones;
$pricing_container_class = ( strcasecmp( $current_page, 'moul-mg-pricing' ) === 0 ) ? ' moul_mg_pricing_container_body' : '';

?>

<div class="moul_mg_main_wrapper">
	<?php require_once MOUL_MG_VIEWS . 'moul-mg-header.php'; ?>
	<div class="moul_mg_body_container<?php echo esc_attr( $pricing_container_class ); ?>">
		<?php
		if ( strcasecmp( $current_page, 'mouserloginmanagement' ) === 0 ) {
			include_once $controller . 'moul-mg-navbar-controller.php';
			include_once $controller . 'moul-mg-pages-controller.php';
		} elseif ( strcasecmp( $current_page, 'moul-mg-pricing' ) === 0 ) {
			include_once $controller . 'moul-mg-pricing-controller.php';
		}
		?>
	</div>
</div>
