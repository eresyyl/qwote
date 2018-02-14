<?php 
require_once( trailingslashit( get_template_directory() ). 'functions/global.php' );
require_once( trailingslashit( get_template_directory() ). 'functions/invoice.php' );
require_once( trailingslashit( get_template_directory() ). 'functions/redirects.php' );
require_once( trailingslashit( get_template_directory() ). 'functions/usertypes.php' );
require_once( trailingslashit( get_template_directory() ). 'functions/scope_details.php' );

require_once( trailingslashit( get_template_directory() ). 'functions/emailing.php' );
require_once( trailingslashit( get_template_directory() ). 'functions/calculations.php' );
require_once( trailingslashit( get_template_directory() ). 'functions/contacts.php' );

add_filter( 'show_admin_bar', '__return_false' );

add_theme_support( 'post-thumbnails' );
add_image_size( 'ava', 110, 110, true );
add_image_size( 'selection', 100, 105, true );

register_nav_menus(
array(
'top_menu'=>__('Top Menu')
)
);

function custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

// ADD OBJECTS POST TYPE AND TAXONOMY

add_action('init', 'head_templates');
function head_templates(){

  $labels = array(
    'name' => __('Quote Templates','go'),
    'singular_name' => __('Quote Template','go')
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'has_archive' => true, 
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array('title','editor','author')
  ); 
  register_post_type('template',$args);
}

add_action('init', 'client_quotes');
function client_quotes(){

  $labels = array(
    'name' => __('Projects','go'),
    'singular_name' => __('Project','go')
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'has_archive' => true, 
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array('title','editor','author')
  ); 
  register_post_type('project',$args);
}

add_action('init', 'invoices_objects');
function invoices_objects(){

  $labels = array(
    'name' => __('Invoices','go'),
    'singular_name' => __('Invoice','go')
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
	'show_in_menu' => 'edit.php?post_type=project', 
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'has_archive' => true, 
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array('title','editor','author')
  ); 
  register_post_type('invoice',$args);
  
}

add_action('init', 'selections_objects');
function selections_objects(){

  $labels = array(
    'name' => __('Selections','go'),
    'singular_name' => __('Selection','go')
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
	'show_in_menu' => 'edit.php?post_type=project', 
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'has_archive' => true, 
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array('title','editor','author')
  ); 
  register_post_type('selection',$args);
  
  $labels = array(
  'name' => 'Brands',
  'singular_name' => 'Brand',
  'menu_name' => 'Brands',
  );
  register_taxonomy('brand', array('selection'), array(
  'hierarchical' => true,
  'show_ui' => true,
  'labels' => $labels,
  'query_var' => true,
  'rewrite' => array( 'slug' => 'brand' ),
   ));
  
}

add_action('init', 'payment_templates_objects');
function payment_templates_objects(){

  $labels = array(
    'name' => __('Payment templates','go'),
    'singular_name' => __('Payment template','go')
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
	'show_in_menu' => 'edit.php?post_type=project', 
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'has_archive' => true, 
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array('title','editor','author')
  ); 
  register_post_type('payment_template',$args);
  
}

if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> __('Global Settings','kiddi'),
		'menu_title'	=> __('Global Settings','kiddi'),
		'menu_slug'	=> 'global_kiddi.php',
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> __('Invoice Settings','kiddi'),
		'menu_title'	=> __('Invoice Settings','kiddi'),
		'parent_slug'	=> 'global_kiddi.php',
	));
        
	acf_add_options_sub_page(array(
		'page_title' 	=> __('Emailing Settings','kiddi'),
		'menu_title'	=> __('Emailing Settings','kiddi'),
		'parent_slug'	=> 'global_kiddi.php',
	));
        
	acf_add_options_sub_page(array(
		'page_title' 	=> __('Default Proposal','kiddi'),
		'menu_title'	=> __('Default Proposal','kiddi'),
		'parent_slug'	=> 'global_kiddi.php',
	));
	acf_add_options_sub_page(array(
		'page_title' 	=> __('Strings','kiddi'),
		'menu_title'	=> __('Strings','kiddi'),
		'parent_slug'	=> 'global_kiddi.php',
	));
	
}


//attach our function to the wp_pagenavi filter
add_filter( 'wp_pagenavi', 'ik_pagination', 10, 2 );
  
//customize the PageNavi HTML before it is output
function ik_pagination($html) {
    $out = '';
    //wrap a's and span's in li's
    $out = str_replace("<div","",$html);
    $out = str_replace("class='wp-pagenavi'>","",$out);
    $out = str_replace("<a","<li><a",$out);
	$out = str_replace("class='page'>","class='pager'",$out);
    $out = str_replace("</a>","</a></li>",$out);
    $out = str_replace("<span","<li class='active'><a",$out);  
    $out = str_replace("</span>","</a></li>",$out);
    $out = str_replace("</div>","",$out);
  
    return '<ul class="pagination pagination-gap">'.$out.'</ul>';
}


// getting current user ID
function current_user_id() {
    $current_user = wp_get_current_user(); 
    if ( !($current_user instanceof WP_User) ) 
        return; 
    return $current_user->ID; 
}

// checking Personal Data existing of user
function user_personal_data($user_id) {
  $userdata = get_userdata( $user_id );
	$user_firstname = $userdata->first_name;
	$user_lastname = $userdata->last_name;
	$user_email = $userdata->user_email;
	$user_phone = get_field('phone','user_' . $user_id);
	$user_address = get_field('address','user_' . $user_id);
	
	if( $user_firstname != '' && $user_lastname != '' && $user_email != '' && $user_phone != '' && $user_address != '' ) {
		return $user_personal_data = true;
	}
	else {
		return $user_personal_data = false;
	}	
}

// checking Company Data existing of user
function user_company_data($user_id) {
  
  $company_name = get_field('company_name','user_' . $user_id);
	$company_phone = get_field('company_phone','user_' . $user_id);
	$company_address = get_field('company_address','user_' . $user_id);
	$company_email = get_field('company_email','user_' . $user_id);
	
	if( $company_name != '' && $company_phone != '' && $company_address != '' && $company_email != '') {
		return $user_company_data = true;
	}
	else {
		return $user_company_data = false;
	}	
}

// checking Company Invoice Settings existing of user
function user_invoice_data($user_id) {
  
  $invoice_terms = get_field('company_terms','user_' . $user_id);
	$invoice_due = get_field('company_due','user_' . $user_id);
	$invoice_acc = get_field('company_account','user_' . $user_id);
	
	
	if( $invoice_terms != '' && $invoice_due != '' && $invoice_acc != '') {
		return $user_invoice_data = true;
	}
	else {
		return $user_invoice_data = false;
	}	
}

?>