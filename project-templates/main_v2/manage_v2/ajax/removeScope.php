<?php
require_once("../../../../../../../wp-load.php");
if($_POST && $_POST['projectId']) {

        $projectId = $_POST['projectId'];
        $scopeId = $_POST['scopeId'];

        // get all scopeIds of project
        $projectScope = get_field('projectScopes',$projectId);
        $projectsArray = array();
        foreach($projectScope as $p) {
          if($scopeId != $p) {
              $projectsArray[] = $p;
          }
        }

        // updating Scopes of project
        update_field('field_57407991f7f92',$projectsArray,$projectId);

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
