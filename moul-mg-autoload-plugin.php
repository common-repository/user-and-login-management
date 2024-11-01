<?php
/**
 * Autoload all the plugin dependencies.
 *
 * @package miniOrange UL_Management
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'MOUL_MG_VERSION', '1.0.7' );
define( 'MOUL_MG_STYLE_VERSION', '1.0.7' );
define( 'MOUL_MG_SCRIPT_VERSION', '1.0.7' );
define( 'MOUL_MG_DIR', plugin_dir_path( __FILE__ ) );
define( 'MOUL_MG_URL', plugin_dir_url( __FILE__ ) );
define( 'MOUL_MG_MAIN_CSS', MOUL_MG_URL . 'includes/css/moul-mg-main-style.min.css' );
define( 'MOUL_MG_CSS_FOLDER', MOUL_MG_URL . 'includes/css/' );
define( 'MOUL_MG_MAIN_JS', MOUL_MG_URL . 'includes/js/moul-mg-main-script.min.js' );
define( 'MOUL_MG_IMAGES', MOUL_MG_URL . 'includes/images/' );
define( 'MOUL_MG_HELPER', MOUL_MG_DIR . 'helper/' );
define( 'MOUL_MG_VIEWS', MOUL_MG_DIR . 'views/' );
define( 'MOUL_MG_LOGO_URL', MOUL_MG_URL . 'includes/images/logo.webp' );
define( 'MOUL_MG_ICONS', MOUL_MG_URL . 'includes/images/icons/' );
define( 'MOUL_MG_GIF', MOUL_MG_URL . 'includes/images/gifs/' );
define( 'MOUL_MG_SUPPORT_EMAIL', 'ldapsupport@xecurify.com' );
define( 'MOUL_MG_HOST_NAME', 'https://login.xecurify.com' );
