<?php
require_once(ABSPATH . "wp-load.php");

// redirecting if User is not registered
function go_check_registered() {
	
	if(!is_user_logged_in()) {
		$object = wp_redirect( home_url() . "/sign-in" ); die;
	}
        else {
               $object = NULL; 
        }
	
	return $object;
}

?>