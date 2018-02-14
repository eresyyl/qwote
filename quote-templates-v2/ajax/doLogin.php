<?php
require_once("../../../../../wp-load.php");
if( $_POST ) {
        $projectId = $_POST['projectId'];
	$login_email = $_POST['loginEmail'];
	$pwd = $_POST['loginPassword'];
        $remember = $_POST['remember'];
        if($remember == 'on') {
                $remember = true;
        }
        else {
                $remember = false;
        }
        
        if($login_email == '' || $pwd == '') {
                $message = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Login or Password can't be empty!</div>";
                echo json_encode( array("message" => $message, "status" => 'fail') );
                die; 
        }
	
        /*
	$creds = array();
	$creds['user_login'] = $login_email;
	$creds['user_password'] = $pwd;
	$creds['remember'] = $remember;
        $user = wp_signon( $creds, false );
        */
        
        $user = get_user_by( 'email', $login_email );
        if ( $user && wp_check_password( $pwd, $user->data->user_pass, $user->ID) ) {
                wp_set_current_user( $user->ID, $user->user_login );
                wp_set_auth_cookie( $user->ID );
                do_action( 'wp_login', $user->user_login );

                $message = "<div class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Successfully signed in!</div>";
                echo json_encode( array("message" => $message, "status" => 'success', "projectId" => $projectId) );
                die;
        }
        else {
                $message = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Wrong email or password!</div>";
                echo json_encode( array("message" => $message, "status" => 'fail') );
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