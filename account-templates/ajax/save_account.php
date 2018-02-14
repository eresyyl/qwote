<?php
require_once("../../../../../wp-load.php");
// var_dump($_POST);
$current_user_id = current_user_id();
$current_user_data = go_userdata($current_user_id);
if($_POST) {
        $user_type = $_POST['user_type'];
        
        if($current_user_data->type == $user_type && $user_type == 'Client') {
                $first_name = $_POST['first_name'];
                $last_name = $_POST['last_name'];
                $address = $_POST['address'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];
                $avatar = $_POST['photo'];
                
                if($first_name == '') {
                        echo "<div class='margin-top-40'><div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>First name is required!</div></div>";
                        echo "<script>$('#save_account').html('Save');</script>";
                        die;
                }
                else {
                	wp_update_user( array( 
                		'ID' => $current_user_id,
                		'first_name' => $first_name
                	));   
                }
                
                if($last_name == '') {
                        echo "<div class='margin-top-40'><div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Last name is required!</div></div>";
                        echo "<script>$('#save_account').html('Save');</script>";
                        die;
                }
                else {
                	wp_update_user( array( 
                		'ID' => $current_user_id,
                		'last_name' => $last_name
                	));   
                }
                
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        echo "<div class='margin-top-40'><div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Email is not valid!</div></div>";
                        echo "<script>$('#save_account').html('Save');</script>";
                        die;
                }
                
                // checking if email is already exist in WP
        	$email_exists = email_exists($email);
        	if($email_exists && $current_user_data->email != $email) { 
                        echo "<div class='margin-top-40'><div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Email is not available!</div></div>";
                        echo "<script>$('#save_account').html('Save');</script>";
                        die;
        	}
                
        	wp_update_user( array( 
        		'ID' => $current_user_id,
        		'user_email' => $email
        	));
                
                if($phone == '') {
                        echo "<div class='margin-top-40'><div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Phone is required!</div></div>";
                        echo "<script>$('#save_account').html('Save');</script>";
                        die;
                }
                else {
                	update_user_meta($current_user_id, 'phone', $phone );  
                }
                
                if($address == '') {
                        echo "<div class='margin-top-40'><div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Address is required!</div></div>";
                        echo "<script>$('#save_account').html('Save');</script>";
                        die;
                }
                else {
                	update_user_meta($current_user_id, 'address', $address );
                }
                
                
                if($avatar) {
                        update_field('field_567814ccf045f',$avatar,'user_' . $current_user_id);
                }
                
                echo "<div class='margin-top-40'><div class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Account updated!</div></div>";
                echo "<script>$('#save_account').html('Save');</script>";
                die;
                
        }
        
        if($current_user_data->type == $user_type && $user_type == 'Contractor') {
                $first_name = $_POST['first_name'];
                $last_name = $_POST['last_name'];
                $address = $_POST['address'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];
                $avatar = $_POST['photo'];
                $trades = $_POST['trade'];
                $areas = $_POST['areas_serviced'];
                $facebook = $_POST['facebook_page'];
                $service = $_POST['service_seeking'];
                $hipages = $_POST['hi_pages'];
                $business_name = $_POST['business_name'];
                
                if($first_name == '') {
                        echo "<div class='margin-top-40'><div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>First name is required!</div></div>";
                        echo "<script>$('#save_account').html('Save');</script>";
                        die;
                }
                else {
                	wp_update_user( array( 
                		'ID' => $current_user_id,
                		'first_name' => $first_name
                	));   
                }
                
                if($last_name == '') {
                        echo "<div class='margin-top-40'><div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Last name is required!</div></div>";
                        echo "<script>$('#save_account').html('Save');</script>";
                        die;
                }
                else {
                	wp_update_user( array( 
                		'ID' => $current_user_id,
                		'last_name' => $last_name
                	));   
                }
                
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        echo "<div class='margin-top-40'><div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Email is not valid!</div></div>";
                        echo "<script>$('#save_account').html('Save');</script>";
                        die;
                }
                
                // checking if email is already exist in WP
        	$email_exists = email_exists($email);
        	if($email_exists && $current_user_data->email != $email) { 
                        echo "<div class='margin-top-40'><div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Email is not available!</div></div>";
                        echo "<script>$('#save_account').html('Save');</script>";
                        die;
        	}
                
        	wp_update_user( array( 
        		'ID' => $current_user_id,
        		'user_email' => $email
        	));
                
                if($phone == '') {
                        echo "<div class='margin-top-40'><div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Phone is required!</div></div>";
                        echo "<script>$('#save_account').html('Save');</script>";
                        die;
                }
                else {
                	update_user_meta($current_user_id, 'phone', $phone );  
                }
                
          
                if($address == '') {
                        echo "<div class='margin-top-40'><div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Address is required!</div></div>";
                        echo "<script>$('#save_account').html('Save');</script>";
                        die;
                }
                else {
                	update_user_meta($current_user_id, 'address', $address );
                }
          
               	update_user_meta($current_user_id, 'facebook_page', $facebook );
               	update_user_meta($current_user_id, 'business_name', $business_name );
               	update_user_meta($current_user_id, 'service_seeking', $service );
               	update_user_meta($current_user_id, 'hi_pages', $hipages );
               	update_user_meta($current_user_id, 'areas_serviced', $areas );
               	update_user_meta($current_user_id, 'trade', $trades );

                
          
                if($avatar) {
                        update_field('field_567814ccf045f',$avatar,'user_' . $current_user_id);
                }
                
                echo "<div class='margin-top-40'><div class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Account updated!</div></div>";
                echo "<script>$('#save_account').html('Save');</script>";
                die;
                
        }
         
        if( $user_type == 'Head' || $user_type == 'Agent' ) {
                $first_name = $_POST['first_name'];
                $last_name = $_POST['last_name'];
                $address = $_POST['address'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];
                $avatar = $_POST['photo'];
                $company = $_POST['company_name'];
                $title = $_POST['user_title'];
                $type = $_POST['leadertype'];
                $business_name = $_POST['business_name'];

                if($first_name == '') {
                        echo "<div class='margin-top-40'><div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>First name is required!</div></div>";
                        echo "<script>$('#save_account').html('Save');</script>";
                        die;
                }
                else {
                	wp_update_user( array( 
                		'ID' => $current_user_id,
                		'first_name' => $first_name
                	));   
                }
                
                if($last_name == '') {
                        echo "<div class='margin-top-40'><div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Last name is required!</div></div>";
                        echo "<script>$('#save_account').html('Save');</script>";
                        die;
                }
                else {
                	wp_update_user( array( 
                		'ID' => $current_user_id,
                		'last_name' => $last_name
                	));   
                }
                
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        echo "<div class='margin-top-40'><div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Email is not valid!</div></div>";
                        echo "<script>$('#save_account').html('Save');</script>";
                        die;
                }
                
                // checking if email is already exist in WP
        	$email_exists = email_exists($email);
        	if($email_exists && $current_user_data->email != $email) { 
                        echo "<div class='margin-top-40'><div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Email is not available!</div></div>";
                        echo "<script>$('#save_account').html('Save');</script>";
                        die;
        	}
                
        	wp_update_user( array( 
        		'ID' => $current_user_id,
        		'user_email' => $email
        	));
                
                if($phone == '') {
                        echo "<div class='margin-top-40'><div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Phone is required!</div></div>";
                        echo "<script>$('#save_account').html('Save');</script>";
                        die;
                }
                else {
                	update_user_meta($current_user_id, 'phone', $phone );  
                }
                
                if($address == '') {
                        echo "<div class='margin-top-40'><div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Address is required!</div></div>";
                        echo "<script>$('#save_account').html('Save');</script>";
                        die;
                }
                else {
                	update_user_meta($current_user_id, 'address', $address );
                }
                
                         	update_user_meta($current_user_id, 'business_name', $business_name );

                
                if($avatar) {
                        update_field('field_567814ccf045f',$avatar,'user_' . $current_user_id);
                }
                
                echo "<div class='margin-top-40'><div class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Account updated!</div></div>";
                echo "<script>$('#save_account').html('Save');</script>";
                die;
                
        }
}
?>
