<?php
require_once("../../../../../wp-load.php");
if( $_POST ) {
	$user_id = $_POST['user_id'];
        $pin = $_POST['user_pincode'];
        $correct_pin = 99999;
        $correct_pin = get_field('pin','user_' . $user_id);
        
        if($correct_pin == $pin) {
                $status = 'success';
                $message = '';
        }
        else {
                $status = 'fail';
                $message = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Invalid PIN!</div>";
        }
        
        echo json_encode( array("message" => $message, "status" => $status, "pin" => $pin) );
	die;
							
}
else {
        $status = 'fail';
        $message = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>";
        echo json_encode( array("message" => $message, "status" => $status) );
        die;   
}
?>