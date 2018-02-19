<?php
/*
Template Name: Contacts List
*/
go_check_registered();

global $need_starrating;

$need_starrating = array(
	'styles' => true
);

if(is_client()) {
	get_template_part('contacts-templates/main/contacts','client');
	die;
}
if(is_contractor()) {
	get_template_part('contacts-templates/main/contacts','contractor');
	die;
}
if(is_headcontractor()) {
	get_template_part('contacts-templates/main/contacts','head');
	die;
}
if(is_agent()) {
	get_template_part('contacts-templates/main/contacts','agent');
	die;
}
?>