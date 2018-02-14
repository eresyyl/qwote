<?php
require_once("../../../../../../../wp-load.php");
if($_POST && $_POST['projectId']) {

        $projectId = $_POST['projectId'];
        $agentId = $_POST['agentId'];

        // get all agents of project and remove agentId
        $agentsId = get_field('agent_id',$projectId);
        $agentsArray = array();
        foreach($agentsId as $a) {
          if($agentId != $a['ID']) {
              $agentsArray[] = $a['ID'];
          }
        }

        // updating agents of project
        update_field('field_56afffa9221d1',$agentsArray,$projectId);

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
