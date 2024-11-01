<?php
/**
 * Plugin Name: User and Login Management
 * Plugin URI: https://miniorange.com/
 * Description: User and Login Management for WordPress
 * Version: 1.0.7
 * Requires PHP: 5.4.0
 * Author: miniOrange
 * Author URI: https://miniorange.com
 * License: MIT/Expat
 * License URI: https://plugins.miniorange.com/mit-license
 *
 * @package miniOrange UL_Management
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once 'class-moul-management.php';

use UL_Management\MoUL_Management;

define( 'MOUL_MG_PLUGIN_NAME', plugin_basename( __FILE__ ) );

$dir_name = substr( MOUL_MG_PLUGIN_NAME, 0, strpos( MOUL_MG_PLUGIN_NAME, '/' ) );

require_once 'moul-mg-autoload-plugin.php';

MoUL_Management::moul_mg_get_instance();
