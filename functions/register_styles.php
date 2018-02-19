<?php
add_action('init', 'register_custom_styles');
function register_custom_styles() {
	//scripts for project review
	wp_register_style('fontawesome', 'http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css');
	wp_register_style('fontawesome-stars', get_template_directory_uri().'/assets/js/jquery-bar-rating/themes/fontawesome-stars.css');
}

//styles for project review
add_action('wp_enqueue_scripts', 'print_project_review_styles');
function print_project_review_styles(){
	global $need_starrating;
	
	if( !$need_starrating['styles'] ) return;
	
	wp_enqueue_style('fontawesome');
	wp_enqueue_style('fontawesome-stars');
}
?>
