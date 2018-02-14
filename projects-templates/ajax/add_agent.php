<?php 
/*
This is AJAX function to Add Agent to project
*/
require_once("../../../../../wp-load.php");
$date = date('d/m/Y H:i');
$user_id = current_user_id();
$user_data = go_userdata($user_id);
$who = $user_data->first_name . " " . $user_data->last_name;
$agent_string = get_field('agent','options');

if($_POST && $_POST['agent_id'] != '' && $_POST['quote_id'] != '') {
        $quote_id = $_POST['quote_id'];
        
        $client_id = get_field('client_id',$quote_id);
        $client_id = $client_id['ID'];
        
        $agent_id = $_POST['agent_id'];
        $agent_data = go_userdata($agent_id);
        update_field('field_56afffa9221d1',$agent_id,$quote_id);
        
        
	// updating client's contacts list: TO, WHO_TO_ADD
        go_addcontact($client_id,$agent_id);
	// updating agent's contacts list: TO, WHO_TO_ADD
        go_addcontact($agent_id,$client_id);
        
       
        // make Activity row
        $activity_text = $who . ' added ' . $agent_string . ' to the project.';
        go_activity($activity_text,'waiting',$date,$user_id,$quote_id);
        
        // make Notification and sent it to Agent
        $notification_text = $who . ' added you to the project.';
        go_notification($notification_text,'waiting',$date,$agent_id,$quote_id);
        
        // make Notification and sent it to Client
        $notification_text = $who . ' added your ' . $agent_string . ' to the project.';
        go_notification($notification_text,'waiting',$date,$client_id,$quote_id);
        
       
       
        // SENDING EMAILs
        
        $agent_data = go_userdata($agent_id);
        $subject = $who . ' added your ' . $agent_string . ' to the project!';
        $title = $who . ' added your ' . $agent_string . ' to the project: <br />' . get_the_title($quote_id);
        $text = '<div style="text-align:center; padding:25px 0;">
                        <div style="display:inline-block; background:#f1f4f5; border-radius: 4px; padding:20px; text-align:center;">
                                <img src="' . $agent_data->avatar . '" alt="">
                                <div style="font-size:16px; padding:20px 0 5px 0; ">' . $agent_data->first_name . ' ' . $agent_data->last_name . '</div>
                                <div style="font-size:14px; padding:5px 0; ">' . $agent_data->email . '</div>
                                <div style="font-size:14px; padding:5px 0; ">' . $agent_data->phone . '</div>
                        </div>
                </div>
                <div style="text-align:center; padding:10px 0;">
                        <a href="' . get_bloginfo('url') . '/?p=' . $quote_id . '" style="background:#f96868; color:#fff; padding:12px 25px; text-decoration:none; font-size:16px; border-radius:10px; ">Project Details</a>
                </div>';
        go_email($subject,$title,$text,$client_id);
        
        $subject = $who . ' added you to the project!';
        $title = $who . ' added you to the project: <br />' . get_the_title($quote_id);
        $text = '<div style="text-align:center; padding:25px 0;">
                        <a href="' . get_bloginfo('url') . '/?p=' . $quote_id . '" style="background:#f96868; color:#fff; padding:12px 25px; text-decoration:none; font-size:16px; border-radius:10px; ">Project Details</a>
                </div>';
        go_email($subject,$title,$text,$agent_id);
        
        
        
       
        echo "<div class='text-center margin-vertical-20 green-600'>" . $agent_string . " successfully added!</div>";
        echo "<script>$('.set_agent').html('<i class=\'icon wb-user-add green-600\'></i>');</script>";
        die;
        
}
else {
        echo "<div class='text-center margin-vertical-20 red-800'>Something went wrong!</div>";
        echo "<script>$('.set_agent').html('<i class=\'icon wb-user-add green-600\'></i>');</script>";
        die;
}
?>