<?php
require_once("../../../../../../../wp-load.php");
if($_POST && $_POST['projectId']) {

  // get POST details
  $projectId = $_POST['projectId'];
  $agentId = $_POST['agentId'];

  // get project defaults
  $agentsId = get_field('agent_id',$projectId);

  if(!$agentsId) {
      update_field( 'field_57740b30f6908', $agentId, $projectId );
  }

  $projectTitle = get_the_title($projectId);
  $clientId = get_field('client_id',$projectId); $clientId = $clientId['ID'];
  $contractorsId = get_field('contractor_id',$projectId);
  $changeDate = date('d/m/Y H:i');
  $changeUserId = current_user_id();
  $changeUserData = go_userdata($changeUserId);
  $changeWho = $changeUserData->first_name . " " . $changeUserData->last_name;

        // get all agents of project and remove agentId
        // check if Agent is currently added
        $agentsArrayTemp = array();
        foreach($agentsId as $a) {
          $agentsArrayTemp[] = $a['ID'];
        }
        if(in_array($agentId,$agentsArrayTemp)) {
          $message = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Project Leader already added to this project!</div>";
          echo json_encode( array("message" => $message, "status" => 'fail') );
          die;
        }

        $agentsArray = array();
        foreach($agentsId as $a) {
          if($agentId != $a['ID']) {
              $agentsArray[] = $a['ID'];
          }
        }
        $agentsArray[] = $agentId;

        // updating agents of project
        update_field('field_56afffa9221d1',$agentsArray,$projectId);

        // make Activity row
        $activity_text = $changeWho . ' added a Job Manager to your project.';
        go_activity($activity_text,'waiting',$changeDate,$changeUserId,$projectId);

        // sent notification to clientId
        $notification_text = $changeWho . ' added your Job Manager to the project.';
        go_notification($notification_text,'waiting',$changeDate,$clientId,$projectId);
        // sent email to clientId
        $agentData = go_userdata($agentId);
        $subject = 'Meet your Job Manager!';
        $title = 'Your one point of contact for: <br />' . $projectTitle;
        $text = '<div style="text-align:center; padding:25px 0;">
                        <div style="display:inline-block; background:#f1f4f5; border-radius: 4px; padding:20px; text-align:center;">
                                <img src="' . $agentData->avatar . '" alt="">
                                <div style="font-size:16px; padding:20px 0 5px 0; ">' . $agentData->first_name . ' ' . $agentData->last_name . '</div>
                                <div style="font-size:14px; padding:5px 0; ">' . $agentData->email . '</div>
                                <div style="font-size:14px; padding:5px 0; ">' . $agentData->phone . '</div>
                        </div>
                </div>
                <div style="text-align:center; padding:10px 0;">
                        <a href="' . get_bloginfo('url') . '/?p=' . $projectId . '" style="background:#f96868; color:#fff; padding:12px 25px; text-decoration:none; font-size:16px; border-radius:10px; ">Project Details</a>
                </div>';
        go_email($subject,$title,$text,$clientId);

        // sent notification to agentId
        $notification_text = $changeWho . ' added you to the project.';
        go_notification($notification_text,'waiting',$changeDate,$agentId,$projectId);
        // sent email to agentId
        $subject = $changeWho . ' added you to the project!';
        $title = $changeWho . ' added you to the project: <br />' . $projectTitle;
        $text = '<div style="text-align:center; padding:25px 0;">
                        <a href="' . get_bloginfo('url') . '/?p=' . $projectId . '" style="background:#f96868; color:#fff; padding:12px 25px; text-decoration:none; font-size:16px; border-radius:10px; ">Project Details</a>
                </div>';
        go_email($subject,$title,$text,$agentId);

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
