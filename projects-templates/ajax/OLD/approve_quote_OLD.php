<?php 
/*
This is AJAX function to Approve project by Client, Contractor or We.
Depending of current project status, this function can be used by We, Client or Contractor.
*/
require_once("../../../../../wp-load.php");
$date = date('d/m/Y H:i');
$user_id = current_user_id();
$user_data = go_userdata($user_id);
$who = $user_data->first_name . " " . $user_data->last_name;

if($_POST && $_POST['quote_id'] != '') {
	$quote_id = $_POST['quote_id'];
	$status = get_field('status',$quote_id);
        $client_id = get_field('client_id',$quote_id);
        if($client_id[0] == NULL) {
                $client_id = $client_id['ID'];
        }
        else {
                $client_id = $client_id[0];
        }
        $contractor_id = get_field('contractor_id',$quote_id);
        if($contractor_id[0] == NULL) {
                $contractor_id = $contractor_id['ID'];
        }
        else {
                $contractor_id = $contractor_id[0];
        }
        $agent_id = get_field('agent_id',$quote_id);
        if($agent_id[0] == NULL) {
                $agent_id = $agent_id['ID'];
        }
        else {
                $agent_id = $agent_id[0];
        }
        
        // if current project status is Active, so that's approval from Client or We. Project will change status: Active -> Pending.
        if($status == 'active') {
                update_field('status','pending',$quote_id);
                update_field('client_approve',true,$quote_id);
                
                // make Activity row
                $activity_text = $who . ' approved project. Status changed to Pending.';
                go_activity($activity_text,'approved',$date,$user_id,$quote_id);
                
                
                /*
                *
                * SENDING EMAIL
                *
                */
                
                $head_contractor = get_field('head','options');
                $subject = $who . ' approved project!';
                $title =  $who . ' approved project!';
                $text = '<p>' . $who . ' approved project and now it is Pending.</p><p>You need to check it: ' . get_bloginfo('url') . '/?p=' . $quote_id . '</p>';
                go_email($subject,$title,$text,$head_contractor['ID']);
                if($agent_id != NULL && $agent_id != '' && !empty($agent_id)) {
                        go_email($subject,$title,$text,$agent_id);
                }
                
                if(is_headcontractor() || is_agent()) {
                        $subject = $who . ' approved quote!';
                        $title = 'Project was approved by ' . $who . '!';
                        $text = '<p>' . $who . ' approved project and now it is Pending.</p><p>Project details: ' . get_bloginfo('url') . '/?p=' . $quote_id . '</p>';
                        go_email($subject,$title,$text,$client_id);
                }
                
                
                // showing response message
                echo "<div class='text-center margin-bottom-20 green-600'>
                                Successfully approved!
                        </div>
                        <script>
                                $('.approve_quote_close').show().html('Close');
                                $('#project_" . $quote_id . " .label').html('Pending').removeClass('label-primary').addClass('label-warning');
                                $('#project_" . $quote_id . " .cancel').remove();
                                $('#project_" . $quote_id . " .approve').remove();
                        </script>";
        	die;
                
        }
        // if current project status is Pending, so that's approval from Contractor or We. Project will change status: Pending -> Live.
        elseif($status == 'pending') {
                update_field('status','live',$quote_id);
                update_field('contractor_approve',true,$quote_id);
                // marking first Payment (milestone) as Active
                $payments = get_field('payments',$quote_id);
                $payments_with_status = array();
                $i=0;
                foreach($payments as $payment) { $i++;
                        if($i == 1) {
                                $payments_with_status[] = array('title' => $payment['title'], 'description' => $payment['description'], 'percent' => $payment['percent'], 'due_date' => $payment['due_date'], 'done' => $payment['done'], 'paid' => $payment['paid'], 'status' => 'active');
                        }
                        else {
                                $payments_with_status[] = array('title' => $payment['title'], 'description' => $payment['description'], 'percent' => $payment['percent'], 'due_date' => $payment['due_date'], 'done' => $payment['done'], 'paid' => $payment['paid'], 'status' => $project['status']);
                        }
                }
                update_field('field_567eedc8a0297',$payments_with_status,$quote_id);
                
                // make Activity row
                $activity_text = $user_data->first_name . ' ' . $user_data->last_name . ' approved project. Status changed to Live.';
                go_activity($activity_text,'approved',$date,$user_id,$quote_id);
                
                // make Notification and sent it to Client
                $notification_text = $who . ' approved project. Status changed to Live.';
                go_notification($notification_text,'approved',$date,$client_id,$quote_id);
                
                
                /*
                *
                * SENDING EMAIL
                *
                */
                
                $head_contractor = get_field('head','options');
                $subject = $who . ' approved project!';
                $title = $who . ' approved project!';
                $text = '<p>' . $who . ' approved project and now it is Live.</p><p>Project details: ' . get_bloginfo('url') . '/?p=' . $quote_id . '</p>';
                go_email($subject,$title,$text,$head_contractor['ID']);
                go_email($subject,$title,$text,$client_id);
                if($agent_id != NULL && $agent_id != '' && !empty($agent_id)) {
                        go_email($subject,$title,$text,$agent_id);
                }
                
                if(is_headcontractor() || is_agent()) {
                        go_email($subject,$title,$text,$contractor_id);
                }
                
                // showing response message 
                echo "<div class='text-center margin-bottom-20 green-600'>
                                Project successfully approved!
                        </div>
                        <script>
                                $('.approve_quote_close').show().html('Close');
                                $('#project_" . $quote_id . " .label').html('Live').removeClass('label-warning').addClass('label-info');
                                $('#project_" . $quote_id . " .cancel').remove();
                                $('#project_" . $quote_id . " .approve').remove();
                        </script>";
        }
die;        
}
else {
	echo "<script>
                $('.approve_quote').show();
                $('.approve_quote_close').show();
                $('#approve_quote_respopnse').html('<div class=\'text-center margin-bottom-20\'>Something went wrong!</div>');</script>";
	die;
}
?>