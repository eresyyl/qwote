<?php 
/*
This is AJAX function to save_note
*/
require_once("../../../../../wp-load.php");
$proposal = $_POST['proposal'];
$quote_id = $_POST['quote_id'];

update_field('field_56e50e40db352',$proposal,$quote_id);
echo json_encode( array("message" => "<div class='text-center green-600'>New Proposal saved!</div>") );
die;
?>