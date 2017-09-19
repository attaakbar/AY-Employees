(function ($) {
	
	 /**
	  * Change Employees's post Featured Image meta box title
	  */
	
//	$('body.post-type-ay_employees #poststuff #postimagediv h2.hndle').html('Profile Pic');
//	$('body.post-type-ay_employees #poststuff #postimagediv #remove-post-thumbnail').html('Remove Profile Image');
//	
//	
//	/**
//	 * A little function to check if and element exest within other element
//	 * 
//	 * Thanks to author
//	 * Auther Link : https://stackoverflow.com/users/900807/spyk3hh
//	 */
//	if (!$.exist) {
//		$.extend({
//			exist: function(elm) {
//				if (typeof elm == null || elm == undefined) return false;
//				
//				if (typeof elm == "object" && elm instanceof jQuery && elm.length) {
//					if ($.contains(document.documentElement, elm[0])) return true;
//				}
//				else if (typeof elm == "string") {
//					if ($(elm).length) return true; 
//				}
//				
//				return false;
//			}
//		});
//		$.fn.extend({ exist: function() { return $.exist($(this)); } });
//	}
//	
//	/**
//	 * Check if Employee profile image is set
//	 * 
//	 * Logically it works very simple. It check if an image tag exists within the below path.
//	 * 
//	 * @return
//	 * true if specific element exists, false otherwise 
//	 */
//	var ayEmpPi = $('body.post-type-ay_employees #poststuff #postimagediv a#set-post-thumbnail img').exist();
//	
//	if ( ayEmpPi == false ) {
//		$('body.post-type-ay_employees #poststuff #postimagediv a#set-post-thumbnail').html( "Set Profile Pic" );
//	} 
	
}) (jQuery, document, window); 
	  