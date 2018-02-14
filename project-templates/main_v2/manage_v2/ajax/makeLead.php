<?php
require_once("../../../../../../../wp-load.php");
if($_POST) {

    $projectId = $_POST['projectId'];
    $agentId = $_POST['agentId'];

        $log = update_field('field_57740b30f6908',$agentId,$projectId);
        $message = '';
        echo json_encode( array("message" => $message, "status" => 'success','agentId'=>$agentId, 'log'=>$log) );
        die;
}
else {
        $message = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>";
        echo json_encode( array("message" => $message, "status" => 'fail') );
        die;
}
?>
