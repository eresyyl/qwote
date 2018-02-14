<?php
require_once("../../../../../wp-load.php");
if( $_POST ) {
        $user_type = $_POST['user_type'];
        $first_name = $_POST['user_firstname'];
        $last_name = $_POST['user_lastname'];
	$email = $_POST['user_email'];
	$password = $_POST['user_password'];
	$password2 = $_POST['user_passwordc'];
        
        // creating unique user login for WP
	$rand = rand(111111,999999);
	$user_login = $first_name . "_" . $last_name . "_" . $rand;
        
        if($first_name == '' || $last_name == '' || $email == '' || $password == '' || $password2 = '') {
                echo "<div class='margin-top-40'><div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>All fields are required!</div></div>";
                echo "<script>$('#go-sign-up').html('Sign Up');</script>";
                die;
        }
        
        // checking if email is already exist in WP
	$email_exists = email_exists($email);
	if($email_exists) { 
                echo "<div class='margin-top-40'><div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Email is not available!</div></div>";
                echo "<script>$('#go-sign-up').html('Sign Up');</script>";
                die;
	}
	
        // checking if passwords are not the same	
	if($_POST['user_password'] != $_POST['user_passwordc'] ) {
                echo "<div class='margin-top-40'><div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Password and Password Confirm need to be equal!</div></div>";
                echo "<script>$('#go-sign-up').html('Sign Up');</script>";
                die;
	}
        
        // creating user in WP
	$userdata = array(
		'user_login'  =>  $user_login,
		'user_pass'   =>  $password,
		'user_email' => $email
	);
	$user_id = wp_insert_user( $userdata );
	
	wp_update_user( array( 
		'ID' => $user_id,
		'first_name' => $first_name,
		'last_name' => $last_name
	));
	
	update_user_meta($user_id, 'user_type', $user_type );
        
        
        // SENDING EMAIL with all creds data
        
        $user_data = go_userdata($user_id);
        $subject = 'Your Qwote account has been created!';
        $title = 'Your Qwote account has been created.<br />Here are all details:';
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
        go_email($subject,$title,$text,$user_id);
        
        
	
        // auto logging after user creating
	$creds = array();
	$creds['user_login'] = $email;
	$creds['user_password'] = $password;
	$creds['remember'] = true;
        $user = wp_signon( $creds, false );
        
	if ( is_wp_error($user) ) {
                echo "<div class='margin-top-40'><div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong, try again!</div></div>";
                echo "<script>$('#go-sign-up').html('Sign Up');</script>";
                die;
	}
	else {
                $logged_in = true;
	}
        
        // show Success message and reload page if it's all ok
        if($user_id) {
                echo "<div class='margin-top-40'><div class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>User successfully created! You will be redirected to your Account!</div></div>";
                echo "<script>$('#go-sign-up').remove(); setTimeout(function(){location.reload();},2000);</script>";
                die;
        }
        
	die;
							
}
else {
        echo "<div class='margin-top-40'><div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div></div>";
        echo "<script>$('#go-sign-up').html('Sign Up');</script>";
        die;   
}
?>