<?php
require_once("../../../../../../../wp-load.php");
if($_POST && $_POST['projectId']) {

    $currentUserId = current_user_id();
    $currentUserData = go_userdata($currentUserId);
    $projectId = $_POST['projectId'];
    $noteText = $_POST['noteText'];
    $noteRole = $_POST['noteRole'];
    $noteDate = date('d/m/Y H:i');

    $allNotes = get_field('notes',$projectId);
    $allNotesTemp = array();
    foreach($allNotes as $note) {
        $allNotesTemp[] = array('note_text' => $note['note_text'], 'note_date' => $note['note_date'], 'noteRole' => $note['noteRole'], 'note_user' => $note['note_user']['ID']);
    }
    $allNotesTemp[] = array('note_text' => $noteText, 'note_date' => $noteDate, 'noteRole' => $noteRole, 'note_user' => $currentUserId);

    update_field('field_56e8fe256db80',$allNotesTemp,$projectId);

    $message = '<div class="chat">
                        <div class="chat-avatar">
                                <a class="avatar">
                                        <img src="' . $currentUserData->avatar . '">
                                </a>
                        </div>
                        <div class="chat-body">
                                <div class="chat-content text-left">
                                        <div class="margin-bottom-5"><strong style="font-weight:normal;">' . $currentUserData->first_name . ' ' . $currentUserData->last_name . '</strong>, <small>' . $noteDate . '</small></div>
                                        <p>' . $noteText . '</p>

                                </div>
                        </div>
                </div>';
    echo json_encode( array("message" => $message, "status" => 'success') );
    die;

}
else {
        $message = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>";
        echo json_encode( array("message" => $message, "status" => 'fail') );
        die;
}
?>
