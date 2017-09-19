<?php 
if ( !defined( 'ABSPATH' ) ) exit; // Prevent direct access.
class ay_employees_class {
	
	private static $instance;
	public $prefix = 'ay_';
	
	public static function forge () {
		if ( !isset ( self::$instance ) ) {
			$class_name = __CLASS__ ;
			self::$instance = new $class_name;
		}
		return self::$instance;
	}
	
	private function __construct() {
		
		add_action('admin_enqueue_scripts', array(&$this, 'ay_emp_admin_scripts'));
		
		if ( is_admin() ) {
		
			add_action('init', array( &$this, 'reg_employees_cpt' ), 5);
			
			add_action('init', array( &$this, 'reg_departments_ct' ), 5);
		
			// Remove original featured image meta box from Employees Posts
// 			add_action('do_meta_boxes', array( &$this, 'ay_emp_remove_fi_metabox' ), 1);
			
// 			// Add new Meta box
// 			add_action('add_meta_boxes', array( &$this, 'ay_emp_pi_metabox' ), 2);
		
			// Add extra fields in custom taxonomy Departments	
			add_action( 'init', array( &$this, 'add_ct_departments_extrafields'), 10 );
			
			// Add extra columns in Employees custom post type
			add_filter( 'manage_ay_employees_posts_columns', array( &$this, 'ay_emp_custom_columns' ) , 10, 1);
			add_action( 'manage_ay_employees_posts_custom_column', array( &$this, 'ay_emp_custom_columns_content' ), 10, 2);	
		}
	}
	
	public function ay_emp_admin_scripts () {
		//if(get_post_type() == "ay_employees") {
			wp_enqueue_media();
			wp_enqueue_script('ay-depr-js', AYEMPLOYEES_PLUGIN_DIR_URL . 'admin/res/js/script.js', array(), false, true);
			wp_enqueue_style('ay-depr-style', AYEMPLOYEES_PLUGIN_DIR_URL . 'admin/res/css/style.css');
		//}
	}
	
	/**
	 * Register Employees custom post type
	 */
	function reg_employees_cpt () {
		$singular	= 'Employee';
		$plural		= 'Employees';
		$labels = array (
				'name'							=> __ ( $plural ),
				'singular_name'					=> __ ( $singular ),
				'all_items'						=> __ ( 'All ' . $plural ),
				'edit_item'						=> __ ( 'Edit ' . $singular ),
				'view_item'						=> __ ( 'View ' . $singular ),
				'parent_item_colon'				=> __ ( 'Parent Item: ' . $singular),
				'add_new_item'					=> __ ( 'Add New ' . $singular ),
				'add_new'						=> __ ( 'Add New Employee' ),
				'new_item_name'					=> __ ( 'New ' . $singular . ' Name' ),
				'separate_items_with_commas'	=> NULL,
				'a dd_or_remove_items'			=> __ ( 'Remove ' . $plural ),
				'choose_from_most_used'			=> NULL,
				'no_terms'						=> __ ( 'No ' . $plural ),
				'items_list_navigation'			=> __ ( $plural . ' List Navigation' ),
				'items_list'					=> __ ( $plural . ' List' ),
				'menu_name'						=> __ ( $plural ),
				'not_found'						=> __ ( 'No ' . $plural . ' Found' ),
				'not_found_in_trash'			=> __ ( 'No ' . $plural . ' Found' ),
				'update_item'					=> __ ( 'Update ' . $singular ),
				'search_items'					=> __ ( 'Search ' . $plural ) 
		);
		// Setting args
		$args = array (
				'hierarchical'		=> false,
				'public'			=> true,
				'labels'			=> $labels,
				'show_ui'			=> true,
				'menu_position'     => 5,
				'menu_icon'         => 'dashicons-admin-users',
				'show_admin_column' => true,
				'supports'			=> array (
						'title',
						'editor',
						'thumbnail'
				),
				'description' => 'Add Employees custom post type' 
		);
		register_post_type( 'ay_employees', $args );	
	}
	
	function ay_emp_custom_columns ( $defaults ) {
		$defaults['ay_emp_depr']	= 'Department';
		$defaults['ay_emp_pi']		= 'Profile Pic';		
		return $defaults;
	}
	
