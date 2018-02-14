<?php 
/*
This is AJAX function to save_note
*/
require_once("../../../../../wp-load.php");
$current_user_id = current_user_id();
$contact_id = $_POST['contact_id'];
$contact_id = intval($contact_id);

// updating current's contacts list: TO, WHO_TO_ADD
go_addcontact($current_user_id,$contact_id);

die; 
?>