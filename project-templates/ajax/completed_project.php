<?php 
/*
This is AJAX function for Head or Agent to make Quote (Project) Completed.
Client will get a notification about changing status: Quote -> Completed.
*/
require_once("../../../../../wp-load.php");

$contractor_string = get_field('contractor','options');
$head_string = get_field('head_contractor','options');
$agent_string = get_field('agent','options');

$date = date('d/m/Y H:i');
$user_id = current_user_id();
$who = $user_data->first_name . " " . $user_data->last_name;

if($_POST && $_POST['quote_id']) {
        $quote_id = $_POST['quote_id'];
        $client_id = get_field('client_id',$quote_id);
        if($client_id[0] == NULL) {
                $client_id = $client_id['ID'];
        }
        else {
                $client_id = $client_id[0];
        }
        
        // updating project status
        update_field('field_567db3a488cb0','completed',$quote_id);
        
        // make Notification for Client
        $notification_text = $who . ' completed your project.';
        go_notification($notification_text,'approved',$date,$client_id,$quote_id);
        
        // make Activity row
        $activity_text = $who . ' completed your project.';
        go_activity($activity_text,'approved',$date,$user_id,$quote_id);
        
        
        /*
        *
        * SENDING EMAIL
        *
        */
        
        $subject = $who . ' completed your project!';
        $title = 'Your project is now completed!';
        $text = '<p>' . $who . ' completed your project.</p><p>You can check it: ' . get_bloginfo('url') . '/?p=' . $quote_id . '</p>';
        go_email($subject,$title,$text,$client_id);
        
        // showing response message
        echo "<div class='text-center selection_add_success margin-vertical-20 green-600'>Project is completed!</div>";
        die;
}
else {
        echo "<div class='text-center margin-vertical-20 red-800'>Something went wrong!</div>";
        die;
}
?>