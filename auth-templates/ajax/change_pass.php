<?php
require_once("../../../../../wp-load.php");
if( $_POST ) {
	$user_id = $_POST['user_id'];
        $pin = $_POST['pin'];
        $correct_pin = 99999;
        $correct_pin = get_field('pin','user_' . $user_id);

        $new_password = $_POST['user_password'];
        
        if($correct_pin == $pin) {
                
                $change_pass = wp_update_user( array( 'ID' => $user_id, 'user_pass' => $new_password ) );
                if ( is_wp_error( $user_id ) ) {
                        $status = 'fail';
                        $message = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>";
                } else {
                        update_field('field_57275a496377d','','user_' . $user_id);
                        $status = 'success';
                        $message = '';
                }
        }
        else {
                $status = 'fail';
                $message = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>You are cheating! Try again.</div>";
        }
        
        echo json_encode( array("message" => $message, "status" => $status) );
	die;
							
}
else {
        $status = 'fail';
        $message = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>";
        echo json_encode( array("message" => $message, "status" => $status) );
        die;   
}
?>