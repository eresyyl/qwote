<?php
/*
Template Name: Account
*/
?>
<?php
if(!is_user_logged_in()) {
        wp_redirect( home_url() . "/sign-in" ); die;
}
if(is_client()) {
	get_template_part('account-templates/main/account','client');
	die;
}
if(is_contractor()) {
	get_template_part('account-templates/main/account','contractor');
	die;
}
if(is_headcontractor() || is_agent()) {
	get_template_part('account-templates/main/account','head');
	die;
}
?>