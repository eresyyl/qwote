<?php
/*
Template Name: Edit Project
*/

// redirecting to Login page if user is unregistered
if(!is_user_logged_in()) {
	wp_redirect( home_url() . "/sign-in" ); die;
}

$current_user_id = current_user_id();
$current_user_type = get_field('user_type','user_' . $current_user_id);

// redirecting if user is Contractor
if($current_user_type == 'Contractor') {
	wp_redirect( home_url() . "/all_projects" ); die;
}

// redirecting if Get var is not defined
if(!$_GET) {
	wp_redirect( home_url() . "/all_projects" ); die;
}

// getting Client ID from Project post
$quote_id = $_GET['quote_id'];
$client_id = get_field('client_id',$quote_id);
if($client_id[0] == NULL) {
	$client_id = $client_id['ID'];
}
else {
	$client_id = $client_id[0];
}
// redirecting if Current user is not a Client of this quote
if( ( $current_user_type == 'Client' ) &&  ( $client_id != $current_user_id) ) {
	wp_redirect( home_url() . "/all_projects" ); die;
}

// load Client's template if user is Client
if($current_user_type == 'Client' && ( $client_id == $current_user_id ) ) {
	get_template_part('edit-templates/main/edit','client');
	die;
}

// load Head Contractor's template if user is admin
if( current_user_can( 'manage_options' ) && $current_user_type == 'Head') {
	get_template_part('edit-templates/main/edit','head');
	die;
}


?>