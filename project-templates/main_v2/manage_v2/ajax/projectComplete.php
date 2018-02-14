<?php
require_once("../../../../../../../wp-load.php");
if($_POST && $_POST['projectId']) {

        $projectId = $_POST['projectId'];
        $userId = $_POST['userId'];

        $changeDate = date('d/m/Y H:i');
        $changeUserId = $userId;
        $changeUserData = go_userdata($changeUserId);
        $changeWho = $changeUserData->first_name . " " . $changeUserData->last_name;

        // check all payments are done already
        $projectPayments = get_field('payments',$projectId);
        $projectValidation = true;
        foreach($projectPayments as $p) {
            $status = $p['status'];
            if($status != 'paid') {
                $projectValidation = false;
            }
        }
        if($projectValidation == false) {
            $message = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>You can't Complete project until all payments are Paid!</div>";
            echo json_encode( array("message" => $message, "status" => 'fail') );
            die;
        }

        // updating project status
        update_field('field_567db3a488cb0','completed',$projectId);

        // make Activity row
        $activityText = $changeWho . ' completed job. Status changed to Completed';
        go_activity($activityText,'waiting',$changeDate,$changeUserId,$projectId);

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
