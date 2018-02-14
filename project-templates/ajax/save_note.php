<?php 
/*
This is AJAX function to save_note
*/
require_once("../../../../../wp-load.php");
$note_date = date('d/m/Y H:i');
$user_id = current_user_id();
$note_user_info = go_userdata($user_id);
$note_text = $_POST['note'];
$quote_id = $_POST['quote_id'];

$new_notes = array();
$notes = get_field('notes',$quote_id);
if(is_array($notes)) {
        foreach($notes as $note) {
               $new_notes[] = array('note_text' => $note['note_text'], 'note_date' => $note['note_date'], 'note_user' => $note['note_user']); 
        }
}
$new_notes[] = array('note_text' => $note_text, 'note_date' => $note_date, 'note_user' => $user_id); 

$log = update_field('field_56e8fe256db80',$new_notes,$quote_id);

$text = "<div class='green-600'>Saved</div>";
$note = '<div class="chat">
                        <div class="chat-avatar">
                                <a class="avatar">
                                        <img src="' . $note_user_info->avatar . '">
                                </a>
                        </div>
                        <div class="chat-body">
                                <div class="chat-content text-left">
                                        <div class="margin-bottom-5"><strong style="font-weight:normal;">' . $note_user_info->first_name . ' ' . $note_user_info->last_name . '</strong>, <small>' . $note_date . '</small></div>
                                        <p>' . $note_text . '</p>

                                </div>
                        </div>
                </div>';

echo json_encode( array("message" => $text, "note" => $note, "log" => $log) );
die;
?>