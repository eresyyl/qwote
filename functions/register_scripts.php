<?php
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

?>
