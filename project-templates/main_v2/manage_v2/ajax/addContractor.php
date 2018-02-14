<?php
require_once("../../../../../../../wp-load.php");
if($_POST && $_POST['projectId']) {

  // get POST details
  $projectId = $_POST['projectId'];
  $contractorId = $_POST['contractorId'];

  // get project defaults
  $projectTitle = get_the_title($projectId);
  $clientId = get_field('client_id',$projectId); $clientId = $clientId['ID'];
  $contractorsId = get_field('contractor_id',$projectId);
  $agentsId = get_field('agent_id',$projectId);
  $changeDate = date('d/m/Y H:i');
  $changeUserId = current_user_id();
  $changeUserData = go_userdata($changeUserId);
  $changeWho = $changeUserData->first_name . " " . $changeUserData->last_name;

        // get all contractors of project and remove contractorId
        // check if Contractor is currently added
        $contractorsArrayTemp = array();
        foreach($contractorsId as $c) {
          $contractorsArrayTemp[] = $c['ID'];
        }
        if(in_array($contractorId,$contractorsArrayTemp)) {
          $message = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Contractor already added to this project!</div>";
          echo json_encode( array("message" => $message, "status" => 'fail') );
          die;
        }

        $contractorsArray = array();
        foreach($contractorsId as $c) {
          if($contractorId != $c['ID']) {
              $contractorsArray[] = $c['ID'];
          }
        }
        $contractorsArray[] = $contractorId;

        // updating contractors of project
        update_field('field_567eb812b96b4',$contractorsArray,$projectId);


        // make Activity row
        $activity_text = $changeWho . ' added contractor to the job.';
        go_activity($activity_text,'waiting',$changeDate,$changeUserId,$projectId);

        
        // sent notification to contractor
        $notification_text = $changeWho . ' sent you a work order.';
        go_notification($notification_text,'waiting',$changeDate,$contractorId,$projectId);
        // sent email to agentId
        $subject = $changeWho . ' sent you a work order!';
        $title = $changeWho . ' sent you a work order: <br />' . $projectTitle;
        $text = '<div style="text-align:center; padding:25px 0;">
                        <a href="' . get_bloginfo('url') . '/?p=' . $projectId . '" style="background:#f96868; color:#fff; padding:12px 25px; text-decoration:none; font-size:16px; border-radius:10px; ">Job Details</a>
                </div>';
        go_email($subject,$title,$text,$contractorId);

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