	function ay_emp_custom_columns_content ( $column, $post_ID ) {
		
	
			if( $column == 'ay_emp_depr' ) {
				$terms = get_the_term_list($post_ID, 'department', '');
				if ( is_string( $terms ) ) {
					echo $terms;
				}
				else {
					echo _e("No Dpartment assigned yet");
				}
			}	
			if( $column == 'ay_emp_pi' ) {
				$emp_pi = call_user_func_array(array(&$this, 'ay_emp_get_pi'), array($post_ID));
// 				$emp_pi = add_action( 'ay_emp_pi_custom_hook' , 'ay_emp_get_pi', $post_ID );
				if ( $emp_pi ) {
					echo '<img src="'.$emp_pi.'" width="55" height="55"/>';
				}
				else {
					// NO FEATURED IMAGE, SHOW THE DEFAULT ONE
					echo _e('No image', 'text-domain');
				}
			}
	}
	
	// GET Employee Profile Image
	function ay_emp_get_pi ( $post_ID ) {
		$post_thumbnail_id = get_post_thumbnail_id( $post_ID );
		if ( $post_thumbnail_id ) {
			$post_thumbnail_img = wp_get_attachment_image_src($post_thumbnail_id );
			return $post_thumbnail_img[0];
		}
	}
	
// 	/**
// 	 * Remove Featured Image metabox from Employees posts
// 	 */
// 	public function ay_emp_remove_fi_metabox () {
// 		remove_meta_box('postimagediv', 'ay_employees', 'side');
// 	}
	
// 	/**
// 	 * Add new metaboxes Profile Image in Employees Pssosts
// 	 */
// 	public function ay_emp_pi_metabox () {
// 		add_meta_box(
// 				'ay-emp-pi-metabox',
// 				__('Profile Image'),
// 				 array( &$this, 'render_ay_emp_pi_metabox' ),
// 				'ay_employees',
// 				'side',
// 				'low'
// 				);
// 	}
	
// 	public function render_ay_emp_pi_metabox () {
// 		//wp_nonce_field( 'custom_nonce_action', 'custom_nonce' );
		
// 	}
	
	/**
	 * Register Departments custom taxonomy
	 */
	function reg_departments_ct() {
		// Setting all labels
		$singular = 'Department';
		$plural = 'Departments';
		$labels = array (
				'name' => __ ( $plural ),
				'singular_name' => __ ( $singular ),
				'all_items' => __ ( 'All ' . $plural ),
				'parent_item' => __ ( 'Parent ' . $singular ),
				'parent_item_colon' => __ ( 'Parent ' . $singular . ':' ),
				'edit_item' => __ ( 'Edit ' . $singular ),
				'view_item' => __ ( 'View ' . $singular ),
				'add_new_item' => __ ( 'Add New ' . $singular ),
				'new_item_name' => __ ( 'New ' . $singular . ' Name' ),
				'separate_items_with_commas' => NULL,
				'add_or_remove_items' => __ ( 'Remove ' . $plural ),
				'choose_from_most_used' => NULL,
				'no_terms' => __ ( 'No ' . $plural ),
				'items_list_navigation' => __ ( $plural . ' List Navigation' ),
				'items_list' => __ ( $plural . ' List' ),
				'menu_name' => __ ( $plural ),
				'not_found' => __ ( 'No ' . $plural . ' Found' ),
				'update_item' => __ ( 'Update ' . $singular ),	
				'search_items' => __ ( 'Search ' . $plural )
		);
		
		// Setting args
		$args = array (
				'hierarchical' => false,
				'public' => true,
				'labels' => $labels,
				'show_ui' => true,
				'query_var' => true,
				'supports' => array (
						'title',
						'editor',
						'thumbnail'
				),
				'description' => 'Add custom taxonomy'
		);
		
		register_taxonomy ( 'department', 'ay_employees', $args );	
	}
	
	/**
	 * Add Extra fields in custom taxonomy Departments
	 */
	function add_ct_departments_extrafields () {
			
		require_once 'Tax-meta-class/Tax-meta-class.php';
		
		$config = array (
				'id'		=> 'ay-emp-depr-metabox',		// meta box id, unique per meta box
				'title'		=> 'Employee Departments Metabox',		// meta box title
				'pages'		=> array('department'),		// taxonomy name, accept categories, post_tag and custom taxonomies
				'context'	=> 'normal',                           // where the meta box appear: normal (default), advanced, side; optional
				'fields'	=> array(),                             // list of meta fields (can be added by field arrays)
				'local_images'		=> true,                         // Use local or hosted images (meta box images for add/remove)
				'use_with_theme'	=> false                        //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
		);
		
		$my_meta =	new Tax_Meta_Class($config);
		
		$my_meta->addImage( $this->prefix . 'emp_depr_thumbnail',
							array(
									'name'	=> 'Departments Thumbnail',
								)
						);
	
		$my_meta->Finish();
	}
}

global $emp_class_obj; 
$emp_class_obj = ay_employees_class::forge();