<?php 
require_once("../../../../../../../wp-load.php");
if($_POST && $_POST['projectId']) {
    
        $projectId = $_POST['projectId'];
        $projectTimeframe = $_POST['projectTimeframe'];

        // updating project timeframe
        update_field('field_57407979f7f90',$projectTimeframe,$projectId);

        $message = '';
        echo json_encode( array("message" => $message, "status" => 'success', "newTimeframe" => $projectTimeframe) );
        die;
}
else {
        $message = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>";
        echo json_encode( array("message" => $message, "status" => 'fail') );
        die;
}
?>