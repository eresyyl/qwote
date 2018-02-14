<?php
require_once("../../../../../../../wp-load.php");
if($_POST && $_POST['projectId']) {

        $projectId = $_POST['projectId'];
        $projectStatus = $_POST['projectStatus'];
        $projectStatusBefore = $_POST['projectStatusBefore'];
        $clientId = get_field('client_id',$projectId); $clientId = $clientId['ID'];

        $changeDate = date('d/m/Y H:i');
        $changeUserId = current_user_id();
        $changeUserData = go_userdata($changeUserId);
        $changeWho = $changeUserData->first_name . " " . $changeUserData->last_name;

        if( $projectStatus != 'quote' && $projectStatus != 'active' && $projectStatus != 'pending' && $projectStatus != 'live' && $projectStatus != 'completed' && $projectStatus != 'cancelled' ) {
            $message = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong! Invalid Status!</div>";
                echo json_encode( array("message" => $message, "status" => 'fail') );
                die;
        }

        $projectPayments = get_field('payments',$projectId);
        if($projectStatus == 'final quote' && !is_array($projectPayments)) {
          $message = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>You can't make project In Proposal while not set up Payments!</div>";
          echo json_encode( array("message" => $message, "status" => 'fail') );
          die;
        }

        // updating project status
        update_field('field_567db3a488cb0',$projectStatus,$projectId);

        if($projectStatus == 'quote') {
            $newStatus = 'Quote';
        }
        elseif($projectStatus == 'pending') {
            $newStatus = 'Final Quote';
        }
        elseif($projectStatus == 'live') {
            $newStatus = 'Live';
        }
        elseif($projectStatus == 'completed') {
            $newStatus = 'Completed';
        }
        elseif($projectStatus == 'cancelled') {
            $newStatus = 'Cancelled';
        }

        if($projectStatusBefore == 'quote') {
            $newStatusBefore = 'Quote';
        }
        elseif($projectStatus == 'pending') {
            $newStatus = 'Final Quote';
        }
        elseif($projectStatusBefore == 'live') {
            $newStatusBefore = 'Live';
        }
        elseif($projectStatusBefore == 'completed') {
            $newStatusBefore = 'Completed';
        }
        elseif($projectStatusBefore == 'cancelled') {
            $newStatusBefore = 'Cancelled';
        }

        // make Activity row
        $activityText = $changeWho . ' updated your job from ' . $newStatusBefore . ' to ' . $newStatus;
        go_activity($activityText,'waiting',$changeDate,$changeUserId,$projectId);

        // sending email
        $subject = $changeWho . '  updated your job from  ' . $newStatusBefore . ' to ' . $newStatus;
        $title = 'Your job has been updated!';
        $text = '<p>' . $changeWho . ' updated your job from ' . $newStatusBefore . ' to ' . $newStatus .'</p><p>You can login and check the details here: ' . get_bloginfo('url') . '/?p=' . $projectId . '</p>';
        go_email($subject,$title,$text,$clientId);

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
