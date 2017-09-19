 <?php 
// if ( !defined( 'ABSPATH' ) ) exit; // Prevent direct access.
// class ay_employees_public_class extends ay_employees_class {
	
// 	private static $instance;
// 	public $prefix = 'ay_';
	
// 	public static function forge () {
// 		if ( !isset ( self::$instance ) ) {
// 			$class_name = __CLASS__ ;
// 			self::$instance = new $class_name;
// 		}
// 		return self::$instance;
// 	}
	
// 	private function __construct() {
// // 		add_action( 'admin_enqueue_scripts', array( &$this, 'ay_emp_public_scripts' ) );
// 		add_action('init', array( &$this, 'get_departments' ), 10);
// 	}
	
// 	function get_departments () {
// 		add_shortcode( 'AY_DEPARTMENT_CAROUSEL', array( &$this, 'ay_departments_carousel' ) );	
// 	}
	
// 	function ay_departments_carousel () {
// 		$departments = get_terms( 'department' );
// // 		require 'content.php';
// 		return var_dump( $departments );
// 	}
// }

// // global $emp_class_obj; 
// // $emp_class_obj = ay_employees_public_class::forge();
// ay_employees_public_class::forge();