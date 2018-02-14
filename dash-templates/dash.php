<?php
/*
Template Name: Dash
*/
if(is_client()) {
	get_template_part('dash-templates/main/dash','client');
	die;
}
elseif(is_contractor()) {
	get_template_part('dash-templates/main/dash','contractor');
	die;
}
elseif(is_agent()) {
	get_template_part('dash-templates/main/dash','agent');
	die;
}
elseif(is_headcontractor()) {
	get_template_part('dash-templates/main/dash','head');
	die;
}
else {
	wp_redirect( home_url() . '/sign-in' );
	die;
}
?>
