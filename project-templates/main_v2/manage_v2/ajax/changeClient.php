<?php
require_once("../../../../../../../wp-load.php");
if($_POST && $_POST['projectId']) {

        $projectId = $_POST['projectId'];
        $clientId = $_POST['clientId'];
        $oldClientId = get_field('client_id',$projectId); $oldClientId = $oldClientId['ID'];

        if( $clientId == $oldClientId ) {
            $message = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>You selected same client, nothing to change!</div>";
                echo json_encode( array("message" => $message, "status" => 'fail') );
        die;
        }

        // updating client Id
        update_field('field_567eb805b96b3',$clientId,$projectId);

        $message = '';
        $message = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Old Client ID: " . $oldClientId . ". New client ID: " . $clientId . "</div>";
        echo json_encode( array("message" => $message, "status" => 'success') );
        die;
}
else {
        $message = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>";
        echo json_encode( array("message" => $message, "status" => 'fail') );
        die;
}
?>
