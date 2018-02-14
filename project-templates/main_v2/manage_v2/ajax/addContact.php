<?php
require_once("../../../../../../../wp-load.php");
if($_POST && $_POST['userId']) {

        $userId = $_POST['userId'];
        $currentUserId = current_user_id();
        go_addcontact($currentUserId,$userId);

        $message = '';
        echo json_encode( array("message" => $message, "status" => 'success','userId'=>$userId) );
        die;
}
else {
        $message = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>";
        echo json_encode( array("message" => $message, "status" => 'fail') );
        die;
}
?>
