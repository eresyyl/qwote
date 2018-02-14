<?php 
/*
This is AJAX function to save_note
*/
require_once("../../../../../wp-load.php");
$current_user_id = current_user_id();
$current_user_data = go_userdata($current_user_id);
$who = $current_user_data->first_name . " " . $current_user_data->last_name;
$user_type = $_POST['user_type'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$email = $_POST['e_mail'];


// creating new user
$login = $first_name . "_" . $last_name . "_" . rand(111111,999999);
$password = rand(111111,999999);

$userdata = array(
	'user_login'  =>  $login,
	'user_pass'   =>  $password,
	'user_email' => $email
);
$user_id = wp_insert_user( $userdata );

wp_update_user( array( 
	'ID' => $user_id,
	'first_name' => $first_name,
	'last_name' => $last_name
));
update_user_meta($user_id, 'phone', $phone );
update_user_meta($user_id, 'address', $address );
if($user_type == 'client') {
        update_user_meta($user_id, 'user_type', 'Client' );
}      

if($user_type == 'contractor') {
        update_user_meta($user_id, 'user_type', 'Contractor' );
}      


// SENDING EMAIL with all creds data

$user_data = go_userdata($user_id);
$subject = 'Welcome to Paynt!';
$title = 'We have just created your contractor account<br />Here are all details:';
$text = '<div style="text-align:center; padding:25px 0;">
                <div style="display:inline-block; background:#f1f4f5; border-radius: 4px; padding:20px; text-align:center;">
                        <img src="' . $user_data->avatar . '" alt="">
                        <div style="font-size:16px; padding:20px 0 5px 0; ">' . $user_data->first_name . ' ' . $user_data->last_name . '</div>
                        <div style="font-size:14px; padding:5px 0; ">Login Email: ' . $user_data->email . '</div>
                        <div style="font-size:14px; padding:5px 0; ">Password: ' . $password . '</div>
                </div>
        </div>
        <div style="text-align:center; padding:10px 0;">
                <a href="' . get_bloginfo('url') . '/sign-in" style="background:#f96868; color:#fff; padding:12px 25px; text-decoration:none; font-size:16px; border-radius:10px; ">Sign In</a>
        </div>
				<p>Remember to complete your profiles with at least your business name, logo and license numbers. We will be in touch soon to get you ready for work orders. </p>';
go_email($subject,$title,$text,$user_id);

// updating current's contacts list: TO, WHO_TO_ADD
go_addcontact($current_user_id,$user_id);
// updating created user's contacts list: TO, WHO_TO_ADD
go_addcontact($user_id,$current_user_id);

die;
 
?>