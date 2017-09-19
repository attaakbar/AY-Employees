<?php
/**
 * Plugin Name: AY Employees
 * Plugin URI: www.notavailableyet.com
 * Description: You can add employees and deparments and then assign an employee a department.
 * Version: 0.1
 * Author: Atta Ur Rehman Akbar
 * Author URI: https://notavailableyet.com
 * License: GPLv2 or later
 */

if ( !defined( 'ABSPATH' ) ) exit; // Prevent direct access.

/**
 * Predefined Constants
 */ 
define( 'AYEMPLOYEES_VERSION', '0.1' );
define( 'AYEMPLOYEES_MINIMUM_WP_VERSION', '3.7' );
define( 'AYEMPLOYEES_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'AYEMPLOYEES_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'AYEMPLOYEES_DELETE_LIMIT', 100000 );

//register_activation_hook( AYEMPLOYEES_PLUGIN_DIR, array( 'ay_employees_class', 'on_ay_employees_activation' ) );

/**
 * Require core login Class ay_employees_class
 */
require_once ("admin/ay-employees-class.php");

/**
 * Require core login Class ay_employees_class
 */
// require_once ("public/ay-employees-public-class.php");