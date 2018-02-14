<?php
session_start();
require_once("../../../../../../../wp-load.php");
if($_POST && $_SESSION['projectUploads']) {

    $date = date('d/m/Y H:i');
    $current_user_id = current_user_id();
    $user_data = go_userdata($current_user_id);
    $who = $user_data->first_name . " " . $user_data->last_name;

    $projectId = $_POST['projectId'];
    // getting $_SESSION files ids
    $uploadsIds = $_SESSION['projectUploads'];

    $messages = get_field('messages',$projectId);
    $messages_temp = array();
    foreach($messages as $m) {
         $messages_temp[] = array('message' => $m['message'], 'user_from' => $m['user_from'], 'date' => $m['date'],'attachment' => $m['attachment'], 'attachments' => $m['attachments']);
    }
    $messages_temp[] = array('message' => '', 'user_from' => $current_user_id, 'date' => $date,'attachment' => null, 'attachments' => $uploadsIds);
    $log = update_field('field_56962dd283ab7',$messages_temp,$projectId);

    $message = "<div class='alert alert-danger alert-dismissible margin-horizontal-15' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>" . $u . "</div>";
    echo json_encode( array("message" => $message, "status" => 'success', "log" => $log) );
    session_unset();
    die;

}
else {
        $message = "<div class='alert alert-danger alert-dismissible margin-horizontal-15' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>";
        echo json_encode( array("message" => $message, "status" => 'fail') );
        die;
}
?>
