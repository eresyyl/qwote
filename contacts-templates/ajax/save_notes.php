<?php 
/*
This is AJAX function to save_note
*/
require_once("../../../../../wp-load.php");
$current_user_id = current_user_id();
$current_user_data = go_userdata($current_user_id);
$notes = $_POST['notes'];
$contact_id = $_POST['contact_id'];

$new_notes = array();
$current_notes = get_field('notes','user_' . $contact_id);
if(is_array($current_notes)) {
        foreach($current_notes as $current_note) {
              $new_notes[] = array('note'=>$current_note['note'],'author_id'=>$current_note['author_id']);  
        }
}
$new_notes[] = array('note'=>$notes,'author_id'=>$current_user_id);  

update_field('field_5701913bb18e9',$new_notes,'user_' . $contact_id);
echo json_encode( array("message" => "<div class='text-center green-600'>Notes saved!</div>", "ava" => $current_user_data->avatar, "username" => $current_user_data->first_name . " " . $current_user_data->last_name, "usertype" => $current_user_data->type, "note" => $notes) );
die;
?>