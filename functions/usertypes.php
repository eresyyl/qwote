<?php
require_once(ABSPATH . "wp-load.php");

function is_client() {	
	$object = false;
        $current_user = wp_get_current_user(); 
        $user_type = get_field('user_type','user_' . $current_user->ID);
	if($user_type == 'Client') {
		$object = true;
	}
	return $object;
}

function is_contractor() {	
	$object = false;
        $current_user = wp_get_current_user(); 
        $user_type = get_field('user_type','user_' . $current_user->ID);
	if($user_type == 'Contractor') {
		$object = true;
	}
	return $object;
}

function is_headcontractor() {	
	$object = false;
        $current_user = wp_get_current_user(); 
        $user_type = get_field('user_type','user_' . $current_user->ID);
	if($user_type == 'Head' && current_user_can( 'manage_options' ) )  {
		$object = true;
	}
	return $object;
}

function is_agent() {	
	$object = false;
        $current_user = wp_get_current_user(); 
        $user_type = get_field('user_type','user_' . $current_user->ID);
	if($user_type == 'Agent') {
		$object = true;
	}
	return $object;
}

?>