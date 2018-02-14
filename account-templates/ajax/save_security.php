<?php
require_once("../../../../../wp-load.php");
//var_dump($_POST);
$current_user_id = current_user_id();
if($_POST) {
        $user_type = $_POST['user_type'];
        $password = $_POST['password'];
        $passwordc = $_POST['passwordc'];
        
        if($password == '' || $passwordc == '') {
                echo "<div class='margin-top-40'><div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Password and Password Confirm are required!</div></div>";
                echo "<script>$('#save_security').html('Save');</script>";
                die;  
        }
        
        if($password != $passwordc) {
                echo "<div class='margin-top-40'><div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Password and Password Confirm need to be equal!</div></div>";
                echo "<script>$('#save_security').html('Save');</script>";
                die;
        }
        else{
        	wp_update_user( array( 
        		'ID' => $current_user_id,
        		'user_pass' => $password
        	));
                echo "<div class='margin-top-40'><div class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Password successfully changed!</div></div>";
                echo "<script>$('#save_security').html('Save');</script>";
                die;
        }
        
}

?>
