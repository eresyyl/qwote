<?php 
require_once("../../../../../wp-load.php");
//var_dump($_POST);

// registering user if Guest
if(!is_user_logged_in()) {
	$first_name = esc_attr(strip_tags($_POST['first_name']));
	$last_name = esc_attr(strip_tags($_POST['last_name']));
	$email = esc_attr(strip_tags($_POST['email']));
	$phone = esc_attr(strip_tags($_POST['phone']));
	$address = esc_attr(strip_tags($_POST['address']));
	$login = $first_name . "_" . $last_name . "_" . rand(111111,999999);
	
	// checking user email
	$mail_check = $email;
	$email_exists = email_exists($mail_check);
	if($email_exists) { 
		echo "<script>$('input[name=email]').addClass('error'); $('#goto_quotesave_step').html('Finish Quote'); $('.last_prev').show();</script>";
		echo "<div class='text-center'>User with such email is already exist!</div>";
		die;
	}
	
	$password = rand(111111,999999);
	
	// creating new user
	$userdata = array(
		'user_login'  =>  $login,
		'user_pass'   =>  $password,
		'user_email' => $email
	);
	$current_user_id = wp_insert_user( $userdata );
	
	wp_update_user( array( 
		'ID' => $current_user_id,
		'first_name' => $first_name,
		'last_name' => $last_name
	));
	
	update_user_meta($current_user_id, 'phone', $phone );
	update_user_meta($current_user_id, 'address', $address );
	update_user_meta($current_user_id, 'user_type', 'Client' );
	$account_created = true;
        $account_created_from_agent = false;
	
	// logging in new created user
	$creds = array();
	$creds['user_login'] = $login;
	$creds['user_password'] = $password;
	$creds['remember'] = true;
        $user_signon = wp_signon( $creds, false );
        
	// here will be emailing function to inform user about his creds
        
        $quote_author = $current_user_id;
	
}
elseif(is_agent() || is_headcontractor()) {
	$current_user_id = current_user_id();
	$account_created = false;
        $account_created_from_agent = true;
	
        $agent_id = $current_user_id;
        
        $agent_client_id = $_POST['agents_client'];
        if(!empty($agent_client_id) && $agent_client_id != 0 && $agent_client_id != '') {
                
                $quote_author = $agent_client_id;
                
        	$account_created = false;
                $account_created_from_agent = false;
                
        }
        else {
                
                // creating new Client if agent selected new client
                
        	$first_name = esc_attr(strip_tags($_POST['first_name']));
        	$last_name = esc_attr(strip_tags($_POST['last_name']));
        	$email = esc_attr(strip_tags($_POST['email']));
        	$phone = esc_attr(strip_tags($_POST['phone']));
        	$address = esc_attr(strip_tags($_POST['address']));
        	$login = $first_name . "_" . $last_name . "_" . rand(111111,999999);
	
        	// checking user email
        	$mail_check = $email;
        	$email_exists = email_exists($mail_check);
        	if($email_exists) { 
        		echo "<script>$('input[name=email]').addClass('error'); $('#goto_quotesave_step').html('Finish Quote'); $('.last_prev').show();</script>";
        		echo "<div class='text-center'>User with such email is already exist!</div>";
        		die;
        	}
	
        	$password = rand(111111,999999);
	
        	// creating new user
        	$userdata = array(
        		'user_login'  =>  $login,
        		'user_pass'   =>  $password,
        		'user_email' => $email
        	);
        	$current_user_id = wp_insert_user( $userdata );
	
        	wp_update_user( array( 
        		'ID' => $current_user_id,
        		'first_name' => $first_name,
        		'last_name' => $last_name
        	));
	
        	update_user_meta($current_user_id, 'phone', $phone );
        	update_user_meta($current_user_id, 'address', $address );
        	update_user_meta($current_user_id, 'user_type', 'Client' );
        	$account_created = false;
                $account_created_from_agent = true;
	
                if(is_agent()) {
                	// updating agent's contacts list
                        $agent_contacts = get_field('contacts','user_' . $agent_id);
                        $agent_contacts_temp = array();
                        foreach($agent_contacts as $ac) {
                                $agent_contacts_temp[] = $ac['ID'];
                        }
                        $agent_contacts_temp[] = $current_user_id;
                        update_field('field_56ffe302d624e', $agent_contacts_temp, 'user_' . $agent_id);
                        
                	// updating clients's contacts list
                        $new_client_contacts = array($agent_id);
                        update_field('field_56ffe302d624e', $new_client_contacts, 'user_' . $current_user_id);
                          
                }
                if(is_head()) {
                	// updating clients's contacts list
                        $new_client_contacts = array(current_user_id());
                        update_field('field_56ffe302d624e', $new_client_contacts, 'user_' . $current_user_id);
                }
        	
        
        	// here will be emailing function to inform user about his creds
        
                $quote_author = $current_user_id;
                
                
        }
        
        
}
else {
	$current_user_id = current_user_id();
	$account_created = false;
	// updating user's info depending on form in quote
	$first_name = esc_attr(strip_tags($_POST['first_name']));
	$last_name = esc_attr(strip_tags($_POST['last_name']));
	$phone = esc_attr(strip_tags($_POST['phone']));
	$address = esc_attr(strip_tags($_POST['address']));
	wp_update_user( array( 
		'ID' => $current_user_id,
		'first_name' => $first_name,
		'last_name' => $last_name
	));
	update_user_meta($current_user_id, 'phone', $phone );
	update_user_meta($current_user_id, 'address', $address );
        
        $quote_author = $current_user_id;
        
	$account_created = false;
        $account_created_from_agent = false;
}

