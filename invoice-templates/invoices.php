<?php
/*
Template Name: Invoices List
*/
go_check_registered();
if(is_client()) {
	get_template_part('invoice-templates/main/invoices','client');
	die;
}
if(is_agent()) {
	get_template_part('invoice-templates/main/invoices','agent');
	die;
}
if(is_headcontractor()) {
	get_template_part('invoice-templates/main/invoices','head');
	die;
}
else {
        wp_redirect(home_url() . "/all_projects");
        die;
}
?>