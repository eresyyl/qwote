<?php
require_once("../../../../../../../wp-load.php");
if($_POST && $_POST['projectId']) {

        $projectId = $_POST['projectId'];
        $contractorId = $_POST['contractorId'];

        // get all contractors of project and remove contractorId
        $contractorsId = get_field('contractor_id',$projectId);
        $contractorsArray = array();
        foreach($contractorsId as $c) {
          if($contractorId != $c['ID']) {
              $contractorsArray[] = $c['ID'];
          }
        }

        // updating contractors of project
        update_field('field_567eb812b96b4',$contractorsArray,$projectId);

        $message = '';
        echo json_encode( array("message" => $message, "status" => 'success') );
        die;
}
else {
        $message = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>";
        echo json_encode( array("message" => $message, "status" => 'fail') );
        die;
}
?>
