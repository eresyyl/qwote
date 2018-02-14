<?php
/*
Template Name: Projects List
*/
if(is_client()) {
	get_template_part('projects-templates/main/projects','client');
	die;
}
if(is_contractor()) {
	get_template_part('projects-templates/main/projects','contractor');
	die;
}
if(is_headcontractor()) {

	get_template_part('projects-templates/main/projects','head');
	die;
}
if(is_agent()) {
	get_template_part('projects-templates/main/projects','agent');
	die;
}
else {
	wp_redirect( home_url() ); die;
}
?>
