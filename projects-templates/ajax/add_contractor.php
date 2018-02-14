<?php 
/*
This is AJAX function to Add Contractor to project
*/
require_once("../../../../../wp-load.php");
$date = date('d/m/Y H:i');
$user_id = current_user_id();
$user_data = go_userdata($user_id);
$who = $user_data->first_name . " " . $user_data->last_name;
$contractor_string = get_field('contractor','options');

if($_POST && $_POST['contractor_id'] != '' && $_POST['quote_id'] != '') {
        $quote_id = $_POST['quote_id'];
        
        $client_id = get_field('client_id',$quote_id);
        $client_id = $client_id['ID'];
        
        $agent_id = get_field('agent_id',$quote_id);
        $agent_id = $agent_id['ID'];
        
        $contractor_id = $_POST['contractor_id'];
        $contractor_data = go_userdata($contractor_id);
        update_field('field_567eb812b96b4',$contractor_id,$quote_id);
        
	// updating client's contacts list: TO, WHO_TO_ADD
        go_addcontact($client_id,$contractor_id);
	// updating agent's contacts list: TO, WHO_TO_ADD
        go_addcontact($agent_id,$contractor_id);
	// updating contractors's contacts list: TO, WHO_TO_ADD
        go_addcontact($contractor_id,$client_id);
        go_addcontact($contractor_id,$agent_id);
        
        // make Activity row
        $activity_text = $who . ' added ' . $contractor_string . ' to the project.';
        go_activity($activity_text,'waiting',$date,$user_id,$quote_id);
        
        // make Notification and sent it to Contractor
        $notification_text = $who . ' added you to the project.';
        go_notification($notification_text,'waiting',$date,$contractor_id,$quote_id);
        
        // make Notification and sent it to Client
        $notification_text = $who . ' added your ' . $contractor_string . ' to the project.';
        go_notification($notification_text,'waiting',$date,$client_id,$quote_id);
        
        // make Notification and sent it to Agent
        $notification_text = $who . ' added ' . $contractor_string . ' to the project.';
        go_notification($notification_text,'waiting',$date,$agent_id,$quote_id);
        
        
        // SENDING EMAILs
        
        $subject = $who . ' added a ' . $contractor_string . ' to your job!';
        $title = $who . ' added a ' . $contractor_string . ' to your job: <br />' . get_the_title($quote_id);
        $text = '<div style="text-align:center; padding:25px 0;">
                        <div style="display:inline-block; background:#f1f4f5; border-radius: 4px; padding:20px; text-align:center;">
                                <img src="' . $contractor_data->avatar . '" alt="">
                                <div style="font-size:16px; padding:20px 0 5px 0; ">' . $contractor_data->first_name . ' ' . $contractor_data->last_name . '</div>
                                <div style="font-size:14px; padding:5px 0; ">' . $contractor_data->email . '</div>
                                <div style="font-size:14px; padding:5px 0; ">' . $contractor_data->phone . '</div>
                        </div>
                </div>
                <div style="text-align:center; padding:10px 0;">
                        <a href="' . get_bloginfo('url') . '/?p=' . $quote_id . '" style="background:#f96868; color:#fff; padding:12px 25px; text-decoration:none; font-size:16px; border-radius:10px; ">Project Details</a>
                </div>';
        go_email($subject,$title,$text,$client_id);
        
        $subject = $who . ' added ' . $contractor_string . ' to the job!';
        $title = $who . ' added ' . $contractor_string . ' to the job: <br />' . get_the_title($quote_id);
        $text = '<div style="text-align:center; padding:25px 0;">
                        <div style="display:inline-block; background:#f1f4f5; border-radius: 4px; padding:20px; text-align:center;">
                                <img src="' . $contractor_data->avatar . '" alt="">
                                <div style="font-size:16px; padding:20px 0 5px 0; ">' . $contractor_data->first_name . ' ' . $contractor_data->last_name . '</div>
                                <div style="font-size:14px; padding:5px 0; ">' . $contractor_data->email . '</div>
                                <div style="font-size:14px; padding:5px 0; ">' . $contractor_data->phone . '</div>
                        </div>
                </div>
                <div style="text-align:center; padding:10px 0;">
                        <a href="' . get_bloginfo('url') . '/?p=' . $quote_id . '" style="background:#f96868; color:#fff; padding:12px 25px; text-decoration:none; font-size:16px; border-radius:10px; ">Project Details</a>
                </div>';
        go_email($subject,$title,$text,$agent_id);
        
        $subject = $who . ' added you to the job!';
        $title = $who . ' added you to the job: <br />' . get_the_title($quote_id);
        $text = '<div style="text-align:center; padding:25px 0;">
                        <a href="' . get_bloginfo('url') . '/?p=' . $quote_id . '" style="background:#f96868; color:#fff; padding:12px 25px; text-decoration:none; font-size:16px; border-radius:10px; ">Project Details</a>
                </div>';
        go_email($subject,$title,$text,$contractor_id);
        
       
        echo "<div class='text-center margin-vertical-20 green-600'>Contractor successfully added! Notification was sent.</div>";
        echo "<script>$('.set_contractor').html('<i class=\'icon wb-user-add green-600\'></i>');</script>";
        die;
        
}
else {
        echo "<div class='text-center margin-vertical-20 red-800'>Something went wrong!</div>";
        echo "<script>$('.set_contractor').html('<i class=\'icon wb-user-add green-600\'></i>');</script>";
        die;
}
?>