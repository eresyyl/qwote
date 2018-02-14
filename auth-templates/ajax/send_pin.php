<?php
require_once("../../../../../wp-load.php");
if( $_POST ) {
	
        $user_email = $_POST['user_login'];
        $user = get_user_by('email',$user_email);
        if($user == false) {
                $status = 'notfound';
                $message = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>There is no user with such email!</div>";
        }
        else {
                $pin = rand(00000,99999);
                update_field('field_57275a496377d',$pin,'user_' . $user->ID);

                $subject = 'Password recovery PIN-code';
                $title = 'Here is your PIN-code to recover password:';
                $text = '<div style="text-align:center; padding:25px 0;">
                                <div style="display:inline-block; background:#f1f4f5; border-radius: 4px; padding:20px; text-align:center;">
                                        <div style="font-size:16px; padding:5px 0 5px 0; ">' . $pin . '</div>
                                </div>
                        </div>';
                go_email($subject,$title,$text,$user->ID);

                $status = 'success';
                $user_id = $user->ID;
                $message = '';
        }

        echo json_encode( array("message" => $message, "status" => $status, 'user_id' => $user_id) );
	die;
							
}
else {
        $status = 'fail';
        $message = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>";
        echo json_encode( array("message" => $message, "status" => $status) );
        die;   
}
?>