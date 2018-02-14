<?php
require_once("../../../../../../../wp-load.php");
if($_POST && $_POST['projectId']) {

        $projectId = $_POST['projectId'];
        $userId = $_POST['userId'];

        $changeDate = date('d/m/Y H:i');
        $changeUserId = $userId;
        $changeUserData = go_userdata($changeUserId);
        $changeWho = $changeUserData->first_name . " " . $changeUserData->last_name;

        // updating project status
        update_field('field_567db3a488cb0','cancelled',$projectId);

        // make Activity row
        $activityText = $changeWho . ' cancelled job. Status changed to Cancelled.';
        go_activity($activityText,'waiting',$changeDate,$changeUserId,$projectId);

        
        $subject = 'You quote has been cancelled or closed';
        $title = 'Thanks for using Qwote';
        $text = '<p> We have cancelled your qwote!</p><p>You can login a reopen or just get back in touch if this is a mistake.  ' . get_bloginfo('url') . '/?p=' . $projectId . '</p>';
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
