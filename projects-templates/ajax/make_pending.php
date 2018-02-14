<?php 
/*
This is AJAX function for Head or Agent to make Quote (Project) PENDING.
Client will get a notification about changing status: Quote -> Pending.
After that action Client will need to Approve or Cancel project.
*/
require_once("../../../../../wp-load.php");
$date = date('d/m/Y H:i');
$user_id = current_user_id();
$user_data = go_userdata($user_id);
$who = $user_data->first_name . " " . $user_data->last_name;

if($_POST && $_POST['quote_id']) {
        $quote_id = $_POST['quote_id'];
        $single = $_POST['single'];
        $client_id = get_field('client_id',$quote_id);
        $client_id = $client_id['ID'];
        
        // updating project status
        update_field('field_567db3a488cb0','pending',$quote_id);
        
        // make Notification for Client
        $notification_text = $who . ' updated your job. You can now approve it.';
        go_notification($notification_text,'waiting',$date,$client_id,$quote_id);
        
        // make Activity row
        $activity_text = $who . ' updated your job. Waiting for approval.';
        go_activity($activity_text,'waiting',$date,$user_id,$quote_id);
        
        
        /*
        *
        * SENDING EMAIL
        *
        */
        
        $subject = $who . ' updated your quote!';
        $title = 'Your Job is almost ready!';
        $text = '<p>' . $who . ' updated details of your job and now it is pending approval by you.</p><p>You can approve it here: ' . get_bloginfo('url') . '/?p=' . $quote_id . '</p>';
        go_email($subject,$title,$text,$client_id);
        
        // showing response message
        echo "<div class='text-center selection_add_success margin-vertical-20 green-600'>Project is In proposal!</div>";
        if($single == 'true') {
                echo "<script>$(document).ready(function(){ $('.add_details i').click(); });</script>";
        }
        else {
               echo "<script>$(document).ready(function(){ $('#project_" . $quote_id . " .add_details i').click(); });</script>"; 
        }
        die;
}
else {
        echo "<div class='text-center margin-vertical-20 red-800'>Something went wrong!</div>";
        die;
}
?>