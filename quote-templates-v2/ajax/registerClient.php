<?php
require_once("../../../../../wp-load.php");
if( $_POST ) {
        $user_type = 'Client';
        $registerFirstName = $_POST['registerFirstName'];
        $registerLastName = $_POST['registerLastName'];
        $registerAddress = $_POST['registerAddress'];
        $registerPhone = $_POST['registerPhone'];
	$registerEmail = $_POST['registerEmail'];
	$registerPassword = rand(111111,999999);
        
        // creating unique user login for WP
	$rand = rand(111111,999999);
	$user_login = $registerFirstName . "_" . $registerLastName . "_" . $rand;
        
        // checking if email is already exist in WP
	$email_exists = email_exists($registerEmail);
	if($email_exists) { 
                $message = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Email is not available!</div>";
                echo json_encode( array("message" => $message, "status" => 'fail') );
                die; 
	}
	
        // creating user in WP
	$userdata = array(
		'user_login'  =>  $user_login,
		'user_pass'   =>  $registerPassword,
		'user_email' => $registerEmail
	);
	$user_id = wp_insert_user( $userdata );
	
	wp_update_user( array( 
		'ID' => $user_id,
		'first_name' => $registerFirstName,
		'last_name' => $registerLastName
	));
	
	update_user_meta($user_id, 'user_type', $user_type );
        
        update_user_meta($user_id, 'phone', $registerPhone );  
        update_user_meta($user_id, 'address', $registerAddress );  
        
        
        // SENDING EMAIL with all creds data
        
        $user_data = go_userdata($user_id);
        $subject = 'Your Paynt account created!';
        $title = 'Your Paynt account created.<br />Here are all details:';
        $text = '<div style="text-align:center; padding:25px 0;">
                        <div style="display:inline-block; background:#f1f4f5; border-radius: 4px; padding:20px; text-align:center;">
                                <img src="' . $user_data->avatar . '" alt="">
                                <div style="font-size:16px; padding:20px 0 5px 0; ">' . $user_data->first_name . ' ' . $user_data->last_name . '</div>
                                <div style="font-size:14px; padding:5px 0; ">Login: ' . $user_data->email . '</div>
                                <div style="font-size:14px; padding:5px 0; ">Password: ' . $registerPassword . '</div>
                        </div>
                </div>
                <div style="text-align:center; padding:10px 0;">
                        <a href="' . get_bloginfo('url') . '/sign-in" style="background:#f96868; color:#fff; padding:12px 25px; text-decoration:none; font-size:16px; border-radius:10px; ">Sign In</a>
                </div>';
        go_email($subject,$title,$text,$user_id);
        
        
        // show Success message
        if($user_id) {

                if(is_agent()) {
                        $current_user_id = current_user_id();
                        // updating current's contacts list: TO, WHO_TO_ADD
                        go_addcontact($current_user_id,$user_id);
                        // updating created user's contacts list: TO, WHO_TO_ADD
                        go_addcontact($user_id,$current_user_id);

                }

                $message = "<div class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Account successfully created!</div>";
                echo json_encode( array("message" => $message, "clientId" => $user_id, "clientName" => $registerFirstName . ' ' . $registerLastName, "status" => 'success') );
                die;
        }
        
	die;
							
}
else {
        $message = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>";
        echo json_encode( array("message" => $message, "status" => 'fail') );
        die;  
}
?>