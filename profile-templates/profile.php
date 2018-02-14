<?php
/*
Template Name: profile
*/
?>
<?php
if(!is_user_logged_in()) {
        wp_redirect( home_url() . "/sign-in" ); die;
}
if(is_user_logged_in()) {
	get_template_part('profile-templates/main-profile');
	
}
?>