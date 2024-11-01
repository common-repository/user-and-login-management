<?php
/**
 * Pricing page controller.
 *
 * @package miniOrange UL_Management
 * @subpackage controllers
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
wp_enqueue_style( 'moul_mg_license_page_style', MOUL_MG_CSS_FOLDER . 'moul-mg-license-page.min.css', array(), MOUL_MG_STYLE_VERSION );
wp_enqueue_style( 'moul_mg_grid_layout_license_page', MOUL_MG_CSS_FOLDER . 'moul-mg-licensing-grid.min.css', array(), MOUL_MG_STYLE_VERSION );

require_once MOUL_MG_VIEWS . 'moul-mg-pricing.php';
