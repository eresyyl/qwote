<?php
add_action('init', 'register_custom_scripts');
function register_custom_scripts() {
	//scripts for project review
	wp_register_script('jquery.barrating', get_template_directory_uri().'/assets/js/jquery-bar-rating/jquery.barrating.min.js', array('jquery'), NULL, true);
	wp_register_script('starrating', get_template_directory_uri().'/project-templates/js/starrating.js', array('jquery'), NULL, true);
}

//scripts for single-template.php
add_action('init', 'register_frontend_quote_template_editor_script');
add_action('wp_footer', 'print_frontend_quote_template_editor_script', 10);

function register_frontend_quote_template_editor_script() {
	wp_register_script('single-template', get_template_directory_uri().'/assets/js/wp_templates/single-template.min.js', array('jquery'), NULL, true);
}

function print_frontend_quote_template_editor_script() {
	global $is_single_template;

	if ( ! $is_single_template ) return;
	wp_print_scripts('single-template');
}

//scripts for project review
add_action('wp_footer', 'print_project_review_script');
function print_project_review_script(){
	global $need_starrating;
	
	if( !$need_starrating['scripts'] ) return;
	
	wp_print_scripts('jquery.barrating');
	wp_print_scripts('starrating');
}
?>