// checking templates
$templates = $_POST['templates'];
$job_type = $_POST['job_type'];
$template_titles = '';
foreach ($templates as $t) {
	$template_titles = $template_titles . get_the_title($t) . ". ";
}
// getting user info
$current_user_data = get_userdata($current_user_id);
//creating Quote title
$title = "Quote from: " . $current_user_data->first_name . " " . $current_user_data->last_name . ". Templates: " . $template_titles;

// creating new quote in Quotes custom post type
$rand = rand(111111111,999999999);
$slug = "project_" . $rand;
$post_information = array(
	'post_title' => $title,
        'post_name' => $slug,
	'post_content' => '',
	'post_author' => $quote_author,
	'post_type' => 'project',
	'post_status' => 'publish'
);
$new_object_id = wp_insert_post( $post_information );

update_post_meta($new_object_id, 'quote_array', $_POST);
$quote_author = intval($quote_author);
update_field('field_567eb805b96b3', $quote_author, $new_object_id);
if(is_agent()) {
        update_field('field_56afffa9221d1', array($agent_id), $new_object_id);
}

update_post_meta($new_object_id, 'templates', $templates);
update_post_meta($new_object_id, 'job_type', $job_type);
update_post_meta($new_object_id, 'status', 'quote');


$total = go_calculate($_POST);

//update prices
update_post_meta($new_object_id, 'total', $total->total);
update_post_meta($new_object_id, 'paid', 0);
update_post_meta($new_object_id, 'topay', 0);

$quote_city = $_POST['city'];
update_post_meta($new_object_id, 'city', $quote_city);


// let's sent email to head about new quote
$head_contractor = get_field('head','options');
$subject = 'Your project is Underway!';
$title = 'New project started';
$text = '<p>New Quotation on renovar</p><p>Check your project out here: ' . get_bloginfo('url') . '/?p=' . $new_object_id . '</p>';
$m = go_email($subject,$title,$text,$head_contractor['ID']);

if(is_agent()) {
        $subject = 'Your project is Underway!';
        $title = 'New project started';
        $text = '<p>Congratulaions your are 1 step closer to a better home.</p><p>Check your project out here ' . get_bloginfo('url') . '/?p=' . $new_object_id . '</p>';
        $m = go_email($subject,$title,$text,$current_user_id);    
}

// let's sent email to new user
if($account_created == true || $account_created_from_agent == true) {
        
        if(is_agent()) {
                $who = 'Your Project Leader';
        }        
        elseif(is_headcontractor()) {
                $who = 'Renovar Projects';
        }
        $subject = 'New Renovar account info';
        $title = 'Your account was created!';
        $text = '<p>Here are all details:</p><p>Login: ' . $email . '<br />Password: ' . $password . '</p><p>You can login to your account now ' . get_bloginfo('url') . '/sign-in</p><p>' . $who . ' created new Quote for you. You need to check and approve it: ' . get_bloginfo('url') . '/?p=' . $new_object_id . '</p>';   
        $m = go_email($subject,$title,$text,$quote_author);
}


// making main Panel html layout
echo "<div class='panel'>";
echo "<div class='row'><div class='col-md-12 text-center padding-40'>";
echo "<div role='alert' class='alert dark alert-primary alert-dismissible'><h4>Great You're all set!</h4><p>You can follow the link below to view your project quote or click edit to play around with the options.</p>";
echo "<p class='margin-top-15'><a class='btn btn-primary btn-inverse btn-outline' href='" . get_bloginfo('url') . "/?p=" . $new_object_id . "'>View Live Quote</a><a class='btn btn-link white' href='" . get_bloginfo('url') . "/edit/?quote_id=" . $new_object_id . "'>Or Edit Quote</a></p></div>";
echo "<h1 class='text-center'>Total Estimate: $" . $total->total . "</h1>";
echo "<div class='row'><div class='col-md-12 text-center'>";
if($account_created == true) {
	echo "<p>Your account was automatically created! All information was sent to your email!</p>";
}
if($account_created_from_agent == true) {
	echo "<p>New account was created for your client! All information was sent to their email!</p>";
}
echo "</div></div>";

echo "<div class='row margin-vertical-40'><div class='col-md-12 text-center'>";
echo "<p>Here are some details of your quote:<br/> For more detail follow the project link to view the full scope.</p>";
$scope_array = get_field('quote_array',$new_object_id);
if(!is_array($scope_array)) {
        $scope_array = json_decode($scope_array,true);
}
foreach($templates as $t) : 
        $total_slug = get_field('total_slug',$t);
        $rooms_count = $scope_array[$total_slug . '_rooms'];

echo "<div class='template_show'><img src='" . get_field('template_image',$t) . "'><div class='text-center'><strong>" . get_the_title($t) . "</strong> <span class='label label-default'>x" . $rooms_count . "</span></div></div>";

endforeach;
echo "</div></div>";

echo "<div class='row'><div class='col-md-12 text-center'>";
echo "<div role='alert' class='alert dark alert-primary alert-dismissible'><h4>Great You're all set!</h4><p>You can follow the link below to view your project quote or click edit to play around with the options.</p>";
echo "<p class='margin-top-15'><a class='btn btn-primary btn-inverse btn-outline' href='" . get_bloginfo('url') . "/?p=" . $new_object_id . "'>View Live Quote</a><a class='btn btn-link white' href='" . get_bloginfo('url') . "/edit/?quote_id=" . $new_object_id . "'>Or Edit Quote</a></p></div>";
echo "</div></div>";
// closing main Panel html layout
echo "</div></div>";
echo "<script>$('.step_quote').remove();</script>";

?>