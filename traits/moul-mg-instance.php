<?php
/**
 * Trait.
 *
 * @package miniOrange UL_Management
 * @subpackage traits
 */

namespace UL_Management\Traits;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

trait MoUL_Mg_Instance {

	/**
	 * Instance variable.
	 *
	 * @var [object]
	 */
	private static $moul_mg_instance = null;
	/**
	 * Create an instance.
	 *
	 * @return [object]
	 */
	public static function moul_mg_get_instance() {
		if ( is_null( self::$moul_mg_instance ) ) {
			self::$moul_mg_instance = new self();
		}
		return self::$moul_mg_instance;
	}
}
