<?php 
require_once("../../../../../wp-load.php");

// QUOTE PROCEED for unregistered user (new client)
if(!is_user_logged_in()) {
	$first_name = esc_attr(strip_tags($_POST['first_name']));
	$last_name = esc_attr(strip_tags($_POST['last_name']));
	$email = esc_attr(strip_tags($_POST['email']));
	$phone = esc_attr(strip_tags($_POST['phone']));
	$address = esc_attr(strip_tags($_POST['address']));

        $new_user_password = $_POST['new_user_password'];


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
		'user_pass'   =>  $new_user_password,
		'user_email' => $email
	);
	$current_user_id = wp_insert_user( $userdata );
        $current_user_id = intval($current_user_id);
	wp_update_user( array( 
		'ID' => $current_user_id,
		'first_name' => $first_name,
		'last_name' => $last_name
	));
	
	update_user_meta($current_user_id, 'phone', $phone );
	update_user_meta($current_user_id, 'address', $address );
	update_user_meta($current_user_id, 'user_type', 'Client' );
	
        $user_data = go_userdata($current_user_id);
        $subject = 'Your Renovar account created!';
        $title = 'Your Renovar account created.<br />Here are all the details:';
        $text = '<div style="text-align:center; padding:25px 0;">
                        <div style="display:inline-block; background:#f1f4f5; border-radius: 4px; padding:20px; text-align:center;">
                                <img src="' . $user_data->avatar . '" alt="">
                                <div style="font-size:16px; padding:20px 0 5px 0; ">' . $user_data->first_name . ' ' . $user_data->last_name . '</div>
                                <div style="font-size:14px; padding:5px 0; ">Login: ' . $user_data->email . '</div>
                                <div style="font-size:14px; padding:5px 0; ">Password: ' . $new_user_password . '</div>
                        </div>
                </div>
                <div style="text-align:center; padding:10px 0;">
                        <a href="' . get_bloginfo('url') . '/sign-in" style="background:#f96868; color:#fff; padding:12px 25px; text-decoration:none; font-size:16px; border-radius:10px; ">Sign In</a>
                </div>';
        go_email($subject,$title,$text,$current_user_id);
        
	// logging in new created user
	$creds = array();
	$creds['user_login'] = $login;
	$creds['user_password'] = $new_user_password;
	$creds['remember'] = true;
        $user_signon = wp_signon( $creds, false );
        
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
        	'post_author' => $current_user_id,
        	'post_type' => 'project',
        	'post_status' => 'publish'
        );
        $new_object_id = wp_insert_post( $post_information );

        update_post_meta($new_object_id, 'quote_array', $_POST);
        update_field('field_567eb805b96b3', $current_user_id, $new_object_id);
        
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

        
        // SEND EMAILs with all details about project
        $user_data = go_userdata($current_user_id);
        $scope_array = get_field('quote_array',$new_object_id);
        if(!is_array($scope_array)) {
                $scope_array = json_decode($scope_array,true);
        }
        $subject = 'New project started!';
        $title = 'Your new project started.<br />Here are all the details:';
        $text = '<div style="text-align:center; font-size:18px; font-weight:bold;">Total: $' . $total->total . '</div>';
        $text .= '<div style="text-align:center; padding:25px 0;">';
        foreach($templates as $t) : 
                $total_slug = get_field('total_slug',$t);
                $rooms_count = $scope_array[$total_slug . '_rooms'];
                $scope_details = go_scope_details($t,$new_object_id);
                $quote_fields = get_field('quote_fields',$t);
                $count = count($scope_details);
                
                $text .= '<div style="padding:0 0 20px 0;"><div style="display:block; background:#f1f4f5; border-radius: 4px; padding:20px; text-align:center;">
                                <img src="' . get_field('template_image',$t) . '" alt="" width="100px" height="100px">
                                <div style="font-size:18px; font-weight:bold; padding:20px 0 5px 0; ">' . get_the_title($t) . ' <span class="label label-default">x' . $rooms_count . '</span></div>';
                                
                                foreach($scope_details as $s) {
                                        $room = $s['room'];
                                        $details = $s['details'];
                                        if($count > 1) {
                                                $text .= '<div style="font-size:16px; padding:10px 0; font-weight:bold; ">' . $room . '</div>';
                                        }
                                        
                                        foreach($details as $d) {
                                                $section_title = $d['section_title'];
                                                $section_details = $d['section_values'];
                                                $section_type = $d['section_type'];
                        
                                                if($section_type == 'flds') {
                                                        $text .= '<div style="font-size:16px; padding:10px 0; font-weight:bold; ">' . $section_title . '</div>';
                                                        if(is_array($section_details)) {
                                                                $s_title = preg_replace("/[^a-zA-Z]/", "", $section_title);
                                                                $s_title = strtolower($s_title);
                                                                foreach($section_details as $v) {
                                                                        $title_flat = strpos($v, " x") ? substr($v, 0, strpos($v, " x")) : $v;
                                                                        if($v != null) {
                                                                                $v_link = preg_replace("/[^a-zA-Z]/", "", $title_flat);
                                                                                $v_link = strtolower($v_link);
                                                                                $text .= '<div style="padding:5px 0;">';
                                                                                $text .= $v;
                                                                
                                                                                // looking for description
                                                                                $count = count($quote_fields);
                                                                                $i=1;
                                                                                while($i <= $count) {
                                                                                        if($quote_fields[$i]['title'] == $section_title) {
                                                                                                foreach($quote_fields[$i]['fields'] as $field) {
                                                                                                        if($field['title'] == $title_flat) {
                                                                                                                if($field['description'] != '') {
                                                                                                                        $text .= '<em>' . $field['description'] . '</em>';
                                                                                                                }
                                                                                                                else {
                                                                                                                        $text .= '<em></em>';
                                                                                                                }
                                                                                                
                                                                                                        }
                                                                                                }
                                                                                        }
                                                                                        $i++;
                                                                                }
                                                                                
                                                                                $text .= '</div>';
                                                                
                                                                        }
                                                                        else {
                                                                                $text .= '';
                                                                        }
                                                        
                                                                }
                                                        }
                                                        else {
                                                                $text .= '<div style="padding:5px 0;">';
                                                                $text .= $section_details;
                                                                
                                                                // looking for description
                                                                $count = count($quote_fields);
                                                                $i=1;
                                                                while($i <= $count) {
                                                                        if($quote_fields[$i]['title'] == $section_title) {

                                                                                foreach($quote_fields[$i]['fields'] as $field) {
                                                                                        if($field['title'] == $section_details) {
                                                                                                if($field['description'] != '') {
                                                                                                        $text .= '<em>' . $field['description'] . '</em>';
                                                                                                }
                                                                                                else {
                                                                                                        $text .= '<em></em>';
                                                                                                }
                                                                                        }
                                                                                }
                                                                        }
                                                                        $i++;
                                                                }
                                                                
                                                                $text .= '</div>';
                                                        }
                                
                                                }
                        
                                        }
                                        
                                }
                                
                $text .= '</div></div>';
                
        endforeach;
                        
        $text .= '</div>
                <div style="text-align:center; padding:10px 0;">
                        <a href="' . get_bloginfo('url') . '/?p=' . $new_object_id . '" style="background:#f96868; color:#fff; padding:12px 25px; text-decoration:none; font-size:16px; border-radius:10px; ">Quote Details</a>
                </div>';
        // sending to user
        go_email($subject,$title,$text,$current_user_id);
        // sending to head
        $head_contractor = get_field('head','options');
        $title_head = 'New project started by ' . $first_name . ' ' . $last_name;
        $m = go_email($subject,$title_head,$text,$head_contractor['ID']);
        

        // making main Panel html layout
        echo "<div class='panel'>";
        echo "<div class='row'><div class='col-md-12 text-center padding-40'>";
        echo "<div role='alert' class='alert dark alert-primary alert-dismissible'><h4>Great You're all set!</h4><p>You can follow the link below to view your project quote or click edit to play around with the options.</p>";
        echo "<p class='margin-top-15'><a class='btn btn-primary btn-inverse btn-outline' href='" . get_bloginfo('url') . "/?p=" . $new_object_id . "'>View Live Quote</a><a class='btn btn-link white' href='" . get_bloginfo('url') . "/edit/?quote_id=" . $new_object_id . "'>Or Edit Quote</a></p></div>";
        echo "<h1 class='text-center'>Total Estimate: $" . $total->total . "</h1>";
        echo "<div class='row'><div class='col-md-12 text-center'>";
        
        echo "<p>Your account was automatically created! All information was sent to your email!</p>";
        
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
	
}
// QUOTE PROCEED for agent
elseif(is_agent()) {
	$agent_id = current_user_id();
        $agent_data = go_userdata($agent_id);
	
        $agent_client_id = $_POST['agents_client'];
        if(!empty($agent_client_id) && $agent_client_id != 0 && $agent_client_id != '') {
                
                // if agent select client from select input
                $client_id = $agent_client_id;
                
        	// updating client's contacts list
                $clients_contacts = get_field('contacts','user_' . $client_id);
                $clients_contacts_temp = array();
                foreach($clients_contacts as $cc) {
                        if($cc['ID'] != $agent_id) {
                                $clients_contacts_temp[] = $cc['ID'];
                        }
                }
                $clients_contacts_temp[] = $agent_id;
                update_field('field_56ffe302d624e', $clients_contacts_temp, 'user_' . $client_id);
                
                $new_client_created = false;
                
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
        	$client_id = wp_insert_user( $userdata );
	
        	wp_update_user( array( 
        		'ID' => $client_id,
        		'first_name' => $first_name,
        		'last_name' => $last_name
        	));
        	update_user_meta($client_id, 'phone', $phone );
        	update_user_meta($client_id, 'address', $address );
        	update_user_meta($client_id, 'user_type', 'Client' );
        	
                $user_data = go_userdata($client_id);
                $subject = 'Your Renovar account created!';
                $title = 'Your Renovar account created by ' . $agent_data->first_name . ' ' . $agent_data->last_name . '.<br />Here are all the details:';
                $text = '<div style="text-align:center; padding:25px 0;">
                                <div style="display:inline-block; background:#f1f4f5; border-radius: 4px; padding:20px; text-align:center;">
                                        <img src="' . $user_data->avatar . '" alt="">
                                        <div style="font-size:16px; padding:20px 0 5px 0; ">' . $user_data->first_name . ' ' . $user_data->last_name . '</div>
                                        <div style="font-size:14px; padding:5px 0; ">Login: ' . $user_data->email . '</div>
                                        <div style="font-size:14px; padding:5px 0; ">Password: ' . $password . '</div>
                                </div>
                        </div>
                        <div style="text-align:center; padding:10px 0;">
                                <a href="' . get_bloginfo('url') . '/sign-in" style="background:#f96868; color:#fff; padding:12px 25px; text-decoration:none; font-size:16px; border-radius:10px; ">Sign In</a>
                        </div>';
                go_email($subject,$title,$text,$client_id);
	
        	// updating agent's contacts list
                $agent_contacts = get_field('contacts','user_' . $agent_id);
                $agent_contacts_temp = array();
                foreach($agent_contacts as $ac) {
                        $agent_contacts_temp[] = $ac['ID'];
                }
                $agent_contacts_temp[] = $client_id;
                update_field('field_56ffe302d624e', $agent_contacts_temp, 'user_' . $agent_id);
                
        	// updating clients's contacts list
                $new_client_contacts = array($agent_id);
                update_field('field_56ffe302d624e', $new_client_contacts, 'user_' . $client_id);
                
                $new_client_created = true;
                
                
        }
        
        // checking templates
        $templates = $_POST['templates'];
        $job_type = $_POST['job_type'];
        $template_titles = '';
        foreach ($templates as $t) {
        	$template_titles = $template_titles . get_the_title($t) . ". ";
        }
        // getting user info
        $client_user_data = get_userdata($client_id);
        $agent_user_data = get_userdata($agent_id);
        //creating Quote title
        $title = "Quote from: " . $client_user_data->first_name . " " . $client_user_data->last_name . ". Templates: " . $template_titles;

        // creating new quote in Quotes custom post type
        $rand = rand(111111111,999999999);
        $slug = "project_" . $rand;
        $post_information = array(
        	'post_title' => $title,
                'post_name' => $slug,
        	'post_content' => '',
        	'post_author' => $client_id,
        	'post_type' => 'project',
        	'post_status' => 'publish'
        );
        $new_object_id = wp_insert_post( $post_information );

        update_post_meta($new_object_id, 'quote_array', $_POST);
        update_field('field_567eb805b96b3', $client_id, $new_object_id);
        update_field('field_56afffa9221d1', $agent_id, $new_object_id);
        
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

        // SEND EMAILs with all details about project
        $user_data = go_userdata($client_id);
        $scope_array = get_field('quote_array',$new_object_id);
        if(!is_array($scope_array)) {
                $scope_array = json_decode($scope_array,true);
        }
        $subject = 'New project started!';
        $title = 'Your new project started by Project Leader ' . $agent_user_data->first_name . ' ' . $agent_user_data->last_name . '.<br />Here are all the details:';
        $text = '<div style="text-align:center; font-size:18px; font-weight:bold;">Total: $' . $total->total . '</div>';
        $text .= '<div style="text-align:center; padding:25px 0;">';
        foreach($templates as $t) : 
                $total_slug = get_field('total_slug',$t);
                $rooms_count = $scope_array[$total_slug . '_rooms'];
                $scope_details = go_scope_details($t,$new_object_id);
                $quote_fields = get_field('quote_fields',$t);
                $count = count($scope_details);
                
                $text .= '<div style="padding:0 0 20px 0;"><div style="display:block; background:#f1f4f5; border-radius: 4px; padding:20px; text-align:center;">
                                <img src="' . get_field('template_image',$t) . '" alt="" width="100px" height="100px">
                                <div style="font-size:18px; font-weight:bold; padding:20px 0 5px 0; ">' . get_the_title($t) . ' <span class="label label-default">x' . $rooms_count . '</span></div>';
                                
                                foreach($scope_details as $s) {
                                        $room = $s['room'];
                                        $details = $s['details'];
                                        if($count > 1) {
                                                $text .= '<div style="font-size:16px; padding:10px 0; font-weight:bold; ">' . $room . '</div>';
                                        }
                                        
                                        foreach($details as $d) {
                                                $section_title = $d['section_title'];
                                                $section_details = $d['section_values'];
                                                $section_type = $d['section_type'];
                        
                                                if($section_type == 'flds') {
                                                        $text .= '<div style="font-size:16px; padding:10px 0; font-weight:bold; ">' . $section_title . '</div>';
                                                        if(is_array($section_details)) {
                                                                $s_title = preg_replace("/[^a-zA-Z]/", "", $section_title);
                                                                $s_title = strtolower($s_title);
                                                                foreach($section_details as $v) {
                                                                        $title_flat = strpos($v, " x") ? substr($v, 0, strpos($v, " x")) : $v;
                                                                        if($v != null) {
                                                                                $v_link = preg_replace("/[^a-zA-Z]/", "", $title_flat);
                                                                                $v_link = strtolower($v_link);
                                                                                $text .= '<div style="padding:5px 0;">';
                                                                                $text .= $v;
                                                                
                                                                                // looking for description
                                                                                $count = count($quote_fields);
                                                                                $i=1;
                                                                                while($i <= $count) {
                                                                                        if($quote_fields[$i]['title'] == $section_title) {
                                                                                                foreach($quote_fields[$i]['fields'] as $field) {
                                                                                                        if($field['title'] == $title_flat) {
                                                                                                                if($field['description'] != '') {
                                                                                                                        $text .= '<em>' . $field['description'] . '</em>';
                                                                                                                }
                                                                                                                else {
                                                                                                                        $text .= '<em></em>';
                                                                                                                }
                                                                                                
                                                                                                        }
                                                                                                }
                                                                                        }
                                                                                        $i++;
                                                                                }
                                                                                
                                                                                $text .= '</div>';
                                                                
                                                                        }
                                                                        else {
                                                                                $text .= '';
                                                                        }
                                                        
                                                                }
                                                        }
                                                        else {
                                                                $text .= '<div style="padding:5px 0;">';
                                                                $text .= $section_details;
                                                                
                                                                // looking for description
                                                                $count = count($quote_fields);
                                                                $i=1;
                                                                while($i <= $count) {
                                                                        if($quote_fields[$i]['title'] == $section_title) {

                                                                                foreach($quote_fields[$i]['fields'] as $field) {
                                                                                        if($field['title'] == $section_details) {
                                                                                                if($field['description'] != '') {
                                                                                                        $text .= '<em>' . $field['description'] . '</em>';
                                                                                                }
                                                                                                else {
                                                                                                        $text .= '<em></em>';
                                                                                                }
                                                                                        }
                                                                                }
                                                                        }
                                                                        $i++;
                                                                }
                                                                
                                                                $text .= '</div>';
                                                        }
                                
                                                }
                        
                                        }
                                        
                                }
                                
                $text .= '</div></div>';
                
        endforeach;
                        
        $text .= '</div>
                <div style="text-align:center; padding:10px 0;">
                        <a href="' . get_bloginfo('url') . '/?p=' . $new_object_id . '" style="background:#f96868; color:#fff; padding:12px 25px; text-decoration:none; font-size:16px; border-radius:10px; ">Quote Details</a>
                </div>';
        // sending to user
        go_email($subject,$title,$text,$client_id);
        // sending to agent
        $title_agent = 'New project started by you for ' . $client_user_data->first_name . ' ' . $client_user_data->last_name . '.<br />Here are all the details:';
        go_email($subject,$title_agent,$text,$agent_id);
        // sending to head
        $head_contractor = get_field('head','options');
        $title_head = 'New project started by Project Leader ' . $agent_user_data->first_name . ' ' . $agent_user_data->last_name . ' for ' . $client_user_data->first_name . ' ' . $client_user_data->last_name . '.<br />Here are all the details:';
        $m = go_email($subject,$title_head,$text,$head_contractor['ID']);

        // making main Panel html layout
        echo "<div class='panel'>";
        echo "<div class='row'><div class='col-md-12 text-center padding-40'>";
        echo "<div role='alert' class='alert dark alert-primary alert-dismissible'><h4>Great You're all set!</h4><p>You can follow the link below to view your project quote or click edit to play around with the options.</p>";
        echo "<p class='margin-top-15'><a class='btn btn-primary btn-inverse btn-outline' href='" . get_bloginfo('url') . "/?p=" . $new_object_id . "'>View Live Quote</a><a class='btn btn-link white' href='" . get_bloginfo('url') . "/edit/?quote_id=" . $new_object_id . "'>Or Edit Quote</a></p></div>";
        echo "<h1 class='text-center'>Total Estimate: $" . $total->total . "</h1>";
        
        if($new_client_created == true) {
                echo "<div class='row'><div class='col-md-12 text-center'>";
                echo "<p>Account for your client was automatically created! All information was sent to its email!</p>";
                echo "</div></div>";
        }

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
        
        
}
// QUOTE PROCEED for head
elseif(is_headcontractor()) {
	$head_id = current_user_id();
        $head_data = go_userdata($head_id);
	
        $head_client_id = $_POST['agents_client'];
        if(!empty($head_client_id) && $head_client_id != 0 && $head_client_id != '') {
                
                // if agent select client from select input
                $client_id = $head_client_id;
                
        	// updating client's contacts list
                $clients_contacts = get_field('contacts','user_' . $client_id);
                $clients_contacts_temp = array();
                foreach($clients_contacts as $cc) {
                        if($cc['ID'] != $head_id) {
                                $clients_contacts_temp[] = $cc['ID'];
                        }
                }
                $clients_contacts_temp[] = $head_id;
                update_field('field_56ffe302d624e', $clients_contacts_temp, 'user_' . $client_id);
                
                $new_client_created = false;
                
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
        	$client_id = wp_insert_user( $userdata );
	
        	wp_update_user( array( 
        		'ID' => $client_id,
        		'first_name' => $first_name,
        		'last_name' => $last_name
        	));
        	update_user_meta($client_id, 'phone', $phone );
        	update_user_meta($client_id, 'address', $address );
        	update_user_meta($client_id, 'user_type', 'Client' );
        	
                $user_data = go_userdata($client_id);
                $subject = 'Your Renovar account created!';
                $title = 'Your Renovar account created by ' . $head_data->first_name . ' ' . $head_data->last_name . '.<br />Here are all the details:';
                $text = '<div style="text-align:center; padding:25px 0;">
                                <div style="display:inline-block; background:#f1f4f5; border-radius: 4px; padding:20px; text-align:center;">
                                        <img src="' . $user_data->avatar . '" alt="">
                                        <div style="font-size:16px; padding:20px 0 5px 0; ">' . $user_data->first_name . ' ' . $user_data->last_name . '</div>
                                        <div style="font-size:14px; padding:5px 0; ">Login: ' . $user_data->email . '</div>
                                        <div style="font-size:14px; padding:5px 0; ">Password: ' . $password . '</div>
                                </div>
                        </div>
                        <div style="text-align:center; padding:10px 0;">
                                <a href="' . get_bloginfo('url') . '/sign-in" style="background:#f96868; color:#fff; padding:12px 25px; text-decoration:none; font-size:16px; border-radius:10px; ">Sign In</a>
                        </div>';
                go_email($subject,$title,$text,$client_id);
                
        	// updating clients's contacts list
                $new_client_contacts = array($head_id);
                update_field('field_56ffe302d624e', $new_client_contacts, 'user_' . $client_id);
                
                $new_client_created = true;
                
                
        }
        
        // checking templates
        $templates = $_POST['templates'];
        $job_type = $_POST['job_type'];
        $template_titles = '';
        foreach ($templates as $t) {
        	$template_titles = $template_titles . get_the_title($t) . ". ";
        }
        // getting user info
        $client_user_data = get_userdata($client_id);
        $head_user_data = get_userdata($head_id);
        //creating Quote title
        $title = "Quote from: " . $client_user_data->first_name . " " . $client_user_data->last_name . ". Templates: " . $template_titles;

        // creating new quote in Quotes custom post type
        $rand = rand(111111111,999999999);
        $slug = "project_" . $rand;
        $post_information = array(
        	'post_title' => $title,
                'post_name' => $slug,
        	'post_content' => '',
        	'post_author' => $client_id,
        	'post_type' => 'project',
        	'post_status' => 'publish'
        );
        $new_object_id = wp_insert_post( $post_information );

        update_post_meta($new_object_id, 'quote_array', $_POST);
        update_field('field_567eb805b96b3', $client_id, $new_object_id);
        
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

        
        // SEND EMAILs with all details about project
        $user_data = go_userdata($client_id);
        $scope_array = get_field('quote_array',$new_object_id);
        if(!is_array($scope_array)) {
                $scope_array = json_decode($scope_array,true);
        }
        $subject = 'New project started!';
        $title = 'Your new project started by ' . $head_user_data->first_name . ' ' . $head_user_data->last_name . '.<br />Here are all the details:';
        $text = '<div style="text-align:center; font-size:18px; font-weight:bold;">Total: $' . $total->total . '</div>';
        $text .= '<div style="text-align:center; padding:25px 0;">';
        foreach($templates as $t) : 
                $total_slug = get_field('total_slug',$t);
                $rooms_count = $scope_array[$total_slug . '_rooms'];
                $scope_details = go_scope_details($t,$new_object_id);
                $quote_fields = get_field('quote_fields',$t);
                $count = count($scope_details);
                
                $text .= '<div style="padding:0 0 20px 0;"><div style="display:block; background:#f1f4f5; border-radius: 4px; padding:20px; text-align:center;">
                                <img src="' . get_field('template_image',$t) . '" alt="" width="100px" height="100px">
                                <div style="font-size:18px; font-weight:bold; padding:20px 0 5px 0; ">' . get_the_title($t) . ' <span class="label label-default">x' . $rooms_count . '</span></div>';
                                
                                foreach($scope_details as $s) {
                                        $room = $s['room'];
                                        $details = $s['details'];
                                        if($count > 1) {
                                                $text .= '<div style="font-size:16px; padding:10px 0; font-weight:bold; ">' . $room . '</div>';
                                        }
                                        
                                        foreach($details as $d) {
                                                $section_title = $d['section_title'];
                                                $section_details = $d['section_values'];
                                                $section_type = $d['section_type'];
                        
                                                if($section_type == 'flds') {
                                                        $text .= '<div style="font-size:16px; padding:10px 0; font-weight:bold; ">' . $section_title . '</div>';
                                                        if(is_array($section_details)) {
                                                                $s_title = preg_replace("/[^a-zA-Z]/", "", $section_title);
                                                                $s_title = strtolower($s_title);
                                                                foreach($section_details as $v) {
                                                                        $title_flat = strpos($v, " x") ? substr($v, 0, strpos($v, " x")) : $v;
                                                                        if($v != null) {
                                                                                $v_link = preg_replace("/[^a-zA-Z]/", "", $title_flat);
                                                                                $v_link = strtolower($v_link);
                                                                                $text .= '<div style="padding:5px 0;">';
                                                                                $text .= $v;
                                                                
                                                                                // looking for description
                                                                                $count = count($quote_fields);
                                                                                $i=1;
                                                                                while($i <= $count) {
                                                                                        if($quote_fields[$i]['title'] == $section_title) {
                                                                                                foreach($quote_fields[$i]['fields'] as $field) {
                                                                                                        if($field['title'] == $title_flat) {
                                                                                                                if($field['description'] != '') {
                                                                                                                        $text .= '<em>' . $field['description'] . '</em>';
                                                                                                                }
                                                                                                                else {
                                                                                                                        $text .= '<em></em>';
                                                                                                                }
                                                                                                
                                                                                                        }
                                                                                                }
                                                                                        }
                                                                                        $i++;
                                                                                }
                                                                                
                                                                                $text .= '</div>';
                                                                
                                                                        }
                                                                        else {
                                                                                $text .= '';
                                                                        }
                                                        
                                                                }
                                                        }
                                                        else {
                                                                $text .= '<div style="padding:5px 0;">';
                                                                $text .= $section_details;
                                                                
                                                                // looking for description
                                                                $count = count($quote_fields);
                                                                $i=1;
                                                                while($i <= $count) {
                                                                        if($quote_fields[$i]['title'] == $section_title) {

                                                                                foreach($quote_fields[$i]['fields'] as $field) {
                                                                                        if($field['title'] == $section_details) {
                                                                                                if($field['description'] != '') {
                                                                                                        $text .= '<em>' . $field['description'] . '</em>';
                                                                                                }
                                                                                                else {
                                                                                                        $text .= '<em></em>';
                                                                                                }
                                                                                        }
                                                                                }
                                                                        }
                                                                        $i++;
                                                                }
                                                                
                                                                $text .= '</div>';
                                                        }
                                
                                                }
                        
                                        }
                                        
                                }
                                
                $text .= '</div></div>';
                
        endforeach;
                        
        $text .= '</div>
                <div style="text-align:center; padding:10px 0;">
                        <a href="' . get_bloginfo('url') . '/?p=' . $new_object_id . '" style="background:#f96868; color:#fff; padding:12px 25px; text-decoration:none; font-size:16px; border-radius:10px; ">Quote Details</a>
                </div>';
        // sending to user
        go_email($subject,$title,$text,$client_id);
        // sending to head
        $head_contractor = get_field('head','options');
        $title_head = 'New project started by you for ' . $client_user_data->first_name . ' ' . $client_user_data->last_name . '.<br />Here are all the details:';
        $m = go_email($subject,$title_head,$text,$head_contractor['ID']);
        
        

        // making main Panel html layout
        echo "<div class='panel'>";
        echo "<div class='row'><div class='col-md-12 text-center padding-40'>";
        echo "<div role='alert' class='alert dark alert-primary alert-dismissible'><h4>Great You're all set!</h4><p>You can follow the link below to view your project quote or click edit to play around with the options.</p>";
        echo "<p class='margin-top-15'><a class='btn btn-primary btn-inverse btn-outline' href='" . get_bloginfo('url') . "/?p=" . $new_object_id . "'>View Live Quote</a><a class='btn btn-link white' href='" . get_bloginfo('url') . "/edit/?quote_id=" . $new_object_id . "'>Or Edit Quote</a></p></div>";
        echo "<h1 class='text-center'>Total Estimate: $" . $total->total . "</h1>";
        
        if($new_client_created == true) {
                echo "<div class='row'><div class='col-md-12 text-center'>";
                echo "<p>Account for your client was automatically created! All information was sent to its email!</p>";
                echo "</div></div>";
        }

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
        
        
}
// QUOTE PROCEED for existing client
else {
	$current_user_id = current_user_id();
	
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
        	'post_author' => $current_user_id,
        	'post_type' => 'project',
        	'post_status' => 'publish'
        );
        $new_object_id = wp_insert_post( $post_information );

        update_post_meta($new_object_id, 'quote_array', $_POST);
        update_field('field_567eb805b96b3', $current_user_id, $new_object_id);
        
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

        
        // SEND EMAILs with all details about project
        $user_data = go_userdata($current_user_id);
        $scope_array = get_field('quote_array',$new_object_id);
        if(!is_array($scope_array)) {
                $scope_array = json_decode($scope_array,true);
        }
        $subject = 'New project started!';
        $title = 'Your new project started.<br />Here are all the details:';
        $text = '<div style="text-align:center; font-size:18px; font-weight:bold;">Total: $' . $total->total . '</div>';
        $text .= '<div style="text-align:center; padding:25px 0;">';
        foreach($templates as $t) : 
                $total_slug = get_field('total_slug',$t);
                $rooms_count = $scope_array[$total_slug . '_rooms'];
                $scope_details = go_scope_details($t,$new_object_id);
                $quote_fields = get_field('quote_fields',$t);
                $count = count($scope_details);
                
                $text .= '<div style="padding:0 0 20px 0;"><div style="display:block; background:#f1f4f5; border-radius: 4px; padding:20px; text-align:center;">
                                <img src="' . get_field('template_image',$t) . '" alt="" width="100px" height="100px">
                                <div style="font-size:18px; font-weight:bold; padding:20px 0 5px 0; ">' . get_the_title($t) . ' <span class="label label-default">x' . $rooms_count . '</span></div>';
                                
                                foreach($scope_details as $s) {
                                        $room = $s['room'];
                                        $details = $s['details'];
                                        if($count > 1) {
                                                $text .= '<div style="font-size:16px; padding:10px 0; font-weight:bold; ">' . $room . '</div>';
                                        }
                                        
                                        foreach($details as $d) {
                                                $section_title = $d['section_title'];
                                                $section_details = $d['section_values'];
                                                $section_type = $d['section_type'];
                        
                                                if($section_type == 'flds') {
                                                        $text .= '<div style="font-size:16px; padding:10px 0; font-weight:bold; ">' . $section_title . '</div>';
                                                        if(is_array($section_details)) {
                                                                $s_title = preg_replace("/[^a-zA-Z]/", "", $section_title);
                                                                $s_title = strtolower($s_title);
                                                                foreach($section_details as $v) {
                                                                        $title_flat = strpos($v, " x") ? substr($v, 0, strpos($v, " x")) : $v;
                                                                        if($v != null) {
                                                                                $v_link = preg_replace("/[^a-zA-Z]/", "", $title_flat);
                                                                                $v_link = strtolower($v_link);
                                                                                $text .= '<div style="padding:5px 0;">';
                                                                                $text .= $v;
                                                                
                                                                                // looking for description
                                                                                $count = count($quote_fields);
                                                                                $i=1;
                                                                                while($i <= $count) {
                                                                                        if($quote_fields[$i]['title'] == $section_title) {
                                                                                                foreach($quote_fields[$i]['fields'] as $field) {
                                                                                                        if($field['title'] == $title_flat) {
                                                                                                                if($field['description'] != '') {
                                                                                                                        $text .= '<em>' . $field['description'] . '</em>';
                                                                                                                }
                                                                                                                else {
                                                                                                                        $text .= '<em></em>';
                                                                                                                }
                                                                                                
                                                                                                        }
                                                                                                }
                                                                                        }
                                                                                        $i++;
                                                                                }
                                                                                
                                                                                $text .= '</div>';
                                                                
                                                                        }
                                                                        else {
                                                                                $text .= '';
                                                                        }
                                                        
                                                                }
                                                        }
                                                        else {
                                                                $text .= '<div style="padding:5px 0;">';
                                                                $text .= $section_details;
                                                                
                                                                // looking for description
                                                                $count = count($quote_fields);
                                                                $i=1;
                                                                while($i <= $count) {
                                                                        if($quote_fields[$i]['title'] == $section_title) {

                                                                                foreach($quote_fields[$i]['fields'] as $field) {
                                                                                        if($field['title'] == $section_details) {
                                                                                                if($field['description'] != '') {
                                                                                                        $text .= '<em>' . $field['description'] . '</em>';
                                                                                                }
                                                                                                else {
                                                                                                        $text .= '<em></em>';
                                                                                                }
                                                                                        }
                                                                                }
                                                                        }
                                                                        $i++;
                                                                }
                                                                
                                                                $text .= '</div>';
                                                        }
                                
                                                }
                        
                                        }
                                        
                                }
                                
                $text .= '</div></div>';
                
        endforeach;
                        
        $text .= '</div>
                <div style="text-align:center; padding:10px 0;">
                        <a href="' . get_bloginfo('url') . '/?p=' . $new_object_id . '" style="background:#f96868; color:#fff; padding:12px 25px; text-decoration:none; font-size:16px; border-radius:10px; ">Quote Details</a>
                </div>';
        // sending to user
        go_email($subject,$title,$text,$current_user_id);
        // sending to head
        $head_contractor = get_field('head','options');
        $title_head = 'New project started by ' . $first_name . ' ' . $last_name;
        $m = go_email($subject,$title_head,$text,$head_contractor['ID']);

        // making main Panel html layout
        echo "<div class='panel'>";
        echo "<div class='row'><div class='col-md-12 text-center padding-40'>";
        echo "<div role='alert' class='alert dark alert-primary alert-dismissible'><h4>Great You're all set!</h4><p>You can follow the link below to view your project quote or click edit to play around with the options.</p>";
        echo "<p class='margin-top-15'><a class='btn btn-primary btn-inverse btn-outline' href='" . get_bloginfo('url') . "/?p=" . $new_object_id . "'>View Live Quote</a><a class='btn btn-link white' href='" . get_bloginfo('url') . "/edit/?quote_id=" . $new_object_id . "'>Or Edit Quote</a></p></div>";
        echo "<h1 class='text-center'>Total Estimate: $" . $total->total . "</h1>";
        
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
        
}

?>